<?php
/*
число_дней_VBS*86400+число_сек_VBS=число_сек_PHP+2209172400
PHP
VBScript
	represents a date between January 1, 100 to December 31, 9999.
JScript
	represents the number of milliseconds in Universal Coordinated Time between the specified date and midnight January 1, 1970.
*/
//******************************************************
function myDatePHPtoVB($date)
//******************************************************
{return floor(($date+2209172400)/86400);}
//******************************************************
function myDateVBtoPHP($date)
//******************************************************
{return floor(($date*86400-2209172400));}
//******************************************************
function myDatePHPtoMySQL($date)
//******************************************************
{return date('Y-m-d',$date);}

function Now()
//******************************************************
{return date('U');}
//******************************************************
function myLastDay($date)
//******************************************************
{return date('t',$date);}

//******************************************************
function myDateTimePHPtoMySQL($date)
//******************************************************
{return date('Y-m-d H:i:s',$date);}

//******************************************************
function myDay($date)
//******************************************************
{return date('d',$date);}

function myYear($date)
//******************************************************
{return date('Y',$date);}

function myMonth($date)
//******************************************************
{return date('m',$date);}

function myMonthName($month)
//******************************************************
{
switch ($month) {
	case  1: $month='Январь';break;
	case  2: $month='Февраль';break;
	case  3: $month='Март';break;
	case  4: $month='Апрель';break;
	case  5: $month='Май';break;
	case  6: $month='Июнь';break;
	case  7: $month='Июль';break;
	case  8: $month='Август';break;
	case  9: $month='Сентябрь';break;
	case 10: $month='Октябрь';break;
	case 11: $month='Ноябрь';break;
	case 12: $month='Декабрь';break;
}
return $month;
}

//******************************************************
function myDate($date)
//******************************************************
{return date('d.m.Y',$date);}

//******************************************************
function myDateRUStoPHP($date) // из формата ДД.ММ.ГГГГ в PHP
//******************************************************
{return date('d.m.Y',$date);}

//******************************************************
function myColorMix($color1,$color2,$ratio=1)
//******************************************************
{
for ($i=0;$i!=3;$i++)
	{	
	$c1[$i]=hexdec(substr($color1,$i*2,2));
	$c2[$i]=hexdec(substr($color2,$i*2,2));
	$c1[$i]=$c1[$i]-$ratio/(1+$ratio)*($c1[$i]-$c2[$i]);
	}
return sprintf('%02s%02s%02s',dechex($c1[0]),dechex($c1[1]),dechex($c1[2]));
}
//******************************************************
function MyNumberSign($number)
//******************************************************
{return $number>=0?1:-1;}

//******************************************************
function MyGiveSign(&$Target,$Source)
//******************************************************
{
if ($Source<0)
	$Target=-$Target;
}

//******************************************************
function SelectValueByKey($table,$id,$value,$key='id')
//******************************************************
{
$rs = mysql_query('select '.$value.' from '.$table.' where '.$key.'='.$id);
if (mysql_num_rows($rs)==0)
	$result=-1;
else
	{
	$rec = mysql_fetch_array($rs, MYSQL_ASSOC);
	$result=$rec{$value};	
	mysql_free_result($rs);	
	}
return $result;
}
//******************************************************
function SelectValueByWhere($table,$value,$where)
//******************************************************
{
$rs = mysql_query('select '.$value.' from '.$table.' where '.$where);
if (mysql_num_rows($rs)==0)
	$result=-1;
else
	{
	$rec = mysql_fetch_array($rs, MYSQL_ASSOC);
	$result=$rec{$value};	
	mysql_free_result($rs);	
	}
return $result;
}
?>	

 