<?php  
class Mail 
{ 
var $to = ''; 
var $from = ''; 
var $reply_to = ''; 
var $cc = ''; 
var $bcc = ''; 
var $subject = ''; 
var $msg = ''; 
var $validate_email = false; //true 
// ��������� ������������ �������� ������� 

var $rigorous_email_check = true; 
// ��������� ������������ �������� ���� �� ������� DNS 

var $allow_empty_subject = false; 
// ������������ ������� ���� subject 

var $allow_empty_msg = false; 
// ������������ ������� ���� msg 

var $headers = array(); 
// ������ $headers �������� ��� ���� ���������, ����� to � subject 


//------------------------------------------
function check_fields() 
//------------------------------------------
// �����, �����������, �������� �� ��� �������� ���������� � �������� ������������ �������� ������� 
{ 
if(empty($this -> to)) 
	{return false;} 
if(!$this -> allow_empty_subject && empty($this -> subject)) 
	{return false;} 
if(!$this -> allow_empty_msg && empty($this -> msg)) 
	{return false;} 
// ���� ���� �������������� ���������, �������� �� � ������ $headers 
if(!empty($this -> from)) 
	{$this->headers[] = "From: $this -> from";} 
if(!empty($this -> reply_to)) 
	{$this -> headers[] = "Reply_to: $this -> reply_to";} 
// ��������� ������������ ��������� ������ 
if ($this -> validate_email) 
	{
	if (!preg_match("/[0-9a-z_]+@[0-9a-z_^\.]+\.[a-z]{2,3}/i", $this -> to)) 
	{return false;} 
	return true; 
	} 
} 

//------------------------------------------
function send() 
//------------------------------------------
// ����� �������� ���������  
{ 
if (!$this -> check_fields())
	 {return true;} 
if (mail($this -> to, htmlspecialchars( stripslashes(trim($this -> subject))), 
	htmlspecialchars(stripslashes(trim($this -> msg))))) 
	
	{return true;}
else
	{return false;} 
}	

} 
?>
