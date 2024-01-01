<?php require_once "../config/app.php"; ?>
<?php require_once MAIN_PATH . "/inc/header.php";
$department = get_all_data("department");
?>
<div class="container">
    <div class="row">
        <div class="col-8 mx-auto">

            <h1 class="text-center my-2 border-bottom border-2 p-3">Add Employees</h1>
            <?php
            alert_display("erorrs", "danger");
            alert_display("success", "success");

            ?>
            <form action="<?= URL . "/employees/requests/store.php" ?>" method="POST" class="form border p-3">
                <div class="mb-3">
                    <label for="name" class="form-label">Name : </label>
                    <input type="text" class="form-control" id="name" name="emp_name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email : </label>
                    <input type="email" class="form-control" id="email" name="emp_email">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone : </label>
                    <input type="text" class="form-control" id="phone" name="emp_phone">
                </div>
                <div class="mb-3">
                    <label for="salary" class="form-label">Salary : </label>
                    <input type="number" class="form-control" id="phone" name="emp_salary">
                </div>
                <div class="mb-3">
                    <select name="emp_department" id="" class="form-control">
                        <option value="">Select Department</option>
                        <?php foreach ($department as $dep): ?>
                            <option value="<?= $dep['id'] ?>">
                                <?= $dep['name'] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="mb-3">
                    <button class="form-control text-white bg-success ">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php require_once MAIN_PATH . "inc/footer.php";
?>