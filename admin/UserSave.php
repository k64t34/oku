<?php
/*	echo 'UserAdmin=',$HTTP_POST_VARS['UserAdmin'],'<br>'; 
	echo 'AllFirms=',$HTTP_POST_VARS['AllFirms'],'<br>'; 
	echo 'access=',$HTTP_POST_VARS['access'],'<br>'; 
	echo 'UserFirm=',$HTTP_POST_VARS['UserFirm'],'<br>'; 
exit;*/



ini_set('include_path','/home/home1/oku/');
include('inc/isAdmin.php'); 
include 'inc/OpenDB.php'; 

$HTTP_POST_VARS['UserAdmin']=(strcasecmp($HTTP_POST_VARS['UserAdmin'],'ON')==0 )?'1':'0';
$HTTP_POST_VARS['AllFirms']= (strcasecmp($HTTP_POST_VARS['AllFirms'] ,'ON')==0 )?'1':'0';
$HTTP_POST_VARS['access']=   (strcasecmp($HTTP_POST_VARS['access'] ,'ON')==0 )?'1':'0';


if (strcasecmp($HTTP_POST_VARS['UserAdmin'],'1')==0 | strcasecmp($HTTP_POST_VARS['AllFirms'],'1')==0)
	{
	$HTTP_POST_VARS['UserFirm']='0';
	}	
else
	{
	$sql="SELECT id FROM firm WHERE code='{$HTTP_POST_VARS['UserFirm']}'";
	$rs = mysql_query($sql);   
	if (mysql_num_rows($rs)==0)
		{	
		echo 'Неверный код фирмы<br>';
		exit;
		}	
	$rec = mysql_fetch_array($rs, MYSQL_ASSOC);
	$HTTP_POST_VARS['UserFirm']=$rec{'id'};
	mysql_free_result($rs);
	}
	



if (isset($HTTP_POST_VARS['id']))
	{	
	$sql='UPDATE user SET '.
	'name=\''.$HTTP_POST_VARS['UserName'].'\','.
	'admin='. $HTTP_POST_VARS['UserAdmin'].','.
	'access='. $HTTP_POST_VARS['access'].','.
	'idFirm='.$HTTP_POST_VARS['UserFirm'];
	if (strcasecmp($HTTP_POST_VARS['UserPassword'],'')!=0 )
		$sql=$sql.',password=\''.md5($HTTP_POST_VARS['UserPassword']).'\'';
	$sql=$sql.' WHERE id='.$HTTP_POST_VARS['id'];
	}
else
	$sql='INSERT INTO user (name,password,admin,idFirm,access) VALUES ('.	
		'\''.$HTTP_POST_VARS['UserName'].'\','.		
		'\''.md5($HTTP_POST_VARS['UserPassword']).'\','.
		$HTTP_POST_VARS['UserAdmin'].','.
		$HTTP_POST_VARS['UserFirm'].','.
		$HTTP_POST_VARS['access'].
		')';


echo 'sql=',$sql;
mysql_query($sql);   
include 'inc/CloseDB.php';
header("Location: user.php");	

?>