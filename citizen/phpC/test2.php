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
