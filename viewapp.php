<?php
session_start();
 if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
include "header.php";

include"connection.php";
$pid= $_SESSION['pid'];
$sql = "SELECT * FROM appointments WHERE  pid= $pid";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    
        
    echo "<h2>Your Appointments</h2>";
    echo "<table border='1' style='border-collapse:collapse;'>";
    echo "<tr><th>Patient_name</th><th>Email</th><th>Phone</th><th>Gender</th><th>Address</th><th>speciality</th><th>Doctor</th><th>Appointment Date</th><th>Appointment Time</th><th>Confirmed</th><th>Action</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["patient_name"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["phone"] . "</td>";
        echo "<td>" . $row["gender"] . "</td>";
        echo "<td>" . $row["address"] . "</td>";
        echo "<td>" . $row["speciality"] . "</td>";
        echo "<td>" . $row["doctor"] . "</td>";
        echo "<td>" . $row["appointment_date"] . "</td>";
        echo "<td>" . $row["appointment_time"] . "</td>";
         echo "<td>" . $row["confirmed"] . "</td>";
        echo "<td><button><a href='cancel_appointment.php?id=" . $row["id"] . "'>Cancel</a></button>
        <button> <a href='update_appointment.php?id=" . $row["id"] . "'>Update</a></button>
         <button>  <a href='payment.php?id=" . $row["id"] . "'>Pay</a></td></button>";
        echo "</tr>";
    }
    

    echo "</table>";
} 
else {
    echo "No appointments booked yet.";
}

$conn->close();
?>
