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

	define("ADMINCENTER", true);
	$theme_version	=	"0.2";
  $login 	= "no";
  $password 	= "no";
  $ttt		=	microtime();
  $ttt		=	((double)strstr($ttt, ' ')+(double)substr($ttt,0,strpos($ttt,' ')));
  include("../conf/config.php");
  if (!file_exists($cms_root.'/includes/core.php'))
  {
  	header('location: ../index.php');
  	exit;
  };
  include($cms_root."/includes/core.php");
  if ($cms_punycode==1)
  {
	require_once($cms_root.'/includes/idna_convert.class.php');
	$IDN = new idna_convert();
  };
  
  if (isset($_COOKIE['site_login'])) 
  	$login 		= $Filtr->clear($_COOKIE['site_login']);
  if (isset($_COOKIE['site_password']))
  	$password 	= $Filtr->clear($_COOKIE['site_password']);
  	  
  include($cms_root."/includes/languages/".$cms_language."/general.php");
  include($cms_root."/includes/languages/".$cms_language."/admin.php");
  
  $tmp58	=	$GlobalUsers->getstatus($login);

  if ($GlobalUsers->checkthisadmin()==true)
  {
     	
     	
     	$for_us_ 	= 	true;
     	if (isset($_GET['action']))
     		$action = $Filtr->clear($_GET['action']);
     	else
     	{
     		if ($GlobalUsers->getstatus($login)=='admin')
     			$action = "index";
     		else
     		{
     			$action = 'bfg';
     			$tmp	=	$GlobalUsers->getrules($login);
     			if (!strstr($tmp['bfg_types'],','))
     			{
     				$action='bfgshow';
     				$_GET['type']=$tmp['bfg_types'];
     			};
     		};
     	};
     	$ar 		= array("{TITLE}","{GENERATOR}","{ADMIN}","{NEWMESS}","{/NEWMESS}","{ADDINFO}","{COUNT_NEW}","{LOGO}","{BFGADD}","{GENERALMENU}");
     	$newmess 	= "<!-- ";
     	$cnewmess 	= " -->";
    	$count_new 	= "";
     	$cc 		=	count(file($cms_root."/conf/new_messages.dat")); 
     	if ($cc>0)
     	{
     		if ($GlobalUsers->getstatus($login)=='admin')
     		{
        		$newmess 	= 	"";
        		$cnewmess 	= 	"";
        		$count_new 	= 	$cc;
        	};
     	};
     	switch ($action)
     	{
		case "localmessage":
			$title	=	"Уведомление";
			break;
		case "bfgcommands":
			$title	=	"Специальные команды для новостей";
			break;
        	case "manager":
         		$title = "Файловый менеджер";
         		break;
        	case "general":
         		$title = "Основные настройки";
         		break;
        	case "edit":
         		$title = "Редактор файлов";
         		break;
        	case "style":
         		$title = "Оформление";
         		break;
        	case "news":
         		$title = "Новости";
         		break;
        	case "faq":
         		$title = "F.A.Q.";
         		break;
        	case "messages":
         		$title = "Комментарии";
         		break;
        	case "users":
         		$title = "Пользователи";
         		break;
        	case "blog":
         		$title = "Блог";
         		break;
        	case "system":
         		$title = "Обслуживание";
         		break;
        	case "bfg":
         		$title = "Новостные разделы";
         		break;
        	case "bfgshow":
         		$title = "Новостной раздел";
         		break;
        	case "downloads":
         		$title = "Счётчики загрузок";
         		break;
        	case "counts":
         		$title = "Счётчики просмотров";
         		break;
        	case "links":
         		$title = "Каталог ссылок";
         		break;
        	case "modules":
         		$title = "Другие модули";
         		break;
        	case "newmessages":
         		$title = "Новые сообщения";
         		break;
        	case "pages":
         		$title = "Страницы";
         		break;
        	case "votes":
         		$title = "Голосования";
         		break;
        	case "message":
         		$title = "Одиночные разделы для комментирования";
         		break;
        	case "rotator":
         		$title = "Ротатор баннеров";
         		break;
        	case "plugins":
         		$title = "Дополнения";
         		break;
        	case "smiles":
         		$title = "Смайлы";
         		break;
        	default:
         		$title = "Админ-центр Ruxe Engine";
     	};
     	if (
      		(date("d.m")=="11.02")
      		or
      		(date("d.m")=="22.04")
     	)
       		$logo = "birthday";
     	else
       		$logo = "rpanel";
     	$admin_ = "Вы вошли как <b>".$login."</b>";
     	$creator = false;
     	if (
     		($login=="Includen")
      		or
     		($login=="Dr1D")
     	) 
     	{
         	$tusers = file($cms_root."/conf/users/users.dat");
         	foreach ($tusers as $t)
         	{
              		$tt = explode("|",$t);
              		if (($Filtr->tolower($tt[18])==$Filtr->tolower("dr1d")) and ($Filtr->tolower($tt[2])=="dr1d@i.ua"))
              		{
                  		$creator = true;
                  		$admin_ = "Система ожидает Ваших указаний, <b>Создатель</b>";
                  		break;
              		};
              		if (($Filtr->tolower($tt[18])=="includen") and ($Filtr->tolower($tt[2])=="includen@gmail.com"))
              		{
                  		$creator = true;
                  		$admin_ = "Система ожидает Ваших указаний, <b>Создатель</b>";
                  		break;
              		};
         	};
     	};
     	$bfg = file($cms_root."/conf/bfg.dat");
     	$bfgadd="";
     	//if ($bfg[count($bfg)-1]=="") unset($bfg[count($bfg)-1]);
     	if (count($bfg)==1)
     	{
        	$t      = explode("|",$bfg[0]);
        	$bfgadd = "show&amp;type=".$t[0];
     	}; 
     	
     	if ($GlobalUsers->getstatus($login)=='admin')
     	{
     		$generalmenu ='
     				<li><a href="?action=index">Главная</a></li>
      				<li><a href="?action=pages">Страницы</a></li>
      				<li><a href="?action=bfg{BFGADD}">Новости</a></li>      
      				<li><a href="?action=users">Пользователи</a></li>
      				<li><a href="?action=modules">Другие модули</a></li>
      				<li><a href="?action=style">Оформление</a></li>
      				<li><a href="?action=manager">Файловый менеджер</a></li>
				<li><a href="?action=general">Настройки</a></li>
      				<li><a href="?action=system">Обслуживание</a></li>';
      	}
      	else
      	{
      		$tmp	=	$GlobalUsers->getrules($login);
      		$generalmenu = '<li><a href="?action=bfg{BFGADD}">Новости</a></li>';
      		if ( ($tmp['comments_edit']==true) or ($tmp['plugins_use']==true))
      			$generalmenu.='<li><a href="?action=modules">Другие модули</a></li>';
      		if (!strstr($tmp['bfg_types'],','))
      			$bfgadd = 'show&amp;type='.$tmp['bfg_types'];
      	};
      	$generalmenu = str_replace('{BFGADD}',$bfgadd,$generalmenu);
     	
     	($action=="users") ? $br = array($title,"Ruxe Engine (ruxe-engine.ru)",$admin_,$newmess,$cnewmess," onLoad='checkpoles();'",$Filtr->truecount($count_new,"новое сообщение","новых сообщений","новых сообщения"),$logo,$bfgadd, $generalmenu) : $br = array($title,"Ruxe Engine (ruxe-engine.ru)",$admin_,$newmess,$cnewmess,"",$Filtr->truecount($count_new,"новое сообщение","новых сообщений","новых сообщения"),$logo,$bfgadd, $generalmenu);
     	header("Cache-Control: no-store"); 
     	header("Expires: " .  date("r"));
     	header('Content-type: text/html; charset=utf-8');
     	echo $GlobalTemplate->template($ar,$br,$cms_root."/rpanel/theme/admincenterstart.tpl");
     	switch ($action)
     	{
	
        	case "index":
        		$GlobalUsers->access(1);
         		$whatdoing	= "Главная страница центра";
         		$ar 		= array("{ALL_HITS}","{MESSAGE}","{ALL_HOSTS}","{HITS}","{LAST_HOSTS}","{SERVER_TIME}","{HOSTS}",
  						"{ONLINE}","{BOTS}","{RSS_NEWS}","{DEFAULT_ROOT}","{register_globals}","{register_long_arrays)",
  						"{NOTEPAD}","{RAND}","{WHOONLINE}", "{TIME_RECORD}","{INSTALL}","{UTCTIME}","{MESSAGES}");
  			$hello 		= "";
  			$whoonline 	= "";
  			if (isset($_GET['go']))
  			{
      				if (isset($_POST['message']))
      				{
           				$notepad = fopen($cms_root."/conf/notepad.dat","w");
           				//$message = str_replace("\\\\", "\\", $_POST['message']);
           				//$message = str_replace("\'", "'", $message);
           				//$message = str_replace('\"', '"', $message);
           				$message = $Filtr->clear($_POST['message']);
           				fwrite($notepad,$message);
           				fclose($notepad);
           				$hello = " (Сохранено)";
      				};
  			};
  			$who = file($cms_root."/conf/online_users.dat");
  			foreach ($who as $wh)
  			{
     				$w 	= explode("|",$wh);
     				$add 	= "";
     				if ($w[4]!="")
        				$add = ' (<a href="'.$Navigation->furl('viewprofile',$w[4]).'" target="_blank">'.$w[4].'</a>)';
     				$showed = $w[1];
     				$whoonline.="<tr><td>".$Filtr->ipclick($w[0]).$add."</td><td><a href=\"".$w[1]."\" target=\"_blank\">".$showed."</a></td><td>".$w[3]."</td></tr>\r\n";
  			};
  			$all_hits = file($cms_root."/conf/all_hits.dat");
  			$all_hosts = file($cms_root."/conf/all_hosts.dat");
  			$hits = file("../conf/hits.dat");
  			$last_hosts = file("../conf/last_hosts.dat");
  			$ip_file = file("../conf/ip.dat");    
  			$today_hosts = 0;
  			foreach ($ip_file as $ip_file_)
  			{
      				$ip_file__ = explode("|",$ip_file_);
      				if ($ip_file__[1] == "people")
        				$today_hosts++;
  			};
  			$today_bots = 0;
  			foreach ($ip_file as $ip_file_)
  			{
      				$ip_file__ = explode("|",$ip_file_);
      				if ($ip_file__[1] == "bot")
        				$today_bots++;
  			};
  			$notepad_file = file("../conf/notepad.dat");
  			$notepad = "";
  			foreach ($notepad_file as $notepad_)
      				$notepad .= $notepad_; 
  			if (ini_get('register_globals')) 
  				$jfj = "Включен";
  			else
  				$jfj = "Выключен";
  			if (ini_get('register_long_arrays'))
  				$ofj = "Включен";
  			else
  				$ofj = "Выключен";
  			$install = "";


			/*
			 *
			 */
  			if (file_exists($cms_root."/install.php"))
  			{
       					$install .= '
       							<tr class="titlered"><td colspan=2>БЕЗОПАСНОСТЬ ПОД УГРОЗОЙ</td></tr>
       							<tr class="redtd"><td colspan=2><a style="color:black; font-weight:bold;" href="?action=manager" target="_blank">Удалите файл install.php из каталога с сайтом</a>,<br>чтобы злоумышленник не смог переписать учётную запись
       					главного администратора</td></tr>
       					';
  			};
  			if (file_exists($cms_root."/update.php"))
  			{
       					$install .= '
       						<tr class="titlegreen"><td colspan=2>НЕЖЕЛАТЕЛЬНАЯ УГРОЗА</td></tr>
       						<tr class="greentd"><td colspan=2><a style="color:black; font-weight:bold;" href="?action=manager" target="_blank">Удалите файл update.php из каталога с сайтом</a>,<br>если Вы уже выполнили обновление</td></tr>
       					';
  			};
			if ($cms_closed==1)
  			{
       					$install .= '
       						<tr class="titlegreen"><td colspan=2>САЙТ ЗАКРЫТ</td></tr>
       						<tr class="greentd"><td colspan=2>В данный момент доступ к сайту посетителям закрыт<br><a style="color:black; font-weight:bold;" href="?action=general#close">Не забудьте отрыть сайт после окончания технических работ</a></td></tr>
       					';
  			};
  
  			if (function_exists('file_get_contents')) {
				$this_date    = date("d.m.y");
				$checkVerFile = file("../conf/last_checkver.dat");
				$ld           = "";
				foreach ($checkVerFile as $line)
					$ld .= str_replace(array("\r", "\n"), "", $line);
				$ls           = explode("|",$ld);
				$ls[2] = (int)$ls[2];
				$new_version  = $ls[1];
				if ($this_date != $ls[0]) {
					if ($ls[2] >= 2) {
						$new = fopen("../conf/last_checkver.dat","w");
						fwrite($new, $this_date."|".$ls[1]."|1|");
						fclose($new);
						$new_version = @file_get_contents("http://ruxe-engine.ru/lastver.html");
						if ($new_version!='')
						{
								$new         = fopen("../conf/last_checkver.dat","w");
								fwrite($new, $this_date."|".$new_version."|1|");
								fclose($new);
						}
						else
							$new_version = $this_version;
					} else {
						$ls[2]++;
						$new         = fopen("../conf/last_checkver.dat","w");
						fwrite($new, $this_date."|".$ls[1]."|".$ls[2]."|");
						fclose($new);
					}
				}

				if ($new_version!=$this_version) {
						$install .= '<tr class="titlegreen"><td colspan=2>ДОСТУПНО ОБНОВЛЕНИЕ</td></tr>
					<tr class="greentd"><td colspan=2>У Вас установлена '.$this_version.' версия, в то время как последняя версия '.$new_version.'<br>
					Настоятельно рекомендуется <a style="color:black; font-weight:bold;" href="http://ruxe-engine.ru">обновиться до новой версии</a></td></tr>';
				}
  			}

  			include("../conf/backup.php");
  			$backup = explode(".",$backup_date);
  			$now    = mktime("00","00","00",date("m"),date("d"),date("Y"));
  			$last   = mktime("00","00","00",$backup[1],$backup[0],$backup[2]);
  			$days   = floor(($now-$last)/86400);
  			if ($days>10)
  			{  
  				$install .= '<tr class="titlegreen"><td colspan=2>РЕЗЕРВНОЕ КОПИРОВАНИЕ ПАРАМЕТРОВ</td></tr>
     					<tr class="greentd"><td colspan=2>Вы не <a style="color:black;font-weight:bold;" href="?action=system#backup">обновляли резервную копию параметров</a> более 10 дней</td></tr>';
  			};
			//последние комментарии
			$messages	=	'';
			
			$last_posts = file($cms_root."/conf/last_posts.dat");
			$last_posts = array_reverse($last_posts);
			$i = 1;			
			foreach ($last_posts as $last_post) {
				$l	=	explode('|',$last_post);
				if ($i<=$cms_lastposts_count) {
					
					//Составление ссылок правки
					//1.4
					$listmess= file($cms_root.'/conf/messages/listmess.dat');
					$founded = false;
					if ($l[0]=='messages') {
						//downloads|Загрузки|
						$x	= 0;
						foreach ($listmess as $listline) {
							$n = explode('|',$listline);
							if ($n[1]==$l[6]) {
								$founded= true;
								$path	= $cms_root.'/conf/messages/mess_'.$n[0].'.dat';
								break;
							}
							$x++;
						}
					} else {
						$founded= true;
						$path	= $cms_root.'/conf/'.$l[0].'/'.$l[5].'.dat';
					};
					$items  = '';
					if ($founded) {
						$fp	= file($path);
						$z	= 0;
						foreach ($fp as $fline) {
							
							$it	= explode('|',$fline);
							/* $l[0] откуда messages news
								* $l[1] кто имя
								* $l[2] опубликован или нет yes no
									* $l[3] дата
										* $l[4] комментарий
								* $l[5] страница или новость
									* $l[6] заголовок новости или имя (не ИД!) раздела комментариев
								*/
							//23.05.11, 21:07|Денис|admin@domain.here|dasd||127.0.0.1|yes|
							//22.08.11, 07:40|admin|admin@domain.here|dasd||127.0.0.1|yes|
							
							if ( 	($it[0] == $l[3])
								and
								($it[1] == $l[1])
								and
								($it[3] == $l[4])
								) {
								
								if ($l[0] == 'messages') {
									//saver.php?saverdo=showmess&from=message&file=downloads&line=0&addline=0
									$showinglink	= 'saver.php?saverdo=showmess&amp;from=message&amp;file='.$n[0].'&amp;line='.$z.'&amp;addline='.$x;
									//http://dev/rpanel/index.php?action=messages&from=message&go=edit&message=downloads&line=0&addline=1
									$editlink	= 'index.php?action=messages&amp;from=message&amp;go=edit&amp;message='.$n[0].'&amp;line='.$x.'&amp;addline='.$z;
									//saver.php?saverdo=delcomment&amp;type=message&amp;message=downloads&amp;addline=0&amp;line=0
									$dellink	= 'saver.php?saverdo=delcomment&amp;type=message&amp;message='.$n[0].'&amp;addline='.$x.'&amp;line='.$z;
								} else {
									//saver.php?saverdo=showmess&from=news&file=pozdravlyaem-s-ustanovkoy&line=3&lastline=
									$showinglink	= 'saver.php?saverdo=showmess&amp;from='.$l[0].'&amp;file='.$l[5].'&amp;line='.$z.'&amp;lastline=';
									//http://dev/rpanel/index.php?action=messages&from=news&go=edit&news=pozdravlyaem-s-ustanovkoy&line=3
									$editlink 	= 'index.php?action=messages&amp;from='.$l[0].'&amp;go=edit&amp;news='.$l[5].'&amp;line='.$z;
									//saver.php?saverdo=delcomment&amp;type=news&amp;news=pozdravlyaem-s-ustanovkoy&amp;line=1
									$dellink	= 'saver.php?saverdo=delcomment&amp;type='.$l[0].'&amp;news='.$l[5].'&amp;line='.$z;
								}
								$showing = ($l[2] == 'yes') ? 'Скрыть' : 'Отобразить';
								$showinglink.= ($l[2] == 'yes') ? '&amp;withdo=hidecomment' : '';
								$items = '<a href="'.$showinglink.'">'.$showing.'</a> <a href="'.$editlink.'">Изменить</a> <a href="#" onClick="if (checkhead()) location.href=\''.$dellink.'\';">Удалить</a>';
								break;
							};
							$z++;
						}
					}
					//
					if ($l[0]=='messages') {
						if ($cms_furl==1)
							$rew	=	$cms_site.'/'.$l[5];
						else
							$rew	=	$cms_site.'/?viewpage='.$l[5];
						$cmes	=	file($cms_root.'/conf/messages/listmess.dat');
						$cline	=	0;
						$cmessage	=	'';
						$ci	=	0;
						foreach ($cmes as $cme) {
							$cm	=	explode('|',$cme);
							if ($cm[1]==$l[6]) {
								$cline	=	$ci;
								$cmessage	=	$cm[0];
								break;
							};
							$ci++;
						};
						$res	=	'?action=messages&amp;from=message&amp;line='.$cline.'&amp;message='.$cmessage;
					} else {
						$rew 	= 	$Navigation->furl('bfgfull',$l[0],$l[5]);
						$res	=	'?action=messages&amp;from='.$l[0].'&amp;news='.$l[5];
					};
					$l[4] = $GlobalTemplate->usebbcodes($l[4],'lastposts');
					if ($l[2]=='yes') {
						$bc		=	'titletable';
						$bf		=	'';
						$bd		=	'';
					} else {
						$bc		=	'titleblue';
						$bd		=	' class="bluetd"';
						$bf		=	'(НЕ ОПУБЛИКОВАН) ';
					};
					$user = $GlobalUsers->finduser($l[1]);
					$needcenzura	=	true;
					if ($user!=-1) {
						$pie	=	explode('|',$fileusers[$user]);
						if ($pie[4] == "admin")
							$needcenzura	=	false;
						$l[1]	=	'<a class="black" href="'.$Navigation->furl('viewprofile',$l[1]).'">'.$l[1].'</a>';
					} else
						$l[1]	=	'<b>'.$l[1].'</b>';
					$l[4] 	=	$GlobalTemplate->usebbcodes($Filtr->textmax($l[4],$cms_lastposts_len,'...'),'html',false,$needcenzura);
					$l[4]	=	preg_replace('|<([^>]*)\.\.\.|uUis','...',$l[4]);
					$messages 	.= '
								<br><table class="optionstable" border=0 cellpadding=1 cellspacing=0>
									<tr class="'.$bc.'"><td style="border-right: 0px;"><a href="'.$res.'">'.$l[6].'</a></td><td style="text-align:right;">'.$items.'</td></tr>
									<tr'.$bd.'><td colspan=2 style="text-align:left; font-weight: normal;">
										<font style="font-weight: bold; font-size:8pt;">'.$l[3].', '.$l[1].':</font>
										<div style="margin: 5px 0 5px 15px;">
											'.$l[4].'
										</div>
									</td></tr>
								</table>
							';
				}
				$i++;
			};
  			$br = array($all_hits[0],$hello,$all_hosts[0],$hits[0],$last_hosts[0],date("d.m.y H:i:s"),$today_hosts,
  				count(file("../conf/online_users.dat")),$today_bots,($cms_furl==1) ? $cms_site.'/rss' : $cms_site.'/?action=rss',$_SERVER['DOCUMENT_ROOT'],$jfj,$ofj,
				$notepad,rand(0,99999),$whoonline,$cms_online_time,$install,$Filtr->gettimezonedate(),$messages);
  			$echooptions = $GlobalTemplate->template($ar,$br,"./theme/stat.tpl");
  			$ar = array("{MENU}","{OPTIONS}");
  			$br = array("",$echooptions);
  			echo $GlobalTemplate->template($ar,$br,"./theme/admincenteroptions.tpl");
         		break;
        	case "bfg":
         		$whatdoing="Новостные разделы";
         		$ar = array("{MENU}","{LIST}");
         		if ($GlobalUsers->access(2))
   				$menu = '<input type="button" onClick="location.href=\'?action=bfg&amp;go=new\';" value="Создать раздел"><br><br>';
			else
				$menu = '';   				
   
   			if (isset($_GET['go']))
   			{
   				$GlobalUsers->access(1);
      				switch ($_GET['go'])
      				{
          				case "new":
               					$menu = '
               						<center>
                						<form name="add" method="post" action="saver.php?saverdo=bfgnew">
                 						<table class="optionstable" border=0 cellpadding=1 cellspacing=0>
                  							<tr class="titletable"><td colspan=2>НОВЫЙ НОВОСТНОЙ РАЗДЕЛ</td></tr>
                  							<tr><td>Идентификатор:<br><font class="desc">Например, <b>news</b></font></td>
                   								<td><input type="text" maxlength=9 size=46 name="type"></td></tr>
                  							<tr><td>Описание:<br><font class="desc">Например, <b>Новоcти</b></font></td>
                   									<td><input type="text" maxlength=100 size=46 name="description"></td></tr>
                  								<tr><td>Страница, где указана или будет команда <b>&lt;?php here_news...</b>:</td>
                   								<td><select name="page1">
                  				';
                  				$pages = file("../conf/pages/config");
                  				$c = 0;
                  				foreach ($pages as $page)
                  				{
                      					$p = explode("|",$page);
                      					$showers = $p[0];
							if ($cms_furl==1)
								$ass	=	'';
							else
								$ass	=	'?viewpage=';
                      					if ($p[0] == "index")
							{
								$showers = '';
								$ass='';
							};
                      					($c == 1) ? $menu .= '<option value="'.$p[0].'" selected>'.$cms_site.'/'.$ass.$showers : $menu .= '<option value="'.$p[0].'">'.$cms_site.'/'.$ass.$showers;
                      					$c++;
                  				}; 
                  				$menu .= ' </select></td></tr>
                  						<tr class="titletable"><td colspan=2><input type="submit" name="submit" value="Создать раздел"></td></tr>
                 						</table>
                						</form>
               						</center><br>
               					';
               					break;
          				case "view":
               					break;
          				case "edit":
               					$bfg = file("../conf/bfg.dat");
               					$b = explode("|",$bfg[$_GET['pos']]);
               					$menu.= '
               						<center>
                						<form name="add" method="post" action="saver.php?saverdo=bfgedit">
                 						<table class="optionstable" border=0 cellpadding=1 cellspacing=0>
               								   <tr class="titletable"><td colspan=2>ИЗМЕНИТЬ НОВОСТНОЙ РАЗДЕЛ</td></tr>
             							     <tr><td>
             								     <input type="hidden" name="pos" value="'.$_GET['pos'].'">
             								     Идентификатор:<br><font class="desc">Например, <b>news</b></font></td>
            						       <td><input type="text" maxlength=9 size=46 readonly name="type" value="'.$b[0].'"></td></tr>
            							      <tr><td>Описание:<br><font class="desc">Например, <b>Новоcти</b></font></td>
           										        <td><input type="text" maxlength=100 size=46 name="description" value="'.$b[1].'"></td></tr>
           								       <tr><td>Страница, где указана или будет команда <b>&lt;?php here_news...</b>:</td>
         								          <td><select name="page1">
                  				';
                  				$pages = file("../conf/pages/config");
                  				foreach ($pages as $page)
                  				{
                      					$p = explode("|",$page);
							if ($cms_furl==1)
								$ass='';
							else
								$ass='?viewpage=';
                      					$showers = $p[0];
                      					if ($p[0] == "index")
							{
								$showers = '';
								$ass='';
							};
                      					($b[2] == $p[0]) ? $menu .= '<option value="'.$p[0].'" selected>'.$cms_site.'/'.$ass.$showers : $menu .= '<option value="'.$p[0].'">'.$cms_site.'/'.$ass.$showers;
                  				}; 
                  				$menu .= ' </select></td></tr>
                  
                  					<tr class="titletable"><td colspan=2><input type="submit" name="submit" value="Сохранить изменения"></td></tr>
                 						</table>
                						</form>
               						</center><br>
               					';
               					break;
      				};
	   		};
   
   			$bfglist = file("../conf/bfg.dat");
   			$list = array();
   			$i = 0;
   			foreach ($bfglist as $b)
   			{
      				$bfg = explode("|",$b);
				
      				if ($GlobalUsers->access(3,$bfg[0]))
      				{
					if ($cms_furl==1)
						$ass='';
					else
						$ass='?viewpage=';
					if ($bfg[2]=="index")
					{
						$bfg[2]="";
						$ass='';
					};
      					/*$list .= '<tr><td><a href="?action=bfgshow&amp;type='.$bfg[0].'">'.$bfg[0].'</a></td><td>'.$bfg[1].'</td><td>'.$cms_site."/".$ass.$bfg[2].'</td><td><a href="?action=bfgshow&amp;type='.$bfg[0].'">Войти в раздел</a>';
      					if ($GlobalUsers->getstatus($login)=='admin')
      						$list.=' <a href="?action=bfg&amp;go=edit&amp;pos='.$i.'">Параметры</a> <a href="#" onClick="if (checkhead()) location.href=\'saver.php?saverdo=bfgdelete&amp;pos='.$i.'\';">Удалить</a>';
      					$list .='	</td></tr>';
					onClick="location.href=\'?action=bfgshow&amp;type='.$bfg[0].'\';"
					document.getElementById(\'bfgtd'.$i.'\').style.background=\'#D9D9FF\';
					*/
      					
      					$tmp	=	'<div class="bfgdiv" id="bfgtd'.$i.'" 
									
									onMouseOut="document.getElementById(\'bfgfoot'.$i.'\').style.display=\'none\'; document.getElementById(\'bfgline'.$i.'\').style.display=\'none\'; document.getElementById(\'bfgtd'.$i.'\').className=\'bfgout\';" 
									onMouseOver="document.getElementById(\'bfgfoot'.$i.'\').style.display=\'inline\'; document.getElementById(\'bfgline'.$i.'\').style.display=\'inline\'; document.getElementById(\'bfgtd'.$i.'\').className=\'bfgover\';">
										<div style="display:none;" id="bfgline'.$i.'">
											<font style="float:right; font-size:8pt;">'.count(file($cms_root.'/conf/'.$bfg[0].'/list.dat')).' зап.</font>
											<font style="font-size:8pt;">ID: '.$bfg[0].'</font>
										</div>&nbsp;
										
										<center>
											<div style="margin: 5px 0 8px 0;"><a id="bfglink'.$i.'" style="font-weight: bold; color: #0000A0; font-size:16pt;" href="?action=bfgshow&amp;type='.$bfg[0].'">'.$bfg[1].'</a></div>
											<div style="display:none;" id="bfgfoot'.$i.'">
												<a style="color: #0000A0; font-size:8pt;" href="?action=bfgshow&amp;type='.$bfg[0].'">Новости</a> ';
					if ($GlobalUsers->getstatus($login)=='admin')
						$tmp	.=	'				<a style="color: #0000A0; font-size:8pt;" href="?action=bfg&amp;go=edit&amp;pos='.$i.'">Изменить</a>
												<a style="color: #0000A0; font-size:8pt;" href="#" onClick="if (checkhead()) location.href=\'saver.php?saverdo=bfgdelete&amp;pos='.$i.'\';">Удалить</a>
												';
					$tmp	.=	'				</div>&nbsp;
										</center>
								
							</div>';
					$list[]	=	$tmp;
      				};
      				$i++;
   			};
   			$lists	=	'<center><table width="93%" border=0 cellpadding=0 cellspacing=0><tr><td>';
			foreach ($list as $l)
				$lists.=$l;
			$lists	.= 	'</td></tr></table></center>';
   			$br = array($menu,$lists);
   			$options = $GlobalTemplate->template($ar,$br,"./theme/bfg.tpl");
   			$ar = array("{MENU}","{OPTIONS}");
   			$br = array("",$options);
   			echo $GlobalTemplate->template($ar,$br,"./theme/admincenteroptions.tpl");
         		break;
		case "localmessage":
			$whatdoing	=	"Уведомление";
			if (!isset($_GET['line']))
			{
				$message	=	$acms['without_get_message'];
				$title		=	$acms['without_get_title'];
				$back		=	'?action=index';
			}
			else
			{
				$message	=	$acms[$Filtr->clear($_GET['line']).'_message'];
				$title		=	$acms[$Filtr->clear($_GET['line']).'_title'];
				$back		=	(isset($acms[$_GET['line'].'_back'])) ? $acms[$Filtr->clear($_GET['line']).'_back'] : 'none';
			};
			$options	=	'
						<br><br><br><br>
						<center>
							<table class="optionstable2" width="700" cellpadding=1 cellspacing=0 border=0>
								<tr class="titleblue"><td>'.$title.'</td></tr>
								<tr class="bluetd"><td><p>'.$message.'</p></td></tr>
								';
			if ($back!='none') 
				$options.=	'<tr class="sub"><td><input type="button" onClick="location.href=\''.$back.'&rand='.rand(1,99999).'\';" value="Вернуться"></td></tr>';
			$options.=	'		</table>
							<br><br><br>
						</center>
			';
			$ar = array("{MENU}","{OPTIONS}");
   			$br = array('',$options);
  			echo $GlobalTemplate->template($ar,$br,"./theme/admincenteroptions.tpl");
         		break;
        	case "manager":
        		$GlobalUsers->access(1);
         		$whatdoing="Файловый менеджер";
         		$ololo = $cms_root;
			if ($ololo = "./")
			{
     				$ololo = "..";
			};
			$url = $ololo;
			$files = "";
			$menu = "";
			$message = "";
			$ar = array("{MESSAGE}","{DIRECTORY}","{FILES}");
			if(isset($_GET['url'])) {$url = $Filtr->clear($_GET['url']); };
			$message .= '
					<input type="button" onClick="location.href=\'?action=manager&amp;url='.$ololo.'\';" value="Домой">
					<input type="button" onClick="location.href=\'?action=manager&amp;url='.$FileManager->updir($url).'\';" value="Каталогом выше">
					<input type="button" onClick="location.href=\'?action=manager&amp;makedir=1&amp;url='.$url.'\';" value="Создать папку">
					<input type="button" onClick="location.href=\'?action=manager&amp;makefile=1&amp;url='.$url.'\';" value="Создать файл">
					<input type="button" onClick="location.href=\'?action=manager&amp;upload=1&amp;url='.$url.'\';" value="Загрузить">
			';

			if($FileManager->listing($url,1)) 
			{
      				foreach($FileManager->listing($url,1) as $f) 
      				{
          				if (is_writable($url."/".$f."/"))
          				{
            					$writed = "Есть";
          				}
          				else
            					$writed = "Нет";
            				//<input type=\"button\" onClick=\"location.href='?action=manager&amp;chmod=1&amp;url=".$url."&amp;type=folder&amp;fname=".$f."';\" value=\"Права\">
          				$files.= "<tr><td align=\"center\"><a href=\"?action=manager&amp;url=".$url."/".$f."&amp;oldurl=".$url."\"><img src=\"theme/images/dir.png\" alt=\"\" border=0></a></td>";
          				$files.= "<td><a href=\"?action=manager&amp;url=".$url."/".$f."&amp;oldurl=".$url."\">".$f."</a></td>\r\n";
          				$files.= "<td>-</td><td>".$writed."</td><td align=\"center\">
          						<input type=\"button\" onClick=\"location.href='?action=manager&amp;rename=1&amp;url=".$url."&amp;fname=".$f."';\" value=\"Переименовать\"> 
          						 
          						<input type=\"button\" onClick=\"if (checkhead()) location.href='saver.php?saverdo=deldir&amp;url=".$url."&amp;fname=".$f."';\" value=\"Удалить\"> </td></tr>\r\n";
      				};
			};
  
			if($FileManager->listing($url,0)) 
			{
				$z	=	0;
      				foreach($FileManager->listing($url,0) as $f)
      				{
      					$z++;
        				if (is_writable($url."/".$f))
          				{
            					$writed = "Есть";
          				}
          				else
            					$writed = "Нет";
        				$size  = $FileManager->fsize($url."/".$f);
					if (str_replace('.',"",$size)==$size) $size = floor($size);
					if (substr($size,strpos($size,'.'),strlen($size))==0) $size = floor($size);
       					$files.= "<tr><td align=\"center\"><img src=\"theme/images/file.png\" alt=\"\" border=0></td>";
        				$files.= "<td>".$f."</td>\r\n";
        				//<input type=\"button\" onClick=\"location.href='?action=manager&amp;type=file&amp;chmod=1&amp;url=".$url."&amp;fname=".$f."';\" value=\"Права\">
        				$files.= "<td>".$size." Кб</td><td>".$writed."</td><td align=\"center\">
        				<div style=\"display:none;margin:5px;\" id=\"pathfile".$z."\">
        					<input type=\"text\" id=\"pf".$z."\" value=\"".str_replace($cms_root,$cms_site,realpath($url.'/'.$f))."\" size=33><br>
        				</div><input type=\"button\" id=\"butfile".$z."\" onClick=\"document.getElementById('butfile".$z."').style.display='none'; document.getElementById('pathfile".$z."').style.display='block'; document.getElementById('pf".$z."').select();\" value=\"Адрес\">
        				<input type=\"button\" style=\"margin-bottom:5px\" onClick=\"location.href='?action=downloads&amp;go=add&amp;url=".str_replace('\\','/',str_replace($cms_root,$cms_site,realpath($url.'/'.$f)))."';\" value=\"Создать счётчик загрузок\"><br>
        						<input type=\"button\" onClick=\"location.href='?action=manager&amp;rename=1&amp;url=".$url."&amp;fname=".$f."';\" value=\"Переименовать\">
        						
        						<input type=\"button\" onClick=\"location.href='?action=edit&amp;file=".$url."/".$f."';\" value=\"Правка\">
        							
        							<input type=\"button\" onClick=\"if (checkhead()) location.href='saver.php?saverdo=delfile&amp;url=".$url."&amp;fname=".$f."';\" value=\"Удалить\"></td></tr>\r\n";
      				};
			};

			if(isset($_GET['makedir']))
			{
           			$message.= "<br><form name=\"createfolder\" action=\"saver.php?saverdo=makedir\" method=\"post\">";
           			$message.= "Имя новой папки:<br>";
           			$message.= "<input name=\"ndir\" type=\"text\" maxlength=\"75\">";
           			$message.= "<input name=\"url\" type=\"hidden\" value=\"".$Filtr->clear($_GET['url'])."\">";
           			$message.= "<input type=\"submit\" name=\"add\" value=\"Создать\"></form><br>"; 
			};

			if(isset($_GET['makefile']))
			{
           			$message.= "<br><form name=\"createfile\" action=\"saver.php?saverdo=makefile\" method=\"post\">";
           			$message.= "Имя нового файла:<br>";
           			$message.= "<input name=\"ndir\" type=\"text\" maxlength=\"75\">";
           			$message.= "<input name=\"url\" type=\"hidden\" value=\"".$Filtr->clear($_GET['url'])."\">";
           			$message.= "<input type=\"submit\" name=\"add\" value=\"Создать\"></form><br>"; 
			};

			if (isset($_GET['upload']))
			{
    				$message.="<br><form name=\"uploadform\" action=\"saver.php?saverdo=uploadfile&amp;rand=".rand(1,999999)."\" method=\"post\" enctype=\"multipart/form-data\">
 				Отправить этот файл: <input name=\"userfile\" type=\"file\">
 				<input type=\"hidden\" name=\"url\" value=\"".$Filtr->clear($_GET['url'])."\">
 					<input type=\"submit\" name=\"submit\" value=\"Отправить\">
				</form><br>
				";
    
			};

			if(isset($_GET['chmod']))
			{
                  		$message.= "<br><form name=\"changechmod\" action=\"saver.php?saverdo=changechmod\" method=\"post\">";
                  		$message.= "Права на запись:<br>";
                  		$message.= "<select name=\"chmod\"><option value=\"yes\" selected>Да<option value=\"no\">Нет</select>";
                  		$message.= "<input name=\"type\" type=\"hidden\" value=\"".$Filtr->clear($_GET['type'])."\"><input name=\"fname\" type=\"hidden\" value=\"".$Filtr->clear($_GET['fname'])."\"><input name=\"url\" type=\"hidden\" value=\"".$Filtr->clear($_GET['url'])."\">";
                  			$message.= "<input type=\"submit\" name=\"add\" value=\"Сохранить\"></form><br>";
			};

			if(isset($_GET['rename']))
			{
                               $message.= '<br><form name="editname" action="saver.php?saverdo=rename" method="post">';
                               $message.= 'Новое имя:<br>';
                               $message.= '<input name="nname" type="text" value="'.$Filtr->clear($_GET['fname']).'" maxlength="25">';
                               $message.= '<input name="url" type="hidden" value="'.$Filtr->clear($_GET['url']).'">';
                               $message.= '<input name="oldname" type="hidden" value="'.$Filtr->clear($_GET['fname']).'">';
                               $message.= '<input type="submit" name="rename" value="Сохранить"></form><br>'; 
			};


   			$br = array($message,$url,$files);
   			$options = $GlobalTemplate->template($ar,$br,"./theme/manager.tpl");
   			$ar = array("{MENU}","{OPTIONS}");
   			$br = array($menu,$options);
  			echo $GlobalTemplate->template($ar,$br,"./theme/admincenteroptions.tpl");
         		break;
        	case "general":
        		$GlobalUsers->access(1);
         		$whatdoing="Основные настройки";
  			$message = "";
  			$ar = array("{DESCRIPTION}","{SITE}","{CREDITS}","{DAYVOTE1}","{DAYVOTE2}","{DAYVOTE3}",
  					"{HTTPSHOW1}","{HTTPSHOW2}","{NOINDEXSHOW1}","{NOINDEXSHOW2}","{RSS}","{ROOT}",
  					"{ERSHOW1}","{ERSHOW2}","{ERSHOW3}","{MAIL}","{TIME_COOKIE}","{CLSHOW1}","{CLSHOW2}","{CLOSED_TEXT}","{COMMENTSSHOW1}",
  					"{COMMENTSSHOW2}","{SMILESSHOW1}","{SMILESSHOW2}","{PREMODERSHOW1}","{PREMODERSHOW2}","{MESHOW1}","{MESHOW2}","{REC_PAGE}",
  					"{NOFLOOD}","{NOCSHOW1}","{NOCSHOW2}","{BANSHOW1}","{BANSHOW2}","{LOSHOW1}","{LOSHOW2}","{ALSHOW1}","{ALSHOW2}","{RESHOW1}",
  					"{RESHOW2}","{ONLINETIME}","{BANLOGSHOW1}","{BANLOGSHOW2}","{GZIPSHOW1}","{GZIPSHOW2}","{KEYS}","{MESSAGE}","{TOP_COUNT}",
  					"{TOPSHOWSHOW1}","{TOPSHOWSHOW2}","{VIEWS_COUNTER1}","{VIEWS_COUNTER2}","{MAX_MESSAGE}","{MAIL_SELECT}",
  					"{SAVE_ADMIN_IP1}","{SAVE_ADMIN_IP2}","{REWRITE1}","{REWRITE2}","{ACTIVE1}","{ACTIVE2}","{ACTIVE_MAIL}","{ACTIVE_NAME}",
  					"{AVATARS1}","{AVATARS2}","{UPLOAD_MAXSITE}","{UPLOAD_WIDTH}","{UPLOAD_HEIGHT}","{RESTORE1}","{RESTORE2}",
  					"{PS1}","{PS2}","{PS_MAX}","{PLUS1}","{PLUS2}", "{REWRITE_EXT}","{CENZURA1}","{CENZURA2}","{CENZURA_WORDS}","{LASTPOSTS_COUNT}",
  					"{LASTPOSTS_LEN}","{RSS_ID}","{THEMES}","{DIRECTDOWNLOAD1}","{DIRECTDOWNLOAD2}","{FULLREDIRECT1}","{FULLREDIRECT2}",
  					"{PM_MAX}","{PM_SHOWUSERS1}","{PM_SHOWUSERS2}","{RESIZE1}","{RESIZE2}","{MAXRESIZE}","{LOG_MAX}","{SUBSTRERROR}","{SUBSTRERROR2}",
  					"{SUBSTRERROR3}","{GDERROR}","{GRAVATARS1}","{GRAVATARS2}","{GRAVATARS_IM}","{GUEST1}","{GUEST2}","{LANGUAGES}",
  					"{CREATELINKS1}","{CREATELINKS2}","{SEND_MAIL}","{SERVERDATE}","{UTCDATE}","{TIMEZONE}","{ADMINM1}","{ADMINM2}",
  					"{AL}","{FONTFAMILY}","{FONTSIZE}","{NAV_NEWS}","{NAV_COMMENTS}","{NAV_DOWNLOADS}","{NAV_FAQ}","{NAV_PM}",
  					"{NAV_SYSTEM}","{EDITAREA1}","{EDITAREA2}","{EDITAREAWP1}","{EDITAREAWP2}","{ONEIPREG1}","{ONEIPREG2}","{ERSHOW4}",
  					"{HIDE_ADMIN1}","{HIDE_ADMIN2}","{WITHOUT_MAIL1}","{WITHOUT_MAIL2}","{UNIQBFG1}","{UNIQBFG2}",
					"{RSSTITLE}", "{PUNYCODE1}","{PUNYCODE2}","{VISUAL1}","{VISUAL2}","{SIMCOUNT}", "{FURL1}", "{FURL2}",
					"{SHOWBFGHINTS1}","{SHOWBFGHINTS2}","{premod_mess}","{RSS_COUNT}","{WHOIS}",
					"{WWWREDIRECT1}","{WWWREDIRECT2}","{TITLE_LENGTH}","{REG1}","{REG2}",
					"{NAV_BACK1}","{NAV_BACK2}","{TOP_NEWS_MAX}", "{COMMENTSSHOW1}", "{COMMENTSSHOW2}", "{IMG_COMMENTS1}", "{IMG_COMMENTS2}");
  			include("../conf/rss.dat");
  			if (isset($_GET['go']))
  				$message = "(Сохранено)";
  			$DAYVOTE1 = "selected";
  			$DAYVOTE2 = "";
 			$DAYVOTE3 = "";
			if ($cms_nav_back	==	1) {
				$NAV_BACK1	=	"selected";
				$NAV_BACK2	=	"";
			} else {
				$NAV_BACK1	=	"";
				$NAV_BACK2	=	"selected";
			}
			if ($cms_wwwredirect	==	1)
			{
				$WWWREDIRECT1	=	"selected";
				$WWWREDIRECT2	=	"";
			}
			else
			{
				$WWWREDIRECT1	=	"";
				$WWWREDIRECT2	=	"selected";
			};
			if ($cms_registration	==	1) {
				$REG1	=	"selected";
				$REG2	=	"";
			} else {
				$REG1	=	"";
				$REG2	=	"selected";
			}
			if ($cms_showbfghints	==	1)
			{
				$SHOWBFGHINTS1	=	"selected";
				$SHOWBFGHINTS2	=	"";
			}
			else
			{
				$SHOWBFGHINTS1	=	"";
				$SHOWBFGHINTS2	=	"selected";
			};
			if ($cms_furl		==	1)
			{
				$FURL1		=	"selected";
				$FURL2		=	"";
			}
			else
			{
				$FURL1		=	"";
				$FURL2		=	"selected";
			};
			if ($cms_punycode	==	1)
			{
				$PUNYCODE1	=	"selected";
				$PUNYCODE2	=	"";
			}
			else
			{
				$PUNYCODE1	=	"";
				$PUNYCODE2	=	"selected";
			};
 			if ($cms_uniqbfg	==	1)
 			{
				$UNIQBFG1	=	"selected";
				$UNIQBFG2	=	"";
			}
			else
			{
				$UNIQBFG1	=	"";
				$UNIQBFG2	=	"selected";
			};
			if ($cms_visual==1)
			{
				$VISUAL1		=	"selected";
				$VISUAL2		=	"";
			}
			else
			{
				$VISUAL1		=	"";
				$VISUAL2		=	"selected";
			};
 			if ($cms_without_mail==1)
 			{
 				$WITHOUT_MAIL1	=	"selected";
 				$WITHOUT_MAIL2	=	"";
 			}
 			else
 			{
 				$WITHOUT_MAIL1	=	"";
 				$WITHOUT_MAIL2	=	"selected";
 			};
 			if ($cms_hide_admin==1)
 			{
 				$HIDE_ADMIN1	=	"selected";
 				$HIDE_ADMIN2	=	"";
 			}
 			else
 			{
 				$HIDE_ADMIN1	=	"";
 				$HIDE_ADMIN2	=	"selected";
 			};
 			if ($cms_oneipreg == 1)
 			{
				$ONEIPREG1 = "selected";
				$ONEIPREG2 = "";
			}
			else
			{
				$ONEIPREG1 = "";
				$ONEIPREG2 = "selected";
			};
  			if ($cms_editarea == 1)
  			{
  				$EDITAREA1 = "selected";
  				$EDITAREA2 = "";
 			}
  			else
  			{
  				$EDITAREA1 = "";
  				$EDITAREA2 = "selected";
  			};
  			if ($cms_editareawp == 1)
  			{
  				$EDITAREAWP1 = "selected";
  				$EDITAREAWP2 = "";
  			}
  			else
  			{
  				$EDITAREAWP1 = "";
  				$EDITAREAWP2 = "selected";
  			};
  			if ($cms_adminm==1)
  			{
  				$ADMINM1="selected";
  				$ADMINM2="";
  			}
  			else
  			{
  				$ADMINM1="";
  				$ADMINM2="selected";
  			};
  
  			if ($cms_createlinks==1)
  			{
    				$CREATELINKS1 = "selected";
  				$CREATELINKS2 = "";
  			}
  			else
  			{
  				$CREATELINKS1 = "";
  				$CREATELINKS2 = "selected";
  			};
  			if ($cms_guestnotwrite==1)
  			{
  			  $GUEST1 = "selected";
  			  $GUEST2 = "";
  			}
  			else
  			{
  			  $GUEST1 = "";
  			  $GUEST2 = "selected";
  			};
  			if ($cms_gravatars==1)
  			{
  			  $GRAVATARS1 = "selected";
  			  $GRAVATARS2 = "";
  			}
  			else
  			{
   			  $GRAVATARS1 = "";
  			  $GRAVATARS2 = "selected";
  			};
  			if ($cms_avatars_resize == 1)
  			{
  			  $RESIZE1 = "selected";
  			  $RESIZE2 = "";
  			}
  			else
  			{
  			  $RESIZE1 = "";
  			  $RESIZE2 = "selected";
  			};
  			if ($cms_pm_showusers == 1)
  			{
  			  $PM_SHOWUSERS1 = "selected";
  			  $PM_SHOWUSERS2 = "";
  			}
  			else
  			{
  			  $PM_SHOWUSERS1 = "";
  			  $PM_SHOWUSERS2 = "selected";
  			};


  			if ($cms_fullredirect == 1)
  			{
  			  $FULLREDIRECT1 = "selected";
  			  $FULLREDIRECT2 = "";
  			}
  			else
  			{
  			  $FULLREDIRECT1 = "";
  			  $FULLREDIRECT2 = "selected";
  			};
  
  			if ($cms_directdownload == 1)
  			{
  			  $DIRECTDOWNLOAD1 = "selected";
  			  $DIRECTDOWNLOAD2 = "";
  			}
  			else
  			{
  			  $DIRECTDOWNLOAD1 = "";
  			  $DIRECTDOWNLOAD2 = "selected";
  			};
  			
  			if ($cms_plusmess == 1)
  			{
  			  $PLUS1 = "selected";
  			  $PLUS2 = "";
  			}
  			else
  			{
  			  $PLUS1 = "";
  			  $PLUS2 = "selected";
  			};
  
  			if ($cms_restore == 1)
  			{
  			   $RESTORE1 = "selected";
  						   $RESTORE2 = "";
  			}
  			else
  			{
  			   $RESTORE1 = "";
  			   $RESTORE2 = "selected";
  			};
  
  			if ($cms_ps == 1)
  			{
  			   $PS1 = "selected";
  			   $PS2 = "";
  			}
  			else
  			{
  			   $PS1 = "";
  			   $PS2 = "selected";
  			};
  			
  			if ($cms_cenzura == 1)
  			{
  			   $CENZURA1 = "selected";
  			   $CENZURA2 = "";
  			}
  			else
  			{
  			   $CENZURA1 = "";
  			   $CENZURA2 = "selected";
  			};
  
  			if ($cms_views_counter == 1)
  			{
   			  $VIEWS_COUNTER1 = "selected";
  			   $VIEWS_COUNTER2 = "";
  			}
  			else
  			{
  			   $VIEWS_COUNTER1 = "";
  			   $VIEWS_COUNTER2 = "selected";
  			};
  
  			if ($cms_save_admin_ip == 1)
  			{
  			  $SAVE_ADMIN_IP1 = "selected";
  			  $SAVE_ADMIN_IP2 = "";
  			}
  			else
  			{
  			  $SAVE_ADMIN_IP1 = "";
  			  $SAVE_ADMIN_IP2 = "selected";
  			};
  
  			if ($cms_http == 1)
  			{
  			  $HTTPSHOW1 = "selected";
  			  $HTTPSHOW2 = "";
  			}
  			else
  			{
   			 $HTTPSHOW1 = "";
  			  $HTTPSHOW2 = "selected";
  			};
  
  			if ($cms_active == 1)
  			{
  			  $ACTIVE1 = "selected";
  			  $ACTIVE2 = "";
  			}
  			else
  			{
  			  $ACTIVE1 = "";
  			  $ACTIVE2 = "selected";
  			};
  			
  			if ($cms_noindexlinks == 1)
  			{
  			  $NOINDEXSHOW1 = "selected";
  			  $NOINDEXSHOW2 = "";
  			}
  			else
  			{
  			  $NOINDEXSHOW1 = "";
  			  $NOINDEXSHOW2 = "selected";
  			};
  
  			if ($cms_noshowerr == 1)
  			{
  			  $ERSHOW1 = "selected";
  			  $ERSHOW2 = "";
  			  $ERSHOW3 = "";
  			  $ERSHOW4	=	'';
  			}
  			else if ($cms_noshowerr == 5)
  			{
  			  $ERSHOW2 = "selected";
  			  $ERSHOW1 = "";
  			  $ERSHOW3 = "";
  			  $ERSHOW4	=	'';
  			}
  			else if ($cms_noshowerr	== 25)
  			{
  				$ERSHOW2	=	'';
  				$ERSHOW1	=	'';
  				$ERSHOW3	=	'';
  				$ERSHOW4	=	'selected';
  			}
  			else
  			{
  			  $ERSHOW1 = "";
  			  $ERSHOW2 = "";
  			  $ERSHOW3 = "selected";
  			  	$ERSHOW4	=	'';
  			};
  
  			if ($cms_top_show == 1)
  			{
  			  $TOPSHOWSHOW1 = "selected";
  			  $TOPSHOWSHOW2 = "";
  			}
  			else
  			{
  			  $TOPSHOWSHOW1 = "";
  			  $TOPSHOWSHOW2 = "selected";
  			};
  
  			if ($cms_closed == 1)
  			{
  			  $CLSHOW1 = "selected";
  			  $CLSHOW2 = "";
  			}
  			else
  			{
  			  $CLSHOW1 = "";
  			  $CLSHOW2 = "selected";
  			};
  
  			if ($cms_oncomments == 1)
  			{
  			  $COMMENTSSHOW1 = "selected";
  			  $COMMENTSSHOW2 = "";
  			}
  			else
  			{
  			  $COMMENTSSHOW1 = "";
  			  $COMMENTSSHOW2 = "selected";
  			};
  
  			if ($cms_smiles == 1)
  			{
  			  $SMILESSHOW1 = "selected";
  			  $SMILESSHOW2 = "";
  			}
  			else
  			{
  			  $SMILESSHOW1 = "";
  			  $SMILESSHOW2 = "selected";
  			};
  
  			if ($cms_premoder == 1)
  			{
  			  $PREMODERSHOW1 = "selected";
  			  $PREMODERSHOW2= "";
  			}
  			else
  			{
  			  $PREMODERSHOW1 = "";
  			  $PREMODERSHOW2 = "selected";
  			};
  
  			if ($cms_sendmess == 1)
  			{
  			  $MESHOW1 = "selected";
  			  $MESHOW2 = "";
  			}
  			else
  			{
  			  $MESHOW1 = "";
  			  $MESHOW2 = "selected";
  			};
  
  			if ($cms_nocache == 1)
  			{
  			  $NOCSHOW1 = "selected";
  			  $NOCSHOW2 = "";
  			}
  			else
  			{
  			  $NOCSHOW1 = "";
  			  $NOCSHOW2 = "selected";
  			};
  
  			if ($cms_ban == 1)
  			{
  			  $BANSHOW1 = "selected";
  			  $BANSHOW2= "";
  			}
  			else
  			{
  			  $BANSHOW1 = "";
  			  $BANSHOW2 = "selected";
  			};
  
  			if ($cms_needlog == 1)
  			{
  			  $LOSHOW1 = "selected";
  			  $LOSHOW2 = "";
  			}
  			else
  			{
   			 $LOSHOW1 = "";
   			 $LOSHOW2 = "selected";
  			};
  
  			if ($cms_needalog == 1)
  			{
  			  $ALSHOW1 = "selected";
  			  $ALSHOW2 = "";
  			}
  			else
  			{
  			  $ALSHOW1 = "";
  			  $ALSHOW2 = "selected";
  			};
  
  			if ($cms_needrecord == 1)
  			{
  			  $RESHOW1 = "selected";
  			  $RESHOW2 = "";
  			}
  			else
  			{
  			  $RESHOW1 = "";
  			  $RESHOW2 = "selected";
  			};
  			
  			if ($cms_banlog == 1)
  			{
  			  $BANLOGSHOW1 = "selected";
  			  $BANLOGSHOW2 = "";
  			}
  			else
  			{
  			  $BANLOGSHOW1 = "";
  			  $BANLOGSHOW2 = "selected";
  			};
  
  			if ($cms_gzip == 1)
  			{
  			  $GZIPSHOW1 = "selected";
  			  $GZIPSHOW2 = "";
  			}
  			else
  			{
  			  $GZIPSHOW1 = "";
  			  $GZIPSHOW2 = "selected";
  			};
  
  			if ($cms_avatars == 1)
  			{
  			   $AVATARS1 = "selected";
  			   $AVATARS2 = "";
  			}
  			else
  			{
  			   $AVATARS1 = "";
  			   $AVATARS2 = "selected";
  			};
  
  			if ($cms_rewrite == 1)
  			{
  			  $REWRITE1 = "selected";
  			  $REWRITE2 = "";
  			}
  			else
  			{
  			  $REWRITE1 = "";
  			  $REWRITE2 = "selected";
  			};
                        if($cms_img_comment == 1){
                          $IMG_COMMENTS1 = "selected";
                          $IMG_COMMENTS2 = "";
                        }
                        else{
                          $IMG_COMMENTS1 = "";
                          $IMG_COMMENTS2 = "selected";
                        };
  			$themes = "";  
  			foreach ($FileManager->listing("../themes/",1) as $f)
  			{
     				($cms_theme == $f) ? $themes.="<option value=\"".$f."\" selected>".$f : $themes.="<option value=\"".$f."\">".$f; 
  			};
  
  			$bfg = file("../conf/bfg.dat");
  			$rss_id = "";
  			foreach ($bfg as $bf)
  			{
     				$b = explode("|",$bf);
     				if ($cms_rss_id == "") $cms_rss_id = $b[0];
     				($cms_rss_id == $b[0]) ? $rss_id .= "<option value=\"".$b[0]."\" selected>".$b[0] : $rss_id .= "<option value=\"".$b[0]."\">".$b[0];
  			};
			if ($cms_punycode==1)
			{
				$tmp = $IDN->decode($cms_site);
				$cms_site = htmlentities($tmp, null, 'UTF-8');
			};
  
  			$tmp = "Тестовое сообщение";
  			if (function_exists('mb_substr'))
  			{
        			mb_internal_encoding("UTF-8");
        			$tmp = mb_substr($tmp,0,6);
  			}
  			else
  			{
        			if (function_exists("iconv"))
        			{
            				$a   = @iconv('utf-8', 'windows-1251', $tmp);
            				$tmp = substr($a,0,6);
            				$b   = @iconv('windows-1251','utf-8',$tmp);
            				$tmp = $b;
        			}
        			else
        			{
            				$tmp = "";
        			};
  			};
  			if ($tmp!="")
  			{
       				$SUBSTRERROR  = "";
       				$SUBSTRERROR2 = "";
       				$SUBSTRERROR3 = "";
  			}
  			else
  			{
      	 			$SUBSTRERROR  = "<font color=\"red\"><br><b>Функции mb_substr, iconv недоступны или работают неверно. В связи с этим, модуль here_last_posts не работоспособен!</b></font>";
       				$SUBSTRERROR2 = "<font color=\"red\"><br><b>Функции mb_substr, iconv недоступны или работают неверно. Цензура не будет работать!</b></font>";
       				$SUBSTRERROR3 = "<font color=\"red\"><br><b>Функции mb_substr, iconv недоступны или работают неверно. Комментарии, количество символов которых превысит данное значение, будут потеряны!</b></font>";
  			};
  
  			if (
   				(!function_exists('imagecopyresampled'))
   				or
   				(!function_exists('imagecreatetruecolor'))
  			)
  			{
       				$GDERROR = "<font color=\"red\"><br><b>Не установлена библиотека GD версии 2.0.1 или новее - данная опция не будет работать!</b></font>";
  			}
  			else
  			{
       				$GDERROR = "";
  			};
  
  			$languages="";
  			foreach ($FileManager->listing("../includes/languages/",1) as $l)
  			{
                          	$file = file("../includes/languages/".$l."/general.php");
                          	foreach ($file as $f)
                          	{
                              		if (strstr($f,"language_info"))
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
                          	if ($l==$cms_language)
                          	{
                             		$languages.='<option value="'.$l.'" selected>'.$info;
                          	}
                          	else
                          	{
                             		$languages.='<option value="'.$l.'">'.$info;
                          	};
  			};
  			$timezones = '';
  			for ($i=13; $i>0; $i--)
  			{
       				if ($cms_timezone=='+'.$i)
           				$timezones.='<option value="+'.$i.'" selected> +'.$i;
       				else
           				$timezones.='<option value="+'.$i.'"> +'.$i;
  			};
  			if ($cms_timezone=='+0')
           			$timezones.='<option value="+0" selected> 0';
  			else
           			$timezones.='<option value="+0"> 0';
  			for ($i=1; $i<14; $i++)
  			{
       				if ($cms_timezone=='-'.$i)
           				$timezones.='<option value="-'.$i.'" selected> -'.$i;
       				else
           				$timezones.='<option value="-'.$i.'"> -'.$i;
  			};
  
  			$tusers = file($cms_root."/conf/users/users.dat");
  			$t      = explode("|",$tusers[0]);
  			if ($Filtr->tolower($t[18])==$Filtr->tolower($login))
  				$AL = "";
  			else
  				$AL = '<font class="desc" style="color:red;"><br>Только <b>главный администратор</b> может изменять данную опцию</font>';
			
			if (!function_exists('mb_strlen'))
				$SUBSTRERROR.='<font color="green"><br><b>Рекомендуется установить mbstring расширение PHP на сервер</b></font>';
			
  			$br = array("",$cms_site,"",$DAYVOTE1,$DAYVOTE2,$DAYVOTE3,
  				$HTTPSHOW1,$HTTPSHOW2,$NOINDEXSHOW1,$NOINDEXSHOW2,$rss_gdd,$cms_root,
  				$ERSHOW1,$ERSHOW2,$ERSHOW3,$cms_mail,$cms_time_cookie,$CLSHOW1,$CLSHOW2,$cms_closed_text,$COMMENTSSHOW1,
  				$COMMENTSSHOW2,$SMILESSHOW1,$SMILESSHOW2,$PREMODERSHOW1,$PREMODERSHOW2,$MESHOW1,$MESHOW2,'',
  				$cms_noflood,$NOCSHOW1,$NOCSHOW2,$BANSHOW1,$BANSHOW2,$LOSHOW1,$LOSHOW2,$ALSHOW1,$ALSHOW2,$RESHOW1,
  				$RESHOW2,$Filtr->progress($cms_online_time,'lastposts'),$BANLOGSHOW1,$BANLOGSHOW2,$GZIPSHOW1,$GZIPSHOW2,"",$message,
  				$Filtr->progress($cms_top_count),$TOPSHOWSHOW1,$TOPSHOWSHOW2,$VIEWS_COUNTER1,$VIEWS_COUNTER2,$cms_max_message,$cms_mail_select,
  				$SAVE_ADMIN_IP1,$SAVE_ADMIN_IP2,$REWRITE1,$REWRITE2,$ACTIVE1,$ACTIVE2,$cms_active_mail,$cms_active_name,
  				$AVATARS1, $AVATARS2,$cms_upload_maxsite,$cms_upload_width,$cms_upload_height,$RESTORE1,$RESTORE2,
  				$PS1,$PS2,$cms_ps_max,$PLUS1,$PLUS2,$cms_rewrite_ext,$CENZURA1,$CENZURA2,$cms_cenzura_words,
  				$Filtr->progress($cms_lastposts_count,'lastposts'),$cms_lastposts_len,$rss_id,$themes,$DIRECTDOWNLOAD1,$DIRECTDOWNLOAD2,$FULLREDIRECT1,$FULLREDIRECT2,
  				$Filtr->progress($cms_pm_max,'newpm'),$PM_SHOWUSERS1,$PM_SHOWUSERS2,$RESIZE1,$RESIZE2,$cms_avatars_maxresize,$cms_log_max,$SUBSTRERROR,$SUBSTRERROR2,
  				$SUBSTRERROR3,$GDERROR,$GRAVATARS1,$GRAVATARS2,$cms_gravatars_im,$GUEST1,$GUEST2,$languages,$CREATELINKS1,$CREATELINKS2,
  				$cms_send_mail,date('d.m.y H:i:s'),$Filtr->gettimezonedate(),$timezones,$ADMINM1,$ADMINM2,$AL,$cms_fontfamily,$Filtr->progress($cms_fontsize,'fontsize'),
  				$Filtr->progress($cms_nav_news),$Filtr->progress($cms_nav_comments),$Filtr->progress($cms_nav_downloads),$Filtr->progress($cms_nav_faq),$Filtr->progress($cms_nav_pm),$Filtr->progress($cms_nav_system),
  				$EDITAREA1, $EDITAREA2, $EDITAREAWP1,$EDITAREAWP2, $ONEIPREG1, $ONEIPREG2, $ERSHOW4,
  				$HIDE_ADMIN1, $HIDE_ADMIN2,$WITHOUT_MAIL1,$WITHOUT_MAIL2,$UNIQBFG1,$UNIQBFG2,
				$cms_rss_title,$PUNYCODE1,$PUNYCODE2,$VISUAL1,$VISUAL2,$Filtr->progress($cms_simcount,'lastposts'), $FURL1, $FURL2,
				$SHOWBFGHINTS1,$SHOWBFGHINTS2,$cms_premod_mess,$Filtr->progress($cms_rss_count,'pm'),$cms_whois,
				$WWWREDIRECT1,$WWWREDIRECT2, $Filtr->progress($cms_title_length,'pm'),$REG1,$REG2,
				$NAV_BACK1,$NAV_BACK2, $Filtr->progress($cms_top_news_max), "","", $IMG_COMMENTS1, $IMG_COMMENTS2);
  			$echooptions = $GlobalTemplate->template($ar,$br,"./theme/general.tpl");
  			$ar = array("{MENU}","{OPTIONS}");
  			if (isset($_GET['go']))
  			{
   				$br = array("<center>Настройки сохранены</center>",$echooptions);  
  			}
  			else
   				$br = array("",$echooptions);
  			echo $GlobalTemplate->template($ar,$br,"./theme/admincenteroptions.tpl");
         		break;
        	case "pages":
        		
        		$GlobalUsers->access(1);
         		$whatdoing="Страницы";
         		$ar = array("{MENU}","{LIST}");
  			$menu = '<input type="button" onClick="location.href=\'?action=pages&amp;do=newpage\';" value="Создать страницу"><br>';
  			if (isset($_GET['do']))
  			{
       				switch ($_GET['do'])
       				{
         				case 'newpage':
             					$menu = '<center><form name="newpage" action="?action=pages&amp;do=createpage&amp;rand='.rand(0,9999).'" method="POST">
                					<table class="optionstable" border=0 cellpadding=1 cellspacing=0>
                   						<tr class="titletable"><td colspan=2 width="50%">СОЗДАТЬ СТРАНИЦУ</td></tr>
                   						<tr><td width="50%">Адрес страницы:</td><td>
                  						<select name="child">
                         					<option value="nochild" selected>'.$cms_site.'/';
						if ($cms_furl!=1)
							$menu.='?viewpage=';
             					$config = file("../conf/pages/config");
             					foreach ($config as $line)
             					{
                 					$record = explode("|",$line);
                 					$tmp = explode("/",$record[0]);
                 					/*if ( (count($tmp)-1) >= 0) 
                 					{*/
                     						if ($record[0]!="index")
                     							$menu .= ($cms_furl==1) ? '<option value="'.$record[0].'/">'.$cms_site.'/'.$record[0].'/' : '<option value="'.$record[0].'/">'.$cms_site.'/?viewpage='.$record[0].'/';
                 					//};
             					};
             					$menu .= '   
                    						</select>
                  						<input type="text" name="url" value="mypage.html" size=20 maxlength=30></td></tr>
                  						<tr><td>Заголовок:</td><td><input type="text" name="title" value="" size=66></td></tr>
                  									<tr><td>Описание:</td><td><input type="text" name="description" value="" size=66 maxlength=210></td></tr>
                  						<tr><td>Ключевые слова:</td><td><input type="text" name="keywords" value="" size=66 maxlength=150></td></tr>
                  						<tr class="sub"><td colspan=2>Тема: <select name="theme">';
							foreach ($FileManager->listing("../themes/",1) as $f)
							{
								$menu.="<option value=\"".$f."\">".$f;
							};

							$menu .= '</select><input type="submit" name="submit" value="Создать страницу"></td></tr>
                						</table></form></center>
             					';
             					break;


         				case "createpage":
             					if (isset($_POST['submit']))
             					{
                 					$child       = $_POST['child'];
                 					if ($child == "nochild") $child = "";
                 					$url         = $_POST['url'];
                 					$title       = $Filtr->clear($_POST['title']);
                 					$description = $Filtr->clear($_POST['description']);
                 					$keywords    = $Filtr->clear($_POST['keywords']);
									$page_theme  = $Filtr->clear($_POST['theme']);
                 					$config      = file("../conf/pages/config");
                 					$cancontinue = true;
                 					foreach ($config as $line)
                 					{
                      						$lin = explode("|",$line);
                      						if ($child.$url==$lin[0])
                      						{
                          						$cancontinue = false;
                          						$menu .= "<center><font color=\"red\"><b>Повторите создание страницы</b></font><br>Указанный Вами адрес страницы уже используется</center>";
                      						};
                 					};
                 					if (!$FileManager->checkfilename($url))
                 					{
                   						$menu .= "<center><font color=\"red\"><b>Повторите создание страницы</b></font><br>В качестве адреса страницы можно использовать только буквы английского алфавита, числа и следующие символы: <b>_-.</b><br>Адрес страницы не может быть пустым</center>";
                   						$cancontinue = false;
                 					};
							if ($url=='index.php')
							{
								$menu .= "<center><font color=\"red\"><b>Повторите создание страницы</b></font><br>В качестве адреса страницы можно использовать только буквы английского алфавита, числа и следующие символы: <b>_-.</b><br>Адрес страницы не может быть пустым</center>";
                   						$cancontinue = false;
							};
                 					if ($cancontinue==true)
                 					{
                    						$name = $url;
                    						if (file_exists("../conf/pages/".$name.".txt"))
                    						{
                        						$yes = false;
                        						while ($yes!=true)
                        						{
                               							$path = $name."-".rand(1,300);
                               							if (!file_exists("../conf/pages/".$path.".txt"))
                               							{
                                  							$yes = "yes";
                                  							$name = $path;
                               							};


                        						};
                    						};
                    						$config = fopen("../conf/pages/config","a");
											fputs($config,$child.$url."|".$title."|".$keywords."|".$description."|".$name."|".$page_theme."|\r\n");
                    						fclose($config);
                    						$nf = fopen("../conf/pages/".$name.".txt","w");
                    						fwrite($nf,"Страница создана");
                    						fclose($nf);
                    						chmod("../conf/pages/".$name.".txt",0777);
                    						$GlobalBFG->refreshrewrite();
                 					};
             					};
             					break;
         				case "delpage":
             					$page     = $_GET['page'];
             					if ($page!=0)
             					{
                         				$fullpage = $_GET['fullpage'];
                         				$config   = file("../conf/pages/config");
                         				$nconf    = fopen("../conf/pages/config","w");
                         				$counter  = 0;
                         				foreach ($config as $line)
                         				{
                                 				if ($counter != $page)
                                 					fwrite($nconf,$line);
                                 				$counter+=1;
                         				};
                         				fclose($nconf);
                         				$FileManager->removefile("../conf/pages/".$fullpage.".txt");
                         				$GlobalBFG->refreshrewrite();
             					}
             					else
             					{
                         				$menu.='<center><font color="red"><b>Нельзя удалить самую главную страницу</b></font></center>';
             					};
             					break;
         				case "editpage":
             					$page         = (int)$_GET['page'];
             					$config       = file("../conf/pages/config");
             					$line         = explode("|",$config[$page]);
             					$url          = $line[0];
             					$title        = $line[1];
             					$description  = $line[3];
             					$keywords     = $line[2];
             					$name         = $line[4];
								$page_theme   = $line[5];
             					$child        = explode("/",$url); 
             					$foundedchild = false;
             					if (count($child) > 1)
             					{
                					$url = $child[1];
                					foreach ($config as $lines)
                					{
                  						$record = explode("|",$lines);
                  						if ($child[0]==$record[0])
                  						{
                     							$foundedchild = true;
                  						};
                					};
             					};
             					if (!isset($child[1])) $child[1] = "";
             					$tmp = ($child[1]!="") ? $child[0]."/" : "";
             					$menu .= '<br><center><form name="newpage" action="?action=pages&amp;do=savepage&amp;rand='.rand(0,9999).'" method="POST">
                					<table class="optionstable" border=0 cellpadding=1 cellspacing=0>
                   						<tr class="titletable"><td colspan=2 width="50%">ПАРАМЕТРЫ СТРАНИЦЫ</td></tr>
                   						<tr><td width="50%">
                   							<input type="hidden" name="page" value="'.$page.'">
                   							<input type="hidden" name="name" value="'.$name.'">
                   							<input type="hidden" name="last" value="'.$tmp.$url.'">
                   						Адрес страницы:</td><td>';
             					if ($url!='index')
             					{
                  					$menu .='<select name="child">';
							if ($cms_furl==1)
								$ass	=	'';
							else
								$ass	=	'?viewpage=';
                  					($foundedchild==true) ? $menu.= '<option value="nochild">'.$cms_site.'/' : $menu.= '<option value="nochild" selected>'.$cms_site.'/'.$ass;                    
                  					foreach ($config as $lines)
                  					{
                          					$record = explode("|",$lines);
                          					$tmp = explode("/",$record[0]);
                          					if ( (count($tmp)-1) < 1) 
                          					{
                             						if ($record[0]!="index")
                             						{
                                						if ($foundedchild)
                                						{
                                   							($child[0] == $record[0]) ? $menu .= '<option value="'.$record[0].'/" selected>'.$cms_site.'/'.$ass.$record[0].'/' : $menu .= '<option value="'.$record[0].'/">'.$cms_site.'/'.$ass.$record[0].'/';
                                						}
                                						else
                                						{
                                    							if ($url != $record[0]) $menu .= '<option value="'.$record[0].'/">'.$cms_site.'/'.$ass.$record[0].'/';
                                						};
                             						}; 
                          					}; 
                  					};
                  					$menu .= '   
                    						</select>
                  						<input type="text" name="url" value="'.$url.'" size=20 maxlength=30></td></tr>';
             					}
             					else
             					{
                  					$menu .= 'Нельзя изменить адрес самой главной страницы<input type="hidden" name="child" value="nochild"><input type="hidden" name="url" value="index"></td></tr>';
             					};

             					$menu .='
                  					<tr><td>Заголовок:</td><td><input type="text" name="title" value="'.$title.'" size=66></td></tr>
                  						<tr><td>Описание:</td><td><input type="text" name="description" value="'.$description.'" size=66 maxlength=210></td></tr>
                  					<tr><td>Ключевые слова:</td><td><input type="text" name="keywords" value="'.$keywords.'" size=66 maxlength=150></td></tr>
                  					<tr class="sub"><td colspan=2>Тема: <select name="theme">';
							foreach ($FileManager->listing("../themes/",1) as $f)
							{
								($page_theme == $f) ? $menu.="<option value=\"".$f."\" selected>".$f : $menu.="<option value=\"".$f."\">".$f;
							};

							$menu .= '</select><input type="submit" name="submit" value="Сохранить параметры"></td></tr>
                					</table></form></center>
             					';

							break;
         				case "savepage":
             					if (isset($_POST['submit']))
             					{
                  					$url         = $_POST['url'];
                  					$title       = $_POST['title'];
                  					$child       = $_POST['child'];
                  					if ($child == "nochild") $child = "";
                  					$description = $_POST['description'];
                  					$page        = (int)$_POST['page'];
                  					$keywords    = $_POST['keywords'];
                  					$name        = $_POST['name'];
									$page_theme  = $_POST['theme'];
                  					$last        = $_POST['last'];
                  					$config      = file("../conf/pages/config");
                  					$cancontinue = true;
                  					foreach ($config as $line)
                  					{
                      						$lin = explode("|",$line);
                      						if ($child.$url==$lin[0])
                      						{
                          						if ($child.$url!=$last) 
                          						{
                            							$cancontinue = false;
                            							$menu .= "<center><font color=\"red\"><b>Повторите изменение параметров</b></font><br>Указанный Вами адрес страницы уже используется</center>";
                          						};  
                      						};
                  					};
                  					if (!$FileManager->checkfilename($url))
                  					{
                   						$menu .= "<center><font color=\"red\"><b>Повторите изменение параметров</b></font><br>В качестве адреса страницы можно использовать только буквы английского алфавита, числа и следующие символы: <b>_-.</b><br>Адрес страницы не может быть пустым</center>";
                   						$cancontinue = false;
                  					};
                  					if ($cancontinue==true)
                  					{
                  						$nconfig = fopen("../conf/pages/config","w");
                  						$counter = 0;
                  						foreach ($config as $line)
                  						{
                      							$record   = explode("|",$line);
                      							if ($counter == $page)
                      							{
													fwrite($nconfig,$child.$url."|".$title."|".$keywords."|".$description."|".$name."|".$page_theme."|\r\n");
                      							}
                      							else
                      							{
                            							fwrite($nconfig,$line);
                      							};
                      							$counter += 1;
                  						};
                  						$GlobalBFG->refreshrewrite();
                  					};
             					};
             					break;
       				};
  			};
  			$list = "";
  			$config = file("../conf/pages/config");
			//сортировка в 2 ночи, по-моему то что надо
			$sorted	=	array();
			foreach ($config as $line) {
				$record	=	explode('|',$line);
				if ($record[0]!='index')
					$sorted[]	=	$record[0];
			};
			natsort($sorted);
			$i	=	0;
			$tmp	=	$config;
			$config	=	array();
			foreach ($tmp as $tm) {
				$t	=	explode('|',$tm);
				$config[$t[0]]	=	$i.'|'.$t[1].'|'.$t[2].'|'.$t[3].'|'.$t[4].'|';
				$i++;
			};
			$i	=	0;
			function showpage($so) {
				global $config, $cms_furl, $list, $cms_site;
				$c	=	explode('|', $config[$so]);
				$tmp	=	explode('/',$so);
				$prefix = '';
				if ($cms_furl!=1)
					$prefix	=	'?viewpage=';

				$pageUrl = "{$cms_site}/{$prefix}{$so}";
				$pageUrlTitle = "{$prefix}<b>{$so}</b>";

				if ($so == 'index') {
					$pageUrl = $cms_site;
					$pageUrlTitle = "<b>Главная страница сайта</b>";
				}

				$list	.=	'<tr><td><a href="'.$pageUrl.'" target="_blank">'.$pageUrlTitle.'</b></a></td><td>'.$c[1].'</td><td>'.$c[2].'</td><td>'.$c[3].'</td><td>
							<a href="?action=edit&amp;file=../conf/pages/'.$c[4].'.txt">Редактировать</a>
							<a href="?action=pages&amp;do=editpage&amp;page='.$c[0].'">Параметры</a>
							<a href="#" onClick="if (checkhead()) location.href=\'?action=pages&amp;do=delpage&amp;page='.$c[0].'&amp;fullpage='.$c[4].'\';">Удалить</a>
						</td></tr>';
			};
			showpage('index');
			foreach ($sorted as $so)
				showpage($so);
			//
			/*
  			$counter = 0;
  			foreach ($config as $line)
  			{
       				$record = explode("|",$line);
       				$tmp = explode("/",$record[0]);
				if ($cms_furl==1)
					$ass='';
				else
					$ass='?viewpage=';
				if ($record[0]=='index')
				{
					$record[0]='';
					$ass='';
				};
       				$list.='<tr><td>/'.$ass.$record[0].'</td><td>'.$record[1].'</td><td>'.$record[2].'</td><td>'.$record[3].'</td><td>
       
       				<a href="?action=edit&amp;file=../conf/pages/'.$record[4].'.txt">Редактировать</a>
       				<a href="?action=pages&amp;do=editpage&amp;page='.$counter.'">Параметры</a>
       					<a href="#" onClick="if (checkhead()) location.href=\'?action=pages&amp;do=delpage&amp;page='.$counter.'&amp;fullpage='.$record[4].'\';">Удалить</a>
       				</td></tr>
       				';
       				$counter+=1;
  			};
			*/
  			$br = array($menu,$list);
  			$echooptions = $GlobalTemplate->template($ar,$br,"./theme/pages.tpl");
  			$ar = array("{MENU}","{OPTIONS}");
  			$br = array("",$echooptions);
  			echo $GlobalTemplate->template($ar,$br,"./theme/admincenteroptions.tpl");
         		break;
		case "bfgcommands":
			$whatdoing	=	"Просмотр специальных команд для новостей";
			$ar = array("{MENU}","{OPTIONS}");
			$smileslist	=	'';
            		$smiles      = file($cms_root."/conf/smiles.dat");
            		foreach ($smiles as $smile)
            		{
                        		$smile = str_replace("\r\n","",$smile);
                        		if ($smile!="")
						$smileslist	.=	'<tr><td><b>['.$smile.']</b></td><td><img src="'.$cms_site.'/smiles/'.$smile.'.gif" border=0 alt="'.$smile.'"></td></tr>';
            		};
			$echooptions	=	'
				<h2>Специальные команды для новостей</h2>
				<font class="desc">Вы можете использовать в новостях зарезервированные слова, именуемые командами, расширяющие возможности новостей во время просмотра их на сайте.</font><br><br>
				<center><table class="optionstable" border=0 cellpadding=1 cellspacing=0>
					<tr class="titletable"><td width="50%">КОМАНДА</td><td>ДЕЙСТВИЕ</td></tr>
					<tr><td><b>[spoiler=</b>Заголовок<b>]</b>Текст<b>[/spoiler]</b></td><td>Спойлер</td></tr>
					<tr><td><b>[quote]</b>Текст<b>[/quote]</b></td><td>Цитата</td></tr>
					<tr><td><b>[hide]</b>Текст<b>[/hide]</b></td><td>Скрытый текст</td></tr>
					<tr><td><b>[show_downloads=</b>идентификатор<b>]</b></td><td>Счётчик загрузок</td></tr>
					<tr><td><b>[urlsite]</b></td><td>Адрес сайта</td></tr>
					<tr><td><b>[themepath]</b></td><td>Путь до темы оформления</td></tr>
					<tr><td><b>[code]</b>HTML код<b>[/code]</b></td><td>HTML код как есть</td></tr>
					'.$smileslist.'
				</table></center>
				
			';
  			$br = array("",$echooptions);
  			echo $GlobalTemplate->template($ar,$br,"./theme/admincenteroptions.tpl",'','',false,false);
         		break;
        	case "edit":
        		$GlobalUsers->access(1);
         		$whatdoing="Редактор файлов";
         		$ar = array("{FILE}","{INFORMATION}","{ADDPARAMS}","{FONTFAMILY}","{FONTSIZE}","{EDITAREA}","{WP}");
  
  			$file = $Filtr->clear($_GET['file']);
  			if (!file_exists($file)){
     				die ("Error.1272: File not found");
  			};
  
     			$infom = "";
  			$message = "";
  			if (isset($_GET['saved']))
  			{
        			$message = "(Сохранено)";
  			};
  			$editarea = ($cms_editarea==1) ? 'onload' : 'later';
  			$br = array($file,$infom,(isset($_GET['style'])) ? "?style=".$_GET['style'] : "",$cms_fontfamily,$cms_fontsize,$editarea,($cms_editareawp==1) ? 'true' : 'false');
  			$echooptions = $GlobalTemplate->template($ar,$br,"./theme/edit_start.tpl");
  			$file_ = file($file);
  			for ($i=0; $i<count($file_); $i++)
  			{
  				$e	=	str_replace('&','&amp;',$file_[$i]);
     				$e = str_replace("<","&lt;",$e);
     				$e = str_replace(">","&gt;",$e);
     				$echooptions.= $e;
  			};
  			
  
  			$echooptions.= $GlobalTemplate->template("{MESSAGE}", $message, "./theme/edit_end.tpl");
  
  			$ar = array("{MENU}","{OPTIONS}");
  			$br = array("Редактируется файл ".$file,$echooptions);
  			echo $GlobalTemplate->template($ar,$br,"./theme/admincenteroptions.tpl",'','',false,false);
         		break;
        	case "style":
        		$GlobalUsers->access(1);
         		$whatdoing="Оформление";
         		(isset($_GET['name'])) ? $name = $Filtr->clear($_GET['name']) : $name = "index.php";
         		if (isset($_GET['theme'])) $cms_theme = $_GET['theme'];
         		$display = ($cms_editarea==1) ? 'onload' : 'later';
         		$word_wrap = ($cms_editareawp==1) ? 'true' : 'false';
         		$echooptions = '
         				<h2>Оформление сайта</h2>
					<font class="desc">Здесь Вы можете отредактировать темы оформления<br><a href="https://github.com/maindefine/ruxe-engine/blob/master/README.md#design" style="color:#5D5D5D;" target="_blank">Инструкция</a></font><br><br>
					<center>
              					<table border=0 width="99%" cellpadding=4>
                     					<tr><td align="left" valign="top">
                     						<script type="text/javascript">
								editAreaLoader.init({
								id : "code"
								,syntax: "html"
								,start_highlight: true
								,language: "ru"
								,toolbar:"fullscreen, |, select_font,|, change_smooth_selection, highlight, reset_highlight, word_wrap"
								,gecko_spellcheck: false
        							,allow_toggle: true
								,font_family:"'.$cms_fontfamily.'"
								,font_size:'.$cms_fontsize.'
								,display:"'.$display.'"
								,word_wrap:'.$word_wrap.'
								});
								</script>
                         					<form name="editform" action="saver.php?saverdo=savefile&amp;plus='.$cms_theme.'&amp;name='.$name.'" method="post">
                             						<input type="hidden" name="file" value="../themes/'.$cms_theme.'/'.$name.'">
                             					';
                        if (isset($_GET['done']))
                        {
                               	$echooptions .= '<center>&nbsp;Шаблон '.$name.' темы '.$cms_theme.' успешно сохранён</center><br>';
                        }; 
                        $echooptions .='
                             						<textarea name="text" id="code" style="width:100%; height:550px;">';
         		$fl = file("../themes/".$cms_theme."/".$name);
         		for ($i=0; $i<count($fl); $i++)
         		{
               			$e = str_replace("<","&lt;",$fl[$i]);
               			$e = str_replace(">","&gt;",$e);
               			$echooptions.= $e;
         		};                   
         		$echooptions .= '</textarea><br>
                        	<center><input type="submit" name="submit" value="Сохранить"></center>
                        	</form>
                     		</td><td width=190 valign="top" style="padding-left:20px;padding-right:0px;">
                         	<form name="changetheme" action="index.php" method="GET"><input type="hidden" name="action" value="style">Тема: <select onChange="this.form.submit();" name="theme">';
                        foreach ($FileManager->listing("../themes/",1) as $f)
                        {
                              ($cms_theme == $f) ? $echooptions.="<option value=\"".$f."\" selected>".$f : $echooptions.="<option value=\"".$f."\">".$f; 
                        };
           		$echooptions .='             
           								</select></form><br><br>';
           		$templates = array("index.php","message.html","commentform.html","newsfullrecord.html","newsrecord.html","users.php","other.php");
           		$templates2 = array("Основа дизайна","Сообщения системы","Форма ввода комментариев","Полная новость","Краткая новость","Пользовательское","Другое");
           		$listdat = file("../themes/".$cms_theme."/list.dat");
           		foreach ($listdat as $list)
           		{
               			$l = explode("|",$list);
               			$templates[] = $l[0];
               			$templates2[] = $l[1];
           		};
            
           		for ($i=0;$i<count($templates);$i++)
           		{
               			($templates[$i]==$name) ? $echooptions .= "<b>".$templates[$i]."</b><br><font style=\"font-size:8pt;\">".$templates2[$i]."</font><br><br>" : $echooptions .= '<a href="index.php?action=style&amp;theme='.$cms_theme.'&amp;name='.$templates[$i].'">'.$templates[$i].'</a><br><font style="font-size:8pt;">'.$templates2[$i].'</font><br><br>';   
           		};
           
           		$echooptions .='          </td></tr>
              					</table>
					</center><br>
         				';
         		$ar = array("{MENU}","{OPTIONS}");
         		$br = array("",$echooptions);
         		echo $GlobalTemplate->template($ar,$br,"./theme/admincenteroptions.tpl",'','',false,false);
         		break;
        	case "faq":
        		$GlobalUsers->access(1);
         		$whatdoing="F.A.Q.";
         		include("faq.php");
         		break;
        	case "messages":
         		$whatdoing="Комментарии";
         		include("messages.php");
         		break;
        	case "users":
        		$GlobalUsers->access(1);
         		$whatdoing="Пользователи";
         		include("users.php");
         		break;
        	case "system":
         		$whatdoing="Обслуживание";
         		include("system.php");
         		break;
        	case "bfgshow":
         		$whatdoing="Новостной раздел";
         		include("bfgshow.php");
         		break;
        	case "downloads":
        		$GlobalUsers->access(1);
             		$whatdoing="Счётчики загрузок";
          		$menu = '<input type="button" onClick="location.href=\'?action=downloads&amp;go=add\';" value="Создать счётчик"> <input type="button" onClick="window.open(\'?action=manager&amp;upload=1&amp;url=..\');return false;" value="Загрузить файл"><br>';
          		if (isset($_GET['go']))
          		{
            			if ($_GET['go']=="add")
            			{
					$url	=	(isset($_GET['url']))?$Filtr->clear($_GET['url']):'http://';
            				$menu.= '<center><br>
            					<form name="addfile" action="saver.php?saverdo=addfile" method="post">
            					<table class="optionstable" border=0 cellpadding=1 cellspacing=0>
            					<tr class="titletable"><td colspan=2>НОВЫЙ СЧЁТЧИК ЗАГРУЗОК</td></tr>
						<tr><td>Идентификатор:</td><td><input type="text" name="id" value="" size=66></td></tr>
						<tr><td>Краткое описание:</td><td><input type="text" name="name" value="" size=66></td></tr>
            					<tr><td width="50%">URL файла:</td><td><input type="text" name="url" value="'.$url.'" size=66></td></tr>
            					<tr class="sub"><td colspan=2><input type="submit" value="Добавить" name="submit"></td></tr>
            					</table>
            					</form>
            					</center>';
            			}
            			else if ($_GET['go']=="edit")
            			{
             				$line = (int)$_GET['line'];
             				$paths = file("../conf/paths.dat");
             				$p = explode("|",$paths[$line]);
             				$menu.= '<center><br>
             					<form name="editdownloads" action="saver.php?saverdo=editdownloads" method="post">
            	 				<table class="optionstable" border=0 cellpadding=1 cellspacing=0>
             					<tr class="titletable"><td colspan=2>ПРАВКА СЧЁТЧИКА ЗАГРУЗОК</td></tr>
						
             					<tr><td>Идентификатор:</td><td><input type="text" readonly name="id" value="'.$p[0].'" size=66></td></tr>
						<tr><td>Краткое описание:</td><td><input type="text" name="name" value="'.$p[2].'" size=66></td></tr>
						<tr><td width="50%"><input type="hidden" name="line" value="'.$line.'">URL файла:</td><td><input type="text" name="url" value="'.$p[1].'" size=66></td></tr>
             					<tr class="sub"><td colspan=2><input type="submit" value="Сохранить" name="submit"></td></tr>
             					</table>
             					</form>
             					</center>';
            			};
          		};
          		$echooptions = '<h2>Счётчики загрузок</h2>
          		<font class="desc">Позволяет вести учёт скачиваний файлов и др.</font><br><br>
          		'.$menu.'

          		<br><center>
          		<table class="optionstable" border=0 cellpadding=1 cellspacing=0>
           			<tr class="titletable"><td>ID</td><td>ОПИСАНИЕ</td><td>АДРЕС ФАЙЛА</td><td>ЗАГРУЗОК</td><td width=180>ДЕЙСТВИЯ</td></tr>
           		';
          		$paths = file("../conf/paths.dat");
          		$paths = array_reverse($paths);
          		$count_downloads = file("../conf/downloads.dat");
          		$i = count($paths)-1;
          		foreach ($paths as $path)
          		{
             			$l = explode("|",$path);
             			$f = "";
             			$z = 0;
             			$x = 0;
             			foreach ($count_downloads as $c)
             			{
                 			$o = explode("=",$c);
                 			if ($l[0]==$o[0])
                 			{
                 				$f = $o[1];
                 				$x = $z;
                 			};
                 			$z++;
             			};
				$echooptions.='<tr><td>'.$l[0].'</td><td>'.$l[2].'</td><td><a href="'.$l[1].'">'.$l[1].'</a></td><td>'.$f.'</td><td valign="top"><a href="?action=downloads&amp;go=edit&amp;line='.$i.'">Изменить</a>
               					<a href="#" onClick="if (checkhead()) location.href=\'saver.php?saverdo=deldownloads&amp;line='.$i.'&amp;c='.$x.'\';">Удалить</a></td></tr>';
             			$i--;
          		}; 
         		$echooptions .= ' 
          				</table></center>
          					<br>
          						
				<center><table class="optionstable" border=0 cellpadding=1 cellspacing=0>
						<tr class="titletable"><td colspan=2>СПРАВКА</td></tr>
						<tr><td colspan=2>
							Счётчики загрузок используются на сайте с помощью следующих команд и путей:<br>
						</td></tr>
          					<tr><td width=500>'.$Navigation->furl('getfile','<b>ID</b>').'</td><td>Ссылка для загрузки файла по идентификатору с повышением показания счётчика</td></tr>
						<tr><td>&lt;?php here_show_downloads("<b>ID</b>"); ?&gt;</td><td>Команда для вывода показаний счётчика загрузок файла по идентификатору</td></tr>
						<tr><td>&lt;?php here_top_downloads(); ?&gt;</td><td>Выводит список наиболее популярных загрузок</td></tr>
       					</table></center>
        		';
          		$ar = array("{MENU}","{OPTIONS}");
          		$br = array("",$echooptions);
          		echo $GlobalTemplate->template($ar,$br,"./theme/admincenteroptions.tpl");
          		break;
        	case "counts":
        		$GlobalUsers->access(1);
             		$whatdoing="Счётчики просмотров";
          		$add = '<input type="button" onClick="location.href=\'?action=counts&amp;go=add\';" value="Создать счётчик"><br><br>';
          		if (isset($_GET['go']))
          		{
             			switch ($_GET['go'])
            			{
                			case "add":
                     				$add = '
                       					<form name="addcount" action="?action=counts&amp;go=add2" method="POST">               
                             					<center>
                                    				 <table class="optionstable" border=0 cellpadding=1 cellspacing=0>
             				                               <tr class="titletable"><td colspan=2>СОЗДАТЬ СЧЁТЧИК</td></tr>
             				                               <tr><td>Идентификатор:<font class="desc"><br>Например: myprogram</font></td>
              					                                                          <td><input type="text" name="id" size=46></td></tr>
              				                              <tr class="sub"><td colspan=2><input type="submit" name="submit" value="Создать счётчик"></td></tr>
              						                       </table>                             
              				               </center><br>                        
              						         </form>
                     				';
                     				break;
                			case "add2":
                     				$id = $Filtr->clear($_POST['id']);
                     				$file = fopen("../conf/views.dat","a");
                     				fputs($file,$id."=0\r\n");
                     				fclose($file);
                     				break;
                			case "reset":
                     				$line = (int)$_GET['line'];
                     				$old2_file = file("../conf/views.dat");
                     				$new_file = fopen("../conf/views.dat","w");
                     				$c = 0;
                     				foreach ($old2_file as $old)
                     				{
                         				$o = explode("=",$old);
                         				($c==$line) ? fwrite($new_file,$o[0]."=0\r\n") : fwrite($new_file,$o[0]."=".$o[1]);
                         				$c++;
                     				};
                     				fclose($new_file);
                     				break;
                			case "delete":
                     				$line = (int)$_GET['line'];
                     				$old2_file = file("../conf/views.dat");
                     				$new_file = fopen("../conf/views.dat","w");
                     				$c = 0;
                     				foreach ($old2_file as $old)
                     				{
                         				$o = explode("=",$old);
                         				if ($c!=$line) fwrite($new_file,$o[0]."=".$o[1]);
                         				$c++;
                     				};
                     				fclose($new_file);
                     				break;
             			};
          		};
          		$echooptions = '<h2>Счётчики просмотров</h2>
          				<font class="desc">Управление модулем &lt;?php here_show_views(\'Идентификатор\'); ?&gt; и &lt;?php here_hided_counter_views(\'Идентификатор\'); ?&gt;</font><br><br>'.$add.'
        	  				<center>
        					  <table class="optionstable" border=0 cellpadding=1 cellspacing=0>
      						     <tr class="titletable"><td>СЧЁТЧИКИ ПРОСМОТРОВ</td><td>ДЕЙСТВИЯ</td></tr>
      			     ';
          		$views = file("../conf/views.dat");
          		for ($i = 0; $i<count($views); $i++)
          		{ 
             			$p = explode("=",$views[$i]);
             			$echooptions.= '<tr><td>Идентификатор: '.$p[0].'. Показания счётчика: '.str_replace("\r\n","",$p[1]).'.</td><td>
             				<input type="button" onClick="location.href=\'?action=counts&amp;go=reset&amp;line='.$i.'\';" value="Обнулить">
             				<input type="button" onClick="if (checkhead()) location.href=\'?action=counts&amp;go=delete&amp;line='.$i.'\';" value="Удалить">
             				</td></tr>
             			';
          		};
          		$echooptions.='</table></center>';
          		$ar = array("{MENU}","{OPTIONS}");
          		$br = array("",$echooptions);
          		echo $GlobalTemplate->template($ar,$br,"./theme/admincenteroptions.tpl");
          		break;

        	case "smiles":
        		$GlobalUsers->access(1);
             		$whatdoing   = "Смайлы";
             		$m           = '<input type="button" onClick="location.href=\'?action=smiles&amp;do=new\';" value="Добавить новый">';
             		if (isset($_GET['do']))
             		{
                 		switch ($_GET['do'])
                 		{
                     			case "new":
                          			$m = '
                          			<form name="uploadform" action="?action=smiles&amp;do=upload&amp;rand='.rand(0,999).'" method="post" enctype="multipart/form-data">
                               			<center>
                                    			<table class="optionstable" cellpadding=1 cellspacing=0>
                                            			<tr class="titletable"><td colspan=2>ДОБАВИТЬ НОВЫЙ СМАЙЛ</td></tr>
                                            			<tr><td>Файл:<br><font class="desc">Поддерживаются <b>только</b> .gif изображения</font></td><td><input name="userfile" type="file"></td></tr>
                                            			<tr class="sub"><td colspan=2><input type="submit" name="submit" value="Добавить"></td></tr>
                                    			</table>
                                    
                               			</center>
                          			</form>';
                          			break;
                     			case "upload":
                          			if (isset($_FILES['userfile']))
                          			{
                               				if ($_FILES['userfile']['size'] == 0)
                                   				die("Error.556: File size = 0 bytes");
                               				if (substr($Filtr->tolower($_FILES['userfile']['name']),strlen($Filtr->tolower($_FILES['userfile']['name']))-4,4)!= '.gif')
                                   				die("Error.558: Поддерживаются только GIF изображения");
                               				if (@copy($_FILES['userfile']['tmp_name'], $cms_root."/smiles/".substr(basename($_FILES['userfile']['name']),0,strlen(basename($_FILES['userfile']['name']))-4).".gif")!=true)
                                   				die("Error.560: Файл не загружен");
                               				$smiles = fopen($cms_root."/conf/smiles.dat","a");
                               				fputs($smiles,substr(basename($_FILES['userfile']['name']),0,strlen(basename($_FILES['userfile']['name']))-4)."\r\n");
                               				fclose($smiles);
                               				chmod($cms_root."/smiles/".substr(basename($_FILES['userfile']['name']),0,strlen(basename($_FILES['userfile']['name']))-4).".gif",0777);
                          			}
                          			else
                          			{
                              				$tmp = get_cfg_var('upload_max_filesize');
                              				die("Error.62: File is very big (".$tmp." max) or another error");
                          			};
                          			break;
                     			case "delete":
                          			$smile = $_GET['smile'];
                          			$smiles = file($cms_root."/conf/smiles.dat");
                          			$n      = fopen($cms_root."/conf/smiles.dat","w");
                          			foreach ($smiles as $s)
                          			{
                                  			$s = str_replace("\r\n","",$s);
                                  			if ($s!=$smile) fwrite($n,$s."\r\n"); 
                          			};
                          			fclose($n);
                          			$FileManager->removefile($cms_root."/smiles/".$smile.".gif");
                          			break;
                	 	};
             		};
             		$echooptions = '<h2>Смайлы</h2>
             				<font class="desc"></font><br><br>
             				'.$m.'<br><br>
             				<center>
                     			<table class="optionstable" border=0 cellpadding=1 cellspacing=0>
                             			<tr class="titletable"><td>СМАЙЛ</td><td>BB КОД</td><td>ДЕЙСТВИЕ</td></tr>
                        ';
             		$smiles   = file($cms_root."/conf/smiles.dat");
             		foreach ($smiles as $smile)
             		{
                     		$smile = str_replace("\r\n","",$smile);
                     		if ($smile!="")
                     		{ 
                      			$echooptions .= '<tr><td><img src="'.$cms_site.'/smiles/'.$smile.'.gif" border=0 alt=""></td><td>['.$smile.']</td><td>
                      			<a href="#" onClick="if (checkhead()) location.href=\'?action=smiles&amp;do=delete&amp;smile='.$smile.'\';">Удалить</a>
                      			</td></tr>';
                     		};
             		};                
             		$echooptions .= '                
                     			</table>
             				</center>
             		';
             		$ar = array("{MENU}","{OPTIONS}");
             		$br = array("",$echooptions);
             		echo $GlobalTemplate->template($ar,$br,"./theme/admincenteroptions.tpl");
             		break;
        	case "plugins":
        		$tmp	=	$GlobalUsers->getrules($Filtr->clear($_COOKIE['site_login']));
			if ($tmp['plugins_use']!=true)
			{
				die('Недостаточно прав');
				exit;
			};
             		$whatdoing = "Дополнения";
             		if (isset($_GET['do']))
             		{
                 		switch ($_GET['do'])
                 		{
                        		case "active":
                             			$test     = $_GET['name'];
                             			$original = file("../conf/plugins.dat");
                             			$new      = fopen("../conf/plugins.dat","a");
                             			include("../includes/plugins/".$test."/info.dat");
                                                
                                                if(isset($install) && !function_exists($install)){
                                                        include("../includes/plugins/".$_GET['name']."/functions.php");
                                                        if(function_exists($install)){
                                                                $install();
                                                        }
                                                }

                                                $isset = false;
                                                foreach($original as $lines){
                                                    $line = explode("|", $lines);
                                                    if($line[0] == $test)
                                                        $isset = true;
                                                }
                             			if(!$isset)
                                                    fputs($new,$test."|".$name."|".$addaction."|\r\n");
                             			fclose($new);
                             			break;
                        		case "off":
                             			$name     = $_GET['name'];
                             			$original = file("../conf/plugins.dat");
                             			$new      = fopen("../conf/plugins.dat","w");

                             			foreach ($original as $or)
                             			{
                                   			$o  = explode("|",$or);
                                   			if ($o[0]!=$name){
                                                            fwrite($new,$or); 
                                                        }else{
                                                            include("../includes/plugins/".$_GET['name']."/info.dat");
                                                            if(isset($install)){
                                                                if(function_exists($uninstall)){
                                                                    $uninstall();
                                                                }
                                                            }
                                                        }
                             			}
                             			fclose($new);
                             			break;
                 		};
             		};
             		if (isset($_GET['choose']))
             		{
                     		$plugins    = file("../conf/plugins.dat");
                     		$founded    = false;
                     		foreach ($plugins as $plug)
                     		{
                           		$o    = explode("|",$plug);
                           		if ($o[0] == $_GET['choose']) 
                           		{
                              			$founded = true;
                              			$op      = $o[1];
                           		};
                     		};
                     		if (!$founded)
                     		{
                           		$echooptions = '<h2>Дополнения</h2>
                                          <font class="desc"></font><br><br>';
                           		$echooptions .= "<b>Модуль не найден или он не активен</b>";
                     		}
                     		else
                     		{
                           		$echooptions = '<h2>'.$op.'</h2>
                                          <font class="desc"></font><br><br>';
                          		 include("../includes/plugins/".$Filtr->clear($_GET['choose'])."/admin.php");
                           		$echooptions .= $print;
                     		};
             		}
             		else
             		{
                     		$echooptions = '<h2>Дополнения</h2>
                                  <font class="desc"></font><br><br>';
                     		$echooptions .='
                     			<center>
                     			<table class="optionstable" border=0 cellpadding=1 cellspacing=0>
                                                 <tr class="titletable"><td width=200>ИМЯ</td><td width=55>ВЕРСИЯ</td><td>ОПИСАНИЕ</td><td width=200>АВТОР</td><td width=60>АКТИВЕН</td><td width=110>ОПЦИИ</td></tr>';
                     		$plugins  = file("../conf/plugins.dat");
                     		if (count($FileManager->listing("../includes/plugins/",1))>0)
                     		{  
                       			foreach ($FileManager->listing("../includes/plugins/",1) as $f)
                       			{
                             			$founded = false;
                             			foreach ($plugins as $plug)
                             			{
                                     			$o = explode("|",$plug);
                                    	 		if ($f==$o[0]) $founded = true;
                             			};
                             			if (!$founded)
                             			{
                                           		include("../includes/plugins/".$f."/info.dat");
                                           		$echooptions .= '<tr><td>'.$name.'</td><td>'.$version.'</td><td>'.$description.'</td><td><a href="'.$site.'">'.$author.'</a></td><td><img src="theme/images/false.gif" alt="" border=0></td><td>
                                           		<a href="?action=plugins&amp;do=active&amp;name='.$f.'&amp;rand='.rand(1,999).'">Включить</a>
                                           		</td></tr>';
                             			};
                       			};
                       			foreach ($FileManager->listing("../includes/plugins/",1) as $f)
                       			{
                             			$founded = false;
                             			foreach ($plugins as $plug)
                             			{
                                     			$o = explode("|",$plug);
                                     			if ($f==$o[0]) 
                                     				$founded = true;
                             			};
                             			if ($founded)
                             			{
                                          		include("../includes/plugins/".$f."/info.dat");
                                          		$echooptions .= '<tr><td><a href="?action=plugins&amp;choose='.$f.'">'.$name.'</a></td><td>'.$version.'</td><td>'.$description.'</td><td><a href="'.$site.'">'.$author.'</a></td><td><img src="theme/images/true.gif" alt="" border=0></td><td>
                                          			<a href="?action=plugins&amp;do=off&amp;name='.$f.'&amp;rand='.rand(1,999).'">Отключить</a>
                                          			</td></tr>';
                             			};
                       			};
                     		};       
                     		$echooptions .='</table>
                     			</center>';
             		};
             		$ar = array("{MENU}","{OPTIONS}");
             		$br = array("",$echooptions);
             		echo $GlobalTemplate->template($ar,$br,"./theme/admincenteroptions.tpl");
             		break;
        	case "links":
        		$GlobalUsers->access(1);
             		$whatdoing="Каталог ссылок";
          		$echooptions = '<h2>Каталог ссылок</h2>
          			<font class="desc"></font><br><br>
          			<center>
          			<form name="addlink" action="saver.php?saverdo=addlink" method="post">
          			<table class="optionstable" border=0 cellpadding=1 cellspacing=0>
          			<tr class="titletable"><td colspan=2>ДОБАВИТЬ ССЫЛКУ</td></tr>
          			<tr><td>Адрес (например, <font class="desc">http://mysite.ru</font>):</td><td><input type="text" name="url" value="http://" size=66></td></tr>
          			<tr><td>Идентификатор (например, <font class="desc">mysite</font>):</td><td><input type="text" name="id" value="" size=66></td></tr>
          			<tr><td>Описание (<font class="desc">HTML теги</font> разрешены):</td><td><textarea cols=50 rows=5 name="text"></textarea></td></tr>
          			<tr class="sub"><td colspan=2><input type="submit" value="Добавить" name="submit"></td></tr>
          			</table>
          			</form>
          			</center>
          			<br><center>
          			<table class="optionstable" border=0 cellpadding=1 cellspacing=0>
          			 <tr class="titletable"><td>АДРЕС</td><td>ИДЕНТИФИКАТОР</td><td>ОПИСАНИЕ</td><td>ПЕРЕХОДОВ</td><td>ДЕЙСТВИЕ</td></tr>';
          		$links = file("../conf/links.dat");
          		$links	=	array_reverse($links);
          		$count_links = file("../conf/count_links.dat");
          		$i = count($links)-1;
          		foreach ($links as $link)
          		{
             			$l = explode("|",$link);
             			$f = "";
             			$z = 0;
             			$x = 0;
             			foreach ($count_links as $c)
             			{
                 			$o = explode("=",$c);
                 			if ($l[0]==$o[0])
                 			{
                 				$f = $o[1];
                 				$x = $z;
                 			};
                 			$z++;
             			};
             			$echooptions .= '<tr><td><a href="'.$l[1].'" target="_blank">'.$l[1].'</a></td><td>'.$l[0].'</td><td>'.$l[2].'</td><td>'.$f.'</td><td>
             			
             			<input type="button" onClick="location.href=\'saver.php?saverdo=uplink&amp;id='.$l[0].'\';" value="Вверх">
             			<input type="button" onClick="location.href=\'saver.php?saverdo=downlink&amp;id='.$l[0].'\';" value="Вниз">
             			<input type="button" onClick="if (checkhead()) location.href=\'saver.php?saverdo=dellink&amp;line='.$i.'&amp;count='.$x.'\';" value="Удалить">
             			
             			
             			</td></tr>
             			';
             			$i--;
          		}; 
          		$echooptions .= ' 
          				</table></center>
          			';
          		$ar = array("{MENU}","{OPTIONS}");
          		$br = array("",$echooptions);
          		echo $GlobalTemplate->template($ar,$br,"./theme/admincenteroptions.tpl");
          		break;
        	case "modules":
             		$whatdoing="Другие модули";
             		$tmp		=	$GlobalUsers->getrules($login);
          		$echooptions = '<h2>Другие модули</h2>
          			<font class="desc">Некоторые стандартные модули:</font><br><br>
          			
          		';
          		if ($GlobalUsers->getstatus($login)=='admin')
          			$echooptions.='
          			<input class="modules" type="button" onClick="location.href=\'?action=smiles\';" value="Смайлы">
          			<input class="modules" type="button" onClick="location.href=\'?action=downloads\';" value="Счётчики загрузок">
          			<input class="modules" type="button" onClick="location.href=\'?action=links\';" value="Каталог ссылок">
          			';
          		if ($tmp['comments_edit']==true)
          			$echooptions.='
          			<input class="modules" type="button" onClick="location.href=\'?action=message\';" value="Разделы комментариев">
          		';
          		if ($GlobalUsers->getstatus($login)=='admin')
          			$echooptions.='<input class="modules" type="button" onClick="location.href=\'?action=messages&amp;from=feedback\';" value="Обратная связь">
          			<input class="modules" type="button" onClick="location.href=\'?action=counts\';" value="Счётчики просмотров">
          			<input class="modules" type="button" onClick="location.href=\'?action=rotator\';" value="Ротатор баннеров">
          			<input class="modules" type="button" onClick="location.href=\'?action=faq\';" value="F.A.Q.">';
          		$echooptions.='';
          		if ($tmp['plugins_use']==true)
          		{
          			$echooptions.='
          				<br><font class="desc">Дополнения: (<a style="color:#5D5D5D;" href="?action=plugins">Настроить</a> | <a style="color:#5D5D5D;" href="http://ruxe-engine.ru/viewforum.php?f=21" target="_blank">Скачать новые</a> | <a style="color:#5D5D5D;" href="https://github.com/maindefine/ruxe-engine/blob/master/README.md#install-plugins" target="_blank">Как устанавливать дополнения</a> | <a style="color:#5D5D5D;" href="https://github.com/maindefine/ruxe-engine/blob/master/README.md#create-plugins" target="_blank">Как создать дополнение</a>)</font><br><br>
          				
          			';
          			$plugins      = file("../conf/plugins.dat");
          			foreach ($plugins as $plug)
          			{
              				$o        = explode("|",$plug);
              				$echooptions .= '<input type="button" id="modules" onClick="location.href=\'?action=plugins&amp;choose='.$o[0].'\';" value="'.$o[1].'"> ';
          			};
          			$echooptions .= '';
          		};
          		$ar = array("{MENU}","{OPTIONS}");
          		$br = array("",$echooptions);
          		echo $GlobalTemplate->template($ar,$br,"./theme/admincenteroptions.tpl");
          		break;
        	case "newmessages":
        		$GlobalUsers->access(1);
            	 	$whatdoing="Новые сообщения";
          		$echooptions = '<h2>Новые сообщения</h2><br><br>
           			<center><table class="optionstable" border=0 cellpadding=1 cellspacing=0>
           		';
           		$newmessages=file("../conf/new_messages.dat");
           		$newmessages=array_reverse($newmessages);
           		foreach($newmessages as $nms)
           		{
             			$nm=explode("|",$nms);
             			if ($nm[1] == "no")
             			{
              				$showed_on_site = "<font color=\"red\"><b>Да</b></font>";
             			}
             			else 
             			{
              				if ($nm[1] == "yes")
              				{
               					$showed_on_site = "Нет";
              				}
              				else
              				{
               					$showed_on_site = "В этом нет необходимости";
              				}
             			};
             			if ($cms_smiles==1) 
             			{
               				$echooptions.= "<tr><td><b>Тема:</b> ".$nm[0]."<br><b>Требуется Ваше участие:</b> ".$showed_on_site."<br><b>Сообщение:</b> ".$GlobalTemplate->usebbcodes($nm[2],'html')."</td></tr>
             				";
             			}
             			else
             			{
               				$echooptions.= "<tr><td><b>Тема:</b> ".$nm[0]."<br><b>Требуется Ваше участие:</b> ".$showed_on_site."<br><b>Сообщение:</b> ".$nm[2]."</td></tr>
             				";
             			};
           		};
           		$echooptions .='
           				<tr class="titletable"><td><input type="button" onClick="location.href=\'saver.php?saverdo=clear&amp;file=newmessages\';" value="Очистить"></td></tr>
           			</table></center> 
           			';  
           		$ar = array("{MENU}","{OPTIONS}");
           		$br = array("",$echooptions);
           		echo $GlobalTemplate->template($ar,$br,"./theme/admincenteroptions.tpl");
           		break;
        	case "message":
        		$tmp	=	$GlobalUsers->getrules($Filtr->clear($_COOKIE['site_login']));
			if ($tmp['comments_edit']!=true)
			{
				die('Недостаточно прав');
				exit;
			};
            	 	$whatdoing="Разделы комментариев";
             		$add = '<input type="button" onClick="location.href=\'?action=message&amp;go=add\';" value="Добавить раздел комментариев"><br><br>';
             		if (isset($_GET['go']))
             		{
                 		$go = $_GET['go'];
                 		switch ($go)
                 		{
                        		case "add":
                             			$add = '
                              				<form name="addrazdel" action="saver.php?saverdo=addrazdel" method="post">
                     				          <center>
                  				              <table class="optionstable" border=0 cellpadding=1 cellspacing=0>
                  				               <tr class="titletable"><td colspan=2>ДОБАВИТЬ РАЗДЕЛ КОММЕНТАРИЕВ</td></tr>
                  				               <tr><td>Идентификатор:<br><font class="desc">Например: myprogram. Внимание! Используйте только строчные английские буквы и числа, символ подчёркивания (<b>_</b>)!</font></td>
                  				                   <td><input type="text" name="id" value="" size=46></td></tr>
                 				                <tr><td>Описание:<br><font class="desc">Например: Раздел комментариев моей программы</font></td>
                 				                    <td><input type="text" name="description" value="" size=46></td></tr>
                 				                <tr class="sub"><td colspan=2><input type="submit" name="submit" value="Создать одиночный раздел"></td></tr>                                 
                 					               </table>
                	 				              </center><br>
                					              </form>
               				              ';
                             			break;
                        		case "edit":
                             			$file = file("../conf/messages/listmess.dat");
                             			$p = explode("|",$file[$_GET['line']]);
                             			$add = '
                              					<form name="edrazdel" action="saver.php?saverdo=editrazdel" method="post">
                        					       <center>
                    				           <input type="hidden" name="line" value="'.(int)$_GET['line'].'">
                   				             <table class="optionstable" border=0 cellpaddong=1 cellspacing=0>
                   				              <tr class="titletable"><td colspan=2>ИЗМЕНИТЬ РАЗДЕЛ КОММЕНТАРИЕВ</td></tr>
                    				             <tr><td>Идентификатор:<br><font class="desc">Например: myprogram. Внимание! Используйте только строчные английские буквы и числа, символ подчёркивания (<b>_</b>)!</font></td>
                   					                  <td><input type="text" readonly name="id" value="'.$p[0].'" size=46></td></tr>
                     				            <tr><td>Описание:<br><font class="desc">Например: Раздел комментариев моей программы</font></td>
                     					                <td><input type="text" name="description" value="'.$p[1].'" size=46></td></tr>
												<tr><td>Запретить новые комментарии:</td>
													<td><select name="_close">
													';
										if ($p[2]=='close')
											$add.='<option value="open">Нет<option value="close" selected>Да';
										else
											$add.='<option value="open" selected>Нет<option value="close">Да';
										$add .= '
													</select></td></tr>
                     					            <tr class="sub"><td colspan=2><input type="submit" name="submit" value="Сохранить изменения"></td></tr>                                 
                     					           </table>
                     					          </center><br>
                     					         </form>
                             			';
                             			break;
                 		};
             		};
			$echooptions = '<h2>Разделы комментариев</h2>
				<font class="desc">С помощью данных разделов и команды &lt;?php here_messages(\'ID\'); ?&gt; можно установить на любой странице сайта возможность комментирования</font><br><br>
				'.$add.'
				<center><table width="93%" border=0 cellpadding=0 cellspacing=0><tr><td>';
			$listmess = file($cms_root.'/conf/messages/listmess.dat');
			$i = 0;
			foreach ($listmess as $list) {
				$l = explode('|',$list);
				$echooptions.='
					<div class="bfgdiv" id="bfgtd'.$i.'" 
						onMouseOut="document.getElementById(\'bfgfoot'.$i.'\').style.display=\'none\'; document.getElementById(\'bfgline'.$i.'\').style.display=\'none\';  document.getElementById(\'bfgtd'.$i.'\').className=\'bfgout\';" 
						onMouseOver="document.getElementById(\'bfgfoot'.$i.'\').style.display=\'inline\'; document.getElementById(\'bfgline'.$i.'\').style.display=\'inline\';  document.getElementById(\'bfgtd'.$i.'\').className=\'bfgover\';">
						<div style="display:none;" id="bfgline'.$i.'">
							<font style="float:right; font-size:8pt;">'.count(file($cms_root.'/conf/messages/mess_'.$l[0].'.dat')).' зап.</font>
							<font style="font-size:8pt;">ID: '.$l[0].'</font>
						</div>&nbsp;
						<center>
							<div style="margin: 5px 0 8px 0;"><a id="bfglink'.$i.'" style="font-weight: bold; color: #0000A0; font-size:16pt;" href="?action=messages&amp;from=message&amp;line='.$i.'&amp;message='.$l[0].'">'.$l[1].'</a></div>
							<div style="display:none;" id="bfgfoot'.$i.'">
								<a style="color: #0000A0; font-size:8pt;" href="?action=messages&amp;from=message&amp;line='.$i.'&amp;message='.$l[0].'">Комментарии</a>
								<a style="color: #0000A0; font-size:8pt;" href="?action=message&amp;go=edit&amp;line='.$i.'">Изменить</a> <a style="color: #0000A0; font-size:8pt;" href="#" onClick="if (checkhead()) location.href=\'saver.php?saverdo=delcomment&amp;frommessage=1&amp;file='.$l[0].'&amp;line='.$i.'\';">Удалить</a>
							</div>&nbsp;
						</center>			
					</div>
				';
				$i++;
			}
			$echooptions.= '</td></tr></table></center>';
             		$ar = array("{MENU}","{OPTIONS}");
             		$br = array("",$echooptions);
             		echo $GlobalTemplate->template($ar,$br,"./theme/admincenteroptions.tpl");
             		break;
        	case "rotator":
        		$GlobalUsers->access(1);
             		$whatdoing="Ротатор баннеров";
           		$add='<input type="button" onClick="location.href=\'?action=rotator&amp;go=add\';" value="Добавить баннер"><br><br>';
           		$rotatordat = file("../conf/rotator.dat");
           		$counts = file("../conf/rotator_count.dat");
           		if (isset($_GET['go']))
           		{
              			$go=$_GET['go'];
              			switch($go)
              			{
                 			case "add":
                      				$add = '
                         				<center><form name="addrotator" action="saver.php?saverdo=addrotator" method="POST">
                         				<table class="optionstable" border=0 cellpadding=1 cellspacing=0>
                          				<tr class="titletable"><td colspan=2>ДОБАВИТЬ БАННЕР</td></tr>
                          				<tr><td>URL:<br><font class="desc">Например: http://reklama.ext</font></td><td><input type="text" name="url" value="" size=46></td></tr>
                     				     <tr><td>Генерируемый код (HTML разрешен):<br><font class="desc">Например: &lt;img src="images/banner.gif" border=0 alt=""&gt;</font></td><td><input type="text" name="code" size=46 value=\'\'></td></tr>
                   					       <tr><td>Идентификатор:<br><font class="desc">Например: banner1</font></td><td><input type="text" name="id" value="" size=46></td></tr>
                   					       <tr class="sub"><td colspan=2><input type="submit" name="submit" value="Добавить"></td></tr>
                   				      </table><br>
                   				      </form></center>
                      				';
                      				break;
                 			case "edit":
                      				$line = (int)$_GET['line'];
                      				$id = $_GET['id'];
                      				$y = explode("|",$rotatordat[$line]);
                      				$add = '
                         				<center><form name="addrotator" action="saver.php?saverdo=editrotator&amp;line='.$line.'" method="POST">
                         				<table class="optionstable" border=0 cellpadding=1 cellspacing=0>
                          				<tr class="titletable"><td colspan=2>ИЗМЕНИТЬ БАННЕР</td></tr>
                          				<tr><td>URL:<br><font class="desc">Например: http://reklama.ext</font></td><td><input type="text" name="url" value="'.$y[2].'" size=46></td></tr>
                        						  <tr><td>Генерируемый код (HTML разрешен):<br><font class="desc">Например: &lt;img src="images/banner.gif" border=0 alt=""&gt;</font></td><td><input type="text" name="code" size=46 value=\''.$y[1].'\'></td></tr>
                  				        <tr class="sub"><td colspan=2><input type="submit" name="submit" value="Изменить"></td></tr>
                  					       </table><br>
                  				       </form></center>
                      				';
                      				break;
              			};
           		};
           		$echooptions = '<h2>Ротатор баннеров</h2>
           			<font class="desc"></font><br><br>
           			'.$add.'
           			<center><table class="optionstable" border=0 cellpadding=1 cellspacing=0>
             			<tr class="titletable"><td width=120>ИДЕНТИФИКАТОР</td><td>ГЕНЕРИРУЕМЫЙ КОД</td><td>ССЫЛКА</td><td width=85>ПЕРЕХОДОВ</td><td width=265>ДЕЙСТВИЯ</td></tr>
           		';
           		$rotatordat = array_reverse($rotatordat);
           		$i = count($rotatordat)-1;
           		foreach ($rotatordat as $rotator)
           		{
              			$r = explode("|",$rotator);
              			$o = "Не найдено";
              			$z = 0;
              			$x = 0;
              			foreach ($counts as $count)
              			{
                 			$c = explode("=",$count);
                 			if ($c[0] == $r[0]) {$o = $c[1]; $x = $z; break;};
                 			$z++;
              			};
              			$echooptions.= '<tr><td>'.$r[0].'</td><td>'.str_replace("<","&lt;",str_replace(">","&gt;",$r[1])).'</td>
              				<td>'.$r[2].'</td><td>'.$o.'</td><td>
              					<a href="?action=rotator&amp;go=edit&amp;line='.$i.'&amp;id='.$r[0].'">Изменить</a>
              						<a href="saver.php?saverdo=delfile&amp;fromupdate=1&amp;count='.$x.'">Обнулить</a>
              						<a href="#" onClick="if (checkhead()) location.href=\'saver.php?saverdo=delfile&amp;fromrotator=1&amp;line='.$i.'&amp;count='.$x.'\';">Удалить</a>
              					</td></tr>';
              			$i--;
           		};
           		$echooptions .= '
           			</table></center>';
           
           		$ar = array("{MENU}","{OPTIONS}");
           		$br = array("",$echooptions);
           		echo $GlobalTemplate->template($ar,$br,"./theme/admincenteroptions.tpl");
           		break;
        	default:
           		$whatdoing="Не найдено";
           		$echooptions = '<h2>Раздел не существует</h2>
           		<font class="desc">Запрашиваемый Вами раздел не существует</font><br><br>';
           		$ar = array("{MENU}","{OPTIONS}");
           		$br = array("",$echooptions);
           		echo $GlobalTemplate->template($ar,$br,"./theme/admincenteroptions.tpl");
           		break;
     	};
 	$ddd=microtime(); $ddd=((double)strstr($ddd, ' ')+(double)substr($ddd,0,strpos($ddd,' ')));
     	echo $GlobalTemplate->template("{CREDITS}",
			"Используя данное программное обеспечение, Вы соглашаетесь
            с <a href=\"https://github.com/maindefine/ruxe-engine/blob/master/LICENSE-FULL-EN.txt\"
            target=\"_blank\" style=\"color:white;\">Лицензионным соглашением</a>.<br>
            Автор, программирование: <b>Ахрамеев Денис Викторович</b> <a style=\"color:white; font-weight:bold;\" href=\"http://ahrameev.ru\" target=\"_blank\">http://ahrameev.ru</a>.<br>
            Темы оформления: <b>Александр Плотников</b> <a style=\"color:white; font-weight:bold;\" href=\"http://webdesign.ru.net/\" target=\"_blank\">http://webdesign.ru.net/</a>.<br>
            Логотип, дизайн админ-центра: <b>Игорь </b> <a href=\"http://ruxe-engine.ru/old/viewprofile/Dr1D\" target=\"_blank\" style=\"color:white; font-weight: bold;\">Dr1D</a>.<br>
            Контроль качества, документация: <b>Олег Прохоров</b> <a href=\"http://ruxe-engine.ru/old/viewprofile/Tanatos\" target=\"_blank\" style=\"color:white; font-weight: bold;\">Tanatos</a>.<br>
            Генерация: ".number_format(($ddd-$ttt),3)." секунд.","./theme/admincenterend.tpl");
  }
  else
  {
     	$ar = array("{TITLE}","{GENERATOR}","{SITE}","{CREDITS}","{MESSAGE}");
     	$dmessage = "<br>";
     	if (isset($_COOKIE['admin_password'])) $dmessage = "Перезайдите, пожалуйста.<br><br>";
     	$br = array("Админ-центр Ruxe Engine","Ruxe Engine (ruxe-engine.ru)",$cms_site,"Powered by <a href=\"http://ruxe-engine.ru\" style=\"color:black;\" target=\"_blank\">Ruxe Engine</a>",$dmessage);
     	header("Expires: Mod, 26 Jul 1997 05:00:00 GMT");
     	header("Last-Modified: ".gmdate("D, d M Y H:i:s", 10000) . " GMT");
     	header("Cache-Control: no-cache, must-revalidate");
     	header("Cache-Control: post-check=0,pre-check=0", false);
     	header("Cache-Control: max-age=0",false);
     	header("Pragma: no-cache");
     	header('Content-type: text/html; charset=utf-8');
     	$whatdoing = "Страница входа в центр";
     
     	echo $GlobalTemplate->template($ar,$br,"./theme/admincenterlogin.tpl");
  };
  if ($cms_needalog == 1){
  $log = fopen("../conf/logs/rpanel.log","a");
  fputs($log,"<b>Логин:</b> ".$Filtr->clear($login)."<br><B>IP:</B> ".$Filtr->clear($_SERVER['REMOTE_ADDR'])."<br><B>Дата и время:</B> ".date("d.m.y H:i:s")."<br><b>Браузер: </b>".$Filtr->clear($_SERVER['HTTP_USER_AGENT'])."<br><b>Раздел: </b>".$whatdoing."<br><b>Параметры: </b>?".$Filtr->clear($_SERVER['QUERY_STRING'])."\r\n");
  fclose($log);};
