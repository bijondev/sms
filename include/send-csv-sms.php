<?php
include '../sanitizer_function/sanitizer.php';
$id=_rainsenitizedata(isset($_GET['id'])?$_GET['id']:NULL);
?>
<link href="assets/css/bootstrap-fileupload.css" rel="stylesheet">
<script src="assets/js/bootstrap-fileupload.js"></script>
<div class="modal-header">
  <a class="close" data-dismiss="modal">&times;</a>
  <h3>Send SMS from CSV File</h3>
</div>
<div class="modal-body">
  <form method="POST" enctype="multipart/form-data" >
<input type="hidden" value="<?php echo $id; ?>"  name="userid" />
<div class="fileupload fileupload-new" data-provides="fileupload">
  <div class="input-append">
    <div class="uneditable-input span3"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span>
    <input type="file" name="CSVfile" /></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
  </div>
</div>
  	<input type="hidden" value="CSvsms" name="CSvsms" >
    <a href="mycsv.csv">Download Sample CSV File</a>
  </form>
</div>
<div class="modal-footer">
  <a class="btn btn-primary" onclick="$('.modal-body > form').submit();">Send SMS</a>
  <a class="btn" data-dismiss="modal">Close</a>
</div>