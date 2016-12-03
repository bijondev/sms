<?php
include '../sanitizer_function/sanitizer.php';
$id=_rainsenitizedata(isset($_GET['id'])?$_GET['id']:NULL);
function __autoload($class) {
    include_once("../oopCrud.php");
}
$obj = new oopCrud;
extract($obj->getById($id,"_user"));
?>
<div class="modal-header">
  <a class="close" data-dismiss="modal">&times;</a>
  <h3>View Balance Of "<?php echo $_name; ?>"</h3>
</div>
<div class="modal-body">
  <table class="table table-striped">
    <tr>
      <th>Taka</th>
      <th>Rate</th>
      <th>Total SMS</th>
      <th>Date</th>
    </tr>
    <?php
    
    foreach($obj->showBalance("_sms_balance", $id) as $value){
extract($value);
    ?>
    <tr>
      <td><?php echo $_taka; ?></td>
      <td><?php echo $_sms_rate; ?></td>
      <td><?php echo $_sms_count; ?></td>
      <td><?php echo $create_at; ?></td>
    </tr>
    <?php } ?>
 
    <?php
include 'connectdb.php';
    
    $totaltk_sql = "SELECT SUM(`_taka`) AS totaltk FROM `_sms_balance` WHERE `_user_id`=?";
    $total_q = $smscon->prepare($totaltk_sql);
    $total_q->execute(array($id));
    $result_tk = $total_q->fetch();
    $recivetk = $result_tk['totaltk'];
    
    $totalsms_sql = "SELECT SUM(`_sms_count`) AS totalsms from `_sms_balance` where `_user_id`=?";
    $totalsms_q = $smscon->prepare($totalsms_sql);
    $totalsms_q->execute(array($id));
    $result_sms = $totalsms_q->fetch();
    $paidsms = $result_sms['totalsms'];
    
    $usedsms_sql = "SELECT COUNT(*) AS sendsms FROM `_sms` WHERE `_user_id`=?";
    $usedsms_q = $smscon->prepare($usedsms_sql);
    $usedsms_q->execute(array($id));
    $result_usedsms = $usedsms_q->fetch();
    $usedsms = $result_usedsms['sendsms'];
    
    $leftsms = $paidsms-$usedsms;
    ?>
    <tr>
        <th>Total TK = <?php echo isset($recivetk) ?  $recivetk  :NULL; ?></th>
        <th>Total SMS = <?php echo isset($paidsms) ?  $paidsms  :NULL; ?></th>
        <th>Used SMS = <?php echo isset($usedsms) ?  $usedsms  :NULL; ?></th>
        <th>Left SMS = <?php echo isset($leftsms) ?  $leftsms  :NULL; ?></th>
    </tr>
  </table>
</div>
<div class="modal-footer">
  <a class="btn btn-primary" onclick="$('.modal-body > form').submit();">Save Changes</a>
  <a class="btn" data-dismiss="modal">Close</a>
</div>