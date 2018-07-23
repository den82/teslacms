<?php
session_start();
include('../../../include/db.php');
include('functions.php');
if ($_POST['mode'] == 'order') {

	//Получаем пост от recaptcha
	$recaptcha = $_POST['g-recaptcha-response'];
	 
	//Сразу проверяем, что он не пустой
	if(!empty($recaptcha)) {
		//Получаем HTTP от recaptcha
		$recaptcha = $_REQUEST['g-recaptcha-response'];
		//Сюда пишем СЕКРЕТНЫЙ КЛЮЧ, который нам присвоил гугл
		$secret = '6Lc05SsUAAAAALthNjeXJ7ZSVr-1E9SkVr5fQ-P2';
		//Формируем utl адрес для запроса на сервер гугла
		$url = "https://www.google.com/recaptcha/api/siteverify?secret=".$secret ."&response=".$recaptcha."&remoteip=".$_SERVER['REMOTE_ADDR'];
	 
		//Инициализация и настройка запроса
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_TIMEOUT, 10);
		curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.2.16) Gecko/20110319 Firefox/3.6.16");
		//Выполняем запрос и получается ответ от сервера гугл
		$curlData = curl_exec($curl);
	 
		curl_close($curl);  
		//Ответ приходит в виде json строки, декодируем ее
		$curlData = json_decode($curlData, true);
	 
		//Смотрим на результат 
		if($curlData['success']) {
			//Сюда попадем если капча пройдена, дальше выполняем обычные 
			//действия(добавляем коммент или отправляем письмо) с формой
			$settings = get_settings_form_order($conn);
			if (send_mail($_POST, $settings) == true) {
				unset($_SESSION['name']);
				unset($_SESSION['email']);
				unset($_SESSION['phone']);
				unset($_SESSION['message']);
				$_SESSION['success'] = "<div class='alert alert-success' role='alert'>Ваш запрос успешно отправлен!</div>";
			}
			else {
				//Капча не пройдена, сообщаем пользователю, все закрываем стираем и так далее
				$_SESSION['name'] = $_POST['name'];
				$_SESSION['email'] = $_POST['email'];
				$_SESSION['phone'] = $_POST['phone'];
				$_SESSION['message'] = $_POST['message'];
				$_SESSION['fail'] = "<div class='alert alert-danger' role='alert'>Ошибка!</div>";
			}
		}
	}
	else {
		//Капча не введена, сообщаем пользователю, все закрываем стираем и так далее
		$_SESSION['name'] = $_POST['name'];
		$_SESSION['email'] = $_POST['email'];
		$_SESSION['phone'] = $_POST['phone'];
		$_SESSION['message'] = $_POST['message'];
		$_SESSION['fail'] = "<div class='alert alert-danger' role='alert'>Капча не введена!</div>";
	}
	header("Location: ".$_SERVER['HTTP_REFERER']);
	exit;
}



if ($_POST['mode'] == 'settings') {
	if (form_order_settings($conn, $_POST, $_SESSION['username']) == true) {
		header("Location: ".$_SERVER['HTTP_REFERER']."&result=success");
		exit;
	}
}
?>