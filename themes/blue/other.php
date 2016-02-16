<?php
//Оформление комментариев модуля here_last_posts(); (переделал на дивах)
//{THEMEPATH} - полный адрес до используемой темы без / на конце
//{URL} - адрес новости
//{DATE} - дата публикации комментария
//{NAME} - имя комментатора
//{MESSAGE} - сообщение
$ocms[0] = '
<li>
<div class="last-posts">
    <h4><a href="{URL}#comments">{TITLE}</a></h4>
	<div class="name">
	    {DATE}
	</div>
	<br>
	{MESSAGE}
<div>
</li>
';

//Оформление комментариев с аватарами (переделал на дивах)
//{WIDTH} - максимальная ширина аватар
//{NAME} - имя комментатора
//{DATE} - дата комментирования
//{SITE} - адрес сайта без / на конце
//{THEMEPATH} - полный путь до каталога выбранной темы оформления без / на конце
//{HEIGHT} - максимальная высота аватар
//{AVATAR} - физическое имя аватары
//{MESSAGE} - комментарий
//{ONLYNAME} - имя комментатора без генерации тегов
$ocms[14]='
<div class="comment-table">
    <div class="row">
	    <div class="comment-cell-name">{NAME}</div>
		<div class="comment-cell-date">{DATE}</div>
		<div class="comment-cell-cite">[if_canquote][<a href="#messbox" class="cite" onClick="copyText(\'{ONLYNAME}\');"  title="Выделите текст в сообщении {ONLYNAME} и нажмите эту ссылку">Цитировать</a>][/if_canquote]</div>
	</div>
	<div class="row">
	    <div class="comment-cell-name"><img src="{AVATAR}" border=0 alt=""></div>
		<div class="comment-cell-text">{MESSAGE}</div>
	</div>
</div>
<br>';

//Оформление комментариев без аватаров (переделал на дивах)
//{NAME} - имя комментатора
//{DATE} - дата комментирования
//{SITE} - адрес сайта без / на конце
//{THEMEPATH} - полный путь до каталога выбранной темы оформления без / на конце
//{MESSAGE} - комментарий
//{ONLYNAME} - имя комментатора без генерации тегов
$ocms[13]='
<div class="comment-table">
    <div class="row">
	    <div class="comment-cell-name">{NAME}</div>
		<div class="comment-cell-date">{DATE}</div>
		<div class="comment-cell-cite">[if_canquote][<a href="#messbox" class="cite" onClick="copyText(\'{ONLYNAME}\');"  title="Выделите текст в сообщении {ONLYNAME} и нажмите эту ссылку">Цитировать</a>][/if_canquote]</div>
	</div>
	<div class="row">
		<div class="comment-cell-text-wava">{MESSAGE}</div>
	</div>
</div>
<br>';

//Главное оформление Каталога файлов (записи настраиваются в $ocms[4])
//{PAGES} - навигация
//{LIST} - список записей
//
//Судя по всему, листинг каталога выполнен на тегах "tr" и "td" (поэтому не буду трогать)
$ocms[3]='
<center><table width="99%" border=0 cellpadding=2 cellspacing=5>
{LIST}
</table></center> <br>
{PAGES}';

//Стиль записей в модуле Каталог файлов
//{BIGIMG} - адрес крупного скриншота
//{PROGRAM} - название файла
//{IMG} - адрес мини скриншота
//{COUNT} - количество скачиваний
//{DESCRIPTION} - описание
//{ADD1} - дополнительное описание 1
//{ADD2} - дополнительное описание 2
//{SITE} - адрес сайта без / на конце
//{FILE} - идентификатор
//{PATHFILE}
//
//Тоже на тегах "tr" и "td" (поэтому не буду трогать)
$ocms[4]='
<tr>
	<td valign="middle" align="left" width=100>
		<div>
			<a href="{BIGIMG}" title="Увеличить скриншот {PROGRAM}" target="_blank"><img src="{IMG}" border=0 alt=""></a>
		</div>
	</td>
	<td align="left">
		<b>{PROGRAM}</b><br>
		<font color="grey">
		Freeware<br>
	        {COUNT}<br>
		Автор: <a href="{ADD1}">{ADD2}</a><br><br>
		</font>
		{DESCRIPTION}
	</td>
</tr>
<tr>
	<td style="border-bottom: 1px dashed #c7c7c7;" colspan=2 align="center">
		<a href="{PATHFILE}">Скачать {PROGRAM}</a>
	</td>
</tr>';

//Главное оформление модуля F.A.Q. (записи оформляются в $ocms[9])
//{PAGES} - навигатор страниц
//{LIST} - записи
$ocms[8]='
<h4>F.A.Q.</h4>
    <br>
    {LIST}
	{PAGES}
';

//Оформление записей F.A.Q.
//{THEMEPATH} - полный путь до каталога выбранной темы оформления без / на конце
//{NAME} - имя спрашивающего
//{QUESTION} - вопрос
//{DATE} - дата
//{ADMIN} - имя отвечающего
//{ANSWER} - ответ
$ocms[9]='
<div class="question-table">
    <div class="row">
	    <div class="question-cell-name">{NAME}</div>
		<div class="question-cell">{QUESTION}</div>
		<div class="question-cell-date">{DATE}</div>
	</div>
	<div class="row">
	    <div class="question-cell-name"><b>{ADMIN}:</b></div>
		<div class="question-cell-text">{ANSWER}</div>
	</div>
</div>
<br>';

//Главное оформление модуля Каталог ссылок (записи настраиваются в $ocms[6])
//{LINKS} - записи
//
//Тоже в LINKS теги "tr" и "td" сидят (поэтому не буду трогать)
$ocms[5]='<table border=0 cellpadding=3 cellspacing=5>
{LINKS}
</table>';

//Оформление записей в Каталоге ссылок
//{SITE} - адрес сайта без / на конце
//{URL} - идентификатор ссылки
//{SHOWED_URL} - ссылка
//{COUNT} - количество переходов
//{DESCRIPTION} - описание ссылки
//{NOINDEX} - заменяется на rel="nofollow" при включённой опции запрета индексации поисковыми системами ссылок
//"Запретить индексацию поисковиками каталога ссылок" и удаляются при отключённой
//{URLPATH}
//
//Где-то начинается и заканчивается таблица (поэтому не буду трогать)
$ocms[6]='
<tr>
	<td><a {NOINDEX} target="_blank" href="{URLPATH}">{SHOWED_URL}</a> (переходов: {COUNT})</td>
</tr>
<tr>
	<td>{DESCRIPTION}</td>
</tr>';

//Оформление одной записи F.A.Q. для here_random_faq();
//{SITE} - адрес сайта
//{NAME} - имя спрашивающего
//{QUESTION} - вопрос
//{ADMIN} - имя отвечающего
//{ANSWER} - ответ
//{THEMEPATH} - полный путь до каталога выбранной темы оформления без / на конце
$ocms[1]='
<div class="question-table">
    <div class="row">
	    <div class="question-cell-name">{NAME}:</div>
		<div class="question-cell-text">{QUESTION}</div>
	</div>
	<div class="row">
	    <div class="question-cell-name"><b>{ADMIN}:</b></div>
		<div class="question-cell-text">{ANSWER}</div>
	</div>
</div>
';

//Оформление ссылок на категории новостей в here_list_category
//{LINK} - адрес категории
//{ID} - идентификатор новостного раздела
//{CATEGORY} - категория новостей
//{THEMEPATH} - полный путь до каталога выбранной темы оформления без / на конце
//{SITE} - адрес сайта без / на конце
//{PATH} - ....
$ocms[2]='<li><h4><a href="{PATH}">{CATEGORY}</a></h4></li>';

//Оформление результата работы модуля Ротатор баннеров
//{URL} - адрес
//{CODE} - код
$ocms[7]='<a href="{URL}" target="_blank">{CODE}</a>';

//Оформление результатов команды here_top_downloads
//{SITE} - адрес сайта без / на конце
//{NAME} - идентификатор файла
//{DESCRIPTION} - название файла
//{COUNT} - количество скачиваний
//{PATH}
$ocms[10]='<li><a href="{PATH}">{DESCRIPTION}{COUNT}</a></li>';

//Оформление одиночных разделов для комментариев
//{COMMENTFORM} - форма ввода комментариев
//{PAGES} - навигатор страниц
//{COMMENTS} - комментарии
$ocms[11]='{COMMENTFORM}<br>{PAGES}<br>{COMMENTS}{PAGES}';

//Стиль оформления спойлера ([spoiler][/spoiler])
//{TITLE} - заголовок
//{TEXT} - текст
$ocms[15]='
<div class="spoiler" onClick="if (this.lastChild.style.display != \'\') {this.lastChild.style.display = \'\';} else {this.lastChild.style.display = \'none\';}">
	    {TITLE}:<br>
    <div class="spoilertext">
		{TEXT}
    </div>
</div>
';

//Стиль оформления цитат с указанием имени ([quote=TITLE][/quote])
//{TITLE} - имя цитируемого
//{TEXT} - текст
$ocms[16]='
<div class="quote">
    {TITLE} писал(а):
    <div class="quotetext">
	    {TEXT}
    </div>
</div>
';

//Стиль оформления скрытого текста ([hide][/hide])
//{HIDE_MESSAGE} - текст
//Просто вынес в файл style.css
$ocms[17]='
<div class="hide">
        Скрытый текст:
    <div class="hidetext">
	    {HIDE_MESSAGE}
	</div>
</div>
';

//Навигатор страниц
//{PAGES} - страницы
$ocms[18]='
<div class="pager">Страницы: {PAGES}</div>
';

//Стиль оформления цитат без указания имени цитируемого ([quote][/quote])
//{TEXT} - текст
$ocms[19]='
<div class="quote">
        Цитата:
    <div class="quotetext">
	    {TEXT}
    </div>
</div>
';

//{PAGES} - Навигатор страниц
//{NEWS} - Краткие новости, каждая из которых будет использовать шаблон newsrecord.html
$ocms[20]='{NEWS}<br>
{PAGES}';

//Оформление ссылок для списка тегов, выводимых командой here_list_tags
//{LINK} - адрес страницы с отфильтрованными новостями
//{CAPTION} - название тега
//Самые частые теги:
$ocms[21]='<a href="{LINK}" style="font-size:100%;">{CAPTION}</a> ';
//Просто частые теги:
$ocms[22]='<a href="{LINK}" style="font-size:95%;">{CAPTION}</a> ';
//Обычные теги:
$ocms[23]='<a href="{LINK}" style="font-size:85%;">{CAPTION}</a> ';
//Очень редкие теги:
$ocms[24]='<a href="{LINK}" style="font-size:70%;">{CAPTION}</a> ';

//Обязательный системный параметр. Вручную не вносить НИКАКИХ изменений!
$ocms[90] = "0.2";

//Оформление ссылок на популярные новости (here_top_news)
//{URL} - адрес
//{CAPTION} - заголовок новости
//{COUNTER} - число просмотров
//{FULLCOUNTER} - число просмотров + поясняющее слово (напр., 98 просмотров)
$ocms[30] = '<li><h4><a href="{URL}">{CAPTION}</a></h4></li>
    <div class="counter"> ({FULLCOUNTER})</div>
<br>
';
