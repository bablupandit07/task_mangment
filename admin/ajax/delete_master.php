<?php include("../../adminsession.php");

$id  = (int)$obj->test_input($_POST['id']);
$tblname  = $obj->test_input($_REQUEST['tblname']);
$tblpkey  = $obj->test_input($_REQUEST['tblpkey']);
if ($id > 0) {
	$where = array($tblpkey => $id);
	$obj->delete_record($tblname, $where);
}
