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


if ($action=="rss")
{
	header('Content-type: text/xml; charset=utf-8');

	echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<rss version=\"2.0\"
	xmlns:content=\"http://purl.org/rss/1.0/modules/content/\"
	xmlns:wfw=\"http://wellformedweb.org/CommentAPI/\"
	xmlns:dc=\"http://purl.org/dc/elements/1.1/\"
	xmlns:atom=\"http://www.w3.org/2005/Atom\"
	xmlns:sy=\"http://purl.org/rss/1.0/modules/syndication/\"
	xmlns:slash=\"http://purl.org/rss/1.0/modules/slash/\"
	>
<channel>
 <title>".$cms_rss_title."</title>
 <link>".$cms_site."</link>
 <atom:link href=\"".$cms_site."/rss\" rel=\"self\" type=\"application/rss+xml\" />";
	include($cms_root."/conf/rss.dat");
	if ($cms_rss_id=="")
	{
        	if (count($bfgfile)>0)
        	{
           		$bfg = explode("|",$bfgfile[0]);
           		$cms_rss_id = $bfg[0];
        	};
	};
	foreach ($bfgfile as $bf)
	{
    		$b = explode("|",$bf);
    		if ($cms_rss_id == $b[0]) echo " 
 <description>".$b[1]."</description>";
	};
	echo "
 <language>ru-ru</language>
 <generator>Ruxe Engine (ruxe-engine.ru)</generator>
 "; 
	echo "
 <lastBuildDate>".$rss_pub_date." ".$rss_gdd."</lastBuildDate> 
"; 
	$file = file($cms_root."/conf/".$cms_rss_id."/list.dat"); 
	$file = array_reverse($file); 
	$id = 0;
	$cc = -1;
	$addednews	=	0;
	if (count($file)>0)
	{ 
   		foreach ($file as $stroka)
   		{
			if ($addednews<$cms_rss_count)
			{
				$items = explode("|",$stroka);
				$items[3] = $GlobalTemplate->usebbcodes($items[3],'html');
				if (strstr($items[3],"[show_downloads="))
				{
					foreach ($pathsfile as $path)
					{
						$pat = explode("|",$path);
						$items[3] = preg_replace('|\[show_downloads='.$pat[0].'\]|Uis', get_downloads($pat[0]), $items[3]);
					};
				};
				$items[3] = str_replace(array('[urlsite]','[themepath]'),array($cms_site,$cms_site.'/themes/'.$cms_theme),$items[3]);
				$items[3] = $Filtr->clear($items[3]);
				if ($items[8] == "\r\n")
				{
					$original = $items[0];
					$or_dat = explode(",", $original);
					$or_dat2 = explode(".", $or_dat[0]);
					$new_dat = $or_dat2[0].".".$or_dat2[1].".20".$or_dat2[2];
					$new = strtotime($new_dat.",".$or_dat[1]);
					$items[8] = Date("D, d M Y H:i:s", $new);
				};
				$cc+=1;
				if ($items[9] != "Нет")
				{
					echo '
 <item>
  <title>'.$items[2].'</title>';
					if ($items[12]!='')
					{
						if ($cms_punycode==1)
						{
							require_once($cms_root.'/includes/idna_convert.class.php');
							$IDN = new idna_convert();
							$tmp = $IDN->encode($items[12]);
							$sv_tmp = htmlentities($tmp, null, 'UTF-8');
						}
						else
							$sv_tmp = $items[12];
						echo '
    <guid isPermaLink=\'true\'>'.$Navigation->furl('bfglink',$cms_rss_id,$items[6]).'</guid>  
    <link>'.$Navigation->furl('bfglink',$cms_rss_id,$items[6]).'</link>   
    ';
					}  
					else
						echo '
    <guid isPermaLink=\'true\'>'.$Navigation->furl('bfgfull',$cms_rss_id,$items[6]).'</guid>  
    <link>'.$Navigation->furl('bfgfull',$cms_rss_id,$items[6]).'</link>    
    ';
					echo '  <pubDate>'.$items[8].' '.$rss_gdd.'</pubDate>
  <description>
  '.$items[3].'
  </description>
 </item>';
					$id+=1;
				}; 
			};
			$addednews++;
 		}; 
	} 
	else 
	{
		echo "
 <item>
  <title>".$lcms['rss_nonews']."</title>
  <description></description>
  <link></link>
  <guid isPermaLink='true'></guid>
 </item>"; 
	}; 
	echo "
</channel>
</rss>";
	exit;
};

if ($action=="link")
{
	if ($cms_punycode==1)
	{
		require_once('includes/idna_convert.class.php');
		$IDN 	= new idna_convert();
	};
     	$id 	= $Filtr->clear($_GET['id']);
     	$new 	= $Filtr->clear($_GET['new']);
     	$bfg 	= file($cms_root."/conf/bfg.dat");
     	foreach ($bfg as $bf)
     	{
         	$b = explode("|",$bf);
         	if ($b[0]==$id)
         	{
              		$list = file($cms_root."/conf/".$b[0]."/list.dat");
              		foreach ($list as $lis)
              		{
                    		$l = explode("|",$lis);
                    		if ( ($l[6]==$new) && ($l[12]!="") )
                    		{
                         		if (!isset($_COOKIE['view'.$b[0].$l[6]]))
                         		{
                            			setcookie('view'.$b[0].$l[6], 'viewed', time() + 1209600,"/");
                            			$views = file($cms_root."/conf/".$b[0]."/views.dat");

									$newviews = fopen($cms_root . "/conf/" . $b[0] . "/views.dat", "cb");
									flock($newviews, LOCK_EX);
                                    ftruncate($newviews, 0);
									foreach ($views as $view) {
										$vie = explode("|", $view);
										if ($vie[0] == $new) $vie[1]++;
										fwrite($newviews, $vie[0] . "|" . $vie[1] . "|\r\n");
									};
									flock($newviews, LOCK_UN);
									fclose($newviews);
                         		};
					if ($cms_punycode==1)
					{
						$tmp = $IDN->encode($l[12]);
						$sv_tmp = htmlentities($tmp, null, 'UTF-8');
					}
					else
						$sv_tmp	=	$l[12];
                         		header("location: ".$sv_tmp);
                         		exit;
                    		};
              		};
         	};
     	};
};

if ($action=="gosite")
{
	if ($cms_punycode==1)
	{
		require_once('includes/idna_convert.class.php');
  
		$IDN = new idna_convert();
	};
     
     $url = str_replace("http://","",$_GET['url']);
     //$url	=	str_replace('/gosite/','',$_SERVER['REQUEST_URI']);
	if ($cms_furl==1)
		$t	=	(str_replace('action=gosite&url='.$url,'',$_SERVER['QUERY_STRING'])!='') ? '?'.str_replace('action=gosite&url='.$url.'&','',$_SERVER['QUERY_STRING']) : '';
	else
		$t	=	'';
     //die($url);
     $url	.=	$t;
     //die($url);
     $ur = explode("/",$url);
     if ($cms_punycode==1)
     {
	$tmp = $IDN->encode($ur[0]);
	$ur[0] = htmlentities($tmp, null, 'UTF-8');
     };
     $url = implode("/",$ur);
     
     header("location: http://".$url);
     exit;
};

if ($action=="go")
{
   	$get		=	$Filtr->clear($_GET['link']);
   	$sv_views	=	file($cms_root."/conf/count_links.dat");
   	$sv_found	=	0;
   	$sv_line	=	0;
    $new_view = fopen($cms_root . "/conf/count_links.dat", "cb");
    flock($new_view, LOCK_EX);
    ftruncate($new_view, 0);
    foreach ($sv_views as $sv_elemetns) {
        $sv_elemetn = trim($sv_elemetns);
        $programm = explode("=", $sv_elemetn);
        if ($programm[0] == $get) {
            $sv_tmp = $programm[1];
            $sv_found = 1;
            $sv_tmp++;
            fwrite($new_view, $get . "=" . $sv_tmp . "\r\n");
        } else {
            if ($programm[1] != "")
                fwrite($new_view, $sv_views[$sv_line]);
        };
        $sv_line++;
    };
    flock($new_view, LOCK_UN);
    fclose($new_view);
   	$sv_downloads	=	file($cms_root."/conf/links.dat");
   	$sv_found	=	0;
   	$sv_line	=	0;
   	foreach($sv_downloads as $sv_elemetns)
   	{
     		$sv_elemetn	=	trim($sv_elemetns);
     		$programm	=	explode("|",$sv_elemetn);
     		if ($programm[0] == $get)
     		{
          		$sv_tmp	=	$programm[1];
			if ($cms_punycode==1)
			{
				require_once('includes/idna_convert.class.php');
				$IDN 	= 	new idna_convert();
				$tmp 	= 	$IDN->encode($sv_tmp);
				$sv_tmp = 	htmlentities($tmp, null, 'UTF-8');
			};
          		header("location: ".$sv_tmp);
          		exit;
          		$sv_found	=	1;
          		$sv_tmp++;
     		};
     		$sv_line+=1;
   	};
};

if ($action=="new_message")
{
$GlobalComments->add((isset($_POST['ruxekod'])) ? $_POST['ruxekod'] : "", 
      (isset($_POST['ruxeimya'])) ? $Filtr->clear($_POST['ruxeimya']) : "", (isset($_POST['from'])) ? $Filtr->clear($_POST['from']) : "", 
      (isset($_POST['ruxemylo'])) ? $Filtr->clear($_POST['ruxemylo']) : "", 
      (isset($_POST['sname'])) ? $Filtr->clear($_POST['sname']) : "", (isset($_POST['id'])) ? $Filtr->clear($_POST['id']) : "", (isset($_POST['ruxesoobchenie'])) ? $_POST['ruxesoobchenie'] : "", "message");
};

if ($action=="tomail")
{
$GlobalComments->add((isset($_POST['ruxekod'])) ? $_POST['ruxekod'] : "", 
      (isset($_POST['ruxeimya'])) ? $Filtr->clear($_POST['ruxeimya']) : "", (isset($_POST['from'])) ? $Filtr->clear($_POST['from']) : "", 
      (isset($_POST['ruxemylo'])) ? $Filtr->clear($_POST['ruxemylo']) : "", 
      (isset($_POST['subject'])) ? $Filtr->clear($_POST['subject']) : "", "", (isset($_POST['ruxesoobchenie'])) ? $_POST['ruxesoobchenie'] : "", "tomail");
};

if ($action=="question")
{
$GlobalComments->add((isset($_POST['ruxekod'])) ? $_POST['ruxekod'] : "", 
      (isset($_POST['ruxeimya'])) ? $Filtr->clear($_POST['ruxeimya']) : "", (isset($_POST['from'])) ? $Filtr->clear($_POST['from']) : "", 
      (isset($_POST['ruxemylo'])) ? $Filtr->clear($_POST['ruxemylo']) : "", 
      "", "", (isset($_POST['ruxesoobchenie'])) ? $_POST['ruxesoobchenie'] : "", "question");
};

if ($action=="download")
{
   	//Проверка на ботов
   	$botfounded	= 	false;
	$sv_tmp		=	'';
	
   	$useragent  	= 	isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
   	if ($Robots->check($useragent))
   	{
		$botfounded 	= true;
		$ar 		= array("{TITLE}","{GENERATOR}","{URL}","{MESSAGE}","{READRESS}","{/READRESS}","{SITE}","{THEMEPATH}");
   		$br 		= array($lcms['botdownload_title'],"Ruxe Engine (ruxe-engine.ru)","",$lcms['botdownload_message'],"","",$cms_site,$cms_site."/themes/".$cms_theme);
   		$openpage 	= $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
   		$pagetitle 	= $lcms['botdownload_title'];
		//break;
		
	};

   	//
   	if (!$botfounded)
   	{
		$get	  =	$Filtr->clear($_GET['file']);
		$sv_views =	file($cms_root."/conf/downloads.dat");
		$sv_found =	0;
		$sv_line  =	0;
        $new_view = fopen($cms_root . "/conf/downloads.dat", "cb");
        flock($new_view, LOCK_EX);
        ftruncate($new_view, 0);
        foreach ($sv_views as $sv_elemetns) {
            $sv_elemetn = trim($sv_elemetns);
            $programm = explode("=", $sv_elemetn);
            if ($programm[0] == $get) {
                $sv_tmp = $programm[1];
                $sv_found = 1;
                $sv_tmp += 1;
                fwrite($new_view, $get . "=" . $sv_tmp . "\r\n");
            } else {
                if ($programm[1] != "")
                    fwrite($new_view, $sv_views[$sv_line]);
            };
            $sv_line += 1;
        };
        flock($new_view, LOCK_UN);
        fclose($new_view);
		$sv_downloads	=	file($cms_root."/conf/paths.dat");
		$sv_found	=	false;
		$sv_line	=	0;
		foreach($sv_downloads as $sv_elemetns)
		{
     			$sv_elemetn	=	trim($sv_elemetns);
     			$programm	=	explode("|",$sv_elemetn);
     			if ($programm[0] == $get)
     			{
          			$sv_tmp  = $programm[1];
          			$sv_name = $programm[2];
          			if ($cms_directdownload == 0)
          			{
					if ($cms_punycode==1)
					{
						require_once($cms_root.'/includes/idna_convert.class.php');
						$IDN = new idna_convert();
						$tmp = $IDN->encode($sv_tmp);
						$sv_tmp = htmlentities($tmp, null, 'UTF-8');
					};
            				header("location: ".$sv_tmp);
            				exit;
          			};
          			$sv_found=true;
          			break;
     			};
     			$sv_line+=1;
		};
		if ($sv_found)
		{
   			$ar = array("{TITLE}","{GENERATOR}","{URL}","{MESSAGE}","{READRESS}","{/READRESS}","{SITE}","{THEMEPATH}");
   			$br = array($lcms['download_title'].$sv_name,"Ruxe Engine (ruxe-engine.ru)",$sv_tmp,str_replace("{URL}",$sv_tmp,$lcms['download_text']),"","",$cms_site,$cms_site."/themes/".$cms_theme);
   			$pageredirect = $sv_tmp;
   			$openpage = $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
   			$pagetitle = $lcms['download_title'].$sv_name;
		}
		else
		{
   			$ar = array("{TITLE}","{GENERATOR}","{URL}","{MESSAGE}","{READRESS}","{/READRESS}","{SITE}","{THEMEPATH}");
   			$br = array($lcms['download_notfound'],"Ruxe Engine (ruxe-engine.ru)","",str_replace("{URL}","",$lcms['download_notfound_text']),"","",$cms_site,$cms_site."/themes/".$cms_theme);
   			$openpage = $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
   			$pagetitle = $lcms['download_notfound'];
		};
   	};
};

if ($action=="add_comment")
{
$GlobalComments->add((isset($_POST['ruxekod'])) ? $Filtr->clear($_POST['ruxekod']) : "", (isset($_POST['ruxeimya'])) ? $Filtr->clear($_POST['ruxeimya']) : "", 
   (isset($_POST['from'])) ? $Filtr->clear($_POST['from']) : "", (isset($_POST['ruxemylo'])) ? $Filtr->clear($_POST['ruxemylo']) : "", (isset($_POST['title_news'])) ? $Filtr->clear($_POST['title_news']) : "", 
   (isset($_POST['comment'])) ? $Filtr->clear($_POST['comment']) : "", (isset($_POST['ruxesoobchenie'])) ? $_POST['ruxesoobchenie'] : "", (isset($_POST['type'])) ? $Filtr->clear($_POST['type']) : "");
};

if ($action=="restore")
{
   	if (isset($_GET['step']))
   	{
   		if (!isset($_POST['mail']))
   			$_POST['mail'] = 'no';
       		$mail = str_replace("..","",str_replace("%","",$Filtr->clear($_POST['mail'])));
       		$found = false;
       		$last_restore = file($cms_root."/conf/last_restore.dat");
       		if ((time() - $last_restore[0]) < 900)
       		{
          		$ar = array("{TITLE}","{READRESS}","{GENERATOR}","{/READRESS}","{URL}","{MESSAGE}","{SITE}","{THEMEPATH}");
          		$br = array($lcms['restore_time_title'],"","Ruxe Engine (ruxe-engine.ru)","",$Navigation->furl('restorelink'),$lcms['restore_time_text'],$cms_site,$cms_site."/themes/".$cms_theme);
          		$openpage = $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
          		$pagetitle = $lcms['restore_time_title'];
       		}
       		else
       		{
          		if ($cms_restore==1)
          		{
             			foreach ($fileusers as $user)
             			{
                			$u = explode("|",$user);
                			if ($Filtr->tolower($u[2])==$Filtr->tolower($mail))
                			{
								$doStop = false;
								//Проверка на бан пользователя
								if ($u[4]=="baned") {
									$ar = array("{TITLE}","{READRESS}","{GENERATOR}","{/READRESS}","{URL}","{MESSAGE}","{SITE}","{THEMEPATH}");
									$br = array($lcms['ban_title'],"","Ruxe Engine (ruxe-engine.ru)","",$Navigation->furl('restorelink'),$lcms['baned_text'].$u[19],$cms_site,$cms_site."/themes/".$cms_theme);
									$openpage =  $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
									$pagetitle = $lcms['ban_title'];
									$doStop = true;
								}
								//
								$found = true;
								if (!$doStop) {
									$key = rand(1,999).rand(1,999);
									$usersfruits[15] = $key;
									$GlobalUsers->editpoles("mail",$mail);
									$file = fopen($cms_root."/conf/last_restore.dat","w");
									fwrite($file,time());
									fclose($file);
									$cr = array("{MAIL}","{SITE}","{KEY}");
									$dr = array($mail,$cms_site,$key);
									$message = str_replace($cr,$dr,$lcms['restore_post']);
									$Mailing->tousers($lcms['restore_1'],$message,$mail);
									$ar = array("{TITLE}","{READRESS}","{GENERATOR}","{/READRESS}","{URL}","{MESSAGE}","{SITE}","{THEMEPATH}");
									$br = array($lcms['restore_title'],"<!-- ","Ruxe Engine (ruxe-engine.ru)"," -->",$Navigation->furl('restorelink'),$lcms['restore_go'],$cms_site,$cms_site."/themes/".$cms_theme);
									$openpage= $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
									$pagetitle = $lcms['restore_title'];           
								}
								break;
                			};
             			};
             			if (!$found)
             			{
                   			$ar = array("{TITLE}","{READRESS}","{GENERATOR}","{/READRESS}","{URL}","{MESSAGE}","{SITE}","{THEMEPATH}");
                   			$br = array($lcms['user_ae_title'],"","Ruxe Engine (ruxe-engine.ru)","",$Navigation->furl('restorelink'),$lcms['restore_mail_notfound'],$cms_site,$cms_site."/themes/".$cms_theme);
                   			$openpage =  $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
                   			$pagetitle = $lcms['user_ae_title'];
             			};
          		}
          		else
          		{
            			$ar = array("{TITLE}","{READRESS}","{GENERATOR}","{/READRESS}","{URL}","{MESSAGE}","{SITE}","{THEMEPATH}");
            			$br = array($lcms['user_ae_title'],"","Ruxe Engine (ruxe-engine.ru)","",$Navigation->furl('restorelink'),$lcms['restore_off'],$cms_site,$cms_site."/themes/".$cms_theme);
            			$openpage =  $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
            			$pagetitle =  $lcms['user_ae_title'];
          		};
       		};  
   	}
   	else
   	{
       		if (isset($_GET['key']))
       		{
        		$key = (int) $_GET['key'];
        		$mail = $Filtr->tolower(str_replace("/","",str_replace("%","",$Filtr->clear($_GET['mail']))));
        		$founded = false;
        		foreach ($fileusers as $u)
        		{
         			$o = explode("|",$u);
         			if ($Filtr->tolower($o[2]) == $mail)
         			{
             				if ($o[15]==$key)
             				{
                  				if ($o[15]==0) 
                  				{
                    					die($lcms['error_395']);
                    					exit;
                  				};
                  				$login   = $o[18];
                  				$founded = true;
             				};
         			};
        		};
        		if ($founded)
        		{
         			$newpassword = substr(md5(rand(1,99999)),0,8);
         			$gen		=	$GlobalUsers->getpole($login,22);
         			$usersfruits[1] = md5(md5($newpassword).$gen);
         			$usersfruits[15] = '0';
         			$GlobalUsers->editpoles("mail",$mail); 
         			$cr = array("{LOGIN}","{SITE}","{PASSWORD}");
         			$dr = array($login,$cms_site,$newpassword);
         			$message = str_replace($cr,$dr,$lcms['new_post']);
         			$Mailing->tousers($lcms['restore_2'],$message,$mail);
         			$ar = array("{TITLE}","{GENERATOR}","{READRESS}","{/READRESS}","{MESSAGE}","{URL}","{SITE}","{THEMEPATH}");
         			$br = array($lcms['restore_title'],"Ruxe Engnine (ruxe-engine.ru)","<!-- "," -->",$lcms['restore_ok'],$cms_site,$cms_site,$cms_site."/themes/".$cms_theme);
         			$openpage =  $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
         			$pagetitle = $lcms['restore_title'];
      			}
      			else
      			{
         			die($lcms['error_477']);
      			};
       		}
       		else
       		{
        		$ar = array("{GENERATOR}","{SITE}","{THEMEPATH}","{RESTORESTEP2}");
			$link	=	$Navigation->furl('restorelink');
			if (strstr($link,'?'))
				$link.='&amp;step=2';
			else
				$link.='?step=2';
        		$br = array("Ruxe Engine (ruxe-engine.ru)",$cms_site,$cms_site."/themes/".$cms_theme,$link);
        		$openpage = $GlobalTemplate->users($ar,$br,5);
        		$pagetitle = $lcms['restore_title'];
       		};
   	};
};

if ($action=="rotator")
{
   	if (isset($_GET['go']))
   	{
		$counts = file($cms_root."/conf/rotator_count.dat");
		$rotators = file($cms_root."/conf/rotator.dat");
		$go = $Filtr->clear($_GET['go']);
		$new_count = array();
		$founded = false;
		foreach ($counts as $count)
		{
		    	$c = explode("=",$count);
		    	if ($c[0]==$go)
		    	{
                      		$founded = true;
                      		$c[1]++;
                    	};  
                    	$new_count[] = $c[0]."=".$c[1]."=";
		};
		if ($founded)
		{
            $file = fopen($cms_root . "/conf/rotator_count.dat", "cb");
            flock($file, LOCK_EX);
            ftruncate($file, 0);
            foreach ($new_count as $new)
                fwrite($file, $new . "\r\n");
            flock($file, LOCK_UN);
            fclose($file);
		};
		foreach ($rotators as $rotator)
		{
		    	$p = explode("|",$rotator);
		    	if ($go == $p[0])
		    	{
				if ($cms_punycode==1)
				{
					require_once('includes/idna_convert.class.php');
					$IDN = new idna_convert();
					$tmp = $IDN->encode($p[2]);
					$p[2] = htmlentities($tmp, null, 'UTF-8');
				};
		       		header("location: ".$p[2]);
		      	 	exit;
		    	};
		};
   	};
};

if ($action=="newuser")
{
if ($cms_registration==1) {
	if ($GlobalUsers->thisisuser()!=true) {
		if (isset($_GET['step'])) {
			$step      = (int)$_GET['step'];
			$errortext = $GlobalUsers->reg('site');
			if ($errortext==-1) {
				$ar 		= array("{TITLE}","{GENERATOR}","{URL}","{MESSAGE}","{READRESS}","{/READRESS}","{SITE}","{THEMEPATH}");
				$br 		= ($cms_active==1) ? array($lcms['user_ok_title'],"Ruxe Engine (ruxe-engine.ru)",$cms_site,$lcms['user_need_activate'],"<!-- "," -->",$cms_site."/themes/".$cms_theme) : array($lcms['user_ok_title'],"Ruxe Engine (ruxe-engine.ru)",$cms_site,$lcms['user_ok_message'],"<!-- "," -->",$cms_site."/themes/".$cms_theme);
				$openpage 	= $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
				$pagetitle	= $lcms['user_ok_title'];
			} else {
				$backlink	= $Navigation->furl('reglink');
				$login     = (isset($_POST['login'])) ? $Filtr->clear($_POST['login']) : "";
				$mail      = (isset($_POST['mail'])) ? $Filtr->tolower($Filtr->clear($_POST['mail'])) : "";
				$smail     = (isset($_POST['smail'])) ? $Filtr->tolower($Filtr->clear($_POST['smail'])) : "";
				if (strstr($backlink,'?'))
					$backlink.= '&amp;';
				else
					$backlink.= '?';
				$ar 		= array("{TITLE}","{GENERATOR}","{URL}","{MESSAGE}","{READRESS}","{/READRESS}","{SITE}","{THEMEPATH}");
				$br 		= array($lcms['user_error_title'],"Ruxe Engine (ruxe-engine.ru)",$cms_site,$errortext."<center><a href=\"".$backlink."rand=".rand(1,9999)."&amp;login=".$login."&amp;smail=".$smail."&amp;mail=".$mail.
							"\">".$lcms['error_back']."</a></center>","","",$cms_site,$cms_site."/themes/".$cms_theme);
				$openpage 	= $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
				$pagetitle	= $lcms['user_error_title']; 
			}; 
		} else {
			if (isset($_GET['login'])) {$login=$Filtr->clear($_GET['login']);} else $login="";
			if (isset($_GET['password'])) {$password=$Filtr->clear($_GET['password']);} else $password="";
			if (isset($_GET['spassword'])) {$spassword=$Filtr->clear($_GET['spassword']);} else $spassword="";
			if (isset($_GET['mail'])) {$mail=$Filtr->clear($_GET['mail']);} else $mail = "";
			if (isset($_GET['smail'])) {$smail=$Filtr->clear($_GET['smail']);} else $smail = "";
			$ar = array("{SITE}","{GENERATOR}","{LOGIN}","{PASSWORD}","{SPASSWORD}","{MAIL}",
				"{SMAIL}","{SECURITY}","{THEMEPATH}","{REGSTEP2}");
			$reglink	=	$Navigation->furl('reglink');
			if (strstr($reglink,'?'))
				$reglink.='&amp;step=2';
			else
				$reglink.='?step=2';
			$br = array($cms_site,"Ruxe Engine (ruxe-engine.ru)",$login,$password,$spassword,$mail,$smail,$cms_site."/captcha/?".session_name()."=".session_id(),$cms_site."/themes/".$cms_theme,$reglink);
			$openpage = $GlobalTemplate->users($ar,$br,3);
			$pagetitle = $lcms['registerform_title'];
		};
   	} else {
   		$ar = array("{TITLE}","{GENERATOR}","{URL}","{MESSAGE}","{READRESS}","{/READRESS}","{SITE}","{THEMEPATH}");
      		$br = array($lcms['user_error_title'],"Ruxe Engine (ruxe-engine.ru)",$cms_site,
      		'Действие недоступно активным пользователям.',"","",$cms_site,$cms_site."/themes/".$cms_theme);
      		$openpage = $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
      		$pagetitle=$lcms['user_error_title']; 
   	};
} else {
	$ar = array("{TITLE}","{GENERATOR}","{URL}","{MESSAGE}","{READRESS}","{/READRESS}","{SITE}","{THEMEPATH}");
      	$br = array($lcms['user_error_title'],"Ruxe Engine (ruxe-engine.ru)",$cms_site,
      		$lcms['regclosed'],"","",$cms_site,$cms_site."/themes/".$cms_theme);
      	$openpage = $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
      	$pagetitle=$lcms['user_error_title'];
}
};

if ($action=="activate")
{
   	if (isset($_GET['key']))
   	{
      		$key = (int) $_GET['key'];
      		$user = $Filtr->clear($_GET['user']);
      		$founded = false;
      		$stop_down = false;
      		foreach ($fileusers as $u)
     	 	{
         		$o = explode("|",$u);
         		if ($Filtr->tolower($o[18]) == $Filtr->tolower($user))
         		{
             			if ($o[15]==$key)
             			{
                  			if (($o[4]!="active") or ($o[15]==0)) 
                  			{
                    				$ar = array("{TITLE}","{GENERATOR}","{READRESS}","{/READRESS}","{MESSAGE}","{URL}","{SITE}","{THEMEPATH}");
                    				$br = array($lcms['user_error_title'],"Ruxe Engnine (ruxe-engine.ru)","","",$lcms['user_already'],$cms_site,$cms_site,$cms_site."/themes/".$cms_theme);
                    				$openpage = $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
                    				$pagetitle = $lcms['user_error_title'];
                    				$stop_down = true;
                  			};
                  			$founded = true;
             			};
         		};
      		};
      		if ($founded)
      		{
        		if (!$stop_down)
        		{
         			$usersfruits[4] = 'user';
         			$usersfruits[15] = 0;
         			$GlobalUsers->editpoles("user",$user); 			
         			$ar = array("{TITLE}","{GENERATOR}","{READRESS}","{/READRESS}","{MESSAGE}","{URL}","{SITE}","{THEMEPATH}");
         			$br = array($lcms['user_ok_title'],"Ruxe Engnine (ruxe-engine.ru)","","",$lcms['user_ok_activate'],$cms_site,$cms_site,$cms_site."/themes/".$cms_theme);
         			$openpage = $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
         			$pagetitle = $lcms['user_ok_title'];
        		};
      		}
      		else
         		die($lcms['error_477']);
   	}
   	else
       		die($lcms['error_649']);
};

if ($action=="pm")
{
  	if ($GlobalUsers->thisisuser())
  	{  
    		if (isset($_GET['do']))
        		$do = $Filtr->clear($_GET['do']);
    		else
        		$do = "inbox";
    		if ($do=="") 
    			$do = "inbox";
    		$fnderr = false;
    		$t         = $GlobalUsers->pmpath($GlobalUsers->getid($_COOKIE['site_login']));
    		$pagetitle = $lcms['pm_title'];
    		$inbox     = 0;
    		$notread   = 0;
    		$outbox    = 0;
    		if (file_exists($t))
    		{
       			$pmfile = file($t);
       
       			foreach ($pmfile as $pmline)
       			{
           			$pml = explode("|",$pmline);
           			if ($pml[0]=="inbox")
           			{
              				$inbox++;
              				if ($pml[1]=="false")
                 				$notread++;
           			};
           			if ($pml[0]=="outbox")
              				$outbox++;
       			};
      			if ($notread>0) $pagetitle = $lcms['pm_title'].' - '.$Filtr->truecount($notread,$lcms['pm_notread_one'],$lcms['pm_notread_much'],$lcms['pm_notread_much2']);
    		}
    		else
    			$pmfile	=	array();
    
    		$list = "";
    		switch ($do)
    		{
        		case "inbox":
             			$pre  = array();
             			if (($inbox+$notread)!=0)
             			{
                			$z = 0;
                			foreach ($pmfile as $pmline)
                			{
                        			$pml = explode("|",$pmline);
                        			if ($pml[0]=="inbox")
                        			{
                                             		($pml[1]=="false")? $fw = "bold" : $fw = "normal"; 
                                             		$pre[] ="<tr><td>".$Filtr->fulldate($pml[3])."</td><td><a style=\"font-weight:".$fw.";\" href=\"".$Navigation->furl('pmshow',$z)."\">".$pml[4]."</a></td><td><a href=\"".$Navigation->furl('viewprofile',$pml[2])."\">".$pml[2]."</a></td><td><a href=\"".$Navigation->furl('pmdelete','inbox',$z)."\">".$lcms['pm_delete']."</a></td></tr>\r\n";
                        			};
                        			$z++;
                			};
             			}
             			else
                        		$pre[] = "<tr><td align=\"center\" colspan=4><b>".$lcms['pm_cleared_inbox']."</b></td></tr>";
             			$pre    = array_reverse($pre);
             			$ones   = "";
             			$i      = count($pre)-1;
             
             			foreach ($pre as $p)
             			{
                        		if ($Navigation->ShowPage(count($pre),$i,$cms_nav_pm)) $ones .= $p;
                        		$i--;
             			};
             
             			if (count($pre)>$cms_nav_pm)
             				$ones.='<tr><td colspan=4 align="center">'.$Navigation->Pager(count($pre),($cms_furl==1) ? '&amp;rand='.rand(1,999) : '&amp;action=pm&amp;do=inbox&amp;rand='.rand(1,999),$cms_nav_pm).'</td></tr>';
             
             			$list = $GlobalTemplate->users(array("{LIST}","{BYORTO}","{DELETEALLLINK}"),array($ones,$lcms['pm_by'],"if (confirm('Вы уверены? Это действие нельзя будет отменить.')) location.href='".$Navigation->furl('pmdeleteall','inbox')."'; return false;"),10);
             
             			break;
        		case "outbox":
             			if (($outbox)!=0)
             			{
                			$z = 0;
                			$pre = array();
                			foreach ($pmfile as $pmline)
                			{
                        			$pml = explode("|",$pmline);
                        			$addd = "";
                        			if ($pml[7]=="notread") $addd=' ('.$lcms['pm_not_read'].')';
                        			if ($pml[7]=="deleted") $addd=' ('.str_replace("{USER}",$pml[2],$lcms['pm_delete_not_read']).')';
                        			if ($pml[0]=="outbox")
                                             		$pre[]="<tr><td>".$Filtr->fulldate($pml[3])."</td><td><a style=\"font-weight:normal;\" href=\"".$Navigation->furl('pmshow',$z)."&amp;from=outbox\">".$pml[4]."</a>".$addd."</td><td><a href=\"".$Navigation->furl('viewprofile',$pml[2])."\">".$pml[2]."</a></td><td><a href=\"".$Navigation->furl('pmdelete','outbox',$z)."\">".$lcms['pm_delete']."</a></td></tr>\r\n";
                        			$z++;
                			};
             			}
             			else
                        		$pre[] = "<tr><td align=\"center\" colspan=4><b>".$lcms['pm_cleared_outbox']."</b></td></tr>";
            			$pre = array_reverse($pre);
             			$ones = "";
             			$i      = count($pre)-1;
             			foreach ($pre as $p)
             			{
                        		if ($Navigation->ShowPage(count($pre),$i,$cms_nav_pm)) $ones .= $p;
                        		$i--;
             			};
             
             			if (count($pre)>$cms_nav_pm)
             				$ones.='<tr><td colspan=4 align="center">'.$Navigation->Pager(count($pre),($cms_furl==1) ? '&amp;rand='.rand(1,999) : '&amp;action=pm&amp;do=outbox&amp;rand='.rand(1,999),$cms_nav_pm).'</td></tr>';
             
             			$list = $GlobalTemplate->users(array("{LIST}","{BYORTO}","{DELETEALLLINK}"),array($ones,$lcms['pm_to'],"if (confirm('Вы уверены? Это действие нельзя будет отменить.')) location.href='".$Navigation->furl('pmdeleteall','outbox')."'; return false;"),10);
             			break;
        		case "new":
             			$critical  = $cms_pm_max;
             
             			if (isset($pmfile))
             			{
                			if (count($pmfile)>$critical)
                			{
                    				$fnderr    = true;
                    				$pmlink		=	$Navigation->furl('pmlink');
						if (strstr($pmlink,'?'))
							$pmlink.='&amp;';
						else
							$pmlink.='?';
						$aar          = array("{TITLE}","{GENERATOR}","{READRESS}","{/READRESS}","{MESSAGE}","{URL}","{SITE}","{THEMEPATH}");
                    				$abr          = array($lcms['pm_title_error'],"Ruxe Engine (ruxe-engine.ru)","","",$lcms['pm_critical'],$pmlink."rand=".rand(1,999),$cms_site,$cms_site."/themes/".$cms_theme);
                    				$openpage     = $GlobalTemplate->template($aar,$abr,$cms_root."/themes/".$cms_theme."/message.html");
                    				$pagetitle    = $lcms['pm_title_error'];
                			};
             			};
             
             			if ($fnderr!=true)
                 			$list = $GlobalTemplate->commentform("pmnew","","","");
             			break;
        		case "send":
             			if (isset($_POST['submit']))
             			{
                 			$theme = (isset($_POST['theme'])) ? $Filtr->clear($_POST['theme']) : "";
                 			$to    = (isset($_POST['to'])) ? $Filtr->clear($_POST['to']) : "no";
                 			$message = (isset($_POST['ruxesoobchenie'])) ? $_POST['ruxesoobchenie'] : "";
                 			$message = str_replace("|","",$message);
                 			$message = $Filtr->textmax($message,$cms_max_message);
                 			$message = $Filtr->clear($message);
                 			$message = str_replace("\r\n","<br>",$message);
					$pmlink		=	$Navigation->furl('pmlink');
					if (strstr($pmlink,'?'))
						$pmlink.='&amp;';
					else
						$pmlink.='?';
                 			$isuser	=	($GlobalUsers->finduser($to,false,'',true)==-1) ? false : true;
                 			if (
						($theme == "")
						or
						(preg_match('/^[ ]+$/u', $theme))
					)
						$theme = "Нет темы";
                 			if (!$isuser)
                 			{
                    				$fnderr    = true;
						
                    				$aar          = array("{TITLE}","{GENERATOR}","{READRESS}","{/READRESS}","{MESSAGE}","{URL}","{SITE}","{THEMEPATH}");
                    				$abr          = array($lcms['pm_title_error'],"Ruxe Engine (ruxe-engine.ru)","","",$lcms['user_notfound_text'].'<center><a href="'.$Navigation->furl('pmnewmessage',$message).'">'.$lcms['error_back'].'</a></center>',$pmlink."rand=".rand(1,999),$cms_site,$cms_site."/themes/".$cms_theme);
                    				$openpage     = $GlobalTemplate->template($aar,$abr,$cms_root."/themes/".$cms_theme."/message.html");
                    				$pagetitle    = $lcms['pm_title_error'];
                 			}
                 			else
                 			{
                    				if ($message == "")
                    				{
                       					$ar = array("{TITLE}","{GENERATOR}","{READRESS}","{/READRESS}","{MESSAGE}","{URL}","{SITE}","{THEMEPATH}");
                       					$br = array($lcms['pm_title_error'],"Ruxe Engine (ruxe-engine.ru)","","",$lcms['error_message'].'<center><a href="'.$Navigation->furl('pmnewmessage',$message).'">'.$lcms['error_back'].'</a></center>',$pmlink."rand=".rand(1,999),$cms_site,$cms_site."/themes/".$cms_theme);
                       					$openpage     = $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
                       					$pagetitle    = $lcms['pm_title_error'];
                       					$fnderr = true;
                    				}
                    				else
                    				{
                       					if ((time() - $GlobalUsers->thisusertime()) < $cms_noflood)
                       					{ 
                          					$ar = array("{TITLE}","{GENERATOR}","{READRESS}","{/READRESS}","{MESSAGE}","{URL}","{SITE}","{THEMEPATH}");
                          					$br = array($lcms['pm_title_error'],"Ruxe Engine (ruxe-engine.ru)","","",$lcms['user_addnoflood'].'<center><a href="'.$Navigation->furl('pmnewmessage',$message).'">'.$lcms['error_back'].'</a></center>',$pmlink."rand=".rand(1,999),$cms_site,$cms_site."/themes/".$cms_theme);
                          					$openpage     = $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
                          					$pagetitle    = $lcms['pm_title_error'];
                          					$fnderr = true;
                       					}
                       					else
                       					{
                       						$to	=	$GlobalUsers->fullname($to);
                            					$date     = date("d.m.y, H:i");
                            					$ip       = $Filtr->clear($_SERVER['REMOTE_ADDR']);
                            					$path     = $GlobalUsers->pmpath($GlobalUsers->getid($to));
                            					if (!file_exists($path))
                            					{    
                                 					$nf   = fopen($path,"w");
                                 					fwrite($nf,"");
                                 					fclose($nf);
                                 					chmod($path,0777);
                            					};
                            					if (!file_exists($GlobalUsers->pmpath($GlobalUsers->getid($_COOKIE['site_login']))))
                            					{    
                                 					$nf   = fopen($GlobalUsers->pmpath($GlobalUsers->getid($_COOKIE['site_login'])),"w");
                                 					fwrite($nf,"");
                                 					fclose($nf);
                                 					chmod($GlobalUsers->pmpath($GlobalUsers->getid($_COOKIE['site_login'])),0777);
                            					};
                            					$nf       = fopen($path,"a");
                            					fputs($nf,"inbox|false|".$Filtr->clear($_COOKIE['site_login'])."|".$date."|".$theme."|".$ip."|".$message."|\r\n");
                            					fclose($nf);
                            					$nf       = fopen($t,"a");
                            					fputs($nf,"outbox||".$to."|".$date."|".$theme."|".$ip."|".$message."|notread|\r\n");
                            					fclose($nf);
                            
                           					$critical = $cms_pm_max + 75;
                            					$acn      = file($path);
                            					if (count($acn)>$critical)
                            					{
                                					$ncn  = fopen($path,"w");
                                					$g    = count($acn);
                                					foreach ($acn as $ac)
                                					{
                                      						if ($g+20<$critical)
                                         						fwrite($ncn,$ac);
                                      						else
                                      						{
                                         						$a = explode("|",$ac);
                                         						if (($a[0]=="inbox")&&($a[1]=="false"))
                                            						$GlobalUsers->DeletePMButNotRead($ac,$to);
                                      						};
                                      						$g--;
                                					};
                                					fclose($ncn);
                            					};
                            					$acn      = file($t);
                            					if (count($acn)>$critical)
                            					{
                                					$ncn  = fopen($path,"w");
                                					$g    = count($acn);
                                					foreach ($acn as $ac)
                                					{
                                      						if ($g<$critical+20)
                                         						fwrite($ncn,$ac);
                                      						$g--;
                                					};
                                					fclose($ncn);
                            					};
                            
                            					$usersfruits[13] = time();
                            					$GlobalUsers->editpoles("user",$Filtr->clear($_COOKIE['site_login']));
                            					header("location: ".$Navigation->furl('pmoutbox'));
                       					};  
                    				};
                 			};   
             			};
             			break;
        		case "show":
             			(isset($_GET['line'])) ? $line = (int)$_GET['line'] : $line = -1;
				if ($line>count($pmfile)-1) $line=-1;
				if ($line<-1) $line=-1;
             			if ($line!=-1)
             			{
                			$x       = explode("|",$pmfile[$line]);
                			if (($notread>0) and ($x[0]=="inbox")) $notread--;
                			$list    = $GlobalTemplate->users("{THEME}",$x[4],11);
                			($x[0]=="inbox") ? $message = array($x[3]."|".$x[2]."||".$x[6]."||".$x[5]."|yes|") : $message = array($x[3]."|".$Filtr->clear($_COOKIE['site_login'])."||".$x[6]."||".$x[5]."|yes|");
                			$list   .= $GlobalComments->show($message,count($message)-1);
                			if ($x[0]=="inbox") 
                			{
                    				if (count($pmfile)>$cms_pm_max)                    
                      					$list .= "<br>".$lcms['pm_critical'];
                    				else
                    				{
                      					if (substr($x[4],0,3)=="Re:")
                            					$x[4] = str_replace("Re: ","Re[1]: ",$x[4]);

                      					if (substr($x[4],0,3)=="Re[")
                      					{
                           					$l    = preg_replace('|Re\[(.*)\]:(.*)|Uis', "\${1}", $x[4])+1;
								
                           					$r    = "Re[".$l."]: ".preg_replace('|Re\[(.*)\]:(.*)|Uis', "\${2}", $x[4]);
								
                           					$x[4] = $r;
                      					}
                      					else
                           					$x[4] = "Re: ".$x[4];
                      					$list .= $GlobalTemplate->users("{REPLYFORM}",$GlobalTemplate->commentform("pm",$x[4],$x[2],""),12);
                    				};
                			};
                			if ($x[2]!="true")
                			{
                   				$newpm   = fopen($t,"w");
                   				$y       = 0;
                   				foreach ($pmfile as $pmline)
                   				{	
                     					$w  = explode("|",$pmline);
                     					if ($y==$line)
                     					{
                       						if ($w[0]=="inbox")
                        						fwrite($newpm, $w[0]."|true|".$w[2]."|".$w[3]."|".$w[4]."|".$w[5]."|".$w[6]."|\r\n");
                       						else
                        						fwrite($newpm, $w[0]."|true|".$w[2]."|".$w[3]."|".$w[4]."|".$w[5]."|".$w[6]."|".$w[7]."|\r\n");
                       						$GlobalUsers->ReadedPM($pmline,$_COOKIE['site_login']);
                     					}
                     					else
                      						fwrite($newpm, $pmline);
                     					$y++;
                   				};
                   				fclose($newpm);
                			};
             			};
             			break;
        		case "delete":
             			(isset($_GET['line'])) ? $line = (int)$_GET['line'] : $line = -1;
             			if ($line!=-1)
             			{
                			$z = 0;
                			$newpmfile = fopen($t,"w");
                			foreach ($pmfile as $pmline)
                			{
                   	 			if ($z!=$line) fwrite($newpmfile,$pmline);
                    				else
                    				{
                                         		$a = explode("|",$pmline);
                                         		if (($a[0]=="inbox")&&($a[1]=="false"))
                                            			$GlobalUsers->DeletePMButNotRead($pmline,$_COOKIE['site_login']);
                    				};
                    				$z++;
                			};
                			fclose($newpmfile);
                			(isset($_GET['from'])) ? $from = $Filtr->clear($_GET['from']) : $from = "inbox";
                			header("location: ".str_replace('&amp;','&',$Navigation->furl('pmlinkrand',$from)));
             			};
             			break;
        		case "deleteall":
             			(isset($_GET['from'])) ? $from = $_GET['from'] : $from = "no";
            			if ($from!="no")
             			{
                			$newpmfile = fopen($t,"w");
                			foreach ($pmfile as $pmline)
                			{
                                         	$a = explode("|",$pmline);
                                         	if ($a[0]!=$from) fwrite($newpmfile,$pmline);
                                         	if (($a[0]=="inbox")&&($a[1]=="false"))
                                            		$GlobalUsers->DeletePMButNotRead($pmline,$_COOKIE['site_login']);
                			};
                			fclose($newpmfile);
                			header("location: ".str_replace('&amp;','&',$Navigation->furl('pmlinkrand',$from)));
             			};
             			break;
    		};
    		$z         = ($notread>0) ? ',<b>+'.$notread.'</b>' : '';
    		$inbox     = $inbox-$notread;
    		switch ($do)
    		{
        		case "inbox":
             			$menu      = $GlobalTemplate->users(
                                           array('{LINK}','{CAPTION}'),
                                           array($Navigation->furl('pmlinkrand','new'),$lcms['pm_new']),
                                           13).' |
                           		'.$lcms['pm_inbox'].' ('.$inbox.$z.') | '.$GlobalTemplate->users(
                                           array('{LINK}','{CAPTION}'),
                                           array($Navigation->furl('pmlinkrand','outbox'),$lcms['pm_outbox'].' ('.$outbox.')'),
                                           13);
             			break;
        		case "outbox":
             			$menu      = $GlobalTemplate->users(
                                           array('{LINK}','{CAPTION}'),
                                           array($Navigation->furl('pmlinkrand','new'),$lcms['pm_new']),
                                           13).' | '.$GlobalTemplate->users(
                                           array('{LINK}','{CAPTION}'),
                                           array($Navigation->furl('pmlinkrand','inbox'),$lcms['pm_inbox'].' ('.$inbox.$z.')'),
                                           13).' | '.$lcms['pm_outbox'].' ('.$outbox.')';
             			break;
        		case "new": 
             			$menu      = $lcms['pm_new'].' | '.$GlobalTemplate->users(
                                           array('{LINK}','{CAPTION}'),
                                           array($Navigation->furl('pmlinkrand','inbox'),$lcms['pm_inbox'].' ('.$inbox.$z.')'),
                                           13).' | '.$GlobalTemplate->users(
                                           array('{LINK}','{CAPTION}'),
                                           array($Navigation->furl('pmlinkrand','outbox'),$lcms['pm_outbox'].' ('.$outbox.')'),
                                           13);
             			break;
        		default:
             			$menu      = $GlobalTemplate->users(
                                           array('{LINK}','{CAPTION}'),
                                           array($Navigation->furl('pmlinkrand','new'),$lcms['pm_new']),
                                           13).' | '.$GlobalTemplate->users(
                                           array('{LINK}','{CAPTION}'),
                                           array($Navigation->furl('pmlinkrand','inbox'),$lcms['pm_inbox'].' ('.$inbox.$z.')'),
                                           13).' | '.$GlobalTemplate->users(
                                           array('{LINK}','{CAPTION}'),
                                           array($Navigation->furl('pmlinkrand','outbox'),$lcms['pm_outbox'].' ('.$outbox.')'),
                                           13);
    		};
    		$ar        = array("{MENU}","{LIST}","{THEMEPATH}","{SITE}");
    		$br        = array($menu,$list);
    		if (!$fnderr) 
    			$openpage  = $GlobalTemplate->users($ar,$br,9);
  	}
  	else
  	{
    		$pagetitle = $lcms['pm_title_error'];
    		$ar = array("{TITLE}","{GENERATOR}","{URL}","{MESSAGE}","{READRESS}","{/READRESS}","{SITE}");
    		$br = array($lcms['pm_title_error'],"Ruxe Engine (ruxe-engine.ru)",$cms_site,$lcms['pm_title_error_text'],"<!-- "," -->",$cms_site);
    		echo str_replace($ar,$br,$retpldef);
    		exit;
  	};
};

if ($action=="login")
{
   if (isset($_POST['submit']))
   {
     	if (isset($_POST['login']))
     		$login = $Filtr->clear($_POST['login']);
     	if (isset($_POST['password']))
     		$password = $Filtr->clear($_POST['password']);
     	$founded = false;
     	$avatar = "noavatar.png";
     	$tmppos	=	$GlobalUsers->finduser($login,false,'',true);
     	if ($tmppos!=-1)
     	{
     		$tmpres	=	explode('|',$fileusers[$tmppos]);
     		if ($tmpres[23]!='yes')
     		{
     			//Создать новый пароль с солью на основе старого
     			$gen			=	$Filtr->randwords(12);
     			$pos			=	$GlobalUsers->finduser($login,true,md5($password),true);
     			if ($pos!=-1)
     			{
     				$usersfruits[23]	=	'yes';
     				$usersfruits[22]	=	$gen;
     				$usersfruits[1]		=	md5(md5($password).$gen);
     				$GlobalUsers->editpoles('user',$tmpres[18]);
     				$newpass		=	md5(md5($password).$gen);
     			};
     		}
     		else
     		{
     			$newpass=	md5(md5($password).$tmpres[22]);     		
     			$pos	=	$GlobalUsers->finduser($login,true,$newpass,true);
     		};
     	}
     	else
     		$pos	=	-1;
     	if ($pos!=-1)
     	{
     		$tmp	=	explode('|',$fileusers[$pos]);
     		$avatar	=	$tmp[16];
     		$login	=	$tmp[18];
     		$founded=	true;
     	};
     	$back = $Loging->referer();
     	if ($founded) 
     	{
       		if (isset($_POST['save']))
       		{
         		setcookie("site_login", $login, time() + 1209600,"/");
         		setcookie("site_password", $newpass, time() + 1209600,"/");
         		setcookie("site_avatar", $avatar, time() + 1209600,"/");
       		}
       		else
       		{
         		setcookie("site_login", $login, time() + $cms_time_cookie,"/");
         		setcookie("site_password", $newpass, time() + $cms_time_cookie,"/");
         		setcookie("site_avatar", $avatar, time() + $cms_time_cookie,"/");
       		};
       		$ar = array("{TITLE}","{GENERATOR}","{URL}","{MESSAGE}","{READRESS}","{/READRESS}","{SITE}","{THEMEPATH}");
       		$br = array($lcms['ok_enter_title'],"Ruxe Engine (ruxe-engine.ru)",$back,$lcms['ok_enter'].$login.$lcms['ok_enter_end'].$lcms['refer1']." <a href=\"".$back."\">".$lcms['refer2']."</a>".$lcms['refer3'],"","",$cms_site,$cms_site."/themes/".$cms_theme);
       		$openpage = $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
       		$pageredirect = $back;
       		$pagetitle = $lcms['ok_enter_title'];
     	}
     	else
     	{
       		$ar = array("{TITLE}","{GENERATOR}","{URL}","{MESSAGE}","{READRESS}","{/READRESS}","{SITE}","{THEMEPATH}");
       		$br = array($lcms['user_error_title'],"Ruxe Engine (ruxe-engine.ru)",$back,$lcms['user_notvalid'],"","",$cms_site,$cms_site."/themes/".$cms_theme);
       		$openpage = $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
       		$pagetitle = $lcms['user_error_title'];
     	};
   };
};

if ($action=="logout")
{
  setcookie("site_login", "no", time() + $cms_time_cookie,"/");
  setcookie("site_password", "no", time() + $cms_time_cookie,"/");
  $back = $Loging->referer();
  $ar = array("{TITLE}","{GENERATOR}","{URL}","{MESSAGE}","{READRESS}","{/READRESS}","{SITE}","{THEMEPATH}");
  $br = array($lcms['ok_logout_title'],"Ruxe Engine (ruxe-engine.ru)",$back,$lcms['ok_logout'].$lcms['refer1']." <a href=\"".$back."\">".$lcms['refer2']."</a>".$lcms['refer3'],"","",$cms_site,$cms_site."/themes/".$cms_theme);
  $openpage = $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
  $pageredirect = $back;
  $pagetitle = $lcms['ok_logout_title'];
};

if ($action=="profile")
{
  	if (isset($_GET['user']))
  	{
    		$user = $Filtr->clear($_GET['user']);
    		$pos	=	$GlobalUsers->finduser($user,false,'',true);
    		if ($pos!=-1)
    		{
       			$pieces = explode("|",$fileusers[$pos]);
       			$user	=	$pieces[18];
       			include($cms_root."/conf/users/config.dat");
       			if (($pole[1]==true) && ($pieces[5]!="")){$pole1 = ""; $pole1c = "";} else {$pole1 = "<!-- "; $pole1c = " -->";};
       			if (($pole[2]==true) && ($pieces[6]!="")){$pole2 = ""; $pole2c = "";} else {$pole2 = "<!-- "; $pole2c = " -->";};
       			if (($pole[3]==true) && ($pieces[7]!="")){$pole3 = ""; $pole3c = "";} else {$pole3 = "<!-- "; $pole3c = " -->";};

       			if (($pole[4]==true) && ($pieces[8]!="")){$pole4 = ""; $pole4c = "";} else {$pole4 = "<!-- "; $pole4c = " -->";};
       			if (($pole[5]==true) && ($pieces[9]!="")){$pole5 = ""; $pole5c = "";} else {$pole5 = "<!-- "; $pole5c = " -->";};
       			if (($pole[6]==true) && ($pieces[10]!="")){$pole6 = ""; $pole6c = "";} else {$pole6 = "<!-- "; $pole6c = " -->";};
       			if (($pole[7]==true) && ($pieces[11]!="")){$pole7 = ""; $pole7c = "";} else {$pole7 = "<!-- "; $pole7c = " -->";};
       			if ($pieces[3]=="")  {$about1 = "<!-- "; $about2 = " -->";} else {$about1 = ""; $about2= "";};
       			$ar = array("{NAME}","{GENERATOR}",
       				"{POLE1}","{POLECAPTION1}","{POLE1RESULT}","{/POLE1}",
       				"{POLE2}","{POLECAPTION2}","{POLE2RESULT}","{/POLE2}",
       				"{POLE3}","{POLECAPTION3}","{POLE3RESULT}","{/POLE3}",
       				"{POLE4}","{POLECAPTION4}","{POLE4RESULT}","{/POLE4}",
       				"{POLE5}","{POLECAPTION5}","{POLE5RESULT}","{/POLE5}",
       				"{POLE6}","{POLECAPTION6}","{POLE6RESULT}","{/POLE6}",
       				"{POLE7}","{POLECAPTION7}","{POLE7RESULT}","{/POLE7}",
       				"{ABOUTUSER}","{STATUS}","{CM}",
       				"{AVATAR}","{SITE}","{THEMEPATH}","{ABOUT}","{/ABOUT}",
       				"{REGDATE}","{PMNEW}");
       
       			switch($pieces[4])
       			{
           			case "admin":
                			$status = $lcms['user_status_admin'];
                			break;
           			case "superuser":
                			$status = $lcms['user_status_superuser'];
                			break;
           			case "user":
                			$status = $lcms['user_status_user'];
                			break;
           			case "editor":
                			$status = $lcms['user_status_editor'];
                			break;
           			case "moderator":
                			$status = $lcms['user_status_moderator'];
                			break;
           			case "baned":
                			$status = $lcms['user_status_baned'].' ('.$lcms['ban_why'].': '.$pieces[19].')';
                			break;
           			case "active":
                			$status = $lcms['user_status_noactive'];
                			break;
           			default:
                			$status = "Error. 1212.";           
       			};
        
       			if ($cms_avatars == 1)
			{
				$ava 	=	$cms_site.'/avatars/noavatar.png';
				//$cms_site."/avatars/".str_replace("\\","",str_replace("/","",str_replace("..","",$Filtr->clear($pieces[16]))))
				if ($cms_gravatars==1)
				{
					if ($pieces[16]=='noavatar.png')
						$ava	=	$GlobalImaging -> get_gravatar($pieces[2],$cms_upload_width,$cms_gravatars_im,'g',false);
				};
				if ($pieces[16]!='noavatar.png')
					$ava	=	$cms_site.'/avatars/'.$Filtr->clear($pieces[16]);
        		        $avatar = "<tr><td colspan=2><img src=\"".$ava."\" border=0 alt=\"\"></td></tr>";
			}
       			else
        			$avatar = "";
			$pieces[20] 	= str_replace('Не известно','Неизвестно',$pieces[20]);
			if (
				($pieces[20]!='Неизвестно')
				and
				($pieces[20]!='Начало эпохи Unix')
			)
				$pieces[20] = $Filtr->fulldate($pieces[20]);
       			$br = array($user,"Ruxe Engine (ruxe-engine.ru)",
       				$pole1,$polecaption[1],$pieces[5],$pole1c,
       				$pole2,$polecaption[2],$pieces[6],$pole2c,
       				$pole3,$polecaption[3],$pieces[7],$pole3c,
				$pole4,$polecaption[4],$pieces[8],$pole4c,
       				$pole5,$polecaption[5],$pieces[9],$pole5c,
       				$pole6,$polecaption[6],$pieces[10],$pole6c,
       				$pole7,$polecaption[7],$pieces[11],$pole7c,
       				$pieces[3],$status,$pieces[14],
       				$avatar,$cms_site,$cms_site."/themes/".$cms_theme,$about1,$about2,$pieces[20],
				$Navigation->furl('pmnewname',$user));
       			//$Filtr->showarray($br);
       			$openpage = $GlobalTemplate->users($ar,$br,4);
       			$pagetitle = $lcms['viewprofile_title'].$user;
    		}
    		else
    		{
       			$ar = array("{TITLE}","{GENERATOR}","{READRESS}","{/READRESS}","{MESSAGE}","{URL}","{SITE}","{THEMEPATH}");
       			$br = array($lcms['user_notfound_title'],"Ruxe Engine (ruxe-engine.ru)","<!-- "," -->",$lcms['user_notfound_text'],$cms_site,$cms_site,$cms_site."/themes/".$cms_theme);
       			$openpage = $GlobalTemplate->template($ar,$br,$cms_site."/themes/".$cms_theme."/message.html");
       			$pagetitle = $lcms['viewprofile_title'].$user;
    		};
  	};
};

if ($action=="myprofile")
{
	$profilelink	=	$Navigation->furl('profilelink');
	if (strstr($profilelink,'?'))
		$profilelink.='&amp;';
	else
		$profilelink.='?';
  	if ($GlobalUsers->thisisuser())
  	{
    		$user = $Filtr->clear($_COOKIE['site_login']);
    		$founded = false;
    		//$pos = 0;
    		//$foundedpos = 0;
    		$stop_his = false;
    		$pos	=	$GlobalUsers->finduser($user);
    		/*foreach ($usersfile as $user_)
    		{
        		$pieces = explode("|",$user_);
        		if ($Filtr->tolower($pieces[18]) == $Filtr->tolower($user))
        		{
        			$founded = true;
        			$foundedpos = $pos;
        			break;
        		}; 
        		$pos +=1;
    		};*/
    		if ($pos!=-1)
    		{
       			if (isset($_GET['step']))
       			{
          			if (($_GET['step'] == "uploadavatar") && ($cms_avatars == 1))
          			{
             				$login = $Filtr->clear($_COOKIE['site_login']);
             				$founderror = 0;
             				if ($_FILES['avatarfile']['tmp_name']=='')
             					$founderror	=	25;
             				else
             				{
             					$imageinfo    =    @getimagesize($_FILES['avatarfile']['tmp_name']);
            					if (
             						($imageinfo['mime'] != 'image/gif')
             						&& 
             						($imageinfo['mime'] != 'image/jpeg')
             						&&
             						($imageinfo['mime'] != 'image/png')
             					) 
             						$founderror = 1;
             					if (
             						(substr($Filtr->tolower($_FILES['avatarfile']['name']),strlen($Filtr->tolower($_FILES['avatarfile']['name']))-4,4)!= '.gif')
             						&& 
             						(substr($Filtr->tolower($_FILES['avatarfile']['name']),strlen($Filtr->tolower($_FILES['avatarfile']['name']))-4,4)!= '.jpg')
             						&&
             						(substr($Filtr->tolower($_FILES['avatarfile']['name']),strlen($Filtr->tolower($_FILES['avatarfile']['name']))-4,4)!= '.png')
             					)
             						$founderror = 2;
             					if ((time() - $GlobalUsers->thisusertime())< $cms_noflood)
             						$founderror = 6;
             					if ($cms_avatars_resize==1)
             					{
                 					if ($_FILES["avatarfile"]["size"]>$cms_avatars_maxresize*1024)
                 						$founderror = 8;
                 					if ($founderror == 0)
                 					{
                                 				if (
                                    					($imageinfo[0] > $cms_upload_width)
                                    				or
                                    					($imageinfo[1] > $cms_upload_height)
                                 				)
									$GlobalImaging->resize($_FILES['avatarfile']['tmp_name'],$_FILES['avatarfile']['tmp_name'],$cms_upload_width,$cms_upload_height);
                                 				else
                                 				{
                                    					if ($_FILES["avatarfile"]["size"]>$cms_upload_maxsite*1024)
                                    						$founderror = 3;
                                 				};

                 					};
             					}
             					else

             					{
                 					if ($_FILES["avatarfile"]["size"]>$cms_upload_maxsite*1024)
                 						$founderror = 3;
                 					if ($imageinfo[0] > $cms_upload_width)
                 						$founderror = 4;
                 					if ($imageinfo[1] > $cms_upload_height)
                 						$founderror = 5;
             					};
             				};
             				if ($founderror!=0)
             				{
                				$stop_his = true;
                				$ar = array("{TITLE}","{GENERATOR}","{READRESS}","{/READRESS}","{MESSAGE}","{URL}","{SITE}","{THEMEPATH}");
						
                				$br = array($lcms['user_ae_title'],"Ruxe Engine (ruxe-engine.ru)","","",$lcms['user_ae_'.$founderror].$lcms['user_add'],$profilelink."rand=".rand(1,9999),$cms_site,$cms_site."/themes/".$cms_theme);
                				$openpage = $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
                				$pagetitle = $lcms['user_ae_title'];
             				}
             				else
             				{

                				$uploaddir  = $cms_root.'/avatars/';
                				$onotole    = date("dmyHis");
                				$uploadfile = $uploaddir.basename($onotole.substr($_FILES['avatarfile']['name'],strlen($Filtr->tolower($_FILES['avatarfile']['name']))-4,4));
                
                				if (!move_uploaded_file($_FILES['avatarfile']['tmp_name'], $uploadfile)) 
                				{
                    					$ar = array("{TITLE}","{GENERATOR}","{READRESS}","{/READRESS}","{MESSAGE}","{URL}","{SITE}","{THEMEPATH}");
                    					$br = array($lcms['user_ae_title'],"Ruxe Engine (ruxe-engine.ru)","","",$lcms['user_ae_7'].$lcms['user_add'],$profilelink."rand=".rand(1,9999),$cms_site,$cms_site."/themes/".$cms_theme);
                    					$openpage = $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
                    					$pagetitle = $lcms['user_ae_title'];
                    					$stop_his = true;
                				};
                				if ($GlobalUsers->getpole($login,16)!='noavatar.png')
                					$FileManager->removefile($uploaddir.$GlobalUsers->getpole($login,16));
                				/*foreach ($usersfile as $user)
                				{
                    					$u = explode("|",$user);
                    					if ($Filtr->tolower($u[18])==$Filtr->tolower($login))
                    					{
                          					if ($u[16]!='noavatar.png')
                          						$FileManager->removefile($uploaddir.$u[16]);
                          					break;
                    					};
                				};*/
                				chmod($uploadfile,0777);
                				$usersfruits[13] = time();
                				$usersfruits[16] = $onotole.substr($_FILES['avatarfile']['name'],strlen($Filtr->tolower($_FILES['avatarfile']['name']))-4,4);
                				$GlobalUsers->editpoles("user",$login);
                				$pageredirect = $profilelink."rand=".rand(0,9999);
                				setcookie("site_avatar",$onotole.substr($_FILES['avatarfile']['name'],strlen($Filtr->tolower($_FILES['avatarfile']['name']))-4,4), time() + $cms_time_cookie,"/");
                				$ar = array("{TITLE}","{GENERATOR}","{READRESS}","{/READRESS}","{MESSAGE}","{URL}","{SITE}","{THEMEPATH}");
                				$br = array($lcms['avatar_ok_title'],"Ruxe Engine (ruxe-engine.ru)","","",$lcms['avatar_ok_text'].str_replace("{URL}",$pageredirect,$lcms['user_add']),$profilelink."rand=".rand(0,9999),$cms_site,$cms_site."/themes/".$cms_theme);
                				$openpage = $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");               
                				$pagetitle = $lcms['avatar_ok_title'];
                
             				};
             				$stop_his = true;
          			};
          			if (!$stop_his)
          			{
          				$founderror = false;
          				if (isset($_POST['pole1'])) {$pole1 = $Filtr->textmax($Filtr->clear($_POST['pole1']),90);} else $pole1 = "";
          				if (isset($_POST['pole2'])) {$pole2 = $Filtr->textmax($Filtr->clear($_POST['pole2']),90);} else $pole2 = "";
          				if (isset($_POST['pole3'])) {$pole3 = $Filtr->textmax($Filtr->clear($_POST['pole3']),90);} else $pole3 = "";
          				if (isset($_POST['pole4'])) {$pole4 = $Filtr->textmax($Filtr->clear($_POST['pole4']),90);} else $pole4 = "";
          				if (isset($_POST['pole5'])) {$pole5 = $Filtr->textmax($Filtr->clear($_POST['pole5']),90);} else $pole5 = "";
          				if (isset($_POST['pole6'])) {$pole6 = $Filtr->textmax($Filtr->clear($_POST['pole6']),90);} else $pole6 = "";
          				if (isset($_POST['pole7'])) {$pole7 = $Filtr->textmax($Filtr->clear($_POST['pole7']),90);} else $pole7 = "";
          				if (isset($_POST['about'])) {$about = $Filtr->textmax($Filtr->clear($_POST['about']),255);} else $about = "";
          				if (isset($_POST['ps'])) {$ps = $Filtr->textmax($Filtr->clear($_POST['ps']),$cms_ps_max);} else $ps = "";
          				if (isset($_POST['mail'])) {$mail = $Filtr->clear($_POST['mail']);} else $mail = "";
          				if (isset($_POST['newpassword'])) {$newpassword = $Filtr->clear($_POST['newpassword']);} else $newpassword = "";
          				if (isset($_POST['newspassword'])) {$newspassword = $Filtr->clear($_POST['newspassword']);} else $newspassword = "";
          				if (isset($_POST['oldpassword'])) {$oldpassword = $Filtr->clear($_POST['oldpassword']);} else $oldpassword = "";
          
          				if ($newpassword!="")
          				{
             					if ($GlobalUsers->checkpassword($newpassword,$newspassword,true) != "")
             					{
                					$founderror = true;
                					$errortext =  $GlobalUsers->checkpassword($newpassword,$newspassword,true);
             					};
             					if (md5(md5($oldpassword).$GlobalUsers->getpole($user,22))!=$_COOKIE['site_password'])
             					{
                					$founderror = true;
                					$errortext = $lcms['user_old'];
             					};
          				};
          				if ((time() - $GlobalUsers->thisusertime())< $cms_noflood)
          				{ 
          					$founderror = true;
          					$errortext = $lcms['user_noflood'];
          				};
          
          				$about = str_replace("\r","",$about);
          				$about = str_replace("\n","<br>",$about);
          				$ps = str_replace("\n","<br>",$ps);
          				$ps = str_replace("\r","",$ps);
          
          				if (!$Mailing->checkmail($mail)) 
          				{
          					$founderror = true;
          					$errortext = $lcms['user_errormail'];
          				};
          
          				if (!$founderror)
          				{
          
          					if ($newpassword!="")
          					{
                     					$usersfruits[1] = md5(md5($newpassword).$GlobalUsers->getpole($user,22));
                     					setcookie("site_password", md5(md5($newpassword).$GlobalUsers->getpole($user,22)), time() + $cms_time_cookie,"/");
          					};
          					$usersfruits[2] = $mail;
          					$usersfruits[3] = $about;
          					$usersfruits[5] = $pole1;
          					$usersfruits[6] = $pole2;
          					$usersfruits[7] = $pole3;
          					$usersfruits[8] = $pole4;
          					$usersfruits[9] = $pole5;
          					$usersfruits[10] = $pole6;
          					$usersfruits[11] = $pole7;
          					$usersfruits[13] = time();
          					$usersfruits[17] = $ps;
          					$GlobalUsers->editpoles("user",$_COOKIE['site_login']);

          					$ar = array("{TITLE}","{GENERATOR}","{READRESS}","{/READRESS}","{MESSAGE}","{URL}","{SITE}","{THEMEPATH}");
          					$pageredirect = $profilelink."rand=".rand(1,9999);
          					$br = array($lcms['user_edit_title'],"Ruxe Engine (ruxe-engine.ru)","","",str_replace("{URL}",$pageredirect,$lcms['user_edit_text']),$Filtr->clear($_SERVER['HTTP_REFERER']),$cms_site,$cms_site."/themes/".$cms_theme);
          					$openpage = $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
          					$pagetitle = $lcms['user_edit_title'];
          				}
          				else
          				{
           					$ar = array("{TITLE}","{GENERATOR}","{READRESS}","{/READRESS}","{MESSAGE}","{URL}","{SITE}","{THEMEPATH}");
           					$br = array($lcms['user_notfound_title'],"Ruxe Engine (ruxe-engine.ru)","","",$errortext.str_replace("{URL}",$profilelink."rand=".rand(1,9999),$lcms['user_add']),$Filtr->clear($_SERVER['HTTP_REFERER']),$cms_site,$cms_site."/themes/".$cms_theme);
           					$openpage = $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
           					$pagetitle = $lcms['user_notfound_title'];
          				};
          			};
       			}
       			else
       			{
       				$pieces = explode("|",$fileusers[$pos]);
       				include($cms_root."/conf/users/config.dat");
       				if (($pole[1]==true)){$pole1 = ""; $pole1c = "";} else {$pole1 = "<!-- "; $pole1c = " -->";};
       				if (($pole[2]==true)){$pole2 = ""; $pole2c = "";} else {$pole2 = "<!-- "; $pole2c = " -->";};
       				if (($pole[3]==true)){$pole3 = ""; $pole3c = "";} else {$pole3 = "<!-- "; $pole3c = " -->";};
       				if (($pole[4]==true)){$pole4 = ""; $pole4c = "";} else {$pole4 = "<!-- "; $pole4c = " -->";};
       				if (($pole[5]==true)){$pole5 = ""; $pole5c = "";} else {$pole5 = "<!-- "; $pole5c = " -->";};
       				if (($pole[6]==true)){$pole6 = ""; $pole6c = "";} else {$pole6 = "<!-- "; $pole6c = " -->";};
       				if (($pole[7]==true)){$pole7 = ""; $pole7c = "";} else {$pole7 = "<!-- "; $pole7c = " -->";};
       				$ar = array("{NAME}","{GENERATOR}",
       					"{POLE1}","{POLECAPTION1}","{POLE1RESULT}","{/POLE1}",
      					 "{POLE2}","{POLECAPTION2}","{POLE2RESULT}","{/POLE2}",
       					"{POLE3}","{POLECAPTION3}","{POLE3RESULT}","{/POLE3}",
       					"{POLE4}","{POLECAPTION4}","{POLE4RESULT}","{/POLE4}",
       					"{POLE5}","{POLECAPTION5}","{POLE5RESULT}","{/POLE5}",
       					"{POLE6}","{POLECAPTION6}","{POLE6RESULT}","{/POLE6}",
       					"{POLE7}","{POLECAPTION7}","{POLE7RESULT}","{/POLE7}",
       					"{ABOUTUSER}","{STATUS}","{SITE}","{MAIL}","{CM}",
       					"{AVATAR}","{MAXSIZE}","{WIDTH}","{HEIGHT}","{AVATARS}","{/AVATARS}",
       					"{PS1}","{/PS1}","{PS_MAX}","{PS}","{THEMEPATH}","{RULES}","{REGDATE}","{STEPUPLOAD}","{STEP2}");
       				if ($pieces[4] == "admin") 
       					$status = $lcms['user_status_admin'];
       				else if ($pieces[4] == "superuser")
       					$status = $lcms['user_status_superuser'];
       				else 
       					$status = $lcms['user_status_user'];
       				if ($cms_ps == 1)
       				{
          				$PS1 = "";
          				$PS2 = "";
       				}
       				else
       				{
          				$PS1 = "<!-- ";
          				$PS2 = " -->";
       				}; 
       				if ($cms_avatars==1)
       				{
          				$AVATARS1 = "";
          				$AVATARS2 = "";
       				}
       				else
       				{
          				$AVATARS1 = "<!-- ";
          				$AVATARS2 = " -->";
       				};
       				($cms_avatars_resize == 1)?$rules = $lcms['user_a_rules_2']:$rules=$lcms['user_a_rules_1']; 
				//str_replace("\\","",str_replace("/","",$Filtr->clear($pieces[16])))
				//Сначала сделать noavatar.png
				$ava	=	$cms_site.'/avatars/noavatar.png';
				//Потом сделать с граватарой если нужно
				if ($cms_gravatars==1)
					$ava	=	$GlobalImaging -> get_gravatar($pieces[2],$cms_upload_width,$cms_gravatars_im,'g',false);
				//Потом проверить у юзера - может у него своя аватара
				if ($pieces[16]!='noavatar.png')
					$ava = $cms_site.'/avatars/'.str_replace("\\","",str_replace("/","",$Filtr->clear($pieces[16])));
				
				$ep	=	$Navigation->furl('profilelink');
				if ($cms_furl!=1)
				{
					$STEPUPLOAD	=	$ep.'&amp;step=uploadavatar';
					$STEP2		=	$ep.'&amp;step=2';
				}
				else
				{
					$STEPUPLOAD	=	$ep.'?step=uploadavatar';
					$STEP2		=	$ep.'?step=2';
				};
				
       				$br = array($user,"Ruxe Engine (ruxe-engine.ru)",
       					$pole1,$polecaption[1],$pieces[5],$pole1c,
       					$pole2,$polecaption[2],$pieces[6],$pole2c,
       					$pole3,$polecaption[3],$pieces[7],$pole3c,
       					$pole4,$polecaption[4],$pieces[8],$pole4c,
       					$pole5,$polecaption[5],$pieces[9],$pole5c,
       					$pole6,$polecaption[6],$pieces[10],$pole6c,
       					$pole7,$polecaption[7],$pieces[11],$pole7c,
       					$pieces[3],$status,$cms_site,$pieces[2],$pieces[14],
       					$ava,$cms_upload_maxsite,$cms_upload_width,$cms_upload_height,
       					$AVATARS1,$AVATARS2,
       					$PS1,$PS2,$cms_ps_max,str_replace("<br>","\n",$pieces[17]),$cms_site."/themes/".$cms_theme,$rules,str_replace('Не известно','Неизвестно',$pieces[20]),
					$STEPUPLOAD,$STEP2);
       				$openpage = $GlobalTemplate->users($ar,$br,6);
       				$pagetitle = $lcms['edit_profile_title'];
       			};
    		}
    		else
    		{
       			$ar = array("{TITLE}","{GENERATOR}","{READRESS}","{/READRESS}","{MESSAGE}","{URL}","{SITE}","{THEMEPATH}");
       			$br = array($lcms['user_notfound_title'],"Ruxe Engine (ruxe-engine.ru)","<!-- "," -->",$lcms['user_notfound_text'],$cms_site,$cms_site,$cms_site."/themes/".$cms_theme);
       			$openpage = $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
       			$pagetitle = $lcms['user_notfound_title'];
    		};
  	}
  	else
  	{
       		$ar = array("{TITLE}","{GENERATOR}","{READRESS}","{/READRESS}","{MESSAGE}","{URL}","{SITE}","{THEMEPATH}");
       		$br = array($lcms['user_notfound_title'],"Ruxe Engine (ruxe-engine.ru)","<!-- "," -->",$lcms['user_notvalid'],$cms_site,$cms_site,$cms_site."/themes/".$cms_theme);
       		header('Content-type: text/html; charset=utf-8');
       		$openpage = $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/message.html");
       		$pagetitle = $lcms['user_notfound_title'];
  	};
};

