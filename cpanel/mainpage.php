<?php
session_start();
include('../include/db.php');
include('include/install.php');
include('include/lang.php');
include('include/auth.php');
include('include/user.php');
include('include/menu.php');
include('include/modules.php');
include('include/functions/f_mainpage.php');
include('include/functions/f_innerpage.php');
include('include/functions/f_products.php');
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
    
    <script src="js/parsley.min.js"></script>

    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="ckeditor/ajexFileManager/ajex.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="css/style.css">

    <style>
  #container1{overflow:hidden;width:100%}
  #sortable{overflow:hidden;width:100%}
  .box1{white-space:nowrap}
  .box1 div{display:inline-block;border-bottom:1px solid #f5f5f5; padding-top:12px;}
  .box1_header div{display:inline-block; padding-top:12px;}
  </style>

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
                // Обработчик ошибок
                if ($_GET['result'] == 'success') {
                  echo "<div class='alert alert-success'>".$lang[$code]['saved successfully']."</div>";
                }
                else if ($_GET['result'] == 'product_success_deleted') {
                  echo "<div class='alert alert-success'>".$lang[$code]['item deleted successfully']."</div>";
                }
                else if ($_GET['result'] == 'product_fail_deleted') {
                  echo "<div class='alert alert-danger'>".$lang[$code]['item not deleted']."</div>";
                }
                else if ($_GET['result'] == 'product_settings_success') {
                  echo "<div class='alert alert-success'>".$lang[$code]['saved successfully']."</div>";
                }
                else if ($_GET['result'] == 'product_settings_fail') {
                  echo "<div class='alert alert-danger'>".$lang[$code]['not saved']."</div>";
                }
                
                else {
                  echo "";
                }
                
                if ($_GET['mode'] == 'edit') {
                  $first_page_data = get_mainpage($conn);
                  if ($_GET['type'] == 'meta') {
                    display_edit_fp_meta($first_page_data, $lang[$code]);
                  }
                  if ($_GET['type'] == 'main') {
                    display_edit_fp_main($first_page_data, $lang[$code], $code);
                  }
                  if ($_GET['type'] == 'map') {
                    display_edit_fp_map($first_page_data, $lang[$code]);
                  }
                  if ($_GET['type'] == 'products') {
                    if ($_GET['subtype'] == 'add') {
                      if ($_GET['result'] == 'product_img_fail') {
                        echo "<div class='alert alert-danger'>".$lang[$code]['023']."</div>";
                      }
                      display_add_fp_products($conn, $lang[$code], $code);
                    }
                    else if ($_GET['subtype'] == 'edit') {
                      if ($_GET['result'] == 'product_img_fail') {
                        echo "<div class='alert alert-danger'>".$lang[$code]['023']."</div>";
                      }
                      $product = get_product_by_id($conn, $_GET['id']);
                      display_edit_fp_products($conn, $product, $lang[$code], $code);
                    }
                    else if ($_GET['subtype'] == 'settings') {
                      $settings = get_product_settings($conn);
                      display_settings_fp_products($conn, $settings, $lang[$code]);
                    }
                    else {
                      $products = get_products($conn);
                      display_all_products($products, $lang[$code]);
                    }
                  }
                  if ($_GET['type'] == 'free_section') {
                    display_edit_fp_free_section($first_page_data, $lang[$code]);
                  }
                }
                else {
                  $mainpage = get_mainpage($conn);
                  display_mainpage($mainpage, $lang[$code]);
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

    <!-- Jquery sorting pages library -->
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
  <!-- Custom scripts -->
    <script type="text/javascript" src="js/scripts.js"></script>
    
    <script type="text/javascript">   
      /* Charecters left */ 
    $(document).ready(function(){       
      $('#title').limit('#charsLeft_title', 80);  
      $('#description').limit('#charsLeft_description', 140);
    });   

    /* Sorting pages */
    $(document).ready(function () {
        $('#sortable').sortable({
            axis: 'y',
            stop: function (event, ui) {
              var data = $(this).sortable('serialize');
                $('#resu').text(data);
                $.ajax({
                    data: data,
                    type: 'POST',
                    url: '/cpanel/include/action_sort_products.php'
                });
      }
        });
    });
  </script>
  </body>
</html>