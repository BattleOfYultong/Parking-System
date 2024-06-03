<?php
    session_start();
    if(isset($_SESSION['Email'])){
        $Email = $_SESSION['Email'];
            include '../php/config.php';

        $profSql = "SELECT Email, Name, loginID FROM account_tbl WHERE Email = '$Email'";
        $result = mysqli_query($connections, $profSql);

        if($result && mysqli_num_rows($result)){
            $row = mysqli_fetch_assoc($result);
            $NameSession = $row['Name'];
            $SessionloginID =$row['loginID'];
        }
    }
    else{
        echo "<script>window.location.href='../login.php?show_error=true';</script>";
        
    }

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <script src="../SweetAlert/sweetalert2.min.css"></script>
    <script src="../SweetAlert/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../fontawesome-free-6.5.2-web/css/all.min.css" />
    <script src="../jquery/jquery.js"></script>
    <link rel="stylesheet" href="../css/dashboard.css">
    <title>Admin</title>
</head>
<body>

    <aside>
        <div class="profiles">
            
            <h1>ADMIN</h1>
        </div>

        <ul>
            <li class="li-act">
                <a href="admin.php">
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="">
                    <span>Module 1</span>
                </a>
            </li>

            <li class="">
                <a href="">
                    <span>Module 2</span>
                </a>
            </li>

            <li >
                <a href="../php/logout.php">
                    <span>Log - Out</span>
                </a>
            </li>
        </ul>
        

    </aside>

    <main>
        <nav>
            <div class="title-sys">
                <h1>Parking System</h1>
            </div>
        </nav>

        <section>

            <div class="button-create">
                <button onclick="CreateSlot();">Create Parking Slot</button>
            </div>

                <div class="table-con">
                    <table>
                        <thead>
                            <tr>
                                <th>
                                    slotID 
                                </th>
                                <th>
                                    Parking Area   
                                </th>
                                <th>
                                   Status
                                </th>

                                <th>
                                    Time Limit
                                </th>

                                 <th>
                                   Vehicle
                                </th>

                                <th>
                                    Occuppied By
                                </th>

                                 <th>
                                    Date
                                </th>

                                <th>
                                    Action
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            include '../php/config.php';
                           $sql = "SELECT slots.*, account_tbl.Name 
                            FROM slots
                            LEFT JOIN account_tbl ON slots.userID = account_tbl.loginID";
                            $result = $connections->query($sql);

                            if(!$result){
                                die("Invalid Query: " .$connections->error);
                            }

                          
while($row = $result->fetch_assoc()){
    $SlotID = $row['SlotID'];
    // Other variables...

    echo '<tr>
        <td>
            '.$row['SlotID'].'
        </td>
        <td>
            '.$row['Parking Area'].'
        </td>
        <td>
            '.$row['Status'].'
        </td>

         <td>
            '.$row['Rate'].'
        </td>

        <td>
            '.$row['Vehicle'].'
        </td>

         <td>
            '.$row['Name'].'
        </td>

         <td>
            '.$row['date'].'
        </td>
        <td>
            <div class="wrapper-btn">
                <button onclick="editUser(\''.$SlotID.'\');" class="edit-button" data-loginid="'.$SlotID.'">Edit/View</button>
                 <a href="#" onclick="confirmDelete(\''.$row['SlotID'].'\');">
                        <button>Delete</button>
                </a>
            </div>
        </td>
    </tr>';
}
?>

                           
                        </tbody>
                    </table>
                </div>

               <?php
include '../php/config.php';

// Fetch all users for the dropdown
$usersQuery = "SELECT loginID, Name FROM account_tbl";
$usersResult = $connections->query($usersQuery);

$users = [];
if ($usersResult->num_rows > 0) {
    while ($row = $usersResult->fetch_assoc()) {
        $users[] = ['loginID' => $row['loginID'], 'Name' => $row['Name']];
    }
}

// Fetch slot details along with the associated user's name
$slotsQuery = "SELECT slots.*, account_tbl.Name 
               FROM slots
               LEFT JOIN account_tbl ON slots.userID = account_tbl.loginID";
$slotsResult = $connections->query($slotsQuery);

if (!$slotsResult) {
    die("Invalid Query: " . $connections->error);
}

while ($slot = $slotsResult->fetch_assoc()) {
    $slotID = $slot['SlotID'];
    $parkingArea = $slot['Parking Area'];
    $status = $slot['Status'];
    $rate = $slot['Rate'];
    $vehicle = $slot['Vehicle'];
    $containerID = 'container_' . $slot['SlotID']; // Unique ID for each update container
    $occupiedBy = $slot['Name'];
    $userID = $slot['userID'];
    $date = $slot['date'];
?>

<form action="../php/edit.php" method="post" class="edit-container" id="<?php echo $containerID; ?>">
    <div class="create-header">
        <div onclick="ExitEdit('<?php echo $containerID; ?>');" class="exitbtn" id="<?php echo $containerID . '_exitbtn'; ?>">
            <i class="fa-solid fa-circle-xmark exitbtncreate"></i>
        </div>
        <h1>Edit/View A Slot</h1>
    </div>

    <div class="input-wrapper" id="edit-wrap">
        <div class="inputbox">
            <label for="SlotID">SlotID</label>
            <input type="text" name="SlotID" id="SlotID" placeholder="SlotID" value="<?php echo htmlspecialchars($slotID); ?>" readonly> 
        </div>

        <div class="inputbox">
            <label for="userID">Occupied By</label>
            <select name="userID" id="userID">
                <?php foreach ($users as $user): ?>
                    <option value="<?php echo htmlspecialchars($user['loginID']); ?>" <?php echo ($user['loginID'] == $userID) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($user['Name']) . ' (' . htmlspecialchars($user['loginID']) . ')'; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="inputbox">
            <label for="Parking_area">Parking Area</label>
            <select name="Status">
            <option value="Occupied" <?php echo ($parkingArea == 'Occupied') ? 'selected' : ''; ?>>Occupied</option>
            <option value="Reserved" <?php echo ($parkingArea == 'Reserved') ? 'selected' : ''; ?>>Reserved</option>
        </select>
           
        </div>

        <div class="inputbox">
            <label for="">Status</label>
          <select name="Parking_area">
            <option value="Building 1" <?php echo ($parkingArea == 'Building 1') ? 'selected' : ''; ?>>Building 1</option>
            <option value="Building 2" <?php echo ($parkingArea == 'Building 2') ? 'selected' : ''; ?>>Building 2</option>
            <option value="Building 3" <?php echo ($parkingArea == 'Building 3') ? 'selected' : ''; ?>>Building 3</option>
            <option value="Building 4" <?php echo ($parkingArea == 'Building 4') ? 'selected' : ''; ?>>Building 4</option>
            <option value="Outside 1" <?php echo ($parkingArea == 'Outside 1') ? 'selected' : ''; ?>>Outside 1</option>
            <option value="Outside 2" <?php echo ($parkingArea == 'Outside 2') ? 'selected' : ''; ?>>Outside 2</option>
        </select>
        
        </div>
        <div class="inputbox">
            <label for="Rate">Time limit</label>
            <input type="text" name="Rate" id="Rate" placeholder="Rate" value="<?php echo htmlspecialchars($rate); ?>">
        </div>
        <div class="inputbox">
            <label for="Vehicle">Vehicle</label>
            <input type="text" name="Vehicle" id="Vehicle" placeholder="Vehicle" value="<?php echo htmlspecialchars($vehicle); ?>">
        </div>

        <div class="inputbox">
            <label for="Date">Date</label>
            <input type="text" name="Date" id="Date" placeholder="Date" value="<?php echo htmlspecialchars($date); ?>" readonly>
        </div>

        <div class="input-submit">
            <input type="submit" value="Submit">
        </div>
    </div>
</form>

<?php } ?>


           <?php
include '../php/config.php';

// Fetch loginID from account_tbl
$query = "SELECT loginID,Name FROM account_tbl";
$resultquery = $connections->query($query);

$loginIDs = [];
if ($resultquery->num_rows > 0) {
    while($row = $resultquery->fetch_assoc()) {
        $users[] = ['loginID' => $row['loginID'], 'Name' => $row['Name']];
    }
}
$connections->close();
?>

<form action="../php/create.php" method="post" class="create-container">
    <div class="create-header">
        <div onclick="ExitSlot();" class="exitbtn">
            <i class="fa-solid fa-circle-xmark exitbtncreate"></i>
        </div>
        <h1>Create Slot</h1>
    </div>

    <div class="input-wrapper">
        <div class="inputbox">
            <label for="">Current Users_ID</label>
            <select name="user_no">
               <?php foreach ($users as $user): ?>
                    <option value="<?php echo htmlspecialchars($user['loginID']); ?>">
                        <?php echo htmlspecialchars($user['Name']) . ' (' . htmlspecialchars($user['loginID']) . ')'; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="inputbox">
            <label for="">Vehicle</label>
            <input type="text" name="Vehicle" placeholder="Vehicle">
        </div>
        <div class="inputbox">
            <label for="">Time Limit</label>
            <input type="text" name="Rate" placeholder="Rate">
        </div>
        <div class="inputbox">
            <label for="">Status</label>
            <select name="Status">
                <option value="Occupied">Occupied</option>
                <option value="Reserved">Reserved</option>
            </select>
        </div>
        <div class="inputbox">
            <label for="">Parking Area</label>
            <select name="Parking_area">
                <option value="Building 1">Building 1</option>
                <option value="Building 2">Building 2</option>
                <option value="Building 3">Building 3</option>
                <option value="Building 4">Building 4</option>
                <option value="Outside 1">Outside 1</option>
                <option value="Outside 2">Outside 2</option>
            </select>
        </div>
        <div class="input-submit">
            <input type="submit" value="Submit">
        </div>
    </div>
</form>

        </section>
        
    </main>

                
<script>
    function confirmDelete(SlotID) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../php/delete.php?slotID=" + SlotID;
            }
        });
    }

    </script>

      <?php
if (isset($_GET['delete_success']) && $_GET['delete_success'] == 'true') {
    echo "
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Slot Deleted',
            timer: 2000,
            showConfirmButton: false,
            position: 'top',
        });
    </script>
    ";
}
?>      
<?php
if (isset($_GET['show_name']) && $_GET['show_name'] == 'true') {
    echo "
    <script>
        Swal.fire({
            position: 'top',
            icon: 'success',
            title: 'Welcome $NameSession',
            showConfirmButton: false,
            timer: 1500
        });
    </script>
    ";
}
?>

<?php
if (isset($_GET['edit_success']) && $_GET['edit_success'] == 'true') {
    echo "
    <script>
        Swal.fire({
            position: 'top',
            icon: 'success',
            title: 'Slot Has been Edited',
            showConfirmButton: false,
            timer: 1500
        });
    </script>
    ";
}
?>

<?php
if (isset($_GET['create_success']) && $_GET['create_success'] == 'true') {
    echo "
    <script>
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Slot Succesfully Created',
            showConfirmButton: false,
            timer: 1500
        });
    </script>
    ";
}
?>

    <script>
        function CreateSlot(){
            const CreateContainer = document.querySelector('.create-container');
            CreateContainer.classList.add('create-act');
        };

        function ExitSlot() {
            const CreateContainer = document.querySelector('.create-container');
            CreateContainer.classList.remove('create-act');
        };

        function editUser(loginID) {
        const editContainer = document.getElementById('container_' + loginID);
        editContainer.classList.add('create-act');
    }
    function ExitEdit(containerID) {
        const editContainer = document.getElementById(containerID);
        editContainer.classList.remove('create-act');
    }


        
        
    </script>
</body>
</html>