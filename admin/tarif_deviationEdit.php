<?php
ini_set('include_path','/home/home1/oku/');
include('inc/isAdmin.php'); 
if (!isset($HTTP_GET_VARS['id']))
	{
	header("Location: firm.php");	
	exit;
	}
include("inc/OpenDB.php"); 
$sql = 'SELECT * FROM firm WHERE id='.$HTTP_GET_VARS['id'];
$rs_firm	= mysql_query($sql);
if (mysql_num_rows($rs_firm)==0)
	{
	header("Location: firm.php");	
	exit;
	}
$rec_firm = mysql_fetch_array($rs_firm, MYSQL_ASSOC);
$firm_id=$HTTP_GET_VARS['id'];
$firmName=$rec_firm{'name'};
$firmGeneration=$rec_firm{'generation'};		
mysql_free_result($rs_firm);
?>
<html>
<head>
<meta http-equiv="Content-Language" content="ru">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" type="text/css" href="../oku.css">
</head>
<body>
<H2>Тариф за отклонение(руб./МВт·ч)</H2>
<?=$firmName?>
<form name="Forma" method="POST"  action="tarif_deviationSave.php">
<input type="hidden" name ="id" value ="<?=$firm_id?>">

<table border="1" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse">
	<tr>   	
		<td width="100%" colspan="5" align="center">
        <p><b>Инициатива</b></td>		
    </tr>
	<tr>   	
      	<td width="50%" align="center" colspan="2" ><b>Внешняя</b></td>
		<td width="50%" align="center" colspan="3" ><b>Собственная</b></td>
    </tr>	
	<tr>   	
      	<td width="25%" align="center" ><b>при увеличении </b></td>		
      	<td width="25%" align="center" ><b>при снижении</b></td>		
		<td width="25%" align="center" ><b>при увеличении </b></td>		
		<td width="25%" align="center" colspan="2" ><b>при снижении </b></td>
    </tr>	
	<tr>
     	<?php
		//В Н Е Ш Н И Я Я
 		add_fld_tarif($firm_id,1,1);//Внешняя-увеличение
 		add_fld_tarif($firm_id,1,0);//Внешняя-снижение
		//С О Б С Т В Е Н Н А Я
		
		if ($firmGeneration)
			{
			add_fld_tarif($firm_id,0,1);//Собственная-увеличение
	 		add_fld_tarif($firm_id,0,0);//Собственная-снижение
			}
		else 		//ПЕРИОДЫ только для потребления
			{	
		    $sql = 'SELECT * FROM period';
			$rs_period	= mysql_query($sql);				
			for ($i_increase=1;$i_increase>=0;$i_increase--)
				{
				echo '<td><table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">';
				mysql_data_seek($rs_period,0);
				while ($rec_period = mysql_fetch_array($rs_period, MYSQL_ASSOC))
					{
					echo'<tr>';
					echo '<td width="50%">'.$rec_period{'name'}.'</td>';
					add_fld_tarif($firm_id,0,$i_increase,$rec_period{'id'});
					echo'</tr>';
					}
				echo '</table></td>';
				}
			}?>

	</tr>
</table>
<p align="center"> <input type="submit" value="        OK        " name="OK" class="fld_Btm"> </p>
</form>

</body></html>

<?php
function firm_tarif_deviation($idFirm,$iniciative,$Increase,$idPeriod=0)
{
$sql = "SELECT * 	FROM tarif_deviation 
		WHERE idFirm=$idFirm
			AND initiative=$iniciative
			AND idPeriod=$idPeriod";
$rs_firm_tarif_deviation=mysql_query($sql);
$id=0;
$price=0;
if (mysql_num_rows($rs_firm_tarif_deviation)) //Если нет записи по ключу, то создать запись и присвоить ноль
	{
	$rec_firm_tarif_deviation= mysql_fetch_array($rs_firm_tarif_deviation, MYSQL_ASSOC);
	$id=$rec_firm_tarif_deviation{'id'};
	$price=$Increase?$rec_firm_tarif_deviation{'increase_price'}:$rec_firm_tarif_deviation{'decrease_price'};
	mysql_free_result($rs_firm_tarif_deviation);	
	}
else
	{
	$sql = "INSERT INTO tarif_deviation (idFirm,initiative,idPeriod) VALUES
			($idFirm,$iniciative,$idPeriod)";
	
	mysql_query($sql);
	$id=mysql_insert_id();
	}
return array($id,$price);
}

function add_fld_tarif($idFirm,$iniciative,$Increase,$idPeriod=0)
{
$tarif=firm_tarif_deviation($idFirm,$iniciative,$Increase,$idPeriod);
echo '<td width="25%" align="center" ><input type="text" name="'.($Increase?'in':'de').$tarif[0].'" size="10" class="fld_Edit" value="'.$tarif[1].'"></td>
';

}
?>


