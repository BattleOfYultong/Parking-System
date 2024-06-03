<?php

include 'config.php';

$occupiedBy = $_POST['user_no'];
$vehicle = $_POST['Vehicle'];
$rate = $_POST['Rate'];
$status = $_POST['Status'];
$parking_area = $_POST['Parking_area'];


$occupiedBy = mysqli_real_escape_string($connections, $occupiedBy);
$vehicle = mysqli_real_escape_string($connections, $vehicle);
$rate = mysqli_real_escape_string($connections, $rate);
$status = mysqli_real_escape_string($connections, $status);
$parking_area = mysqli_real_escape_string($connections, $parking_area);


$sql = "INSERT INTO slots (`Parking Area`, Status, Rate, userID, Vehicle, date) VALUES 
('$parking_area', '$status', '$rate', '$occupiedBy', '$vehicle', NOW())";


if ($connections->query($sql) === TRUE) {
    echo "<script>window.location.href='../admin/admin.php?create_success=true';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $connections->error;
}

$connections->close();

