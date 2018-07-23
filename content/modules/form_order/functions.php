<?php

// Вставляем строку в таблицу модулей
// 2017
function delete_row_in_modules($conn, $dir) {
  $sql = "DELETE FROM cms_modules WHERE dir = '".$dir."'";
  $result = mysqli_query($conn, $sql);
  if (!$result)
    return false;
  return true; 
}


function delete_table_form_order($conn, $table1, $table2) {
  $sql1 = "TRUNCATE TABLE ".$table1."";
  $result1 = mysqli_query($conn, $sql1);

  $sql1_ = "DROP TABLE ".$table1."";
  $result1_ = mysqli_query($conn, $sql1_);

  $sql2 = "TRUNCATE TABLE ".$table2."";
  $result2 = mysqli_query($conn, $sql2);

  $sql2_ = "DROP TABLE ".$table2."";
  $result2_ = mysqli_query($conn, $sql2_);

  return true;
}



function delete_module_forever($module) {
  $dir = "../".$module."/";
  $result = removeDirectory($dir);
  
  if (!$result)
   return false;
  return true;
}


function removeDirectory($dir) {
  if ($objs = glob($dir."/*")) {
     foreach($objs as $obj) {
     is_dir($obj) ? removeDirectory($obj) : unlink($obj);
     }
  }
  rmdir($dir);
  return true;
}

function get_settings_form_order($conn) {
   $sql = "SELECT * FROM cms_form_order_settings WHERE id = '1'";
   $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;  
   $result = mysqli_fetch_assoc($result);
   return $result;
}

function form_order_settings($conn, $array, $username) {
	$sql = "UPDATE cms_form_order_settings SET 
	modifiedon = now(), 
	modifiedby = '".$username."',
	subject = '".$array['subject']."',
	email = '".$array['email']."',
	charset = '".$array['charset']."'
	WHERE id = '1'
	";
	$result = mysqli_query($conn, $sql);
	if (!$result)
	return false;
	return true; 
}


function send_mail($array, $settings) {

	$mes = "
	<!DOCTYPE html>
	<html lang='ru'>
	<head>
	  <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	<BODY>
	<P>
	<b>Имя:</b> ".$array['name']."<br>
	<b>E-mail:</b> ".$array['email']."<br>
	<b>Телефон:</b> ".$array['phone']."<br>
	<b>Заказ/вопрос:</b> ".$array['message']."
	</BODY>
	</html>
	";	

	$headers  = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type: text/html; charset=".$settings['charset']."" . "\r\n";
  //$headers .= "From: d.tereshchuk@gmail.com" . "\r\n";
  //$headers .= "Reply-To: d.tereshchuk@gmail.com" . "\r\n" .
  //$headers .= "X-Mailer: PHP/" . phpversion();

	if (mail($settings['email'], $settings['subject'], $mes, $headers))
		return true;
	return false;
}

function display_form_order() {
	?>
	
	<form method="post" action="/content/modules/form_order/action.php" enctype="multipart/form-data" data-parsley-validate style="margin-bottom:25px;">
    <input type="hidden" name="mode" value="order">

    <div class="form-group">
      <label for="exampleFormControlInput1"><b>Ваше имя <font color="red">*</font></b></label>
      <input type="text" class="form-control" name="name" id="name" value='<?php echo $array['name']; ?>' required>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b>Ваш e-mail <font color="red">*</font></b></label>
      <input type="email" class="form-control" name="email" id="email" value='<?php echo $array['email']; ?>' required>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b>Ваш телефон <font color="red">*</font></b></label>
      <input type="phone" class="form-control" name="phone" id="phone" value='<?php echo $array['name']; ?>' required>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b>Ваш заказ/вопрос <font color="red">*</font></b></label>
      <textarea class="form-control" id="exampleFormControlTextarea1" name="message" id="message" rows="6" required><?php echo $array['message']; ?></textarea>
    </div>

    <div class="g-recaptcha" data-sitekey="6Lc05SsUAAAAAAdv5N84otgGcpZHy_nUTAiSXPDi" style='margin:25px 0;'></div>

    <button type='submit' class='btn btn-primary mb-2'>Отправить</button>
  </form>

  <?php
}



function display_settings_form_order($array) {
	?>

	<div class="headline"><h1>Настройки модуля "Форма заказа"</h1></div>

	<form method="post" action="/content/modules/form_order/action.php" enctype="multipart/form-data" data-parsley-validate style="margin-bottom:25px;">
    <input type="hidden" name="mode" value="settings">

    <div class="form-group">
      <label for="exampleFormControlInput1"><b>E-mail получателя (можно указать несколько через запятую) <font color="red">*</font></b></label>
      <input type="text" class="form-control" name="email" id="email" value='<?php echo $array['email']; ?>' required>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b>Тема письма <font color="red">*</font></b></label>
      <input type="text" class="form-control" name="subject" id="subject" value='<?php echo $array['subject']; ?>' required>
    </div>

    <div class="form-group">
      <label for="exampleFormControlInput1"><b>Кодировка письма <font color="red">*</font></b></label>
      <select class="form-control" name="charset" id="exampleFormControlSelect1" required>
        <?php
        if ($array['charset'] == 'utf-8') {
          echo "<option value='utf-8' selected>utf-8</option>";
          echo "<option value='windows-1251'>windows-1251</option>";
        }
        else if ($array['charset'] == 'windows-1251') {
          echo "<option value='utf-8'>utf-8</option>";
          echo "<option value='windows-1251' selected>windows-1251</option>";
        }
        else {
          echo "<option value='utf-8'>utf-8</option>";
          echo "<option value='windows-1251'>windows-1251</option>";
        }
        ?>
      </select>
    </div>

    <button type='submit' class='btn btn-primary mb-2'>Сохранить</button>
  </form>

  <?php
}

?>