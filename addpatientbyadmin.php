 <?php
  include"header.php";
   include "connection.php";
   session_start();
     if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

     $err_uname= $err_pass= $err_email="";
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
   if(empty($err_uname)&& empty($err_pass) && empty($err_uname)){
   	$sq= "SELECT * FROM users WHERE email= '$email' ";
    $result= mysqli_query($conn, $sq);
    $row= mysqli_num_rows($result);
    if($row>0){
    echo "user already exists";
     header('location:addpatientbyadmin.php');
     exit();	
    }
    else{

    	 $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql= "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$hashedPassword', 'patient')";
    
    $result= mysqli_query($conn, $sql);
    if($result){

      header('location: displaypatient.php');
      echo "<script> alert('Patient added successfully'); </script>";
      exit();
    }
    else{
      echo "<script> alert('not completed'); </script>";
    }
}
  }
}
    function test_input($data){
      $data= stripslashes($data);
      $data= htmlspecialchars($data);
      return $data;
    }
   ?>
<!DOCTYPE html>
<html>
<head>
	<title>Patient signup</title>
	<style>
		 .plogin{
    text-align: center;
  }
       .plogin form{
    border:1px solid black;
    margin:auto;
    width: 400px;
    background-color: lightblue;
  }

	</style>
</head>
<body>
	<div class= "plogin">
	<h1>Add Patient Here</h1>
	<form action="" method="POST">
		<label>Username</label><br>
		<input type="text" name= "username"><div>
		 <?php
      if(!empty($err_uname)){
        echo $err_uname;
      } 
      ?> </div><br><br>
		<label>Email</label><br>
		<input type="text" name= "email">  <div>
      <?php
      if(!empty($err_email)){
        echo $err_email;
      } 
      ?>
    </div>
		<br><br>
		<label>Password</label><br>
		<input type="password" name= "password">
		 <div>
      <?php
      if(!empty($err_pass)){
        echo $err_pass;
      } 
      ?>
    </div><br><br>
		<input type="submit" name= "submit" value= "Add"><br><br>

</form>
</div>
</body>
</html>