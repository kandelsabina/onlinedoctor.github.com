<?php
session_start();
 if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
include "header.php";

include"connection.php";
$sql = "SELECT * FROM users WHERE confirmed = 0 AND role= 'doctor'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    
    echo "<h2>Unconfirmed Doctors</h2>";
    echo "<table border='1' style='border-collapse:collapse;'>";
    echo "<tr><th>Username</th><th>Email</th><th>Speciality</th><th>Qualification</th><th>Action</th></tr>";

    while ($row = mysqli_fetch_assoc($result)) {
      $demail= $row['email'];
      $_SESSION['demail']= $demail;
        echo "<tr>";
        echo "<td>" . $row["username"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["speciality"] . "</td>";
        echo "<td>" . $row["qualification"] . "</td>";
        echo "<td><a href='confirm_doctor.php?id=" . $row["id"] . "'>Confirm</a></td>";
        echo "</tr>";
    }

    echo "</table>";
} 
else {
    echo "No unconfirmed doctors.";
}


$conn->close();
?>

