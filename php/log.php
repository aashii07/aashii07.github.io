<?php
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];
    $num=$_POST['num'];
    $psw=$_POST['psw'];
    $psw2=$_POST['psw2'];

    //DB connection
    $conn=new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
    if($conn->connect_error){
        die('Connection Failed : '.$conn->connect_error);
    }
    else{
        //check if already has an account
        $check="SELECT * FROM signup WHERE email='$email' LIMIT 1";
        $result=mysqli_query($conn, $check);
        $user=mysqli_fetch_assoc($result);

        if($user){
            echo "This email has already been registered.";
            
        }
        else{
            if ($psw !== $psw2) {
                echo "Passwords do not match";
                exit;
            }
            else{
                $stmt=$conn->prepare("INSERT INTO signup(firstname, lastname, email, phonenum, password, password2) VALUES(?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("sssiss", $fname, $lname, $email, $num, $psw, $psw2);
                $stmt->execute();
                echo "Registration Successful";
                $stmt->close();
                $conn->close();
            }
        }
    }
?>