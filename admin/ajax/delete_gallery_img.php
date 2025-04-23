<?php include("../../adminsession.php");

$id  = $_REQUEST['id'];
$tblname  = $_REQUEST['tblname'];
$tblpkey  = $_REQUEST['tblpkey'];
$module = $_REQUEST['module'];
$submodule = $_REQUEST['submodule'];
$pagename = $_REQUEST['pagename'];
$imgpath = $_REQUEST['imgpath'];
$type = $_REQUEST['type'];
$where = array($tblpkey => $id, "type" => $type);
$res = $obj->select_record($tblname, $where);
$flyer_upload = $res['flyer_upload'];
$checklist_upload = $res['checklist_upload'];
$img_upload    = $res['img_upload'];
$media_covage = $res['media_covage'];
$samiksha_upload = $res['samiksha_upload'];
if ($id != "") {
   if ($samiksha_upload != "") {
      // echo $samiksha_upload;
      // die;
      @unlink("../$imgpath" . $samiksha_upload);
   }
   if ($media_covage != "") {
      @unlink("../$imgpath" . $media_covage);
   }
   if ($samiksha_upload != "") {
      @unlink("../$imgpath" . $samiksha_upload);
   }
   if ($img_upload != "") {
      @unlink("../$imgpath" . $img_upload);
   }
   if ($checklist_upload != "") {
      @unlink("../$imgpath" . $checklist_upload);
   }
   if ($flyer_upload != "") {
      @unlink("../$imgpath" . $flyer_upload);
   }
   // die;
   $obj->delete_record($tblname, $where);
}
