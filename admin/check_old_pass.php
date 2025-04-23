<?php
include("../adminsession.php");
$oldpass = $_SERVER['QUERY_STRING'];
$loginid = $_SESSION['userid'];

$where = array('password' => $oldpass, 'userid' => $loginid);
$cnt = $obj->count_method("user", $where);

$idname = "";

if ($cnt != 0)
   $idname = "<span style='color:green'>Old passsword is correct</span>";
else
   $idname = "<span style='color:red'>Old password is wrong</span>";

echo $idname;
