<?php

    // Start the session
    session_start();

    

    //DB connection
    $db=new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
    if($db->connect_error){
        die('Connection Failed : '.$db->connect_error);
    }
    else{
        $email=$_POST['email'];
        $psw=$_POST['psw'];

        include 'message.php';

        //check if already has an account
        $check="SELECT * FROM public WHERE email='$email' LIMIT 1";
        $result=mysqli_query($db, $check);
        $user=mysqli_fetch_assoc($result);

        if($user){
            
            $checkpsw="SELECT * FROM public WHERE email='$email' AND password='$psw'";
            $resultpsw=mysqli_query($db, $checkpsw);
            if (mysqli_num_rows($resultpsw) == 1) {
                $_SESSION['email']=$email;
                header("location: home.php");
            }
            else{
                //echo "<h2>Invalid Email or Password</h2>";

                $msg = '<h2>Error Message<hr></h2>';
                $msg .= '<p>Invalid Email or Password</p>';
                $msg .= '<div class="button-container">';
                $msg .= '<button onclick="window.location.href=\'../htmlC/login.html\'"><span class="text">Close</span></button>';
                $msg .= '</div>';
                generateMessageBox($msg);
            }
        }
        else{
            //echo "<h2>This email has not been registered yet.</h2>";
            $msg = '<h2>Error Message<hr></h2>';
            $msg .= '<p>This email has not been registered yet.</p>';
            $msg .= '<div class="button-container">';
            $msg .= '<button onclick="window.location.href=\'../htmlC/login.html\'"><span class="text">Close</span></button>';
            $msg .= '</div>';
            generateMessageBox($msg);
    
        }
    }
?>