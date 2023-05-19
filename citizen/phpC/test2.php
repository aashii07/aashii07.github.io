<?php
// Assuming you have a database connection
// Modify the database connection details accordingly
$servername = "your_servername";
$username = "your_username";
$password = "your_password";
$database = "your_database";

// Create a connection
$conn = new mysqli('localhost', 'root', '!AAshi4477', 'fyp');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the form is submitted

    // Retrieve the shifts from the form submission
    $shifts = $_POST['shift'];

    // Loop through each shift
    foreach ($shifts as $personId => $shift) {
        // Update the database with the new shift

        // Assuming you have a table named samu_staff with a column named shift
        $sql = "UPDATE samu_staff SET shift='$shift' WHERE id='$personId'";
        $result = $conn->query($sql);
    }

    // Redirect to the shift schedule page after saving the shifts
    header("Location: shift_schedule.html");
    exit();
}

$conn->close();
?>
