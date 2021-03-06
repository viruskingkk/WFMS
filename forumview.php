<?php


require_once('Connections/SQL.php');
require_once('config.php');
require_once('include/view.php');

if(!isset($_SESSION['Center_Username'])){
    header("Location: index.php?login");
    exit;
}

if((!isset($_GET['id']))or($_GET['id']=='')){
    header("Location: forum.php");
	exit;
}

$_post = sc_get_result("SELECT * FROM `forum` WHERE `id` = '%d'",array($_GET['id']));

if($_post['num_rows']<=0){
	header("Location: forum.php");
	exit;
}

if(isset($_GET['reply'])){
	if($_SESSION['Center_UserGroup']==0){
		header("Location: forumview.php?banned&id=".$_GET['id']);
		exit;
	}
}
if((isset($_GET['reply']))&& isset($_POST['content']) && trim($_POST['content'],"&nbsp;") != ''){
	$SQL->query("INSERT INTO `forum_reply` ( `post_id`,`content`, `mktime`, `author`) VALUES ('%s','%s',now(),'%d')",array(
		$_post['row']['id'],
		sc_xss_filter($_POST['content']),
		$_SESSION['Center_Id']
	));
	
	if($_SESSION['Center_Id']!=$_post['row']['author']){
		 sc_add_notice(
			sc_get_headurl().'forumview.php?id='.$_post['row']['id'],
			$_SESSION['Center_Username'].'在您的文章中發表回覆',
			$_SESSION['Center_Id'],
			$_post['row']['author']
		);
	}
	sc_tag_member(
		sc_xss_filter($_POST['content']),
		sc_get_headurl().'forumview.php?id='.$_post['row']['id'],
		$_SESSION['Center_Username'].'在論壇提到你',
		$_SESSION['Center_Id']
	);
	header("Location: forumview.php?replying&id=".$_GET['id']);
}


$_block = sc_get_result("SELECT * FROM `forum_block` WHERE `id`='%d'",array($_post['row']['block']));

$limit_row=$center['forum']['limit'];
	
if(isset($_GET['page'])){
	$limit_start = abs(intval(($_GET['page']-1)*$limit_row));
	$_reply = sc_get_result("SELECT * FROM `forum_reply` WHERE `post_id`='%d' ORDER BY `mktime` ASC LIMIT %d,%d",array($_post['row']['id'],$limit_start,$limit_row));
} else {
	$limit_start=0;
	$_reply = sc_get_result("SELECT * FROM `forum_reply` WHERE `post_id`='%d' ORDER BY `mktime` ASC LIMIT %d,%d",array($_post['row']['id'],$limit_start,$limit_row));
}
$_author = sc_get_result("SELECT `username` FROM `member` WHERE `id` = '%d'",array($_post['row']['author']));
$view = new View('include/theme/default.html','include/nav.php',NULL,$center['site_name'],$_post['row']['title']);
$view->addScript("include/js/notice.js");
?>
<?php if(isset($_GET['replying'])){?>
	<div class="alert alert-success">回覆成功！</div>
<?php }elseif(isset($_GET['editok'])){ ?>
	<div class="alert alert-success">編輯成功！</div>
<?php }elseif(isset($_GET['banned'])){ ?>
	<div class="alert alert-danger">您被禁言無法發文！</div>
<?php }
if(isset($_GET['reply'])){
$view->addCSS("include/js/summernote/summernote.css");
$view->addScript("include/js/summernote/summernote.min.js");
$view->addScript("include/js/summernote/lang/summernote-zh-TW.min.js");
?>
<script>
$(function(){
	$("#summernote").summernote({width:'99%', height:300, focus: true, lang: 'zh-TW'});
});
</script>
<form action="forumview.php?id=<?php echo $_GET['id']; ?>&reply" method="POST" name="form1">
	<div class="form-group">
		<label for="content">回覆內容：</label>
		<textarea id="summernote" class="form-control" name="content" cols="65" rows="10" required="required"></textarea>
	</div>
	<p><input type="submit" name="button" class="btn btn-primary" value="回覆"></p>
</form>
<?php } else { ?>
<ul class="breadcrumb">
	<li><a href="forum.php">論壇</a></li>
	<li><a href="forum.php?fid=<?php echo $_block['row']['id']; ?>"><?php echo $_block['row']['blockname']; ?></a></li>
	<li class="active"><?php echo sc_removal_escape_string($_post['row']['title']); ?></li>
</ul>
<ul class="list-inline">
	<li>
		<h2><?php echo $_post['row']['title']; ?></h2>
	</li>
	<?php if($_post['row']['level']>1){ ?>
	<li>
		<span class="label label-default"><?php echo sc_member_level($_post['row']['level']); ?></span>
	</li>
	<?php } ?>
	<li>
		<a href="forumview.php?id=<?php echo $_post['row']['id']; ?>&reply" class="btn btn-primary btn-xs">發表新回覆</a>
	</li>
</ul>
<div id="1" class="post">
	<ul class="list-inline">
		<li>
			<img src="<?php echo sc_avatar_url($_post['row']['author']); ?>" class="avatar">
		</li>
		<li style="font-size:120%;"><?php echo $_author['row']['username']; ?></li>
		<li>發表於&nbsp;<?php echo $_post['row']['mktime']; ?></li>
		<li>1&nbsp;樓</li>
		<?php if($_post['row']['author'] == $_SESSION['Center_Id']){ ?>
		<li>
			<a href="forumedit.php?post&id=<?php echo $_post['row']['id']; ?>" class="btn btn-info btn-sm">
				編輯
			</a>
			<a href="javascript:if(confirm('確定刪除？'))location='mypost.php?del=<?php echo $_post['row']['id']; ?>'" class="btn btn-danger btn-sm">
				刪除
			</a>	
		</li>
		<?php } ?>
	</ul>
    <div class="con"><?php echo sc_removal_escape_string($_post['row']['content']); ?></div>
</div>
<?php
if($_reply['num_rows']>0){
	$_floor = 1+$limit_start;
	do{
		$_floor++;
		$_reply_author = sc_get_result("SELECT `username` FROM `member` WHERE `id` = '%d'",array($_reply['row']['author']));
?>
<div id="<?php echo $_floor; ?>" class="post">
	<ul class="list-inline">
		<li>
			<img src="<?php echo sc_avatar_url($_reply['row']['author']); ?>" class="avatar">
		</li>
		<li style="font-size:110%;"><?php echo $_reply_author['row']['username']; ?></li>
		<li>回覆於&nbsp;<?php echo $_reply['row']['mktime']; ?></li>
		<li><?php echo $_floor; ?>&nbsp;樓</li>
		<?php if($_reply['row']['author']==$_SESSION['Center_Id']){ ?>
		<li>
			<a href="forumedit.php?reply&id=<?php echo $_reply['row']['id']; ?>" class="btn btn-info btn-sm">
				編輯
			</a>
		</li>
		<?php } ?>
	</ul>
	<div class="con"><?php echo sc_removal_escape_string($_reply['row']['content']); ?></div>
</div>
<?php
	}while($_reply['row'] = $_reply['query']->fetch_assoc());
}
$_all_reply=sc_get_result("SELECT COUNT(*) FROM `forum_reply` WHERE `post_id`='%d'",array($_post['row']['id']));
echo sc_page_pagination('forumview.php',@$_GET['page'],implode('',$_all_reply['row']),$center['forum']['limit'],'&id='.$_post['row']['id']);
?>
<?php } ?>
<?php
$view->render();
?>