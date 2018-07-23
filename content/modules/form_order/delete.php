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

$lang['en']['cms_order_005'] = "Module <b>Order form</b> was removed permanently.";
$lang['ru']['cms_order_005'] = "Модуль <b>Форма заказа</b> удален навсегда.";

$lang['en']['cms_order_006'] = "Unsuccessfull attempt to remove module <b>Order form</b> permanently.";
$lang['ru']['cms_order_006'] = "Неудачная попытка удалить навсегда модуль <b>Форма заказа</b>.";

delete_row_in_modules($conn, $dir);
delete_table_form_order($conn, $table1, $table2);

if (delete_module_forever($dir) == true) {
	update_logs($conn, $_SESSION['username'], $lang[$code]['cms_order_005'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
	header("Location: /cpanel/modules.php?result=success_removed");
	exit;
}
else {
	update_logs($conn, $_SESSION['username'], $lang[$code]['cms_order_006'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
	header("Location: /cpanel/modules.php?result=fail_removed");
	exit;
}