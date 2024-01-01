<?php
require_once "../../config/app.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $emp_id = $_POST["emp_id"];
    if (check_id("employees", $emp_id)) {

        $erorrs = [];
        $file = $_FILES["emp_img"];
        $allowed = ["jpg", "png"];
        $ext = pathinfo($file["name"]);

        if ($file["name"] == "") {
            $erorrs[] = "file is empty";
        } elseif (!in_array($ext["extension"], $allowed)) {
            $erorrs[] = "file extension not allowed";
        } elseif ($file["error"] > 0) {
            $erorrs[] = "file have error";
        } elseif ($file["size"] > 10500000) {
            $erorrs[] = "file more than 10MB";
        }

        if (empty($erorrs)) {
            $uploads_path = MAIN_PATH . "/uploads/";
            if (!is_dir($uploads_path)) {
                mkdir($uploads_path, 0755, true);
            }
            $newName = uniqid("", true) . "." . $ext['extension'];
            $newFilePath = $uploads_path . $newName;
            if (move_uploaded_file($file['tmp_name'], $newFilePath)) {
                $sql = "INSERT INTO emp_images (file_path,emp_id) VALUES ('/uploads/$newName','$emp_id')";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $_SESSION["success"] = ["image done uploaded"];
                } else {
                    $_SESSION["erorrs"] = ["image not uploaded" . mysqli_error($conn)];

                }
            } else {
                $_SESSION["erorrs"] = ["Check the file path"];
            }

        } else {
            $_SESSION["erorrs"] = $erorrs;
        }
    } else {
        $_SESSION["erorrs"] = ["employee not found"];
    }
    header("location:" . URL . "/employees/index.php");
}