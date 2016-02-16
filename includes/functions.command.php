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


function here_thispage()
{
	global $viewpage;
	return ($viewpage=='index') ? 'index.php' : $viewpage;
};
function here_urlrss()
{
	global $cms_site, $cms_furl;
	if ($cms_furl==1)
		echo $cms_site.'/rss';
	else
		echo $cms_site.'/?action=rss';
};
function here_metaredirect()
{
   global $pageredirect;
   echo $pageredirect;
};
function here_title()
{
   global $pagetitle;
   echo $pagetitle;
};
function here_keywords()
{
         global $pagekeys;
         echo $pagekeys;
};
function here_generator() 
{
	echo "Ruxe Engine (ruxe-engine.ru)";
};
function here_description()
{
    global $pagedesc;
    echo $pagedesc;
};
function here_themepath()
{
    global $cms_theme,$cms_site;
    echo $cms_site."/themes/".$cms_theme;
};
function here_urltheme()
{
    here_themepath();
};
function here_urlsite($page	=	'')
{
	global $cms_site, $cms_furl;
	if ($page=='')
		$result		=	$cms_site;
	else
	{
		$result		=	($cms_furl!=1) ? $cms_site.'/?viewpage='.$page : $cms_site.'/'.$page;
	};
	echo $result;
};
function here_time_generation()
{
   global $ttt;
   $ddd=microtime(); 
   $ddd=((double)strstr($ddd, ' ')+(double)substr($ddd,0,strpos($ddd,' ')));
   echo number_format(($ddd-$ttt),3); 
};

function here_top_news($id = 'nouserid') {
	//1.4
	global $bfgfile, $GlobalTemplate, $lcms, $cms_root, $Navigation, $Filtr, $cms_top_news_max;
	$founded 	= false;
	foreach ($bfgfile as $bfgline) {
		$bfg	= explode('|',$bfgline);
		if ($bfg[0]==$id) {
			$founded= true;
			break;
		}
	}
	if ($founded) {
		$array_with_news= array();
		$views_file	= file($cms_root.'/conf/'.$id.'/views.dat');
		$list_file	= file($cms_root.'/conf/'.$id.'/list.dat');
		//Медленные процессы. Надо придумать что-то кэширующее.
		foreach ($list_file as $list_line) {
			$list	= explode('|',$list_line);
			if ($list[9]=='Да') {
				$counter= 0;
				foreach ($views_file as $views_line) {
					$views	= explode('|',$views_line);
					if ($views[0]==$list[6]) {
						$counter=$views[1];
						break;
					}
				}
				$array_with_news[]= $counter.'|'.$list[2].'|'.$list[6].'|'.$list[12];
			}
		}
		natcasesort($array_with_news);
		$array_with_news= array_reverse($array_with_news);
		//
		$counter= 0;
		foreach ($array_with_news as $line) {
			$items	= explode('|',$line);
			if ($counter<$cms_top_news_max) {
				$link	= ($list[12]=='') ? $Navigation->furl('bfgfull',$id,$items[2]) : $Navigation->furl('bfglink',$id,$items[2]);
				echo $GlobalTemplate->other(array('{URL}','{CAPTION}','{FULLCOUNTER}','{COUNTER}'),
								array($link,$items[1],
								$Filtr->truecount($items[0],$lcms['views_one'],$lcms['views_much'],$lcms['views_much2']),$items[0]),30);
			} else break;
			$counter++;
		}
	} else
		echo str_replace('{ID}',$id,$lcms['error_544']);
}

function here_last_posts()
{
	global $cms_root,$cms_site,$cms_lastposts_count,$cms_rewrite,$cms_rewrite_ext,
		$cms_lastposts_len,$bfgfile,$cms_theme,$lcms,$GlobalTemplate,$Filtr,$GlobalUsers, $cms_furl, $Navigation, $fileusers;
	$last_posts = file($cms_root."/conf/last_posts.dat");
	$last_posts = array_reverse($last_posts);
	$i = 1;
	$new_last_posts = array();
	foreach ($last_posts as $last_post)
	{
	       $l = explode("|",$last_post);
	       if ($l[2]=="yes") $new_last_posts[] = $last_post;
	};
	foreach ($new_last_posts as $last_post)
	{
		$l = explode("|",$last_post);
		if ($i<=$cms_lastposts_count)
		{
			if ($l[0]=='messages')
			{
				if ($cms_furl==1)
					$rew	=	$cms_site.'/'.$l[5];
				else
					$rew	=	$cms_site.'/?viewpage='.$l[5];
			}
			else
		         	$rew = $Navigation->furl('bfgfull',$l[0],$l[5]);
			//
		        $l[4] = $GlobalTemplate->usebbcodes($l[4],'lastposts');
			//$l[1]
			$user	=	$GlobalUsers->finduser($l[1]);
			$needcenzura	=	true;
			if ($user!=-1) {
				$l[1]	=	'<a href="'.$Navigation->furl('viewprofile',$l[1]).'">'.$l[1].'</a>';
				$pie	=	explode('|',$fileusers[$user]);
				if ($pie[4] == "admin")
					$needcenzura	=	false;
			};
			$result	=	$Filtr->textmax($l[4],$cms_lastposts_len,'...');
			//0.9.9.9 <br...
			$result	=	preg_replace('|<([^>]*)\.\.\.|uUis','...',$result);
			echo $GlobalTemplate->other(array("{URL}","{TITLE}","{NAME}","{DATE}","{MESSAGE}","{THEMEPATH}"),
						     array($rew,  $l[6],  $l[1],$Filtr->fulldate($l[3]),$GlobalTemplate->usebbcodes($result,'html',false,$needcenzura),$cms_site."/themes/".$cms_theme),
                                               0);
		};
		$i++;
	};
};

function here_random_faq()
{
global $cms_site, $cms_root,$GlobalUsers,$cms_theme, $GlobalTemplate, $Filtr, $Navigation;
$ar = array("{SITE}","{NAME}","{QUESTION}","{ADMIN}","{ANSWER}","{THEMEPATH}");
$faqs = file($cms_root."/conf/faq.dat");
if (count($faqs)>0)
{
   $newfaq = array();
   foreach ($faqs as $faq)
   {
       $pieces = explode("|",$faq);
       if ($pieces[3]!="hide")
       {
           $newfaq[] = $faq;
       };
   };
   if (count($newfaq)>0)
   {
     $pos = rand(0,count($newfaq)-1);
     $pieces = explode("|",$newfaq[$pos]);
     if ($GlobalUsers->finduser($pieces[5])!=-1)
     {
     	if ($GlobalUsers->getpole($pieces[5],4) == "admin")
        	$pieces[5] = "<a href=\"".$Navigation->furl('viewprofile',$pieces[5])."\"><font color=\"red\">".$pieces[5]."</font></a>";
        else
        	$pieces[5] = "<a href=\"".$Navigation->furl('viewprofile',$pieces[5])."\">".$pieces[5]."</a>";
     };
     if ($GlobalUsers->finduser($pieces[0])!=-1)
     {
     	if ($GlobalUsers->getpole($pieces[0],4) == "admin")
        	$pieces[0] = "<a href=\"".$Navigation->furl('viewprofile',$pieces[0])."\"><font color=\"red\">".$pieces[0]."</font></a>";
        else
        	$pieces[0] = "<a href=\"".$Navigation->furl('viewprofile',$pieces[0])."\">".$pieces[0]."</a>";
     };
     $br = array($cms_site,$pieces[0],$GlobalTemplate->usebbcodes($pieces[4],'html',true),$pieces[5],$GlobalTemplate->usebbcodes($pieces[6],'html',true),$cms_site."/themes/".$cms_theme);
     echo $GlobalTemplate->other($ar,$br,1);
   };
};
};

function here_list_category($type = 'noidhere')
{
  	global $cms_site, $cms_root, $bfgfile, $cms_theme, $lcms, $GlobalTemplate, $Filtr, $GlobalCache, $Navigation;
	if (file_exists($cms_root."/conf/".$type."/list.dat"))
	{
  		if (!file_exists($cms_root.'/conf/cache/cats_'.$type))
  			$GlobalCache->cats($type);
  		$tmp	=	file($cms_root.'/conf/cache/cats_'.$type);
  		$newlist=	unserialize($tmp[0]);
  		$ar = array("{SITE}","{CATEGORY}","{LINK}","{THEMEPATH}","{ID}","{PATH}");
  		foreach ($bfgfile as $b)
  		{
     			$f = explode("|",$b);
     			if ($f[0]==$Filtr->tolower($type))
     			{
        			$o = $f[2];
        			break;
        		};
  		};
  		sort($newlist);
 		foreach ($newlist as $new)
  		{
     			$pieces = explode("|",$new);
      			if ($o=="index") 
      				$o = $cms_site;
      			$br = array($cms_site,$Filtr->clear($pieces[0]),$GlobalTemplate->getonlywords($pieces[0]),$cms_site."/themes/".$cms_theme,$type,$Navigation->furl('category',$type,$GlobalTemplate->getonlywords($pieces[0])));
      			echo $GlobalTemplate->other($ar,$br,2);
  		};
	}
	else
     		echo $lcms['error_222'];
};

function here_login()
{
	global $GlobalUsers;
	echo $GlobalUsers->returnloginform();
};

function here_downloads(){
  global $cms_root, $cms_site, $GlobalUsers, $cms_theme,$lcms,$cms_nav_downloads,$GlobalTemplate,$Filtr,$Navigation,$cms_furl;
	
	if ($GlobalUsers->thisisuser()) {
		if ($GlobalUsers->getstatus($Filtr->clear($_COOKIE['site_login']))=='admin') {
			echo "<center>";
			$Filtr->showmess('
				<b>Внимание! Данное сообщение отображается только для администраторов.</b><br><br>
				Команда &lt;?php here_downloads(); ?&gt; будет отменена в следующих версиях Ruxe Engine.<br>
				Используйте команду &lt;?php here_show_downloads("ID"); ?&gt; и др. для создания каталога файлов.<br>
				Подробнее в Админ-центр - Другие модули - Счётчики загрузок.
				');
			echo "</center>";
		}
	}
  $downloads = file($cms_root."/conf/downloads.dat");
  $paths     = file($cms_root."/conf/paths.dat");
  $paths     = array_reverse($paths);
  $echolist  = "";
  $pos       = count($paths)-1;
  foreach ($paths as $path){
    $program      =  explode("|",$path);
    $ar           =  array("{IMG}","{DESCRIPTION}","{COUNT}","{SITE}","{FILE}","{PROGRAM}","{BIGIMG}","{ADD1}","{ADD2}","{PATHFILE}");
    $cms_count        =  "Not Found";
    foreach ($downloads as $download)
    {
       $down            =  explode("=",$download);
       if ($down[0] == $program[0])
          {
           $cms_count   =           $Filtr->TrueCount($down[1], $lcms['download_one'], $lcms['download_much'], $lcms['download_much2']);
          };
    };
    $br          =  array($program[3],$program[4], $cms_count, $cms_site, $program[0],$program[2],$program[5],$program[6],$program[7], $Navigation->furl('getfile',$program[0]));
    if ($Navigation->ShowPage(count($paths),$pos,$cms_nav_downloads)) {
    $echolist.=$GlobalTemplate->other($ar,$br,4);
    };
    $pos-=1;   
  };
  $ar = array("{PAGES}","{LIST}","{THEMEPATH}");
  $br = array($Navigation->Pager(count($paths),($cms_furl!=1) ? '&amp;viewpage='.$Filtr->clear($_GET['viewpage']) : '',$cms_nav_downloads), $echolist,$cms_site."/themes/".$cms_theme);
  echo $GlobalTemplate->other($ar,$br,3);
};

function here_hosts(){global $hosts; echo $hosts;};

function here_last_hosts(){
 global $cms_root;
 include($cms_root."/conf/last_hosts.dat");
};

function here_bots() {global $bots; echo $bots;};

function here_hits(){global $hits; echo $hits;};

function here_all_hits(){global $all_hits; echo $all_hits;};

function here_all_hosts(){global $all_hosts; echo $all_hosts;};

function here_links()
{
global $cms_root,$cms_http,$cms_noindexlinks, $cms_site,$cms_theme,$GlobalTemplate,$Navigation;
$ar = array("{URL}","{SHOWED_URL}","{DESCRIPTION}","{COUNT}","{SITE}","{NOINDEX}","{/NOINDEX}","{URLPATH}");
$links_data = file($cms_root.'/conf/links.dat');
$links_data = array_reverse($links_data);
$links_list = "";
foreach($links_data as $element)
{
 $element = trim($element);
 $links_showed = "";
 $pieces = explode("|", $element);
 $links_url = $pieces[1];
 $links_showed.=$links_url;
 if ($cms_http==1)
 {
   $links_showed = str_replace("http://","",$links_showed);
 };
 $link = $pieces[0];
 $lc   = 0;
 $count_links = file($cms_root."/conf/count_links.dat");
 foreach ($count_links as $count_link)
 {
    $co = explode("=",$count_link);
    if ($co[0] == $link)
    {
         $lc = $co[1];   
    };
 };
 ($cms_noindexlinks==1) ? $br = array($link,$links_showed,$pieces[2],$lc,$cms_site,'rel="nofollow"',"",$Navigation->furl('go',$link)) : $br = array($link,$links_showed,$pieces[2],$lc,$cms_site,"","",$Navigation->furl('go',$link));
 $links_list.= $GlobalTemplate->other($ar,$br,6);
};
echo $GlobalTemplate->other(array("{LINKS}","{THEMEPATH}"),array($links_list,$cms_site."/themes/".$cms_theme),5);
};

function here_hided_counter_views($id = 'noidused')
{
 global $cms_root, $lcms;
       $sv_views  = file($cms_root."/conf/views.dat");
       $sv_found  = 0;
       $sv_line   = 0;
    $new_view = fopen($cms_root . "/conf/views.dat", "cb");
    flock($new_view, LOCK_EX);
    ftruncate($new_view, 0);
    foreach ($sv_views as $sv_elemetns) {
        $sv_elemetn = trim($sv_elemetns);
        $programm = explode("=", $sv_elemetn);
        if ($programm[0] == $id) {
            $sv_tmp = $programm[1];
            $sv_found = 1;
            $sv_tmp += 1;
            fwrite($new_view, $id . "=" . $sv_tmp . "\r\n");
        } else {
            if ($programm[1] != "") {
                fwrite($new_view, $sv_views[$sv_line]);
            };
        };
        $sv_line += 1;
    };
    flock($new_view, LOCK_UN);
    fclose($new_view);
       if ($sv_found==0)
             echo $lcms['error_222'];
};

function here_show_views($id = 'notusedid')
{
         global $cms_root, $lcms;
         $sv_views=file($cms_root."/conf/views.dat");
         $sv_found=0;
         $sv_line=0;
         foreach($sv_views as $sv_elemetns)
         {
                           $sv_elemetn=trim($sv_elemetns);
                           $programm=explode("=",$sv_elemetn);
                           if ($programm[0] == $id){
                                            $sv_found=1;
                                            echo $programm[1];
                           };
         };
         if ($sv_found==0) echo $lcms['error_222'];
};

function here_mail()
{
	global $GlobalTemplate;
	echo $GlobalTemplate->commentform("tomail","","","");
};

function get_downloads($id = 'notusedid')
{
global $cms_root, $lcms, $Filtr;
$sv_downloads=file($cms_root."/conf/downloads.dat");
$founded = false;
foreach($sv_downloads as $sv_elemetns)
{
   $sv_elemetn=trim($sv_elemetns);
   $programm=explode("=",$sv_elemetn);
   if ($programm[0] == $id){
      $founded = true;
      return $Filtr->truecount($programm[1], $lcms['download_one'], $lcms['download_much'], $lcms['download_much2']);
   };
};
if (!$founded) return $lcms['error_222'];
};

function here_show_downloads($id = 'notusedid')
{
echo get_downloads($id);
};


function here_rotator()
{
    global $cms_root, $cms_site, $cms_theme, $GlobalTemplate, $Navigation;
    $url_list = file($cms_root . "/conf/rotator.dat");
    $last = file($cms_root . "/conf/last_rotator.dat");
    $last = $last[0];
    if (count($url_list) != 0) {
        if ($last >= (count($url_list) - 1)) {
            $last = 0;
        } else {
            $last = $last + 1;
        };
        $tmp_url = explode("|", $url_list[$last]);
        $ar = array("{URL}", "{CODE}", "{THEMEPATH}");
        $br = array($Navigation->furl('rotator', $tmp_url[0]), $tmp_url[1], $cms_site . "/themes/" . $cms_theme);
        echo $GlobalTemplate->other($ar, $br, 7);

        $ll = fopen($cms_root . "/conf/last_rotator.dat", "cb");
        flock($ll, LOCK_EX);
        ftruncate($ll, 0);
        fwrite($ll, $last);
        flock($ll, LOCK_UN);
        fclose($ll);
    };
};

function here_record_online()
{
global $cms_root;
include($cms_root."/conf/online.dat");
};

function here_faq()
{
global $cms_root,$cms_site,$lcms,$cms_theme,$cms_nav_faq,
	$GlobalTemplate,$Navigation,$Filtr, $GlobalUsers, $cms_furl, $_GET;
$faq_d = 0;
$faq_db = file($cms_root."/conf/faq.dat");
$new_faq_db = array();
foreach ($faq_db as $f)
{
   $p = explode("|",$f);
   if ($p[3]!="hide")
   {
       $new_faq_db[]=$f;
   };
};
$faq_db = array_reverse($new_faq_db);
$pos = count($faq_db)-1;
$echolist="";
foreach ($faq_db as $faq_)
{
    $pieces = explode("|",$faq_);
    $ar     = array("{SITE}","{NAME}","{DATE}","{QUESTION}","{ADMIN}","{ANSWER}","{THEMEPATH}");

    if ($Navigation->ShowPage(count($faq_db),$pos,$cms_nav_faq)==True && $pieces[3]=="show") {
    	$tmp	=	$GlobalUsers->finduser($pieces[0]);
    	$tmp2	=	$GlobalUsers->finduser($pieces[5]);
    	if ($tmp!=-1)
    		$pieces[0] = "<a href=\"".$Navigation->furl('viewprofile',$pieces[0])."\">".$pieces[0]."</a>";
    	if ($tmp2!=-1)
    		$pieces[5] = "<a href=\"".$Navigation->furl('viewprofile',$pieces[5])."\">".$pieces[5]."</a>";
     
     
     $br     = array($cms_site,$pieces[0],$Filtr->fulldate($pieces[2]),$GlobalTemplate->usebbcodes($pieces[4],'html'),$pieces[5],$GlobalTemplate->usebbcodes($pieces[6],'html',true),$cms_site."/themes/".$cms_theme);
     $echolist.=$GlobalTemplate->other($ar,$br,9);
    };
    $pos-=1;
};
$ar = array("{PAGES}","{LIST}","{THEMEPATH}");
$br = array($Navigation->Pager(count($faq_db),($cms_furl!=1) ? '&amp;viewpage='.$Filtr->clear($_GET['viewpage']) : '',$cms_nav_faq),$echolist,$cms_site."/themes/".$cms_theme);
echo $GlobalTemplate->other($ar,$br,8);
};

function here_question()
{
	global $GlobalTemplate;
  	echo $GlobalTemplate->commentform("question","","","");
};

function here_top_downloads()
{
global $cms_root,$cms_site,$_SERVER,$cms_top_count,$cms_top_show,$cms_theme,$GlobalTemplate, $Navigation;
$top_db_download = file($cms_root."/conf/downloads.dat");
$top_db_new = array();
foreach($top_db_download as $top_download)
{
  $top_download  = str_replace("\r\n","",$top_download);
  $top_download  = str_replace("\n","",$top_download);
  $top_download_ = explode("=",$top_download);
  $top_db_new[]  = $top_download_[1]."=".$top_download_[0];
};
natsort($top_db_new);
reset($top_db_new);
$top_db_new      = array_reverse($top_db_new);
$paths_file      = file($cms_root."/conf/paths.dat");
if (count($top_db_new)<$cms_top_count) $cms_top_count = count($top_db_new); 
for ($i_=0;$i_<$cms_top_count;$i_++)
{
  $temp_         = explode("=",$top_db_new[$i_]);
  $name_d        = "";
  for ($i__=0;$i__<count($paths_file);$i__++)
  {
     $temp__     = explode("|",$paths_file[$i__]);
     if ($temp__[0]==$temp_[1]) {$name_d = $temp__[2]; break;};
  };
  $ar = array("{SITE}","{NAME}","{DESCRIPTION}","{COUNT}","{THEMEPATH}","{PATH}");
  if ($cms_top_show==1)
  {
    $temp_[0] = str_replace("\n","",$temp_[0]);
    $temp_[0] = str_replace("\r","",$temp_[0]);
    $name_c = " (".$temp_[0].")";
  }
  else
  {
    $name_c = "";
  };
  $name_d = str_replace("\n","",$name_d);
  $name_d = str_replace("\r","",$name_d);
  $br = array($cms_site,$temp_[1],$name_d,$name_c,$cms_site."/themes/".$cms_theme, $Navigation->furl('getfile',$temp_[1]));
  if (!$temp_[1] == "")
  {
      echo $GlobalTemplate->other($ar,$br,10);
  };
};
};

function here_online()
{
global $online_count,$onlinefusers,$lcms,$online_users,$online_index;
echo $online_count.' ';
echo $online_users[$online_index];
if ($onlinefusers!="")
{
   echo $lcms['users_online'].$onlinefusers.$lcms['users_end'];
};
};

function here_messages($id = 'notusedid')
{
 global $cms_root, $cms_smiles, $cms_site, $lcms, $_GET, $cms_secpic,$cms_nav_comments,
 $GlobalTemplate,$GlobalComments,$Navigation, $cms_furl, $Filtr;
 $listmess  = file($cms_root."/conf/messages/listmess.dat");
 $found = false;
 foreach ($listmess as $list)
 {
    $l = explode("|",$list);
    if ($l[0]==$id) 
    {
       $sname = $l[1];
       $found = true;
    }; 
 };
 if (!$found)
 {
    echo str_replace("{ID}",$id,$lcms['error_544']);
 }
 else
 {
 $messdata  = file($cms_root."/conf/messages/mess_".$id.".dat");
 $nmessdata = array();
 foreach ($messdata as $mess)
 {
    $o = explode("|",$mess);
    if ($o[6]!='no') $nmessdata[] = $mess;
 };
 $messdata  = $nmessdata;
 $messdata  = array_reverse($messdata);
 $pos       = count($messdata)-1;
 $echolist = $GlobalComments->show($messdata,$pos);
 $ar = array("{COMMENTFORM}","{PAGES}","{COMMENTS}");
 $br = array($GlobalTemplate->commentform("new_message",$id,$sname,""),$Navigation->Pager(count($messdata),($cms_furl==1) ? '' : '&amp;viewpage='.$Filtr->clear($_GET['viewpage']),$cms_nav_comments),$echolist);
 echo $GlobalTemplate->other($ar,$br,11);
 };
};

function here_guestbook()
{
	echo '<div style="background-color:#f6e79a; border:1px solid black; margin: 2px 2px 2px 2px; padding: 2px 2px 2px 2px;">
	        <center><b>Внимание</b></center>
	        <p>Гостевая книга (как модуль) удалена. Если вы использовали скрипт обновления, то был создан одиночный раздел "Гостевая книга" (ID: guestbook), куда перенесены все ваши записи.</p>
	        <p>Используйте команду <b>&lt;?php here_messages(\'guestbook\'); ?&gt;</b>.</p>
		<p>Администратирование осуществляется в Админ-центр - Другие модули - Разделы комментариев - Гостевая книга.</p>
	        </div>';
};

function here_list_tags($type = 'notusedid')
{
         global $cms_root, $cms_site, $bfgfile, $lcms, $GlobalCache, $GlobalTemplate, $Filtr, $GlobalUsers, $Navigation;
         $founded 	=	false;
         $types		=	array();
         if ($type=='notusedid')
         {
         	$founded 	= 	true;
         	$tags		=	array();
         	$counter	=	array();
         	foreach ($bfgfile as $bfgline)
         	{
         		$bfg		=	explode('|',$bfgline);
         		if (!file_exists($cms_root.'/conf/cache/tags_'.$bfg[0])) {
         			$GlobalCache	->	tags($bfg[0]);
			}
         		$cache		=	file($cms_root.'/conf/cache/tags_'.$bfg[0]);
         		$c		=	explode('[<|>]',$cache[0]);
         		$tags		=	array_merge($tags,unserialize($c[0]));
         		$counter	=	array_merge($counter,unserialize($c[1]));
         		$x		=	count($types);
         		for ($y	= $x; $y<=(count(unserialize($c[1]))+$x-1); $y++)
         			$types[$y]	=	$bfg[0];
         		
         	};
         	//$Filtr->showarray($types);
         	
         }
         else
         {
         	if (file_exists($cms_root."/conf/".$type."/list.dat"))
         	{
         		$founded = true;
         		                   
                   	if (!file_exists($cms_root."/conf/cache/tags_".$type))
                   		$GlobalCache -> tags($type);
                   
                   	$cache = file($cms_root."/conf/cache/tags_".$type);
                   	$c     = explode("[<|>]",$cache[0]);
                   	$tags  = unserialize($c[0]);
                   	$counter = unserialize($c[1]);
         	};
         };
         
         if (!$founded)
         	echo $lcms['error_222'];
         else
         {
		
		
         	$pos  = 0;
                $max  = 0;
                $tmp1	=	array();
                foreach ($tags as $t)
                {
                            	$tmp1[] = $counter[$pos]."||".$Filtr->tolower($tags[$pos]).'||'.$tags[$pos];
                            	if ($counter[$pos]>$max) $max = $counter[$pos];
                            	$pos++;
                };
                if (count($tmp1)!=0)
                {   
                	natsort($tmp1);
                	$tmp1 = array_reverse($tmp1);
                	$oldtags	=	$tags;
                	$tags = $tmp1;
                	//$pos  = count($tags);
                	foreach ($tags as $t)
                	{
                            	$z     = explode("||",$t);
                            	//$check = $pos / count($tags) * 100;
                            	$check = $z[0]/$max*100;
                            	$line  = 21;
                            	if ($check<75) $line = 22;
                            	if ($check<50) $line = 23;
                            	if ($check<25) $line = 24;
                            	
                            	if (count($types)>0)
                            	{
                            		$n	=	0;
                            		foreach ($oldtags as $oldtag)
                            		{
                            			if ($Filtr->tolower($oldtag)==$Filtr->tolower($z[1]))
                            			{
                            				$type	=	$types[$n];
                            				//echo $z[1].':'.$type.'<br>';
                            				break;
                            			};
                            			$n++;
                            		};
                            	};
                            	
                            	$res[] = $z[1]."||".$z[0]."||".$GlobalTemplate->other(
                                                     array("{LINK}","{CAPTION}"),
                                                     array($Navigation->furl('tags',$type,$GlobalTemplate->getonlywords($z[2])),$z[2]),
                                                     $line);
                            	//$pos--;
                	};
                	natsort($res);
                	foreach ($res as $r)
                	{
                            	$x = explode("||",$r);
                            	echo $x[2];
                	};
                };
         };
};

function here_news($type = 'notusedid')
{
global $cms_root,$cms_site,$cms_smiles,$_GET,$_SERVER,$_POST,$lcms,
       $cms_premoder, $cms_secpic, $cms_oncomments,$cms_views_counter,$cms_rewrite, $cms_rewrite_ext,$bfgfile,$cms_theme,
       $pathsfile,$_COOKIE,$wassetview,
       $cms_nav_news,$cms_nav_comments,$cms_uniqbfg,
       $GlobalTemplate,$Filtr,$Navigation,$GlobalComments,$Robots, $GlobalUsers, $cms_furl;

	$continue = true;
	$bfgfile = $bfgfile;
	//Проверка на существование новостного раздела
       
	$founded = false;
	$type    = $Filtr->tolower($type);
	foreach ($bfgfile as $b)
	{
		$f        = explode("|",$b);
		if ($f[0]==$type)
		{
			$founded = true;
			$nameofbfg	=	$f[1];
			$bfg = $f;
			break;
		};
	};
       
	if (!$founded) 
	{    
		$continue = false;
		echo $lcms['error_222'];
	};

	//Если новостной раздел существует, то продолжаем
	if ($continue)
	{
		//Проверка на вызов полной новости
		if ( isset($_GET['viewnews']) && isset($_GET['record']) )
		{
			$comment = $Filtr->clear($_GET['record']);
			$comment = str_replace(".","",$comment);
			$comment = $Filtr->tolower($comment);
		}
		else
			$comment = "no_comment";
                    
		if ($comment!="no_comment")
		{
			//Проверка на существование полной новости
			$list  = file($cms_root."/conf/".$type."/list.dat");
			$founded = false;
			$futurecat	=	'';
			foreach ($list as $lis)
			{
				$l = explode("|",$lis);
				if ($l[6]==$comment)
				{
					$founded = true;
					//$futurecat	=	$l[7];
					//подбор похожих новостей 
					$futurecat	=	array();
					foreach ($list as $li)
					{
						$s	=	explode('|',$li);
						if ( ($s[9]!='Нет') and ($s[7]==$l[7]) and ($s[6]!=$comment) )
						{
							//12 - линк
							if ($s[12]!='')
								$futurecat[]	=	$Navigation->furl('bfglink',$type,$s[6]).'|'.$s[2];
							else
								$futurecat[]	=	$Navigation->furl('bfgfull',$type,$s[6]).'|'.$s[2];
						};
					};
					$futurecat	=	array_reverse($futurecat);
					//print_r($futurecat);
					break;
				};
			};
			if (!$founded)
			{
				echo $lcms['news_not_found'];
				//Проверка окончена
			}
			else
			{
				$echonews = "";
				$echolist = "";

				$db_news = file($cms_root."/conf/".$type."/".$comment.".dat");
				$new_db_news = array();
				$z	=	0;
				$new_db_news[] = $db_news[0];
   
				foreach ($db_news as $tmpdb)
				{
					$tmpdbb = explode("|",$tmpdb);
					if ($z!=0)
					{
						if ($tmpdbb[6]!='no') $new_db_news[] = $tmpdb;
					}
					$z++;
				};
   
				$db_news = $new_db_news;

				$db_new  = explode("|",$db_news[0]);
   
				if ($GlobalUsers->finduser($db_new[1])!=-1)
					$db_new[1]	=	'<a href="'.$Navigation->furl('viewprofile',$db_new[1]).'">'.$db_new[1].'</a>';
   
				$news_db_title = $db_new[2];
				$counter_views = "";
   
				if ($cms_views_counter == 1)
				{
					$counters = file($cms_root."/conf/".$type."/views.dat");
					$changecounter	=	false;
					if ($cms_uniqbfg==0)
						$changecounter	=	true;
					else
					{
						if (
							($wassetview==true)
							and
							(!$Robots->check($_SERVER['HTTP_USER_AGENT']))
						)
							$changecounter	=	true;
					};
					if ($changecounter)
					{
						$new_counters = fopen($cms_root."/conf/".$type."/views.dat","cb");
						flock($new_counters,LOCK_EX);
                        ftruncate($new_counters, 0);
					};
					$fnc = $comment;
					$counterfinded	=	false;
					foreach ($counters as $counter)
					{
						$c = explode("|",$counter);
						if ($fnc == $c[0]) 
						{
							$counterfinded	=	true;
							if ($changecounter)
							{
								$c[1]++;
								fwrite($new_counters,$fnc."|".$c[1]."|\r\n");
							};
							$counter_views = $c[1];
						}
						else
						{
							if ($changecounter)
								fwrite($new_counters,$c[0]."|".$c[1]."|\r\n");
						};
					};
					if ($changecounter)
					{
						if ($counterfinded==false)
							fwrite($new_counters,$fnc."|1|\r\n");
						flock($new_counters,LOCK_UN);
						fclose($new_counters);
					};
					if ($counter_views<1)
						$counter_views = $lcms['views_0'];
					else
						$counter_views = $Filtr->TrueCount($counter_views,$lcms['views_one'],$lcms['views_much'],$lcms['views_much2']);
				};

				$db_new[3] = $GlobalTemplate->usebbcodes($db_new[3],'html',false,false);
				$db_new[3] = str_replace(array("[urlsite]","[themepath]"),array($cms_site,$cms_site."/themes/".$cms_theme),$db_new[3]);
                        
				if (strstr($db_new[3],"[show_downloads="))
				{
					foreach ($pathsfile as $path)
					{
						$pat = explode("|",$path);
						$db_new[3] = preg_replace('|\[show_downloads='.$pat[0].'\]|Uis', get_downloads($pat[0]), $db_new[3]);
					};
				};
				array_shift($db_news);
				$db_news = array_reverse($db_news);
   
				$pos = count($db_news)-1;
				$echolist = $GlobalComments->show($db_news,$pos);
				//1.3
				$date	=	explode('>',$Filtr->fulldate($db_new[0],'00',false));
				$day	=	$date[0];
				$month	=	$date[1];
				$year	=	$date[2];
				//
				$ar = array("{URL}","{TITLE}","{DESCRIPTION}","{AUTHOR}","{DATE}","{CATURL}","{CATEGORY}","{LIST}",
						"{1COMMENTS}","{COMURL}","{/LIST}","{VIEWS}","{THEMEPATH}","{PAGES}","{COMMENTS}","{COMMENTFORM}",
						"{DAY}","{MONTH}","{YEAR}");
				$cs	=	($cms_furl!=1) ? '&amp;viewnews='.$type.'&amp;record='.$comment : '';
				if ($db_new[8] == "Нет")
					$br = array($Navigation->furl('bfgfull',$type,$comment),$db_new[2],$db_new[3],
                                       		$db_new[1],$Filtr->fulldate($db_new[0]),"","","<!-- ","",""," -->",$counter_views,$cms_site."/themes/".$cms_theme,
                                       		$Navigation->Pager(count($db_news),$cs."#comments",$cms_nav_comments),$echolist,'<a name="comments"></a>
                        			'.$lcms['news_no_comments'],
						$day,$month,$year);
				else
                                       $br = array($Navigation->furl('bfgfull',$type,$comment),$db_new[2],$db_new[3],
                                       		$db_new[1],$Filtr->fulldate($db_new[0]),"","","<!-- ","",""," -->",$counter_views,$cms_site."/themes/".$cms_theme,
                                       		$Navigation->Pager(count($db_news),$cs."#comments",$cms_nav_comments),$echolist,$GlobalTemplate->commentform("add_comment",$comment,$news_db_title,$type).'<a name="comments"></a>
                        			',$day,$month,$year);
				echo $GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/newsfullrecord.html",$db_new[4],$type,false,false,$futurecat);
			};
		}
		else
		{
			//Список новостей
			$showfoot = true;
			if ($showfoot)
			{
				$gb_db = file($cms_root."/conf/".$type."/list.dat");
				$gb_db = array_reverse($gb_db);
				$counter_views = "";
				$pos   = count($gb_db)-1;
				$echolist  = "";
				(isset($_GET['category'])) ? $ch_cat = $Filtr->clear($_GET['category']) : $ch_cat = "nonesortre";
				$new_cat   = array();
				$cat_count = 0;
                            
				//Отдельный массив для поднятых новостей, чтобы новые были выше старых, а не наоборот
				$new_cat_upped = array();
                            
				foreach ($gb_db as $new_cat_list)
				{
					$new_cat_see = explode("|",$new_cat_list);
					if ( 
						($GlobalTemplate->getonlywords($new_cat_see[7]) == $ch_cat) 
						or 
						($ch_cat == "nonesortre")
					)
					{
						if ($new_cat_see[9] == "Да")
						{
							$cat_count++;
							if ($new_cat_see[11]=="Да")
							{
								//array_unshift($new_cat,$new_cat_list);
								$new_cat_upped[] = $new_cat_list;
							}
							else
								$new_cat[$cat_count] = $new_cat_list;
						};
					};
				};
				$cancont = true;
				if ($cat_count == 0)
				{
					if (count($gb_db)==0)
						echo str_replace('{WHO}',$nameofbfg,$lcms['news_empty']);
					else
						echo $lcms['news_not_found'];
					$cancont = false;
				};
                            
				//Добавляю массив с поднятыми новостями в обратном порядке
				$new_cat_upped = array_reverse($new_cat_upped);
				foreach ($new_cat_upped as $ncu)
					array_unshift($new_cat,$ncu);
				//
                            
				$gb_db = $new_cat;
  
				if (isset($_GET['searchtag']))
				{
					$tag      = $Filtr->clear($_GET['searchtag']);
					$newdb    = array();
					foreach ($gb_db as $gbdb)
					{
						$bd = explode("|",$gbdb);
						$tags = explode(",",$bd[4]);
						foreach ($tags as $ta)
						{
							if ($Filtr->tolower($tag)==$Filtr->tolower($GlobalTemplate->getonlywords($ta))) 
								$newdb[] = $gbdb;
						};
					};
					if (count($newdb)<1)
					{
						echo $lcms['news_not_found'];
						$cancont = false;
					}
					else
						$gb_db = $newdb;
				};
  
				if ($cancont)
				{ 
					$pos   = count($gb_db)-1;
					foreach ($gb_db as $gb_)
					{
                                         
						if ($Navigation->ShowPage(count($gb_db),$pos,$cms_nav_news) == True)
						{
							$pieces = explode("|",$gb_);
                               			
							if ($cms_views_counter == 1)
							{
								$counters = file($cms_root."/conf/".$type."/views.dat");
								foreach ($counters as $counter)
								{
									$c = explode("|",$counter);
									if ($c[0]==str_replace(".txt","",$pieces[6])) $counter_views = $c[1];
								};
								if ($counter_views<1)
									$counter_views = $lcms['views_0'];
								else
									$counter_views = $Filtr->truecount($counter_views,$lcms['views_one'],$lcms['views_much'],$lcms['views_much2']);
							};
							
							$ar = array("{URL}","{TITLE}","{DESCRIPTION}","{AUTHOR}","{DATE}","{CATURL}","{CATEGORY}",
									"{LIST}","{COMMENTS}","{COMURL}","{/LIST}","{VIEWS}","{THEMEPATH}",
									"{CANCOMMENTS}","{DAY}","{MONTH}","{YEAR}");
							if ($GlobalUsers->finduser($pieces[1])!=-1)
								$pieces[1]	=	'<a href="'.$Navigation->furl('viewprofile',$pieces[1]).'">'.$pieces[1].'</a>';

							//if ($pieces[12]=='') {
								
								$tmpcc = file($cms_root."/conf/".$type."/".str_replace(".txt","",$pieces[6]).".dat");
								$ntmpcc = array();
								$z	=	0;
								foreach ($tmpcc as $tmpc) {
									$tmpx = explode("|",$tmpc);
									if ($tmpx[6]!="no") $ntmpcc[] = $tmpc;
									if ($z==0) {
										$needfull	=	($tmpx[3]!=$pieces[3]) ? true : false;
									}
									$z++;
								};
							//} else 
							//	$needfull	=	true;
							if ($pieces[12]!='')
								$needfull = true;
							$pieces[3] = $GlobalTemplate->usebbcodes($pieces[3],'html',false,false);
							//$needfull	=	false;
							$pieces[3] = str_replace(array("[urlsite]","[themepath]"),array($cms_site,$cms_site."/themes/".$cms_theme),$pieces[3]);
                                                 
							//$pieces[3] = showhtmlcode($pieces[3]);
                                                 
							if (strstr($pieces[3],"[show_downloads="))
							{
								foreach ($pathsfile as $path)
								{
									$pat = explode("|",$path);
									$pieces[3] = preg_replace('|\[show_downloads='.$pat[0].'\]|Uis', get_downloads($pat[0]), $pieces[3]);
								};
							};
							$count_comments = count($ntmpcc)-1;
							if ($count_comments == 0)
								$count_comments = $lcms['comment_0'];
							else
								$count_comments = $Filtr->truecount($count_comments,$lcms['comment_one'],$lcms['comment_much'],$lcms['comment_much2']);
							if ($pieces[12]!="")
								$url = $Navigation->furl('bfglink',$type,$pieces[6]);
							else
								$url = $Navigation->furl('bfgfull',$type,$pieces[6]);
							//1.3
							$date	=	explode('>',$Filtr->fulldate($pieces[0],'00',false));
							
							$day	=	$date[0];
							$month	=	$date[1];
							$year	=	$date[2];
							//
							$br = array($url,$pieces[2],$pieces[3],$pieces[1],$Filtr->fulldate($pieces[0]),
									$Navigation->furl('category',$type,$GlobalTemplate->getonlywords($pieces[7])),$Filtr->clear($pieces[7]),"",$count_comments,
									$url."#messbox","",
									$counter_views,$cms_site."/themes/".$cms_theme,($pieces[10]=="Да") ? "" : "<!--",
									$day,$month,$year);
                                                 
							$echolist.=$GlobalTemplate->template($ar,$br,$cms_root."/themes/".$cms_theme."/newsrecord.html",$pieces[4],$type,false,true,array(),$needfull);
						};
						$pos-=1;
					};  
					$ar = array("{NEWS}","{PAGES}");
					$lp	=	'';
					if ($cms_furl!=1)
					{
						$lp	=	'&amp;viewpage='.$Filtr->clear($_GET['viewpage']);
						if (isset($_GET['category']))
							$lp	.=	'&amp;category='.$Filtr->clear($_GET['category']);
						if (isset($_GET['searchtag']))
							$lp	.=	'&amp;searchtag='.$Filtr->clear($_GET['searchtag']);
					};
					$br = array($echolist, $Navigation->Pager(count($gb_db),$lp,$cms_nav_news ));
					echo $GlobalTemplate->other($ar,$br,20);
				};
			};
		};
	}; 
};

