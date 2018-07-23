<?php
// Update logs
function update_logs($conn, $login, $action, $ip, $system) {
	$sql = "INSERT INTO cms_logs VALUES ('', now(), now(), '".$login."', '".$action."', '".$ip."', '".$system."')";
	$result = mysqli_query($conn, $sql);
	if (!$result)
	 return false;
	return true; 
}

// Get logs
function get_logs($conn, $count) {
   $sql = "SELECT * FROM cms_logs ORDER BY created_on DESC LIMIT ".$count.""; 
   $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;  
   $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
   return $result;
}

// Get white ip list
function get_white_ip_list($conn) {
   $sql = "SELECT ip FROM cms_white_ip_list WHERE id = '1'"; 
   $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;  
   $result = mysqli_fetch_assoc($result);
   return $result['ip'];
}

// Edit white ip list
function white_ip_list_edit($conn, $array, $username) {
  $array['white_ip_list'] = str_replace(" ", "", $array['white_ip_list']);
  $sql = "UPDATE cms_white_ip_list SET 
  modifiedon = now(), 
  modifiedby = '".$username."',
  ip = '".$array['white_ip_list']."'
  WHERE id = '1'";

  $result = @mysqli_query($conn, $sql);
  if (!$result)
   return false;
  return true;
}

// Display security section
function display_security($lang) {
	?>
		
	<div class="headline"><h1><?php echo $lang['security']; ?></h1></div>

	<form action="" method="post">
	<div class="table-responsive">
	  <table class="table" style="width:100%">
	  <thead>
	    <tr>
	      <th scope="col" style="width:90%; border-top: 0px; border-bottom: 0px;"><?php echo $lang['section']; ?></th>
	      <th scope="col" style="width:10%; border-top: 0px; border-bottom: 0px; text-align: center;"><?php echo $lang['actions']; ?></th>
	    </tr>
	  </thead>
	  <tbody>
	    <tr>
	      <td><?php echo $lang['white ip list']; ?></td>
	      <td style="text-align: center;">
	        <a href="/cpanel/security.php?mode=edit&type=white_ip_list"><img src="img/icons/edit.gif" border="0" width="16" height="16" alt="<?php echo $lang['edit']; ?>" title="<?php echo $lang['edit']; ?>"></a>
	      </td>
	    </tr>
	    <tr>
	      <td><?php echo $lang['logs']; ?></td>
	      <td style="text-align: center;">
	        <a href="/cpanel/security.php?mode=show&type=logs"><img src="img/icons/getin.gif" border="0" width="16" height="16" alt="<?php echo $lang['show']; ?>" title="<?php echo $lang['show']; ?>"></a>
	      </td>
	    </tr>
	  </tbody>
	  </table>
	</div>
	</form>
 <?php
}

// Display white ip list edit form
function display_white_ip_list($ip_list, $lang) {
  ?>
  <div class="headline"><h1><?php echo $lang['white ip list']; ?></h1></div>

  <form method="post" action="include/action.php">
    <input type="hidden" name='mode' value="security">
    <input type="hidden" name='submode' value="white_list_ip">
    <input type="hidden" name='subtype' value="edit">
	
    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['white ip list']; ?> (<?php echo $lang['use comma']; ?>) <font color="red">*</font></b><br>
     <?php echo $lang['to prevent unapproved entrance']; ?> <b><?php echo $_SERVER['REMOTE_ADDR'];?></b>
      </label><br>
<textarea name="white_ip_list" id="white_ip_list" rows="10" cols="80">
<?php echo $ip_list; ?>
</textarea>
    </div>

    <button type='submit' class='btn btn-primary mb-2'><?php echo $lang['save']; ?></button>
  </form>
  <?php
}

// Display logs
function display_logs($logs, $lang) {
	?>
	<div class="headline"><h1><?php echo $lang['logs']; ?></h1></div>

	<div class="table-responsive">
	  <table class="table" style="width:100%">
	  <thead>
	    <tr>
	      <th scope="col" style="width:5%; border-top: 0px; border-bottom: 0px;">Id</th>
	      <th scope="col" style="width:15%; border-top: 0px; border-bottom: 0px;"><?php echo $lang['date an time']; ?></th>
	      <th scope="col" style="width:15%; border-top: 0px; border-bottom: 0px;"><?php echo $lang['username']; ?></th>
	      <th scope="col" style="width:15%; border-top: 0px; border-bottom: 0px;">IP</th>
	      <th scope="col" style="width:50%; border-top: 0px; border-bottom: 0px;"><?php echo $lang['action']; ?></th>
	    </tr>
	  </thead>
	  <tbody>
	  	<?php
	  	foreach ($logs as $row) {
	  	echo "
	    <tr>
	      <th scope='row'>".$row['id']."</th>
	      <td>".date("d.m.Y H:i:s", strtotime($row['datetime']))."</td>
	      <td>".$row['username']."</td>
	      <td>".$row['ip']."</td>
	      <td>".$row['action']."</td>
	    </tr>";
		}
	    ?>
	  </tbody>
	  </table>
	</div>
<?php
}
?>