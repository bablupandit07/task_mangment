<?php
include("action.php");



// print_r($_POST);

if (isset($_POST['login'])) {
    // echo "sdf";die;
    $email = trim($_POST['email_id']);
    $password = trim($_POST['admin_pwd']);

    if ($email != "" && $password != "") {
        $user = $obj->get_user_by_email("user",$email);


        if ($user) {

            $valid = password_verify($password, $user['password']) || md5($password) === $user['md5_password'];
                if ($valid) {
                		// print_r($user);die;

				$obj->update_record("user", ["id" => $user['id']], ["last_login" => date("Y-m-d H:i:s")]);
                // Store session
                $_SESSION['userid'] = $user['id'];
                $_SESSION['role'] = $user['role'];

                // Check if password needs to be changed
                $lastChanged = strtotime($user['last_password_change']);
                $isFirst = $user['is_first_login'];

                if ($isFirst==0 || $lastChanged < strtotime("-30 days")) {
                    header("Location: change_password.php");
                } else {
                    header("Location: " . ($user['role'] === 'admin' ? 'admin/index.php' : 'admin/index.php'));
                }
                exit;
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "User not found.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}else {
    $error = "Invalid request.";
}
?>
