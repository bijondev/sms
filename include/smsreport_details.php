<?php
$token = isset($_GET['token'])? $_GET['token'] :NULL;


$view_sms_details_sql = "SELECT * FROM `vw_smsinfo` WHERE `_user_id`=? ORDER BY `_id` DESC";
$view_sms_details_q = $smscon->prepare($view_sms_details_sql);
$view_sms_details_q->execute(array($token));
$total_sms = $view_sms_details_q->rowCount();

$view_sms_details_q->bindColumn(1, $sms_id);
$view_sms_details_q->bindColumn(3, $user_name);
$view_sms_details_q->bindColumn(4, $user_login_name);
$view_sms_details_q->bindColumn(5, $company);
$view_sms_details_q->bindColumn(6, $mobile);
$view_sms_details_q->bindColumn(7, $sms_body);
$view_sms_details_q->bindColumn(9, $date_time);
$view_sms_details_q->bindColumn(11, $ip_add);
$view_sms_details_q->bindColumn(12, $mac_add);
$view_sms_details_q->bindColumn(13, $status);

$i  = 0; 

?>
<table id="example"  class="table table-striped table-hover">
<thead>
    <tr>
        <th colspan="6" style="font-size: 20px; text-align: center;"><b style=" padding-right: 50px;">VIEW ALL SMS STATUS</b> <b style=" color: red;">Total SMS = <?php echo isset($total_sms) ?  $total_sms  :NULL; ?></b></th>
    </tr>
<tr>
    <th>#</th>
    <th>Mobile No</th>
    <th>SMS Body</th>
    <th>Status</th>
    <th>Send By</th>
    <th>Date & Time</th>
</tr>
</thead>
<tbody>
<?php

while ($view_sms_details_q->fetch())
{
$i++;
?>
<tr>
    <td><?php echo $i; ?></td>
    <td><?php echo isset($mobile) ?  $mobile  :NULL; ?></td>
    <td><?php echo isset($sms_body) ?  $sms_body  :NULL; ?></td>
    <td><?php if($status=='11'){echo 'Success'; } else {echo 'Pending';}?></td>
    <td><?php echo isset($user_login_name) ?  $user_login_name  :NULL; ?></td>
    <td><?php echo isset($date_time) ?  $date_time  :NULL; ?></td>
</tr>
<?php
}
?>
<tbody>
</table>