<?php
session_start();
include('../../include/db.php');
include('auth.php');
include('functions/f_products.php');
include('functions/f_logs.php');

// Sorting products on the main page
if ($_POST['item']) {
	//$_POST['item'] = array_reverse($_POST['item']);
	$i=0;
	foreach ($_POST['item'] as $value) {
		$sql = "UPDATE cms_products SET sort = '".$i."' WHERE id = '".$value."'";
		$result = mysqli_query($conn, $sql);
	    $i++;
	}
}