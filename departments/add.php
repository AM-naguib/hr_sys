<?php require_once "../config/app.php"; ?>
<?php require_once MAIN_PATH . "/inc/header.php"; ?>
<div class="container">
    <div class="row">
        <div class="col-8 mx-auto">
            
            <h1 class="text-center my-2 border-bottom border-2 p-3">Add Department</h1>
            <form action="<?= URL . "/departments/requests/store.php" ?>" method="POST" class="form border p-3">
                <div class="mb-3">
                    <?php 
                        alert_display("erorrs","danger");
                        alert_display("success","success");

                     ?>
                    <label for="name" class="form-label">Department Name</label>
                    <input type="text" class="form-control" id="name" name="dep_name">
                </div>
                <div class="mb-3">
                    <button class="form-control text-white bg-success ">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>