<?php
include "connection.php";
session_start();
 if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

if(isset($_POST['query'])){
    $search = mysqli_real_escape_string($conn, $_POST['query']);
    $sql = "SELECT * FROM users WHERE username LIKE '%$search%' AND role= 'patient'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
              echo "<table class='patient-table'>";
            echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Password</th><th>Actions</th></tr>";
            while($row = mysqli_fetch_assoc($result)) {
               echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["username"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["password"] . "</td>";
        echo "<td> <a href='deletepatient.php?id=" . $row["id"] . "' class='delete-btn'>Delete</a></td>";
        echo "</tr>";
    }
    echo "</table>";
            }
           
         else {
            echo "No patients found";
        }
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}


mysqli_close($conn);
?>
