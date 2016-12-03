<?php
session_start();
$userid=$_SESSION['user_id'];
function __autoload($class) {
    include_once("../oopCrud.php");
}
$obj = new oopCrud;
$i=0;
foreach($obj->checkSMS() as $value){
extract($value);

//$satus=$obj->sendsms($_mobile_no, $_body);
//echo $satus."KKK";

$balance=$obj->balancecheck($userid);
$smsrate=$obj->smsrate($userid);

if($balance>=$smsrate)
{
$obj->updateSMS($_id, $obj->sendsms($_mobile_no, trim($_body)));
}
$i++;
}
echo $i;
?>