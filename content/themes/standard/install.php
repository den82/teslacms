<?php
// Theme installation
session_start();
include('../../../include/db.php');

$theme_dir = 'standard';
$theme_name = 'Стандартная тема';

// Устанавливаем все флаги в таблице cms_themes в значение 0 (все темы деактивированы)
//reset_flags_in_themes($conn, $_SESSION['username']);
delete_themes($conn);
// Добавляем строку в таблицу с новой темой
if (insert_row_in_themes($conn, $_SESSION['username'], $theme_dir, $theme_name) == true) {
	header("Location: /cpanel/themes.php?result=success_install");
	exit;
}
else {
	header("Location: /cpanel/themes.php?result=fail_install");
	exit;
}

// Delete all rows in cms_themes
// 2018
function delete_themes($conn) {
	$sql = "DELETE from cms_themes";
	$result = @mysqli_query($conn, $sql);
	if (!$result)
	 return false;
	return true;
}

// Insert new row with new theme
// 2018
function insert_row_in_themes($conn, $username, $theme_dir, $theme_name) {
	$sql = "
	INSERT INTO cms_themes (id, createdon, modifiedon, createdby, modifiedby, dir, name, status) VALUES (
	'',
	now(),
	now(),
	'".$username."',
	'',
	'".$theme_dir."',
	'".$theme_name."',
	'1'
	);
	";
	$result = mysqli_query($conn, $sql);
	if (!$result)
	 return false;
	return true; 
}

// Reset 
function reset_flags_in_themes($conn, $login) {
	$sql = "UPDATE cms_themes SET 
	modifiedon = now(), 
	modifiedby = '".$login."',
	flag = '0'
	WHERE flag = '1'";
	$result = @mysqli_query($conn, $sql);
	if (!$result)
		return false;
	return true;
}

function check_theme_in_db($conn, $login, $dir) {
  $sql = "select id from cms_themes WHERE dir = '".$dir."'";
  $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;
   return true;
}

function update_row_in_themes($conn, $login, $dir) {
	$sql = "UPDATE cms_themes SET 
	modifiedon = now(), 
	modifiedby = '".$login."',
	flag = '1'
	WHERE dir = '".$dir."'";
	$result = @mysqli_query($conn, $sql);
	if (!$result)
		return false;
	return true;
}