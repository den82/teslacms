<?php
// Installation page
function make_install($host, $username, $dbname, $lang, $code) {
	echo "
	<!doctype html>
	<html lang='en'>
	  <head>
	    <!-- Required meta tags -->
	    <meta charset='utf-8'>
	    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>

	    <!-- Bootstrap CSS -->
	    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' integrity='sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm' crossorigin='anonymous'>

	    <title>".$lang['062']."</title>
	  </head>
	  <body>

		<div class='container-fluid' style='margin-top:50px;'>
        	<div class='row'>
          		<div class='col-md-4 offset-md-4'>";
				echo "<h1>".$lang['062']."</h1>";

				echo "<p>".$lang['063']."";

				echo "<form method='post' action='cpanel/include/action.php'>";
				echo "
				<input type='hidden' name='mode' value='install'>
				<input type='hidden' name='lang' value='".$code."'>
				<div class='form-group'>
					<label><b>".$lang['Server name']."</b></label>
					<input type='text' name='host' class='form-control' id='exampleFormControlInput1' value='".$host."'>
				</div>
				<div class='form-group'>
					<label><b>".$lang['Username']."</b></label>
					<input type='text' name='username' class='form-control' id='exampleFormControlInput1' value='".$username."'>
				</div>
				<div class='form-group'>
					<label><b>".$lang['Password']."</b></label>
					<input type='password' name='password' class='form-control' id='exampleFormControlInput1'>
				</div>
				<div class='form-group'>
					<label><b>".$lang['Database']."</b></label>
					<input type='text' name='dbname' class='form-control' id='exampleFormControlInput1' value='".$dbname."'>
				</div>

				<button type='submit' class='btn btn-primary mb-2'>".$lang['Install']."</button>

			</form>
		</div>
      </div>
    </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src='https://code.jquery.com/jquery-3.2.1.slim.min.js' integrity='sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN' crossorigin='anonymous'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js' integrity='sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q' crossorigin='anonymous'></script>
    <script src='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js' integrity='sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl' crossorigin='anonymous'></script>
    </body>
	</html>
    ";
}

// Import tables in database
function import_tables($conn, $lang) {
	// Russian version
	if ($lang == 'ru') {
		$sql1 = "
		CREATE TABLE IF NOT EXISTS cms_admin (
		  id int(3) unsigned NOT NULL auto_increment,
		  createdon datetime NOT NULL,
		  modifiedon timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
		  createdby varchar(50) NOT NULL,
		  modifiedby varchar(50) NOT NULL,
		  username varchar(50) NOT NULL,
		  password varchar(50) NOT NULL,
		  email varchar(50) NOT NULL,
		  surname varchar(50) NOT NULL,
		  name varchar(50) NOT NULL,
		  position varchar(50) NOT NULL,
		  permitions varchar(50) NOT NULL,
		  lang varchar(2) NOT NULL,
		  status int(1) NOT NULL,
		  PRIMARY KEY (id)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
		";
		$result1 = mysqli_query($conn, $sql1);

		$sql1_ = "INSERT INTO cms_admin VALUES (1, now(), now(), 'admin', '', 'admin', '".md5('admin')."', '', '', '', '', '1,1,1', 'ru', 1);";
		$result1_ = mysqli_query($conn, $sql1_);


		$sql2 = "
		CREATE TABLE IF NOT EXISTS cms_pages (
		  id int(10) unsigned NOT NULL auto_increment,
		  pid int(4) NOT NULL,
		  mid int(2) NOT NULL,
		  submid int(2) NOT NULL,
		  createdon datetime NOT NULL,
		  modifiedon timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
		  createdby varchar(255) NOT NULL,
		  modifiedby varchar(255) NOT NULL,
		  link varchar(255) NOT NULL,
		  title varchar(255) NOT NULL,
		  headline varchar(255) NOT NULL,
		  description varchar(255) NOT NULL,
		  keywords varchar(255) NOT NULL,
		  content text NOT NULL,
		  block_down_id int(11) NOT NULL,
		  block_sidebar_id int(11) NOT NULL,
		  status int(1) NOT NULL,
		  sort int(2) NOT NULL,
		  PRIMARY KEY  (id)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;
		";
		$result2 = mysqli_query($conn, $sql2);

		$sql2_ = "INSERT INTO cms_pages ( id, pid, mid, submid, createdon, modifiedon, createdby, modifiedby, link, 
		title, headline, description, keywords, content, block_down_id, block_sidebar_id, status, sort) VALUES
		(1, 0, 0, 0, now(), now(), '', '', 'about', 'О компании', 'О компании', '', '', '', '0', '0', 1, 10),
		(2, 0, 0, 0, now(), now(), '', '', 'products', 'Услуги', 'Услуги', '', '', '', '0', '0', 1, 20),
		(3, 0, 0, 0, now(), now(), '', '', 'price', 'Цены', 'Цены', '', '', '', '0', '0', 1, 30),
		(4, 0, 0, 0, now(), now(), '', '', 'order', 'Заказать', 'Заказать', '', '', '', '0', '0', 1, 40),
		(5, 0, 0, 0, now(), now(), '', '', 'contacts', 'Контакты', 'Контакты', '', '', '', '0', '0', 1, 40),
		(6, 2, 0, 0, now(), now(), '', '', 'amsterdam', 'Тур в амстердам', 'Тур в амстердам', '', '', '', '0', '0', 1, 40),
		(7, 2, 0, 0, now(), now(), '', '', 'paris', 'Тур в Париж', 'Тур в Париж', '', '', '', '0', '0', 1, 40),
		(8, 2, 0, 0, now(), now(), '', '', 'london', 'Тур в Лондон', 'Тур в Лондон', '', '', '', '0', '0', 1, 40);
		";
		$result2_ = mysqli_query($conn, $sql2_);


		$sql3= "
		CREATE TABLE IF NOT EXISTS cms_firstpage (
		  id int(1) unsigned NOT NULL,
		  createdon datetime NOT NULL,
		  modifiedon timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  createdby varchar(100) NOT NULL,
		  modifiedby varchar(100) NOT NULL,
		  title varchar(255) NOT NULL,
		  slogan varchar(255) NOT NULL,
		  description varchar(255) NOT NULL,
		  keywords varchar(255) NOT NULL,
		  main_h1 varchar(100) NOT NULL,
		  main_content text NOT NULL,
		  main_status int(1) NOT NULL,
		  products_status int(1) NOT NULL,
		  free_section_headline varchar(100) NOT NULL,
		  free_section_content text NOT NULL,
		  free_section_status int(1) NOT NULL,
		  map text NOT NULL,
		  map_status int(1) NOT NULL,
		  status int(1) NOT NULL,
		  PRIMARY KEY (id)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		";
		$result3 = mysqli_query($conn, $sql3);

		$sql3_ = "
		INSERT INTO cms_firstpage (id, createdon, modifiedon, createdby, modifiedby, title, slogan, description, keywords, main_h1, main_content,  main_status, products_status, free_section_headline, free_section_content, free_section_status, map, map_status, status) VALUES
		(1, 
		now(), 
		now(),
		'',
		'', 
		'Title', 
		'A new website on TeslaCMS', 
		'Description', 
		'Keywords', 
		'Заголовок главной страницы', 
		'<p>
		Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

	<p><a class=\"btn btn-primary\" href=/cpanel/>В панель администрирования</a></p>
	',  
		1, 
		1,
		'Прайс-лист',
		'
		<table class=table>
		<thead class=thead-light>
			<tr>
				<th scope=col>&nbsp;</th>
				<th scope=col>3 дня</th>
				<th scope=col>7 дней</th>
				<th scope=col>14 дней</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th scope=row>Париж</th>
				<td>43 900</td>
				<td>95 900</td>
				<td>142 900</td>
			</tr>
			<tr>
				<th scope=row>Лондон</th>
				<td>49 900</td>
				<td>119 900</td>
				<td>169 900</td>
			</tr>
			<tr>
				<th scope=row>Берлин</th>
				<td>39 900</td>
				<td>92 900</td>
				<td>131 900</td>
			</tr>
			<tr>
				<th scope=row>Рим</th>
				<td>43 900</td>
				<td>95 900</td>
				<td>142 900</td>
			</tr>
			<tr>
				<th scope=row>Прага</th>
				<td>49 900</td>
				<td>119 900</td>
				<td>169 900</td>
			</tr>
			<tr>
				<th scope=row>Вена</th>
				<td>39 900</td>
				<td>92 900</td>
				<td>131 900</td>
			</tr>
		</tbody>
	</table>

	<p><a class=\"btn btn-primary\" href=/price/>Показать все предложения</a></p>
	',
		1, 
		'<script type=text/javascript charset=utf-8 async src=https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3AwYJbX_YFZa64kKVvwIRpS_yplSkeiyiw&amp;width=100%25&amp;height=400&amp;lang=ru_RU&amp;scroll=true></script>',
		1, 
		0);
		";
		$result3_ = mysqli_query($conn, $sql3_);


		$sql4 = "
		CREATE TABLE IF NOT EXISTS cms_themes (
		  id int(2) unsigned NOT NULL auto_increment,
		  createdon datetime NOT NULL,
		  modifiedon timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  createdby varchar(100) NOT NULL,
		  modifiedby varchar(100) NOT NULL,
		  dir varchar(255) NOT NULL,
		  name varchar(255) NOT NULL,
		  status int(1) NOT NULL,
		  PRIMARY KEY  (id)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
		";
		$result4 = mysqli_query($conn, $sql4);
		
		$sql4_ = "
		INSERT INTO cms_themes (id, createdon, modifiedon, createdby, modifiedby, dir, name, status) VALUES
		(1, now(), now(), '', '', 'standard', 'Стандартная тема', 1);
		";
		$result4_ = mysqli_query($conn, $sql4_);


		$sql5 = "
		CREATE TABLE IF NOT EXISTS cms_blocks (
		  id int(2) unsigned NOT NULL AUTO_INCREMENT,
		  createdon datetime NOT NULL,
		  modifiedon timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  createdby varchar(100) NOT NULL,
		  modifiedby varchar(100) NOT NULL,
		  name varchar(255) NOT NULL,
		  content text NOT NULL,
		  PRIMARY KEY (id)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;
		";
		$result5 = mysqli_query($conn, $sql5);
		
		$sql5_ = "
		INSERT INTO cms_blocks (id, createdon, modifiedon, createdby, modifiedby, name, content) VALUES
		(1, now(), now(), '', '', 'Bottom block', ''),
		(2, now(), now(), '', '', 'Right block', '');
		";
		$result5_ = mysqli_query($conn, $sql5_);


		$sql6 = "
		CREATE TABLE IF NOT EXISTS cms_menu (
		  id int(2) unsigned NOT NULL AUTO_INCREMENT,
		  createdon datetime NOT NULL,
		  modifiedon timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  createdby varchar(100) NOT NULL,
		  modifiedby varchar(100) NOT NULL,
		  name varchar(255) NOT NULL,
		  bgcolor varchar(7) NOT NULL,
		  line_color varchar(7) NOT NULL,
		  bg_button varchar(7) NOT NULL,
		  search int(1) NOT NULL,
		  status int(1) NOT NULL,
		  PRIMARY KEY (id)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
		";
		$result6 = mysqli_query($conn, $sql6);

		$sql6_ = "
		INSERT INTO cms_menu (id, createdon, modifiedon, createdby, modifiedby, name, bgcolor, line_color, bg_button, search, status) VALUES
		(1, now(), now(), '', '', 'Main navigation', '#b21f2d', '#117a8b', '#b21f2d', 0, 1);
		";
		$result6_ = mysqli_query($conn, $sql6_);


		$sql7 = "
		CREATE TABLE IF NOT EXISTS cms_logs (
		  id int(11) unsigned NOT NULL AUTO_INCREMENT,
		  created_on datetime NOT NULL,
		  datetime datetime NOT NULL,
		  username varchar(255) NOT NULL,
		  action text NOT NULL,
		  ip varchar(20) NOT NULL,
		  system varchar(255) NOT NULL,
		  PRIMARY KEY (id)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		";
		$result7 = mysqli_query($conn, $sql7);

		$sql8 = "
		CREATE TABLE IF NOT EXISTS cms_products (
		  id int(2) unsigned NOT NULL AUTO_INCREMENT,
		  createdon datetime NOT NULL,
		  modifiedon timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  createdby varchar(100) NOT NULL,
		  modifiedby varchar(100) NOT NULL,
		  product_title varchar(255) NOT NULL,
		  product_text varchar(255) NOT NULL,
		  product_img varchar(255) NOT NULL,
		  page_id int(3) NOT NULL,
		  status int(1) NOT NULL,
		  sort int(3) NOT NULL,
		  PRIMARY KEY (id)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;
		";
		$result8 = mysqli_query($conn, $sql8);


		$sql8_ = "
		INSERT INTO cms_products (id, createdon, modifiedon, createdby, modifiedby, product_title, product_text, product_img, page_id, status, sort) VALUES
		(1, now(), now(), '', '', 'Тур в амстердам', 'Незабываемая поездка в Амстердам - город тюльпанов и потрясающей архитектуры.', '/content/userfiles/images/ywk6crfn.png', 0, 1, 0),
		(2, now(), now(), '', '', 'Увидеть Париж и вернуться', 'Поездка на автобусе в прекрасный и неповторимый Париж, с остановками в Берлине, Кельне и других городах.', '/content/userfiles/images/k45a5cr1.png', 0, 1, 0),
		(3, now(), now(), '', '', 'В Лондон на выходные', 'Что может быть лучше чем провести викенд в Лондоне. Успейте принять участие в розыгрыше поездки.', '/content/userfiles/images/5lsvg8nd.png', 0, 1, 0);
		";
		$result8_ = mysqli_query($conn, $sql8_);


		$sql9= "
		CREATE TABLE IF NOT EXISTS cms_header_footer (
		  id int(1) unsigned NOT NULL,
		  createdon datetime NOT NULL,
		  modifiedon timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  createdby varchar(100) NOT NULL,
		  modifiedby varchar(100) NOT NULL,
		  header_bg varchar(7) NOT NULL,
		  header_logo varchar(255) NOT NULL,
		  header_center_section varchar(255) NOT NULL,
		  header_phone varchar(20) NOT NULL,
		  footer_bg varchar(7) NOT NULL,
		  footer_phone varchar(20) NOT NULL,
		  footer_email varchar(150) NOT NULL,
		  footer_address varchar(255) NOT NULL,
		  footer_text text(1000) NOT NULL,
		  footer_copyright varchar(255) NOT NULL,
		  footer_navigation int(1) NOT NULL,
		  footer_logo varchar(255) NOT NULL,
		  vkontakte varchar(255) NOT NULL,
		  facebook varchar(255) NOT NULL,
		  twitter varchar(255) NOT NULL,
		  google varchar(255) NOT NULL,
		  PRIMARY KEY (id)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		";
		$result9 = mysqli_query($conn, $sql9);

		$sql9_ = "
		INSERT INTO cms_header_footer (id, createdon, modifiedon, createdby, modifiedby, header_bg, header_logo, header_center_section, header_phone, footer_bg, footer_phone, footer_email, footer_address, footer_text, footer_copyright, footer_navigation, footer_logo, vkontakte, facebook, twitter, google) VALUES
		(1, 
		now(), 
		now(),
		'',
		'', 
		'#eef0f5', 
		'/content/userfiles/images/header_logo.png', 
		'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 
		'(812) 123-45-67', 
		'#21292d', 
		'(812) 123-45-67',
		'info@exmple.com',
		'190000, Санкт-Петербург, Возрождения 20А', 
		'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
		'Copyright', 
		'1', 
		'/content/userfiles/images/footer_logo.png', 
		'https://', 
		'https://', 
		'https://',  
		'https://');
		";
		$result9_ = mysqli_query($conn, $sql9_);


		$sql10= "
		CREATE TABLE IF NOT EXISTS cms_white_ip_list (
		  id int(1) unsigned NOT NULL,
		  createdon datetime NOT NULL,
		  modifiedon timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  createdby varchar(100) NOT NULL,
		  modifiedby varchar(100) NOT NULL,
		  ip text NOT NULL,
		  PRIMARY KEY (id)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		";
		$result10 = mysqli_query($conn, $sql10);

		$sql10_ = "
		INSERT INTO cms_white_ip_list (id, createdon, modifiedon, createdby, modifiedby, ip) VALUES
		(1, 
		now(), 
		now(),
		'',
		'', 
		'');
		";
		$result10_ = mysqli_query($conn, $sql10_);


		$sql11 = "
		CREATE TABLE IF NOT EXISTS cms_modules (
		  id int(3) unsigned NOT NULL auto_increment,
		  createdon datetime NOT NULL,
		  modifiedon timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
		  createdby varchar(50) NOT NULL,
		  modifiedby varchar(50) NOT NULL,
		  dir varchar(50) NOT NULL,
		  name varchar(50) NOT NULL,
		  icon varchar(50) NOT NULL,
		  status int(1) NOT NULL,
		  status_mainpage int(3) NOT NULL,
		  PRIMARY KEY (id)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
		";
		$result11 = mysqli_query($conn, $sql11);



		$sql12 = "
		CREATE TABLE IF NOT EXISTS cms_products_settings (
		  id int(2) unsigned NOT NULL AUTO_INCREMENT,
		  createdon datetime NOT NULL,
		  modifiedon timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  createdby varchar(100) NOT NULL,
		  modifiedby varchar(100) NOT NULL,
		  bgcolor varchar(7) NOT NULL,
		  headline varchar(50) NOT NULL,
		  count int(2) NOT NULL,
		  PRIMARY KEY (id)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
		";
		$result12 = mysqli_query($conn, $sql12);


		$sql12_ = "
		INSERT INTO cms_products_settings (id, createdon, modifiedon, createdby, modifiedby, bgcolor, headline, count) VALUES
		(1, now(), now(), '', '', '#eef0f5', 'Мы предлагаем', 0);
		";
		$result12_ = mysqli_query($conn, $sql12_);

		$sql13 = "
		CREATE TABLE IF NOT EXISTS cms_options (
		  id int(1) unsigned NOT NULL AUTO_INCREMENT,
		  option_name varchar(100) NOT NULL,
		  option_value varchar(100) NOT NULL,
		  PRIMARY KEY (id)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
		";
		$result13 = mysqli_query($conn, $sql13);


		$sql13_ = "
		INSERT INTO cms_options (id, option_name, option_value) VALUES
		(1, 'cms_version', '1.0'),
		(2, 'cms_lang', 'ru');
		";
		$result13_ = mysqli_query($conn, $sql13_);

		$sql14 = "
		CREATE TABLE IF NOT EXISTS cms_languages (
		  id int(2) unsigned NOT NULL auto_increment,
		  code varchar(2) NOT NULL,
		  name varchar(50) NOT NULL,
		  PRIMARY KEY (id)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;
		";
		$result14 = mysqli_query($conn, $sql14);

		$sql14_ = "
		INSERT INTO cms_languages (id, code, name) VALUES
		(1, 'en', 'English'),
		(2, 'ru', 'Русский');
		";
		$result14_ = mysqli_query($conn, $sql14_);
	}


	// English version
	if ($lang == 'en') {
		$sql1 = "
		CREATE TABLE IF NOT EXISTS cms_admin (
		  id int(3) unsigned NOT NULL auto_increment,
		  createdon datetime NOT NULL,
		  modifiedon timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
		  createdby varchar(50) NOT NULL,
		  modifiedby varchar(50) NOT NULL,
		  username varchar(50) NOT NULL,
		  password varchar(50) NOT NULL,
		  email varchar(50) NOT NULL,
		  surname varchar(50) NOT NULL,
		  name varchar(50) NOT NULL,
		  position varchar(50) NOT NULL,
		  permitions varchar(50) NOT NULL,
		  lang varchar(2) NOT NULL,
		  status int(1) NOT NULL,
		  PRIMARY KEY (id)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
		";
		$result1 = mysqli_query($conn, $sql1);

		$sql1_ = "INSERT INTO cms_admin VALUES (1, now(), now(), 'admin', '', 'admin', '".md5('admin')."', '', '', '', '', '1,1,1', 'en', 1);";
		$result1_ = mysqli_query($conn, $sql1_);


		$sql2 = "
		CREATE TABLE IF NOT EXISTS cms_pages (
		  id int(10) unsigned NOT NULL auto_increment,
		  pid int(4) NOT NULL,
		  mid int(2) NOT NULL,
		  submid int(2) NOT NULL,
		  createdon datetime NOT NULL,
		  modifiedon timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
		  createdby varchar(255) NOT NULL,
		  modifiedby varchar(255) NOT NULL,
		  link varchar(255) NOT NULL,
		  title varchar(255) NOT NULL,
		  headline varchar(255) NOT NULL,
		  description varchar(255) NOT NULL,
		  keywords varchar(255) NOT NULL,
		  content text NOT NULL,
		  block_down_id int(11) NOT NULL,
		  block_sidebar_id int(11) NOT NULL,
		  status int(1) NOT NULL,
		  sort int(2) NOT NULL,
		  PRIMARY KEY  (id)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;
		";
		$result2 = mysqli_query($conn, $sql2);

		$sql2_ = "INSERT INTO cms_pages ( id, pid, mid, submid, createdon, modifiedon, createdby, modifiedby, link, 
		title, headline, description, keywords, content, block_down_id, block_sidebar_id, status, sort) VALUES
		(1, 0, 0, 0, now(), now(), '', '', 'about', 'About', 'About', '', '', '', '0', '0', 1, 10),
		(2, 0, 0, 0, now(), now(), '', '', 'products', 'Products', 'Products', '', '', '', '0', '0', 1, 20),
		(3, 0, 0, 0, now(), now(), '', '', 'price', 'Price', 'Price', '', '', '', '0', '0', 1, 30),
		(4, 0, 0, 0, now(), now(), '', '', 'order', 'Order', 'Order', '', '', '', '0', '0', 1, 40),
		(5, 0, 0, 0, now(), now(), '', '', 'contacts', 'Contacts', 'Contacts', '', '', '', '0', '0', 1, 40),
		(6, 2, 0, 0, now(), now(), '', '', 'amsterdam', 'Trip to Amsterdam', 'Trip to Amsterdam', '', '', '', '0', '0', 1, 40),
		(7, 2, 0, 0, now(), now(), '', '', 'paris', 'Trip to Paris', 'Trip to Paris', '', '', '', '0', '0', 1, 40),
		(8, 2, 0, 0, now(), now(), '', '', 'london', 'Trip to London', 'Trip to London', '', '', '', '0', '0', 1, 40);
		";
		$result2_ = mysqli_query($conn, $sql2_);


		$sql3= "
		CREATE TABLE IF NOT EXISTS cms_firstpage (
		  id int(1) unsigned NOT NULL,
		  createdon datetime NOT NULL,
		  modifiedon timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  createdby varchar(100) NOT NULL,
		  modifiedby varchar(100) NOT NULL,
		  title varchar(255) NOT NULL,
		  slogan varchar(255) NOT NULL,
		  description varchar(255) NOT NULL,
		  keywords varchar(255) NOT NULL,
		  main_h1 varchar(100) NOT NULL,
		  main_content text NOT NULL,
		  main_status int(1) NOT NULL,
		  products_status int(1) NOT NULL,
		  free_section_headline varchar(100) NOT NULL,
		  free_section_content text NOT NULL,
		  free_section_status int(1) NOT NULL,
		  map text NOT NULL,
		  map_status int(1) NOT NULL,
		  status int(1) NOT NULL,
		  PRIMARY KEY (id)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		";
		$result3 = mysqli_query($conn, $sql3);

		$sql3_ = "
		INSERT INTO cms_firstpage (id, createdon, modifiedon, createdby, modifiedby, title, slogan, description, keywords, main_h1, main_content,  main_status, products_status, free_section_headline, free_section_content, free_section_status, map, map_status, status) VALUES
		(1, 
		now(), 
		now(),
		'',
		'', 
		'Title', 
		'A new website on TeslaCMS', 
		'Description', 
		'Keywords', 
		'Mainpage headline', 
		'<p>
		Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

	<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

	<p><a class=\"btn btn-primary\" href=/cpanel/>Go to control panel</a></p>
	',  
		1, 
		1,
		'Price',
		'
		<table class=table>
		<thead class=thead-light>
			<tr>
				<th scope=col>&nbsp;</th>
				<th scope=col>3 days</th>
				<th scope=col>7 days</th>
				<th scope=col>14 days</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<th scope=row>Paris</th>
				<td>$ 800</td>
				<td>$1 700</td>
				<td>$2 600</td>
			</tr>
			<tr>
				<th scope=row>London</th>
				<td>$ 900</td>
				<td>$1 850</td>
				<td>$2 900</td>
			</tr>
			<tr>
				<th scope=row>Berlin</th>
				<td>$ 800</td>
				<td>$1 700</td>
				<td>$2 600</td>
			</tr>
			<tr>
				<th scope=row>Rome</th>
				<td>$ 900</td>
				<td>$1 850</td>
				<td>$2 900</td>
			</tr>
			<tr>
				<th scope=row>Prague</th>
				<td>$ 800</td>
				<td>$1 700</td>
				<td>$2 600</td>
			</tr>
			<tr>
				<th scope=row>Vienna</th>
				<td>$ 900</td>
				<td>$1 850</td>
				<td>$2 900</td>
			</tr>
		</tbody>
	</table>

	<p><a class=\"btn btn-primary\" href=/price/>Show all offers</a></p>
	',
		1, 
		'<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2002.0425468939713!2d30.271931316094626!3d59.88164298185548!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46963a80516cbdad%3A0x1cadead6f95126b7!2z0YPQuy4g0JLQvtC30YDQvtC20LTQtdC90LjRjywgMjDQkCwg0KHQsNC90LrRgi3Qn9C10YLQtdGA0LHRg9GA0LMsIDE5ODE4OA!5e0!3m2!1sru!2sru!4v1531643915155\" width=100% height=400 frameborder=0 style=border:0 allowfullscreen></iframe>',
		1, 
		0);
		";
		$result3_ = mysqli_query($conn, $sql3_);


		$sql4 = "
		CREATE TABLE IF NOT EXISTS cms_themes (
		  id int(2) unsigned NOT NULL auto_increment,
		  createdon datetime NOT NULL,
		  modifiedon timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  createdby varchar(100) NOT NULL,
		  modifiedby varchar(100) NOT NULL,
		  dir varchar(255) NOT NULL,
		  name varchar(255) NOT NULL,
		  status int(1) NOT NULL,
		  PRIMARY KEY  (id)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
		";
		$result4 = mysqli_query($conn, $sql4);
		
		$sql4_ = "
		INSERT INTO cms_themes (id, createdon, modifiedon, createdby, modifiedby, dir, name, status) VALUES
		(1, now(), now(), '', '', 'standard', 'Standard theme', 1);
		";
		$result4_ = mysqli_query($conn, $sql4_);


		$sql5 = "
		CREATE TABLE IF NOT EXISTS cms_blocks (
		  id int(2) unsigned NOT NULL AUTO_INCREMENT,
		  createdon datetime NOT NULL,
		  modifiedon timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  createdby varchar(100) NOT NULL,
		  modifiedby varchar(100) NOT NULL,
		  name varchar(255) NOT NULL,
		  content text NOT NULL,
		  PRIMARY KEY (id)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;
		";
		$result5 = mysqli_query($conn, $sql5);
		
		$sql5_ = "
		INSERT INTO cms_blocks (id, createdon, modifiedon, createdby, modifiedby, name, content) VALUES
		(1, now(), now(), '', '', 'Bottom block', ''),
		(2, now(), now(), '', '', 'Right block', '');
		";
		$result5_ = mysqli_query($conn, $sql5_);


		$sql6 = "
		CREATE TABLE IF NOT EXISTS cms_menu (
		  id int(2) unsigned NOT NULL AUTO_INCREMENT,
		  createdon datetime NOT NULL,
		  modifiedon timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  createdby varchar(100) NOT NULL,
		  modifiedby varchar(100) NOT NULL,
		  name varchar(255) NOT NULL,
		  bgcolor varchar(7) NOT NULL,
		  line_color varchar(7) NOT NULL,
		  bg_button varchar(7) NOT NULL,
		  search int(1) NOT NULL,
		  status int(1) NOT NULL,
		  PRIMARY KEY (id)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
		";
		$result6 = mysqli_query($conn, $sql6);

		$sql6_ = "
		INSERT INTO cms_menu (id, createdon, modifiedon, createdby, modifiedby, name, bgcolor, line_color, bg_button, search, status) VALUES
		(1, now(), now(), '', '', 'Main navigation', '#b21f2d', '#117a8b', '#b21f2d', 0, 1);
		";
		$result6_ = mysqli_query($conn, $sql6_);


		$sql7 = "
		CREATE TABLE IF NOT EXISTS cms_logs (
		  id int(11) unsigned NOT NULL AUTO_INCREMENT,
		  created_on datetime NOT NULL,
		  datetime datetime NOT NULL,
		  username varchar(255) NOT NULL,
		  action text NOT NULL,
		  ip varchar(20) NOT NULL,
		  system varchar(255) NOT NULL,
		  PRIMARY KEY (id)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
		";
		$result7 = mysqli_query($conn, $sql7);

		$sql8 = "
		CREATE TABLE IF NOT EXISTS cms_products (
		  id int(2) unsigned NOT NULL AUTO_INCREMENT,
		  createdon datetime NOT NULL,
		  modifiedon timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  createdby varchar(100) NOT NULL,
		  modifiedby varchar(100) NOT NULL,
		  product_title varchar(255) NOT NULL,
		  product_text varchar(255) NOT NULL,
		  product_img varchar(255) NOT NULL,
		  page_id int(3) NOT NULL,
		  status int(1) NOT NULL,
		  sort int(3) NOT NULL,
		  PRIMARY KEY (id)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;
		";
		$result8 = mysqli_query($conn, $sql8);

		$sql8_ = "
		INSERT INTO cms_products (id, createdon, modifiedon, createdby, modifiedby, product_title, product_text, product_img, page_id, status, sort) VALUES
		(1, now(), now(), '', '', 'Trip to Amsterdam', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '/content/userfiles/images/ywk6crfn.png', 0, 1, 0),
		(2, now(), now(), '', '', 'Trip to Paris', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '/content/userfiles/images/k45a5cr1.png', 0, 1, 0),
		(3, now(), now(), '', '', 'Trip to London', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', '/content/userfiles/images/5lsvg8nd.png', 0, 1, 0);
		";
		$result8_ = mysqli_query($conn, $sql8_);


		$sql9= "
		CREATE TABLE IF NOT EXISTS cms_header_footer (
		  id int(1) unsigned NOT NULL,
		  createdon datetime NOT NULL,
		  modifiedon timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  createdby varchar(100) NOT NULL,
		  modifiedby varchar(100) NOT NULL,
		  header_bg varchar(7) NOT NULL,
		  header_logo varchar(255) NOT NULL,
		  header_center_section varchar(255) NOT NULL,
		  header_phone varchar(20) NOT NULL,
		  footer_bg varchar(7) NOT NULL,
		  footer_phone varchar(20) NOT NULL,
		  footer_email varchar(150) NOT NULL,
		  footer_address varchar(255) NOT NULL,
		  footer_text text(1000) NOT NULL,
		  footer_copyright varchar(255) NOT NULL,
		  footer_navigation int(1) NOT NULL,
		  footer_logo varchar(255) NOT NULL,
		  vkontakte varchar(255) NOT NULL,
		  facebook varchar(255) NOT NULL,
		  twitter varchar(255) NOT NULL,
		  google varchar(255) NOT NULL,
		  PRIMARY KEY (id)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		";
		$result9 = mysqli_query($conn, $sql9);

		$sql9_ = "
		INSERT INTO cms_header_footer (id, createdon, modifiedon, createdby, modifiedby, header_bg, header_logo, header_center_section, header_phone, footer_bg, footer_phone, footer_email, footer_address, footer_text, footer_copyright, footer_navigation, footer_logo, vkontakte, facebook, twitter, google) VALUES
		(1, 
		now(), 
		now(),
		'',
		'', 
		'#eef0f5', 
		'/content/userfiles/images/header_logo.png', 
		'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.', 
		'(812) 123-45-67', 
		'#21292d', 
		'(812) 123-45-67',
		'info@exmple.com',
		'190000, Saint Petersburg, Vozrogdenia 20A', 
		'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
		'Copyright', 
		'1', 
		'/content/userfiles/images/footer_logo.png', 
		'https://', 
		'https://', 
		'https://',  
		'https://');
		";
		$result9_ = mysqli_query($conn, $sql9_);


		$sql10= "
		CREATE TABLE IF NOT EXISTS cms_white_ip_list (
		  id int(1) unsigned NOT NULL,
		  createdon datetime NOT NULL,
		  modifiedon timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  createdby varchar(100) NOT NULL,
		  modifiedby varchar(100) NOT NULL,
		  ip text NOT NULL,
		  PRIMARY KEY (id)
		) ENGINE=MyISAM DEFAULT CHARSET=utf8;
		";
		$result10 = mysqli_query($conn, $sql10);

		$sql10_ = "
		INSERT INTO cms_white_ip_list (id, createdon, modifiedon, createdby, modifiedby, ip) VALUES
		(1, 
		now(), 
		now(),
		'',
		'', 
		'');
		";
		$result10_ = mysqli_query($conn, $sql10_);


		$sql11 = "
		CREATE TABLE IF NOT EXISTS cms_modules (
		  id int(3) unsigned NOT NULL auto_increment,
		  createdon datetime NOT NULL,
		  modifiedon timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
		  createdby varchar(50) NOT NULL,
		  modifiedby varchar(50) NOT NULL,
		  dir varchar(50) NOT NULL,
		  name varchar(50) NOT NULL,
		  icon varchar(50) NOT NULL,
		  status int(1) NOT NULL,
		  status_mainpage int(3) NOT NULL,
		  PRIMARY KEY (id)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
		";
		$result11 = mysqli_query($conn, $sql11);



		$sql12 = "
		CREATE TABLE IF NOT EXISTS cms_products_settings (
		  id int(2) unsigned NOT NULL AUTO_INCREMENT,
		  createdon datetime NOT NULL,
		  modifiedon timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
		  createdby varchar(100) NOT NULL,
		  modifiedby varchar(100) NOT NULL,
		  bgcolor varchar(7) NOT NULL,
		  headline varchar(50) NOT NULL,
		  count int(2) NOT NULL,
		  PRIMARY KEY (id)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
		";
		$result12 = mysqli_query($conn, $sql12);


		$sql12_ = "
		INSERT INTO cms_products_settings (id, createdon, modifiedon, createdby, modifiedby, bgcolor, headline, count) VALUES
		(1, now(), now(), '', '', '#eef0f5', 'Мы предлагаем', 0);
		";
		$result12_ = mysqli_query($conn, $sql12_);

		$sql13 = "
		CREATE TABLE IF NOT EXISTS cms_options (
		  id int(1) unsigned NOT NULL AUTO_INCREMENT,
		  option_name varchar(100) NOT NULL,
		  option_value varchar(100) NOT NULL,
		  PRIMARY KEY (id)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
		";
		$result13 = mysqli_query($conn, $sql13);


		$sql13_ = "
		INSERT INTO cms_options (id, option_name, option_value) VALUES
		(1, 'cms_version', '1.0'),
		(2, 'cms_lang', 'en');
		";
		$result13_ = mysqli_query($conn, $sql13_);

		$sql14 = "
		CREATE TABLE IF NOT EXISTS cms_languages (
		  id int(2) unsigned NOT NULL auto_increment,
		  code varchar(2) NOT NULL,
		  name varchar(50) NOT NULL,
		  PRIMARY KEY (id)
		) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;
		";
		$result14 = mysqli_query($conn, $sql14);

		$sql14_ = "
		INSERT INTO cms_languages (id, code, name) VALUES
		(1, 'en', 'English'),
		(2, 'ru', 'Русский');
		";
		$result14_ = mysqli_query($conn, $sql14_);
	}


	if (!$result1 || !$result1_ || !$result2 || !$result2_ || !$result3 || !$result3_ || !$result4 || !$result4_ || !$result5 || !$result5_ || !$result6 || !$result6_ || !$result7 || !$result8 || !$result8_ || !$result9 || !$result9_ || !$result10 || !$result10_ || !$result11 || !$result12 || !$result12_ || !$result13 || !$result13_ || !$result14 || !$result14_)
	 return false;
	return true;
}