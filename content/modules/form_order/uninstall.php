<?php
session_start();
//include("../../../config.php");
include('../../../include/db.php');
include('../../../cpanel/include/lang.php');
include('../../../cpanel/include/functions/f_security.php');
include('functions.php');
//include('../../../cpanel/include/a_get.php');
//db_connect($host, $login, $password, $database);

$dir = "form_order";
$table1 = "cms_form_order";
$table2 = "cms_form_order_settings";

// Set coockies for language
if ($_COOKIE['code']) {
  $code = $_COOKIE['code'];
}
// Russian language as default
else {
  $code = 'ru';
}

$lang['en']['cms_order_003'] = "Module <b>Order form</b> uninstalled.";
$lang['ru']['cms_order_003'] = "Модуль <b>Форма заказа</b> деактивирован.";

$lang['en']['cms_order_004'] = "Unsuccessfull attempt to uninstall module <b>Order form</b>.";
$lang['ru']['cms_order_004'] = "Неудачная попытка деактивировать модуль <b>Форма заказа</b>.";

if ((delete_row_in_modules($conn, $dir) == true) && (delete_table_form_order($conn, $table1, $table2) == true)) {
	update_logs($conn, $_SESSION['username'], $lang[$code]['cms_order_003'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
	header("Location: /cpanel/modules.php?result=success_uninstall");
	exit;
}
else {
	update_logs($conn, $_SESSION['username'], $lang[$code]['cms_order_004'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
	header("Location: /cpanel/modules.php?result=fail_uninstall");
	exit;
}