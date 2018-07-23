<?php
session_start();
include('../../include/db.php');
include('install.php');
include('lang.php');
include('auth.php');
include('functions/f_mainpage.php');
include('functions/f_innerpage.php');
include('functions/f_menu.php');
include('functions/f_header_footer.php');
include('functions/f_products.php');
include('functions/f_security.php');
include('functions/f_accounts.php');

// Set coockies for language
if ($_COOKIE['code']) {
  $code = $_COOKIE['code'];
}
// Russian language as default
else {
  $code = 'ru';
}

// Intallation TeslaCMS
if ($_POST['mode'] == 'install') {
	/*
	$host = mysqli_real_escape_string($conn, $_POST['host']);
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);
	$dbname = mysqli_real_escape_string($conn, $_POST['dbname']);
	*/

	$lang = $_POST['lang'];
	$host = $_POST['host'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$dbname = $_POST['dbname'];
	
	if (empty($host) || empty($username) || empty($dbname)) {
		header("Location: ../../?result=empty&host=".$host."&username=".$username."&dbname=".$dbname);
		exit();
	}
	else {
		$file="../../include/config.php";

		$fo = fopen($file, "w");
		fclose($fo);
		
		$f=fopen($file,"a");
		$string = "<?php 
					return array(
				  	'host'     => '".$host."',
				    'username' => '".$username."',
				    'password' => '".$password."',
				    'dbname'   => '".$dbname."'
					);";
		fputs($f,$string);
		fclose($f);

		$conn = @mysqli_connect($host, $username, $password, $dbname);
		if (!$conn) {
			header("Location: ../../?result=wrong_data&host=".$host."&username=".$username."&dbname=".$dbname);
			exit();
		    //echo "Error: Unable to connect to MySQL." . PHP_EOL;
		    //echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
		    //echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
		    //exit;
		}

		if (import_tables($conn, $lang) == true) {
			update_logs($conn, $_SESSION['username'], $lang[$code]['001'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
			header("Location: ../?result=success");
			exit();
		}
		else {
			update_logs($conn, $_SESSION['username'], $lang[$code]['002'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
			header("Location: ../../?result=failed&host=".$host."&username=".$username."&dbname=".$dbname);
			exit();
		}
	}
}

// Authentication
if ($_POST['mode'] == 'signin') {
	if ($_POST['cms_login'] && $_POST['cms_password']) {
		// Sign in
		if (get_auth($conn, $_POST['cms_login'], $_POST['cms_password']) == true) {
			$_SESSION['username'] = $_POST['cms_login'];
			//set_language($conn, $_POST['language'], $_SESSION['username']);
			// Set language
			setcookie("code", $_POST['language'], time()+3600*24*90, "/", "", 0);
			// Note in logs
			update_logs($conn, $_SESSION['username'], $lang[$code]['003'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
			header("Location: ../../cpanel/");
			exit;
		}
		else {
			update_logs($conn, $_SESSION['username'], $lang[$code]['004'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
			header("Location: ../?result=signin_failed");
			exit();
		}
	}
	else {
		header("Location: ../?result=signin_empty");
		exit();
	}

}

// Disable main section on the main page
if (($_GET['section'] == 'main') && ($_GET['mode'] == 'disable')) {
	if (change_status($conn, $_GET['section'], '2', $_SESSION['username']) == true) {
		update_logs($conn, $_SESSION['username'], $lang[$code]['005'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
	}
	else {
		update_logs($conn, $_SESSION['username'], $lang[$code]['006'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
	}
	header("Location: ../mainpage.php");
	exit;
}
// Enable main section on the main page
if (($_GET['section'] == 'main') && ($_GET['mode'] == 'enable')) {
	if (change_status($conn, $_GET['section'], '1', $_SESSION['username']) == true) {
		update_logs($conn, $_SESSION['username'], $lang[$code]['007'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
	}
	else {
		update_logs($conn, $_SESSION['username'], $lang[$code]['008'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
	}
	header("Location: ../mainpage.php");
	exit;
}

// Disable main section on the products page
if (($_GET['section'] == 'products') && ($_GET['mode'] == 'disable')) {
	if (change_status($conn, $_GET['section'], '2', $_SESSION['username']) == true) {
		update_logs($conn, $_SESSION['username'], $lang[$code]['009'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
	}
	else {
		update_logs($conn, $_SESSION['username'], $lang[$code]['010'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
	}
	header("Location: ../mainpage.php");
	exit;
}
// Enable products section on the products page
if (($_GET['section'] == 'products') && ($_GET['mode'] == 'enable')) {
	if (change_status($conn, $_GET['section'], '1', $_SESSION['username']) == true) {
		update_logs($conn, $_SESSION['username'], $lang[$code]['011'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
	}
	else {
		update_logs($conn, $_SESSION['username'], $lang[$code]['012'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
	}
	header("Location: ../mainpage.php");
	exit;
}

// Disable free section on the main page
if (($_GET['section'] == 'free_section') && ($_GET['mode'] == 'disable')) {
	if (change_status($conn, $_GET['section'], '2', $_SESSION['username']) == true) {
		update_logs($conn, $_SESSION['username'], $lang[$code]['069'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
	}
	else {
		update_logs($conn, $_SESSION['username'], $lang[$code]['070'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
	}
	header("Location: ../mainpage.php");
	exit;
}
// Enable free_section on the main page
if (($_GET['section'] == 'free_section') && ($_GET['mode'] == 'enable')) {
	if (change_status($conn, $_GET['section'], '1', $_SESSION['username']) == true) {
		update_logs($conn, $_SESSION['username'], $lang[$code]['071'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
	}
	else {
		update_logs($conn, $_SESSION['username'], $lang[$code]['072'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
	}
	header("Location: ../mainpage.php");
	exit;
}

// Disable map section on the map page
if (($_GET['section'] == 'map') && ($_GET['mode'] == 'disable')) {
	if (change_status($conn, $_GET['section'], '2', $_SESSION['username']) == true) {
		update_logs($conn, $_SESSION['username'], $lang[$code]['013'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
	}
	else {
		update_logs($conn, $_SESSION['username'], $lang[$code]['014'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
	}
	header("Location: ../mainpage.php");
	exit;
}
// Enable map section on the map page
if (($_GET['section'] == 'map') && ($_GET['mode'] == 'enable')) {
	if (change_status($conn, $_GET['section'], '1', $_SESSION['username']) == true) {
		update_logs($conn, $_SESSION['username'], $lang[$code]['015'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
		$_SESSION['msg'] = "<div class='mes_blue'>map section has been turned on!</div>";
	}
	else {
		update_logs($conn, $_SESSION['username'], $lang[$code]['016'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
	}
	header("Location: ../mainpage.php");
	exit;
}

// Edit main page - main block
if ($_POST['mode'] == 'main_page_edit') {
	// Edit meta section
	if ($_POST['submode'] == 'meta') {
		if (edit_fp_meta($conn, $_POST, $_SESSION['username']) == true) {
			update_logs($conn, $_SESSION['username'], $lang[$code]['017'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
			header("Location: ../mainpage.php?result=success");
			exit;
		}
		else {
			update_logs($conn, $_SESSION['username'], $lang[$code]['018'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
			header("Location: ../mainpage.php?result=fail");
			exit;
		}
	}
	// Edit main section
	if ($_POST['submode'] == 'main') {
		if (edit_fp_main($conn, $_POST, $_SESSION['username']) == true) {
			update_logs($conn, $_SESSION['username'], $lang[$code]['019'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
			header("Location: ../mainpage.php?result=success");
			exit;
		}
		else {
			update_logs($conn, $_SESSION['username'], $lang[$code]['020'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
			header("Location: ../mainpage.php?result=fail");
			exit;
		}
	}
	// Edit map section
	if ($_POST['submode'] == 'map') {
		if (edit_fp_map($conn, $_POST, $_SESSION['username']) == true) {
			update_logs($conn, $_SESSION['username'], $lang[$code]['021'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
			header("Location: ../mainpage.php?result=success");
			exit;
		}
		else {
			update_logs($conn, $_SESSION['username'], $lang[$code]['022'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
			header("Location: ../mainpage.php?result=fail");
			exit;
		}
	}
	// Products section
	if ($_POST['submode'] == 'products') {
		// Add new item
		if ($_POST['subtype'] == 'add') {
			if ($_FILES['product_img']['tmp_name']) {
				$size = getimagesize($_FILES['product_img']['tmp_name']);
				// If perimeter of the image is not equal to 256x256 then error.
				if (($size[0] != '391') && ($size[1] != '260')) {
					update_logs($conn, $_SESSION['username'], $lang[$code]['023'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
					header("Location: /cpanel/mainpage.php?mode=edit&type=products&subtype=add&result=product_img_fail");
					exit;
				}
			}
			if (add_product($conn, $_POST, $_FILES, $_SESSION['username']) == true) {
				update_logs($conn, $_SESSION['username'], $lang[$code]['024'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
				header("Location: /cpanel/mainpage.php?mode=edit&type=products&result=success");
				exit;
			}
			else {
				update_logs($conn, $_SESSION['username'], $lang[$code]['025'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
				header("Location: /cpanel/mainpage.php?mode=edit&type=products&result=fail");
				exit;
			}
		}
		// Edit item
		if ($_POST['subtype'] == 'edit') {
			if ($_FILES['product_img']['tmp_name']) {
				$size = getimagesize($_FILES['product_img']['tmp_name']);
				// If perimeter of the image is not equal to 256x256 then error.
				if (($size[0] != '391') && ($size[1] != '260')) {
					update_logs($conn, $_SESSION['username'], $lang[$code]['023'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
					header("Location: /cpanel/mainpage.php?mode=edit&type=products&subtype=edit&id=".$_POST['id']."&result=product_img_fail");
					exit;
				}
			}
			if (edit_product($conn, $_POST, $_FILES, $_SESSION['username']) == true) {
				update_logs($conn, $_SESSION['username'], $lang[$code]['026'].": <b>".$_POST['product_title']."</b>", $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
				header("Location: ../mainpage.php?mode=edit&type=products&result=success");
				exit;
			}
			else {
				update_logs($conn, $_SESSION['username'], $lang[$code]['027'].": <b>".$_POST['product_title']."</b>", $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
				header("Location: ../mainpage.php?mode=edit&type=products&result=fail");
				exit;
			}
		}
		// Settings
		if ($_POST['subtype'] == 'settings') {
			if (edit_product_settings($conn, $_POST, $_SESSION['username']) == true) {
				update_logs($conn, $_SESSION['username'], $lang[$code]['075'].": <b>".$_POST['product_title']."</b>", $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
				header("Location: ../mainpage.php?mode=edit&type=products&result=product_settings_success");
				exit;
			}
			else {
				update_logs($conn, $_SESSION['username'], $lang[$code]['076'].": <b>".$_POST['product_title']."</b>", $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
				header("Location: ../mainpage.php?mode=edit&type=products&result=product_settings_fail");
				exit;
			}
		}
	}
	// Edit main section
	if ($_POST['submode'] == 'free_section') {
		if (edit_fp_free_section($conn, $_POST, $_SESSION['username']) == true) {
			update_logs($conn, $_SESSION['username'], $lang[$code]['073'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
			header("Location: ../mainpage.php?result=success");
			exit;
		}
		else {
			update_logs($conn, $_SESSION['username'], $lang[$code]['074'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
			header("Location: ../mainpage.php?result=fail");
			exit;
		}
	}
}

// Delete product page
if ($_GET['mode'] == 'product_delete') {
	$product_name = get_product_name_by_id($conn, $_GET['id']);
	if (delete_product_page($conn, $_GET['id']) == true) {
		update_logs($conn, $_SESSION['username'], $lang[$code]['067'].": <b>".$product_name."</b>", $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
		header("Location: ../mainpage.php?mode=edit&type=products&result=product_success_deleted");
		exit;
	}
	else {
		update_logs($conn, $_SESSION['username'], $lang[$code]['068'].": <b>".$product_name."</b>", $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
		header("Location: ../mainpage.php?mode=edit&type=products&result=product_fail_deleted");
		exit;
	}
}
		
// Add inner page
if ($_POST['mode'] == 'inner_page_add') {
	if (check_unique_page($conn, $_POST['link']) == true) {
		update_logs($conn, $_SESSION['username'], $lang[$code]['034']." <b>".$_POST['headline']."</b>", $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
		header("Location: ../innerpage.php?id=".$_POST['id']."&mode=add&result=page_not_unique&title=".$_POST['title']."&description=".$_POST['description']."&keywords=".$_POST['keywords']."&headline=".$_POST['headline']."&link=".$_POST['link']."&content=".$_POST['content']."");
		exit;
	}
	else {
		if (insert_inner_page($conn, $_POST, $_SESSION['username']) == true) {
			update_logs($conn, $_SESSION['username'], $lang[$code]['028'].": <b>".$_POST['headline']."</b>", $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
			header("Location: ../innerpage.php?id=".$_POST['id']."&mode=getin&result=success_added");
			exit;
		}
		else {
			update_logs($conn, $_SESSION['username'], $lang[$code]['029'].": <b>".$_POST['headline']."</b>", $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
			header("Location: ../innerpage.php?id=".$_POST['id']."&mode=getin&result=fail_added");
			exit;
		}
	}
}

// Edit inner page
if ($_POST['mode'] == 'inner_page_edit') {
	$_POST['link'] = mb_strtolower($_POST['link']);
	if (edit_inner_page($conn, $_POST, $_SESSION['username']) == true) {
		update_logs($conn, $_SESSION['username'], $lang[$code]['030'].": <b>".$_POST['headline']."</b>", $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
		header("Location: ../innerpage.php?id=".$_POST['pid']."&mode=getin&result=success_edited");
		exit;
	}
	else {
		update_logs($conn, $_SESSION['username'], $lang[$code]['031'].": <b>".$_POST['headline']."</b>", $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
		header("Location: ../innerpage.php?id=".$_POST['pid']."&mode=edit&result=fail_edited");
		exit;
	}
}

// Delete inner page
if ($_GET['mode'] == 'page_delete') {
	$headline = get_name_by_id($conn, $_GET['id']);
	if (delete_inner_page($conn, $_GET['id']) == true) {
		update_logs($conn, $_SESSION['username'], $lang[$code]['060'].": <b>".$headline."</b>", $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
		header("Location: ../innerpage.php?id=".$_POST['pid']."&mode=getin&result=success_deleted");
		exit;
	}
	else {
		update_logs($conn, $_SESSION['username'], $lang[$code]['061'].": <b>".$headline."</b>", $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
		header("Location: ../innerpage.php?id=".$_POST['pid']."&mode=edit&result=fail_deleted");
		exit;
	}
}

// Edit header
if ($_POST['mode'] == 'header_edit') {
	if ($_FILES['header_logo']['tmp_name']) {
		$size = getimagesize($_FILES['header_logo']['tmp_name']);
		// If perimeter of the image is not equal to 256x256 then error.
		if (($size[0] > '200') || ($size[1] > '90')) {
			update_logs($conn, $_SESSION['username'], $lang[$code]['033'], $_SERVER['REMOTE_ADDR'], $_SERVER["HTTP_USER_AGENT"]);
			header("Location: /cpanel/header_footer.php?mode=edit&submode=header&result=logo_fail");
			exit;
		}
	}
	if (header_edit($conn, $_POST, $_FILES, $_SESSION['username']) == true) {
		update_logs($conn, $_SESSION['username'], $lang[$code]['034'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
		header("Location: ../header_footer.php?id=".$_POST['id']."&result=header_success");
		exit;
	}
	else {
		update_logs($conn, $_SESSION['username'], $lang[$code]['035'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
		header("Location: ../header_footer.php?id=".$_POST['id']."&result=header_fail");
		exit;
	}
}

// Edit footer
if ($_POST['mode'] == 'footer_edit') {
	if (footer_edit($conn, $_POST, $_FILES, $_SESSION['username']) == true) {
		update_logs($conn, $_SESSION['username'], $lang[$code]['036'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
		header("Location: ../header_footer.php?id=".$_POST['id']."&result=footer_success");
		exit;
	}
	else {
		update_logs($conn, $_SESSION['username'], $lang[$code]['037'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
		header("Location: ../header_footer.php?id=".$_POST['id']."&result=footer_fail");
		exit;
	}
}

// Edit menu settings
if ($_POST['mode'] == 'menu') {
	if ($_POST['submode'] == 'edit') {
		if (edit_menu($conn, $_POST) == true) {
			update_logs($conn, $_SESSION['username'], $lang[$code]['038'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
			header("Location: ../navigation.php?menu_id=".$_POST['menu_id']."&result=success");
			exit;
		}
		else {
			update_logs($conn, $_SESSION['username'], $lang[$code]['039'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
			header("Location: ../navigation.php?menu_id=".$_POST['menu_id']."&result=fail");
			exit;
		}
	}
}

// Create account
if ($_POST['mode'] == 'account_create') {
	if (account_create($conn, $_POST, $_SESSION['username']) == true) {
		update_logs($conn, $_SESSION['username'], $lang[$code]['040'].": <b>".$_POST['username']."</b>", $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
		header("Location: ../accounts.php?id=".$_POST['id']."&result=success_created");
		exit;
	}
	else {
		update_logs($conn, $_SESSION['username'], $lang[$code]['041'].": <b>".$_POST['username']."</b>", $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
		header("Location: ../accounts.php?id=".$_POST['id']."&result=fail_created");
		exit;
	}
}

// Edit account
if ($_POST['mode'] == 'account_edit') {
	if (account_edit($conn, $_POST, $_SESSION['username']) == true) {
		update_logs($conn, $_SESSION['username'], $lang[$code]['042'].": <b>".$_POST['username']."</b>", $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
		header("Location: ../accounts.php?id=".$_POST['id']."&result=success_saved");
		exit;
	}
	else {
		update_logs($conn, $_SESSION['username'], $lang[$code]['043'].": <b>".$_POST['username']."</b>", $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
		header("Location: ../accounts.php?id=".$_POST['id']."&result=fail_saved");
		exit;
	}
}

// Delete account
if ($_GET['mode'] == 'account_delete') {
	if (account_delete($conn, $_GET['id'], $_SESSION['username']) == true) {
		update_logs($conn, $_SESSION['username'], $lang[$code]['044']." <b>".$_POST['username']."</b>", $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
		header("Location: ../accounts.php?id=".$_GET['id']."&result=success_deleted");
		exit;
	}
	else {
		update_logs($conn, $_SESSION['username'], $lang[$code]['045']." <b>".$_POST['username']."</b>", $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
		header("Location: ../accounts.php?id=".$_GET['id']."&result=fail_deleted");
		exit;
	}
}

// Change password
if ($_POST['mode'] == 'password_change') {
	if ($_SESSION['username'] != 'admin') {
		if (get_current_password($conn, $_POST, $_SESSION['username']) == true) {
			if (password_change($conn, $_POST, $_SESSION['username']) == true) {
				update_logs($conn, $_SESSION['username'], $lang[$code]['046']." <b>".$_POST['username']."</b>", $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
				header("Location: ../accounts.php?id=".$_POST['id']."&result=password_changed");
				exit;
			}
			else {
				update_logs($conn, $_SESSION['username'], $lang[$code]['047']." <b>".$_POST['username']."</b>", $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
				header("Location: ../accounts.php?id=".$_POST['id']."&result=fail");
				exit;
			}
		}
		else {
			update_logs($conn, $_SESSION['username'], $lang[$code]['048']." <b>".$_POST['username']."</b>", $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
			header("Location: ../accounts.php?id=".$_POST['id']."&result=current_password_fail");
			exit;
		}
	}
	else {
		if (password_change($conn, $_POST, $_SESSION['username']) == true) {
			update_logs($conn, $_SESSION['username'], $lang[$code]['046']." <b>".$_POST['username']."</b>", $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
			header("Location: ../accounts.php?id=".$_POST['id']."&result=password_changed");
			exit;
		}
		else {
			update_logs($conn, $_SESSION['username'], $lang[$code]['047']." <b>".$_POST['username']."</b>", $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
			header("Location: ../accounts.php?id=".$_POST['id']."&result=fail");
			exit;
		}
	}
}

// Security
if ($_POST['mode'] == 'security') {
	if (white_ip_list_edit($conn, $_POST, $_SESSION['username']) == true) {
		update_logs($conn, $_SESSION['username'], $lang[$code]['049'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
		header("Location: ../security.php?result=success");
		exit;
	}
	else {
		update_logs($conn, $_SESSION['username'], $lang[$code]['050'], $_SERVER['REMOTE_ADDR'], $_SERVER['HTTP_USER_AGENT']);
		header("Location: ../security.php?result=fail");
		exit;
	}
}

//$cms_login = mysqli_real_escape_string($conn, $_POST['cms_login']);
//$cms_password = mysqli_real_escape_string($conn, $_POST['cms_password']);