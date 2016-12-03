<h2>SMS History</h2>
<?php
$userid=$_SESSION['user_id'];
if(isset($_POST['singelsms'])?$_POST['singelsms']:NULL){


	$userid=_rainsenitizedata(isset($_POST['userid'])?$_POST['userid']:NULL);
	$phonenumber=_rainsenitizedata(isset($_POST['phonenumber'])?$_POST['phonenumber']:NULL);
	$smsbody=_rainsenitizedata(isset($_POST['smsbody'])?$_POST['smsbody']:NULL);

	$smsrate=$obj->smsrate($userid);

	$obj->insertSIngelSMS($userid, $phonenumber, $smsbody, $smsrate);
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
	while ($data = fgetcsv($csvfile,1000,",","'")) {
		$phonenumber= $data[0];
		$smsbody= $data[1];

	//$csv_data[] = fgets($csvfile, 1024);
	//$csv_array = explode(",", $csv_data[$i]);
	
	//$phonenumber = _rainsenitizedata($csv_array[0]);
	//$smsbody = _rainsenitizedata($csv_array[1]);

		$smsrate=$obj->smsrate($userid);

	$obj->insertSIngelSMS($userid, $phonenumber, $smsbody, $smsrate);

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
<table id="example"  class="table table-striped">
	<thead>
<tr>
	<th>Phone</th>
	<th>SMS Body</th>
	<th>Time</th>
</tr>
</thead>
<tbody>
<?php

foreach($obj->showByWhere("_sms", "_user_id", $userid) as $value){
extract($value);
?>
<tr>
<td><?php echo $_mobile_no; ?></td>
<td><?php echo $_body; ?></td>
<td><?php echo $_create_at; ?></td>
</tr>
<?php
}
?>
<tbody>
</table>