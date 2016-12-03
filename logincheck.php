<?php
session_start();
function __autoload($class) {
    include_once($class . ".php");
}
include 'sanitizer_function/sanitizer.php';

$email=_rainsenitizedata($_POST['login']);
$password=_rainsenitizedata($_POST['password']);
$obj = new oopCrud;
if($obj->logincheck($email, $password)==1){

$data=$obj->getData($email);
$_SESSION['user_id']=$data['user_id'];
 $_SESSION['uesr_name']=$data['name'];
 $_SESSION['uesr_mail']=$data['email'];
 $_SESSION['usertype']=$data['usertype'];

 header('location: index.php');
}
else{
	$_SESSION['msg']="Invalid User Name Or Password!";
	 header('location: login.php');
}
?>