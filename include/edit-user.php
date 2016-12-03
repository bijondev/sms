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
  <h3>Edit User "<?php echo $_name; ?>"</h3>
</div>
<div class="modal-body">
  <form method="POST">
    <table>
        <tr>
            <td><input type="hidden" name="hiden_id" value="<?php echo $_id; ?>" >
              <label>Name : </label></td>
            <td>
                <div class="control-group">
                    <div class="controls">
                      <input type="text" data-validation-required-message="please enter full name." value="<?php echo $_name; ?>" name="username" required  />
                      <p class="help-block"></p>
                    </div>
                  </div>
            </td>
        </tr>
            <tr>
            <td><label>Email : </label></td>
            <td>  <div class="control-group">
                    <div class="controls">
                      <input type="email" value="<?php echo $_email; ?>" name="email" required  />
                      <p class="help-block"></p>
                    </div>
                  </div>
</td>
        </tr>

            <tr>
            <td><label>Company : </label></td>
            <td><input type="text" value="<?php echo $_company; ?>" name="company"  /></td>
        </tr>
            <tr>
            <td><label>Address : </label></td>
            <td><textarea name="address" rows="3"><?php echo $_address; ?></textarea></td>
        </tr>
            <tr>
            <td><label>User Type : </label></td>
            <td><div class="control-group">
                    <div class="controls" >
                      <select name="usertype" required >
                          <option></option>
                          <option <?php if($_usertype=="A") echo "selected"; ?> value="A">Admin</option>
                          <option <?php if($_usertype=="U") echo "selected"; ?> value="U">User</option>
                          <option <?php if($_usertype=="C") echo "selected"; ?> value="C">SMS Consol</option>
                        </select>
                      <p class="help-block"></p>
                    </div>
                  </div></td>
        </tr>
        <tr>
            <td><label>Status : </label></td>
            <td><label class="radio">
  <input type="radio" <?php if($_status=="D") echo "checked"; ?> name="status" id="optionsRadios1" value="D" >
Diesable
</label>
<label class="radio">
  <input type="radio" <?php if($_status=="E") echo "checked"; ?> name="status" id="optionsRadios2" value="E">
  Enable
</label>
<input type="hidden" name="edituser" value="edituser" >
</td>
        </tr>
    </table>
    </form>
</div>
<div class="modal-footer">
  <a class="btn btn-primary" onclick="$('.modal-body > form').submit();">Save Changes</a>
  <a class="btn" data-dismiss="modal">Close</a>
</div>