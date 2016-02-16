<h2>Добро пожаловать в админ-центр Ruxe Engine</h2>
<font class="desc">Приятной работы с Ruxe Engine.</font><br><br>
<noscript>
	<center>
		<table class="optionstable" border=0 cellpadding=1 cellspacing=0>
			<tr class="titlered"><td>ВКЛЮЧИТЕ ПОДДЕРЖКУ JAVASCRIPT В ВАШЕМ БРАУЗЕРЕ</td></tr>
			<tr class="redtd"><td>Для полноценной работы Ruxe Engine необходимо включить JavaScript в Вашем браузере</td></tr>
		</table>
	</center><br>
</noscript>
<center>
	<table class="optionstable" border=0 cellpadding=1 cellspacing=0>
		<tr class="titletable"><td colspan=2>О ПРОГРАММЕ</td></tr>
		<tr><td colspan=2 align="center">
			<a href="http://ruxe-engine.ru/" target="_blank">Сайт программы</a> •
			<a href="https://github.com/maindefine/ruxe-engine/blob/master/README.md" target="_blank">Документация</a> •
			<a href="http://ruxe-engine.ru/viewforum.php?f=21" target="_blank">Дополнения</a> •
			<a href="?action=system&amp;go=thanks">Благодарности</a> •
			<a href="https://github.com/maindefine/ruxe-engine/blob/master/LICENSE-FULL-EN.txt">Лицензия</a>
		</td></tr>{INSTALL}
		<tr class="titletable"><td width = "50%">СТАТИСТИКА</td><td width="50%">НЕДАВНИЕ КОММЕНТАРИИ</td></tr>
		<tr><td valign="top">			
			<table id="notebook" border=0 class="optionstable2" cellpadding=1 cellspacing=0 style="display:none; position: absolute;">
				<tr class="titleblue"><td>БЛОКНОТ</td></tr>
				<tr class="bluetd"><td>
					<form name="notepad" action="?action=index&amp;go=savenotepad&amp;rand={RAND}#note" method="POST">
						<textarea cols=80 rows=10 name="message">{NOTEPAD}</textarea><br>
						<input type="submit" name="submit" value="Сохранить и закрыть">
					</form>
				</td></tr>
			</table>
			<table id="without" border=0>
				<tr><td>Блокнот:</td><td><a name="note"></a><input type="button" id="notebutton" value="Открыть блокнот" onClick="document.getElementById('notebook').style.display='block'; location.href='#note';"></td></tr>
				<tr><td>Всего просмотрено страниц:</td><td>{ALL_HITS}</td></tr>
				<tr><td>За всё время посетило людей:</td><td>{ALL_HOSTS}</td></tr>
				<tr><td>Сегодня просмотрено страниц:</td><td>{HITS}</td></tr>
				<tr><td>Вчера посетило людей:</td><td>{LAST_HOSTS}</td></tr>
				<tr><td>Серверное время:</td><td>{SERVER_TIME}</td></tr>
				<tr><td>Время с учётом часового пояса:</td><td>{UTCTIME}</td></tr>
				<tr><td>Сегодня посетило людей:</td><td>{HOSTS}</td></tr>
				<tr><td>Сейчас людей на сайте:</td><td>{ONLINE}</td></tr>
				<tr><td>Роботов сегодня:</td><td>{BOTS}</td></tr>
				<tr><td>RSS-канал новостей:</td><td>{RSS_NEWS}</td></tr>
				<tr><td>Серверное DOCUMENT_ROOT:</td><td>{DEFAULT_ROOT}</td></tr>
				<tr><td>register_globals:</td><td>{register_globals}</td></tr>
			</table> 
		</td><td valign="top" align="center">
			{MESSAGES}
		</td></tr>
	</table>
</center>
<br>
<h2>Кто где</h2>
<font class="desc">Просмотр информации о посетителях, побывавших на сайте за последние {TIME_RECORD} минут</font><br><br>
<center> 
	<table class="optionstable" border=0 cellpadding=1 cellspacing=0>
		<tr class="titletable"><td width=100>IP</td><td width=300>ПОСЛЕДНЕЕ ДЕЙСТВИЕ</td><td>БРАУЗЕР</td></tr>
		{WHOONLINE}
	</table>
</center>
