<SCRIPT LANGUAGE="VBScript">
<!--
function btm_onMoseOver
window.event.srcElement.classname="menu_Btm_mouseOver" 
end function 

function btm_onMoseOut
window.event.srcElement.classname="menu_Btm" 
end function 
-->
</script>
<head><meta http-equiv="Content-Language" content="ru">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<base target="contents">
<link rel="stylesheet" type="text/css" href="oku.css">
</head>
<body bgcolor="#000080" topmargin="0" leftmargin="0" style="background-image: url('images/background2.gif')" >
<input type="button" value=" О нас    " name="B1" class="menu_Btm" onmouseover="btm_onMoseOver()" onmouseout="btm_onMoseOut()" onclick=parent.main.navigate("about.htm")  >
<input type="button" value=" Информация " name="B2" class="menu_Btm" onmouseover="btm_onMoseOver()" onmouseout="btm_onMoseOut()" onclick=parent.main.navigate("info.htm") >
<input type="button" value=" Услуги   " name="B3" class="menu_Btm" onmouseover="btm_onMoseOver()" onmouseout="btm_onMoseOut()" onclick=parent.main.navigate("services.htm") >
<input type="button" value=" Витрина  " name="B4" class="menu_Btm" onmouseover="btm_onMoseOver()" onmouseout="btm_onMoseOut()" onclick=parent.main.navigate("window.php") >
<input type="button" value=" Контакты " name="B5" class="menu_Btm" onmouseover="btm_onMoseOver()" onmouseout="btm_onMoseOut()" onclick=parent.main.navigate("contacts.htm") >	
<input type="button" value=" Обратная связь " name="B6" class="menu_Btm" onmouseover="btm_onMoseOver()" onmouseout="btm_onMoseOut()" onclick=parent.main.navigate("feedback.php") >	
<?php

//session_start();
if ($_SESSION['Admin_right']==1)
{?>
<input type="button" value=" Администрирование " name="B7" class="menu_Btm" onmouseover="btm_onMoseOver()" onmouseout="btm_onMoseOut()" onclick=parent.main.navigate("http://oku.megalog.ru/admin") >	
<?;}?>

</body></html>