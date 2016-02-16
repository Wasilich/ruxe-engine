<?php
class MiniNews
{
	function update() {
		global $cms_root;
		if (!file_exists($cms_root.'/conf/mini-news')) {
			$nf	=	fopen($cms_root.'/conf/mini-news','w');
			fwrite($nf,'<?
				$mininews_count		=	5;
				$mininews_length	=	150;
				$mininews_template	=	\'<font style="font-size:8pt;">{DATE}:</font><br>
<div style="margin: 0px 0px 9px 15px;"><a href="{LINK}">{TITLE}</a></div>\';
			?>');
			fclose($nf);
			chmod($cms_root.'/conf/mini-news',0777);
		};
	}
	
	function show($type='withouttype') {
		global $cms_root, $Navigation, $cms_site, $cms_theme, $GlobalUsers, $Filtr, $GlobalTemplate;
		//Проверить существование файлов настроек
		$this->update();
		include($cms_root.'/conf/mini-news');
		//Сначала проверить существование новостного раздела
		$bfg	=	file($cms_root.'/conf/bfg.dat');
		$founded=	false;
		foreach ($bfg as $bf) {
			$b	=	explode("|",$bf);
			if ($b[0]==$type)
				$founded	=	true;
		};
		//Показать определённое число новых новостей
		if (!$founded)
			echo 'Идентификатор новостного раздела не найден';
		else {
			$list	=	file($cms_root.'/conf/'.$type.'/list.dat');
			$list	=	array_reverse($list);
			$views	=	file($cms_root.'/conf/'.$type.'/views.dat');
			$i	=	1;
			foreach ($list as $lis) {
				$l	=	explode('|',$lis);
				//9 - публикация Да|Нет
				//0 - дата
				//1 - имя
				//2 - заголовок
				//6 - латинский заголовок
				//10 - разрешены комментарии или нет
				//12 - либо "", либо http://...
				if ($l[9]=='Да') {
					if ($i>$mininews_count)
						break;
					else {
						$ar	=	array('{LINK}','{TITLE}','{COMMENTS}','{VIEWS}','{THEMEPATH}','{NAME}','{DATE}','{TEXT}');
						//Подсчитываем количество просмотров
						$viewscounter	=	0;
						foreach ($views as $view) {
							$v	=	explode('|',$view);
							if ($v[0]==$l[6])
							{
								$viewscounter	=	$v[1];
								break;
							};
						}
						//Подсчитываем количество комментариев
						$full	=	file($cms_root.'/conf/'.$type.'/'.$l[6].'.dat');
						$comments	=	0;
						$z		=	0;
						foreach ($full as $ful) {
							if ($z!=0) {
								//6
								$f	=	explode('|',$ful);
								if ($f[6]=='yes')
									$comments++;
							}
							$z++;
						}
						//Разбираемся с именем
						if ($GlobalUsers->finduser($l[1])!=-1)
							$user	=	'<a href="'.$Navigation->furl('viewprofile',$l[1]).'">'.$l[1].'</a>';
						else
							$user	=	$l[1];
						$br	=	array(
									($l[12]=='') ? $Navigation->furl('bfgfull',$type,$l[6]) : $Navigation->furl('bfglink',$type,$l[6]), //{LINK}
									$l[2], //{TITLE}
									$comments, //{COMMENTS}
									$viewscounter, //{VIEWS}
									$cms_site.'/themes/'.$cms_theme, //{THEMEPATH}
									$user, //{NAME}
									$Filtr->fulldate($l[0]), //{DATE}
									$GlobalTemplate->usebbcodes($Filtr->textmax($l[3],$mininews_length,'...'),'html',false,false) //{TEXT}
						);
						echo str_replace($ar,$br,$mininews_template);
						$i++;
					};
				};
			};
		};
	}
};

$MiniNews = new MiniNews();

function here_mininews($type) {
	global $MiniNews;
	$MiniNews->show($type);
}
