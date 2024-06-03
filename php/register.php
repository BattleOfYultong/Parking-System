<?php
    include 'config.php';

$name = $_POST['Name'];
$Email = $_POST['Email'];
$password = $_POST['Password'];
$account_type = $_POST['account_type'];

$sql = "INSERT INTO account_tbl (Email, Password, Name, Account_Type) VALUES ('$Email', '$password', '$name', 
$account_type)";

if($connections->query($sql) === TRUE){
    echo "<script>window.location.href ='../login.php?register_success=true';</script>";
}
else{
    echo "error:" .$sql. "br" .$connections->error;
}

