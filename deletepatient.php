<?php
session_start();
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
include"connection.php";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM users WHERE id='$id'";

    if (mysqli_query($conn, $sql) === TRUE) {
        echo "Patient deleted successfully";
        header('location: displaypatient.php');
    } else {
        echo "Error deleting patient: " . $conn->error;
    }
} else {
    echo "Invalid request";
}
?>