<?php
$token = isset($_GET['token']) ? $_GET['token'] :NULL;

$view_suer_sql = "SELECT * FROM `_user` WHERE `_id`=?";
$view_user_q = $smscon->prepare($view_suer_sql);
$view_user_q->execute(array($token));

$view_user_q->bindColumn(1, $token);
$view_user_q->bindColumn(2, $user_name);
$view_user_q->bindColumn(3, $user_email);

while ($view_user_q->fetch())
    
if (isset($_POST['change']) ?   $_POST['change']  :NULL) {
    $token                  = isset($_POST['user_id'])? $_POST['user_id'] :NULL;
    $new_pass_word          = isset($_POST['new_password']) ?   $_POST['new_password']  :NULL;
    $conform_pass           = isset($_POST['conform_password']) ?   $_POST['conform_password']  :NULL;
    $current_pass_encript   = md5($conform_pass);

    if ($new_pass_word==$conform_pass) {
        
    $sql = "UPDATE `_user` SET `_password` =? WHERE `_id` =?";
    $q = $smscon->prepare($sql);
    $result = $q->execute(array($current_pass_encript,$token));
    
    if (!$result)
            {$result = "<span style='color: red;'>PASSWORD CHANGE FAILED</span>";}
       else {$result = "<span style='color: red;'>PASSWORD CHANGE  SUCCESSFULL</span>";}
    
    }
    else {$unmatch = "<span style='color: red;'>UNMATCH PASSWORD</span>";  }
}
?>



<form action="" method="post">
    <table class="table table-bordered" style="width: 700px; margin: 0 auto;">
        <tr><input name="user_id" type="hidden" value="<?php echo isset($token)? $token :NULL; ?>"></tr>
        <tr>
            <td colspan="2" style="text-align: center; font-size: 25px;">
                <u>CHANGE PASSWORD</u>
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
            <td style="width: 200px;">NEW PASSWORD : </td>
            <td><input name="new_password" type="password" class="input-large" placeholder="********" required></td>
        </tr>
        <tr>
            <td style="width: 200px;">CONFORM PASSWORD : </td>
            <td><input name="conform_password" type="password" class="input-large" placeholder="********" required> <?php echo isset($unmatch) ?  $unmatch  :NULL; ?></td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">
                <input class="btn btn-success" type="submit" name="change" value="CHANGE"/>
            </td>
        </tr>
    </table>
</form>