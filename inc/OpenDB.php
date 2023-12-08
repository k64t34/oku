<?php
$openConn2db =mysql_connect( "localhost", "oku", "okudb77" ) 
 or die("Could not connect to MySQL Server");
	
$dbSelected = mysql_select_db( "oku", $openConn2db )
 or die("Could not open DataBase");
?>