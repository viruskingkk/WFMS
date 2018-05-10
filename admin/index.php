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

if(isset($_GET['logout'])){
	sc_loginout();
	header("Location: ../index.php?out");
	exit;
}
$view = new View('theme/admin_default.html','admin/nav.php','',$center['site_name'],'系統管理',true);
?>
<h2 class="page-header">系統管理</h2>
<p>歡迎來到系統管理介面！</p>
<div class="row">
	<div class="col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">系統</h3>
			</div>
			<div class="panel-body">
				目前版本：TWIT System <?php echo sc_ver(); ?>&nbsp;&nbsp;<span id="ver_check"></span>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-warning">
			<div class="panel-heading">
				<h3 class="panel-title">會員</h3>
			</div>
			<div class="panel-body">
				目前會員數量：
				<?php echo implode('',$SQL->query("SELECT COUNT(*) FROM `member`")->fetch_assoc()); ?> 人
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-success">
			<div class="panel-heading">
				<h3 class="panel-title">論壇</h3>
			</div>
			<div class="panel-body">
				目前文章總數：
				<?php echo implode('',$SQL->query("SELECT COUNT(*) FROM `forum`")->fetch_assoc()); ?> 篇
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3 class="panel-title">通知</h3>
			</div>
			<div class="panel-body">
				目前通知數量：
				<?php echo implode('',$SQL->query("SELECT COUNT(*) FROM `notice`")->fetch_assoc()); ?> 筆
			</div>
		</div>
	</div>
</div>
<?php
$view->render();
?>