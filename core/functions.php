<?php

function sanitarize($input){
    return trim(htmlentities(htmlspecialchars($input)));
}


function required_input($input){
    return empty($input);
}

function min_length($input, $min){
    return strlen($input) < $min;
}


function max_length($input, $max){
    return strlen($input) > $max;
}


function insert_to_db($sql){
    global $conn;
    $result = mysqli_query($conn, $sql);
    if(mysqli_affected_rows($conn)>0){
        return true;
    }
    return false;
}


function alert_display($key,$class){
    if(isset($_SESSION[$key])){
        foreach($_SESSION[$key] as $value){
            echo "<div class='alert alert-$class'>$value</div>";
        }
        unset($_SESSION[$key]);
    }
}


function get_all_data($table){
    global $conn;
    $sql = "SELECT * FROM $table ORDER BY id ASC";
    $result = mysqli_query($conn, $sql);
    $data = [];
    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }
    return $data;
}

function delete_item($table,$id){
    global $conn;
    $sql = "DELETE FROM $table WHERE id = '$id'";
    $result = mysqli_query($conn,$sql);
    if($result){
        return true;
    }
    return false;
    
}

function check_id($table,$id){
    global $conn;
    $sql = "SELECT * FROM $table WHERE id = '$id'";
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) > 0){
        return true;
    }
    return false;
}

function department_edit($id,$input){
    global $conn;
    $sql = "UPDATE department SET name = '$input' WHERE id = $id";
    $result = mysqli_query($conn,$sql);
    if($result){
        return true;
    }
    return false;
}
function get_emp_images($id){
    global $conn;
    $data = [];
    $sql = "SELECT file_path from emp_images i,employees e
    WHERE e.id = i.emp_id AND e.id = '$id'";
    $result = mysqli_query($conn, $sql);
    if($result){
        while($row = mysqli_fetch_assoc($result)){
            $data [] = $row;
        }
        return $data;
    }
    return false;
}
function get_vacation($id){
    global $conn;
    $sql = "SELECT * FROM vacation WHERE emp_id = '$id'";
    $data = [];
    $result = mysqli_query($conn, $sql);
    if($result){
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        return $data;
    }
    return false;
}


function check_if_attendance($id){
    global $conn;
    $data =[];
    $day_date = date("Y-m-d");
    $sql = "SELECT * FROM attendance WHERE emp_id = '$id' AND date_day = '$day_date'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $data[] = $row;
        }
        return $data;
    }
    return false;
}