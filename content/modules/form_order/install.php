<?php
session_start();
//include("../../../config.php");
include('../../../include/db.php');
include('../../../cpanel/include/lang.php');
include('../../../cpanel/include/functions/f_security.php');
//include('../../../cpanel/include/a_get.php');
//db_connect($host, $login, $password, $database);


// Вставляем строку в таблицу модулей
// 2017
function insert_row_in_modules($conn, $username) {
	$sql = "
	INSERT INTO `cms_modules` (`id`, `createdon`, `modifiedon`, `createdby`, `modifiedby`, `dir`, `name`, `icon`, `status`, `status_mainpage`) VALUES (
	'',
	now(),
	now(),
	'".$username."',
	'".$username."',
	'form_order',
	'Форма заказа',
	'/content/modules/form_order/img/icon.gif',
	'1',
	'0'
	);
	";
	$result = mysqli_query($conn, $sql);
	if (!$result)
		return false;
	return true; 
}

function create_table_form_order($conn, $username) {
	$sql = "
	CREATE TABLE IF NOT EXISTS cms_form_order (
	  id int(1) unsigned NOT NULL AUTO_INCREMENT,
	  createdon datetime NOT NULL,
	  modifiedon timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
	  createdby varchar(50) NOT NULL,
	  modifiedby varchar(50) NOT NULL,
	  username varchar(50) NOT NULL,
	  form_name varchar(50) NOT NULL,
	  fio varchar(100) NOT NULL,
	  email varchar(100) NOT NULL,
	  phone varchar(100) NOT NULL,
	  message text NOT NULL,
	  status int(1) NOT NULL,
	  PRIMARY KEY (id)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
	";
	$result = mysqli_query($conn, $sql);
	if (!$result)
		return false;
	return true;
}

function create_table_form_order_settings($conn, $username) {
	$sql = "
	CREATE TABLE IF NOT EXISTS cms_form_order_settings (
	  id int(1) unsigned NOT NULL AUTO_INCREMENT,
	  createdon datetime NOT NULL,
	  modifiedon timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
	  createdby varchar(50) NOT NULL,
	  modifiedby varchar(50) NOT NULL,
	  subject varchar(100) NOT NULL,
	  email varchar(100) NOT NULL,
	  charset varchar(15) NOT NULL,
	  PRIMARY KEY (id)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
	";
	$result = mysqli_query($conn, $sql);
	if (!$result)
		return false;

	$sql2 = "
	INSERT INTO cms_form_order_settings (id, createdon, modifiedon, createdby, modifiedby, subject, email, charset) VALUES (
	'',
	now(),
	now(),
	'".$username."',
	'".$username."',
	'Заполнена форма заказа',
	'',
	'utf-8'
	);
	";
	$result2 = mysqli_query($conn, $sql2);
	if (!$result2)
		return false;
	return true; 
}

// Set coockies for language
if ($_COOKIE['code']) {
  $code = $_COOKIE['code'];
}
// Russian language as default
else {
  $code = 'ru';
}

$lang['en']['cms_order_001'] = "Module <b>Order form</b> installed.";
$lang['ru']['cms_order_001'] = "Модуль <b>Форма заказа</b> установлен.";

$lang['en']['cms_order_002'] = "Unsuccessfull attempt to install module <b>Order form</b>.";
$lang['ru']['cms_order_002'] = "Неудачная попытка установить модуль <b>Форма заказа</b>.";

if ((create_table_form_order($conn, $_SESSION['username']) == true) && (insert_row_in_modules($conn, $_SESSION['username']) == true) && (create_table_form_order_settings($conn, $_SESSION['username']) == true)) {
	update_logs($conn, $_SESSION['username'], $lang[$code]['cms_order_001'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
	header("Location: /cpanel/modules.php?result=success_install");
	exit;
}
else {
	update_logs($conn, $_SESSION['username'], $lang[$code]['cms_order_002'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
	header("Location: /cpanel/modules.php?result=fail_install");
	exit;
}