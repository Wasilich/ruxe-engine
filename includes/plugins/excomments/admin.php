<?php
    /*
        ADMIN FUNCTIONS OF EXTENDED COMMENTS PLUGIN FOR RUXE ENGINE
        Requirements: Ruxe Engine 1.9
        Author: Akhrameyev Denis Viktorovich
        Site: http://ahrameev.ru
    */
    $print = "
        <input type=\"button\" onClick=\"location.href='?action=plugins&amp;choose=excomments&amp;do=create';\" value=\"Создать расширенный раздел\"><br>
    ";
    $ExtendedComments->checkConfig();
	$listMess = array_reverse(file($cms_root."/conf/messages/listmess.dat"));
	$bfg = array_reverse(file($cms_root."/conf/bfg.dat"));
    
    if (isset($_GET['do'])) {
        switch($_GET['do']) {
			case "create":
				$print .= "
					<br><center>
						<form name=\"create\" action=\"?action=plugins&amp;choose=excomments&amp;do=creating\" method=\"post\">
							<table class=\"optionstable\" border=0 cellpadding=1 cellspacing=0>
								<tr class=\"titletable\"><td colspan=2>НОВЫЙ РАСШИРЕННЫЙ РАЗДЕЛ</td></tr>
								<tr><td>Идентификатор:<br><font class=\"desc\">Например, <b>everything</b></font></td><td><input type=\"text\" name=\"id\" value=\"\" size=45></td></tr>
								<tr><td>Новые комментарии сохранять в:</td><td><select name=\"section\">
				";
				foreach($listMess as $line) {
					$pieces = explode("|", $line);
					$print .= "<option value=\"".$pieces[0]."\">Раздел комментариев - ".$pieces[1];
				}
				$print .= "
								</select></td></tr>
								<tr class=\"sub\"><td colspan=2><input type=\"submit\" name=\"submit\" value=\"Создать расширенный раздел\"></td></tr>
							</table>
						</form>
					</center>
				";
				break;
			case "creating":
				$id = $_POST['id'];
				$section = $_POST['section'];
				$ExtendedComments->create($id, array(), $section);
				break;
			case "remove":
				$id = $_GET['id'];
				$ExtendedComments->remove($id);
				break;
			case "options":
				$originalId = $_GET['id'];
				$originalSection = $ExtendedComments->getMessagesSection($originalId);
				$print .= "
					<br><center>
						<form name=\"options\" action=\"?action=plugins&amp;choose=excomments&amp;do=optionsing\" method=\"post\">
							<table class=\"optionstable\" border=0 cellpadding=1 cellspacing=0>
								<tr class=\"titletable\"><td colspan=2>ОПЦИИ РАСШИРЕННОГО РАЗДЕЛА</td></tr>
								<tr><td>Идентификатор:</td><td>
<input type=\"hidden\" name=\"originalId\" value=\"".$originalId."\">								
<input type=\"text\" name=\"newId\" value=\"".$originalId."\" size=45></td></tr>
								<tr><td>Новые комментарии сохранять в:</td><td><select name=\"section\">
				";
				foreach($listMess as $line) {
					$pieces = explode("|", $line);
					$print .= "<option value=\"".$pieces[0]."\"".(($originalSection==$pieces[0]) ? " selected" : "").">Раздел комментариев - ".$pieces[1];
				}
				$print .= "
								</select></td></tr>
								<tr class=\"sub\"><td colspan=2><input type=\"submit\" name=\"submit\" value=\"Сохранить\"></td></tr>
							</table>
						</form>
					</center>
				";
				break;
			case "optionsing":
				$originalId = $_POST['originalId'];
				$newId = $Filtr->clear($_POST['newId']);
				$section = $_POST['section'];
				$list = $ExtendedComments->getIncludes($originalId);
				$ExtendedComments->edit($originalId, $newId, $list, $section);
				break;
			case "deinclude":
				$id = $_GET['id'];
				$type = $_GET['type'];
				$section = $_GET['section'];
				$new = (isset($_GET['new'])) ? $_GET['new'] : "";
				$ExtendedComments->deinclude($id, $section, $new);
				break;
			case "include":
				$res = explode("@", $_POST['res']);
				$id = $_GET['id'];
				$type = $_GET['type'];
				$ExtendedComments->exinclude($id, $res[0], (isset($res[1]) ? $res[1] : ""));
				break;
        }
    }
    $print .= "
        <br><center>
            <table class=\"optionstable\" border=0 cellpadding=1 cellspacing=0>
                <tr class=\"titletable\"><td>ИДЕНТИФИКАТОР</td><td>ПОДКЛЮЧЕНИЯ</td><td>РАЗДЕЛ ДЛЯ НОВЫХ КОММЕНТАРИЕВ</td><td>ДЕЙСТВИЯ</td></tr>
    ";
    $generalList = $ExtendedComments->getList();
    foreach($generalList as $generalListLine) {
        $generalPieces = explode("|", $generalListLine);
        //Формат: id|подключения|основной раздел|
		/*$data = unserialize($pieces[1]);
		//downloads|Загрузки|open|
		//news|Новости|index|
		//12.07.11, 09:19|admin|Поздравляем с установкой|<p><a href="http://engine.ruxesoft.net/humans.txt" target="_blank">Команда разработки</a> Ruxe Engine поздравляет с успешной установкой Ruxe Engine и надеется на то, что вы уделите достаточно времени на <a href="http://engine.ruxesoft.net/documentation/" target="_blank">изучение системы</a> и понимание её смысла.</p>[newlinere]<p>Удачных веб-проектов, работающих под управлением Ruxe Engine [wink].</p>[newlinere]<p>Всю информацию о системе, техническую поддержку, дополнения и многое другое вы найдёте на официальном сайте Ruxe Engine &mdash; <a href="http://engine.ruxesoft.net">engine.ruxesoft.net</a>.</p>|тест,установка|127.0.0.1|pozdravlyaem-s-ustanovkoy|Автоматическое|Tue, 12 Jul 2011 09:19:01|Да|Да|Нет||
		$pieces[1] = "";
		foreach($data as $section) {
			$dat = explode("@", $section);
			if ($dat[0] == "bfg") {
				foreach($bfg as $bf) {
					$b = explode("|", $bf);
					if ($b[0] == $dat[1]) {
						$list = file($cms_root."/conf/".$b[0]."/list.dat");
						foreach($list as $lis) {
							$li = explode("|", $lis);
							if ($li[6] == $dat[2]) {
								$pieces[1] .= $b[1] . " - " . $li[2] . "<br>";
							}
						}
					}
				}
			} else {
				foreach($listMess as $list) {
					$li = explode("|", $list);
					if ($li[0] == $dat[1])
						$pieces[1] .= "Раздел комментариев - " . $li[1] . "<br>"; //Оформить ссылками
				}
			}
		}
		$tmp = $pieces[2];
		foreach($listMess as $list) {
			$li = explode("|", $list);
			if ($li[0] == $tmp)
				$pieces[2] = $li[1];
		}*/
		$data = $ExtendedComments->getIncludes($generalPieces[0]);
		$generalPieces[1] = "";
		foreach($data as $line) {
			$pieces = explode("@", $line);
			if ($pieces[0] == "bfg") {
				$section = "error";
				$new = "error";
				foreach($bfg as $bfgLine) {
					$bfgPieces = explode("|", $bfgLine);
					if ($bfgPieces[0] == $pieces[1]) {
						$section = $bfgPieces[1];
						$list = file($cms_root."/conf/".$pieces[1]."/list.dat");
						$list = array_reverse($list);
						foreach($list as $listLine) {
							$listPieces = explode("|", $listLine);
							if ($listPieces[6] == $pieces[2]) {
								$new = $listPieces[2];
								break;
							}
						}
						break;
					}
				}
				$generalPieces[1] .= "<div style=\"margin: 5px 0px 10px 0px; border-bottom: 1px solid gray;\">".$section." - ".$new." 
							<div style=\"display: inline; float: right;\"><a href=\"?action=plugins&amp;choose=excomments&amp;do=deinclude&amp;id=".$generalPieces[0]."&amp;type=bfg&amp;section=".$pieces[1]."&amp;new=".$pieces[2]."\">Отключить</a></div>
						</div>
				";
			} else {
				$section = "error";
				foreach($listMess as $listMessLine) {
					$listMessPieces = explode("|", $listMessLine);
					if ($listMessPieces[0] == $pieces[1]) {
						$section = $listMessPieces[1];
						break;
					}
				}
				$generalPieces[1] .= "<div style=\"margin: 5px 0px 10px 0px; border-bottom: 1px solid gray;\">Раздел комментариев - ".$section." 
							<div style=\"display: inline; float: right;\"><a href=\"?action=plugins&amp;choose=excomments&amp;do=deinclude&amp;id=".$generalPieces[0]."&amp;type=messages&amp;section=".$pieces[1]."\">Отключить</a></div>
						</div>
						";
			}
		}
		$count = 0;
		$add = "<div style=\"margin: 5px 0px 10px 0px; border-bottom: 1px solid gray;\">
							<form name=\"add1\" action=\"?action=plugins&amp;choose=excomments&amp;do=include&amp;id=".$generalPieces[0]."&amp;type=bfg\" method=\"post\">
								<select name=\"res\">";
		foreach($bfg as $line) {
			$pieces = explode("|", $line);
			$list = file($cms_root."/conf/".$pieces[0]."/list.dat");
			$list = array_reverse($list);
			foreach($list as $listLine) {
				$listPieces = explode("|", $listLine);
				if (!in_array("bfg@".$pieces[0]."@".$listPieces[6], $data)) {
					$add .= "
								<option value=\"".$pieces[0]."@".$listPieces[6]."\">".$pieces[1]." - ".$listPieces[2];
					$count++;
				}
			}
		}
		$add .= "</select>
								<div style=\"display: inline; float: right;\">".(($count>0) ? "<input type=\"submit\" name=\"submit\" value=\"Подключить\">" : "")."</div>
							</form>
							</div>";
		$generalPieces[1] .= (($count>0) ? $add : "");
		$add = "
							<div style=\"margin: 5px 0px 10px 0px; border-bottom: 1px solid gray;\">
								<form name=\"add2\" action=\"?action=plugins&amp;choose=excomments&amp;do=include&amp;id=".$generalPieces[0]."&amp;type=messages\" method=\"post\">
									<select name=\"res\">
									";
		$count = 0;
		foreach($listMess as $line) {
			$pieces = explode("|", $line);
			if (!in_array("messages@".$pieces[0], $data)) {
				$add .= "
						<option value=\"".$pieces[0]."\">Раздел комментариев - ".$pieces[1];	
				$count++;
			}
		}
		$add .= "
									</select>
									<div style=\"display: inline; float: right;\">".(($count>0) ? "<input type=\"submit\" name=\"submit\" value=\"Подключить\">" : "")."</div>
								</form>
							</div>
		";
		$generalPieces[1] .= (($count>0) ? $add : "");
				
        $print .= "
                <tr><td>".$generalPieces[0]."</td>
					<td>".$generalPieces[1]."</td>
					<td>".$generalPieces[2]."</td>
					<td>
						<a href=\"?action=plugins&amp;choose=excomments&amp;do=options&amp;id=".$generalPieces[0]."\">Настройки</a>
						<br><br><a href=\"#\" onClick=\"if (checkhead()) location.href='?action=plugins&amp;choose=excomments&amp;do=remove&amp;id=".$generalPieces[0]."';\">Удалить</a></td>
				</tr>
        ";
    }
    $print .= "         
            </table>
        </center><br>
        
        <center>
            <table class=\"optionstable\" border=0 cellpadding=1 cellspacing=0>
                <tr class=\"titletable\"><td colspan=2>СПРАВКА</td></tr>
                <tr><td colspan=2>На странице, где необходимо вывести собранные комментарии, используете команду &lt;?php here_excomments(\"<b>ID</b>\"); ?&gt;, где <b>ID</b> – идентификатор расширенного раздела.</td></tr>
            </table>
        </center>
    ";
