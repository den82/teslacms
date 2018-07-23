<?php
session_start();
include('../include/db.php');
include('include/install.php');
include('include/lang.php');
include('include/auth.php');
include('include/user.php');
include('include/menu.php');
include('include/modules.php');
include('include/functions/f_header_footer.php');
include('include/functions/f_options.php');

// Getting cms options
$cms_options = get_cms_options($conn);

// Creating variables
$cms_version = $cms_options[0]['option_value'];
$cms_lang = $cms_options[1]['option_value'];

// Set coockies for language
if ($_COOKIE['code']) {
  $code = $_COOKIE['code'];
}
// Russian language as default from database
else {
  $code = $cms_lang;
}

// Get info about user and put it into array $user
if ($_SESSION['username']) {
  $user = get_user($conn, $_SESSION['username']);
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">    

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="css/style.css">

    <script type="text/javascript" src="js/jquery2.js"></script>
    <script type="text/javascript" src="js/jquery.maskedinput-1.2.2.js"></script>
    <script type="text/javascript">
    jQuery(function($) {
      $.mask.definitions['~']='[+-]';
      $('#phone').mask('(999) 999-99-99');
    });
    </script> 

    <title>TeslaCMS: <?php echo $lang[$code]['cp'];?></title>
  </head>
  <body>
     <div class="container-fluid">
        
        <div class="row header">
              <div class="col-lg-8 col-md-12 top_left">
                  <b>TeslaCMS</b> - <?php echo $lang[$code]['version'];?> <?php echo $cms_version;?>
              </div>
              <div class="col-lg-4 col-md-12 top_right">
                  <?php 
                  if ($_SESSION['username']) { 
                    echo $lang[$code]['loged in as']." <b>". $user['username']."</b>"; ?>. <a href="logout.php" class='logout'> <?php echo $lang[$code]['logout'];?></a>
                  <?php } ?>
              </div>
        </div>

        <div class="row content">
            <?php 
            if ($_SESSION['username']) { 
            ?>
            <div class="col-xl-2 col-md-3 col-sm-12 content_left">
                <?php 
                $modules = get_active_modules($conn);
                display_cms_menu($conn, $user, $modules, $lang[$code], $code);
                ?>
            </div>
            <div class="col-xl-10 col-md-9 col-sm-12 content_right">

                <div class="breadcrumbs">
                  <?php display_breadcrumbs($conn, $_SERVER['REQUEST_URI'], '', $lang[$code]); ?>
                </div>
                
                <?php
                  if ($_GET['mode'] == 'edit') {
                    if ($_GET['result'] == 'logo_fail') {
                      echo "<div class='alert alert-danger'>".$lang[$code]['033']."</div>";
                    }
                    $header_footer = get_header_footer($conn);
                    if ($_GET['submode'] == 'header') { 
                      display_header_form($header_footer, $lang[$code]);
                    }
                    if ($_GET['submode'] == 'footer') {
                      display_footer_form($header_footer, $lang[$code]);
                    }
                  }
                  else {
                    if ($_GET['result'] == 'header_success') {
                      echo "<div class='alert alert-success'>".$lang[$code]['034']."</div>";
                    }
                    if ($_GET['result'] == 'header_fail') {
                      echo "<div class='alert alert-success'>".$lang[$code]['035']."</div>";
                    }
                    if ($_GET['result'] == 'footer_success') {
                      echo "<div class='alert alert-success'>".$lang[$code]['036']."</div>";
                    }
                    if ($_GET['result'] == 'footer_fail') {
                      echo "<div class='alert alert-success'>".$lang[$code]['037']."</div>";
                    }
                    display_header_footer($lang[$code]);
                  }
                ?>
            </div>

            <?php 
            }
            else {
                
                echo "<div class='col-md-4 offset-md-4'>";
                  display_login_form($lang[$code], $code, $conn, $cms_login, $cms_password, $type);
                echo "</div>";
            }
            ?>
      </div>

      <div class="row footer">
            <div class="col-lg-12 col-md-12">
                <a target="_blank" href="http://teslacms.ru">teslacms.ru</a>
            </div>
      </div>

    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    
    <script type="text/javascript" src="js/jquery1.3.2.js"></script>
    <script type="text/javascript" src="js/jquery.maskedinput-1.2.2.js"></script>
    <script type="text/javascript">
    jQuery(function($) {
    $.mask.definitions['~']='[+-]';
    $('#header_phone').mask('(999) 999-99-99');
    });</script>

  </body>
</html>