<?php
//Форма входа пользователей и администраторов
//{SITE} - адрес сайта без / на конце
//{THEMEPATH} - полный адрес до используемой темы без / на конце
//{REGLINK} - ...
//{RESTORELINK} - ...
$logincms[0]='
    <form class="loginform" name="loginform" action="{SITE}/index.php?action=login" method="POST">
        <div class="form-header">
		    <span>Вход на сайт</span>
        </div>
		<div class="form-content">
		    <input class="input" type="text" name="login" placeholder="Логин ">
			<input class="input" type="password" name="password" placeholder="Пароль ">
		    <div class="row"><input type="checkbox" name="save" value="true"> Запомнить</div>
			<button type="submit" class="btn-default" name="submit">Вход</button>
		    <div class="row"><a href="{RESTORELINK}">Забыли пароль?</a></div>
	        <div class="row"><a href="{REGLINK}">Быстрая регистрация</a></div>
		</div>
    </form>
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
<div class="account text-center">
    <img src="{AVATAR}" alt="Avatar">
    <div class="row">Вы вошли как &laquo;{LOGIN}&raquo;</div>
    <div class="row"><a href="{PMLINK}">Личных сообщений ({PM})</a></div>
    <div class="row"><a href="{PROFILELINK}">Мой профиль</a></div>
    <div class="row"><a target="_blank" href="{SITE}/rpanel">Админ-центр</a></div>
    <div class="row"><a href="{SITE}/index.php?action=logout">Выйти</a></div>
</div>
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
<div class="account text-center">
    <img src="{AVATAR}" alt="Avatar">
    <div class="row">Вы вошли как &laquo;{LOGIN}&raquo;</div>
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
<div class="account text-center">
    <img src="{AVATAR}" alt="Avatar">
    <div class="row">Вы вошли как &laquo;{LOGIN}&raquo;</div>
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
<div class="account text-center">
    <img src="{AVATAR}" alt="Avatar">
    <div class="row">Вы вошли как &laquo;{LOGIN}&raquo;</div>
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
<div class="group-60-offset-20">
    <h2>Быстрая регистрация</h2>
    <hr>
    <br>
    <div class="register block-100">
        <form name="register" action="{REGSTEP2}" method="POST">
        <div class=" block-100">
		    <div class="label-name">Логин</div>
			<input class="form-control" type="text" name="login" value="{LOGIN}">
		</div>
	    <div class="row block-100">
		    <div class="label-name">Пароль</div>
		    <input class="form-control" type="password" name="password" value="{PASSWORD}">
		</div>
	    <div class="row block-100">
		    <div class="label-name">Повторите пароль</div>
		    <input class="form-control" type="password" name="spassword" value="{SPASSWORD}">
		</div>
	    <div class="row block-100">
		    <div class="label-name"><a href="http://test/confidence.html">E-mail (не отображается на сайте)*</a></div>
		    <input class="form-control" type="text" name="mail" value="{MAIL}">
		</div>
	    <div class="row block-100">
		    <div class="label-name">Повторите e-mail</div>
		    <input class="form-control" type="text" name="smail" value="{SMAIL}">
		</div>
	    <div class="row block-100">
		    <img class="security" src="{SECURITY}">
		</div>
	    <div class="row block-100">
		    <input class="form-control" type="text" name="security" placeholder="Введите код проверки (captcha)">
		</div>
	    <br>
	    <div class="row block-100">
			<input class="btn tf-btn btn-default" type="submit" name="submit" value="Зарегистрироваться">
	    </div>
	    <br>
        </form>
    </div>
</div>
<div class="clearfix"></div>
<br>
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
<div class="group-60-offset-20">
	<h2>Просмотр аккаунта</h2>
    <hr>
	<br>
        <div class="account text-center">
		    <h5>Профиль пользователя «{NAME}»</h5>
			<div class="center">{AVATAR}</div>
			<br>
			[if_user_entered]<a href="{PMNEW}">Отправить личное сообщение</a>[/if_user_entered]
			<br>&nbsp;<br>
			<div class="block-100"><div class="label-name">Имя пользователя: </div><div class="label-info"> {NAME}</div></div>
			<div class="block-100"><div class="label-name">Статус на сайте: </div><div class="label-info"> {STATUS}</div></div>
			<div class="block-100"><div class="label-name">Сообщений: </div><div class="label-info"> {CM}</div></div>
			<div class="block-100"><div class="label-name">Дата регистрации: </div><div class="label-info"> {REGDATE}</div></div>
			[if_used_pole1]
			<div class="block-100"><div class="label-name">{POLECAPTION1}: </div><div class="label-info"> {POLE1RESULT}</div></div>
			[/if_used_pole1]
			[if_used_pole2]
			<div class="block-100"><div class="label-name">{POLECAPTION2}: </div><div class="label-info"> {POLE2RESULT}</div></div>
			[/if_used_pole2]
			[if_used_pole3]
			<div class="block-100"><div class="label-name">{POLECAPTION3}: </div><div class="label-info"> {POLE3RESULT}</div></div>
			[/if_used_pole3]
			[if_used_pole4]
			<div class="block-100"><div class="label-name">{POLECAPTION4}: </div><div class="label-info"> {POLE4RESULT}</div></div>
			[/if_used_pole4]
			[if_used_pole5]
			<div class="block-100"><div class="label-name">{POLECAPTION5}: </div><div class="label-info"> {POLE5RESULT}</div></div>
			[/if_used_pole5]
			[if_used_pole6]
			<div class="block-100"><div class="label-name">{POLECAPTION6}: </div><div class="label-info"> {POLE6RESULT}</div></div>
			[/if_used_pole6]
			[if_used_about]
			<div class="block-100"><div class="label-name">О себе: </div><div class="label-info">{ABOUTUSER}</div></div>
			[/if_used_about]
        </div>
</div>
<div class="clearfix"></div>
<br>
';
 
//Восстановление аккаунта
//{THEMEPATH} - полный адрес до используемой темы без / на конце
//{SITE} - адрес сайта без / на конце
$logincms[5]='
<div class="group-60-offset-20">
	<h2>Восстановление аккаунта</h2>
	<hr>
	<br>
    <form class="restore" name="restore" action="{RESTORESTEP2}" method="POST">
        <p>Введите адрес Вашей электронной почты, который вы указали при регистрации</p>
		<div class="clearfix"></div>
		<br>
        <div class="block-100"><input class="form-control" type="text" name="mail" placeholder="E-Mail..."></div>
		<br>
		<div class="block-100">
			<input class="btn tf-btn btn-default" type="submit" name="submit" value="Отправить">
		</div>
			<br>&nbsp;<br>
            <p>Проверьте почтовый ящик, адрес которого Вы указали. Удачи! Увидимся позже.</p>
    </form>
</div>
<div class="clearfix"></div>
<br>
';

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
<div class="group-60-offset-20">
    <h2>Личный кабинет</h2>
    <hr>
    <br>
        <div class="account">
		<h4>Основные сведения</h4>
		<hr>
		<br>
            <div class="block-100"><div class="label-name">Имя пользователя: </div><div class="label-info">{NAME}</div></div>
	        <div class="block-100"><div class="label-name">Статус на сайте: </div><div class="label-info">{STATUS}</div></div>
	        <div class="block-100"><div class="label-name">Сообщений: </div><div class="label-info">{CM}</div></div>
		</div>
		    <br>&nbsp;<br>
		<h4>Аватар</h4>
		<hr>
		<br>
			<div class="center">
			    [if_can_avatars]<img class="center" src="{AVATAR}" alt="avatar">[/if_can_avatars]
			</div>
	    [if_can_avatars]
		    <form class="block-100" name="uploadavatar" action="{STEPUPLOAD}" method="POST" enctype="multipart/form-data">
				    <div class="block-100"><div class="label-name">Загрузить новый аватар 96x96px: </div><input type="file" size=30 name="avatarfile"></div>
					<div class="block-100"><span class="em">{RULES}</span></div>
					<br>
					<button type="submit" class="btn tf-btn btn-default">Сменить аватар</button>
			</form>
		[/if_can_avatars]
		<br>&nbsp;<br>
	    <h4>Изменение личных данных</h4>
		<hr>
		<br>
	    <form name="editprofile" id="profileedit" class="container" action="{STEP2}" method="POST">
			<div class="block-100">
				<div class="label-name">E-mail:</div>
				<input class="form-control" type="text" name="mail" value="{MAIL}">
			</div>
				[if_can_pole1]
			<div class="block-100">
				<div class="label-name">{POLECAPTION1}:</div>
				<input class="form-control" type="text" name="pole1" value="{POLE1RESULT}">
			</div>
				[/if_can_pole1]
				[if_can_pole2]
			<div class="block-100">
				<div class="label-name">{POLECAPTION2}:</div>
				<input class="form-control" type="text" name="pole2" value="{POLE2RESULT}">
			</div>
				[/if_can_pole2]
				[if_can_pole3]
			<div class="block-100">
				<div class="label-name">{POLECAPTION3}:</div>
				<input class="form-control" type="text" name="pole3" value="{POLE3RESULT}">
			</div>
				[/if_can_pole3]
				[if_can_pole4]
			<div class="block-100">
				<div class="label-name">{POLECAPTION4}:</div>
				<input class="form-control" type="text" name="pole4" value="{POLE4RESULT}">
			</div>
				[/if_can_pole4]
				[if_can_pole5]
			<div class="block-100">
				<div class="label-name">{POLECAPTION5}:</div>
				<input class="form-control" type="text" name="pole5" value="{POLE5RESULT}">
			</div>
				[/if_can_pole5]
				[if_can_pole6]
			<div class="block-100">
				<div class="label-name">{POLECAPTION6}:</div>
				<input class="form-control" type="text" name="pole6" value="{POLE6RESULT}">
			</div>
				[/if_can_pole6]
				[if_can_pole7]
			<div class="block-100">
				<div class="label-name">{POLECAPTION7}:</div>
				<input class="form-control" type="text" name="pole7" value="{POLE7RESULT}">
			</div>
				[/if_can_pole7]
			<br>&nbsp;<br>
	    <h4>О себе:</h4>
		<div class="account">
			<div class="block-100">(Не более 255 символов)</div>
			<div class="block-100">
				<textarea class="form-control block-100" name="about">{ABOUTUSER}</textarea>
			</div>
		</div>
	        <br>&nbsp;<br>
	    <h4>Подпись:</h4>
	        <div class="account">
				[if_can_ps]
				    <span class="block-100">(Подпись, содержащая более {PS_MAX} символов будет урезана)</span>
					<div class="block-100">
						<ul class="inline text-center">
						    <li type="button" title="Жирный" class="btn fa fa-bold" onClick="tag(document.getElementById(\'mess\'),\'[ж]\',\'[/ж]\');"></li>
							<li type="button" title="Наклонный" class="btn fa fa-italic" onClick="tag(document.getElementById(\'mess\'),\'[к]\',\'[/к]\');"></li>
						    <li type="button" title="Подчёркнутый" class="btn fa fa-underline" onClick="tag(document.getElementById(\'mess\'),\'[ч]\',\'[/ч]\');"></li>
							<li type="button" title="Зачёркнутый" class="btn fa fa-strikethrough" onClick="tag(document.getElementById(\'mess\'),\'[п]\',\'[/п]\');"></li>
							<li type="button" title="Ссылка" class="btn fa fa-link" onClick="tag(document.getElementById(\'mess\'),\'[url]\',\'[/url]\');"><li>
						</ul>
					</div>
				    <div class="block-100">
					    <textarea class="form-control block-100" id="mess" name="ps">{PS}</textarea>
					</div>
				[/if_can_ps]
			</div>
			<br>&nbsp;<br>
	    <h4>Смена пароля:</h4>
		    <div class="register">
	            <span class="block-100 color-orange">Не заполняйте следующие ниже поля, если не хотите менять пароль!</span>
				<br>&nbsp;<br>
			    <div class="block-100"><div class="label-name">Новый пароль:</div><input class="label-info block-100" type="password" name="newpassword"></div>
			    <div class="block-100"><div class="label-name">Повторите новый пароль:</div><input class="label-info block-100" type="password" name="newspassword"></div>
			    <div class="block-100"><div class="label-name">Старый пароль:</div><input class="label-info block-100" type="password" name="oldpassword"></div>
			</div>
			<br>&nbsp;<br>
			<div class="account">
				<div class="block-100">
					<input type="submit" class="btn tf-btn btn-default" value="Сохранить изменения">
				</div>
			</div>
		</form>
</div>
<div class="clearfix"></div>
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
//{MENU} - меню
//{LIST} - содержимое
$logincms[9]='
<div class="block-90-offset-05">
    <h2>Личные сообщения</h2>
	    <br>
	    <div class="block-100">{MENU}</div>
		<div class="block-100">{LIST}</div>
		<div class="clearfix"></div>
	    <br>
</div>
';

//Стиль списка входящих и отправленных сообщений (ЛС)
//{BYORTO} - заменяется на $lcms['pm_by'], если просматриваются входящие сообщения, и на $lcms['pm_to'] - если отправленные
//{LIST} - список сообщений
//{DELETEALLLINK} - ссылка на чистку всей папки (с входящими сообщениями или исходящими)

//Пришлось вставить теги таблицы "table" в начало и конец блока, т.к. сообщения привязаны к тегам "tr" и "td"
$logincms[10]='
<table border=0 cellpadding=1 cellspacing=0 width="100%" margin-left="0">
    <div class="account">
        <div class="block-100 em-air">
	            <div class="label-message">Дата</div>
		        <div class="label-message">Тема</div>
		        <div class="label-message">{BYORTO}</div>
		        <div class="label-message">Действия</div>
        </div>
    </div>
    <div class="account">
        <div class="block-100 em-air">
	        {LIST}
        </div>
    </div>
</table>
<div class="clearfix"></div>
	<br>
	<div class="block-100">
		<button class="btn tf-btn btn-default" onClick="{DELETEALLLINK}">Очистить всю папку</button>
	</div>

';

//Стиль надписи над сообщением из ЛС
//{THEME} - тема
$logincms[11]='
<div class="block-100 em-air">Тема: {THEME}</div>
';

//Что генерировать после сообщения из ЛС
//{REPLYFORM} - форма для ответа на сообщение
$logincms[12]='
<div class="clearfix"></div>
<br>&nbsp;<br>
<h3>Ответить</h3>
<br>
{REPLYFORM}
';

//Стиль оформления ссылок в меню ЛС
$logincms[13]='<a href="{LINK}">{CAPTION}</a>';

//Обязательный системный параметр. Вручную не вносить НИКАКИХ изменений!
$logincms[90] = "0.2";
?>
