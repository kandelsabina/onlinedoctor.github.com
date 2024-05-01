<?php
session_start();
include "connection.php";

// Check if the date parameter is set
if(isset($_GET['date'])) {
    // Get the selected date from the request
    $date = $_GET['date'];
    
    // Check if the selected date is not a Saturday (assuming Saturday should be excluded)
    $dayOfWeek = date('N', strtotime($date));
    if($dayOfWeek = 6) { 
        echo "NO appointments available";
        exit;}
        // Fetch available appointment times for the selected date from the database
        $sql = "SELECT appointment_time FROM appointments WHERE appointment_date = '$date'";
        $result = mysqli_query($conn, $sql);

        // Array to store all possible appointment times
        $appointment_times = array("08:00", "08:30", "09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00", "13:30", "14:00", "14:30", "15:00", "15:30", "16:00", "16:30", "17:00");

        // Loop through the fetched results to remove booked times
        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $booked_time = $row['appointment_time'];
                // Remove booked time from available appointment times
                $key = array_search($booked_time, $appointment_times);
                if($key !== false) {
                    unset($appointment_times[$key]);
                }
            }
        }

        // Output the available appointment times as table rows with radio buttons
        foreach($appointment_times as $time) {
            echo "<tr>";
            echo "<td>$time</td>";
            echo "<td><input type='radio' name='appointment_time' value='$time'></td>";
            echo "</tr>";
        }
    } else {
        // If it's Saturday, return an empty response
        echo "<tr><td colspan='2'>No appointments available on Saturday.</td></tr>";
    }
} else {
    // If date parameter is not set, return an empty response
    echo "<tr><td colspan='2'>Please select a date.</td></tr>";
}
?>
