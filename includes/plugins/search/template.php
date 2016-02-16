<?php

//Главное оформление here_results();
$general = '
        <form name="searching" class="group-60-offset-20" action="{URL}" method="GET">
              <input name="q" type="text" class="block-100 search" value="{Q}"><br><input type="submit" name="submit" class="btn tf-btn btn-default" value="Искать">
        </form>
<br>
{PRINT}
';

//Оформление маленькой формы поиска (here_shortsearch)
$shortform = '
	<form name="shortsearch" class="group-60-offset-20" action="{URL}" method="GET">
		{WITHOUTREWRITE}
		<input name="q" type="text" class="block-100 search" value="" placeholder="Введите запрос и нажите Enter">
	</form> 
';

//Сообщение, выводимое при 0 результатах
$notfound = '<div class="text-center"><span class="em-air"><b>Ничего не найдено. Попробуйте задать свой запрос иначе.</b></span></div>';

//Оформление критических сообщений
$critical_template = '<div class="text-center"><span class="em-air"><b>{MESSAGE}</b></span></div><br>';

//Время поиска
$timegen = '<br><span class="info">На поиск затрачено {TIME} секунд</span><br><br>';

//Оформление результатов
$results_template = '
    <a href="{URL}"><h4>{CAPTION}</h4></a>
	<hr>
    <p>{RESULT}</p>
    <span class="info"><a href="{URL}">{URL}</a> | Индекс релевантности: <b>{REL}</b></span>
    <br><br>
';

//Сообщение о том, что использовано больше допустимого количества слов
$much_words = '<div class="text-center"><span class="em-air"><b>Слишком много слов</b></span></div>';

//Сообщение, выводимое при запросе до 4 символов
$short_q = '<div class="text-center"><span class="em-air"><b>Ваш запрос должен быть больше 3-х символов</b></span></div>';

$needupdate = '<div class="text-center"><span class="em-air"><b>Для работы поиска, необходимо обновить поисковый индекс</b></span></div>';
