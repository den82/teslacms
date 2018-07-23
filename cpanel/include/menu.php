<?php
// Display main TeslaCMS navigation (left sidebar)
function display_cms_menu($conn, $user, $modules, $lang, $lang_code) {
	echo "
	<div style='padding:15px 0;' align='center'>
		<img src='/cpanel/img/teslacms-logo.png'>
	</div>
	<div style='background:#979ea3; color:#fff; padding:10px 10px 10px 30px; margin: 0 -15px;'>".$lang['main block']."</div>
	<ul class='nav flex-column' style='margin:10px 0;'>
	  <li class='nav-item'>
	    <a class='nav-link active' href='mainpage.php'>".$lang['mainpage']."</a>
	  </li>
	  <li class='nav-item'>
	    <a class='nav-link' href='innerpage.php?mode=getin&pid=0'>".$lang['structure']."</a>
	  </li>
	  <li class='nav-item'>
	    <a class='nav-link' href='header_footer.php'>".$lang['header and footer']."</a>
	  </li>
	  <li class='nav-item'>
	    <a class='nav-link' href='navigation.php'>".$lang['navigation']."</a>
	  </li>
	  <li class='nav-item'>
	    <a target='_blank' class='nav-link' href='/cpanel/ckeditor/kcfinder/browse.php?opener=ckeditor&type=images&CKEditor=main_content&CKEditorFuncNum=1&langCode=".$lang_code."'>".$lang['file manager']."</a>
	  </li>
	  <li class='nav-item'>
	    <a class='nav-link' href='themes.php'>".$lang['themes']."</a>
	  </li>
	  <li class='nav-item'>
	    <a class='nav-link' href='modules.php'>".$lang['modules']."</a>
	  </li>
	  <li class='nav-item'>
	    <a class='nav-link' href='accounts.php'>".$lang['accounts']."</a>
	  </li>
	  <li class='nav-item'>
	    <a class='nav-link' href='security.php'>".$lang['security']."</a>
	  </li>
	</ul>
	<div style='background:#979ea3; color:#fff; padding:10px 10px 10px 30px; margin: 0 -15px;'>".$lang['active modules']."</div>
	<ul class='nav flex-column' style='margin:10px 0;'>
	  <li class='nav-item' style='padding: .5rem 1rem;'>";
	  if ($modules) {
	  	foreach($modules as $row) {
	    	echo "<a href='/cpanel/module.php?module=".$row['dir']."&mode=settings'>".$row['name']."</a><br>";
		}
	  }
	  else {
	  	echo $lang['no active modules'];
	  }
	  echo "
	  </li>
	</ul>
	<div style='background:#979ea3; color:#fff; padding:10px 10px 10px 30px; margin: 0 -15px;'>".$lang['earn with']." TeslaCMS</div>
	<ul class='nav flex-column' style='margin:10px 0;'>
	  <li class='nav-item'>
	    <a class='nav-link active' href='partnership.php'>".$lang['partnership']."</a>
	  </li>
	</ul>
	<div style='background:#979ea3; color:#fff; padding:10px 10px 10px 30px; margin: 0 -15px;'>".$lang['help and support']."</div>
	<ul class='nav flex-column' style='margin:10px 0;'>
	  <!--
	  <li class='nav-item'>
	    <a class='nav-link active' href='documentation.php'>".$lang['documentation']."</a>
	  </li>
	  -->
	  <li class='nav-item'>
	    <a class='nav-link active' target='_blank' href='https://teslacms.ru/support/ask/'>".$lang['ask a question']."</a>
	  </li>
	  <li class='nav-item'>
	    <a class='nav-link active' target='_blank' href='https://teslacms.ru/support/custom_development/'>".$lang['custom development']."</a>
	  </li>
	</ul>
	<div style='background:#979ea3; color:#fff; padding:10px 10px 10px 30px; margin: 0 -15px;'>".$lang['donation']."</div>
	<ul class='nav flex-column' style='margin:10px 0;'>
	  <li class='nav-item'>
	    <a class='nav-link active' target='_blank' href='https://www.patreon.com/teslacms'>".$lang['patreon']."</a>
	  </li>
	</ul>
	";
}

// Display breadcrumbs navigation
function display_breadcrumbs($conn, $url, $module_name, $lang) {
	
	$array = explode('/', $url);

	if (substr_count($array['2'], 'mainpage.php') > 0) {
		if (substr_count($array['2'], 'mode=edit&type=meta') > 0) {
			echo "<a href='/cpanel/'>".$lang['cp']."</a> / <a href='/cpanel/mainpage.php'>".$lang['mainpage']."</a> / ".$lang['edit meta section']."";
		}
		else if (substr_count($array['2'], 'mode=edit&type=main') > 0) {
			echo "<a href='/cpanel/'>".$lang['cp']."</a> / <a href='/cpanel/mainpage.php'>".$lang['mainpage']."</a> / ".$lang['edit main section']."";
		}
		else if (substr_count($array['2'], 'mode=edit&type=free_section') > 0) {
			echo "<a href='/cpanel/'>".$lang['cp']."</a> / <a href='/cpanel/mainpage.php'>".$lang['mainpage']."</a> / ".$lang['edit free section']."";
		}
		else if (substr_count($array['2'], 'mode=edit&type=map') > 0) {
			echo "<a href='/cpanel/'>".$lang['cp']."</a> / <a href='/cpanel/mainpage.php'>".$lang['mainpage']."</a> / ".$lang['edit map section']."";
		}
		else if ((substr_count($array['2'], 'mode=edit&type=products') > 0) && (strlen($array['2']) < 37)) {
			echo "<a href='/cpanel/'>".$lang['cp']."</a> / <a href='/cpanel/mainpage.php'>".$lang['mainpage']."</a> / ".$lang['products services']."";
		}
		else if (substr_count($array['2'], 'mode=edit&type=products&subtype=edit') > 0) {
			echo "<a href='/cpanel/'>".$lang['cp']."</a> / <a href='/cpanel/mainpage.php'>".$lang['mainpage']."</a> / <a href='/cpanel/mainpage.php?mode=edit&type=products'>".$lang['products services']."</a> / ".$lang['edit products services section']."";
		}
		else if (substr_count($array['2'], 'mode=edit&type=products&subtype=add') > 0) {
			echo "<a href='/cpanel/'>".$lang['cp']."</a> / <a href='/cpanel/mainpage.php'>".$lang['mainpage']."</a> / <a href='/cpanel/mainpage.php?mode=edit&type=products'>".$lang['products services']."</a> / ".$lang['add new item']."";
		}
		else if (substr_count($array['2'], 'mode=edit&type=products&subtype=settings') > 0) {
			echo "<a href='/cpanel/'>".$lang['cp']."</a> / <a href='/cpanel/mainpage.php'>".$lang['mainpage']."</a> / <a href='/cpanel/mainpage.php?mode=edit&type=products'>".$lang['products services']."</a> / ".$lang['settings']."";
		}
		else {
			echo "<a href='/cpanel/'>".$lang['cp']."</a> / ".$lang['mainpage']."";
		}
	}
	else if (substr_count($array['2'], 'innerpage.php') > 0) {
		if (substr_count($array['2'], 'mode=edit') > 0) {
			echo "<a href='/cpanel/'>".$lang['cp']."</a> / <a href='/cpanel/innerpage.php?mode=getin&pid=0'>".$lang['structure']."</a> / ".$lang['edit page']."";
		}
		else if (substr_count($array['2'], 'mode=add') > 0) {
			echo "<a href='/cpanel/'>".$lang['cp']."</a> / <a href='/cpanel/innerpage.php?mode=getin&pid=0'>".$lang['structure']."</a> / ".$lang['new page']."";
		}		
		else {
			echo "<a href='/cpanel/'>".$lang['cp']."</a> / ".$lang['structure']."";
		}
	}
	else if (substr_count($array['2'], 'header_footer.php') > 0) {
		if (substr_count($array['2'], 'mode=edit&submode=header') > 0) {
			echo "<a href='/cpanel/'>".$lang['cp']."</a> / <a href='/cpanel/header_footer.php'>".$lang['header and footer']."</a> / ".$lang['edit header']."";
		}
		else if (substr_count($array['2'], 'mode=edit&submode=footer') > 0) {
			echo "<a href='/cpanel/'>".$lang['cp']."</a> / <a href='/cpanel/header_footer.php'>".$lang['header and footer']."</a> / ".$lang['edit footer']."";
		}		
		else {
			echo "<a href='/cpanel/'>".$lang['cp']."</a> / ".$lang['header and footer']."";
		}
	}
	else if (substr_count($array['2'], 'themes.php') > 0) {
		echo "<a href='/cpanel/'>".$lang['cp']."</a> / ".$lang['themes']."";
	}
	else if (substr_count($array['2'], 'modules.php') > 0) {
		echo "<a href='/cpanel/'>".$lang['cp']."</a> / ".$lang['modules']."";
	}
	else if (substr_count($array['2'], 'partnership.php') > 0) {
		echo "<a href='/cpanel/'>".$lang['cp']."</a> / ".$lang['partnership']."";
	}
	else if (substr_count($array['2'], 'navigation.php') > 0) {
		echo "<a href='/cpanel/'>".$lang['cp']."</a> / ".$lang['navigation']."";
	}
	else if (substr_count($array['2'], 'module.php') > 0) {
		echo "<a href='/cpanel/'>".$lang['cp']."</a> / <a href='/cpanel/modules.php'>".$lang['modules']."</a> / ".$module_name."";
	}
	else if (substr_count($array['2'], 'security.php') > 0) {
		if (substr_count($array['2'], 'mode=edit&type=white_ip_list') > 0) {
			echo "<a href='/cpanel/'>".$lang['cp']."</a> / <a href='/cpanel/security.php'>".$lang['security']."</a> / ".$lang['white ip list']."";
		}
		else if (substr_count($array['2'], 'mode=show&type=logs') > 0) {
			echo "<a href='/cpanel/'>".$lang['cp']."</a> / <a href='/cpanel/security.php'>".$lang['security']."</a> / ".$lang['logs']."";
		}
		else {
			echo "<a href='/cpanel/'>".$lang['cp']."</a> / ".$lang['security']."";
		}
	}
	else if (substr_count($array['2'], 'accounts.php') > 0) {
		if (substr_count($array['2'], 'mode=edit') > 0) {
			echo "<a href='/cpanel/'>".$lang['cp']."</a> / <a href='/cpanel/accounts.php'>".$lang['accounts']."</a> / ".$lang['account update']."";
		}
		else if (substr_count($array['2'], 'mode=create') > 0) {
			echo "<a href='/cpanel/'>".$lang['cp']."</a> / <a href='/cpanel/accounts.php'>".$lang['accounts']."</a> / ".$lang['сreate new account']."";
		}
		else if (substr_count($array['2'], 'mode=password') > 0) {
			echo "<a href='/cpanel/'>".$lang['cp']."</a> / <a href='/cpanel/accounts.php'>".$lang['accounts']."</a> / ".$lang['сhange password']."";
		}
		else {
			echo "<a href='/cpanel/'>".$lang['cp']."</a> / ".$lang['accounts']."";
		}
	}
	else {
		echo 0;
	}
}