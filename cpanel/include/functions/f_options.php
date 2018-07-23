<?php
// Getting TeslaCMS current version
function get_cms_options($conn) {
   $sql = "SELECT * FROM cms_options"; 
   $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $count_rows = mysqli_num_rows($result);
   if ($count_rows < 1)
      return false;  
   $result = mysqli_fetch_all($result, MYSQLI_ASSOC);
   return $result;
}