<?php
$cansearch 	= true; 
$timesearch 	= 0;
$GlobalSearch 	= 1;
class SearchPlugin {
	function update($mode) {
		global $cms_root;
		include($cms_root."/conf/search/config");
		$continue = true;
		if ( ($autoupdate!='checked')
			and
				($mode!='manual')
		) $continue = false;
		if ($continue) {
			$db = fopen($cms_root."/conf/search/index.db","w");
			if ($mode != 'manual') {
				$date 		= date("d.m.y, H:i");
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
					\$autoupdate = '".$autoupdate."';
					");
				fclose($config);
			}
			if ($pages_checked!='') {
				$pages = file($cms_root."/conf/pages/config");
				$hp    = file($cms_root."/conf/users/hidepages.dat");
				foreach ($pages as $page) {
					$p = explode("|",$page);
					$canadd = true;
					$h = explode("|",$hp[0]);
					foreach ($h as $a) {
						if ($a=='/'.$p[0])
							$canadd = false;
					}
					if ($canadd) {
						$file = file($cms_root."/conf/pages/".$p[4].".txt");
						$line = '[titlere]'.$p[1].'[/titlere] ';
						foreach ($file as $f) {
							$f = str_replace("\r\n"," ",$f);
							$f = str_replace("\r"," ",$f);
							$f = str_replace("\n"," ",$f);
							$f = strip_tags($f);
							$line .= $f;
						}
						fwrite($db,"pages[{|}]".$p[4]."[{|}][{|}]".$line."[{|}]\r\n");
					}
				}
			}
			
			if ($news_checked!='') {
				$bfg = file($cms_root."/conf/bfg.dat");
				foreach ($bfg as $bf) {
					$b = explode("|",$bf);
					$list = file($cms_root."/conf/".$b[0]."/list.dat");
					foreach ($list as $lis) {
						$l = explode("|",$lis);
						$file = file($cms_root."/conf/".$b[0]."/".$l[6].".dat");
						$s    = explode("|",$file[0]);
						$s[3] = preg_replace('|(.*)\[hide\](.*)\[\/hide\](.*)|uUis',"\${1}\${3}",$s[3]);
						$s[3] = preg_replace('|(.*)\[скрыть\](.*)\[\/скрыть\](.*)|uUis',"\${1}\${3}",$s[3]);
						$line = '[titlere]'.$l[2].'[/titlere] '.$s[3];
						$line = str_replace(array(
								"[newlinere]",
								"[b]","[/b]",
								"[ж]","[/ж]",
								"[i]","[/i]",
								"[к]","[/к]",
								"[u]","[/u]",
								"[ч]","[/ч]",
								"[s]","[/s]",
								"[п]","[/п]",
								"[center]","[/center]",
								"[по центру]","[/по центру]",
								"[right]","[/right]",
								"[справа]","[/справа]",
								"[left]","[/left]",
								"[слева]","[/слева]",
								"[bad]",
								"[beach]",
								"[blum]",
								"[blush]",
								"[bye]",
								"[cool]",
								"[cray]",
								"[crazy]",
								"[dance]",
								"[dance2]",
								"[don-t_mention]",
								"[good]",
								"[mosking]",
								"[sad]",
								"[scratch]",
								"[shok]",
								"[shout]",
								"[smile]",
								"[wacko]",
								"[wink]",
								"[yes]"
								)," ",$line);
						$line = strip_tags($line);
						fwrite($db,"bfg[{|}]".$b[0]."[{|}]".$l[6]."[{|}]".$line."[{|}]\r\n");
					}
				}
			}
			fclose($db);
		}
	}
	
	function shortForm() {
		global $cms_root, $cms_site, $cms_furl;
		include($cms_root."/includes/plugins/search/template.php");
		$npage = '';
		if (file_exists($cms_root."/conf/search/config"))
			include($cms_root."/conf/search/config");
		if ($cms_furl==1)
			echo str_replace(array('{URL}','{WITHOUTREWRITE}'),array($cms_site.'/'.$npage,''),$shortform);
		else
			echo str_replace(array('{URL}','{WITHOUTREWRITE}'),array($cms_site,'<input type="hidden" name="viewpage" value="'.$npage.'">'),$shortform);
	}
	
	function getTime() {        
		global $timesearch;       
		$ddd	= microtime(); 
		$ddd	= ((double)strstr($ddd, ' ')+(double)substr($ddd,0,strpos($ddd,' ')));
		return number_format(($ddd-$timesearch),3) ;
	}
	
	function getResultSearch($index,$length,$q,$file,$caption,$add,$maxtime) {
		global $cansearch;
		$z        = explode(" ",$q);
		$rel      = 0;
		$oldrel   = 0;
		foreach ($z as $w) {
			if ($this->getTime() > $maxtime) $cansearch = false;
			if ( ($w!='') && ($cansearch) ) {
				if (mb_stristr($index,$w)) {
					$oldrel++;
					$rel += mb_substr_count(mb_strtolower($index), mb_strtolower($w));
				}
			}
		}
		if ($oldrel==count($z)-1) 
			$rel*=10;
               
		foreach ($z as $w) {
			if ($this->getTime() > $maxtime) 
				$cansearch = false;
			if ( ($w!='') && ($cansearch) ) {     
				if (mb_stristr($index, $w)) {
	
					$start = mb_strpos(mb_strtolower($index), mb_strtolower($w));
					$end   = mb_strlen($w);
					if ($start-$length<0) {
						$a  	= "";
						$start 	= 0;
					} else {
						$a 	= '... ';
						$start-=$length;
					}
					$end  += $length*2;
					$index = $a.mb_substr($index,$start,$end).'...';
					break;
				}
			}
		}
               
		foreach ($z as $q) {
			if ($this->getTime() > $maxtime)
				$cansearch = false;
			if ( ($q!='') && ($cansearch) ) {
				if (mb_stristr($index, $q))
					$index = preg_replace('|(.*)('.$q.'.*)([^a-zа-яё].*)|uUis',"\${1}<b><font color='green'>\${2}</font></b>\${3}", $index);                
			}
		}
		return ($cansearch) ? $rel.'[{|}]'.$file.'[{|}]'.$caption.'[{|}]'.$add.'[{|}]'.$index.'[{|}]' : '';
	}
	
	function specSearch($in,$q,$maxtime)
	{
		global $cansearch;
		$search  = explode(' ',$q);
		$founded = false;
		foreach ($search as $s) {
			if ($this->getTime()>$maxtime) $cansearch = false;
			if ( ($s!='')  && ($cansearch) ) {
				if (mb_stristr($in,$s))
					$founded = true;
			}
		}
		return $founded;
	}
	
	function result() {
		global $cms_root, $cms_furl, $cms_site, $_GET,$cansearch,$timesearch,$cms_rewrite_ext, $Navigation, $Filtr;
      
		$print     = '';

		include($cms_root."/includes/plugins/search/template.php");
      
		if (file_exists($cms_root."/conf/search/config")) {
			include($cms_root."/conf/search/config");
			mb_internal_encoding("UTF-8");
			$indexdb     = file($cms_root."/conf/search/index.db");
			if (isset($_GET['q'])) {
				$q           = preg_replace("|[^ёa-zа-я0-9\s]|uUis","",trim($_GET['q']));
				$q           = preg_replace("|\s+|", " ", $q);
			}
			else
				$q           = '';
			if (mb_strlen($q)>3) {
				if (mb_substr_count($q," ")<$maxwords) {
					$change      = array("ная","ого","ов","ом","ам","ев","ся","ие","ия","ая","ый","ое","их","ий","ed","s","а","ы","у","е","я","и","й");
					$resultcount = 0;
					$resulttext  = array();
					$words       = explode(' ',$q);
					$j           = array();
					foreach ($words as $w)
						$j[] = mb_substr($w,0,15);
					$words       = $j;
					$newwords    = $words;
                           
					$timesearch  = microtime();
					$timesearch  = ((double)strstr($timesearch, ' ')+(double)substr($timesearch,0,strpos($timesearch,' ')));
                           
					foreach ($indexdb as $indexline) {
						$index    = explode("[{|}]",$indexline); 
						$i        = 0;
						$sss      = false;
						if ($resultcount<$maxresults) {
							foreach ($words as $word) {
								foreach ($change as $ch) {
									if (
										(mb_substr($words[$i],mb_strlen($words[$i])-mb_strlen($ch),mb_strlen($ch)) == $ch)
										&&
										(mb_strlen($words[$i])>3)
									) {
										$newwords[$i] = mb_substr($words[$i],0,mb_strlen($words[$i])-mb_strlen($ch));
										$sss = true;
										break;
									}
								}
								$i++;
							}
							$newq    = '';
							foreach ($newwords as $newword) 
								$newq.=$newword.' ';
                                               
							if ($this->specSearch($index[3],$newq,$maxtime)) {
								$tmp = $this->getResultSearch($index[3],$length,$newq,$index[0],$index[1],$index[2],$maxtime);
								if ($tmp!='') {   
									$resulttext[] = $tmp; 
									$resultcount++;
								}
							}	
						}
						else 
							break;
					}
					$print .= str_replace('{TIME}',$this->getTime(),$timegen); 
					if ($resultcount==0) $print.=$notfound;
					if (!$cansearch) $print.=str_replace('{MESSAGE}',$critical,$critical_template);
                           
					if ($resultcount>0) {
						natsort($resulttext);
						$resulttext = array_reverse($resulttext);
						$tmp        = explode('[{|}]',$resulttext[0]);
						$pages      = file($cms_root."/conf/pages/config");
						$max        = $tmp[0];                                                  
						foreach ($resulttext as $r) {
							$z = explode('[{|}]',$r);
							$rel = round($z[0] / $max * 100);
							switch ($z[1]) {
								case "pages":
									foreach ($pages as $page) {
										$p = explode("|",$page);
										if ($p[4]==$z[2]) {
											if ($p[0]=="index") $p[0]="";
											if ($cms_furl==1)
												$url = $cms_site."/".$p[0];
											else
												$url = $cms_site.'/?viewpage='.$p[0];
											$caption = $p[1];
											break;
										}
									}
									break;
								case "bfg":
									//$url = $cms_site."/".$z[2]."/".$z[3].$cms_rewrite_ext;
									$url = $Navigation->furl('bfgfull',$z[2],$z[3]);
									$bfg = file($cms_root."/conf/".$z[2]."/".$z[3].".dat");
									$bf  = explode("|",$bfg[0]);
									$caption = $bf[2]; 
									break;
							}
							$z[4] = preg_replace('|(.*)\[titlere\](.*)\[\/titlere\](.*)|uUis',"\${1}\${3}",$z[4]);
							$print.= str_replace(array('{REL}','{COUNT}','{RESULT}','{URL}','{CAPTION}'),array($rel,$z[0],$z[4],$url,$caption),$results_template);
						}
					}      
				} else
					$print .= $much_words;
			}
			else {
				if ($q!='') 
					$print .= $short_q;
			}
			$ar = array("{URL}","{Q}","{PRINT}");
			$br = array($npage,(isset($_GET['q'])) ? $Filtr->clear($_GET['q']) : '',$print); 
			echo str_replace($ar,$br,$general);
		} else
			echo $needupdate;
	}
}
$SearchPlugin = new SearchPlugin;
  
function here_shortsearch() {
       global $SearchPlugin;
       $SearchPlugin->shortForm();
}
   
function here_results() {
	global $SearchPlugin;
	$SearchPlugin->result();
}

function updatesearchdb() {
	global $SearchPlugin;
	$SearchPlugin->update('auto');
}
