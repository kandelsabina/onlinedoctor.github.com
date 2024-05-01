<?php
include "connection.php";

$speciality = $_GET['speciality'];
$doctor = $_GET['doctor'];

// Fetching available days, start time, and end time for the selected doctor and speciality
$sql = "SELECT available_days, start_time, end_time FROM users WHERE speciality = '$speciality' AND username = '$doctor'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$availableDays = explode(",", $row['available_days']);
$startTime = $row['start_time'];
$endTime = $row['end_time'];

// Fetching today's date
$today = date("Y-m-d");

// Generating available dates within the specified range
$availableDates = array();
for ($i = 0; $i < 7; $i++) { // Generate dates for the next 7 days
    $date = date('Y-m-d', strtotime($today . " +$i day"));
    $dayOfWeek = date('N', strtotime($date));

    // Check if the day is available
    if (in_array($dayOfWeek, $availableDays)) {
        $availableDates[] = $date;
    }
}

// Generating available time slots for each available date
$availableTimes = array();
foreach ($availableDates as $date) {
    $times = generateTimeSlots($startTime, $endTime);
    $availableTimes[$date] = $times;
}

echo json_encode(array("dates" => $availableDates, "times" => $availableTimes));

// Function to generate time slots between start and end time
function generateTimeSlots($startTime, $endTime)
{
    $times = array();
    $currentTime = strtotime($startTime);
    $endTime = strtotime($endTime);

    while ($currentTime < $endTime) {
        $times[] = date("H:i", $currentTime);
        $currentTime += 15 * 60; // Increment by 15 minutes
    }

    return $times;
}
?>
