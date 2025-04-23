<div class="offcanvas show shadow-sm text-white offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false"
    tabindex="-1" id="staticBackdrop" aria-labelledby="staticBackdropLabel" style="width: 230px;background: #06163a;">
    <div class="offcanvas-header shadow-sm">
    
        <h5 class="offcanvas-title" id="staticBackdropLabel"><?php 
echo $obj->getvalfield("user", "CONCAT(first_name, ' ', last_name)", "id='$loginid'");
?>
</h5>
        <button type="button" class="btn-close d-lg-none" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <hr class="mt-0" />
    <div class="offcanvas-body p-0">
        <ul class="nav flex-column mt-3">
            <li class="nav-item shadow-sm">
                <a class="nav-link <?php echo ($pagename == "index.php") ? "active" : ""; ?>" href="index.php">
                    <i class="bi bi-speedometer2"></i> &nbsp; Dashboard
                    <span class="float-end"><i class="bi bi-chevron-right"></i></span>
                </a>
            </li>
         
<?php if($_SESSION['role'] == "admin") { ?>


            <li class="nav-item shadow-sm">
                <a class="nav-link <?php echo ($pagename == "user_master.php") ? "active" : ""; ?>"
                    href="user_master.php">
                    <i class="bi bi-person"></i> &nbsp; Users Entry
                    <span class="float-end"><i class="bi bi-chevron-right"></i></span>
                </a>
            </li>
            <li class="nav-item shadow-sm">
                <a class="nav-link <?php echo ($pagename == "task_report.php") ? "active" : ""; ?>"
                    href="task_report.php">
                    <i class="bi-card-checklist"></i> &nbsp; Task Report
                    <span class="float-end"><i class="bi bi-chevron-right"></i></span>
                </a>
            </li>
            <?php } ?>
            <?php if($_SESSION['role'] == "user") { ?>
                <li class="nav-item shadow-sm">
                <a class="nav-link <?php echo ($pagename == "add_task.php") ? "active" : ""; ?>"
                    href="add_task.php">
                    <i class="bi bi-card-checklist"></i> &nbsp; Add Task

                    <span class="float-end"><i class="bi bi-chevron-right"></i></span>
                </a>
            </li> <?php
} ?>            
            <!-- <li class="nav-item shadow-sm">
                <a class="nav-link <?php echo ($pagename == "change-password.php") ? "active" : ""; ?>"
                    href="change-password.php">
                    <i class="bi bi-lock"></i> &nbsp; Change Password
                    <span class="float-end"><i class="bi bi-chevron-right"></i></span>
                </a>
            </li> -->

        </ul>
    </div>

</div>