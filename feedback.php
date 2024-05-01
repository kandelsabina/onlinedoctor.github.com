<?php
include "connection.php";

$sql = "SELECT *
        FROM feedbacks
        ORDER BY id DESC";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo '<h1>Feedbacks</h1>';
    if(mysqli_num_rows($result)>0){
    echo '<ul>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<li><strong>' . htmlspecialchars($row['username']) . '</strong>: ' . htmlspecialchars($row['feedback']) . '</li>';
    }
    echo '</ul>';
}
else {
    echo 'No feedbacks yet.';
}
} 

?>
<html>
<br><br>
<button ><a href="patientlogin.php"><h4>Give Feedback</h4></a></button>
</html>
