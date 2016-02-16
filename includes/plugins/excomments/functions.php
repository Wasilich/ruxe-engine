<?php
	/*
		CORE OF EXTENDED COMMENTS PLUGIN FOR RUXE ENGINE
		Requirements: Ruxe Engine 1.9
		Author: Akhrameyev Denis Viktorovich
		Site: http://ahrameev.ru
	*/

	define("CHECK_FILE_EXISTS", true);

	class ExtendedComments {
		private $settingsPath = "";
		
		function __construct($settingsPath) {
			$this->settingsPath = $settingsPath;
		}

		function cmp($a, $b) {
			$piecesIt = explode("|", $a);
			//23.08.11, 07:18
			$tmp = explode(",", $piecesIt[0]);
			$dateIt = explode(".", $tmp[0]);
			$timeIt = explode(":", $tmp[1]);
			$piecesLast = explode("|", $b);
			$tmp2 = explode(",", $piecesLast[0]);
			$dateLast = explode(".", $tmp2[0]);
			$timeLast = explode(":", $tmp2[1]);
			//22.08.11

			if ($dateIt[2] > $dateLast[2])
				return 1;
			else if ($dateIt[2] === $dateLast[2]) {
				if ($dateIt[1] > $dateLast[1])
					return 1;
				else if ($dateIt[1] === $dateLast[1]) {
					if ($dateIt[0] > $dateLast[0])
						return 1;
					else if ($dateIt[0] === $dateLast[0]) {
						//Проверить время
						if ($timeIt[0] > $timeLast[0]) 
							return 1;
						else if ($timeIt[0] === $timeLast[0]) {
							if ($timeIt[1] > $timeLast[1])
								return 1;
							else if ($timeIt[1] === $timeLast[1])
								return 0;
							else
								return -1;
						} else
							return -1;
					} else
						return -1;
				} else
					return -1;
			} else
				return -1;
		}
		
		function checkConfig() {
			global $cms_root, $FileManager;
			$baseDir = $this->settingsPath;
			if (!is_dir($baseDir)) {
				$FileManager->makedir($baseDir);
				@chmod($baseDir, 0777);
			}
			if (!file_exists($baseDir.".htaccess")) {
				$n = fopen($baseDir.".htaccess", "w");
				fwrite($n, "deny from all");
				fclose($n);
			}
			if (!file_exists($baseDir."config.dat")) {
				$n = fopen($baseDir."config.dat", "w");
				fwrite($n, "");
				fclose($n);
				@chmod($baseDir."config.dat", 0777);
			}
			if (!is_writeable($baseDir."config.dat")) {
				die("don't have permissions to write in config.dat");
			}
			
			//Восстановить конфигурацию, если имеются битые подключения
			$original = file($this->settingsPath."config.dat");
			$new = fopen($this->settingsPath."config.dat", "w");
			foreach($original as $line) {
				$pieces = explode("|", $line);
				$data = unserialize($pieces[1]);
				$newData = array();
				for ($i = 0; $i < count($data); $i++) {
					$dataPieces = explode("@", $data[$i]);
					if (file_exists(($dataPieces[0] == "bfg") 
							? $cms_root."/conf/".$dataPieces[1]."/".$dataPieces[2].".dat" 
							: $cms_root."/conf/messages/mess_".$dataPieces[1].".dat")) {
						$newData[] = $data[$i];
					}
				}
				$pieces[1] = serialize($newData);
				fwrite($new, implode("|", $pieces));
			}
			fclose($new);
		}
		
		function getList() {
			$f = file($this->settingsPath."config.dat");
			$r = array();
			foreach($f as $line)
				$r[] = $line;
			return $r;
		}
		
		function getIncludes($id) {
			$config = file($this->settingsPath."config.dat");
			foreach($config as $line) {
				$pieces = explode("|", $line);
				if ($pieces[0] == $id) {
					return unserialize($pieces[1]);
				}
			}
			return false;
		}
		
		function getMessagesSection($id) {
			$config = file($this->settingsPath."config.dat");
			foreach($config as $line) {
				$pieces = explode("|", $line);
				if ($pieces[0] == $id)
					return $pieces[2];
			}
			return false;
		}
		
		function exinclude($id, $section, $new) {
			$list = $this->getIncludes($id);
			$messSection = $this->getMessagesSection($id);
			$line = ($new!="") ? "bfg@".$section."@".$new : "messages@".$section;
			$list[] = $line;
			return $this->edit($id, $id, $list, $messSection);
		}
		
		function deinclude($id, $section, $new) {
			$list = $this->getIncludes($id);
			$search = ($new != "") ? "bfg@".$section."@".$new : "messages@".$section;
			$newList = array();
			foreach($list as $line) {
				if ($line != $search)
					$newList[] = $line;
			}
			$messSection = $this->getMessagesSection($id);
			return $this->edit($id, $id, $newList, $messSection);
		}
		
		function updateByBFG($section, $title) {
			return $this->updateWithParams($section, $title);
		}
		
		function updateByMessages($section) {
			return $this->updateWithParams($section);
		}
		
		function updateWithParams($param1, $param2 = "") {
			//test|a:2:{i:0;s:34:"bfg@news@pozdravlyaem-s-ustanovkoy";i:1;s:18:"messages@downloads";}|downloads|
			$config = file($this->settingsPath.".config.dat");
			$toUpdate = array();
			foreach($config as $line) {
				$pieces = explode("|", $line);
				$data = unserialize($pieces[1]);
				foreach($data as $downLine) {
					$downPieces = explode("@", $downLine);
					if ($param2 == "") {
						if ( 
								($downPieces[0] == "messages")
								&&
								($downPieces[1] == $param1)
								&&
								(!in_array($pieces[0], $toUpdate))
							) {
							$toUpdate[] = $pieces[0];
						}
					} else {
						if ( 
								($downPieces[0] == "bfg")
								&&
								($downPieces[1] == $param1)
								&&
								($downPieces[2] == $param2)
								&&
								(!in_array($pieces[0], $toUpdate))
							) {
							$toUpdate[] = $pieces[0];
						}
					}
				}
			}
			foreach($toUpdate as $id) {
				$this->update($id);
			}
			return true;
		}
		
		function create($id, $list, $messagesSection) {
			if ($this->isExists($id)) {
				return false;
			}
			if (!$this->check($id)) {
				return false;
			}
			$config = fopen($this->settingsPath . "config.dat", "a");
			fputs($config, $id."|".serialize($list)."|".$messagesSection."|\r\n");
			fclose($config);
			$f = fopen($this->settingsPath.$id.".cache", "w");
			fwrite($f, "");
			fclose($f);
			chmod($this->settingsPath.$id.".cache", 0777);
			$this->update($id);
			return true;
		}
		
		function check($id) {
			return preg_match('/^[a-z0-9\-_]+$/', $id);
		}
		
		function isExists($id) {
			$config = file($this->settingsPath."config.dat");
			foreach($config as $line) {
				$pieces = explode("|", $line);
				if ($pieces[0] == $id)
					return true;
			}
			return false;
		}
		
		function remove($id) {
			if (!$this->isExists($id))
				return false;
			$original = file($this->settingsPath."config.dat");
			$new = fopen($this->settingsPath."config.dat", "w");
			foreach($original as $line) {
				$pieces = explode("|", $line);
				if ($pieces[0] == $id) {
					unlink($this->settingsPath.$id.".cache");
				} else
					fwrite($new, $line);
			}
			fclose($new);
			return true;
		}
		
		function edit($lastId, $newId, $newList, $newMessagesSection) {
			if (!$this->isExists($lastId))
				return false;
			$this->remove($lastId);
			return $this->create($newId, $newList, $newMessagesSection);
		}
		
		function update($id, $cached = true) {
			//Сбор тут
			global $cms_root;
			$config = file($this->settingsPath . "config.dat");
			$data = array();
			foreach($config as $line) {
				$pieces = explode("|", $line);
				if ($pieces[0] == $id) {
					$data = unserialize($pieces[1]);
					break;
				}
			}
			$messages = array();
			foreach($data as $line) {
				$pieces = explode("@", $line);
				if ($pieces[0] == "bfg") {
					$fileName = $cms_root."/conf/".$pieces[1]."/".$pieces[2].".dat";
					
					if (!$this->checkExists($fileName)) {
						
					} else {
						$bfg = file($fileName);
						if (count($bfg) > 1) {
							for ($i = 1; $i < count($bfg); $i++) {
								$downPieces = explode("|", $bfg[$i]);
								if ($downPieces[6] != "no")
									$messages[] = $bfg[$i];
							}
						}
					}
				} else {
					$fileName = $cms_root."/conf/messages/mess_".$pieces[1].".dat";
					if (!$this->checkExists($fileName)) {
						
					} else {
						$comments = file($fileName);
						for ($i = 0; $i < count($comments); $i++) {
							$downPieces = explode("|", $comments[$i]);
							if ($downPieces[6] != "no")
								$messages[] = $comments[$i];
						}
					}
				}
			}
			
			//Отсортировать по дате
			usort($messages, array($this, "cmp"));
			$messages = array_reverse($messages);
			
			if (!$cached)
				return $messages;
			
			$cache = fopen($this->settingsPath . $id . ".cache", "w");
			foreach($messages as $message)
				fwrite($cache, $message);
			fclose($cache);
		}
		
		function checkExists($filename) {
			if (CHECK_FILE_EXISTS === true) {
				return file_exists($filename);
			} else
				return true;
		}
		
		function show($id, $cached = true, $messages = array()) {
			global $cms_root, $lcms, $_GET, $cms_nav_comments, $GlobalTemplate,$GlobalComments,$Navigation, $cms_furl, $Filtr;
			$founded = false;

			//Проверить существование id
			$config = file($this->settingsPath . "config.dat");
			$section = "";
			foreach($config as $line) {
				$pieces = explode("|", $line);
				if ($pieces[0] == $id) {
					$founded = true;
					$section = $pieces[2];
					break;
				}
			}

			
			if (!$founded) {
				return str_replace("{ID}", $id, $lcms['error_544']);
			} else {
				//Получить имя
				$name = "";
				//downloads|Загрузки|open|
				$messData = file($cms_root."/conf/messages/listmess.dat");
				foreach($messData as $line) {
					$pieces[0] = explode("|", $line);
					if ($pieces[0] == $id) {
						$name = $pieces[1];
						break;
					}
				}
				
				if ($cached) {
					//Взять из кэша
					$cache = file($this->settingsPath . $id . ".cache");
					foreach($cache as $line)
						$messages[] = $line;
				}

				//Вернуть результат
				$pos = count($messages)-1;
				$echolist = $GlobalComments->show($messages, $pos);
				$ar = array("{COMMENTFORM}", "{PAGES}", "{COMMENTS}");
				$br = array($GlobalTemplate->commentform("new_message", $section, $name, ""), $Navigation->Pager(count($messages),($cms_furl==1) ? '' : '&amp;viewpage='.$Filtr->clear($_GET['viewpage']), $cms_nav_comments), $echolist);
				return $GlobalTemplate->other($ar,$br,11);
			}
		}
	}
	$ExtendedComments = new ExtendedComments($cms_root."/conf/excomments/");
	
	function here_extended_comments($id) {
		global $ExtendedComments;
		//$ExtendedComments->update($id);
		//echo $ExtendedComments->show($id);
		echo $ExtendedComments->show($id, false, $ExtendedComments->update($id, false));
	}
	
	function here_excomments($id) {
		here_extended_comments($id);
	}
