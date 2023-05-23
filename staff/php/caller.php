<!DOCTYPE html>
<html>
<head>
    <style>
        .active {
            background-color: #03d9ffbc;
            /* Replace with your desired color */
            color: #000000 !important;
            /* Replace with your desired text color */
        }
    </style>
    <link rel="stylesheet" type="text/css" href="../css/home.css" />
    <script type="text/JavaScript" src="../js/home.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="../html/home.html">Home</a>
        <a href="../html/resource.html">Resource Management</a>
        <a href="caller.php" class="active">Caller</a>
        <a href="../html/dash.html">Dashboard</a>
        <a href="logout.php">Log Out</a>
    </div>

    <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>
    <br>

    <?php
        // Start the session
        session_start();

        //$id=$_POST['id'];

        //DB connection
        $db = new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
        if ($db->connect_error) {
            die('Connection Failed : ' . $db->connect_error);
        } else {
            $q = "SELECT p.phonenum, i.description, i.latitude, i.longitude
                FROM public p
                JOIN incident i ON p.id = i.public_id";
            $r = mysqli_query($db, $q);

            echo "<table>
                    <tr>
                        <th>Phone Number</th>
                        <th>Description</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                    </tr>";

            while ($row = mysqli_fetch_assoc($r)) {
                $num = $row["phonenum"];
                $des = $row["description"];
                $lat = $row["latitude"];
                $long = $row["longitude"];

                echo "<tr>
                        <td>$num</td>
                        <td>$des</td>
                        <td>$lat</td>
                        <td>$long</td>
                    </tr>";
            }

            echo "</table>";
        }
    ?>

</body>
</html>
