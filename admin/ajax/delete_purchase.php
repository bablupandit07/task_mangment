<?php include("../../adminsession.php");

$id = $_POST['id'];
$tblname = $_REQUEST['tblname'];
$tblpkey = $_REQUEST['tblpkey'];
$type = $_REQUEST['type'];
if ($id > 0) {
   $paywhere = array($tblpkey => $id, 'payment_from' => "sale");
   $obj->delete_record("payments", $paywhere);

   $where = array($tblpkey => $id, 'type' => $type);
   $keyvalue = $obj->delete_record("purchase_details", $where);
   $keyvalue = $obj->delete_record($tblname, $where);
}
