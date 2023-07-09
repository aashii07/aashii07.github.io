<?php
// Start the session
session_start();



//DB connection
$db = new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
if ($db->connect_error) {
        die('Connection Failed : ' . $db->connect_error);
} else {
    // Disable ONLY_FULL_GROUP_BY mode for the current session
    mysqli_query($db, "SET SESSION sql_mode = ''");




    // Check if the id parameter is present in the URL
    if (isset($_GET['id'])) {

        $id = $_GET['id'];
        include 'message.php';


        $msg = '<h2>MPF Request<hr></h2>';
        $msg .= '<p>Do you want request the services of MPF for this incident?</p>';
        $msg .= '<div class="button-container">';
        $msg .= '<button onclick="window.location.href=\'mpf.php?id='. $id .'\'"style="margin-left: 150px;">Yes</button>';
        $msg .= '<button onclick="window.location.href=\'priority.php\'" style="margin-left: 15px;">No</button>';
        $msg .= '</div>';
        generateMessageBox($msg);

    }



}
?>