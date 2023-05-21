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

    // Retrieve all staff from the hospital
    $query = "SELECT * FROM samu_staff WHERE hospital_id='$hos'";
    $staffResult = mysqli_query($db, $query);

    echo "<form method='post' action='Uremove.php'>";

    echo "<html>
            <style>
                .active {
                    background-color: #03d9ffbc;
                    /* Replace with your desired color */
                    color: #000000 !important;
                    /* Replace with your desired text color */
                }
                /* CSS styles for name boxes */
                .name-box {
                    border: 1px solid #ccc;
                    padding: 10px;
                    margin: 5px;
                    display: inline-block;
                    cursor: pointer;
                    background-color: #f2f2f2;
                    border-radius: 4px;
                    transition: background-color 0.3s;
                    font-size: 14px;
                    color: #333;
                    text-align: center;
                    width: 200px;
                }
                .name-box:hover {
                    background-color: #e0e0e0;
                }
                .selected {
                    background-color: teal;
                    color: white;
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
                    <a href=\"Uscheduling.php\">Staff Scheduling</a>
                    <a href=\"UselectS.php\" class=\"active\">Remove Staff</a>
                    <a href=\"logout.php\">Log Out</a>
                </div>
                <span style=\"font-size:30px;cursor:pointer\" onclick=\"openNav()\">&#9776; Menu</span>
                <br>
            </body>
        </html>";
        echo "<input type='text' id='search-input' onkeyup='filterNames()' placeholder='Search for staff' style='margin-bottom: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 16px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);'>
        <br>";

    echo "<script>
        var selectedIDs = [];

        function toggleSelection(element, id) {
          element.classList.toggle('selected');
          var index = selectedIDs.indexOf(id);
          if (index !== -1) {
            selectedIDs.splice(index, 1);
          } else {
            selectedIDs.push(id);
          }
        }

        function submitForm() {
          document.getElementById('selected-ids-input').value = selectedIDs.join(',');
          document.forms[0].submit();
        }

        function filterNames() {
          var input, filter, names, nameBox, i;
          input = document.getElementById('search-input');
          filter = input.value.toUpperCase();
          names = document.getElementsByClassName('name-box');
          
          for (i = 0; i < names.length; i++) {
            nameBox = names[i];
            if (nameBox.innerText.toUpperCase().indexOf(filter) > -1) {
              nameBox.style.display = '';
            } else {
              nameBox.style.display = 'none';
            }
          }
        }
    </script>";

    while ($staffRow = mysqli_fetch_assoc($staffResult)) {
        $fname = $staffRow['firstname'];
        $lname = $staffRow['lastname'];
        $id = $staffRow['id'];
        $rl = $staffRow['role'];
        if($rl=="f"){
            $rl="Fleet Manager";
        }else if($rl=="u"){
            $rl="Unit Manager";
        }else if($rl=="e"){
            $rl="Emergency Physician";
        }else if($rl=="h"){
            $rl="Helper";
        }else if($rl=="d"){
            $rl="Driver";
        }else if($rl=="n"){
            $rl="Nurse";
        }

        echo "<div class='name-box' onclick='toggleSelection(this, $id)'>
                $id<br>$fname $lname<br>$rl
              </div>";
    }

    echo "<input type='hidden' name='selected_ids' id='selected-ids-input'>";

    echo "<div style='text-align: center; margin-top: 20px;'>
            <button type='button' onclick='submitForm()' style='display: inline-block; background-color: teal; color: white; padding: 15px 30px; border: none; border-radius: 4px; font-size: 20px; text-decoration: none;'>Remove Staff</button>
        </div>";

    echo "</form>";
}
?>
