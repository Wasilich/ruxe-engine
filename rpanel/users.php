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

	$echooptions 	= "";
	$menu 		= "";
	$mess 		= "";
	$users 		= file("../conf/users/users.dat");
	$start 		= '<h2>Пользователи и администраторы</h2>
				<font class="desc">В данном разделе Вы можете удалить, забанить, изменить профиль пользователей, установить статус (например, администратор или суперпользователь), обнулить счётчики сообщений, добавить новые поля профиля и страницы, доступные для просмотра только администраторам и суперпользователям</font><br><br>
			';
	$echooptions 	= "<center><table class=\"optionstable\" border=0 cellpadding=1 cellspacing=0>
				<tr class=\"titletable\"><td>ИМЯ ПОЛЬЗОВАТЕЛЯ</td><td width=110>СТАТУС (<a target=\"_blank\" title=\"Помощь\" href=\"https://github.com/maindefine/ruxe-engine/blob/master/README.md#user-statuses\">?</a>)</td><td width=85>СООБЩЕНИЙ</td><td width=150>E-MAIL</td><td width=100>IP</td><td width=270>ДЕЙСТВИЕ</td></tr>
			";
	if (isset($_GET["poles"]))
		$mess 	= "(Сохранено)";

	include("../conf/users/config.dat");
	
	if (isset($_GET['go'])) {
		$go 	= $_GET['go'];
		$user 	= $_GET['user'];
		if ($go == 'new') {
			$menu .= '<form name="newuser" action="saver.php?saverdo=newuser" method="POST">
					<center><table class="optionstable2" border=0 cellpadding=1 cellspacing=0>
						<tr class="titletable"><td colspan=2>СОЗДАНИЕ НОВОГО ПОЛЬЗОВАТЕЛЯ</td></tr>
						<tr><td>Логин:</td><td><input type="text" size=30 name="login"></td></tr>
						<tr><td>Пароль:</td><td><input type="password" size=30 name="password"></td></tr>
						<tr><td>Повторите пароль:</td><td><input type="password" size=30 name="spassword"></td></tr>
						<tr><td>Email:</td><td><input type="text" size=30 name="mail"></td></tr>
						<tr><td>Повторите email:</td><td><input type="text" size=30 name="smail"></td></tr>
						<tr class="sub"><td colspan=2><input type="submit" name="submit" value="Создать"></td></tr>
					</table></center>
					</form><br>';
		}
		
		if ($go=="edit") {
			for ($i=0; $i<count($users); $i++) {
				$p = explode("|",$users[$i]);
				if ($user == $p[0])
					$pos = $i;
			};
			$p 	= explode("|",$users[$pos]);
			$menu 	.= '<form name="edituser" action="saver.php?saverdo=edituser" method="POST">
					<center><table class="optionstable" border=0 cellpadding=1 cellspacing=0>
					<tr class="titletable"><td colspan=2>РЕДАКТИРОВАНИЕ ПРОФИЛЯ</td></tr>
					<tr><td>Логин:</td><td width=345><input type="text" size=52 name="login" value="'.$p[18].'"></td></tr>
					<tr><td><input type="hidden" name="lastlogin" value="'.$p[18].'">Пароль <font class="desc">(оставьте пустым, если не хотите менять)</font>:</td><td><input type="password" name="password" size=52></td></tr>
					<tr><td>E-mail:</td><td><input type="text" name="mail" size=52 value="'.$p[2].'"></td></tr>
					<tr><td>О себе:</td><td><textarea name="about" cols=40 rows=3>'.str_replace("<br>","\n",$p[3]).'</textarea></td></tr>
					<tr><td>Подпись:</td><td><textarea name="ps" cols=40 rows=3>'.str_replace("<br>","\n",$p[17]).'</textarea></td></tr>
					<tr><td>Звание (статус) <a title="Помощь" href="https://github.com/maindefine/ruxe-engine/blob/master/README.md#user-statuses" target="_blank">?</a>:</td><td>
				';
			if ($pos!=0) {
				$menu .='<select name="status" id="statuser" onChange="diuc()">';
        
				switch ($p[4]) {
					case "admin":
						$menu.= '<option value="admin" selected>'.$lcms['user_status_admin'].'
							<option value="superuser">'.$lcms['user_status_superuser'].'
							<option value="user">'.$lcms['user_status_user'].'
							<option value="baned">'.$lcms['user_status_baned'].'
							<option value="active">'.$lcms['user_status_noactive'].'
							<option value="editor">'.$lcms['user_status_editor'].'
							<option value="moderator">'.$lcms['user_status_moderator'].'
						';
						break;
					case "superuser":
						$menu.= '<option value="admin">'.$lcms['user_status_admin'].'
							<option value="superuser" selected>'.$lcms['user_status_superuser'].'
							<option value="user">'.$lcms['user_status_user'].'
							<option value="baned">'.$lcms['user_status_baned'].'
							<option value="active">'.$lcms['user_status_noactive'].'
							<option value="editor">'.$lcms['user_status_editor'].'
							<option value="moderator">'.$lcms['user_status_moderator'].'
						';
						break;
					case "user":
						$menu.= '<option value="admin">'.$lcms['user_status_admin'].'
							<option value="superuser">'.$lcms['user_status_superuser'].'
							<option value="user" selected>'.$lcms['user_status_user'].'
							<option value="baned">'.$lcms['user_status_baned'].'
							<option value="active">'.$lcms['user_status_noactive'].'
							<option value="editor">'.$lcms['user_status_editor'].'
							<option value="moderator">'.$lcms['user_status_moderator'].'
						';
						break;
					case "baned":
						$menu.= '<option value="admin">'.$lcms['user_status_admin'].'
							<option value="superuser">'.$lcms['user_status_superuser'].'
							<option value="user">'.$lcms['user_status_user'].'
							<option value="baned" selected>'.$lcms['user_status_baned'].'
							<option value="active">'.$lcms['user_status_noactive'].'
							<option value="editor">'.$lcms['user_status_editor'].'
							<option value="moderator">'.$lcms['user_status_moderator'].'
						';
						break;
					case "active":
						$menu.= '<option value="admin">'.$lcms['user_status_admin'].'
							<option value="superuser">'.$lcms['user_status_superuser'].'
							<option value="user">'.$lcms['user_status_user'].'
							<option value="baned">'.$lcms['user_status_baned'].'
							<option value="active" selected>'.$lcms['user_status_noactive'].'
							<option value="editor">'.$lcms['user_status_editor'].'
							<option value="moderator">'.$lcms['user_status_moderator'].'
						';
						break;
					case "editor":
						$menu.= '<option value="admin">'.$lcms['user_status_admin'].'
							<option value="superuser">'.$lcms['user_status_superuser'].'
							<option value="user">'.$lcms['user_status_user'].'
							<option value="baned">'.$lcms['user_status_baned'].'
							<option value="active">'.$lcms['user_status_noactive'].'
							<option value="editor" selected>'.$lcms['user_status_editor'].'
							<option value="moderator">'.$lcms['user_status_moderator'].'
						';
						break;
					case "moderator":
						$menu.= '<option value="admin">'.$lcms['user_status_admin'].'
							<option value="superuser">'.$lcms['user_status_superuser'].'
							<option value="user">'.$lcms['user_status_user'].'
							<option value="baned">'.$lcms['user_status_baned'].'
							<option value="active">'.$lcms['user_status_noactive'].'
							<option value="editor">'.$lcms['user_status_editor'].'
							<option value="moderator" selected>'.$lcms['user_status_moderator'].'
						';
						break;
				};
        
				$display= 'none';
				if ($p[4] == 'baned') 
					$display = 'inline';
				if (($p[4] == 'editor') or ($p[4]=='moderator')) 
					$display_editor = 'inline';
				else
					$display_editor = 'none';
				if ($p[4]=='moderator')
					$display_moderator	=	'inline';
				else
					$display_moderator	=	'none';
        
				$menu	.= '</select> 
						<div style="display:'.$display.'; margin-top:2px; margin-bottom: 2px;" id="whyban"><br>Причина:<br><input name="whybaned" type="text" id="wb1" style="margin-top:3px;" size=52 value="'.$p[19].'"></div>
					';
				//Редактор
				$menu.='
					<div style="display:'.$display_editor.'; margin-top:2px; margin-bottom: 2px;" id="display_editor">
						<br>Новостные разделы: <br>
        		';
        $bfg		=	file($cms_root.'/conf/bfg.dat');
        $rules		=	$GlobalUsers->getrules($p[18]);
        $bfg_types	=	explode(',',$rules['bfg_types']);
        foreach ($bfg as $bf)
        {
        	$b 		=	explode('|',$bf);
        	$checked 	= 	'';
        	foreach ($bfg_types as $z)
        	{
        		if ($z==$b[0])
        		{
        			$checked = ' checked';
        			break;
        		};
        	};
        	$menu .= '<input type="checkbox" name="editor_'.$b[0].'" value="'.$b[0].'"'.$checked.'> '.$b[1].'<br>';
        };
        if ($rules['bfg_public']==true)
        	$checked = ' checked';
        else
        	$checked = '';
        if ($rules['bfg_delete']==true)
        	$bfg_delete	=	' checked';
        else
        	$bfg_delete	=	'';
        $menu.='
        	<br><input type="checkbox" name="bfg_public" value="yes"'.$checked.'> Разрешить опубликовывать новости<br>
		<input type="checkbox" name="bfg_delete" value="yes"'.$bfg_delete.'> Разрешить удалять новости
        	</div>
        ';
        
        //
        //Модератор
        if ($rules['comments_edit']==true)
        	$comments_edit	=	' checked';
        else
        	$comments_edit	=	'';
        if ($rules['plugins_use']==true)
        	$plugins_use	=	' checked';
        else
        	$plugins_use	=	'';
        if ($rules['banip']==true)
        	$banip		=	' checked';
        else
        	$banip		=	'';
	//<br><input type="checkbox" name="banip" value="yes"'.$banip.'> Блокировка посетителей по IP (<font color="red"><b>В разработке</b></font>)
        $menu.='<div style="display:'.$display_moderator.'; margin-top:2px; margin-bottom:2px;" id="display_moderator">
        	<br><input type="checkbox" name="comments_edit" value="yes"'.$comments_edit.'> Управление комментариями
        	<br><input type="checkbox" name="plugins_use" value="yes"'.$plugins_use.'> Использование дополнений
        	<input type="hidden" name="banip" value="">
        </div>';
        //
        
        }
        else
        {
            $menu.='<b>Главный администратор</b>';
        }
	if (
		($p[20]!='Не известно')
		and
		($p[20]!='Начало эпохи Unix')
		)
		$p[20]	=	$Filtr->fulldate(
					str_replace('2011','11',$p[20])
					);
        $menu.='
        </td></tr>
	<tr><td>IP при регистрации:</td><td>'.$Filtr->ipclick($p[12]).'</td></tr>
        <tr><td>Дата регистрации:</td><td>'.str_replace('Не известно','Неизвестно',$p[20]).'</td></tr>
        ';
        for ($i = 1; $i<=7; $i++)
        {
            if ($pole[$i]==true)
            {
                $menu.='<tr><td>'.$polecaption[$i].':</td><td><input type="text" name="pole'.$i.'" value="'.$p[5+$i-1].'" size=52></td></tr>
                ';
            }
            else
            {
                $menu.='<input type="hidden" name="pole'.$i.'" value="'.$p[5+$i-1].'">
                ';
            };
        };         
	$ava	=	$cms_site.'/avatars/'.$Filtr->clear($p[16]);
	if ($p[16]=='noavatar.png')
	{
		if ($cms_gravatars==1)
			$ava	=	$GlobalImaging -> get_gravatar($p[2],$cms_upload_width,$cms_gravatars_im,'g',false);
	};	
        $menu.='<tr><td>Сообщений:</td><td><input type="text" size=52 name="messages" value="'.$p[14].'"></td></tr>
        <tr><td>Аватар:</td><td>
        <input type="hidden" name="avatar" id="av3" value="'.$p[16].'">
        <input type="hidden" name="oldavatar" value="'.$p[16].'">
        <img id="av" alt="" src="'.$ava.'" border=0> <input id="av2" type="button" onClick="document.getElementById(\'av\').style.display=\'none\'; document.getElementById(\'av2\').style.display=\'none\'; document.getElementById(\'av3\').value=\'noavatar.png\';" value="Удалить"></td></tr>
        <tr class="sub"><td colspan=2><input type="submit" name="submit" value="Сохранить"></td></tr>
        </table>
        </center>
        </form><br>';
     };
  };
	for ($i=0; $i<count($users);$i++) {
		$p 	= explode("|",$users[$i]);
		$name 	= $p[18];
		switch ($p[4]) {
			case "admin":
				$status	= $lcms['user_status_admin'];
				$name 	= "<font color=\"red\"><b>".$name."</b></font>";
				break;
			case "moderator":
				$status = $lcms['user_status_moderator'];
				$name 	= "<font color=\"green\"><b>".$name."</b></font>";
				break;
			case "editor":
				$status = $lcms['user_status_editor'];
				$name 	= "<font color=\"green\"><b>".$name."</b></font>";
				break;
			case "superuser":
				$status = $lcms['user_status_superuser'];
				$name 	= "<font color=\"green\"><b>".$name."</b></font>";
				break;
			case "user":
				$status = $lcms['user_status_user'];
				break;
			case "baned":
				$status = $lcms['user_status_baned'];
				$name = "<font color=\"grey\"><b>".$name."</b></font>";
				break;
			case "active":
				$status = $lcms['user_status_noactive'];
				$name = "<font color=\"grey\"><b>".$name."</b></font>";
				break;
		}
		if (
			($p[20]!='Не известно')
			and
			($p[20]!='Начало эпохи Unix')
		)
			$p[20]	=	$Filtr->fulldate(str_replace('2011','11',$p[20]));
		$echooptions.="<tr><td>";
		$echooptions	.= "<a href=\"".$Navigation->furl('viewprofile',$p[18])."\" onClick=\"window.open('".$Navigation->furl('viewprofile',$p[18])."'); return false;\">".$name."</a><font class=\"desc\"><br>Зарегистрирован: ".str_replace('Не известно','Неизвестно',$p[20])."</font></td><td>";
		if ($i==count($users)-1) {
			$echooptions.='
					<div id="newuser" style="position: absolute; display: none;">
					<form name="newuser" action="saver.php?saverdo=newuser" method="POST">
					<table class="optionstable2" border=0 cellpadding=1 cellspacing=0>
						<tr class="titleblue"><td colspan=2>СОЗДАНИЕ НОВОГО ПОЛЬЗОВАТЕЛЯ</td></tr>
						<tr class="bluetd"><td>Логин:</td><td><input type="text" size=30 name="login"></td></tr>
						<tr class="bluetd"><td>Пароль:</td><td><input type="password" size=30 name="password"></td></tr>
						<tr class="bluetd"><td>Повторите пароль:</td><td><input type="password" size=30 name="spassword"></td></tr>
						<tr class="bluetd"><td>Email:</td><td><input type="text" size=30 name="mail"></td></tr>
						<tr class="bluetd"><td>Повторите email:</td><td><input type="text" size=30 name="smail"></td></tr>
						<tr class="bluetd"><td colspan=2><input type="submit" name="submit" value="Создать"></td></tr>
					</table>
					</form>
					</div>';
		}
		$echooptions	.= $status."</td><td>".$p[14]."</td><td>".$p[2]."</td><td>".$Filtr->ipclick($p[12])."</td>
					<td>
					<a href=\"?action=users&amp;go=edit&amp;user=".$p[0]."&amp;rand=".rand(0,99999)."\">Изменить</a>";
		if ($i!=0) {
			if ($p[4]=="baned")
				$echooptions.= ' <a href="saver.php?saverdo=banuser&amp;user='.$p[0].'&amp;donotban=true">Разблокировать</a>';
			else
				$echooptions.= ' <a href="saver.php?saverdo=banuser&amp;user='.$p[0].'">Заблокировать</a>';
			$echooptions.=" <a href=\"#\" onClick=\"if (checkhead()) location.href='saver.php?saverdo=deluser&amp;user=".$i."';\">Удалить</a>";
		};
		$echooptions.="</td></tr>";
	}; 

  $echooptions .='
  <tr class="sub"><td colspan=6>
	<input type="button" onClick="document.getElementById(\'newuser\').style.display=\'inline\';" value="Создать нового пользователя">
	</td></tr>
  </table><br>
  <form name="poles" action="saver.php?saverdo=savepoles" method="POST">
   <table class="optionstable" border=0 cellpadding=1 cellspacing=0>
    <tr class="titletable"><td width="50%">ДОПОЛНИТЕЛЬНЫЕ ПОЛЯ В ПРОФИЛЕ</td><td width="50%">ОГРАНИЧЕННЫЙ ДОСТУП</td></tr>
    <tr><td valign="top" align="center"><div align="left"><input type="button" onClick="addpole();" value="Добавить поле"></div><br>
    ';
    for ($i=1; $i<=7; $i++)
    {
      $echooptions.='<input style="display: inline" type="text" id="pole'.$i.'" name="pole'.$i.'" value="'.$polecaption[$i].'" size=50>
      <input type="button" style="display: inline" onClick="delpole(\'pole'.$i.'\');" id="pole'.$i.'b" value="Удалить"><div style="display:block;" id="pole'.$i.'c"><br></div>
';
    };
  $pagesconfig = file("../conf/pages/config");
  $echooptions .='
   </td><td valign="top" align="center">
    <div align="left">Адреса страниц сайта, просмотр которых разрешён только администраторам, модераторам, редакторам и суперпользователям
    <br>
    <select style="margin-top:10px;" id="newpage">
    ';
    $c = 0;
    foreach ($pagesconfig as $pageline)
    {
        $p = explode("|",$pageline);
	if ($p[0]=='index') 
	{
		$p[0]='index';
		$shw	=	'index.php';
	}
	else
		$shw	=	$p[0];
        ($c==0) ? $echooptions .= '<option value="/'.$p[0].'" selected>'.$shw : $echooptions .='<option value="/'.$p[0].'">'.$shw;
        $c++;
    };
    $echooptions.='
    </select> <input type="button" onClick="addpage();" value="Добавить страницу"></div><br>
   
   ';
   $hidepages = file("../conf/users/hidepages.dat");
   $pagecaption = explode("|",$hidepages[0]);
    for ($i=0; $i<=9; $i++)
    {
      
      $echooptions.='<input style="display: inline" readonly type="text" id="page'.$i.'" name="page'.$i.'" value="'.$pagecaption[$i].'" size=50>
      <input type="button" style="display: inline" onClick="delpage(\'page'.$i.'\');" id="page'.$i.'b" value="Удалить"><div style="display:block;" id="page'.$i.'c"><br></div>
      ';
      
    };
   $echooptions .='</td></tr>
   <tr class="sub"><td colspan=2><input type="submit" name="submit" value="Сохранить все изменения"> '.$mess.'</td></tr>  
   </table>
  </form>
  </center>
  ';
  $ar = array("{MENU}","{OPTIONS}");
  $br = array("",$start.$menu.$echooptions);
  echo $GlobalTemplate->template($ar,$br,"./theme/admincenteroptions.tpl");

