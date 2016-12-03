<?php
session_start();
$msg=isset($_SESSION['msg'])?$_SESSION['msg']:NULL;
?>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>e-edu sms gateway :: Login Form</title>
  <link rel="stylesheet" href="css/style.css">
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
  <section class="container">
    <div class="login">
      <h1>Login to e-edu.info sms gateway</h1>
      <div style="color:red; text-align:center;">
      <?php
      if($msg!=""){
        echo $msg;
        session_destroy();
      }
      ?>
      </div>
      <form method="post" action="logincheck.php">
        <p><input type="text" name="login" placeholder="Enter Email"></p>
        <p><input type="password" name="password" placeholder="Enter Password"></p>
        <p class="remember_me">
          <label>
            <input type="checkbox" name="remember_me" id="remember_me">
            Remember me on this computer
          </label>
        </p>
        <p class="submit"><input type="submit" name="commit" value="Login"></p>
      </form>
    </div>
  </section>

  <section class="about">
    <p class="about-author">
      Powered By <a href="http://e-edubd.info" target="_blank">e-edu.info</a>
  </section>
</body>
</html>
