<?php
session_start();
 if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
include"connection.php";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM appointments WHERE id='$id'";

    if (mysqli_query($conn, $sql) === TRUE) {
        echo "Appointment deleted successfully";
        header('location:displayappbyadmin.php');
    } else {
        echo "Error deleting appointment: " . $conn->error;
    }
} else {
    echo "Invalid request";
}
?>
