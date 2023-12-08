<?php
include_once $_SERVER["DOCUMENT_ROOT"].'/inc/isAdmin.php'; 
?>
<html>
<head>
<meta http-equiv="Content-Language" content="ru">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" type="text/css" href="../oku.css">
</head>
<body>
<h2>Список пользователей</h2>
<a href="UserEdit.php">Новый</a>
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" >
  <tr>
    <th width="20%"><b>Имя</b></th>
	<th width="50%"><b>Организация</b></th>
    <th width="10%"><b>Администратор</b></th>
    <th width="10%"><b>&copy;</b></th>
    <th width="10%"></th>
    <th width="10%"></th>
  </tr>

<?
$sql = 'SELECT u.*,f.name as FirmName FROM user as u left join firm as f  on (u.idFirm=f.id)';

$rs = mysql_query($sql);   
while ($rec = mysql_fetch_array($rs, MYSQL_ASSOC)) 
   {?>
  <tr>
    <td><?=$rec{"name"}?></td>
	<td><?=$rec{"FirmName"}?></td>
	 <td ><?if ($rec{"admin"}==1)
							echo '[X]';
						else
							echo '[ ]';?></td>
	 <td ><?if ($rec{"access"}==1)
							echo '[X]';
						else
							echo '[ ]';?></td>

    <td><a href="UserEdit.php?id=<?=$rec{"id"}?>">Править</a></td>
    <td><a href="DeleteRecord.php?tbl=user&id=<?=$rec{"id"}?>">Удалить</a></td>
  </tr>
  <?php
  }
  ?>
</table>
<?php
mysql_free_result($rs);
include '../inc/btmBack.php'; 
?> 
</body>
</html>