<?php

if($_SERVER['REQUEST_METHOD']=='POST'){
require_once "../../config/app.php";
$id = $_POST['dep_id'];
$dep_content = sanitarize($_POST['edit_dep']);
$erorrs = [];
if(check_id("department",$id)){
    
    if(required_input($dep_content)){
        $erorrs[] = "Department name is required";
    }elseif(min_length($dep_content,3)){
        $erorrs[] = "Department name must be at least 3 characters";
    }elseif(max_length($dep_content,50)){
        $erorrs[] = "Department name must be at most 50 characters";
    }

    if(empty($erorrs)){
        if(department_edit($id,$dep_content)){
            $_SESSION["success"] = ["done edited"];
        }else{
            $_SESSION["erorrs"] = [ "erorr : ". mysqli_error($conn) ];
        }
    }else{
        $_SESSION["erorrs"] = $erorrs;
    }
}else{
    $_SESSION["erorrs"] = ["can not find id"];
}
header("location:".URL." /departments/index.php");
}