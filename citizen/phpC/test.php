<?php
// Start the session
session_start();

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
                $sev = $loc["severity"];

                if ($sev == "3") {

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
                        $hospital = mysqli_fetch_assoc($result);
                        $hospitalID = $hospital["id"];
                        $hospitalN = $hospital["name"];

                        $vehicle = "SELECT v.id, v.license
                            FROM vehicle v
                            JOIN hospital h ON h.id = v.hospital_id
                            WHERE (v.status = 'available' AND v.type = 'a' AND v.hospital_id = $hospitalID)
                            ORDER BY RAND() LIMIT 1";
                        $result = mysqli_query($db, $vehicle);
                        $veh = mysqli_fetch_assoc($result);
                        $vehID = $veh["id"];
                        $vehN = $veh["license"];

                        /*$query = "UPDATE vehicle
                        SET status = 'dispatched'
                        WHERE id = $vehID";
                        mysqli_query($db, $query);*/

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

                        /*$query = "INSERT INTO incident_staff(incident_id, staff_id)
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
                        mysqli_query($db, $query);*/

                         // JavaScript alert for vehicle dispatch
                        echo '<script>
                                alert("Hospital: ' . $hospitalN . '\nAmbulance: ' . $vehN . '\nHelper: ' . $hN1 . ' ' . $hN2 . '\nDriver: ' . $dN1 . ' ' . $dN2 . '");
                                window.location.href = "../html/resource.html";
                                </script>';

                } else {

                        $hospitals = "SELECT h.id, h.name
                                        FROM hospital h
                                        JOIN (
                                                SELECT hospital_id
                                                FROM samu_staff
                                                WHERE role IN ('d', 'e', 'n')
                                                        AND status = 'available'
                                                GROUP BY hospital_id
                                                HAVING COUNT(DISTINCT role) = 3
                                                        AND COUNT(CASE WHEN role = 'n' THEN 1 END) >= 2
                                                LIMIT 1
                                        ) s ON h.id = s.hospital_id
                                        JOIN vehicle v ON h.id = v.hospital_id
                                        WHERE v.type = 's' AND v.status = 'available'
                                        ORDER BY SQRT(POW(69.1 * (h.latitude - $lat), 2) + POW(69.1 * ($long - h.longitude) * COS(h.latitude / 57.3), 2)) ASC
                                        LIMIT 1";
                        $result = mysqli_query($db, $hospitals);
                        $hospital = mysqli_fetch_assoc($result);
                        $hospitalID = $hospital["id"];
                        $hospitalN = $hospital["name"];

                        $vehicle = "SELECT v.id, v.license
                            FROM vehicle v
                            JOIN hospital h ON h.id = v.hospital_id
                            WHERE (v.status = 'available' AND v.type = 's' AND v.hospital_id = $hospitalID)
                            ORDER BY RAND() LIMIT 1";
                        $result = mysqli_query($db, $vehicle);
                        $veh = mysqli_fetch_assoc($result);
                        $vehID = $veh["id"];
                        $vehN = $veh["license"];

                        /*$query = "UPDATE vehicle
                        SET status = 'dispatched'
                        WHERE id = $vehID";
                        mysqli_query($db, $query);*/

                        $staff = "SELECT s.id, s.firstname, s.lastname  
                            FROM samu_staff s
                            JOIN hospital h ON h.id = s.hospital_id
                            WHERE (s.status = 'available' AND s.role = 'n' AND s.hospital_id = $hospitalID)
                            ORDER BY RAND() LIMIT 2";
                        $result = mysqli_query($db, $staff);
                        if ($result === false) {
                                echo "Query error: " . mysqli_error($db);
                        } else {
                                if (mysqli_num_rows($result) > 0) {
                                        $nID1 = null;
                                        $nID2 = null;

                                        $row = mysqli_fetch_assoc($result);
                                        $nID1 = $row["id"];

                                        $row = mysqli_fetch_assoc($result);
                                        $nID2 = $row["id"];

                                } else {
                                        echo "No available staff found.";
                                }
                        }


                        $staff = "SELECT s.id, s.firstname, s.lastname 
                            FROM samu_staff s
                            JOIN hospital h ON h.id = s.hospital_id
                            WHERE (s.status = 'available' AND s.role = 'e' AND s.hospital_id = $hospitalID)
                            ORDER BY RAND() LIMIT 1";
                        $result = mysqli_query($db, $staff);
                        $staff = mysqli_fetch_assoc($result);
                        $eID = $staff["id"];

                        $staff = "SELECT s.id, s.firstname, s.lastname 
                            FROM samu_staff s
                            JOIN hospital h ON h.id = s.hospital_id
                            WHERE (s.status = 'available' AND s.role = 'd' AND s.hospital_id = $hospitalID)
                            ORDER BY RAND() LIMIT 1";
                        $result = mysqli_query($db, $staff);
                        $staff = mysqli_fetch_assoc($result);
                        $dID = $staff["id"];

                        /*$query = "INSERT INTO incident_staff(incident_id, staff_id)
                        VALUES('$id', '$eID')";
                        mysqli_query($db, $query);

                        $query = "INSERT INTO incident_staff(incident_id, staff_id)
                        VALUES('$id', '$nID1')";
                        mysqli_query($db, $query);

                        $query = "INSERT INTO incident_staff(incident_id, staff_id)
                        VALUES('$id', '$nID2')";
                        mysqli_query($db, $query);

                        $query = "INSERT INTO incident_staff(incident_id, staff_id)
                        VALUES('$id', '$dID')";
                        mysqli_query($db, $query);

                        $query = "UPDATE samu_staff
                        SET status = 'dispatched'
                        WHERE id = $eID";
                        mysqli_query($db, $query);

                        $query = "UPDATE samu_staff
                        SET status = 'dispatched'
                        WHERE id = $nID1";
                        mysqli_query($db, $query);

                        $query = "UPDATE samu_staff
                        SET status = 'dispatched'
                        WHERE id = $nID2";
                        mysqli_query($db, $query);

                        $query = "UPDATE samu_staff
                        SET status = 'dispatched'
                        WHERE id = $dID";
                        mysqli_query($db, $query);*/

                         // JavaScript alert for vehicle dispatch
                        echo '<script>
                                alert("Hospital: ' . $hospitalID . '\nVehicle: ' . $vehID . '\nEmergency Physician: ' . $eID . '\nNurse 1: ' . $nID1 . '\nNurse 2: ' . $nID2 . '\nDriver: ' . $dID . '\n");
                                window.location.href = "../html/resource.html";
                                </script>';


                }

                $CO = $_SESSION['email'];
                $co = "SELECT id FROM control_officer WHERE email='$CO' LIMIT 1";
                $result = mysqli_query($db, $co);
                $co = mysqli_fetch_assoc($result);
                $coID = $co["id"];

                date_default_timezone_set("Indian/Mauritius");
                $dispatch = date("Y-m-d H:i:s");

                /*$query = "UPDATE incident
                    SET status = 'dispatched', dispatched_datetime = '$dispatch', hospital_id = '$hospitalID', co_id = '$coID', vehicle_id = '$vehID'
                    WHERE id = $id";
                mysqli_query($db, $query);*/





               
                




        











        } else {
                // If the id parameter is not present in the URL, handle the error accordingly
                echo "No id parameter provided.";
        }




}
?>