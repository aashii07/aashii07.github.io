<?php
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];
    $num=$_POST['num'];
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
                $query="INSERT INTO signup(firstname, lastname, email, phonenum, password, password2) VALUES($fname, $lname, $email, $num, $psw, $psw2)";
                mysqli_query($db, $query);
                echo "<h2>Registration Successful!</h2>";
                $_SESSION['email']=$email;
                header("location: ../html/home.html");
            }
        }
    }
?>