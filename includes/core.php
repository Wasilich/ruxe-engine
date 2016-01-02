<?php

/*
 * Ruxe Engine - CMS на файлах
 * http://ruxe-engine.ru
 *
 * Лицензия:
 * Это произведение доступно по Open Source лицензии
 * Creative Commons «Attribution-ShareAlike» («Атрибуция — На тех же
 * условиях») 4.0 Всемирная (CC BY-SA 4.0).
 *
 * Разработчики:
 * Ахрамеев Денис Викторович (http://den.bz) Автор, программирование
 * Игорь Dr1D - Дизайн
 * Олег Прохоров (http://ruxe-engine.ru/viewprofile/Tanatos) - Контроль качества, документация
 *
 */

$this_version = '1.8.6';

class Filtr
{
	function randwords($size)
	{
		//return substr(md5(rand(1,55000).rand(1,55000).rand(1,55000)),0,$size);
		$words	=	array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','r','s','t','u','v','x','y','z',
					'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','R','S','T','U','V','X','Y','Z',
                 			'1','2','3','4','5','6','7','8','9','0','.',',','(',')','[',']','!','?','/','%');
                $result	=	'';
                for ($i=1;$i<=$size;$i++)
                	$result.=$words[rand(0,count($words)-1)];
                return $result; 
	}
	function showmess($text) {
		echo '<div class="error-message">
			<center><b>Ошибка</b></center>
			<p>'.$text.'</p>
	        </div>';
	}
	function showarray($array)
	{
		echo '<div class="error-message"><pre>';
		print_r($array);
		echo '</pre></div>';
	}
	
	function delendslash($text)
	{
		return (substr($text,strlen($text)-1,1)=='/') ? substr($text,0,strlen($text)-1) : $text;
	}
	
	function clear($stroka,$dividing=false) {
		if ($dividing)
			$r	=	"[dividinglinere]";
		else
			$r	=	" ";
 		return htmlspecialchars(str_replace("|",$r,$stroka));
	}
	
	function progress($param,$from = 'no')
  	{
  		$res = '';
  		switch ($from)
  		{
  			case 'lastposts':
  				$cou = array(1,2,3,4,5,6,7,8,9,10,11,12);
  				break;
  			case 'fontsize':
  				$cou = array(6,7,8,9,10,11,12,14,16,18,20);
  				break;
			case 'pm':
  				$cou = array(5,10,25,50,75,100,125,150,175,200);
  				break;
  			case 'newpm':
  				$cou = array(125,300,500,700,1000,1500,2000,5000);
  				break;
  			default:
  				$cou = array(3,4,5,10,15,20,25,30,35,40,45,50);
  		};
  		foreach ($cou as $co)
  			$res.= ($param==$co) ? '<option value="'.$co.'" selected>'.$co : '<option value="'.$co.'">'.$co;
  		return $res;
  	}
	
	function tolat($text)
	{
		global $cms_title_length;
    		$a1    = array("а","б","в","г","д","е","ё","ж","з","и","й","к","л","м","н","о","р","п","с","т","у","ф","х","ц","ч","ш","щ","ъ","ь","ы","э","ю","я");
    		$a2    = array("А","Б","В","Г","Д","Е","Ё","Ж","З","И","Й","К","Л","М","Н","О","Р","П","С","Т","У","Ф","Х","Ц","Ч","Ш","Щ","Ъ","Ь","Ы","Э","Ю","Я");
    		$a3    = array("<",">","!","@","~","#","$","%","^","&","*","(",")","+","?","/","\\",",",".","\"","'","№",";",":");
    		$b     = array("a","b","v","g","d","e","e","j","z","i","y","k","l","m","n","o","r","p","s","t","u","f","h","c","ch","sh","shch","","","y","e","yu","ya");
    		for ($i=0; $i<count($a1); $i++)
    		{
       			$text = preg_replace("/".$a2[$i]."/iu",$b[$i],$text);
       			$text = preg_replace("/".$a1[$i]."/iu",$b[$i],$text);
    		};
    		$text = str_replace($a3,"",$text);
    		$text = str_replace(" ","-",$text);
    		$text = strtolower($text);
    		preg_match_all('/([a-z0-9\-]+)/',$text,$out);
    		$text = "";
    		for ($i=0; $i<count($out[1]); $i++)
        		$text .= $out[1][$i];
    		if ($text == "") 
    			$text = rand(1,9999);
    		return substr($text,0,$cms_title_length);
	}
	
	function tolower($content) 
	{ 
		if (function_exists('mb_strtolower'))
  		{
        		mb_internal_encoding("UTF-8");
			$content	=	mb_strtolower($content,'UTF-8');
  		}
		else
			$content = str_replace(array("А","Б","В","Г","Д","Е","Ё","Ж","З","И","Й","К","Л","М","Н","О","Р","П","С","Т","У","Ф","Х","Ц","Ч","Ш","Щ","Ъ","Ь","Ы","Э","Ю","Я","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","А","Б","В","Г","Ґ","Д","Е","Є","Ж","З","И","І","Ї","Й","К","Л","М","Н","О","П","Р","С","Т","У","Ф","Х","Ц","Ч","Ш","Щ","Ь","Ю","Я"), 
						array("а","б","в","г","д","е","ё","ж","з","и","й","к","л","м","н","о","р","п","с","т","у","ф","х","ц","ч","ш","щ","ъ","ь","ы","э","ю","я","a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","а","б","в","г","ґ","д","е","є","ж","з","и","і","ї","й","к","л","м","н","о","п","р","с","т","у","ф","х","ц","ч","ш","щ","ь","ю","я"),
					$content);
      		return $content;
	}
	
	function utf8_casesort($tagsarray) {
		if (function_exists("iconv")) {
			$tmparra=	array();
			for ($n=0; $n<count($tagsarray); $n++)
				$tmparra[$n] =	@iconv('utf-8', 'windows-1251', $tagsarray[$n]);
			natcasesort($tmparra);
			for ($n=0; $n<count($tagsarray); $n++)
				$tmparra[$n] =	@iconv('windows-1251', 'utf-8', $tmparra[$n]);
			$tagsarray=	$tmparra;
		} else
			natcasesort($tagsarray);
		return $tagsarray;
	}
	
	function utf8_substr($str,$from,$len)
	{
  		global $lcms;
  		if (function_exists('mb_substr'))
  		{
        		mb_internal_encoding("UTF-8");
        		$tmp = mb_substr($str,$from,$len,'UTF-8');

  		}
  		else
  		{
        		if (function_exists("iconv"))
        		{
            			$a   = @iconv('utf-8', 'windows-1251', $str);
            			$tmp = substr($a,$from,$len);
            			$b   = @iconv('windows-1251','utf-8',$tmp);
            			$tmp = $b;
        		}
        		else
            			$tmp = "";
  		};
  		if ($tmp == "")
       			$tmp = $lcms['notshowmessage']; 
  		return $tmp;
	}
	
	function textmax($text,$col,$add='') 
	{ 
		if (function_exists('mb_strlen'))
  		{
        		mb_internal_encoding("UTF-8");
        		if (mb_strlen($text,'UTF-8') > $col)
				$text	=	$this->utf8_substr($text,0,$col).$add;
			
  		}
		else
		{
			if (strlen($text) > $col) 
				$text = $this->utf8_substr($text,0,$col).$add;
		};
		return ($text); 
	}
	
	function truecount($value, $one, $much, $much2)
	{
		$cc  = $value % 100;
		if (($cc >= 11) && ($cc <= 14))
			$cc = 0;
		else
			$cc = (($cc %= 10) < 5) ? ($cc > 2 ? 2 : $cc) : 0;
		switch ($cc)
		{
			case 0: 
				return $value.' '.$much;
				break;
			case 1:
				return $value.' '.$one;
				break;
			case 2:
				return $value.' '.$much2;
				break;
		}; 
	}
	
	function ipclick($ip)
	{
		global $cms_whois;
		if (preg_match('/^[0-9\.]+$/u', $ip))
			return '<a href="'.$cms_whois.$ip.'" target="_blank" rel="nofollow">'.$ip.'</a>';
		else
			return $this->clear(
						str_replace(
							array('<','>','%','?','!','#'),
							'',
							$ip)
					);
	}
	
	function fulldate($date,$seconds='00',$zz = true)
	{
   		global $lcms;

   		//25.03.11, 16:15
   		$a      = explode(",",$date);
   		$b      = explode(".",$a[0]);
   		$c      = explode(":",$a[1]);
   		$date   = $this->gettimezonedate("d.m.y, H:i",$b[0],$b[1],"20".$b[2],$c[0],$c[1],$seconds);
   		$a      = explode(",",$date);
   		$b      = explode(".",$a[0]);
   		$c      = explode(":",$a[1]);
   		if (substr($b[0],0,1)=="0") $b[0] = substr($b[0],1,1);
		
		//Нынешняя дата с учётом часового пояса
		$nowdate   = $this->gettimezonedate("d.m.y, H:i",date('d'),date('m'),date('Y'),date('H'),date('i'),date('s'));
   		$nowa      = explode(",",$nowdate);
   		$nowb      = explode(".",$nowa[0]);
   		if (substr($b[0],0,1)=="0") $b[0] = substr($b[0],1,1);
		//
   		   				
   		$now    = mktime("00","00","00",$nowb[1],$nowb[0],$nowb[2]);
		//$now    = mktime("00","00","00",date("m"),date("d"),date("Y"));
  		$last   = mktime("00","00","00",$b[1],$b[0],$b[2]);
		if ($zz) {
			switch (floor(($now-$last)/86400))
			{
				case 1:
					$ret	=	$lcms['yesterday'].', '.$a[1];
					break;
				case -1:
					$ret	=	$lcms['tomorrow'].', '.$a[1];
					break;
				case 0:
					$ret	=	$lcms['today'].', '.$a[1];
					break;
				default:
					$ret	=	$b[0]." ".$lcms['months'][$b[1]]." 20".$b[2].", ".$a[1];
			};
		} else
			$ret = $b[0].'>'.$lcms['months'][$b[1]].'>20'.$b[2].'>'.$a[1];
   		return ($seconds=='00') ? $ret : $ret.':'.$seconds;
	}
	
	function getuseragent()
	{
		global $_SERVER;
		$res	=	'-';
		if (isset($_SERVER['HTTP_USER_AGENT']))
		{
			if ($_SERVER['HTTP_USER_AGENT']!='')
			{
				$res	=	$this->clear($_SERVER['HTTP_USER_AGENT']);
				$res	=	str_replace(array('|',"\r","\n",'>','<','%'),'',$res);
			};
		};
		return $res;
	}
	
	function gettimezonedate(
                    $format = 'd.m.y H:i:s',
                    $day = '',
                    $month = '',
                    $year = '',
                    $hours = '',
                    $minutes = '',
                    $seconds = ''
        )
	{
   		global $cms_timezone;
   		if ($day     == '') $day = date("d");
   		if ($month   == '') $month = date("m");
   		if ($year    == '') $year = date("Y");
   		if ($hours   == '') $hours = date("H");
   		if ($minutes == '') $minutes = date("i");
   		if ($seconds == '') $seconds = date("s");
   		$where        = substr($cms_timezone,0,1);
   		$h            = substr($cms_timezone,1,strlen($cms_timezone)-1);
   		switch ($where)
   		{
          		case "-":
               			$result          = mktime($hours-$h,$minutes,$seconds,$month,$day,$year);    
               			break;
          		default:
               			$result          = mktime($hours+$h,$minutes,$seconds,$month,$day,$year);    
   		};
   		return date($format,$result);
	}
};

$Filtr	=	new Filtr;

$foundedpage = false;
$pages       = file(__DIR__."/../conf/pages/config");
(isset($_GET['viewpage'])) ? $viewpage = $Filtr->clear($_GET['viewpage']) : $viewpage = "index";
foreach ($pages as $onepage)
{
	$opa    = explode("|",$onepage);
	if ($viewpage == $opa[0])
	{
		$pagetitle   = $opa[1];
		$pagedesc    = $opa[3];
		$pagekeys    = $opa[2];
		$foundedpage = true;
		$openpage    = $opa[4];
		$cms_theme   = is_dir(__DIR__.'/../themes/'.$opa[5].'/')?$opa[5]:$cms_theme;
		break;
	};
};

//if (!defined("ADMINCENTER")) {
	$toinclude	=	array('other.php','users.php');
	for ($i = 0; $i<count($toinclude); $i++) {
		if (file_exists('themes/'.$cms_theme.'/'.$toinclude[$i]))
			include("themes/".$cms_theme."/".$toinclude[$i]);
		else {
			if (file_exists($cms_root.'/themes/'.$cms_theme.'/'.$toinclude[$i]))
				include($cms_root."/themes/".$cms_theme."/".$toinclude[$i]);
			else {
				$Filtr->showmess('Шаблон '.$toinclude[$i].' в теме оформления '.$cms_theme.' недоступен');
				die();
				exit();
			}	
		}
	}
//}

if (file_exists('conf/smiles.dat'))
	$smilesdb = file("conf/smiles.dat");
else
	$smilesdb = file($cms_root."/conf/smiles.dat");
	
$usersfruits = array("ReStandartConst0","ReStandartConst1","ReStandartConst2","ReStandartConst3","ReStandartConst4","ReStandartConst5",
             "ReStandartConst6","ReStandartConst7","ReStandartConst8","ReStandartConst9","ReStandartConst10","ReStandartConst11",
             "ReStandartConst12","ReStandartConst13","ReStandartConst14","ReStandartConst15","ReStandartConst16","ReStandartConst17",
             "ReStandartConst18","ReStandartConst19","ReStandartConst20","ReStandartConst21","ReStandartConst22","ReStandartConst23");

function errorstofile($errno,$errmsg,$file,$line)
{
		global $cms_root,$Filtr;
		$time = date("d.m.y, H:i");
		if (
 			(!strstr($errmsg,"date() [<a href='function.date'>function.date</a>]: It is not safe to rely on the system's timezone settings. Please use the date.timezone setting, the TZ environment variable or the date_default_timezone_set() function."))
 			&&
 			(!strstr($errmsg,"It is not safe to rely on the system's timezone settings. Please use the date.timezone setting, the TZ environment variable or the date_default_timezone_set() function. In case you used any"))
		)
		{
			$error_log = fopen($cms_root."/conf/logs/errors.log","a");
			fputs($error_log,$time."||".$errno."||".$errmsg."||".$file."||".$line."||".$Filtr->clear($_SERVER['REMOTE_ADDR'])."||\r\n");
			fclose($error_log);
		};
}
	
function errorstonothing($errno,$errmsg,$file,$line)
{
	//nothing	
}

function errortoshow($errno,$errmsg,$file,$line)
{
	if (
 			(!strstr($errmsg,"date() [<a href='function.date'>function.date</a>]: It is not safe to rely on the system's timezone settings. Please use the date.timezone setting, the TZ environment variable or the date_default_timezone_set() function."))
 			&&
 			(!strstr($errmsg,"It is not safe to rely on the system's timezone settings. Please use the date.timezone setting, the TZ environment variable or the date_default_timezone_set() function. In case you used any"))
	)
	{
	        echo '<div class="error-message">
	        <center><b>Ошибка</b></center>
	        <p>'.$errmsg.' в файле '.$file.' на строке '.$line.'</p>
	        <p>Пожалуйста, обратитесь по <a href="http://ruxe-engine.ru/news/problemy-i-oshibki.html" target="_blank">http://ruxe-engine.ru/news/problemy-i-oshibki.html</a> если вы уверены, что ошибка не по вашей вине</p>
	        </div>';
	}
}

function etswwr($errno,$errmsg,$file,$line)
{
	global $cms_root, $Filtr;
	if (
 			(!strstr($errmsg,"date() [<a href='function.date'>function.date</a>]: It is not safe to rely on the system's timezone settings. Please use the date.timezone setting, the TZ environment variable or the date_default_timezone_set() function."))
 			&&
 			(!strstr($errmsg,"It is not safe to rely on the system's timezone settings. Please use the date.timezone setting, the TZ environment variable or the date_default_timezone_set() function. In case you used any"))
	)
	{
	        echo '<div class="error-message">
	        <center><b>Ошибка</b></center>
	        <p>'.$errmsg.' в файле '.$file.' на строке '.$line.'</p>

	        <p>Пожалуйста, обратитесь по <a href="http://ruxe-engine.ru/news/problemy-i-oshibki.html" target="_blank">http://ruxe-engine.ru/news/problemy-i-oshibki.html</a> если вы уверены, что ошибка не по вашей вине</p>
	        </div>';
	        $error_log = fopen($cms_root."/conf/logs/errors.log","a");
		fputs($error_log,date("d.m.y, H:i")."||".$errno."||".$errmsg."||".$file."||".$line."||".$Filtr->clear($_SERVER['REMOTE_ADDR'])."||\r\n");
		fclose($error_log);
	}
}

switch ($cms_noshowerr)
{
	case 1:
		ini_set('display_errors',0);
		set_error_handler('errorstofile');
		break;
	case 5:
		ini_set('display_errors',0);
		set_error_handler('errorstonothing');
		break;
	case 25:
		error_reporting(E_ALL); 
 		ini_set("display_errors", 'on');
		set_error_handler('etswwr');
		break;
	default:
		error_reporting(E_ALL); 
 		ini_set("display_errors", 'on');
		set_error_handler('errortoshow');
};

$httpuseragent	=	(isset($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '-';

function here_pagecontent()
{
	global $openpage, $typeopenpage, $cms_root;
	switch ($typeopenpage)
	{
		case 'page':
		include($cms_root."/conf/pages/".$openpage.".txt");
		break;
	case 'action':
		echo $openpage;
		break;
	}; 
};

function array_stripslashes($array) {
   //thanks for http://habrahabr.ru/blogs/personal/21971/
   return is_array($array) ? array_map("array_stripslashes", $array) : stripslashes($array);
};

function magic_quotes_gpc_off() {
  global $_GET,$_POST,$_COOKIE;
  //thanks for http://habrahabr.ru/blogs/personal/21971/
  if (get_magic_quotes_gpc()) 
  {
     $_GET = array_stripslashes($_GET);
     $_POST = array_stripslashes($_POST);
     $_COOKIE = array_stripslashes($_COOKIE);
  };
};

magic_quotes_gpc_off();

$bfgfile	=	(file_exists('conf/bfg.dat')) ? file('conf/bfg.dat') : file($cms_root.'/conf/bfg.dat');
$fileusers	=	(file_exists('conf/users/users.dat')) ? file('conf/users/users.dat') : file($cms_root.'/conf/users/users.dat');
//Все поля активного юзера
$rtuc		=	array();
//Список существующих юзеров
$rtuclistfull	=	array();
$rtuclist	=	'';
//позиция этого юзера
$rtuci		=	-1;
foreach ($fileusers as $users)
{
	$tmp	=	explode('|',$users);
	$rtuclist	.=	$tmp[18].'|';
	$rtuclistfull[]	=	$tmp[18];
}

class UpdateCache
{
	function cats($type)
	{
		global $cms_root, $Filtr;
		
		$list		=	file($cms_root.'/conf/'.$type.'/list.dat');
		
		$newlist	=	array();
		for ($i = 0; $i < count($list); $i++)
		{
			$pieces	=	explode('|',$list[$i]);
			$newcat	=	$Filtr->tolower($pieces[7]);
			$founded=	false;
			for ($a = 0; $a < count($newlist); $a++)
			{
				if ($newcat == $Filtr->tolower($newlist[$a]))
				{
					$founded = true;
					break;
				};
			};



			if (!$founded) {
				if ($pieces[9]=='Да') 
					$newlist[]	=	$pieces[7];
			}
		};
		
		$wantchmod	= 	(!file_exists($cms_root."/conf/cache/cats_".$type)) ? true : false;
                   
                $cache 		= 	fopen($cms_root."/conf/cache/cats_".$type,"w");
                fwrite($cache,serialize($newlist));
                fclose($cache);
                   
                if ($wantchmod) chmod($cms_root."/conf/cache/cats_".$type,0777);
	}
	
	function tags($type)
	{
		global $cms_root, $Filtr;
		$list    = file($cms_root."/conf/".$type."/list.dat");
		$tags    = array();
		$counter = array();
		foreach ($list as $l)
		{
			$i     = explode("|",$l);
			$s     = explode(",",$i[4]);
			foreach ($s as $t)
			{
				if (count($tags) > 0)
				{
					$pos       = 0;
					$founded   = false;
					foreach ($tags as $a)
					{
						if ( ($Filtr->tolower($a)==$Filtr->tolower($t)) && ($t!=""))
						{
							$founded = true;
							$counter[$pos]++;
							break;
						};
						$pos++;
					};
					if ((!$founded) && ($t!=""))
					{
						if ($i[9]=='Да')
						{
							//$tags[]    = $Filtr->tolower($t);
							$tags[]	=	$t;
							$counter[] = 1;
						};
					};
                                          
				}
				else
				{
                                   	if ($t!='')
                                   	{
						if ($i[9]=='Да')
						{
							//$tags[]    = $Filtr->tolower($t);
							$tags[]	=	$t;
							$counter[] = 1;
						};
                                        };
				};
			};
		};
		$res  = array();
		$tmp1 = array();
                   
		$wantchmod = (!file_exists($cms_root."/conf/cache/tags_".$type)) ? true : false;
                   
		$cache = fopen($cms_root."/conf/cache/tags_".$type,"w");
		fwrite($cache,serialize($tags)."[<|>]".serialize($counter)."[<|>]");
		fclose($cache);
                   
		if ($wantchmod) chmod($cms_root."/conf/cache/tags_".$type,0777);
	}
};

$GlobalCache = new UpdateCache();

class GlobalUsers
{
	function checkthisuser()
	{
		global $_COOKIE, $Filtr, $cms_time_cookie, $cms_site, $fileusers;
		//Проверка на пару логин-пароль пользователя
		if (isset($_COOKIE['site_login']))
		{
			$login		=	$Filtr->clear($_COOKIE['site_login']);
			$password	=	(isset($_COOKIE['site_password'])) ? $Filtr->clear($_COOKIE['site_password']) : 'no';
			$pos		=	$this->finduser($login,true,$password);
			if (
			($pos==-1)
			and
			($login!='no')
			)
			{
				//Юзер неверен
				setcookie("site_login",'no', time() + $cms_time_cookie,"/");
				setcookie("site_password",'no', time() + $cms_time_cookie,"/");
				header('location: '.$cms_site.'?rand='.rand(1,9999));
				exit;
			};
			if ($pos!=-1)
			{
				//Нужно проверить - не надо ли ему сменить пароль...
				if ($this->getpole($login,23)!='yes')
				{
					setcookie("site_login",'no', time() + $cms_time_cookie,"/");
					setcookie("site_password",'no', time() + $cms_time_cookie,"/");
					header('location: '.$cms_site.'?rand='.rand(1,9999));
					exit;
				};
			};
		};
	}
	
	function access($mod	=	1,$type='')
	{
		global $_COOKIE, $Filtr, $cms_root;
		$login	=	$Filtr->clear($_COOKIE['site_login']);
		switch ($mod)
		{
			case 1:
				if ($this->getstatus($login)!='admin')
				{
        				die('В данный раздел имеют доступ только администраторы');
        				exit;
				};
				break;
			case 2:
				if ($this->getstatus($login)!='admin')
					return false;
				else
					return true;
				break;
			case 3:
				if ($this->getstatus($login)=='admin')
				{
					return true;
				}
				else
				{
					$rules		=	$this->getrules($login);
					$bfg_types	=	explode(',',$rules['bfg_types']);
					$bfg		=	file($cms_root.'/conf/bfg.dat');
					$res		=	false;
					foreach ($bfg as $bf)
					{
						$b	=	explode('|',$bf);
						if ($b[0]==$type)
						{
							foreach ($bfg_types as $z)
							{
								if ($b[0]==$z)
								{
									$res	=	true;
									break;
								};
							};
						};
					};
					return $res;
				};
				break;
			case 4:
				if ($this->access(3,$type)==false)
				{
        				die('В данный раздел имеют доступ только администраторы');
        				exit;
				};
				break;
		};
	}
	
	function getrules($name)
	{
		global $fileusers, $GlobalCache, $Filtr;
		$bfg_types	=	'';
		$bfg_public	=	false;
		$bfg_delete	=	false;
		$comments_edit	=	false;
		$plugins_use	=	false;
		$banip		=	false;
		$u		=	$this->getpole($name,4);
		$rules		=	explode(':',$this->getpole($name,21));
		if (count($rules)>1)
		{
			$bfg_types	=	$rules[0];
			$bfg_public	=	($rules[1]=='yes') ? true : false;
			$bfg_delete	=	($rules[2]=='yes') ? true : false;
			if ($u == 'moderator')
			{
						$comments_edit	=	($rules[3]=='yes') ? true : false;
						$plugins_use	=	($rules[4]=='yes') ? true : false;
						$banip		=	($rules[5]=='yes') ? true : false;
			};
		};
		if ($u=='admin')
		{
			$bfg_public	=	true;
			$bfg_delete	=	true;
			$comments_edit	=	true;
			$plugins_use	=	true;
			$banip		=	true;
		};
				
		return	  array(
     				'bfg_types'=>$bfg_types,
     				'bfg_public'=>$bfg_public,
     				'bfg_delete'=>$bfg_delete,
     				'comments_edit'=>$comments_edit,
     				'plugins_use'=>$plugins_use,
     				'banip'=>$banip);
	}
	
	function fullname($name)
	{
		global $fileusers;
		$pos	=	$this->finduser($name,false,'',true);
		if ($pos!=-1)
		{
			$tmp	=	explode('|',$fileusers[$pos]);
			$res	=	$tmp[18];
		};
		return ($pos!=-1) ? $res : 'no';
	}
	
	function checkthisadmin()
	{
		global $cms_root, $_COOKIE, $Filtr, $GlobalTemplate, $cms_save_admin_ip, $cms_site, $cms_time_cookie;
		$login		=	(isset($_COOKIE['site_login'])) ? $Filtr->clear($_COOKIE['site_login']) : 'no';
		$password	=	(isset($_COOKIE['site_password'])) ? $Filtr->clear($_COOKIE['site_password']) : 'no';
		$pos		=	$this->finduser($login,true,$password);
		if ($pos!=-1)
		{
			if ($this->getpole($login,23)!='yes')
			{
				setcookie("site_login",'no', time() + $cms_time_cookie,"/");
				setcookie("site_password",'no', time() + $cms_time_cookie,"/");
				header('location: '.$cms_site.'/rpanel/?rand='.rand(1,9999));
				exit;
			};
			$status	=	$this->getstatus($login);
			if (
				($status=='admin')
				or
				($status=='editor')
				or
				($status=='moderator')
			)
			{
				if ($cms_save_admin_ip==1)
				{
					$file		=	file($cms_root.'/conf/admin_ip.dat');
					$founded	=	false;
					foreach ($file as $f)
					{
						$z	=	explode('|',$f);
						if (
							($Filtr->tolower($login)==$Filtr->tolower($z[0]))
							and
							($Filtr->clear($_SERVER['REMOTE_ADDR'])==$z[1])
						)
						{
							$founded	=	true;
							break;
						};
					};
				}
				else
					$founded	=	true;
				return $founded;
			}
			else
				return false;
		}
		else
		{
			return false;
		};
	}
	
	function checklogin($login,$mess = false)
	{ 
		global $lcms;
     			$errortext = '';
     			if (!preg_match('/^[ёЁa-zA-Zа-яА-Я0-9\-\!\@\*]+$/u', $login))
     				$errortext = $lcms['user_invalid'];
     			if (strlen($login)>20)
     				$errortext = $lcms['user_strln'];
     			if (strlen($login)<4)
     				$errortext = $lcms['user_strln'];
     			if ($login == "no")
     				$errortext = $lcms['user_cannot_no'];
     			if (!$mess)
     			{
     				if ($errortext!='') 
     					$errortext = false;
     				else
     					$errortext = true;
     			};
     			return $errortext; 
	}
	
	function checkpassword($password, $spassword,$mess = false)
	{
		global $lcms;
     		$errortext = "";
     		if ($password != $spassword)
     			$errortext = $lcms['user_passs'];
     		if (!preg_match('/^[a-zA-Z0-9\-\!\@\*]+$/u', $password))
     			$errortext = $lcms['user_invalid'];
     		if (strlen($password)>20)
     			$errortext = $lcms['user_strln'];
     		if (strlen($password)<4)
     			$errortext = $lcms['user_strln'];
     		if (!$mess)
     		{

     			if ($errortext!='')
     				$errortext = false;
     			else
     				$errortext = true;
     		};
 		return $errortext;
	}
	
	function checkcaptcha($code)
	{
		global $_POST, $_SESSION;
		if(count($_POST)>0)
		{
			if(isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] == $code)
				return TRUE;
			else
				return FALSE;
		}
		unset($_SESSION['captcha_keystring']); 
	}
	
	function returnloginform()
	{
		global $cms_site, $cms_root,$cms_theme,$Filtr,$_COOKIE,$_SERVER,$_POST,$GlobalTemplate, 
			$cms_gravatars, $cms_upload_width,$cms_gravatars_im, $GlobalImaging, $Navigation;
  		if (isset($_COOKIE['site_login']) && isset($_COOKIE['site_password']))
  		{
   			$chus = $this->getstatus($Filtr->clear($_COOKIE['site_login']));
   			if ($chus!="no")
   			{
    				$ar = array("{LOGIN}","{SITE}","{AVATAR}","{THEMEPATH}","{PM}","{PMLINK}","{PROFILELINK}");
   			 	if (!isset($_COOKIE['site_avatar'])) 
   			 		$avatar = "noavatar.png";
   			 	else 
   			 		$avatar = $Filtr->clear($_COOKIE['site_avatar']);
    				$avatar = str_replace(array("%","#","..","\\","/","!","@","$","^","&","_","(",")","*"),'',$avatar);
    				$pm = 0;
    				$t  = $this->pmpath($this->getid($_COOKIE['site_login']));
    				if (file_exists($t))
    				{
       					$pmfile = file($t);
       					foreach ($pmfile as $pmline)
       					{
           					$pml = explode("|",$pmline);
           					if (
              					($pml[0]=="inbox")
              					and
              					($pml[1]=="false")
              					)
           					$pm++;
       					};
    				};
    				if ($pm>0) 
    					$pm = "<b>".$pm."</b>";
				$retav	=	$cms_site."/avatars/".$avatar;
				if ($cms_gravatars==1)
				{
					if ($avatar=='noavatar.png')
						$retav	=	$GlobalImaging->get_gravatar($this->getpole($Filtr->clear($_COOKIE['site_login']),2),$cms_upload_width,$cms_gravatars_im,'g',false);
				};
    				$br = array($Filtr->clear($_COOKIE['site_login']),$cms_site,$retav,$cms_site."/themes/".$cms_theme,$pm,$Navigation->furl('pmlink'),$Navigation->furl('profilelink'));
    				switch ($chus)
    				{
           				case "admin":
                				return $GlobalTemplate->users($ar,$br,1);
                				break;
           				case "editor":
                				return $GlobalTemplate->users($ar,$br,14);
                				break;
           				case "moderator":
                				return $GlobalTemplate->users($ar,$br,15);
                				break;
           				default:
                				return $GlobalTemplate->users($ar,$br,2);  
    				};
   			}
   			else
    				return $GlobalTemplate->users(
							array(
								"{SITE}",
								"{THEMEPATH}",
								"{REGLINK}",
								"{RESTORELINK}"
							),
							array(
								$cms_site,
								$cms_site."/themes/".$cms_theme,
								$Navigation->furl('reglink'),
								$Navigation->furl('restorelink')
							),
						0);
  		}
  		else
  			return $GlobalTemplate->users(
							array(
								"{SITE}",
								"{THEMEPATH}",
								"{REGLINK}",
								"{RESTORELINK}"
							),
							array(
								$cms_site,
								$cms_site."/themes/".$cms_theme,
								$Navigation->furl('reglink'),
								$Navigation->furl('restorelink')
							),
						0);	
	}
	
	function DeletePMButNotRead($stroka,$deletefrom)
	{
    		global $_COOKIE, $Filtr;
         	$str = explode("|",$stroka);
         	if (file_exists($this->pmpath($this->getid($str[2]))))
         	{
               		$original = file($this->pmpath($this->getid($str[2])));
               		foreach ($original as $or)
               		{
                       		$o = explode("|",$or);
                       		if (
                              		($o[0]=="outbox")
                              		&&
                              		($Filtr->tolower($o[2])==$Filtr->tolower($deletefrom))
                              		&&
                              		($o[3]==$str[3])
                              		&&
                              		($o[4]==$str[4])
                              		&&
                              		($o[6]==$str[6])
                       		)
                       		{
                              		$new = fopen($this->pmpath($this->getid($str[2])),"w");
                              		foreach ($original as $or2)
                              		{
                                		$o2 = explode("|",$or2);
                                       		if (
                                          	($o2[0]=="outbox")
                                          	&&
                                          	($Filtr->tolower($o2[2])==$Filtr->tolower($deletefrom))
                                          	&&
                                          	($o2[3]==$str[3])
                                          	&&
                                          	($o2[4]==$str[4])
                                          	&&
                                          	($o2[6]==$str[6])
                                       		)
                                        		fwrite($new,$o[0]."|".$o[1]."|".$o[2]."|".$o[3]."|".$o[4]."|".$o[5]."|".$o[6]."|deleted|\r\n");
                                       		else
                                          		fwrite($new,$or2);
                              		};
                              		fclose($new);
                              		break;
				};
			};                              
		};
	}
	
	function ReadedPM($stroka,$whoread)
	{
    		global $_COOKIE, $Filtr;
         	$str = explode("|",$stroka);
         	if (file_exists($this->pmpath($this->getid($str[2]))))
         	{
               		$original = file($this->pmpath($this->getid($str[2])));
               		foreach ($original as $or)
               		{
                       		$o = explode("|",$or);
                       		if (
                              		($o[0]=="outbox")
                              		&&
                              		($Filtr->tolower($o[2])==$Filtr->tolower($whoread))
                              		&&
                              		($o[3]==$str[3])
                              		&&
                              		($o[4]==$str[4])
                              		&&
                              		($o[6]==$str[6])
                       		)
                       		{
                              		$new = fopen($this->pmpath($this->getid($str[2])),"w");
                              		foreach ($original as $or2)
                              		{
                                       		$o2 = explode("|",$or2);
                                       		if (
                                          		($o2[0]=="outbox")
                                          		&&
                                          		($Filtr->tolower($o2[2])==$Filtr->tolower($whoread))
                                          		&&
                                          		($o2[3]==$str[3])
                                          		&&
                                          		($o2[4]==$str[4])
                                          		&&
                                          		($o2[6]==$str[6])
                                       		)
                                       			fwrite($new,$o[0]."|".$o[1]."|".$o[2]."|".$o[3]."|".$o[4]."|".$o[5]."|".$o[6]."|readed|\r\n");
                                       		else
                                          		fwrite($new,$or2);
                              		};
                              		fclose($new);
                              		break;
                       		};
               		};                              
         	};
	}
	
	function checkfromcookie()
	{
		global $_COOKIE;
		if (isset($_COOKIE['site_login']))
   		{
        		return ($_COOKIE['site_login']!="no") ? true : false; 
   		}
   		else
   			return false;
	}
	
	function pmpath($id)
	{
   		global $cms_root;
   		return $cms_root."/conf/users/pm_".(int)$id.".dat";
	}
	
	function isuser($name)
	{
		return ($this->finduser($name,false,'',true)!=-1) ? true : false;
	}
	
	function thisisuser()
	{
		global $_COOKIE, $Filtr;
  		$founded__ = false;
  		if (isset($_COOKIE['site_login'])) {$site_login = $Filtr->clear($_COOKIE['site_login']);} else $site_login = "no";
  		if (isset($_COOKIE['site_password'])) {$site_password = $Filtr->clear($_COOKIE['site_password']);} else $site_password = "no";
  		if ($this->finduser($site_login,true,$site_password)!=-1)
  			$founded__	=	true;
  		return $founded__;
	}
	
	function finduser($name,$checkpassword=false,$password='',$registr=false)
	{
		global $rtuclist, $rtuc, $rtuclistfull, $Filtr, $fileusers, $rtuci;
		$founded	=	false;
		$name		=	$Filtr->clear($name);
		if ($name=='')
			$name	=	'a';
		
		if ($name!='no')
		{
			$canfind	=	true;
			if (isset($rtuc[18]))
			{
				if ($Filtr->tolower($rtuc[18])==$Filtr->tolower($name))
				{
					return $rtuci;
					$founded	=	true;
					$canfind	=	false;
				}
			};
			if ($canfind)
			{
				if (strstr($Filtr->tolower($rtuclist),$Filtr->tolower($name)))
				{
					for ($i=0; $i<count($rtuclistfull); $i++)
					{
						if ($checkpassword==true)
						{
							if ($registr==true)
							{
								if ($Filtr->tolower($rtuclistfull[$i])==$Filtr->tolower($name))
								{
									$tmp	=	explode('|',$fileusers[$i]);
									if ($tmp[1]==$password)
									{
										//$rtuci	=	$i;
										return $i;
										$founded	=	true;
									};
									break;
								};
							}
							else
							{
								if ($rtuclistfull[$i]==$name)
								{
									$tmp	=	explode('|',$fileusers[$i]);
									if ($tmp[1]==$password)
									{
										//$rtuci	=	$i;
										return $i;
										$founded	=	true;
									};
									break;
								};
							};
						}
						else
						{
							if ($registr==true)
							{
								if ($Filtr->tolower($rtuclistfull[$i])==$Filtr->tolower($name))
								{
									//$rtuci	=	$i;
									return $i;
									$founded	=	true;
									break;
								};
							}
							else
							{
								if ($rtuclistfull[$i]==$name)
								{
									//$rtuci	=	$i;
									return $i;
									$founded	=	true;
									break;
								};
							};
						};
					};
				};
			};
		};
		if (!$founded)
			return -1;
	}
	
	function getpole($name,$pole)
	{
		global $rtuc, $fileusers, $_COOKIE, $Filtr, $rtuci;
		//Если name равен кэшированному юзеру - то юзать его
		//Если не равен - сначала проверить существует ли он вообще и вернуть false либо результат
		$founded	=	false;
		$login		=	(isset($_COOKIE['site_login'])) ? $Filtr->clear($_COOKIE['site_login']) : 'no';
		
		if (count($rtuc)==0)
		{
			//Создать кэшированного юзера
			$password	=	(isset($_COOKIE['site_password'])) ? $Filtr->clear($_COOKIE['site_password']) : 'no';
			$pos		=	$this->finduser($login,true,$password);
			//$pos		=	$this->finduser($name);
			if ($pos!=-1)
			{
				$tmp2	=	explode('|',$fileusers[$pos]);
				$rtuc	=	$tmp2;
				$rtuci	=	$pos;
				$founded=	true;
			};
			if (!$founded)
				$rtuc[0]	=	'renouser';
		};
		
		if (
			($rtuc[0]=='renouser') or ($Filtr->tolower($name)!=$Filtr->tolower($login))
		)
		{
			if ($Filtr->tolower($name)!=$Filtr->tolower($login))
				$pos	=	$this->finduser($name);
			else
				$pos	=	$rtuci;
			if ($pos!=-1)
			{
				$tmp	=	explode('|',$fileusers[$pos]);
				return $tmp[$pole];
			}
			else
				return false;
		}
		else
			return $rtuc[$pole];
	}
	
	function banmessage($site_login)
	{
		$ban_message = '';
		
		$tmp	=	$this->getpole($site_login,19);
		if ($tmp!=false)
			$ban_message	=	$tmp;
  		return $ban_message;
	}
	
	function getstatus($login)
	{
		$tmp	=	$this->getpole($login,4);
		return ($tmp!=false) ? $tmp : 'no';
	}
	
	function getuser($id)
	{
		global $fileusers;
		$res	=	'no';
		foreach ($fileusers as $users)
		{
			$user = explode("|",$users);
			if ($user[0]==(int)$id)
			{
				$res = $user[18];
				break;
			};
		};
		return $res;
	}
	
	function getid($user)
	{
		$res		=	$this->getpole($user,0);		
		return ($res!=false) ? $res : 'no';
	}
	
	function lastid()
	{
		global $cms_root;
		include($cms_root.'/conf/users/config.dat');
		return $lastid;
	}
	
	function newid()
	{
		global $cms_root;
		include($cms_root.'/conf/users/config.dat');
		$n = fopen($cms_root.'/conf/users/config.dat','w');
		flock($n,LOCK_EX);
		fwrite($n,"<?php\r\n");
		for ($i=1; $i<=7; $i++)
		{
			fwrite($n,"\$polecaption[".$i."] = \"".$polecaption[$i]."\";\r\n");
			fwrite($n,"\$pole[".$i."] = \"".$pole[$i]."\";\r\n");
		};
		fwrite($n,"\$lastid = ".($lastid+1).";\r\n");
		flock($n,LOCK_UN);
		fclose($n);
		return $lastid+1;
	}
	
	function thisusertime()
	{
		global $_COOKIE, $Filtr;
  		$time_ 		= 	0;
  		$login 		= 	(isset($_COOKIE['site_login'])) ? $Filtr->clear($_COOKIE['site_login']) : "no";
  		$adminyou 	= 	false;
  		
  		$time_		=	$this->getpole($login,13);
  		
  		if ($this->getstatus($login)=='admin')
  			$time_	=	0;
  		return $time_;
  		
	}
	
	function editpoles($condition,$check,$method = "w")
	{
      			global $cms_root, $usersfruits, $Filtr;
      			$original   = file($cms_root."/conf/users/users.dat");

      			$new        = fopen($cms_root."/conf/users/users.dat",$method);
      			flock($new,LOCK_EX);
      			$pos        = 0;
      			$countpoles = 23;
      			if ($method == "w")
      			{
              			foreach ($original as $orig)
              			{
                         		$line       =  explode("|",$orig);
                         		$newpoles   = $usersfruits;
                         		for ($i=0; $i<=$countpoles; $i++)
                         		{
                                            if (strstr($usersfruits[$i],"ReStandartConst")) 
                                            	$newpoles[$i] = $line[$i];
                                        };
                         
                         		switch ($condition)
                         		{
                                            case "pos":
                                                       ($pos==$check) ? fwrite($new,implode("|",$newpoles)."|\r\n") : fwrite($new,$orig);  
                                                       break;
                                            case "mail":
                                                       ($Filtr->tolower($line[2])==$Filtr->tolower($check)) ? fwrite($new,implode("|",$newpoles)."|\r\n") : fwrite($new,$orig);
                                                       break;
                                            case "user":
                                                       ($Filtr->tolower($line[18])==$Filtr->tolower($Filtr->clear($check))) ? fwrite($new,implode("|",$newpoles)."|\r\n") : fwrite($new,$orig);
                                                       break;
                                            case 'id':
                                            	($line[0]==(int)$check) ? fwrite($new,implode('|',$newpoles)."|\r\n") : fwrite($new,$orig);
                                            	break; 
                         		};
                         		$pos++;     
              			};
      			}
      			else
      			{
              			for ($i=0; $i<=$countpoles; $i++)

              			{
                                            if (strstr($usersfruits[$i],"ReStandartConst")) 
                                            	$usersfruits[$i] = '';
                                };
              			fputs($new,implode("|",$usersfruits)."|\r\n");
      			};
      			flock($new,LOCK_UN);
      			fclose($new);
      			$usersfruits = array("ReStandartConst0","ReStandartConst1","ReStandartConst2","ReStandartConst3","ReStandartConst4","ReStandartConst5", "ReStandartConst6","ReStandartConst7","ReStandartConst8","ReStandartConst9","ReStandartConst10","ReStandartConst11",
             				"ReStandartConst12","ReStandartConst13","ReStandartConst14","ReStandartConst15","ReStandartConst16","ReStandartConst17","ReStandartConst18","ReStandartConst19","ReStandartConst20","ReStandartConst21","ReStandartConst22","ReStandartConst23");
	}
	
	function reg($from) {
		global $_GET, $cms_site, $usersfruits, $_POST, $Mailing, $cms_root, $Filtr, $lcms, $fileusers, $cms_oneipreg, $cms_active, $_SERVER, $cms_punycode;
		$login     = (isset($_POST['login'])) ? $Filtr->clear($_POST['login']) : "";
		$password  = (isset($_POST['password'])) ? $Filtr->clear($_POST['password']) : "";
		$spassword = (isset($_POST['spassword'])) ? $Filtr->clear($_POST['spassword']) : "";
		$mail      = (isset($_POST['mail'])) ? $Filtr->tolower($Filtr->clear($_POST['mail'])) : "";
		$smail     = (isset($_POST['smail'])) ? $Filtr->tolower($Filtr->clear($_POST['smail'])) : "";
		$security  = (isset($_POST['security'])) ? $Filtr->clear($_POST['security']) : "";
		$founderror= false;
		$errortext = "";
		if (!$this->checkpassword($password,$spassword,true) == "") {
			$founderror = true;
			$errortext =  $this->checkpassword($password,$spassword,true);
		}
		if (!$Mailing->checkmail($mail)) {
			$founderror = true;
			$errortext = $lcms['user_errormail'];
		}
		if ($mail != $smail) {
			$founderror = true;
			$errortext = $lcms['user_errormail'];
		}
		if ($from=='site') {
			if (!$this->checkcaptcha($security)) {
				$errortext = $lcms['user_errorsec'];
				$founderror = true;
			}
		}
		if (!$this->checklogin($login,true) == "") {
			$founderror = true;
			$errortext =  $this->checklogin($login,true);
		}
		if ($founderror == false) {
			foreach ($fileusers as $user)  { 
				$pieces = explode("|",$user); 
				if ($Filtr->tolower($login) == $Filtr->tolower($pieces[18])) {
					$founderror=true;
					$errortext=$lcms['user_login'];
				}
				if ($Filtr->tolower($mail) == $Filtr->tolower($pieces[2])) {
					$founderror=true;
					$errortext=$lcms['user_mailbusy'];
				}
				if (
					($Filtr->clear($_SERVER['REMOTE_ADDR'])==$pieces[12])
					and
					($cms_oneipreg==1)
				) {
					$founderror	=	true;
					$errortext	=	$lcms['user_ipbusy'];
				}
			}
		}
		if (!$founderror) {
			$ackey = rand(1,9999).rand(1,999);
			$usersfruits[0]  = $this->newid();
			//$usersfruits[1]  = md5($password);
			//создание пароля с солью
			$usersfruits[22] = $Filtr->randwords(12);
			$usersfruits[1]	 = md5(md5($password).$usersfruits[22]);
			$usersfruits[23] = 'yes';
			//	
			$usersfruits[2]  = $mail;
			$usersfruits[4]  = ($cms_active==1) ? 'active' : 'user';
			$usersfruits[12] = $Filtr->clear($_SERVER['REMOTE_ADDR']);
			$usersfruits[14] = 0;
			$usersfruits[15] = ($cms_active==1) ? $ackey : '';
			$usersfruits[16] = 'noavatar.png';
			$usersfruits[18] = $login;
			$usersfruits[19] = "Не указана";
			$usersfruits[20] = date("d.m.y, H:i");
			$usersfruits[21] = ':no:no:no:no:no';
			$this->editpoles("add","","a");
			if ($cms_active==1) {
				$cr = array("{LOGIN}","{PASSWORD}","{SITE}","{KEY}");
				if ($cms_punycode==1) {
					require_once($cms_root.'/includes/idna_convert.class.php');
					$IDN = new idna_convert();
					$tmp = $IDN->decode($cms_site);
					$cms_site = htmlentities($tmp, null, 'UTF-8');
				}
				$dr = array($login,$password,$cms_site,$ackey);
				$message = str_replace($cr,$dr,$lcms['active_post']);
				$Mailing->tousers(str_replace("{SITE}",$cms_site,$lcms['user_mail_subject']),$message,$mail);
			}
			return -1;
		} else
			return $errortext;
	}
}

$GlobalUsers = new GlobalUsers();

class RuxeTemplate
{
	function generate_content() 
	{
  		global $cms_root;
  		include($cms_root."/conf/cache/design");
	}
	
	function commentform($comment_action,$comment_id,$comment_plus,$comment_type)
	{
		global $cms_root, $cms_site, $lcms, $cms_smiles, $cms_mail_select, $cms_theme, $_GET, $_COOKIE, $_SERVER, $cms_max_message,
 		$cms_oncomments, $rtuclistfull, $cms_pm_showusers, $cms_guestnotwrite,
 		$GlobalUsers,$Filtr, $Navigation, $cms_furl;

		$canform = true;
        if ($cms_oncomments != 1) {
            switch ($comment_action) {
                case 'tomail':
                case 'question':
                case 'pmnew':
                case 'pm':
                    break;
                default:
                    return $lcms['comments_off'];
            }
        }

		if (
     			($cms_guestnotwrite==1)
     			&&
     			($comment_action!="tomail")
     			&&
     			($comment_action!="question")
		)
		{
  			if (isset($_COOKIE['site_login']))
  			{
      				if ($_COOKIE['site_login']=="no")
      				{
      					$canform = false;
           				return $lcms['guest_not_write'];
      				};
  			}
  			else
  			{
  				$canform = false;
       				return $lcms['guest_not_write'];	
  			};
		};
		
		//Проверка на закрытость раздела комментариев
		if ($comment_action=="new_message") {
			$valListmess = file($cms_root.'/conf/messages/listmess.dat');
			foreach ($valListmess as $valLine) {
				$valPiece = explode("|", $valLine);
				if ($valPiece[0]==$comment_id) {
					if ($valPiece[2]=="close") {
						$canform = false;
						return $lcms['comments_closed'];
					}
				}
			}
		}
		//

		if ($canform)
		{
 			$ar 	= array("{URL}","{HIDDENS}","{NAME_VALUE}","{MAIL_VALUE}", "{THEME}","{THEMES}","{/THEME}","{SECURITY}",
				"{MESSAGE_VALUE}","{SITE}","{FROM}","{SHOWSMILES}","{/SHOWSMILES}","{THEMEPATH}","{MAXMESSAGE}","{USERLINK}");
 			$me_url = $cms_site."/index.php?action=".$comment_action;
 			if ( ($comment_action=="pm") or ($comment_action=="pmnew") ) 
				$me_url = $Navigation->furl('pmsend').rand(0,9999);
 			$me_hiddens = '<input type="hidden" name="comment" value="'.$comment_id.'">';
 			switch ($comment_action)
 			{
 				case "add_comment":
 					$me_hiddens.="<input type=\"hidden\" name=\"title_news\" value=\"".str_replace('"','',$comment_plus)."\">\r\n<input type=\"hidden\" name=\"type\" value=\"".$comment_type."\">\r\n";
  					break;
  				case "new_message":
  					$me_hiddens.="<input type=\"hidden\" name=\"id\" value=\"".$comment_id."\"><input type=\"hidden\" name=\"sname\" value=\"".$comment_plus."\">";
  					break;
  				case "pm":
  					$me_hiddens.="<input type=\"hidden\" name=\"theme\" value=\"".$comment_id."\"><input type=\"hidden\" name=\"to\" value=\"".$comment_plus."\">";
  					break;	

 			};

 			
 			$me_name 	= "";
 			$me_mail 	= "";
 			$me_mess 	= "";
 			$me_themes 	= "";
 			$me_theme 	= "<!-- ";
 			$me_ctheme 	= " -->";
 			if (isset($_GET['name']))
         			$me_name = "value=\"".$Filtr->clear($_GET['name'])."\"";
 			if (isset($_GET['mail']))
         			$me_mail = "value=\"".$Filtr->clear($_GET['mail'])."\"";
 			if ($cms_smiles==1)
 			{
      				$showsmiles 	= "";
      				$showsmilesc 	= "";
 			}
 			else
 			{
     				$showsmiles 	= "<!-- ";
     				$showsmilesc 	= " -->";
 			};
 			$fromtomail = false;
 			if ($comment_action=="tomail") {
      				$me_theme 	= "";
      				$fromtomail 	= true;
      				$me_ctheme 	= "";
      				$showsmiles 	= "<!-- ";
      				$showsmilesc 	= " -->";
      				$mail_select	=	explode(",",$cms_mail_select);
      				//$me_themes 	= "<option value=\"".$mail_select[0]."\" selected>&gt;&gt; ".$lcms['mail_choose']." &lt;&lt;";
      				for ($q=0; $q<count($mail_select); $q++)
				{
					$sel	=	($q==0) ? ' selected' : '';
         				$me_themes.="<option value=\"".$mail_select[$q]."\"".$sel.">".$mail_select[$q];
				};
 			};
 			$me_security = $cms_site."/captcha/?".session_name()."=".session_id();
 			if (isset($_GET['message']))
     				$me_mess = $Filtr->clear($_GET['message']);
 			if (($comment_action=="pm") or ($comment_action=="pmnew"))
 			{
  				if (!$GlobalUsers->thisisuser())
    					$br = array($me_url,$me_hiddens,$me_name,$me_mail,$me_theme,$me_themes,$me_ctheme,$me_security, $me_mess,$cms_site,"",$showsmiles,$showsmilesc,$cms_site."/themes/".$cms_theme,$cms_max_message,'');
  				else
    					$br = array($me_url,$me_hiddens,$Filtr->clear($_COOKIE['site_login']),"",$me_theme,$me_themes,$me_ctheme,"",$me_mess,$cms_site,"",$showsmiles,$showsmilesc,$cms_site."/themes/".$cms_theme,$cms_max_message,$Navigation->furl('viewprofile',$Filtr->clear($_COOKIE['site_login'])));
  				$ar[] = "{PM_TO}";
  				$pm_to = "";
  				$tmp = (isset($_COOKIE['site_login'])) ? $Filtr->clear($_COOKIE['site_login']) : 'no';
  				if (($cms_pm_showusers==1)or($GlobalUsers->getstatus($tmp)=="admin"))
  				{
  					$login	=	$Filtr->clear($_COOKIE['site_login']);
      					foreach ($rtuclistfull as $user)
      					{
      						if ($user!=$login)
      						{
      							if (isset($_GET['name']))
      							{
      								if ($user==$Filtr->clear($_GET['name']))
      									$pm_to .= "<option value=\"".$user."\" selected>".$user;
                  						else
                    							$pm_to .= "<option value=\"".$user."\">".$user;
      							}
      							else
      								$pm_to .= "<option value=\"".$user."\">".$user;
      						};
      					};
  				}
  				else
  				{
      					if (isset($_GET['name'])) $pm_to = $Filtr->clear($_GET['name']);
  				};
  				$br[] = $pm_to;
  				return $this->template($ar,$br,$cms_root."/themes/".$cms_theme."/commentform.html",'','',$fromtomail);

 			}
 			else
 			{
				$from 	=	($cms_furl==1) ? $Filtr->clear($_GET['viewpage']) : '?viewpage='.$Filtr->clear($_GET['viewpage']);
				//$from = $Filtr->clear($_GET['viewpage']);
  				if (!$GlobalUsers->thisisuser()){
    					$br = array($me_url,$me_hiddens,$me_name,$me_mail,$me_theme,$me_themes,$me_ctheme,$me_security,
    					$me_mess,$cms_site,$from,$showsmiles,$showsmilesc,$cms_site."/themes/".$cms_theme,$cms_max_message,'');
    					return $this->template($ar,$br,$cms_root."/themes/".$cms_theme."/commentform.html",'','',$fromtomail);
  				}
 				else
  				{
    					$br = array($me_url,$me_hiddens,$Filtr->clear($_COOKIE['site_login']),"",$me_theme,$me_themes,$me_ctheme,"",
    					$me_mess,$cms_site,$from,$showsmiles,$showsmilesc,$cms_site."/themes/".$cms_theme,$cms_max_message,$Navigation->furl('viewprofile',$Filtr->clear($_COOKIE['site_login'])));
    					return $this->template($ar,$br,$cms_root."/themes/".$cms_theme."/commentform.html",'','',$fromtomail);
  				};
 			};
		}; 
	}
	
	function getonlywords($tag)
	{
   		$tag   	= str_replace(" ","_",$tag);
		$tag	= str_replace("+","p",$tag);
		$tag	= str_replace("#","Sharp",$tag);
   		//ывывыв !@#$%^&*()_=+-\][.></"';
   		$tag   = str_replace(array("%","$","^","&","*",">","<","\"","'","|","/",";",".","\\","?","!","@"),"",$tag);
   		return $tag;
	}
	
	function template($fu_a,$fu_b,$fu_file,$itags = "",$type = "",$fromtomail=false,$usecodesuser=true,$category=array(),$needfull=true)
	{
	
		global $cms_root, $cms_site, $Filtr, $Navigation, $cms_smiles, $cms_simcount;
		$i	=	0;
		$res	=	'';
		$file	=	file($fu_file);
		$nfile	=	array();
		foreach ($file as $fil)	$res .= $fil;
		$res	=	str_replace($fu_a,$fu_b,$res);
		if ($usecodesuser)
		{
			$res 	= 	$this -> checkteg($res,'[if_user_entered]','[/if_user_entered]','user');
         		$res 	= 	$this -> checkteg($res,'[if_user_not_entered]','[/if_user_not_entered]','guest');
         	};
         	
         	if (strstr($fu_file,"record.html"))
         	{
			$res    		=	$this -> checkteg($res,'[code]','[/code]','html');
			//Похожие записи (0.9.9)
			//print_r($category);
			$wtmp			=	array();
			preg_match('|\[SIMILAR\=\{(.*)\}\/SIMILAR\]|mUis',$res,$wtmp);
			if (isset($wtmp[1]))
			{
				if (count($category)>0)
				{
					$templatesimilar	=	$wtmp[1];
					$linewithsimlinks	=	'';
					$counter		=	0;
					foreach ($category as $cat)
					{
						$c			=	explode('|',$cat);
						if ($counter<$cms_simcount)
							$linewithsimlinks	.=	str_replace(
											array('[SIMLINK]','[SIMCAPTION]'),
											array($c[0],$c[1]),
											$templatesimilar);
						$counter++;
					};
					$res	=	str_replace(array('[if_similar]','[/if_similar]'),'',$res);
					$res	= 	$this->checkteg($res,'[SIMILAR={','}/SIMILAR]','replace',array(),$linewithsimlinks);
				}
				else
					$res	=	$this->checkteg($res,'[if_similar]','[/if_similar]','replace',array(),'');
				
			};
			
			//Теги (метки)
         		
         		$tmp	=	array();
         		preg_match('|\[TAGS\=\{(.*)\}\/TAGS\]|mUis',$res,$tmp);
			if (isset($tmp[1])) {
				$templatelinktegs = $tmp[1];
				$tegs_            = explode(",",$itags);
				$tegs             = array();
				$linewithtegs     = "";
				foreach ($tegs_ as $teg)
				{
					$founded = false;
					if (count($tegs)>0)
					{
						foreach ($tegs as $teg2)
						{
							if ($Filtr->tolower($teg)==$Filtr->tolower($teg2))
							{
								$founded = true;
								break;
							};
						};
					};
					if (!$founded) 
					{    
						if (count($tegs)<1)
							$linewithtegs.=str_replace(array("[TAGLINK]","[TAGCAPTION]"),array($Navigation->furl('tags',$type,$this->getonlywords($teg)),$Filtr->clear($teg)),$templatelinktegs);
						else	
							$linewithtegs.=", ".str_replace(array("[TAGLINK]","[TAGCAPTION]"),array($Navigation->furl('tags',$type,$this->getonlywords($teg)),$Filtr->clear($teg)),$templatelinktegs);
						if ($teg!="") $tegs[] = $this->getonlywords($teg);
					}; 
				};
				if (count($tegs)>0)
				{
					$res	  = 	str_replace(array('[if_tags]','[/if_tags]'),'',$res);
					$res	  = 	$this->checkteg($res,'[TAGS={','}/TAGS]','replace',array(),$linewithtegs);           			
				}
				else
					$res	=	$this->checkteg($res,'[if_tags]','[/if_tags]','replace',array(),'');
			}
           		if (strstr($fu_file,'newsrecord.html'))
           		{
				$res 	= 	$this->checkteg($res,'[if_oncomments]','[/if_oncomments]','default',$fu_b,13);
				if ($needfull)
					$res	=	str_replace(array('[if_needfull]','[/if_needfull]'),'',$res);
				else
					$res 	= 	$this->checkteg($res,'[if_needfull]','[/if_needfull]','replace',array(),'');
                        };
         	};
         	
         	if (strstr($fu_file,'commentform.html'))
         	{
         		$res 	=	$this->checkteg($res,'[if_here_mail]','[/if_here_mail]','default',$fu_b,4);
         		$res 	=	$this->checkteg($res,'[if_can_smiles]','[/if_can_smiles]','default',$fu_b,11);
         		$res    =	$this->checkteg($res,'[if_pm_list]','[/if_pm_list]','pm_list');
         		$res	=	$this->checkteg($res,'[if_pm_input]','[/if_pm_input]','pm_input');
         		$res	=	$this->checkteg($res,'[if_pm]','[/if_pm]','pm');
         		$res	=	$this->checkteg($res,'[if_pmurl]','[/if_pmurl]','pmurl');
         		if (!$fromtomail)
         		{
         			if ($cms_smiles==1)
         			{
         				$tmp    = 	array();
         				if (preg_match('|\[SMILES\=\{(.*)\}\/SMILES\]|mUis',$res,$tmp)) {
                            $template   = $tmp[1];
                            $smilesbase = file($cms_root."/conf/smiles.dat");
                            $smiles    = '';
                            foreach ($smilesbase as $smile)
                            {
                                $smile = str_replace("\r\n","",$smile);
                                if ($smile!="")
                                    $smiles.=str_replace(array("{SITE}","{SMILE}"),array($cms_site,$smile),$template);
                            };
                            $res  = 	$this->checkteg($res,'[SMILES={','}/SMILES]','replace',array(),$smiles);
                        };
                    };
                }
         	};
         	
		return $res;
	}
	
	function checkteg($text,$start,$end,$command,$add1=array(),$add2='0')
	{
		global $GlobalUsers, $_GET, $cms_createlinks, $cms_pm_showusers, $Filtr;
		if (
			(strstr($text,$start))
			and
			(strstr($text,$end))
		)
		{
			$codes	=	explode($start,$text);
			$i	=	0;
			foreach ($codes as $code)
			{
				if ($i>0)
				{
					$cod = explode($end,$code);
					switch ($command)
					{
						case 'user':
							if ($GlobalUsers->checkfromcookie() != true)
								$text = str_replace($cod[0],'',$text);
							break;
						case 'guest':
							if ($GlobalUsers->checkfromcookie() == true)
								$text = str_replace($cod[0],'',$text);
							break;
						case 'html':
							$text = str_replace($cod[0],htmlspecialchars($cod[0]),$text);
							break;
						case 'replace':
							$text = str_replace($cod[0],$add2,$text);
							break;
						case 'pm':
							$act = (isset($_GET['action'])) ? $_GET['action'] : "";
      							$do  = (isset($_GET['do'])) ? $_GET['do'] : "";
      							if (($act=="pm") && ($do=="new"))
      							{
                                 				if ($Filtr->clear($_GET['action'])!="pm")
                                                                  $text = str_replace($cod[0],'',$text);
                                                        }
      							else
                                 				$text = str_replace($cod[0],'',$text);
							break;
						case 'pmurl':
      							if ($cms_createlinks!=1)
                                                                  $text = str_replace($cod[0],'',$text);
							break;
						case 'pm_list':
							$act 	= (isset($_GET['action'])) ? $Filtr->clear($_GET['action']) : "";
     							$do  	= (isset($_GET['do'])) ? $Filtr->clear($_GET['do']) : "";
     							if (($act=="pm") && ($do=="new"))
     							{
     								if (($cms_pm_showusers==1) or ($GlobalUsers->getstatus($Filtr->clear($_COOKIE['site_login']))=="admin"))
     								{
     								
     								}
     								else
     									$text = str_replace($cod[0],'',$text);	
     							}
     							else
     								$text = str_replace($cod[0],'',$text);   
							break;
						case 'pm_input':
							$act 	= (isset($_GET['action'])) ? $Filtr->clear($_GET['action']) : "";
     							$do  	= (isset($_GET['do'])) ? $Filtr->clear($_GET['do']) : "";
     							if (($act=="pm") && ($do=="new"))
     							{

     								if (($cms_pm_showusers==1) or ($GlobalUsers->getstatus($Filtr->clear($_COOKIE['site_login']))=="admin"))
     									$text = str_replace($cod[0],'',$text);	
     							}
     							else
     								$text = str_replace($cod[0],'',$text);   
							break;
						case 'default':
							if (strstr($add1[$add2],'<!--'))
								$text = str_replace($cod[0],'',$text);
							break;
					};
				};
				$i++;
			};
			$text = str_replace(array($start,$end),"",$text);
		};
		return $text;
	}
	
	function other($fu_a,$fu_b,$whatline)
	{
		global $ocms;
		return str_replace($fu_a,$fu_b,$ocms[$whatline]);
	}
	
	function users($fu_a,$fu_b,$whatline)
	{
		global $logincms;
		$res = '';
		$j   = 0;
		switch($whatline)
                {
                         case 6:
                                $one = array(2,6,10,14,18,22,26,39,41);
                                $two = array("if_can_pole1","if_can_pole2","if_can_pole3","if_can_pole4","if_can_pole5","if_can_pole6","if_can_pole7","if_can_avatars","if_can_ps");
                                $res = $logincms[$whatline];
                                //die();
                                //print_r($fu_b);
                                foreach ($one as $o)
                                {
                                	//$res = (strstr($fu_b[$o],'<!--')) ? $this->checkteg($res,
                                	$res = $this -> checkteg($res,'['.$two[$j].']','[/'.$two[$j].']','default',$fu_b,$o);
                                	$j++;
                                }
                                //$fufile[4] = CmsTemplateIf($one,$two,$fufile[4],$fu_b);
                                $res = str_replace($fu_a,$fu_b,$res);
                                //$res = $this -> checkteg($res,'[if_user_entered]','[/if_user_entered]','user');
                                //$fufile[$whatline] = CmsTemplateIf($one,$two,$fufile[$whatline],$fu_b);
                                break;
                         case 4:
                                $one = array(2,6,10,14,18,22,26,36);
                                $two = array("if_used_pole1","if_used_pole2","if_used_pole3","if_used_pole4","if_used_pole5","if_used_pole6","if_used_pole7","if_used_about");
                                $res = $logincms[$whatline];
                                //print_r($fu_b);
                                foreach ($one as $o)
                                {
                                	//$res = (strstr($fu_b[$o],'<!--')) ? $this->checkteg($res,
                                	$res = $this -> checkteg($res,'['.$two[$j].']','[/'.$two[$j].']','default',$fu_b,$o);
                                	$j++;
                                }
                                //$fufile[4] = CmsTemplateIf($one,$two,$fufile[4],$fu_b);
                                $res = str_replace($fu_a,$fu_b,$res);
                                $res = $this -> checkteg($res,'[if_user_entered]','[/if_user_entered]','user');
                                break;
                         default:
                         	$res = str_replace($fu_a,$fu_b,$logincms[$whatline]);
                };
                return $res;
	}
	
	function getsmiles()
	{
		global $cms_root,$smilesdb;
		
		$smiles   = array();
		foreach ($smilesdb as $smile)
		{
			$smile = str_replace(array("\r","\n"),'',$smile);
			if ($smile!='') $smiles[] = $smile;
		};
		return $smiles;
	}
	
	function findcode($start,$end,$text,$code)
	{
		global $Filtr;
		$start	=	$Filtr->tolower($start);
		$end	=	$Filtr->tolower($end);
		$text	=	$Filtr->tolower($text);
		$code	=	$Filtr->tolower($code);
		$result	=	'ok';
		$ar1	=	explode($start,$text);
		if (count($ar1)>1)
		{
			for ($i=1; $i<count($ar1); $i++)
			{
				if (strstr($ar1[$i],$end))
				{
					$ar2	=	explode($end,$ar1[$i]);
					for ($z	= 0; $z<count($ar2)-1; $z++)
					{
						if (strstr($ar2[$z],$code))
							$result	=	'fail';
					};
				}
				else
				{
					if (strstr($ar1[$i],$code))
						$result	=	'fail';
				}
			};
		};
		return $result;
	}
	
	function usebbcodes($text,$do,$imgteg=false,$needcenz=true)
	{
		global $cms_smiles, $GlobalUsers, $lcms, $cms_createlinks, $cms_img_comment, $cms_site, $cms_cenzura, $cms_cenzura_words, $cms_theme, $cms_root, $cms_furl;
		$text	=	str_replace('[dividinglinere]','|',$text);
		switch ($do)
		{
			case 'lastposts':
				$text = preg_replace('|\[spoiler=(.*)](.*)\[\/spoiler]|Uis',$lcms['hlp_spoiler'], $text);
				$text = preg_replace('|\[url=(.*)](.*)\[\/url]|Uis',"\${1} - \${2}", $text);
				$text = preg_replace('|\[hide](.*)\[\/hide]|Uis',$lcms['hlp_hide'], $text);
				$text = preg_replace('|\[quote](.*)\[\/quote]|Uis',$lcms['hlp_quote'], $text);
				$text = preg_replace('|\[quote=(.*)](.*)\[\/quote]|Uis',str_replace("{NAME}","\${1}",$lcms['hlp_quote_name']), $text);
				$text = preg_replace('|\[b](.*)\[\/b]|Uis',"\${1}", $text);
				$text = preg_replace('|\[i](.*)\[\/i]|Uis',"\${1}", $text);
				$text = preg_replace('|\[u](.*)\[\/u]|Uis',"\${1}", $text);
				$text = preg_replace('|\[s](.*)\[\/s]|Uis',"\${1}", $text);
				$text = preg_replace('|\[url](.*)\[\/url]|Uis',"\${1}", $text);
				$text = preg_replace('|\[left](.*)\[\/left]|Uis',"<br>\${1}", $text);
				$text = preg_replace('|\[center](.*)\[\/center]|Uis',"<br>\${1}", $text);
				$text = preg_replace('|\[right](.*)\[\/right]|Uis',"<br>\${1}", $text);
				break;
			case 'clear':
				$a = array('[b]','[/b]',
					   '[i]','[/i]',
					   '[u]','[/u]',
					   '[s]','[/s]',
					   '[left]','[/left]',
					   '[center]','[/center]',
					   '[/right]','[/right]',
					   '[quote]','[/quote]',
					   '[hide]','[/hide]');
				if ($cms_createlinks==1)
				{
					$a[] = '[url]';
					$a[] = '[/url]';
					$a[] = '[url=';
				};
				if ($cms_smiles==1)
				{
					foreach ($this->getsmiles() as $smile)
						$a[] = '['.$smile.']';
				};
				$text = str_replace($a,'',$text);
				break;
			case 'html':
				if ($cms_smiles==1)
				{
					//hide
					if ($GlobalUsers->thisisuser())
						$text = preg_replace('|\[hide](.*)\[\/hide]|Uis', $this->other("{HIDE_MESSAGE}","\${1}",17), $text);
					else
						$text = preg_replace('|\[hide](.*)\[\/hide]|Uis', $this->other("{HIDE_MESSAGE}",$lcms['hide_message'],17), $text);
					//spoiler
					$text = preg_replace('|\[spoiler=(.*)](.*)\[\/spoiler]|Uis', $this->other(array("{TITLE}","{TEXT}"),array("\${1}","\${2}"),15), $text);
					//quote
					$text = preg_replace('|\[quote=(.*)](.*)\[\/quote]|Uis', $this->other(array("{TITLE}","{TEXT}"),array("\${1}","\${2}"),16), $text);
					$text = preg_replace('|\[quote](.*)\[\/quote]|Uis', $this->other("{TEXT}","\${1}",19), $text);	
					//bb codes
					$text = preg_replace('|\[b](.*)\[\/b]|Uis', "<b>\${1}</b>", $text);
					$text = preg_replace('|\[i](.*)\[\/i]|Uis', "<i>\${1}</i>", $text);
					$text = preg_replace('|\[u](.*)\[\/u]|Uis', "<u>\${1}</u>", $text);
					$text = preg_replace('|\[s](.*)\[\/s]|Uis', "<s>\${1}</s>", $text);
					$text = preg_replace('|\[center](.*)\[\/center]|Uis', "<center>\${1}</center>", $text);
					$text = preg_replace('|\[right](.*)\[\/right]|Uis', "<div align=\"right\">\${1}</div>", $text);
					$text = preg_replace('|\[left](.*)\[\/left]|Uis', "<div align=\"left\">\${1}</div>", $text);
					//url
					if ($cms_createlinks==1)
					{
						$text    = preg_replace("|\[url\]http://(.*)\[/url\]|Usi",'[url]${1}[/url]',$text);
           					if ($cms_furl==1)
							$text    = preg_replace('|\[url\](.*)\[/url\]|Uis', "<a href=\"".$cms_site."/gosite/\${1}\" target=\"_blank\" rel=\"nofollow\">\${1}</a>", $text);
						else
							$text    = preg_replace('|\[url\](.*)\[/url\]|Uis', "<a href=\"".$cms_site."/?action=gosite&amp;url=\${1}\" target=\"_blank\" rel=\"nofollow\">\${1}</a>", $text);
						
						$text    = preg_replace("|\[url=http://(.*)\](.*)\[/url\]|Usi",'[url=${1}]${2}[/url]',$text);
           					if ($cms_furl==1)
							$text    = preg_replace('|\[url=(.*)\](.*)\[/url\]|Uis', "<a href=\"".$cms_site."/gosite/\${1}\" target=\"_blank\" rel=\"nofollow\">\${2}</a>", $text);
						else
							$text    = preg_replace('|\[url=(.*)\](.*)\[/url\]|Uis', "<a href=\"".$cms_site."/?action=gosite&amp;url=\${1}\" target=\"_blank\" rel=\"nofollow\">\${2}</a>", $text);
					};
					//img
					if ($imgteg || $cms_img_comment)
						$text	=	preg_replace('|\[img\](.*)\[\/img\]|Uis',"<img src=\"\${1}\" border=0 alt=\"\">",$text);
					//smiles
					foreach ($this->getsmiles() as $smile)
					        $text	=	str_replace('['.$smile.']',"<img src=\"".$cms_site."/smiles/".$smile.".gif\" border=0 alt=\"[".$smile."]\">",$text);
				};
				//newlinere
				$text = str_replace("[newlinere]","\r\n",$text);
				//cenzura
				if (($cms_cenzura==1) and ($needcenz==true))
				{
					$words = explode(",",$cms_cenzura_words);
     					for ($i=0; $i<count($words); $i++)
       					$text = str_replace($words[$i],"***",$text);
				};
				break;
					
		};
		return $text;
	}
};

$GlobalTemplate = new RuxeTemplate;

class GlobalBFG
{
	function refreshrewrite($furl=2,$frominstall=false,$installpath='')
	{
		global $cms_rewrite, $cms_rewrite_ext, $cms_root, $cms_furl, $cms_site;
		/*
		 * 1.1
		 */
		$tmp 		= 	str_replace('http://','',$cms_site);
		$tmp2		=	explode('/',$tmp);
		if (count($tmp2)>1) {
			unset($tmp2[0]);
			$installpath = '/'.implode('/',$tmp2);
		} else
			$installpath = '';
		$frominstall = true;
		//die($installpath);
		/*
		 *
		 */
		$gener = "#Don't edit a next code";
   		if (!is_writable($cms_root."/.htaccess"))
   		{
			header('Content-type: text/xml; charset=utf-8');
        		die("Нет прав на запись в файл .htaccess, находящийся в корне сайта. Пожалуйтса, установите права на запись (777 или 666) на файл .htaccess.");
        		exit;
   		};
   		$oldfile = file($cms_root."/.htaccess");
   		$newfile = fopen($cms_root."/.htaccess","w");
   		foreach ($oldfile as $oldline)
   		{
      				if (substr_count($oldline,$gener)!=0) 
      					break;
      				if (substr_count($oldline,"RewiteEngine")==0) 
      				{

         				if (substr_count($oldline,"RewriteBase")==0)
             					fwrite($newfile,$oldline);
         			};  
   		};
   		fwrite($newfile,$gener."\r\n");
		$addpath = $_SERVER['PHP_SELF'];
		$t       = explode("/rpanel/",$addpath);
		if ($furl==2)
			$furl	=	$cms_furl;
		if ($frominstall=true)
		{
			if ($installpath!='')
				$t[0]=$installpath;
			else
				$t[0]='';
		};
		if ($furl==1)
		{
			fwrite($newfile,"RewriteEngine On\r\nRewriteRule ^rss$ rss/\r\nRewriteRule ^rss/$ index.php?action=rss [L]\r\n");
			fwrite($newfile,"RewriteRule ^viewprofile/(.*) index.php?action=profile&user=\$1 [QSA]\r\nRewriteRule ^link/(.*)/(.*)/ index.php?action=link&id=\$1&new=\$2 [L]\r\nRewriteRule ^go/(.*) index.php?action=go&link=\$1 [QSA]\r\nRewriteRule ^tag/(.*)/(.*) \$1/?searchtag=\$2 [QSA]\r\nRewriteRule ^gosite/(.*) index.php?action=gosite&url=\$1 [QSA]\r\nRewriteRule ^category/(.*)/(.*) \$1/?category=\$2 [QSA]\r\nRewriteRule ^rotator/(.*) index.php?action=rotator&go=\$1 [QSA]\r\nRewriteRule ^getfile/(.*) index.php?action=download&file=\$1 [QSA]\r\nRewriteRule ^pm/(.*) index.php?action=pm&do=\$1 [QSA]\r\nRewriteRule ^editprofile/ index.php?action=myprofile [QSA]\r\nRewriteRule ^restore/ index.php?action=restore [QSA]\r\nRewriteRule ^newuser/ index.php?action=newuser [QSA]\r\n");
			$pagesconfig = file($cms_root."/conf/pages/config");
			foreach ($pagesconfig as $pagesline)
			{
				$precords = explode("|",$pagesline);
				fwrite($newfile,"RewriteRule ^".$precords[0]."$ ".$precords[0]."/\r\nRewriteRule ^".$precords[0]."/$ index.php?viewpage=".$precords[0]." [QSA]\r\n");
			};
			$bfgconfig = file($cms_root."/conf/bfg.dat");
			foreach ($bfgconfig as $bfgline)
			{
				$bc = explode("|",$bfgline);
				fwrite($newfile,"RewriteRule ^".$bc[0]."$ ".$bc[0]."/\r\nRewriteRule ^".$bc[0]."/$ ".$bc[2]."/ [L]\r\nRewriteRule ^".$bc[0]."/(.*)".$cms_rewrite_ext." index.php?viewpage=".$bc[2]."&viewnews=".$bc[0]."&record=\$1 [QSA]\r\n");
			};
		};
		fclose($newfile);
	}

	function updaterss()
	{
		global $cms_root;
      		include($cms_root."/conf/rss.dat");
      		$rss_dat = fopen($cms_root."/conf/rss.dat","w");
      		fwrite($rss_dat,"<?php\r\n\$rss_pub_date = \"".date("D, d M Y H:i:s")."\";\r\n\$rss_gdd = \"".$rss_gdd."\";\r\n\$cms_rss_id = \"".$cms_rss_id."\";\r\n");
      		fclose($rss_dat);
	}	
	
	function delrecord($list,$news,$type)
	{
		global $cms_root, $GlobalComments, $GlobalCache, $_COOKIE, $Filtr, $_SERVER, $GlobalUsers;
		
		if (!is_numeric($list))
		{
    			die("Error.54: LIST is not supported");
    			exit;
  		};
  		$file=file("../conf/".$type."/list.dat"); 

  		for($i=0;$i<sizeof($file);$i++)
			if($i==$list) unset($file[$i]); 

  		$fp=fopen("../conf/".$type."/list.dat","w"); 
  		fputs($fp,implode("",$file)); 
  		fclose($fp);
  
  		//Удалять комментарии
  		$fullnew = file($cms_root."/conf/".$type."/".$news.".dat");
  		$z = count($fullnew)-1;
 	 	foreach ($fullnew as $fullne)
  		{
       			if (($z!=0) && ($fullne!=""))
              			$GlobalComments->DelCommentFromNew($type,$news,$z);
       			$z--;
  		};
  		//
  
  		$flag = unlink("../conf/".$type."/".str_replace(".","",$news).".dat");
  		$old_file = file("../conf/".$type."/views.dat");
  		$new_file = fopen("../conf/".$type."/views.dat","w");
  		foreach ($old_file as $old)
  		{
     			$o = explode("|",$old);
     			if ($o[0] != $news) fwrite($new_file,$o[0]."|".$o[1]."|\r\n");
  		};
  		fclose($new_file);
  		$GlobalCache -> tags($type);
  		$GlobalCache -> cats($type);
  		$this->updaterss();
		//0.9.9.2
		$name	=	$Filtr->clear($_COOKIE['site_login']);
		$status	=	$GlobalUsers->getstatus($name);
		if ( ($status=='editor') or ($status=='moderator') )
		{
			//пляшим
			$nm	=	fopen($cms_root.'/conf/new_messages.dat','a');
			$mess	=	($status=='editor') ? 'Редактор' : 'Модератор';
			$mess	.=	' '.$name.' удалил новость "'.$news.'" из новостного раздела "'.$type.'"';
			fputs($nm,'Отчёт о действиях '.$name.'|yes|'.$mess."\r\n");
			fclose($nm);
		};
		//
  		return $flag;
	}
	
	function editrecord()
	{
		global $_POST, $_COOKIE, $Filtr, $GlobalCache, $GlobalUsers, $cms_root;
		$category   	= str_replace("|","",$_POST['category']);
		$newcategory 	= str_replace("|","",$_POST['newcategory']);

		if ($newcategory!="")
		{
     			$category = $newcategory;
		};
		$name 		= $Filtr->clear($_COOKIE['site_login']);
		$keys 		= $Filtr->clear($_POST['keys']);
		$list 		= $Filtr->clear($_POST['list']);
		$news 		= $Filtr->clear($_POST['newss']);
		$tegs 		= str_replace("|","",$_POST['tegs']);
		$tegs  		= str_replace(",    ",",",$tegs);
		$tegs  		= str_replace(",   ",",",$tegs);
		$tegs  		= str_replace(",  ",",",$tegs);
		$tegs  		= str_replace(", ",",",$tegs);
		(isset($_POST['upped'])) ? $upped = $_POST['upped'] : $upped = "no";
		$link  		= filter_var($_POST['link'], FILTER_SANITIZE_URL);
		if ($link=="http://") $link = "";
		$needdeletefile = "";
		$date 		= $Filtr->clear($_POST['date']);
		$updatedate	= (isset($_POST['updatedate'])) ? $_POST['updatedate'] : 'no';
		if ($updatedate=='yes')
			$date	=	date("d.m.y, H:i");
		$author 	= $Filtr->clear($_POST['author']);
		$type 		= $Filtr->clear($_POST['type']);
		$fulldate 	= $Filtr->clear($_POST['fulldate']);
		$description 	= $Filtr->clear($_POST['description']);
		(isset($_POST['post_public'])) ? $post_public = $Filtr->clear($_POST['post_public']) : $post_public = "no";
		$tmp		=	$GlobalUsers->getrules($name);
		if ($tmp['bfg_public']!=true)
			$post_public = 'no';
		(isset($_POST['comments_'])) ? $comments_ = $Filtr->clear($_POST['comments_']) : $comments_ = "no";
		($comments_ == "yes") ? $comments_ = "Да" : $comments_ = "Нет";
		if (!is_numeric($list))
		{
    			echodie("Error.1212: LIST not supported");
		};
		$title = trim($_POST['title']);

  		$yes = "no";
  
  		$path2 = preg_replace("|\-+|","-",$Filtr->tolat($title));
		if ($news!=$path2)
		{
   			$needdeletefile = true;
   			$lastfile = "../conf/".$type."/".$news.".dat"; 
		};
  		if (
      			(file_exists("../conf/".$type."/".$path2.".dat"))
       			and
       			($news!=$path2)
      		)
  		{
     			while ($yes!="yes")
     			{
      				$path2 = $Filtr->tolat($title)."-".rand(1,150);
      				if (!file_exists("../conf/".$type."/".$path2.".dat"))
      				{
         				$yes = "yes"; 
      				};
     			};
  		};

		$br 		= (isset($_POST['br'])) ? $_POST['br'] : false;
		$brplus 	= (isset($_POST['brplus'])) ? $_POST['brplus'] : false;
		$pq   		= (isset($_POST['pq'])) ? $Filtr->clear($_POST['pq']) : false;
		$message 	= $_POST['text'];
		$messageplus 	= $_POST['textplus'];
  		if ($pq=='yes')
  		{
       			$message 	= preg_replace("|\"(.*)\"|uUis", "«\${1}»", $message);
       			$messageplus 	= preg_replace("|\"(.*)\"|uUis", "«\${1}»", $messageplus);
  		};
  		
  		$tire		=	(isset($_POST['tire'])) ? $_POST['tire'] : 'no';
  		if ($tire=='yes')
  		{
  			$message 	= preg_replace("| - |uUis", " — ", $message);
       			$messageplus 	= preg_replace("| - |uUis", " — ", $messageplus);
  		};

  		if ($messageplus=="")
  			$messageplus = $message;
   
		if ($br == "yes")
		{
			setcookie('addbr', 'yes', time() + 1209600,"/");
   			$message = str_replace("\r\n","<br>[newlinere]",$message);
		}
		else
		{
			setcookie('addbr', 'no', time() + 1209600,"/");
    			$message = str_replace("\r\n","[newlinere]",$message);
		};
		if ($brplus == "yes")
		{
			setcookie('addbrplus', 'yes', time() + 1209600,"/");
    			$messageplus = str_replace("\r\n","<br>[newlinere]",$messageplus);
		}
		else
		{
			setcookie('addbrplus', 'no', time() + 1209600,"/");
    			$messageplus = str_replace("\r\n","[newlinere]",$messageplus);
		};
		//|
		$message	=	str_replace("|","[dividinglinere]",$message);
		$messageplus	=	str_replace("|","[dividinglinere]",$messageplus);
		//
		$old_file = file("../conf/".$type."/".$news.".dat");   
		$file    = fopen("../conf/".$type."/".$path2.".dat","w");
		$i = 1;
		fwrite($file,$date."|".$author."|".$title."|".$messageplus."|".$tegs."|".$_SERVER['REMOTE_ADDR']."|".$keys."|".$description."|".$comments_."|\r\n");
		for ($i=0; $i<count($old_file); $i++)
		{
     			if ($i!=0)
     			{
       				fwrite($file, $old_file[$i]);
     			};
		};
		fclose($file);
		if ($news!=$path2)
			chmod($cms_root."/conf/".$type."/".$path2.".dat",0777);
   
		$i = 0;
   
		$old_file 	= file("../conf/".$type."/list.dat");
		$file 		= fopen("../conf/".$type."/list.dat","w");
   
		for ($i=0; $i<count($old_file); $i++)
		{
     			if ($i==$list)
     			{
       				($post_public == "yes") ? $post_public2 = "Да" : $post_public2 = "Нет";
       				($upped == "yes") ? $upped2 = "Да": $upped2 = "Нет";
       				fwrite($file,$date."|".$author."|".$title."|".$message."|".$tegs."|".$_SERVER['REMOTE_ADDR']."|".$path2."|".$category."|".$fulldate."|".$post_public2."|".$comments_."|".$upped2."|".$link."|\r\n");
     			}
     			else
     			{
       				fwrite($file,$old_file[$i]);
     			};
		};
		fclose($file);



		$old_file = file("../conf/".$type."/views.dat");
		$new      = fopen("../conf/".$type."/views.dat","w");
		foreach ($old_file as $old_)
		{
    			$o = explode("|",$old_);
    			($o[0]==$news) ? fwrite($new,$path2."|".$o[1]."|\r\n") : fwrite($new,$old_);
		};
		fclose($new);

		if ($needdeletefile==true) @unlink($lastfile);
		$GlobalCache -> tags($type);
		$GlobalCache -> cats($type);
		$this->updaterss();
		//0.9.9.2
		$status	=	$GlobalUsers->getstatus($name);
		if ( ($status=='editor') or ($status=='moderator') )
		{
			//пляшим
			$nm	=	fopen($cms_root.'/conf/new_messages.dat','a');
			$mess	=	($status=='editor') ? 'Редактор' : 'Модератор';
			$mess	.=	' '.$name.' изменил новость "'.$title.'" в новостном разделе "'.$type.'"';
			fputs($nm,'Отчёт о действиях '.$name.'|yes|'.$mess."\r\n");
			fclose($nm);
		};
		//
	}
	
	function createrecord($type,$name)
	{
	 	global $_POST,$_SERVER, $_COOKIE, $GlobalCache, $Filtr, $cms_root, $GlobalUsers;       
  
  		$category 	= str_replace("|","",$_POST['category']);
  		$newcategory 	= str_replace("|","",$_POST['newcategory']);
  		if ($newcategory!="")
     			$category = $newcategory;

  		$keys  = $Filtr->clear($_POST['keys']);
  		$title = trim(str_replace("|","",$_POST['title']));
  		$tegs  = str_replace("|","",$_POST['tegs']);
  		$tegs  = str_replace(",    ",",",$tegs);
  		$tegs  = str_replace(",   ",",",$tegs);
  		$tegs  = str_replace(",  ",",",$tegs);
  		$tegs  = str_replace(", ",",",$tegs);
  		$upped = (isset($_POST['upped'])) ? $_POST['upped'] : "no";
  		$link  = filter_var($_POST['link'], FILTER_SANITIZE_URL);
  		if ($link=="http://") 
  			$link = "";
  		$br 		= (isset($_POST['br'])) ? $_POST['br'] : false;
		$brplus 	= (isset($_POST['brplus'])) ? $_POST['brplus'] : false;
		$pq   		= (isset($_POST['pq'])) ? $Filtr->clear($_POST['pq']) : false;
  		$message= $_POST['text'];
  		$messageplus = $_POST['textplus'];
  
  		
  		if ($pq=='yes')
  		{
       			$message = preg_replace("|\"(.*)\"|uUis", "«\${1}»", $message);
       			$messageplus = preg_replace("|\"(.*)\"|uUis", "«\${1}»", $messageplus);
  		};
  		
  		$tire		=	(isset($_POST['tire'])) ? $_POST['tire'] : 'no';
  		if ($tire=='yes')
  		{
  			$message 	= preg_replace("| - |uUis", " — ", $message);
       			$messageplus 	= preg_replace("| - |uUis", " — ", $messageplus);
  		};
  
  		if ($messageplus=="") 
  			$messageplus = $message;
  		$description = $Filtr->clear($_POST['description']);
  		$post_public = (isset($_POST['post_public'])) ? $Filtr->clear($_POST['post_public']) : "no";
  		$tmp		=	$GlobalUsers->getrules($name);
		if ($tmp['bfg_public']!=true)
			$post_public = 'no';
  		$comments_   = (isset($_POST['comments_'])) ? $Filtr->clear($_POST['comments_']) : "no";
  		$comments_   = ($comments_=="yes") ?  "Да" : "Нет";
  		$yes  = "no";
  
  		$path = preg_replace("|\-+|","-",$Filtr->tolat($title));
  
  		if (file_exists($cms_root."/conf/".$type."/".$path.".dat"))
  		{
     			while ($yes!="yes")
     			{
      				$path = $Filtr->tolat($title)."-".rand(1,100);
      				if (!file_exists($cms_root."/conf/".$type."/".$path.".dat"))
      				{
         				$yes = "yes";
      				};
     			};
  		};   
  		if ($br == "yes")
  		{
  			setcookie('addbr', 'yes', time() + 1209600,"/");
    			$message = str_replace("\r\n","<br>[newlinere]",$message);
  		}
  		else
  		{
  			setcookie('addbr', 'no', time() + 1209600,"/");
    			$message = str_replace("\r\n","[newlinere]",$message);
  		};   

  		if ($brplus == "yes") 
  		{
  			setcookie('addbrplus', 'yes', time() + 1209600,"/");
    			$messageplus = str_replace("\r\n","<br>[newlinere]",$messageplus);
  		}
  		else
  		{
  			setcookie('addbrplus', 'no', time() + 1209600,"/");
    			$messageplus = str_replace("\r\n","[newlinere]",$messageplus);
  		};
		//|
		$message	=	str_replace("|","[dividinglinere]",$message);
		$messageplus	=	str_replace("|","[dividinglinere]",$messageplus);
		//
  		$file    = fopen($cms_root."/conf/".$type."/".$path.".dat","w");
  		fwrite($file,date("d.m.y, H:i")."|".$name."|".$title."|".$messageplus."|".$tegs."|".$_SERVER['REMOTE_ADDR']."|".$keys."|".$description."|".$comments_."|\r\n");
  		fclose($file); 
  		chmod($cms_root."/conf/".$type."/".$path.".dat",0777);
  		$list = fopen($cms_root."/conf/".$type."/list.dat","a");
  
  		$post_public2 	= ($post_public == "yes") ?  "Да" : "Нет";
  		$upped2 	= ($upped == "yes") ?  "Да":"Нет";
  
  		fwrite($list,date("d.m.y, H:i")."|".$name."|".$title."|".$message."|".$tegs."|".$_SERVER['REMOTE_ADDR']."|".$path."|".$category."|".date("D, d M Y H:i:s")."|".$post_public2."|".$comments_."|".$upped2."|".$link."|\r\n");
  		fclose($list);
  		$file = fopen($cms_root."/conf/".$type."/last_category.dat","w");

  		fwrite($file, $category);
  		fclose($file);
  		$file = fopen($cms_root."/conf/".$type."/views.dat","a");
  		fputs($file,$path."|0|\r\n");
  		fclose($file);
  		$this->updaterss();
  		$GlobalCache -> tags($type);
  		$GlobalCache -> cats($type);
		//0.9.9.2
		$status	=	$GlobalUsers->getstatus($name);
		if ( ($status=='editor') or ($status=='moderator') )
		{
			//пляшим
			$nm	=	fopen($cms_root.'/conf/new_messages.dat','a');
			$mess	=	($status=='editor') ? 'Редактор' : 'Модератор';
			$mess	.=	' '.$name.' создал новость "'.$title.'" в новостном разделе "'.$type.'"';
			fputs($nm,'Отчёт о действиях '.$name.'|yes|'.$mess."\r\n");
			fclose($nm);
		};
		//
	}
};

$GlobalBFG = new GlobalBFG;

class Commentaries
{
	function DelCommentFromNew($type,$new,$line)
	{
    		global $cms_root,$Filtr,$GlobalUsers;
    
    		//Защита
    		$a = array(".","%"," ","/","\\","#");
    		$news = str_replace($a,'',$new);
    
    		//const
    		$fie = $cms_root."/conf/".$type."/".$news.".dat";
    
    		$file=file($fie); 
    		$tmp = explode("|",$file[$line]);
        
    		$old_users = file($cms_root."/conf/users/users.dat");
    		$i = 0;
    		foreach ($old_users as $old_user)
    		{
           		$old = explode("|",$old_user);
           		if ($Filtr->tolower($old[18])==$Filtr->tolower($Filtr->clear($tmp[1])))
           		{   
               			$usersfruits[14] = $old[14] - 1;
               			$GlobalUsers->editpoles("pos",$i);
           		};
           		$i++;
    		};
           
    		$elsefile = file($fie);
    		$lastposts = file($cms_root."/conf/last_posts.dat");

    		$e = explode("|",$elsefile[$line]);
    		foreach ($lastposts as $last)
    		{
               		$l = explode("|",$last);
               		if (
                  		($l[0]==$type) &&
                  		($l[1]==$e[1]) &&
                  		($l[3]==$e[0]) &&
                  		($l[4]==$e[3]) &&
                  		($l[5]==$news)
              		) {
				$this->dellastpost($type,$l[1],$l[3],$l[4],$l[5]);
				break;
			}
    		};
    
    		for($i=0;$i<sizeof($file);$i++)
          		if($i==$line) unset($file[$i]); 
    		$fp=fopen($fie,"w"); 
    		fputs($fp,implode("",$file)); 
    		fclose($fp);
	}

	function editlastpost($from,$name,$new_showing,$date,$last_message,$new_message,$last_title)
	{
     		global $cms_root;
     		$original = file($cms_root."/conf/last_posts.dat");
     		$new      = fopen($cms_root."/conf/last_posts.dat","w");
     		foreach ($original as $orig)
     		{
          		$o = explode("|",$orig);
          		if (
           			($o[0]==$from) &&
           			($o[1]==$name) &&
           			($o[3]==$date) &&
           			($o[4]==$last_message) &&
           			($o[5]==$last_title)
          		)
              			fwrite($new,$o[0]."|".$o[1]."|".$new_showing."|".$o[3]."|".$new_message."|".$o[5]."|".$o[6]."|\r\n");
          		else
              			fwrite($new,$orig);
     		};
     		fclose($new);
	}

	function dellastpost($from,$name,$date,$message,$title)
	{
     		global $cms_root;
     		$original = file($cms_root."/conf/last_posts.dat");
     		$new      = fopen($cms_root."/conf/last_posts.dat","w");
		$founded  = false;
     		foreach ($original as $orig)
     		{
          		$o = explode("|",$orig);
			$write	= true;
			if (
				($o[0]==$from) and
				($o[1]==$name) and
				($o[3]==$date) and
				($o[4]==$message) and
				($o[5]==$title) and
				($founded==false)
			) {
				$founded= true;
				$write	= false;
			}
		
          		if ($write)
				fwrite($new,$orig);
     		};
     		fclose($new);
	}

	function addtolastposts($from,$name,$showing,$message,$title,$date)
	{
		//die($title);
     		global $cms_root, $_SERVER, $cms_site, $Filtr, $cms_furl;
     		if ($from == 'messages')
     		{
     			$list	=	file($cms_root.'/conf/messages/listmess.dat');
     			foreach ($list as $ls)
     			{
     				$l	=	explode('|',$ls);
     				if ($l[0]==$title)
     				{
     					$fulltitle	=	$l[1];
     					break;
     				};
     			};
     			$title	=	str_replace($cms_site.'/','',$Filtr->clear($_SERVER['HTTP_REFERER']));
			//die($title);
     			if (strstr($title,'?'))
     			{
				if ($cms_furl==1)
					$title	=	substr($title,0,strpos($title,'?'));
				else
				{
					$tmp	=	explode('viewpage=',$title);
					$tmp2	=	explode('&',$tmp[1]);
					$title	=	$tmp2[0];
				};
				
     			};
			
     		}
     		else
     		{
     			$list		=	file($cms_root.'/conf/'.$from.'/list.dat');
     			foreach ($list as $lst)
     			{
     				$ls	=	explode('|',$lst);
     				if ($title==$ls[6])
     				{
     					$fulltitle	=	$ls[2];
     					break;
     				};
     			};
     		};
     		$lastposts = file($cms_root."/conf/last_posts.dat");
    		if (count($lastposts)==30)
     		{
            	 	$newlastposts = fopen($cms_root."/conf/last_posts.dat","w");
            	 	$pos = 0;
            	 	foreach ($lastposts as $lastpost)
            	 	{
            	 		if ( $pos!=0 )
            	 		{
            	 			fwrite($newlastposts,$lastpost);
            	 		};
            	 		$pos++;
            	 	};
            	 	fclose($newlastposts);
     		};
     		$file = fopen($cms_root."/conf/last_posts.dat","a");
     		fputs($file,$from."|".$name."|".$showing."|".$date."|".$message."|".$title."|".$fulltitle."|\r\n");
     		fclose($file);
	}
	

	function show($messdata,$pos)
	{
 		global $cms_site,$lcms,$cms_avatars,$cms_upload_width,$cms_upload_height,$cms_ps,$cms_ps_max,
 			$cms_theme,$cms_gravatars,$cms_gravatars_im,
 			$cms_nav_comments,$GlobalTemplate,$GlobalUsers,$Navigation,$GlobalImaging,$Filtr,$fileusers; 
 		
 		$echolist  = "";
 		foreach ($messdata as $mess)
 		{
   			$pieces = explode("|",$mess);
  			if ($Navigation->ShowPage(count($messdata),$pos,$cms_nav_comments) == True && $pieces[6]=="yes")
  			{
    				
    				$ps = "";
    				$ONLYNAME = $pieces[1];


				$tr	=	$GlobalUsers->finduser($pieces[1]);
				//Пусть сначала аватара будет noavatar.png
				$avatar = $cms_site."/avatars/noavatar.png";
				//Потом если включены граватары - брать из мыла
				$needgravatar	=	true;
				$needcenzura	=	true;
				if ($tr!=-1)
    				{
    					$pie	=	explode('|',$fileusers[$tr]);
    					$ps	=	$Filtr->textmax($pie[17],$cms_ps_max);
    					if ($pie[4] == "admin") {
						$needcenzura	=	false;
                  				$pieces[1] = $GlobalTemplate->users(array("{SITE}","{THEMEPATH}","{NAME}","{PROFILELINK}"),array($cms_site,$cms_site."/themes/".$cms_theme,$pieces[1],$Navigation->furl('viewprofile',$pieces[1])),8); 
                	 		} else
                  				$pieces[1] = $GlobalTemplate->users(array("{SITE}","{THEMEPATH}","{NAME}","{PROFILELINK}"),array($cms_site,$cms_site."/themes/".$cms_theme,$pieces[1],$Navigation->furl('viewprofile',$pieces[1])),7);
					//if ($pie[16]=='noavatar.png')
					$pieces[2] = $pie[2];
					if ($pie[16]!='noavatar.png')
					{
						$avatar 	= 	$cms_site."/avatars/".str_replace("\\","",str_replace("..","",str_replace("/","",$Filtr->clear($pie[16]))));
						$needgravatar	=	false;
					};
					
				};
				if (($cms_gravatars==1) and ($needgravatar==true))
					$avatar = $GlobalImaging -> get_gravatar($pieces[2],$cms_upload_width,$cms_gravatars_im,'g',false);
				//Потом проверить установленную аватару если пользователь и сменить аватару если она не равна noavatar.png
				//usebbcodes($text,$do,$imgteg=false,$needcenz=true)
    				$pieces[3] = $GlobalTemplate->usebbcodes($pieces[3],'html',false,$needcenzura);
    				if ($cms_ps==1 && $ps!="")
       					$pieces[3] .= $lcms['ps_start'].$GlobalTemplate->usebbcodes($ps,'html',false,$needcenzura).$lcms['ps_end'];
    				if ($cms_avatars==1)
    				{
     					$ar = array("{NAME}","{DATE}","{MESSAGE}","{AVATAR}","{SITE}","{WIDTH}","{HEIGHT}","{ONLYNAME}","{THEMEPATH}");
     					$br = array($pieces[1],$Filtr->fulldate($pieces[0]),$pieces[3],$avatar,$cms_site,$cms_upload_width,$cms_upload_height,$ONLYNAME,$cms_site."/themes/".$cms_theme);
     					$echolist.=$GlobalTemplate->other($ar,$br,14);
    				}
    				else
    				{
     					$ar = array("{NAME}","{DATE}","{MESSAGE}","{ONLYNAME}","{THEMEPATH}");
     					$br = array($pieces[1],$Filtr->fulldate($pieces[0]),$pieces[3],$ONLYNAME,$cms_site."/themes/".$cms_theme);
     					$echolist.=$GlobalTemplate->other($ar,$br,13);
    				};
   			};
   			$pos--;
 		};

 		return $echolist;
	}
	
	function add($security, $name, $from, $mail, $title_news, $comment, $message, $type)
	{
		global $_SERVER, $lcms, $_COOKIE, $_POST, $cms_root, $cms_premoder, $cms_noflood, $cms_site,$cms_max_message,$cms_premoder,$cms_rewrite,
   		$cms_plusmess,$cms_sendmess,$cms_rewrite_ext,$cms_theme,$fileusers,$cms_theme,$openpage,$pagetitle,$pageredirect,
   		$cms_oncomments,$cms_guestnotwrite,$cms_adminm,$usersfruits,$cms_smiles,$Filtr,$GlobalUsers,$GlobalTemplate,$Mailing,
   		$cms_without_mail, $cms_furl, $Navigation, $cms_premod_mess;
   		
   		$frombfgololo 	= false;
   		$tomailmessage 	= $message;
   		$message 	= $Filtr->clear($message,true);
   		$name 		= $Filtr->textmax($name,30);
   		$mail 		= $Filtr->textmax($mail,50);
   		$from 		= $Filtr->clear($from);
   		$from 		= $Filtr->textmax($from,60);
   		$a 			= array(".","%"," ","/","\\","#");
   		$b 			= array("","","","","","");
   		$type 		= str_replace($a,$b,$Filtr->clear($type));
   		$comment  	= str_replace(".","",$comment);
   		$date     	= date("d.m.y, H:i");
   		$ip       	= $Filtr->clear($_SERVER['REMOTE_ADDR']);
   		$finderror 	= false;
   		$stop_down 	= false;
   		$errortext 	= "";
   		
   		if ($cms_oncomments!=1)
   		{
      			die($lcms['error_602']);
      			exit;
   		};
   		 
   		if (strstr($message,"|")) 
   		{ 
   			$errortext = $lcms['serror_message'];
   			$finderror = true;
   		};
   		if (!$message) 
   		{
   			$errortext = $lcms['error_message'];
   			$finderror = true;
   		};
   		if ((time() - $GlobalUsers->thisusertime())< $cms_noflood)
   		{ 
   			$finderror = true;
   			$errortext = $lcms['user_addnoflood'];
   		};
   		
   		$pluscounter = true;
   		if ($GlobalUsers->thisisuser())
   		{
      			$name = $Filtr->clear($_COOKIE['site_login']);
      			if (!$finderror) 
      			{
      				
      				$mail	=	$GlobalUsers->getpole($name,2);
      				if ($cms_premoder==1) {
      					if ($GlobalUsers->getpole($name,4)=='admin')
      						$pluscounter	=	true;
      					else {
							if ($GlobalUsers->getpole($name,14)>=$cms_premod_mess)
								$pluscounter=true;
							else
								$pluscounter	=	false;
						};
      				};
      				if (
                      			($pluscounter==true)
                      			&&
                      			($type!="tomail")
                      			&&
                      			($type!="question")
                      		)
                      			$usersfruits[14] = $GlobalUsers->getpole($name,14) + 1;
      				
         			$usersfruits[13] = time();
         			$GlobalUsers->editpoles("user",$_COOKIE['site_login']);
      			};
   		}
   		else
   		{
      			if (!$name) 
      			{
      				$errortext = $lcms['error_name']; 
      				$finderror = true;
      			};
      			if ($cms_without_mail==1)
      			{
      				if ($mail!='')
      				{
      					if (!$Mailing->checkmail($mail))
      					{
      						$errortext = $lcms['error_mail'];
      						$finderror = true;
      					};
      				}
      				else
      					$mail	=	'-';
      			}
      			else
      			{
      				if (!$Mailing->checkmail($mail))
      				{
      					$errortext = $lcms['error_mail'];
      					$finderror = true;
      				};
      			};
      			if (strstr($name,"|")) 
      			{
      				$errortext = $lcms['serror_name'];
      				$finderror = true;
      			};
      			if ($GlobalUsers->isuser($name))
      			{
      				$errortext = $lcms['user_founded'];
      				$finderror = true;
      			};
      			if (!$GlobalUsers->checkcaptcha($security))
      			{ 
      				$errortext = $lcms['error_security'];
      				$finderror = true;
      			};
      			if ($cms_guestnotwrite==1)
      			{
      				$errortext = $lcms['guest_not_write'];
      				$finderror = true;
      			};
      			if ($cms_premoder==1)
                      		$pluscounter = false;
   		};
   		if ($finderror)
   		{
      			$ar = array("{TITLE}","{GENERATOR}","{READRESS}","{/READRESS}","{MESSAGE}","{URL}","{SITE}","{THEMEPATH}");
      			if (
      				($type=='question')
      				or
      				($type=='tomail')
      				or
      				($type=='message')
      			)
			{
				if (strstr($from,'?'))
					$qwerty	=	$from.'&amp;';
				else
					$qwerty	=	$from.'?';
			}
      			else
			{
				$qwerty	=	$Navigation->furl('bfgfull',$type,$comment);
				if (strstr($qwerty,'?'))
					$qwerty.='&amp;';
				else
					$qwerty.='?';
			};
			$qwerty 	.=	"name=".$name."&amp;message=".$message."&amp;mail=".$mail."&amp;rand=".rand(1,9999);
			if (strstr($from,'?'))
				$from.='&amp;';
			else
				$from.='?';
      			$br 		= array($lcms['error_title'],"Ruxe Engine (ruxe-engine.ru)","","",$errortext."<center><a href=\"".$qwerty."\">".$lcms['error_back']."</a></center>",$from."comment=".$comment."&name=".$name."&message=".$message."&mail=".$mail,$cms_site,$cms_site."/themes/".$cms_theme);
      			$openpage     	= $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
      			$pagetitle    	= $lcms['error_title'];
      			$stop_down    	= true;
   		};
 		if (!$stop_down)
 		{  
			//Проверка на открытость одиночного раздела комментирования
			$valListmess 	= file($cms_root."/conf/messages/listmess.dat");
			foreach ($valListmess as $valLine) {
				$valPiece	= explode("|", $valLine);
				if ($valPiece[0]==$comment) {
					if ($valPiece[2]=="close") {
						die("В разделе запрещены новые комментарии");
						exit;
					}
				}
			}
			//
   			if ($_POST['submit'])
   			{
      				$message 	= str_replace("\r\n","<br>",$message);
      				$message 	= $Filtr->textmax($message,$cms_max_message);
     				switch ($type)
      				{
          				case "question":
               					$ffop = $cms_root."/conf/faq.dat";
               					break;
          				case "tomail":
               					$ffop = $cms_root."/conf/feedback.dat";
               					break;
          				case "message":
               					$ffop = $cms_root."/conf/messages/mess_".$comment.".dat";
               					break;
          				default:
               					$ffop = $cms_root."/conf/".$type."/".$comment.".dat";
      				};
      				if (file_exists($ffop))
      				{
        				$file = fopen($ffop,"a");
        				if ($pluscounter == true)
        					$premoderacia="yes";
        				else
        					$premoderacia="no";
        				if ($type == "tomail")
        				{
          					$subject = $title_news;
          					$premoderacia="no";
          					$line = "Тема: ".$subject."<br>Имя: ".$name."<br>Дата: ".$date."<br>E-mail:".$mail."<br>IP: ".$Filtr->clear($_SERVER['REMOTE_ADDR'])."|".$message;
        				}

        				else if ($type == "question")
        				{
          					$subject = $lcms['faq_subject'];
          					$premoderacia="no";
          					$line = $name."|".$mail."|".$date."|hide|".$message."||[b]Без ответа[/b]";
        				}
        				else
          					$line = $date."|".$name."|".$mail."|".$message."||".$ip."|".$premoderacia."|";
        				$line = str_replace("\r\n","<br>",$line); 
        				$line .= "\r\n";
        				fputs($file, $line); 
        				fclose($file);
        				switch ($type)
       					{
            					case "tomail":
                 					$qwerty_mail = 
                 							"Имя: ".$name."\n"
                 							."E-mail: ".$mail."\n"
                 							."Дата: ".$date."\n"
                 							."IP: ".$Filtr->clear($_SERVER['REMOTE_ADDR'])."\n"
                 							."Сообщение: ".$tomailmessage;
                 					$mess_submit_title = $lcms['gb_submit_title'];
                 					$message_submit = $lcms['faq_submit_title'];
                 					$qwerty_message = '<br><input type="button" onClick="location.href=\'?action=messages&from=feedback\';" value="Перейти в историю обратной связи"><br>'
                 							."Тема сообщения: ".$title_news."<br>"
                 							."Имя: ".$name."<br>"
                 							."E-mail: ".$mail."<br>"
                 							."Дата: ".$date."<br>"
                 							."IP: ".$ip."<br>" 
                 							."Сообщение: ".$message;

                 					$qwerty_addmail = "История обратной связи: ".$cms_site."/rpanel/index.php?action=messages&from=feedback \n\n"; 
                 					break;
            					case "question":
                 					$qwerty_mail = 
                 							"Имя: ".$name."\n"
                 							."E-mail: ".$mail."\n"
                 							."Дата: ".$date."\n"
                 							."IP: ".$ip."\n"
                 							."Вопрос: ".$tomailmessage;
                 					$mess_submit_title = $lcms['gb_submit_title'];
                 					$message_submit = $lcms['faq_submit_title'];
                 					$qwerty_message = '<br><input type="button" onClick="location.href=\'?action=faq\';" value="Перейти в базу F.A.Q."><br>'
                 							."Имя: ".$name."<br>"
                 							."E-mail: ".$mail."<br>"
                 							."Дата: ".$date."<br>"
                 							."IP: ".$ip."<br>" 
                 							."Вопрос: ".$message;
                 					$qwerty_addmail = "База F.A.Q.: ".$cms_site."/rpanel/index.php?action=faq \n\n"; 
                 					break;
            					case "message":
                 					$subject = $lcms['mess_title']." ".$title_news;
                 					$qwerty_mail =
                 						"Имя комментатора: ".$name."\n"
                 						."E-mail: ".$mail."\n"
                 						."Дата: ".$date."\n"
                 						."IP: ".$ip."\n" 
                 						."Комментарий: ".$tomailmessage;
                 					$x = 0;
                 					$z = 0;
                 					$listmess = file($cms_root."/conf/messages/listmess.dat");
                 					foreach ($listmess as $list_)
                 					{
                     						$l = explode("|",$list_);
                     						if ($l[0] == $comment) $x = $z;
                     						$z++;
                 					};
                 					$mess_submit_title = $lcms['mess_submit_title'];
                 					$message_submit = $lcms['mess_submit_text'];
							if ($premoderacia=='no')
								$message_submit	=	$lcms['comment_send_with_premoder'];
                 					$qwerty_message = '<br><input type="button" onClick="location.href=\'?action=messages&from=message&line='.$x.'&message='.$comment.'\';" value="Перейти в базу комментариев '.$title_news.'"><br>'
                 					."Имя комментатора: ".$name."<br>"
                 					."E-mail: ".$mail."<br>"
                 					."Дата: ".$date."<br>"
                 					."IP: ".$ip."<br>" 
                 					."Комментарий: ".$message;
                 					$qwerty_addmail = "База комментариев: ".$cms_site."/rpanel/index.php?action=messages&from=message&line=".$x."&message=".$comment." \n\n"; 
                 					break;
            					default:
            	 					$frombfgololo = true;
                 					$subject = $Filtr->clear($lcms['news_subject']);
                 					$qwerty_mail =
                 						"Заголовок: ".$Filtr->clear($title_news)."\n"
                 						."Имя комментатора: ".$name."\n"
                 						."E-mail: ".$mail."\n"
                 						."Дата: ".$date."\n"
                 						."IP: ".$ip."\n" 
                 						."Комментарий: ".$tomailmessage;
                 					$mess_submit_title = $lcms['mess_submit_title'];
                 					$message_submit = $lcms['news_submit_title'];
							if ($premoderacia=='no')
								$message_submit	=	$lcms['comment_send_with_premoder'];
                 					$qwerty_message = '<br><input type="button" onClick="location.href=\'?action=messages&from='.$type.'&news='.$comment.'\';" value="Перейти в базу комментариев"> <input type="button" onClick="window.open(\''.$Navigation->furl('bfgfull',$type,$comment).'\');" value="Перейти в новость на сайте"><br>'
                 						."Заголовок: ".$Filtr->clear($title_news)."<br>"
                 						."Имя комментатора: ".$name."<br>"
                 						."E-mail: ".$mail."<br>"
                 						."Дата: ".$date."<br>"
                					 	."IP: ".$ip."<br>" 
                 						."Комментарий: ".$message;
                 					$qwerty_addmail = "База комментариев: ".$cms_site."/rpanel/index.php?action=messages&from=".$type."&news=".$comment." \n\n";                 
        				};
        				$qwerty_mail 	= strip_tags($qwerty_mail,"");
        				$qwerty_mail 	= $GlobalTemplate->usebbcodes($qwerty_mail,'clear');
        				$qwerty_mail 	= str_replace(array('<','>'),'',$qwerty_mail);
        				$gomail 	= true;
        				if ($cms_adminm==0)
        				{
        					$tmp	=	(isset($_COOKIE['site_login'])) ? $Filtr->clear($_COOKIE['site_login']) : 'no';
             					if ($GlobalUsers->getstatus($tmp)=="admin") 
             						$gomail = false;
        				};                       
        				if ($gomail)
        				{                           
                   				if (($type == "tomail") or ($type == "question"))
                   				{
                      					if ($cms_plusmess == 1)
                         					$Mailing->toadmin($subject,$qwerty_addmail.$qwerty_mail);
                   				}
                   				else
                   				{
                       					if ($cms_sendmess == 1)
                          					$Mailing->toadmin($subject,$qwerty_addmail.$qwerty_mail);
                   				};
        				};
        				$addnm = true;
        				if ($cms_adminm==0)
        				{
        					$tmp	=	(isset($_COOKIE['site_login'])) ? $Filtr->clear($_COOKIE['site_login']) : 'no';
             					if ($GlobalUsers->getstatus($tmp)=="admin")
             						$addnm = false;
        				};
        				if ($addnm)
        				{       
                				$nm=fopen($cms_root."/conf/new_messages.dat","a");
                				fwrite($nm,$subject."|".$premoderacia."|".$qwerty_message."\r\n");
                				fclose($nm);
        				};
        				switch($type)
        				{
           					case "tomail":
               						break;
           					case "question":
               						break;
           					case "message":
           						$this->addtolastposts('messages',$name,$premoderacia,$message,$comment,$date);
               						break;
           					default:
               						$this->addtolastposts($type,$name,$premoderacia,$message,$comment,$date);     
        				};
        				header('Content-type: text/html; charset=utf-8');
        				$ar = array("{TITLE}","{GENERATOR}","{READRESS}","{/READRESS}","{MESSAGE}","{URL}","{SITE}","{THEMEPATH}");
        				if (
        					($type=='question')
        					or
        					($type=='tomail')
        					or
        					($type=='message')
        				)
					{
						if (strstr($from,'?'))
							$pageredirect = $from."&amp;rand=".rand(1,9999);
						else
							$pageredirect = $from."?rand=".rand(1,9999);
					}
        				else
					{
						$pageredirect	=	$Navigation->furl('bfgfull',$type,$comment);
						if (strstr($pageredirect,'?'))
							$pageredirect.='&amp;rand='.rand(1,999);
						else
							$pageredirect.='?rand='.rand(1,9999);
						$pageredirect	=	str_replace('&amp;','&',$pageredirect);
					};
					
					$br = array($mess_submit_title,"Ruxe Engine (ruxe-engine.ru)","","",$message_submit.$lcms['refer1']." <a href=\"".$pageredirect."\">".$lcms['refer2']."</a> ".$lcms['refer3'],$pageredirect,$cms_site,$cms_site."/themes/".$cms_theme);
						
        				$openpage = $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
        				$pagetitle = $mess_submit_title;
        				if (
        					($type == "question")
        					or
        					($type == "tomail")
        				)
        					$pageredirect = "";
      				}
      				else
      				{
        				header('Content-type: text/html; charset=utf-8');
        				die($lcms['hack']);
        				exit;
      				}
   			}
   			else
   			{
       				header('Content-type: text/html; charset=utf-8');
       				die($lcms['hack']);
       				exit;
   			};
 		};
	}

};

$GlobalComments = new Commentaries;

class Imaging
{
	function get_gravatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) 
	{
		//http://gravatar.com/site/implement/images/php/
		$url = 'http://www.gravatar.com/avatar/';
		$url .= md5( strtolower( trim( $email ) ) );
		$url .= "?s=$s&amp;d=$d&amp;r=$r";
		if ( $img ) {
			$url = '<img src="' . $url . '"';
			foreach ( $atts as $key => $val )
				$url .= ' ' . $key . '="' . $val . '"';
			$url .= ' />';
		}
		return $url;
	}
	
	function setTransparency($new_image, $image_source) 
	{
    		//thanks for http://www.answerium.com/article36/
    		$transparencyIndex = imagecolortransparent($image_source);
    		$transparencyColor = array('red' => 255, 'green' => 255, 'blue' => 255);
       
    		if ($transparencyIndex >= 0)
        			$transparencyColor = imagecolorsforindex($image_source, $transparencyIndex);   
       
    		$transparencyIndex = imagecolorallocate($new_image, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']);
    		imagefill($new_image, 0, 0, $transparencyIndex);
    		imagecolortransparent($new_image, $transparencyIndex);
	}
	
	function resize($sourse,$new_image,$width,$height)
	{
    		//thanks for http://gv0zdik.livejournal.com/5817.html
    		$size = GetImageSize($sourse);
    		$new_height = $height;
    		$new_width = $width;

    		($size[0] < $size[1])? $new_width=($size[0]/$size[1])*$height : $new_height=($size[1]/$size[0])*$width;
    		$new_width    = ($new_width > $width) ? $width : $new_width;
    		$new_height   = ($new_height > $height) ? $height : $new_height;
    		$image_p      = @imagecreatetruecolor($new_width, $new_height);
    		switch ($size[2])
    		{
        		case 1:
             			$image_cr = imagecreatefromgif($sourse);
             			$this->setTransparency($image_p, $image_p);
             			break;
        		case 2:
             			$image_cr = imagecreatefromjpeg($sourse);
             			break;
        		case 3:
             			$image_cr = imagecreatefrompng($sourse);
             			$this->setTransparency($image_p, $image_p);
             		break;
    		};
    		imagecopyresampled($image_p, $image_cr, 0, 0, 0, 0, $new_width, $new_height, $size[0], $size[1]);
    		switch ($size[2])
    		{
        		case 1:
             			imagegif($image_p, $new_image);
             			break;
        		case 2:
             			imagejpeg($image_p, $new_image, 98);
             			break;
        		case 3:
             			imagepng($image_p, $new_image);
             			break;
    		};
	}
	
	
};

$GlobalImaging	=	new	Imaging;

class FileManager
{

	function listing($url,$mode) 
	{
		if (is_dir($url)) 
		{
    			if ($dir = opendir($url)) 
    			{
        			while ($file = readdir($dir)) 
        			{
                   			if ($file != "." && $file != "..") 
                   			{
                     				if(is_dir($url."/".$file)) 
                     					$folders[] = $file;
                     				else 
                     					$files[] = $file;
                       			}
          			}
        		}
        		closedir($dir);
		}
		if($mode == 1) {if (isset($folders)) { sort($folders); return $folders; };};
		if($mode == 0) {if (isset($files)) { sort($files); return $files;}; };
	}
	
	function enablerules() {
		global $GlobalTemplate, $cms_theme, $_SERVER, $cms_root, $Navigation;
		$zxcfile 	= 	file($cms_root."/themes/".$cms_theme."/index.php");
		$zxcchmod	=	false;
		if (!file_exists($cms_root.'/conf/cache/design'))
			$zxcchmod	=	true;
		$zxcnfile 	= 	fopen($cms_root."/conf/cache/design","w");
		$zxctext 	= 	'';
		foreach ($zxcfile as $zxcline)
			$zxctext .= $zxcline;

		if ($GlobalTemplate->findcode('<!--',
						'-->',
						$zxctext,
				'{CREDITS}'
						)=='fail')
			$zxctext 	= 	str_replace('{CREDITS}',
				'-->{CREDITS}',
						$zxctext);
		if ($GlobalTemplate->findcode('<style',
				'/style>',
						$zxctext,
				'{CREDITS}'
						)=='fail')
			$zxctext 	= 	str_replace(
				'{CREDITS}',
				'</style>{CREDITS}',
						$zxctext);
		fwrite(
			$zxcnfile, str_replace(
				'{CREDITS}',
				'<span>Powered by <a href="http://ruxe-engine.ru/" target="_blank" >Ruxe Engine</a>.</span>',
				$zxctext
			)
		);
		fclose($zxcnfile);
		if ($zxcchmod) 
			chmod($cms_root.'/conf/cache/design',0777);
	}
	
	function enablemodules()
	{
		global $cms_theme, $cms_root, $cms_site, $cms_needlog, $cms_log_max, $_SERVER, $Filtr, $httpuseragent, $Robots, $GlobalUsers, $Navigation;
		$tmp22founded = false;

		if (file_exists($cms_root."/themes/".$cms_theme."/index.php"))
		{
			foreach (file($cms_root."/themes/".$cms_theme."/index.php") as $tmp33)
			{
				if (substr_count($tmp33,'{CREDITS}')!=0)
					$tmp22founded=true;
			};
		};
		
		$crithocspec	=	'87451234d03c11240fd3edfdd8dd962f256f519cd03c11240fd3edfdd8dd962f256f519c';

		if (substr_count($_SERVER['SERVER_NAME'],base64_decode($crithocspec))!=0) 
			$tmp22founded	=	true;
		

       		$date_file=file($cms_root."/conf/date.dat");
       		if ($date_file[0]!=date("d.m.y"))
       		{
              		$date_file = fopen($cms_root."/conf/date.dat", "w");
              		fwrite($date_file, date("d.m.y"));
              		fclose($date_file);
              		$tmp_ip_file = file($cms_root."/conf/ip.dat");
              		$count_last_hosts = 0;
              		foreach ($tmp_ip_file as $tmp_ip_file_)
              		{
                    		$tmp_ip_file__ = explode("|",$tmp_ip_file_);
                    		if ($tmp_ip_file__[1]=="people") 
                    			$count_last_hosts=$count_last_hosts+1;
              		};
              		$last_hosts = fopen($cms_root."/conf/last_hosts.dat","w");
              		fwrite($last_hosts,$count_last_hosts);
              		fclose($last_hosts);
              		$ip_file = fopen($cms_root."/conf/ip.dat", "w");
              		fwrite($ip_file, "");
              		fclose($ip_file);
              		$hits_file = fopen($cms_root."/conf/hits.dat", "w");
              		fwrite($hits_file, 0);
              		fclose($hits_file);
       		};
       		$stat_ip 	= $Filtr->clear($_SERVER['REMOTE_ADDR']);
       		$found_ip 	= 'no';
       		$ip_file 	= file($cms_root."/conf/ip.dat");
       		$all_hosts_file = file($cms_root."/conf/all_hosts.dat");
       		$all_hosts 	= $all_hosts_file[0];
       		$hosts 		= count($ip_file);
       		foreach($ip_file as $stat_element)
       		{
                        $stat_element = trim($stat_element);
                        $stat_ = explode("|", $stat_element);
                        if ($stat_ip == $stat_[0])
                                     $found_ip = 'yes';
       		};
       		if ($found_ip == 'no')
       		{
                        $ip_file = fopen($cms_root."/conf/ip.dat", "a");
                        if ($Robots->check($httpuseragent))
                        	$tmp_itsbot = 'bot';
                        else
                        	$tmp_itsbot = 'people';
                        fputs($ip_file, $Filtr->clear($stat_ip)."|".$tmp_itsbot."|\r\n");
                        fclose($ip_file);
                        $hosts += 1;
                        $all_hosts += 1;
                        $all_hosts_file = fopen($cms_root."/conf/all_hosts.dat", "w");
                        flock($all_hosts_file,LOCK_EX);
                        fwrite($all_hosts_file, $all_hosts);
                        flock($all_hosts_file,LOCK_UN);
                        fclose($all_hosts_file);
       		};
       		$hits_file=file($cms_root."/conf/hits.dat");
       		$all_hits_file=file($cms_root."/conf/all_hits.dat");
       		$hits = isset($hits_file[0]) ? (int)$hits_file[0] : 0;
       		$all_hits = isset($all_hits_file[0]) ? (int)$all_hits_file[0] : 0;
       		$hits +=1;
       		$all_hits +=1;
       		$hits_file=fopen($cms_root."/conf/hits.dat", "w");
       		flock($hits_file,LOCK_EX);
       		fwrite($hits_file, $hits);
       		flock($hits_file,LOCK_UN);
       		fclose($hits_file);
       		$all_hits_file=fopen($cms_root."/conf/all_hits.dat", "w");
       		flock($all_hits_file,LOCK_EX);
       		fwrite($all_hits_file, $all_hits); 
       		flock($all_hits_file,LOCK_UN); 
       		fclose($all_hits_file);
       		if ($cms_needlog==1)
       		{
				$logFileName = $cms_root.'/conf/logs/log.log';
				$original = array();
				if (file_exists($logFileName))
					$original	=	file($logFileName);
			//Сначала вычисления
			$needrewriteall	=	false;
			if (count($original)>=$cms_log_max)
			{
				unset($original[0]);
				$needrewriteall=true;
			};
				
			$ip		=	str_replace(array('[=]',"\r","\n"),' ',$Filtr->clear($_SERVER['REMOTE_ADDR']));
			$page		=	str_replace(array('[=]',"\r","\n"),' ','http://'.$Filtr->clear($_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']));
			$from		=	(isset($_SERVER['HTTP_REFERER'])) ? str_replace(array('[=]',"\r","\n"),'',$Filtr->clear($_SERVER['HTTP_REFERER'])) : '';
			$browser	=	($Robots->check($httpuseragent)==true) ? 'Бот ('.str_replace(array('[=]',"\r","\n"),'',$Filtr->clear($httpuseragent)).')' : str_replace(array('[=]',"\r","\n"),'',$Filtr->clear($httpuseragent));
			//$date		=	$Filtr->gettimezonedate();
			//23.05.11, 21:06
			/*$seconds	=	date("s");
			if ($seconds==0)
				$seconds	=	'01';
			$date		=	date("d.m.y, H:i").';'.$seconds;*/
			$date		=	date("d.m.y, H:i:s");
			$l		=	(isset($_COOKIE['site_login'])) ? $Filtr->clear($_COOKIE['site_login']) : 'no';
			$whom		=	($GlobalUsers->finduser($l)!=-1) ? str_replace(array('[=]',"\r","\n"),' ',$Filtr->clear($_COOKIE['site_login'])) : '';
			
			//Запись в конце производить
			if ($needrewriteall)
			{
				$new		=	fopen($cms_root.'/conf/logs/log.log','w');
				flock($new,LOCK_EX);
				fwrite($new,implode("",$original));
				fwrite($new,$page."[=]".$from."[=]".$browser."[=]".$ip."[=]".$date."[=]".$whom."[=]\r\n");
				flock($new,LOCK_UN);
				fclose($new);
			}
			else
			{
				$new	=	fopen($cms_root.'/conf/logs/log.log','a');
				fputs($new,$page."[=]".$from."[=]".$browser."[=]".$ip."[=]".$date."[=]".$whom."[=]\r\n");
				fclose($new);
			};
			//...
			
       		}; 
       		$this->enablerules();    
   	}

	function makedir($url){
                   $url = trim(htmlspecialchars($url));
                   if(@mkdir($url)){return TRUE;}
                   else{return FALSE;} }

	function frename($url,$oldname,$nname){
                   $nname = trim(htmlspecialchars($nname));
                   $oldname = trim(htmlspecialchars($oldname));
                   $url = trim(htmlspecialchars($url));
                   if(@rename($url."/".$oldname,$url."/".$nname)) {
                   return TRUE; }
                   else {return FALSE; } }

	function removedir($directory) {
  		$dir = opendir($directory);
  		while(($file = readdir($dir)))
  		{
    			if ( is_file ($directory."/".$file))
    			{ 
      				@chmod($directory."/".$file,0777);
      				@unlink ($directory."/".$file);
    			}
    			else if ( is_dir ($directory."/".$file) &&
             			($file != ".") && ($file != ".."))
    			{
      					@chmod($directory."/".$file,0777);
      					@$this->removedir ($directory."/".$file);
    			}
  		}
  		closedir ($dir);
  		@rmdir ($directory);

  		return TRUE;
	}	
	
	
	function updir($path)
	{
		$last = strrchr($path, "/");
		$n1 = strlen($last);
		$n2 = strlen($path);
		return substr($path,0,$n2-$n1); 
	}
	
	function fsize($path) 
	{ 
		return substr(filesize($path)/1024, 0, 4); 
	}

	function removefile($path) 
	{
         	@chmod($path, 0777);
         	if(@unlink($path))
         		return TRUE;
         	else 
         		return FALSE;
        }
        
        function recoursiveDir($dir)
        {
		//thanks for http://mauri.pp.ua/2010/10/18/zip/
    		global $allfiles, $cms_root;
    		if (file_exists($dir.'/.htaccess'))
    			$allfiles[] = $dir.'/.htaccess';
    		if ($files = glob($dir.'/*'))
    		{
        		foreach($files as $file)
        		{
            			if (is_dir($file))
                			$this->recoursiveDir($file);
            			else
            			{
            				if ($file!=$cms_root.'/index.php')
                				$allfiles[]    =   $file;
            			};
        		};
    		};
	}
	
	function checkfilename($text)
	{
  		if (preg_match('/^[a-zA-Z0-9\-\_\.]+$/', $text) && (strlen($text)>1))
     			return true;
  		else
     			return false;
	}
};

$FileManager = new FileManager;

$filewithbots	=	array();

class Robots
{
	function get()
	{
		global $cms_root, $filewithbots;
		
		if (count($filewithbots)==0)
			$filewithbots	=	file($cms_root.'/conf/bots');
		$res	=	unserialize($filewithbots[0]);
		
		return $res;
	}
	
	function check($text)
	{
		global $Filtr;
		$res = false;
		foreach ($this->get() as $bot)
		{
			if (strstr($Filtr->clear($text),$bot))
			{
				$res = true;
				break;
			};
		};
		return $res;
	}
}

$Robots = new Robots;

class Navigation
{
	function furl($action, $param1='', $param2='')
	{
		global $cms_site, $cms_rewrite_ext, $cms_furl;
		$actions	=	array(
					'bfglink',
					'bfgfull',
					'viewprofile',
					'category',
					'reglink',
					'restorelink',
					'pmlink',
					'profilelink',
					'pmsend',
					'tags',
					'pmshow',
					'pmdelete',
					'pmdeleteall',
					'pmnewmessage',
					'pmoutbox',
					'pmlinkrand',
					'getfile',
					'rotator',
					'pmnewname',
					'gosite',
					'go'
					);
		$flink		=	array(
					$cms_site.'/link/'.$param1.'/'.$param2.'/',
					$cms_site.'/'.$param1.'/'.$param2.$cms_rewrite_ext,
					$cms_site.'/viewprofile/'.$param1,
					$cms_site.'/category/'.$param1.'/'.$param2,
					$cms_site.'/newuser/',
					$cms_site.'/restore/',
					$cms_site.'/pm/',
					$cms_site.'/editprofile/',
					$cms_site.'/pm/send?rand='.rand(1,9999),
					$cms_site.'/tag/'.$param1.'/'.$param2,
					$cms_site.'/pm/show?line='.$param1,
					$cms_site.'/pm/delete?from='.$param1.'&amp;line='.$param2,
					$cms_site.'/pm/deleteall?from='.$param1,
					$cms_site.'/pm/new?message='.$param1,
					$cms_site.'/pm/outbox?rand='.rand(1,9999),
					$cms_site.'/pm/'.$param1.'?rand='.rand(1,9999),
					$cms_site.'/getfile/'.$param1,
					$cms_site.'/rotator/'.$param1,
					$cms_site.'/pm/new?name='.$param1,
					$cms_site.'/gosite/'.$param1,
					$cms_site.'/go/'.$param1
					);
		$link		=	array(
					$cms_site.'/?action=link&amp;id='.$param1.'&amp;new='.$param2,
					$cms_site.'/?viewnews='.$param1.'&amp;record='.$param2,
					$cms_site.'/?action=profile&amp;user='.$param1,
					$cms_site.'/?viewnews='.$param1.'&amp;category='.$param2,
					$cms_site.'/?action=newuser',
					$cms_site.'/?action=restore',
					$cms_site.'/?action=pm',
					$cms_site.'/?action=myprofile',
					$cms_site.'/?action=pm&do=send&rand='.rand(1,9999),
					$cms_site.'/?viewnews='.$param1.'&amp;searchtag='.$param2,
					$cms_site.'/?action=pm&amp;do=show&amp;line='.$param1,
					$cms_site.'/?action=pm&amp;do=delete&amp;from='.$param1.'&amp;line='.$param2,
					$cms_site.'/?action=pm&amp;do=deleteall&amp;from='.$param1,
					$cms_site.'/?action=pm&amp;do=new&amp;message='.$param1,
					$cms_site.'/?action=pm&do=outbox&rand='.rand(1,9999),
					$cms_site.'/?action=pm&amp;do='.$param1.'&amp;rand='.rand(1,9999),
					$cms_site.'/?action=download&amp;file='.$param1,
					$cms_site.'/?action=rotator&amp;go='.$param1,
					$cms_site.'/?action=pm&amp;do=new&amp;name='.$param1,
					$cms_site.'/?action=gosite&amp;url='.$param1,
					$cms_site.'/?action=go&amp;link='.$param1
					);
		$res		=	'';
		$i		=	0;
		foreach ($actions as $act)
		{
			if ($action==$act)
				$res	=	($cms_furl==1) ? $flink[$i] : $link[$i];
			$i++;
		};
		return $res;
	}
	
	function link($link,$caption,$active,$params,$newparams) {
  		return ($active==true) ? '<a href="'.$newparams.'page='.$link.$params.'" class="active">'.$caption.'</a> ' : '<a href="'.$newparams.'page='.$link.$params.'">'.$caption.'</a> ';
	}

	function Pager($count,$params,$rec_page,$newparams='?') {
 		global $_GET, $cms_root, $cms_rewrite,$lcms,$GlobalTemplate, $Filtr, $cms_nav_back;
 
 		$showendleftright 	= true; //Показывать ли ссылки "След.", "Пред."
 		$page			= 1;
 		$send 			= "";
 		$pag 			= "";
 		$total 			= ceil($count/$rec_page);
		if ($cms_nav_back == 1) {
			if ($total<1)
				$total	= 1;
			$ar		= array();
			for ($i=1; $i<=$total; $i++)
				$ar[$i]	= $total-$i+1;
			$page		= $ar[1];
 		}
 		if (isset($_GET['page'])) {
       			if (($_GET['page']>0) and ($_GET['page']<=ceil($count/$rec_page))) $page=(int)$Filtr->clear($_GET['page']);
 		};
 		//thanks for http://php.su/articles/?cat=examples&page=062
 		$page2left		= "";
 		$page1left		= "";
 		$page1right		= "";
 		$page2right		= "";
 		$endright 		= "";
 		$endleft  		= "";
 		$next 			= "";
 		$last			= "";
 		if($page != 1) { 
   			$endleft  = $this->link(1,1,false,$params,$newparams);
			if ($cms_nav_back==1)
				$last = $this->link(($page-1),$lcms['page_last'],false,$params,$newparams);
			else
				$last = $this->link(($page-1),$lcms['page_next'],false,$params,$newparams);
 		}
 		if($page != $total) 
 			$endright = $this->link($total,$total,false,$params,$newparams);
 		if($page - 2 > 1) {
    			$page2left = ($page - 2 == 2) ? $this->link(($page - 2),($page - 2),false,$params,$newparams) : $this->link(($page - 2),'...',false,$params,$newparams);
 		}
 		if($page - 1 > 1) 
 			$page1left = $this->link(($page - 1),($page - 1),false,$params,$newparams);
 		if ($page + 2 < $total) { 
    			$page2right = ($page + 2 == $total-1) ? $this->link(($page + 2),($page + 2),false,$params,$newparams) : $this->link(($page + 2),'...',false,$params,$newparams);
 		}
 		if($page + 1 < $total) 
   			$page1right = $this->link(($page + 1),($page + 1),false,$params,$newparams);
 		if ($page + 1 <= $total) {
			if ($cms_nav_back==1) 
				$next = $this->link(($page + 1),$lcms['page_next'],false,$params,$newparams);
			else
				$next = $this->link(($page + 1),$lcms['page_last'],false,$params,$newparams);
		}
 		if ($showendleftright)
         		$send = $last.$endleft.$page2left.$page1left.$this->link($page,$page,true,$params,$newparams).$page1right.$page2right.$endright.$next;
 		else
 	 		$send = $endleft.$page2left.$page1left.$this->link($page,$page,true,$params,$newparams).$page1right.$page2right.$endright;
 	 	if ($cms_nav_back == 1)
			$send	=	$next.$endright.$page2right.$page1right.$this->link($page,$page,true,$params,$newparams).$page1left.$page2left.$endleft.$last;
 		if ($count>$rec_page)
 			$pag = $GlobalTemplate->other("{PAGES}",$send,18); 
 		return $pag;
	}	

	function ShowPage($count,$position,$rec_page) {
  		global $_GET, $Filtr, $cms_nav_back;
		if ($cms_nav_back == 1) {
			$ar	= array();
			$total 	= ceil($count/$rec_page);
			if ($total<1)
				$total = 1;
			for ($i=1; $i<=$total; $i++)
				$ar[$i] = $total-$i+1;
			$page 	= $total;
		} else 
			$page 	= 1;
  		$yes  		= false;
  		if (isset($_GET['page'])) {
			if ($cms_nav_back == 1) {
				if (($_GET['page'] > 0) and ($_GET['page'] <= $total))
					$page	= (int)$Filtr->clear($_GET['page']);
			} else {
				if (($_GET['page'] > 0) and ($_GET['page'] <= ceil($count/$rec_page)))
					$page	= (int)$Filtr->clear($_GET['page']);
			}
  		}
		if ($cms_nav_back == 1)
			$page	= $ar[$page];
  		$mess_j 	= ($count-1)-(($page-1)*$rec_page);
  		$mess_i 	= $mess_j-$rec_page;
  		$mess_i_ 	= $mess_j-$rec_page;
  		$mess_all	= ceil($count/$rec_page);
  		for (; $mess_i<$mess_j && $mess_j>=0; $mess_j--) {
     			if ($mess_j==$position) 
        			$yes	= true;
  		}
  		return $yes;
	}
};

$Navigation = new Navigation;


class Loging
{	
	function referer()
	{
		global $_SERVER, $cms_site, $Filtr;
   		if (isset($_SERVER['HTTP_REFERER']))
   		{
      			if ($_SERVER['HTTP_REFERER']!="")
      			{
         			$return = $Filtr->clear($_SERVER['HTTP_REFERER']);
         			if (
            				(strstr($_SERVER['HTTP_REFERER'],"action"))
            				or
            				(strstr($_SERVER['HTTP_REFERER'],"pm"))
            				or
            				(strstr($_SERVER['HTTP_REFERER'],"getfile"))
            				or
            				(strstr($_SERVER['HTTP_REFERER'],"editprofile"))
            				or
            				(strstr($_SERVER['HTTP_REFERER'],"restore"))
            				or
            				(strstr($_SERVER['HTTP_REFERER'],"newuser"))
         			)
         			$return = $cms_site;
      			}
      			else
         			$return = $cms_site;
   		}
   		else
      			$return = $cms_site;
   		return $return;
	}
}

$Loging = new Loging;

class Mailing
{
	function toadmin($subject,$message)
	{
		global $cms_mail, $_SERVER, $lcms, $cms_send_mail;
		$to = $cms_mail;
		$headers = 'From: '.$cms_send_mail.' <'.$cms_send_mail.">\n";
		$headers .= 'Reply-To: '.$cms_send_mail."\n";
		$headers .= 'Return-Path: '.$cms_send_mail."\n";
		$headers .= "MIME-Version: 1.0\nContent-type: text/plain; charset=utf-8\nContent-Transfer-Encoding: 8bit\nDate: " . gmdate('D, d M Y H:i:s', time()) . " UT\nX-Priority: 3\nX-MSMail-Priority: Normal\nX-Mailer: PHP\n";
		mail ($to,$subject,str_replace("<br>","\n",$message),$headers);
	}
	
	function tousers($subject,$message,$to)
	{
		global $cms_active_mail,$cms_active_name,$_SERVER;
		$headers = 'From: '.$cms_active_name.' <'.$cms_active_mail.">\n";
		$headers .= 'Reply-To: '.$cms_active_mail."\n";
		$headers .= 'Return-Path: '.$cms_active_mail."\n";
		$headers .= "MIME-Version: 1.0\nContent-type: text/plain; charset=utf-8\nContent-Transfer-Encoding: 8bit\nDate: " . gmdate('D, d M Y H:i:s', time()) . " UT\nX-Priority: 3\nX-MSMail-Priority: Normal\nX-Mailer: PHP\n";
		mail ($to,$subject,$message,$headers);
	}
	
	function checkmail($mail)
	{
		return preg_match("/^([\w\.\-])+@([\w\.\-]+\\.)+[a-z]{2,4}$/i", $mail);
	}
}

$Mailing = new Mailing;
//Далее ужас в 2 ночи
if (
  		(!isset($_GET['viewpage']))
  		and
  		(isset($_GET['viewnews']))
)
{
  		foreach ($bfgfile as $bfgline)
  		{
  			$bfg	=	explode('|',$bfgline);
  			if ($bfg[0]==$Filtr->clear($_GET['viewnews']))
  			{
  				$_GET['viewpage']	=	$bfg[2];
  				break;
  			}
  		};
}

if (!isset($_GET['viewpage']))
	$_GET['viewpage']='index';
	
if ($_GET['viewpage']=='index.php') $_GET['viewpage']='index';
  
//Загрузка дополнений (functions.php)
$withfullpath	= (file_exists('conf/plugins.dat')) ? false : true;
if (!$withfullpath) {
	$pluginsfile = file("conf/plugins.dat");
	$pluginpath  = '';
} else {
	$pluginsfile = file($cms_root."/conf/plugins.dat");
	$pluginpath  = $cms_root.'/';
}
foreach ($pluginsfile as $plugline) {
        $plu_ = explode("|",$plugline);
        include($pluginpath.'includes/plugins/'.$plu_[0].'/functions.php');
};

//Для поиска
if (!isset($GlobalSearch))
	$GlobalSearch = -1;
function updatesearch() {
	global $GlobalSearch;
	if ($GlobalSearch!=-1)
		updatesearchdb();
}
//
