<?php


set_include_path('../include/');
$includepath = true;

require_once('../Connections/SQL.php');
require_once('../config.php');
require_once('view.php');

if(!isset($_SESSION['Center_Username']) or $_SESSION['Center_UserGroup'] != 9){
    header("Location: ../index.php");
    exit;
}

if(isset($_GET['del'])){
	$SQL->query("TRUNCATE TABLE `chat`");
}

$view = new View('theme/admin_default.html','admin/nav.php','',$center['site_name'],'聊天室',true);
$view->addScript("../include/js/chat.js");
?>
<script>
$(function(){
	new sc_chat('#chat',1);
	$('#chat_del').click(function(e){
		if(!window.confirm("確定清除所有聊天紀錄？")){
			e.preventDefault();
		}
	});
});
</script>
<h2 class="page-header">聊天管理</h2>
<p>
	<a id="chat_del" class="btn btn-danger" href="chat.php?del">清除所有聊天紀錄</a>
</p>
<div id="chat"></div>
<?php
	$view->render();
?>