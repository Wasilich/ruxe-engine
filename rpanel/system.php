<?
/*
Ruxe Engine (http://engine.ruxesoft.net/)

1) Правообладателем, а также автором программы Ruxe Engine и всех версий является Ахрамеев Денис 
Викторович (официальный сайт: www.ruxesoft.net).

2) Вы имеете право бесплатно использовать программу в течение неограниченного срока и получать 
коммерческую выгоду от сайта, работающего под управлением Ruxe Engine.

3) Вы можете распространять программу, но НЕ получая от этого никакой коммерческой выгоды и не 
нарушая целостность оригинального дистрибутива.

4) Вы НЕ имеете права сдавать в аренду, продавать программу, а также использовать её на сайтах с 
порно или другим, нарушающим законодательство РФ, контентом.

5) Вы НЕ имеете права использовать программу для создания дорвеев.

6) При использовании любой части кода из программы в личных целях (например, для написания 
собственной CMS), необходимо указывать следующее: "Следующий код взят из Ruxe Engine 
(http://engine.ruxesoft.net)". Однако, если вы использовали более 10 Кбайт кода из программы 
в личных целях, то вам необходимо разместить ссылку на сайт http://engine.ruxesoft.net на 
видном месте, например:

echo '<a href="http://engine.ruxesoft.net" target="_blank">Скрипт написан на основе кода Ruxe Engine</a>';

7) Вы НЕ имеете права препятствовать/удалять или каким-либо другим образом мешать программе 
отображать на страницах сайта, использующего систему, текст "Powered by Ruxe Engine" с 
ссылкой на http://engine.ruxesoft.net.

8) Помните, что Ruxe Engine держится лишь на чистом энтузиазме автора, прибыли от программы 
никакой.

9) Программа распространяется по принципу "как есть". Никаких гарантий автор не предоставляет, 
а также не несёт ответственности за порчу имущества или информации программой.

10) Вы можете использовать данное программное обеспечение в любой стране мира.

11) Любые другие права, не указанные явно в настоящем Соглашении, принадлежат Ахрамееву Денису 
Викторовичу.

12) Данное Лицензионное соглашение может быть изменено для последующих версий программного 
обеспечения без уведомления вас об этом.

13) Если вы не согласны с условиями данного Лицензионного соглашения, вы обязаны удалить 
программу и все её части с ваших носителей.
*/
  include("check2.php");
  
  $GlobalUsers->access(1);
  
  $ar = array("{VERSION}","{BANLIST}","{DATEBACKUP}","{HITS}","{REHITS}","{HOSTS}","{REHOSTS}","{LINKS}","{RELINKS}",
  "{DOWNLOADS}","{REDOWNLOADS}","{VIEWS}","{REVIEWS}",
  "{LOG}","{LOGPAGES}","{ALOG}","{ALOGPAGES}","{ERRORS}","{ERRORSPAGES}","{BANLOG}","{BANLOGPAGES}","{CLEARALOG}","{CONFBACKUPCHECK}","{CONFBACKUPLIST}");

  $version = "<b>".$this_version."</b> <a href=\"?action=system&amp;go=checkver\">Проверить обновление</a>";
  $gendown = true;
  
  //<input type="button" onClick="location.href='clear.php?file=alog';" value="Очистить">
  $tusers = file($cms_root."/conf/users/users.dat");
  $t      = explode("|",$tusers[0]);
  if ($Filtr->tolower($t[18])==$Filtr->tolower($_COOKIE['site_login']))
          $clearalog = '<input type="button" onClick="location.href=\'saver.php?saverdo=clear&amp;file=alog\';" value="Очистить">';
  else
  	  $clearalog = '<font style="color:red;">Только <b>главный администратор</b> может очищать лог админ-центра</font>';
  
  //Работа с zip бэкапами
  $confbackupcheck = md5(rand(1,30000));
  $checkbackup     = fopen($cms_root."/conf/checkbackup.dat","w");
  fwrite($checkbackup,$confbackupcheck);
  fclose($checkbackup);
  
  $backups         = file($cms_root.'/conf/backups.dat');
  $confbackuplist  = '';
  foreach ($backups as $backup)
  {
  	$b = explode("|",$backup);
  	$tmp = substr(filesize($cms_root.'/rpanel/backups/'.$b[0])/1024, 0, 4);
	if (substr($tmp,strlen($tmp)-1,1)=='.') $tmp = substr($tmp,0,strlen($tmp)-1);
	if (substr($tmp,strlen($tmp)-2,2)=='.0') $tmp = substr($tmp,0,strlen($tmp)-2);
	$sizeupdate = $tmp;
  	$confbackuplist .= '<tr><td>'.$Filtr->fulldate(str_replace('2011','11',$b[1])).'</td><td><a href="'.$cms_site.'/rpanel/backups/'.$b[0].'">'.$b[0].'</a></td>
  	<td>'.$sizeupdate.' КБ</td>
  	<td>
  	<a href="'.$cms_site.'/rpanel/backups/'.$b[0].'">Скачать</a>
  	<a href="#confbackup" onClick="if (checkhead()) location.href=\'saver.php?saverdo=delfile&amp;url='.$cms_root.'/rpanel/backups&amp;fname='.$b[0].'&amp;confbackup=true\';">Удалить</a>
  	</td></tr>
  	';
  };
  //
  
  if (isset($_GET['go']))
  {
    $go = $_GET['go'];
    if ($go == "checkver")
    {
          $addpath = $_SERVER['PHP_SELF'];
          $addpath = str_replace("/rpanel/index.php", "", $addpath);
          $version= "<b>".$this_version."</b> (Последняя версия: <img alt=\"\" src=\"http://engine.ruxesoft.net/enginever.php?rand=".rand(1111,9999)."\" border=0>)";

    }
    else if ($go == "log")
    {
          $gendown = false;
          $echooptions='<h2>Лог посещений</h2>
          <font class="desc">Новые записи располагаются сверху</font>
          <br><br>
          <center><table class="optionstable" style="table-layout: fixed;" border=0 cellpadding=1 cellspacing=0>
           <tr class="titletable"><td>АДРЕС</td><td>ОТКУДА</td><td width=200>БРАУЗЕР</td><td width-120>IP</td><td width=150>ДАТА И ВРЕМЯ</td></tr>
           ';
          $stat=file("../conf/logs/log.log");
          $stat	=	array_reverse($stat);
	  

	  
          foreach($stat as $element)
          {
            $elemen = $Filtr->clear($element);
            $elemen	=	str_replace('&amp;amp;','&',$elemen);
            $elemen	=	str_replace('$amp;','&',$elemen);
            $pieces = explode("[=]",$elemen);
	    
		//
		$tmp		=	explode(':',$pieces[4]);
		if (isset($tmp[2]))
		{
			$seconds=	($tmp[2]=='') ? '01' : $tmp[2];
		}
		else
			$seconds=	'01';
		$pieces[4]	=	$tmp[0].':'.$tmp[1];
		//
	    
	    $add	=	'';
		if (!isset($pieces[5]))
			$pieces[5] == '';
	    if ($pieces[5]!='')
		$add	=	' (<a href="'.$Navigation->furl('viewprofile',$Filtr->clear($pieces[5])).'" target="_blank">'.$Filtr->clear($pieces[5]).'</a>)';
            $echooptions.= "<tr><td>".$pieces[0]."</td><td>".$pieces[1]."</td><td>".$pieces[2]."</td><td>".$Filtr->ipclick($pieces[3]).$add."</td><td>".$Filtr->fulldate($pieces[4],$seconds)."</td></tr>
            ";
          };
          
          $echooptions.='
          <tr class="sub"><td colspan=5><input type="button" onClick="location.href=\'saver.php?saverdo=clear&amp;file=log\';" value="Очистить"></td></tr> 
          </table></center>
          ';
    }
    else if ($go == "alog")
    {
          $gendown = false;
          $echooptions='<h2>Лог админ-центра</h2>
          <font class="desc">Новые записи располагаются сверху</font>
          <br><br>
          <center><table class="optionstable" border=0 cellpadding=1 cellspacing=0>
           ';
          $stat=file("../conf/logs/rpanel.log");
          $stat	=	array_reverse($stat);
          foreach($stat as $element)
          {
            $pieces = trim($element);
            $echooptions.= "<tr><td>".$pieces."</td></tr>
            ";
          };
          
          $echooptions.='
          <tr class="sub"><td>'.$clearalog.'</td></tr> 
          </table></center>
          ';
    }
    else if ($go == "errors")
    {
          $gendown = false;
          $echooptions='<h2>Лог ошибок</h2>
          <font class="desc">Новые записи располагаются сверху</font>
          <br><br>
          <center><table class="optionstable" border=0 cellpadding=1 cellspacing=0>
          <tr class="titletable"><td>ВРЕМЯ</td><td>КОД ОШИБКИ</td><td>СООБЩЕНИЕ ОШИБКИ</td><td>ФАЙЛ</td><td>СТРОКА</td><td>IP</td></tr>
           ';
          $stat=file("../conf/logs/errors.log");
          $stat	=	array_reverse($stat);
          foreach($stat as $element)
          {
            $elemen = trim($element);
            $p = explode("||",$elemen);
            $echooptions.= "<tr><td>".$Filtr->fulldate($Filtr->clear($p[0]))."</td><td>".$Filtr->clear($p[1])."</td><td>".$Filtr->clear($p[2])."</td><td>".$Filtr->clear($p[3])."</td><td>".$Filtr->clear($p[4])."</td><td>".$Filtr->ipclick($Filtr->clear($p[5]))."</td></tr>
            ";
          };
          
          $echooptions.='
          <tr class="sub"><td colspan=6><input type="button" onClick="location.href=\'saver.php?saverdo=clear&amp;file=errors\';" value="Очистить"></td></tr> 
          </table></center>
          ';
    }
    else if ($go == "banlog")
    {
          $gendown = false;
          $echooptions='<h2>Лог бана</h2>
	  <font class="desc">Новые записи располагаются сверху</font>
          <br><br>
          <center><table class="optionstable" border=0 cellpadding=1 cellspacing=0>
          <tr class="titletable"><td>ВРЕМЯ</td><td>IP</td><td>СТРАНИЦА</td><td>БРАУЗЕР</td><td>ОТКУДА</td></tr>
           ';
          $stat=file("../conf/logs/ban.log");
	  $stat=array_reverse($stat);
          foreach($stat as $element)
          {
            $elemen = trim($element);
            $p = explode("||",$elemen);
            $echooptions.= "<tr><td>".$Filtr->fulldate($p[0])."</td><td>".$p[1]."</td><td>".$p[4]."</td><td>".$p[2]."</td><td>".$p[3]."</td></tr>
            ";
          };
          
          $echooptions.='
          <tr class="sub"><td colspan=5><input type="button" onClick="location.href=\'saver.php?saverdo=clear&amp;file=ban\';" value="Очистить"></td></tr> 
          </table></center>
          ';
    }
    else if ($go == "thanks")
    {
          $gendown = false;
          $echooptions='<h2>Благодарности</h2>
<font class="desc">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Прежде всего, благодарим Вас за использование CMS Ruxe Engine.<br><br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;И выражается благодарность следующим людям, так или иначе участвующих в развитии проекта:<br><br>
</font>
<center>
<font class="desc">
<a href="http://tinymce.moxiecode.com/" target="_blank">Tiny MCE визуальный редактор</a><br><br>
<a href="http://www.cdolivet.com/index.php?page=editArea" target="_blank">Edit Area</a><br><br>
Matthias Sommerfeld (<a href="http://idnaconv.phlymail.de" target="_blank">idnaconv.phlymail.de</a>)<br><br>
Stanisov и PAT<br><br>
<a href="http://www.captcha.ru">www.captcha.ru</a><br><br>
<a href="http://phpforum.ru/index.php?showtopic=28607">http://phpforum.ru/index.php?showtopic=28607</a><br><br>
<a href="http://www.kolobok.us">www.kolobok.us</a><br><br>
<a href="http://stackoverflow.com/users/53114/gumbo" target="_blank">Gumbo</a><br><br>
<a href="http://engine.ruxesoft.net/viewprofile/Polar">Polar</a><br><br>
Константин Vanstorm<br><br>
Александр freshcoder<br><br>
<a href="http://engine.ruxesoft.net/viewprofile/Buranek">Buranek</a><br><br>
Roman Mamedov<br><br>
<a href="http://www.answerium.com/user/simplex/">Simplex</a><br><br>
<a href="http://gv0zdik.livejournal.com/">Gv0zdik</a><br><br> 
Олег olegteror
</font>
</center>
          ';
    }
    else if ($go == "license")
    {
          $gendown = false;
          $echooptions = '
          <h2>Лицензионное соглашение</h2>
<font class="desc">
<p>1) Правообладателем, а также автором программы Ruxe Engine и всех версий является Ахрамеев Денис Викторович (официальный сайт: <a href="http://ruxesoft.net">www.ruxesoft.net</a>).</p> 
              				<p>2) Вы имеете право бесплатно использовать программу в течение неограниченного срока и получать коммерческую выгоду от сайта, работающего под управлением Ruxe Engine.</p>
              				<p>3) Вы можете распространять программу, но НЕ получая от этого никакой коммерческой выгоды и не нарушая целостность оригинального дистрибутива.</p>
                                        <p>4) Вы НЕ имеете права сдавать в аренду, продавать программу, а также использовать её на сайтах с порно или другим, нарушающим законодательство РФ, контентом.</p> 
					<p>5) Вы НЕ имеете права использовать программу для создания дорвеев.</p>
              				<p>6) При использовании любой части кода из программы в личных целях (например, для написания собственной CMS), необходимо указывать следующее: "Следующий код взят из Ruxe Engine (http://engine.ruxesoft.net)". Однако, если вы использовали более 10 Кбайт кода из программы в личных целях, то вам необходимо разместить ссылку на сайт http://engine.ruxesoft.net на видном месте, например: 
<br><br>echo \'&lt;a href="http://engine.ruxesoft.net" target="_blank"&gt;Скрипт написан на основе кода Ruxe Engine&lt;/a&gt;\';</p>
              				<p>7) Вы НЕ имеете права препятствовать/удалять или каким-либо другим образом мешать программе отображать на страницах сайта, использующего систему, текст "Powered by Ruxe Engine" с ссылкой на http://engine.ruxesoft.net.</p>
              				<p>8) Помните, что Ruxe Engine держится лишь на чистом энтузиазме автора, прибыли от программы никакой.</p>
              				<p>9) Программа распространяется по принципу "как есть". Никаких гарантий автор не предоставляет, а также не несёт ответственности за порчу имущества или информации программой.</p>
              				<p>10) Вы можете использовать данное программное обеспечение в любой стране мира.</p>
              				<p>11) Любые другие права, не указанные явно в настоящем Соглашении, принадлежат Ахрамееву Денису Викторовичу.</p>
              				<p>12) Данное Лицензионное соглашение может быть изменено для последующих версий программного обеспечения без уведомления вас об этом.</p>
              				<p>13) Если вы не согласны с условиями данного Лицензионного соглашения, вы обязаны удалить программу и все её части с ваших носителей.</p>
</font><br><br>
';
    };
  };
  
  if ($gendown)
  {
  
  $banlist = "";
  $db=file("../conf/ban.dat");
  $db=array_reverse($db);
  $d=count($db);
  foreach($db as $el_dbs)
  {
       $tmp     = explode("|",$el_dbs);
       $el_dbs_ = explode(".",$tmp[0]);
       $banlist.= "<tr><td><b>".$el_dbs_[0].".".$el_dbs_[1].".".$el_dbs_[2].".".$el_dbs_[3]."</b> (".$tmp[1].")</td><td><input type=\"button\" onClick=\"location.href='saver.php?saverdo=deleteban&amp;id=".$d."';\" value=\"Удалить\"></td></tr>
       ";
       $d=$d-1;
  };
  
  $banlog = "";
  $data = file("../conf/logs/ban.log");
  $i = 0;
  $banlogpages = "";
  $max = $cms_nav_system;
  $data = array_reverse($data);

  foreach ($data as $element)
  {
        $p = explode("||",$element);
        if ($i<$max) {
           $banlog.= "<tr><td>".$Filtr->fulldate($p[0])."</td><td>".$p[1]."</td><td>".$p[4]."</td><td>".$p[2]."</td><td>".$p[3]."</td></tr>
           ";
        };
        $i++;
  };
  if ($i>$max)
  {
   $banlogpages = "<a target=\"_blank\" href=\"?action=system&amp;go=banlog\">Просмотреть все записи (".$i.")</a>";
  };
  
  $alog = "";
  $alogpages = "";
  $i = 0;
  $stat=file("../conf/logs/rpanel.log");
  $stat = array_reverse($stat);
  foreach($stat as $element)
  {
       $pieces = trim($element);
       if ($i<$max) {
        $alog.= "<tr><td>".$pieces."</td></tr>
        ";
       };
       $i++;
  };
  if ($i>$max)
  {
     $alogpages = "<a target=\"_blank\" href=\"?action=system&amp;go=alog\">Просмотреть все записи (".$i.")</a>";
  };
  
  $log="";
  $logpages="";
  $i = 0;
  $stat=file("../conf/logs/log.log");
  $stat = array_reverse($stat);
  foreach($stat as $element)
  {
       $elemen = str_replace("&amp;","&",$Filtr->clear($element));
       $pieces = explode("[=]",$elemen);
	//
	$tmp		=	explode(':',$pieces[4]);
	if (isset($tmp[2]))
	{
		$seconds=	($tmp[2]=='') ? '01' : $tmp[2];
	}
	else
		$seconds=	'01';
	$pieces[4]	=	$tmp[0].':'.$tmp[1];
	//
       if ($i<$max) {
        if (str_replace($cms_site."/","",$pieces[0]) == "") $pieces[0] = "Главная страница сайта";
	if ($pieces[5]!='')
		$add	=	' (<a href="'.$Navigation->furl('viewprofile',$Filtr->clear($pieces[5])).'" target="_blank">'.$Filtr->clear($pieces[5]).'</a>)';
	else
		$add	=	'';
        $log.= "<tr><td><table class=\"without\" border=0>
        <tr><td width=120><b>Страница:</b></td><td>".str_replace($cms_site."/","",$pieces[0])."</td></tr>";
		if (!isset($pieces[1]))
			$pieces[1] = "";
        if ($pieces[1]!="")
			$log.="<tr><td><b>Откуда: </b></td><td>".str_replace($cms_site."/","",$pieces[1])."</td></tr>";
        $log.="<tr><td><b>User Agent: </b></td><td>".$Filtr->clear($pieces[2])."</td></tr>
        <tr><td><b>IP: </b></td><td>".$Filtr->ipclick($pieces[3]).$add."
	</td></tr>
        <tr><td><b>Дата и время: </b></td><td>".$Filtr->fulldate($pieces[4],$seconds)."</td></tr>
        </table>
        </td></tr>
        ";
        
       };
       $i++;
  };
  if ($i>$max)
  {
     $logpages = "<a target=\"_blank\" href=\"?action=system&amp;go=log\">Просмотреть все записи (".$i.")</a>";
  };
  
  $errors = "";
  $errorspages="";
  $i = 0;
  $data = file("../conf/logs/errors.log");
  $data = array_reverse($data);
  foreach($data as $element)
  {
        $p = explode("||",$element);
        if ($i<$max) {
         $errors.= "<tr><td>".$Filtr->fulldate($Filtr->clear($p[0]))."</td><td>".$Filtr->clear($p[1])."</td><td>".$Filtr->clear($p[2])."</td><td>".$Filtr->clear($p[3])."</td><td>".$Filtr->clear($p[4])."</td><td>".$Filtr->ipclick($p[5])."</td></tr>
         ";
        };
        $i++;
  };
  if ($i>$max)
  {
     $errorspages = "<a target=\"_blank\" href=\"?action=system&amp;go=errors\">Просмотреть все записи (".$i.")</a>";
  };
  
  include("../conf/backup.php");
  
  $hits = file("../conf/all_hits.dat");
  $hosts = file("../conf/all_hosts.dat");
  $links = "";
  $file = file("../conf/count_links.dat");
  foreach ($file as $one)
  {
     $p = explode("=",$one);
     $links.=$p[0]."=".$p[1]."<br>
     ";
  };
  $relinks = str_replace("|","<br>",$backup_links);
  
  $downloads = "";
  $file = file("../conf/downloads.dat");
  foreach ($file as $one)
  {
     $p = explode("=",$one);
     $downloads.=$p[0]."=".$p[1]."<br>
     ";
  };
  $redownloads = str_replace("|","<br>",$backup_downloads);
  
  $views = "";
  $file = file("../conf/views.dat");
  foreach ($file as $one)
  {
     $p = explode("=",$one);
     $views.=$p[0]."=".$p[1]."<br>
     ";
  };
  $reviews = str_replace("|","<br>",$backup_views);
  
  $br = array($version,$banlist,$backup_date,$hits[0],$backup_all_hits,$hosts[0],$backup_all_hosts,$links,$relinks,
  $downloads,$redownloads,$views,$reviews,
  $log,$logpages,$alog,$alogpages,$errors,$errorspages,$banlog,$banlogpages,$clearalog,
  $confbackupcheck,$confbackuplist);
  
  
 
  $echooptions = $GlobalTemplate->template($ar,$br,"./theme/system.tpl");
  $starts	=	array(
  			'[if_log]',
  			'[if_alog]',
  			'[if_elog]',
  			'[if_blog]');
  $ends		=	array(
  			'[/if_log]',
  			'[/if_alog]',
  			'[/if_elog]',
  			'[/if_blog]');
  $res		=	array(
  			($log=='') ? '<!--' : '',
  			($alog=='') ? '<!--' : '',
  			($errors=='') ? '<!--' : '',
  			($banlog=='') ? '<!--' : '');
  $codes	=	array(
  			0,
  			1,
  			2,
  			3);
  for ($i=0;$i<count($starts);$i++)
  	$echooptions = $GlobalTemplate->checkteg($echooptions,$starts[$i],$ends[$i],'default',$res,$codes[$i]);
  };
  $ar = array("{MENU}","{OPTIONS}");
  $br = array("",$echooptions);
  echo $GlobalTemplate->template($ar,$br,"./theme/admincenteroptions.tpl");
?>