<?php
  /*
  Этот файл подключается (через include) после подключения funtions.command.php
  
  Здесь Вы можете создавать новые команды системы, например:
  
  function here_example()
  {
      echo "Hello World!";
  };

  Или любой другой код, на Ваше усмотрение. Этот файл - "сердце" Вашего дополнения.
  
  Если существует $_GET['action'] при запросе страницы, то система
  сравнивает с своей базой действий значение $_GET['action'] и, если не находит соответствие,
  выдаёт ошибку ("Действие не найдено"). 
  Вы можете добавить своё действие. Для этого в info.dat переменная $addaction должна равняться
  1 ($addaction = 1;). Вашим действием станет имя каталога дополнения (в данном случае example).
  В действии обязательно должны использоваться переменные $openpage и $pagetitle.
  $openpage = текст страницы, а $pagetitle - заголовок.
  Пример:
  
  function here_example()
  {
       echo '<a href="?action=example">Проверка</a>';
  };
  if (isset($_GET['action']))
  {
    if ($_GET['action']=="example")
    {
      $openpage   = "Проверка пройдена!";
      $pagetitle  = "Сообщение";
    };
  };
  
  В действии можно включить автоматическую переадресацию. Но в этом случае страница действия не будет
  отображена, если отключена опция показа промежуточных страниц в админ-центре, а будет сразу переадресация
  на указанный адрес. Для включения автоматической переадресации заполните переменную $pageredirect.
  Пример:
  
  function here_example()
  {
       echo '<a href="?action=example">Проверка</a>';
  };
  if (isset($_GET['action']))
  {
    if ($_GET['action']=="example")
    {
      $openpage     = "Проверка пройдена!";
      $pagetitle    = "Сообщение";
      $pageredirect = "http://mysite.domain";
     }; 
  };
  
  
  */ 
  function here_example_plugin()
  {
      echo "Hello World!";
  };

  if (isset($_GET['action']))
  {
    if ($_GET['action']=="example_plugin")
    {
      $openpage = "привет";
      $pagetitle = "Тест";
      $pageredirect = "http://ruxe-engine.ru";
    };
  };

function installExamplePlugin(){
  // функция автоматически выполнится при активации дополнения
}

function uninstallExamplePlugin(){
  // функция автоматически выполнится при деактивации дополнения
}
