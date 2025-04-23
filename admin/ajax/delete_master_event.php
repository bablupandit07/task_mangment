<?php include("../../adminsession.php");

$id  = (int)$obj->test_input($_POST['id']);
$tblname  = $obj->test_input($_REQUEST['tblname']);
$tblpkey  = $obj->test_input($_REQUEST['tblpkey']);
$module = $obj->test_input($_REQUEST['module']);
$submodule = $obj->test_input($_REQUEST['submodule']);
$pagename = $obj->test_input($_REQUEST['pagename']);
$imagepath = "../uploaded/event/";
if ($id > 0) {
	$qry = $obj->getvalMultiple("event_images", "imgname", "event_id='$id'");
	foreach ($qry as $imgname) {
		if ($imgname != "")
			@unlink($imagepath . $imgname);
	}
	$where = array($tblpkey => $id);
	$obj->delete_record($tblname, $where);
}
