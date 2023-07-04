<?php
    // Start the session
    session_start();
    ?>
<!DOCTYPE html>
<html>
    <style>
        body {
            background-image: url(../../gallery/bg.jpg);
            background-repeat: repeat;
            font-family: Arial, Helvetica, sans-serif;
        }
        .active {
            background-color: rgb(150, 200, 200); /* Replace with your desired color */
            color: teal !important; /* Replace with your desired text color */
        }
        hr{
            background-image: linear-gradient(to left, red, teal); /* Replace "red" and "blue" with your desired colors */
            height: 2px; /* Adjust the height of the hr element as needed */
            border: none;
        }

        .button:hover, .cancel-button:hover {
            background-color: rgb(0, 128, 128, 0.7);
        
            color: black!important;
           
            
        }
        .cancel-button {
            text-decoration:none; 
            background-color:teal; 
            color:white; 
            padding:10px;
            border-radius: 8px;
        }
        
       

        table td, table th {
            padding: 12px;
            text-align: left;
            border-radius: 8px;
            
        }

        table tr {
            background-color: rgb(180, 200, 200)
            
           
        }
        .center {
            display: flex;
            justify-content: center;
            align-items: center;
            
        }

        .menu-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid rgb(150, 200, 200, 0.3);
            height: 43px;
            width: 100%;
            background-color: rgb(150, 200, 200, 0.2);
        }

        .menu-icon {
            font-size: 30px;
            cursor: pointer;
            color: rgb(150, 200, 200);
            margin-left: 20px;
        }

        .firstname {
            text-align: right;
            padding-right: 30px;
            color: rgb(100, 200, 200);
        }

        .call-button {
            align-items: center !important;
            background-image: linear-gradient(45deg, red, teal);
            border: 0;
            border-radius: 8px;
            box-shadow: rgba(151, 65, 252, 0.2) 0 15px 30px -5px;
            box-sizing: border-box;
            color: #ffffff;
            display: flex;
            font-family: Phantomsans, sans-serif;
            font-size: 16px;
            justify-content: center;
            line-height: 1em;
            padding: 10px 20px;
            text-decoration: none;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            white-space: nowrap;
            cursor: pointer;
            width: 260px;
            margin-top: 10px;
            
        }

        .call-button:hover {
            background-image: linear-gradient(45deg, teal, red);
        }

        .sidenav{
            background-color: black !important;
            border-right: 2px solid red; 
            
        }
        .sidenav .active:hover{
            color: teal !important;
        }
        
       
        .sidenav a:hover{
            color: rgb(150, 200, 200) !important;
        }
        

        
    </style>
<head>
    <link rel="stylesheet" type="text/css" href="../cssC/home.css" />
    <script type="text/JavaScript" src="../jsC/home.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

    <img src="../../gallery/logo.png" alt="logo" width="250">
    <br>

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <hr>
        <a href="home.php" class="active">Home</a>
        <hr>
        <a href="../htmlC/formself.php">Self-Reporting</a>
        <hr>
        <a href="../htmlC/formthird.php">Third-Party Reporting</a>
        <hr>
        <a href="logout.php">Log Out</a>
        <hr>
    </div>

    
    



    
    

</body>

</html>
<?php
    // Start the session
    //session_start();
   
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

            $n = $row["firstname"];
            echo '<br>
            <div class="menu-box">
                <span class="menu-icon" onclick="openNav()">&#9776; Menu </span>
                <span class="firstname">Hello '.$n.' &#x1F600;</span>
            </div> <br> <br><br>';

           

            $cID=$row["id"];
            

        
            $caller="SELECT * FROM incident 
                    WHERE public_id='$cID' AND status<>'closed' AND status<>'cancelled'";
            $result=mysqli_query($db, $caller);

           
            
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='center'>";
                echo "<table>";
                
                $res=$row['id'];
                $q1="SELECT * FROM incident 
                        WHERE id='$res'";
                $r1=mysqli_query($db, $q1);
                $stat = mysqli_fetch_assoc($r1);
                $dt=$row['reported_datetime'];
                
                
                echo "<tr>";
                //echo "<td style=' text-align:center' ><b>ID - " . $res."</b><hr>".$row['description'] . "</td>";
                

                echo '<style>
                            .clickable {
                                color: teal;
                                text-decoration: underline;
                                cursor: pointer;
                            }
                        </style>';
                    echo "<td style='text-align:center'><b>" . $row['description'] . "</b><hr><span class='clickable' onclick='showMessage(\"$res\", \"$dt\")'>Click for more details</span></td>";

                echo '<script>
                        function showMessage(res, dt) {
                           
                            window.alert("ID - " + res + "\nReported date and time - " + dt);
                            
                        }

                    </script>';


                if($stat['status']=="pending"){
                    echo "<td style='text-align: center;' ><a href='cancel.php?id=" . $row['id'] . "' class='cancel-button'>Cancel Incident Report</a></td>";

                }
                
                echo "</tr>";

               
                

                echo "<tr>";
                echo "<td colspan='4'>";
                echo "<table style='margin: 0 auto;'>";
                echo "<tr>";
                if ($stat['status'] === "pending") {
                    echo "<td style='text-align: center; color: red; font-weight: bold;'>Pending</td>";
                } else {
                    echo "<td style='text-align: center;'>Pending</td>";
                }
                echo "<td style='text-align: center;'>&#10230;</td>";
                if ($stat['status'] === "dispatched") {
                    echo "<td style='text-align: center; color: red; font-weight: bold;'>Dispatched</td>";
                } else {
                    echo "<td style='text-align: center;'>Dispatched</td>";
                }
                echo "<td style='text-align: center;'>&#10230;</td>";
                if ($stat['status'] === "resolving") {
                    echo "<td style='text-align: center; color: red; font-weight: bold;'>Resolving</td>";
                } else {
                    echo "<td style='text-align: center;'>Resolving</td>";
                }
                echo "<td style='text-align: center;'>&#10230;</td>";
                if ($stat['status'] === "closed") {
                    echo "<td style='text-align: center; color: red; font-weight: bold;'>Closed</td>";
                } else {
                    echo "<td style='text-align: center;'>Closed</td>";
                }
              
                echo "</tr>";
                echo "</table>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
                echo "</div><br><br><br>";
                
               
                
            }

           

            echo '<div class="center">';
            echo '<a class="call-button" href="tel:114">Call 114</a>';
            echo '</div><br>';

        }
        
        
    }
?>

<title>MedRush</title>
<style>
    /* CSS for the footer */
    .footer {
      position: relative;
      left: 0;
      bottom: 0;
      top: 0;;
      width: 100%;
      height: 150px;
      background-color: rgb(150, 200, 200, 0);
      text-align: center;
      overflow: hidden;
    }

    .footer1 {
      position: relative;
      left: 0;
      bottom: 0;
      top: 0;
      width: 100%;
      height: 120px;
      border: 1px solid rgb(150, 200, 200, 0.3);
      background: linear-gradient(to left, rgba(255, 0, 0, 0.5), rgba(0, 128, 128, 0.5)); /* Add a linear gradient background */
      text-align: center;
      overflow: hidden;
    }

    /* CSS for the GIF animation */
    .gif-animation {
      position: relative;
      animation: moveGif 4s linear infinite;
      margin-left: 1px;
    }
   

    /* Keyframes for the GIF animation */
    @keyframes moveGif {
      0% { right: 100%; }
      100% { right: -100%; }
    }

    /* CSS for the icon links */
    .footer-icons {
        display: flex; /* Display the icons in a row */
        justify-content: center; /* Center the icons horizontally */
        align-items: center; /* Center the icons vertically */
        padding: 10px; /* Add some space around the icons */
    }

    .footer-icons a {
        color: rgb(150, 200, 200, 0.5);
        margin: 10px; /* Increase or decrease the margin as needed */
        font-size: 30px; /* Adjust the font size */
        margin-left: 20px;
        margin-right: 20px;
        margin-top: 20px;
        
        transition: color 0.3s ease; /* Add a smooth transition effect on hover */
    }

    .footer-icons a:hover {
        color: rgb(150, 250, 250); /* Change the color on hover */
    }

    .footer1 .copyright {
        color: rgb(150, 200, 200, 0.5);
        font-size: 14px;
        margin-top: 10px; /* Add some space between the icons and the copyright notice */
    }
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  
<div class="footer">
    <div class="gif-animation">
        <img src="./a.gif" alt="Moving GIF">
        <span style="margin-right: 1000px;"></span>
        <img src="./a.gif" alt="Moving GIF">
      
    </div>
</div>




<div class="footer1">
  
    <div class="footer-icons">
        <!-- Phone icon with number -->
        <a href="tel:57647416" target="_blank"><i class="fas fa-phone"></i></a>
        
        <!-- Email icon with email address -->
        <a href="mailto:assist@medrush.com" target="_blank"><i class="fas fa-envelope"></i></a>
        
        <!-- Facebook icon with link to Facebook page -->
        <a href="https://www.facebook.com/medrush" target="_blank"><i class="fab fa-facebook"></i></a>
        
        <!-- Instagram icon with link to Instagram profile -->
        <a href="https://www.instagram.com/medrush" target="_blank"><i class="fab fa-instagram"></i></a>
        
        <!-- YouTube icon with link to YouTube channel -->
        <a href="https://www.youtube.com/medrush" target="_blank"><i class="fab fa-youtube"></i></a>
    </div>

    <p class="copyright">
        &copy;2023 MedRush | All Rights Reserved
    </p>

</div>



