<?php

/*
 * Ruxe Engine - Понятная CMS для людей
 * http://ruxe-engine.ru
 *
 * Это произведение доступно по Open Source лицензии
 * Creative Commons «Attribution-ShareAlike» («Атрибуция — На тех же
 * условиях») 4.0 Всемирная (CC BY-SA 4.0).
 *
 * Разработчики:
 * Ахрамеев Денис Викторович (http://ahrameev.ru) - Автор, программирование
 * Александр Wasilich Плотников (http://webdesign.ru.net/) - Темы оформления
 * Игорь Dr1D - Логотип, дизайн админ-центра
 * Олег Прохоров (http://ruxe-engine.ru/old/viewprofile/Tanatos) - Контроль качества, документация
 *
 */

$installer_version = '1.9 Beta';

include('conf/config.php');
include("includes/core.php");

if ($installer_version != $this_version)
{
	header("Expires: Mod, 26 Jul 1997 05:00:00 GMT");
	header("Last-Modified: ".gmdate("D, d M Y H:i:s", 10000) . " GMT");
	header("Cache-Control: no-cache, must-revalidate");
	header("Cache-Control: post-check=0,pre-check=0", false);
	header("Cache-Control: max-age=0",false);
	header("Pragma: no-cache");
	header('Content-type: text/html; charset=utf-8');
	die('Инсталлятор предназначен только для '.$installer_version.' версии');
};

if (!isset($_GET['step'])) 
	$_GET['step']='install';
//header("location: install.php?step=install&rand=".rand(1,999));



header("Expires: Mod, 26 Jul 1997 05:00:00 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s", 10000) . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: post-check=0,pre-check=0", false);
header("Cache-Control: max-age=0",false);
header("Pragma: no-cache");
header('Content-type: text/html; charset=utf-8');

$addpath = $_SERVER['PHP_SELF'];
$addpath = str_replace("/install.php", "", $addpath);
$addpath2 = $_SERVER['HTTP_HOST'].strtolower($addpath);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//RU" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <title>Мастер установки Ruxe Engine</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8">
  <meta name="generator" content="Ruxe Engine (http://ruxe-engine.ru)">
  <style>
   body {
        font-family:verdana,arial,tahoma;
        font-size:10pt;
        min-width:950px;
   }
   .spoiler {
        border-left: solid 1px silver;
        border-top: solid 1px silver;
        border-right: solid 1px silver;
        border-bottom: solid 1px silver;
        width:80%;
        background-color:#DDDDDD;
        text-align:left;
        font-family:verdana,arial,tahoma;
        font-size:8pt;
        font-weight: bold;
        padding:4px;
        margin-top:3px;
        margin-bottom:10px;
        }

   .spoilertext {
        font-family:verdana,arial,tahoma;
        background-color:#FFFFFF;
        font-size:10pt;
        padding:4px;
        margin-top:5px;
        font-weight: normal;
        }
   input {
        font-size:10pt;
        font-family:verdana,arial,tahoma;
	color: #111111;
	margin-right:2px;
	border-left: 1px solid silver;
	border-top: 1px solid silver;
	border-right: 1px solid silver;
	border-bottom: 1px solid silver;
	background-color: #F5F5F5;
   }
   input:hover, textarea:hover { 
	border-left: 1px solid #000000;
	border-top: 1px solid #000000;
	border-right: 1px solid #000000;
	border-bottom: 1px solid #000000;
	background-color: #FFF2D7;
  }
  .table {
        border-left: solid 1px silver;
        border-top: solid 1px silver;
        width:80%;
        text-align:left;
  }
  .table td{
        border-bottom: solid 1px silver;
        border-right:solid 1px silver;
        padding:4px;
        font-family:verdana,arial,tahoma;
        font-size:8pt;
  }
  .title td {
        background-color:#DDDDDD;
        text-align: left;
        font-weight: bold;
  }
  .optionstable{
        border-left: solid 1px silver;
        border-top: solid 1px silver;
        border-right: solid 1px silver;
        border-bottom: solid 1px silver;
        text-align:left;
        font-size:10pt;
        width:70%;
        padding:5px;
        background-color:#FFF2D7;
        font-weight: bold;
  }
  .text   {
        background-color:#FFFFFF;
        font-weight: normal;
        margin-top:5px;
        padding:5px;
  }
  textarea {
        font-size:8pt;
        font-family:verdana,arial,tahoma;
	color: #111111;
	margin-right:2px;
	width:100%;
	border-left: 1px solid silver;
	border-top: 1px solid silver;
	border-right: 1px solid silver;
	border-bottom: 1px solid silver;
	background-color: #F5F5F5;
  }
  </style>
</head>
<body>
<br><br><?php
  if (isset($_GET['step']))
  {
    switch($_GET['step'])
    {
       case "install":
            echo '
		<Center><div class="optionstable">
			Установка Ruxe Engine: Шаг 1 из 5
			 <div class="text"><h3>Лицензионное соглашение</h3>
				<form name="license" method="post" action="?step=2&amp;rand='.rand(1,9999).'">
					<textarea rows=25 readonly>';
		   include('LICENSE-FULL-EN.txt');
		   echo '</textarea><br>
<br><input type="checkbox" onClick=\'if (document.license.rule1.checked==true) {document.license.check.style.display="block";} else {document.license.check.style.display="none";}\' name="rule1" value="true"> Я принимаю условия данного лицензионного соглашения и обязуюсь выполнять их
<br>
<br><center><input style="display:none;" type="button" name="check" onClick=\'document.license.submit();\' value="Продолжить"></center>
</form>
 </div>           
</div></Center>    
            '; 
            break;
       case "2":
            echo '
<center>
<div class="optionstable">
Установка Ruxe Engine: Шаг 2 из 5
<div class="text">
';
            $error = false;
            if (!isset($_POST['rule1']))
            {
                echo 'Вы не приняли условия лицензионного соглашения. Продолжение установки невозможно.';
                $error = true;
            }
            else
            {
                if ($_POST['rule1']!='true')
                {
                    echo 'Вы не приняли условия лицензионного соглашения. Продолжение установки невозможно.';
                    $error = true;
                };
            };
            if (!$error)
            {
                $found = false;
                echo '<h3>Анализ важных файлов системы: Основные файлы системы</h3><br>';
		$iferror = '
                Все следующие файлы и папки должны быть обязательно загружены:<br>
				<center>
				<div style="margin-right:130px;text-align:right;">
					<a href="#footer"><img src="rpanel/theme/images/arrow-down.gif" border=0 alt=""></a> <a href="#footer">Вниз</a></div><br>
                   <table class="table" cellpadding=5 width="100%" cellspacing=0 border=0>
                    <tr class="title"><td>ПУТЬ</td><td width=75>ЗАГРУЖЕН</td><td width=60>ОШИБКА</td></tr>
                    ';
                $codestyle = array(
                'index.php',
                'includes/core.php',
                'includes/functions.action.php',
                'includes/functions.command.php',
                'includes/idna_convert.class.php',
                'includes/transcode_wrapper.php',
                'includes/uctc.php',
                'captcha/index.php',
                'captcha/kcaptcha.php',
                'captcha/kcaptcha_config.php',
                'captcha/fonts/antiqua.png',
                'captcha/fonts/baskerville.png',
                'captcha/fonts/batang.png',
                'captcha/fonts/bookman.png',
                'captcha/fonts/calisto.png',
                'captcha/fonts/cambria.png',
                'captcha/fonts/centaur.png',
                'captcha/fonts/century.png',
                'captcha/fonts/chaparral.png',
                'captcha/fonts/constantia.png',
                'captcha/fonts/footlight.png',
                'captcha/fonts/garamond.png',
                'captcha/fonts/georgia.png',
                'captcha/fonts/goudy_old.png',
                'captcha/fonts/kozuka.png',
                'captcha/fonts/lucida.png',
                'captcha/fonts/minion.png',
                'captcha/fonts/palatino.png',
                'captcha/fonts/perpetua.png',
                'captcha/fonts/rockwell.png',
                'captcha/fonts/times.png',
                'captcha/fonts/warnock.png',
                'captcha/util/font_preparer.php',
                'captcha/util/index.php',
                'includes/languages/ru/general.php',
                'includes/languages/ru/admin.php',
                'rpanel/bfgshow.php',
                'rpanel/check.php',
                'rpanel/check2.php',
                'rpanel/faq.php',
                'rpanel/index.php',
                'rpanel/login.php',
                'rpanel/messages.php',
                'rpanel/saver.php',
                'rpanel/system.php',
                'rpanel/users.php',
                'rpanel/theme/addfaq.tpl',
                'rpanel/theme/addnew.tpl',
                'rpanel/theme/admincenterend.tpl',
                'rpanel/theme/admincenterlogin.tpl',
                'rpanel/theme/admincenteroptions.tpl',
                'rpanel/theme/admincenterstart.tpl',
                'rpanel/theme/bfg.tpl',
                'rpanel/theme/edit_end.tpl',
                'rpanel/theme/edit_start.tpl',
                'rpanel/theme/general.tpl',
                'rpanel/theme/manager.tpl',
                'rpanel/theme/messages.tpl',
                'rpanel/theme/pages.tpl',
                'rpanel/theme/rpanel.css',
                'rpanel/theme/rpanel.js',
                'rpanel/theme/somemessages.tpl',
                'rpanel/theme/stat.tpl',
                'rpanel/theme/system.tpl',
                'rpanel/theme/edit_area/edit_area_full.js',
                'rpanel/theme/edit_area/license_apache.txt',
                'rpanel/theme/edit_area/license_bsd.txt',
                'rpanel/theme/edit_area/license_lgpl.txt',
                'rpanel/theme/edit_area/images/autocompletion.gif',
                'rpanel/theme/edit_area/images/close.gif',
                'rpanel/theme/edit_area/images/fullscreen.gif',
                'rpanel/theme/edit_area/images/go_to_line.gif',
                'rpanel/theme/edit_area/images/help.gif',
                'rpanel/theme/edit_area/images/highlight.gif',
                'rpanel/theme/edit_area/images/load.gif',
                'rpanel/theme/edit_area/images/move.gif',
                'rpanel/theme/edit_area/images/newdocument.gif',
                'rpanel/theme/edit_area/images/opacity.png',
                'rpanel/theme/edit_area/images/processing.gif',
                'rpanel/theme/edit_area/images/redo.gif',
                'rpanel/theme/edit_area/images/reset_highlight.gif',
                'rpanel/theme/edit_area/images/save.gif',
                'rpanel/theme/edit_area/images/search.gif',
                'rpanel/theme/edit_area/images/smooth_selection.gif',
                'rpanel/theme/edit_area/images/spacer.gif',
                'rpanel/theme/edit_area/images/statusbar_resize.gif',
                'rpanel/theme/edit_area/images/undo.gif',
                'rpanel/theme/edit_area/images/word_wrap.gif',
                'rpanel/theme/edit_area/langs/ru.js',
                'rpanel/theme/edit_area/langs/en.js',
                'rpanel/theme/edit_area/reg_syntax/css.js',
                'rpanel/theme/edit_area/reg_syntax/html.js',
                'rpanel/theme/edit_area/reg_syntax/js.js',
                'rpanel/theme/edit_area/reg_syntax/php.js',
		
		
		
		
		//tinymce
		'rpanel/theme/tiny_mce/license.txt',
		'rpanel/theme/tiny_mce/tinymce.min.js',
		//
		
		//elRTE
		/*'rpanel/theme/elrte/css/elrte.full.css',
		'rpanel/theme/elrte/css/elrte.min.css',
		'rpanel/theme/elrte/css/elrte-inner.css',
		'rpanel/theme/elrte/css/smoothness/jquery-ui-1.8.13.custom.css',
		'rpanel/theme/elrte/css/smoothness/images/ui-bg_flat_0_aaaaaa_40x100.png',
		'rpanel/theme/elrte/css/smoothness/images/ui-bg_flat_75_ffffff_40x100.png',
		'rpanel/theme/elrte/css/smoothness/images/ui-bg_glass_55_fbf9ee_1x400.png',
		'rpanel/theme/elrte/css/smoothness/images/ui-bg_glass_65_ffffff_1x400.png',
		'rpanel/theme/elrte/css/smoothness/images/ui-bg_glass_75_dadada_1x400.png',
		'rpanel/theme/elrte/css/smoothness/images/ui-bg_glass_75_e6e6e6_1x400.png',
		'rpanel/theme/elrte/css/smoothness/images/ui-bg_glass_95_fef1ec_1x400.png',
		'rpanel/theme/elrte/css/smoothness/images/ui-bg_highlight-soft_75_cccccc_1x100.png',
		'rpanel/theme/elrte/css/smoothness/images/ui-icons_2e83ff_256x240.png',
		'rpanel/theme/elrte/css/smoothness/images/ui-icons_222222_256x240.png',
		'rpanel/theme/elrte/css/smoothness/images/ui-icons_454545_256x240.png',
		'rpanel/theme/elrte/css/smoothness/images/ui-icons_888888_256x240.png',
		'rpanel/theme/elrte/css/smoothness/images/ui-icons_cd0a0a_256x240.png',
		'rpanel/theme/elrte/images/elrte-toolbar.png',
		'rpanel/theme/elrte/images/iframe.png',
		'rpanel/theme/elrte/images/loading.gif',
		'rpanel/theme/elrte/images/outline-div.png',
		'rpanel/theme/elrte/images/outline-p.png',
		'rpanel/theme/elrte/images/pagebreak.gif',
		'rpanel/theme/elrte/images/pixel.gif',
		'rpanel/theme/elrte/js/elrte.full.js',
		'rpanel/theme/elrte/js/elrte.min.js',
		'rpanel/theme/elrte/js/jquery-1.6.1.min.js',
		'rpanel/theme/elrte/js/jquery-ui-1.8.13.custom.min.js',
		'rpanel/theme/elrte/js/i18n/elrte.en.js',
		'rpanel/theme/elrte/js/i18n/elrte.ru.js',*/
		
		
		
                'rpanel/theme/images/arrow-down.gif',
                'rpanel/theme/images/birthday.jpg',
                'rpanel/theme/images/dir.png',
                'rpanel/theme/images/false.gif',
                'rpanel/theme/images/file.png',
                'rpanel/theme/images/imbody.jpg',
                'rpanel/theme/images/img_head_left.jpg',
                'rpanel/theme/images/img_headmenu_bg.jpg',
                'rpanel/theme/images/img_head_right.jpg',
                'rpanel/theme/images/img_menu_bg.jpg',
                'rpanel/theme/images/img_menu_left.jpg',
                'rpanel/theme/images/img_menu_right.jpg',
                'rpanel/theme/images/img_navy_bg.jpg',
                'rpanel/theme/images/menu_center.bmp',
                'rpanel/theme/images/nleft.jpg',
                'rpanel/theme/images/nright.jpg',
                'rpanel/theme/images/rpanel.jpg',
                'rpanel/theme/images/true.gif',
                'rpanel/theme/images/valid-html401.png',
                'rpanel/theme/images/vcss.gif',
                'rpanel/theme/images/vleft.jpg',
                'rpanel/theme/images/vright.jpg'
                );
                foreach ($codestyle as $code)
                {
                    $errorcode = "Нет";
                    if (file_exists($code))
                    {
                      $loaded = "<img src=\"rpanel/theme/images/true.gif\" border=0>";
                    }
                    else
                    {
                      $loaded = "<img src=\"rpanel/theme/images/false.gif\" border=0>";
                      $errorcode = "Да";
                    };
                    if ($errorcode == "Да") $found=true; 
			$iferror.='<tr><td>'.$code.'</td><td align="center">'.$loaded.'</td><td align="center">'.$errorcode.'</td></tr>
';
                }; 
		if (!$found)
		{
			echo '    
				Основные файлы системы загружены на сервер.<br><br>
			';
		}
		else
		{
			$iferror .= '
						</table>
					</centeR>
				<br><a name="footer"> </a>
			';
			echo $iferror;
		};
                if ($found)
                {
                    echo '<center><form name="edit" method="post" action="?step=2&rand='.rand(0,9999).'">
                    <font color="red"><b>На данном шаге установки обнаружены ошибки. Пожалуйста, исправьте их и обновите страницу</b></font><br><br>
                    <input type="hidden" name="rule1" value="true">
                    <input type="submit" name="submit" value="Обновить страницу">
                    </form> </center>';
                }
                else
                {
                     echo '<center>
                     <form name="edit" method="post" action="?step=3&rand='.rand(0,99999).'">
                      <input type="hidden" name="rule1" value="true">
                      <input type="submit" name="submit" value="Продолжить">
                     </form>
                     </center>';
                };
                echo '<br>
                ';
            };
echo '</div>
</div>
</center>
';
            break;
       case "3":
            echo '
<center>
<div class="optionstable">
Установка Ruxe Engine: Шаг 3 из 5
<div class="text">
';
            $error = false;
            if (!isset($_POST['rule1']))
            {
                echo 'Вы не приняли условия лицензионного соглашения. Продолжение установки невозможно.';
                $error = true;
            }
            else
            {
                if ($_POST['rule1']!='true')
                {
                    echo 'Вы не приняли условия лицензионного соглашения. Продолжение установки невозможно.';
                    $error = true;
                };
            };
            if (!$error)
            {
                $found = false;
                echo '<h3>Анализ важных файлов системы: Конфигурация и др.</h3><br>';
		$iferror='
                Все следующие файлы и папки должны быть обязательно загружены и иметь права на запись:
                <br>&nbsp;&nbsp;&nbsp;&nbsp;1. Файл <b>.htaccess</b>
                <br>&nbsp;&nbsp;&nbsp;&nbsp;2. Каталог <b>/avatars/</b> и все файлы в нём
                <br>&nbsp;&nbsp;&nbsp;&nbsp;3. Каталог <b>/conf/</b>, все файлы и подкаталоги в нём
                <br>&nbsp;&nbsp;&nbsp;&nbsp;4. Каталог <b>/themes/</b>, все файлы и подкаталоги в нём
                <br>&nbsp;&nbsp;&nbsp;&nbsp;5. Каталог <b>/smiles/</b> и все файлы в нём
                <br>&nbsp;&nbsp;&nbsp;&nbsp;6. Каталог <b>/rpanel/backups/</b><br>
                <div style="margin-right:130px;text-align:right;"><a href="#footer"><img src="rpanel/theme/images/arrow-down.gif" border=0 alt=""></a> <a href="#footer">Вниз</a></div><br>
                   <center><table class="table" cellpadding=5 width="100%" cellspacing=0 border=0>
                    <tr class="title"><td>ПУТЬ</td><td width=75>ЗАГРУЖЕН</td><td width=125>ПРАВА НА ЗАПИСЬ</td><td width=60>ОШИБКА</td></tr>
                    ';
                $codestyle = array(
                ".htaccess",
                "avatars/",
                "conf/",
                "themes/",
                "smiles/",
                "rpanel/backups/"
                );
                foreach ($FileManager->listing("avatars/",0) as $a)
                        $codestyle[]="avatars/".$a;
                foreach ($FileManager->listing("smiles/",0) as $a)
                        $codestyle[]="smiles/".$a;
                foreach ($FileManager->listing("conf/",0) as $a)
                        $codestyle[]="conf/".$a;
                foreach ($FileManager->listing("conf/",1) as $a)
                {
                        $codestyle[]="conf/".$a;
                        foreach ($FileManager->listing("conf/".$a,0) as $b) $codestyle[]="conf/".$a."/".$b;
                };
                
                foreach ($FileManager->listing("themes/",1) as $a)
                {
                        $codestyle[]="themes/".$a;
                        foreach ($FileManager->listing("themes/".$a,0) as $b) $codestyle[]="themes/".$a."/".$b;
                };
                foreach ($codestyle as $code)
                {
                    $errorcode = "Нет";
                    if (file_exists($code))
                    {
                      $loaded = "<img src=\"rpanel/theme/images/true.gif\" border=0>";
                    }
                    else
                    {
                      $loaded = "<img src=\"rpanel/theme/images/false.gif\" border=0>";
                      $errorcode = "Да";
                    };
                    if (is_writeable($code))
                    {
                      $write = "<img src=\"rpanel/theme/images/true.gif\" border=0>";
                    }
                    else
                    {
                      $write = "<img src=\"rpanel/theme/images/false.gif\" border=0>";
                      $errorcode = "Да";
                    };
                    if ($errorcode == "Да") $found=true; 
                    $iferror.= '<tr><td>'.$code.'</td><td align="center">'.$loaded.'</td><td align="center">'.$write.'</td><td align="center">'.$errorcode.'</td></tr>
                    ';
                };    
                $iferror.= '    
                   </table></center>
                   <br><a name="footer"> </a>
                   ';
		
                if ($found)
                {
			echo $iferror;
                    echo '
		    <center><form name="edit" method="post" action="?step=3&rand='.rand(0,9999).'">
                    <font color="red"><b>На данном шаге установки обнаружены ошибки. Пожалуйста, исправьте их и обновите страницу</b></font><br><br>
                    <input type="hidden" name="rule1" value="true">
                    <input type="submit" name="submit" value="Обновить страницу">
                    </form> </center>';
                }
                else
                {
                     echo '
			Конфигурационные файлы загружены и имеют права на запись.<br><br>
		     <center>
                     <form name="edit" method="post" action="?step=4&rand='.rand(0,99999).'">
                      <input type="hidden" name="rule1" value="true">
                      <input type="submit" name="submit" value="Продолжить">
                     </form>
                     </center>';
                };
                echo '<br>
                ';
            };
echo '</div>
</div>
</center>
';
            break;
       case "4":
            echo '
<center>
<div class="optionstable">
Установка Ruxe Engine: Шаг 4 из 5
<div class="text">
';
            $error = false;
            if (!isset($_POST['rule1']))
            {
                echo 'Вы не приняли условия лицензионного соглашения. Продолжение установки невозможно.';
                $error = true;
            }
            else
            {
                if ($_POST['rule1']!='true')
                {
                    echo 'Вы не приняли условия лицензионного соглашения. Продолжение установки невозможно.';
                    $error = true;
                };
            };
            if (!$error)
            {
                $found = false;
                echo '<h3>Анализ конфигурации сервера</h3><br>';
                if (!extension_loaded('gd')) {
                  $gd = "Не установлена";
                  $found=true;
                }
                else  
                  $gd = "Установлена";
                if (!function_exists('version_compare'))
                  $found = true;
                
                
                if (function_exists('apache_get_modules'))
                {
                   if (in_array('mod_rewrite', apache_get_modules()))
                   {
                       $modrewrite="Установлен";
                   }
                   else
                   {
                       if (isset($_POST['mr']))
                       {
                         $modrewrite = "<font color=\"green\"><b>Проверка пропущена</b></font>";
                       }
                       else
                       {
                         //$found = true;
                         $modrewrite = "Не установлен";
                       };
                   };
                }
                else
                {
                  //http://stackoverflow.com/questions/1301118/how-to-detect-mod-rewrite-without-apache-get-modules
                  ob_start();
                  phpinfo(INFO_MODULES);
                  $im = ob_get_contents();
                  ob_end_clean();
                  
                  if (strstr($im, 'mod_rewrite') != '') 
                  {
                     $modrewrite="Установлен";
                  }
                  else
                  {
                     if (isset($_POST['mr']))
                     {
                         $modrewrite = "<font color=\"green\"><b>Проверка пропущена</b></font>";
                     }
                     else
                     {
                         //$found = true;
                         $modrewrite = "Не установлен";
                     };
                  };
                };
                
                $ver = phpversion();
                /*if (is_writeable(".htaccess"))
                {
                  $htac = "Имеются";
                }
                else
                { 
                  $htac = "Не установлены";
                  $found = true;
                };*/ 
                if (ini_get('register_globals'))
                {
                  $rg = "Включён";
                  $found = true;                
                }
                else
                  $rg = "Отключён";
                //<tr><td>Права на запись /.htaccess</td><td>'.$htac.'</td><td>Имеются</td></tr>
		//<tr><td>Модуль mod_rewrite</td><td>'.$modrewrite.'</td><td>Установлен</td></tr>
                echo '<center><table class="table" cellpadding=5 width="100%" cellspacing=0 border=0>
                  <tr class="title"><td>ПАРАМЕТР</td><td>ЗНАЧЕНИЕ</td><td>ДОЛЖНО БЫТЬ</td></tr>
                  <tr><td>GD библиотека</td><td>'.$gd.'</td><td>Установлена</td></tr>
                  <tr><td>Версия PHP</td><td>'.$ver.'</td><td>5.3 или новее</td></tr>
                  <tr><td>Параметр Register Globals</td><td>'.$rg.'</td><td>Отключён</td></tr>
                </table></center><br>
                ';
                if ($found)
                {
                    echo '<center><form name="edit" method="post" action="?step=4&rand='.rand(0,9999).'">';
                    /*if ($modrewrite=="Не установлен")
                    {
                        echo '<font color="green"><b><INPUT TYPE="checkbox" NAME="mr" VALUE="force"> Я УВЕРЕН, что на сервере установлен и включён модуль mod_rewrite<br>(Ruxe Engine не всегда верно определяет наличие mod_rewrite)</b></font><br><br>';
                    };*/
                    echo '
                    <font color="red"><b>На данном шаге установки обнаружены ошибки. Обратитесь к администратору сервера или внесите сами нужные изменения, если имеете достаточные привилегии.</b></font><br><br>';
                    echo '
                    <input type="hidden" name="rule1" value="true">
                    <input type="submit" name="submit" value="Обновить страницу">
                    </form> </center>';
                }
                else
                {
			$md	=	($modrewrite=="Не установлен")?"no":"yes";
                     echo '<center>
                     <form name="edit" method="post" action="?step=5&rand='.rand(0,99999).'">
                      <input type="hidden" name="rule1" value="true">
		      <input type="hidden" name="modrewrite" value="'.$md.'">
                      <input type="submit" name="submit" value="Продолжить">
                     </form>
                     </center>';
                };
            };
echo '</div>
</div>
</center>
';
            break;
       case "5":
            echo '
<center>
<div class="optionstable">
Установка Ruxe Engine: Шаг 5 из 5
<div class="text">
';
            $error = false;
            if (!isset($_POST['rule1']))
            {
                echo 'Вы не приняли условия лицензионного соглашения. Продолжение установки невозможно.';
                $error = true;
            }
            else
            {
                if ($_POST['rule1']!='true')
                {
                    echo 'Вы не приняли условия лицензионного соглашения. Продолжение установки невозможно.';
                    $error = true;
                };
            };
            if (!$error)
            {
                $found = false;
                $languages = "";
                foreach ($FileManager->listing("includes/languages/",1) as $l)
                {
                          //include("includes/languages/".$l);
                          $file = file("includes/languages/".$l."/general.php");
                          foreach ($file as $f)
                          {
                              if (strstr($f,"language_info']"))
                              {
                                   $info = str_replace("\$lcms","",$f);
                                   $info = str_replace(" = ","",$info);
                                   $info = str_replace(" =","",$info);
                                   $info = str_replace("= ","",$info);
                                   $info = str_replace("=","",$info);
                                   $info = str_replace("\"","",$info);
                                   $info = str_replace("'","",$info);
                                   $info = str_replace(";","",$info);
                                   $info = str_replace("[","",$info);
                                   $info = str_replace("]","",$info);
                                   $info = str_replace("language_info","",$info);
                              };
                          };
                          if ($l=="ru")
                          {
                             $languages.='<option value="'.$l.'" selected>'.$info;
                          }
                          else
                          {
                             $languages.='<option value="'.$l.'">'.$info;
                          };
                };
                $site = $_SERVER['HTTP_HOST'].$addpath;
                $root = str_replace("/install.php","",$_SERVER['SCRIPT_FILENAME']);
                $flag = @file($root."/install.php");
                if (!$flag) $root = ".";
		if ($_POST['modrewrite']=='no')
		{
			$furl	=	'<option value="1">Да<option value="0" selected>Нет';
			$finfo	=	'red; font-weight: bold';
			$sinfo	=	'';
		}
		else
		{
			$furl	=	'<option value="1" selected>Да<option value="0">Нет';
			$finfo	=	'grey';
			$sinfo	=	', рекомендуется';
		};
		//<tr><td align="left">Включить поддержку кириллических доменов:<br><font style="color:grey;font-size:8pt;">Автоматическое преобразование кириллических доменов (напр., <i>мой-черновик.рф</i>) в Punycode (<b>требуется PHP версии 5.2 или новее</b>).</font></td><td><select name="pc"><option value="yes">Да<option value="no" selected>Нет</select></td></tr>
                echo '<h3>Установка главных параметров</h3><br>
                <form name="edit" action="?step=6&rand='.rand(0,99999).'" method="post">
                 <center><table border=0 cellpadding=5>
                  <tr><td align="left">Логин администратора:<br><font style="color:grey;font-size:8pt;">В логине можно использовать буквы английского и русского алфавита, числа, <b>@</b>, <b>!</b>, <b>-</b> и <b>*</b>. От 4 до 20 символов.</font></td><td><input type="text" name="login" size=46></td></tr>
                  <tr><td align="left">Пароль:<br><font style="color:grey;font-size:8pt;">Как и в логине, в пароле можно использовать <b>только</b> буквы английского алфавита, числа, <b>@</b>, <b>!</b>, <b>-</b> и <b>*</b>. От 4 до 20 символов.</font></td><td><input type="password" name="password" size=46></td></tr>
                  <tr><td align="left">Повторите пароль:</td><td><input type="password" name="replaypassword" size=46></td></tr>
                  <tr><td align="left">E-mail:</td><td><input type="text" name="mail" size=46></td></tr>
                  <tr><td align="left">Адрес сайта:</font></td><td><input type="text" name="site" size=46 value="http://'.$site.'"></td></tr>
                  <tr><td align="left">Полный путь до скриптов:<br><font style="color:grey;font-size:8pt;">Путь к каталогу с системой на сервере. Как правило, указывается в инструкции к хостингу в DOCUMENT_ROOT, но лучше оставить автоматически подставленное значение.</font></td><td><input type="text" name="root" size=46 value="'.$root.'"></td></tr>
		  <tr><td align="left">Активировать ЧПУ (человекопонятные урл'.$sinfo.'):<br><font style="color:'.$finfo.'; font-size:8pt;">Требуется Apache веб-сервер с mod_rewrite.</font></td><td><select name="furlresult">'.$furl.'</select></td></tr>
                  <tr><td align="left">Язык:<br><font style="color:grey;font-size:8pt;"><b>Внимание!</b> Смена языка не действует на админ-центр и темы оформления.</font></td><td><select name="language">'.$languages.'</select></td></tr>                  
                 </table></center><br><br>
                 <input type="hidden" name="rule1" value="true">
                 <center><input type="submit" name="submit" value="Продолжить">
                 </center>
                </form>
                ';
            };
echo '</div>
</div>
</center>
';
            break;
       case "6":
            echo '
<center>
<div class="optionstable">
Установка Ruxe Engine
<div class="text">
';
            $error = false;
            
            if (!$GlobalUsers->checklogin($_POST['login']))
            {
                echo 'В логине можно использовать только буквы английского и русского алфавита, числа, @, !, - и *. От 4 до 20 символов. ';
                $error = true;
            };
            if (!$GlobalUsers->checkpassword($_POST['password'],$_POST['replaypassword']))
            {
                echo 'В пароле можно использовать только буквы английского алфавита, числа, @, ! и -. От 4 до 20 символов. Повтор пароля должен быть идентичен паролю. ';
                $error = true;
            };
            if (!$Mailing->checkmail($_POST['mail']))
            {
                echo 'Вы указали неверный e-mail администратора. ';
                $error = true;
            };
            if (!$_POST['site'])
            {
                echo 'Вы не указали адрес сайта. ';
                $error = true;
            };
            if (!$_POST['root'])
            {
                echo 'Вы не указали ROOT адрес. ';
                $error = true;
            };
            
            
            
            if (!isset($_POST['rule1']))
            {
                echo 'Вы не приняли условия лицензионного соглашения. Продолжение установки невозможно.';
                $error = true;
            }
            else
            {
                if ($_POST['rule1']!='true')
                {
                    echo 'Вы не приняли условия лицензионного соглашения. Продолжение установки невозможно.';
                    $error = true;
                };

            };
            if ($error) echo "<br><br><center><a href=\"javascript:history.go(-1);\">Вернуться</a></center>";
            if (!$error)
            {
                $login = $Filtr->clear($_POST['login']);
                $password = $Filtr->clear($_POST['password']);
                $mail = $Filtr->clear($_POST['mail']);
                $language = $Filtr->clear($_POST['language']);
                $site = $Filtr->clear($_POST['site']);
                $root = $Filtr->clear($_POST['root']);
		include($root."/conf/config.php");
                $cms_root	=	$root;
                $cms_site	=	$site;
		$cms_furl	=	(int)$_POST['furlresult'];
		
		//$puny		=	$Filtr->clear($_POST['pc']);
		$puny		=	'no';
		/*if ($puny=='yes')
		{
			require_once('includes/idna_convert.class.php');
			$IDN = new idna_convert();
			$tmp = $IDN->encode($site);
			$site = htmlentities($tmp, null, 'UTF-8');
			$respc	=	1;
		}
		else*/
			$respc	=	0;
                $cms_root = $root;
                $usersfruits[0] = 1;
                $gen			=	$Filtr->randwords(12);
                $usersfruits[22]	=	$gen;
                $usersfruits[23]	=	'yes';
                $usersfruits[1] 	= 	md5(md5($password).$gen);
                $usersfruits[2] = $mail;
                $usersfruits[4] = "admin";
                $usersfruits[12] = $Filtr->clear($_SERVER['REMOTE_ADDR']);
                $usersfruits[18] = $login;
                $usersfruits[20] = date("d.m.y, H:i");
                $GlobalUsers->editpoles("pos",0);
                $file = fopen($root."/conf/config.php","w");
                fwrite($file,"<?php
\$cms_site=\"".$Filtr->delendslash($site)."\";
\$cms_root=\"".$Filtr->delendslash($root)."\";
\$cms_gzip=".$cms_gzip.";
\$cms_sendmess=".$cms_sendmess.";
\$cms_mail=\"".$mail."\";
\$cms_needlog=".$cms_needlog.";
\$cms_needalog=".$cms_needalog.";
\$cms_online_time=".$cms_online_time.";
\$cms_needrecord=".$cms_needrecord.";
\$cms_closed=".$cms_closed.";
\$cms_closed_text=\"".$cms_closed_text."\";
\$cms_nocache=".$cms_nocache.";
\$cms_noshowerr=".$cms_noshowerr.";
\$cms_ban=".$cms_ban.";
\$cms_http=".$cms_http.";
\$cms_noindexlinks=".$cms_noindexlinks.";
\$cms_premoder=".$cms_premoder.";
\$cms_time_cookie=".$cms_time_cookie.";
\$cms_banlog=".$cms_banlog.";
\$cms_smiles=".$cms_smiles.";
\$cms_oncomments=".$cms_oncomments.";
\$cms_noflood = ".$cms_noflood.";
\$cms_top_show = ".$cms_top_show.";
\$cms_top_count = ".$cms_top_count.";
\$cms_views_counter = ".$cms_views_counter.";
\$cms_max_message = ".$cms_max_message.";
\$cms_mail_select = \"".$cms_mail_select."\";
\$cms_save_admin_ip = \"".$cms_save_admin_ip."\";
\$cms_rewrite = ".$cms_rewrite.";
\$cms_active = ".$cms_active.";
\$cms_active_mail = \"".$cms_active_mail."\";
\$cms_active_name = \"".$cms_active_name."\";
\$cms_avatars = ".$cms_avatars.";
\$cms_upload_maxsite = ".$cms_upload_maxsite.";
\$cms_upload_width = ".$cms_upload_width.";
\$cms_upload_height = ".$cms_upload_height.";
\$cms_restore = ".$cms_restore.";
\$cms_ps = ".$cms_ps.";
\$cms_ps_max = ".$cms_ps_max.";
\$cms_plusmess = ".$cms_plusmess.";
\$cms_rewrite_ext = \"".$cms_rewrite_ext."\";
\$cms_cenzura = ".$cms_cenzura.";
\$cms_cenzura_words = \"".$cms_cenzura_words."\";
\$cms_lastposts_count = ".$cms_lastposts_count.";
\$cms_lastposts_len = ".$cms_lastposts_len.";
\$cms_theme = \"".$cms_theme."\";
\$cms_directdownload = ".$cms_directdownload.";
\$cms_fullredirect = ".$cms_fullredirect.";
\$cms_pm_max = ".$cms_pm_max.";
\$cms_pm_showusers = ".$cms_pm_showusers.";
\$cms_avatars_resize = ".$cms_avatars_resize.";
\$cms_avatars_maxresize = ".$cms_avatars_maxresize.";
\$cms_log_max = ".$cms_log_max.";
\$cms_gravatars = ".$cms_gravatars.";
\$cms_gravatars_im = \"".$cms_gravatars_im."\";
\$cms_guestnotwrite = ".$cms_guestnotwrite.";
\$cms_language = \"".$language."\";
\$cms_createlinks = ".$cms_createlinks.";
\$cms_img_comment	= 0;
\$cms_send_mail = \"".$cms_send_mail."\";
\$cms_timezone = \"".$cms_timezone."\";
\$cms_adminm = ".$cms_adminm.";
\$cms_fontfamily = \"".$cms_fontfamily."\";
\$cms_fontsize = ".$cms_fontsize.";
\$cms_nav_news          = ".$cms_nav_news.";
\$cms_nav_comments      = ".$cms_nav_comments.";
\$cms_nav_downloads     = ".$cms_nav_downloads.";
\$cms_nav_faq           = ".$cms_nav_faq.";
\$cms_nav_pm            = ".$cms_nav_pm.";
\$cms_nav_system        = ".$cms_nav_system.";
\$cms_editarea          = ".$cms_editarea.";
\$cms_editareawp        = ".$cms_editareawp.";
\$cms_oneipreg	        = ".$cms_oneipreg.";
\$cms_hide_admin	= ".$cms_hide_admin.";
\$cms_without_mail	= ".$cms_without_mail.";
\$cms_uniqbfg		= ".$cms_uniqbfg.";
\$cms_rss_title		= \"".$cms_rss_title."\";
\$cms_punycode		= ".$respc.";
\$cms_visual		= ".$cms_visual.";
\$cms_simcount		= ".$cms_simcount.";
\$cms_furl		= ".$cms_furl.";
\$cms_showbfghints	= ".$cms_showbfghints.";
\$cms_premod_mess	= ".$cms_premod_mess.";
\$cms_rss_count		= ".$cms_rss_count.";
\$cms_whois		= \"".$cms_whois."\";
\$cms_wwwredirect	= ".$cms_wwwredirect.";
\$cms_title_length	= ".$cms_title_length.";
\$cms_registration	= ".$cms_registration.";
\$cms_nav_back		= ".$cms_nav_back.";
\$cms_top_news_max	= ".$cms_top_news_max.";
");
                fclose($file); 
                
                $new	=	fopen('conf/checkbackup.dat','w');
		fwrite($new,md5(rand(1,9999).rand(1,9999)));
		fclose($new);

		$GlobalBFG->refreshrewrite(2,true,$addpath);
                
                
                if (!file_exists("conf/users/pm_1.dat"))
                {
                    $new = fopen("conf/users/pm_1.dat","w");
                    fwrite($new, "inbox|false|Мастер установки|".date("d.m.y, H:i")."|Поздравление|0.0.0.0|[center]Поздравляем с установкой Ruxe Engine [wink][/center]|\r\n");
                    fclose($new);
                    chmod("conf/users/pm_1.dat",0777);
                };

                echo '<h3>Установка завершена</h3><br>
                <br>
                Установка Ruxe Engine успешно завершена, и Вы можете приступить к работе с системой.<br>
                <b>В целях обеспечения безопасности, удалите файл <i>install.php</i>.</b>
                <br><br>
                Вы установили '.$this_version.' версию<br>
                Последняя: <img src="http://ruxe-engine.ru/enginever.php?rand='.rand(0,9999).'" border=0> версия
               <br><br>
	       Обратите внимание - Ruxe Engine работает <b>только</b> в UTF-8 (без BOM) кодировке. При изменении страниц или шаблонов внешним редактором (не из админ-центра), сохраняйте в UTF-8 (без BOM) кодировке.
	       <br><br>
               <center><a style="font-size:14pt;" href="rpanel/">Перейти в админ-центр</a><font style="font-size:14pt;"><br>('.$site.'/rpanel/)<br></font>
                <br><br><br><div style="border: 1px solid silver; background-color:#FFF2D7; text-align:center; margin-left:90px; margin-right:90px;"><b>
                Ruxe Engine БЕСПЛАТНАЯ программа. Если Вы заплатили за неё деньги,<br>
                требуйте у продавца вернуть Ваши деньги обратно.<br><br>
                Кроме того, оригинальные и свежие дистрибутивы Ruxe Engine находятся всегда по адресу:<br><a href="http://ruxe-engine.ru" target="_blank">http://ruxe-engine.ru</a>.
                <br>Если у Вас есть сомнения насчёт оригинальности используемого дистрибутива, рекомендуется скачать его по вышеуказанному адресу.                                                                               
                </b></div> 
                <br><br>
                ';
            };
echo '</div>
</div>
</center>
';
            break;
    };
  };
?>
<br><br><center><font style="color:#6B6B6B;">Powered by <a target="_blank" style="color:#6B6B6B;font-weight:bold;" href="http://ruxe-engine.ru">Ruxe Engine</a></font></center>
</body>
</html>