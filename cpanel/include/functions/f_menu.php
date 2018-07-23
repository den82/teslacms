<?php
// Display main navigation settings edit form
function display_menu_edit_form($settings, $lang) {
	?>
	<div class="headline"><h1><?php echo $lang['navigation'];?></h1></div>

	<form method='post' action='include/action.php'>
	
	<input type='hidden' name='mode' value='menu'>
	<input type='hidden' name='submode' value='edit'>

	<div class='form-group'>
      <label for='exampleFormControlInput1'><b><?php echo $lang['bg color'];?> <font color='red'>*</font></b></label>
      <br>
      <input type='color' name='bgcolor' id='html5colorpicker' onchange='clickColor(0, -1, -1, 5)' value='<?php echo $settings['bgcolor'];?>' style='width:10%;'>
    </div>

    <div class='form-group'>
      <label for='exampleFormControlInput1'><b><?php echo $lang['line color'];?> <font color='red'>*</font></b></label>
      <br>
      <input type='color' name='line_color' id='html5colorpicker' onchange='clickColor(0, -1, -1, 5)' value='<?php echo $settings['line_color'];?>' style='width:10%;'>
    </div>

    <div class='form-group'>
      <label for='exampleFormControlInput1'><b><?php echo $lang['bg button'];?> <font color='red'>*</font></b></label>
      <br>
      <input type='color' name='bg_button' id='html5colorpicker' onchange='clickColor(0, -1, -1, 5)' value='<?php echo $settings['bg_button'];?>' style='width:10%;'>
    </div>
	<!--
    <div class='form-group'>
      <label for='exampleFormControlInput1'><b>Search block <font color='red'>*</font></b></label>
      <select name='search' class='form-control' style='width:200px;'>-->
        <?php
        /*
        if ($settings['search'] == '1') {
          echo "
          <option value='1'>Show</option>
          <option value='0'>None</option>
          ";
        }
        else {
          echo "
          <option value='1'>Show</option>
          <option value='0' selected>None</option>
          ";
        }

        echo "
      </select>
    </div>
    ";
*/
	echo "<button type='submit' class='btn btn-primary mb-2'>".$lang['save']."</button>";
	echo "</form>";

}

// Edit main navigation
function edit_menu($conn, $array) {
	$sql = "UPDATE cms_menu SET 
	bgcolor = '".$array['bgcolor']."',
	line_color = '".$array['line_color']."',
	bg_button = '".$array['bg_button']."'
	WHERE id = '1'";
	$result = mysqli_query($conn, $sql);
	if (!$result)
	 return false;
	return true;  
}