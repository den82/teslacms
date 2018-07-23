<?php
// Authorization form
// $type = 1 - after successfully installed form
// $type = 0 - usual form
function display_login_form($lang, $lang_code, $conn, $cms_login, $cms_password, $type) {
	if ($type == '1') {
		echo "<div class='alert alert-success' style='margin-top:35px;'>".$lang['installed']."</div>";
        $cms_login = 'admin';
        $cms_password = 'admin';
	}
	else {
		$cms_login = '';
        $cms_password = '';
	}

	echo "<form method='post' action='include/action.php' data-parsley-validate style='margin:50px 0;'>";
		echo "
		<p>
		".$lang['first_enter']."
		<input type='hidden' name='mode' value='signin'>
		<hr>
		<div class='form-group'>
			<label><b>".$lang['login']."</b></label>
			<input type='text' name='cms_login' class='form-control' id='exampleFormControlInput1' value='".$cms_login."' required>
		</div>

		<div class='form-group'>
			<label><b>".$lang['password']."</b></label>
			<input type='password' name='cms_password' class='form-control' id='exampleFormControlInput1' value='".$cms_password."' required>
		</div>

		<div class='form-group'>
	      <label for='exampleFormControlInput1'><b>".$lang['language']."</b></label>
	      <select name='language' class='form-control' style='width:200px;'>";
		        $lang_name = get_lang_name_by_code($conn, $lang_code);
		        echo "<option value='".$lang_code."' selected>".$lang_name."</option>";
		        $langs = get_other_langs($conn, $lang_code);
		        foreach ($langs as $row) {
		        	echo "<option value='".$row['code']."'>".$row['name']."</option>";
		        }
		        echo "
		    </select>
	    </div>

		<button type='submit' class='btn btn-primary mb-2'>".$lang['signin']."</button>

	</form>";

}

// Authorization checking
function get_auth($conn, $username, $password) {	
	$sql = "SELECT * FROM cms_admin WHERE username = '".$username."' and password = '".md5($password)."'";
	$result = mysqli_query($conn, $sql);
	if (!$result)
	  return false;
	$count_rows = mysqli_num_rows($result);
	if ($count_rows < 1)
	   return false;
	return true;
}

// Setting language
/*
function set_language($conn, $lang_code, $username) {
	$sql = "UPDATE cms_admin SET modifiedon = now(), modifiedby = '".$username."', lang = '".$lang_code."'  WHERE username = '".$username."' and status = '1'";
	$result = @mysqli_query($conn, $sql);
	if (!$result)
		return false;
	return true;
}
*/

// Check if password still equal 'admin'
function check_secure_password($conn) {	
	$sql = "SELECT id FROM cms_admin WHERE username = 'admin' and password = '".md5('admin')."'";
	$result = mysqli_query($conn, $sql);
	if (!$result)
	  return false;
	$count_rows = mysqli_num_rows($result);
	if ($count_rows < 1)
	   return false;
	return true;
}