<?php

// Delete inner page by id
function delete_inner_page($conn, $id) {
  $sql = "DELETE FROM cms_pages WHERE id = '".$id."'";
  $result = mysqli_query($conn, $sql);
  if (!$result)
   return false;
    return true;  
}

// Get headline by page id
function get_name_by_id($conn, $id) {
  $sql = "SELECT headline FROM cms_pages WHERE id = '".$id."'";
  $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;
   $result = mysqli_fetch_assoc($result);
   return $result['headline'];
}

// Display list of inner pages
function display_inner_pages($conn, $structure='', $id='', $pid, $name, $array_current_page='', $lang) {
?>

  <div class='headline'><h1><?php echo $lang['structure'];?></h1></div>

  <form action="" method="post">
    <div id="container1">
    <?php
    if ($structure) {
      echo "
      <div class='box1_header' style='width:100%; height:45px; color:#2a2a2a; font-weight:bold; border-bottom: 1px solid #dee2e6;'>
        <div style='width:5%; height:45px; padding-left:10px;'>&nbsp;</div>
        <div style='width:12%; height:45px;'>".$lang['modified on']."</div>
        <div style='width:38%; height:45px;'>".$lang['headline']."</div>
        <div style='width:27%; height:45px;'>".$lang['page']."</div>
        <!--<div style='width:15%; height:45px;'>".$lang['module']."</div>-->
        <div style='width:11%; height:45px; text-align:center;'>".$lang['actions']."</div>
      </div>";
    }
    ?>
    </div>

    <div class="box1" style='width:100%; height:45px; border-bottom: 1px solid #dee2e6;'>
        <div style='width:5%; height:45px;'>
            <div style='background:<?php echo $bgcolor;?>; padding:0px; width:10px; height:10px; border-radius:50%;'></div>
        </div>
        <div style='width:12%; height:45px;'>
            <?php 
            if ($array_current_page != '') {
              //echo "<b>".date("d.m.Y", strtotime($row['datetime']))."</b>&nbsp;";
            }
            ?>
            &nbsp;
        </div>
        <div style='width:38%; height:45px;'>
            <?php 
            if ($array_current_page != '') {
              echo "<b>".$array_current_page['headline']."</b>";
            }
            ?>
            &nbsp;
        </div>
        <div style='width:27%; height:45px;'><?php echo $row['link']; ?>&nbsp;</div>
        <!--<div style='width:15%; height:45px;'>&nbsp;</div>-->
        <div style='width:5%; height:45px;'>
            <?php
            if ($pid != '') {
              echo "<a href='innerpage.php?id=".$pid."&mode=getin'><img src='img/icons/folder_up.gif' border='0' alt='".$lang['level up']."' title='".$lang['level up']."'></a>&nbsp;&nbsp;&nbsp;";
            }
            else {
              echo "&nbsp;&nbsp;&nbsp;";
            }
            ?>
        </div>
        <div style='width:5%; height:45px;'>
            <?php
            if ($id) {
              echo "<a href='innerpage.php?mode=add&id=".$id."'><img src='img/icons/add.gif' border='0' alt='".$lang['new page']."' title='".$lang['new page']."'></a>";
            }
            else {
              echo "<a href='innerpage.php?mode=add'><img src='img/icons/add.gif' border='0' alt='".$lang['new page']."' title='".$lang['new page']."'></a>";
            }
            ?>  
        </div>
        <!--<div style='width:5%; height:45px;'>&nbsp;</div>-->
    </div>

    <div id="sortable">
    <?php
      if ($structure) {
      foreach ($structure as $row) {
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

        if ($row['mid'] != '0') {
          $module_name = get_module_name_by_id($conn, $row['mid']);
        }
        else {
          $module_name = "-";
        }
      ?>

      <div id="item-<?php echo $row['id']; ?>" class="box1" style='width:100%; height:45px; border-bottom: 1px solid #dee2e6;'>
        <div style='width:5%; height:45px; padding-left:20px;'>
          <div style='background:<?php echo $bgcolor;?>; padding:0px; width:10px; height:10px; border-radius:50%;'></div>
        </div>
        <div style='width:12%; height:45px;'><?php echo date("d.m.Y", strtotime($row['modifiedon'])); ?>&nbsp;</div>
        <div style='width:38%; height:45px;'><?php echo $row['headline']; ?>&nbsp;</div>
        <div style='width:27%; height:45px;'><?php echo $row['link']; ?>&nbsp;</div>
        <!--<div style='width:15%; height:45px;'><?php echo $module_name; ?></div>-->
        <div style='width:5%; height:45px;'><a href="innerpage.php?id=<?php echo $row['id'];?>&pid=<?php echo $row['id'];?>&mode=getin"><img src="img/icons/getin.gif" border="0" width="16" height="16" alt="<?php echo $lang['get in'];?>" title="<?php echo $lang['get in'];?>"></a></div>
        <div style='width:5%; height:45px;'><a href="innerpage.php?id=<?php echo $row['id'];?>&mode=edit"><img src="img/icons/edit.gif" border="0" width="16" height="16" alt="<?php echo $lang['edit'];?>" title="<?php echo $lang['edit'];?>"></a></div>
        <div style='width:5%; height:45px;'><a href="include/action.php?id=<?php echo $row['id'];?>&mode=page_delete"><img src="img/icons/delete.gif" border="0" width="16" height="16" alt="<?php echo $lang['delete'];?>" title="<?php echo $lang['delete'];?>" onclick="return confirm('<?php echo $lang['are you sure'];?>');"></a>
        </div>
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

  <?php
}

// Get page by page id and put it in array
function get_page($conn, $id) {
   $sql = "SELECT * FROM cms_pages WHERE id = '".$id."";
   $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;
   $result = mysqli_fetch_assoc($result);
   return $result;
}

// Get inner pages by parent id (pid)
function get_inner_pages_by_pid($conn, $pid) {  
  $sql = "SELECT * FROM cms_pages WHERE pid = '".$pid."' ORDER BY sort ASC";
  $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;
   $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
   return $result;
}

// Get all other pages (where id != $id)
function get_inner_pages($conn, $id) {  
  $sql = "SELECT * FROM cms_pages WHERE id != '".$id."' ORDER BY pid ASC";
  $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;

   $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
   return $result;
}

// Get all pages
function get_all_pages($conn) {  
  $sql = "SELECT * FROM cms_pages";
  $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;
   $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
   return $result;
}

// Get published pages (status = 1)
function get_all_published_pages($conn) {  
  $sql = "SELECT * FROM cms_pages WHERE status = '1' ORDER BY pid ASC";
  $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;
   $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
   return $result;
}

// Edit inner page
function edit_inner_page($conn, $array, $username) {
  $sql = "UPDATE cms_pages SET 
  pid = '".$array['pid']."', 
  mid = '".$array['mid']."', 
  submid = '".$array['submid']."',
  createdon = now(), 
  modifiedon = now(), 
  createdby = '',
  modifiedby = '".$username."',
  link = '".$array['link']."',
  title = '".$array['title']."', 
  headline = '".$array['headline']."', 
  description = '".$array['description']."', 
  keywords = '".$array['keywords']."', 
  content = '".$array['content']."', 
  block_down_id = '".$array['block_down_id']."', 
  block_sidebar_id = '".$array['block_sidebar_id']."', 
  status = '".$array['status']."'
  WHERE id = '".$array['id']."'";
  $result = mysqli_query($conn, $sql);
  if (!$result)
   return false;
  return true; 
}

// Create new inner page
function insert_inner_page($conn, $array, $username) {
  $sql = "INSERT INTO cms_pages VALUES (
  '', 
  '".$array['id']."', 
  '".$array['mid']."', 
  '".$array['submid']."', 
  now(), 
  now(), 
  '".$username."',
  '".$username."',
  '".$array['link']."', 
  '".$array['title']."', 
  '".$array['headline']."', 
  '".$array['description']."', 
  '".$array['keywords']."', 
  '".$array['content']."', 
  '0', 
  '0', 
  '".$array['status']."', 
  '".$array['sort']."'
  )";
  $result = mysqli_query($conn, $sql);
  if (!$result)
   return false;
  return true; 
}

// Check link name for uniqueness
function check_unique_page($conn, $link) {
  $sql = "SELECT id FROM cms_pages WHERE link = '".$link."'";
  $result = mysqli_query($conn, $sql);
  if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;
   return true;
}

// Get parent headline
function get_parent_headline($conn, $id) {
   $sql = "SELECT pid FROM cms_pages WHERE id = '".$id."'"; 
   $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;
   $result = mysqli_fetch_assoc($result);

   $sql = "SELECT headline FROM cms_pages WHERE id = '".$result['pid']."'"; 
   $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;
   $result = mysqli_fetch_assoc($result);
   return $result['headline'];
}

// Get id of a parent by page id
function get_parent_id($conn, $id) {
   $sql = "SELECT id FROM cms_pages WHERE pid = '".$id."'"; 
   $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;
   $result = mysqli_fetch_assoc($result);
   return $result['id'];
}

// Getting parent id (pid) by page id
function get_pid_by_id($conn, $id) {
   $sql = "SELECT pid FROM cms_pages WHERE id = '".$id."' ORDER BY sort ASC";
   $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;
   $result = mysqli_fetch_assoc($result);
   return $result['pid'];
}

// Display page edit form
function display_page_edit_form($page, $current_page_parent_headline, $current_page_parent_id, $array_other_pages, $module_name, $array_other_modules, $lang, $code) {
?>
  
  <div class='headline'><h1><?php echo $lang['edit page'];?></h1></div>

  <form method="post" action="include/action.php" data-parsley-validate>
    <input type="hidden" name='mode' value="inner_page_edit">
    <input type="hidden" name='id' value="<?php echo $page['id']; ?>">

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['title'];?> <font color="red">*</font></b></label>
      <input type="text" class="form-control" name="title" id="title" value="<?php echo $page['title']; ?>" required> &nbsp;&nbsp;<?php echo $lang['chars left'];?>: <span id="charsLeft_title"></span>
    </div>

    <div class="form-group">
      <label for="exampleFormControlTextarea1"><b><?php echo $lang['description'];?></b></label>
      <textarea class="form-control" name='description' id='description' id="charsLeft_description" rows="2"><?php echo $page['description']; ?></textarea>&nbsp;&nbsp;<?php echo $lang['chars left'];?>: <span id="charsLeft_description"></span>
    </div>

    <div class="form-group">
      <label for="exampleFormControlTextarea1"><b><?php echo $lang['keywords'];?></b></label>
      <textarea class="form-control" name='keywords' id='keywords' rows="2"><?php echo $page['keywords']; ?></textarea>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['headline'];?> (H1) <font color="red">*</font></b></label>
      <input type="text" class="form-control" name="headline" id="headline" value="<?php echo $page['headline']; ?>" required>
    </div>

    <div class="form-group">
      <label for="exampleFormControlTextarea1"><b><?php echo $lang['content'];?> <font color="red">*</font></b></label>
      <textarea class="form-control" name='content' id='content' rows="2"><?php echo $page['content']; ?></textarea>
      <script>
        CKEDITOR.replace('content', {
        language: '<?php echo $code;?>',
        uiColor: '#9AB8F3'
        });
      </script>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['permanent page'];?> <font color="red">*</font></b></label>
      <input type="text" class="form-control" name="link" id="link" value="<?php echo $page['link']; ?>" pattern="^[A-Za-z0-9-_]+$" required>
    </div>

    <div class="form-group">
      <label for="exampleFormControlSelect1"><b><?php echo $lang['parent page'];?></b></label>
      <select class="form-control" name="pid" id="exampleFormControlSelect1">
        <option value='0'><?php echo $lang['top level'];?></option>
        <?php
        if ($current_page_parent_headline) {
          echo "<option value='".$current_page_parent_id."' selected>".$current_page_parent_headline."</option>";
          foreach ($array_other_pages as $row) {
            echo "<option value='".$row['id']."'>".$row['headline']."</option>";
          }
        }
        else {
          foreach ($array_other_pages as $row) {
            echo "<option value='".$row['id']."'>".$row['headline']."</option>";
          }
        }
        ?>
      </select>
    </div>

    <div class="form-group">
      <label for="exampleFormControlSelect1"><b><?php echo $lang['module'];?></b></label>
      <select class="form-control" name="mid" id="exampleFormControlSelect1">
        <option value='0'><?php echo $lang['no module'];?></option>
        <?php
        if ($module_name != '') {
          echo "<option value='".$page['mid']."' selected>".$module_name."</option>";
          foreach ($array_other_modules as $row2) {
            echo "<option value='".$row2['id']."'>".$row2['name']."</option>";
          }
        }
        else {
          foreach ($array_other_modules as $row2) {
            echo "<option value='".$row2['id']."'>".$row2['name']."</option>";
          }
        }
        ?>
      </select>
    </div>

    <div class="form-group">
      <label for="exampleFormControlSelect1"><b><?php echo $lang['status'];?></b></label>
      <select class="form-control" name="status" id="exampleFormControlSelect1">
        <?php
        if ($page['status'] == '1') {
          echo "
          <option value='1' selected>".$lang['published']."</option>
          <option value='2'>".$lang['pending']."</option>
          <option value='3'>".$lang['draft']."</option>
          ";
        }
        else if ($page['status'] == '2') {
          echo "
          <option value='1'>".$lang['published']."</option>
          <option value='2' selected>".$lang['pending']."</option>
          <option value='3'>".$lang['draft']."</option>
          ";
        }
        else if ($page['status'] == '3') {
          echo "
          <option value='1'>".$lang['published']."</option>
          <option value='2'>".$lang['pending']."</option>
          <option value='3' selected>".$lang['draft']."</option>
          ";
        }
        else {
          echo "
          <option value='1'>".$lang['published']."</option>
          <option value='2'>".$lang['pending']."</option>
          <option value='3'>".$lang['draft']."</option>
          ";
        }
        ?>
      </select>
    </div>   

    <button type='submit' class='btn btn-primary mb-2'><?php echo $lang['save page'];?></button>

  </form>
<?php
}

// Display page add form
function display_page_add_form($array_all_pages, $current_id, $array_active_modules, $lang, $code) {
?>
  
  <div class='headline'><h1><?php echo $lang['new page'];?></h1></div>
  
  <form method="post" action="include/action.php" data-parsley-validate>
    <input type="hidden" name='mode' value="inner_page_add">
    <input type="hidden" name='id' value="<?php echo $current_id; ?>">

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['title'];?> <font color="red">*</font></b></label>
      <input type="text" class="form-control" name="title" id="title" value="<?php echo $_GET['title'];?>" required> &nbsp;&nbsp;<?php echo $lang['chars left'];?>: <span id="charsLeft_title"></span>
    </div>

    <div class="form-group">
      <label for="exampleFormControlTextarea1"><b><?php echo $lang['description'];?></b></label>
      <textarea class="form-control" name='description' id='description' id="charsLeft_description" rows="2"><?php echo $_GET['description'];?></textarea>&nbsp;&nbsp;<?php echo $lang['chars left'];?>: <span id="charsLeft_description"></span>
    </div>

    <div class="form-group">
      <label for="exampleFormControlTextarea1"><b><?php echo $lang['keywords'];?></b></label>
      <textarea class="form-control" name='keywords' id='keywords' rows="2"><?php echo $_GET['keywords'];?></textarea>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['headline'];?> (H1) <font color="red">*</font></b></label>
      <input type="text" class="form-control" name="headline" id="headline" value="<?php echo $_GET['headline']; ?>" required>
    </div>

    <div class="form-group">
      <label for="exampleFormControlTextarea1"><b><?php echo $lang['content'];?></b></label>
      <textarea class="form-control" name='content' id='content' rows="2"></textarea>
      <script>
        CKEDITOR.replace('content', {
        language: '<?php echo $code;?>',
        uiColor: '#9AB8F3'
        });
      </script>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b><?php echo $lang['permanent page'];?> <font color="red">*</font></b></label>
      <input type="text" class="form-control" name="link" id="link" value="<?php echo $page['link']; ?>" pattern="^[A-Za-z0-9-_]+$" required>
    </div>

    <div class="form-group">
      <label for="exampleFormControlSelect1"><b><?php echo $lang['module'];?></b></label>
      <select class="form-control" name="mid" id="exampleFormControlSelect1">
        <option value='0'><?php echo $lang['no module'];?></option>
        <?php
          foreach ($array_active_modules as $row2) {
            echo "<option value='".$row2['id']."'>".$row2['name']."</option>";
          }
        ?>
      </select>
    </div>

    <div class="form-group">
      <label for="exampleFormControlSelect1"><b><?php echo $lang['status'];?></b></label>
      <select class="form-control" name="status" id="exampleFormControlSelect1">
        <?php
        if ($row['status'] == '1') {
          echo "
          <option value='1' selected>".$lang['published']."</option>
          <option value='2'>".$lang['pending']."</option>
          <option value='3'>".$lang['draft']."</option>
          ";
        }
        else if ($row['status'] == '2') {
          echo "
          <option value='1'>".$lang['published']."</option>
          <option value='2' selected>".$lang['pending']."</option>
          <option value='3'>".$lang['draft']."</option>
          ";
        }
        else if ($row['status'] == '3') {
          echo "
          <option value='1'>".$lang['published']."</option>
          <option value='2'>".$lang['pending']."</option>
          <option value='3' selected>".$lang['draft']."</option>
          ";
        }
        else {
          echo "
          <option value='1'>".$lang['published']."</option>
          <option value='2'>".$lang['pending']."</option>
          <option value='3'>".$lang['draft']."</option>
          ";
        }
        ?>
      </select>
    </div>

    <button type='submit' class='btn btn-primary mb-2'><?php echo $lang['save page'];?></button>

  </form>
<?php
}