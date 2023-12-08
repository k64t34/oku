<SCRIPT LANGUAGE="VBScript">
<!--
sub b_OnClick
window.location.href="log.php?date="+ _ 
cstr(cdbl(cDate(FormatDateTime(DateControl.DateTime,vbShortDate)+" 00:00:00")))
end sub 
-->
</script>

<html>
<head>
<meta http-equiv="Content-Language" content="ru">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" type="text/css" href="../oku.css">
</head>
<body>
<h2>Журнал посещений</h2>
<?php
ini_set('include_path','/home/home1/oku/');
include('inc/isAdmin.php'); 

if (isset($_GET['date']) )
	$date= myDatePHPtoMySQL(myDateVBtoPHP($_GET['date']));
else
	$date= myDatePHPtoMySQL(time());
?>
<object classid="clsid:3FD7C98B-E0BC-4A98-B954-F32FE6699D7C" 
	  	id="DateControl" 
	  	name="DateControl"
	  	align="left" 
	  	width="128" 
	  	height="20" 
	  	codebase="http://oku.megalog.ru/BIN/DateTimePickerXControl1.ocx"
	  	style="font-family: Arial; font-size: 12px"
		class="fld_Edt"
		>
    <!--<param name="DateTime" value="38145,3517512731">-->
    <param name="CalAlignment" value="0">
	<param name="Date" value="<?=isset($_GET['date'])?$_GET['date']:''?>">
    <!--<param name="Time" value="38145,3517512731">-->
    <param name="ShowCheckbox" value="0">
    <param name="Checked" value="-1">
    <param name="Color" value="2147483653">
    <param name="DateFormat" value="0">
    <param name="DateMode" value="0">
    <param name="DragCursor" value="-12">
    <param name="DragMode" value="0">
    <param name="Enabled" value="-1">
    <param name="Font" value="Arial">
	    <!---<param name="Font" value="MS Sans Serif">-->
    <param name="ImeMode" value="3">
    <param name="ImeName" value>
    <param name="Kind" value="0">
    <param name="MaxDate" value="0">
    <param name="MinDate" value="0">
    <param name="ParseInput" value="0">
    <param name="ParentColor" value="0">
    <param name="Visible" value="-1">
    <param name="DoubleBuffered" value="0">
    <param name="Cursor" value="0">
</object>
<input type="button" value="OK" name="b">

<table width="100%" border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" >
  <tr>
    <td width="20%"><b>Дата/Время</b></td>
	<td width="20%"><b>Пользователь</b></td>
    <td width="40%"><b>Ресурс</b></td>
	<td width="10%"><b>IP</b></td>
	<td width="10%"><b>Host</b></td>
  </tr>

<?php  
include("inc/OpenDB.php"); 

$sql = "SELECT log.*,user.name FROM log left join user on( log.IdUser=user.id ) WHERE DATE_FORMAT(log.date,'%Y-%m-%d')='$date' ORDER BY id";
//echo $sql,'<br>' ;
$rs = mysql_query($sql);   
while ($rec = mysql_fetch_array($rs, MYSQL_ASSOC)) 
   {?>
  <tr>
    <td><?=$rec{"date"}?></td>
	<td><?=$rec{"name"}?><?if ($rec{'name'}=='')
							echo '<font color="red">не авторизован</font>';
						?></td>
	<td ><?=$rec{"file"}?></td>
	<td ><?=$rec{"ip"}?></td>
	<td ><?=$rec{"host"}?></td>
  </tr>
  <?php
  }
  ?>

</table>

<table border=1>
<?$sql = "SELECT user.name,sum(1) as cnt FROM log left join user on( log.IdUser=user.id ) WHERE DATE_FORMAT(log.date,'%Y-%m-%d')='$date' GROUP BY IdUser";
$rs = mysql_query($sql);   
while ($rec = mysql_fetch_array($rs, MYSQL_ASSOC)) 
   {?>
  <tr>   
	<td><?=$rec{"name"}?></td>
	<td><?=$rec{"cnt"}?></td>
  </tr>
  <?php
  }
  ?>
</table>

<table  border=1>
<?$sql = "SELECT ip,sum(1) as cnt FROM log WHERE DATE_FORMAT(log.date,'%Y-%m-%d')='$date' GROUP BY ip";
$rs = mysql_query($sql);   
while ($rec = mysql_fetch_array($rs, MYSQL_ASSOC)) 
   {?>
  <tr>
    <td><?=$rec{"ip"}?></td>
	<td><?=$rec{"cnt"}?></td>
  </tr>
  <?php
  }
  ?>
</table>


<?php
mysql_free_result($rs);
include("inc/CloseDB.php"); 
?> 
</body>
</html>