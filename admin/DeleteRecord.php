<?php
ini_set('include_path','/home/home1/oku/');
include('inc/isAdmin.php'); 

include 'inc/OpenDB.php'; 

$sql = 'DELETE FROM '.$HTTP_GET_VARS['tbl'].' WHERE id='.$HTTP_GET_VARS['id'] ;
//echo $sql; 
mysql_query($sql);   
include 'inc/CloseDB.php';
header('Location: '.$HTTP_GET_VARS['tbl'].'.php');	
?>