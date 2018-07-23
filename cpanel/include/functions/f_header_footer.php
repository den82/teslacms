<?php

// Get header and footer data
function get_header_footer($conn) {
   $sql = "SELECT * FROM cms_header_footer WHERE id = '1'";
   $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;  
   $result = mysqli_fetch_assoc($result);
   return $result;
}

// Edit header
function header_edit($conn, $array, $files, $username) {
	if ($files['header_logo']['tmp_name'] != '') {
		$uploaddir = "../../content/userfiles/images/";
		$uploadfile = $uploaddir.basename($files['header_logo']['name']);
		// Copy file from catalog for temporary storage:
		copy($files['header_logo']['tmp_name'], $uploadfile);
		rename($uploadfile, "../../content/userfiles/images/header_logo.png");
		$img_base = "/content/userfiles/images/header_logo.png";
		//img_resize($photo_base, $photo1_s, 130, 68, $rgb=0xFFFFFF, $quality=100);
		$header_logo = "header_logo = '".$img_base."',";
	}
	else {
		$header_logo = "";
	}

	$array['header_center_section'] = str_replace("'", "\'", $array['header_center_section']);

	$sql = "UPDATE cms_header_footer SET 
	".$header_logo."
	header_bg = '".$array['header_bg']."',  
	header_center_section = '".$array['header_center_section']."',
	createdon = now(), 
	modifiedon = now(), 
	createdby = '',
	modifiedby = '".$username."',
	header_phone = '".$array['header_phone']."'
	WHERE id = '".$array['id']."'";
	$result = mysqli_query($conn, $sql);
	if (!$result)
	return false;
	return true; 
}

// Edit footer
function footer_edit($conn, $array, $files, $username) {
  if ($files['footer_logo']['tmp_name'] != '') {
    $uploaddir = "../../content/userfiles/images/";
    $uploadfile = $uploaddir.basename($files['footer_logo']['name']);
    // Copy file from catalog for temporary storage:
    copy($files['footer_logo']['tmp_name'], $uploadfile);
    rename($uploadfile, "../../content/userfiles/images/footer_logo.png");
    $img_base = "/content/userfiles/images/footer_logo.png";
    //img_resize($photo_base, $photo1_s, 130, 68, $rgb=0xFFFFFF, $quality=100);
    $footer_logo = "footer_logo = '".$img_base."',";
  }
  else {
    $footer_logo = "";
  }

  $array['footer_address'] = str_replace("'", "\'", $array['footer_address']);
  $array['footer_address'] = str_replace("&#34;", "\&#34;", $array['footer_address']);
  $array['footer_copyright'] = str_replace("'", "\'", $array['footer_copyright']);
  $array['footer_copyright'] = str_replace("&#34;", "\&#34;", $array['footer_copyright']);
  $array['footer_text'] = str_replace("'", "\'", $array['footer_text']);
  $array['footer_text'] = str_replace("&#34;", "\&#34;", $array['footer_text']);

  $sql = "UPDATE cms_header_footer SET 
  ".$footer_logo."
  modifiedon = now(), 
  modifiedby = '".$username."',
  footer_bg = '".$array['footer_bg']."',  
  footer_phone = '".$array['footer_phone']."',
  footer_email = '".$array['footer_email']."',
  footer_address = '".$array['footer_address']."',
  footer_text = '".$array['footer_text']."',
  footer_copyright = '".$array['footer_copyright']."',
  footer_navigation = '".$array['footer_navigation']."',
  vkontakte = '".$array['vkontakte']."',
  facebook = '".$array['facebook']."',
  twitter = '".$array['twitter']."',
  google = '".$array['google']."'
  WHERE id = '1'";
  $result = mysqli_query($conn, $sql);
  if (!$result)
   return false;
  return true; 
}

// Display header form
function display_header_form($array, $lang) {
?>
  <div class='headline'><h1><?php echo $lang['edit header'];?></h1></div>

  <form method="post" action="include/action.php" enctype="multipart/form-data" data-parsley-validate>
    <input type="hidden" name='mode' value="header_edit">
    <input type="hidden" name='submode' value="header">
    <input type="hidden" name='id' value="<?php echo $array['id']; ?>">
	
	  <div class="form-group">
      <label for="exampleFormControlTextarea1"><b><?php echo $lang['header background'];?></b></label>
      <br>
      <input type="color" name="header_bg" id="html5colorpicker"  onchange="clickColor(0, -1, -1, 5)" value="<?php echo $array['header_bg']; ?>" style="width:10%;">
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['logo size'];?></b></label>
      <?php
      if ($array['header_logo'] != '') {
        echo "<br><img src='".$array['header_logo']."' style='margin-right:20px;'>";
      }
      ?>
      <input class="" type='file' name='header_logo' id='header_logo'>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['header text'];?></b></label>
      <input type="text" class="form-control" name="header_center_section" id="header_center_section" value='<?php echo $array['header_center_section']; ?>'>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['phone'];?></b></label>
      <input type="text" class="form-control" name="header_phone" id="phone" value="<?php echo $array['header_phone']; ?>">
    </div>

    <button type='submit' class='btn btn-primary mb-2'><?php echo $lang['save'];?></button>

  </form>
<?php
}

// Display footer form
function display_footer_form($array, $lang) {
  $array['footer_address'] = str_replace('"', '&#34;', $array['footer_address']);
?>
  
  <div class='headline'><h1><?php echo $lang['edit footer'];?></h1></div>

  <form method="post" action="include/action.php" enctype="multipart/form-data" data-parsley-validate>
    <input type="hidden" name='mode' value="footer_edit">
    <input type="hidden" name='submode' value="footer">
  
    <div class="form-group">
      <label for="exampleFormControlTextarea1"><b><?php echo $lang['footer background'];?></b></label>
      <br>
      <input type="color" name="footer_bg" id="html5colorpicker" onchange="clickColor(0, -1, -1, 5)" value="<?php echo $array['footer_bg']; ?>" style="width:10%;">
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['logo size'];?></b></label>
      <?php
      if ($array['footer_logo'] != '') {
        echo "<br><img src='".$array['footer_logo']."' style='margin-right:20px;'>";
      }
      ?>
      <input class="" type='file' name='footer_logo' id='footer_logo'>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['phone'];?></b></label>
      <input type="text" class="form-control" name="footer_phone" id="phone" value="<?php echo $array['footer_phone']; ?>">
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b>E-mail</b></label>
      <input type="text" class="form-control" name="footer_email" id="footer_email" value="<?php echo $array['footer_email']; ?>">
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['address'];?></b></label>
      <input type="text" class="form-control" name="footer_address" id="footer_address" value="<?php echo $array['footer_address']; ?>">
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['footer text'];?></b></label>
      <textarea class="form-control" name="footer_text" id="footer_text" value=''><?php echo $array['footer_text']; ?></textarea>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['copyright'];?></b></label>
      <input type="text" class="form-control" name="footer_copyright" id="footer_copyright" value='<?php echo $array['footer_copyright']; ?>'>
    </div>
    
    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['navigation'];?></b></label>
      <select name="footer_navigation" class="form-control" style="width:200px;">
        <?php
        if ($array['footer_navigation'] == '1') {
          echo "
          <option value='1'>".$lang['show']."</option>
          <option value='2'>".$lang['hide']."</option>
          ";
        }
        else {
          echo "
          <option value='1'>".$lang['show']."</option>
          <option value='2' selected>".$lang['hide']."</option>
          ";
        }
        ?>
      </select>
    </div>
  
    <div class="form-group">
      <label for="exampleFormControlInput1"><b>Vkontakte</b></label>
      <input type="text" class="form-control" name="vkontakte" id="vkontakte" value="<?php echo $array['vkontakte']; ?>">
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b>Facebook</b></label>
      <input type="text" class="form-control" name="facebook" id="facebook" value="<?php echo $array['facebook']; ?>">
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b>Twitter</b></label>
      <input type="text" class="form-control" name="twitter" id="twitter" value="<?php echo $array['twitter']; ?>">
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b>Google Plus</b></label>
      <input type="text" class="form-control" name="google" id="google" value="<?php echo $array['google']; ?>">
    </div>

    <button type='submit' class='btn btn-primary mb-2'><?php echo $lang['save'];?></button>

  </form>
<?php
}


// Display header and footer
function display_header_footer($lang) {
  ?>
  <div class='headline'><h1><?php echo $lang['header and footer'];?></h1></div>

  <form action="" method="post">
  <div class="table-responsive">
    <table class="table" style="width:100%">
    <thead>
      <tr>
        <th scope="col" style="width:5%; border-top: 0px; border-bottom: 0px;">Id</th>
        <th scope="col" style="width:85%; border-top: 0px; border-bottom: 0px;"><?php echo $lang['section'];?></th>
        <th scope="col" style="width:10%; border-top: 0px; border-bottom: 0px;" colspan=2><?php echo $lang['actions'];?></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">1</th>
        <td><?php echo $lang['header'];?></td>
        <td><a href="header_footer.php?mode=edit&submode=header"><img src="img/icons/edit.gif" border="0" width="16" height="16" alt="<?php echo $lang['edit'];?>" title="<?php echo $lang['edit'];?>"></a></td>
      </tr>
      <tr>
        <th scope="row">2</th>
        <td><?php echo $lang['footer'];?></td>
        <td>
          <a href="header_footer.php?mode=edit&submode=footer"><img src="img/icons/edit.gif" border="0" width="16" height="16" alt="<?php echo $lang['edit'];?>" title="<?php echo $lang['edit'];?>"></a>
        </td>
      </tr>
    </tbody>
    </table>
  </div>
  </form>
  <?php
}