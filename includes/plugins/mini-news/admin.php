<?php
	if (isset($_GET['do'])) {
		$n	=	fopen($cms_root.'/conf/mini-news','w');
		fwrite($n,'<?
			$mininews_count		=	'.$_POST['count'].';
			$mininews_length	=	'.$_POST['length'].';
			$mininews_template	=	\''.str_replace("'","\\'",$_POST['template']).'\';
		?>');
		fclose($n);
		
	};
	$MiniNews->update();
	include($cms_root.'/conf/mini-news');
	$print	=	'
		<script type="text/javascript">
			editAreaLoader.init({
				id : "code"
				,syntax: "html"
				,start_highlight: true
				,language: "ru"
				,toolbar:\'fullscreen, |, select_font,|, change_smooth_selection, highlight, reset_highlight, word_wrap\'
				,gecko_spellcheck: false
				,allow_toggle: true
				,font_family:"'.$cms_fontfamily.'"
				,font_size:'.$cms_fontsize.'
				,display:"onload"
				,word_wrap:false
			});
		</script>
		<center>
			<form name="options" method="POST" action="?do=saved&amp;action=plugins&amp;choose=mini-news&amp;rand='.rand(1,60000).'">
				<table border=0 cellpadding=1 cellspacing=0 class="optionstable">
					<tr class="titletable"><td colspan=2>НАСТРОЙКИ ДОПОЛНЕНИЯ МИНИ-НОВОСТЕЙ</td></tr>
					<tr><td>Количество выводимых новостей:</td><td><select name="count">'.$Filtr->progress($mininews_count).'</select></td></tr>
					<tr><td>Если используется команда {TEXT}, то максимальная длина кратких новостей (символы):</td><td><select name="length">'.$Filtr->progress($mininews_length,'pm').'</select></td></tr>
					<tr><td valign="top">
						Оформление:
						<br><font class="desc">
							HTML теги разрешены. В оформлении можно использовать следующие команды:<br><br>
							<b>{LINK}</b> - адрес к полной новости<br>
							<b>{TITLE}</b> - заголовок<br>
							<b>{COMMENTS}</b> - количество комментариев<br>
							<b>{VIEWS}</b> - количество просмотров<br>
							<b>{THEMEPATH}</b> - путь к теме оформления без / на конце<bR>
							<b>{NAME}</b> - имя опубликовавшего новость<br>
							<b>{DATE}</b> - дата и время публикации<br>
							<b>{TEXT}</b> - текст краткой новости, укороченной до выбранного количества символов
						</font>					
					</td><td><textarea rows=10 cols=60 id="code" name="template">'.$mininews_template.'</textarea></td></tr>
					<tr class="sub"><td colspan=2><input type="submit" name="submit" value="Сохранить"></td></tr>
				</table>
			</form>
		</center>
	';
