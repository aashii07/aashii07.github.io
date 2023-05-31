<?php
    // Start the session
    session_start();
    // Include the Composer autoloader
    require 'PHPMailer-master/vendor/autoload.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    // Set up SMTP configuration
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  // Specify your SMTP server
    $mail->Port = 587;  // Specify the SMTP port
    // Enable SMTP encryption
    $mail->SMTPSecure = 'tls'; // or 'ssl' for SSL encryption
    $mail->SMTPAuth = true;
    $mail->Username = 'aashi.jaulim@gmail.com';  // Your SMTP username
    $mail->Password = 'hhjqbxsjjwrqbpee';  // Your SMTP password
    
    $fname=$_POST['fname'];
    $lname=$_POST['lname'];
    $email=$_POST['email'];
    $num=$_POST['num'];
    $role=$_POST['role'];
    $place=$_POST['place'];
    $psw=$_POST['psw'];
    $psw2=$_POST['psw2'];

    include 'message.php';

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
            //echo "<h2>This email has already been registered.</h2>";
            $msg = '<h2>Error Message<hr></h2>';
            $msg .= '<p>This email has already been registered.</p>';
            $msg .= '<div class="button-container">';
            $msg .= '<button onclick="window.location.href=\'../html/login.html\'">Close</button>';
            $msg .= '</div>';
            generateMessageBox($msg);
            
        }
        else{
            if ($psw !== $psw2) {
                //echo "<h2>Passwords do not match!</h2>";
                $msg = '<h2>Error Message<hr></h2>';
                $msg .= '<p>Passwords do not match!</p>';
                $msg .= '<div class="button-container">';
                $msg .= '<button onclick="window.location.href=\'../html/signup.html\'">Close</button>';
                $msg .= '</div>';
                generateMessageBox($msg);
            }
            else{
                
                if($role=='c'){
                    $query="INSERT INTO control_officer(firstname, lastname, email, phonenum, password, password2) 
                        VALUES('$fname', '$lname', '$email', '$num', '$psw', '$psw2')";

                    // Set up email parameters
                    $mail->setFrom('aashi.jaulim@gmail.com', 'SAMU IMS');
                    $mail->addAddress($email, 'Control Officer');
                    $mail->Subject = 'Successful Signup Confirmation for SAMU IMS';
                }
                else{
                    $status="available";
                    $query="SELECT id FROM hospital WHERE name='$place' LIMIT 1";
                    $result=mysqli_query($db, $query);
                    $row=mysqli_fetch_assoc($result);
                    $hospital_id=$row['id'];
                    $query="INSERT INTO samu_staff(firstname, lastname, email, phonenum, role, status, password, password2, hospital_id) 
                        VALUES('$fname', '$lname', '$email', '$num', '$role', '$status', '$psw', '$psw2', '$hospital_id')";
                    
                    // Set up email parameters
                    $mail->setFrom('aashi.jaulim@gmail.com', 'SAMU IMS');
                    $mail->addAddress($email, 'SAMU staff');
                    $mail->Subject = 'Successful Signup Confirmation for SAMU IMS';
                }

                if($role=='c'){
                    $rl="control officer";
                }
                else if ($role=='u'){
                    $rl="unit manager";
                }
                else if ($role=='f'){
                    $rl="fleet manager";
                }
                else if ($role=='e'){
                    $rl="emergency physician";
                }
                else if ($role=='n'){
                    $rl="nurse";
                }
                else if ($role=='h'){
                    $rl="helper";
                }
                else if ($role=='d'){
                    $rl="driver";
                }

               
                $mail->Body = 'Dear '.$fname.',

You have successfully signed up for SAMU IMS as '.$rl.'! 

Our platform streamlines the incident response process and enables real-time communication between team members. Log in to your account to explore our various features and tools. If you have any questions, our support team is always available to assist you.

Thank you for choosing SAMU IMS. We are confident that our platform will help you manage incidents more efficiently.

Best regards,
SAMU IMS Team';
                
            try {
            // Send the email
                    $mail->send();
                    //echo 'Email sent successfully.';
            } catch (Exception $e) {
                    //echo 'An error occurred. Email not sent.';
                    //echo 'Error: ' . $mail->ErrorInfo;
            }


                

                mysqli_query($db, $query);
                $_SESSION['email']=$email;

                if($role=='c'){
                    header("location: ../html/home.html");
                }else if ($role=="u") {
                    header("location: ../html/Uhome.html");
                }
                else if ($role=="f") {
                    header("location: ../html/Fhome.html");
                }else if ($role=="e"){
                    header("location: EPhome.php");
                }
                else{
                    header("location: Shome.php");
                }

                
               
                
            }
        }
    }
?>