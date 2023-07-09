<?php
$db=new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
if($db->connect_error){
    die('Connection Failed : '.$db->connect_error);
}
else{
    $user = "SELECT *
                FROM samu_staff
                WHERE hospital_id='4'";
    $result = mysqli_query($db, $user);
    while($staff = mysqli_fetch_assoc($result)){

        print $staff["role"];
        print(" ");
    }
    
}

?>