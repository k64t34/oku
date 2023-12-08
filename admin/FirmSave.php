<?php
error_reporting (2047);

$_POST['publish']=isset($_POST['publish'])?1:0;
include_once $_SERVER["DOCUMENT_ROOT"].'/inc/isAdmin.php'; 
if ($_POST['firmGeneration']==1)
	{
	$_POST['firmControl']=0;
	$price='price_max';
	}
else
	$price='price_e';
if (isset($_POST['id']))
	{	
	$sql='UPDATE firm SET '.
	'name=\''.$_POST['firmName'].'\','.
	'k_norm_deviation='.$_POST['k_norm_deviation'].','.
	'Generation='.$_POST['firmGeneration'].','.
	'price_em='.$_POST['price_em'].','.
	'publish='.$_POST['publish'].','.
	$price.'='.$_POST['price_e'].','.
	'control='.$_POST['firmControl'].','.	'code=\''.$_POST['firmCode'].'\''.
	' WHERE id='.$_POST['id'];

	}
else
	$sql='INSERT INTO firm (name,code,k_norm_deviation,price_em,'.$price.',control,generation,publish) VALUES ('.
		'\''.$_POST['firmName'].'\','.
		'\''.$_POST['firmCode'].'\','.
		$_POST['k_norm_deviation'].','.
		$_POST['price_em'].','.
		$_POST['price_e'].','.
		$_POST['firmControl'].','.
		$_POST['firmGeneration'].','.
		$_POST['publish'].		
		')';


if (mysql_query($sql))
	{
	include 'inc/CloseDB.php';
	header("Location: firm.php");	
	}
else
	echo 'ньхайю намнбкемхъ дюммшу.<br>',$sql;	
?>