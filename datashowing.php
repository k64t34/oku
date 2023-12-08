<?php 
//error_reporting (2047);
include_once $_SERVER["DOCUMENT_ROOT"].'/inc/login.php'; 
include_once $_SERVER["DOCUMENT_ROOT"].'/inc/OpenDB.php';
if (isset($_GET['Date']))
	{
	$date=$_GET['Date'];
	$idFirm=$_GET['firm'];
	}
else
	{
	$date=$_POST['Date'];
	$idFirm=$_POST['firm'];
	}
$_SESSION['user_choice_date']=$date;
$_SESSION['user_choice_firm']=$idFirm;
$date=myDateVBtoPHP($date);


if (!$_SESSION['Admin_right'] AND $_SESSION['idUserFirm']!=0)
	{
	if ($_SESSION['idUserFirm']!=$idFirm)
		{
		echo '<h2><font color="#FF0000"> У вас нет прав для просмотра этой информации</font></h2>';
		exit;
		}
	}
//*****************************************************************************
$sql = 'SELECT * FROM firm WHERE id='.$idFirm;
$rs = mysql_query($sql);
$rec = mysql_fetch_array($rs, MYSQL_ASSOC);
$Firm_Name=$rec{'name'};
$firmGeneration=$rec{'generation'};	
mysql_free_result($rs);	
//*****************************************************************************
include_once $_SERVER["DOCUMENT_ROOT"].'/inc/oku.php';
$sql='SELECT * FROM FirmShowing WHERE idFirm='.$idFirm.' AND date=\''.myDatePHPtoMySQL($date).'\'';
$rs = mysql_query($sql);

//*****************************************************************************
$DataExist=mysql_num_rows($rs);
if ($DataExist)
	{
	include_once $_SERVER["DOCUMENT_ROOT"].'/inc/FillColor.php';

	if ($firmGeneration)
		$Cclr='"CEE4FB","D9F9D9","FFE8F3","FFFFFF","FFFFFF","FFFFFF"';
	else
		$Cclr='"CEE4FB","D9F9D9","FFE8F3","FFFFFF","FFFFFF","FFFFFF"';

	$Rclr='';
	for ($i=0;$i<24;$i++)
	{
		$sql="SELECT period.color_start 
			FROM period,period_time  
			WHERE period.id=period_time.idPeriod 
				AND 
				time_start<=$i AND $i<=time_finish";    
		$rs_color=mysql_query($sql);
		$rec_color= mysql_fetch_array($rs_color, MYSQL_ASSOC);  
		$Rclr=$Rclr.'"'.$rec_color{'color_start'}.'"';
		if ($i<23)
			$Rclr=$Rclr.',';
	}
	if ($firmGeneration)
		myFillColorScript(1,6,1,24,$Cclr,$Rclr);
	else
		myFillColorScript(1,6,1,24,$Cclr,$Rclr);
	}
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Content-Language" content="ru">
<link rel="stylesheet" type="text/css" href="oku.css">
<TITLE>Таблица</TITLE>
</head>
<body >
<h2>Предварительные фактические и стоимостные отклонения по 
<?=$firmGeneration?'выработке':'потреблению';?> электроэнергии от торгового графика</h2>
<p><font color="#FFFF00"><b><?=myDate($date)?> <?=$Firm_Name?></b></font>
<a href="datashowing.php?Date=<?=myDatePHPtoVB($date)-1?>&firm=<?=$idFirm?>"><IMG SRC="images/previos.bmp" BORDER="0" ALT="назад" align="left"></a>
<a href="window.php"><IMG SRC="images/Calendar.bmp" BORDER="0" ALT="Витрина" align="left"></a>
<a href="datashowing.php?Date=<?=myDatePHPtoVB($date)+1?>&firm=<?=$idFirm?>"><IMG SRC="images/next.bmp" BORDER="0" ALT="вперед" align="left"></a>

<a href="chartshowing.php?Date=<?=myDatePHPtoVB($date)?>&firm=<?=$idFirm?>"><IMG SRC="images/chart.bmp" BORDER="0" ALT="Диаграмма" align="left"></a>
<!--<a href="/admin/Calc1.php"><IMG SRC="/images/Calculator.bmp" BORDER="0" ALT="Калькулятор сумм отклонений" align="left"></a>-->
</p><br>
<?
//*****************************************************************************
if (!$DataExist)
	{
	?><font color="#FF5050">Нет данных на <?=myDate($date)?> по <?=$Firm_Name?></font><?
	exit;
	}

?>

<table	border=1 
		bgcolor="#FFFFFF"
		width=100%
		cellpadding="0" 
		cellspacing="0"
		bordercolorlight="#4848FF" 
		bordercolordark="#CEE4FB"
		style="font-family: Tahoma;color: #000000; font-size:10pt; background-color:#FFFFFF"
		id="t1"
		>
<TR>
    <TD align="center" width="5%" bgcolor="#f0f0f0" ><b>часы</b></TD>
    <TD align="center" width="12%" bgcolor="#CEE4FB"><b>план<br></b>КВт· ч</TD>
    <TD align="center" width="12%" bgcolor="#D9F9D9"><b>факт<br></b>КВт· ч</TD>
	<TD align="center" width="15%" bgcolor="#FFE8F3"><b>Фактические<br>отклонения</b><br>КВт· ч</TD>
	<TD align="center" width="12%" bgcolor="#FFFFFF"><b>Доплата</b><br>Руб.</TD>  
	<TD align="center" width="12%" bgcolor="#FFFFFF"><b>Возврат</b><br>Руб.</TD>  
	<TD align="center" width="16%" bgcolor="#FFFFFF" ><b>Фактическая стоимость</b><br>Руб.</TD>  
</TR>
<?
$total=Array('plan'=>0,'fact'=>0,'sum_deviation_up'=>0,'sum_deviation_down'=>0,'sum_e'=>0);
while ($rec = mysql_fetch_array($rs, MYSQL_ASSOC)) 
	{?>
<tr> 
<?$sql='SELECT period.id,period.color_start FROM period,period_time  WHERE period.id=period_time.idPeriod AND time_start<='.$rec{'time'}.' AND '.$rec{'time'}.'<=time_finish';	
$rs_period=mysql_query($sql);
$rec_period= mysql_fetch_array($rs_period, MYSQL_ASSOC);	
?>

<td align="center" bgcolor="#<?=$rec_period{'color_start'}?>"><?=$rec{"time"}?>:00</td>
<td align="right" ><?=$rec{"plan"}?></td>
<td align="right" ><?=$rec{"fact"}?></td>
<td align="right" ><?=$rec{"deviation_int"}?></td>
<td align="right" ><?=number_format($rec{'sum_deviation_up'},2,',',' ')?></td>
<td align="right" ><?=number_format($rec{'sum_deviation_down'},2,',',' ')?></td>
<td align="right" ><?=number_format($rec{'sum_e'},2,',',' ')?></td>
</td>
</tr>
	<?
	$total['plan']=$total['plan']+$rec{"plan"};
	$total['fact']=$total['fact']+$rec{"fact"};
	$total['sum_deviation_up']=$total['sum_deviation_up']+$rec{'sum_deviation_up'};
	$total['sum_deviation_down']=$total['sum_deviation_down']+$rec{'sum_deviation_down'};
	$total['sum_e']+=$rec{'sum_e'};
	}
	?>
<tr><b><td>ИТОГО</td>
<td align="right"><?=$total['plan']?></td>
<td align="right"><?=$total['fact']?></td>
<td align="right"><?=$total['fact']-$total['plan']?></td>
<td align="right"><?=number_format($total['sum_deviation_up'],2,',',' ')?></td>
<td align="right"><?=number_format($total['sum_deviation_down'],2,',',' ')?></td>
<td align="right"><?=number_format($total['sum_e'],2,',',' ')?></td>
</b></tr>
<?
$sql='SELECT sum(plan) as plan ,sum(fact) as fact,sum(sum_deviation_up) as sum_deviation_up,sum(sum_deviation_down) as sum_deviation_down,sum(sum_e) as sum_e'.
' FROM FirmShowing '.
' WHERE year(date)='.MyYear($date).' AND '.
' month(date)='.MyMonth($date).' AND '.
' DAYOFMONTH(date)<='.MyDay($date).' AND '.
' idFirm='.$idFirm;
//echo $sql; 
$rs = mysql_query($sql);
$rec = mysql_fetch_array($rs, MYSQL_ASSOC);
?>

<tr><b><td>ИТОГО с начала месяца</td>
<td align="right"><?=$rec{'plan'}?></td>
<td align="right"><?=$rec{'fact'}?></td>
<td align="right"><?=$rec{'fact'}-$rec{'plan'}?></td>
<td align="right"><?=number_format($rec{'sum_deviation_up'},2,',',' ')?></td>
<td align="right"><?=number_format($rec{'sum_deviation_down'},2,',',' ')?></td>
<td align="right"><?=number_format($rec{'sum_e'},2,',',' ')?></td>

</b></tr>

</table> 
</body></html>
<?mysql_free_result($rs);
myFillColorControl();
?>