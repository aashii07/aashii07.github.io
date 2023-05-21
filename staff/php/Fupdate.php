<?php
// Start the session
session_start();

// DB connection
$db = new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
if ($db->connect_error) {
    die('Connection Failed : ' . $db->connect_error);
} else {
    $staff = $_SESSION['email'];
    $user = "SELECT *
                FROM samu_staff
                WHERE email='$staff'";
    $result = mysqli_query($db, $user);
    $row = mysqli_fetch_assoc($result);
    $hos = $row['hospital_id'];

    // Retrieve the selected IDs from the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['selected_ids'])) {
        $selectedIDs = $_POST['selected_ids'];
        // Access the selected IDs and perform the desired actions

        // Split the selected IDs into an array
        $selectedIDsArray = explode(',', $selectedIDs);

        // Generate the SQL query to select vehicles with the selected IDs
        $q = "SELECT * FROM vehicle WHERE id IN (";
        foreach ($selectedIDsArray as $index => $id) {
            // Append the ID to the query
            $q .= $id;

            // Add a comma if it's not the last ID
            if ($index < count($selectedIDsArray) - 1) {
                $q .= ",";
            }
        }
        $q .= ")";

        // Execute the query and process the results
        $result = mysqli_query($db, $q);
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $status = $row['status'];
            
            if($status=="available"){
                $query="UPDATE vehicle
                        SET status='maintenance'
                        WHERE id='$id'";
                $res = mysqli_query($db, $query);
            }else if($status=="maintenance"){
                $query="UPDATE vehicle
                        SET status='available'
                        WHERE id='$id'";
                $res = mysqli_query($db, $query);
            }
            
        }
    }
}
header("location: FavaiV.php");

}

?>