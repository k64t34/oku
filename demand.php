<?php 
define('__ROOT__', dirname(dirname(__FILE__))); 
require_once(__ROOT__.'/access.php'); 
?>
<html>
<head>
<meta http-equiv="Content-Language" content="ru" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Заявка на предоставление ИТ услуг</title>
<style type="text/css">
.style1 {
				text-align: right;
}
.p_center {
				text-align: center;
}
</style>

</head>
<body>
<p class="p_center"><strong>Заявка на предоставление ИТ услуг</strong></p>
<form method="post">

				<table style="width: 100%; height: 114px;">
								<tr>
												<td  width="50%"class="style1">Пользователь</td>
												<td> <input name="Text1" type="text" style="width: 251px" /></td>
								</tr>
								<tr>
												<td class="style1">Рабочее место</td>
												<td> 
												<input name="Text3" type="text" style="width: 249px" size="20" /></td>
								</tr>
								<tr>
												<td class="style1">Описание проблемы</td>
												<td> <textarea name="TextArea1" style="width: 444px; height: 58px"></textarea></td>
								</tr>
				</table>
				<br>

				
<p class="p_center">			<input name="Submit1" type="submit" value="Отправить" /></p>
				
				</form>

</body>

</body>
</html>
