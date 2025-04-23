<?php
include("../adminsession.php");
$title = "Task Report";
$pagename = "task_report.php";
$tblname = "tasks";
$tblpkey = "id";
$keyvalue = isset($_GET['taskid']) ? $_GET['taskid'] : 0;
$action = isset($_GET['action']) ? $_GET['action'] : "";

if ($_SESSION['role'] != 'admin') {
    header("Location: index/index.php?msg=invalid");
    exit();
}

$where = " WHERE 1=1 ";


if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
    $from_date = $_GET['from_date'];
    $to_date = $_GET['to_date'];
    $where .= "and  DATE(start_time) BETWEEN '$from_date' AND '$to_date'";

}else {
    $from_date = date("Y-m-d");
    $to_date = date("Y-m-d");
}

if (isset($_GET['user_filter'])) {
    $user_filter = $_GET['user_filter'];
    if ($user_filter !== "" && $user_filter !== "all") {
        $where .= " AND user_id = " . intval($user_filter);
    }
} else {
    $user_filter = "all";
}   




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
                        <form method="Get">

                            <div class="card">
                                <div class="card-header text-white" style="background-color: #06163a;">
                                    Task Entry
                                </div>
                                <div class="card-body">
                                <div class="row">
                                <div class="col-md-3">
                                <label class="form-label">User</label>
                                <select name="user_filter" class="form-control">
                                    <option value="all" <?php if ($user_filter=="all") echo "selected"; ?>>All</option>
                                    <?php
                                    $users = $obj->executequery("SELECT id, first_name, last_name FROM user WHERE role != 'admin' ORDER BY first_name ASC");
                                    foreach ($users as $u) {
                                        $sel = ($user_filter == $u['id']) ? "selected" : "";
                                        echo "<option value='{$u['id']}' $sel>{$u['first_name']} {$u['last_name']}</option>";
                                    }
                                    ?>
                                </select>
                                    </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <label>From Date</label>
                                            <input type="date" class="form-control" name="from_date" value="<?php echo $from_date; ?>" required>
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label>To date</label>
                                            <input type="date" class="form-control" name="to_date" value="<?php echo $to_date; ?>" required>
                                        </div>
                                      
                                        <div class="col-md-4 mb-3">
                                            <br>
                                            <button type="search" name="search" class="btn btn-success">Search</button>
                                            <a href="task_report.php" class="btn btn-danger">Reset</a>
                                        </div>
                                    </div>
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
                            <button onclick="exportTableToCSV('task_report.csv')" class="btn btn-primary btn-sm " style="    margin-left: 77%;">Export CSV</button>
                        
                            <button onclick="exportTableToExcel('task_report.xls')" class="btn btn-success btn-sm">Export Excel</button>

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

                                        $tasks = $obj->executequery("SELECT * FROM tasks $where ORDER BY start_time ASC ");

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
            </div>

        </div>
    </div>
</body>

<?php include('component/script.php'); ?>



</html>
<script>
function downloadBlob(content, filename, type) {
    const blob = new Blob([content], { type });
    const a = document.createElement('a');
    a.href = URL.createObjectURL(blob);
    a.download = filename;
    a.click();
}

function exportTableToCSV(filename) {
    const rows = document.querySelectorAll("table tr");
    let csv = [];

    rows.forEach(row => {
        const cols = row.querySelectorAll("td, th");
        let rowData = [];
        cols.forEach(col => rowData.push(`"${col.innerText}"`));
        csv.push(rowData.join(","));
    });

    downloadBlob(csv.join("\n"), filename, "text/csv");
}

function exportTableToExcel(filename) {
    let table = document.querySelector("table").outerHTML;
    let dataType = 'application/vnd.ms-excel';
    let tableHTML = `<html xmlns:o="urn:schemas-microsoft-com:office:office" 
                         xmlns:x="urn:schemas-microsoft-com:office:excel" 
                         xmlns="http://www.w3.org/TR/REC-html40">
                         <head><meta charset="UTF-8"></head><body>${table}</body></html>`;
    downloadBlob(tableHTML, filename, dataType);
}
</script>
