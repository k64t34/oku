<html><head>
<meta http-equiv="Content-Language" content="ru">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" type="text/css" href="../oku.css">
</head><body>
<?php
include $_SERVER["DOCUMENT_ROOT"].'/inc/isAdmin.php';
?>
<h2>Список опубликованных данных</h2><hr>
<?if (isset($_POST['date']) )
	$date=myDateVBtoPHP($_POST['date']);
else
	$date=time();
?>
<p><form name="F" action="datalist.php" method="POST" onsubmit="F_OnSubmit">
<INPUT TYPE="hidden" name="date" value="date">
<object classid="clsid:3FD7C98B-E0BC-4A98-B954-F32FE6699D7C" 
	  	id="DateControl" 
	  	name="DateControl"
	  	align="left" width="128" height="20" 
	  	codebase="http://oku.megalog.ru/BIN/DateTimePickerXControl1.ocx"
	  	style="font-family: Arial; font-size: 12px"
		class="fld_Edt">
    <param name="CalAlignment" value="0">
	<param name="Date" value="<?=isset($_POST['date'])?$_POST['date']:''?>">
    <param name="ShowCheckbox" value="0">
    <param name="Checked" value="-1">
    <param name="Color" value="2147483653">
    <param name="DateFormat" value="0">
    <param name="DateMode" value="0">
    <param name="DragCursor" value="-12">
    <param name="DragMode" value="0">
    <param name="Enabled" value="-1">
    <param name="Font" value="Arial">
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
<INPUT TYPE="submit" value="    OK    " name="gogogo">
</form></p>
<?
include_once $_SERVER["DOCUMENT_ROOT"].'/inc/oku.php';
$date=myDatePHPtoMySQL($date);
$sql = "SELECT distinct idFirm FROM FirmShowing WHERE date='$date'";
$rs = mysql_query($sql);
if (mysql_num_rows($rs)==0) 
{?><font color="red"><h3>За указанный период данные отсутствуют.</h3></font><hr><?$a=1;}
else
	{
	while ($rec = mysql_fetch_array($rs, MYSQL_ASSOC)) 
		PrintFirm($rec{'idFirm'},$date);	
	}
mysql_free_result($rs);
//include $_SERVER["DOCUMENT_ROOT"].'/inc/CloseDB.php'; 
//*************************************************************
function PrintFirm($idFirm,$date)
//*************************************************************
{
$sql="SELECT * FROM firm WHERE id=$idFirm";
$rs_firm = mysql_query($sql); 	
$rec_firm = mysql_fetch_array($rs_firm, MYSQL_ASSOC);
mysql_free_result($rs_firm);?>
<h3><?=$rec_firm{'name'}?></h3>
<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" >
  <tr>
    <td width="5%">Время</td>
    <td width="10%">План</td>
    <td width="10%">Факт</td>
    <td width="10%">Откл.ИС</td>
    <td width="10%">Откл.ИВ</td>
    <td width="10%">Откл.Норм</td>
    <td width="10%">Откл. %</td>
    <td width="10%">тариф</td>
    <td width="5%">К</td>
    <td width="10%">тариф</td>
    <td width="10%">Откл.оплач</td>
    <td width="10%">тариф.оплач</td>
    <td width="10%">Сумма.оплач</td>
  </tr><?
$sql = "SELECT * FROM FirmShowing WHERE date='$date' AND IdFirm=$idFirm";
$rs = mysql_query($sql);
while ($rec = mysql_fetch_array($rs, MYSQL_ASSOC)) 
	{?>
  <tr>
    <td><?=$rec{'time'}?></td>
    <td><?=$rec{'fact'}?></td>
    <td><?=$rec{'plan'}?></td>
    <td><?=$rec{'deviation_int'}?></td>
    <td><?=$rec{'deviation_ext'}?></td>
    <td><?=$rec{'deviation_norm'}?></td>
    <td><?=$rec{'deviation_pc'}?></td>
    <td><?
	if ($rec{'deviation_int'}<>0)
		echo oku_FirmTarif($idFirm,0,$rec{'deviation_pc'},
		$rec_firm{'generation'}==1?-1:$rec{'time'});
	if ($rec{'deviation_ext'}<>0 AND  $rec{'deviation_int'}<>0)
		echo '<br>';
	if ($rec{'deviation_ext'}<>0)
		echo oku_FirmTarif($idFirm,1,$rec{'deviation_pc'},
		$rec_firm{'generation'}==1?-1:$rec{'time'});
	?></td>
	<td><?=oku_Deviation_K($idFirm,$rec{'deviation_pc'},0)?></td>
    <td><?=Tarif_Deviation_K($idFirm,$rec{'deviation_pc'},0)?></td>	
    <td><?=$rec{'deviation_pay'}?></td>
    <td><?if ($rec{'deviation_int'}<>0)
		echo round(Tarif_Deviation_K($idFirm,$rec{'deviation_pc'},0,$rec{'time'})*
		oku_FirmTarif($idFirm,0,$rec{'deviation_pc'},
		$rec_firm{'generation'}==1?-1:$rec{'time'}),3);
	if ($rec{'deviation_ext'}<>0 AND  $rec{'deviation_int'}<>0)
		echo '<br>';
	if ($rec{'deviation_ext'}<>0)
		echo round(Tarif_Deviation_K($idFirm,$rec{'deviation_pc'},0,$rec{'time'})*	
	oku_FirmTarif($idFirm,1,$rec{'deviation_pc'},
		$rec_firm{'generation'}==1?-1:$rec{'time'}),3);
	?></td>
    <td><?=$rec{'sum_deviation'}?></td>
  </tr><?
	}
mysql_free_result($rs);
?></table>
<?}?> 
</body></html>
<SCRIPT LANGUAGE="VBScript">
<!--
sub F_OnSubmit
F.date.value=cstr(cdbl(cDate(FormatDateTime(F.DateControl.DateTime,vbShortDate)+" 00:00:00")))
end sub 
-->
</script> 
