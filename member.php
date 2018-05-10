<?php


require_once('Connections/SQL.php');
require_once('config.php');
require_once('include/view.php');

if(!isset($_SESSION['Center_Username'])){
	header("Location: index.php?n");
	exit;
}

$view = new View('include/theme/default.html','include/nav.php',NULL,$center['site_name'],'會員中心');
$view->addScript("include/js/notice.js");
?>
<?php if((isset($_COOKIE['login']))&&(isset($_GET['login']))){?>
	<div class="alert alert-success">登入成功！</div>
<?php } ?>
<h2 class="page-header">會員中心</h2>
<div class="row">
	<div class="col-md-4">
		<div class="list-group">
			<a href="account.php" class="list-group-item">我的帳號</a>
			<a href="chat.php" class="list-group-item">聊天室</a>
			<a href="forum.php" class="list-group-item">表單</a>
            <a href="mtqc.php" class="list-group-item">MTQC</a>
		</div>
	</div>
	<div class="col-md-8">
		<?php if($center['member']['message']!=''){ ?>
		<div class="well">
		<?php echo $center['member']['message']; ?>
		</div>
		<?php } ?>
	</div>
</div>
<?php
	$view->render();
?>