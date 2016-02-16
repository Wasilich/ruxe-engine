<h2>Обслуживание</h2>
<font class="desc">Обслуживание системы, а также просмотр статистики и установка блокировки на определенные IP</font><br><br>
<center><table class="optionstable" border=0 cellpadding=1 cellspacing=0>
<tr class="titletable"><td colspan=2>RUXE ENGINE</td></tr>
<tr><td>Версия Ruxe Engine:</td><td>{VERSION}</td></tr>
<tr><td>Справка по работе с Ruxe Engine:</td><td><a href="https://github.com/maindefine/ruxe-engine/blob/master/README.md" target="_blank">Читать</a></td></tr>
<tr><td>Поддержка проекта:</td><td><a href="http://ahrameev.ru/contact" target="_blank">Подробнее</a></td></tr>
<tr><td>Нашли ошибку?</td><td><a href="http://ruxe-engine.ru/viewforum.php?f=13" target="_blank">Сообщите о ней!</a></td></tr>
<tr><td>Благодарности</td><td><a href="?action=system&amp;go=thanks">Читать</a></td></tr>
</table>
<br>
<form name="ban" method="post" action="saver.php?saverdo=addban">
<table class="optionstable" border=0 cellpadding=1 cellspacing=0>
<tr class="titletable"><td colspan=2>БАН IP АДРЕСОВ</td></tr>
<tr><td colspan=2>
<table class="bordernone" width="100%" border=0 cellspacing=0 cellpadding=1>
<tr><td width="50%">IP адрес (например, 127.0.*.1): </td><td><input type="text" name="ip" value="" size=40></td></tr>
<tr><td>Причина бана:</td><td><input type="text" name="why" value="" size=40></td></tr>
<tr><td></td><td><input type="submit" name="submit" value="Заблокировать"></td></tr>
</table>
</td></tr>
{BANLIST}
</table>
<br>
</form>

<form name="confbackup2" method="get" action="../index.php">
<input type="hidden" name="needconfbackup" value="true">
<input type="hidden" name="check" value="{CONFBACKUPCHECK}">
<table class="optionstable" cellpadding=1 cellspacing=0>
	<tr class="titletable"><td colspan=4><a name="confbackup"></a>ПОЛНОЕ РЕЗЕРВНОЕ КОПИРОВАНИЕ КОНФИГУРАЦИИ В ZIP АРХИВ</td></tr>
	<tr><td colspan=4><font class="desc">Полная резервная копия кофигурации включает в себя каталоги /avatars/, /conf/, /themes/. Для создания резервной копии требуется PHP версии 5.2 или новее.</font></td></tr>
	<tr class="titletable"><td width=200>ДАТА</td><td>ИМЯ АРХИВА</td><td>РАЗМЕР</td><td>ДЕЙСТВИЯ</td></tr>
	{CONFBACKUPLIST}
	<tr class="sub"><td colspan=4><input type="submit" name="submit" value="Создать полную резервную копию конфигурации"></td></tr>
</table>
<br>
</form>

<form name="backup" method="post" action="saver.php?saverdo=restorebackup">
<table class="optionstable" border=0 cellpadding=1 cellspacing=0>
<tr class="titletable"><td colspan=2><a name="backup"></a>ЧАСТИЧНОЕ РЕЗЕРВНОЕ КОПИРОВАНИЕ</td></tr>
<tr><td width=20></td><td>Дата последнего обновления: <b>{DATEBACKUP}</b></td></tr>
<tr><td><input type="checkbox" name="hits" value="true"></td><td>Всего хитов: <b>{HITS}</b>; Можно восстановить до: <b>{REHITS}</b></td></tr>
<tr><td><input type="checkbox" name="hosts" value="true"></td><td>Всего хостов: <b>{HOSTS}</b>; Можно восстановить до: <b>{REHOSTS}</b></td></tr>
<tr><td><input type="checkbox" name="links" value="true"></td><td>Счётчики переходов по ссылкам: <b>{LINKS}</b>; Можно восстановить до: <b>{RELINKS}</b></td></tr>
<tr><td><input type="checkbox" name="downloads" value="true"></td><td>Счётчики скачиваний: <b>{DOWNLOADS}</b>; Можно восстановить до: <b>{REDOWNLOADS}</b></td></tr>
<tr><td><input type="checkbox" name="views" value="true"></td><td>Счётчики просмотров: <b>{VIEWS}</b>; Можно восстановить до: <b>{REVIEWS}</b></td></tr>
<tr><td><input type="checkbox" name="config" value="true"></td><td>config.php</td></tr>
<tr class="sub"><td colspan=2>
<input type="button" onClick="location.href='saver.php?saverdo=create_backup';" value="Обновить всё">
<input type="submit" name="submit" value="Восстановить выбранное"></td></tr>
</table>
<br>
</form>
[if_log]
<table class="optionstable" border=0 cellpadding=1 cellspacing=0>
<tr class="titletable"><td colspan=5>ЛОГ ПОСЕЩЕНИЙ</td></tr>

{LOG}
<tr><td colspan=5>{LOGPAGES}</td></tr>
<tr class="sub"><td colspan=5><input type="button" onClick="location.href='saver.php?saverdo=clear&amp;file=log';" value="Очистить"></td></tr>
</table>
<br>
[/if_log]
[if_alog]
<table class="optionstable" border=0 cellpadding=1 cellspacing=0>
<tr class="titletable"><td>ЛОГ АДМИН-ЦЕНТРА</td></tr>
{ALOG}
<tr><td>{ALOGPAGES}</td></tr>
<tr class="sub"><td>{CLEARALOG}</td></tr>
</table>
<br>
[/if_alog]
[if_elog]
<table class="optionstable" border=0 cellpadding=1 cellspacing=0>
<tr class="titletable"><td colspan=6>ЛОГ ОШИБОК</td></tr>
<tr class="titletable"><td width=200>ВРЕМЯ</td><td>КОД ОШИБКИ</td><td>СООБЩЕНИЕ ОШИБКИ</td><td>ФАЙЛ</td><td>СТРОКА</td><td>IP</td></tr>
{ERRORS}
<tr><td colspan=6>{ERRORSPAGES}</td></tr>
<tr class="sub"><td colspan=6><input type="button" onClick="location.href='saver.php?saverdo=clear&amp;file=errors';" value="Очистить"></td></tr>
</table><br>
[/if_elog]
[if_blog]
<table class="optionstable" border=0 cellpadding=1 cellspacing=0>
<tr class="titletable"><td colspan=5>ЛОГ БАНА</td></tr>
<tr class="titletable"><td width=200>ВРЕМЯ</td><td>IP</td><td>СТРАНИЦА</td><td>БРАУЗЕР</td><td>ОТКУДА</td></tr>
{BANLOG}
<tr><td colspan=5>{BANLOGPAGES}</td></tr>
<tr class="sub"><td colspan=5><input type="button" onClick="location.href='saver.php?saverdo=clear&amp;file=ban';" value="Очистить"></td></tr>
</table>
[/if_blog]
</center> 
