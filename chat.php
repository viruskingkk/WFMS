<?php


require_once('Connections/SQL.php');
require_once('config.php');
require_once('include/view.php');

if(!isset($_SESSION['Center_Username'])){
	header("Location: index.php?login");
	exit;
}

$view = new View('include/theme/default.html','include/nav.php',NULL,$center['site_name'],'聊天室');
$view->addScript("include/js/chat.js");
$view->addScript("include/js/notice.js");
?>
<script>
$(function(){
	new sc_chat('#chat',<?php echo $center['chat']['public']*1000; ?>);
});
</script>
<h2 class="page-header">聊天室</h2>可用@標注對方
<div id="chat"></div>
<?php
	$view->render();
?>