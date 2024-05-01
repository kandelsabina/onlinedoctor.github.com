<?php
    session_start();
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
include "connection.php";
$username = $_SESSION['username'];
 $err_feedback="";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $feedback = $_POST['feedback'];
    if(empty(trim($feedback)))
    {
         $err_feedback= "Fields are required";
    }

   if( empty($err_feedback)){
    $sql = "INSERT INTO feedbacks (username, feedback) VALUES ('$username', '$feedback')";

    if (mysqli_query($conn, $sql)) {
        echo "Feedback submitted successfully!";
        header("location:feedback.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
else{
    echo $err_uname;

}
}


mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form</title>
</head>
<body>
    <h2>Provide Feedback</h2>
    <form action="" method="post">
        <label for="feedback">Feedback:</label><br>
        <textarea id="feedback" name="feedback" rows="4" ></textarea><br><br>
        <button type="submit">Submit Feedback</button>
    </form>
</body>
</html>
