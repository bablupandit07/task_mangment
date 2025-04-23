<?php
switch ($action) {
    case '1':
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert"  id="myElem">
                <strong><i class="bi bi-check-circle-fill" ></i> Record Inserted !!</strong> Successfully.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        break;
    case '2':
        echo '<div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong><i class="bi bi-check-circle-fill"></i> Record Updated !! </strong> Successfully.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
        break;
    case '3':
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><i class="bi bi-check-circle-fill"></i> Record Deleted !! </strong> Successfully.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        break;
    case '4':
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong><i class="bi bi-exclamation-triangle-fill"></i> Duplicate Record !! </strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>';
        break;
} ?>
<!-- <script>
    $("#myElem").show().delay(5000).queue(function(n) {
        $(this).hide();
        n();
    });
</script> -->