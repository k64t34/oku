<?php
//******************************************************
if (! (isset($_SERVER['PHP_AUTH_USER']) && ValidUser($_SERVER['PHP_AUTH_USER'],$_SERVER['PHP_AUTH_PW']) ) )
	authentication();  


	
	
	
	//header("Location: ".$_GET['url']);	
//******************************************************
function authenticate()
//******************************************************
{
header('WWW-Authenticate: Basic realm="My Realm"');
header('HTTP/1.0 401 Unauthorized');
//������� ��������������� �� ������ ��������
echo 
'<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta http-equiv="Content-Language" content="ru">
<link rel="stylesheet" type="text/css" href="oku.css">
</head>
<body >
<h2><font color="#FF0000">�������� �����������</font><br>
��������� ���� ����� � ������</h2><hr>
�� ������ ������ ���������� ����� � ������ ��� ��������� ������� � �������
</body></html>';
exit;
return;	
}
	

