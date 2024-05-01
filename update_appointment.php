<!DOCTYPE html>
<html>
<head>
    <title>Update Appointment</title>
    <style>
        body {
            text-align: center;
            font-family: Arial, sans-serif;
        }
        
        form {
            margin: auto;
            width: 450px;
            padding: 20px;
            border: 1px solid black;
            background-color: white;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="phone"],
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }
        
        .error {
            color: red;
            font-size: 12px;
            text-align: left;
        }
        
        .button-container {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 20px;
        }
        
        .button-container button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            color: white;
        }
        
        .btn-1 {
            background-color: #007bff;
        }
        
        .btn-2 {
            background-color: green;
        }
        
        .btn-3 {
            background-color: black;
        }
    </style>
</head>
<body>
    <h1>Update Appointment</h1>
    <?php
    session_start();
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        header("Location: login.php");
        exit;
    }

    include "connection.php";

    if (isset($_GET['id'])) {
        $appointment_id = $_GET['id'];
        $sql = "SELECT * FROM appointments WHERE id = '$appointment_id'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $appointment = mysqli_fetch_assoc($result);
            ?>
            <form action="update.php" method="POST">
                <input type="hidden" name="appointment_id" value="<?php echo $appointment['id']; ?>">
                
                <div>
                    Name: <input type="text" name="patient_name" value="<?php echo htmlspecialchars($appointment['patient_name']); ?>">
                </div>
    
                <div>
                    Email: <input type="email" name="email" value="<?php echo htmlspecialchars($appointment['email']); ?>">
                </div>
    
                <div>
                    Phone: <input type="text" name="phone" value="<?php echo htmlspecialchars($appointment['phone']); ?>">
                </div>
    
                <div>
                    Address: <input type="text" name="address" value="<?php echo htmlspecialchars($appointment['address']); ?>">
                </div>
    
                <div>
                    Gender:
                    <input type="radio" name="gender" value="Male" <?php echo ($appointment['gender'] === 'Male') ? 'checked' : ''; ?>>Male
                    <input type="radio" name="gender" value="Female" <?php echo ($appointment['gender'] === 'Female') ? 'checked' : ''; ?>>Female
                </div>
    
                <div>
                    <label>Select Speciality:</label>
                    <select name="speciality">
                        <?php
                        $sql_specialities = "SELECT DISTINCT speciality FROM users WHERE confirmed = 1 AND role = 'doctor'";
                        $result_specialities = mysqli_query($conn, $sql_specialities);
    
                        if ($result_specialities && mysqli_num_rows($result_specialities) > 0) {
                            while ($row = mysqli_fetch_assoc($result_specialities)) {
                                $selected = ($appointment['speciality'] === $row['speciality']) ? 'selected' : '';
                                echo "<option value='" . $row['speciality'] . "' $selected>" . $row['speciality'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
    
                <div>
                    <label>Select Doctor:</label>
                    <select name="doctor">
                        <?php
                        $selected_speciality = $appointment['speciality'];
                        $sql_doctors = "SELECT * FROM users WHERE confirmed = 1 AND role = 'doctor' AND speciality = '$selected_speciality'";
                        $result_doctors = mysqli_query($conn, $sql_doctors);
    
                        if ($result_doctors && mysqli_num_rows($result_doctors) > 0) {
                            while ($row = mysqli_fetch_assoc($result_doctors)) {
                                $selected = ($appointment['doctor'] === $row['username']) ? 'selected' : '';
                                echo "<option value='" . $row['username'] . "' $selected>" . $row['username'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
    
                <div>
                    
                    Select Appointment Date: <input type="date" name="appointment_date" value="<?php echo $appointment['appointment_date']; ?>">
                </div>
    
                <div>
                    Booking Time:
                    <select name="appointment_time">
                        <?php
                        $appointment_times = array("08:00", "08:15", "08:30", "08:45", "09:00", "09:15", "09:30", "09:45", "10:00", "10:15", "10:30", "10:45", "11:00", "11:15", "11:30", "11:45", "12:00", "12:15", "12:30", "12:45", "13:00", "13:15", "13:30", "13:45", "14:00", "14:15", "14:30", "14:45", "15:00", "15:15", "15:30", "15:45", "16:00", "16:15", "16:30", "16:45", "17:00");
    
                        foreach ($appointment_times as $time) {
                            $selected = ($appointment['appointment_time'] === $time) ? 'selected' : '';
                            echo "<option value='$time' $selected>$time</option>";
                        }
                        ?>
                    </select>
                </div>
    
                <input type="submit" value="Update Appointment">
            </form>
            <?php
        } else {
            echo "Appointment not found";
        }
    } else {
        echo "Invalid request";
    }
    ?>
</body>
</html>
