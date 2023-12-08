//
//(c) SkorikTinySoft 2004 skorikone@yandex.ru
//
//******************************************************************************
function SetCalendar(){
//******************************************************************************
var strActiveElement=document.activeElement.name;
var oCalendar=document.activeElement.parentElement;
var oDay = oCalendar.children("day");
var oMonth = oCalendar.children("month").selectedIndex;
var oYear = oCalendar.children("year").value;
if (strActiveElement.localeCompare("day")!=0)	{		
	var tmpDate=new Date(Number(oYear)+(oMonth==11?1:0),oMonth==11?0:oMonth+1,1);	
	var tmpDate2=new Date(Number(tmpDate.valueOf()-24*60*60*1000));
	var DaysInMonth=tmpDate2.getDate()-1;	
	if (oDay.selectedIndex>DaysInMonth)
		oDay.selectedIndex=DaysInMonth;			
	if (oDay.length>DaysInMonth+1)
		for (i=oDay.length-1;i>DaysInMonth;i--)
			oDay.remove(i);
	else 
		for (i=oDay.length;i<=DaysInMonth;i++)			{
			var oOption = document.createElement("OPTION");
			oOption.innerText = Number(i+1);
			oDay.options.appendChild(oOption);
			}
	}
var date=new Date(oYear,oMonth,oDay.selectedIndex+1)
oCalendar.children(0).value=Math.ceil((date.valueOf()/1000+2209172400)/86400);
}
