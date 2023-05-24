<?php
// Start the session
session_start();

// DB connection
$db = new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
if ($db->connect_error) {
    die('Connection Failed : ' . $db->connect_error);
} else {
    $staff = $_SESSION['email'];
    $user = "SELECT *
                FROM samu_staff
                WHERE email='$staff'";
    $result = mysqli_query($db, $user);
    $row = mysqli_fetch_assoc($result);
    $hos = $row['hospital_id'];

    // Retrieve the roles from the database
    $rolesQuery = "SELECT DISTINCT role FROM samu_staff";
    $rolesResult = mysqli_query($db, $rolesQuery);

    if (mysqli_num_rows($rolesResult) > 0) {
        echo "<form method='post' action='Ushift.php'>"; // Add the form element here


        echo "<html>
            <style>
                .active {
                    background-color: #03d9ffbc;
                    /* Replace with your desired color */
                    color: #000000 !important;
                    /* Replace with your desired text color */
                }

                table {
                    border-collapse: collapse;
                }

                th, td {
                    padding: 8px;
                    text-align: center;
                    border: 1px solid #ddd;
                }

                th {
                    background-color: #f2f2f2;
                }

                select {
                    padding: 4px;
                }

                .center {
                    display: flex;
                    justify-content: center;
                    margin-top: 20px;
                }

                /* Add CSS for highlighting */
                .highlight-row td {
                    background-color: #e6f4f1;
                }
            </style>

            <head>
                <link rel=\"stylesheet\" type=\"text/css\" href=\"../css/home.css\" />
                <script type=\"text/JavaScript\" src=\"../js/home.js\"></script>
                <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
            </head>

            <body>

                <div id=\"mySidenav\" class=\"sidenav\">
                    <a href=\"javascript:void(0)\" class=\"closebtn\" onclick=\"closeNav()\">&times;</a>
                    <a href=\"../html/Uhome.html\">Home</a>
                    <a href=\"Uscheduling.php\" class=\"active\">Staff Scheduling</a>
                    <a href=\"UselectS.php\">Remove Staff</a>
                    <a href=\"logout.php\">Log Out</a>
                </div>

                <span style=\"font-size:30px;cursor:pointer\" onclick=\"openNav()\">&#9776; Menu</span>
                <br>";
            echo "</body>
        </html>";

        while ($roleRow = mysqli_fetch_assoc($rolesResult)) {
            $role = $roleRow['role'];

            // Retrieve the persons for the specific role
            $sql = "SELECT id, firstname, lastname FROM samu_staff WHERE role = '$role' AND hospital_id='$hos'";
            $result = mysqli_query($db, $sql);

            if (mysqli_num_rows($result) > 0) {

                if ($role == "e") {
                    $rl = "Emergency Physician";
                } else if ($role == "u") {
                    $rl = "Unit Manager";
                } else if ($role == "f") {
                    $rl = "Fleet Manager";
                } else if ($role == "n") {
                    $rl = "Nurse";
                } else if ($role == "h") {
                    $rl = "Helper";
                } else {
                    $rl = "Driver";
                }
                

                echo "<h2 style='text-align: center; color: teal; margin-top:60px; text-decoration: underline; font-size: 30px;'>$rl</h2>";

                echo "<table style='margin: 0 auto;' id='grid-table'>
                        <tr>
                        <th>ID</th>
                        <th>Name</th>";

                // Get the current date
                $currentDate = strtotime('today');

                // Get the day of the week (1 for Monday, 2 for Tuesday, etc.)
                $dayOfWeek = date('N', $currentDate);

                // Calculate the start date of the week
                if ($dayOfWeek === '1') {
                    // Current day is Monday, use the current date as the week start
                    $weekStart = $currentDate;
                } else {
                    // Find the previous Monday
                    $weekStart = strtotime('last Monday', $currentDate);
                }

                // Calculate the end date of the week
                $weekEnd = strtotime('+6 days', $weekStart);

                $start=$weekStart;
                $wk=$weekStart;

                for ($day = 0; $day < 7; $day++) {
                    $dayName = date('D', $weekStart);
                    $date = date('Y-m-d', $weekStart);
                    echo "<th>$dayName<br><span style='font-size: 13px; font-weight: normal;'>($date)</span></th>";

                    $weekStart = strtotime('+1 day', $weekStart);
                    // $weekEnd can also be updated if needed
                }




                echo "</tr>";

                while ($row = mysqli_fetch_assoc($result)) {
                    $personId = $row['id'];
                    $firstName = $row['firstname'];
                    $lastName = $row['lastname'];

                    echo "<tr class='grid-row'>
                            <td>$personId</td>
                            <td>$firstName $lastName</td>";

                    

                    $start=$wk;
                    for ($day = 0; $day < 7; $day++) {
                        $dayName = date('D', $start);
                        $date = date('Y-m-d', $start);
                        
                        
                        

                        $q="SELECT shift FROM staff_schedule WHERE date='$date' AND staff_id='$personId'";
                        $r=mysqli_query($db, $q);
                        if (mysqli_num_rows($r) == 0){
                            
                            $q1="INSERT INTO staff_schedule (date, staff_id)
                                VALUES('$date', '$personId')";
                            $r1=mysqli_query($db, $q1);
                            
                            $q="SELECT shift FROM staff_schedule WHERE date='$date' AND staff_id='$personId'";
                            $r=mysqli_query($db, $q);

                        }
                        
                        $rw=mysqli_fetch_assoc($r);
                        $s=$rw['shift'];
                        if($s=="d"){
                            $S="Day";
                        }else if($s=="dn"){
                            $S="Day + Night";
                        }else if($s=="n"){
                            $S="Night";
                        }else if($s=="o"){
                            $S="Off Duty";
                        }else{
                            $S="Select shift";
                        }

                        echo "<td data-row='$personId' data-col='$day' class='grid-cell'>
                        <input type='hidden' name='shift[$personId][$day][date]' value='$date'>
                        
                        <input type='hidden' name='shift[$personId][$day][staff_id]' value='$personId'>";
                        
                        

                        if($date >= date('Y-m-d')){

                            echo "<select name='shift[$personId][$day][shift]'>
                            <option value='$s'>$S</option>
                            " . ($S !== 'Day + Night' ? "<option value='dn'>Day + Night</option>" : "") . "
                            " . ($S !== 'Day' ? "<option value='d'>Day</option>" : "") . "
                            " . ($S !== 'Night' ? "<option value='n'>Night</option>" : "") . "
                            " . ($S !== 'Off Duty' ? "<option value='o'>Off Duty</option>" : "") . "                                
                            </select>
                            </td>";
                        }else{
                            echo "<select name='shift[$personId][$day][shift]'>
                            <option value='$s'>$S</option>                        
                            </select>
                            </td>";
                        }

                        
                        $start = strtotime('+1 day', $start);
                    }

                    echo "</tr>";
                }

                echo "</table>";


            } else {

                //echo "<p>No persons found for role '$role'.</p>";
            }
        }

        echo "<div style='text-align: center; margin-top: 60px;'>
            <button type='submit' style='display: inline-block; background-color: teal; color: white; padding: 15px 30px; border: none; border-radius: 4px; font-size: 20px; text-decoration: none;'>Save Shift</button>
        </div>";

        echo "</form>"; // Close the form element here


               

    } else {
        echo "<p>No roles found in the database.</p>";
    }

}

?>

<script>
    // Add event listeners to highlight row on hover
    var gridRows = document.querySelectorAll('.grid-row');

    if (gridRows) {
        for (var i = 0; i < gridRows.length; i++) {
            gridRows[i].addEventListener('mouseover', highlightRow);
            gridRows[i].addEventListener('mouseout', removeHighlight);
        }
    }

    function highlightRow(event) {
        var row = event.target.parentNode;
        row.classList.add('highlight-row');
    }

    function removeHighlight(event) {
        var row = event.target.parentNode;
        row.classList.remove('highlight-row');
    }
</script>
