<?php
   /*
   Код в данном файле подключается (include) на странице дополнения в админ-центре
   Страница дополнения в админ-центре всегда имеет путь:
   Админ-центр -> Другие модули -> Дополнения -> $name из info.dat
   Замечание: страница дополнения не будет отображаться до тех пор, пока дополнение
   не будет включено (Админ-центр -> Другие модули -> Дополнения -> Настроить -> Ваше дополнение -> Включить)

   Важно: то, что пользователь может увидеть на странице дополнения, должно быть в переменной $print
   Не допускайте прямого вывода на страницу. 
   */
   
   $print = '';
   $showmenu = true;
   if (isset($_GET['do']))
   {
     switch ($_GET['do'])
     {
            case "save":
                         $name = (int)$_GET['name'];
                         $question = $_POST['question'];
                         $answers = $_POST['answers'];
                         $original = file($cms_root."/conf/votes/vote_".$name.".dat");
                         $new = fopen($cms_root."/conf/votes/vote_".$name.".dat","w");
                         $a = array();
                         $answers = str_replace("|"," ",$answers);
                         $answers = str_replace("\r\n","|",$answers);
                         $answers = str_replace("\n","|",$answers);
                         $answers = str_replace("\r","|",$answers);
                         $a = explode("|",$answers);
                         $tmp = explode("|",$original[0]);
                         $b = unserialize($tmp[2]);
                         $c = unserialize($tmp[3]);
                         fwrite($new,$question."|".serialize($a)."|".serialize($b)."|".serialize($c)."|");
                         fclose($new);
                         $original = file($cms_root."/conf/votes/config.dat");
                         $new = fopen($cms_root."/conf/votes/config.dat","w");
                         foreach ($original as $or)
                         {
                              $o = explode("|",$or);
                              if ($o[0]==$name)
                              {
                                 fwrite($new,$o[0]."|".$question."|\r\n");
                              }
                              else
                                 fwrite($new,$or);
                         }
                         fclose($new);
                         break; 
            case "create":
                         $question = $_POST['question'];
                         $answers  = $_POST['answers'];
                         if (!is_dir($cms_root."/conf/votes/"))
                         {
                              mkdir($cms_root."/conf/votes/");
                              chmod($cms_root."/conf/votes/",0777);
                              
                         };
                         if (!file_exists($cms_root."/conf/votes/config.dat"))
                         {
                              $n = fopen($cms_root."/conf/votes/config.dat","w");
                              fwrite($n,"");
                              fclose($n);
                              chmod($cms_root."/conf/votes/config.dat",0777);
                         };
                         $a = array();
                         $answers = str_replace("|"," ",$answers);
                         $answers = str_replace("\r\n","|",$answers);
                         $answers = str_replace("\n","|",$answers);
                         $answers = str_replace("\r","|",$answers);
                         $a = explode("|",$answers);
                         $b = array();
                         $p = array();
                         $z = 0;
                         foreach ($a as $c)
                         {     
                             if ($c=="")
                             {
                                 unset($a[$z]);
                             }
                             else
                              $b[] = 0;
                             $z++;
                         };
                         $f = rand(1,9);
                         $maybe = false;
                         for ($i=1; $maybe!=true; $i++)
                         {
                              if (!file_exists($cms_root."/conf/votes/vote_".$f.$i.".dat"))
                              {
                                  $maybe = true;
                                  $path  = $f.$i;
                              };
                         };
                         $config  = fopen($cms_root."/conf/votes/config.dat","a");
                         fputs($config,$path."|".$question."|\r\n");
                         fclose($config);
                         $vote    = fopen($cms_root."/conf/votes/vote_".$path.".dat","w");
                         fwrite($vote,str_replace("|"," ",$question)."|".serialize($a)."|".serialize($b)."|".serialize($p)."|");
                         fclose($vote);
                         chmod($cms_root."/conf/votes/vote_".$path.".dat",0777);
                         break;
            case "clear":
                         $name = (int)$_GET['name'];
                         $original = file($cms_root."/conf/votes/vote_".$name.".dat");
                         $new      = fopen($cms_root."/conf/votes/vote_".$name.".dat","w");
                         $z        = explode("|",$original[0]);
                         $a        = unserialize($z[1]);
                         $b        = unserialize($z[2]);
                         $c        = array();
                         $i        = 0;
                         foreach ($b as $y)
                         {
                              $b[$i]=0;
                              $i++;
                         };
                         fwrite($new,$z[0]."|".serialize($a)."|".serialize($b)."|".serialize($c)."|");
                         fclose($new);
                         break;
            case "del":
                         $name = (int)$_GET['name'];
                         @unlink($cms_root."/conf/votes/vote_".$name.".dat");
                         $original = file($cms_root."/conf/votes/config.dat");
                         $new      = fopen($cms_root.'/conf/votes/config.dat',"w");
                         foreach ($original as $or)
                         {
                                 $o = explode("|",$or);
                                 if ($o[0]!=$name) fwrite($new,$or);
                         };
                         fclose($new);
                         break;
            case "edit":
                         $name = (int)$_GET['name'];
                         $file = file($cms_root."/conf/votes/vote_".$name.".dat");
                         $z    = explode("|",$file[0]);
                         $a    = unserialize($z[1]);
                         $b    = unserialize($z[2]);
                         $c    = unserialize($z[3]);
                         $print .= '
                         <center>
                         <form name="editform" action="?action=plugins&choose=votes&name='.$name.'&do=save&rand='.rand(0,9999).'" method="POST">
                         <table class="optionstable" border=0 cellpadding=1 cellspacing=0>
                                <tr class="titletable"><td colspan=2>РЕДАКТИРОВАТЬ ГОЛОСОВАНИЕ</td></tr>
                                <tr><td width="50%">Вопрос: </td><td width="50%"><input type="text" size=65 name="question" value="'.$z[0].'"></td></tr>
                                <tr><td valign="top">Варианты ответов (по одному на каждой строке):</td><td><textarea name="answers" rows=5 cols=63>'.implode("\r\n",$a).'</textarea></td></tr>
                                <tr class="sub"><td colspan=2><input type="submit" name="submit" value="Сохранить"></td></tr>
                         </table>
                         </form>
                         </center><br>
                         ';
                         break; 
            case "new":
                         $print .= '
                         <center>
                         <form name="newform" action="?action=plugins&choose=votes&do=create&rand='.rand(0,9999).'" method="POST">
                         <table class="optionstable" border=0 cellpadding=1 cellspacing=0>
                                <tr class="titletable"><td colspan=2>СОЗДАТЬ ГОЛОСОВАНИЕ</td></tr>
                                <tr><td width="50%">Вопрос: </td><td width="50%"><input type="text" size=65 name="question"></td></tr>
                                <tr><td valign="top">Варианты ответов (по одному на каждой строке):</td><td><textarea name="answers" rows=5 cols=63></textarea></td></tr>
                                <tr class="sub"><td colspan=2><input type="submit" name="submit" value="Создать"></td></tr>
                         </table>
                         </form>
                         </center><br>
                         ';
                         $showmenu = false;
                         break;
     };
   };
   if ($showmenu)
     $print .= '
     <input type="button" value="Создать голосование" onClick="location.href=\'?action=plugins&choose=votes&do=new&rand='.rand(1,999).'\';"><br><br>';
   $print .= '<center><table class="optionstable" border=0 cellpadding=1 cellspacing=0>
       <tr class="titletable"><td>ГОЛОСОВАНИЕ</td><td width=100>ДЕЙСТВИЯ</td></tr>';
   if (file_exists($cms_root."/conf/votes/config.dat"))
   {
       $config = file($cms_root."/conf/votes/config.dat");
       $config = array_reverse($config);
       foreach ($config as $conf)
       {
              $c = explode("|",$conf);
              $v = file($cms_root."/conf/votes/vote_".$c[0].".dat");
              $x = explode("|",$v[0]);
              $a = unserialize($x[1]);
              $b = unserialize($x[2]);
              $o = 0;
              $print .= '<tr><td valign="top">'.$x[0].'<br><table style="margin-left:10px" border=0>';
              foreach ($a as $y)
              {
                   $print .= '<tr><td style="border-right:0px; border-bottom:0px;">'.$b[$o].'</td><td style="border-right:0px; border-bottom:0px;">'.$y.'</td></tr>';
                   $o++;
              };
              $print .= '</table></td><td>
              <a href="?action=plugins&choose=votes&do=edit&name='.$c[0].'">Изменить</a><br><br>
              <a href="?action=plugins&choose=votes&do=clear&name='.$c[0].'">Обнулить</a><br><br>
              <a href="?action=plugins&choose=votes&do=del&name='.$c[0].'">Удалить</a>
              </td></tr>'; 
       };
   }
   else
   {
       $print .= '<tr><td colspan=2 align="center"><b>Нет голосований</b></td></tr>';
   };
   $print .= '</table></center>
   ';
