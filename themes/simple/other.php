<?php
//Оформление комментариев модуля here_last_posts();
//{THEMEPATH} - полный адрес до используемой темы без / на конце
//{URL} - адрес новости
//{DATE} - дата публикации комментария
//{NAME} - имя комментатора
//{MESSAGE} - сообщение
$ocms[0] = '
<div class="section-title">
	<h4><a href="{URL}#comments" title="{TITLE}">{TITLE}</a></h4>
	<span class="info">
	    {DATE}
	</span>
	<br>
	<br>
</div>
';

//Оформление комментариев с аватарами
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
<div class="clearfix"></div>
<form class="commentform block-70" role="form">
    <div class="comment-block block-100">
        <div class="row  block-100 colour">
	        <div class="comment-wrapper">
                <div class="comment-cell-top">
                    {DATE}
			        <span class="pull-right">[if_canquote]<a href="#messbox" onClick="copyText(\'{ONLYNAME}\');"  title="Выделите текст в сообщении {ONLYNAME} и нажмите эту ссылку">«Цитировать»</a>[/if_canquote]</span>
                </div>
            </div>
            <div class="fix-column">
                {NAME}
            </div>
	    </div>
	    <div class="row">
            <div class="comment-wrapper">
                <div class="comment-cell-text">
                    {MESSAGE}
                </div>
            </div>
            <div class="fix-column">
                <img src="{AVATAR}">
            </div>
	    </div>
		
    </div>
</form>
<br>
<br>';

//Оформление комментариев без аватаров
//{NAME} - имя комментатора
//{DATE} - дата комментирования
//{SITE} - адрес сайта без / на конце
//{THEMEPATH} - полный путь до каталога выбранной темы оформления без / на конце
//{MESSAGE} - комментарий
//{ONLYNAME} - имя комментатора без генерации тегов
$ocms[13]='
<div class="clearfix"></div>
<form class="commentform block-70" role="form">
    <div class="comment-block block-100">
	    <div class="row block-100 colour">
            <div class="comment-wrapper">
		        <div class="comment-cell-top">
				    {DATE}
		        <span class="pull-right">[if_canquote]<a href="#messbox" onClick="copyText(\'{ONLYNAME}\');"  title="Выделите текст в сообщении {ONLYNAME} и нажмите эту ссылку">[Цитировать]</a>[/if_canquote]</span>
				</div>
	        </div>
			<div class="fix-column">
			    {NAME}
			</div>
        </div>
		<div class="row block-100">
            <div class="comment-wrapper">
                {MESSAGE}
            </div>
	    </div>
			
	</div>
</form>
<br>
<br>';

//Главное оформление Каталога файлов (записи настраиваются в $ocms[4])
//{PAGES} - навигация
//{LIST} - список записей
//
//Судя по всему, листинг каталога выполнен на тегах "tr" и "td" (поэтому не буду трогать)
$ocms[3]='
<table width="99%" border=0 cellpadding=2 cellspacing=5>
    {LIST}
</table>
<br>
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
    <div class="row block-100">
	    <div class="block-50">
		    <div class="content">
			<div class="question-cell-name">
			    {NAME}
			</div>
		    <div class="question-cell-text">
			    {QUESTION}
				<div class="info">
				    {DATE}
				</div>
			</div>
			</div>
		</div>
	
	    <div class="block-50">
		    <div class="content">
			<div class="question-cell-name">
			    {ADMIN}:
			</div>
		    <div class="question-cell-text">
			    {ANSWER}
			</div>
			</div>
		</div>
	</div>
</div>
<br>';

//Оформление одной записи F.A.Q. для here_random_faq();
//{SITE} - адрес сайта
//{NAME} - имя спрашивающего
//{QUESTION} - вопрос
//{ADMIN} - имя отвечающего
//{ANSWER} - ответ
//{THEMEPATH} - полный путь до каталога выбранной темы оформления без / на конце
$ocms[1]='
<div class="question-table border block-100">
    <div class="content">
	<span class="color-orange"><h4>Случайный «вопрос-ответ»</h4></span>
	<div class="row block-100 color-bottom-bordered ">
	    <div class="question-cell-name">{NAME}:</div>
		<div class="question-cell-text">{QUESTION}</div>
	</div>
	<br>
	<div class="row block-100">
	    <div class="question-cell-name">{ADMIN}:</div>
		<div class="question-cell-text">{ANSWER}</div>
	</div>
	</div>
</div>
';

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

//Оформление ссылок на категории новостей в here_list_category();
// class="block-50" можно менять по своему желанию...
//{LINK} - адрес категории
//{ID} - идентификатор новостного раздела
//{CATEGORY} - категория новостей
//{THEMEPATH} - полный путь до каталога выбранной темы оформления без / на конце
//{SITE} - адрес сайта без / на конце
//{PATH} - ....
$ocms[2]='
<div class="block-50">
    <ul>
        <li class="inline"><i class="fa fa-list-ul"></i><a href="{PATH}"> {CATEGORY}</a></li>
    </ul>
    <br>
</div>
';

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
$ocms[10]='
<div class="block-50">
    <ul>
        <li class="inline"><i class="fa fa-download"></i><a href="{PATH}"> {DESCRIPTION} {COUNT}</a></li>
    </ul>
    <br>
</div>
';

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
		{TITLE}: 
		{TEXT}
</div>
';

//Стиль оформления цитат с указанием имени ([quote=TITLE][/quote])
//{TITLE} - имя цитируемого
//{TEXT} - текст
$ocms[16]='
<blockquote>
    {TITLE} писал(а):
    <div class="quote-text">
	    {TEXT}
    </div>
</blockquote>
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
<div class="row group-100">
    <div class="navy-page text-center">
        <p>Страницы</p>
        <div class="clearfix"></div>
        <span class="pager">{PAGES}</span>
    </div>
</div>
<br>
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
$ocms[20]='
{NEWS}<br>
{PAGES}
';

//Оформление ссылок для списка тегов, выводимых командой here_list_tags
//{LINK} - адрес страницы с отфильтрованными новостями
//{CAPTION} - название тега
//Самые частые теги:
$ocms[21]='<a href="{LINK}" style="font-size:95%;">{CAPTION}</a> ';
//Просто частые теги:
$ocms[22]='<a href="{LINK}" style="font-size:95%;">{CAPTION}</a> ';
//Обычные теги:
$ocms[23]='<a href="{LINK}" style="font-size:95%;">{CAPTION}</a> ';
//Очень редкие теги:
$ocms[24]='<a href="{LINK}" style="font-size:95%;">{CAPTION}</a> ';

//Обязательный системный параметр. Вручную не вносить НИКАКИХ изменений!
$ocms[90] = "0.2";

//Оформление ссылок на популярные новости (here_top_news)
//{URL} - адрес
//{CAPTION} - заголовок новости
//{COUNTER} - число просмотров
//{FULLCOUNTER} - число просмотров + поясняющее слово (напр., 98 просмотров)
$ocms[30] = '
<ul>
    <li><a href="{URL}">{CAPTION}</a>
        <br>
		<span class="info"> ({FULLCOUNTER})</span>
    </li>
</ul>
<br>
';