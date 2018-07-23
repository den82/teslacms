<?php
// Change section status
function change_status($conn, $section, $status, $username) {
  $sql = "UPDATE cms_firstpage SET modifiedon = now(), modifiedby = '".$username."', ".$section."_status = '".$status."' WHERE id = '1'";
  $result = @mysqli_query($conn, $sql);
  if (!$result)
   return false;
  return true;
}

// Get array with main page data
function get_mainpage($conn) {
   $sql = "SELECT * FROM cms_firstpage WHERE id = '1'";
   $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;  
   $result = mysqli_fetch_assoc($result);
   return $result;
}

// Display all main page blocks
function display_mainpage($mainpage, $lang) {

echo "<div class='headline'><h1>".$lang['mainpage']."</h1></div>";
?>
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
      <td><?php echo $lang['meta tags'];?></td>
      <td><a href="mainpage.php?mode=edit&type=meta"><img src="img/icons/edit.gif" border="0" width="16" height="16" alt="<?php echo $lang['edit'];?>" title="<?php echo $lang['edit'];?>"></a></td>
      <td></td>
    </tr>
    <tr>
      <th scope="row">2</th>
      <td><?php echo $lang['main section'];?></td>
      <td style='width:75px;'>
        <a href="mainpage.php?mode=edit&type=main"><img src="img/icons/edit.gif" border="0" width="16" height="16" alt="<?php echo $lang['edit'];?>" title="<?php echo $lang['edit'];?>"></a>
      </td>
      <td style='width:75px;'>
        <?php
          if ($mainpage['main_status'] == '1') {
            echo "<a href='/cpanel/include/action.php?section=main&mode=disable'><img src='img/icons/stop.png' border='0' width='16' height='16' alt='".$lang['hide on main page']."' title='".$lang['hide on main page']."'></a>";
          }
          else {
            echo "<a href='/cpanel/include/action.php?section=main&mode=enable'><img src='img/icons/play.png' border='0' width='16' height='16' alt='".$lang['show on main page']."' title='".$lang['show on main page']."'></a>";
          }
        ?>
      </td>
    </tr>
    <tr>
      <th scope="row">3</th>
      <td><?php echo $lang['products section'];?></td>
      <td>
        <a href="mainpage.php?mode=edit&type=products"><img src="img/icons/getin.gif" border="0" width="16" height="16" alt="<?php echo $lang['edit'];?>" title="<?php echo $lang['edit'];?>"></a>
      </td>
      <td>
        <?php
          if ($mainpage['products_status'] == '1') {
            echo "<a href='/cpanel/include/action.php?section=products&mode=disable'><img src='img/icons/stop.png' border='0' width='16' height='16' alt='".$lang['hide on main page']."' title='".$lang['hide on main page']."'></a>";
          }
          else {
            echo "<a href='/cpanel/include/action.php?section=products&mode=enable'><img src='img/icons/play.png' border='0' width='16' height='16' alt='".$lang['show on main page']."' title='".$lang['show on main page']."'></a>";
          }
        ?>
      </td>
    </tr>
    <tr>
      <th scope="row">4</th>
      <td><?php echo $lang['free section'];?></td>
      <td style='width:75px;'>
        <a href="mainpage.php?mode=edit&type=free_section"><img src="img/icons/edit.gif" border="0" width="16" height="16" alt="<?php echo $lang['edit'];?>" title="<?php echo $lang['edit'];?>"></a>
      </td>
      <td style='width:75px;'>
        <?php
          if ($mainpage['free_section_status'] == '1') {
            echo "<a href='/cpanel/include/action.php?section=free_section&mode=disable'><img src='img/icons/stop.png' border='0' width='16' height='16' alt='".$lang['hide on main page']."' title='".$lang['hide on main page']."'></a>";
          }
          else {
            echo "<a href='/cpanel/include/action.php?section=free_section&mode=enable'><img src='img/icons/play.png' border='0' width='16' height='16' alt='".$lang['show on main page']."' title='".$lang['show on main page']."'></a>";
          }
        ?>
      </td>
    </tr>
    <tr>
      <th scope="row">5</th>
      <td><?php echo $lang['map section'];?></td>
      <td>
        <a href="mainpage.php?mode=edit&type=map"><img src="img/icons/edit.gif" border="0" width="16" height="16" alt="<?php echo $lang['edit'];?>" title="<?php echo $lang['edit'];?>"></a>
      </td>
      <td>
        <?php
          if ($mainpage['map_status'] == '1') {
            echo "<a href='/cpanel/include/action.php?section=map&mode=disable'><img src='img/icons/stop.png' border='0' width='16' height='16' alt='".$lang['hide on main page']."' title='".$lang['hide on main page']."'></a>";
          }
          else {
            echo "<a href='/cpanel/include/action.php?section=map&mode=enable'><img src='img/icons/play.png' border='0' width='16' height='16' alt='".$lang['show on main page']."' title='".$lang['show on main page']."'></a>";
          }
        ?>
      </td>
    </tr>
  </tbody>
  </table>
</div>
</form>
<?php
}

// Edit main block of the main page
function edit_fp_main($conn, $array, $login) {

  $array['main_h1'] = str_replace("'", "\'", $array['main_h1']);
  $array['main_content'] = str_replace("'", "\'", $array['main_content']);

  $sql = "UPDATE cms_firstpage SET 
  modifiedon = now(), 
  modifiedby = '".$login."',
  main_h1 = '".$array['main_h1']."', 
  main_content = '".$array['main_content']."',
  main_status = '".$array['main_status']."' 
  WHERE id = '1'";
  $result = @mysqli_query($conn, $sql);
  if (!$result)
   return false;
  return true; 
}

// Edit free section of the main page
function edit_fp_free_section($conn, $array, $username) {

  $array['free_section_headline'] = str_replace("'", "\'", $array['free_section_headline']);
  $array['free_section_content'] = str_replace("'", "\'", $array['free_section_content']);

  $sql = "UPDATE cms_firstpage SET 
  modifiedon = now(), 
  modifiedby = '".$username."',
  free_section_headline = '".$array['free_section_headline']."', 
  free_section_content = '".$array['free_section_content']."',
  free_section_status = '".$array['free_section_status']."' 
  WHERE id = '1'";
  $result = @mysqli_query($conn, $sql);
  if (!$result)
   return false;
  return true; 
}

// Edit map section of the main page
function edit_fp_map($conn, $array, $login) {

  $array['map'] = str_replace("'", "\'", $array['map']);

  $sql = "UPDATE cms_firstpage SET 
  modifiedon = now(), 
  modifiedby = '".$login."',
  map = '".$array['map']."', 
  map_status = '".$array['map_status']."' 
  WHERE id = '1'";
  $result = @mysqli_query($conn, $sql);
  if (!$result)
   return false;
  return true; 
}

// Edit meta section of the main page
function edit_fp_meta($conn, $array, $login) {

  $array['title'] = str_replace("'", "\'", $array['title']);
  $array['description'] = str_replace("'", "\'", $array['description']);
  $array['keywords'] = str_replace("'", "\'", $array['keywords']);

  $sql = "UPDATE cms_firstpage SET 
  modifiedon = now(), 
  modifiedby = '".$login."',
  title = '".$array['title']."', 
  description = '".$array['description']."',
  keywords = '".$array['keywords']."'
  WHERE id = '1'";
  $result = @mysqli_query($conn, $sql);
  if (!$result)
   return false;
  return true; 
}

// Display meta section of the main page edit form
function display_edit_fp_meta($array, $lang) {
  
  echo "<div class='headline'><h1>".$lang['edit meta section']."</h1></div>";
  ?>

  <form method="post" action="include/action.php" enctype="multipart/form-data" data-parsley-validate>
    <input type="hidden" name='mode' value="main_page_edit">
    <input type="hidden" name='submode' value="meta">

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['title']; ?> <font color="red">*</font></b></label>
      <input type="text" class="form-control" name="title" id="title" value='<?php echo $array['title']; ?>' required>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['description']; ?> <font color="red">*</font></b></label>
      <textarea class="form-control" id="exampleFormControlTextarea1" name="description" id="description" rows="2" cols="80" required><?php echo $array['description']; ?></textarea>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['keywords']; ?> <font color="red">*</font></b></label>
      <textarea class="form-control" id="exampleFormControlTextarea1" name="keywords" id="keywords" rows="2" cols="80" required><?php echo $array['keywords']; ?></textarea>
    </div>

    <button type='submit' class='btn btn-primary mb-2'><?php echo $lang['save section']; ?></button>
  </form>

<?php
}

// Display main section of the main page edit form
function display_edit_fp_main($array, $lang, $code) {
?>

  <div class='headline'><h1><?php echo $lang['edit main section'];?></h1></div>

  <form method="post" action="include/action.php" data-parsley-validate>
    <input type="hidden" name='mode' value="main_page_edit">
    <input type="hidden" name='submode' value="main">
    <input type="hidden" name='id' value="<?php echo $array['id']; ?>">

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['headline'];?> <font color="red">*</font></b></label>
      <input type="text" class="form-control" name="main_h1" id="main_h1" value='<?php echo $array['main_h1']; ?>' required>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['content'];?> <font color="red">*</font></b></label>
      <textarea name="main_content" id="main_content" rows="10" cols="80">
        <?php echo $array['main_content']; ?>
      </textarea>
      <script>
        CKEDITOR.replace('main_content', {
        language: '<?php echo $code;?>',
        uiColor: '#9AB8F3'
        });
      </script>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['status'];?> <font color="red">*</font></b></label>
      <select name="main_status" class="form-control" style="width:200px;">
        <?php
        if ($array['main_status'] == '1') {
          echo "
          <option value='1'>".$lang['published']."</option>
          <option value='2'>".$lang['draft']."</option>
          ";
        }
        else {
          echo "
          <option value='1'>Published</option>
          <option value='2' selected>Draft</option>
          ";
        }
        ?>
      </select>
    </div>

    <button type='submit' class='btn btn-primary mb-2'><?php echo $lang['save section']; ?></button>
  </form>

<?php
}



// Display free section of the main page edit form
function display_edit_fp_free_section($array, $lang) {
?>

  <div class='headline'><h1><?php echo $lang['edit free section'];?></h1></div>

  <form method="post" action="include/action.php" data-parsley-validate>
    <input type="hidden" name='mode' value="main_page_edit">
    <input type="hidden" name='submode' value="free_section">
    <input type="hidden" name='id' value="<?php echo $array['id']; ?>">

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['headline'];?> <font color="red">*</font></b></label>
      <input type="text" class="form-control" name="free_section_headline" id="free_section_headline" value='<?php echo $array['free_section_headline']; ?>' required>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['content'];?> <font color="red">*</font></b></label>
      <textarea name="free_section_content" id="free_section_content" rows="10" cols="80">
        <?php echo $array['free_section_content']; ?>
      </textarea>
      <script>
        CKEDITOR.replace('free_section_content', {
        language: 'en',
        uiColor: '#9AB8F3'
        });
      </script>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['status'];?> <font color="red">*</font></b></label>
      <select name="free_section_status" class="form-control" style="width:200px;">
        <?php
        if ($array['free_section_status'] == '1') {
          echo "
          <option value='1'>".$lang['published']."</option>
          <option value='2'>".$lang['draft']."</option>
          ";
        }
        else {
          echo "
          <option value='1'>Published</option>
          <option value='2' selected>Draft</option>
          ";
        }
        ?>
      </select>
    </div>

    <button type='submit' class='btn btn-primary mb-2'><?php echo $lang['save section']; ?></button>
  </form>

<?php
}

// Display map section of the main page edit form
function display_edit_fp_map($array, $lang) {
?>

  <div class='headline'><h1><?php echo $lang['edit map section'];?></h1></div>

  <form method="post" action="include/action.php" data-parsley-validate>
    <input type="hidden" name='mode' value="main_page_edit">
    <input type="hidden" name='submode' value="map">

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['map'];?> (<a target='_blank' href="https://yandex.ru/map-constructor/?from=mapstools"><?php echo $lang['yandex_maps'];?></a>) <font color="red">*</font></b></label><br>
      <em><?php echo $lang['example'];?>:</em><br>
      <div class="example_code">&lt;script type="text/javascript" charset="utf-8" async src="https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3Ae9d62d5c0e92580c4625268ebd6a2b1d934216f62901521e848b3e9da4536a24&width=100%25&height=580&lang=ru_RU&scroll=true"&gt;&lt;/script&gt;</div>
<textarea class="form-control" name="map" id="map" rows="4" cols="80" required>
<?php echo $array['map']; ?>
</textarea>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['status'];?> <font color="red">*</font></b></label>
      <select name="map_status" class="form-control" style="width:200px;">
        <?php
        if ($array['map_status'] == '1') {
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

    <button type='submit' class='btn btn-primary mb-2'><?php echo $lang['save section']; ?></button>
  </form>

<?php
}