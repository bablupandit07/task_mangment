<?php include("../../adminsession.php");

$id  = $_POST['id'];
$tblname  = $_REQUEST['tblname'];
$tblpkey  = $_REQUEST['tblpkey'];
$module = $_REQUEST['module'];
$submodule = $_REQUEST['submodule'];
$pagename = $_REQUEST['pagename'];
if ($id > 0) {
   $where = array($tblpkey => $id, 'type' => 'issue');
   $keyvalue = $obj->delete_record("purchase_details", $where);
   $keyvalue = $obj->delete_record($tblname, $where);
}
