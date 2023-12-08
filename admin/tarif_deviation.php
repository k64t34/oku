<?php
echo '<p align="center">Тариф за отклонение(руб./МВт·ч)</p>';
?>
<table border="1" cellpadding="0" cellspacing="0" width="986" style="border-collapse: collapse">
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
		<!--
		В Н Е Ш Н И Я Я
		-->
		<!--Внешняя-увеличение-->
      	<td width="25%" align="center" >	
		<?$tarif=firm_tarif_deviation1($firm_id,1,1);?>
		<input type="text" name="id_<?=$tarif[0]?>" size="10" class="fld_Edit" value="<?=$tarif[1]?>"></td>

		<!--//Внешняя-снижение-->
    	<td width="25%" align="center" >	
		<?$tarif=firm_tarif_deviation1($firm_id,1,0);?>
		<input type="text" name="id_<?=$tarif[0]?>" size="10" class="fld_Edit" value="<?=$tarif[1]?>"></td>

		
		<!--
		С О Б С Т В Е Н Н А Я
		-->
		<?
		if ($rec_firm{'generation'})
			{?>
		<!--Собственная-увеличение-->
      	<td width="25%" align="center" >	
		<?$tarif=firm_tarif_deviation1($firm_id,0,1);?>
		<input type="text" name="id_<?=$tarif[0]?>" size="10" class="fld_Edit" value="<?=$tarif[1]?>"></td>

		<!--Собственная-снижение-->
    	<td width="25%" align="center" >	
		<?$tarif=firm_tarif_deviation1($firm_id,0,0);?>
		<input type="text" name="id_<?=$tarif[0]?>" size="10" class="fld_Edit" value="<?=$tarif[1]?>"></td>
		
		<?	}
		else 		//ПЕРИОДЫ только для потребления
			{
		    $sql = 'SELECT * FROM period';
			$rs_period	= mysql_query($sql);
			for ($i_increase=1;$i_increase==0;$i_increase--)
				{?>
				<td>
				<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" bordercolor="#111111" width="100%">
				<?
				mysql_data_seek($rs_period,0);
				while ($rec_period = mysql_fetch_array($rs_period, MYSQL_ASSOC))
					{?>
					<tr>
						<td width="50%"><?=$rec_period{'name'}?></td>
						<td width="50%">
						<?$tarif=firm_tarif_deviation1($firm_id,0,$i_increase,$rec_period{'id'});?>
						<input type="text" name="id_<?=$tarif[0]?>" size="10" class="fld_Edit" value="<?=$tarif[1]?>"></td>
					</tr>
					<?}?>				
		        </table>
				</td>
				<?}?>

<?
function firm_tarif_deviation1($idFirm,$iniciative,$Increase,$idPeriod)
{
/*
Если нет записи по ключу, то создать запись и присвоить ноль
*/
return array(0,0);
}
?>