<?php

 if(isset($_SESSION['Center_Username'])){ ?>
	<li><a href="member.php">會員中心</a></li>
	<li><a href="chat.php">聊天室</a></li>
    <li><a href="mtqc.php">MTQC</a></li>
    <li><a href="gold.php">黃金走勢</a></li>
	<li class="dropdown">
		<a href="forum.php" data-target="#" data-toggle="dropdown">表單&交接 ▼</a>
		<ul class="dropdown-menu">
			<li><a href="forum.php">表單</a></li>
			<li><a href="forum.php?newpost">發表表單</a></li>
			<li><a href="mypost.php">我的表單</a></li>
		</ul>
	</li>
	<?php if($_SESSION['Center_UserGroup']==9){?>
		<li><a href="admin/index.php">系統管理</a></li>
	<?php } ?>
	<li><a href="index.php?logout">登出</a></li>
<?php }else{ ?>
	<li><a href="index.php">登入</a></li>
	<li><a href="register.php">註冊</a></li>
<?php } ?>