<?php

    // Start the session
    session_start();

    $email=$_POST['email'];
    $psw=$_POST['psw'];

    //DB connection
    $db=new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
    if($db->connect_error){
        die('Connection Failed : '.$db->connect_error);
    }
    else{
        //check if already has an account
        if($role=='c'){
            $check="SELECT * FROM control_officer WHERE email='$email' LIMIT 1";
        }
        else{
            $check="SELECT * FROM samu_staff WHERE email='$email' LIMIT 1";
        }
      
        $result=mysqli_query($db, $check);
        $user=mysqli_fetch_assoc($result);

        if($user){
            if($role=='c'){
                $checkpsw="SELECT * FROM control_officer WHERE email='$email' AND password='$psw'";
            }
            else{
                $checkpsw="SELECT * FROM samu_staff WHERE email='$email' AND password='$psw'";
            }
           
            $resultpsw=mysqli_query($db, $checkpsw);
            if (mysqli_num_rows($resultpsw) == 1) {
                $_SESSION['email']=$email;
                header("location: ../html/dash.html");
            }
            else{
                echo "<h2>Invalid Email or Password</h2>";
            }
        }
        else{
            echo "<h2>This email has not been registered yet.</h2>";
            exit;
            
        }
    }
?>