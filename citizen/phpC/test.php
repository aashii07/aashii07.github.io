<?php


// Create a connection
$conn = new mysqli('localhost', 'root', '!AAshi4477', 'fyp');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the roles from the database
$rolesQuery = "SELECT DISTINCT role FROM samu_staff";
$rolesResult = $conn->query($rolesQuery);

if ($rolesResult->num_rows > 0) {
    while ($roleRow = $rolesResult->fetch_assoc()) {
        $role = $roleRow['role'];

        // Retrieve the persons for the specific role
        $sql = "SELECT id, firstname, lastname FROM samu_staff WHERE role = '$role'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
                
            if($role=="e"){
                $rl="Emergency Phisician";
            }else if($role=="u"){
                $rl="Unit Manager";
            }else if($role=="f"){
                $rl="Fleet Manager";
            }else if($role=="n"){
                $rl="Nurse";
            }else if($role=="h"){
                $rl="Helper";
            }else{
                $rl="Driver";
            }
            echo "<h2 style='text-align: center; color: teal; margin-top:60px; text-decoration: underline;'>$rl</h2>";

            echo "<table style='margin: 0 auto;'>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>";

            // Get the current date
            $currentDate = strtotime('last Saturday');
            $currentDate = strtotime('+2 day', $currentDate); // Start from Monday

            for ($day = 0; $day < 7; $day++) {
                $dayName = date('l', $currentDate);
                $date = date('d/m', $currentDate);
                echo "<th>$dayName<br>($date)</th>";
                $currentDate = strtotime('+1 day', $currentDate);
            }

            echo "</tr>";

            while ($row = $result->fetch_assoc()) {
                $personId = $row['id'];
                $firstName = $row['firstname'];
                $lastName = $row['lastname'];

                echo "<tr>
                        <td>$personId</td>
                        <td>$firstName $lastName</td>";

                // Reset the current date for each person
                $currentDate = strtotime('last Saturday');
                $currentDate = strtotime('+2 day', $currentDate); // Start from Monday

                for ($day = 0; $day < 7; $day++) {
                    $dayName = date('l', $currentDate);
                    $date = date('d/m', $currentDate);
                    echo "<td>
                              <select name='shift[$personId][$dayName]'>
                                  <option value='d'>Day + Night</option>
                                  <option value='n'>Day</option>
                                  <option value='dn'>Night</option>
                                  <option value='o'>Off</option>
                              </select>
                          </td>";
                    $currentDate = strtotime('+1 day', $currentDate);
                }

                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No persons found for role '$role'.</p>";
        }
    }
} else {
    echo "<p>No roles found in the database.</p>";
}

$conn->close();
?>
