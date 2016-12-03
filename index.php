<?php
session_start();
$timezone = "Asia/Dhaka";
if(function_exists('date_default_timezone_set')) date_default_timezone_set($timezone);

function __autoload($class) {
    include_once($class . ".php");
}
$obj = new oopCrud;
//echo $_SESSION['uesr_mail'];
if(!empty($_SESSION['uesr_mail'])){
?>
<?php include 'header.php' ?>
<?php include 'sanitizer_function/sanitizer.php' ?>
<div class="container">

    <!-- Docs nav
    ================================================== -->
    <div class="row">
    	<?php include 'left.php' ?>
    	<div class="span9">
    		<?php
                include 'include/connectdb.php';                
                
    		$q=_rainsenitizedata(isset($_GET['q'])?$_GET['q']:NULL);
				if($q=="all-user"){
					include 'include/alluser.php';
				}
                                elseif ($q=='sms_report') {
                                    include 'include/sms_report.php';
                                }
				else if($q=="my-balance-history"){
					include "include/my-balance-history.php";
				}
				else if($q=="my-sms"){
					include "include/sms.php";
				}
                                elseif ($q=="change_pass_word") {
                                    include 'include/change_pass_word.php';
                                }
                                elseif ($q=='resetpassword') {
                                    include 'include/reset_password.php';
                                }
                                elseif ($q=='smsreport_details') {
                                    include 'include/smsreport_details.php';
                                }
				//else if($q==""){
				//}
				//else if($q==""){
				//}
				//else{
				//}
    		?>
    	</div>
    	</div>
<?php include 'footer.php' ?>
<?php
}
else{
	header('location: login.php');
}
?>