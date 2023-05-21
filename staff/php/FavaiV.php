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
    $query = "SELECT * FROM vehicle WHERE hospital_id='$hos' AND (status='available' OR status='maintenance')";
    $result = mysqli_query($db, $query);

    echo "<form method='post' action='Fupdate.php'>";
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
                table {
                    width: 100%;
                    border-collapse: collapse;
                    

                }
            
                th,
                td {
                    padding: 10px;
                    text-align: left;
                    border-bottom: 1px solid #ccc;
                }
            
                th {
                    background-color: #f2f2f2;
                }

                th:first-child,
                td:first-child {
                    padding-right: 0;
                    padding-left: 100;
                }

                th:last-child,
                td:last-child {
                    padding-left: 0;
                    padding-right: 400;
                }

                tr.available-row {
                    background-color: lightgreen;
                }
            
                tr.maintenance-row {
                    background-color: rgb(255, 120, 120);
                }
            
                /* Selected row style */
                tr.selected {
                    background-color: #333333;
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
                    <a href=\"../html/Fhome.html\">Home</a>
                    <a href=\"FavaiV.php\" class=\"active\">Vehicle Availability</a>
                    <a href=\"../html/Fadd.html\">Add Vehicle</a>
                    <a href=\"FselectV.php\" >Remove Vehicle</a>
                    <a href=\"logout.php\">Log Out</a>
                </div>
                <span style=\"font-size:30px;cursor:pointer\" onclick=\"openNav()\">&#9776; Menu</span>
                <br>
            </body>
        </html>";

    echo "<input type='text' id='search-input' onkeyup='filterNames()' placeholder='Search for vehicle' style='margin-bottom: 10px; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 16px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);'>";

    echo "<table id='vehicle-list'>";
    echo "<tr>
            <th>ID</th>
            <th>License</th>
          </tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        $license = $row['license'];
        $id = $row['id'];
        $status = $row['status'];


        // Set the CSS class based on the status
        $rowClass = '';
        if ($status == 'available') {
            $rowClass = 'available-row';
        } elseif ($status == 'maintenance') {
            $rowClass = 'maintenance-row';
        }

        echo "<tr onclick='toggleSelection(this, $id)' class='$rowClass'>
                <td>$id</td>
                <td>$license</td>
            </tr>";
    }
    echo "</table>";

    echo "<input type='hidden' name='selected_ids' id='selected-ids-input'>";

    echo "<div style='text-align: center; margin-top: 20px;'>
            <button type='button' onclick='submitForm()' style='display: inline-block; background-color: teal; color: white; padding: 15px 30px; border: none; border-radius: 4px; font-size: 20px; text-decoration: none;'>Update</button>
        </div>";

    echo "</form>";
}
?>

<script>
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
  var input, filter, table, tr, td, i;
  input = document.getElementById('search-input');
  filter = input.value.toUpperCase();
  table = document.getElementById('vehicle-list');
  tr = table.getElementsByTagName('tr');

  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName('td');
    var match = false;
    for (var j = 0; j < td.length; j++) {
      if (td[j].innerHTML.toUpperCase().indexOf(filter) > -1) {
        match = true;
        break;
      }
    }
    if (match) {
      tr[i].style.display = '';
    } else {
      // Hide only the content of the row, not the entire row
      for (var k = 0; k < td.length; k++) {
        td[k].style.display = 'none';
      }
    }
  }
}
</script>
