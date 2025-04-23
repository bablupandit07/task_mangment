<?php
include("../adminsession.php");
$title = "Create/Edit Task";
$pagename = "add_task.php";
$tblname = "tasks";
$tblpkey = "id";
$keyvalue = isset($_GET['taskid']) ? $_GET['taskid'] : 0;
$action = isset($_GET['action']) ? $_GET['action'] : "";

if ($_SESSION['role'] == 'admin') {
    header("Location: index/index.php?msg=invalid");
    exit();
}
if (isset($_POST['submit'])) {
    $user_id = $loginid;
    $start_time = $_POST['start_time'];
    $stop_time = $_POST['stop_time'];
    $notes = $obj->test_input($_POST['notes']);
    $description = $obj->test_input($_POST['description']);
    
    // Prepare form data
    $form_data = array(
        'user_id' => $user_id,
        'start_time' => $start_time,
        'stop_time' => $stop_time,
        'notes' => $notes,
        'description' => $description
    );

    if ($keyvalue == 0) {
        $obj->insert_record($tblname, $form_data);
        $action = "1"; // Insert action
    } else {
        $where = array($tblpkey => $keyvalue);
        $obj->update_record($tblname, $where, $form_data);
        $action = "2"; // Update action
    }

    echo "<script>location='$pagename?action=$action'</script>";
}

if ($keyvalue > 0) {
    $data = $obj->select_record($tblname, array($tblpkey => $keyvalue));
    $user_id = $data['user_id'];
    $start_time = $data['start_time'];
    $stop_time = $data['stop_time'];
    $notes = $data['notes'];
    $description = $data['description'];
} else {
    $user_id  = $notes = $description = "";
    $start_time=date("Y-m-d h:i:s");
    $stop_time=date("Y-m-d h:i:s");
}

// Fetch all tasks for display
$tasks = $obj->executequery("SELECT * FROM tasks where user_id = $loginid");
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
                                    Task Entry
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        
                                        <div class="col-md-6 mb-3">
                                            <label>Start Time *</label>
                                            <input type="datetime-local" class="form-control" name="start_time" value="<?php echo $start_time; ?>" required>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label>Stop Time *</label>
                                            <input type="datetime-local" class="form-control" name="stop_time" value="<?php echo $stop_time; ?>" required>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label>Notes</label>
                                            <textarea class="form-control" name="notes" rows="4"><?php echo $notes; ?></textarea>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label>Description</label>
                                            <textarea class="form-control" name="description" rows="4" required><?php echo $description; ?></textarea>
                                        </div>
                                        <div class="col-md-12">
                                            <button type="submit" name="submit" class="btn btn-success">Save</button>
                                            <a href="add_task.php" class="btn btn-danger">Reset</a>
                                        </div>
                                    </div>
                                    <input type="hidden" name="<?php echo $tblpkey; ?>" value="<?php echo $keyvalue; ?>">
                                </div>
                            </div>
                        </form>
                    </fieldset>
                </div>
            </div>

            <!-- Display Tasks Below -->
            <div class="row mt-4">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-white" style="background-color: #06163a;">
                            Task Records
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Start Time</th>
                                            <th>Stop Time</th>
                                            <th>Notes</th>
                                            <th>Description</th>
                                            <th>Edit</th>
                                            <th>Delete</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $sl = 1;
                                        foreach ($tasks as $task) {
                                            $start_time_formatted = date("d-m-Y H:i:s", strtotime($task['start_time']));
                                            $stop_time_formatted = date("d-m-Y H:i:s", strtotime($task['stop_time']));
                                            echo "
                                            <tr>
                                                <td>{$sl}</td>
                                                <td>{$start_time_formatted}</td>
                                                <td>{$stop_time_formatted}</td>
                                                <td>{$task['notes']}</td>
                                                <td>{$task['description']}</td>
                                                <td>
                                                    <a href='add_task.php?taskid={$task['id']}' class='btn btn-sm btn-warning'>Edit</a>
                                                </td>
                                                <td>
                                                    <button class='btn btn-sm btn-danger' onclick='funDel({$task['id']})'>Delete</button>
                                                </td>
                                            </tr>
                                            ";
                                            $sl++;
                                        }
                                        ?>
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
