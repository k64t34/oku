<?php
error_reporting (2047);
include_once $_SERVER["DOCUMENT_ROOT"].'/inc/oku.php';  
?>


<CENTER>Тариф на отклонение, руб/МВт</CENTER>
<table width=100% border=1 cellspacing="0"  align="center">
<tr>
<?
$colspan=0;
for ($initiative=1;$initiative!=-1;$initiative--)
	for ($increase=0;$increase!=2;$increase++)
		$colspan+=t_DeviationCount($s,$initiative,$increase);
?>		
<td colspan="<?=$colspan?>" align="center"><b>Инициатива</b></td>
</tr>

<tr>
<?
$colspan=0;
for ($increase=0;$increase!=2;$increase++)
	$colspan+=t_DeviationCount($s,1,$increase);
?>
<td colspan="<?=$colspan?>" align="center"><b>Внешняя</b></td>
<?
$colspan=0;
for ($increase=0;$increase!=2;$increase++)
	$colspan+=t_DeviationCount($s,0,$increase);
?>
<td colspan="<?=$colspan?>" align="center"><b>Собственная</b></td>
</tr>

<tr>
<?
for ($initiative=1;$initiative!=-1;$initiative--)
	for ($increase=0;$increase!=2;$increase++)
		{
		?><td colspan="<?=t_DeviationCount($s,$initiative,$increase)?>" align="center" bgcolor="<?=color_inc($increase)?>"><b><?=$increase?'+':'-'?></b></td><?;	
		}
?>
</tr>

<tr>
<?
for ($initiative=1;$initiative!=-1;$initiative--)
	for ($increase=0;$increase!=2;$increase++)
		{
		?><td bgcolor="<?=color_inc($increase)?>">до 2%</td><?
		$sql='SELECT percent_from,percent_to FROM k WHERE '.t_GetDeviationQuery($s,$initiative,$increase);
		$rs= mysql_query($sql);
		while ($rec= mysql_fetch_array($rs, MYSQL_ASSOC))
			{
			$from=$rec{'percent_from'};
			$to=  $rec{'percent_to'};
			?><td bgcolor="<?=color_inc($increase)?>"><?=PercentName($from,$to)?></td><?
			}
		mysql_free_result($rs);
		}
?>
</tr>

<tr align="center">
<?for ($initiative=1;$initiative!=-1;$initiative--)
	for ($increase=0;$increase!=2;$increase++)
		{
		?><td bgcolor="<?=color_inc($increase)?>">-</td><?
		$sql='SELECT percent_from,percent_to FROM k WHERE '.t_GetDeviationQuery($s,$initiative,$increase);
		$rs= mysql_query($sql);
		while ($rec= mysql_fetch_array($rs, MYSQL_ASSOC))
			{
			$from=$rec{'percent_from'};
			$to=  $rec{'percent_to'};
			?><td bgcolor="<?=color_inc($increase)?>"><?=t_Deviation_K($s,$from,$to,$initiative,$increase)?></td><?
			}
		mysql_free_result($rs);
		}
?>
</tr>
<tr align="center">
<?for ($initiative=1;$initiative!=-1;$initiative--)
	for ($increase=0;$increase!=2;$increase++)
		{
		?><td bgcolor="<?=color_inc($increase)?>">-</td><?
		$sql='SELECT percent_from,percent_to FROM k WHERE '.t_GetDeviationQuery($s,$initiative,$increase);
		$rs= mysql_query($sql);
		while ($rec= mysql_fetch_array($rs, MYSQL_ASSOC))
			{
			$from=$rec{'percent_from'};
			$to=  $rec{'percent_to'};
			?><td bgcolor="<?=color_inc($increase)?>"><?=t_rate_Deviation_K($s,$from,$to,$initiative,$increase)?></td><?
			}
		mysql_free_result($rs);
		}
?>
</tr>
<tr align="center">
<?for ($initiative=1;$initiative!=-1;$initiative--)
	for ($increase=0;$increase!=2;$increase++)
		{
		?><td bgcolor="<?=color_inc($increase)?>"><?=SelectValueByKey('firm',$s['idFirm'],'price_em')?></td><?
		$sql='SELECT percent_from,percent_to FROM k WHERE '.t_GetDeviationQuery($s,$initiative,$increase);
		$rs= mysql_query($sql);
		while ($rec= mysql_fetch_array($rs, MYSQL_ASSOC))
			{
			$from=$rec{'percent_from'};
			$to=  $rec{'percent_to'};
			?><td bgcolor="<?=color_inc($increase)?>"><?=t_FirmTarifbyPerCent($s,$from,$to,$initiative,$increase)?></td><?
			}
		mysql_free_result($rs);
		}
?>
</tr>
</table>
<?
//******************************************************
function t_Deviation_K(&$s,$from,$to,$initiative,$inc)
//******************************************************
{
set_S($s,$inc);
return o_Deviation_K($s,$from,$to,$initiative);
}
//******************************************************
function t_rate_Deviation_K(&$s,$from,$to,$initiative,$inc)
//******************************************************
{
set_S($s,$inc);
$s['fact']=$s['plan']+$s['deviation_int']+$s['deviation_ext'];
return o_rate_Deviation_K($s,$from,$to,$initiative);
}
//******************************************************
function t_FirmTarifbyPerCent(&$s,$from,$to,$initiative,$inc)
//******************************************************
{
set_S($s,$inc);
return o_FirmTarifbyPerCent($s,$from,$to,$initiative);
}

//******************************************************
function t_GetDeviationQuery(&$s,$initiative,$inc)
//******************************************************
{
set_S($s,$inc);
return o_GetDeviationQuery($s,$initiative);
}
//******************************************************
function set_S(&$s,$inc)
//******************************************************
{
if ($inc)
	{
	$s['deviation_ext']=1;
	$s['deviation_int']=1;
	}
else
	{
	$s['deviation_ext']=-1;
	$s['deviation_int']=-1;
	}
}

//******************************************************
function t_DeviationCount(&$s,$initiative,$inc)
//******************************************************
{
set_S($s,$inc);
return 1+o_DeviationCount($s,$initiative);
}
//******************************************************
function color_inc($inc)
//******************************************************
{return $inc?'#993366':'#093366';}

?>