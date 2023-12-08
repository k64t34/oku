<SCRIPT LANGUAGE="VBScript">
<!--
'*****************************************************************************
Function Forma_OnSubmit
'*****************************************************************************
Forma_OnSubmit=True
if MyIsEmptyString(Forma.firmName.value) then 
	Forma_OnSubmit=False
	msgbox "Заполните наименование фирмы",vbOKOnly+vbCritical, "О Ш И Б К А"  
End if 
end Function
'*****************************************************************************
Sub firmGeneration__onclick
'*****************************************************************************
Forma.firmControl(0).disabled = Forma.firmGeneration(0).checked
Forma.firmControl(1).disabled = Forma.firmGeneration(0).checked
tr_control.disabled = Forma.firmGeneration(0).checked
if Forma.firmGeneration(0).checked then
	t1.innerHTML="<b>Тариф на электроэнергию MAX(руб./МВт·ч)</b>"
else
	t1.innerHTML="<b>Тариф на электроэнергию(руб./МВт·ч)</b>"
end if

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
<h2>Профиль субъекта</h2>

<?php
include_once $_SERVER["DOCUMENT_ROOT"].'/inc/isAdmin.php'; 
?><form name="Forma" method="POST"  action="FirmSave.php"><?
$name='';
$code='';
$k_norm_deviation=0;
$firmGeneration=0;
$price_fek=0;
$control=0;
if (isset($_GET['id']))
	{	
	$sql = 'SELECT * FROM firm WHERE id='.$_GET['id'];
	$rs_firm	= mysql_query($sql);
	if (mysql_num_rows($rs_firm))
		{
		?><input type="hidden" name ="id" value ="<?=$_GET['id']?>"><?
		$rec_firm = mysql_fetch_array($rs_firm, MYSQL_ASSOC);
		$name=$rec_firm{'name'};
		$name=htmlspecialchars($name,ENT_QUOTES);		
		$code=$rec_firm{'code'};
		$k_norm_deviation=$rec_firm{'k_norm_deviation'};
		$firmGeneration=$rec_firm{'generation'};		
		$price_em=$rec_firm{'price_em'};
		$price_e=$rec_firm{'price_e'};
		$price_max=$rec_firm{'price_max'};
		$control=$rec_firm{'control'};
		$publish=$rec_firm{'publish'};
		}	
	}
?>
<table border="0" cellpadding="4" width="100%" cellspacing="4">
  <tr>
    <td width="50%" align="right"><b>Наименование</b></td>
    <td width="50%">
      <input type="text" name="firmName" size="32" class="fld_Edit" value="<?=$name?>"></td>
  </tr>
  <tr>
    <td width="50%" align="right"><b>Код</b></td>
    <td width="50%">
      <input type="text" name="firmCode" size="32" class="fld_Edit" value="<?=$code?>"></td>
  </tr>
  <tr>
    <td width="50%" align="right"><b>Публиковать</b></td>
    <td width="50%">
	<INPUT TYPE="checkbox" NAME="publish"<?=$publish<>0?' checked':''?>></td>
  </tr>

  <tr>
    <td width="50%" align="right"><b>Коэф. нормативное отклонение, %</b></td>
    <td width="50%">
      <input type="text" name="k_norm_deviation" size="4" class="fld_Edit" value="<?=$k_norm_deviation?>"></td>
  </tr>
  <tr>
    <td width="50%" align="right"><b>Тариф на электроэнергию с учетом мощности(руб./МВт·ч)</b></td>
    <td width="50%">
      <input type="text" name="price_em" size="10" class="fld_Edit" value="<?=$price_em?>"></td>
  </tr>
  <tr>
    <td id="t1" width="50%" align="right"><b><?=$firmGeneration?'Тариф на электроэнергию MAX (руб./МВт·ч)':'Тариф на электроэнергию(руб./МВт·ч)'?></b></td>
    <td width="50%">
      <input type="text" name="price_e" size="10" class="fld_Edit" value="<?=$firmGeneration?$price_max:$price_e?>"></td>
  </tr>

  <tr>
    <td width="50%" align="right"><b></b></td>
    <td width="50%">
      <input type="radio" value="1" name="firmGeneration" <?=$firmGeneration?' checked ':''?> onclick=firmGeneration__onclick>Генерация
      <input type="radio" value="0" name="firmGeneration" <?=!$firmGeneration?' checked ':''?> onclick=firmGeneration__onclick>Потребление

      </td>
  </tr>
  <tr id="tr_control" <?=$firmGeneration?' DISABLED ':''?> >
    <td width="50%" align="right"><b>Регулируемый</b></td>
    <td width="50%">
      <input type="radio" value="1" name="firmControl" <?=$control?' checked ':''?> <?=$firmGeneration?' DISABLED ':''?>>Да
      <input type="radio" value="0" name="firmControl" <?=!$control?' checked ':''?> <?=$firmGeneration?' DISABLED ':''?> >Нет

      </td>
  </tr>

</table>

<p align="center"> <input type="submit" value="        Cохранить        " name="OK" class="fld_Btm"> </p>
</form>
<?if (isset($_GET['id']))
	{?>
	<!--<a href="tarif_deviationEdit.php?id=<?=$HTTP_GET_VARS['id']?>">Тариф за отклонение</a><br>--><?
	$s=array(
		'idFirm'		=>$_GET['id'],
		'plan'			=>0 ,
		'fact'			=>0 ,
		'deviation_int'	=>0 ,
		'deviation_ext'	=>0 ,
		'time'			=>0
		);

	include($_SERVER["DOCUMENT_ROOT"]."/showFirmTarif.php"); 
	}
include_once $_SERVER["DOCUMENT_ROOT"].'/inc/CloseDB.php';
?>
</body></html>
