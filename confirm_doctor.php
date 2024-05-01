<?php
include"header.php";
session_start();
 if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid request";
    exit();
}

// Get doctor ID
$doctor_id = $_GET['id'];
include "connection.php";
$sql = "UPDATE users SET confirmed = 1 WHERE id = $doctor_id";


if ($conn->query($sql) === TRUE) {
    echo "Doctor confirmed successfully.";
} else {
    echo "Error updating record: " . $conn->error;
}
$demail = $_SESSION['demail'];
$to = $demail;

$subject = "Doctor confirmation";
$message = "You are approved as a doctor. Now You can go to loginpage and manage the patients and appointments";
$headers = "From: kandelsabina1111@gmail.com";
if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully.";
} else {
    echo "Email sending failed.";
}
$conn->close();
?>
