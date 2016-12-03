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
  <h3>Add Balance to "<?php echo $_name; ?>"</h3>
</div>
<div class="modal-body">
  <form method="POST">
    <table>
        <tr>
            <td><input type="hidden" name="hiden_id" value="<?php echo $_id; ?>" >
              <label>Taka : </label></td>
            <td>
                <div class="control-group">
                    <div class="controls">
                      <input type="number" onKeyup="myFunction()" data-validation-number-message="please enter number only." id="totaltaka" name="totaltaka" required  />
                      <p class="help-block"></p>
                    </div>
                  </div>
            </td>
        </tr>
            <tr>
            <td><label>Rate : </label></td>
            <td>  <div class="control-group">
                    <div class="controls">
                      <input  type="number"  onKeyup="myFunction()" data-validation-number-message="please enter number only." id="smsrate"  name="smsrate" required  />
                      <p class="help-block"></p>
                    </div>
                  </div>
</td>
        </tr>

            <tr>
            <td><label>Total SMS : </label></td>
            <td><input type="text" readonly id="totalsms" name="totalsms"  /></td>
        </tr>

        <tr>
            <td></td>
            <td>
          <input type="hidden" name="add-balance" value="add-balance" >
</td>
        </tr>
    </table>
    </form>
</div>
<div class="modal-footer">
  <a class="btn btn-primary" onclick="$('.modal-body > form').submit();">Add Balance</a>
  <a class="btn" data-dismiss="modal">Close</a>
</div>
<script src="assets/js/jqBootstrapValidation.js"></script>
<script type="text/javascript">
  $(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } );

function myFunction()
{
var val1 = document.getElementById('totaltaka').value;
var val2 = document.getElementById('smsrate').value;
var total = document.getElementById('totalsms');
var sum = parseInt(val1) + parseInt(val2);
if (val1.value!='' && val2.value!=''){
total.value='';
var t =val1 / val2;
total.value = Math.round(t);
}
   }
</script>