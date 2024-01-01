<?php

require_once '../../config/app.php';
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $erorrs = [];
    foreach($_POST as $key => $value){
        $$key = sanitarize($value);
    }
    if(required_input($dep_name)){
        $erorrs [] = "Department name is required";
    }elseif(min_length($dep_name,3)){
        $erorrs [] = "Department name is too short";
    }elseif(max_length($dep_name,50)){
        $erorrs [] = "Department name is too long";
    }

    if(empty($erorrs)){
        $sql = "INSERT INTO department(name) VALUES('$dep_name')";
        $results = insert_to_db($sql);
        if($results){
            $_SESSION['success'] = ["department added"];
        }else{
            $_SESSION['erorrs'] = ["something went wrong" . mysqli_error($conn)];
        }
    }else{
        $_SESSION['erorrs'] = $erorrs;
    }
    header("location:" . URL . "/departments/add.php");
}