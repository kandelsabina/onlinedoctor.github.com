<?php
session_start();
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
include "connection.php";
if(isset($_POST['query'])){
	 $search = mysqli_real_escape_string($conn, $_POST['query']);
	$sql= "SELECT * FROM users WHERE username LIKE '%$search%' AND role= 'doctor'";
	$result= mysqli_query($conn, $sql);
	if($result){
		if(mysqli_num_rows($result)>0){
			 echo "<table border='1' style= 'border-collapse: collapse; text-align:center';>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Speciality</th>
                <th>Qualification</th>
                <th>Operations</th>
            </tr>";
			while($row= mysqli_fetch_assoc($result))
			{
				  echo "<tr>
                <td>".$row["id"]."</td>
                <td>".$row["username"]."</td>
                <td>".$row["email"]."</td>
                <td>".$row["speciality"]."</td>
                <td>".$row["qualification"]."</td>
                <td>
                    <a href='update_doctor.php?id=".$row["id"]."'>Update</a> | 
                    <a href='delete_doctor.php?id=".$row["id"]."'>Delete</a>
                </td>
              </tr>";
    }
    echo "</table>";
    echo "</div>";
} else {
    echo "No doctor found";
}
			}
		}
	
?>