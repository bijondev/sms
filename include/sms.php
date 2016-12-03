<h2>SMS History</h2>
<?php
$userid=$_SESSION['user_id'];
if(isset($_POST['singelsms'])?$_POST['singelsms']:NULL){


	$userid=_rainsenitizedata(isset($_POST['userid'])?$_POST['userid']:NULL);
	$phonenumber=_rainsenitizedata(isset($_POST['phonenumber'])?$_POST['phonenumber']:NULL);
	$smsbody=_rainsenitizedata(isset($_POST['smsbody'])?$_POST['smsbody']:NULL);

	$smsrate=$obj->smsrate($userid);
	$balance=$obj->balancecheck($userid);

		$smsrate=$obj->smsrate($userid);

		if($balance>=$smsrate)
		{
			$obj->insertSIngelSMS($userid, $phonenumber, $smsbody, $smsrate);
		}
		else
		{
			echo "No Enough balance";
		}
}

if(isset($_POST['CSvsms'])?$_POST['CSvsms']:NULL){

	$csv_mimetypes = array(
    'text/csv',
    'text/plain',
    'application/csv',
    'text/comma-separated-values',
    'application/excel',
    'application/vnd.ms-excel',
    'application/vnd.msexcel',
    'text/anytext',
    'application/octet-stream',
    'application/txt',
);

	//print_r($csv_file);



	if (in_array($_FILES['CSVfile']['type'], $csv_mimetypes)){
		$csv_file = $_FILES['CSVfile']['tmp_name']; // Name of your CSV file
	$csvfile = fopen($csv_file, 'r');
	$theData = fgets($csvfile);
	$i = 0;
	while ($data = fgetcsv($csvfile,1000,"|")) {
		$phonenumber= $data[0];
		$smsbody= $data[1];

	//$csv_data[] = fgets($csvfile, 1024);
	//$csv_array = explode(",", $csv_data[$i]);
	
	//$phonenumber = _rainsenitizedata($csv_array[0]);
	//$smsbody = _rainsenitizedata($csv_array[1]);

		$smsrate=$obj->smsrate($userid);

			$smsrate=$obj->smsrate($userid);
			$balance=$obj->balancecheck($userid);
		if($balance>=$smsrate)
		{
	$obj->insertSIngelSMS($userid, $phonenumber, $smsbody, $smsrate);
}
else
{
	echo "No Enough balance";
}

	//$obj->insertSIngelSMS($userid, $phonenumber, $smsbody);
	$i++;
	}
	fclose($csvfile);
	echo "File data successfully imported to database!!";

}
else{
	echo "Please select CSV File";
}
}

?>
<p>
<a href="include/send-singel-sms.php?id=<?php echo $userid; ?>" class="btn btn-small btn-warning" data-toggle="send-singel-sms" type="button">Send Singel SMS</a>
<a href="include/send-csv-sms.php?id=<?php echo $userid; ?>" class="btn btn-small btn-warning" data-toggle="view-balance" type="button">Send From CSV File</a>
</p>



<?php
$view_sms_details_sql = "SELECT * FROM `vw_smsinfo` WHERE `_user_id`=? ORDER BY `_id` DESC";
$view_sms_details_q = $smscon->prepare($view_sms_details_sql);
$view_sms_details_q->execute(array($userid));
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