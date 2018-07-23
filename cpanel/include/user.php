<?php
// Get array of the authorized user to sign in
function get_user($conn, $username) {
   $sql = "SELECT * FROM cms_admin WHERE username = '".$username."'"; 
   $result = mysqli_query($conn, $sql);
   if (!$result)
     return false;
   $num_cats = mysqli_num_rows($result);
   if ($num_cats ==0)
      return false;  
   $result = mysqli_fetch_assoc($result);
   return $result;
}