<?php
session_start();
include('include/db.php');
include('cpanel/include/install.php');
include('cpanel/include/lang.php');
include('cpanel/include/auth.php');
include('cpanel/include/themes.php');
include('cpanel/include/modules.php');
include('include/functions/f_menu.php');
include('cpanel/include/functions/f_header_footer.php');
include('cpanel/include/functions/f_products.php');
include('cpanel/include/functions/f_options.php');
include('include/functions/f_innerpage.php');

if ($_GET['result'] == 'empty') {
  echo "<div class='alert alert-danger'>".$lang[$code]['064']."</div>";
}
else if ($_GET['result'] == 'wrong_data') {
  echo "<div class='alert alert-danger'>".$lang[$code]['065']."</div>";
}
else if ($_GET['result'] == 'failed') {
  echo "<div class='alert alert-danger'>".$lang[$code]['066']."</div>";
}
else {
  echo "";
}              

// Check connection
if (!$conn || $_GET['result'] == 'failed') {
  // Installation language
  $code = 'ru';
  make_install($_GET['host'], $_GET['username'], $_GET['dbname'], $lang[$code], $code);
}
else {

  // Getting cms options
  $cms_options = get_cms_options($conn);

  // Creating variables
  $cms_version = $cms_options[0]['option_value'];
  $cms_lang = $cms_options[1]['option_value'];

  // Set language
  $code = $cms_lang;

  $menu = get_navigation($conn);
  $header_footer = get_header_footer($conn);
  $theme = get_theme_active($conn);
  
  if (check_index_page($conn, $_SERVER['REQUEST_URI']) == true) {
    $index_page = get_index_page($conn);
    show_index_page($conn, $index_page, $header_footer, $menu, $theme);
  }
  else {
    $inner_page = get_inner_page($conn, $_SERVER['REQUEST_URI']);
    if (($inner_page == false) && (!$_GET)) {
      show_404_page($conn, $inner_page, $header_footer, $menu, $theme);
    }
    else {
      show_inner_page($conn, $inner_page, $header_footer, $menu, $theme);
    }
  }
}
?>