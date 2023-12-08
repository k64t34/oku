<SCRIPT LANGUAGE="VBScript">
<!--
'*****************************************************************************
Function F1_OnSubmit
'*****************************************************************************

F1_OnSubmit=NOT ( 	MyIsEmptyString(F1.Body.value) 	OR 	MyIsEmptyString(F1.FIO.value)	OR 	MyIsEmptyString(F1.email.value)	OR 	MyIsEmptyString(F1.firm.value)        )

if NOT F1_OnSubmit then 
	msgbox "Заполните все поля формы",vbOKOnly+vbCritical, "ОШИБКА"  
end if 

End Function 
'*****************************************************************************
function MyIsEmptyString(str)
'*****************************************************************************
str=trim(str)
MyIsEmptyString = IsEmpty(str)  _ 
					OR IsNULL(str)  _ 
					OR str="" _ 
					OR Len(str)=0
End Function

-->
</script>

<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Content-Language" content="ru">
<link rel="stylesheet" type="text/css" href="oku.css">


</head>
<body stylesrc="intro.htm" background="images/background1.bmp">

<?php 
if  ($_GET['err']==1)
{
?>
<h2><font color="#FF5050">При отправке сообщения возникли ошибки.</font><br>Проверьте сообщение и повторите отправку</h2>
<?
}
else
{
?>
<h2>Обратная связь</h2>
<?}?>

<form name="F1" method="POST" ACTION = "sendmail.php">
<p>
  <u>Пишите нам:</u></p>
  <table border="0" cellspacing="5" style="border-collapse: collapse" bordercolor="#111111" width="100%" id="AutoNumber1" cellpadding="5">
    <tr>
      <td width="22%" align="right">&nbsp;</td>
      <td width="22%" align="left">Ваше имя:</td>
      <td width="93%">
      <input type="text" name="fio" size="54"  class="fld_Edit" value="<?=$_GET["fio"]?>"></td>
    </tr>
    <tr>
      <td width="22%" align="right">&nbsp;</td>
      <td width="22%" align="left">Ваш e-mail:</td>
      <td width="93%">
      <input type="text" name="email" size="54" class="fld_Edit" value="<?=$_GET["email"]?>"></td>
    </tr>
    <tr>
      <td width="22%" align="right">&nbsp;</td>
      <td width="22%" align="left">Организация</td>
      <td width="93%"><input type="text" name="firm" size="54" class="fld_Edit" value="<?=$_GET["firm"]?>"></td>
    </tr>
    <tr>
      <td width="22%" align="right">&nbsp;</td>
      <td width="22%" align="left">Текст сообщения</td>
      <td width="93%"><textarea rows="7" name="body" cols="57" class="fld_Edit"><?=$_GET["body"]?></textarea></td>
    </tr>
  </table>
  <p align="center">
  <input type="submit" value="Отправить" name="Submit" class="fld_Btm"></p>
</form>
	</body></html>