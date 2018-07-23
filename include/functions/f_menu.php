<?php
// Functions for visitors side

// Get main navigation settings
function get_navigation_settings($conn) {
	$sql = "SELECT * FROM cms_menu WHERE id = '1'";
	$result = mysqli_query($conn, $sql);
	if (!$result)
	 return false;
	$count_rows = mysqli_num_rows($result);
	if ($count_rows < 1)
	  return false;
	$result = mysqli_fetch_assoc($result);
    return $result;
}

// Get main navigation block (published and first level only)
function get_navigation($conn) {
	$sql = "SELECT * FROM cms_pages WHERE status = '1' and pid = '0' ORDER BY sort ASC";
	$result = mysqli_query($conn, $sql);
	if (!$result)
	 return false;
	$count_rows = mysqli_num_rows($result);
	if ($count_rows < 1)
	  return false;
	$result = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $result;
}

// Display navigation
function display_navigation($conn, $pages, $settings) {
	?>
	<div class="row" style="background-color: <?php echo $settings['bgcolor'];?>;">
    	<div class="col-xl-8 offset-xl-2 col-md-12">
			<nav class="navbar navbar-expand-lg navbar-light" style="background-color: <?php echo $settings['bgcolor'];?>;">
			  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			    <span class="navbar-toggler-icon"></span>
			  </button>

			  <div class="collapse navbar-collapse" id="navbarSupportedContent">
			  	<ul class="navbar-nav mr-auto">
				<?php
				foreach ($pages as $row) {
					//echo $row['id']."<br>";
					//$level = check_level($conn, $row['id']);
					//echo $level;
					$page = get_link_by_id($conn, $row['id']);
					$name = get_headline_by_id($conn, $row['id']);
					// Получаем детей по адресу страницы
					$kids = get_kids($conn, $page);
					//print_r($kids);
					if ($kids) {
						foreach ($kids as $row2) {
							$dropdown = "class='nav-item dropdown'";
							$toggle = "class='nav-link dropdown-toggle' id='navbarDropdown' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'";	
						}
					}
					else {
						//$arrow = "";
						$dropdown = "class='nav-item'";
						$toggle = "class='nav-link'";
					}
					echo "
					<li ".$dropdown.">";
					//if ($level == "1") {
						// Выводим навигацию верхнего уровня
						echo "
						<a ".$toggle." href='/".$page."'>".$name."".$arrow."</a>
						";
						// Там где есть дети выводим список, оставляя только отмеченные элементы
						if ($kids) {
							//print_r($kids);
							echo "
							<div class='dropdown-menu' aria-labelledby='navbarDropdown'>";
							foreach ($kids as $row) {
								echo "<a class='dropdown-item' href='/".$page."/".$row['link']."'>".$row['headline']."</a>";
							}
							echo "</div>";
						}
					//}
					echo "</li>";
				}
				?>
			    </ul>
				<!--
			    <form class="form-inline my-2 my-lg-0">
			      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
			      <button class="btn btn-outline-success my-2 my-sm-0" type="submit" style="color: #ffffff; border-color: #ffffff;">Search</button>
			    </form>
			  	-->
			  </div>
			</nav>
	    </div>
	</div>
	<div class="row" style="background-color: <?php echo $settings['line_color'];?>; height:3px;">
		<div class="col-xl-8 offset-xl-2 col-md-12">
		</div>
	</div>
	<?php
}

// Get navigation first evel
function display_menu_up_level($pages) {
	foreach ($pages as $row) {
		echo "<a href='/".$row['link']."/' style='color:#ffffff; font-size:16px;'>".$row['headline']."</a><br>";
	}
}

// Check level
function check_level($conn, $id) {
	$sql = "SELECT pid FROM cms_pages WHERE id = '".$id."'";
	$result = mysqli_query($conn, $sql);
	if (!$result)
	 return false;
	$count_rows = mysqli_num_rows($result);
	if ($count_rows < 1)
	  return false;
	//$result = db_result_to_array($result);
	//return $result; 
	$result = mysqli_fetch_assoc($result);
	if ($result['pid'] == '0') {
		$level = "1";
	}
	else if (($result['pid'] == '1') || ($result['pid'] == '2') || ($result['pid'] == '3') || ($result['pid'] == '4') || ($result['pid'] == '17') || ($result['pid'] == '71')) {
		$level = "2";
	}
	else {
		$level = "3";
	}
	return $level; 
}


// Get link by page id
function get_link_by_id($conn, $id) {
	$sql = "SELECT link FROM cms_pages WHERE id = '".$id."'";
	$result = mysqli_query($conn, $sql);
	if (!$result)
	 return false;
	$count_rows = mysqli_num_rows($result);
	if ($count_rows < 1)
	  return false;
	$result = mysqli_fetch_assoc($result);
	return $result['link'];
}

// Get headline by page id
function get_headline_by_id($conn, $id) {
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

// Get kids by page name
function get_kids($conn, $page) {
	$sql = "SELECT id FROM cms_pages WHERE link = '".$page."' and status = '1' ORDER BY sort ASC";
	$result1 = mysqli_query($conn, $sql);
	if (!$result1) {
		return false;
	}
	else {
		$data = mysqli_fetch_assoc($result1);
		$sql = "SELECT id, link, headline FROM cms_pages WHERE pid = '".$data['id']."' and status = '1' ORDER BY sort ASC";
		$result = mysqli_query($conn, $sql);
		if (!$result)
		 return false;
		$count_rows = mysqli_num_rows($result);
		if ($count_rows < 1)
		  return false;
		$result = mysqli_fetch_all($result, MYSQLI_ASSOC);
		return $result;
	}
}