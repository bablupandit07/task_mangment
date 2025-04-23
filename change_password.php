<?php
include("adminsession.php");
if (!isset($_SESSION['userid'])) {
    header("Location: index.php?msg=invalid");
    exit();
}
$user_id = $_SESSION['userid'];
$user = $obj->select_record('user', array('id' => $user_id));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    if ($newPassword === $confirmPassword) {
        
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $form_data = array(
            'password' => $hashedPassword,
            'temp_pass' => $newPassword,
            'last_password_change' => date('Y-m-d H:i:s')
        );

        $obj->update_record('user', array('id' => $user_id), $form_data);
        header("Location: admin/index.php");
        exit();
    } else {
        $error_message = "Passwords do not match. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Change Your Password</h2>

    <?php
    // Display error message if passwords don't match
    if (isset($error_message)) {
        echo "<div class='alert alert-danger'>$error_message</div>";
    }
    ?>

    <form method="POST">
        <div class="mb-3">
            <label for="new_password" class="form-label">New Password</label>
            <input type="password" name="new_password" id="new_password" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password" id="confirm_password" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Change Password</button>
    </form>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
