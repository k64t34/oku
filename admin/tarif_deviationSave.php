<?php
ini_set('include_path','/home/home1/oku/');
include('inc/isAdmin.php'); 
include 'inc/OpenDB.php'; 

reset ($HTTP_POST_VARS );
foreach($HTTP_POST_VARS as $key => $value) 
	{
	if (strncmp($key,'in',2)==0)
		AddRec(substr($key,2),'in',$value);
	else if (strncmp($key,'de',2)==0)
		AddRec(substr($key,2),'de',$value);
	}	

include 'inc/CloseDB.php';
header("Location: firm.php");	


//-----------------------------------------
function AddRec($id,$increase,$price)
//-----------------------------------------
{
$sql="UPDATE tarif_deviation SET ".$increase."crease_price=$price WHERE id=$id";
mysql_query($sql);
}
?>