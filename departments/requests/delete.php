<?php
require_once "../../config/app.php";
echo isset($_GET["id"]) ? "done" : "not done";
if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET["id"])){
        $id = $_GET["id"];
        if(check_id("department",$id)){
            if(delete_item("department",$id)){
                $_SESSION['success'] = ["department deleted"];
            }
        }else{
            $_SESSION['erorrs'] = ["something went wrong" . mysqli_error($conn)];
        }
    }
    header("location:" . URL . "/departments/index.php");
}
