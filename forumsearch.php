<?php


require_once('Connections/SQL.php');
require_once('config.php');
require_once('include/view.php');

if(!isset($_SESSION['Center_Username'])){
    header("Location: index.php?login");
    exit;
}

if(!isset($_GET['q'])or trim($_GET['q'])==''){
	header("Location: forum.php");
    exit;
}

$limit_row=$center['forum']['limit'];

if(isset($_GET['page'])){
	$limit_start = abs(intval(($_GET['page']-1)*$limit_row));
	$_post = sc_get_result("SELECT * FROM `forum` WHERE `title` LIKE '%%%s%%' OR `content` LIKE '%%%s%%' ORDER BY `mktime` DESC LIMIT %d,%d",array(sc_xss_filter($_GET['q']),sc_xss_filter($_GET['q']),$limit_start,$limit_row));
} else {
	$limit_start=0;
	$_post = sc_get_result("SELECT * FROM `forum` WHERE `title` LIKE '%%%s%%' OR `content` LIKE '%%%s%%' ORDER BY `mktime` DESC LIMIT %d,%d",array(sc_xss_filter($_GET['q']),sc_xss_filter($_GET['q']),$limit_start,$limit_row));
}

$view = new View('include/theme/default.html','include/nav.php',NULL,$center['site_name'],'內容搜尋');
$view->addScript("include/js/notice.js");
?>
<h2>內容搜尋</h2>
<form id="search" method="GET" action="forumsearch.php" style="margin-bottom:1em;">
	<div class="input-group">
		<input id="q" class="form-control" name="q" type="text" class="search-query" required="required" value="<?php echo sc_xss_filter($_GET['q']); ?>">
		<span class="input-group-btn">
			<span class="btn btn-default" onclick="if(document.getElementById('q').value!=''){document.getElementById('search').submit();}"><i class="glyphicon glyphicon-search"></i></span>
		</span>
	</div>
</form>
<?php if($_post['num_rows']<=0){ ?>
<div class="alert alert-danger">沒有符合的資料！</div>
<?php }else{ ?>
<?php do{
	$_reply = sc_get_result("SELECT COUNT(*) FROM `forum_reply` WHERE `post_id`='%d'",array($_post['row']['id']));
	$_author = sc_get_result("SELECT `username` FROM `member` WHERE `id` = '%d'",array($_post['row']['author']));
?>
<div class="post">
	<a href="forumview.php?id=<?php echo $_post['row']['id']; ?>" style="font-size:120%;display:block;">
	<?php echo $_post['row']['title']; ?>
	</a>
	<p>
	<?php echo mb_substr(strip_tags($_post['row']['content']),mb_stripos(strip_tags($_post['row']['content']),sc_xss_filter($_GET['q']),0,'UTF-8')-30,60,'UTF-8'); ?>...
	</p>
	<ul class="list-inline" style="font-size:80%;color:rgb(100,100,100);">
		<li><?php echo $_author['row']['username']; ?></li>
		<li><?php echo date('Y-m-d H:i',strtotime($_post['row']['mktime'])); ?></li>
		<li><?php echo implode('',$_reply['row']); ?> 回覆</li>
		<?php if($_post['row']['level']>1){ ?>
		<li><span class="label label-default"><?php echo sc_member_level($_post['row']['level']); ?></span></li>
		<?php } ?>
	</ul>
</div>
<?php }while ($_post['row'] = $_post['query']->fetch_assoc()); ?>
<?php
$_all=sc_get_result("SELECT COUNT(*) FROM `forum` WHERE `title` LIKE '%%%s%%' OR `content` LIKE '%%%s%%'",array(sc_xss_filter($_GET['q']),sc_xss_filter($_GET['q'])));
echo sc_page_pagination('forumsearch.php',@$_GET['page'],implode('',$_all['row']),$center['forum']['limit'],'&q='.sc_xss_filter($_GET['q']));
}
?>
<?php
$view->render();
?>