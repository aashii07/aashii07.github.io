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
    .sidenav{
        background-color: black !important;
        border-right: 2px solid red; 
        
    }
    
    
    .sidenav a:hover{
        color: rgb(150, 200, 200) !important;
    }
    .sidenav .active:hover{
        color: teal !important;
    }



    .container {
      border-radius: 5px;
      background-color: rgb(150, 200, 200) !important;
      padding: 20px;
      margin-top: 0px;
      padding-top: 0px;
      width: 60%;
     
    }


    .container-parent {
      display: flex;
      justify-content: center;
      align-items: center;

    }




    .button-64 {
        align-items: center;
        background-image: linear-gradient(45deg,red, teal);
        border: 0;
        border-radius: 8px;
        box-shadow: rgba(151, 65, 252, 0.2) 0 15px 30px -5px;
        box-sizing: border-box;
        color: #FFFFFF;
        display: flex;
        font-family: Phantomsans, sans-serif;
        font-size: 16px; /* Updated font size */
        justify-content: center;
        line-height: 1em;
        width: 100%; /* Updated width */
        padding: 3px; /* Updated padding */
        text-decoration: none;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        white-space: nowrap;
        cursor: pointer;
    }

    .button-64:active,
    .button-64:hover {
        outline: 0;
    }

    .button-64 span {
        background-color: rgb(5, 6, 45);
        padding: 20px; /* Updated padding */
        border-radius: 6px;
        width: 100%;
        height: 20px;
        transition: 300ms;
        padding-bottom: 30px;
        padding-top: 15px;
        
    }

    .button-64:hover span {
        background: none;
    }

    


        

    
   



</style>



<head>
    <link rel="stylesheet" type="text/css" href="../cssC/form.css" />
    <script type="text/JavaScript" src="../jsC/form.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

  <img src="../../gallery/logo.png" alt="logo" width="250">
  <br>

  <div id="mySidenav" class="sidenav">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <hr>
      <a href="../phpC/home.php" >Home</a>
      <hr>
      <a href="formself.php" class="active">Self-Reporting</a>
      <hr>
      <a href="formthird.php">Third-Party Reporting</a>
      <hr>
      <a href="../phpC/logout.php">Log Out</a>
      <hr>
  </div>

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
            </div>';

           
        }
        
        
    }
?>

 

    <span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776; Menu</span>

    

    <div class="container-parent">
    <div class="container">
    <h1>Incident Details</h1><hr><br>
       
        
        <form onsubmit="return validateForm()" action="../phpC/formself.php" method="post">

            
            
           

            
            
           

        <label for="latitude"><b>Latitude</b></label>
        <input type="text" id="latitude" name="lat">

        <label for="longitude"><b>Longitude</b></label>
        <input type="text" id="longitude" name="long">


            
            <label for="subject"><b>Description</b></label>
            <textarea id="subject" name="subject" placeholder="Write here.." style="height:100px"></textarea>

            

            

            <button class="button-64" role="button"><span class="text">Submit</span></button>
        </form>
    </div>
    </div>
    


    <script>

    window.onload = function() {
          getLocation();
        };
        
        
        function getLocation() {
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(fillForm);
        } else {
          alert("Geolocation is not supported by this browser.");
        }
      }

      function fillForm(position) {
        document.getElementById("latitude").value = position.coords.latitude;
        document.getElementById("longitude").value = position.coords.longitude;
      }

      
      function validateForm() {
        var latitude = document.getElementById("latitude").value.trim();
        var longitude = document.getElementById("longitude").value.trim();
        var description = document.getElementById("subject").value.trim();

        // Check if latitude and longitude are valid numbers
        if (latitude === "") {
          alert("Latitude can't be blank");
          return false;
        }else if (latitude < -20.55 || latitude > -20) {
          alert("Latitude must be between -20.55 and -20.00");
          return false;
        }

        if (longitude === "") {
          alert("Longitude can't be blank");
          return false;
        }else if (longitude < 57.31 || longitude > 57.82) {
          alert("Longitude must be between 57.31 and 57.82");
          return false;
        }

        if (description === "") {
          alert("Description can't be blank");
          return false;
        }

        return true; // Form submission will proceed if all validations pass
      }
  
  </script>
        

</body>



</html>