<!DOCTYPE html>
<html>
    <style>
        .active {
            background-color: #03d9ffbc; /* Replace with your desired color */
            color: #000000 !important; /* Replace with your desired text color */
        }
        .button:hover, .cancel-button:hover {
            background-color: rgb(0, 120, 255, 0.5)!important;
            color: black!important;
            font-weight: bold;
            
        }
        .cancel-button {
            text-decoration:none; 
            background-color:rgb(0, 120, 255); 
            color:white; padding:10px;
            border-radius: 4px;
        }
        
       

        table td, table th {
            padding: 12px;
            text-align: left;
            
        }

        table tr {
            background-color: #f2f2f2;
            
           
        }
        .center {
            display: flex;
            justify-content: center;
            align-items: center;
            
        }
    </style>
<head>
    <link rel="stylesheet" type="text/css" href="../cssC/home.css" />
    <script type="text/JavaScript" src="../jsC/home.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <a href="home.php" class="active">Home</a>
        <a href="../htmlC/formself.html">Self-Reporting</a>
        <a href="../htmlC/formthird.html">Third-Party Reporting</a>
        <a href="logout.php">Log Out</a>
    </div>

    <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>
    <br>

    <br><br>
    <a href="formthird.html" class="button" style="text-decoration:none; background-color:rgb(0, 120, 255); color:white; padding:10px; border-radius: 4px;">Third-Party Reporting</a>
    <a href="formself.html" class="button" style="text-decoration:none; background-color:rgb(0, 120, 255); color:white; padding:10px; border-radius: 4px;">Self-Reporting</a>
    <a href="tel:114" class="button" style="text-decoration:none; background-color:rgb(0, 120, 255); color:white; padding:10px; border-radius: 4px;">Call 114</a>

    <br><br><br>
    



    
    

</body>

</html>
<?php
    // Start the session
    session_start();
   
    //DB connection
    $db=new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
    if($db->connect_error){
        die('Connection Failed : '.$db->connect_error);

    }
    else{
        
        $user=$_SESSION['email'];
        $caller="SELECT * FROM public WHERE email='$user' LIMIT 1";
        $result=mysqli_query($db, $caller);
        $row=mysqli_fetch_assoc($result);
        if($row){

            $cID=$row["id"];

        
            $caller="SELECT * FROM incident 
                    WHERE public_id='$cID' AND status='pending'";
            $result=mysqli_query($db, $caller);
            echo "<div class='center'>";
            echo "<table>";
            while ($row = mysqli_fetch_assoc($result)) {
                
                echo "<tr>";
                echo "<td style='text-align: center; font-weight: bold;' >" . $row['description'] . "</td>";
                echo "<td><a href='cancel.php?id=" . $row['id'] . "' class='cancel-button'>Cancel Incident Report</a></td>";
                echo "</tr>";
                
            }
            echo "</table>";
            echo "</div>";

        }
        
        
    }
?>