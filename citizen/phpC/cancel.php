<?php
    // Start the session
    session_start();
   
    //DB connection
    $db=new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
    if($db->connect_error){
        die('Connection Failed : '.$db->connect_error);

    }
    else{
        $id = $_GET['id'];

        
        $caller="DELETE FROM incident WHERE id='$id'";
        $result=mysqli_query($db, $caller);


        header("location: home.php");

        
    }
?>