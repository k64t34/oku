<?php
/*
‘ормат S
--------
idFirm
plan
fact
deviation_int
deviation_ext
time
$s=array(
		'idFirm'		=> ,
		'plan'			=> ,
		'fact'			=> ,
		'deviation_int'	=> ,
		'deviation_ext'	=> ,
		'time'			=>
		);
*/
//******************************************************
function PercentName($from,$to)
//******************************************************
{
if ($from==0)
	$result='до '.$to.'%';
else if ($to==0)
	$result='более '.$from.'%';
else
	$result='от '.$from.'% до '.$to.'%';
return $result;
}

//******************************************************
function o_normDeviation(&$s)
//******************************************************
{return round($s['plan']*SelectValueByKey('firm',$s['idFirm'],'k_norm_deviation')/100);}
//******************************************************
function o_DeviationInNorm(&$s)
//******************************************************
{return round(min(o_normDeviation($s),abs($s['deviation_int']+$s['deviation_ext'])));}

//******************************************************
function o_IdPeriod($time)
//******************************************************
{
return SelectValueByWhere('period_time','idPeriod', 
	'time_start<='.$time.' AND '.$time.'<=time_finish');
}
//******************************************************
function FirmName($idFirm)
//******************************************************
{return SelectValueByKey('firm',$idFirm,'name');}
//******************************************************
function FirmGeneration($idFirm)
//******************************************************
{return SelectValueByKey('firm',$idFirm,'generation');}
//******************************************************
function deviation_pc_color($deviation_pc)
//******************************************************
{
$deviation_pc=abs($deviation_pc);
if ($deviation_pc<=2)
	$color='#000000';
elseif ($deviation_pc<=5)
	$color='#550000';
elseif ($deviation_pc<=10)	
	$color='#AA0000';
else
	$color='#FF0000';
return $color;
}
//******************************************************
function o_FirmTarifbyPerCent(&$s,$from,$to,$initiative=0)
//******************************************************
{
$result=SelectValueByKey('k',o_Deviation_K($s,$from,$to,$initiative),'tarif');
if ($result==0)
	$result='price_em';
elseif ($result==1)
	$result='price_e';
else
	$result='price_max';

$result=SelectValueByKey('firm',$s['idFirm'],$result);
return round($result*o_rate_Deviation_K($s,$from,$to,$initiative),4);
}


//******************************************************
function o_Deviation_K(&$s,$from,$to,$initiative=0)
//******************************************************
{
$result=SelectValueByWhere('k','id','percent_from='.$from.' AND percent_to='.$to.' AND '.	
	o_GetDeviationQuery(&$s,$initiative));
return $result;
}
//******************************************************
function o_rate_Deviation_K(&$s,$from,$to,$initiative=0)
//******************************************************
{
$result=SelectValueByKey('k',o_Deviation_K($s,$from,$to,$initiative),'value');
return $result;
}


//******************************************************
function o_SumDeviationPerCent(&$s,$from,$to,$initiative=0)
//******************************************************
{
$Portion=o_PortionDeviation($s,$from,$to,$initiative);
if (FirmGeneration($s['idFirm'])==0)
	$Portion=abs($Portion);
return	round(
		$Portion*
		o_FirmTarifbyPerCent($s,$from,$to,$initiative)
		/1000,2);

}
//******************************************************
function o_GetDeviationQuery(&$s,$initiative=0)
//******************************************************
{
$FirmGeneration=FirmGeneration($s['idFirm']);
$sql='generation='.$FirmGeneration.' AND '.
	'initiative='.$initiative.' AND ';
	if ($initiative)
		$increase=$s{'deviation_ext'}>0?'1':'0';
	else
		$increase=$s{'deviation_int'}>0?'1':'0';
	$sql=$sql.'increase='.$increase.' AND control=';
if 	($initiative==1 AND $FirmGeneration==0)
	$sql=$sql.SelectValueByKey('firm',$s['idFirm'],'control');
else
	$sql=$sql.'0';

return $sql;
}
//******************************************************
function o_DeviationCount(&$s,$initiative=0)
//******************************************************
{
$sql='SELECT 1 FROM k WHERE '.o_GetDeviationQuery(&$s,$initiative);
$rs_o_DeviationCount = mysql_query($sql);
$result=mysql_num_rows($rs_o_DeviationCount);
mysql_free_result($rs_o_DeviationCount);

return $result;
}

//******************************************************
function o_SumDeviation(&$s,$initiative=0)
//******************************************************
{
$rs_o_SumDeviation = mysql_query('SELECT percent_from,percent_to FROM k WHERE '.o_GetDeviationQuery(&$s,$initiative));
$result=0;
while ($rec_o_SumDeviation = mysql_fetch_array($rs_o_SumDeviation, MYSQL_ASSOC))
	{
	$result+=o_SumDeviationPerCent($s,
				$rec_o_SumDeviation{'percent_from'},
				$rec_o_SumDeviation{'percent_to'},
				$initiative);
	}
mysql_free_result($rs_o_SumDeviation);	
return $result;	
}
//******************************************************
function o_SumEnergy(&$s)
//******************************************************
{return round($s['fact']*SelectValueByKey('firm',$s['idFirm'],'price_em')/1000,2);}
//******************************************************
function o_SumDeviationAll(&$s)
//******************************************************
{return /*o_SumDeviationInNorm($s)+*/o_SumDeviation($s,0)+o_SumDeviation($s,1);}
//******************************************************
function o_SumDeviationInNorm(&$s)
//******************************************************
{
$result=round(o_DeviationInNorm($s)*SelectValueByKey('firm',$s['idFirm'],'price_em')/1000,2);
return $result;
}
//******************************************************
function o_Deviation(&$s,$initiative=0)
//******************************************************
{return $initiative?$s['deviation_ext']:$s['deviation_int'];}
//******************************************************

//******************************************************
function o_PortionDeviation(&$s,$from,$to,$initiative=0)
//******************************************************
{
$deviation=o_Deviation($s,$initiative);
$result=0;
if ($deviation<>0)
	{
	$from=round($s['plan']*$from/100);
	if ($from<abs($deviation))
		{
		if ($to==0)
			$result=abs($deviation)-$from;		
		else
			$result=round(min(abs($deviation),$s['plan']*$to/100))-$from;
		MyGiveSign($result,$deviation);
		}
	}
return $result;
}

?>	

 