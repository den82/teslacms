<?php

// Checking whether it main page or not
function check_index_page($conn, $url) {
   if ($url == '/') {
    return true;
   }
   else {
    return false;
   }
}

// Display index page of a theme
function show_index_page($conn, $index_page, $header_footer, $menu, $theme) {
   $path = "/content/themes/".$theme."";
	 include_once("content/themes/".$theme."/index.php");
}

// Display inner page of a theme
function show_inner_page($conn, $inner_page, $header_footer, $menu, $theme) {
   $path = "/content/themes/".$theme."";
   include_once("content/themes/".$theme."/inner.php");
}

// Display 404 page of a theme
function show_404_page($conn, $inner_page, $header_footer, $menu, $theme) {
   $path = "/content/themes/".$theme."";
   include_once("content/themes/".$theme."/404.php");
}

// Get array with main page data
function get_index_page($conn) {
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

// Get array with main page data
function get_inner_page($conn, $url) {
   $array = explode('/', $url);

   for($i=0; $i<count($array); $i++){
       if($array[$i] != "") {
         $count ++;
       }
   }

   $sql = "SELECT * FROM cms_pages WHERE link = '".$array[$count]."'";
   $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;
   $result = mysqli_fetch_assoc($result);
   return $result;
}


// Get all themes
function get_themes($conn) {
  $sql = "select * from cms_themes ORDER BY id ASC";
  $result = mysqli_query($conn, $sql);
  if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;
   $result = mysqli_fetch_assoc($result);
   return $result;
}

// Display all themes
function display_themes($conn, $themes, $lang) {

  echo "<div class='headline'><h1>".$lang['themes']."</h1></div>";

  $themes = scandir("../content/themes/");

  unset($themes[0]);
  unset($themes[1]);

    if (!empty($themes)) {
      echo "
      <form action='' method='post'>
        <div class='table-responsive'>
          <table class='table'>
          <thead>
            <tr>
              <th scope='col'>".$lang['status']."</th>
              <th scope='col'>".$lang['theme name']."</th>
              <th scope='col'>".$lang['date']."</th>
              <th scope='col'>".$lang['image']."</th>
              <th scope='col'>".$lang['actions']."</th>
            </tr>
          </thead>
          <tbody>
      ";
      foreach ($themes as $k=>$v) {
        //echo $v."<br>";
        $names=file("../content/themes/".$v."/about.txt");

        $module_name = substr($names[0], 10); 
        $module_date = date("d.m.Y", filectime("../content/themes/".$v."/"));

        // Модуль активирован если есть строка с этим модулем в таблице
        if (check_active_theme($conn, $v) == true) {
          $link = "<a href='/content/themes/".$v."/uninstall.php?mode=deactivate'>".$lang['deactivate']."</a>&nbsp;";
          $status = $lang['active'];
          $bgcolor = '#56eb64';
          $settings = "<a href='module.php?module=".$v."&mode=settings'>Manage</a>";
        }
        else {
          $link = "<a href='/content/themes/".$v."/install.php'>".$lang['activate']."</a>";
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
          <td><img src='/content/themes/".$v."/ava.png' border='0' alt='' title=''></td>
          <td>
            ".$link."<br>
            <a href='/content/themes/".$v."/uninstall.php?mode=delete_forever' onclick=\"return confirm('".$lang['are you sure']."');\">".$lang['delete permanently']."</a>
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
          <td style='padding:5px;'>".$lang['active']."</td>
        </tr>
        <tr>
          <td style='padding:5px;'><div style='float:left; background:#f98171; padding:0px; width:10px; height:10px; border-radius:50%;'></div></td>
          <td style='padding:5px;'>".$lang['no active']."</td>
        </tr>
      </table>
      <p>
      ".$lang['to install new theme']."
      ";
    }
}

// Checkin active theme by directory
function check_active_theme($conn, $dir) {  
  $sql = "select id from cms_themes WHERE dir = '".$dir."' and status = '1'";
  $result = mysqli_query($conn, $sql);
  if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;
   return true;
}

// Get directory of the active theme
function get_theme_active($conn)  {
  $sql = "select dir from cms_themes WHERE status = '1'";
  $result = mysqli_query($conn, $sql);
  if (!$result)
   return false;
  $count_rows = mysqli_num_rows($result);
  if ($count_rows < 1)
    return false;
  $result = mysqli_fetch_assoc($result);
  return $result['dir'];
}  