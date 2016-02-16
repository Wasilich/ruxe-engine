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

@session_start();
$pagefooter	 = 	"";
$pageredirect 	 = 	"";
$openpage 	 = 	"";
$ban_message	 =	"";
setlocale(LC_ALL, "ru_RU.UTF-8");
$ttt		 =	microtime();
$ttt		 =	((double)strstr($ttt, ' ')+(double)substr($ttt,0,strpos($ttt,' ')));
$action		 = 	(isset($_GET['action'])) ? $_GET['action'] : '';
$page		 =	(isset($_GET['page'])) ? $_GET['page'] : '';

include("conf/config.php");
if (isset($_COOKIE['lang'])) {
	if (preg_match('/^[a-z]+$/u', $_COOKIE['lang'])) {
		$tmpLang = htmlspecialchars($_COOKIE['lang']);
		if (file_exists($cms_root.'/includes/languages/'.$tmpLang.'/general.php'))
			$cms_language = $tmpLang;
	}
}
include("includes/core.php");

//Загрузка локализации
if (isset($cms_language))
	include("includes/languages/".$cms_language."/general.php");
else
	include("includes/languages/ru/general.php");

//Загрузка шаблона сообщений
$retpldef 	 = 	'';
$tmp      	 = 	file("rpanel/theme/somemessages.tpl");
foreach ($tmp as $t)
	$retpldef.=$t."\r\n";

//Проверка корректности установки
$test_cms 	= 	$cms_root."/conf/users/config.dat";
if (!file_exists($test_cms))
{
	header('Content-type: text/html; charset=utf-8');
	$ar = array("{TITLE}","{GENERATOR}","{URL}","{MESSAGE}","{READRESS}","{/READRESS}");
	$br = array($lcms['start_title'],"Ruxe Engine (http://ruxe-engine.ru/)","rpanel/install.php?step=install","<center>".$lcms['start_text']."</center>","<!-- "," -->");
	echo str_replace($ar,$br,$retpldef);
	exit;
};

//Проверка авторизации
$GlobalUsers->checkthisuser();

if (isset($_GET['action']))
{
        if (($_GET['action']=="pm") && (isset($_GET['from'])))
        {
             $ocms[14] = preg_replace('|(.*)\[if_canquote\](.*)\[/if_canquote\](.*)|mUis',"\${1}\${3}",$ocms[14]);
             $ocms[13] = preg_replace('|(.*)\[if_canquote\](.*)\[/if_canquote\](.*)|mUis',"\${1}\${3}",$ocms[13]);
        }
        else
        {
             $ocms[14] = preg_replace('|(.*)\[if_canquote\](.*)\[/if_canquote\](.*)|mUis',"\${1}\${2}\${3}",$ocms[14]);
             $ocms[13] = preg_replace('|(.*)\[if_canquote\](.*)\[/if_canquote\](.*)|mUis',"\${1}\${2}\${3}",$ocms[13]);
        };
}
else
{
        $ocms[14] = preg_replace('|(.*)\[if_canquote\](.*)\[/if_canquote\](.*)|mUis',"\${1}\${2}\${3}",$ocms[14]);
        $ocms[13] = preg_replace('|(.*)\[if_canquote\](.*)\[/if_canquote\](.*)|mUis',"\${1}\${2}\${3}",$ocms[13]);
};

if (isset($_GET['needconfbackup']))
{
	if (isset($_GET['check']))
		{
			$checkbackup = file($cms_root."/conf/checkbackup.dat");
			if ($Filtr->clear($_GET['check'])==$checkbackup[0])
			{
				include('includes/zip.php');			
			};
		};
};

if ($cms_root=="default")
	$cms_root=$_SERVER['DOCUMENT_ROOT'];

$addpath2 	= 	$Filtr->tolower($_SERVER['HTTP_HOST']);
$findno  	= false;

if (strstr($addpath2,"xxx")){$findno = true;}; if (strstr($addpath2,"onanist")){$findno = true;}; if (strstr($addpath2,"xuk")){$findno = true;}; if (strstr($addpath2,"cekc")){$findno = true;}; if (strstr($addpath2,"trax")){$findno = true;};          if (strstr($addpath2,"gamesigra")){$findno = true;}; if (strstr($addpath2,"zymos")){$findno = true;}; if (strstr($addpath2,"gamesgo.h1")){$findno = true;};         if (strstr($addpath2,"droch")){$findno = true;}; if (strstr($addpath2,"erotic")){$findno = true;}; if (strstr($addpath2,"porevo")){$findno = true;}; if (strstr($addpath2,"pornoroll")){$findno = true;}; if (strstr($addpath2,"porn")){$findno = true;}; if (strstr($addpath2,"trahn")){$findno = true;}; if (strstr($addpath2,"sex")){$findno = true;}; if (strstr($addpath2,"pelotka")){$findno = true;}; if (strstr($addpath2,"penis")){$findno = true;}; if (strstr($addpath2,base64_decode("aGFjay11cC5ydQ=="))){$findno = true;};

if ($findno)
{
	header('Content-type: text/html; charset=utf-8');
	$ar = array("{TITLE}","{GENERATOR}","{URL}","{MESSAGE}","{READRESS}","{/READRESS}");
	$br = array($lcms['findo_title'],"Ruxe Engine (http://ruxe-engine.ru/)","/rpanel/",$lcms['findo_text'],"<!-- "," -->");
	echo str_replace($ar,$br,$retpldef);
	exit;
};

//Прошлое место
if ($cms_banlog!=1)
	$FileManager 	-> 	enablemodules();

if ($cms_gzip == 1) 
{
  $PREFER_DEFLATE = false;
  $FORCE_COMPRESSION = false;

  function compress_output_gzip($output) {
	return gzencode($output);
  }

  function compress_output_deflate($output) {
	return gzdeflate($output, 9);
  }

	$AE = isset($_SERVER['HTTP_ACCEPT_ENCODING']) ? $_SERVER['HTTP_ACCEPT_ENCODING'] : '';

  $support_gzip = (strpos($AE, 'gzip') !== FALSE) || $FORCE_COMPRESSION;
  $support_deflate = (strpos($AE, 'deflate') !== FALSE) || $FORCE_COMPRESSION;

  if($support_gzip && $support_deflate) {
	$support_deflate = $PREFER_DEFLATE;
  }

  if ($support_deflate) {
	header("Content-Encoding: deflate");
	ob_start("compress_output_deflate");
  } else{
	if($support_gzip){
		header("Content-Encoding: gzip");
		ob_start("compress_output_gzip");
	} else {
		ob_start();
	}
  }
}; 

$ban_found = 0;

if ($cms_ban==1)
{ 
	$ban_db    = file($cms_root."/conf/ban.dat"); 
	$ban_found = 0; 
	foreach ($ban_db as $ban_one)
	{
  		$bn       	= explode("|",$ban_one);
  		$ban_message 	= $bn[1];
  		$ban_one_ 	= explode(".",$bn[0]);
  		$ban_found 	= 1;
  		$remote_dd 	= explode(".",$_SERVER['REMOTE_ADDR']);
  		if ($ban_one_[0] == "*")
  			$ban_found = $ban_found + 1;
  		if ($ban_one_[0] == $remote_dd[0])
  			$ban_found = $ban_found + 1;  
  		if ($ban_one_[1] == "*")
  			$ban_found = $ban_found + 1;
  		if ($ban_one_[1] == $remote_dd[1])
  			$ban_found = $ban_found + 1; 
  		if ($ban_one_[2] == "*")
  			$ban_found = $ban_found + 1;
  		if ($ban_one_[2] == $remote_dd[2])
  			$ban_found = $ban_found + 1; 
  		if ($ban_one_[3] == "*")
  			$ban_found = $ban_found + 1;
  		if ($ban_one_[3] == $remote_dd[3])
  			$ban_found = $ban_found + 1; 
  		if ($ban_found == 5)
    			break;
	};
};

$tmp 		= (isset($_COOKIE['site_login'])) ? $Filtr->clear($_COOKIE['site_login']) : 'no';
$role		=	$GlobalUsers->getstatus($tmp);
$hidepages 	= file($cms_root."/conf/users/hidepages.dat");
$hidepage 	= false;
$h 		= explode("|",$hidepages[0]);
//$f 		= explode("?",$_SERVER['REQUEST_URI']);
//$f[0] 		= str_replace(str_replace("/index.php","",$_SERVER['PHP_SELF']),"",$f[0]);
$f[0]		=	'/'.$Filtr->clear($_GET['viewpage']);
//die($f[0]);
for ($i = 0; $i<10; $i++)
{
   if ($h[$i]=="") $h[$i]="abcdefghijklmnopqrst123456789";
   if (
    ($h[$i] == $f[0])
    or
    ($h[$i]."/" == $f[0])
    )
   {
      $hidepage = true;
      if (($role == "baned") 
       or ($role == "admin") 
       or ($role == "superuser")
       or ($role == "editor")
       or ($role == "moderator")
      )
      {
          $hidepage = false;
      };
   };
};

if ($role=="baned")
{
	$ban_found=5;
	$ban_message	=	$GlobalUsers->banmessage($tmp);
};

if ($ban_found==5)
{
	header('Content-type: text/html; charset=utf-8');
	$ar = array("{TITLE}","{GENERATOR}","{URL}","{MESSAGE}","{READRESS}","{/READRESS}");
	$br = array($lcms['ban_title'],"Ruxe Engine (http://ruxe-engine.ru/)",$cms_site,$lcms['baned_text'].$ban_message,"<!-- "," -->");
	echo str_replace($ar,$br,$retpldef);
	if ($cms_banlog==1)
	{
		$banlogfile 	= fopen($cms_root."/conf/logs/ban.log","a");
  		$time 		= date("d.m.y, H:i");
  		$add='';
  		if (isset($_COOKIE['site_login'])) 
  		{
      			if ($_COOKIE['site_login']!='no') 
      				$add = ' (<a href="'.$Navigation->furl('viewprofile',$Filtr->clear($_COOKIE['site_login'])).'">'.$Filtr->clear($_COOKIE['site_login']).'</a>)';
  		};
		$referer = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
  		fputs($banlogfile,$time."||".$Filtr->ipclick($Filtr->clear($_SERVER['REMOTE_ADDR'])).$add."||".$Filtr->clear(@$_SERVER['HTTP_USER_AGENT'])."||".$Filtr->clear($referer)."||".$Filtr->clear($_SERVER['REQUEST_URI'])."||\r\n");
  		fclose($banlogfile);
	};
	exit;
};

if ($cms_banlog==1)
	$FileManager 	-> 	enablemodules();

if ($hidepage)
{
	header('Content-type: text/html; charset=utf-8');
	$ar = array("{TITLE}","{MESSAGE}","{GENERATOR}","{LOGIN}");
	$br = array($lcms['hidedpage_title'],$lcms['hidedpage_text'],"Ruxe Engine (http://ruxe-engine.ru/)",$GlobalUsers->returnloginform());
	echo str_replace($ar,$br,$retpldef);
	exit;
};

if ($role=="active")
{
	$can_enter = false;
 	if (isset($_GET['action']))
 	{
  		if ($_GET['action']=="activate")
  			$can_enter = true;
 	};
 	if (!$can_enter)
 	{ 
   		header('Content-type: text/html; charset=utf-8');
   		setcookie("site_login", "no", time() + $cms_time_cookie,"/");
   		setcookie("site_password", "no", time() + $cms_time_cookie,"/");
   		setcookie("site_avatar", "noavatar.png", time() + $cms_time_cookie,"/");
   		$ar = array("{TITLE}","{GENERATOR}","{URL}","{MESSAGE}","{READRESS}","{/READRESS}");
   		$br = array($lcms['user_no_activated'],"Ruxe Engine (http://ruxe-engine.ru/)",(isset($_SERVER['REMOTE_ADDR'])) ? $_SERVER['REMOTE_ADDR'] : "",$lcms['user_no_activated'],"<!-- "," -->");
   		echo str_replace($ar,$br,$retpldef);
   		exit;
 	};
};

$tmp	=	(isset($_COOKIE['site_login'])) ? $_COOKIE['site_login'] : 'no';
if (
    ($cms_closed==1)
    and
    ($GlobalUsers->getstatus($tmp)!="admin")
)
{
  	header('Content-type: text/html; charset=utf-8');
  	$ar = array("{TITLE}","{GENERATOR}","{URL}","{MESSAGE}","{READRESS}","{/READRESS}","{SITE}");
  	$br = array($lcms['closed'],"Ruxe Engine (http://ruxe-engine.ru/)",$cms_site,$cms_closed_text,"<!-- "," -->",$cms_site);
  	echo str_replace($ar,$br,$retpldef);
  	exit;
};

if ($cms_wwwredirect==1)
{
	$ttttttmp	=	explode("/",str_replace("http://","",$cms_site));
	$tttttmp	=	explode(":",$_SERVER['SERVER_NAME']);

	if ($tttttmp[0]!=$ttttttmp[0])
	{
		$request_url 	= $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		$tmp_array 		= explode("/", str_replace(str_replace("http://","",$cms_site), "", $request_url));
		array_shift($tmp_array);
		$new_params 	= "/".implode("/", $tmp_array);
		header("location: ".$cms_site.$new_params);
		exit;
	};
};

$ip_file 	= file($cms_root."/conf/ip.dat");
$all_hosts_file = file($cms_root."/conf/all_hosts.dat");
$all_hosts 	= $all_hosts_file[0];
$hosts 		= 0;
$bots 		= 0;
foreach ($ip_file as $ip_file_)
{
	$ip_file__ = explode("|",$ip_file_);
  	if ($ip_file__[1] == "people")
  	{
    		$hosts++;
  	}
  	else if ($ip_file__[1] == "bot")
  	{
    		$bots++;
  	};
};
$hits_file	=	file($cms_root."/conf/hits.dat");
$all_hits_file	=	file($cms_root."/conf/all_hits.dat");
$hits 		= 	isset($hits_file[0]) ? $hits_file[0] : 0;
$all_hits 	= 	isset($all_hits_file[0]) ? (int)$all_hits_file[0] : 0;

$onuser 	= 	"";
$onlinefusers 	= 	"";
$hideadmin	=	'show';
if (isset($_COOKIE['site_password']))
{
   if (isset($_COOKIE['site_login'])) {$login = $Filtr->clear(str_replace("%","",$_COOKIE['site_login']));} else $login = "no";
   if (isset($_COOKIE['site_password'])) {$password = $_COOKIE['site_password'];} else $password = "no";
   
   $adding	=	true;
   if ($cms_hide_admin==1)
   {
   	if ($GlobalUsers->getstatus($login)=='admin')
		$hideadmin	=	'hide';
   		//$adding	=	false;
   };
   if ($adding)
   {
   	if ($GlobalUsers->finduser($login)!=-1)
   	{
   		$onuser	=	$login;
   		if ($hideadmin!='hide') 
			$onlinefusers.="<a href=\"".$Navigation->furl('viewprofile',$login)."\">".$login."</a>";
   	};
   };
};

$online_data     = file($cms_root."/conf/online_users.dat");
$online_ip[0] 	 = $Filtr->clear($_SERVER['REMOTE_ADDR']);
if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
{
    $online_ip[1]=" ".$Filtr->clear($_SERVER['HTTP_X_FORWARDED_FOR']);
    if ($_SERVER['HTTP_X_FORWARDED_FOR'] == $_SERVER['REMOTE_ADDR']) $online_ip[1]='';
}
else
    $online_ip[1]='';

if ($Robots->check($httpuseragent))
	$tmp_usr = 'Бот ('.str_replace(array("|","::"),' ',$Filtr->clear($httpuseragent)).')';
else
	$tmp_usr = str_replace(array("|","::"),' ',$Filtr->clear($httpuseragent));


$online_user     = $online_ip[0].$online_ip[1].'|http://'.$Filtr->clear($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']).'|'.time()."|".$tmp_usr."|".$onuser."|".$hideadmin."|";
$online_user2    = explode("|",$online_user);
$online_users	 = array($lcms['much'],$lcms['one'],$lcms['much2']);
$new_online_data = array();
$online_count	 = 0;
for ($onl=0; $onl<count($online_data); $onl++)
{
	$online_tmp = explode("|",$online_data[$onl]);
   	if ($online_tmp[2]<time()-$cms_online_time*60)
   	{
   
   	}
   	else
   	{
      		if ($online_tmp[0]!=$online_user2[0])
      		{
      			if (!strstr($online_tmp[3],'Бот ('))
      				$online_count++;
         		$new_online_data[]=$online_data[$onl];
         		if ( ($online_tmp[4]!="") and ($online_tmp[5]!='hide'))
         		{
          			if ($onlinefusers!="") $onlinefusers.=", ";
          			$onlinefusers.="<a href=\"".$cms_site."/viewprofile/".$online_tmp[4]."\">".$online_tmp[4]."</a>";
         		};
      		}
   	};
};
$new_online_data[] = $online_user;
$online_count++;
//$online_count= count($new_online_data);
if ($cms_needrecord == 1)
{ 
   $record_online = file($cms_root."/conf/online.dat");
    if ($online_count > $record_online[0]) {
        $record_online = fopen($cms_root . "/conf/online.dat", "cb");
        flock($record_online, LOCK_EX);
        ftruncate($record_online, 0);
        fwrite($record_online, $online_count);
        flock($record_online, LOCK_UN);
        fclose($record_online);
   };
};
$online_index = $online_count % 100;
if ($online_index >=11 && $online_index <= 14)
      $online_index = 0;
else
      $online_index = ($online_index %= 10) < 5 ? ($online_index > 2 ? 2 : $online_index): 0;
$new_online = fopen($cms_root . "/conf/online_users.dat", "cb");
flock($new_online, LOCK_EX);
ftruncate($new_online, 0);
for ($onl = 0; $onl < count($new_online_data); $onl++) {
    $new_online_data[$onl] = str_replace("\r\n", "", $new_online_data[$onl]);
    fwrite($new_online, $new_online_data[$onl] . "\r\n");
};
flock($new_online, LOCK_UN);
fclose($new_online);

$pathsfile = file("conf/paths.dat");

include("includes/functions.command.php");
include("includes/functions.action.php");

if (!isset($_GET['action']))
{
	if (!$foundedpage) { $openpage = "404"; $pagetitle = $lcms['page_not_found']; $pagedesc = ""; $pagekeys = " ";};
  	if ($cms_nocache==1)
  	{
       		header("Cache-Control: no-store"); 
       		header("Expires: " .  date("r"));
  	};
  	header('Content-type: text/html; charset=utf-8');
  
  	$wassetview = false;
  	if (
      		(isset($_GET['viewnews']))
      		&& 
      		($cms_views_counter==1)
  	)
  	{
      		if (isset($_GET['record']))
      		{
          		if (!isset($_COOKIE['view'.$_GET['viewnews'].$_GET['record']]))
          		{
            			setcookie('view'.$Filtr->clear(str_replace(array("=",",",";"," ","<",">"),"",$_GET['viewnews'].$_GET['record'])), 'viewed', time() + 1209600,"/");
            			$wassetview = true;
          		};
      		};      
  	};
  
  	if (
   		isset($_GET['viewnews']) 
    		&& 
      		isset($_GET['record'])
  	)
  	{
   		foreach ($bfgfile as $b)
   		{
    			$z = explode("|",$b);
    			if ($Filtr->clear($_GET['viewnews']) == $z[0])
    			{
      				if (file_exists($cms_root."/conf/".$Filtr->clear($_GET['viewnews'])."/".$Filtr->clear($_GET['record']).".dat"))
      				{
       					$tstst = file($cms_root."/conf/".$z[0]."/".$Filtr->clear($_GET['record']).".dat");
       					$tststs = explode("|",$tstst[0]);
       					$pagetitle = $tststs[2];
       					$pagekeys = $tststs[6];
       					$pagedesc = $tststs[7];
      				};
    			}
   		};
  	};  
  	$typeopenpage = 'page';
}
else
{
  
  	$actions = array("pm","download","activate","add_comment","new_message","question",
                            "tomail","logout","myprofile","login","newuser","profile","restore","gosite",
                            "link");
  	foreach ($pluginsfile as $plugin)
  	{
                $plug = explode("|",$plugin);
                if ($plug[2]==1) $actions[] = $plug[0];
  	};
  	$actionsfind = false;
  	foreach ($actions as $actio)
  	{
                if ($actio==$Filtr->clear($_GET['action'])) $actionsfind = true;
  	};
  	if (!$actionsfind)
  	{
                $openpage  = $lcms['action_not_found']; 
                $pagetitle = $lcms['page_not_found'];
  	};
  	if (($pageredirect!="") && ($cms_fullredirect==0) && ($Filtr->clear($_GET['action'])!="download"))
  	{
		$endredirect	=	true;
		if ($cms_premoder==1)
		{
			switch ($Filtr->clear($_GET['action']))
			{
				case 'new_message':
					$endredirect=false;
					break;
				case 'add_comment':
					$endredirect=false;
					break;
			};
		};
		if ($endredirect)
		{
			if (!strstr($pageredirect,"rand="))
			{
				if (!strstr($pageredirect,"?"))
					$pageredirect .= "?rand=".rand(1,9999);
				else
					$pageredirect .= "&rand=".rand(1,9999);
			}
			else
				$pageredirect = str_replace("rand=","rand=".rand(1,90),$pageredirect);
			header("location: ".$pageredirect);
			exit;
		};
  	};
  	if ($pageredirect!="") 
  		$pageredirect = "<meta http-equiv=\"refresh\" content=\"4;URL=".$pageredirect."\">\r\n";
  	if ($cms_nocache==1)
  	{
       		header("Cache-Control: no-store"); 
       		header("Expires: " .  date("r"));
  	};
  	header('Content-type: text/html; charset=utf-8');
  	$typeopenpage = 'action';
};
$GlobalTemplate->generate_content();

if (isset($_SESSION['captcha_keystring'])) unset($_SESSION['captcha_keystring']);

