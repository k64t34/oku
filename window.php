<?php
ini_set('include_path','/home/home1/oku/');
include_once 'inc/login.php'; 
include_once 'inc/Calendar.php'; 
Calendar_Proc();
?>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Content-Language" content="ru">
<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<link rel="stylesheet" type="text/css" href="oku.css">
</head><body >
<h2>Витрина</h2>
<p>
<form method="POST" action="datashowing.php" name="F1">
<table><tr>
<td>    
<?Calendar('Date',isset($_SESSION['user_choice_date'])?$_SESSION['user_choice_date']:0,'class="fld_Btm"')?>
</td>
<td>
<select size="1" name="firm" class="fld_Btm">

<?php  
include("inc/OpenDB.php"); 

$sql = 'SELECT * FROM firm';
if (!$_SESSION['Admin_right'] AND $_SESSION['idUserFirm']!=0)
	$sql=$sql.' WHERE id='.$_SESSION['idUserFirm'];

$rs = mysql_query($sql);   
while ($rec = mysql_fetch_array($rs, MYSQL_ASSOC)) 
{?><option value="<?=$rec{"id"}?>"<?if ($_SESSION['user_choice_firm']==$rec{'id'}) echo " selected " ;?>><?=$rec{"name"}?></option>

<?php
}  
mysql_free_result($rs);

?> 
</select>
</td>
<td>
<input type="submit" value="    OK     " name="B1" class="fld_Btm">
<!--onclick="alert(document.forms['F1'].Date.value);" -->
<INPUT TYPE="hidden" name="access" value="<?
if ($_SESSION['Admin_right']==1) 
	echo '0';
else
	if ($_SESSION['idUserFirm']==0)
		echo '1';
	else
		if ($_SESSION['access']==1)
			echo '1';
		else
			echo '0';?>">
</td>
</form></p>
</tr></table>

<?
/*$s=array(
		'idFirm'		=>$_SESSION['Admin_right']? $_SESSION['user_choice_firm']:$_SESSION['idUserFirm'],
		'plan'			=>0 ,
		'fact'			=>0 ,
		'deviation_int'	=>0 ,
		'deviation_ext'	=>0 ,
		'time'			=>0
		);

	include($_SERVER["DOCUMENT_ROOT"]."/showFirmTarif.php"); */
include("inc/CloseDB.php"); 
?>
</body></html>


