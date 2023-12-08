<SCRIPT LANGUAGE="VBScript">
<!--
'*****************************************************************************
Function Forma_OnSubmit
'*****************************************************************************
Forma_OnSubmit=True
Forma.AllFirms.DISABLED=False
Forma.access.DISABLED=False

if MyIsEmptyString(Forma.UserName.value) then 
	Forma_OnSubmit=False
	msgbox "Заполните имя пользователя",vbOKOnly+vbCritical, "О Ш И Б К А"  
End if 

if Forma.UserPassword.value<>Forma.UserPassword2.value then 
	Forma_OnSubmit=False
	msgbox "Не совпадают пароль и подтверждение пароля",vbOKOnly+vbCritical, "О Ш И Б К А"  
End if 
if Forma.id.value="" AND MyIsEmptyString(Forma.UserPassword) Then
	Forma_OnSubmit=False
	msgbox "Введите пароль пользователя",vbOKOnly+vbCritical, "О Ш И Б К А"  
end if 
end Function
'*****************************************************************************
Sub UserAdmin_onClick
'*****************************************************************************
if Forma.UserAdmin.checked then 
	Forma.AllFirms.checked=True
end if 
AllFirms_onClick
Forma.AllFirms.DISABLED=Forma.UserAdmin.checked
if Forma.UserAdmin.checked then 
	Forma.access.checked=False
end if 

end sub 

'*****************************************************************************
Sub AllFirms_onClick
'*****************************************************************************
Forma.UserFirm.DISABLED=Forma.AllFirms.checked
if Forma.AllFirms.checked then 
	Forma.access.checked=Forma.AllFirms.checked
end if 
Forma.access.DISABLED=Forma.AllFirms.checked
end sub 

'*****************************************************************************
function MyIsEmptyString(str)
'*****************************************************************************
str=trim(str)
MyIsEmptyString = IsEmpty(str)  _ 
					OR IsNULL(str)  _ 
					OR str="" _ 
					OR Len(str)=0
End Function
--->
</SCRIPT>

<html>
<head>
<meta http-equiv="Content-Language" content="ru">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<link rel="stylesheet" type="text/css" href="../oku.css">
</head>
<body>
<h2>Профиль пользователя</h2>

<?php
ini_set('include_path','/home/home1/oku/');
include('inc/isAdmin.php'); 
?><form name="Forma" method="POST"  action="UserSave.php"><?
include("inc/OpenDB.php"); 

$name="";
$admin=0;
$idFirm=0;
$access=0;

if (isset($HTTP_GET_VARS['id']))
	{	
	$sql = 'SELECT * FROM user WHERE id='.$HTTP_GET_VARS['id'];
	$rs	= mysql_query($sql);
	if (mysql_num_rows($rs))
		{
		?><input type="hidden" name ="id" value ="<?=$HTTP_GET_VARS['id']?>"><?
		$rec = mysql_fetch_array($rs, MYSQL_ASSOC);
		$name=$rec{"name"};
		$admin=$rec{"admin"};
		$idFirm=$rec{"idFirm"};
		if ($idFirm==0 AND $admin==0)
			$access=1;
		else
			$access=$rec{"access"};
		}
	mysql_free_result($rs);
	}
?>
<table border="0" cellpadding="4" style="border-collapse: collapse" bordercolor="#111111" width="100%" cellspacing="4">
  <tr>
    <td width="50%" align="right"><b>Имя</b></td>
    <td width="50%">
      <input type="text" name="UserName" size="32" class="fld_Edit" value="<?=$name?>"></td>
  </tr>
  <tr>
    <td align="right"><b>Пароль</b></td>
    <td>
      <input type="password" name="UserPassword" size="32" class="fld_Edit"></td>
  </tr>
  <tr>
    <td align="right"><b>Повторить пароль</b></td>
    <td>
      <input type="password" name="UserPassword2" size="32" class="fld_Edit"></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><b>Администратор</b></td>
    <td>
    <input type="checkbox" name="UserAdmin" value="ON" class="fld_Edit"<?=$admin?' checked ':''?>>

	</td>
    <td width="50%">&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><b>Организация</b></td>
    <td>
    <input type="checkbox" name="AllFirms" value="ON" class="fld_Edit"<?=$idFirm==0?' checked ':''?> <?=$admin?' DISABLED ':''?>> Все<br>

	<select size="1" name="UserFirm" class="fld_Edit"<?=($idFirm==0 || $admin!=0)?' DISABLED ':''?>    	
    ><?php  

$sql = "SELECT * FROM firm";
$rs = mysql_query($sql);   
while ($rec = mysql_fetch_array($rs, MYSQL_ASSOC))
   {?>
   <option value="<?=$rec{"code"}?>" <?=($idFirm==$rec{"id"})?' selected ':''?>>
   <?=$rec{"name"}?>
   </option>

  <?php
  }  
mysql_free_result($rs);
include("inc/CloseDB.php"); 
?> 
	</select><br>
	 <input type="checkbox" name="access" value="ON" class="fld_Edit"<?=	 
	 $access==1?' checked ':''?> <?=($admin==1 OR $idFirm==0 )?' DISABLED ':''?> onclick="Forma.UserFirm.DISABLED=Forma.AllFirms.checked"> Защита от копирования<br>
	</td>
    <td></td>
  </tr>
</table>
 <p align="center"> <input type="submit" value="        OK        " name="OK" class="fld_Btm"> </p>
</form>
</body>

</html>