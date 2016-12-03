<h2>SMS Balance History</h2>
<!--<span class="label label-info">Total Balance: -->
<?php
$userid=$_SESSION['user_id'];
//$totalbalance=$obj->totalbalanec($userid);

//round($totalbalance);
?>
<!--</span>-->

<!--<span class="label label-warning">Remain Balance: -->
<?php
//$userid=$_SESSION['user_id'];
//$balance=$obj->balancecheck($userid);

//round($balance);
?>
<!--</span>-->


 <span class="label label-warning" style="margin-bottom: 10px; height: 20px; font-size: 20px; padding-top: 10px;"> SMS Balance: 
<?php
$remainsms=$obj->SMSBalance($userid);

//$remainsms=$balance/$smsrate;
echo round($remainsms);
?>
</span>
<br>
<table class="table table-striped table-hover" style="margin-top:30px; width: 800px; margin: 0 auto;">
<tr>
    <td colspan="3" style="text-align: center; font-size: 20px;"><b>SMS Purchase Details</b></td>
</tr>
<tr>
        <?php
        if($_SESSION['usertype']=="A"){
        ?>
        <th>TAKA</th>
        <?php } ?>
	<th>TOTAL SMS</th>
	<th>DATE & TIME</th>
</tr>
<?php
$userid=$_SESSION['user_id'];

foreach($obj->showByWhere("_sms_balance", "_user_id", $userid) as $value){
extract($value);
?>
<tr>
<?php
if($_SESSION['usertype']=="A"){
?>
<td><?php echo $_taka; ?></td>
<?php } ?>
<td><?php echo $_sms_count; ?></td>
<td><?php echo $create_at; ?></td>
</tr>

<?php
}
?>
</table>