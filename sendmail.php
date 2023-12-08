<?php

//echo 'firm=',$HTTP_POST_VARS['firm'],'<br>';
//echo 'fio=',$HTTP_POST_VARS['fio'],'<br>';
//echo 'email=',$HTTP_POST_VARS['email'],'<br>';
//echo 'body=',$HTTP_POST_VARS['body'],'<br>';



include 'inc/mail_class.php'; 
$mail = new Mail();
$mail -> to = 'oku@kmv.ru';
//$mail -> to = 'skorikoff@odusk.so-cdu.ru';
$mail -> subject = 'Обратная связь ОКУ';

$mail -> msg = $HTTP_POST_VARS['fio']
	.$HTTP_POST_VARS['firm']
	.$HTTP_POST_VARS['email']
	.$HTTP_POST_VARS['body'];


$mail -> rigorous_email_check = 0;

if($mail->send())
	{	
	?>
	<html><head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
	<meta http-equiv="Content-Language" content="ru">
	<link rel="stylesheet" type="text/css" href="oku.css">
	</head><body>
	<h2>Ваше сообщение отправлено </h2>		
	</body></html>
	<?
	}
else
	{
	
	header('Location:feedback.asp?err=1'.
		'&fio='  .$HTTP_POST_VARS["FIO"].
    	'&email='.$HTTP_POST_VARS["email"].
		'&firm=' .$HTTP_POST_VARS["firm"].
		'&body=' .$HTTP_POST_VARS["body"] );
	exit;
	}

?>

