<?php
    // Start the session
    session_start();
   ?>
   <!DOCTYPE html>
<html>
<head>
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
    
    
    .sidenav a:hover{
        color: rgb(150, 200, 200) !important;
    }
    .sidenav .active:hover{
        color: teal !important;
    }

    .container{
      background-color: rgb(150, 200, 200) !important;
      
    }

    
    #container {
      display: flex;
     
    }
    #form-container {
      flex: 1;
      padding-right: 20px;
    }
    #map-container {
      flex: 1;
      position: relative;
      
    }
    #map {
      height: 837px;
      width: 100%;
    }
    #search-container {
      position: absolute;
      top: 10px;
      right: 10px;
      z-index: 1;
      display: flex;
      align-items: center;
    }
    #search-input {
      width: 200px;
      height: 30px;
      margin-right: 10px;
      padding: 5px;
    }
    #search-button {
      background-color: red;
      border: none;
      color: white;
      padding: 5px 10px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 14px;
      cursor: pointer;
      margin-top: -10px;
    }
    #search-button:hover{
      background-color: darkred;
    }
  </style>
  <link rel="stylesheet" type="text/css" href="../cssC/form.css" />
  <script type="text/JavaScript" src="../jsC/form.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAUQso1o7rMdoSw6dxo9dCBIfPOKgDX7D8&libraries=places"></script>
  <script>
    var markers = [];

    function placeMarker(location) {
      markers.forEach(function(marker) {
        marker.setMap(null);
      });
      markers = [];

      var marker = new google.maps.Marker({
        position: location,
        map: map
      });

      markers.push(marker);

      document.getElementById('latitude').value = location.lat();
      document.getElementById('longitude').value = location.lng();
    }

    function initMap() {
      var map = new google.maps.Map(document.getElementById('map'), {
        
        
        zoom: 13
      });

      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          var currentLocation = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
          };

          map.setCenter(currentLocation);

          var marker = new google.maps.Marker({
            position: currentLocation,
            map: map,
            title: 'Current Location'
          });
        }, function() {
          // Handle error if the user denies geolocation access
          handleLocationError(true, map.getCenter());
        });
      } 

      var searchContainer = document.createElement('div');
      searchContainer.setAttribute('id', 'search-container');

      var searchInput = document.createElement('input');
      searchInput.setAttribute('type', 'text');
      searchInput.setAttribute('placeholder', 'Enter location');
      searchInput.setAttribute('id', 'search-input');
      searchInput.setAttribute('name', 'loc');

      var searchButton = document.createElement('button');
      searchButton.setAttribute('type', 'button');
      searchButton.setAttribute('onclick', 'searchLocation()');
      searchButton.setAttribute('id', 'search-button');
      searchButton.textContent = 'Search';

      searchContainer.appendChild(searchInput);
      searchContainer.appendChild(searchButton);

      document.getElementById('map-container').appendChild(searchContainer);

      var searchBox = new google.maps.places.SearchBox(searchInput);

      map.addListener('bounds_changed', function() {
        searchBox.setBounds(map.getBounds());
      });

      searchButton.addEventListener('click', searchLocation);

      searchInput.addEventListener('keydown', function(event) {
        if (event.key === "Enter") {
          event.preventDefault();
          searchLocation();
        }
      });

      function searchLocation() {
        var places = searchBox.getPlaces();
        if (places.length === 0) {
          alert('No results found');
          return;
        }

        markers.forEach(function(marker) {
          marker.setMap(null);
        });
        markers = [];

        map.setCenter(places[0].geometry.location);

        

        var marker = new google.maps.Marker({
          
          map: map,
          position: places[0].geometry.location
        });

        markers.push(marker);

        document.getElementById('latitude').value = places[0].geometry.location.lat();
        document.getElementById('longitude').value = places[0].geometry.location.lng();
      }

      map.addListener('click', function(event) {
        placeMarker(event.latLng);
      });
    }
  </script>
</head>
<body>

  <img src="../../gallery/logo.png" alt="logo" width="250">
    <br>

  <div id="mySidenav" class="sidenav">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <hr>
      <a href="../phpC/home.php" >Home</a>
      <hr>
      <a href="formself.php" >Self-Reporting</a>
      <hr>
      <a href="formthird.php" class="active">Third-Party Reporting</a>
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

    
  <div id="container">
    <div id="form-container" class="container">
      <h1>Patient Details</h1><hr><br>

      <form onsubmit="return validateForm()" action="../phpC/formthird.php" method="post">
        <label for="fnamep"><b>First Name</b></label>
        <input type="text" placeholder="Enter first name" name="fnamep" id="fn">

        <label for="lnamep"><b>Last Name</b></label>
        <input type="text" placeholder="Enter your last name" name="lnamep" id="ln">

        <label for="age"><b>Age</b></label>
        <input type="text" placeholder="Enter age" name="age" id="a">

        <label><b>Gender</b></label>
        <br><br>
        <label class="choice">Male
          <input type="radio" checked="checked" name="gender" value="m">
          <span class="checkmark"></span>
        </label>
        <label class="choice">Female
          <input type="radio" name="gender" value="f">
          <span class="checkmark"></span>
        </label>
        <label class="choice">Other
          <input type="radio" name="gender" value="o">
          <span class="checkmark"></span>
        </label>

        <br><br>
        <label for="lat"><b>Latitude</b></label>
        <input type="text" id="latitude" placeholder="Latitude" name="lat">
        <label for="long"><b>Longitude</b></label>
        <input type="text" id="longitude" placeholder="Longitude" name="long">

        <br>
        <label for="subject"><b>Description</b></label>
        <textarea id="subject" name="subject" placeholder="Write here.." style="height:100px"></textarea>

        <button class="button-64" role="button"><span class="text">Submit</span></button>
      </form>
    </div>

    <div id="map-container">
      <div id="map"></div>
    </div>
  </div>

  <script>
    initMap();

    function validateForm() {
        var latitude = document.getElementById("latitude").value.trim();
        var longitude = document.getElementById("longitude").value.trim();
        var description = document.getElementById("subject").value.trim();
        var fn = document.getElementById("fn").value.trim();
        var ln = document.getElementById("ln").value.trim();
        var age = document.getElementById("a").value.trim();

        if (fn !== '' && !isValidName(fn)) {
          alert("First name can contain letters, spaces, apostrophes, and hyphens only");
          return false;
        }

        if (ln !== '' && !isValidName(ln)) {
          alert("Last name can contain letters, spaces, apostrophes, and hyphens only");
          return false;
        }

        if (age !== '') {
          if (isNaN(age) || parseInt(age) < 0) {
            alert("Age must be a positive number");
            return false;
          }
        }
          

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

      function isValidName(name) {
        var nameRegex = /^[a-zA-Z\s'-]+$/; // Regular expression to allow letters, spaces, apostrophes, and hyphens

        return nameRegex.test(name);
      }
  </script>
</body>
</html>
