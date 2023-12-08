<?php
include_once $_SERVER["DOCUMENT_ROOT"].'/inc/login.php'; 
//session_start();
if (!isset($_SESSION['Admin_right']) ) 
	{
	echo '<br><h2><font color="#FF3300">У вас нет прав администратора</font></h2><br>';
	exit;
	}
else
	include_once $_SERVER["DOCUMENT_ROOT"].'/inc/OpenDB.php'; 
?>