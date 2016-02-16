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
            case "create":
                         $id = $_POST['id'];
                         if ($FileManager->checkfilename($id))
                         {
                               if (!is_dir($cms_root."/conf/blocks/"))
                               {
                                   mkdir($cms_root."/conf/blocks/");
                                   chmod($cms_root."/conf/blocks/",0777);
                               };
                               $file = fopen($cms_root."/conf/blocks/block_".$id,"w");
                               fwrite($file,"");
                               fclose($file);
                               chmod($cms_root."/conf/blocks/block_".$id,0777);
                         }
                         else
                         {
                               $print.='<center><font color="red">В качестве идентификатора разрешено использовать только буквы английского алфавита, числа и знаки <b>-</b>, <b>_</b>, <b>.</b></font></center><br><br>';
                         };
                         break;
            case "del":
                         $name = $_GET['name'];
                         unlink($cms_root."/conf/blocks/".$name);
                         break;
            case "new":
                         $print .= '
                         <center>
                         <form name="newform" action="?action=plugins&amp;choose=blocks&amp;do=create&amp;rand='.rand(0,9999).'" method="POST">
                         <table class="optionstable" border=0 cellpadding=1 cellspacing=0>
                                <tr class="titletable"><td colspan=2>СОЗДАТЬ НОВЫЙ БЛОК</td></tr>
                                <tr><td width="50%">Идентификатор: </td><td width="50%"><input type="text" size=65 name="id"></td></tr>
                                <tr class="sub"><td colspan=2><input type="submit" name="submit" value="Создать блок"></td></tr>
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
     <input type="button" value="Создать новый блок" onClick="location.href=\'?action=plugins&amp;choose=blocks&amp;do=new&amp;rand='.rand(1,999).'\';"><br><br>';
   $print .= '<center><table class="optionstable" border=0 cellpadding=1 cellspacing=0>
       <tr class="titletable"><td style="width:50%;">ИДЕНТИФИКАТОР</td><td>ДЕЙСТВИЯ</td></tr>';
   if (is_dir($cms_root."/conf/blocks/"))
   {
       $blocks = 0;
       if (count($FileManager->listing($cms_root."/conf/blocks/",0))>0)
       {
          foreach ($FileManager->listing($cms_root."/conf/blocks/",0) as $file)
          {
                   $blocks++;
                   $print .= '<tr><td>'.substr($file,6,strlen($file)-6).'</td><td>
                   <a href="?action=edit&amp;file=../conf/blocks/'.$file.'">Редактировать код</a> 
                   <a href="#" onClick="if (checkhead()) location.href=\'?action=plugins&amp;choose=blocks&amp;do=del&amp;name='.$file.'\';">Удалить</a>
                   </td></tr>
                   ';
          };
       };
       if ($blocks==0)
          $print .= '<tr><td colspan=2 align="center"><b>Не создан ни один блок</b></td></tr>';
   }
   else
   {
       $print .= '<tr><td colspan=2 align="center"><b>Не создан ни один блок</b></td></tr>';
   };
   $print .= '</table></center>
   ';
