<?php
$conn = mysqli_connect("localhost","root","","hr_sys");


if(!$conn){
    die("Connection Failed".mysqli_connect_error());
}