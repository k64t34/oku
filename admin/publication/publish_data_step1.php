<?php
include $_SERVER["DOCUMENT_ROOT"].'/inc/isAdmin.php'; 
?>
<html><head>
<meta http-equiv="Content-Language" content="ru">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" type="text/css" href="/oku.css">
<title>Публикация данных. Этап 1.</title>
</head><body>
<h2>Публикация данных.  Этап 1.</h2>
<form enctype="multipart/form-data" action="publish_data_step2.php " method="post">
<input type="hidden" name="MAX_FILE_SIZE" value="100000">
Укажите файл с данными для публикации(ДДММГГГГ.txt)<br>
<input type="file" name="TXT_FILE" size="128"><br>
<?$sql = "SELECT * FROM firm WHERE publish=1";
$rs = mysql_query($sql);   
while ($rec = mysql_fetch_array($rs, MYSQL_ASSOC)) 
   {?>Укажите XLS файл с данными <?=$rec{'name'}?><br>
<input type="file" name="XLS_FILE<?=$rec{'id'}?>" size="128"><br>
  <?;}
mysql_free_result($rs);
include_once $_SERVER["DOCUMENT_ROOT"].'/inc/CloseDB.php'; 
?> 

<p align="center">
<input type="submit" value=" Далее " name="B1"></p>
</p>
</form>
</body></html>


