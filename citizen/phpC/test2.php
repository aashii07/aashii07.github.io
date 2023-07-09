<?php
// Function to make an HTTP request using cURL
function makeRequest($url) {
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($curl);
    curl_close($curl);
    return $response;
}

// Replace "http://localhost:5000" with the actual URL where your Flask server is running
$flaskUrl = "http://localhost:5000";

// Make a GET request to the Flask server
$response = makeRequest($flaskUrl);

?>
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
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';  
    $mail->Port = 587;  
    $mail->SMTPSecure = 'tls'; 
    $mail->SMTPAuth = true;
    $mail->Username = 'aashi.jaulim@gmail.com'; 
    $mail->Password = 'hhjqbxsjjwrqbpee'; 

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

<?php

        $selectedIDs = $_POST['selected_ids'];
        $selectedIDsArray = explode(',', $selectedIDs);
        $q = "SELECT * FROM vehicle WHERE id IN (";
        foreach ($selectedIDsArray as $index => $id) {
            $q .= $id;
            if ($index < count($selectedIDsArray) - 1) {
                $q .= ",";
            }
        }
        $q .= ")";

        $result = mysqli_query($db, $q);
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $status = $row['status'];
            
            if($status=="available"){
                $query="UPDATE vehicle
                        SET status='maintenance'
                        WHERE id='$id'";
                $res = mysqli_query($db, $query);
            }else if($status=="maintenance"){
                $query="UPDATE vehicle
                        SET status='available'
                        WHERE id='$id'";
                $res = mysqli_query($db, $query);
            }
        }
    
