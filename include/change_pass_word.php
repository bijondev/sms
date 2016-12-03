<?php

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] :NULL;

$view_suer_sql = "SELECT * FROM `_user` WHERE `_id`=?";
$view_user_q = $smscon->prepare($view_suer_sql);
$view_user_q->execute(array($user_id));

$view_user_q->bindColumn(1, $user_id);
$view_user_q->bindColumn(2, $user_name);
$view_user_q->bindColumn(3, $user_email);
$view_user_q->bindColumn(4, $user_pass_word);

while ($view_user_q->fetch())
    
if (isset($_POST['change']) ?   $_POST['change']  :NULL) {
    
    $current_pass           = isset($_POST['current_password']) ?   $_POST['current_password']  :NULL;    
    $current_pass_encript   = md5($current_pass);
    $new_pass               = isset($_POST['new_password']) ?   $_POST['new_password']  :NULL;
    $conform_pass           = isset($_POST['conform_password']) ?   $_POST['conform_password']  :NULL;
    $new_enc_pass           = md5($new_pass);
    
if ($current_pass_encript==$user_pass_word) {
    if ($new_pass==$conform_pass) {
        
    $sql = "UPDATE `_user` SET `_password` =? WHERE `_id` =?";
    $q = $smscon->prepare($sql);
    $result = $q->execute(array($new_enc_pass,$user_id));
    
    if (!$result)
            {$result = "<span style='color: red;'>PASSWORD CHANGE FAILED</span>";}
       else {$result = "<span style='color: red;'>PASSWORD CHANGE  SUCCESSFULL</span>";}
    
    }
    else {$unmatch = "<span style='color: red;'>UNMATCH PASSWORD</span>";  }
  }
  else {$invalid_pass = "<span style='color: red;'>INVALID PASSWORD</span>";  }
}
?>


<div style="margin: 0 auto; text-align: center; width: 100%;">
    <form action="" method="post">
    <table class="table table-bordered" style="width: 700px; margin: 0 auto;">
        <tr>
            <td colspan="2" style="text-align: center; font-size: 25px;">
                <u>CHANGE YOUR PASSWORD FOR SECURE ACCESS</u>
            </td>
        </tr>        
        <tr>
            <td colspan="2" style="text-align: center;"><?php echo isset($result) ?  $result  :NULL; ?></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center; font-size: 20px; font-weight: bold;">
                <?php echo isset($user_email) ?  $user_email  :NULL; ?>
            </td>
        </tr>
        <tr>
            <td style="width: 200px;">CURRENT PASSWORD : </td>
            <td><input name="current_password" type="password" class="input-large" placeholder="********" required> <?php echo isset($invalid_pass) ?  $invalid_pass  :NULL; ?></td>
        </tr>
        <tr>
            <td style="width: 200px;">NEW PASSWORD : </td>
            <td><input name="new_password" type="password" class="input-large" placeholder="********" required></td>
        </tr>
        <tr>
            <td style="width: 200px;">CONFORM PASSWORD : </td>
            <td><input name="conform_password" type="password" class="input-large" placeholder="********" required> <?php echo isset($unmatch) ?  $unmatch  :NULL; ?></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <input class="btn btn-success" type="submit" name="change" value="SAVE CHANGE"/>
            </td>
        </tr>
    </table>
</form>
</div>