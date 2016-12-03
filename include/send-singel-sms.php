<?php
include '../sanitizer_function/sanitizer.php';
$id=_rainsenitizedata(isset($_GET['id'])?$_GET['id']:NULL);
?>
<div class="modal-header">
  <a class="close" data-dismiss="modal">&times;</a>
  <h3>Send Singel SMS</h3>
</div>
<div class="modal-body">
  <form method="POST">
<input type="hidden" value="<?php echo $id; ?>"  name="userid" />
  <div class="control-group">
    <label class="control-label">Phone Number</label>
    <div class="controls">
      <input type="number" required  minlength="11" maxlength="11"
data-validation-maxlength-message="please enter your correct phone number (11 digit)" 
data-validation-minlength-message="please enter your correct phone number (11 digit)" name="phonenumber" />
      <p class="help-block"></p>
    </div>
  </div>

  <div class="control-group">
    <label class="control-label">SMS Body</label>
    <div class="controls">
      <textarea rows="3"  onkeyup="countChar(this)"  maxlength="160" required name="smsbody"></textarea>
      <div>Character Remain : <div id="charNum">160</div></div>
      <p class="help-block"></p>
    </div>
  </div>
<input type="hidden" value="singelsms" name="singelsms" >
  </form>
</div>
<div class="modal-footer">
  <a class="btn btn-primary" onclick="$('.modal-body > form').submit();">Send SMS</a>
  <a class="btn" data-dismiss="modal">Close</a>
</div>
<script src="assets/js/jqBootstrapValidation.js"></script>
<script type="text/javascript">
$(function () { $("input,select,textarea").not("[type=submit]").jqBootstrapValidation(); } );

 function countChar(val) {
        var len = val.value.length;
        if (len >= 160) {
          val.value = val.value.substring(0, 160);
        } else {
          $('#charNum').text(160 - len);
        }
      };
</script>