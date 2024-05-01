
<?php
include"header.php";
session_start();

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Invalid request";
    exit();
}

$app_id = $_GET['id'];
include "connection.php";
$sql = "UPDATE appointments SET confirmed = 1 WHERE id = $app_id";

if ($conn->query($sql) === TRUE) {
    echo "Appointment confirmed successfully.";
    $pemail= $_SESSION['pemail'];
$to = $pemail;

$subject = "Appointment confirmation";
$message = "Your appointment has been confirmed. Now You can go to payment";

// Set additional headers
$headers = "From: kandelsabina1111gmail.com";

// Send the email
if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully.";
} else {
    echo "Email sending failed.";
}


} else {
    echo "Error updating record: " . $conn->error;
}

// Close database connection
$conn->close();
?>
