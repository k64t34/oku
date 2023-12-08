<?php
//*****************************************************************************
function myFillColorScript($C0,$Ccnt,$R0,$Rcnt,$Cclr,$Rclr,$A0=1)
//*****************************************************************************
{
$Cmax=$C0+$Ccnt-1;
$Rmax=$R0+$Rcnt-1;
echo "<SCRIPT LANGUAGE=\"VBScript\"><!--
'--------------------------------------------------------------------
sub myFillColor
'--------------------------------------------------------------------
dim Cclr
dim Rclr
Cclr=array($Cclr)
Rclr=array($Rclr)
for r=$R0 to $Rmax
	for c=$C0 to $Cmax
t1.rows(r).cells(c).bgColor=myColorMix(Rclr(r-$R0),Cclr(c-$C0),mySliderScale(Slider1.Value))
	next 
next
end sub
'--------------------------------------------------------------------
Sub  Window_OnLoad
'--------------------------------------------------------------------
myFillColor
end sub
'--------------------------------------------------------------------
function mySliderScale(SliderValue)
'--------------------------------------------------------------------
if SliderValue=15 then 
	mySliderScale=100	
else
	if SliderValue<=10 then 
		mySliderScale=SliderValue/10
	else
		mySliderScale=SliderValue/10
	end if
end if
End Function
'--------------------------------------------------------------------
function myColorMix(color1,color2,ratio)
'--------------------------------------------------------------------
Dim c1(3)
Dim c2(3)
for i=1 to 3
	c1(i)=myHEXtoInt(mid(color1,(i-1)*2+1,2))
	c2(i)=myHEXtoInt(mid(color2,(i-1)*2+1,2))
	c1(i)=c1(i)-ratio/(1+ratio)*(c1(i)-c2(i))	
next
myColorMix=cstr(hex(c1(1)))+cstr(hex(c1(2)))+cstr(hex(c1(3)))
End Function

'--------------------------------------------------------------------
function myHEXtoInt(h)
'--------------------------------------------------------------------
Dim d
d=array(\"0\",\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"A\",\"B\",\"C\",\"D\",\"E\",\"F\")
myHEXtoInt=0
p=0
for i= len(h) to 1 step -1
	c=UCase(mid(h,i,1)	)
	for j=1 to 15
		if d(j)=c then
			Exit For
		end if
	next
	if j=16 then
		j=0
	end if
	myHEXtoInt=myHEXtoInt+16^p*j
	p=p+1
next

End Function

-->
</SCRIPT>
";
}

//*****************************************************************************
function myFillColorControl()
//*****************************************************************************
{
echo '<div style="border-style: solid; border-width: 1">
Настройка подсветки
<table><tr><td>
<object classid="clsid:F08DF954-8592-11D1-B16A-00C0F0283628" 
	id="Slider1" 
	name="Slider1" 
	width="256" 
	height="32"	
	>
  <param name="_ExtentX" value="2646">
  <param name="_ExtentY" value="1323">
  <param name="_Version" value="393216">
  <param name="BorderStyle" value="0">
  <param name="MousePointer" value="0">
  <param name="Enabled" value="1">
  <param name="OLEDropMode" value="0">
  <param name="Orientation" value="0">
  <param name="LargeChange" value="2">
  <param name="SmallChange" value="1">
  <param name="Min" value="1">
  <param name="Max" value="15">
  <param name="SelectRange" value="0">
  <param name="SelStart" value="1">
  <param name="SelLength" value="1">
  <param name="TickStyle" value="0">
  <param name="TickFrequency" value="1">
  <param name="Value" value="15">
  <param name="TextPosition" value="0">
</object>
</td><td>
<input type="button" value="Применить" onclick="myFillColor" class="fld_Btm">
</td></tr></table></div>';
}
?>