<?php
// Functions for visitors side

// Get name by id
function get_page_by_id($conn, $id) {
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

// Display breadcrumbs section
function display_bread_crumbs($conn, $URI, $name, $id) {
	$array = explode('/', $URI);
	$last = array_pop($array);
	unset($array[0]);
	$url .= "<a href='/' style='font-size:15px;'><span>Главная</span></a> / ";
	if (($array[1]) && ($array[2]) && (!$array[3])) {
		$header = get_name_by_page($conn, $array[1]);
		$url .= "<a href='../../".$array[1]."/' style='font-size:15px;'><span>".$header."</span></a> / ";
	}
	else if (($array[1]) && ($array[2]) && ($array[3])) {
		$header1 = get_name_by_page($conn, $array[1]);
		$header2 = get_name_by_page($conn, $array[2]);
		$url .= "<a href='../../../".$array[1]."/' style='font-size:15px;'>".$header1."</a>&nbsp;&nbsp;&nbsp; /&nbsp;&nbsp;&nbsp; <a href='../".$array[2]."/' style='font-size:13px;'><span class='active'>".$header2."</span></a> /&nbsp;&nbsp;&nbsp;";
	}
	else {
		echo "";
	}
	$url .= $name;
	echo $url;
}

// Get page name using url
function get_name_by_page($conn, $link) {
	$sql = "SELECT headline FROM cms_pages WHERE link = '".$link."'"; 
	$result = mysqli_query($conn, $sql);
	if (!$result)
	 return false;
	$count_rows = mysqli_num_rows($result);
	if ($count_rows < 1)
	  return false;
	$result = mysqli_fetch_assoc($result);
	return $result['headline'];
}