<?php


require_once('Connections/SQL.php');
require_once('config.php');
require_once('include/view.php');

if(!isset($_SESSION['Center_Username'])){
	header("Location: index.php?login");
	exit;
}

$_mtqc = sc_get_result("SELECT * FROM `mtqc` WHERE `mtqc_id` = '%d'",array($_SESSION['Center_Id']));


$view = new View('include/theme/default.html','include/nav.php',NULL,$center['site_name'],'MTQC');
$view->addScript("include/js/notice.js");
?>

<h2 class="page-header">MTQC</h2>

	<div class="col-sm-9">
		<table class="table table-striped table-hover">
		<thead>
			<tr>
				<th width="63">ID</th>
                <th width="63">電腦</th>
				<th width="82">電腦IP</th>
				<th width="83">主服務器IP</th>
				<th width="83">備服務器IP</th>
                <th width="28">Port</th>
                <th width="34">狀態</th>
                <th width="102">最後更新時間</th>
			</tr>
		</thead>
<?php do { ?>
            
			<tr>
			<td>
			<?php echo $_mtqc['row']['mtqc_id']; ?>
			</td>
            <td>
			<?php echo $_mtqc['row']['pc']; ?>
			</td>
			<td>
			<?php echo $_mtqc['row']['pcip']; ?>
			</td>
            <td>
			<?php echo $_mtqc['row']['serverip']; ?>
			</td>
            <td>
			<?php echo $_mtqc['row']['sserverip']; ?>
			</td>
            <td>
			<?php echo $_mtqc['row']['port']; ?>
			</td>
            <td>
			<?php echo $_mtqc['row']['status']; ?>
			</td>
			<td>
<br><?php echo date('Y-m-d H:i',strtotime($_mtqc['row']['date'])); ?>
			</td>
			</tr>
        <?php } while ($_mtqc['row'] = $_mtqc['query']->fetch_assoc()); ?>		
</table>
	</div>
</div>



<?php
	$view->render();
?>