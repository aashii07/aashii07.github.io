<?php
echo "table {
    border-collapse: collapse;
}

th, td {
    padding: 8px;
    text-align: center;
    border: 1px solid #ddd;
}

th {
    background-color: #f2f2f2;
}

select {
    padding: 4px;
}

.center {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}";
$staff = $_SESSION['email'];
$user = "SELECT *
            FROM samu_staff
            WHERE email='$staff'";
$result = mysqli_query($db, $user);
$row = mysqli_fetch_assoc($result);
$id = $row['id'];

$currentDate = date('Y-m-d');  // Get the current date in 'YYYY-MM-DD' format
$weekStartDate = date('Y-m-d', strtotime("last Monday", strtotime($currentDate))); // Get the week start date

// Generate the week
$week = array();
for ($i = 0; $i < 7; $i++) {
    $day = date('Y-m-d', strtotime("+$i days", strtotime($weekStartDate)));
    $dname = date('D', $weekStartDate);
    $week[] = $day;
}



// Print the week
foreach ($week as $day) {
    echo $day . "\n";
    echo $dname."\n";
    $q="SELECT * FROM staff_schedule
        WHERE staff_id='$id' AND date='$day'";
    $r = mysqli_query($db, $q);
    $row = mysqli_fetch_assoc($r);
    $shift = $row['shift'];
    if($shift=="d"){
        $S="Day";
    }else if($shift=="dn"){
        $S="Day + Night";
    }else if($shift=="n"){
        $S="Night";
    }else if($shift=="o"){
        $S="Off Duty";
    }else{
        $S="";
    }
    echo $S;
}

?>
