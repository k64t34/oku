<?php 
error_reporting (2047);
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
$sql = 'SELECT * FROM firm WHERE id='.$idFirm;
$rs = mysql_query($sql);
$rec = mysql_fetch_array($rs, MYSQL_ASSOC);

$Firm_Name=$rec{'name'};  
$firmGeneration=$rec{'generation'};
$mySQLdate=myDatePHPtoMySQL(myDateVBtoPHP($date));

$sql='SELECT plan,fact,round(sum_deviation,0) as  sum_deviation FROM FirmShowing WHERE idFirm='.$idFirm.' AND date=\''.$mySQLdate.'\'';
$rs = mysql_query($sql);
$DataExist=mysql_num_rows($rs);
?>
<HTML><HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Content-Language" content="ru">
<link rel="stylesheet" type="text/css" href="/oku.css">
<TITLE>Диаграмма</TITLE>
</HEAD>
<BODY>
<h2>Предварительные фактические стоимостные отклонения по <?=$firmGeneration==1?'выработке':'потреблению'?> электроэнергии</h2>

<p><font color="#FFFF00"><b><?=myDate(myDateVBtoPHP($date))?> <?=$Firm_Name?></b></font>

<a href="chartshowing.php?Date=<?=$date-1?>&firm=<?=$idFirm?>"><IMG SRC="images/previos.bmp" BORDER="0" ALT="назад" align="left"></a>
<a href="window.php"><IMG SRC="images/Calendar.bmp" BORDER="0" ALT="Витрина" align="left"></a>
<a href="chartshowing.php?Date=<?=$date+1?>&firm=<?=$idFirm?>"><IMG SRC="images/next.bmp" BORDER="0" ALT="вперед" align="left"></a>
<A HREF="datashowing.php?Date=<?=$date?>&firm=<?=$idFirm?>"><IMG SRC="images/table.bmp" BORDER="0" ALT="Таблица" align="left"></A></p><br>
<?if (!$DataExist)
	{
	?><font color="#FF5050">Нет данных на <?=myDate(myDateVBtoPHP($date))?> по <?=$Firm_Name?></font><?
	exit;
	}
?>
<object classid="clsid:0002E556-0000-0000-C000-000000000046" id="ChartSpace1" width="100%" height="100%">
  <param name="ScreenUpdating" value="-1">
  <param name="EnableEvents" value="-1">
  <param name="XMLData" value="&lt;xml xmlns:x=&quot;urn:schemas-microsoft-com:office:excel&quot;&gt;
 &lt;x:ChartSpace&gt;
  &lt;x:OWCVersion&gt;10.0.0.2720         &lt;/x:OWCVersion&gt;
  &lt;x:Width&gt;23574&lt;/x:Width&gt;
  &lt;x:Height&gt;14367&lt;/x:Height&gt;
  &lt;x:FormatValue&gt;
   &lt;x:DataSourceIndex&gt;-3&lt;/x:DataSourceIndex&gt;
   &lt;x:Data&gt;2&lt;/x:Data&gt;
  &lt;/x:FormatValue&gt;
  &lt;x:DisplayFieldList/&gt;
  &lt;x:NoGrouping/&gt;
  &lt;x:NoFiltering/&gt;
  &lt;x:Palette&gt;
   &lt;x:Entry&gt;#000000&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#000000&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#000000&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#000000&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#000000&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#000000&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#000000&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#000000&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#000000&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#000000&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#000000&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#000000&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#000000&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#000000&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#000000&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#000000&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#8080FF&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#802060&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#FFFFA0&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#A0E0E0&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#600080&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#FF8080&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#008080&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#C0C0FF&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#000080&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#FF00FF&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#80FFFF&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#0080FF&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#FF8080&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#C0FF80&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#FFC0FF&lt;/x:Entry&gt;
   &lt;x:Entry&gt;#FF80FF&lt;/x:Entry&gt;
  &lt;/x:Palette&gt;
  &lt;x:DefaultFont&gt;Arial&lt;/x:DefaultFont&gt;
  &lt;x:Border&gt;
   &lt;x:ColorIndex&gt;None&lt;/x:ColorIndex&gt;
  &lt;/x:Border&gt;
  &lt;x:Chart&gt;
   &lt;x:PlotArea&gt;
    &lt;x:Interior&gt;
     &lt;x:ColorIndex&gt;None&lt;/x:ColorIndex&gt;
     &lt;x:FillEffect&gt;
      &lt;x:fill x:type=&quot;Solid&quot; x:color=&quot;#000000&quot;/&gt;
     &lt;/x:FillEffect&gt;
    &lt;/x:Interior&gt;
    &lt;x:Graph&gt;
     &lt;x:SubType&gt;Clustered&lt;/x:SubType&gt;
     &lt;x:Type&gt;Column&lt;/x:Type&gt;
     &lt;x:Series&gt;
      &lt;x:Interior&gt;
       &lt;x:Color&gt;#FFC0CB&lt;/x:Color&gt;
       &lt;x:FillEffect&gt;
        &lt;x:fill x:type=&quot;gradient&quot; x:color=&quot;#FFC0CB&quot; x:color2=&quot;#FFE4E1&quot; x:angle=&quot;0&quot;
         focusposition=&quot;0,0&quot; focus=&quot;100%&quot;/&gt;
       &lt;/x:FillEffect&gt;
      &lt;/x:Interior&gt;
      &lt;x:FormatMap&gt;
      &lt;/x:FormatMap&gt;
      &lt;x:Name&gt;Отклонения (руб)&lt;/x:Name&gt;
      &lt;x:Caption&gt;
       &lt;x:DataSourceIndex&gt;-1&lt;/x:DataSourceIndex&gt;
       &lt;x:Data&gt;&amp;quot;Отклонения (руб)&amp;quot;&lt;/x:Data&gt;
      &lt;/x:Caption&gt;
      &lt;x:Index&gt;2&lt;/x:Index&gt;
      &lt;x:Category&gt;
       &lt;x:DataSourceIndex&gt;-1&lt;/x:DataSourceIndex&gt;
       &lt;x:Data&gt;{&amp;quot;1&amp;quot;,&amp;quot;2&amp;quot;,&amp;quot;3&amp;quot;,&amp;quot;4&amp;quot;,&amp;quot;5&amp;quot;,&amp;quot;6&amp;quot;,&amp;quot;7&amp;quot;,&amp;quot;8&amp;quot;,&amp;quot;9&amp;quot;,&amp;quot;10&amp;quot;,&amp;quot;11&amp;quot;,&amp;quot;12&amp;quot;,&amp;quot;14&amp;quot;,&amp;quot;15&amp;quot;,&amp;quot;16&amp;quot;,&amp;quot;17&amp;quot;,&amp;quot;18&amp;quot;,&amp;quot;19&amp;quot;,&amp;quot;20&amp;quot;,&amp;quot;21&amp;quot;,&amp;quot;22&amp;quot;,&amp;quot;23&amp;quot;,&amp;quot;0&amp;quot;}&lt;/x:Data&gt;
      &lt;/x:Category&gt;
      &lt;x:Value&gt;
       &lt;x:DataSourceIndex&gt;-1&lt;/x:DataSourceIndex&gt;
       &lt;x:Data&gt;{<?php
		$i=1;
		mysql_data_seek($rs,0);
		for ($i=1;$i!=23;$i++)
			{
			$rec = mysql_fetch_array($rs, MYSQL_ASSOC);
			echo $rec{'sum_deviation'},','; 
			}
		$rec = mysql_fetch_array($rs, MYSQL_ASSOC);
		echo $rec{'sum_deviation'}; 
	  ?>}&lt;/x:Data&gt;
      &lt;/x:Value&gt;
      &lt;x:DataLabels&gt;
       &lt;x:Border&gt;
        &lt;x:ColorIndex&gt;None&lt;/x:ColorIndex&gt;
       &lt;/x:Border&gt;
       &lt;x:ShowValue/&gt;
       &lt;x:Separator&gt;;&lt;/x:Separator&gt;
       &lt;x:Position&gt;OutsideEnd&lt;/x:Position&gt;
      &lt;/x:DataLabels&gt;
      &lt;x:Marker&gt;
      &lt;/x:Marker&gt;
      &lt;x:Explode&gt;0&lt;/x:Explode&gt;
      &lt;x:Thickness&gt;10&lt;/x:Thickness&gt;
     &lt;/x:Series&gt;
     &lt;x:Dimension&gt;
      &lt;x:ScaleID&gt;29175104&lt;/x:ScaleID&gt;
      &lt;x:Index&gt;Categories&lt;/x:Index&gt;
     &lt;/x:Dimension&gt;
     &lt;x:Dimension&gt;
      &lt;x:ScaleID&gt;29175324&lt;/x:ScaleID&gt;
      &lt;x:Index&gt;Value&lt;/x:Index&gt;
     &lt;/x:Dimension&gt;
     &lt;x:Overlap&gt;0&lt;/x:Overlap&gt;
     &lt;x:GapWidth&gt;150&lt;/x:GapWidth&gt;
     &lt;x:FirstSliceAngle&gt;0&lt;/x:FirstSliceAngle&gt;
    &lt;/x:Graph&gt;
    &lt;x:Graph&gt;
     &lt;x:Type&gt;Line&lt;/x:Type&gt;
     &lt;x:SubType&gt;Stacked&lt;/x:SubType&gt;
     &lt;x:SubType&gt;Marker&lt;/x:SubType&gt;
     &lt;x:Series&gt;
      &lt;x:Border&gt;
       &lt;x:Color&gt;#0000FF&lt;/x:Color&gt;
       &lt;x:Weight&gt;0&lt;/x:Weight&gt;
       &lt;x:LineStyle&gt;Solid&lt;/x:LineStyle&gt;
      &lt;/x:Border&gt;
      &lt;x:Line&gt;
       &lt;x:Color&gt;#0000FF&lt;/x:Color&gt;
       &lt;x:Weight&gt;3&lt;/x:Weight&gt;
       &lt;x:LineStyle&gt;Solid&lt;/x:LineStyle&gt;
      &lt;/x:Line&gt;
      &lt;x:Interior&gt;
       &lt;x:Color&gt;#6495ED&lt;/x:Color&gt;
       &lt;x:FillEffect&gt;
        &lt;x:fill x:type=&quot;gradient&quot; x:color=&quot;#6495ED&quot; color2=&quot;fill darken(204)&quot;
         x:angle=&quot;0&quot; focusposition=&quot;0,0&quot; focus=&quot;100%&quot;/&gt;
       &lt;/x:FillEffect&gt;
      &lt;/x:Interior&gt;
      &lt;x:FormatMap&gt;
      &lt;/x:FormatMap&gt;
      &lt;x:Name&gt;План(квт*ч)&lt;/x:Name&gt;
      &lt;x:Caption&gt;
       &lt;x:DataSourceIndex&gt;-1&lt;/x:DataSourceIndex&gt;
       &lt;x:Data&gt;&amp;quot;План(квт*ч)&amp;quot;&lt;/x:Data&gt;
      &lt;/x:Caption&gt;
      &lt;x:Index&gt;0&lt;/x:Index&gt;
      &lt;x:Category&gt;
       &lt;x:DataSourceIndex&gt;-1&lt;/x:DataSourceIndex&gt;
       &lt;x:Data&gt;{&amp;quot;1&amp;quot;,&amp;quot;2&amp;quot;,&amp;quot;3&amp;quot;,&amp;quot;4&amp;quot;,&amp;quot;5&amp;quot;,&amp;quot;6&amp;quot;,&amp;quot;7&amp;quot;,&amp;quot;8&amp;quot;,&amp;quot;9&amp;quot;,&amp;quot;10&amp;quot;,&amp;quot;11&amp;quot;,&amp;quot;12&amp;quot;,&amp;quot;14&amp;quot;,&amp;quot;15&amp;quot;,&amp;quot;16&amp;quot;,&amp;quot;17&amp;quot;,&amp;quot;18&amp;quot;,&amp;quot;19&amp;quot;,&amp;quot;20&amp;quot;,&amp;quot;21&amp;quot;,&amp;quot;22&amp;quot;,&amp;quot;23&amp;quot;,&amp;quot;0&amp;quot;}&lt;/x:Data&gt;
      &lt;/x:Category&gt;
      &lt;x:Value&gt;
       &lt;x:DataSourceIndex&gt;-1&lt;/x:DataSourceIndex&gt;
       &lt;x:Data&gt;{<?php
		$i=1;
		mysql_data_seek($rs,0);
		for ($i=1;$i!=23;$i++)
			{
			$rec = mysql_fetch_array($rs, MYSQL_ASSOC);
			echo $rec{'plan'},','; 
			}
		$rec = mysql_fetch_array($rs, MYSQL_ASSOC);
		echo $rec{'plan'}; 
	  ?>}&lt;/x:Data&gt;
      &lt;/x:Value&gt;
      &lt;x:Explode&gt;0&lt;/x:Explode&gt;
      &lt;x:Thickness&gt;10&lt;/x:Thickness&gt;
     &lt;/x:Series&gt;
     &lt;x:Dimension&gt;
      &lt;x:ScaleID&gt;29175104&lt;/x:ScaleID&gt;
      &lt;x:Index&gt;Categories&lt;/x:Index&gt;
     &lt;/x:Dimension&gt;
     &lt;x:Dimension&gt;
      &lt;x:ScaleID&gt;29175324&lt;/x:ScaleID&gt;
      &lt;x:Index&gt;Value&lt;/x:Index&gt;
     &lt;/x:Dimension&gt;
     &lt;x:Overlap&gt;100&lt;/x:Overlap&gt;
     &lt;x:GapWidth&gt;150&lt;/x:GapWidth&gt;
     &lt;x:FirstSliceAngle&gt;0&lt;/x:FirstSliceAngle&gt;
    &lt;/x:Graph&gt;
    &lt;x:Graph&gt;
     &lt;x:Type&gt;Line&lt;/x:Type&gt;
     &lt;x:SubType&gt;Standard&lt;/x:SubType&gt;
     &lt;x:SubType&gt;Marker&lt;/x:SubType&gt;
     &lt;x:Series&gt;
      &lt;x:Border&gt;
       &lt;x:Color&gt;#228B22&lt;/x:Color&gt;
      &lt;/x:Border&gt;
      &lt;x:Line&gt;
       &lt;x:Color&gt;#008000&lt;/x:Color&gt;
       &lt;x:Weight&gt;3&lt;/x:Weight&gt;
       &lt;x:LineStyle&gt;Solid&lt;/x:LineStyle&gt;
      &lt;/x:Line&gt;
      &lt;x:Interior&gt;
       &lt;x:Color&gt;#D9F9D9&lt;/x:Color&gt;
       &lt;x:FillEffect&gt;
        &lt;x:fill x:type=&quot;gradient&quot; x:color=&quot;#D9F9D9&quot; color2=&quot;fill darken(214)&quot;
         x:angle=&quot;0&quot; focusposition=&quot;0,0&quot; focus=&quot;100%&quot;/&gt;
       &lt;/x:FillEffect&gt;
      &lt;/x:Interior&gt;
      &lt;x:FormatMap&gt;
      &lt;/x:FormatMap&gt;
      &lt;x:Name&gt;Факт(квт*ч)&lt;/x:Name&gt;
      &lt;x:Caption&gt;
       &lt;x:DataSourceIndex&gt;-1&lt;/x:DataSourceIndex&gt;
       &lt;x:Data&gt;&amp;quot;Факт(квт*ч)&amp;quot;&lt;/x:Data&gt;
      &lt;/x:Caption&gt;
      &lt;x:Index&gt;1&lt;/x:Index&gt;
      &lt;x:Category&gt; &lt;x:DataSourceIndex&gt;-1&lt;/x:DataSourceIndex&gt;&lt;x:Data&gt;{&amp;quot;1&amp;quot;,&amp;quot;2&amp;quot;,&amp;quot;3&amp;quot;,&amp;quot;4&amp;quot;,&amp;quot;5&amp;quot;,&amp;quot;6&amp;quot;,&amp;quot;7&amp;quot;,&amp;quot;8&amp;quot;,&amp;quot;9&amp;quot;,&amp;quot;10&amp;quot;,&amp;quot;11&amp;quot;,&amp;quot;12&amp;quot;,&amp;quot;14&amp;quot;,&amp;quot;15&amp;quot;,&amp;quot;16&amp;quot;,&amp;quot;17&amp;quot;,&amp;quot;18&amp;quot;,&amp;quot;19&amp;quot;,&amp;quot;20&amp;quot;,&amp;quot;21&amp;quot;,&amp;quot;22&amp;quot;,&amp;quot;23&amp;quot;,&amp;quot;0&amp;quot;}&lt;/x:Data&gt;
      &lt;/x:Category&gt;
      &lt;x:Value&gt;
       &lt;x:DataSourceIndex&gt;-1&lt;/x:DataSourceIndex&gt;
       &lt;x:Data&gt;{<?php
		$i=1;
		mysql_data_seek($rs,0);
		for ($i=1;$i!=23;$i++)
			{
			$rec = mysql_fetch_array($rs, MYSQL_ASSOC);
			echo $rec{'fact'},','; 
			}
		$rec = mysql_fetch_array($rs, MYSQL_ASSOC);
		echo $rec{'fact'};		?>}&lt;/x:Data&gt;
      &lt;/x:Value&gt;
      &lt;x:Explode&gt;0&lt;/x:Explode&gt;
      &lt;x:Thickness&gt;10&lt;/x:Thickness&gt;
     &lt;/x:Series&gt;
     &lt;x:Dimension&gt;
      &lt;x:ScaleID&gt;29175104&lt;/x:ScaleID&gt;
      &lt;x:Index&gt;Categories&lt;/x:Index&gt;
     &lt;/x:Dimension&gt;
     &lt;x:Dimension&gt;
      &lt;x:ScaleID&gt;29175324&lt;/x:ScaleID&gt;
      &lt;x:Index&gt;Value&lt;/x:Index&gt;
     &lt;/x:Dimension&gt;
     &lt;x:Overlap&gt;100&lt;/x:Overlap&gt;
     &lt;x:GapWidth&gt;150&lt;/x:GapWidth&gt;
     &lt;x:FirstSliceAngle&gt;0&lt;/x:FirstSliceAngle&gt;
    &lt;/x:Graph&gt;
    &lt;x:Axis&gt;
     &lt;x:AxisID&gt;29212532&lt;/x:AxisID&gt;
     &lt;x:ScaleID&gt;29175104&lt;/x:ScaleID&gt;
     &lt;x:Type&gt;Category&lt;/x:Type&gt;
     &lt;x:MajorTick&gt;Outside&lt;/x:MajorTick&gt;
     &lt;x:MinorTick&gt;None&lt;/x:MinorTick&gt;
     &lt;x:Placement&gt;Bottom&lt;/x:Placement&gt;
     &lt;x:GroupingEnum&gt;Auto&lt;/x:GroupingEnum&gt;
    &lt;/x:Axis&gt;
    &lt;x:Axis&gt;
     &lt;x:AxisID&gt;29213004&lt;/x:AxisID&gt;
     &lt;x:ScaleID&gt;29175324&lt;/x:ScaleID&gt;
     &lt;x:Type&gt;Value&lt;/x:Type&gt;
     &lt;x:MajorGridlines&gt;
      &lt;x:Line&gt;
       &lt;x:Weight&gt;1&lt;/x:Weight&gt;
       &lt;x:LineStyle&gt;Dot&lt;/x:LineStyle&gt;
      &lt;/x:Line&gt;
     &lt;/x:MajorGridlines&gt;
     &lt;x:MajorTick&gt;Outside&lt;/x:MajorTick&gt;
     &lt;x:MinorTick&gt;None&lt;/x:MinorTick&gt;
     &lt;x:Placement&gt;Left&lt;/x:Placement&gt;
    &lt;/x:Axis&gt;
   &lt;/x:PlotArea&gt;
  &lt;/x:Chart&gt;
  &lt;x:Legend&gt;
   &lt;x:Interior&gt;
    &lt;x:ColorIndex&gt;None&lt;/x:ColorIndex&gt;
    &lt;x:FillEffect&gt;
     &lt;x:fill x:type=&quot;Solid&quot; x:color=&quot;#000000&quot;/&gt;
    &lt;/x:FillEffect&gt;
   &lt;/x:Interior&gt;
   &lt;x:Border&gt;
    &lt;x:ColorIndex&gt;None&lt;/x:ColorIndex&gt;
    &lt;x:Weight&gt;1&lt;/x:Weight&gt;
   &lt;/x:Border&gt;
   &lt;x:Placement&gt;Bottom&lt;/x:Placement&gt;
  &lt;/x:Legend&gt;
  &lt;x:Scaling&gt;
   &lt;x:ScaleID&gt;29175104&lt;/x:ScaleID&gt;
  &lt;/x:Scaling&gt;
  &lt;x:Scaling&gt;
   &lt;x:ScaleID&gt;29175324&lt;/x:ScaleID&gt;
  &lt;/x:Scaling&gt;
 &lt;/x:ChartSpace&gt;
&lt;/xml&gt;">
</object>




</BODY>
</HTML>


