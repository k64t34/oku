<html>
<head>
<meta http-equiv="Content-Language" content="ru">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" type="text/css" href="../oku.css">
</head>
<body>
<h2>Калькулятор сумм отклонений</h2> 
<?php
include_once $_SERVER["DOCUMENT_ROOT"].'/inc/login.php'; 
include_once $_SERVER["DOCUMENT_ROOT"].'/inc/oku.php'; 
//include_once $_SERVER["DOCUMENT_ROOT"].'/inc/OpenDB.php'; 

if (isset($_GET['idFirm']))
	{	
	$s=array(
		'idFirm'=>$_GET['idFirm'],
		'plan'=>$_GET['plan'],
		'fact'=>$_GET['fact'],
		'deviation_int'=>$_GET['deviation_int'],
		'deviation_ext'=>$_GET['deviation_ext'],
		'time'=>$_GET['time']
		);
	}
elseif (isset($_POST['idFirm']))
	{
	$_POST['idFirm']=substr ($_POST['idFirm'],4);
	$s=array(
		'idFirm'=>$_POST['idFirm'],
		'plan'=>$_POST['plan'],
		'fact'=>$_POST['fact'],
		'deviation_int'=>$_POST['deviation_int'],
		'deviation_ext'=>$_POST['deviation_ext'],
		'time'=>$_POST['time']
		);
	}
elseif (isset($_SESSION['idUserFirm'])) 
	{	
	$s=array(
		'idFirm'=>$_SESSION['idUserFirm'],
		'plan'=>0,
		'fact'=>0,
		'deviation_int'=>0,
		'deviation_ext'=>0,
		'time'=>1
		);
	}
elseif (isset($_SESSION['Admin_right']))
	{	
	$s=array(
		'idFirm'=>$_SESSION['idUserFirm']==0?2:$_SESSION['idUserFirm']	,
		'plan'=>0,
		'fact'=>0,
		'deviation_int'=>0,
		'deviation_ext'=>0,
		'time'=>1
		);
	}
else
	{
	echo 'У вас нет права пользоваться этим ресурсом';
	exit;
	}
$pc=array(2,5,10);
?>
<table>
<tr><td>
<form method="post" action="Calc1.php">
<table>
<tr><td>Субъект</td>
<td>
<select size="1" name="idFirm" class="fld_Btm">
<?php  
$sql = 'SELECT * FROM firm';
if (!$_SESSION['Admin_right'] AND $_SESSION['idUserFirm']!=0)
	$sql=$sql.' WHERE id='.$_SESSION['idUserFirm'];
$rs = mysql_query($sql);   
while ($rec = mysql_fetch_array($rs, MYSQL_ASSOC)) 
   {?>
   <option value="firm<?=$rec{"id"}?>"
   <?if ($s['idFirm']==$rec{'id'} )
		echo ' selected ';?>
		>
		<?=$rec{"name"}?></option>
  <?php
  }  
mysql_free_result($rs);
?> 
</select>
</td>
<tr>
<td>План</td>
<td><INPUT TYPE="text" NAME="plan" value="<?=$s['plan']?>"></td>
</tr><tr>
<td>Факт</td>
<td><INPUT TYPE="text" NAME="fact" value="<?=$s['fact']?>"></td>
</tr><tr>
<td>Отклонения<br>по собственной<br>инициативе</td>
<td><INPUT TYPE="text" NAME="deviation_int" 
value="<?=$s['deviation_int']?>"></td>
</tr><tr>
<td>Отклонения<br>по внешней<br>инициативе</td>
<td><INPUT TYPE="text" NAME="deviation_ext" value="<?=$s['deviation_ext']?>"></td>
</tr><tr>
<td>время</td>
<td><INPUT TYPE="text" NAME="time" value="<?=$s['time']?>" size="2"></td>
</tr><tr><td>
<INPUT TYPE="submit" value="Расчет" >
</td></tr>
</table>
</form>
</td>
<td>
<table width="100%">
<tr bgcolor="BLUE">
	<td width="16%">Время</td>
	<td width="16%">План</td>
	<td width="16%">Факт</td>
	<td width="16%">Отклонения<br>Нормативные</td>	
	<td width="16%">Тариф</td>	
	<td width="16%">Сумма</td>	
</tr>
<tr bgcolor="BLUE">
	<td><?=$s['time']?></td>
	<td><?=$s['plan']?></td>
	<td><?=$s['fact']?></td>
	<td><?=o_DeviationInNorm($s)?></td>	
	<td><?=SelectValueByKey('firm',$s['idFirm'],'price_em')?></td>	
	<td><?=o_SumDeviationInNorm($s)?></td>	
</tr>

<?for ($j=0;$j<2;$j++) {?>

<tr bgcolor="red">
	<td>инициатива</td>	
	<td>Отклонение</td>	
	<td></td>	
	<td></td>	
	<td></td>	
	<td>Сумма</td>	
</tr>
<tr bgcolor="red">
	<td><?=$j?'Внешняя':'Собственная'?></td>	
	<td><?=o_Deviation($s,$j)?></td>	
	<td></td>	
	<td></td>	
	<td></td>	
	<td><?=o_SumDeviation($s,$j)?></td>	
</tr>


<tr bgcolor="gray">

	<td>%</td>	
	<td>откл.оплач</td>	
	<td>к</td>	
	<td>коэф</td>	
	<td>тариф</td>	
	<td>сумма</td>	
</tr>

<?
$sql='SELECT * FROM k WHERE '.o_GetDeviationQuery($s,$j);

$rs= mysql_query($sql);
while ($rec= mysql_fetch_array($rs, MYSQL_ASSOC))
	{
	$from=$rec{'percent_from'};
	$to=  $rec{'percent_to'};

?>
<tr bgcolor="gray">
	<td><?=PercentName($from,$to)?></td>
	<td><?
	//o_PerCentPortion($pc[$i],&$from,&$to);	
	echo o_PortionDeviation($s,$from,$to,$j);?></td>	
	<td><?=o_Deviation_K($s,$from,$to,$j)?></td>	
	<td><?=o_rate_Deviation_K($s,$from,$to,$j)?></td>	
	<td><?=o_FirmTarifbyPerCent($s,$from,$to,$j)?></td>	
	<td><?=o_SumDeviationPerCent($s,$from,$to,$j)?></td>	

</tr>
<?;
   }
	mysql_free_result($rs);	
?>

<?;}?>
<tr bgcolor="BLUE">
<td>ИТОГО</td>
<td></td>	
<td></td>	
<td></td>	
<td></td>	
<td><?=o_SumDeviationAll($s)?></td>
</tr>

</table>
</td></tr></table>

</body></html>