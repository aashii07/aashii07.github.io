<?php
    // Start the session
    session_start();
    
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];
    $num=$_POST['num'];
    $role=$_POST['role'];
    $place=$_POST['place'];
    $psw=$_POST['psw'];
    $psw2=$_POST['psw2'];

    //DB connection
    $db=new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
    if($db->connect_error){
        die('Connection Failed : '.$db->connect_error);
    }
    else{
        //check if already has an account
        $check1 = "SELECT * FROM control_officer WHERE email='$email' LIMIT 1";
        $result=mysqli_query($db, $check1);
        $user1=mysqli_fetch_assoc($result);

        $check2 = "SELECT * FROM samu_staff WHERE email='$email' LIMIT 1";
        $result=mysqli_query($db, $check2);
        $user2=mysqli_fetch_assoc($result);

        if($user1 || $user2){
            echo "<h2>This email has already been registered.</h2>";
            
        }
        else{
            if ($psw !== $psw2) {
                echo "<h2>Passwords do not match!</h2>";
                exit;
            }
            else{
                
                if($role=='c'){
                    $query="INSERT INTO control_officer(firstname, lastname, email, phonenum, password, password2) 
                        VALUES('$fname', '$lname', '$email', '$num', '$psw', '$psw2')";
                }
                else{
                    $status="available";
                    $query="SELECT id FROM hospital WHERE name='$place' LIMIT 1";
                    $result=mysqli_query($db, $query);
                    $row=mysqli_fetch_assoc($result);
                    $hospital_id=$row['id'];
                    $query="INSERT INTO samu_staff(firstname, lastname, email, phonenum, role, status, password, password2, hospital_id) 
                        VALUES('$fname', '$lname', '$email', '$num', '$role', '$status', '$psw', '$psw2', '$hospital_id')";
                }
                

                mysqli_query($db, $query);
                $_SESSION['email']=$email;

                if($role=='c'){
                    header("location: ../html/home.html");
                }
                else{
                    header("location: ../html/Shome.html");
                }
                
            }
        }
    }
?>