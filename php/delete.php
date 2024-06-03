<?php

include 'config.php';
$slotID = $_GET['slotID'];

$sql = "DELETE FROM slots WHERE slotID  = $slotID";

 if ($connections->query($sql) === TRUE) {
    echo "<script>window.location.href='../admin/admin.php?delete_success=true';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $connections->error;
}
