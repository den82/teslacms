<?php
// Display all products
function display_products($conn, $products, $products_settings, $settings) {
?>
  <div class="row content" style="background:<?php echo $products_settings['bgcolor'];?>;">
      <div class="col-xl-8 offset-xl-2 col-md-12">
        <div class="title">
          <h2><?php echo $products_settings['headline'];?></h2>
        </div>
        <div class="card-deck">
            <?php
            foreach ($products as $row) {
              $page_name = get_page_by_id($conn, $row['page_id']);
              echo "
              <div class='card' style='border-bottom: 3px solid ".$settings['line_color'].";'>
                <img class='card-img-top' src='".$row['product_img']."' alt='".$row['product_title']."'  title='".$row['product_title']."' style='border-bottom:1px solid #eeeeee;'>
                <div class='card-body'>
                  <h5 class='card-title'>".$row['product_title']."</h5>
                  <p class='card-text'>".$row['product_text']."</p>
                  <a href='/products/".$page_name."' class='btn btn-primary' style='background:".$settings['bg_button']."'>Подробнее</a>
                </div>
              </div>
              ";
              }
              ?>
          </div>
          <br><br>
      </div>
    </div>
<?php
}

// Get product name by id
function get_product_name_by_id($conn, $id) {
  $sql = "select product_title from cms_products WHERE id = '".$id."'";
  $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;

   $result = mysqli_fetch_assoc($result);
   return $result['product_title'];
}

// Delete product by id
function delete_product_page($conn, $id) {
  $sql = "DELETE FROM cms_products WHERE id = '".$id."'";
  $result = mysqli_query($conn, $sql);
  if (!$result)
   return false;
    return true;  
}

// Create random string
function randomkeys($length) {
  $pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
  for($i=0;$i<$length;$i++)
  {
   if(isset($key))
	 $key .= $pattern{rand(0,35)};
   else
	 $key = $pattern{rand(0,35)};
  }
  return $key;
}

// Get published products
function get_products($conn) {
   $sql = "SELECT * FROM cms_products WHERE status = '1' ORDER BY sort ASC";
   $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;  
   $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
   return $result;
}

// Get product by id and put data in array
function get_product_by_id($conn, $id) {
   $sql = "SELECT * FROM cms_products WHERE id = '".$id."'";
   $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;  
   $result = mysqli_fetch_assoc($result);
   return $result;
}

// Get products settings and put it in array
function get_products_settings($conn) {
   $sql = "SELECT * FROM cms_products_settings WHERE id = '1'";
   $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;  
   $result = mysqli_fetch_assoc($result);
   return $result;
}

// Display product edit form
function display_edit_fp_products($conn, $array, $lang, $code) {
?>

  <div class='headline'><h1><?php echo $lang['edit products services section'];?>: <?php echo $array['product_title']; ?></h1></div>

  <form method="post" action="include/action.php" data-parsley-validate enctype="multipart/form-data">
    <input type="hidden" name='mode' value="main_page_edit">
    <input type="hidden" name='submode' value="products">
    <input type="hidden" name='subtype' value="edit">

    <?php 
    if (!$array) {
      echo "
      There are no products here <a href='?mode=edit&type=products&subtype=add'>Add product</a>";
    }
    else {
    	
    ?>
    <input type="hidden" name='id' value="<?php echo $array['id']; ?>">

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['headline'];?> <font color="red">*</font></b></label>
      <input type="text" class="form-control" name="product_title" id="product_title" value="<?php echo $array['product_title']; ?>" required>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['description'];?> <font color="red">*</font></b></label>
      <textarea name="product_text" id="product_text" rows="10" cols="80">
        <?php echo $array['product_text']; ?>
      </textarea>
      <script>
        CKEDITOR.replace('product_text', {
        language: '<?php echo $code;?>',
        height: '150px',
        uiColor: '#9AB8F3'
        });
      </script>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['image'];?> 391x260 <font color="red">*</font></b></label><br>
      <?php
      if ($array['product_img'] != '') {
        echo "<br><img src='".$array['product_img']."' style='margin-right:20px;'>";
      }
      ?>
      <input class="" type='file' name='product_img' id='product_img'>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['permanent page'];?> <font color="red">*</font></b></label>

      <select name="page_id" class="form-control" style="width:500px;" required>
        <option value=''><?php echo $lang['choose'];?></option>
        <?php
        $headline = get_name_by_id($conn, $array['page_id']);
        $array_other_pages = get_inner_pages($conn, $array['page_id']);
        if ($array['page_id'] != '0') {
          echo "<option value='".$array['page_id']."' selected>".$headline."</option>";
          foreach ($array_other_pages as $row) {
            if ($row['pid'] == '0') {
              echo "<option value='".$row['id']."'>* ".$row['headline']."</option>";
            }
            else {
              echo "<option value='".$row['id']."'>".$row['headline']."</option>";
            }
          }
        }
        else {
          foreach ($array_other_pages as $row) {
            if ($row['pid'] == '0') {
              echo "<option value='".$row['id']."'>* ".$row['headline']."</option>";
            }
            else {
              echo "<option value='".$row['id']."'>".$row['headline']."</option>";
            }
          }
        }
        ?>
      </select>
      <em>* <?php echo $lang['top level'];?></em>

    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['status'];?> <font color="red">*</font></b></label>
      <select name="status" class="form-control" style="width:200px;">
        <?php
        if ($array['status'] == '1') {
          echo "
          <option value='1'>".$lang['published']."</option>
          <option value='2'>".$lang['draft']."</option>
          ";
        }
        else {
          echo "
          <option value='1'>".$lang['published']."</option>
          <option value='2' selected>".$lang['draft']."</option>
          ";
        }
        ?>
      </select>
    </div>

    <button type='submit' class='btn btn-primary mb-2'><?php echo $lang['save section'];?></button>
    <?php } ?>
  </form>
<?php
}

// Display product add form
function display_add_fp_products($conn, $lang, $lang_code) {
?>

  <div class='headline'><h1><?php echo $lang['add new item'];?></h1></div>

  <form method="post" action="include/action.php" data-parsley-validate enctype="multipart/form-data">
    <input type="hidden" name='mode' value="main_page_edit">
    <input type="hidden" name='submode' value="products">
    <input type="hidden" name='subtype' value="add">

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['headline'];?> <font color="red">*</font></b></label>
      <input type="text" class="form-control" name="product_title" id="product_title" value="" required>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['description'];?> <font color="red">*</font></b></label>
      <textarea name="product_text" id="product_text" rows="10" cols="80">
        
      </textarea>
      <script>
        CKEDITOR.replace('product_text', {
        language: '<?php echo $lang_code;?>',
        height: '150px',
        uiColor: '#9AB8F3'
        });
      </script>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['image'];?> 391x260 <font color="red">*</font></b></label><br>
      <input class="" type='file' name='product_img' id='product_img'>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['page'];?> <font color="red">*</font></b></label>
      <select name="page_id" class="form-control" style="width:500px;" required>
        <option value=''><?php echo $lang['choose'];?></option>
        <?php
          $array_published_pages = get_all_published_pages($conn);
          foreach ($array_published_pages as $row) {
            if ($row['pid'] == '0') {
              echo "<option value='".$row['id']."'>* ".$row['headline']."</option>";
            }
            else {
              echo "<option value='".$row['id']."'>".$row['headline']."</option>";
            }
          }
        ?>
      </select>
      <em>* <?php echo $lang['top level'];?></em>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['status'];?> <font color="red">*</font></b></label>
      <select name="status" class="form-control" style="width:200px;">
          <option value='1'><?php echo $lang['published'];?></option>
          <option value='2'><?php echo $lang['draft'];?></option>
      </select>
    </div>

    <button type='submit' class='btn btn-primary mb-2'><?php echo $lang['save section'];?></button>

  </form>

<?php
}

// Display products section settings edit form
function display_settings_fp_products($conn, $array, $lang) {
?>

  <div class='headline'><h1><?php echo $lang['products settings'];?></h1></div>

  <form method="post" action="include/action.php" data-parsley-validate enctype="multipart/form-data">
    <input type="hidden" name='mode' value="main_page_edit">
    <input type="hidden" name='submode' value="products">
    <input type="hidden" name='subtype' value="settings">

    <div class="form-group">
      <label for="exampleFormControlTextarea1"><b><?php echo $lang['background'];?> <font color="red">*</font></b></label>
      <br>
      <input type="color" name="bgcolor" id="html5colorpicker"  onchange="clickColor(0, -1, -1, 5)" value="<?php echo $array['bgcolor']; ?>" style="width:10%;">
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['headline'];?> <font color="red">*</font></b></label>
      <input type="text" class="form-control" name="headline" id="headline" value="<?php echo $array['headline']; ?>" required>
    </div>

    <button type='submit' class='btn btn-primary mb-2'><?php echo $lang['save section'];?></button>
  </form>
<?php
}

// Add new product
function add_product($conn, $array, $files, $username) {

  $array['product_title'] = str_replace("'", "\'", $array['product_title']);
  $array['product_text'] = str_replace("'", "\'", $array['product_text']);

  if ($files['product_img']['tmp_name'] != '') {
  	$newfile = randomkeys('8');
  	$uploaddir = "../../content/userfiles/images/";
  	$uploadfile = $uploaddir.basename($files['product_img']['name']);
  	// Copy file from catalog for temporary storage:
  	copy($files['product_img']['tmp_name'], $uploadfile);
  	rename($uploadfile, "../../content/userfiles/images/".$newfile.".png");
  	$img_base = "/content/userfiles/images/".$newfile.".png";
  	//img_resize($photo_base, $photo1_s, 130, 68, $rgb=0xFFFFFF, $quality=100);
  	$product_img = $img_base;
  }
  else {
  	$product_img = "";
  }

  $sql = "INSERT INTO cms_products VALUES (
  '', 
  now(), 
  now(), 
  '".$username."',
  '".$username."',
  '".$array['product_title']."', 
  '".$array['product_text']."', 
  '".$product_img."',
  '".$array['product_link']."',  
  '".$array['status']."',
  '".$array['sort']."'
  )";
  $result = mysqli_query($conn, $sql);
  if (!$result)
   return false;
  return true; 
}

// Edit product
function edit_product($conn, $array, $files, $username) {

  $array['product_title'] = str_replace("'", "\'", $array['product_title']);
  $array['product_text'] = str_replace("'", "\'", $array['product_text']);

  if ($files['product_img']['tmp_name'] != '') {
  	$newfile = randomkeys('8');
  	$uploaddir = "../../content/userfiles/images/";
  	$uploadfile = $uploaddir.basename($files['product_img']['name']);
  	// Copy file from catalog for temporary storage:
  	copy($files['product_img']['tmp_name'], $uploadfile);
  	rename($uploadfile, "../../content/userfiles/images/".$newfile.".png");
  	$img_base = "/content/userfiles/images/".$newfile.".png";
  	//img_resize($photo_base, $photo1_s, 130, 68, $rgb=0xFFFFFF, $quality=100);
  	$product_img = "product_img = '".$img_base."',";
  }
  else {
  	$product_img = "";
  }

  $sql = "UPDATE cms_products SET 
  modifiedon = now(), 
  modifiedby = '".$username."', 
  product_title = '".$array['product_title']."', 
  product_text = '".$array['product_text']."', 
  ".$product_img." 
  page_id = '".$array['page_id']."', 
  status = '".$array['status']."'  
  WHERE id = '".$array['id']."'";

  $result = @mysqli_query($conn, $sql);
  if (!$result)
   return false;
  return true;
}

// Edit products settings block
function edit_product_settings($conn, $array, $username) {

  $array['headline'] = str_replace("'", "\'", $array['headline']);

  $sql = "UPDATE cms_products_settings SET 
  modifiedon = now(), 
  modifiedby = '".$username."', 
  bgcolor = '".$array['bgcolor']."', 
  headline = '".$array['headline']."', 
  count = '".$array['count']."'  
  WHERE id = '1'";

  $result = @mysqli_query($conn, $sql);
  if (!$result)
   return false;
  return true;
}

// Display all products
function display_all_products($array, $lang) {
?>
  <div class='headline'><h1><?php echo $lang['products services'];?></h1></div>

  &nbsp;&nbsp;<a href="/cpanel/mainpage.php?mode=edit&type=products&subtype=add"><?php echo $lang['add new item'];?></a>
  &nbsp;&nbsp;&nbsp;<a href="/cpanel/mainpage.php?mode=edit&type=products&subtype=settings"><?php echo $lang['settings'];?></a>

  <form action="" method="post">
  <div id="container1">
  <?php
  if ($array) {
    echo "
    <div class='box1_header' style='height:45px; color:#2a2a2a; font-weight:bold;'>
      <div style='width:5%; height:45px; padding-left:10px;'>&nbsp;</div>
      <div style='width:12%; height:45px;'>".$lang['modified on']."</div>
      <div style='width:38%; height:45px;'>".$lang['headline']."</div>
      <div style='width:30%; height:45px;'>".$lang['page']."</div>
      <div style='width:15%; height:45px;'>".$lang['actions']."</div>
    </div>";
  }
  ?>
  </div>



<div id="sortable">
<?php
  if ($array) {
  foreach ($array as $row) {
    if ($row['status'] == '1') {
      $bgcolor = "#56eb64";
    }
    else if ($row['status'] == '2') {
      $bgcolor = "#ffcb68";
    }
    else if ($row['status'] == '3') {
      $bgcolor = "#f98171";
    }
    else {
      $bgcolor = "#ffffff";
    }

  ?>


  <div id="item-<?php echo $row['id']; ?>" class="box1" style='height:45px; margin-right: -5px; padding-left:10px;'>
    <div style='width:
    5%; height:45px; margin-right: -5px; padding-left:20px;'><div style='background:<?php echo $bgcolor;?>; padding:0px; width:10px; height:10px; border-radius:50%;'></div></div>
    <div style='width:12%; height:45px; margin-right: -5px;'><?php echo date("d.m.Y", strtotime($row['modifiedon'])); ?>&nbsp;</div>
    <div style='width:38%; height:45px; margin-right: -5px;'><?php echo $row['product_title']; ?>&nbsp;</div>
    <div style='width:30%; height:45px; margin-right: -5px;'><?php echo $row['product_link']; ?>&nbsp;</div>
    <div style='width:5%; height:45px; margin-right: -5px;'><a href="/cpanel/mainpage.php?mode=edit&type=products&subtype=edit&id=<?php echo $row['id'];?>"><img src="img/icons/edit.gif" border="0" width="16" height="16" alt="<?php echo $lang['edit'];?>" title="<?php echo $lang['edit'];?>"></a></div>
    <div style='width:5%; height:45px; margin-right: -5px;'><a href="/cpanel/include/action.php?id=<?php echo $row['id'];?>&mode=product_delete"><img src="img/icons/delete.gif" border="0" width="16" height="16" alt="<?php echo $lang['delete'];?>" title="<?php echo $lang['delete'];?>" onclick="return confirm('<?php echo $lang['are you sure'];?>');"></a></div>
  </div>

  <input type="hidden" name="id[]" value="<?php echo $row['id']; ?>">
  
   <?php } } ?>
</div>

</form>

<p><br>
<em><?php echo $lang['you can drag and drop lines to sort pages'];?></em>
<table>
<tr>
  <td style='padding:5px;'><div style='float:left; background:#56eb64; padding:0px; width:10px; height:10px; border-radius:50%;'></div></td>
  <td style='padding:5px;'><?php echo $lang['published'];?></td>
</tr>
<tr>
  <td style='padding:5px;'><div style='float:left; background:#ffcb68; padding:0px; width:10px; height:10px; border-radius:50%;'></div></td>
  <td style='padding:5px;'><?php echo $lang['pending'];?></td>
</tr>
<tr>
  <td style='padding:5px;'><div style='float:left; background:#f98171; padding:0px; width:10px; height:10px; border-radius:50%;'></div></td>
  <td style='padding:5px;'><?php echo $lang['draft'];?></td>
</tr>
</table>
<?php } ?>