===============================================
Secret Center 由 Secret Center 開發團隊 (http://center.gdsecret.net/#team) 製作
使用 GNU AFFERO GENERAL PUBLIC LICENSE 3.0 (AGPL 3.0) 授權。
===============================================

Secret Center

內建聊天室、論壇、通知以及後臺管理的會員系統

官方網站：http://center.gdsecret.net/

-----------------------------------------------

安裝

1. 上傳文件後，執行 install.php
2. 填入相關資料
3. 安裝成功！

-----------------------------------------------

使用

* 後台位置：http://你的網址/admin/index.php
* 詳細資料(如：網站名稱)：config.php

-----------------------------------------------

從Secret Center 9.0升級

1. 備份 Connections/SQL.php 及資料庫
2. 上傳新版，不要覆蓋 Connections/SQL.php
3. 執行 upgrade.php
4. 升級成功！

-----------------------------------------------

其他

本專案所引用的其他開放原始碼軟體：

Bootstrap v3.3.7
授權：MIT License
官方網站：http://getbootstrap.com/

Summer Note v0.8.2
授權：MIT License
官方網站：http://summernote.org/

HTML Purifier v4.8.0
授權：LGPL v2.1+
官方網站：http://htmlpurifier.org/

Jcrop v0.9.12
授權：MIT License
官方網站：http://deepliquid.com/content/Jcrop.html

-----------------------------------------------

Secret Center 9.1 (1月21日) 更新資訊

主要更新：
*正式支援 PHP 7
*Bootstrap升級為3.3.7版
*jQuery升級為1.12.4版
*手機介面改良
*新增頭貼裁切


聊天室更新：
*將自動清除聊天紀錄門檻由50提高至300筆


論壇更新：
*編輯器改為 Summer Note
*可直接拖拉於圖片文章編輯器內上傳
*開放 Youtube 影片嵌入
*修正搜尋文章時作者顯示錯誤的BUG


通知更新：
*通知由一次已讀5筆改成已讀所有