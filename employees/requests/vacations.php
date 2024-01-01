<?php
require_once "../../config/app.php";
$erorrs = [];
if($_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET["id"]) && isset($_GET["v_type"])) {

        $allowed_vacations = ["annual","sick","casual"];
        $emp_id = $_GET["id"];
        $v_type = sanitarize($_GET["v_type"]);
        $v_date = date("Y-m-d");

        if(!in_array($v_type,$allowed_vacations)){
            $erorrs [] = "vacation type not allowed";
        }
        if(!check_id("employees",$emp_id)){
            $erorrs [] = "employee not found";
        }
        if(empty($erorrs)){
            $sql = "INSERT INTO vacation (emp_id,v_type,v_date) VALUES ('$emp_id','$v_type','$v_date')";
            if(insert_to_db($sql)){
                $_SESSION["success"] = ["vacation added"];
            }else{
                $_SESSION["erorrs"] = ["vacation not added"];
            }
        }else{
            $_SESSION["erorrs"] = $erorrs;
        }
        header("location:" . URL . "/employees/index.php");
}
}