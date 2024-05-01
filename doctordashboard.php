<?php
   
    include "connection.php";
    session_start();
     if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
     $did= $_SESSION['did'];
   ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        
        .button-container {
            display: flex;
            justify-content: space-around;
            margin: 30px;
        }

        .btn-1, .btn-2 {
            padding: 10px 20px;
            font-size: 16px;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-1 {
            background-color: #007bff;
        }

        .btn-1:hover {
            background-color: #0056b3;
            height:200px;
        }

        .btn-2 {
            background-color: #28a745;
            height:200px;
        }

        .btn-2:hover {
            background-color: #1e7e34;
        }
   

    </style>

</head>
<body>
    <nav class="navbar">
        <h1>Doctor Dashboard</h1>
        <ul>
            <li><a href="viewappointmentbydoctor.php">View Confirmed Appointments</a></li>
            <li><a href="confirmappointment.php" > View unconfirm Appointments</a></li>
            <li><a href="logout.php" > Logout</a></li>
             
             

        </ul>
    </nav>

    <div class="button-container">
        <br><br>
        <button class="btn-1"><?php 
           $sql= "SELECT Count(*) AS appcount FROM appointments WHERE doctor= $did AND confirmed= 1";
           $result= mysqli_query($conn, $sql);
           $row= mysqli_fetch_assoc($result);
           echo $row['appcount'];

           
        ?><br><a href="viewappointmentbydoctor.php"> Confirmed Appointments</a></button>
                <button class="btn-2"><?php 
           $sql= "SELECT Count(*) AS appcount FROM appointments WHERE doctor= $did AND confirmed= 0";
           $result= mysqli_query($conn, $sql);
           $row= mysqli_fetch_assoc($result);
           echo $row['appcount'];

           
        ?><br><a href="confirmappointment.php"> Unconfirmed Appointments</a></button>
    </div>

    <script src="scripts.js"></script>
</body>
</html>
