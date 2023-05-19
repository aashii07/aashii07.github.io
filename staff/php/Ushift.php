<?php
// Start the session
session_start();

// DB connection
$db = new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
if ($db->connect_error) {
    die('Connection Failed : ' . $db->connect_error);
} else {
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the shift data from the form
        $shiftData = $_POST['shift'];
       

        // ...

if (isset($_POST['shift'])) {
    $shiftData = $_POST['shift'];

    foreach ($shiftData as $personId => $shifts) {
        foreach ($shifts as $day => $shift) {
            $date = $shift['date'];
            $selectedShift = $shift['shift'];
            $staffId = $shift['staff_id'];

            $query = "SELECT * FROM staff_schedule WHERE date='$date' AND staff_id='$staffId'";
            $row = mysqli_query($db, $query);

            if ($row) {
                if (mysqli_num_rows($row) > 0 && $selectedShift!="") {
                    $updateQuery = "UPDATE staff_schedule SET shift='$selectedShift' WHERE date='$date' AND staff_id='$staffId'";
                    $result = mysqli_query($db, $updateQuery);

                   
                } else {
                    $insertQuery = "INSERT INTO staff_schedule (date, shift, staff_id) VALUES ('$date', '$selectedShift', '$staffId')";
                    $result = mysqli_query($db, $insertQuery);

                    //if (!$result) {
                    //    echo "Insert Error: " . mysqli_error($db);
                    //}
                }
            } else {
                echo "Query Error: " . mysqli_error($db);
            }
        }
    }
} else {
    echo "No shift data submitted.";
}

// ...


       
    } else {
        echo "Invalid request.";
    }
    header("location: ../php/Uscheduling.php");
}
?>
