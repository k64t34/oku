<?php
//*****************************************************************************
function Calendar_Proc()
//*****************************************************************************
{echo '<script LANGUAGE="JScript" type="text/javascript" src="/inc/calendar.js"></script>';}


//*****************************************************************************
function Calendar($fldName="date",$VBdate=0,$TableTagAttr='')
//*****************************************************************************
{
if ($VBdate==0) 
	$VBdate=myDatePHPtoVB(Now());
$phpdate=myDateVBtoPHP($VBdate);
$d=myDay($phpdate);
$m=myMonth($phpdate);
$y=myYear($phpdate);
echo "<table border=1 $TableTagAttr><tr><td>";
echo '<input type="hidden" name="'.$fldName.'" value="'.$VBdate.'">';
echo '<select size="1" name="day" onchange="SetCalendar();">';
for ($i=1;$i<=myLastDay($phpdate);$i++)
	{
	echo '<option';
	if ($d==$i)
		echo ' selected';
	echo '>'.$i.'</option>';
	}
echo '</select>';
echo '<select size="1" name="month" onchange=SetCalendar()>';
for ($i=1;$i<=12;$i++)
	{
	echo '<option';
	if ($m==$i)
		echo ' selected';
	echo '>'.myMonthName($i).'</option>';
	}
echo '</select>';
echo '<input type="text" name="year" size="4" value="'.$y.'" onchange=SetCalendar()>';
echo '</td></tr></table>';
}
?>