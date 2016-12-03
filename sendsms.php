<?php
function __autoload($class) {
    include_once($class . ".php");
}
$obj = new oopCrud;

include 'sanitizer_function/sanitizer.php';

$userid=_rainsenitizedata(isset($_GET['userid'])?$_GET['userid']:NULL);
$pass=_rainsenitizedata(isset($_GET['pass'])?$_GET['pass']:NULL);
$uid=_rainsenitizedata(isset($_GET['uid'])?$_GET['uid']:NULL);
$phoneno=_rainsenitizedata(isset($_GET['phoneno'])?$_GET['phoneno']:NULL);
$smsbody=_rainsenitizedata(isset($_GET['smsbody'])?$_GET['smsbody']:NULL);

//echo strlen($phoneno);

$balance=$obj->balancecheck($userid);
$smsrate=$obj->smsrate($userid);

if($balance>=$smsrate)
{
if(is_numeric($phoneno)){
if(strlen($phoneno)==11){
if($obj->logincheck($userid, $pass)==1){
	$data=$obj->getData($userid);
	//print_r($data);
	$userid=$data['user_id'];
	//echo $data['email'];
		$smsrate=$obj->smsrate($userid);

	//$obj->insertSIngelSMS($userid, $phonenumber, $smsbody, $smsrate);

	//if($obj->insertSIngelSMS($userid, $phoneno, $smsbody)){
        $remainsms=$obj->SMSBalance($userid);
        if($remainsms>=1)
        {
                
	if($obj->insertSIngelSMS($userid, $phoneno, $smsbody, $smsrate)){
		echo "sms send successfully";
            }
        }
        else{
            echo "No enough Balance";
            }

}
else{
	echo "invalid username or password!";
}
}
else{
	echo "Invalid phone number format!";
}
}
else{
	echo "character type not supported!";
}
}
else{
	echo "No enough Balance";
}
//http://smsport.e-edubd.info/sendsms.php?userid=<userid>&pass=<password>&phoneno=<phoneno>&smsbody=<smsbody>

//http://smsport.e-edubd.info/sendsms.php?userid=bijon.bairagi@gmail.com&pass=1234567890&phoneno=01734977842&smsbody=link check
