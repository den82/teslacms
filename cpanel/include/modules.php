<?php

// Checking active module
function check_active_module($conn, $dir) {  
  $sql = "select id from cms_modules WHERE dir = '".$dir."' and status = '1'";
  $result = mysqli_query($conn, $sql);
  if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;
   return true;
}

// Display all modules
function display_modules($conn, $modules, $lang, $code) {
	echo "<div class='headline'><h1>".$lang['modules']."</h1></div>";

  $modules = scandir("../content/modules/");

  unset($modules[0]);
  unset($modules[1]);

    if (!empty($modules)) {
      echo "
      <form action='' method='post'>
        <div class='table-responsive'>
          <table class='table'>
          <thead>
            <tr>
              <th scope='col'>".$lang['status']."</th>
              <th scope='col'>".$lang['module name']."</th>
              <th scope='col'>".$lang['date']."</th>
              <th scope='col'>".$lang['location']."</th>
              <th scope='col'>".$lang['actions']."</th>
            </tr>
          </thead>
          <tbody>
      ";
      foreach ($modules as $k=>$v) {
        //echo $v."<br>";
        $names=file("../content/modules/".$v."/about_".$code.".txt");

        $module_name = substr($names[0], 14); 
        $module_date = date("d.m.Y", filectime("../content/modules/".$v."/"));

        // Модуль активирован если есть строка с этим модулем в таблице cms_modules
        if (check_active_module($conn, $v) == true) {
          $link = "<a href='/content/modules/".$v."/uninstall.php?mode=deactivate'>".$lang['deactivate']."</a>&nbsp;";
          $status = $lang['active'];
          $bgcolor = '#56eb64';
          $settings = "<a href='/cpanel/module.php?module=".$v."&mode=settings'>".$lang['manage']."</a>";
        }
        else {
          $link = "<a href='/content/modules/".$v."/install.php'>".$lang['activate']."</a>";
          $status = $lang['no active'];
          $bgcolor = '#f98171';
          $settings = '';
        }

        echo "
        <tr>
          <td style='padding:20px;'>
            <div style='background:".$bgcolor."; padding:0px; width:10px; height:10px; border-radius:50%;'></div>
          </td>
          <td>".$module_name."</td>
          <td>".$module_date."</td>
          <td>/content/modules/".$v."/</td>
          <td>
            ".$link."<br>
            ".$settings."<br>
            <a href='/content/modules/".$v."/delete.php' onclick=\"return confirm('".$lang['are you sure']."');\">".$lang['delete permanently']."</a>
          </td>
        </tr>
        ";
      }
      echo "
          </tbody>
          </table>
        </div>
      </form>
      <p>

      <table>
        <tr>
          <td style='padding:5px;'><div style='float:left; background:#56eb64; padding:0px; width:10px; height:10px; border-radius:50%;'></div></td>
          <td style='padding:5px;'>".$lang['active module']."</td>
        </tr>
        <tr>
          <td style='padding:5px;'><div style='float:left; background:#f98171; padding:0px; width:10px; height:10px; border-radius:50%;'></div></td>
          <td style='padding:5px;'>".$lang['no active module']."</td>
        </tr>
      </table>
      <p>
      ".$lang['to install new module']."
      ";
    }
    else {
      echo $lang['no active modules'];
    }
}

// Get all active modules
function get_active_modules($conn) {
   $sql = "SELECT * FROM cms_modules WHERE status = '1' ORDER BY id ASC";
   $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;  
   $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
   return $result;
}

// Get module directory by module id
function get_module_dir($conn, $id) {
   $sql = "SELECT dir FROM cms_modules WHERE id = '".$id."'";
   $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;  
   $result = mysqli_fetch_assoc($result);
   return $result['dir'];
}

// Get module name by module directory
function get_module_name_by_dir($conn, $dir) {
   $sql = "SELECT name FROM cms_modules WHERE dir = '".$dir."'";
   $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;  
   $result = mysqli_fetch_assoc($result);
   return $result['name'];
}

// Get module name by module id
function get_module_name_by_id($conn, $id) {
   $sql = "SELECT name FROM cms_modules WHERE id = '".$id."'";
   $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;  
   $result = mysqli_fetch_assoc($result);
   return $result['name'];
}

// Get module name by page id
function get_module_name_by_page_id($conn, $page_id) {
   $sql = "SELECT mid FROM cms_pages WHERE id = '".$page_id."'";
   $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;  
   $result = mysqli_fetch_assoc($result);

   $sql2 = "SELECT name FROM cms_modules WHERE id = '".$result['mid']."'";
   $result2 = mysqli_query($conn, $sql2);
   if (!$result2)
     return false;
   $count_rows2 = mysqli_num_rows($result2);
   if ($count_rows2 < 1)
      return false;  
   $result2 = mysqli_fetch_assoc($result2);
   return $result2['name'];
}

// Get all other modules name by page id
function get_other_modules_by_page_id($conn, $page_id) {
   $sql = "SELECT mid FROM cms_pages WHERE id = '".$page_id."'";
   $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;  
   $result = mysqli_fetch_assoc($result);

   $sql2 = "SELECT * FROM cms_modules WHERE id != '".$result['mid']."'";
   $result2 = mysqli_query($conn, $sql2);
   if (!$result2)
     return false;
   $count_rows2 = mysqli_num_rows($result2);
   if ($count_rows2 < 1)
      return false;  
   $result2 = mysqli_fetch_all($result2, MYSQLI_ASSOC);
   return $result2;
}
?>