<?php 
//DB Connection Start For Online

//$smshost_name	=	"infoedu.ipagemysql.com";
//$smsdb_name	=	"sms_port";
//$smsuser_name	=	"sms_panal";
//$smspass_word	=	"MJA_562443";
//
//$smscon = new PDO("mysql:host=$smshost_name; dbname=$smsdb_name", $smsuser_name, $smspass_word);


//DB Connection End For Online

//DB Connection Start For Local

$smshost_name	=	"localhost";
$smsdb_name	=	"db_smsgateway";
$smsuser_name	=	"root";
$smspass_word	=	"";

$smscon = new PDO("mysql:host=$smshost_name; dbname=$smsdb_name", $smsuser_name, $smspass_word);


//DB Connection End For Local
?>