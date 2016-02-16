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

	include("check2.php");
	$options= "";
  
	$tmp	=	$GlobalUsers->getrules($login);
	if ($tmp['comments_edit']!=true) {
		die('Недостаточно прав');
		exit;
	}
      
	if (isset($_GET['from'])) {
		$from	= $_GET['from'];
		if ($from == "message") {
			if (isset($_GET['message'])) {
				$file	= file("../conf/messages/mess_".str_replace(".","",$Filtr->clear($_GET['message'])).".dat");
				if (count($file)>0)
					$p	= explode("|",$file[0]);
				$listmess 	= file("../conf/messages/listmess.dat");
				$o 		= explode("|",$listmess[(int)$_GET['line']]);
				$menu 		= '
							<h2>Комментарии</h2>
							<font class="desc">Управление комментариями раздела "<b>'.$o[1].'</b>"</font><br><br>  
						';
				$messages 	= '<center><table class="optionstable" border=0 cellpadding=1 cellspacing=0>
							<tr class="titletable"><td>КОММЕНТАРИЙ</td><td>ДЕЙСТВИЯ</td></tr>';
				for ($i=count($file)-1; $i>-1; $i--)
				{
					$p = explode("|",$file[$i]);
					if ($p[6]=="yes") {
						$p[6]="Да";
					} else 
						$p[6]="Нет";
					($cms_smiles==1) ? $tm = $GlobalTemplate->usebbcodes($p[3],'html') : $tm = $p[3]; 
					$messages.="<tr><td><b>Дата:</b> ".$Filtr->fulldate($p[0])."<br>
							<b>Имя:</b> ".$p[1]."<br>
							<b>E-mail:</b> ".$p[2]."<br>
							<b>IP:</b> ".$Filtr->ipclick($p[5])."<br>
							<b>Отображено:</b> ".$p[6]."<br>
							<b>Сообщение:</b> ".$tm."</td><td width=130>";
					if ($p[6]=='Да')
						$messages.="<a href=\"saver.php?saverdo=showmess&amp;withdo=hidecomment&amp;from=message&amp;file=".$Filtr->clear($_GET['message'])."&amp;line=".$i."&amp;addline=".(int)$_GET['line']."\">Скрыть</a><br><bR>";
					else
						$messages.="<a href=\"saver.php?saverdo=showmess&amp;from=message&amp;file=".$Filtr->clear($_GET['message'])."&amp;line=".$i."&amp;addline=".(int)$_GET['line']."\">Отобразить</a><br><bR>";
					$messages.="               
							<a href=\"?action=messages&amp;from=message&amp;go=edit&amp;message=".$Filtr->clear($_GET['message'])."&amp;line=".(int)$_GET['line']."&amp;addline=".$i."\">Изменить</a><br><bR>
							<a href=\"#\" onClick=\"if (checkhead()) location.href='saver.php?saverdo=delcomment&amp;type=".$from."&amp;message=".$Filtr->clear($_GET['message'])."&amp;addline=".(int)$_GET['line']."&amp;line=".$i."';\">Удалить</a>
					";                   
				};
				$messages .= '</table></center>
							';
			};
		} else if ($from == "feedback") {
			$GlobalUsers->access(1);
			$file = @file("../conf/feedback.dat");
			if (count($file)>0)
			$p = explode("|",$file[0]);
			$menu = '
				<h2>Обратная связь</h2>
				<font class="desc">История сообщений, отправленных через форму обратной связи</font><br><br>  
				';
			$messages = '<center><table class="optionstable" border=0 cellpadding=1 cellspacing=0>
					<tr class="titletable"><td>СООБЩЕНИЕ</td><td>ДЕЙСТВИЯ</td></tr>
				';
			for ($i=count($file)-1; $i>-1; $i--) {
				$p = explode("|",$file[$i]);
				($cms_smiles==1) ? $tm = $GlobalTemplate->usebbcodes($p[1],'html') : $tm = $p[1]; 
				$messages.="<tr><td>".$p[0]."<br>
					Сообщение: ".$tm."</td><td width=130>
						<a href=\"#\" onClick=\"if (checkhead()) location.href='saver.php?saverdo=delcomment&amp;type=".$from."&amp;line=".$i."';\">Удалить</a>
					";                   
			};
			$messages .= '</table></center>
					';
		} else {
			if (isset($_GET['news'])) {
				$file = file("../conf/".$from."/".$Filtr->clear($_GET['news']).".dat");
				$p = explode("|",$file[0]);
              
				$bfg = file($cms_root.'/conf/bfg.dat');
				foreach ($bfg as $bf) {
					$b = explode("|",$bf);
					if ($b[0]==$from) {
						$nameofbfg = $b[1];
						break;
					};
				};
		
				$menu = '
					<h2>Комментарии</h2>
					<font class="desc">Управление комментариями записи "<b>'.$p[2].'</b>" новостного раздела <a href="?action=bfgshow&type='.$from.'">'.$nameofbfg.'</a></font><br><br>  
					';
				$messages = '<center><table class="optionstable" border=0 cellpadding=1 cellspacing=0>
						<tr class="titletable"><td>КОММЕНТАРИЙ</td><td>ДЕЙСТВИЯ</td></tr>
				';
				
				$lastposts = file("../conf/last_posts.dat");
				for ($i=count($file)-1; $i>0; $i--) {
					$p = explode("|",$file[$i]);
					if ($p[6]=="yes") {$p[6]="Да";} else $p[6]="Нет";
					($cms_smiles==1) ? $tm = $GlobalTemplate->usebbcodes($p[3],'html') : $tm = $p[3];
					
					$messages.="<tr><td><b>Дата:</b> ".$Filtr->fulldate($p[0])."<br>
							<b>Имя:</b> ".$p[1]."<br>
							<b>E-mail:</b> ".$p[2]."<br>
							<b>IP:</b> ".$Filtr->ipclick($p[5])."<br>
							<b>Отображено:</b> ".$p[6]."<br>
							<b>Сообщение:</b> ".$tm."</td><td width=130>
							<a href=\"../".$from."/".$_GET['news'].$cms_rewrite_ext."?message=[quote=".$p[1]."]".str_replace('<br>',' ',$p[3])."[/quote]&amp;rand=".rand(1,999)."#messbox\" target=\"_blank\">Ответить</a><br><br>";
					if ($p[6]=='Да')
						$messages.="<a href=\"saver.php?saverdo=showmess&amp;withdo=hidecomment&amp;from=".$from."&amp;file=".$Filtr->clear($_GET['news'])."&amp;line=".$i."&amp;lastline=\">Скрыть</a><br><bR>";
					else
						$messages.="
							<a href=\"saver.php?saverdo=showmess&amp;from=".$from."&amp;file=".$Filtr->clear($_GET['news'])."&amp;line=".$i."&amp;lastline=\">Отобразить</a><br><bR>";
						$messages.="
				
							<a href=\"?action=messages&amp;from=".$from."&amp;go=edit&amp;news=".$Filtr->clear($_GET['news'])."&amp;line=".$i."\">Изменить</a><br><bR>
							<a href=\"#\" onClick=\"if (checkhead()) location.href='saver.php?saverdo=delcomment&amp;type=".$from."&amp;news=".$Filtr->clear($_GET['news'])."&amp;line=".$i."';\">Удалить</a>
							";                   
				};
				$messages .= '</table></center>
						';
			};
		};
	} else {
		$messages = "";
	};
  
	if (isset($_GET['go'])) {
		$from = $_GET['from'];
		(isset($_GET['addline'])) ? $line = $_GET['addline'] : $line = $_GET['line'];
		if ($from=="message") {
			$file = $Filtr->clear($_GET['message']);
			$fp = file("../conf/messages/mess_".$file.".dat");
			$p = explode("|",$fp[$line]);
		} else if ($from=="gb") {
			$file = "";
			$fp = file("../conf/guestbook.dat");
			$p = explode("|",$fp[$line]);
		} else {
			$file = $Filtr->clear($_GET['news']);
			$fp = file("../conf/".$from."/".$file.".dat");
			$p = explode("|",$fp[$line]);
		};
		$smiles = '';
		$smilesdb = file($cms_root."/conf/smiles.dat");
		foreach ($smilesdb as $smilesd) {
			$smile = str_replace("\r\n","",$smilesd);
			if ($smile!='')
				$smiles.='<img alt="'.$smile.'" src="'.$cms_site.'/smiles/'.$smile.'.gif" border=0 style="cursor:hand;" onClick="tag(document.getElementById(\'mess\'),\'['.$smile.']\',\'\'); document.getElementById(\'smiles\').style.display=\'none\';"> ';
		};
		$menu .= "
				<center><table class=\"optionstable\" border=0 cellpadding=1 cellspacing=0>
				<tr class=\"titletable\"><td>РЕДАКТИРОВАНИЕ КОММЕНТАРИЯ</td></tr>
				<tr><td>
				<form name=\"edit\" method=\"post\" action=\"saver.php?saverdo=editmess\">
			";
		$menu.='
				<input type="button" onClick="if (document.getElementById(\'smiles\').style.display==\'none\'){document.getElementById(\'smiles\').style.display=\'block\';} else {document.getElementById(\'smiles\').style.display=\'none\';};"
				value="=)">
				<table bgcolor="white" class="smilestable" cellpadding=1 cellspacing=0 id="smiles" style="position:absolute;display:none;">
					<tr><td width=350>
						'.$smiles.'
					</td></tr>
				</table>
				<input type="button" value="ж" style="font-weight:bold" onClick="tag(document.getElementById(\'mess\'),\'[b]\',\'[/b]\');">
				<input type="button" value="к" style="font-style:italic" onClick="tag(document.getElementById(\'mess\'),\'[i]\',\'[/i]\');">
				<input type="button" value="ч" style="text-decoration:underline" onClick="tag(document.getElementById(\'mess\'),\'[u]\',\'[/u]\');">
				<input type="button" value="п" style="text-decoration:line-through" onClick="tag(document.getElementById(\'mess\'),\'[s]\',\'[/s]\');">
				<input type="button" value="&lt;==" onClick="tag(document.getElementById(\'mess\'),\'[left]\',\'[/left]\');">
				<input type="button" value="&lt;=&gt;" onClick="tag(document.getElementById(\'mess\'),\'[center]\',\'[/center]\');">
				<input type="button" value="==&gt;" onClick="tag(document.getElementById(\'mess\'),\'[right]\',\'[/right]\');">
				<input type="button" value="спойлер" onClick="tag(document.getElementById(\'mess\'),\'[spoiler=Заголовок спойлера]\',\'[/spoiler]\');">
				<input type="button" value="цитата" onClick="tag(document.getElementById(\'mess\'),\'[quote]\',\'[/quote]\');">
				<input type="button" value="скрыть" onClick="tag(document.getElementById(\'mess\'),\'[hide]\',\'[/hide]\');">
				<input type="button" value="ссылка" onClick="tag(document.getElementById(\'mess\'),\'[url]\',\'[/url]\');">
				<br>';
		$menu .=" 
				<textarea name=\"text\" id=\"mess\" cols=90 rows=9>".str_replace(
												array("<br>","[dividinglinere]"),
												array("\n","|"),
													$p[3])."</textarea><br>
			";
		if ($from == "message") $menu.="<input type=\"hidden\" name=\"addline\" value=\"".(int)$_GET['line']."\">
						";
		$menu.="
				<input type=\"hidden\" name=\"from\" value=\"".$from."\">
				<input type=\"hidden\" name=\"line\" value=\"".$line."\">
				<input type=\"hidden\" name=\"file\" value=\"".$file."\">
				<input type=\"submit\" name=\"submit\" value=\"Сохранить\">        
				</form>
				</td></tr></table><br></centeR>
			";
	};
   
	$options = $GlobalTemplate->template("{MESSAGES}",$messages,"./theme/messages.tpl");
	
	$ar = array("{MENU}","{OPTIONS}");
	$br = array("",$menu.$options);
	echo $GlobalTemplate->template($ar,$br,"./theme/admincenteroptions.tpl");
