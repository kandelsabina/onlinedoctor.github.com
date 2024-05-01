<html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
     <h2>Search Doctors</h2>
    <input type="text" id="searchInput" placeholder="Search by Doctor Name">
    <div id="searchResult"></div>

    <script>
        $(document).ready(function(){
            $('#searchInput').keyup(function(){
                var query = $(this).val();
                if(query.length > 0){
                    $.ajax({
                        url: 'searchdoctor.php',
                        method: 'POST',
                        data: {query: query},
                        success: function(data){
                             $('#tables').hide();
                              $('#hi').hide(data);
                            $('#searchResult').html(data);
                        }
                    });
                } else {
                    $('#searchResult').html('');
                    $('#tables').show();
                              $('#hi').show(data);
                }
            });
        });
    </script>   
</body>
</html>
<?php
session_start();
 if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
include "connection.php";
$sql = "SELECT id, username, email, speciality, qualification, confirmed FROM users WHERE role='doctor'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<div >";
    echo "<h1 id= 'hi'>Doctors</h1>";
    echo "<table border='1' id='tables' style= 'border-collapse: collapse; text-align:center';>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Speciality</th>
                <th>Qualification</th>
                <th>Confirmed</th>
                <th>Operations</th>
            </tr>";


    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>".$row["id"]."</td>
                <td>".$row["username"]."</td>
                <td>".$row["email"]."</td>
                <td>".$row["speciality"]."</td>
                <td>".$row["qualification"]."</td>
                <td>".$row["confirmed"]."</td>
                <td>
                    <a href='update_doctor.php?id=".$row["id"]."'>Update</a> | 
                    <a href='delete_doctor.php?id=".$row["id"]."'>Delete</a>
                </td>
              </tr>";
    }
    echo "</table>";
    echo "</div>";
} else {
    echo "0 results";
}

?>
