<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Content-Language" content="ru">
<link rel="stylesheet" type="text/css" href="/oku.css">
</head><body >
<h2>Публикация данных. Этап 2</h2><hr>
<?php
error_reporting (2047);
include_once $_SERVER["DOCUMENT_ROOT"].'/inc/isAdmin.php'; 
include_once $_SERVER["DOCUMENT_ROOT"].'/inc/oku.php'; 
$result=0;
if (is_uploaded_file($_FILES['TXT_FILE']['tmp_name'])) 
	{
	$sname=$_FILES['TXT_FILE']['name'];
	$date=substr($sname,0,2).'.'.substr($sname,2,2).'.'.substr($sname,4,4);
	echo	'Дата публикации :',$date,'<br>',
			'Получен файл    :',$sname,'<br>';
	$result=myReadFile('TXT_FILE');
	echo '<h3><font color="yellow">Публикация данных завершена</font></h3>';
	} 
else
    echo '<font color="red">Ошибка.Не загружен файл TXT.</font>';
?>
<p align ="center">
<input type="button" value=" Назад "  onclick=window.navigate("publish_data_step1.php")>
<input type="button" value=" Готово "  onclick=window.navigate("/")>
<p></body></html>
<?
//---------------------------------------------
function myReadFile($fname)
//---------------------------------------------
{
$date=substr($_FILES[$fname]['name'],4,4).'-'.substr($_FILES[$fname]['name'],2,2).'-'.substr($_FILES[$fname]['name'],0,2);
$sql = "DELETE FROM FirmShowing WHERE date='$date'";
mysql_query($sql);
echo '<h3>Чтение файла ',$_FILES[$fname]['name'],'... </h3><br>';
$fh=fopen($_FILES[$fname]['tmp_name'],'r');
if ($fh<=0)
	{
	echo 'Невозможно открыть файл ',$file,'.<br>';	
	return 0;
	}
while (! feof($fh))
	{
	$code=trim(fgets($fh));	
	if (strlen ($code)==0) break;	
	$idFirm=SelectValueByKey('firm',"'".$code."'",'id','code');
	if ($idFirm==-1)
		{
		echo 'Не найден идентификатор для ',$code;
		fclose($fh);
		return 0;
		}	
	echo '<b><u>',FirmName($idFirm),'</b></u><br>';
	$FirmPlan=explode (':',fgets($fh));
	$FirmFact=explode (':',fgets($fh));
	$FirmPriceDeviation=ReadPriceDeviation($idFirm);
	$i=1;
	for ($i=1;$i!=24;$i++)
		{
		//echo  $date,' ',$idFirm,' ',$i,' ',$FirmPlan[$i],' ',$FirmFact[$i],'<br>';		
		if (!AddRec($i,$date,$idFirm,$FirmPlan[$i-1],$FirmFact[$i-1],$FirmPriceDeviation['up'][$i-1],$FirmPriceDeviation['down'][$i-1])) 
			{
			fclose($fh);
			return 0;
			}
		}
	if (!AddRec(0,$date,$idFirm,$FirmPlan[$i-1],$FirmFact[$i-1],
					$FirmPriceDeviation['up'][$i-1],$FirmPriceDeviation['down'][$i-1]) )
		{
		fclose($fh);
		return 0;
		}

	}
$sql = "UPDATE FirmShowing SET deviation_pc=round((deviation_int+deviation_ext)*100/plan,2) WHERE NOT plan=0 AND date='$date' ";
mysql_query($sql);
fclose($fh);

$sql = "UPDATE firm SET publication=1 WHERE generation=1";
mysql_query($sql);

echo 'Удаление файла ',$_FILES[$fname]['tmp_name'];
unlink($_FILES[$fname]['tmp_name']);
echo '<hr>';
return 1;
}

//---------------------------------------------
function AddRec($time,$date,$idFirm,$Plan,$Fact,$FirmPriceUpDeviation,$FirmPriceDownDeviation)
//---------------------------------------------
{
$deviation=$Fact-$Plan;
$sum_deviation_up=$deviation>0?$FirmPriceUpDeviation*$deviation/1000:0;
$sum_deviation_down=$deviation<0?-$FirmPriceDownDeviation*$deviation/1000:0;
$sum_deviation=$sum_deviation_up-$sum_deviation_down;
$sum_e=$Plan*SelectValueByKey('firm',$idFirm,'price_e')/1000+$sum_deviation;
$sql = 'INSERT INTO FirmShowing (date,idfirm,time,plan,fact,deviation_int, price_deviation_up, price_deviation_down,sum_deviation_up,sum_deviation_down,sum_deviation,sum_e) VALUES ('.
	 			'\''.$date.'\','.
			 	$idFirm.','.
			 	$time.','.
			 	$Plan.','.
			 	$Fact.','.
				$deviation.','.
				$FirmPriceUpDeviation.','.
				$FirmPriceDownDeviation.','.
				$sum_deviation_up.','.
				$sum_deviation_down.','.
				$sum_deviation.','.
				$sum_e.
			 	')';		
if (!mysql_query($sql))
	{
	echo "<font color=\"red\">Ошибка публикации date=$date idFirm=$idFirm time=$time </font><br>$sql<br>";
	return 0;	
	} 
else 
	return 1;
}

//---------------------------------------------
function ReadPriceDeviation($idFirm)
//---------------------------------------------
{
$FirmPriceDeviation=array("up"=> array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0),
						"down"=> array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0) );
if (SelectValueByKey('firm',$idFirm,'publish')==1)
{
$fname='XLS_FILE'.$idFirm;
if (!is_uploaded_file($_FILES[$fname]['tmp_name'])) 		
	echo '<font color="red">Ошибка.Не загружен файл отклонений '.$fname.' для '.SelectValueByKey('firm',$idFirm,'name').'.</font><br>';
else
	{	
	echo '<h3>Чтение файла ',$_FILES[$fname]['name'],'... </h3><br>';
	$dom = new DomDocument();
	if (!$dom->load($_FILES[$fname]['tmp_name']))
		echo '<font color="red">Ошибка.Невозможно разобрать файл отклонений для '.SelectValueByKey('firm',$idFirm,'name').'.</font><br>';
	else
		{
		$items=$dom->getElementsByTagNameNS('urn:schemas-microsoft-com:office:spreadsheet', 'Data');
		$compled=0;		
		$cb_up='Р¦Р‘+';
		$cb_down='Р¦Р‘-';
		for ($i = 0; $i < $items->length; $i++) 
			{
			$v=$items->item($i)->nodeValue;
			if ($v==$cb_up || $v==$cb_down)             
				{
				$compled++;
				$i++;
				$d=$v==$cb_up?'up':'down';				
				for ($t=0;$t<24;$t++)
					{
					$FirmPriceDeviation[$d][$t]=strtr($items->item(++$i)->nodeValue,',','.');
					echo $items->item(++$i)->nodeValue,' ';
					}
				if ($compled==2) break;
				}			
			}

		}
	if ($compled==0) echo '<font color="red">Ошибка.В этом файле не найдены данные отклонений	</font><br>';
	elseif ($compled==0) echo '<font color="red">Ошибка.В этом файле не найдены некоторые данные отклонений	</font><br>';
	echo 'Удаление файла ',$_FILES[$fname]['tmp_name'],'<br>';
	unlink($_FILES[$fname]['tmp_name']);
	}
}
//print_r ($FirmPriceDeviation);
echo '<br>';
return $FirmPriceDeviation;
}
?>