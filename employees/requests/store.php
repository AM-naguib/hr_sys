<?php

require_once '../../config/app.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $erorrs = [];
    foreach ($_POST as $key => $value) {
        $$key = sanitarize($value);
    }


    // name validation
    if (required_input($emp_name)) {
        $erorrs[] = "Name is required";
    } elseif (min_length($emp_name, 3)) {
        $erorrs[] = "Name must be at least 3 characters";
    } elseif (max_length($emp_name, 50)) {
        $erorrs[] = "Name must be at most 50 characters";
    }
    // email validation
    if (required_input($emp_email)) {
        $erorrs[] = "Email is required";
    } elseif (min_length($emp_email, 3)) {
        $erorrs[] = "Email must be at least 3 characters";
    } elseif (max_length($emp_email, 100)) {
        $erorrs[] = "Email must be at most 100 characters";
    } elseif (!filter_var($emp_email, FILTER_VALIDATE_EMAIL)) {
        $erorrs[] = "Email is not valid";
    }
    // phone validation
    if (required_input($emp_phone)) {
        $erorrs[] = "Phone is required";
    } elseif (max_length($emp_phone, 20)) {
        $erorrs[] = "Phone must be at most 20 number";
    }

    // salary validation
    if (required_input($emp_salary)) {
        $erorrs[] = "Salary is required";
    } elseif (max_length($emp_salary, 10)) {
        $erorrs[] = "Phone must be at most 10 number";
    } elseif (!is_numeric($emp_salary)) {
        $erorrs[] = "Salary must be number";
    }

    if(!check_id("department",$emp_department)){
        $erorrs[] = "Department not found";
    }

    if(empty($erorrs)){
        $sql = "INSERT INTO employees (name,email,phone,salary,dep_id) Values ('$emp_name','$emp_email','$emp_phone','$emp_salary','$emp_department')";
        $result = mysqli_query($conn,$sql);
        if($result){
            $_SESSION["success"] = ["done add emp"];
        }else{
            $_SESSION["erorrs"] = ["erorr : " . mysqli_error($conn)];
        }
    }else{
        $_SESSION["erorrs"] = $erorrs;
    }

header("location:".URL . " /employees/add.php");

}