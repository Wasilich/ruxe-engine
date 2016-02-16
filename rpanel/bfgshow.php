<?php

/*
 * Ruxe Engine - Понятная CMS для людей
 * http://ruxe-engine.ru
 *
 * Это произведение доступно по Open Source лицензии
 * Creative Commons «Attribution-ShareAlike» («Атрибуция — На тех же
 * условиях») 4.0 Всемирная (CC BY-SA 4.0).
 *
 * Разработчики:
 * Ахрамеев Денис Викторович (http://ahrameev.ru) - Автор, программирование
 * Александр Wasilich Плотников (http://webdesign.ru.net/) - Темы оформления
 * Игорь Dr1D - Логотип, дизайн админ-центра
 * Олег Прохоров (http://ruxe-engine.ru/old/viewprofile/Tanatos) - Контроль качества, документация
 *
 */

  	include("check2.php");
  	$editarea = 'onload';
  
  	if ($cms_editarea==0)
  		$editarea = 'later';

  	$type = $Filtr->clear($_GET['type']);
  	$GlobalUsers->access(4,$type);

	$br = "checked";
	$brplus = "checked";
	if (isset($_COOKIE['addbr']))
	{
		if ($_COOKIE['addbr']=='no')
		{
			$br = "";
		};
		
		if ($_COOKIE['addbrplus']=='no')
		{
			$brplus = "";
		};
	};

  	$bfglist = file("../conf/bfg.dat");
  	if (count($bfglist)==0)
  		die("Error.73. BFG empty");
  	$typed = "";
  	foreach ($bfglist as $bfg)
  	{
     		$b = explode("|",$bfg);
     		if ($b[0]==$Filtr->tolower($type)) $typed = $b[1];
  	};

  	$list = file("../conf/".$type."/list.dat");
  	$start = '
		<h2>'.$typed.'</h2>
			<font class="desc">Работа с Новостным разделом</font><br><br>
	';
  	$menu = '<input type="button" onClick="location.href=\'?action=bfgshow&amp;go=new&amp;type='.$type.'\';" value="Написать новость"> 
  			<input type="button" onClick="location.href=\'?action=bfg\';" value="Другие новостные разделы"><br><br>';
  	if (isset($_GET['go']))
  	{
			$go = $_GET['go'];
			$smileslist1 = '';
            		$smileslist2 = '';
			//список меток
			if (!file_exists($cms_root.'/conf/cache/tags_'.$type))
				$GlobalCache->tags($type);
			if (file_exists($cms_root.'/conf/cache/tags_'.$type))
			{
				$cachetags	=	file($cms_root.'/conf/cache/tags_'.$type);
				$tagsarray	=	unserialize($cachetags[0]);
				$tagsarray	=	$Filtr->utf8_casesort($tagsarray);
				$tagslist	=	'';
				foreach ($tagsarray as $ta)
				{
					$tagslist.='<option value="'.$ta.'">'.$ta;
				};	
			}
			else
				$tagslist	=	'';
			//
            		$smiles      = file($cms_root."/conf/smiles.dat");
            		$i = 0;
            		foreach ($smiles as $smile)
            		{
                        		$smile = str_replace("\r\n","",$smile);
                        		if ($smile!="")
                        		{
						
                                		$smileslist1 .= '<img src="'.$cms_site.'/smiles/'.$smile.'.gif" border=0 alt="'.$smile.'" onClick="editAreaLoader.insertTags(\'short\', \'['.$smile.']\', \'\'); document.getElementById(\'smiles1\').style.display=\'none\';"> &nbsp;';
                                		$smileslist2 .= '<img src="'.$cms_site.'/smiles/'.$smile.'.gif" border=0 alt="'.$smile.'" onClick="editAreaLoader.insertTags(\'full\', \'['.$smile.']\', \'\'); document.getElementById(\'smiles2\').style.display=\'none\';"> &nbsp;';
                        		};
                        
                        		$i++;
            		};
		if ($cms_visual==1)
		{
			if ($cms_showbfghints==1)
			{
				$ADD2		=	'<font class="desc"><br><a href="?action=bfgcommands" target="_blank" class="desc">Просмотреть специальные команды</a>. Вы можете отключить визуальный редактор в <a href="?action=general#editor" class="desc" target="_blank">Настройках</a>.</font>';
				$ADD3		=	'<font class="desc"><br>Краткая запись <b>не добавляется</b> к началу полной записи.</font>';
				$ADD4		=	'<br><font class="desc">Если полная запись пуста, то она будет скопирована из краткой записи.</font>';
				$ADD1		=	'';
			}
			else
			{
				$ADD2		=	'<font class="desc"><br><a href="?action=bfgcommands" target="_blank" class="desc">Просмотреть специальные команды</a>';
				$ADD3		=	'';
				$ADD4		=	'';
				$ADD1		=	'';
			};
			$BUTTONS1	=	'';
			$BUTTONS2	=	'';
			$BRS		=	'
							<input type="hidden" name="br" value="no">
							<input type="hidden" name="brplus" value="no">
							<input type="hidden" name="pq" value="no">
							';
			$SCRIPTS	=	'
					<script type="text/javascript">
						tinyMCE.init({
							mode : "textareas",
							theme : "modern",
							width: "100%",
							plugins: [
								 "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
								 "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
								 "save table contextmenu directionality emoticons template paste textcolor"
							   ],
							   content_css: "css/content.css",
							   toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons"
						});
					</script>
			';
		}
		else
		{
			if ($cms_showbfghints==1)
			{
				$ADD2		=	'';
				$ADD3		=	'<font class="desc"><br>Краткая запись <b>не добавляется</b> к началу полной записи.</font>';
				$ADD4		=	'<br><font class="desc">Если полная запись пуста, то она будет скопирована из краткой записи.</font>';
				$ADD1		=	' (HTML-теги разрешены)';
			}
			else
			{
				$ADD2		=	'';
				$ADD3		=	'';
				$ADD4		=	'';
				$ADD1		=	'';
			};
				$BUTTONS1	=	'<input id="smiles4" type="button" onClick="if (document.getElementById(\'smiles1\').style.display==\'none\') { document.getElementById(\'smiles1\').style.display=\'block\'; } else { document.getElementById(\'smiles1\').style.display=\'none\'; };" value="Смайлы">
                          <table bgcolor="white" class="smilestable" cellpadding=1 cellspacing=0 id="smiles1" style="position:absolute;display:none;">
      				<tr><td width=500 align="center">
       					'.$smileslist1.'
      				</td></tr>
     			  </table>     			  
                          <input type="button" value="Ж" style="font-weight:bold" onClick="editAreaLoader.insertTags(\'short\', \'<b>\', \'</b>\');">
                          <input type="button" value="К" style="font-style:italic" onClick="editAreaLoader.insertTags(\'short\', \'<i>\', \'</i>\');">
                          <input type="button" value="Ч" style="text-decoration:underline" onClick="editAreaLoader.insertTags(\'short\', \'<u>\', \'</u>\');">
                          <input type="button" value="Ссылка" onClick="editAreaLoader.insertTags(\'short\', \'<a href=&quot;&quot; target=&quot;_blank&quot;>\', \'</a>\');">
                          <input type="button" value="Изображение" onClick="editAreaLoader.insertTags(\'short\', \'<img src=&quot;\', \'&quot; border=0 alt=&quot;&quot;>\');">
                          <input type="button" value="Спойлер" onClick="editAreaLoader.insertTags(\'short\', \'[spoiler=Заголовок спойлера]\', \'[/spoiler]\');">
                          <input type="button" value="Цитата" onClick="editAreaLoader.insertTags(\'short\', \'[quote]\', \'[/quote]\');">
                          <input type="button" value="Скрытый текст" onClick="editAreaLoader.insertTags(\'short\', \'[hide]\', \'[/hide]\');">
                          <br><input type="button" value="Счётчик загрузок" onClick="editAreaLoader.insertTags(\'short\', \'[show_downloads=\', \']\');">
                          <input type="button" value="Адрес сайта" onClick="editAreaLoader.insertTags(\'short\', \'[urlsite]\', \'\');">
                          <input type="button" value="Путь до темы оформления" onClick="editAreaLoader.insertTags(\'short\', \'[themepath]\', \'\');">
                          <input type="button" value="HTML код как есть" onClick="editAreaLoader.insertTags(\'short\', \'[code]\', \'[/code]\');">
		
                          <br>';
				$BUTTONS2	=	'<input id="smiles5" type="button" onClick="if (document.getElementById(\'smiles2\').style.display==\'none\') { document.getElementById(\'smiles2\').style.display=\'block\'; } else { document.getElementById(\'smiles2\').style.display=\'none\'; };" value="Смайлы">
                          <table bgcolor="white" class="smilestable" cellpadding=1 cellspacing=0 id="smiles2" style="position:absolute;display:none;">
      				<tr><td width=500 align="center">
       					'.$smileslist2.'
      				</td></tr>
     			  </table>     			  
                          <input type="button" value="Ж" style="font-weight:bold" onClick="editAreaLoader.insertTags(\'full\', \'<b>\', \'</b>\');">
                          <input type="button" value="К" style="font-style:italic" onClick="editAreaLoader.insertTags(\'full\', \'<i>\', \'</i>\');">
                          <input type="button" value="Ч" style="text-decoration:underline" onClick="editAreaLoader.insertTags(\'full\', \'<u>\', \'</u>\');">
                          <input type="button" value="Ссылка" onClick="editAreaLoader.insertTags(\'full\', \'<a href=&quot;&quot; target=&quot;_blank&quot;>\', \'</a>\');">
                          <input type="button" value="Изображение" onClick="editAreaLoader.insertTags(\'full\', \'<img src=&quot;\', \'&quot; border=0 alt=&quot;&quot;>\');">
                          <input type="button" value="Спойлер" onClick="editAreaLoader.insertTags(\'full\', \'[spoiler=Заголовок спойлера]\', \'[/spoiler]\');">
                          <input type="button" value="Цитата" onClick="editAreaLoader.insertTags(\'full\', \'[quote]\', \'[/quote]\');">
                          <input type="button" value="Скрытый текст" onClick="editAreaLoader.insertTags(\'full\', \'[hide]\', \'[/hide]\');">
                          <br><input type="button" value="Счётчик загрузок" onClick="editAreaLoader.insertTags(\'full\', \'[show_downloads=\', \']\');">
                          <input type="button" value="Адрес сайта" onClick="editAreaLoader.insertTags(\'full\', \'[urlsite]\', \'\');">
                          <input type="button" value="Путь до темы оформления" onClick="editAreaLoader.insertTags(\'full\', \'[themepath]\', \'\');">
                          <input type="button" value="HTML код как есть" onClick="editAreaLoader.insertTags(\'full\', \'[code]\', \'[/code]\');">
                          <br>';
				$BRS		=	'
							<input type="checkbox" '.$br.' name="br" value="yes"> Заменять перенос строки в краткой записи на &lt;br&gt;<br>
							<input type="checkbox" '.$brplus.' name="brplus" value="yes"> Заменять перенос строки в полной записи на &lt;br&gt;<br>
							<input type="checkbox" name="pq" value="yes"> Заменять обычные кавычки (") на « »<br>
							';
				$editarea	=	($cms_editarea==1)?'onload':'later';
				$wp		=	($cms_editareawp==1)?'true':'false';
				$SCRIPTS	=	'<script type="text/javascript">
								editAreaLoader.init({
									id : "short"
									,syntax: "html"
									,start_highlight: true
									,language: "ru"
									,toolbar:"fullscreen, |, select_font,|, change_smooth_selection, highlight, reset_highlight, word_wrap"
									,gecko_spellcheck: true
									,allow_toggle: true
									,font_family:"'.$cms_fontfamily.'"
									,font_size:'.$cms_fontsize.'
									,display:"'.$editarea.'"
									,word_wrap:'.$wp.'
								});
								editAreaLoader.init({
									id : "full"
									,syntax: "html"
									,start_highlight: true
									,language: "ru"
									,toolbar:"fullscreen, |, select_font,|, change_smooth_selection, highlight, reset_highlight, word_wrap"
									,gecko_spellcheck: true
									,allow_toggle: true
									,font_family:"'.$cms_fontfamily.'"
									,font_size:'.$cms_fontsize.'
									,display:"'.$editarea.'"
									,word_wrap:'.$wp.'
								});
							</script>';
		};
        	if ($go == "new")
        	{
            		$fp = file("../conf/".$type."/last_category.dat");
            		if (!count($fp))
            			$fp[0]="";
            		$listcategory = "";
            		$lc = "";
            		$checked = 0;
            		foreach ($list as $l)
            		{
                		$s = explode("|",$l);
                		$founded = false;
                		$p = explode("|",$lc);
                		foreach ($p as $r)
                		{
                    			if ($r == $s[7]) $founded = true;
                		};
                		if (!$founded)
                		{
                   			if ($checked == (count($list)-1))
                   			{
                    	 			$listcategory .= "<option value=\"".$s[7]."\" selected>".$s[7]."
                    	 			";
                   			}
                   			else
                   			{
                     				$listcategory .= "<option value=\"".$s[7]."\">".$s[7]."
						";
                   			};
                   			$lc.=$s[7]."|";
                		}
                		else
                		{
                   			if ($checked == (count($list)-1))
                   			{
                     				$listcategory = str_replace("<option value=\"".$s[7]."\">".$s[7]."
						","<option value=\"".$s[7]."\" selected>".$s[7]."
						",$listcategory);
                   			}
                   			else
                   			{
                     				$listcategory = str_replace("<option value=\"".$s[7]."\" selected>".$s[7]."
						","<option value=\"".$s[7]."\">".$s[7]."
						",$listcategory);
                   			};
                		};
                		$checked++;
            		};
            		if ($listcategory == "") 
            			$listcategory = "<option value=\"Без категории\" selected>Без категории
													";

            		
			$tmp	=	$GlobalUsers->getrules($login);
			if ($tmp['bfg_public']==true)
				$POST_PUBLIC='CHECKED';
			else
				$POST_PUBLIC='DISABLED="TRUE"';
            		$ar = array("{TITLE}","{PATH}","{LASTCATEGORY}","{KEYS}","{TEXT}","{TEXTPLUS}","{SUBMIT}","{HIDDENS}","{TITLETABLE}","{DESCRIPTION}","{POST_PUBLIC}","{THEMEPATH}","{COMMENTS_}","{LISTCATEGORY}","{TEGS}","{UPPED}","{LINK}","{SMILESLIST1}","{SMILESLIST2}","{FONTFAMILY}","{FONTSIZE}","{BR1}","{BR2}","{BRPLUS1}","{BRPLUS2}","{EDITAREA}","{WP}","{BR}","{BRPLUS}","{SCRIPTS}","{ADD1}","{BUTTONS1}","{BUTTONS2}","{BRS}","{ADD2}","{ADD3}","{ADD4}","{TAGSLIST}","{ADD5}");
			
            		$br = array("","saver.php?saverdo=bfgaddrecord",$fp[0],"","","","Сохранить","<input type=\"hidden\" name=\"type\" value=\"".$type."\">","Новая новость","",$POST_PUBLIC,$cms_site."/themes/".$cms_theme,"CHECKED",$listcategory,"","","http://",$smileslist1,$smileslist2,$cms_fontfamily,$cms_fontsize,'','','','',$editarea,($cms_editareawp==1) ? 'true' : 'false',$br,$brplus,$SCRIPTS,$ADD1,$BUTTONS1,$BUTTONS2,$BRS,$ADD2,$ADD3,$ADD4,$tagslist,"");
            		$menu = $GlobalTemplate->template($ar,$br,"./theme/addnew.tpl");
        	}
        	else if ($go == "edit")
        	{
            		$newss = $_GET['newss'];
            		$lists = $_GET['lists'];
            		$fp = file("../conf/".$type."/".$newss.".dat");
            		$pie = explode("|",$list[$lists]);
           		$fpp = explode("|",$fp[0]);
            		$listcategory = "";
            		$lc = "";
            		foreach ($list as $l)
            		{
                		$s = explode("|",$l);
                		$founded = false;
                		$p = explode("|",$lc);
                		foreach ($p as $r)
                		{
                    			if ($r == $s[7]) $founded = true;
                		};
                		if (!$founded)
                		{
                  	 		if ($s[7] == $pie[7])
                   			{
                     				$listcategory .= "<option value=\"".$Filtr->clear($s[7])."\" selected>".$Filtr->clear($s[7])."
						";
                   			}
                   			else
                   			{
                     				$listcategory .= "<option value=\"".$Filtr->clear($s[7])."\">".$Filtr->clear($s[7])."
						";
                   			};
                   			$lc.=$s[7]."|";
                		}
                		else
                		{
                   			if ($s[7] == $pie[7])
                   			{
                     				$listcategory = str_replace("<option value=\"".$Filtr->clear($s[7])."\">".$Filtr->clear($s[7])."
								","<option value=\"".$Filtr->clear($s[7])."\" selected>".$Filtr->clear($s[7])."
						",$listcategory);
                   			}
                   			else
                   			{
                     				$listcategory = str_replace("<option value=\"".$Filtr->clear($s[7])."\" selected>".$Filtr->clear($s[7])."
						","<option value=\"".$Filtr->clear($s[7])."\">".$Filtr->clear($s[7])."
						",$listcategory);
                   			};
                		};
            		};
            
            		$smileslist1 = '';
            		$smileslist2 = '';
            		$smiles      = file($cms_root."/conf/smiles.dat");
            		$i = 0;
            		foreach ($smiles as $smile)
            		{
                        	$smile = str_replace("\r\n","",$smile);
                        	if ($smile!="")
                        	{
                                	$smileslist1 .= '<img src="'.$cms_site.'/smiles/'.$smile.'.gif" border=0 alt="'.$smile.'" onClick="editAreaLoader.insertTags(\'short\', \'['.$smile.']\', \'\'); document.getElementById(\'smiles1\').style.display=\'none\';"> &nbsp;';
                                	$smileslist2 .= '<img src="'.$cms_site.'/smiles/'.$smile.'.gif" border=0 alt="'.$smile.'" onClick="editAreaLoader.insertTags(\'full\', \'['.$smile.']\', \'\'); document.getElementById(\'smiles2\').style.display=\'none\';"> &nbsp;';
                        	};
                        
                        	$i++;
            		};
            
            		$ar = array("{TITLE}","{PATH}","{LASTCATEGORY}","{KEYS}","{TEXT}","{TEXTPLUS}","{SUBMIT}","{HIDDENS}","{TITLETABLE}","{DESCRIPTION}","{POST_PUBLIC}","{THEMEPATH}","{COMMENTS_}","{LISTCATEGORY}","{TEGS}","{UPPED}","{LINK}","{SMILESLIST1}","{SMILESLIST2}","{FONTFAMILY}","{FONTSIZE}","{BR1}","{BR2}","{BRPLUS1}","{BRPLUS2}","{EDITAREA}","{WP}","{BR}","{BRPLUS}","{SCRIPTS}","{ADD1}","{BUTTONS1}","{BUTTONS2}","{BRS}","{ADD2}","{ADD3}","{ADD4}","{TAGSLIST}","{ADD5}");
			
            		//$pie[3] = str_replace(array("<br>","[newlinere]","&"),array("","\r\n","&amp;"),$pie[3]);
            		//$fpp[3] = str_replace(array("<br>","[newlinere]","&"),array("","\r\n","&amp;"),$fpp[3]);
			$pie[3] = str_replace(array("[newlinere]","&","[dividinglinere]"),array("\r\n","&amp;","|"),$pie[3]);
            		$fpp[3] = str_replace(array("[newlinere]","&","[dividinglinere]"),array("\r\n","&amp;","|"),$fpp[3]);
            		($pie[9] == "Да") ? $post_public="CHECKED" : $post_public=" ";
            		($pie[10] == "Да") ? $comments_ = "CHECKED" : $comments_ = " ";
            		($pie[11] == "Да") ? $upped = "checked" : $upped = "";
            		if ($pie[12]=="") $pie[12] = "http://";
            		$tmp	=	$GlobalUsers->getrules($login);
			if ($tmp['bfg_public']==true)
				$post_public.='';
			else
				$post_public.=' DISABLED="TRUE"';
            		$br = array($Filtr->clear($pie[2]),"saver.php?saverdo=bfgeditrecord",$pie[7],$fpp[6],$pie[3],$fpp[3],"Сохранить изменения",
            			"<input type=\"hidden\" name=\"list\" value=\"".$lists."\">
            			<input type=\"hidden\" name=\"date\" value=\"".$pie[0]."\">
            			<input type=\"hidden\" name=\"author\" value=\"".$pie[1]."\">
            			<input type=\"hidden\" name=\"fulldate\" value=\"".$pie[8]."\">
            			<input type=\"hidden\" name=\"newss\" value=\"".$newss."\">
            			<input type=\"hidden\" name=\"type\" value=\"".$type."\">
            			","Правка новости",$fpp[7],$post_public,$cms_site."/themes/".$cms_theme,$comments_,$listcategory,str_replace(",",", ",$Filtr->clear($pie[4])),$upped,$pie[12],$smileslist1,$smileslist2,$cms_fontfamily,$cms_fontsize,
            			'','','','',$editarea,($cms_editareawp==1) ? 'true' : 'false',$br,$brplus,$SCRIPTS,$ADD1,$BUTTONS1,$BUTTONS2,$BRS,$ADD2,$ADD3,$ADD4,$tagslist,
				'<INPUT TYPE="checkbox" NAME="updatedate" VALUE="yes"> Установить текущую дату');
            		$menu .= $GlobalTemplate->template($ar,$br,"./theme/addnew.tpl");
        	};
  	};
  	$echooptions=$menu."<center><table class=\"optionstable\" border=0 cellpadding=1 cellspacing=0>
		<tr class=\"titletable\"><td>ЗАПИСИ НОВОСТНОГО РАЗДЕЛА</td></tr>
	";
  	$i = count($list)-1;
  	$list = array_reverse($list);
  	$newslist = array();
  	$newslistupped = array();
  
  	foreach ($list as $news)
  	{
		//1.3.3
       		$new 	= 	explode("|",$news);
      	 	$all 	= 	count(file("../conf/".$type."/".$new[6].".dat"))-1;
		$tmp	=	$GlobalUsers->getrules($login);
       		$new[3] = 	$GlobalTemplate->usebbcodes($new[3],'html');
       		$new[3] = 	$GlobalTemplate -> checkteg($new[3],'[code]','[/code]','html');
		$new[3] = 	preg_replace('|(.*)\[show_downloads=(.*)\](.*)|Uis', "\${1} [Счётчик скачиваний \${2}] \${3}", $new[3]);
		$new[3] = 	str_replace(array("[urlsite]","[themepath]"),array($cms_site,$cms_site."/themes/".$cms_theme),$new[3]);
		
		$tmpresult	=	'
					<tr><td valign="top">
						<a href="'.$Navigation->furl('bfgfull',$type,$new[6]).'" target="_blank" style="font-size:14pt;">'.$Filtr->clear($new[2]).'</a><br>
						<div style="font-size:8pt;">
							Дата: <b>'.$Filtr->fulldate($new[0]).'</b>, Автор: <b>'.$new[1].'</b>, Категория: <b>'.$Filtr->clear($new[7]).'</b>';
		if ($new[11]=='Да')
			$tmpresult.=	' (закреплено)';
		$tmpresult	.=	'		<div style="float:right;">';
		if ($tmp['bfg_public']) {
			if ($new[9]=="Да") {
				$url	=	"saver.php?saverdo=hidenew&amp;type=".$type."&amp;new=".$new[6];
				$caption=	"Снять с публикации";
			} else {
				$url	=	"saver.php?saverdo=shownew&amp;type=".$type."&amp;new=".$new[6];
				$caption=	"<font color=\"red\">Опубликовать</font>";
			};
			$tmpresult.=	'<a href="'.$url.'">'.$caption.'</a> ';
		};
		if ($tmp['comments_edit']) {
			$tmpresult.=	'<a href="?action=messages&amp;from='.$type.'&amp;news='.$new[6].'">Комментарии (';
			if ($new[10]=='Да')
				$tmpresult.=	'разрешены, ';
			else
				$tmpresult.=	'<font color="red">запрещены</font>, ';
			$tmpresult.=	$all.')</a> ';
		}
		$tmpresult	.=	'<a href="?action=bfgshow&amp;go=edit&amp;lists='.$i.'&amp;type='.$type.'&amp;newss='.$new[6].'">Изменить</a> ';		
		if ($tmp['bfg_delete'])
			$tmpresult.=	'<a href="#" onClick="if (checkhead()) location.href=\'saver.php?saverdo=bfgdelrecord&amp;list='.$i.'&amp;type='.$type.'&amp;news='.$new[6].'\';">Удалить</a>';
		$tmpresult	.=	'
							</div>
						</div><br>
						'.$new[3].'<br><br>
						<div style="font-size:8pt;">
							Метки: <b>'.str_replace(',',', ',$new[4]).'</b>';
		if (
			($GlobalUsers->getstatus($login)=='admin')
			and
			(count($bfglist)>1)
		) {
			$tmpresult.=	'		<div style="float:right; margin-top: -8px;">
								<form name="changeplace" action="saver.php?saverdo=changeplace" method="POST">
									Перенести в раздел: <select style="margin: 5px 0 5px 0;" name="share">';
			foreach ($bfglist as $bfgline) {
				$bfgl	=	explode('|',$bfgline);
				//news|Новости сайта|index|
				if ($bfgl[0]!=$type)
					$tmpresult.='<option value="'.$bfgl[0].'">'.$bfgl[1];
			}
			$tmpresult.='					</select>
									<input type="hidden" name="original_title" value="'.$new[6].'">
									<input type="hidden" name="from" value="'.$type.'">
									 <input type="submit" name="submit" value="Выполнить">
								</form>
							</div>
					';
		}
		$tmpresult	.=	'
						</div>
					</td></tr>
					';
            	$i--;
            	if ($new[11]=="Да")
            		$newslistupped[] = $tmpresult;
            	else
            		$newslist[] = $tmpresult;
  	};
  
  	//Поднятые новости в обратном порядке надо запихнуть в общие новости
  	$newslistupped = array_reverse($newslistupped);
  	foreach ($newslistupped as $nlu)
  		array_unshift($newslist,$nlu);
  
  	//Теперь пора навигацией заняться
  
  	if (count($newslist)>$cms_nav_news) 
  		$echooptions.= '<tr><td colspan=2>'.$Navigation->Pager(count($newslist),'',$cms_nav_news,'?action=bfgshow&amp;type='.$type.'&amp;').'</td></tr>';
  
  	$i = count($newslist)-1;
  
  	foreach ($newslist as $new)
  	{
  		if ($Navigation->ShowPage(count($newslist),$i,$cms_nav_news)) $echooptions.=$new;
  		$i--;
  	};
  
  	if (count($newslist)>$cms_nav_news) $echooptions.= '<tr><td colspan=2>'.$Navigation->Pager(count($newslist),'',$cms_nav_news,'?action=bfgshow&amp;type='.$type.'&amp;').'</td></tr>';

  	$echooptions.="</table></center>
			";
  
  	$ar = array("{MENU}","{OPTIONS}");
  	$br = array("",$start.$echooptions);
  	echo $GlobalTemplate->template($ar,$br,"./theme/admincenteroptions.tpl");
