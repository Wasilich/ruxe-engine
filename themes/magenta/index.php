<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
  <head>
	<title><?php here_title(); ?></title>
	<link rel="shortcut icon" href="<?php here_urlsite(); ?>/favicon.ico" type="image/x-icon">
	<link rel="alternate" type="application/rss+xml" title="RSS лента" href="<?php here_urlrss(); ?>">
	<?php here_metaredirect(); ?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="keywords" content="<?php here_keywords(); ?>">
	<meta name="generator" content="<?php here_generator(); ?>">
	<meta name="description" content="<?php here_description(); ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" href="<?php here_themepath(); ?>/style.css" type="text/css">
	<script type="text/javascript" src="<?php here_themepath(); ?>/js/prefixfree.min.js"></script>
	<script type="text/javascript" src="<?php here_themepath(); ?>/js/jquery.min.js"></script>
	<!--[if lt IE 9]>
        <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->
	<script>
		  $(document).ready(function(){
				$('#login-trigger').click(function(){
					$(this).next('#login-content').slideToggle();
					$(this).toggleClass('active');					
					
					if ($(this).hasClass('active')) $(this).find('span').html('▲')
						else $(this).find('span').html('▼')
					})
		  });
	</script>
	<script>
      var h_hght = 176; // высота шапки
      var h_mrg = 0;     // отступ когда шапка уже не видна
        $(function(){
        $(window).scroll(function(){
      var top = $(this).scrollTop();
      var elem = $('#top-nav');
      if (top+h_mrg < h_hght) {
        elem.css('top', (h_hght-top));
      } else {
        elem.css('top', h_mrg);
      }
        });
      });
    </script>
  </head>
<body>
	<div id="header">
		<div class="container">
			<a href="#"><h1>Логотип и девиз вашего сайта</h1></a>
		</div>
	</div>
	<div id="top-nav">
		<div class="container menu">
			<div class="menu-item">
			    <ul><!--PHP функция here_urlsite(); возвращает полный адрес сайта (с http://), без / на конце.-->
				    <li>
					    <a href="<?php here_urlsite(); ?>/">Новости</a>
				    </li>
				        <!--Если в качестве параметра передать этой функции имя страницы (Админ-центр - Страницы), то в зависимости от того, задействован ЧПУ или нет 
				        (Админ-центр - Настройки - Активировать ЧПУ), вернёт правильный адрес страницы сайта.
			            Пример:
			            ЧПУ активирован, страница "downloads.html", результат: http://ваш_сайт/downloads.html
			            ЧПУ не используется, та же страница, результат: http://ваш_сайт/?viewpage=downloads.html-->
				    <li>
					    <a href="<?php here_urlsite('downloads.html'); ?>">Загрузки</a>
				    </li>
				        <!--Другими словами, чтобы не вводить адрес сайта, используйте команду here_urlsite() без параметров. А для указания ссылки на страницу сайта, 
				        правильнее использовать команду с параметром here_urlsite('тут имя страницы'). Подробнее о командах в документации.-->
				    <li>
					    <a href="<?php here_urlsite('faq.html'); ?>">F.A.Q.</a>
				    </li>
				    <li>
					    <a href="<?php here_urlsite('contact.html'); ?>">Обратная связь</a>
				    </li>
				    <li>
					    <a href="<?php here_urlsite(); ?>/README.md" target="_blank">Документация</a>
				    </li>
			        <li>
					    <a href="<?php here_urlsite('somepage.html'); ?>/#">Ссылка</a>
				    </li>
			    </ul>
			</div>
			<div class="log-form">
		        <div id="login">
					<a id="login-trigger" href="#">Аккаунт <span>▼</span></a>
					<div id="login-content">
			            <?php here_login(); ?>							
		            </div>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
	    <div id="spacer-top"></div>
		<div id="content">
			<?php here_pagecontent(); ?>
			<!-- Рекламный блок. Если вам не нужен этот блок, закройте его комментариями или удалите -->
			<h2>Рекламный блок</h2>
            <div class="wrapper">
	            <p>
	                Здесь можно разместить баннеры и контекстную рекламу
	            </p>
	            <div class="clear"></div>
                <br>
			</div>
			<!-- Конец рекламного блока -->
			<!-- Дополнительный блок. Если вам не нужен этот блок, закройте его комментариями или удалите -->
			<h2>Дополнительный блок</h2>
            <div class="wrapper">
	            <div class="half">
				    <h4>Популярные новости:</h4>
				    <p>
				        <ul>
				            <?php here_top_news('news'); ?>
				        </ul>
				    </p>
                </div>
				<div class="half">
					<h4>Категории новостей:</h4>
				    <p>
				        <ul>
				            <?php here_list_category("news"); ?>
				        </ul>
				    </p>
                </div>
	            <div class="clear"></div>
                <br>
			</div>
			<!-- Конец дополнительного блока -->
		</div>
	</div>
	<div class="clear"></div>
    <div id="footer">
		<div class="container">
		    <div class="wrapper">
		        <div class="half">
			        <p><!-- Для тактичного отображения краткой формы поиска скачайте обновлённое дополнение "Поиск" -->
				        Поиск по сайту:
				        <div class="short-search">
					        <?php //here_shortsearch(); ?>
					    </div>
				    </p>
                </div>
			    <div class="half">
				    <p>{CREDITS}</p>
				    <p><a href="http://d-sign.name" target="_blank">Дизайн:</a> <a href="http://ruxe-engine.ru/viewprofile/Wasilich" target="_blank">Wasilich</a></p>
				    <p>Генерация: <?php here_time_generation(); ?> секунд.</p>
			    </div>
			</div>
		</div>
		<div class="clear"></div>
		<br>
    </div>
</body>
</html>
