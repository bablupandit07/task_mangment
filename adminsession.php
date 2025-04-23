<?php
include("action.php");
//print_r($_SESSION); die;

if (isset($_SESSION['role']) && $_SESSION['role'] != "" && isset($_SESSION['userid']) && $_SESSION['userid'] != "") {


	$loginid = $_SESSION['userid'];
	$role = $_SESSION['role'];
	//$company_id = isset($_SESSION['company_id'])?$_SESSION['company_id']:'';
	$createdate = date('Y-m-d H:i:s');
} else {
	echo "<script>location='../index.php?msg=invalid'</script>";
	die;
}
