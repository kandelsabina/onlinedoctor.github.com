<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Signup</title>
    <style>
        form {
            border: 1px solid black;
            text-align: center;
            margin: auto;
            width: 300px;
            padding: 20px;
            margin-top: 20px;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>

<?php
session_start();
include "connection.php"; // Assuming this file contains database connection code
include "header.php"; // Assuming this file contains the header HTML or PHP code

// Initialize variables
$username = '';
$password = '';
$email = '';
$speciality = '';

// Process form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Validate username (must start with a letter)
    if (!preg_match('/^[a-zA-Z][a-zA-Z0-9_]*$/', $username)) {
        echo "<p>Username must start with a letter and contain only letters, numbers, or underscores.</p>";
    } else {
        // Check if email is already registered
        $query = "SELECT * FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            echo "<p>Email is already registered. Please use a different email.</p>";
        } else {
            // Determine role-specific fields
            if ($role === 'patient') {
                // Insert new patient into the database
                $query = "INSERT INTO users (username, password, email, role) VALUES ('$username', '$password', '$email', '$role')";
            } elseif ($role === 'doctor') {
                $speciality = $_POST['speciality'];
                $qualification = $_POST['qualification'];
                $confirmed = 0; // Doctor needs approval
                // Insert new doctor into the database with confirmed = 0 (pending approval)
                $query = "INSERT INTO users (username, password, email, role, speciality, qualification, confirmed) VALUES ('$username', '$password', '$email', '$role', '$speciality', '$qualification', $confirmed)";
            }

            if (mysqli_query($conn, $query)) {
                echo "<p>Registration successful. Please <a href='login.php'>login</a>.</p>";
            } else {
                echo "<p>Registration failed. Please try again.</p>";
            }
        }
    }
}
?>

<h2>User Signup</h2>
<form action="" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username"  value="<?php echo htmlspecialchars($username); ?>" required><br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password"  value="<?php echo htmlspecialchars($password); ?>" required><br><br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br><br>
    <label for="role">Role:</label>
    <select id="role" name="role" required>
        <option value="patient">Patient</option>
        <option value="doctor">Doctor</option>
    </select><br><br>

    <!-- Additional fields for doctors -->
    <div id="doctorFields" style="display: none;">
        <label for="speciality">Speciality:</label>
        <input type="text" id="speciality" name="speciality" value="<?php echo htmlspecialchars($speciality); ?>" required><br><br>
        <label for="qualification">Qualification:</label>
        <input type="text" id="qualification" name="qualification"><br><br>
    </div>

    <!-- JavaScript to show/hide doctor fields based on role selection -->
    <script>
        document.getElementById('role').addEventListener('change', function() {
            var doctorFields = document.getElementById('doctorFields');
            if (this.value === 'doctor') {
                doctorFields.style.display = 'block';
            } else {
                doctorFields.style.display = 'none';
            }
        });
    </script>

    <button type="submit">Register</button>
</form>

</body>
</html>
