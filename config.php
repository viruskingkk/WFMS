<?php


if(!session_id()) {
    session_start();
}

if(!isset($_COOKIE['login']) && isset($_SESSION['Center_Username'])){//如果已登入COOKIE不存在，但SESSION存在
	header('Location: index.php?logout');//直接消除SESSION並登出
}

global $center;

date_default_timezone_set("Asia/Taipei"); //時區設定
$center['site_name'] = "文德福台灣IT"; //網站名稱
$center['register'] = "1"; //是否開啟註冊，0為關閉，1為開啟
$center['mail'] = "admin@example.com"; //網站Email，用於重設密碼信件

$center['chat']['public'] = "3"; //聊天室_發言間隔 單位 秒
$center['avatar']['max_size'] = "1500";//頭貼_檔案大小限制 單位 KB
$center['avatar']['compress'] = "1";//頭貼_是否開啟壓縮，0為關閉，1為開啟
$center['avatar']['quality'] = "80";//頭貼_壓縮品質設定 0~100
$center['forum']['captcha']="0"; //論壇_驗證碼是否開啟，0為關閉，1為開啟
$center['forum']['limit']="30"; //論壇_文章&回覆每頁顯示數量
$center['member']['message']=
<<<MSG
趕快來使用我!!!
MSG;
;//會員中心信息
require_once('function.php');