<?php

//Главное оформление here_results();
$general = '
<br>
<br>
<center>
        <form name="searching" action="{URL}" method="GET">
              <input name="q" type="text" size=60 value="{Q}"> <input type="submit" name="submit" value="Искать">
        </form>
</center>
<br>
{PRINT}
';

//Оформление маленькой формы поиска (here_shortsearch)
$shortform = '
<center>
	<form name="shortsearch" action="{URL}" method="GET">
		{WITHOUTREWRITE}
		<input name="q" type="text" size=20 value=""><br><br>
		<input type="submit" name="submit" value="Искать">
	</form> 
</center>
';

//Сообщение, выводимое при 0 результатах
$notfound = '<center><b>Ничего не найдено. Попробуйте задать свой запрос иначе.</b></center>';

//Оформление критических сообщений
$critical_template = '<center><b>{MESSAGE}</b></center><br>';

//Время поиска
$timegen = '<br><font style="font-size:8pt;color:#494949;">На поиск затрачено {TIME} секунд</font><br><br>';

//Оформление результатов
$results_template = '
  <a href="{URL}" style="font-size:12pt;">{CAPTION}</a>
  <div style="margin: 0px 5px 0px 5px;">
       <font style="font-size:10pt;">{RESULT}</font>
  </div>
  <font style="font-size:8pt;color:#494949;"><a href="{URL}" style="font-size:8pt;color:#494949;">{URL}</a> | Индекс релевантности: <b>{REL}</b></font>
  <br><br>
';

//Сообщение о том, что использовано больше допустимого количества слов
$much_words = '<center><b>Слишком много слов</b></center>';

//Сообщение, выводимое при запросе до 4 символов
$short_q = '<center><b>Ваш запрос должен быть больше 3-х символов</b></center>';

$needupdate = '<center><b>Для работы поиска, необходимо обновить поисковый индекс</b></center>';
