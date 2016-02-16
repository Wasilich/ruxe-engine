<?php
	$bots1	=	file($cms_root.'/conf/bots');
	$bots	=	unserialize($bots1[0]);
	$print	=	'';
	$p	=	true;
	
	if (isset($_GET['do']))
	{
		switch ($_GET['do'])
		{
			case	'add':
				$print	.=	'
				<form name="addbot" method="POST" action="index.php?action=plugins&amp;choose=robots&amp;rand='.rand(1,999).
					'&amp;do=adding">
				<center>
					<table border=0 class="optionstable" cellpadding=1 cellspacing=0>
						<tr class="titletable"><td>ДОБАВИТЬ ЧАСТЬ USER AGENT\'А РОБОТА</td></tr>
						<tr><td align="center"><input type="text" name="bot" size=45></td></tr>
						<tr class="sub"><td><input type="submit" value="Добавить"></td></tr>
					</table>
				</center>
				</form><br>';
				$p	=	false;
				break;
			case	'edit':
				$p	=	false;
				$print	.=	'
				<form name="addbot" method="POST" action="index.php?action=plugins&amp;choose=robots&amp;rand='.rand(1,999).
					'&amp;do=editing">
				<center>
					<table border=0 class="optionstable" cellpadding=1 cellspacing=0>
						<tr class="titletable"><td>ИЗМЕНИТЬ ЧАСТЬ USER AGENT\'А РОБОТА</td></tr>
						<tr><td align="center">
						<input type="hidden" name="line" value="'.$_GET['line'].'">
						<input value="'.$bots[$_GET['line']].'" type="text" name="bot" size=45></td></tr>
						<tr class="sub"><td><input type="submit" value="Изменить"></td></tr>
					</table>
				</center>
				</form><br>';
				break;
			case	'editing':
				if (isset($_POST['line']))
				{
					$bots[$_POST['line']]	=	$Filtr->clear($_POST['bot']);
					$new	=	fopen($cms_root.'/conf/bots','w');
					fwrite($new,serialize($bots));
					fclose($new);
				};
				break;
			case	'delete':
				$line	=	$_GET['line'];
				unset($bots[$line]);
				$new	=	fopen($cms_root.'/conf/bots','w');
				fwrite($new,serialize($bots));
				fclose($new);
				break;
			case	'adding':
				if (isset($_POST['bot']))
				{
					$bot	=	$Filtr->clear($_POST['bot']);
					$bots[]	=	$bot;
					$new	=	fopen($cms_root.'/conf/bots','w');
					fwrite($new,serialize($bots));
					fclose($new);
				};
				break;
		};
	}
	if ($p)
		$print	.=	'
		<input type="button" value="Добавить" onClick="location.href=\'?action=plugins&amp;choose=robots&amp;do=add\';"><br><br>';
	
	$print	.=	'
	<center>
	
	<table border=0 cellpadding=1 cellspacing=0 class="optionstable">
				<tr class="titletable"><td>ЧАСТЬ USER AGENT\'А</td><td>ДЕЙСТВИЯ</td></tr>
				';
	foreach ($bots as $i => $bot)
	{
		$print	.=	'<tr><td>'.$bot.'</td><td>
		<input type="button" value="Изменить" onClick="location.href=\'?action=plugins&amp;choose=robots&amp;rand='.rand(1,999).'&amp;do=edit&amp;line='.$i.'\';">
		<input type="button" value="Удалить" onClick="if (checkhead()) {location.href=\'?action=plugins&amp;choose=robots&amp;rand='.rand(1,999).'&amp;do=delete&amp;line='.$i.'\';}">
		</td></tr>
		';
	};
	$print	.=	'
	</table></center>';
