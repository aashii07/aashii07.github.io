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

$db=new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
if($db->connect_error){
    die('Connection Failed : '.$db->connect_error);
}
else{

    $id = $_GET['id'];
    
    $q = "SELECT * FROM incident WHERE id='$id'";
    $r = mysqli_query($db, $q);
    $row = mysqli_fetch_assoc($r);

  
    $des=$row['description'];
    $lat=$row['latitude'];
    $long=$row['longitude'];
    $dt=$row['reported_datetime'];
    $pid=$row['public_id'];
    $other=$row['mfrs'];

    



    $q0 = "UPDATE incident
            SET mfrs='Y'
            WHERE id='$id'";
    $r0 = mysqli_query($db, $q0);

    if(!$r0){echo $db->error;}

    
    $link = "https://www.google.com/maps?q={$lat},{$long}";
    

    $q1 = "SELECT * FROM public WHERE id='$pid'";
    $r1 = mysqli_query($db, $q1);
    $row1 = mysqli_fetch_assoc($r1);

    $fn=$row1['firstname'];
    $ln=$row1['lastname'];
    $num=$row1['phonenum'];






    
}
if($other=='Y'){

}else{

    // Set up email parameters
    $mail->setFrom('aashi.jaulim@gmail.com', 'SAMU IMS');
    $mail->addAddress('aashi.jaulim@gmail.com', 'MFRS');
    $mail->Subject = 'Request for Incident Management Services';
    $mail->Body = 'Dear MFRS,

We are experiencing an incident and require your immediate assistance for its management. 

The details of the incident are as follows:

- ID: '.$id.'
- Description: '.$des.'
- Location: '.$link.'
- Date and Time: '.$dt.'

The details of the incident caller are as follows:

- Name: '.$fn.' '.$ln.'
- Phone Number: '.$num.'

Please dispatch your team to the location mentioned above as soon as possible. 
Your prompt response and assistance in this matter will be greatly appreciated.

Thank you,
SAMU IMS Team';

    try {
        // Send the email
        $mail->send();
        echo 'Email sent successfully.';
    } catch (Exception $e) {
        echo 'An error occurred. Email not sent.';
        echo 'Error: ' . $mail->ErrorInfo;
    }
    
}
if($co){

    header("Location: requestmpf.php?id=" . $id);
}else{
    header("location: EPhome.php");
}









?>
