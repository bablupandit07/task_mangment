<?php include("../../adminsession.php");
$tblname = "m_gallery";
$tblpkey = "gallery_id";
$id  = (int)$obj->test_input($_POST['id']);
$imagepath = "../uploaded/gallery_master/";
if ($id > 0) {
	$imgname = $obj->getvalfield($tblname, "imgname", "$tblpkey='$id'");
	if ($imgname != "")
		@unlink($imagepath . $imgname);
	$where = array($tblpkey => $id);
	$obj->delete_record($tblname, $where);
}
