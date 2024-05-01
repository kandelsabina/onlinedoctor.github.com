<?php
session_start();
include"connection.php";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM appointments WHERE id='$id'";

    if (mysqli_query($conn, $sql) === TRUE) {
        echo "Appointment deleted successfully";
        header('location:viewappointmentbydoctor.php');
    } else {
        echo "Error deleting appointment: " . $conn->error;
    }
} else {
    echo "Invalid request";
}
?>
