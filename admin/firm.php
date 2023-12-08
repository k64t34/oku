<?php
include_once $_SERVER["DOCUMENT_ROOT"].'/inc/isAdmin.php'; 
?>
<html><head>
<meta http-equiv="Content-Language" content="ru">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" type="text/css" href="../oku.css">
</head><body>
<h2>Список субъектов</h2>
<a href="FirmEdit.php"><img SRC="/images/add.bmp" border=0 alt="Новый"></a>
<table width="100%"border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" >

<?php  
$sql = "SELECT * FROM firm";
$rs = mysql_query($sql);   
while ($rec = mysql_fetch_array($rs, MYSQL_ASSOC)) 
   {?>
  <tr><td width="10%">
	<a href="FirmEdit.php?id=<?=$rec{'id'}?>">
		<img SRC="/images/edit.bmp" border=0 alt="Править"></a>
	<a href="DeleteRecord.php?tbl=firm&id=<?=$rec{'id'}?>">
		<img SRC="/images/delete.bmp" border=0 alt="Удалить"></a>
	</td>
    <td width="90%"><?=$rec{'name'}?></td>  
  <td><?=$rec{'publish'}<>0?'публикуется':''?></td>
  </tr>
  <?php
  }
  ?>
</table>
<?php
mysql_free_result($rs);
include_once $_SERVER["DOCUMENT_ROOT"].'/inc/CloseDB.php'; 
?> 
</body>
</html>