<?php
session_start();
 if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
 include"connection.php";
 include"header.php";
  $err_uname= $err_pass= $err_email=$err_speciality=$err_qualification="";

    if($_SERVER["REQUEST_METHOD"]=="POST"){

    if(empty(trim($_POST["username"]))){
      $err_uname= "Username can't be empty";
    }
    else{
      $username= test_input($_POST["username"]);

    }
     if(empty(trim($_POST["password"]))){
      $err_pass= "Password can't be empty";
    }
    else{
      $password= test_input($_POST["password"]);

    }
     if(empty(trim($_POST["email"]))){
      $err_email= "Email can't be empty";
    }
    else{
      $email= test_input($_POST["email"]);
      if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $err_email= "Enter a valid email";
      }

    }
    if(empty(trim($_POST["qualification"]))){
      $err_qualification= "qualification can't be empty";
    }
    else{
      $qualification= test_input($_POST["qualification"]);

    }
    if(empty(trim($_POST["speciality"]))){
      $err_speciality= "speciality can't be empty";
    }
    else{
      $speciality= test_input($_POST["speciality"]);

    }

    if (empty($err_uname) && empty($err_pass) && empty($err_email) && empty($err_speciality) && empty($err_qualification)) {
       

        $sql = "INSERT INTO users (username, password, email, role,  speciality, qualification, confirmed)
                VALUES ('$username', '$password', '$email', 'doctor', '$speciality', '$qualification', 1)";


        if (mysqli_query($conn, $sql) === TRUE) {
            echo "Doctor added successfully.";
            header('location:displaydoctor.php');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
    } 
    }

  function test_input($data){
      $data= stripslashes($data);
      $data= htmlspecialchars($data);
      return $data;
    }
?>
<html>
<head>
  <style>
    .contain{
      text-align: center;
    }
    .contain form{
      border: 1px solid black;
      background-color: lightblue;
      width:400px;
      margin:auto;
    }
  </style>
</head>
<div class= "contain">
<h1>Hi!! Admin you can add doctors here</h1>
<form method= "POST" action="">
  Username:  <input type= "text" name= "username">
   <div>
      <?php
      if(!empty($err_uname)){
        echo $err_uname;
      } 
      ?>
    </div><br><br>
   Email: <input type="text" name= "email">
    <div>
      <?php
      if(!empty($err_email)){
        echo $err_email;
      } 
      ?>
    </div><br><br>
    Password:<input type="password" name= "password">
     <div>
      <?php
      if(!empty($err_pass)){
        echo $err_pass;
      } 
      ?>
    </div><br><br>
  Speciality: <input type="text" name= "speciality">
   <div>
      <?php
      if(!empty($err_speciality)){
        echo $err_speciality;
      } 
      ?>
    </div><br><br>
   Qualification: <input type= "text" name= "qualification"> <div>
      <?php
      if(!empty($err_qualification)){
        echo $err_qualification;
      } 
      ?>
    </div><br><br>
        <input type="submit" value= "Add">
</form>
</div>
</html>