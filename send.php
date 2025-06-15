<?php
// Подключение файлов phpmailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// Проверка, что ошибки нет
if (!error_get_last()) {

	$name = $_POST['name'];
	$connects = $_POST['connects'];
	$comment = $_POST['comment'];
	
	// Формирование самого письма
	$title = "Новая заявка";
	$body = "
    <h2>Новое письмо</h2>
    <b>Имя:</b> $name
		<br>
		<b>Контакт:</b> $connects
		<br>
		<b>Комментарий:</b> $comment
	";

	// Настройки PHPMailer
	$mail = new PHPMailer\PHPMailer\PHPMailer();

	$mail->isSMTP();
	$mail->CharSet = "UTF-8";
	$mail->SMTPAuth = true;

	// Настройки вашей почты
	$mail->Host = 'smtp.yandex.ru'; // SMTP сервера вашей почты
	$mail->Username = 'chemnks@yandex.ru'; // Логин на почте
	$mail->Password = 'mixbiyfftpdupodi'; // Пароль
	$mail->SMTPSecure = 'ssl'; // Тип подключения
	$mail->Port = 465; // SMTP порт
	$mail->setFrom('chemnks@yandex.ru', 'Денис'); // Адрес самой почты и имя отправителя

	// Получатель письма
	$mail->addAddress('chemnks@yandex.ru');

	// Отправка сообщения
	$mail->isHTML(true);
	$mail->Subject = $title;
	$mail->Body = $body;

	// Проверяем отправленность сообщения
	if ($mail->send()) {
		$data['result'] = "success";
		$data['info'] = "Сообщение успешно отправлено!";
	} else {
		$data['result'] = "error";
		$data['info'] = "Сообщение не было отправлено. Ошибка при отправке письма";
		$data['desc'] = "Причина ошибки: {$mail->ErrorInfo}";
	}

} else {
	$data['result'] = "error";
	$data['info'] = "В коде присутствует ошибка";
	$data['desc'] = error_get_last();
}

/* if (isset($_POST['submit'])) {  
	if($_SERVER['REQUEST_METHOD'] == 'POST') {  
			$name = $_POST['name'];  
			$email = $_POST['email'];  
			$message = $_POST['message'];  
			if($name && $email && $message) {  
					header('Location: ./pages/thankyou.html');  
			}  
	}  
}  */

// Переадресация после отправки 
header("Location: ./pages/thank-you.html");