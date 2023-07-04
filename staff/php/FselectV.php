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
            width: 300px;
            margin-top: 0px;
            margin-left: 10px;
            margin-bottom: 5px;
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
        


        .button-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* Create two equal-width columns */
            gap: 5px; /* Adjust the gap between buttons */
            justify-content: center; /* Center align buttons horizontally */
            margin-top: 0px; /* Add margin for spacing */
            margin-bottom: 5px;
            margin-left: 40%;
            margin-right: 40%;
        }
        
        

        .center {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        

        .box{
            background-color: rgb(150, 200, 200, 0.5);
            width: 50%;
            margin-left: 25%;
            border-radius: 10px;
            
           
            
        }
        
    </style>

<head>
    <link rel="stylesheet" type="text/css" href="../css/home.css" />
    <script type="text/JavaScript" src="../js/home.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

    <img src="../../gallery/logo.png" alt="logo" width="250">
    <br>

    <div id="mySidenav" class="sidenav">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
        <hr>
        <a href="Fhome.php" >Home</a>
        <hr>
        <a href="../php/FavaiV.php">Vehicle Availability</a>
        <hr>
        <a href="../html/Fadd.php" >Add Vehicle</a>
        <hr>
        <a href="../php/FselectV.php" class="active">Remove Vehicle</a>
        <hr>
        <a href="../php/logout.php">Log Out</a>
        <hr>
    </div>



   





</body>

</html>
<?php

   
    



    // Start the session
    //session_start();
    $_SESSION['schedule']="0";
    require_once('../php/Ushift.php');
    

    //DB connection
    $db=new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
    if($db->connect_error){
        die('Connection Failed : '.$db->connect_error);
    }
    else{
        
        $staff=$_SESSION['email'];
        $user = "SELECT *
                    FROM samu_staff
                    WHERE email='$staff'";
        $result = mysqli_query($db, $user);
        $staff = mysqli_fetch_assoc($result);
        $id = $staff['id'];
        $status = $staff['status'];
        $n = $staff['firstname'];

        echo '<br>
            <div class="menu-box">
                <span class="menu-icon" onclick="openNav()">&#9776; Menu </span>
                <span class="firstname">Hello '.$n.' &#x1F600;</span>
            </div> <br>';

        
    }
?>



<?php
// Start the session


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
    $query = "SELECT * FROM vehicle WHERE hospital_id='$hos'";
    $result = mysqli_query($db, $query);

    echo "<form method='post' action='Fremove.php'>";

    echo "<html>
            <style>
                
                .name-box {
                    border: 1px solid #ccc;
                    padding: 10px;
                    margin: 5px;
                    display: inline-block;
                    cursor: pointer;
                    background-color: rgb(170, 200, 200);
                    border-radius: 4px;
                    transition: background-color 0.3s;
                    font-size: 14px;
                    color: #333;
                    text-align: center;
                    width: 200px;
                }
                .name-box:hover {
                    background-color:rgb(120, 200, 200);
                    color: white;

                }
                .selected {
                    background-color: teal;
                    color: white;
                }
            </style>

           <br><br>
        </html>";
        echo "<input type='text' id='search-input' onkeyup='filterNames()' placeholder='Search for vehicle details'
    style='margin-bottom: 20px; padding: 10px; width: 50%; margin: 0 auto; display: block;
    border: 1px solid #ccc; border-radius: 4px; font-size: 16px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);'>
    <br><hr><br>";


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
    echo "<div style='margin-left:150px;'>";

    while ($row = mysqli_fetch_assoc($result)) {
      $license = $row['license'];
      $type = $row['type'];
      $id = $row['id'];

      if($type=="a"){
          $type="Ambulance";
      }else if($type=="s"){
          $type="SAMU";
      }

      echo "<div class='name-box' onclick='toggleSelection(this, $id)'>
              $id<br>$license<br>$type
            </div>";
  }
    echo  "</div><br>";

    echo "<input type='hidden' name='selected_ids' id='selected-ids-input'>";

    echo "<div style='text-align: center; margin-top: 20px;'>
            <button class='call-button' onclick='submitForm()' style='display: inline-block; background-color: teal; color: white; padding: 15px 30px; border: none; border-radius: 4px; font-size: 20px; text-decoration: none;'>Remove Vehicle</button>
    </div>";

    echo "</form>";
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








