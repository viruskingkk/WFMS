<?php


set_include_path('../');
$includepath = true;
require_once('../../Connections/SQL.php');
require_once('../../config.php');

$_SESSION_scratch = $_SESSION;
session_write_close();
if(!isset($_SESSION_scratch['Center_Username'])){
	exit;
}

if(isset($_GET['sent'])){
	if(isset($_POST['content'])&&trim($_POST['content'])!=''){
		$_chat = sc_get_result("SELECT * FROM `chat` ORDER BY `mktime` ASC");
		
		if($_chat['num_rows'] > 300){
			$SQL->query("TRUNCATE TABLE `chat`");
		}
		$SQL->query("INSERT INTO `chat` (`content`, `mktime`, `author`) VALUES ('%s', now(), '%s')",array(htmlspecialchars($_POST['content']),$_SESSION_scratch['Center_Id']));
		
		sc_tag_member(
			htmlspecialchars($_POST['content']),
			rtrim(sc_get_headurl(),'include/ajax').'/chat.php',
			$_SESSION_scratch['Center_Username'].'在聊天室提到你',
			$_SESSION_scratch['Center_Id']
		);
	
		header("Content-type: application/json");
		echo json_encode(array("success" => true));
	}
}elseif(isset($_POST['last'])){
	$_last=intval($_POST['last']);
	$_timeout=20;
	$i=0;
	while($i<$_timeout){
		$_result = sc_get_result("SELECT * FROM `chat` WHERE `mktime` > '%s'",array(date('Y-m-d H:i:s',$_last)));
		
		$_data=array();
		$_data['last']=time();
		if($_result['num_rows'] > 0){
			do{
				$_member = $SQL->query("SELECT `username` FROM `member` WHERE `id` = '%d'",array($_result['row']['author']))->fetch_assoc();
				$t = strtotime($_result['row']['mktime']);
				if(date('d') == date('d', $t)){
					$_data['data'][]=array('id'=>$_result['row']['id'],'content'=>$_result['row']['content'],'mktime'=>date('H:i:s',$t),'author'=>$_member['username']);
				}else{
					$_data['data'][]=array('id'=>$_result['row']['id'],'content'=>$_result['row']['content'],'mktime'=>$_result['row']['mktime'],'author'=>$_member['username']);
				}
			}while($_result['row'] = $_result['query']->fetch_assoc());
			break;
		}
		$i++;
		sleep(1);
	}
	header("Content-type: application/json");
	echo json_encode($_data);
}
die;