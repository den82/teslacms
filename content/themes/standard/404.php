<?php 
header("HTTP/1.0 404 Not Found"); 
$phone_clear = preg_replace('~[^0-9]+~','',$header_footer['header_phone']);
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link rel="stylesheet" href="<?php echo $path;?>/css/style.css">

    <title>Ошибка 404 - страница не найдена</title>
    
  </head>
  <body>


    <div class="container-fluid">
    <!-- Шапка -->
    <div class="row" style="background:<?php echo $header_footer['header_bg'];?>;">
      <div class="col-xl-8 offset-xl-2 col-md-12 header">
        <div class="row">
          <div class="col-xl-3 col-md-3 header-logo">
            <a href="/">
            <?php echo "<img src='".$header_footer['header_logo']."' alt='".$index_page['title']."' title='".$index_page['title']."'></a>"; ?>
          </div>
          <div class="col-xl-6 col-md-6 header-text">
            <?php echo $header_footer['header_center_section'];?>
          </div>
          <div class="col-xl-3 col-md-3 header-phone">
            <a href="tel:+7<?php echo $phone_clear;?>"><?php echo $header_footer['header_phone'];?></a>
          </div>
        </div>
      </div>
    </div>

    <!-- Navigation -->
    <?php
    $menu = get_navigation($conn);
    $settings =  get_navigation_settings($conn);
    display_navigation($conn, $menu, $settings);
    ?>

    <!-- Контент -->
    <div class="row content">
      <div class="col-xl-8 offset-xl-2 col-md-12">
        <div class="title">
          <h1>Ошибка 404 - страница не найдена</h1>
        </div>
        <p>
        Запрашиваемая вами страница или файл найти не удалось.
        <br><br><br><br><br><br><br><br><br><br><br>

      </div>
    </div>


    <!-- Footer -->
    <div class="row" style="background: #383838 url('http://www.it-palitra.ru/assets/tpl/images/footer.gif') repeat-x;">
      <div class="col-xl-8 offset-xl-2 col-md-12">
        <div class="row">
          <div class="col-md-6 col-lg-3 col-xl-3 col-sm-12 footer-block1">
            <div class="footer-logo">
              <?php
              if ($header_footer['footer_logo'] != '') {
              echo "<a href='/'><img src='".$header_footer['footer_logo']."' alt=''></a>";
              }
              ?>
            </div>
            <div class="copyright">
              <?php
              if ($header_footer['footer_text'] != '') {
                echo $header_footer['footer_text'];
              }
              ?>
            </div>
          </div>
          <div class="col-lg-4 col-xl-4 offset-xl-1 offset-lg-1 col-sm-12 footer-block2">
            <?php
            if ($header_footer['footer_navigation'] == '1') {
            $menu = get_navigation($conn);
            display_menu_up_level($menu);
            }
            ?>
             
          </div>
          <div class="col-md-6 col-lg-4 col-xl-4 col-sm-12 footer-block3">
            <?php
            if ($header_footer['footer_phone'] != '') {
            $phone_clear = preg_replace('~[^0-9]+~','',$header_footer['footer_phone']);
            echo "
            <div class='footer-title'><a href='tel:+7".$phone_clear."' style='color:#ffffff; font-size:28px;'>".$header_footer['footer_phone']."</a></div>";
            }
            if ($header_footer['footer_email'] != '') { 
            echo "
            <div style='color:#ffffff;'>E-mail: <a href='mailto:".$header_footer['footer_email']."' style='color:#ffffff;'>".$header_footer['footer_email']."</a></div><br>";
            }

            if ($header_footer['footer_address'] != '') {
            echo "
            <p style='color:#fff;'>
            <strong>Адрес:</strong> ".$header_footer['footer_address']."<br>";
            }
            ?> 
            <br>
            <?php
            if ($header_footer['vkontakte'] != '') {
              echo "<a target='_blank' href='".$header_footer['vkontakte']."'><img src='".$path."/img/v.png' alt='Vkontakte'></a>&nbsp;&nbsp;&nbsp;";
            }
            if ($header_footer['facebook'] != '') {
              echo "<a target='_blank' href='".$header_footer['facebook']."'><img src='".$path."/img/f.png' alt='Мы в Facebook'></a>&nbsp;&nbsp;&nbsp;";
            }
            if ($header_footer['twitter'] != '') {
              echo "<a target='_blank' href='".$header_footer['twitter']."'><img src='".$path."/img/t.png' alt='Мы в Twitter'></a>&nbsp;&nbsp;&nbsp;";
            }
            if ($header_footer['google'] != '') {
              echo "<a target='_blank' href='".$header_footer['google']."'><img src='".$path."/img/g.png' alt='Мы в Google Plus'></a>&nbsp;&nbsp;&nbsp;";
            }
            ?>
            <p>
            <?php echo $header_footer['footer_copyright'];?>
          </div>
        </div>

        <div class="row developer">
          <div class="col-md-12">
            <a target="_blank" href="https://teslacms.ru">teslacms.ru</a>
          </div>
        </div>

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