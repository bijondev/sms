<?php
include '../sanitizer_function/sanitizer.php';
$id=_rainsenitizedata(isset($_POST['id'])?$_POST['id']:NULL);
function __autoload($class) {
    include_once("../oopCrud.php");
}
$obj = new oopCrud;

echo $obj->deleteData($id, "_user");
?>