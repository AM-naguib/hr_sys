<?php
require_once "../config/app.php";
require_once MAIN_PATH . "inc/header.php";
$sql = "SELECT *,
department.id AS depa_id,
department.name AS depa_name,
employees.id AS empl_id,
employees.name AS empl_name
FROM employees
LEFT JOIN department ON employees.dep_id = department.id;
";
$results = mysqli_query($conn, $sql);
$data = [];
while ($row = mysqli_fetch_assoc($results)) {
    $data[] = $row;
}
$department = get_all_data("department");
?>

<div class="push-alret"
    style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;background: rgba(0,0,0,0.5);display: none;justify-content: center;align-items: center; z-index: 100">
    <div style="width: 400px;height: 200px;position: relative; "
        class="bg-light rounded d-flex align-items-center p-3 flex-column justify-content-center">
        <i onclick="close_alert('.push-alret')" style="position: absolute;top: 10px;right: 10px;cursor: pointer"
            id="close" class="fa-solid fa-x"></i>
        <p>Are you sure you want to delete this department</p>
        <div class="btns">
            <button onclick="close_alert('.push-alret')" class="btn btn-primary">No</button>
            <button class="btn btn-danger"><a id="delete_item" class="text-light text-decoration-none"
                    href="#">Yes</a></button>
        </div>
    </div>

</div>

<div class="file-upload"
    style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;background: rgba(0,0,0,0.5);display: none;justify-content: center;align-items: center; z-index: 100">
    <div style="width: 400px;height: 200px;position: relative; "
        class="bg-light rounded d-flex align-items-center p-3 flex-column justify-content-center">
        <i onclick="close_alert('.file-upload')" style="position: absolute;top: 10px;right: 10px;cursor: pointer"
            id="close" class="fa-solid fa-x"></i>
        <form action="<?= URL . "/employees/requests/fileUpload.php" ?>" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="formFile" class="form-label">Upload Employee Image</label>
                <input class="form-control" type="file" id="formFile" name="emp_img">
                <input class="form-control" type="hidden" id="emp_idU" name="emp_id">
            </div>
            <div class="mb-3">
                <button class="form-control text-white bg-success">Submit</button>
            </div>
        </form>
    </div>

</div>

<div class="push-edit"
    style="height:calc(100vh - 56px) ; position: absolute; left: 0; right: 0; bottom: 0; width: 100%;background: #08080875;display:none;justify-content: center;align-items: center;z-index: 1;">
    <div class="edit-windo" style="height:500px; width:700px; position:relative;">
        <div class="row">
            <div class="col-12 mx-auto">
                <i onclick="close_alert('.push-edit')"
                    style="position: absolute; right: 10px; top: 10px;cursor:pointer;" class="fa-solid fa-x"></i>
                <form action="<?= URL . "/employees/requests/edit.php" ?>" method="POST"
                    class="form-group  p-5 bg-light rounded shadow mb-5 border">
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
                        <input type="number" class="form-control" id="salary" name="emp_salary">
                    </div>
                    <div class="mb-3">
                        <input type="hidden" class="form-control" id="emp_id" name="emp_id">
                    </div>
                    <div class="mb-3">
                        <select name="emp_department" id="" class="form-control">
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
</div>
<div class="push-vacations"
    style="height:calc(100vh - 56px) ; position: absolute; left: 0; right: 0; bottom: 0; width: 100%;background: #08080875;display:none;justify-content: center;align-items: center;z-index: 1;">
    <div class="edit-windo" style="height:500px; width:700px; position:relative;">
        <div class="row">
            <div class="col-12 mx-auto " id="vacationsData">

            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12 my-5 mx-auto">
            <?php
            alert_display("erorrs", "danger");

            alert_display("success", "success");
            ?>
            <h1 class="text-center p-3 border-bottom">Employees</h1>
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Salary</th>
                        <th scope="col">Dep_name</th>
                        <th scope="col">Images</th>
                        <th scope="col">Vacations</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $value): ?>
                        <tr>
                            <td>
                                <?= $value["empl_id"] ?>
                            </td>
                            <td>
                                <?= $value["empl_name"] ?>
                                <div class="attendance my-2">
                                    <?php if(@check_if_attendance($value["empl_id"])[0]['attendance_at'] == ""): ?>
                                    <a href="<?= URL . "/employees/requests/attendance.php?id=" . $value["empl_id"] . "&type=attendance"  ?>" class="btn btn-primary">Attendance</a>
                                    <?php elseif(check_if_attendance($value["empl_id"])[0]['departure_at'] == ""): ?>
                                    <a href="<?= URL . "/employees/requests/attendance.php?id=" . $value["empl_id"] . "&type=departure"  ?>" class="btn btn-danger">Departure</a>
                                    <?php endif ?>
                                </div>

                            </td>
                            <td>
                                <?= $value["email"] ?>
                            </td>
                            <td>
                                <?= $value["phone"] ?>
                            </td>
                            <td>
                                <?= $value["salary"] ?>
                            </td>
                            <td>
                                <?= $value["depa_name"] ?>
                            </td>
                            <td class="d-none php-vactions">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty(get_vacation($value["empl_id"]))): ?>
                                            <?php
                                            $annual = 0;
                                            $sick = 0;
                                            $casual = 0;
                                            ?>
                                            <?php foreach (get_vacation($value["empl_id"]) as $vacation): ?>
                                                <?php if ($vacation["v_type"] == "annual")
                                                    $annual++;
                                                elseif ($vacation["v_type"] == "sick")
                                                    $sick++;
                                                elseif ($vacation["v_type"] == "casual")
                                                    $casual++;
                                                ?>
                                                <tr>
                                                    <td>
                                                        <?= $vacation["v_type"] ?>
                                                    </td>
                                                    <td>
                                                        <?= $vacation["v_date"] ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach ?>
                                            <tr >
                                                <td colspan="2" >
                                                    <?= " Sick = ". $sick . " Day , Casual = ". $casual . " Day , Annual = ". $annual . " Day" ?>
                                                </td>
                                            </tr>
                                            <tr >
                                                <td colspan="2" >
                                                    Total : <?=  $sick + $casual + $annual ?>
                                                </td>
                                            </tr>
                                        <?php endif ?>

                                    </tbody>
                                </table>
                            </td>
                            <td>
                                <?php if (!empty(get_emp_images($value["empl_id"]))): ?>
                                    <?php $i = 1 ?>
                                    <?php foreach (get_emp_images($value["empl_id"]) as $imgs): ?>
                                        <?php foreach ($imgs as $img): ?>
                                            <a class="text-decoration-none" href="<?= URL . $img ?>">img
                                                <?= $i++ ?>
                                            </a>
                                        <?php endforeach ?>
                                    <?php endforeach ?>
                                <?php else: ?>
                                    <p>no image</p>
                                <?php endif ?>

                            </td>
                            <td class="text-center">
                                <a href="<?= URL . "/employees/requests/vacations.php?id=" . $value["empl_id"] . "&v_type=annual" ?>"
                                    class="btn btn-primary">Annual</a>
                                <a href="<?= URL . "/employees/requests/vacations.php?id=" . $value["empl_id"] . "&v_type=sick" ?>"
                                    class="btn btn-warning">Sick</a>
                                <a href="<?= URL . "/employees/requests/vacations.php?id=" . $value["empl_id"] . "&v_type=casual" ?>"
                                    class="btn btn-danger">Casual</a>
                                <button class="btn btn-success" id="vBtnShow">Show All Vacations</button>
                            </td>
                            <td data-id="<?= $value["empl_id"] ?>">
                                <i id="delete-btn"
                                    style="cursor: pointer;color:red;padding:10px;background: #e24d4d17;border-radius: 8px;"
                                    class="fa-solid fa-trash"></i>
                                <i id="edit-btn" data-name="<?= $value["empl_id"] ?>"
                                    style="cursor: pointer;color:blue;padding:10px;background: #0a2ce012;border-radius: 8px;"
                                    class="fa-solid fa-pen-to-square"></i>
                                <i id="upload-btn" data-name="<?= $value["empl_id"] ?>"
                                    style="cursor: pointer;color:#141417;padding:10px;background: #2f2f2f12;border-radius: 8px;"
                                    class="fa-solid fa-upload"></i>
                            </td>
                        </tr>
                    <?php endforeach; ?>

                </tbody>
            </table>

        </div>
    </div>
</div>

<script>
    // alert for delete
    let deleteBtn = document.querySelectorAll("#delete-btn");
    let deleteItem = document.querySelector("#delete_item");

    deleteBtn.forEach(btn => {
        btn.addEventListener("click", () => {
            let id = btn.parentElement.getAttribute("data-id");
            document.querySelector(".push-alret").style.display = "flex";
            deleteItem.href = "requests/delete.php?id=" + id
        })
    })


    function close_alert(container) {
        document.querySelector(container).style.display = "none";


    }
    // edit 

    let editBtn = document.querySelectorAll("#edit-btn");
    let idInput = document.querySelector('#emp_id');
    let empName = document.querySelector('#name')
    let empEmail = document.querySelector('#email')
    let empPhone = document.querySelector('#phone')
    let empSalary = document.querySelector('#salary')


    editBtn.forEach((btn, index) => {
        btn.addEventListener("click", () => {
            let id = btn.parentElement.getAttribute("data-id");
            document.querySelector(".push-edit").style.display = "flex";
            let name = btn.parentElement.parentElement.getElementsByTagName('td')[1].textContent;
            let email = btn.parentElement.parentElement.getElementsByTagName('td')[2].textContent;
            let phone = btn.parentElement.parentElement.getElementsByTagName('td')[3].textContent;
            let salary = btn.parentElement.parentElement.getElementsByTagName('td')[4].textContent;
            idInput.value = id.trim()
            empName.value = name.trim()
            empEmail.value = email.trim()
            empPhone.value = phone.trim()
            empSalary.value = salary.trim()

        })
    })
    let fileUpload = document.querySelectorAll("#upload-btn");
    let uploadEmpId = document.querySelector("#emp_idU");
    fileUpload.forEach(item => {
        item.addEventListener("click", () => {
            document.querySelector(".file-upload").style.display = "flex"
            let id = item.parentElement.getAttribute("data-id");
            uploadEmpId.value = id;
        })
    })

    let vacationBtn = document.querySelectorAll("#vBtnShow");
    let vacationData = document.querySelectorAll(".php-vactions");
    let vacationContainer = document.querySelector("#vacationsData")
    vacationBtn.forEach((btn, index) => {
        btn.addEventListener("click", () => {
            document.querySelector(".push-vacations").style.display = "flex"
            vacationContainer.innerHTML = `<i onclick="close_alert('.push-vacations')"style="position: absolute; right: 10px; top: 10px;cursor:pointer;" class="fa-solid fa-x"></i>`;

            vacationContainer.innerHTML += vacationData[index].innerHTML;

        })
    })
</script>

<?php require_once MAIN_PATH . "inc/footer.php";
?>