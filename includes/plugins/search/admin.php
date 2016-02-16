<?php
	$date 		= "Никогда";
	$pages_checked 	= 'checked';
	$news_checked 	= 'checked';
	$maxtime 	= '0.2';
	$length 	= '150';
	$npage 		= 'index';
	$add3 		= '';
	$add4 		= '';
	$critical 	= 'Поиск не завершён. Нагрузка на сервер поиском превышает допустимый предел. Попробуйте переформулировать свой запрос.';
	$maxresults 	= '40';
	$maxwords 	= '4';
	$print 		= '';
	$autoupdate	= 'checked';
	if (file_exists($cms_root."/conf/search/config"))
		include($cms_root."/conf/search/config");

	if (isset($_GET['do'])) {
		if (isset($_POST['update']))
			$date 		= date("d.m.y, H:i");
		$pages_checked 	= (isset($_POST['pages'])) ? 'checked' : ''; 
		$news_checked 	= (isset($_POST['news'])) ? 'checked' : '';
		$maxtime 	= $Filtr->clear($_POST['maxtime']);
		$length 	= (int)$_POST['length'];
		$npage 		= $_POST['npage'];
		$critical 	= $Filtr->clear(str_replace("'","",$_POST['critical']));
		$maxresults 	= (int)$_POST['maxresults'];
		$maxwords 	= (int)$_POST['maxwords'];
		$autoupdate	= (isset($_POST['autoupdate'])) ? 'checked' : '';
		if (!is_dir($cms_root."/conf/search/")) {
			mkdir($cms_root."/conf/search/");
			chmod($cms_root."/conf/search/",0777);
		}
		$config 	= fopen($cms_root."/conf/search/config","w");
		fwrite($config,"<?php
				\$date = '".$date."';
				\$npage = '".$npage."';
				\$pages_checked = '".$pages_checked."';
				\$news_checked = '".$news_checked."';
				\$maxtime = '".$maxtime."';
				\$length = ".$length.";
				\$critical = '".$critical."';
				\$maxresults = ".$maxresults.";
				\$maxwords = ".$maxwords.";  
				\$autoupdate = '".$autoupdate."';");
		fclose($config);
		if (isset($_POST['update'])) {
                     $SearchPlugin->update('manual');
                     $add4 = '<font color="green"><b> (Обновлён)</b></font>';
		}
		$add3   = '<font color="green"><b> (Сохранено)</b></font>';
	}
   
	$pages 	= '';
	$p     	= file($cms_root."/conf/pages/config");
	foreach ($p as $a) {
		$onepage = explode("|",$a);
		if ($onepage[0]=='index') $onepage[0] = '';
		if ($onepage[4]==$npage) 
			$pages .= '<option value="'.$onepage[4].'" selected> '.$cms_site.'/'.$onepage[0];
		else 
			$pages .= '<option value="'.$onepage[4].'"> '.$cms_site.'/'.$onepage[0];          
	}
	if ($date!='Никогда')
		$date	= $Filtr->fulldate($date);
	$print .= '<center>
       <form name="editsearch" method="POST" action="?action=plugins&amp;choose=search&amp;do=save">
         <table class="optionstable" border=0 cellpadding=1 cellspacing=0>
            <tr class="titletable"><td>ПОИСКОВЫЙ ИНДЕКС</td><td colspan=2>НАСТРОЙКА</td></tr>
            <tr><td rowspan=6>
                    Дата последнего обновления индекса:
                    <br>&nbsp;&nbsp;&nbsp;<font color="green"><b>'.$date.'</b></font><br>
                    <br>
                    <input type="checkbox" name="update" value="true" checked> <b>Обновить индекс</b>'.$add4.'<br>
		    <input type="checkbox" name="autoupdate" value="true" '.$autoupdate.'> <b>Автообновление</b><br><br>
                    Включать в индекс:
                    <br>
                    <input type="checkbox" name="pages" value="true" '.$pages_checked.'> Страницы<br>
                    <input type="checkbox" name="news" value="true" '.$news_checked.'> Новостные разделы<br>
            </td>
            <td>
                    Страница для вывода результатов:<br>
                    <font class="desc">На этой странице должна использоваться команда &lt;? here_results(); ?&gt;</font>
            </td><td>
                    <select name="npage">
                     '.$pages.'
                    </select>
            </td></tr> 
            <tr><td>
                    Максимальное время генерации (секунд):<br>
                    <font class="desc">Например, 0.2</font></td>
            <td>
                    <input type="text" name="maxtime" value="'.$maxtime.'" size=50>
            </td></tr>
            <tr><td>
                    Количество символов среза:
            </td><td>
                    <input type="text" name="length" value="'.$length.'" size=50>
            </td></tr>
            <tr><td>
                    Сообщение, выводимое при превышении максимального времени генерации:
            </td><td>
                    <input type="text" name="critical" value="'.$critical.'" size=50>
            </td></tr>
            <tr><td>
                    Максимальное количество результатов:
            </td><td>
                    <input type="text" name="maxresults" value="'.$maxresults.'" size=50>
            </td></tr>
            <tr><td>
                    Максимально разрешённое количество слов в запросе:
            </td><td>
                   <input type="text" name="maxwords" value="'.$maxwords.'" size=50>
            </td></tr>
            <tr class="sub"><td colspan=3><input type="submit" name="submit" value="Сохранить изменения">'.$add3.'</td></tr>
         </table>
       </form>
   </center>';
