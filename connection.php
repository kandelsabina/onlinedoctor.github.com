<?php
$host= "localhost";
$username="root";
$password= "";
$database= "odabs";
$conn= mysqli_connect($host, $username, $password, $database);
if($conn){

}
else{
	echo"Not connected";
}
?>