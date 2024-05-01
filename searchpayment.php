<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
include "connection.php";
if (isset($_POST['query'])) {
    $search = mysqli_real_escape_string($conn, $_POST['query']);
    $sql = "SELECT * FROM payments WHERE owner_name LIKE '%$search%'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            echo "<h1>Payments</h1>";
            echo "<table border='1' style='border-collapse: collapse;'>";
            echo "<tr>
                    <th>ID</th>
                    <th>Card Number</th>
                    <th>Expiry Date</th>
                    <th>Owner Name</th>
                    <th>Amount</th>
                    <th>Aid</th>
                  </tr>";

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>".$row["id"]."</td>
                        <td>".$row["card_number"]."</td>
                        <td>".$row["expiry_date"]."</td>
                        <td>".$row["owner_name"]."</td>
                        <td>".$row["amount"]."</td>
                        <td>".$row["aid"]."</td>
                      </tr>";
            }

            echo "</table>";
        } else {
            echo "No payment found";
        }
    } else {
        echo "Error: " . mysqli_error($conn); // Display error message
    }

    // Free result set
    mysqli_free_result($result);
}

// Close connection
mysqli_close($conn);
?>
