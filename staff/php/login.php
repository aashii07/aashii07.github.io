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
        $check1 = "SELECT * FROM control_officer WHERE email='$email' LIMIT 1";
        $result=mysqli_query($db, $check1);
        $user1=mysqli_fetch_assoc($result);

        $check2 = "SELECT * FROM samu_staff WHERE email='$email' LIMIT 1";
        $result=mysqli_query($db, $check2);
        $user2=mysqli_fetch_assoc($result);

        if($user1 || $user2){
            if($user1){
                $checkpsw="SELECT * FROM control_officer WHERE email='$email' AND password='$psw'";
                $resultpsw=mysqli_query($db, $checkpsw);
                if (mysqli_num_rows($resultpsw) == 1) {
                    $_SESSION['email']=$email;
                    header("location: ../html/home.html");
                }
                else{
                    //echo "<h2>Invalid Email or Password</h2>";
                    
                    $msg = '<h2>Error Message<hr></h2>';
                    $msg .= '<p>Invalid Email or Password</p>';
                    $msg .= '<div class="button-container">';
                    $msg .= '<button onclick="window.location.href=\'../html/login.html\'">Close</button>';
                    $msg .= '</div>';
                    generateMessageBox($msg);
                }
            }
            else{
                $checkpsw="SELECT * FROM samu_staff WHERE email='$email' AND password='$psw'";
                $resultpsw=mysqli_query($db, $checkpsw);
                if (mysqli_num_rows($resultpsw) == 1) {
                    $_SESSION['email']=$email;
                    $user=mysqli_fetch_assoc($resultpsw);
                    $role=$user['role'];
                    if ($role=="u") {
                        $_SESSION['email']=$email;
                        header("location: ../html/Uhome.html");
                    }
                    else if ($role=="f") {
                        $_SESSION['email']=$email;
                        header("location: ../html/Fhome.html");
                    }
                    else if ($user){
                        $_SESSION['email']=$email;
                        header("location: EPhome.php");
                    }
                   
                }
                else{
                    //echo "<h2>Invalid Email or Password</h2>";
                    
                    $msg = '<h2>Error Message<hr></h2>';
                    $msg .= '<p>Invalid Email or Password</p>';
                    $msg .= '<div class="button-container">';
                    $msg .= '<button onclick="window.location.href=\'../html/login.html\'">Close</button>';
                    $msg .= '</div>';
                    generateMessageBox($msg);
                }
                
                
                   
                
            }
           
            
        }
        else{
            //echo "<h2>This email has not been registered yet.</h2>";

            $msg = '<h2>Error Message<hr></h2>';
            $msg .= '<p>This email has not been registered yet.</p>';
            $msg .= '<div class="button-container">';
            $msg .= '<button onclick="window.location.href=\'../html/login.html\'">Close</button>';
            $msg .= '</div>';
            generateMessageBox($msg);
        
            
        }
    }
?>