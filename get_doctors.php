<?php
include "connection.php";
session_start();

// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

// Check if 'speciality' parameter is set in GET request
if (isset($_GET['speciality'])) {
    $speciality = $_GET['speciality'];

    // Escape the speciality parameter to prevent SQL injection (optional, since you're using mysqli_real_escape_string)
    $escaped_speciality = mysqli_real_escape_string($conn, $speciality);

    // Construct the SQL query
    $sql = "SELECT id, username FROM users WHERE speciality = '$escaped_speciality' AND confirmed = 1";
    
    // Execute the SQL query
    $result = mysqli_query($conn, $sql);

    if ($result) {
        // Check if any rows are returned
        if (mysqli_num_rows($result) > 0) {
            $options = "<option value=''>Select Doctor</option>";

            // Loop through query results and generate options for dropdown
            while ($row = mysqli_fetch_assoc($result)) {
                $options .= "<option value='" . $row['id'] . "'>" . $row['username'] . "</option>";
            }
        } else {
            // No doctors available for the selected speciality
            $options = "<option value=''>No doctors available for this speciality</option>";
        }
    } else {
        // Error occurred during query execution
        $options = "<option value=''>Error retrieving doctors</option>";
    }

    // Close the database connection
    mysqli_close($conn);

    // Output the dropdown options
    echo $options;
} else {
    // 'speciality' parameter is not set in GET request
    echo "<option value=''>Select Doctor</option>";
}
?>
