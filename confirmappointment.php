<?php
session_start();
 if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
include "header.php";

include"connection.php";
$did= $_SESSION['did'];
$sql = "SELECT * FROM appointments WHERE confirmed = 0 AND doctor= $did";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  
    
    echo "<h2>Unconfirmed Appointments</h2>";
    echo "<table border='1' style='border-collapse:collapse;'>";
    echo "<tr><th>Patient_name</th><th>Email</th><th>Phone</th><th>Gender</th><th>Address</th><th>speciality</th><th>Doctor</th><th>Appointment Date</th><th>Appointment Time</th><th>Action</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
        $pemail= $row['email'];
        $_SESSION['pemail']= $pemail;

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
        echo "<td><a href='confirm_appointment.php?id=" . $row["id"] . "'>Confirm</a></td>";
        echo "</tr>";
    }

    echo "</table>";
} 
else {
    echo "No unconfirmed appointments.";
}


$conn->close();
?>
