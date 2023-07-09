<?php
$db = new mysqli('localhost', 'root', '!AAshi4477', 'fyp');
if ($db->connect_error) {
    die('Connection Failed: ' . $db->connect_error);
} else {
    $stmt = $db->prepare("INSERT INTO samu_staff (firstname, lastname, email, phonenum, role, status, password, password2, hospital_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Array of data to be inserted
    $data = array(
        array('Bam', 'Hill', 's40@gmail.com', '51192301', 'n', 'available', 'Qw000000', 'Qw000000', '4'),
        array('Hill', 'Mount', 's41@gmail.com', '51115301', 'n', 'available', 'Qw000000', 'Qw000000', '4'),
        array('Mount', 'Flore', 's42@gmail.com', '51192301', 'd', 'available', 'Qw000000', 'Qw000000', '4'),
        array('Flore', 'Damm', 's43@gmail.com', '51115301', 'd', 'available', 'Qw000000', 'Qw000000', '4'),
        array('Damm', 'Sore', 's44@gmail.com', '51192301', 'u', 'available', 'Qw000000', 'Qw000000', '4'),
        array('Sore', 'Tili', 's45@gmail.com', '51192301', 'f', 'available', 'Qw000000', 'Qw000000', '4')
    );

    // Loop through the data and execute the insert statement
    foreach ($data as $row) {
        $stmt->bind_param('sssssssss', ...$row);
        $result = $stmt->execute();
        if (!$result) {
            die('Insert Failed: ' . $stmt->error);
        }
    }
    
    echo "Multiple rows inserted successfully!";
}
?>
