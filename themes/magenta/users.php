<?php
//Форма входа пользователей и администраторов
//{SITE} - адрес сайта без / на конце
//{THEMEPATH} - полный адрес до используемой темы без / на конце
//{REGLINK} - ...
//{RESTORELINK} - ...
$logincms[0]='
<h3>Вход на сайт</h3>
<div class="account">
    <form name="loginform" action="{SITE}/index.php?action=login" method="POST">
        <div class="row">Логин: </div>
	    <input class="login-input" type="text" name="login">
        <div class="row">Пароль: </div>
	    <input class="login-input" type="password" name="password">
        <div class="row"><input type="checkbox" name="save" value="true"> Запомнить</div>
	    <input class="button" type="submit" name="submit" value="Вход">
    </form>
	<div class="row"><a href="{RESTORELINK}">Забыли пароль?</a></div>
	<div class="row"><a href="{REGLINK}">Быстрая регистрация</a></div>
</div>
';

//Меню администратора на сайте
//{THEMEPATH} - полный адрес до используемой темы без / на конце
//{AVATAR} - полный путь до аватары
//{LOGIN} - имя администратора
//{SITE} - адрес сайта без / на конце
//{PM} - количество непрочитанных личных сообщений
//{PMLINK} - ...
//{PROFILELINK} - ...
$logincms[1]='
<h3>Аккаунт</h3>
<div class="account">
    <img src="{AVATAR}" alt="Avatar">
    <div class="row">Вы вошли как «{LOGIN}»</div>
    <div class="row"><a href="{PMLINK}">Личных сообщений ({PM})</a></div>
    <div class="row"><a href="{PROFILELINK}">Мой профиль</a></div>
    <div class="row"><a target="_blank" href="{SITE}/rpanel">Админ-центр</a></div>
    <div class="row"><a href="{SITE}/index.php?action=logout">Выйти</a></div>
</div>
<br>
';

//Меню редактора на сайте
//{THEMEPATH} - полный адрес до используемой темы без / на конце
//{AVATAR} - полный путь до аватары
//{LOGIN} - имя администратора
//{SITE} - адрес сайта без / на конце
//{PM} - количество непрочитанных личных сообщений
//{PMLINK} - ...
//{PROFILELINK} - ...
$logincms[14]='
<h3>Аккаунт</h3>
<div class="account">
    <img src="{AVATAR}" alt="Avatar">
    <div class="row">Вы вошли как «{LOGIN}»</div>
    <div class="row"><a href="{PMLINK}">Личных сообщений ({PM})</a></div>
    <div class="row"><a href="{PROFILELINK}">Мой профиль</a></div>
    <div class="row"><a target="_blank" href="{SITE}/rpanel">Управление</a></div>
    <div class="row"><a href="{SITE}/index.php?action=logout">Выйти</a></div>
</div>
<br>
';

//Меню модератора на сайте
//{THEMEPATH} - полный адрес до используемой темы без / на конце
//{AVATAR} - полный путь до аватары
//{LOGIN} - имя администратора
//{SITE} - адрес сайта без / на конце
//{PM} - количество непрочитанных личных сообщений
//{PMLINK} - ...
//{PROFILELINK} - ...
$logincms[15]='
<h3>Аккаунт</h3>
<div class="account">
    <img src="{AVATAR}" alt="Avatar">
    <div class="row">Вы вошли как «{LOGIN}»</div>
    <div class="row"><a href="{PMLINK}">Личных сообщений ({PM})</a></div>
    <div class="row"><a href="{PROFILELINK}">Мой профиль</a></div>
    <div class="row"><a target="_blank" href="{SITE}/rpanel">Управление</a></div>
    <div class="row"><a href="{SITE}/index.php?action=logout">Выйти</a></div>
</div>
<br>
';

//Меню пользователей на сайте
//{THEMEPATH} - полный адрес до используемой темы без / на конце
//{AVATAR} - полный путь до аватары
//{LOGIN} - имя пользователя
//{SITE} - адрес сайта без / на конце
//{PM} - количество непрочитанных личных сообщений
//{PMLINK} - ...
//{PROFILELINK} - ...
$logincms[2]='
<h3>Аккаунт</h3>
<div class="account">
    <div class="row"><img src="{AVATAR}" alt="Avatar"></div>
    <div class="row">Вы вошли как «{LOGIN}»</div>
    <div class="row"><a href="{PMLINK}">Личных сообщений ({PM})</a></div>
    <div class="row"><a href="{PROFILELINK}">Мой профиль</a></div>
    <div class="row"><a href="{SITE}/index.php?action=logout">Выйти</a></div>
</div>
<br>
';

//Форма регистрации
//{SITE} - адрес сайта без / на конце
//{LOGIN} - значение логина при возврате страницы
//{PASSWORD} - значение пароля при возврате страницы
//{SPASSWORD} - значение повтора пароля при возврате страницы
//{MAIL} - значение email при возврате страницы
//{SMAIL} - значение повтора email при возврате страницы
//{SECURITY} - изображение капчи
//{THEMEPATH} - полный адрес до используемой темы без / на конце
$logincms[3]='
<div id="content">
<h2>Быстрая регистрация</h2>
<p>
<div class="register">
    <form name="register" action="{REGSTEP2}" method="POST">
      <div class="row"><div class="label">Логин:</div><input class="reg-input" type="text" name="login" value="{LOGIN}"></div>
	  <div class="row"><div class="label">Пароль:</div><input class="reg-input" type="password" name="password" value="{PASSWORD}"></div>
	  <div class="row"><div class="label">Повторите пароль:</div><input class="reg-input" type="password" name="spassword" value="{SPASSWORD}"></div>
	  <div class="row"><div class="label">E-mail (не отображается на сайте):</div><input class="reg-input" type="text" name="mail" value="{MAIL}"></div>
	  <div class="row"><div class="label">Повторите e-mail:</div><input class="reg-input" type="text" name="smail" value="{SMAIL}"></div>
	  <div class="row"><div class="label">Введите код проверки (captcha):</div><img src="{SECURITY}" border=0 alt=""></div>
	  <div class="row"><div class="label"></div><input class="code-input" type="text" name="security"></div>
	  <input class="button reg-submit" type="submit" name="submit" value="Зарегистрироваться">
    </form>
</div>
</p>
<div class="clear"></div>
<br>
</div>
';

//Просмотр аккаунта
//{THEMEPATH} - полный адрес до используемой темы без / на конце
//{NAME} - имя пользователя
//{AVATAR}
//{STATUS} - роль пользователя
//{CM} - всего сообщений
//[if_used_pole(1-7,about)][/if_used_pole(1-7,about)] - код, находящийся между этими тегами будет использован только если пользователь заполнил поле (1-7,about)
//[if_user_entered][/if_user_entered] - код, заключённый между этими тегами будет использован только, если пользователь вошёл в свой аккаунт
//{POLECAPTION(1-7)} - названия полей
//{POLE(1-7)RESULT} - содержимое полей
//{ABOUTUSER} - поле "О себе"
//{PMNEW}
$logincms[4]='
<div id="content">
	<h2>Просмотр аккаунта</h2>
	<p>
    <div class="register">
        <div class="account">
		    <div class="row">Профиль пользователя «{NAME}»</div>
			{AVATAR}<br>
			[if_user_entered]<a href="{PMNEW}">Отправить личное сообщение</a>[/if_user_entered]
			<div class="row"><div class="label-name">Имя пользователя: </div><div class="label-info">{NAME}</div></div>
			<div class="row"><div class="label-name">Статус на сайте: </div><div class="label-info">{STATUS}</div></div>
			<div class="row"><div class="label-name">Сообщений: </div><div class="label-info">{CM}</div></div>
			<div class="row"><div class="label-name">Дата регистрации: </div><div class="label-info">{REGDATE}</div></div>
			[if_used_pole1]
			<div class="row"><div class="label-name">{POLECAPTION1}: </div><div class="label-info">{POLE1RESULT}</div></div>
			[/if_used_pole1]
			[if_used_pole2]
			<div class="row"><div class="label-name">{POLECAPTION2}: </div><div class="label-info">{POLE2RESULT}</div></div>
			[/if_used_pole2]
			[if_used_pole3]
			<div class="row"><div class="label-name">{POLECAPTION3}: </div><div class="label-info">{POLE3RESULT}</div></div>
			[/if_used_pole3]
			[if_used_pole4]
			<div class="row"><div class="label-name">{POLECAPTION4}: </div><div class="label-info">{POLE4RESULT}</div></div>
			[/if_used_pole4]
			[if_used_pole5]
			<div class="row"><div class="label-name">{POLECAPTION5}: </div><div class="label-info">{POLE5RESULT}</div></div>
			[/if_used_pole5]
			[if_used_pole6]
			<div class="row"><div class="label-name">{POLECAPTION6}: </div><div class="label-info">{POLE6RESULT}</div></div>
			[/if_used_pole6]
			[if_used_about]
			<div class="row"><div class="label-name">О себе: </div><div class="label-info">{ABOUTUSER}</div></div>
			[/if_used_about]
        </div>
    </div>
	</p>
	<div class="clear"></div>
	<br>
</div>
';
 
//Восстановление аккаунта
//{THEMEPATH} - полный адрес до используемой темы без / на конце
//{SITE} - адрес сайта без / на конце
$logincms[5]='
<div id="content">
	<h2>Восстановление аккаунта</h2>
	<p>
        <div class="account">
                <form class="restore" name="restore" action="{RESTORESTEP2}" method="POST">
                    <p>Введите адрес Вашей электронной почты</p>
                    <div class="row"><input class="restore-input" type="text" name="mail" placeholder="E-Mail..."></div>
					<div class="row"><input class="button" type="submit" name="submit" value="Отправить"></div>
					<div id="spacer"></div>
                    <p>Проверьте почтовый ящик, адрес которого Вы указали при регистрации аккаунта. Удачи! Увидимся позже.</p>
                </form>
        </div>
    </p>
	<div class="clear"></div>
	<br>
</div>';

//Редактирование профиля
//{THEMEPATH} - полный адрес до используемой темы без / на конце
//[if_can_avatars][/if_can_avatars] - код, заключённый между этими тегами будет использован только, если включены аватары
//в Основных настройках админ-центра
//[if_can_ps][/if_can_ps] - код, между этими тегами будет использоватся только, если включены подписи в Основных настройках админ-центра
//[if_can_pole(1-7)][/if_can_pole(1-7)] - если номер поля используется в дополнительных полях (админ-центр - Пользователи - Дополнителные
//поля), то код между этими тегами будет использован
//{SITE} - адрес сайта без / на конце
//{AVATAR} - вставляет тег с изображением аватары
//{NAME} - имя пользователя
//{STATUS} - роль
//{MAXSIZE} - максимальный размер аватары
//{WIDTH} - максимальная ширина аватары
//{HEIGHT} - максимальная высота аватары
//{POLECAPTION(1-7)} - описание поля
//{POLE(1-7)RESULT} - значение поля
//{ABOUTUSER} - поле "О себе"
//... дописать позже
$logincms[6]='
<script type="text/javascript">
function tag (TXT, startTag, endTag)
{
TXT.focus ();
if (document.selection) with (document.selection.createRange ())
   {
   var t = text; text = startTag + text + endTag;
   if (!t.length) moveEnd (\'character\', endTag.length * (-1)); select ();
   }
else if (TXT.selectionStart >= 0) with (TXT)
   {
   var sT = scrollTop, sL = scrollLeft, t = value,
   stS = selectionStart, leS = selectionEnd - stS,
   w = (startTag + t.substr (stS, leS) + endTag).length;
   value = t.substr (0, stS) + startTag + t.substr (stS, leS) + endTag + t.substr (stS + leS);
   if (leS) 
   {
     selectionStart = stS + w;
     selectionEnd = selectionStart;
   }
   else
   {
     selectionStart = stS + startTag.length;
     selectionEnd = selectionStart;
   };
   scrollTop = sT, scrollLeft = sL;
   }
else TXT.value += startTag + endTag;
};
</script>

<h2>Личный кабинет</h2>
<div id="account">
	<p>
        <h4>Основные сведения</h4>
		<br>
       [if_can_avatars]<img src="{AVATAR}" alt="">[/if_can_avatars]
        <div class="account">
            <div class="row"><div class="label-name">Имя пользователя: </div><div class="label-info">{NAME}</div></div>
	        <div class="row"><div class="label-name">Статус на сайте: </div><div class="label-info">{STATUS}</div></div>
	        <div class="row"><div class="label-name">Сообщений: </div><div class="label-info">{CM}</div></div>
		</div>
	    <h4>Аватар</h4>
	    [if_can_avatars]
		    <form id="loginform" name="uploadavatar" action="{STEPUPLOAD}" method="POST" enctype="multipart/form-data">
			    <div class="account">
				    <div class="row"><div class="label">Загрузить новый аватар 96x96px: </div><input type="file" size=30 name="avatarfile"></div>
					<div class="row">{RULES}</div>
					<input class="button" type="submit" name="submit" value="Сменить аватар">
				</div>
			</form>
		[/if_can_avatars]
		<br>
	    <h4>Изменение личных данных</h4>
	    <form name="editprofile" id="profileedit" action="{STEP2}" method="POST">
		    <div class="register">
				<div class="row"><div class="label">E-mail:</div><input class="reg-input" type="text" name="mail" value="{MAIL}"></div>
				[if_can_pole1]
				<div class="row"><div class="label">{POLECAPTION1}:</div><input class="reg-input" type="text" name="pole1" value="{POLE1RESULT}"></div>
				[/if_can_pole1]
				[if_can_pole2]
				<div class="row"><div class="label">{POLECAPTION2}:</div><input class="reg-input" type="text" name="pole1" value="{POLE2RESULT}"></div>
				[/if_can_pole2]
				[if_can_pole3]
				<div class="row"><div class="label">{POLECAPTION3}:</div><input class="reg-input" type="text" name="pole1" value="{POLE3RESULT}"></div>
				[/if_can_pole3]
				[if_can_pole4]
				<div class="row"><div class="label">{POLECAPTION4}:</div><input class="reg-input" type="text" name="pole1" value="{POLE4RESULT}"></div>
				[/if_can_pole4]
				[if_can_pole5]
				<div class="row"><div class="label">{POLECAPTION5}:</div><input class="reg-input" type="text" name="pole1" value="{POLE5RESULT}"></div>
				[/if_can_pole5]
				[if_can_pole6]
				<div class="row"><div class="label">{POLECAPTION6}:</div><input class="reg-input" type="text" name="pole1" value="{POLE6RESULT}"></div>
				[/if_can_pole6]
				[if_can_pole7]
				<div class="row"><div class="label">{POLECAPTION7}:</div><input class="reg-input" type="text" name="pole1" value="{POLE7RESULT}"></div>
				[/if_can_pole7]
	        </div>
			<br>
	    <h4>О себе:</h4>
		<div class="account">
	        <!--div class="account"-->
				<div class="row">(Не более 255 символов)</div>
				<div class="row"><textarea class="textarea" name="about">{ABOUTUSER}</textarea></div>
			<!--/div-->
		</div>
	        <br>
	    <h4>Подпись:</h4>
	        <div class="account">
				<center>
				[if_can_ps]
				    <div class="row">(Подпись, содержащая более {PS_MAX} символов будет урезана)</div>
					<div class="row">
				        <input class="buttons" type="button" value="ж" style="font-weight:bold" onClick="tag(document.getElementById(\'mess\'),\'[ж]\',\'[/ж]\');">
                        <input class="buttons" type="button" value="к" style="font-style:italic" onClick="tag(document.getElementById(\'mess\'),\'[к]\',\'[/к]\');">
                        <input class="buttons" type="button" value="ч" style="text-decoration:underline" onClick="tag(document.getElementById(\'mess\'),\'[ч]\',\'[/ч]\');">
                        <input class="buttons" type="button" value="п" style="text-decoration:line-through" onClick="tag(document.getElementById(\'mess\'),\'[п]\',\'[/п]\');">
                        <input class="buttons" type="button" value="Ссылка" onClick="tag(document.getElementById(\'mess\'),\'[url]\',\'[/url]\');">
					</div>
				    <div class="row"><textarea class="textarea" id="mess" name="ps">{PS}</textarea></div>
				[/if_can_ps]
				</center>
			</div>
			<br>
	    <h4>Смена пароля:</h4>
		    <div class="register">
	            <div class="row"><b>Не заполняйте следующие ниже поля, если не хотите менять пароль!</b></div>
			    <div class="row"><div class="label-name">Новый пароль:</div><input class="login-input" type="password" name="newpassword"></div>
			    <div class="row"><div class="label-name">Повторите новый пароль:</div><input class="login-input" type="password" name="newspassword"></div>
			    <div class="row"><div class="label-name">Старый пароль:</div><input class="login-input" type="password" name="oldpassword"></div>
			</div>
			<div class="account">
				<div class="row"><input class="button" type="submit" name="submit" value="Сохранить изменения"></div>
			</div>
		</form>
	</p>
</div>
<div class="clear"></div>
<br>

<script type="text/javascript">
document.getElementById("profileedit").setAttribute("autocomplete","off");
</script> 
';

//Имя пользователя в комментариях
//{SITE} - адрес сайта без / на конце
//{THEMEPATH} - полный адрес до выбранной темы оформления без / на конце
//{NAME} - имя пользователя
$logincms[7]='<a class="user-name" href="{PROFILELINK}" onClick="window.open(\'{PROFILELINK}\'); return false;">{NAME}</a>';

//Имя администратора в комментариях
//{SITE} - адрес сайта без / на конце
//{THEMEPATH} - полный адрес до выбранной темы оформления без / на конце
//{NAME} - имя администратора
$logincms[8]='<a class="user-name" href="{PROFILELINK}" onClick="window.open(\'{PROFILELINK}\'); return false;">{NAME}</a>';

//Главный стиль ЛС
//{MENU} - меню - СТРОКИ В МЕНЮ ПРЫГАЮТ! И это где-то в системе? (Wasilich)
//{LIST} - содержимое
$logincms[9]='
<div id="account">
    <h2>Личные сообщения</h2>
	<div id="wrapper">
	    <div class="row">{MENU}</div>
		<div class="row">{LIST}</div>
		<div class="clear"></div>
	</div>
	<br>
</div>
';

//Стиль списка входящих и отправленных сообщений (ЛС)
//{BYORTO} - заменяется на $lcms['pm_by'], если просматриваются входящие сообщения, и на $lcms['pm_to'] - если отправленные
//{LIST} - список сообщений
//{DELETEALLLINK} - ссылка на чистку всей папки (с входящими сообщениями или исходящими)

//Пришлось вставить теги таблицы "table" в начало и конец блока, т.к. сообщения привязаны к тегам "tr" и "td"
$logincms[10]='
<table border=0 cellpadding=1 cellspacing=0 width="100%">
<div class="account">
            <div class="row">
	            <div class="label-message">Дата</div>
		        <div class="label-message">Тема</div>
		        <div class="label-message right">{BYORTO}</div>
		        <div class="label-message">Действия</div>
            </div>
</div>
	{LIST}
</table>
<div class="account">
	<div class="row right">
	    <a href="#" onClick="{DELETEALLLINK}"><p>Очистить всю папку</p></a> 
	</div>
</div>
';

//Стиль надписи над сообщением из ЛС
//{THEME} - тема
$logincms[11]='
<div>Тема: {THEME}</div>
';

//Что генерировать после сообщения из ЛС
//{REPLYFORM} - форма для ответа на сообщение
$logincms[12]='
<div>Ответить:</div>
{REPLYFORM}
';

//Стиль оформления ссылок в меню ЛС
$logincms[13]='<a href="{LINK}">{CAPTION}</a>';




//Обязательный системный параметр. Вручную не вносить НИКАКИХ изменений!
$logincms[90] = "0.2";
?>
