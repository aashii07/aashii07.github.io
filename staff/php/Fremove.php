<?php
// Start the session
session_start();

// DB connection
$db = new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
if ($db->connect_error) {
    die('Connection Failed : ' . $db->connect_error);
} else {
    // Check if the selected IDs are submitted
    if (isset($_POST['selected_ids'])) {
        // Retrieve the selected IDs from the $_POST array
        $selectedIDs = explode(',', $_POST['selected_ids']);

        // Loop through the selected IDs
        foreach ($selectedIDs as $id) {
            // Perform any desired operations with the selected IDs
            echo "Selected ID: $id <br>";

            // Example: Delete the staff record with the selected ID
            $query = "DELETE FROM vehicle WHERE id='$id'";
            $result = mysqli_query($db, $query);

            if ($result) {
                echo "Vehicle with ID $id has been removed successfully.<br>";
            } else {
                echo "Error removing vehicle with ID $id.<br>";
            }
        }
    } else {
        echo "No selected IDs found.";
    }

    header("location: FselectV.php");
}
?>
