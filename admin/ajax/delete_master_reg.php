<?php include("../../adminsession.php");
$m_student_reg_id  = $_REQUEST['id'];
$tblname  =$_REQUEST['tblname'];
$tblpkey  =$_REQUEST['tblpkey'];
$module = $_REQUEST['module'];
$submodule = $_REQUEST['submodule'];
$pagename = $_REQUEST['pagename'];
//print_r($_REQUEST);die;

$where = array($tblpkey=>$m_student_reg_id);
$obj->delete_record("class_transfer",$where);

$where = array($tblpkey=>$m_student_reg_id);
$obj->delete_record($tblname,$where);

	echo "<script>location='$pagename?action=3';</script>";

?>