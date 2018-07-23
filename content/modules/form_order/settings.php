<?php
//$array = get_form_array_by_id($page['submid']);
include('functions.php');

if ($_GET['result'] == 'success') {
	echo "<div class='alert alert-success' role='alert'>Настройки сохранены!</div>"; 
}
if ($_GET['result'] == 'fail') {
	echo "<div class='alert alert-danger' role='alert'>Настройки не сохранены!</div>";
}
$settings = get_settings_form_order($conn);
display_settings_form_order($settings);
?>