<?php
require_once "../config/app.php";
require_once MAIN_PATH . "inc/header.php";
$data = get_all_data("department");

?>

<div class="push-alret"
    style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;background: rgba(0,0,0,0.5);display: none;justify-content: center;align-items: center; z-index: 100">
    <div style="width: 400px;height: 200px;position: relative; "
        class="bg-light rounded d-flex align-items-center p-3 flex-column justify-content-center">
        <i onclick="close_alert('.push-alret')" style="position: absolute;top: 10px;right: 10px;cursor: pointer" id="close"
            class="fa-solid fa-x"></i>
        <p>Are you sure you want to delete this department</p>
        <div class="btns">
            <button onclick="close_alert('.push-alret')" class="btn btn-primary">No</button>
            <button  class="btn btn-danger"><a id="delete_item" class="text-light text-decoration-none"
                    href="#">Yes</a></button>
        </div>
    </div>

</div>

<div class="push-edit"
    style="height:calc(100vh - 56px) ; position: absolute; left: 0; right: 0; bottom: 0; width: 100%;background: #08080875;display:none;justify-content: center;align-items: center;z-index: 1;">
    <div class="edit-windo" style="height:500px; width:700px; position:relative;">
        <div class="row">
            <div class="col-12 mx-auto">
                <i onclick="close_alert('.push-edit')"  style="position: absolute; right: 10px; top: 10px;cursor:pointer;" class="fa-solid fa-x"></i>
                <form action="<?= URL."/departments/requests/edit.php"?>" method="POST"
                    class="form-group  p-5 bg-light rounded shadow mb-5 border">
                    <label for="edit-dep" class="form-label">Edit department</label>
                    <input type="text" class="form-control" id="edit-dep" name="edit_dep">
                    <input type="hidden" style="display" class="form-control" id="dep_id" name="dep_id">
                    <button class="btn btn-primary mt-3">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-8 my-5 mx-auto">
            <?php
            alert_display("erorrs","danger");

            alert_display("success","success");
            ?>
            <h1 class="text-center p-3 border-bottom">Departments</h1>
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $value): ?>
                        <tr>
                            <td>
                                <?= $value["id"] ?>
                            </td>
                            <td>
                                <?= $value["name"] ?>
                            </td>
                            <td  data-id="<?= $value["id"] ?>">
                            <i id="delete-btn" style="cursor: pointer;color:red;padding:10px;background: #e24d4d17;border-radius: 8px;" class="fa-solid fa-trash"></i>
                            <i id="edit-btn" data-name= "<?= $value["name"] ?>" style="cursor: pointer;color:blue;padding:10px;background: #0a2ce012;border-radius: 8px;" class="fa-solid fa-pen-to-square"></i>
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
    let sendId
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

    let editBtn =document.querySelectorAll("#edit-btn");
    let editInput = document.querySelector('#edit-dep');
    let idInput = document.querySelector('#dep_id');
    console.log(editInput);
    editBtn.forEach(btn =>{
        btn.addEventListener("click",()=>{
            let id = btn.parentElement.getAttribute("data-id");
            document.querySelector(".push-edit").style.display = "flex";
            let depName = btn.getAttribute("data-name");
            editInput.value = depName
            idInput.value = id
        })
    })

</script>

<?php require_once MAIN_PATH . "inc/footer.php";
 ?>