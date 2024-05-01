<?php
session_start();
 if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
include "header.php";
?>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
     <h2>Search Appointments</h2>
    <input type="text" id="searchInput" placeholder="Search by Patient Name">
    <div id="searchResult"></div>

    <script>
        $(document).ready(function(){
            $('#searchInput').keyup(function(){
                var query = $(this).val();
                if(query.length > 0){
                    $.ajax({
                        url: 'searchappointmentbyadmin.php',
                        method: 'POST',
                        data: {query: query},
                        success: function(data){
                             $('#tables').hide();
                              $('#hi').hide(data);
                            $('#searchResult').html(data);
                        }
                    });
                } else {
                    $('#searchResult').html('');
                    $('#tables').show();
                              $('#hi').show(data);
                }
            });
        });
    </script>   
<?php

include"connection.php";
$sql = "SELECT * FROM appointments";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  
    
    echo "<h2 id= 'hi'>Appointments</h2>";
    echo "<table border='1' id='tables' style='border-collapse:collapse;'>";
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
        echo "<td><a href='deleteappbyadmin.php?id=" . $row["id"] . "'>Delete</a></td>";
        echo "</tr>";
    }

    echo "</table>";
} 
else {
    echo "No confirmed appointments.";
}

$conn->close();
?>
