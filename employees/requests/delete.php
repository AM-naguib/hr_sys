<?php
require_once "../../config/app.php";

if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET["id"])){
        $id = $_GET["id"];
        if(check_id("employees",$id)){
            if(delete_item("employees",$id)){
                $_SESSION['success'] = ["employee deleted"];
            }
        }else{
            $_SESSION['erorrs'] = ["something went wrong" . mysqli_error($conn)];
        }
        header("location:" . URL . "/employees/index.php");
    }
}
