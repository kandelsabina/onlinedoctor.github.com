
<?php
session_start();
 if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
include "header.php";

include"connection.php";
$did= $_SESSION['did'];
?>
<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <br><br>

    <h2>Search Appointments</h2>
    <input type="text" id="searchInput" placeholder="Search by Patient Name">
    <div id="searchResult"></div>

    <script>
        $(document).ready(function(){
            $('#searchInput').keyup(function(){
                var query = $(this).val();
                if(query.length > 0){
                    $.ajax({
                        url: 'searchconfirmedapp.php',
                        method: 'POST',
                        data: {query: query},
                        success: function(data){
                             $('#confirmedAppointmentsTable').hide();
                             $('#hi').hide();

                            $('#searchResult').html(data);
                        }
                    });
                } else {
                    $('#searchResult').html('');
                     $('#confirmedAppointmentsTable').show();
                             $('#hi').show();
                }
            });
        });
    </script>   
</body>
</html>
<?php
$sql = "SELECT * FROM appointments WHERE confirmed = 1 AND doctor= $did";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  
    
    echo "<h2 id= 'hi'>Confirmed Appointments</h2>";
    echo "<table border='1' id='confirmedAppointmentsTable' style='border-collapse:collapse;'>";
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
        echo "<td><a href='deleteconfirmedappbydoctor.php?id=" . $row["id"] . "'>Delete</a></td>";
        echo "</tr>";
    }

    echo "</table>";
} 
else {
    echo "No confirmed appointments.";
}

$conn->close();
?>
