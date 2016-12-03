<h1>View All User</h1>
<div class="bb-alert alert alert-info" style="display:none;">
        <span>The examples populate this alert with dummy content</span>
    </div>
<?php
if(isset($_POST['AddUser'])?$_POST['AddUser']:NULL){
  $username=_rainsenitizedata($_POST['username']);
  $email=_rainsenitizedata($_POST['email']);
  $password1=_rainsenitizedata($_POST['password1']);
  $company=_rainsenitizedata($_POST['company']);
  $address=_rainsenitizedata($_POST['address']);
  $usertype=_rainsenitizedata($_POST['usertype']);
  $status=_rainsenitizedata($_POST['status']);
  $uniqueid=_rainuniqcodes("UID_", 10);
  $ip=$_SERVER["REMOTE_ADDR"];
  $mac=getMac();
  $date= date("Y-m-d H:i:s");

  $obj->insertUser($username, $email, $password1, $company, $address, $usertype, $status, $ip, $mac, $uniqueid, $date);

}
?>
<?php

if(isset($_POST['edituser'])?$_POST['edituser']:NULL){
  $hiden_id=_rainsenitizedata($_POST['hiden_id']);
    $username=_rainsenitizedata($_POST['username']);
  $email=_rainsenitizedata($_POST['email']);
  $company=_rainsenitizedata($_POST['company']);
  $address=_rainsenitizedata($_POST['address']);
  $usertype=_rainsenitizedata($_POST['usertype']);
  $status=_rainsenitizedata($_POST['status']);
  $obj->UpdateUser($hiden_id, $username, $email, $company, $address, $usertype, $status);

}
?>
<?php
if(isset($_POST['add-balance'])?$_POST['add-balance']:NULL){
  $hiden_id=_rainsenitizedata($_POST['hiden_id']);
    $totaltaka=_rainsenitizedata($_POST['totaltaka']);
  $smsrate=_rainsenitizedata($_POST['smsrate']);

  $totalsms=$totaltaka/$smsrate;

$obj->insertBalance($hiden_id, $totaltaka, $smsrate, $totalsms);

}


    	$page = (int) (!isset($_GET["page"]) ? 1 : $_GET["page"]);
    	$limit = 20;
        if($page==1){
            $s=0;
        }
    	else{
        $s = ($paging * $limit)-$limit;
        }

$table='<table class="table table-bordered">';
$table.='<tr>';
$table.='<th>Name</th>';
$table.='<th>Email</th>';
$table.='<th>Company</th>';
$table.='<th>User Type</th>';
$table.='<th>Status</th>';
$table.='<th style="text-align: center;"><a href="#myModal" role="button" class="btn btn-large btn-primary" data-toggle="modal">Create New User</a></th>';
$table.='<tr>';

echo $table;
foreach($obj->showData("_user", "_id", $s, $limit) as $value){
extract($value);
echo <<<show
<tr>
<td>$_name</td>
<td>$_email</td>
<td>$_company</td>
<td>$_usertype</td>
<td>$_status</td>
<td><a href="include/edit-user.php?id=$_id" class="btn btn-small btn-success" data-toggle="modal-edit-user">Edit</a>
<button class="alertb btn btn-small btn-danger" value="$_id" type="button">Delete</button>
<a href="include/add-balance.php?id=$_id" class="btn btn-small btn-warning" value="$_id" data-toggle="add-balance" type="button">Add Balance</a>
<a href="include/view-all-balance.php?id=$_id" class="btn btn-small btn-warning" value="$_id" data-toggle="view-balance" type="button">View Balance</a>
<a href="?q=resetpassword&token=$_id" class="btn btn-small btn-warning" type="button">Reset Password</a>
</td>
</tr>       
show;
}

echo '</table>';
?>
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Add New User</h3>
  </div>
  <div class="modal-body">
    <form id="saveform" method="POST">
    <table>
        <tr>
            <td><label>Name : </label></td>
            <td>
                <div class="control-group">
                    <div class="controls">
                      <input type="text" data-validation-required-message="please enter full name." name="username" required  />
                      <p class="help-block"></p>
                    </div>
                  </div>
            </td>
        </tr>
            <tr>
            <td><label>Email : </label></td>
            <td>  <div class="control-group">
                    <div class="controls">
                      <input type="email" name="email" required  />
                      <p class="help-block"></p>
                    </div>
                  </div>
</td>
        </tr>
            <tr>
            <td><label>Password : </label></td>
            <td><div class="control-group">
                    <div class="controls">
                      <input type="text" name="password1" required  />
                      <p class="help-block"></p>
                    </div>
                  </div></td>
        </tr>
            <tr>
            <td><label>Company : </label></td>
            <td><input type="text" name="company"  /></td>
        </tr>
            <tr>
            <td><label>Address : </label></td>
            <td><textarea name="address" rows="3"></textarea></td>
        </tr>
            <tr>
            <td><label>User Type : </label></td>
            <td><div class="control-group">
                    <div class="controls" >
                      <select name="usertype" required >
                          <option></option>
                          <option value="A">Admin</option>
                          <option value="U">User</option>
                          <option value="C">SMS Consol</option>
                        </select>
                      <p class="help-block"></p>
                    </div>
                  </div></td>
        </tr>
        <tr>
            <td><label>Status : </label></td>
            <td><label class="radio">
  <input type="radio" name="status" id="optionsRadios1" value="D" checked>
Diesable
</label>
<label class="radio">
  <input type="radio" name="status" id="optionsRadios2" value="E">
  Enable
</label><input type="hidden" name="AddUser" value="AddUser" ></td>
        </tr>
    </table>
    </form>
  </div>
  <div class="modal-footer">
      <a class="btn btn-primary" onclick="$('#saveform').submit();">SAVE</a>
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>