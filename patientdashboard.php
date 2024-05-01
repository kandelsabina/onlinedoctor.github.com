<?php
session_start();
 if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
$pid = $_SESSION['pid'];
include "connection.php";
include "header.php";

$err_pname = $err_email = $err_phone = $err_address = $err_gender = $err_speciality = $err_doctor = $err_adate = $err_atime = "";
$gender = ""; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_name = $_POST["patient_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $gender = isset($_POST["gender"]) ? $_POST["gender"] : ""; // Assign value to $gender if set
    $speciality = $_POST["speciality"];
    $doctor = $_POST["doctor"];
    $appointment_date = $_POST["appointment_date"];
    $appointment_time = $_POST["appointment_time"];

    $dayOfWeek = date('N', strtotime($appointment_date));
    if($dayOfWeek = 6) { 
        $err_adate= "No appointments available for saturday";
    }

    if (empty(trim($patient_name)) || empty(trim($email)) || empty(trim($phone)) || empty(trim($address)) || empty(trim($gender)) || empty(trim($speciality)) || empty(trim($doctor)) || empty(trim($appointment_date)) || empty(trim($appointment_time))) {
        $err_pname = $err_email = $err_phone = $err_address = $err_gender = $err_speciality = $err_doctor = $err_adate = $err_atime = "Field is required";
    }

    if (!preg_match("/^[a-zA-Z][a-zA-Z0-9_]*$/", $patient_name)) {
        $err_pname = "Patient name should start with an alphabet and may contain digits, underscore, etc.";
    }

    if (strlen($phone) != 10) {
        $err_phone = "Phone number should be of 10 digits";
    }

    if (strtotime($appointment_date) < strtotime('today')) {
        $err_adate = "Appointment date should be a future date";
    }

    $sql = "SELECT appointment_date, appointment_time, doctor, speciality FROM appointments WHERE appointment_date = '$appointment_date' AND appointment_time = '$appointment_time' AND doctor = '$doctor' AND speciality = '$speciality'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $err_atime = "The selected time slot is already booked. Please choose another time or date.";
    }

    if (empty($err_pname) && empty($err_email) && empty($err_phone) && empty($err_address) && empty($err_gender) && empty($err_speciality) && empty($err_doctor) && empty($err_adate) && empty($err_atime)) {

        $sql = "INSERT INTO appointments (patient_name, email, phone, address, gender, speciality, doctor, appointment_date, appointment_time, confirmed, pid) 
                VALUES ('$patient_name', '$email', '$phone', '$address', '$gender', '$speciality', '$doctor', '$appointment_date', '$appointment_time', 0, $pid)";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully. Waiting for confirmation. After confirmation you can proceed to payment";
            header('location: viewapp.php');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Dashboard</title>
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
        .button-container{
            border:1px solid black;
            border-radius: 15px;
            background-color: lightblue;
        }
         .booked {
            background-color: yellow;
        }
    </style>
</head>
<body>
    <h1>Please fill the form to book an appointment</h1>
    <form action="" method="POST">
        <div>
            Name: <input type="text" name="patient_name" value="<?php echo isset($patient_name) ? htmlspecialchars($patient_name) : ''; ?>">
            <div class="error"><?php echo $err_pname; ?></div>
        </div>

        <div>
            Email: <input type="email" name="email" value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">
            <div class="error"><?php echo $err_email; ?></div>
        </div>

        <div>
            Phone: <input type="text" name="phone" value="<?php echo isset($phone) ? htmlspecialchars($phone) : ''; ?>">
            <div class="error"><?php echo $err_phone; ?></div>
        </div>

        <div>
            Address: <input type="text" name="address" value="<?php echo isset($address) ? htmlspecialchars($address) : ''; ?>">
            <div class="error"><?php echo $err_address; ?></div>
        </div>

        <div>
            Gender:
            <input type="radio" name="gender" value="Male" <?php echo ($gender === 'Male') ? 'checked' : ''; ?>>Male
            <input type="radio" name="gender" value="Female" <?php echo ($gender === 'Female') ? 'checked' : ''; ?>>Female
            <div class="error"><?php echo $err_gender; ?></div>
        </div>

        <div>
            <label>Select Speciality:</label>
            <select name="speciality" id="speciality_select" onchange="getDoctors()">
                <option value="">Select Speciality</option>
                <?php
                $sql = "SELECT DISTINCT speciality FROM users WHERE confirmed = 1 AND role= 'doctor'";
                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $selected = ($speciality === $row['speciality']) ? 'selected' : '';
                        echo "<option value='" . $row['speciality'] . "' $selected>" . $row['speciality'] . "</option>";
                    }
                }
                ?>
            </select>
            <div class="error"><?php echo $err_speciality; ?></div>
        </div>

        <div>
            <label>Select Doctor:</label>
            <select id="doctor_select" name="doctor">
                <option value="">Select Doctor</option>
            </select>
            <div class="error"><?php echo $err_doctor; ?></div>
        </div>

        <div>
            Select Appointment Date: <input type="date" name="appointment_date" value="<?php echo isset($appointment_date) ? htmlspecialchars($appointment_date) : ''; ?>">
            <div class="error"><?php echo $err_adate; ?></div>
        </div>

        
        <div>
            Booking Time:
            <select name="appointment_time">
                <option value="">Select Time</option>
                <?php
                $appointment_times = array("08:00", "08:15", "08:30", "08:45", "09:00", "09:15", "09:30", "09:45", "10:00", "10:15", "10:30", "10:45", "11:00", "11:15", "11:30", "11:45", "12:00", "12:15", "12:30", "12:45", "13:00", "13:15", "13:30", "13:45", "14:00", "14:15", "14:30", "14:45", "15:00", "15:15", "15:30", "15:45", "16:00", "16:15", "16:30", "16:45", "17:00");

                foreach ($appointment_times as $time) {
                    $sql_check_time = "SELECT COUNT(*) AS count FROM appointments WHERE appointment_date = '$appointment_date' AND appointment_time = '$time' AND doctor = '$doctor' AND speciality = '$speciality'";
                    $result_check_time = mysqli_query($conn, $sql_check_time);
                    $row_check_time = mysqli_fetch_assoc($result_check_time);

                    $is_booked = ($row_check_time['count'] > 0) ? true : false;
                    $option_class = ($is_booked) ? 'class="booked"' : '';
                    echo "<option value='$time' $option_class>$time</option>";
                }
                ?>
            </select>
            <div class="error"><?php echo $err_atime; ?></div>
        </div>

        <input type="submit" value="Book Appointment">
    </form>
    <div class="button-container">
        <button class="btn-1"><a href="viewapp.php">View Appointment</a></button>
        <button class="btn-2"><a href="givefeedback.php">Give Feedback</a></button>
        <button class="btn-3"><a href="logout.php">Logout</a></button>
    </div>

    <script>
        function getDoctors() {
            var speciality = document.getElementById("speciality_select").value;
            var doctorSelect = document.getElementById("doctor_select");
            doctorSelect.innerHTML = '<option value="">Select Doctor</option>';

            if (speciality) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        doctorSelect.innerHTML = xhr.responseText;
                    }
                };
                xhr.open("GET", "get_doctors.php?speciality=" + speciality, true);
                xhr.send();
            }
        }
    </script>
</body>
</html>
