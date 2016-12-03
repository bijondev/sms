<?php
session_start();
if(!empty($_SESSION['uesr_mail'])){
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>e-edu.info :: SMS Gateway</title>
    <style type="text/css">
    #warper{
      margin: 0 auto;
      height: 700px;
      width: 800px;
      border: 1px solid black;
      background-color: black;
    }
    </style>
    
       <script src="assets/js/jquery.js"></script>
        <script type="text/javascript">
      setInterval(function(){
         $.ajax({
            type: "POST",
            url: "include/ajax-confirm-sms-send.php",
            data: {}
            }).done(function( result ) {
                if(result=="oky"){
                 $("#autoSmsSend").submit();  
                }
                else{
                    $("#confmsg").html( "invalid password! Try again" ); 
                }
            //$("#msg").html( " Address of Roll no " +rno +" is "+result );
            });
      },10000);
    </script>

</head>

  <body data-spy="scroll" data-target=".bs-docs-sidebar">
    <div id="warper"></div>
    </body>
    </html>
    <?php
}
else{
  header('location: login.php');
}
?>