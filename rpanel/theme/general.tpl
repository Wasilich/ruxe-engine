<h2>Основные настройки</h2>
<font class="desc"></font><br><br>
<center><form name="generaloptions" action="saver.php?saverdo=generalsave" method="post">
<table class="optionstable" border=0 cellpadding=1 cellspacing=0>
	
	<tr class="titletable"><td colspan=2>
		<center><input type="submit" name="submit" value="Сохранить все изменения"></center>
		СИСТЕМНОЕ</td></tr>
		<tr><td>Адрес сайта:<br><font class="desc">Пример: <b>http://site.com</b></font></td><td><input id="jsite" onKeyUp="generalwwwredirect();" type="text" name="site" value="{SITE}" size=46></td></tr>
		<tr><td><div id="jwww">Включить переадресацию с адреса, имеющим поддомен www, на адрес без www (или наоборот):</div><font class="desc">Крайне рекомендуется</font></td><td><select name="wwwredirect"><option value="1" {WWWREDIRECT1}>Да<option value="0" {WWWREDIRECT2}>Нет</select></td></tr>
		<tr><td>Полный путь до скриптов:<br><font class="desc">Пример: <b>/home/mysite/public_html</b></font></td><td><input type="text" name="root" value="{ROOT}" size=46></td></tr>
		<tr><td>Активировать ЧПУ (человекопонятные урл, рекомендуется):<br><font class="desc">Требуется веб-сервер Apache с mod_rewrite.</font></td><td><select name="furl"><option value="1" {FURL1}>Да<option value="0" {FURL2}>Нет</select></td></tr>		
		<tr><td>Язык:<font class="desc"><br><b>Внимание!</b> Смена языка не действует на админ-центр и темы оформления</font></td><td><select name="language">{LANGUAGES}</select></td></tr>
		<tr><td>Как относиться к возможным ошибкам скриптов (PHP: Warning, Notice и т.д.):</td><td><select name="noshowerr"><option value="1" {ERSHOW1}>Скрывать и записывать в лог ошибок <option value="5" {ERSHOW2}>Скрывать. В лог ошибок не записывать <option value="0" {ERSHOW3}>Отображать. В лог ошибок не записывать<option value="25" {ERSHOW4}>Отображать и записывать в лог ошибок</select></td></tr>
		<tr><td>Тема оформления сайта:</td><td><select name="theme">{THEMES}</select> <a href="http://ruxe-engine.ru/viewforum.php?f=21" target="_blank">Скачать новые</a></td></tr>
		<tr><td>Поправка на часовой пояс:<br><font class="desc">Серверное время: <b>{SERVERDATE}</b><br>С учётом часового пояса: <b>{UTCDATE}</b></font></td><td><select name="timezone">{TIMEZONE}</select></td></tr>
		<tr><td>Использовать GZip сжатие страниц:</td><td><select name="gzip"><option value="1" {GZIPSHOW1}>Да<option value="0" {GZIPSHOW2}>Нет</select></td></tr>
		<tr><td><a name="close"></a>Закрыть сайт:<br><font class="desc">Все, кроме администраторов (заранее вошедших в аккаунт), будут видеть сообщение</font></td><td><select name="closed"><option value="1" {CLSHOW1}>Да<option value="0" {CLSHOW2}>Нет</select></td></tr>
		<tr><td>Сообщение, выводимое при закрытом сайте:<br><font class="desc">HTML-теги разрешены</font></td><td><textarea cols=35 rows=3 name="closed_text">{CLOSED_TEXT}</textarea></td></tr>
	
	<tr class="titletable"><td colspan=2>НОВОСТНЫЕ РАЗДЕЛЫ</td></tr>
		<tr><td>Расширение для полных записей новостных разделов:<br><font class="desc">Пример: <b>.html</b>. Актуально только при активном ЧПУ.</font></td><td><input type="text" name="rewrite_ext" size=46 value="{REWRITE_EXT}"></td></tr>
		<tr><td>Количество кратких новостей на одной странице:</td><td><select name="nav_news">{NAV_NEWS}</select></td></tr>
		<tr><td>Максимальное количество выводимых ссылок на похожие записи:</td><td><select name="simcount">{SIMCOUNT}</select></td></tr>
		<tr><td>Включить счётчики просмотров записей <a href="?action=bfg" target="_blank">Новостных разделов</a>:</td><td><select name="views_counter"><option value="1" {VIEWS_COUNTER1}>Да<option value="0" {VIEWS_COUNTER2}>Нет</select></td></tr>
		<tr><td>Учитывать только уникальные просмотры людьми в счётчиках просмотров записей <a href="?action=bfg" target="_blank">Новостных разделов</a>:<br><font class="desc">Если данная опция включена, то просмотры новостей поисковыми роботами и повторные просмотры одним и тем же человеком учитываться не будут.</font></td><td><select name="uniqbfg"><option value="1" {UNIQBFG1}>Да<option value="0" {UNIQBFG2}>Нет</select></td></tr>
		<tr><td>Максимальная длина заголовка новостей в URL:<font class="desc"><br>Изменение длины происходит только при создании и редактировании новостей</font></td><td><select name="title_length">{TITLE_LENGTH}</select></td></tr>
		<tr><td>Максимальное количество выводимых ссылок на популярные новости в модуле <font class="desc">&lt;?php here_top_news('ID'); ?&gt;</font>:</td><td><select name="top_news_max">{TOP_NEWS_MAX}</select></td></tr>
	
	<tr class="titletable"><td colspan=2>КОММЕНТАРИИ</td></tr>
		<tr><td>Возможность комментирования на сайте:</td><td><select name="comments"><option value="1" {COMMENTSSHOW1}>Да<option value="0" {COMMENTSSHOW2}>Нет</select></td></tr>
		<tr><td>Запретить оставлять комментарии гостям:<br><font class="desc">Гостями считаются незарегистрированные или не вошедшие в свой аккаунт посетители</font></td><td><select name="guestnotwrite"><option value="1" {GUEST1}>Да<option value="0" {GUEST2}>Нет</select></td></tr>
		<tr><td>Включить премодерацию комментариев:<font class="desc"><br>Не действует на администраторов</font></td><td><select name="premoder"><option value="1" {PREMODERSHOW1}>Да<option value="0" {PREMODERSHOW2}>Нет</select></td></tr>
		<tr><td>Количество одобренных сообщений, после которых перестаёт действовать премодерация на пользователя:<font class="desc"><br>Актуально только при включённой премодерации, на администраторов не действует</font></td><td><input type="text" size=46 name="premod_mess" value="{premod_mess}"></td></tr>
		<tr><td>Добавлять комментарии администраторов в раздел <a href="?action=newmessages">Новые сообщения</a> и отправлять на email их (если включена отправка новых комментариев на email):</td><td><select name="adminm"><option value="1" {ADMINM1}>Да<option value="0" {ADMINM2}>Нет</select></td></tr> 
		<tr><td>Разрешить посетителям использовать смайлы и BB-коды:</td><td><select name="smiles"><option value="1" {SMILESSHOW1}>Да<option value="0" {SMILESSHOW2}>Нет</select></td></tr>
		<tr><td>Разрешить BB-код [url][/url] ([url=][/url]) в комментариях:</td><td><select name="createlinks"><option value="1" {CREATELINKS1}>Да<option value="0" {CREATELINKS2}>Нет</select></td></tr>  
		<tr><td>Возможность использовать тег [img] (не рекомендуется):</td><td><select name="img_comments"><option value="1" {IMG_COMMENTS1}>Да<option value="0" {IMG_COMMENTS2}>Нет</select></td></tr>
                <tr><td>Темы сообщений для модуля Обратной связи:<br><font class="desc">Разделяйте запятой, без пробела после неё</font><td><input type="text" name="mail_select" value="{MAIL_SELECT}" size=46></td></tr>  
		<tr><td>Комментариев на одной странице:</td><td><select name="nav_comments">{NAV_COMMENTS}</select></td></tr>
		<tr><td>Количество выводимых сообщений в модуле <font class="desc">&lt;?php here_last_posts(); ?&gt;</font> (последние комментарии):</td><td><select name="lastposts_count">{LASTPOSTS_COUNT}</select></td></tr>
		<tr><td>Длина сообщений в модуле <font class="desc">&lt;?php here_last_posts(); ?&gt;</font> (в символах):{SUBSTRERROR}</td><td><input type="text" name="lastposts_len" value="{LASTPOSTS_LEN}" size=46></td></tr>
		<tr><td>Включить цензуру комментариев:{SUBSTRERROR2}</td><td><select name="cenzura"><option value="1" {CENZURA1}>Да<option value="2" {CENZURA2}>Нет</select></td></tr>
		<tr><td>Цензура: часть слов, заменяющиеся на <font class="desc">***</font>, <b>через запятую БЕЗ пробела и маленькими буквами</b>:<br><font class="desc">Не действует на администраторов</font></td><td><input type="text" name="cenzura_words" value="{CENZURA_WORDS}" size=46></td></tr> 
	
	<tr class="titletable"><td colspan=2>АВАТАРЫ</td></tr>
		<tr><td>Включить поддержку аватар для зарегистрированных пользователей:<font class="desc"><br>При отключённых аватарах необходимо внести вручную изменения в стиль оформления пользовательского и администраторского меню (шаблон users.php)</font></td><td><select name="avatars"><option value="1" {AVATARS1}>Да<option value="2" {AVATARS2}>Нет</select></td></tr>
		<tr><td>Максимальный вес аватары (килобайты):<font class="desc"><br>При включённой опции автоматического изменения размера изображения <b>не учитывается</b></font></td><td><input type="text" name="upload_maxsite" size=46 value="{UPLOAD_MAXSITE}"></td></tr>
		<tr><td>Максимально допустимая ширина аватары (пикселы): </td><td><input type="text" name="upload_width" size=46 value="{UPLOAD_WIDTH}"></td></tr>
		<tr><td>Максимально допустимая высота аватары (пикселы): </td><td><input type="text" name="upload_height" size=46 value="{UPLOAD_HEIGHT}"></td></tr>
		<tr><td>Включить автоматическое изменение размера (ширины, высоты) изображения при загрузке:{GDERROR}</td><td><select name="resize"><option value="1" {RESIZE1}>Да<option value="0" {RESIZE2}>Нет</select></td></tr>
		<tr><td>Максимальный вес оригинального изображения (килобайты):<font class="desc"><br>Параметр <b>используется только</b> при включённой опции автоматического изменения размера изображения</font></td><td><input type="text" name="maxresize" value="{MAXRESIZE}" size=46></td></tr>
		<tr><td>Использовать сервис <a href="http://gravatar.com" target="_blank">gravatar.com</a>:</td><td><select name="gravatars"><option value="1" {GRAVATARS1}>Да<option value="0" {GRAVATARS2}>Нет</select></td></tr>
		<tr><td>Выводимый аватар, если не найден на сервисе <a href="http://gravatar.com" target="_blank">gravatar.com</a>:<br><font class="desc">Активен только в том случае, если используется сервис <a href="http://gravatar.com" target="_blank">gravatar.com</a>. Возможные варианты: <b>mm</b>, <b>identicon</b>, <b>monsterid</b>, <b>wavatar</b>, <b>retro</b></font></td><td><input type="text" size=46 name="gravatars_im" value="{GRAVATARS_IM}"></td></tr>
	
	<tr class="titletable"><td colspan=2>ЛИЧНЫЕ СООБЩЕНИЯ</td></tr>
		<tr><td>Максимальное количество сохранённых личных сообщений на одного пользователя:<font class="desc"><br>Хранение свыше 300 сообщений пользователем может существенно замедлить систему!</font></td><td><select name="pm_max">{PM_MAX}</select></td></tr>
		<tr><td>При создании нового сообщения в ЛС, отображать ли выпадающий список всех пользователей:<font class="desc"><br>Для администраторов всегда активирован выпадающий список</font></td><td><select name="pm_showusers"><option value="1" {PM_SHOWUSERS1}>Да<option value="2" {PM_SHOWUSERS2}>Нет</select></td></tr>
		<tr><td>Сообщений на одной странице в ЛС:</td><td><select name="nav_pm">{NAV_PM}</select></td></tr>
	
	<tr class="titletable"><td colspan=2>ПОДПИСИ ПОЛЬЗОВАТЕЛЕЙ</td></tr>
		<tr><td>Включить подписи:</td><td><select name="ps"><option value="1" {PS1}>Да<option value="0" {PS2}>Нет</select></td></tr>
		<tr><td>Количество символов, разрешённых в подписи:</td><td><input type="text" name="ps_max" value="{PS_MAX}" size=46></td></tr> 
  
	<tr class="titletable"><td colspan=2>EMAIL</td></tr>
		<tr><td>Ваш email адрес:</td><td><input type="text" name="mail" value="{MAIL}" size=46></td></tr>
		<tr><td>Email адрес, который будет считаться отправителем уведомлений о новых комментариях (в т.ч. обратной связи):</td><td><input type="text" name="send_mail" value="{SEND_MAIL}" size=46></td></tr>
		<tr><td>Отсылать комментарии с сайта на ваш email:</td><td><select name="sendmess"><option value="1" {MESHOW1}>Да<option value="0" {MESHOW2}>Нет</select></td></tr>
		<tr><td>Отсылать ли сообщения из Обратной связи и F.A.Q. на ваш email:</td><td><select name="plusmess"><option value="1" {PLUS1}>Да<option value="0" {PLUS2}>Нет</select></td></tr> 
		<tr><td>Email адрес, который будет считаться отправителем писем с кодом активации и восстановлением пароля:</td><td><input type="text" name="active_mail" size=46 value="{ACTIVE_MAIL}"></td></tr>
		<tr><td>Имя отправителя писем с кодом активации и восстановлением пароля:</td><td><input type="text" name="active_name" size=46 value="{ACTIVE_NAME}"></td></tr>
  
	<tr class="titletable"><td colspan=2><a name="editor"></a>РЕДАКТОР В АДМИН-ЦЕНТРЕ</td></tr>
		<tr><td>Включить визуальный редактор (TinyMCE) для редактирования новостей:</td><td><select name="visual"><option value="1" {VISUAL1}>Да<option value="0" {VISUAL2}>Нет</selecT></td></tr>
		<tr><td>Показывать подсказки при редактировании новостей:</td><td><select name="showbfghints"><option value="1" {SHOWBFGHINTS1}>Да<option value="0" {SHOWBFGHINTS2}>Нет</select></td></tr>
		<tr><td>Включить редактор EditArea для новостей (если отключён TinyMCE), страниц и шаблонов:</td><td><select name="editarea"><option value="1" {EDITAREA1}>Да<option value="0" {EDITAREA2}>Нет</select></td></tr>
		<tr><td>Включить перенос по словам по умолчанию в EditArea:</td><td><select name="editareawp"><option value="1" {EDITAREAWP1}>Да<option value="0" {EDITAREAWP2}>Нет</select></td></tr>
		<tr><td>Шрифт, используемый в редакторе EditArea:<br><font class="desc">Пример: <b>Courier New</b></font></td><td><input type="text" name="fontfamily" value="{FONTFAMILY}" size=46></td></tr>
		<tr><td>Размер шрифта, используемого в EditArea:</td><td><select name="fontsize">{FONTSIZE}</select></td></tr>
  
	<tr class="titletable"><td colspan=2>БЕЗОПАСНОСТЬ</td></tr>
		<tr><td>Установить защиту админ-центра по IP (рекомендуется):<br><font class="desc">После входа в админ-центр будет сохранён текущий IP и если IP сменился, то сессия удаляется и необходимо будет перезайти</font></td><td><select name="save_admin_ip"><option value="1" {SAVE_ADMIN_IP1}>Да<option value="0" {SAVE_ADMIN_IP2}>Нет</select></td></tr>
		<tr><td>Время жизни сессии пользователей и администраторов (в секундах):</td><td><input type="text" name="time_cookie" value="{TIME_COOKIE}" size=46></td></tr>
		<tr><td>Вести учёт действий в админ-центре:{AL}<br><font class="desc">Лог админ-центра, если не пуст, отображается в разделе <a href="?action=system">Обслуживание</a></font></td><td><select name="alog"><option value="1" {ALSHOW1}>Да<option value="0" {ALSHOW2}>Нет</select></td></tr>
		<tr><td>Скрывать присутствие администраторов на сайте:</td><td><select name="hide_admin"><option value="1" {HIDE_ADMIN1}>Да<option value="0" {HIDE_ADMIN2}>Нет</select></td></tr>
		<tr><td>Защита от флуда (секунды):<font class="desc"><br>Не действует на администраторов</font></td><td><input type="text" name="noflood" value="{NOFLOOD}" size=46></td></tr>
		<tr><td>Запретить регистрацию нескольких пользователей с одного IP:</td><td><select name="oneipreg"><option value="1" {ONEIPREG1}>Да<option value="0" {ONEIPREG2}>Нет</select></td></tr>
		<tr><td>Разрешить гостям писать комментарии без указания email адреса:</td><td><select name="without_mail"><option value="1" {WITHOUT_MAIL1}>Да<option value="0" {WITHOUT_MAIL2}>Нет</select></td></tr>		
		<tr><td>Максимальное количество символов в комментариях:{SUBSTRERROR3}</td><td><input type="text" name="max_message" value="{MAX_MESSAGE}" size=46></td></tr>
		<tr><td>Запретить кэширование страниц браузером:</td><td><select name="nocache"><option value="1" {NOCSHOW1}>Да<option value="0" {NOCSHOW2}>Нет</select></td></tr>		
		<tr><td>Включить возможность блокировки посетителей по IP:</td><td><select name="ban"><option value="1" {BANSHOW1}>Да<option value="0" {BANSHOW2}>Нет</select></td></tr>
		<tr><td>Разрешить посетителям регистрироваться через сайт:</td><td><select name="registration"><option value="1" {REG1}>Да<option value="0" {REG2}>Нет</select></td></tr>
		<tr><td>Включить активацию новых пользователей по email:</td><td><select name="active"><option value="1" {ACTIVE1}>Да<option value="0" {ACTIVE2}>Нет</select></td></tr>
		<tr><td>Разрешить пользователям восстанавливать пароль:</td><td><select name="restore"><option value="1" {RESTORE1}>Да<option value="0" {RESTORE2}>Нет</select></td></tr>
  	
  	<tr class="titletable"><td colspan=2>RSS</td></tr>
		<tr><td>Заголовок RSS ленты:</td><td><input type="text" name="rsstitle" value="{RSSTITLE}" size=46></td></tr>
		<tr><td>Часовой пояс RSS каналов:</td><td><input type="text" name="rss" value="{RSS}" size=46></td></tr>
		<tr><td><a href="?action=bfg" target="_blank">Идентификатор новостного раздела</a>, используемого для RSS канала:</td><td><select name="rss_id">{RSS_ID}</select></td></tr>
		<tr><td>Максимальное количество записей в ленте:<font class="desc"><br>Если записей будет больше указанного, то старые будут удаляться из ленты</font></td><td><select name="rss_count">{RSS_COUNT}</select></td></tr>
  
	<tr class="titletable"><td colspan=2>СТАТИСТИКА</td></tr>
		<tr><td>Вести статистику посещений:<br><font class="desc">Статистка посещений, если не пуста, отображается в разделе <a href="?action=system">Обслуживание</a></font></td><td><select name="log"><option value="1" {LOSHOW1}>Да<option value="0" {LOSHOW2}>Нет</select></td></tr>
		<tr><td>Максимальное количество записей в статистике посещений:</td><td><input type="text" name="log_max" value="{LOG_MAX}" size=46></td></tr>
		<tr><td>Вести статистику бана:<br><font class="desc">Лог бана, если не пуст, отображается в разделе <a href="?action=system">Обслуживание</a></font></td><td><select name="banlog"><option value="1" {BANLOGSHOW1}>Да<option value="0" {BANLOGSHOW2}>Нет</select></td></tr>
		<tr><td>Сохранять рекорд онлайн:</td><td><select name="record"><option value="1" {RESHOW1}>Да<option value="0" {RESHOW2}>Нет</select></td></tr>
		<tr><td>Количество минут для подсчёта посетителей в онлайн:</td><td><select name="onlinetime">{ONLINETIME}</select></td></tr>
		
	<tr class="titletable"><td colspan=2>ДРУГОЕ</td></tr>
		<tr><td><input type="hidden" name="nav_downloads" value="50">Записей F.A.Q. на одной странице:</td><td><select name="nav_faq">{NAV_FAQ}</select></td></tr>
		<tr><td>Записей логов в разделе <a href="?action=system">Обслуживание</a>:</td><td><select name="nav_system">{NAV_SYSTEM}</select></td></tr>
		<tr><td>Количество позиций в модуле <font class="desc">&lt;?php here_top_downloads(); ?&gt;</font>:</td><td><select name="top_count">{TOP_COUNT}</select></td></tr>
		<tr><td>Показывать счётчик в модуле <font class="desc">&lt;?php here_top_downloads(); ?&gt;</font>:</td><td><select name="top_show"><option value="1" {TOPSHOWSHOW1}>Да<option value="0" {TOPSHOWSHOW2}>Нет</select></td></tr>
		<tr><td>Показывать промежуточные страницы переадресаций:<br><font class="desc">С сообщениями, например, "Ваш комментарий успешно добавлен"</font></td><td><select name="fullredirect"><option value="1" {FULLREDIRECT1}>Да<option value="0" {FULLREDIRECT2}>Нет</select></td></tr>
		<tr><td>Показывать промежуточную страницу с прямой ссылкой при загрузке файла из Каталога файлов:</td><td><select name="directdownload"><option value="1" {DIRECTDOWNLOAD1}>Да<option value="0" {DIRECTDOWNLOAD2}>Нет</select></td></tr> 
		<tr><td>Скрывать текст <font class="desc">http://</font> при работе модуля "Каталог ссылок":</td><td><select name="http"><option value="1" {HTTPSHOW1}>Да<option value="0" {HTTPSHOW2}>Нет</select></td></tr>
		<tr><td>Запретить индексацию поисковиками каталога ссылок:</td><td><select name="noindex"><option value="1" {NOINDEXSHOW1}>Да<option value="0" {NOINDEXSHOW2}>Нет</select></td></tr>
		<tr><td>Whois сервис, используемый в админ-центре:<font class="desc"><br>В конец адреса подставляется IP, поэтому следует учесть параметры типа ?q=, ?ip= и др.</font></td><td><input type="text" size=46 name="whois" value="{WHOIS}"></td></tr>
		<tr><td>Включить поддержку кириллических доменов:<br><font class="desc">Автоматическое преобразование кириллических доменов (напр., <i>мой-черновик.рф</i>) в Punycode (<b>требуется PHP версии 5.2.17 или новее</b>)</font></td><td><select name="punycode"><option value="1" {PUNYCODE1}>Да<option value="0" {PUNYCODE2}>Нет</select></td></tr>
		<tr><td>Использовать обратную навигацию:</td><td><select name="nav_back"><option value="1" {NAV_BACK1}>Да<option value="0" {NAV_BACK2}>Нет</select></td></tr>
	<tr class="sub"><td colspan=2><input type="submit" name="submit" value="Сохранить все изменения"></td></tr>
</table>
</form>
<script type="text/javascript">
	generalwwwredirect();
</script>
</center>