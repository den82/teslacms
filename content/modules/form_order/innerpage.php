<?php
//$array = get_form_array_by_id($page['submid']);
include('functions.php');

if ($_SESSION['success']) {
	echo $_SESSION['success']; 
	unset($_SESSION['success']);
}
if ($_SESSION['fail']) {
	echo $_SESSION['fail'];
	unset($_SESSION['fail']); 
}

//$settings = get_settings_form_order($conn);
display_form_order();
?>