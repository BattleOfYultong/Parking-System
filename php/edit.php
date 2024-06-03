<?php

include 'config.php';

    $slotID = $_POST['SlotID'];
    $parkingArea = $_POST['Parking_area'];
    $status = $_POST['Status'];
    $rate = $_POST['Rate'];
    $vehicle = $_POST['Vehicle'];
   
    $userID = $_POST['userID'];

   $sql = "UPDATE slots 
        SET `Parking Area` = '$parkingArea',  
            Status = '$status', 
            Rate = '$rate', 
            userID = $userID, 
            Vehicle = '$vehicle' 
        WHERE SlotID = $slotID";

    if ($connections->query($sql) === TRUE) {
    echo "<script>window.location.href='../admin/admin.php?edit_success=true';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $connections->error;
}
