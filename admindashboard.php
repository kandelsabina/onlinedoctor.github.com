<?php
    include "connection.php";
    session_start();
       if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: lightgrey;
}

.container {
    display: grid;
    
}


.sidebar {
    width: 250px;
    background-color: black;
    padding-top: 20px;
}

.sidebar h2 {
    color: #fff;
    text-align: center;
}

.sidebar ul {
    list-style-type: none;
    padding: 0;
}

.sidebar ul li {
    padding: 10px;
}

.sidebar ul li a {
    display: block;
    color: #fff;
    text-decoration: none;
    padding: 10px 20px;
}

.sidebar ul li a:hover {
    background-color: #555;
}

.sidebar ul li a.active {
    background-color: #4CAF50;
}

.content{
    text-align: center;
}
.main{
    display:flex;

}

.content {
   
    margin-top: 40px;   
}

.button-container {
      display: flex;
    flex-wrap: wrap; 
        justify-content: center; 
    gap: 10px;
}

.btn {
    padding: 50px 80px; 
    margin: 0 10px;    
    border: none;       
    border-radius: 5px;
    background-color: blue; 
    color: white;      
    font-size: 16px;    
    cursor: pointer;   
    transition: background-color 0.3s ease; 
}

.btn:hover {
    background-color: darkblue; 
}



    </style>
</head>
<body>
    <?php include "header.php"; ?>
    <div class="main">
    <div class="sidebar">
        <h2>Admin Panel</h2>
        <ul>
            <li><a href="adddoctor.php" class="active">Add Doctor</a></li>
            <li><a href="addpatientbyadmin.php">Add Patient</a></li>
            <li><a href="displaypatient.php">Display Patients</a></li>
            <li><a href="displaydoctor.php">Display Doctors</a></li>
            <li><a href="confirmdoctor.php">Doctor Request</a></li>
            <li><a href="displayappbyadmin.php">Display appointments</a></li>
                <li><a href="viewpayment.php">View Payment</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <br><br>
        <div class="button-container">
            <br><br>
            <button class="btn"><?php 
                $sql= "SELECT Count(*) AS Acount FROM appointments ";
                $result= mysqli_query($conn, $sql);
                $row= mysqli_fetch_assoc($result);
                echo $row['Acount'];
             ?><br>Total Appointments</button>
            <button class="btn">
            <?php 
                $sql= "SELECT Count(*) AS Acount FROM users WHERE role= 'patient' ";
                $result= mysqli_query($conn, $sql);
                $row= mysqli_fetch_assoc($result);
                echo $row['Acount'];
             ?><br>Total Patients</button>
            <button class="btn">
            <?php 
                $sql= "SELECT Count(*) AS Acount FROM users WHERE confirmed=1 AND role='doctor'";
                $result= mysqli_query($conn, $sql);
                $row= mysqli_fetch_assoc($result);
                echo $row['Acount'];
             ?><br>Total Confirmed Doctors</button>
            <button class="btn"> <?php 
                $sql= "SELECT Count(*) AS Acount FROM users WHERE confirmed=0 AND role= 'doctor'";
                $result= mysqli_query($conn, $sql);
                $row= mysqli_fetch_assoc($result);
                echo $row['Acount'];
             ?><br>Total Unconfirmed Doctors</button>
              <button class="btn"> <?php 
                $sql= "SELECT Count(*) AS Acount FROM payments";
                $result= mysqli_query($conn, $sql);
                $row= mysqli_fetch_assoc($result);
                echo $row['Acount'];
             ?><br>Total Payments</button>
        </div>
    </div>
</div>

</body>
</html>
