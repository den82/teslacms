<?php
session_start();
include('../include/db.php');
include('include/install.php');
include('include/lang.php');
include('include/auth.php');
include('include/user.php');
include('include/menu.php');
include('include/modules.php');
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

// If TeslaCMS was installed with success set $type as 1. It means auth form will get values: username = admin and password = admin
if ($_GET['result'] == 'success') {
  $type = 1;
  
}
else {
  $type = 0;
}
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="css/style.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

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

                <div class="row">
                  <div class="col-sm-12">
                      <div style='margin:0 15px;'>
                          <?php echo "<div class='headline'><h1>".$lang[$code]['cp index']."</h1></div>"; ?>
                          <?php 
                          if (($_SESSION['username'] == 'admin') && (check_secure_password($conn) == true)) {
                            echo "<div class='alert alert-warning' role='alert'>".$lang[$code]['welcome']."</div>";
                          }
                          ?>
                      </div>
                  </div>
                </div>
                
                
                <div class="row">
                  <div class="col-sm-12">
                      <div style='margin:0 15px;'>
                          <h3><?php echo $lang[$code]['051'];?></h3>
                      </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="card" style='margin-left:15px;'>
                      <h5 class="card-header"><?php echo $lang[$code]['mainpage'];?></h5>
                      <div class="card-body">
                        <!--<h5 class="card-title">Special title treatment</h5>-->
                        <p class="card-text"><?php echo $lang[$code]['052'];?></p>
                        <a href="/cpanel/mainpage.php" class="btn btn-primary"><?php echo $lang[$code]['get me there'];?></a>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="card" style='margin-right:15px;'>
                      <h5 class="card-header"><?php echo $lang[$code]['053'];?></h5>
                      <div class="card-body">
                        <!--<h5 class="card-title">Special title treatment</h5>-->
                        <p class="card-text"><?php echo $lang[$code]['054'];?></p>
                        <a href="/cpanel/mainpage.php?mode=edit&type=products" class="btn btn-primary"><?php echo $lang[$code]['get me there'];?></a>
                      </div>
                    </div>
                  </div>
                </div>
                <br><br>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="card" style='margin-left:15px;'>
                      <h5 class="card-header"><?php echo $lang[$code]['structure'];?></h5>
                      <div class="card-body">
                        <!--<h5 class="card-title">Special title treatment</h5>-->
                        <p class="card-text"><?php echo $lang[$code]['055'];?></p>
                        <a href="/cpanel/innerpage.php?mode=getin&pid=0" class="btn btn-primary"><?php echo $lang[$code]['get me there'];?></a>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="card" style='margin-right:15px;'>
                      <h5 class="card-header"><?php echo $lang[$code]['security'];?></h5>
                      <div class="card-body">
                        <!--<h5 class="card-title">Special title treatment</h5>-->
                        <p class="card-text"><?php echo $lang[$code]['056'];?></p>
                        <a href="/cpanel/security.php" class="btn btn-primary"><?php echo $lang[$code]['get me there'];?></a>
                      </div>
                    </div>
                  </div>
                </div>
                <br>
                <br>
                <div class="row">
                  <div class="col-sm-12">
                      <div style='margin:0 15px;'>
                          <h3><?php echo $lang[$code]['057'];?></h3>
                      </div>
                  </div>
                </div>
                
                <br>
                <div class="row">
                  <div class="col-sm-6">
                    <div class="card" style='margin-left:15px;'>
                      <h5 class="card-header" style='background: #e6583b; color:#ffffff;'><?php echo $lang[$code]['ask a question'];?></h5>
                      <div class="card-body">
                        <!--<h5 class="card-title">Special title treatment</h5>-->
                        <p class="card-text"><?php echo $lang[$code]['058'];?></p>
                        <a target="_blank" href="https://teslacms.ru/support/ask/" class="btn btn-primary"><?php echo $lang[$code]['get me there'];?></a>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="card" style='margin-right:15px;'>
                      <h5 class="card-header" style='background: #e6583b; color:#ffffff;'><?php echo $lang[$code]['custom development'];?></h5>
                      <div class="card-body">
                        <!--<h5 class="card-title">Special title treatment</h5>-->
                        <p class="card-text"><?php echo $lang[$code]['059'];?></p>
                        <a target="_blank" href="https://teslacms.ru/support/custom_development/" class="btn btn-primary"><?php echo $lang[$code]['get me there'];?></a>
                      </div>
                    </div>
                  </div>
                </div>
                <br>



            </div>

            <?php 
            }
            else {
                echo "<div class='col-md-4 offset-md-4'>";
                  if ($_GET['result'] == 'signin_empty') {
                    echo "<div class='alert alert-danger' style='margin-top:50px;'>".$lang[$code]['fill the sign in form']."</div>";
                  }
                  if ($_GET['result'] == 'signin_failed') {
                    echo "<div class='alert alert-danger' style='margin-top:50px;'>".$lang[$code]['wrong username or password']."</div>";
                  }
                  display_login_form($lang[$code], $code, $conn, $cms_login, $cms_password, $type);
                echo "</div>";
            }
            ?>
      </div>

      <div class="row footer">
            <div class="col-lg-12 col-md-12">
                <a target="_blank" href="http://teslacms.ru" style="color:#ffffff;">teslacms.ru</a>
            </div>
      </div>

    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </body>
</html>