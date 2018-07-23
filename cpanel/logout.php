<?php
session_start();
//setcookie('login', '', time()-10800, '/', '.sites-admin.ru');
//setcookie('login', '', time()-10800, '/ru/login/', '.sites-admin.ru');
session_destroy();
header("Location: /cpanel/");
exit;
?>