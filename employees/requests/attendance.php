<?php
require_once "../../config/app.php";
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    foreach ($_GET as $key => $value) {
        $$key = sanitarize($value);
    }
    $errors = [];
    $time = date("H:i:a");
    $date = date("Y-m-d");
    if (!check_id("employees", $id)) {
        $errors[] = "Invalid Employee ID";
    }
    if ($type != "attendance" or $type != "departure") {
        $erorrs[] = "Invalid type";
    }
    if (empty($errors)) {
        if ($type == "attendance") {
            $sql = "INSERT INTO attendance (attendance_at,date_day,emp_id) Values('$time','$date','$id')";
            $result = mysqli_query($conn,$sql);
            if($result){
                $_SESSION["success"] = ["attendance updated"];
            }
        } elseif ($type == "departure") {
            if(check_if_attendance($id)[0]['attendance_at'] == ""){
                $_SESSION["erorrs"] = ["can not update departure without attendance"];
                header("location:" . URL . "/employees/index.php");
                exit();
            }
            $sql = "UPDATE attendance SET departure_at = '$time' WHERE date_day = '$date' AND emp_id = '$id'";
            $result = mysqli_query($conn,$sql);
            if(mysqli_affected_rows($conn) > 0){
                $_SESSION["success"] = ["departure updated"];
            }else{
                $_SESSION["erorrs"] = ["can not update departure" . mysqli_error($conn) ];
            }
        }
        

    }else{
        $_SESSION["erorrs"] = $errors;
    }
    header("location:" . URL . "/employees/index.php");
}