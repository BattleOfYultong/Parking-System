<?php

$localhost = "localhost";
$root = "root";
$password = "";
$database ="parking";

$connections = mysqli_connect($localhost, $root, $password, $database);

 if($connections->connect_errno){
        echo "Error: " .$connections->connect_errno;
    }
    else{
        
    }