<style>
    /* width */
    ::-webkit-scrollbar {
        width: 6px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background: #c3c3c3;
    }

    /* Handle on hover */
    ::-webkit-scrollbar-thumb:hover {
        background: #919191;
    }

    .margin {
        margin-left: 70%;
    }
</style>

<nav class="navbar bg-white shadow-sm border-bottom">
    <div class="container-fluid ">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="d-flex">
            <!-- <a href="#" class="position-relative me-4">
                <i class="bi bi-bell-fill text-dark"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge border border-light rounded-circle bg-danger">9</span>
            </a> -->
            <div class="dropdown">
                <a href="#" class="text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-person-circle text-dark"></i>
                </a>
                <ul class="dropdown-menu end-0 text-small shadow" aria-labelledby="dropdownUser1" style="left: auto;">
                    <li><a class="dropdown-item" href="user_master.php"><?php echo "Hi, " . ucfirst($obj->getvalfield("user", "first_name", "id='$loginid'")); ?></a></li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="logout.php">Sign out</a></li>
                </ul>
            </div>
        </div>
    </div>
</nav>