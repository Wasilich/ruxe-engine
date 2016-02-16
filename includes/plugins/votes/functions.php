<?php
  /*
  Этот файл подключается (через include) после подключения funtions.command.php
  
  Здесь Вы можете создавать новые команды системы, например:
  
  function here_example()
  {
      echo "Hello World!";
  };

  Или любой другой код, на Ваше усмотрение. Этот файл - "сердце" Вашего дополнения.
  
  Если существует $_GET['action'] при запросе страницы, то система
  сравнивает с своей базой действий значение $_GET['action'] и, если не находит соответствие,
  выдаёт ошибку ("Действие не найдено"). 
  Вы можете добавить своё действие. Для этого в info.dat переменная $addaction должна равняться
  1 ($addaction = 1;). Вашим действием станет имя каталога дополнения (в данном случае example).
  В действии обязательно должны использоваться переменные $openpage и $pagetitle.
  $openpage = текст страницы, а $pagetitle - заголовок.
  Пример:
  
  function here_example()
  {
       echo '<a href="?action=example">Проверка</a>';
  };
  if (isset($_GET['action']))
  {
      $openpage   = "Проверка пройдена!";
      $pagetitle  = "Сообщение";
  };
  
  В действии можно включить автоматическую переадресацию. Но в этом случае страница действия не будет
  отображена, если отключена опция показа промежуточных страниц в админ-центре, а будет сразу переадресация
  на указанный адрес. Для включения автоматической переадресации заполните переменную $pageredirect.
  Пример:
  
  function here_example()
  {
       echo '<a href="?action=example">Проверка</a>';
  };
  if (isset($_GET['action']))
  {
      $openpage     = "Проверка пройдена!";
      $pagetitle    = "Сообщение";
      $pageredirect = "http://mysite.domain"; 
  };
  
  
  */
  
  if (isset($_GET['action']))
  {
    if ($_GET['action']=="votes")
    {
      $error = false;
      if (!isset($_POST['submit'])) $error = true;
      if (!isset($_POST['number'])) $error = true;
      if (!isset($_POST['answer'])) $error = true;
      if (!$error)
      {
           $alreadygolos = false;
           $ip = $_SERVER['REMOTE_ADDR'];
           $number = (int)$_POST['number'];
           $answer = (int)$_POST['answer'];
           $config = file($cms_root."/conf/votes/config.dat");
           $findnum = false;
           foreach ($config as $conf)
           {
                  $c = explode("|",$conf);
                  if ($c[0]==$number)
                  {
                       $line = $c;                       
                       $findnum = true;
                       break;
                  };
           };
           if ($findnum)
           {
               if (isset($_COOKIE['vote_'.$line[0]])) $alreadygolos = true;
               $vote = file($cms_root."/conf/votes/vote_".$line[0].".dat");
               $vine = explode("|",$vote[0]);
               $va   = unserialize($vine[1]);
               $vb   = unserialize($vine[2]);
               $vc   = unserialize($vine[3]);
               foreach ($vc as $vz)
               {
                     if ($ip==$vz)
                     {
                         $alreadygolos = true;
                         break;
                     };
               };
               if (!$alreadygolos)
               {
                     $vc[] = $ip;
                     $vb[$answer]++;
                     setcookie("vote_".$line[0], "voted", time() + 144000,"/");

                   $newvote = fopen($cms_root . "/conf/votes/vote_" . $line[0] . ".dat", "cb");
                   flock($newvote, LOCK_EX);
                   ftruncate($newvote, 0);
                   fwrite($newvote, $vine[0] . "|" . serialize($va) . "|" . serialize($vb) . "|" . serialize($vc) . "|");
                   flock($newvote, LOCK_UN);
                   fclose($newvote);

                     $pagetitle    = "Ваше мнение учтено";
                     $pageredirect = $_SERVER['HTTP_REFERER'];
                     (strstr($pageredirect,"?")) ? $pageredirect.="&vote=".$line[0] : $pageredirect.="?vote=".$line[0];
                     $ar = array("{TITLE}","{GENERATOR}","{READRESS}","{/READRESS}","{MESSAGE}","{URL}","{SITE}","{THEMEPATH}");
                     $br = array($pagetitle,"Ruxe Engine (www.ruxe-engine.ru)","","","Спасибо, Ваше мнение учтено",$pageredirect,$cms_site,$cms_site."/themes/".$cms_theme);
                     $openpage = $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
               }
               else
               {
                     $pagetitle    = "Ошибка";
                     $ar = array("{TITLE}","{GENERATOR}","{READRESS}","{/READRESS}","{MESSAGE}","{URL}","{SITE}","{THEMEPATH}");
                     $br = array($pagetitle,"Ruxe Engine (www.ruxe-engine.ru)","","","Вы уже голосовали в опросе \"".$vine[0]."\"",'',$cms_site,$cms_site."/themes/".$cms_theme);
                     $openpage = $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
               };
           }
           else
           {
               $pagetitle    = "Ошибка";
               $ar = array("{TITLE}","{GENERATOR}","{READRESS}","{/READRESS}","{MESSAGE}","{URL}","{SITE}","{THEMEPATH}");
               $br = array($pagetitle,"Ruxe Engine (www.ruxe-engine.ru)","","","Нельзя голосовать в несуществующем опросе",'',$cms_site,$cms_site."/themes/".$cms_theme);
               $openpage = $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
           };
           
      }
      else
      {
           $pagetitle    = "Ошибка";
           $ar = array("{TITLE}","{GENERATOR}","{READRESS}","{/READRESS}","{MESSAGE}","{URL}","{SITE}","{THEMEPATH}");
           $br = array($pagetitle,"Ruxe Engine (www.ruxe-engine.ru)","","","Вы не выбрали вариант ответа в голосовании",'',$cms_site,$cms_site."/themes/".$cms_theme);
           $openpage = $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
      };
    };
  };
   
  function here_votes()
  {
      global $cms_root,$_SERVER,$_COOKIE;
      if (file_exists($cms_root."/conf/votes/config.dat"))
      {
            $vconfig = file($cms_root."/conf/votes/config.dat");
            if (count($vconfig)>0)
            {
                 $vnumber  = rand(0,count($vconfig)-1);
                 $vopt     = explode("|",$vconfig[$vnumber]);
                 if (isset($_GET['vote']))
                 {
                          foreach ($vconfig as $vconf)
                          {
                               $vcon = explode("|",$vconf);
                               if ($vcon[0]==(int)$_GET['vote'])
                               {
                                   $vopt = explode("|",$vconf);
                               };
                          };
                 };
                 $vfile    = file($cms_root."/conf/votes/vote_".$vopt[0].".dat");
                 $vtmp     = explode("|",$vfile[0]);
                 include($cms_root."/includes/plugins/votes/template.php");
                 $vanswers = "";
                 $va       = unserialize($vtmp[1]);
                 $vb       = unserialize($vtmp[2]);
                 $vx       = 0;
                 $vc       = unserialize($vtmp[3]);
                 
                 $ip       = $_SERVER['REMOTE_ADDR'];
                 $cangolos = true;
                 if (isset($_COOKIE['vote_'.$vopt[0]])) $cangolos = false;
                 foreach ($vc as $vz)
                 {
                          if ($ip==$vz)
                          {
                              $cangolos = false;
                              break;
                          };
                 };
                 
                 if ($cangolos)
                 {                 
                    foreach ($va as $vz)
                    {
                           $vanswers.=str_replace(array("{VALUE}","{CAPTION}"),array($vx,$vz),$answer);
                           $vx++;
                    };
                    echo str_replace(array("{VOTENUMBER}","{QUESTION}","{ANSWERS}"),array($vopt[0],$vtmp[0],$vanswers),$general_template);
                 }
                 else
                 {
                    foreach ($va as $vz)
                    {
                           $vanswers.=str_replace(array("{ANSWER}","{COUNT}"),array($vz,$vb[$vx]),$answer_for_already_vote);
                           $vx++;
                    };
                    echo str_replace(array("{QUESTION}","{ANSWERS}"),array($vtmp[0],$vanswers),$already_vote);
                 };
            };
      };
  };
