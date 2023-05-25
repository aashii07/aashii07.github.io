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

//DB connection
$db = new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
if ($db->connect_error) {
        die('Connection Failed : ' . $db->connect_error);
} else {
    // Disable ONLY_FULL_GROUP_BY mode for the current session
    mysqli_query($db, "SET SESSION sql_mode = ''");




    // Check if the id parameter is present in the URL
    if (isset($_GET['id'])) {

        $id = $_GET['id'];


        // Find the closest hospital

        $location = "SELECT latitude, longitude, severity
                    FROM incident
                    WHERE id=$id";
        $result = mysqli_query($db, $location);
        $loc = mysqli_fetch_assoc($result);
        $lat = $loc["latitude"];
        $long = $loc["longitude"];
        

        $hospitals = "SELECT h.id, h.name
                        FROM hospital h
                        JOIN (
                            SELECT hospital_id
                            FROM samu_staff
                            WHERE role IN ('h', 'd')
                                    AND status = 'available'
                            GROUP BY hospital_id
                            HAVING COUNT(DISTINCT role) = 2
                            LIMIT 1
                        ) s ON h.id = s.hospital_id
                        JOIN vehicle v ON h.id = v.hospital_id
                        WHERE v.type = 'a' AND v.status = 'available'
                        ORDER BY SQRT(POW(69.1 * (h.latitude - $lat), 2) + POW(69.1 * ($long - h.longitude) * COS(h.latitude / 57.3), 2)) ASC
                        LIMIT 1";
        $result = mysqli_query($db, $hospitals);
        $assign="n";
        if(mysqli_num_rows($result) > 0){
            $hospital = mysqli_fetch_assoc($result);
            $hospitalID = $hospital["id"];
            $hospitalN = $hospital["name"];

            $vehicle = "SELECT v.id, v.license, v.type
            FROM vehicle v
            JOIN hospital h ON h.id = v.hospital_id
            WHERE (v.status = 'available' AND v.type = 'a' AND v.hospital_id = $hospitalID)
            ORDER BY RAND() LIMIT 1";
            $result = mysqli_query($db, $vehicle);
            $veh = mysqli_fetch_assoc($result);
            $vehID = $veh["id"];
            $vehN = $veh["license"];
            $vehT = $veh["type"];

            $query = "UPDATE vehicle
            SET status = 'dispatched'
            WHERE id = $vehID";
            mysqli_query($db, $query);

            $staff = "SELECT s.id, s.firstname, s.lastname 
            FROM samu_staff s
            JOIN hospital h ON h.id = s.hospital_id
            WHERE (s.status = 'available' AND s.role = 'h' AND s.hospital_id = $hospitalID)
            ORDER BY RAND() LIMIT 1";
            $result = mysqli_query($db, $staff);
            $staff = mysqli_fetch_assoc($result);
            $hID = $staff["id"];
            $hN1 = $staff["firstname"];
            $hN2 = $staff["lastname"];
    

            $staff = "SELECT s.id, s.firstname, s.lastname 
            FROM samu_staff s
            JOIN hospital h ON h.id = s.hospital_id
            WHERE (s.status = 'available' AND s.role = 'd' AND s.hospital_id = $hospitalID)
            ORDER BY RAND() LIMIT 1";
            $result = mysqli_query($db, $staff);
            $staff = mysqli_fetch_assoc($result);
            $dID = $staff["id"];
            $dN1 = $staff["firstname"];
            $dN2 = $staff["lastname"];

            $query = "INSERT INTO incident_staff(incident_id, staff_id)
            VALUES('$id', '$hID')";
            mysqli_query($db, $query);

            $query = "INSERT INTO incident_staff(incident_id, staff_id)
            VALUES('$id', '$dID')";
            mysqli_query($db, $query);

            $query = "UPDATE samu_staff
            SET status = 'dispatched'
            WHERE id = $hID";
            mysqli_query($db, $query);

            $query = "UPDATE samu_staff
            SET status = 'dispatched'
            WHERE id = $dID";
            mysqli_query($db, $query);

            

            $assign="y";

        }
        
        if($assign=="y"){
            $CO = $_SESSION['email'];
            $co = "SELECT id FROM control_officer WHERE email='$CO' LIMIT 1";
            $result = mysqli_query($db, $co);
            $co = mysqli_fetch_assoc($result);
            $coID = $co["id"];

            date_default_timezone_set("Indian/Mauritius");
            $dispatch = date("Y-m-d H:i:s");

            $query = "UPDATE incident
            SET status = 'dispatched', dispatched_datetime = '$dispatch', hospital_id = '$hospitalID', co_id = '$coID', vehicle_id = '$vehID'
            WHERE id = $id";
            mysqli_query($db, $query);



            //email
            $email = "SELECT *
                FROM incident_staff
                WHERE incident_id=$id";
            
            $r = mysqli_query($db, $email);
            while($em = mysqli_fetch_assoc($r)){
                $Sid = $em["staff_id"];

                $ss = "SELECT *
                        FROM samu_staff
                        WHERE id=$Sid";
                $r1 = mysqli_query($db, $ss);
                $s = mysqli_fetch_assoc($r1);
                $n = $s["firstname"];
                $e = $s["email"];

                $type="Ambulance";

                $q = "SELECT * FROM incident WHERE id = $id";
                $r = mysqli_query($db, $q);
                $row = mysqli_fetch_assoc($r);

                $id=$row['id'];
                $des=$row['description'];
                $lat=$row['latitude'];
                $long=$row['longitude'];
                $dt=$row['reported_datetime'];
                $pid=$row['public_id'];

                
                $link = "https://www.google.com/maps?q={$lat},{$long}";
                

                $q1 = "SELECT * FROM public WHERE id='$pid'";
                $r1 = mysqli_query($db, $q1);
                $row1 = mysqli_fetch_assoc($r1);

                $fn=$row1['firstname'];
                $ln=$row1['lastname'];
                $num=$row1['phonenum'];

                                                


                // Set up email parameters
                $mail->setFrom('aashi.jaulim@gmail.com', 'SAMU IMS');
                $mail->addAddress($e, 'SAMU staff');
                $mail->Subject = 'Urgent: Immediate Attendance Required for Incident Response';
                $mail->Body = 'Dear '.$n.',

We have an incident that demands your immediate attention. 
Please report to the location below promptly to assist in resolving the situation. 

Vehicle assigned: '.$vehN.' ('.$type.' '.$vehID.')

The details of the incident are as follows:

- ID: '.$id.'
- Description: '.$des.'
- Location: '.$link.'
- Date and Time: '.$dt.'

The details of the incident caller are as follows:

- Name: '.$fn.' '.$ln.'
- Phone Number: '.$num.'

Your expertise and cooperation are vital in resolving this incident swiftly. 
If you have any questions or concerns, please contact us on +230 57647416.

Thank you for your immediate action.

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
    
    
            }

            $c = "SELECT * FROM incident WHERE id='$id'";
            $result = mysqli_query($db, $c);
            $c = mysqli_fetch_assoc($result);
            $cID = $c["public_id"];

            $c = "SELECT * FROM public WHERE id='$cID'";
            $result = mysqli_query($db, $c);
            $c = mysqli_fetch_assoc($result);
            $cE = $c["email"];
            $cN = $c["firstname"];
           

            if($cE !=""){
                // Set up email parameters
                $mail->setFrom('aashi.jaulim@gmail.com', 'SAMU IMS');
                $mail->addAddress($cE, 'Public');
                $mail->Subject = 'Incident Update';
                $mail->Body = 'Dear '.$cN.',

The necessary resources have already been deployed to resolve the incident reported by you.

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
                
            }

            
            include 'message.php';
            $msg = '<h2>Resource Allocation<hr></h2>';
            $msg .= '<p>Hospital: ' . $hospitalN . '</p>';
            $msg .= '<p>Ambulance: ' . $vehN . '</p>';
            $msg .= '<p>Helper: ' . $hN1 . ' ' . $hN2 . '</p>';
            $msg .= '<p>Driver: ' . $dN1 . ' ' . $dN2 . '</p>';
            $msg .= '<div class="button-container">';
            $msg .= '<button onclick="window.location.href=\'priority.php\'">Okay</button>';
            $msg .= '</div>';
            generateMessageBox($msg);

            

        }else{

            include 'message.php';

            $msg = '<h2>Resource Alert<hr></h2>';
            $msg .= '<p>No hospital has the required resources right now. <br>Please try again later.</p>';
            $msg .= '<div class="button-container">';
            $msg .= '<button onclick="window.location.href=\'priority.php\'">Okay</button>';
            $msg .= '</div>';
            generateMessageBox($msg);



                
                
        }

        
        


        



        



        
        
        


    } else {
        // If the id parameter is not present in the URL, handle the error accordingly
        //echo "No id parameter provided.";
    }




}
?>