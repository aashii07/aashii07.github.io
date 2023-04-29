<?php
    // Start the session
    session_start();
    
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];
    $num=$_POST['num'];
    $role=$_POST['role'];
    $psw=$_POST['psw'];
    $psw2=$_POST['psw2'];

    //DB connection
    $db=new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
    if($db->connect_error){
        die('Connection Failed : '.$db->connect_error);
    }
    else{
        //check if already has an account
        $check="SELECT * FROM signup WHERE email='$email' LIMIT 1";
        $result=mysqli_query($db, $check);
        $user=mysqli_fetch_assoc($result);

        if($user){
            echo "<h2>This email has already been registered.</h2>";
            
        }
        else{
            if ($psw !== $psw2) {
                echo "<h2>Passwords do not match!</h2>";
                exit;
            }
            else{
                
                $query="INSERT INTO signup(firstname, lastname, email, phonenum, role, password, password2) 
                    VALUES('$fname', '$lname', '$email', '$num', '$role', '$psw', '$psw2')";
                mysqli_query($db, $query);
                $_SESSION['email']=$email;

                if($role=='p'){
                    header("location: ../html/home.html");
                }
                else if($role=='c'){
                    header("location: ../html/dash.html");
                }
                else{
                    header("location: ../html/resource.html");
                }
                
            }
        }
    }
?>