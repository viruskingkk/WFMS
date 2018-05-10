<?php


require_once('Connections/SQL.php');
require_once('config.php');
require_once('include/view.php');

if(!isset($_SESSION['Center_Username'])){
	header("Location: index.php?login");
	exit;
}

$_mtqc = sc_get_result("SELECT * FROM `mtqc` WHERE `mtqc_id` = '%d'",array($_SESSION['Center_Id']));


$view = new View('include/theme/default.html','include/nav.php',NULL,$center['site_name'],'Gold_chart');
$view->addScript("include/js/notice.js");
?>

<h2 class="page-header">即時黃金走勢</h2>

<embed type="image/svg+xml" src="gold_chart.svg"    width= 1000 height=680   />


<?php
	$view->render();
?>