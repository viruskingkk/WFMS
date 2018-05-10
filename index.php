<?php


require_once('Connections/SQL.php');
require_once('config.php');
require_once('include/view.php');

if(isset($_POST['username'])){
	if(sc_login($_POST['username'],$_POST['password'])==1){
		header("Location: member.php?login");
	}else{
		header("Location: index.php?login");
	}
	die();
}
else if(isset($_GET['logout'])) {
	sc_loginout();
}

if(isset($_SESSION['Center_Username'],$_SESSION['Center_UserGroup'])){
	header('Location: member.php');
}

$view = new View('include/theme/default.html','include/nav.php',NULL,$center['site_name'],'使用者登入');

switch(true){
	case isset($_GET['reg']):
?>
	<div class="alert alert-success">註冊成功！</div>
<?php
	break;
	case isset($_GET['out']):
?>
	<div class="alert alert-success">您已經登出！</div>
<?php
	break;
	case isset($_GET['getpassword']):
?>
	<div class="alert alert-success">密碼重設成功！</div>
<?php
	break;
	case isset($_GET['login']):
?>
	<div class="alert alert-danger">登入失敗</div>
<?php
	break;
}
?>
<h2 class="page-header">使用者登入</h2>
<form id="loginbox" class="form-horizontal form-sm" action="index.php" method="post">
	<div class="form-group">
		<label class="col-sm-3 control-label" for="username">帳號：</label>
		<div class="col-sm-9">
			<input class="form-control" name="username" type="text" required="required">
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label" for="password">密碼：</label>
		<div class="col-sm-9">
			<input class="form-control" name="password" type="password" required="required">
		</div>
	</div>
	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-9">
			<input class="btn btn-primary" type="submit" value="登入">
			<a href="register.php" class="btn btn-info">註冊</a>
			<a href="getpassword.php">忘了您的密碼？</a>
		</div>
	</div>
</form>
<?php
	$view->render();
?>