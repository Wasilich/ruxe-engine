<?php
$lcms['language_info'] = "Русский";
$lcms['install_file_title'] = "Нарушение безопасности";
$lcms['install_file_text'] = "Удалите файл install.php из каталога с сайтом.";
$lcms['avatar_ok_title'] = "Аватар изменён";
$lcms['avatar_ok_text'] = "Аватар был успешно загружен и установлен в Вашем профиле!";
$lcms['ps_start'] = "<br><br><font style=\"color:gray; font-size:8pt;\">---<br>";
$lcms['ps_end'] = "</font>";
$lcms['users_online'] = "<br>Из них: ";
$lcms['users_end'] = "<br>";
$lcms['user_passs'] = "Пароль и повтор пароля не совпадают!";
$lcms['user_login'] = "Пользователь с таким логином уже зарегистрирован!";
$lcms['user_mailbusy'] = "Пользователь с таким e-mail уже зарегистрирован!";
$lcms['user_ok_title'] = "Успешная регистрация";
$lcms['user_ok_message'] = "Регистрация успешно завершена!<br>Вы можете войти на сайт под своим логином и паролем.";
$lcms['user_need_activate'] = "Регистрация успешно завершена!<br><br>Но необходимо активировать аккаунт<br>На указанный Вами e-mail отправлено письмо с кодом активации.";
$lcms['user_mail_subject'] = "Регистрация на сайте {SITE}";
$lcms['user_fail_activate'] = "Активационный ключ неверен!";
$lcms['user_no_activated'] = "Аккаунт не активирован! Проверьте Ваш почтовый ящик.";
$lcms['user_ok_activate'] = "Аккаунт успешно активирован!<br>Вы можете войти на сайт под своим логином и паролем";
$lcms['user_already'] = "Вы уже активированы!"; 
$lcms['user_error_title'] = "Ошибка";
$lcms['user_notvalid'] = "Логин и/или пароль не верны!<br><br><center><a href=\"javascript:history.go(-1);\">Вернуться</a></center>";
$lcms['user_status_user'] = "Пользователь";
$lcms['user_status_admin'] = "Администратор";
$lcms['user_status_superuser'] = "Суперпользователь";
$lcms['user_status_editor'] = "Редактор";
$lcms['user_status_moderator'] = "Модератор";
$lcms['user_status_baned'] = "Заблокирован";
$lcms['user_status_noactive'] = "Не активирован";
$lcms['user_notfound_title'] = "Ошибка";
$lcms['user_notfound_text'] = "Пользователь с таким логином не найден!";
$lcms['user_edit_title'] = "Редактирование профиля";
$lcms['user_edit_text'] = "Изменения успешно сохранены!<br><br><center><a href=\"{URL}\">Вернуться</a></center>
";
$lcms['user_invalid'] = "В логине и пароле можно использовать только буквы английского алфавита, числа, <b>@</b>, <b>!</b> и <b>-</b>!";
$lcms['user_strln'] = "Логин и пароль не могут содержать менее 4-х и более 20 символов!";
$lcms['user_errormail'] = "Указанный Вами e-mail неверен!";
$lcms['user_errorsec'] = "Защитный код указан неверно!";
$lcms['user_old'] = "Старый пароль введён неверно!";
$lcms['user_founded'] = "Пользователь с таким именем уже зарегистрирован! Если это Вы - пожалуйста,  залогиньтесь. Отправка отменена.";
$lcms['user_add'] = "<br><br><center><a href=\"{URL}\">Вернуться</a></center>";
$lcms['user_noflood'] = "Нельзя сохранять изменения профиля раньше, чем через ".$cms_noflood." секунд после отправки комментария/смены аватара или настроек профиля";
$lcms['user_addnoflood'] = "Нельзя отправлять сообщения или изменять профиль чаще, чем через ".$cms_noflood." секунд.";
$lcms['user_ae_title'] = "Ошибка";
$lcms['user_ae_1'] = "В качестве аватара можно использовать только GIF, PNG и JPG изображения.";
$lcms['user_ae_2'] = "В качестве аватара можно использовать только GIF, PNG и JPG изображения.";
$lcms['user_ae_4'] = "Ширина изображения должна быть не более ".$cms_upload_width." пикселей!";
$lcms['user_ae_5'] = "Высота изображения должна быть не более ".$cms_upload_height." пикселей!";
$lcms['user_ae_6'] = "С Вашего последнего сообщения на сайте или смены аватара прошло менее ".$cms_noflood." секунд.";
$lcms['user_ae_7'] = "Ошибка при загрузке изображения на сервер.<br>Обратитесь к администратору.";
$lcms['restore_time_title'] = "Необходимо подождать";
$lcms['restore_time_text'] = "Пользователям разрешено восстанавливать пароль не чаще, чем раз в 15 минут.<br>Это ограничение действует сразу на всех пользователей.";
$lcms['restore_off'] = "Функция восстановления паролей отключена администратором.";
$lcms['restore_fail'] = "Не удалось восстановить пароль.";
$lcms['restore_go'] = "На Ваш e-mail отправлено письмо с подтверждением на смену пароля.";
$lcms['restore_ok'] = "Пароль успешно изменён!<br>На Ваш e-mail отправлено письмо, содержащее Ваши новые данные.";
$lcms['restore_title'] = "Восстановление пароля";
$lcms['restore_mail_notfound'] = "Пользователь с указанным e-mail не найден!";
$lcms['restore_1'] = "Подтверждение на восстановление пароля с сайта ".str_replace("http://","",$cms_site);
$lcms['restore_2'] = "Новый пароль к аккаунту на сайте ".str_replace("http://","",$cms_site);
$lcms['error_title'] = "Вы ошиблись при вводе данных.";
$lcms['error_back'] = "Вернуться";
$lcms['error_name'] = "Вы не ввели Ваше имя!<br>Пожалуйста, вернитесь и повторите снова.";
$lcms['error_message'] = "Вы не ввели Ваше сообщение!<br>Пожалуйста, вернитесь и повторите снова.";
$lcms['error_mail'] = "Вы не ввели Ваш e-mail или указали его неверно!<br>Пожалуйста, вернитесь и повторите снова.";
$lcms['serror_name'] = "Ваше имя не должно содержать символ <b>|</b>!<br>Пожалуйста, вернитесь и повторите снова.";
$lcms['serror_message'] = "Ваше сообщение не должно содержать символ <b>|</b>!<br>Пожалуйста, вернитесь и повторите снова.";
$lcms['error_security'] = "Защитный код неверен!<br>Пожалуйста, вернитесь назад, обновите страницу и повторите ввод.";
$lcms['findo_title'] = "Внимание!";
$lcms['findo_text'] = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Вы согласились с условием, что не будете размещать порно-материалы на сайте под управлением Ruxe Engine. Однако имеются сведения, что Вы нарушили это условие.<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Работа системы не может быть продолжена. Если Вы считаете это заявление ошибкой и на Вашем сайте нет и не будет порно-материалов, то обратитесь к разработчику.";
$lcms['start_title'] = "Мастер установки Ruxe Engine";
$lcms['start_text'] = "Перед началом работы необходимо уточнить главные параметры системы. Мастер установки позволит вам сделать это максимально быстро и просто.<br><br>
Не забудьте, пожалуйста, прочитать <a href=\"https://github.com/maindefine/ruxe-engine/blob/master/README.md\" target=\"_blank\">документацию</a>.<br><br>
<center><noscript><font color=\"red\"><b>Включите JavaScript в вашем браузере, иначе вы не сможете установить Ruxe Engine.</b></font><br><br></noscript><input type=\"button\" value=\"Начать установку\" onClick=\"location.href='install.php?step=install';\"></center>
";
$lcms['ban_title'] = "Нет доступа";
$lcms['baned_text'] = "Ваше посещение данного Интернет-ресурса заблокировано.<br>Причина: ";
$lcms['date'] = "Дата:";
$lcms['much'] = "посетителей";
$lcms['one'] = "посетитель";
$lcms['much2'] = "посетителя";
$lcms['closed'] = "Сайт временно закрыт.";
$lcms['hack'] = "Обнаружена попытка взлома! Администратору отправлен отчёт. Пожалуйста, входите в скрипт корректно.";
$lcms['hide_message'] = "Просматривать скрытый текст могут только зарегистрированные пользователи.";
$lcms['mail_name'] = "Имя:";
$lcms['mail_choose'] = "Выберите тему";
$lcms['mess_title'] = "Новое мнение о";
$lcms['mess_submit_title'] = "Отправка комментария";
$lcms['mess_submit_text'] = "Ваш комментарий успешно добавлен!";
$lcms['ok_enter_title'] = "Успешный вход";
$lcms['ok_enter'] = "<br><center>Спасибо, что вошли, <b>";
$lcms['ok_enter_end'] = "</b>!</center>";
$lcms['ok_logout_title'] = "Выход...";
$lcms['ok_logout'] = "<br><center>Вы вышли из Вашего аккаунта.</center>";
$lcms['refer1'] = "<br><center>Если Вы не были перемещены, то нажмите";
$lcms['refer2'] = "сюда";
$lcms['refer3'] = ".</center><bR>";
$lcms['gb_subject'] = "Новое сообщение в гостевой книге";
$lcms['gb_submit_title'] = $lcms['mess_submit_title'];
$lcms['gb_submit_text'] = $lcms['mess_submit_text'];
$lcms['faq_submit_title'] = "Ваш вопрос отправлен администратору.<br>Спасибо, ожидайте ответ на e-mail.";
$lcms['faq_subject'] = "Новый вопрос в разделе F.A.Q.";
$lcms['news_subject'] = "Новый комментарий в новости";
$lcms['news_submit_title'] = $lcms['mess_submit_text'];
$lcms['news_not_found'] = "<br><center><h2>Новость не найдена!</h2><br>Указанная Вами новость или категория не существует.</center>";
$lcms['page_not_found'] = "Неверный запрос";
$lcms['action_not_found'] = "<br><br><center><b>Действие не существует!</b></center>";
$lcms['viewprofile_title'] = "Профиль ";
$lcms['registerform_title'] = "Регистрация";
$lcms['restore_title'] = "Восстановление";
$lcms['edit_profile_title'] = "Редактирование профиля";
$lcms['active_post'] = "Спасибо за регистрацию на сайте {SITE}!

Данные для входа под Вашим аккаунтом:
Логин: {LOGIN}
Пароль: {PASSWORD}

Прежде, чем воспользоваться аккаунтом, Вам необходимо его активировать, перейдя по следующему адресу:
{SITE}/index.php?action=activate&user={LOGIN}&key={KEY}";
$lcms['new_post'] = "Новый пароль успешно установлен на сайте {SITE}!

Для входа в Ваш аккаунт используйте новые данные:
Логин: {LOGIN}
Пароль: {PASSWORD}";
$lcms['restore_post'] = "Кто-то (вероятнее всего, Вы) запросил восстановление пароля на сайте {SITE}.

Чтобы получить новый пароль, перейдите по следующему адресу:
{SITE}/index.php?action=restore&mail={MAIL}&key={KEY}

В противном случае проигнорируйте данное письмо";
$lcms['hidedpage_title'] = "Закрытый раздел";
$lcms['hidedpage_text'] = "Просматривать данный раздел имеют право только суперпользователи и администраторы!<br><br><center>{LOGIN}</center><br>";
$lcms['download_title'] = "Загрузка ";
$lcms['download_text'] = "<h2>Загрузка файла сейчас начнётся...</h2>При возникновении проблем с загрузкой, воспользуйтесь <a href=\"{URL}\">прямой ссылкой</a>.";
$lcms['news_no_comments'] = "<a name=\"messbox\"></a><br><br><center><b>Комментирование данной записи запрещено.</b></center><br>";
$lcms['download_notfound'] = "Файл не найден";
$lcms['download_notfound_text'] = "Указанный Вами файл не найден в каталоге.";
$lcms['comments_off'] = "<center><br><b>Администратор отключил комментирование на сайте.</b></center>";
$lcms['user_cannot_no'] = "Вы не можете зарегистрироваться под ником \"no\".<br><br>";
$lcms['rss_nonews'] = "Нет новостей";
$lcms['hlp_spoiler'] = "[Спойлер]";
$lcms['hlp_hide'] = "[Скрытый текст]";
$lcms['hlp_quote_name'] = "[Цитирование {NAME}]";
$lcms['hlp_quote'] = "[Цитата]";
$lcms['months'] = array('01' => 'января', '02' => 'февраля', '03' => 'марта', '04' => 'апреля', 
	'05' => 'мая', '06' => 'июня', '07' => 'июля', '08' => 'августа', 
	'09' => 'сентября', '10' => 'октября', '11' => 'ноября', '12' => 'декабря');
$lcms['pm_title'] = "Личные сообщения";
$lcms['pm_title_error'] = "Ошибка";
$lcms['pm_cleared_inbox'] = "Нет входящих сообщений";
$lcms['pm_cleared_outbox'] = "Нет отправленных сообщений";
$lcms['pm_title_error_text'] = "В данный раздел имеют доступ только зарегистрированные пользователи!";
$lcms['pm_critical'] = "У Вас более ".$cms_pm_max." сообщений в папках Входящие и Отправленные. Пожалуйста, удалите старые сообщения.";
$lcms['notshowmessage'] = "[hide]Сообщение слишком длинное, а функции mb_substr, iconv недоступны или работают неверно.<br>Вариант решения - увеличить \"Максимальное количество символов в комментариях\", но лучше подключить mbstring в опциях сервера[/hide]";
$lcms['pm_by'] = "От кого";
$lcms['pm_to'] = "Кому";
$lcms['user_ae_8'] = "Вес оригинального изображения не должен превышать ".$cms_avatars_maxresize." КБ!";
$lcms['user_a_rules_1'] = "Поддерживаются GIF, JPG и PNG изображения, весом не более ".$cms_upload_maxsite." КБ и размерами не более ".$cms_upload_width." пикселей в ширину и ".$cms_upload_height." в высоту.";
$lcms['user_a_rules_2'] = "Поддерживаются GIF, JPG и PNG изображения. Вы можете использовать изображение любых размеров (ширины, высоты). Если оно будет превышать допустимые, то размеры будут изменены автоматически.";
$lcms['user_ae_3'] = "Вес подходящей по размерам (ширине и высоте) аватары не должен превышать ".$cms_upload_maxsite." КБ!";
$lcms['modifed_generals'] = 'Обнаружены изменения в includes/functions.general.php.<br>Восстановите указанный файл из <a href="http://ruxe-engine.ru">оригинального дистрибутива</a> используемой версии.';
$lcms['rss_title'] = "RSS-лента новостей";
$lcms['error_477'] = "Пользователь или ключ не найден.";
$lcms['error_395'] = "Пользователь уже восстанавливал пароль.";
$lcms['error_649'] = "Не найден ключ.";
$lcms['pm_delete'] = "Удалить";
$lcms['pm_new'] = "Написать";
$lcms['pm_inbox'] = "Входящие";
$lcms['pm_outbox'] = "Отправленные";
$lcms['error_222'] = "Идентификатор не найден.";
$lcms['error_544'] = "Идентификатор {ID} не найден.";
$lcms['error_602'] = "Администратор отключил возможность комментирования на сайте.";
$lcms['pm_theme'] = "Тема: ";
$lcms['guest_not_write'] = "<br><br><center><a href=\"".$cms_site."/newuser/\">Зарегистрируйтесь</a> или войдите в Ваш аккаунт, чтобы оставить комментарий.</center><br>";
$lcms['comment_0'] = "Комментировать";
$lcms['comment_one'] = "комментарий";
$lcms['comment_much'] = "комментариев";
$lcms['comment_much2'] = "комментария";
$lcms['views_0'] = "Нет просмотров";
$lcms['views_one'] = "просмотр";
$lcms['views_much'] = "просмотров";
$lcms['views_much2'] = "просмотра";
$lcms['pm_not_read'] = "Не прочитано";
$lcms['pm_delete_not_read'] = "Удалено без прочтения";
$lcms['download_one'] = "загрузка";
$lcms['download_much'] = "загрузок";
$lcms['download_much2'] = "загрузки";
$lcms['ban_why'] = "Причина";
$lcms['page_next'] = "Новее";
$lcms['page_last'] = "Ранее";
$lcms['pm_notread_one'] = "новое";
$lcms['pm_notread_much'] = "новых";
$lcms['pm_notread_much2'] = "новых";
$lcms['botdownload_title'] = "Роботы не могут качать файлы";
$lcms['botdownload_message'] = "Роботам запрещено качать файлы! Если вы считаете это ошибкой, то, скорее всего, вы не робот. Пожалуйста, обратитесь в <a href=\"http://ruxe-engine.ru\">Техническую поддержку Ruxe Engine</a>.";

$lcms['today'] = 'Сегодня';
$lcms['yesterday'] = 'Вчера';
$lcms['tomorrow'] = 'Завтра';
$lcms['user_ipbusy'] = 'С Вашим IP уже зарегистрирован другой пользователь!';
$lcms['user_ae_25'] = 'Вы не выбрали аватар';
//0.9.8.7.6
$lcms['comment_send_with_premoder']	=	'Ваш комментарий успешно отправлен! Он будет опубликован на сайте после проверки модератором или администратором.';
//1.3
$lcms['news_empty'] = "<br><center><h2>Новостной раздел {WHO} пуст!</h2></center>";
$lcms['regclosed'] = "Регистрация с сайта отключена администратором.";
//1.4.5
$lcms['comments_closed'] = "<br><br><center>Комментирование в данном разделе отключено.</center><br>";
