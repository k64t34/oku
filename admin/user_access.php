<?php
include 'isAdmin.php'; 
?>

<!-- #include file="OpenDB.inc" -->

<html>

<head>
<meta http-equiv="Content-Language" content="ru">
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<link rel="stylesheet" type="text/css" href="oku.css">


</head>

<body>

<h2>Права пользователя</h2>



<table border="1" cellpadding="0" cellspacing="0" style="border-collapse: collapse" >
<%
str_SQL="SELECT * FROM user_access"
Set RS = Conn.Execute(str_SQL)
while NOT RS.EOF
%>

  <tr>
    <td width="5%"><%=RS("iduser")%>&nbsp;</td>
    <td width="55%"><%=RS("idfirm")%>&nbsp;</td>    
    </td>
    
  </tr>
<%
RS.MoveNext
WEND %>	  

</table>


</body>

</html>

<%
RS.Close
Conn.Close
%>