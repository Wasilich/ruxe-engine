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


include("check.php");
if ($cms_punycode==1)
{
	require_once('../includes/idna_convert.class.php');
	$IDN = new idna_convert();
};
include("../conf/rss.dat");

if (isset($_GET['saverdo']))
{
	switch ($_GET['saverdo'])
	{
		case 'newuser':
			//1.4
			$errortext = $GlobalUsers->reg('admin');
			if ($errortext==-1)
				header('location: index.php?action=users&rand='.rand(1,999));
			else
				header('location: index.php?action=localmessage&line=reguser_error&errortext='.$errortext.'&rand='.rand(1,9999));
			break;
		case 'changeplace':
			//1.3.3
			if (isset($_POST['submit'])) {
				$original_title	=	$_POST['original_title'];
				$new_title	=	$original_title;
				$from		=	$_POST['from'];
				$to		=	$_POST['share'];
				$bfglist	=	file($cms_root.'/conf/bfg.dat');
				$lastposts	=	file($cms_root.'/conf/last_posts.dat');
				//1. Проверить существование раздела "куда" из bfg.dat
				$founded	=	false;
				foreach ($bfglist as $bfgline) {
					$bfg	=	explode('|',$bfgline);
					if ($bfg[0]==$to) {
						$founded	=	true;
						break;
					}
				}
				if ($founded) {
					//2. Проверить не повторяется ли имя новости в разделе "куда", если повторяется - запомнить новое имя и менять потом везде
					$views	=	file($cms_root.'/conf/'.$to.'/views.dat');
					$repeat	=	false;
					do {
						$repeat	=	true;
						foreach ($views as $viewline) {
							$view	=	explode('|',$viewline);
							if ($view[0]==$new_title) {
								$repeat	=	false;
								$new_title	=	$original_title.'-'.rand(1000,9999);
							}
						}
					} while (!$repeat);
					//3. Открыть list.dat "откуда" и получить строчку новости, удалить её из list.dat "откуда" и запомнить
					$list	=	file($cms_root.'/conf/'.$from.'/list.dat');
					$new	=	fopen($cms_root.'/conf/'.$from.'/list.dat','w');
					foreach ($list as $listline) {
						$l	=	explode('|',$listline);
						if ($l[6] == $original_title)
							$dividelist	=	$listline;
						else
							fwrite($new,$listline);
					};
					fclose($new);
					//4. Открыть list.dat "куда" и добавить в конец строчку новости
					$new	=	fopen($cms_root.'/conf/'.$to.'/list.dat','a');
					$d	=	explode('|',$dividelist);
					fputs($new,$d[0].'|'.$d[1].'|'.$d[2].'|'.$d[3].'|'.$d[4].'|'.$d[5].'|'.$new_title.'|'.$d[7].'|'.$d[8].'|'.$d[9].'|'.$d[10].'|'.$d[11].'|'.$d[12]."|\r\n");
					fclose($new);
					//5. Открыть views.dat "откуда" и получить строчку новости, удалить её из views.dat "откуда" и запомнить
					$views	=	file($cms_root.'/conf/'.$from.'/views.dat');
					$new	=	fopen($cms_root.'/conf/'.$from.'/views.dat','w');
					foreach ($views as $viewline) {
						$view	=	explode('|',$viewline);
						if ($view[0]==$original_title)
							$counter = $view[1];
						else
							fwrite($new,$viewline);
					}
					fclose($new);
					//6. Открыть views.dat "куда" и добавить в конец строчку новости
					$new	=	fopen($cms_root.'/conf/'.$to.'/views.dat','a');
					fputs($new,$new_title.'|'.$counter."|\r\n");
					fclose($new);
					//7. Открыть новость.dat "откуда" и запомнить всё
					$originalnew	=	file($cms_root.'/conf/'.$from.'/'.$original_title.'.dat');
					//8. Удалить новость.dat "откуда"
					$FileManager->removefile($cms_root.'/conf/'.$from.'/'.$original_title.'.dat');
					//9. Создать новость.dat "куда" и установить права на запись
					$new	=	fopen($cms_root.'/conf/'.$to.'/'.$new_title.'.dat','w');
					foreach($originalnew as $line) {
						fwrite($new,$line);
					}
					fclose($new);
					@chmod($cms_root.'/conf/'.$to.'/'.$new_title.'.dat',0777);
					//10. Открыть last_posts.dat и проверить _оригинальное_ название новости и сменить его и раздел
					$new	=	fopen($cms_root.'/conf/last_posts.dat','w');
					foreach ($lastposts as $line) {
						$l	=	explode('|',$line);
						if (
							($l[0]==$from)
							and
							($l[5]==$original_title)
						)
							fwrite($new,$to.'|'.$l[1].'|'.$l[2].'|'.$l[3].'|'.$l[4].'|'.$new_title.'|'.$l[6]."|\r\n");
						else
							fwrite($new,$line);
					}
					fclose($new);
					//11. Обновить refreshrewrite
					$GlobalBFG->refreshrewrite();
					//12. Обновить RSS ленту
					$GlobalBFG->updaterss();
					$GlobalCache->tags($from);
					$GlobalCache->cats($from);
					$GlobalCache->tags($to);
					$GlobalCache->cats($to);
					//Вызывать событие обновления поиска, если дополнение установлено
					updatesearch();
					//13. Переадресовать в раздел "куда"
					header('location: index.php?action=bfgshow&type='.$from.'&rand='.rand(1,999));
				} else {
					//Сообщить об ошибке
				}
			} else {
				//Сообщить об ошибке
			}
			break;
		case 'hidenew':
			$type	=	$Filtr->clear($_GET['type']);
			$new	=	$Filtr->clear($_GET['new']);
			$GlobalUsers->access(4,$type);
			$tmp	=	$GlobalUsers->getrules($_COOKIE['site_login']);
			if ($tmp['bfg_public']==false)
			{
				die('Вы не можете публиковать/снимать с публикации новости');
				exit;
			};
			$old	=	file($cms_root.'/conf/'.$type.'/list.dat');
			$news	=	fopen($cms_root.'/conf/'.$type.'/list.dat','w');
			foreach ($old as $ol)
			{
				$o	=	explode('|',$ol);
				if ($o[6]==$new)
					fwrite($news,$o[0].'|'.$o[1].'|'.$o[2].'|'.$o[3].'|'.$o[4].'|'.
					$o[5].'|'.$o[6].'|'.$o[7].'|'.$o[8].'|Нет|'.$o[10].'|'.$o[11].'|'.$o[12]."|\r\n");
				else
					fwrite($news,$ol);
			};
			fclose($news);
			$GlobalCache->tags($type);
			$GlobalCache->cats($type);
			updatesearch();
			header('location: index.php?action=bfgshow&type='.$type.'&rand='.rand(1,999));
			break;
		case 'shownew':
			$type	=	$Filtr->clear($_GET['type']);
			$new	=	$Filtr->clear($_GET['new']);
			$GlobalUsers->access(4,$type);
			$tmp	=	$GlobalUsers->getrules($_COOKIE['site_login']);
			if ($tmp['bfg_public']==false)
			{
				die('Вы не можете публиковать/снимать с публикации новости');
				exit;
			};
			$old	=	file($cms_root.'/conf/'.$type.'/list.dat');
			$news	=	fopen($cms_root.'/conf/'.$type.'/list.dat','w');
			foreach ($old as $ol)
			{
				$o	=	explode('|',$ol);
				if ($o[6]==$new)
					fwrite($news,$o[0].'|'.$o[1].'|'.$o[2].'|'.$o[3].'|'.$o[4].'|'.
					$o[5].'|'.$o[6].'|'.$o[7].'|'.$o[8].'|Да|'.$o[10].'|'.$o[11].'|'.$o[12]."|\r\n");
				else
					fwrite($news,$ol);
			};
			fclose($news);
			//1.2
			$old	=	file($cms_root.'/conf/'.$type.'/'.$new.'.dat');
			$new	=	fopen($cms_root.'/conf/'.$type.'/'.$new.'.dat','w');
			$i	=	0;
			foreach ($old as $ol) {
				$o	=	explode('|',$ol);
				if ($i==0)
					fwrite($new,$o[0].'|'.$o[1].'|'.$o[2].'|'.$o[3].'|'.$o[4].'|'.$o[5].'|'.$o[6].'|'.$o[7].'|'.$o[8]."|\r\n");
				else
					fwrite($new,$ol);
				$i++;
			}
			fclose($new);
			//
			$GlobalCache->tags($type);
			updatesearch();
			$GlobalCache->cats($type);
			header('location: index.php?action=bfgshow&type='.$type.'&rand='.rand(1,999));
			break;
		case 'uplink':
			$GlobalUsers->access(1);
			$id	=	$_GET['id'];
			$links	=	file($cms_root.'/conf/links.dat');
			$n	=	array();
			$new	=	fopen($cms_root.'/conf/links.dat','w');
			$i	=	0;
			$cancel	=	false;
			foreach ($links as $z)
				$n[]	=	$z;
			foreach ($links as $link)
			{
				$l	=	explode('|',$link);
				if ($cancel)
					$cancel = false;
				else
				{
					if ($l[0]==$id)
					{
						if ($i!=count($links)-1)
						{
							$cancel = true;
							$x	=	$links[$i+1];
							$n[$i+1]=$link;
							$n[$i]=$x;
							//echo $n[$i+1];
						};
					};
					if (!$cancel)
						$n[$i]=$link;
				};
				$i++;
			};
			foreach ($n as $z)
				fwrite($new,$z);
			fclose($new);
			header("location: index.php?action=links&ok=3&rand=".rand(1,9999));
			break;
		case 'downlink':
			$GlobalUsers->access(1);
			$id	=	$_GET['id'];
			$links	=	file($cms_root.'/conf/links.dat');
			$n	=	array();
			$new	=	fopen($cms_root.'/conf/links.dat','w');
			$i	=	0;
			$cancel	=	false;
			foreach ($links as $z)
				$n[]	=	$z;
			foreach ($links as $link)
			{
				$l	=	explode('|',$link);
				if ($cancel)
					$cancel = false;
				else
				{
					if ($l[0]==$id)
					{
						if ($i!=0)
						{
							$cancel = true;
							$x	=	$links[$i-1];
							$n[$i-1]=$link;
							$n[$i]=$x;
							//echo $n[$i+1];
						};
					};
					if (!$cancel)
						$n[$i]=$link;
				};
				$i++;
			};
			foreach ($n as $z)
				fwrite($new,$z);
			fclose($new);
			header("location: index.php?action=links&ok=3&rand=".rand(1,9999));
			break;
		case 'create_backup':
			$GlobalUsers->access(1);
			$file = file("../conf/downloads.dat");
  			$lines = implode("|",$file);
  			$lines = str_replace("\r\n","",$lines);
  			$lines = str_replace("\n","",$lines);
  
  			$backup_downloads = $lines;
  
  			$file = file("../conf/views.dat");
  			$lines = implode("|",$file);
  			$lines = str_replace("\r\n","",$lines);
  			$lines = str_replace("\n","",$lines);
  
  			$backup_views = $lines;
  
  			$file = file("../conf/count_links.dat");
  			$lines = implode("|",$file);
  			$lines = str_replace("\r","",$lines);
  			$lines = str_replace("\n","",$lines);
  
  			$backup_links = $lines;
  
  			$file = file("../conf/all_hits.dat");
  			$lines = str_replace("\r\n","",$file[0]);
  			$lines = str_replace("\n","",$lines);
  
  			$backup_all_hits = $lines;
  
  			$file = file("../conf/all_hosts.dat");
  			$lines = str_replace("\r\n","",$file[0]);
  			$lines = str_replace("\n","",$lines);
  
  			$backup_all_hosts = $lines;
  
  			$backup_date = date("d.m.Y");
  
  			$file = fopen("../conf/backup.php","w");
  			fwrite($file,"<?php
			\$backup_date=\"".$backup_date."\";
			\$backup_all_hits=\"".$backup_all_hits."\";
			\$backup_all_hosts=\"".$backup_all_hosts."\";
			\$backup_downloads=\"".$backup_downloads."\";
			\$backup_views=\"".$backup_views."\";
			\$backup_links=\"".$backup_links."\";
			");
  			fclose($file);
  			$tmpfile = file("../conf/config.php");
  			$file = fopen("../conf/backup2.php","w");
 			foreach ($tmpfile as $file_) {
  				fputs($file,$file_);
  			};
  			fclose($file);
  			header("location: index.php?action=system&ok=3&rand=".rand(0,99999));
			break;
		case 'restorebackup':
			$GlobalUsers->access(1);
			if (!isset($_POST['submit']))
  			{
      				die("Error.01");
  			};
 			include("../conf/backup.php");
 			if (isset($_POST['hits']))
 			{
    				$file = fopen("../conf/all_hits.dat","w");
    				fwrite($file,$backup_all_hits);
    				fclose($file);
 			};
 			if (isset($_POST['hosts']))
 			{
    				$file = fopen("../conf/all_hosts.dat","w");
    				fwrite($file,$backup_all_hosts);
    				fclose($file);
 			};
 			if (isset($_POST['links']))
 			{
    				$file = fopen("../conf/count_links.dat","w");
    				fwrite($file,str_replace("|","\r\n",$backup_links)."\r\n");
    				fclose($file);
 			};
 			if (isset($_POST['downloads']))
 			{
    				$file = fopen("../conf/downloads.dat","w");
    				fwrite($file,str_replace("|","\r\n",$backup_downloads)."\r\n");
    				fclose($file);
 			};
 			if (isset($_POST['views']))
 			{
    				$file = fopen("../conf/views.dat","w");
    				fwrite($file,str_replace("|","\r\n",$backup_views)."\r\n");
    				fclose($file);
 			};
 			if (isset($_POST['config']))
 			{
    				$tmpfile = file("../conf/backup2.php");
    				$file = fopen("../conf/config.php","w");
   				foreach ($tmpfile as $file_) {
     					fputs($file,$file_);
    				};
    				fclose($file);
 			};
 			header("location: index.php?action=system&ok=5&rand=".rand(0,9999));
			break;
		case 'addban':
			$tmp	=	$GlobalUsers->getrules($Filtr->clear($_COOKIE['site_login']));
			if ($tmp['banip']!=true)
			{
				die('Недостаточно прав');
				exit;
			};
			if(isset($_POST['submit']))
  			{
     				if (isset($_POST['ip']))
     				{
        				if (preg_match('/^[0-9\*]+\.[0-9\*]+\.[0-9\*]+\.[0-9\*]+$/', $_POST['ip']))
        				{
          					$file=fopen("../conf/ban.dat","a");
          					fputs($file, $_POST['ip'].".|".$Filtr->clear($_POST['why'])."|\r\n");
          					fclose($file);
        				};
     				}; 
     				header("location: index.php?action=system&ok=1&rand=".rand(0,99999)); 
  			};
			break;
		case 'deleteban':
			$tmp	=	$GlobalUsers->getrules($Filtr->clear($_COOKIE['site_login']));
			if ($tmp['banip']!=true)
			{
				die('Недостаточно прав');
				exit;
			};
			$id=$_GET['id'];
			if ($id != "") 
			{
				$id--;
				$file=file("../conf/ban.dat"); 

				for($i=0;$i<sizeof($file);$i++)
					if($i==$id) unset($file[$i]); 

				$fp=fopen("../conf/ban.dat","w"); 
				fputs($fp,implode("",$file)); 
				fclose($fp);
			}
			else
        		{
        			exit;
        		}
			header ("location: index.php?action=system&ok=2&rand=".rand(0,99999));
			break;
		case 'clear':
			$GlobalUsers->access(1);
			$file = $_GET['file'];
  			if ($file == "log")
  			{
     				$fp = fopen("../conf/logs/log.log","w");
     				fwrite($fp,"");
     				fclose($fp);
  			};
  			if ($file == "alog")
  			{
     				$tusers = file($cms_root."/conf/users/users.dat");
     				$t      = explode("|",$tusers[0]);
     				if ($Filtr->tolower($t[18])==$Filtr->tolower($_COOKIE['site_login']))
     				{
           				$fp = fopen("../conf/logs/rpanel.log","w");
           				fwrite($fp,"");
           				fclose($fp);
     				};
  			};
  			if ($file == "errors")
  			{
     				$fp = fopen("../conf/logs/errors.log","w");
     				fwrite($fp,"");
     				fclose($fp);
  			};
  			if ($file == "ban")
  			{
     				$fp = fopen("../conf/logs/ban.log","w");
     				fwrite($fp,"");
     				fclose($fp);
  			};
  			if ($file == "newmessages")
  			{
     				$fp = fopen("../conf/new_messages.dat","w");
     				fwrite($fp,"");
     				fclose($fp);
  			};
  			if ($file == "newmessages")
  			{
   				header("location: index.php?action=index&rand=".rand(0,99999));
  			}
  			else
   				header("location: index.php?action=system&rand=".rand(0,99999));
			break;
		case 'rename':
			$GlobalUsers->access(1);
			if(isset($_POST['rename'])) 
   			{
      				if($FileManager->frename($Filtr->clear($_POST['url']),$Filtr->clear($_POST['oldname']),$Filtr->clear($_POST['nname']))!== FALSE) 
      				{
           				header("location:index.php?action=manager&url=".$Filtr->clear($_POST['url'])); 	
      				}
      				else 
      				{
           				header('Content-type: text/html; charset=utf-8');
           				die("Невозможно переименовать файл/каталог. Не хватает прав доступа или файл/каталог не существует.");
     		 		};
   			};
   			break;
		case 'changechmod':
			$GlobalUsers->access(1);
			if(isset($_POST['url'])) 
   			{
      				if ($_POST['chmod']=="yes"){$test = @chmod($_POST['url']."/".$_POST['fname'],0777);} else { if ($_POST['type'] == "file") {$test = @chmod($_POST['url']."/".$_POST['fname'],0644);} else {$test = @chmod($_POST['url']."/".$_POST['fname'],0755);}};
      				if($test != FALSE) 
      				{
           				header("location:index.php?action=manager&url=".$_POST['url']); 	
      				}
      				else 
      				{
           				die ("Невозможно установить CHMOD. Не хватает прав доступа или файл/каталог не существует.");
      				};
   			};
			break;
		case 'uploadfile':
			$GlobalUsers->access(1);
			if (isset($_FILES['userfile']))
   			{
      				$url = $_POST['url'];
      				if ($_FILES['userfile']['size'] == 0)
      				{
          				die("Error.50: File size = 0 bytes");
      				};
      				if (@copy($_FILES['userfile']['tmp_name'], $url."/".basename($_FILES['userfile']['name']))) 
      				{
          				header("location:index.php?action=manager&url=".$url);
      				} 
      				else 
      				{
          
          				die("Error.19: Файл не загружен");
      				};
   			}
   			else
   			{
     				 $tmp = get_cfg_var('upload_max_filesize');
      				die("Error.62: File is very big (".$tmp." max) or another error");
   			};
   			break;
		case 'makefile':
			$GlobalUsers->access(1);
			//проверка на существование файла 0.9.9.8
			if (file_exists($Filtr->clear($_POST['url'])."/".$Filtr->clear($_POST['ndir'])))
			{
				/*header('Content-type: text/html; charset=utf-8');
				die("Файл уже существует");
				exit;*/
				header('location: index.php?action=localmessage&line=file_exists');
				exit;
			};
			if(isset($_POST['add'])) {
             			$test = @fopen($Filtr->clear($_POST['url'])."/".$Filtr->clear($_POST['ndir']),"w");
             			@fwrite($test,"");
             			@fclose($test);
             			if($test!= FALSE) 
              			{
                   			header("location:index.php?action=manager&url=".$Filtr->clear($_POST['url'])); 	
              			}
             			else 
              			{		
                   			header('Content-type: text/html; charset=utf-8');
                   			die("Файл не создан. Возможные причины:<br>1. Не хватает прав доступа в каталоге<br>2. Файл с таким именем уже создан<br>3. Имя файла указано неверно");
              			}
           
   			}
   			else 
   			{
      				header('Content-type: text/html; charset=utf-8');
                    		die("Файл не создан. Возможные причины:<br>1. Не хватает прав доступа в каталоге<br>2. Файл с таким именем уже создан<br>3. Имя файла указано неверно");
   			};
			break;
		case 'makedir':
			$GlobalUsers->access(1);
			if(isset($_POST['add'])) 
			{
             			if($FileManager->makedir($Filtr->clear($_POST['url'])."/".$Filtr->clear($_POST['ndir']))!== FALSE) 
              			{
                   			header("location:index.php?action=manager&url=".$Filtr->clear($_POST['url'])); 	
              			}
             			else 
              			{
                   			die("Каталог не создан. Возможные причины:<br>1. Не хватает прав доступа в каталоге выше создаваемого<br>2. Каталог с таким именем уже создан<br>3. Имя каталога указано неверно");
              			}
           
   			}
   			else 
   			{
      				die("Каталог не создан. Возможные причины:<br>1. Не хватает прав доступа в каталоге выше создаваемого<br>2. Каталог с таким именем уже создан<br>3. Имя каталога указано неверно");
   			};
   			break;
		case 'deldir':
			$GlobalUsers->access(1);
			if(isset($_GET['url']))
			{
    				if($FileManager->removedir($Filtr->clear($_GET['url'])."/".$Filtr->clear($_GET['fname'])) !== FALSE) 
    				{
					header("location:index.php?action=manager&url=".$Filtr->clear($_GET['url']));
	    			}
    				else
    				{
        				die ("Невозможно удалить каталог. Возможно не хватает прав доступа или каталог не существует.");
    				}; 
			}
			else
			{
     				die("Error.18: Without URL");
			};
			break;
		case 'delfile':
			$GlobalUsers->access(1);
			if (isset($_GET['fromupdate']))
			{
    				$count = (int)$_GET['count'];
    				$file = file("../conf/rotator_count.dat");
    				$newfile = fopen("../conf/rotator_count.dat","w");
    				$i = 0;
    				foreach ($file as $f)
    				{
       					$z = explode("=",$f);
       					if ($i==$count)
       					{
          					fwrite($newfile,$z[0]."=0=\r\n");
       					}
       					else
       					{
          					fwrite($newfile,$z[0]."=".$z[1]."=\r\n");
       					};
       					$i++;
    				};
    				fclose($newfile);
    
    				header("location: index.php?action=rotator&rand=".rand(0,9999));
    				exit;
			};
			if (isset($_GET['fromrotator']))
			{
    				$line = (int)$_GET['line'];
    				$count = (int)$_GET['count'];
    				$fie = "../conf/rotator.dat";
    				$file=file($fie);
    				for($i=0;$i<sizeof($file);$i++)
					if($i==$line) unset($file[$i]); 
    				$fp=fopen($fie,"w"); 
    				fputs($fp,implode("",$file)); 
    				fclose($fp);
    				$line = $count;
    				$fie = "../conf/rotator_count.dat";
    				$file=file($fie);
    				for($i=0;$i<sizeof($file);$i++)
					if($i==$line) unset($file[$i]); 
    				$fp=fopen($fie,"w"); 
    				fputs($fp,implode("",$file)); 
    				fclose($fp);
    				header("location: index.php?action=rotator&rand=".rand(0,9999));
    				exit;
			};
			if(isset($_GET['url']))
			{
   			 	if ($FileManager->removefile($Filtr->clear($_GET['url'])."/".$Filtr->clear($_GET['fname'])) !== FALSE) 
    				{
    					if (isset($_GET['confbackup']))
    					{
    						$original = file($cms_root.'/conf/backups.dat');
    						$new      = fopen($cms_root.'/conf/backups.dat','w');
    						foreach ($original as $or)
    						{
    							if (strstr($or,$Filtr->clear($_GET['fname'])))
    							{
    			
    							}
    							else
    								fwrite($new,$or);
    						};
    						fclose($new);
    						header("location: index.php?action=system&go=51&rand=".rand(1,999)."#confbackup");
    					}
    					else
						header("location:index.php?action=manager&url=".$Filtr->clear($_GET['url']));
    				}
    				else
    				{
        				die ("Невозможно удалить файл. Возможно не хватает прав доступа или файл не существует.");
    				}; 
			}
			else
			{
     				die("Error.64: Without URL");
			};
			break;
		case 'editrotator':
			$GlobalUsers->access(1);
			if (!isset($_POST['submit'])) die("Error.01");
  			$url = $_POST['url'];
  			$code = $_POST['code'];
  			$file = "../conf/rotator.dat";
  			$fp = file($file);
  			$new = fopen($file,"w");
  			$line = $_GET['line'];
  			$i = 0;
  			foreach ($fp as $f)
  			{
       				$z = explode("|",$f);
       				if ($i==$line)
       				{
         				fwrite($new,$z[0]."|".$code."|".$url."|\r\n");
       				}
       				else
         				fwrite($new,$z[0]."|".$z[1]."|".$z[2]."|\r\n");
       				$i++;
  			};
  			fclose($new);
  			header("location: index.php?action=rotator&rand=".rand(0,9999));
  			exit;
			break;
		case 'addrotator':
			$GlobalUsers->access(1);
			if (!isset($_POST['submit'])) die("Error.01");
  			$url = $_POST['url'];
  			$code = $_POST['code'];
  			$id = $_POST['id'];
  			$file = fopen("../conf/rotator.dat","a");
  			fputs($file,$id."|".$code."|".$url."|\r\n");
  			fclose($file);
  			$file = fopen("../conf/rotator_count.dat","a");
  			fputs($file,$id."=0=\r\n");
  			fclose($file);
  			header("location: index.php?action=rotator&rand=".rand(0,9999));
  			exit;
			break;
		case 'editrazdel':
			$GlobalUsers->access(1);
			$description 	= $Filtr->clear($_POST['description']);
			$closed			= $Filtr->clear($_POST['_close']);
  			$line        	= (int)$_POST['line'];
  			$old_file 		= file("../conf/messages/listmess.dat");
  			$new_file 		= fopen("../conf/messages/listmess.dat","w");

  			for ($i=0; $i<count($old_file); $i++) {
    				$o = explode("|",$old_file[$i]);
					if (($o[2]!="open") and ($o[2]!="close"))
						$o[2] = "open";
    				($i == $line) ? fwrite($new_file,$o[0]."|".$description."|".$closed."|\r\n") : fwrite($new_file,$o[0]."|".$o[1]."|".$o[2]."|\r\n");   
  			};
  			fclose($new_file);
  
  			header("location: index.php?action=message&rand=".rand(0,9999));
			break;
		case 'addrazdel':
			$GlobalUsers->access(1);
			$id = $Filtr->clear($Filtr->tolower($_POST['id']));
  			if (!preg_match('/^[a-z0-9\-_]+$/', $id))
  			{
    				//die("Error.47: Your ID not valid. Use a-Z, 0-9 symbols.");
				header('location: index.php?action=localmessage&line=razdel_specsymbols');
				exit;
  			};
  			$description = $Filtr->clear($_POST['description']);
  			$file = fopen("../conf/messages/listmess.dat","a");
  			fputs($file,$id."|".$description."|open|\r\n");
  			fclose($file);
  			$file = fopen("../conf/messages/mess_".$id.".dat","w");
  			fwrite($file,"");
  			fclose($file);
  			@chmod("../conf/messages/mess_".$id.".dat",0777);  
  			header("location: index.php?action=message&rand=".rand(0,9999));
			break;
		case 'dellink':
			$GlobalUsers->access(1);
			$line = (int)$_GET['line'];
  			$count = (int)$_GET['count'];
  			$fie = "../conf/links.dat";  
  			$file=file($fie); 
  			for($i=0;$i<sizeof($file);$i++)
					if($i==$line) unset($file[$i]); 

  			$fp=fopen($fie,"w"); 
  			fputs($fp,implode("",$file)); 
  			fclose($fp);
  			$fie = "../conf/count_links.dat";
  			$line = $count;  
  			$file=file($fie); 
  			for($i=0;$i<sizeof($file);$i++)
				if($i==$line) unset($file[$i]); 

  			$fp=fopen($fie,"w"); 
  			fputs($fp,implode("",$file)); 
  			fclose($fp);
  			header("location: index.php?action=links&rand=".rand(0,99999));
			break;
		case 'addlink':
			$GlobalUsers->access(1);
			$url = $_POST['url'];
 			$id = $_POST['id'];
 			$text = $_POST['text'];
 			$text = str_replace("\r"," ",$text);
 			$text = str_replace("\n"," ",$text);
 			$file = fopen("../conf/links.dat","a");
 			fputs($file, $id."|".$url."|".$text."|\r\n");
 			fclose($file);
 			$file = fopen("../conf/count_links.dat","a");
 			fputs($file, $id."=0\r\n");
 			fclose($file);
 			header("location: index.php?action=links&rand=".rand(0,9999));
 			break;
		case 'deldownloads':
			$GlobalUsers->access(1);
			$line = (int)$_GET['line'];
  			$c = (int)$_GET['c'];
  			$file=file("../conf/paths.dat"); 
  			for($i=0;$i<sizeof($file);$i++)
  				if($i==$line) unset($file[$i]); 
  			$fp=fopen("../conf/paths.dat","w"); 
  			fputs($fp,implode("",$file)); 
  			fclose($fp);
  			$file=file("../conf/downloads.dat");
  			$line = $c; 
  			for($i=0;$i<sizeof($file);$i++)
  				if($i==$line) unset($file[$i]); 
  			$fp=fopen("../conf/downloads.dat","w"); 
  			fputs($fp,implode("",$file)); 
  			fclose($fp);
  			header("location: index.php?action=downloads&rand=".rand(0,99999));
			break;
		case 'editdownloads':
			$GlobalUsers->access(1);
			$url = str_replace(array(' ','|',"'",'"'),'',$Filtr->clear($_POST['url']));
  			$id = str_replace(array(' ','|',"'",'"'),'',$Filtr->clear($_POST['id']));
  			//$miniscreen = $Filtr->clear($_POST['miniscreen']);
  			//$fullscreen = $Filtr->clear($_POST['fullscreen']);
  			$name = str_replace(array('|',"'",'"'),'',$Filtr->clear($_POST['name']));
  			//$text = str_replace(array("\r","|"),array(" "," "),$_POST['text']);
  			//$text = str_replace("\n"," ",$text);
  				
  			//$add1 = str_replace(array("\r","|"),array(" "," "),$_POST['add1']);
  			//$add1 = str_replace("\n"," ",$add1);
  
  			//$add2 = str_replace(array("\r","|"),array(" "," "),$_POST['add2']);
  			//$add2 = str_replace("\n"," ",$add2);
  
  			$line = (int)$_POST['line'];
 			$paths = file("../conf/paths.dat");
  			$newpaths = fopen("../conf/paths.dat","w");
  			for ($i = 0; $i<count($paths); $i++)
  			{
        			if ($i == $line) {
           				fwrite($newpaths,$id."|".$url."|".$name."||||||\r\n");
        			}
        			else
        			{
           				fwrite($newpaths,$paths[$i]);
        			};
  			};
  			fclose($newpaths);
  			header("location: index.php?action=downloads&rand=".rand(0,9999));
			break;
		case 'addfile':
			$GlobalUsers->access(1);
			$url = str_replace(array(' ','|',"'",'"'),'',$Filtr->clear($_POST['url']));
  			$id = str_replace(array(' ','|',"'",'"','%','+'),'',$Filtr->clear($_POST['id']));
			if ($id=='') {
				header("location: index.php?action=localmessage&line=empty_id&rand=".rand(1,999));
				exit;
			}
  			//$miniscreen = $Filtr->clear($_POST['miniscreen']);
  			//$fullscreen = $Filtr->clear($_POST['fullscreen']);
  			$name = str_replace(array('|',"'",'"'),'',$Filtr->clear($_POST['name']));
  			//$text = str_replace(array("\n","|"),array(" "," "),$_POST['text']);
  			//$text = str_replace("\r","",$text);
  
  			//$add1 = str_replace(array("\n","|"),array(" "," "),$_POST['add1']);
  			//$add1 = str_replace("\r"," ",$add1);
  
  			//$add2 = str_replace(array("\b","|"),array(" "," "),$_POST['add2']);
  			//$add2 = str_replace("\r"," ",$add2);
  
  			$paths = fopen("../conf/paths.dat","a");
  			fputs($paths,$id."|".$url."|".$name."||||||\r\n");
  			fclose($paths);
  			$downloads = fopen("../conf/downloads.dat","a");
  			fputs($downloads,$id."=0\r\n");
  			fclose($downloads);
  			header("location: index.php?action=downloads&rand=".rand(0,9999));
			break;
		case 'savepoles':
			$GlobalUsers->access(1);
			if (!isset($_POST['submit'])){ die("Error.5: Without SUBMIT");};
  			include($cms_root.'/conf/users/config.dat');
  			$config = fopen("../conf/users/config.dat","w");
  			fwrite($config,"<?php\r\n");
  			for ($i = 1; $i<=7; $i++)
  			{
     				fwrite($config,"\$polecaption[".$i."] = \"".$Filtr->clear($_POST['pole'.$i])."\";\r\n");
  			};
  			for ($i = 1; $i<=7; $i++)
  			{
     				if ($_POST['pole'.$i]=="")
     				{
      					fwrite($config,"\$pole[".$i."] = false;\r\n");
     				}
     				else
     				{
      					fwrite($config,"\$pole[".$i."] = true;\r\n");
     				};
  			};
  			fwrite($config,"\$lastid=".$lastid.";\r\n");
  			fclose($config);
  
  			$file = fopen("../conf/users/hidepages.dat","w");
  			fwrite($file,$_POST['page0']."|".$_POST['page1']."|"
  			.$_POST['page2']."|"
  			.$_POST['page3']."|"
  			.$_POST['page4']."|"
  			.$_POST['page5']."|"
  			.$_POST['page6']."|"
  			.$_POST['page7']."|"
  			.$_POST['page8']."|"
 			.$_POST['page9']."|");
  			fclose($file);
  
  			header("location: index.php?action=users&poles=ok&rand=".rand(0,99999));
			break;
		case 'deluser':
			$GlobalUsers->access(1);
			if (!isset($_GET['user']))
  			{
     				die("Error.46: Without USER");
  			};
  
  			$line = (int)$_GET['user'];
  
  			if ($line==0){
     				die("Error.53: First admin not be deleted");
  			};
  
  			$fie = "../conf/users/users.dat";
  
  			$temp = file($fie);
  			$i    = 0;
  			$need = "no";
  			$avatar	=	'noavatar.png';
  			foreach ($temp as $tem)
  			{
       				$te = explode("|",$tem);
       				if ($i==$line)
				{
					$need=$te[18];
					$avatar	=	$te[16];
				};
       				$i++;
  			};
  
  			if ($line != "") {
				$file=file($fie); 

				for($i=0;$i<sizeof($file);$i++)
					if($i==$line) unset($file[$i]); 

				$fp=fopen($fie,"w"); 
				fputs($fp,implode("",$file)); 
				fclose($fp);
  			}
  			else
  			{
        			die("Error.69: LINE not supported");
  			};
  			//А теперь удалить pm_.dat если он есть
  			if (file_exists($GlobalUsers->pmpath($GlobalUsers->getid($need))))
  			{
       				$FileManager->removefile($GlobalUsers->pmpath($GlobalUsers->getid($need)));
  			}; 
  			//А аватару?
  			if ($avatar!='noavatar.png')
  			{
  				if (file_exists($cms_root.'/avatars/'.$avatar))
  					$FileManager->removefile($cms_root.'/avatars/'.$avatar);
  			};
  			header("location: index.php?action=users&rand=".rand(0,99999));
			break;
		case 'banuser':
			$GlobalUsers->access(1);
			if (!isset($_GET['user']))
			{
  				die("Error.46: Without user");
			};

			$old_file = file("../conf/users/users.dat");   

			$i=0;
			foreach ($old_file as $old)
			{                          
      				$p = explode("|",$old);
      				if ($_GET['user']==$p[0])
      				{
          				if ($i==0)
          				{
            					Die("Error.57: Данное действие не может быть выполнено по отношению к главному администратору!");
            					exit;
          				};
      				};
      				$i++;
			};

			$usersfruits[4] = 'baned';
			if (isset($_GET['donotban'])) $usersfruits[4] = 'user';
			$GlobalUsers->editpoles("id",$_GET['user']);
   
			@header("location: index.php?action=users&rand=".rand(0,99999));
			break;
		case 'edituser':
			$GlobalUsers->access(1);
			if (!isset($_POST['submit']))
			{
  				die("Error.6: Without SUBMIT");
			};

			$login = $Filtr->clear($_POST['login']);
			$password = $Filtr->clear($_POST['password']);
			$mail = $Filtr->clear($_POST['mail']);
			$ps = $Filtr->clear($_POST['ps']);
			$avatar = $Filtr->clear($_POST['avatar']);
			$oldavatar = $Filtr->clear($_POST['oldavatar']);
			if (isset($_POST['whybaned'])) $whybaned = $Filtr->clear($_POST['whybaned']);
			else $whybaned = '-';

			$about = $Filtr->clear($_POST['about']);
			if (isset($_POST['status'])) $status = $Filtr->clear($_POST['status']);
			else $status = 'admin';
			$pole = array();
			$pole[0]="_";
			for ($i=1;$i<=7;$i++)
			{
   				$pole[] = $Filtr->clear($_POST['pole'.$i]);
			};
			$messages = (int)$_POST['messages'];
   
			
			$about = str_replace(array("\n","\r"),array("<br>",""),$about);
			
			$ps = str_replace(array("\n","\r"),array("<br>",""),$ps);

			if ($oldavatar != $avatar)
			{
    				if ($oldavatar!="noavatar.png")
    				{
         				@unlink("../avatars/".$oldavatar);
    				};
			};

			$old_file = file("../conf/users/users.dat");   

			$lastlogin = $Filtr->clear($_POST['lastlogin']);
			$i = 0;
			$gen		=	$GlobalUsers->getpole($lastlogin,22);
			if ($password!="") $usersfruits[1] = md5(md5($password).$gen);
			//$usersfruits[0] = pmpath2($login);
			$usersfruits[2] = $mail;
			$usersfruits[3] = $about;
			$usersfruits[4] = $status;
			$usersfruits[5] = $pole[1];
			$usersfruits[6] = $pole[2];
			$usersfruits[7] = $pole[3];
			$usersfruits[8] = $pole[4];
			$usersfruits[9] = $pole[5];
			$usersfruits[10] = $pole[6];
			$usersfruits[11] = $pole[7];
			$usersfruits[14] = $messages;
			$usersfruits[16] = $avatar;
			$usersfruits[17] = $ps;
			$usersfruits[18] = $login;
			$usersfruits[19] = $whybaned;
			$bfg			=	file($cms_root.'/conf/bfg.dat');
			$bfg_types		=	'';
			foreach ($bfg as $bf)
			{
				$b	=	explode('|',$bf);
				if (isset($_POST['editor_'.$b[0]]))
				{
					if ($_POST['editor_'.$b[0]]!='')
						$bfg_types.=$b[0].',';
				};
			};
			$bfg_types	=	substr($bfg_types,0,strlen($bfg_types)-1);
			
			
			if (isset($_POST['bfg_public']))
			{
				if ($_POST['bfg_public']!='')
					$bfg_public	=	'yes';
				else
					$bfg_public	=	'no';
			}
			else
				$bfg_public	=	'no';
				
			if (isset($_POST['banip']))
			{
				if ($_POST['banip']!='')
					$banip	=	'yes';
				else
					$banip	=	'no';
			}
			else
				$banip	=	'no';
				
			if (isset($_POST['plugins_use']))
			{
				if ($_POST['plugins_use']!='')
					$plugins_use	=	'yes';
				else
					$plugins_use	=	'no';
			}
			else
				$plugins_use	=	'no';
				
			if (isset($_POST['comments_edit']))
			{
				if ($_POST['comments_edit']!='')
					$comments_edit	=	'yes';
				else
					$comments_edit	=	'no';
			}
			else
				$comments_edit	=	'no';
				
			if (isset($_POST['bfg_delete']))
			{
				if ($_POST['bfg_delete']!='')
					$bfg_delete	=	'yes';
				else
					$bfg_delete	=	'no';
			}
			else
				$bfg_delete	=	'no';		
			
			$usersfruits[21]	=	$bfg_types.':'.$bfg_public.':'.$bfg_delete.':'.$comments_edit.':'.$plugins_use.':'.$banip;

			$GlobalUsers->editpoles("user",$lastlogin);
   
			header("location: index.php?action=users&rand=".rand(0,99999));
			break;
		case 'editmess':
			$tmp	=	$GlobalUsers->getrules($Filtr->clear($_COOKIE['site_login']));
			if ($tmp['comments_edit']!=true)
			{
				die('Недостаточно прав');
				exit;
			};
			if (!isset($_POST['submit']))
			{
  				die("Error.7: Without SUBMIT");
			};

			$text = $_POST['text'];
			$from = $_POST['from'];
			$line = $_POST['line'];
			$f = $_POST['file'];
			$a = array(".","%"," ","/","\\","#");
			$b = '';
			$from = str_replace($a,$b,$Filtr->clear($from));
			$f = str_replace($a,$b,$Filtr->clear($f));

			if (!is_numeric($line)){
    				die("Error.16: LINE not supported");
			};


			$text = $Filtr->clear($text,true);
			//$text = stripslashes($text);
			$text = str_replace("\n","<br>",$text);
			$text = str_replace("\r","",$text);

			if ($from == "message")
			{
  				$old_file = file("../conf/messages/mess_".$f.".dat");  
  				
  				$lastposts = file("../conf/last_posts.dat");

          			$e = explode("|",$old_file[$line]);
          			foreach ($lastposts as $last)
          			{
               				$l = explode("|",$last);

               				if (
                  				($l[0]=='messages') &&
                  				($l[1]==$e[1]) &&
                  				($l[3]==$e[0]) &&
                  				($l[4]==$e[3])
                  				
              				)
               				{
                  				$GlobalComments->editlastpost('messages',$l[1],$l[2],$l[3],$l[4],$text,$l[5]);

               				};
          			};
  				 
  				$file    = fopen("../conf/messages/mess_".$f.".dat","w");
  				$i = 0;
  				foreach ($old_file as $old)
  				{
      					$o = explode("|",$old);
      					if ($i == $line)
      					{
      		   				fwrite($file,$o[0]."|".$o[1]."|".$o[2]."|".$text."|".$o[4]."|".$o[5]."|".$o[6]."|\r\n");
      					}
      					else
      					{
         					fwrite($file,$old);
      					};
      					$i++;
  				};
  				fclose($file);
  				$back = "&from=message&message=".$f."&line=".(int)$_POST['addline'];
			}
			else if ($from == "gb")
			{
  				$old_file = file("../conf/guestbook.dat");   
  				$file    = fopen("../conf/guestbook.dat","w");
  				$i = 0;
  				foreach ($old_file as $old)
  				{
      					$o = explode("|",$old);
      					if ($i == $line)
      					{
         					fwrite($file,$o[0]."|".$o[1]."|".$o[2]."|".$text."|".$o[4]."|".$o[5]."|".$o[6]."|\r\n");
      					}
      					else
      					{
         					fwrite($file,$old);
      					};
     	 				$i++;
  				};
  				fclose($file);
  				$back = "&from=gb";
			}
			else
			{

  				$old_file = file("../conf/".$from."/".$f.".dat");

          			$elsefile = file("../conf/".$from."/".$f.".dat");
          			$lastposts = file("../conf/last_posts.dat");

          			$e = explode("|",$elsefile[$line]);
          			foreach ($lastposts as $last)
          			{
               				$l = explode("|",$last);

               				if (
                  				($l[0]==$from) &&
                  				($l[1]==$e[1]) &&
                  				($l[3]==$e[0]) &&
                  				($l[4]==$e[3]) &&
                  				($l[5]==$f)
              				)
               				{
                  				$GlobalComments->editlastpost($from,$l[1],$l[2],$l[3],$l[4],$text,$l[5]);

               				};
          			};
   
  				$file    = fopen("../conf/".$from."/".$f.".dat","w");
  				$i = 0;
  				foreach ($old_file as $old)
  				{
      					$o = explode("|",$old);
      					if ($i == $line)
      					{
         					fwrite($file,$o[0]."|".$o[1]."|".$o[2]."|".$text."|".$o[4]."|".$o[5]."|".$o[6]."|\r\n");
      					}
      					else
      					{
         					fwrite($file,$old);
      					};
      					$i++;
  				};
  				fclose($file);
  				$back = "&from=".$from."&news=".$f;
			};
   
			header("location: index.php?action=messages&rand=".rand(0,99999).$back);
			break;
		case 'delcomment':
			$tmp	=	$GlobalUsers->getrules($Filtr->clear($_COOKIE['site_login']));
			if ($tmp['comments_edit']!=true)
			{
				die('Недостаточно прав');
				exit;
			};
			$needlast = false;

  			$a = array(".","%"," ","/","\\","#");
  			if (isset($_GET['frommessage']))
  			{
    				$file = str_replace($a,'',$Filtr->clear($_GET['file']));
    				$line = (int)$_GET['line'];
    				
    				//Сначала надо удалить поочередно комментарии
    				$comments	=	file($cms_root.'/conf/messages/mess_'.$file.'.dat');    				
    				foreach ($comments as $comment)
    				{
    					$e	=	explode('|',$comment);
    					$lastposts	=	file($cms_root.'/conf/last_posts.dat');
    					foreach ($lastposts as $ls)
    					{
    						$l	=	explode('|',$ls);
    						if (
               						($l[0]=='messages')
               						and
               						($l[1]==$e[1])
               						and
               						($l[3]==$e[0])
               						and
               						($l[4]==$e[3])
               					) {
               						$GlobalComments->dellastpost('messages',$l[1],$l[3],$l[4],$l[5]);
							break;
						}
    					};    					
               				
    				};
    				//
    				
    				$FileManager->removefile("../conf/messages/mess_".$file.".dat");
    				$fie = "../conf/messages/listmess.dat";
    				$file=file($fie); 

				for($i=0;$i<sizeof($file);$i++)
					if($i==$line) unset($file[$i]); 

				$fp=fopen($fie,"w"); 
				fputs($fp,implode("",$file)); 
				fclose($fp);
    				header("location: index.php?action=message&rand=".rand(0,9999));
    				exit;
  			};
  
  			if (!isset($_GET['type']))
  			{
     				echodie("Error.55: Without type");
  			};
  
  			$type = $_GET['type'];
  			$line = (int)$_GET['line'];
  
  			if ($type == "message")
  			{
     				$news = str_replace($a,'',$Filtr->clear($_GET['message']));
     				$fie = "../conf/messages/mess_".$news.".dat";
     				$back = "&from=message&message=".$news."&line=".(int)$_GET['addline'];
     				$needlast	=	true;
  			}
  			else if ($type == "gb")
  			{
     				$fie = "../conf/guestbook.dat";
     				$back = "&from=gb";
  			}
  			else if ($type == "feedback")
  			{
     				$fie = "../conf/feedback.dat";
     				$back = "&from=feedback";
  			}
  			else 
  			{ 
     				$news = str_replace($a,'',$Filtr->clear($_GET['news']));
     				$fie = "../conf/".$type."/".$news.".dat";
     				$back = "&from=".$type."&news=".$news;
                                $needlast=true;
  			};
  
			$file=file($fie); 
        		$tmp = explode("|",$file[$line]);
        
        		$old_users = file("../conf/users/users.dat");
        		$i = 0;
        		foreach ($old_users as $old_user)
        		{
           			$old = explode("|",$old_user);
           			if ($Filtr->tolower($old[18])==$Filtr->tolower($tmp[1]))
           			{   
               				$usersfruits[14] = $old[14] - 1;
               				$GlobalUsers->editpoles("pos",$i);
           			};
           			$i++;
        		};
        
        		if ($needlast)
        		{
           			$elsefile = file($fie);
           			$lastposts = file("../conf/last_posts.dat");

           			$e = explode("|",$elsefile[$line]);
           			foreach ($lastposts as $last)
           			{
               				$l = explode("|",$last);
               				if ($type=='message')
               				{
               					if (
               						($l[0]=='messages')
               						and
               						($l[1]==$e[1])
               						and
               						($l[3]==$e[0])
               						and
               						($l[4]==$e[3])
               					) {
							
               						$GlobalComments->dellastpost('messages',$l[1],$l[3],$l[4],$l[5]);
							break;
						}
               				}
               				else
               				{
               					if (
                  					($l[0]==$type) &&
                  					($l[1]==$e[1]) &&
                  					($l[3]==$e[0]) &&
                  					($l[4]==$e[3]) &&
                  					($l[5]==$news)
               					)
               					{
                  					$GlobalComments->dellastpost($type,$l[1],$l[3],$l[4],$l[5]);
							break;
               					};
               				};
           			};
           
        		};
        
			for($i=0;$i<sizeof($file);$i++)
				if($i==$line) unset($file[$i]); 

			$fp=fopen($fie,"w"); 
			fputs($fp,implode("",$file)); 
			fclose($fp);

  			header("location: index.php?action=messages&rand=".rand(0,99999).$back);
			break;
		case 'showmess':
			$tmp	=	$GlobalUsers->getrules($Filtr->clear($_COOKIE['site_login']));
			if ($tmp['comments_edit']!=true)
			{
				die('Недостаточно прав');
				exit;
			};
			$from 	= $_GET['from'];
			(isset($_GET['file'])) ? $file = $_GET['file'] : $file = "";
			$a = array(".","%"," ","/","\\","#");
			$b = array("","","","","","");
			$from = str_replace($a,$b,$Filtr->clear($from));
			$file = str_replace($a,$b,$Filtr->clear($file));
			$showingorno = "yes";
			if (isset($_GET['withdo'])) $showingorno = "no";
			$line = (int)$_GET['line'];
			if ($from == "message")
			{
  				$fp 		= 	"../conf/messages/mess_".str_replace(".","",$Filtr->clear($file)).".dat";
  				$back 		= 	"&line=".(int)$_GET['addline']."&message=".$Filtr->clear($file);
				
				$lastposts 	= 	file("../conf/last_posts.dat");
				$elsefile	=	file($fp);

          			$e = explode("|",$elsefile[$line]);
          			foreach ($lastposts as $last)
          			{
               				$l = explode("|",$last);
					//e   23.05.11, 21:07|Денис|admin@domain.here|Комментарий в одиночном разделе.||127.0.0.1|yes|
					//l          messages|Денис|yes|23.05.11, 21:07|Комментарий в одиночном разделе.|downloads.html|Загрузки|
               				if (
                  				($l[0]=='messages') &&
                  				($l[1]==$e[1]) &&
                  				($l[3]==$e[0]) &&
                  				($l[4]==$e[3])
               				)
               				{
                  				$GlobalComments->editlastpost('messages',$l[1],$showingorno,$l[3],$l[4],$l[4],$l[5]);
               				};
          			};
			}
			else if ($from == "gb")
			{
  				$fp = "../conf/guestbook.dat";
  				$back = "";
			}
			else
			{
  				$fp = "../conf/".$from."/".$file.".dat";
  				$back = "&news=".$file;
  				$elsefile = file($fp);
  				$lastposts = file("../conf/last_posts.dat");

          			$e = explode("|",$elsefile[$line]);
          			foreach ($lastposts as $last)
          			{
               				$l = explode("|",$last);

               				if (
                  				($l[0]==$from) &&
                  				($l[1]==$e[1]) &&
                  				($l[3]==$e[0]) &&
                  				($l[4]==$e[3]) &&
                  				($l[5]==$file)
               				)
               				{
                  				$GlobalComments->editlastpost($from,$l[1],$showingorno,$l[3],$l[4],$l[4],$l[5]);
               				};
          			};
 			};
			$blogs = file($fp);

			$tmp = explode("|",$blogs[$line]);
        
			$old_users = file("../conf/users/users.dat");
			$i = 0;
			foreach ($old_users as $old_user)
			{
           			$old = explode("|",$old_user);
           			if ($Filtr->tolower($old[18])==$Filtr->tolower($tmp[1]))
           			{
               				if ($showingorno!="no")
               				{
                    				$usersfruits[14] = $old[14] + 1;
               				}
               				else
               				{
                    				$usersfruits[14] = $old[14] -1;
               				};
               				$GlobalUsers->editpoles("pos",$i);
           			};
           			$i++;
			};

			$i=1;
			$original_blog = $blogs[$line];
			$new_blog = explode("|",$original_blog);
			$new_blog[6]=$showingorno;
			$blogs[$line] = implode("|",$new_blog);

			$fp = fopen($fp,"w");
			foreach ($blogs as $blogs_) {
 				fputs($fp,$blogs_);
			}
			fclose($fp);
			header ("location: index.php?action=messages&from=".$from.$back."&rand=".rand(0,99999));
			break;
		case 'bfgdelrecord':
			$GlobalUsers->access(4,$Filtr->clear($_GET['type']));
			$tmp	=	$GlobalUsers->getrules($Filtr->clear($_COOKIE['site_login']));
			if ($tmp['bfg_delete']!=true)
			{
				die('Недостаточно прав');
				exit;
			};
			if (!isset($_GET['news']))
  			{
     				die("Error.47: Without NEWS");
  			};
			
			if ($GlobalUsers->getstatus($Filtr->clear($_COOKIE['site_login']))=='editor')
			{
				$type	=	$Filtr->clear($_GET['type']);
				$news	=	$Filtr->clear($_GET['news']);
				$list	=	file($cms_root.'/conf/'.$type.'/list.dat');
				$founded=	false;
				foreach ($list as $ls)
				{
					$l	=	explode('|',$ls);
					if ($l[6]==$news)
					{
						if ($l[1]!=$Filtr->clear($_COOKIE['site_login']))
						{
							die('Редактору разрешено удалять только свои новости');
							exit;
						};
						$founded	=	true;
						break;
					};
				};
				if (!$founded)
				{
					die('error1363');
					exit;
				};
			};
			
			$flag = $GlobalBFG->delrecord($Filtr->clear($_GET['list']),$Filtr->clear($_GET['news']),$Filtr->clear($_GET['type']));
			updatesearch();
  			if ($flag)
  			{
      				header("location: index.php?action=bfgshow&type=".$Filtr->clear($_GET['type'])."&go=deleted&rand=".rand(0,99999));
  			}
  			else
  			{
      				die("Error.80: File was not deleted");
  			};
			break;
		case 'bfgeditrecord':
			$GlobalUsers->access(4,$Filtr->clear($_POST['type']));
			if ($GlobalUsers->getstatus($Filtr->clear($_COOKIE['site_login']))=='editor')
			{
				$type	=	$Filtr->clear($_POST['type']);
				$news	=	$Filtr->clear($_POST['newss']);
				$list	=	file($cms_root.'/conf/'.$type.'/list.dat');
				$founded=	false;
				foreach ($list as $ls)
				{
					$l	=	explode('|',$ls);
					if ($l[6]==$news)
					{
						if ($l[1]!=$Filtr->clear($_COOKIE['site_login']))
						{
							die('Редактору разрешено редактировать только свои новости');
							exit;
						};
						$founded	=	true;
						break;
					};
				};
				if (!$founded)
				{
					die('error1363');
					exit;
				};
			};
			if (!isset($_POST['submit']))
				die("Error.55: Without submit!");
			$GlobalBFG->editrecord();
			updatesearch();
			header("location: index.php?action=bfgshow&type=".$_POST['type']."&go=edited&rand=".rand(0,99999));
			break;
		case 'bfgaddrecord':
			$GlobalUsers->access(4,$Filtr->clear($_POST['type']));
			if (!isset($_POST['submit']))
			{
  				die("Error.47: Without submit");
			};

			$GlobalBFG->createrecord($Filtr->clear($_POST['type']),$Filtr->clear($_COOKIE['site_login']));
			updatesearch();
			header("location: index.php?action=bfgshow&go=added&type=".$Filtr->clear($_POST['type'])."&rand=".rand(0,99999));
			break;
		case 'bfgdelete':
			$GlobalUsers->access(1);
			
			if (!isset($_GET['pos']))
			{
  				die("Error.56: Without POS");
				exit;
			};

			$pos = (int)$_GET['pos'];
			$bfg = file("../conf/bfg.dat");
			$b = explode("|",$bfg[$pos]);
			$type = $b[0];
			
			//удаление новостей
			$list	=	file($cms_root.'/conf/'.$type.'/list.dat');
			$i	=	0;
			foreach ($list as $ls)
			{
				$l	=	explode('|',$ls);
				$GlobalBFG->delrecord($i,$l[6],$type);
				$i++;
			};
			
			//

			$FileManager->removedir("../conf/".$type);
  			$file=file("../conf/bfg.dat");
  			$line = $pos; 
  			for($i=0;$i<sizeof($file);$i++)
  				if($i==$line) unset($file[$i]); 
  			$fp=fopen("../conf/bfg.dat","w"); 
  			fputs($fp,implode("",$file)); 
  			fclose($fp);

			if (file_exists($cms_root.'/conf/cache/cats_'.$type))
				$FileManager->removefile($cms_root.'/conf/cache/cats_'.$type);
			if (file_exists($cms_root.'/conf/cache/tags_'.$type))
				$FileManager->removefile($cms_root.'/conf/cache/tags_'.$type);

			$GlobalBFG->refreshrewrite();
			updatesearch();
			header("location: index.php?action=bfg&rand=".rand(0,99999));
			break;
		case 'bfgedit':
			$GlobalUsers->access(1);
			if (!isset($_POST['submit']))
			{
  				die("Error.7: Without submit");
			};

			$pos = (int) $_POST['pos'];
			$description = $Filtr->clear($_POST['description']);
			$page1 = $Filtr->clear($_POST['page1']);

			$old = file("../conf/bfg.dat");
			$new = fopen("../conf/bfg.dat","w");
			$i = 0;
			foreach ($old as $o)
			{
   				$s = explode("|",$o);
   				($i==$pos) ? fwrite($new,$s[0]."|".$description."|".$page1."|\r\n") : fwrite($new,$o);
   				$i++;
			};
			fclose($new);
			$GlobalBFG->refreshrewrite();
			header("location: index.php?action=bfg&rand=".rand(0,99999));
			break;
		case 'bfgnew':
			$GlobalUsers->access(1);
			if (!isset($_POST['submit']))
			{
				header('location: index.php?action=localmessage&line=without_submit');
				exit;
			};
			$type = $Filtr->clear($Filtr->tolower($_POST['type']));
			$bisy	=	array('cache','logs','messages','pages','users');
			$bfg	=	file($cms_root.'/conf/bfg.dat');
			foreach ($bfg as $bf)
			{
				$b	=	explode('|',$bf);
				$bisy[]	=	$b[0];
			};
			foreach ($bisy as $bis)
			{
				if ($type==$bis)
				{
					header('location: index.php?action=localmessage&line=bfg_used');
					exit;
				};
			};
			if (!preg_match('/^[a-z0-9\-]+$/', $type))
			{
				header('location: index.php?action=localmessage&line=bfg_symbols');
				exit;
			};
			if (strlen($type)<2)
			{
  				header('location: index.php?action=localmessage&line=bfg_length');
				exit;
			};
			$description = $Filtr->clear($_POST['description']);
			$page1 = $Filtr->clear($_POST['page1']);

			$FileManager->makedir("../conf/".$type);
			chmod("../conf/".$type,0777);

			$file = fopen("../conf/".$type."/.htaccess","w");
			fwrite($file,"deny from all");
			fclose($file);
			chmod("../conf/".$type."/.htaccess",0777);

			$file = fopen("../conf/".$type."/last_category.dat","w");
			fwrite($file,"");
			fclose($file);
			chmod("../conf/".$type."/last_category.dat",0777);

			$file = fopen("../conf/".$type."/list.dat","w");
			fwrite($file,"");
			fclose($file);
			chmod("../conf/".$type."/list.dat",0777);

			$file = fopen("../conf/".$type."/views.dat","w");
			fwrite($file,"");
			fclose($file);
			chmod("../conf/".$type."/views.dat",0777);

			$file = fopen("../conf/bfg.dat","a");
			fputs($file,$type."|".$description."|".$page1."|\r\n");
			fclose($file);

			$GlobalBFG->refreshrewrite();
			header("location: index.php?action=bfg&rand=".rand(0,99999));
			break;
		case 'savefile':
			$GlobalUsers->access(1);
			if (!isset($_POST['text'])){ die("Error.5: Without TEXT");};
  			if (!file_exists($Filtr->clear($_POST['file']))){ die("Error.6: File not found");};
  			$text = $_POST['text'];
  			$file = $Filtr->clear($_POST['file']);
  			if (!is_writable($file)) { die("Error.58: File is not writable");};
  			$fp = fopen($file,"w");
  			fwrite($fp, $text);
  			fclose($fp);
  			if (isset($_GET['style'])){$add = "&style=yes";} else $add = "";
			updatesearch();
  			(isset($_GET['plus'])) ? header("location: index.php?action=style&theme=".$Filtr->clear($_GET['plus'])."&name=".$Filtr->clear($_GET['name'])."&done=yes") : header("location: index.php?action=edit&file=".$file."&saved=ok".$add); 
			break;
		case 'generalsave':
			$GlobalUsers->access(1);
			$tusers = file($cms_root."/conf/users/users.dat");
			$t      = explode("|",$tusers[0]);
			if ($Filtr->tolower($t[18])==$Filtr->tolower($_COOKIE['site_login']))
  				$AL = (int)$_POST['alog'];
			else
  				$AL = $cms_needalog;
			if (!isset($_POST['submit']))			
    				die ("Error.61: Without SUBMIT");
    			$config = fopen("../conf/config.php","w");
			$last = $cms_rewrite;
			if ($cms_rewrite_ext != $_POST['rewrite_ext'])
				$last = 2;
			$closed_text = str_replace("\r","",$_POST['closed_text']);
			$closed_text = str_replace("\n","",$closed_text);
			$rss = fopen("../conf/rss.dat","w");
			fwrite($rss,"<?php
					\$rss_pub_date = \"".$rss_pub_date."\";
					\$rss_gdd = \"".$Filtr->clear($_POST['rss'])."\";
					\$cms_rss_id = \"".$Filtr->clear($_POST['rss_id'])."\";
			");
			fclose($rss);
			if ($cms_punycode==1)
			{
				$tmp = $IDN->encode($Filtr->clear($_POST['site']));
				$_POST['site'] = htmlentities($tmp, null, 'UTF-8');
			}
			else
				$_POST['site']	=	$Filtr->clear($_POST['site']);
			fwrite($config, "<?php
					\$cms_site              = \"".$Filtr->delendslash($_POST['site'])."\";
					\$cms_root              = \"".$Filtr->clear($Filtr->delendslash($_POST['root']))."\";
					\$cms_gzip              = ".(int)$_POST['gzip'].";
					\$cms_sendmess          = ".(int)$_POST['sendmess'].";
					\$cms_mail              = \"".$Filtr->clear($_POST['mail'])."\";
					\$cms_needlog           = ".(int)$_POST['log'].";
					\$cms_needalog          = ".$AL.";
					\$cms_online_time       = ".(int)$_POST['onlinetime'].";
					\$cms_needrecord        = ".(int)$_POST['record'].";
					\$cms_closed            = ".(int)$_POST['closed'].";
					\$cms_closed_text       = \"".str_replace("\"","'",$closed_text)."\";
					\$cms_nocache           = ".(int)$_POST['nocache'].";
					\$cms_noshowerr         = ".(int)$_POST['noshowerr'].";
					\$cms_ban               = ".(int)$_POST['ban'].";
					\$cms_http              = ".(int)$_POST['http'].";
					\$cms_noindexlinks      = ".(int)$_POST['noindex'].";
					\$cms_premoder          = ".(int)$_POST['premoder'].";
					\$cms_time_cookie       = ".(int)$_POST['time_cookie'].";
					\$cms_banlog            = ".(int)$_POST['banlog'].";
					\$cms_smiles            = ".(int)$_POST['smiles'].";
					\$cms_oncomments        = ".(int)$_POST['comments'].";
					\$cms_noflood           = ".(int)$_POST['noflood'].";
					\$cms_top_show          = ".(int)$_POST['top_show'].";
					\$cms_top_count         = ".(int)$_POST['top_count'].";
					\$cms_views_counter     = ".(int)$_POST['views_counter'].";
					\$cms_max_message       = ".(int)$_POST['max_message'].";
					\$cms_mail_select       = \"".$Filtr->clear($_POST['mail_select'])."\";
					\$cms_save_admin_ip     = \"".$Filtr->clear($_POST['save_admin_ip'])."\";
					\$cms_rewrite           = 1;
					\$cms_active            = ".(int)$_POST['active'].";
					\$cms_active_mail       = \"".$Filtr->clear($_POST['active_mail'])."\";
					\$cms_active_name       = \"".$Filtr->clear($_POST['active_name'])."\";
					\$cms_avatars           = ".(int)$_POST['avatars'].";
					\$cms_upload_maxsite    = ".(int)$_POST['upload_maxsite'].";
					\$cms_upload_width      = ".(int)$_POST['upload_width'].";
					\$cms_upload_height     = ".(int)$_POST['upload_height'].";
					\$cms_restore           = ".(int)$_POST['restore'].";
					\$cms_ps                = ".(int)$_POST['ps'].";
					\$cms_ps_max            = ".(int)$_POST['ps_max'].";
					\$cms_plusmess          = ".(int)$_POST['plusmess'].";
					\$cms_rewrite_ext       = \"".$Filtr->clear($_POST['rewrite_ext'])."\";
					\$cms_cenzura           = ".(int)$_POST['cenzura'].";
					\$cms_cenzura_words     = \"".$Filtr->clear($_POST['cenzura_words'])."\";
					\$cms_lastposts_count   = ".(int)$_POST['lastposts_count'].";
					\$cms_lastposts_len     = ".(int)$_POST['lastposts_len'].";
					\$cms_theme             = \"".$Filtr->clear($_POST['theme'])."\";
					\$cms_directdownload    = ".(int)$_POST['directdownload'].";
					\$cms_fullredirect      = ".(int)$_POST['fullredirect'].";
					\$cms_pm_max            = ".(int)$_POST['pm_max'].";
					\$cms_pm_showusers      = ".(int)$_POST['pm_showusers'].";
					\$cms_avatars_resize    = ".(int)$_POST['resize'].";
					\$cms_avatars_maxresize = ".(int)$_POST['maxresize'].";
					\$cms_log_max           = ".(int)$_POST['log_max'].";
					\$cms_gravatars         = ".(int)$_POST['gravatars'].";
					\$cms_gravatars_im      = \"".$Filtr->clear($_POST['gravatars_im'])."\";
					\$cms_guestnotwrite     = ".(int)$_POST['guestnotwrite'].";
					\$cms_language          = \"".$Filtr->clear($_POST['language'])."\";
					\$cms_createlinks       = ".(int)$_POST['createlinks'].";
                                        \$cms_img_comment	= ".(int)$_POST['img_comments'].";
					\$cms_send_mail         = \"".$Filtr->clear($_POST['send_mail'])."\";
					\$cms_timezone          = \"".$_POST['timezone']."\";
					\$cms_adminm            = ".(int)$_POST['adminm'].";
					\$cms_fontfamily        = \"".$Filtr->clear($_POST['fontfamily'])."\";
					\$cms_fontsize          = ".(int)$_POST['fontsize'].";
					\$cms_nav_news          = ".(int)$_POST['nav_news'].";
					\$cms_nav_comments      = ".(int)$_POST['nav_comments'].";
					\$cms_nav_downloads     = ".(int)$_POST['nav_downloads'].";
					\$cms_nav_faq           = ".(int)$_POST['nav_faq'].";
					\$cms_nav_pm            = ".(int)$_POST['nav_pm'].";
					\$cms_nav_system        = ".(int)$_POST['nav_system'].";
					\$cms_editarea          = ".(int)$_POST['editarea'].";
					\$cms_editareawp        = ".(int)$_POST['editareawp'].";
					\$cms_oneipreg		= ".(int)$_POST['oneipreg'].";
					\$cms_hide_admin	= ".(int)$_POST['hide_admin'].";
					\$cms_without_mail	= ".(int)$_POST['without_mail'].";
					\$cms_uniqbfg		= ".(int)$_POST['uniqbfg'].";
					\$cms_rss_title		= \"".$Filtr->clear($_POST['rsstitle'])."\";
					\$cms_punycode		= ".(int)$_POST['punycode'].";
					\$cms_visual		= ".(int)$_POST['visual'].";
					\$cms_simcount		= ".(int)$_POST['simcount'].";
					\$cms_furl		= ".(int)$_POST['furl'].";
					\$cms_showbfghints	= ".(int)$_POST['showbfghints'].";
					\$cms_premod_mess	= ".(int)$_POST['premod_mess'].";
					\$cms_rss_count		= ".(int)$_POST['rss_count'].";
					\$cms_whois		= \"".$Filtr->clear($_POST['whois'])."\";
					\$cms_wwwredirect	= ".(int)$_POST['wwwredirect'].";
					\$cms_title_length	= ".(int)$_POST['title_length'].";
					\$cms_registration	= ".(int)$_POST['registration'].";
					\$cms_nav_back		= ".(int)$_POST['nav_back'].";
					\$cms_top_news_max	= ".(int)$_POST['top_news_max'].";
");

			$cms_rewrite          = 1;
			$cms_rewrite_ext      = $Filtr->clear($_POST['rewrite_ext']);
			$cms_site	=	$Filtr->delendslash($_POST['site']);
			$GlobalBFG->refreshrewrite($_POST['furl']);

			fclose($config);
			header("location: index.php?action=general&rand=".rand(0,99999)."&go=yes");
			break;
	};
};

