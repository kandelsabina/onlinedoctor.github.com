<!DOCTYPE html>
<html>
<head>
    <title>Update Doctor</title>
    <style>
        form{
            text-align: center;
            border: 1px solid black;
            margin: auto;
            width:400px;
            background-color: lightblue;

        }
    </style>
</head>
<body>

<?php
    session_start();
     if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
include "connection.php";
include "header.php";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
?>
<p style="text-align: center;">HEY!! Admin now you can make changes here as your choice </p>
        <h2 style="text-align: center;">Update Doctor</h2>
        <form action="update_doctor.php" method="post">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
            <label for="username">Username:</label><br>
            <input type="text" id="username" name="username" value="<?php echo $row['username']; ?>"><br>
            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>"><br>
            <label for="speciality">Speciality:</label><br>
            <input type="text" id="speciality" name="speciality" value="<?php echo $row['speciality']; ?>"><br>
            <label for="qualification">Qualification:</label><br>
            <input type="text" id="qualification" name="qualification" value="<?php echo $row['qualification']; ?>"><br><br>
            <input type="submit" value="Update">
        </form>
<?php
    } else {
        echo "Doctor not found";
    }
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $speciality = $_POST['speciality'];
    $qualification = $_POST['qualification'];

    if (empty($username) || empty($email)) {
        echo "Username and email are required.";
    } else {
        $sql = "UPDATE users SET username='$username', email='$email', speciality='$speciality', qualification='$qualification' WHERE id='$id'";
        
        if (mysqli_query($conn, $sql) === TRUE) {
            echo "Doctor updated successfully";
            header('location:displaydoctor.php');
        } else {
            echo "Error updating doctor: " . $conn->error;
        }
    }
}

?>

</body>
</html>
