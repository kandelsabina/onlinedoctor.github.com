<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

include "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['appointment_id'])) {
    $appointment_id = $_POST['appointment_id'];

    // Process form submission
    $patient_name = $_POST["patient_name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $gender = isset($_POST["gender"]) ? $_POST["gender"] : "";
    $speciality = $_POST["speciality"];
    $doctor = $_POST["doctor"];
    $appointment_date = $_POST["appointment_date"];
    $appointment_time = $_POST["appointment_time"];
      $dayOfWeek = date('N', strtotime($appointment_date));
    if($dayOfWeek == 6) { 
        echo "No appointment available for saturday";
        exit;
        
    }
        

    // Update the appointment record
    $update_sql = "UPDATE appointments SET 
                   patient_name = '$patient_name',
                   email = '$email',
                   phone = '$phone',
                   address = '$address',
                   gender = '$gender',
                   speciality = '$speciality',
                   doctor = '$doctor',
                   appointment_date = '$appointment_date',
                   appointment_time = '$appointment_time'
                   WHERE id = '$appointment_id'";

    if (mysqli_query($conn, $update_sql)) {
        echo "Appointment updated successfully";
        header('Location: viewapp.php');
        exit;
    } else {
        echo "Error updating appointment: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request";
}
?>
