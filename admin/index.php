<?php
include("../adminsession.php");
$title = "Dashboard";
$pagename = "index.php";
$total_user= $obj->getvalfield("user", "count(*)", "role='user'");

$total_task= $obj->getvalfield("tasks", "count(*)", "1=1");
$today_task= $obj->getvalfield("tasks", "count(*)", "date(start_time) = date(now())");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- meta tag -->
    <?php include('component/css.php'); ?>
    <!-- meta tag -->
    <style>
        a {
            text-decoration: none;
        }
    </style>

</head>

<body class="bg-light">
    <!-- Sidebar -->
    <?php include('component/sidebar.php'); ?>
    <!-- Sidebar Close-->
    <div class="main w-auto">
        <!-- Header -->
        <?php include('component/header.php'); ?>
        <!-- Header Close-->
        <!-- Content -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <fieldset class="mt-3">
                        <legend>Dashboard</legend>
                        <div class="row">
                            <?php if ($_SESSION['role'] == 'admin') { ?>
                            <div class="col-md-3">
                                <div class="card mb-3 bg-success bg-gradient shadow-sm">
                                    <a href="product_master.php">
                                        <div class="card-body text-white">
                                            <div class="row">

                                                <div class="col-8">
                                                    <strong>Total User</strong>
                                                    <h5 class="card-title">
                                                        <?php echo $total_user; 
                                                        ?></h5>
                                                </div>
                                                <div class="col-4 text-end">
                                                    <i class="bi bi-boxes fs-2"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mb-3 bg-warning bg-gradient shadow-sm">
                                    <a href="customer_master.php">
                                        <div class="card-body text-white">
                                            <div class="row">

                                                <div class="col-8">
                                                    <strong>Total Task</strong>
                                                    <h5 class="card-title">
                                                        <?php echo $total_task; 
                                                        ?></h5>
                                                </div>
                                                <div class="col-4 text-end">
                                                    <i class="bi bi-people-fill fs-2"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mb-3 bg-info bg-gradient shadow-sm">
                                    <a href="supplier_master.php">
                                        <div class="card-body text-white">
                                            <div class="row">

                                                <div class="col-8">
                                                    <strong>Today Task</strong>
                                                    <h5 class="card-title">
                                                        <?php echo $today_task; 
                                                        ?></h5>
                                                </div>

                                                <div class="col-4 text-end">
                                                    <i class="bi bi-people-fill fs-2"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>


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
                                            <th>User Name</th>
                                            <th>Start Time</th>
                                            <th>Stop Time</th>
                                            <th>Notes</th>
                                            <th>Description</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $tasks = $obj->executequery("SELECT * FROM tasks ORDER BY start_time ASC ");

                                        $sl = 1;
                                        foreach ($tasks as $task) {
                                            $userid = $task['user_id'];
                                            $user = $obj->select_record("user", ["id" => $userid]);
                                            $start_time_formatted = date("d-m-Y H:i:s", strtotime($task['start_time']));
                                            $stop_time_formatted = date("d-m-Y H:i:s", strtotime($task['stop_time']));
                                            $user_name = $user['first_name']." ". $user['last_name'];
                                            echo "
                                            <tr>
                                                <td>{$sl}</td>
                                                <td>{$user_name}</td>
                                                <td>{$start_time_formatted}</td>
                                                <td>{$stop_time_formatted}</td>
                                                <td>{$task['notes']}</td>
                                                <td>{$task['description']}</td>
                                               
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
                            

                         <?php }else { ?>
                            <div class="col-md-3">
                                <div class="card mb-3 bg-warning bg-gradient shadow-sm">
                                    <a href="customer_master.php">
                                        <div class="card-body text-white">
                                            <div class="row">

                                                <div class="col-8">
                                                    <strong>Total Task</strong>
                                                    <h5 class="card-title">
                                                        <?php echo $total_task; 
                                                        ?></h5>
                                                </div>
                                                <div class="col-4 text-end">
                                                    <i class="bi bi-people-fill fs-2"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card mb-3 bg-info bg-gradient shadow-sm">
                                    <a href="supplier_master.php">
                                        <div class="card-body text-white">
                                            <div class="row">

                                                <div class="col-8">
                                                    <strong>Today Task</strong>
                                                    <h5 class="card-title">
                                                        <?php echo $today_task; 
                                                        ?></h5>
                                                </div>

                                                <div class="col-4 text-end">
                                                    <i class="bi bi-people-fill fs-2"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>



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
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php

                                        $tasks = $obj->executequery("SELECT * FROM tasks where user_id = $loginid ORDER BY start_time ASC ");

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

                            <?php } ?>

                        </div>

                    </fieldset>
                </div>

            </div>

        </div>
    </div>

</body>

<!-- script tag -->
<?php include('component/script.php'); ?>
<!-- script tag -->

</html>