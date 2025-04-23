<?php
include("../adminsession.php");
$title = "User Entry";
$pagename = "user_master.php";
$tblname = "user";
$tblpkey = "id";
$keyvalue = isset($_GET['userid']) ? $_GET['userid'] : 0;
$action = isset($_GET['action']) ? $_GET['action'] : "";

if (isset($_POST['submit'])) {
    $firstname = $obj->test_input($_POST['firstname']);
    $lastname = $obj->test_input($_POST['lastname']);
    $email = $obj->test_input($_POST['email']);
    $mobile = $obj->test_input($_POST['mobile']);
    $password = $obj->test_input($_POST['password']);
    $autoGeneratePassword = isset($_POST['auto_generate_password']); 
    $count = $obj->getvalfield("user", "count(*)", "email='$email' and id!='$keyvalue'");

    if ($count > 0) {
        echo "<script>alert('Email address already exists');</script>";
    } else {
        if ($autoGeneratePassword) {
            $password = generateRandomPassword();
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        } else {
            $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        }
        $form_data = array(
            'first_name' => $firstname,
            'last_name' => $lastname,
            'email' => $email,
            'phone' => $mobile,
            'password' => $passwordHash
        );
        if ($keyvalue == 0) {
            $form_data['password'] = $passwordHash; 
            $form_data['temp_pass'] = $password; 
            $form_data['md5_password'] = md5($password); 
            $obj->insert_record($tblname, $form_data);
            $action = "1";
        } else {
            $where = array($tblpkey => $keyvalue);
            $obj->update_record($tblname, $where, $form_data);
            $action = "2";
        }

        echo "<script>location='$pagename?action=$action'</script>";
    }
}
if ($keyvalue > 0) {
    $data = $obj->select_record($tblname, array($tblpkey => $keyvalue));
    $firstname = $data['first_name'];
    $lastname = $data['last_name'];
    $email = $data['email'];
    $mobile = $data['phone'];
    $password = $data['password'];
} else {
    $firstname = $lastname = $email = $mobile = $password = "";
}

function generateRandomPassword($length = 6) {
    return substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, $length);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('component/css.php'); ?>
    <title><?php echo $title; ?></title>
</head>

<body>
    <?php include('component/sidebar.php'); ?>
    <div class="main w-auto">
        <?php include('component/header.php'); ?>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <fieldset class="mt-3">
                        <legend><?php echo $title; ?></legend>
                        <?php include('component/alert.php'); ?>
                        <form method="POST">

                            <div class="card">
                                <div class="card-header text-white" style="background-color: #06163a;">
                                    User Entry
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label>First Name *</label>
                                            <input type="text" class="form-control" name="firstname" value="<?php echo $firstname; ?>" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Last Name *</label>
                                            <input type="text" class="form-control" name="lastname" value="<?php echo $lastname; ?>" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Email *</label>
                                            <input type="email" class="form-control" name="email" value="<?php echo $email; ?>" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Phone *</label>
                                            <input type="text" class="form-control" name="mobile" maxlength="10" value="<?php echo $mobile; ?>" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>Password *</label>
                                            <input type="password" class="form-control" name="password" id="password" value="<?php echo ($keyvalue > 0 && !$autoGeneratePassword) ? '********' : ''; ?>" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <input type="checkbox" name="auto_generate_password" id="auto_generate_password" <?php echo (isset($_POST['auto_generate_password']) ? 'checked' : ''); ?> />
                                            <label for="auto_generate_password">Auto-Generate Password</label>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" name="submit" class="btn btn-success">Save</button>
                                            <a href="user_master.php" class="btn btn-danger">Reset</a>
                                        </div>
                                    </div>
                                    <input type="hidden" name="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                                </div>
                            </div>
                        </form>
                    </fieldset>
                </div>
            </div>
            <!-- Table Section Below -->
            <div class="row mt-4 mb-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #06163a;">
                            User Records
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>First Name</th>
                                            <th>Last Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Password</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sl = 1;
                                        $res = $obj->executequery("SELECT * FROM user where role!='admin' ORDER BY id DESC");
                                        foreach ($res as $row) {
                                        ?>
                                            <tr>
                                                <td><?php echo $sl++; ?></td>
                                                <td><?php echo $row['first_name']; ?></td>
                                                <td><?php echo $row['last_name']; ?></td>
                                                <td><?php echo $row['email']; ?></td>
                                                <td><?php echo $row['phone']; ?></td>
                                                <td><?php echo $row['temp_pass']; ?></td>
                                                <td>
                                                    <a href="user_master.php?userid=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Edit</a>
                                                </td>
                                                <td>
                                                    <button class="btn btn-sm btn-danger" onclick="funDel(<?php echo $row['id']; ?>)">Delete</button>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>
<?php include('component/script.php'); ?>

<script>
    document.getElementById('auto_generate_password').addEventListener('change', function() {
        var passwordField = document.getElementById('password');
        if (this.checked) {
            passwordField.value = '';
            passwordField.readOnly = true;
            passwordField.removeAttribute('required');
        } else {
            passwordField.readOnly = false;
            passwordField.setAttribute('required', 'required');
        }
    });
</script>

<script>
    function funDel(id) {
        if (confirm("Are you sure you want to delete this record?")) {
            $.ajax({
                type: 'POST',
                url: 'ajax/delete_master.php',
                data: {
                    id: id,
                    tblname: '<?php echo $tblname; ?>',
                    tblpkey: '<?php echo $tblpkey; ?>',
                    pagename: '<?php echo $pagename; ?>',
                    submodule: 'User Master',
                    module: 'User Master'
                },
                success: function(response) {
                    location="<?php echo $pagename; ?>?action=3";
                }
            });
        }
    }
</script>

</html>
