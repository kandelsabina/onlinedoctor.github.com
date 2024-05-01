  <?php
  include"header.php";
  ?>
  <?php
session_start();

include "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if ($user['role'] === 'admin') {
            $_SESSION['logged_in']= true;
            header("Location: admindashboard.php");
            exit();
        } elseif ($user['role'] === 'doctor') {
             $_SESSION['did'] = $user['id'];
                $_SESSION['logged_in'] = true;
            if ($user['confirmed'] == 0) {
                echo "<p>Your account has not been approved yet. Please wait for admin approval.</p>";
            } else {
                 $_SESSION['logged_in']= true;
                header("Location: doctordashboard.php");
                exit();
            }
        } elseif ($user['role'] === 'patient') {
            $_SESSION['pid'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['logged_in'] = true;
            header("Location: patientdashboard.php");
            exit();
        }
    } else {
        echo "<p>Invalid username or password.</p>";
    }
}
?>
  
    <!DOCTYPE html>
   <html>
   <head>
    <style>
      .contain {
    text-align: center; /* Center align the content horizontally */
    padding: 20px; /* Add padding around the container */
}

form {
    display: inline-block; /* Display the form as inline-block */
    text-align: left; /* Reset text alignment inside the form */
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    max-width: 400px; /* Limit the width of the form */
    width: 80%; /* Set the width to 80% of its container */
}

.mySlides {
    display: inline-block; /* Display slideshow images as inline-block */
    margin-top: 20px; /* Add margin at the top of each slide */
}

img {
    max-width: 100%; /* Ensure images don't exceed their container */
    height: auto; /* Maintain aspect ratio */
}

     
    
      </style>
      </head>
      <body>
<div class ="contain">

<h2>User Login</h2>
<form action="" method="post">
    <label for="username">Username:</label>
    <input type="text" id="username" name="username" required><br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>
    <button type="submit">Login</button><br>
    Don't have account?<a href= "register.php">Signup</a>
</form>


<div>
    <div class="container">
        <div class="slideshow-container">
            <div class="mySlides fade">
                <img src="doctor.jpg" style="width:30%; height: 400px; margin: auto; text-align: center;">
            </div>
            <div class="mySlides fade">
                <img src="appointment.png" style="width:30%; height: 400px; margin: auto; text-align: center;">
            </div>
            <div class="mySlides fade">
                <img src="finddoc.jpeg" style="width:30%;height: 400px; margin: auto; text-align: center;">
            </div>
        </div>
          <footer id="footer">
        <p>&copy; 2024 Online Doctor Appointment System. All rights reserved.</p>
        <P>Email: Hamrobooking@gmail.com</P>
        <p>Tel: 01 00000</p>
        <p>Mobile: +977 00000</p>
    </footer>
           <script>
        var slideIndex = 0;
        showSlides();

        function showSlides() {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            slideIndex++;
            if (slideIndex > slides.length) {slideIndex = 1}
            slides[slideIndex-1].style.display = "block";
            setTimeout(showSlides, 2000); 
        }
    </script>


</body>
</html>
             
        