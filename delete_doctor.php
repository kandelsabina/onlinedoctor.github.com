<?php
session_start();
include"connection.php";
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM users WHERE id='$id'";

    if (mysqli_query($conn, $sql) === TRUE) {
        echo "Doctor deleted successfully";
        header('location: displaydoctor.php');
    } else {
        echo "Error deleting doctor: " . $conn->error;
    }
} else {
    echo "Invalid request";
}
?>
