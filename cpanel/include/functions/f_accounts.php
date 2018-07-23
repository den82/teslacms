<?php

// Delete account by id
function account_delete($conn, $id, $username) {
	if ($username == 'admin') {
		$sql = "DELETE FROM cms_admin WHERE id = '".$id."'";
		$result = mysqli_query($conn, $sql);
		if (!$result)
		 return false;
		return true;
	}
	else {
		return false;
	}
}

// Create account
function account_create($conn, $array, $username) {
	$sql = "INSERT INTO cms_admin VALUES (
	'', 
	now(), 
	now(), 
	'".$username."',
	'',
	'".$array['username']."', 
	'".md5($array['password'])."', 
	'".$array['email']."',  
	'".$array['name']."',
	'".$array['surname']."',
	'".$array['position']."',
	'1,1,1',
	'ru',
	'".$array['status']."'
	)";
	$result = mysqli_query($conn, $sql);
	if (!$result)
	return false;
	return true; 
}

// Edit account
function account_edit($conn, $array, $username) {
	$sql = "UPDATE cms_admin SET 
	modifiedon = now(), 
	modifiedby = '".$username."', 
	username = '".$array['username']."', 
	email = '".$array['email']."', 
	name = '".$array['name']."', 
	surname = '".$array['surname']."', 
	position = '".$array['position']."',
	status = '".$array['status']."'
	WHERE id = '".$array['id']."'";
	$result = @mysqli_query($conn, $sql);
	if (!$result)
	  return false;
	return true;
}

// Change password
function password_change($conn, $array, $username) {
	$sql = "UPDATE cms_admin SET 
	modifiedon = now(), 
	modifiedby = '".$username."', 
	password = '".md5($array['password'])."'
	WHERE id = '".$array['id']."'";
	$result = @mysqli_query($conn, $sql);
	if (!$result)
	  return false;
	return true;
}

// Get account by id
function get_account_by_id($conn, $id) {
	$sql = "SELECT * FROM cms_admin WHERE id = '".$id."'"; 
	$result = mysqli_query($conn, $sql);
	if (!$result)
	 return false;
	$count_rows = mysqli_num_rows($result);
	if ($count_rows < 1)
	  return false;  
	$result = mysqli_fetch_assoc($result);
    return $result;
}

// Get current password
function get_current_password($conn, $array, $username) {
	$sql = "SELECT id FROM cms_admin WHERE id = '".$array['id']."' and password = '".md5($array['current_password'])."'";
	$result = mysqli_query($conn, $sql);
	if (!$result)
	 return false;
	$count_rows = mysqli_num_rows($result);
	if ($count_rows < 1)
	  return false; 
    return true;
}

// Get all accounts
function get_accounts($conn) {
	$sql = "SELECT * FROM cms_admin order by id ASC"; 
	$result = mysqli_query($conn, $sql);
	if (!$result)
	 return false;
	$count_rows = mysqli_num_rows($result);
	if ($count_rows < 1)
	  return false;  
	$result = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $result; 
}

// Display all accounts
function display_accounts($array, $username, $lang) {
?>
	<div class='headline'><h1><?php echo $lang['accounts'];?></h1></div>
	
	<div class="table-responsive">
	  <table class="table" style="width:100%">
	  <thead>
	    <tr>
	      <th scope="col" style="width:5%; border-top: 0px; border-bottom: 0px;">Id</th>
	      <th scope="col" style="width:15%; border-top: 0px; border-bottom: 0px;"><?php echo $lang['Username'];?></th>
	      <th scope="col" style="width:15%; border-top: 0px; border-bottom: 0px;"><?php echo $lang['name'];?></th>
	      <th scope="col" style="width:15%; border-top: 0px; border-bottom: 0px;">E-mail</th>
	      <th scope="col" style="width:15%; border-top: 0px; border-bottom: 0px; text-align:center;" colspan="3"><?php echo $lang['actions'];?></th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php
	  	foreach ($array as $row) {
	  		if ($row['status'] == '1') {
				$access = "Открыт";
			}
			if ($row['status'] == '2') {
				$access = "Закрыт";
			}
		  	echo "
		    <tr>
		      <th scope='row'>".$row['id']."</th>
		      <td>".$row['username']."</td>
		      <td>".$row['name']." ".$row['surname']."</td>
		      <td>".$row['email']."</td>
		      <td style='text-align:center;'>";
				if (($row['username'] == $username) || ($username == 'admin')) {
					echo "<a href='accounts.php?id=".$row['id']."&mode=edit'><img src='img/icons/edit.gif' border='0' width='16' height='16' alt='".$lang['edit']."' title='".$lang['edit']."'></a>";
				}
			  echo "
			  </td>
			  <td style='text-align:center;'>";
			  if (($row['username'] == $username) || ($username == 'admin')) {
			  	echo "<a href='accounts.php?id=".$row['id']."&mode=password'><img src='img/icons/accounts.gif' border='0' width='16' height='16' alt='".$lang['change password']."' title='".$lang['change password']."'></a>";
				}
			  echo "
			  </td>
			  <td style='text-align:center;'>";
			  if (($username == 'admin') && ($row['username'] != 'admin')) {
			  	echo "<a href='include/action.php?id=".$row['id']."&mode=account_delete'><img src='img/icons/delete.gif' border='0' width='16' height='16' alt='".$lang['delete account']."' title='".$lang['delete account']."' onclick=\"return confirm('".$lang['are you sure']."');\"></a>";
			  }
			  echo "
			  </td>
		    </tr>
		    ";
		}
	    ?>
	  </tbody>
	  </table>
	</div>

	<?php
	if ($username == 'admin') {
	?>
	<p>
	<a href="/cpanel/accounts.php?id=1&mode=create"><img src="img/icons/add.gif"> <?php echo $lang['сreate new account'];?></a>
	<?php
	}
}

// Display account create form
function display_account_create_form($username, $lang) {
	?>
	<div class="headline"><h1><?php echo $lang['сreate new account'];?></h1></div>

    <form method="post" action="include/action.php" data-parsley-validate>
    	<input type="hidden" name='mode' value='account_create'>	

		<div class="form-group">
	      <label for="exampleFormControlInput1"><b><?php echo $lang['Username'];?> <font color="red">*</font></b></label>
	      <input type="text" class="form-control" name="username" id="username" value="" required>
	    </div>

	    <div class="form-group">
	      <label for="exampleFormControlInput1"><b><?php echo $lang['password'];?> <font color="red">*</font></b></label>
	      <input type="password" class="form-control" name="password" id="password" value="" minlength="8"  required>
	    </div>

	    <div class="form-group">
	      <label for="exampleFormControlInput1"><b><?php echo $lang['confirm password'];?> <font color="red">*</font></b></label>
	      <input type="password" class="form-control" name="password2" id="password2" value="" data-parsley-equalto="#password" required>
	    </div>

	    <div class="form-group">
	      <label for="exampleFormControlInput1"><b>E-mail</b></label>
	      <input type="email" class="form-control" name="email" id="email" value="" required>
	    </div>

	    <div class="form-group">
	      <label for="exampleFormControlInput1"><b><?php echo $lang['name'];?></b></label>
	      <input type="text" class="form-control" name="name" id="name" value="">
	    </div>

	    <div class="form-group">
	      <label for="exampleFormControlInput1"><b><?php echo $lang['surname'];?></b></label>
	      <input type="text" class="form-control" name="surname" id="surname" value="">
	    </div>

	    <div class="form-group">
	      <label for="exampleFormControlInput1"><b><?php echo $lang['position'];?></b></label>
	      <input type="text" class="form-control" name="position" id="position" value="">
	    </div>

		<?php if ($username == 'admin') { ?>
		
		<div class="form-group">
	      <label for="exampleFormControlInput1"><b><?php echo $lang['status'];?> <font color="red">*</font></b></label>
	      <select name="status" class="form-control" style="width:200px;">
	          <option value='1'><?php echo $lang['active'];?></option>
	          <option value='2'><?php echo $lang['no active'];?></option>
		  </select>
	    </div>

		<?php } ?>
		
		<input type="submit" name='submit' value="<?php echo $lang['create'];?>" class='btn btn-primary mb-2'>

    </form>
<?php
}

// Display account edit form
function display_account_edit_form($array, $username, $lang) {
	?>
	
	<div class="headline"><h1><?php echo $lang['account update']; ?>: <?php echo $array['username']; ?></h1></div>

    <form method="post" action="include/action.php" data-parsley-validate>
    	<input type="hidden" name='mode' value='account_edit'>	
    	<input type="hidden" name='id' value='<?php echo $array['id']; ?>'>
		
		<?php
		if (($array['username'] == 'admin') || ($username != 'admin')) {
			$disabled = "disabled";
			echo "<input type='hidden' name='username' value='".$array['username']."'>";
		}
		?>

		<div class="form-group">
	      <label for="exampleFormControlInput1"><b><?php echo $lang['Username']; ?> <font color="red">*</font></b></label>
	      <input type="text" class="form-control" name="username" id="username" value="<?php echo $array['username']; ?>" <?php echo $disabled; ?>>
	    </div>

	    <div class="form-group">
	      <label for="exampleFormControlInput1"><b>E-mail</b></label>
	      <input type="email" class="form-control" name="email" id="email" value="<?php echo $array['email']; ?>" required>
	    </div>

	    <div class="form-group">
	      <label for="exampleFormControlInput1"><b><?php echo $lang['name']; ?></b></label>
	      <input type="text" class="form-control" name="name" id="name" value="<?php echo $array['name']; ?>">
	    </div>

	    <div class="form-group">
	      <label for="exampleFormControlInput1"><b><?php echo $lang['surname']; ?></b></label>
	      <input type="text" class="form-control" name="surname" id="surname" value="<?php echo $array['surname']; ?>">
	    </div>

	    <div class="form-group">
	      <label for="exampleFormControlInput1"><b><?php echo $lang['position']; ?></b></label>
	      <input type="text" class="form-control" name="position" id="position" value="<?php echo $array['position']; ?>">
	    </div>
		<!--
	    <div class="form-group">
	      <label for="exampleFormControlInput1"><b><?php //echo $lang['language']; ?> <font color="red">*</font></b></label>
	      <select name="language" class="form-control" style="width:200px;">
	      -->
		        <?php
		        /*
		        $lang = get_lang_name_by_id($array['lang_id']);
		        echo "<option value='".$array['lang_id']."' selected>".$lang."</option>";
		        $langs = get_other_langs();
		        foreach ($langs as $row) {
		        	echo "<option value='".$row['id']."'>".$row['title']."</option>";
		        }
		        */
		        ?>
		        <!--
		    </select>
	    </div>
	    -->

		<?php if (($username == 'admin') && ($array['username'] != 'admin')) { ?>
		
		<div class="form-group">
	      <label for="exampleFormControlInput1"><b><?php echo $lang['status']; ?> <font color="red">*</font></b></label>
	      <select name="status" class="form-control" style="width:200px;">
		        <?php
		        if ($array['status'] == '1') {
		          echo "
		          <option value='1'>".$lang['account open']."</option>
		          <option value='2'>".$lang['account close']."</option>
		          ";
		        }
		        else {
		          echo "
		          <option value='1'>".$lang['account open']."</option>
		          <option value='2' selected>".$lang['account close']."</option>
		          ";
		        }
		        ?>
		    </select>
	    </div>

		<?php } ?>
		
		<input type="submit" name='submit' value="<?php echo $lang['save']; ?>" class='btn btn-primary mb-2'>

    </form>
<?php
}

// Display account password form
function display_account_password_form($array, $username, $lang) {
	?>
	<div class="headline"><h1><?php echo $lang['сhange password for user'];?>: <?php echo $array['username']; ?></h1></div>

    <form method="post" action="include/action.php" data-parsley-validate>
    	<input type="hidden" name='mode' value='password_change'>	
    	<input type="hidden" name='id' value='<?php echo $array['id']; ?>'>

    	<?php
    	if ($username != 'admin') {
    	?>
    	<div class="form-group">
	      <label for="exampleFormControlInput1"><b><?php echo $lang['current password'];?> <font color="red">*</font></b></label>
	      <input type="password" class="form-control" name="current_password" id="current_password" value="" minlength="5"  required>
	    </div>
		
		<?php } ?>

	    <div class="form-group">
	      <label for="exampleFormControlInput1"><b><?php echo $lang['new password'];?> <font color="red">*</font></b></label>
	      <input type="password" class="form-control" name="password" id="password" value="" minlength="5"  required>
	    </div>

	    <div class="form-group">
	      <label for="exampleFormControlInput1"><b><?php echo $lang['confirm password'];?> <font color="red">*</font></b></label>
	      <input type="password" class="form-control" name="password2" id="password2" value="" data-parsley-equalto="#password" required>
	    </div>
		
		<input type="submit" name='submit' value="<?php echo $lang['save'];?>" class='btn btn-primary mb-2'>

    </form>
<?php
}