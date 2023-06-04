<?php
	session_start();
	ob_start();

	include 'settings/db.php';
	include 'settings/pages.php';

	if(isset($_REQUEST['page'])){
		$RequestedPageNumber = $_REQUEST['page'];
	}else{
		$RequestedPageNumber = "";
	}

	if ($RequestedPageNumber == 0 or $RequestedPageNumber == "" or $RequestedPageNumber > 8 or $RequestedPageNumber < 0){
		include 'pages/homepage.php';
	}else {
		include "$page[$RequestedPageNumber]";
	}

	ob_end_flush();
?>