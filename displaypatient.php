<html>
<head>
<style>
    .patient-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

.patient-table th,
.patient-table td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

.patient-table th {
    background-color: #f2f2f2;
}

.patient-table tr:nth-child(even) {
    background-color: #f2f2f2;
}

.patient-table tr:hover {
    background-color: #ddd;
}

.update-btn,
.delete-btn {
    text-decoration: none;
    padding: 5px 10px;
    border-radius: 3px;
}

.update-btn {
    background-color: #4CAF50;
    color: white;
}

.delete-btn {
    background-color: #f44336;
    color: white;
}

</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
    <h2>Search Patients</h2>
    <input type="text" id="searchInput" placeholder="Search by Patient Name">
    <div id="searchResult"></div>

    <script>
        $(document).ready(function(){
            $('#searchInput').keyup(function(){
                var query = $(this).val();
                if(query.length > 0){
                    $.ajax({
                        url: 'search.php',
                        method: 'POST',
                        data: {query: query},
                        success: function(data){
                              $('#tables').hide();
                            $('#searchResult').html(data);
                        }
                    });
                } else {
                    $('#searchResult').html('');
                     $('#tables').show();
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
include"connection.php";
$sql = "SELECT id, username, email, password FROM users WHERE role= 'patient'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    echo "<table  id='tables' class='patient-table'>";
    echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Password</th><th>Actions</th></tr>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["username"] . "</td>";
        echo "<td>" . $row["email"] . "</td>";
        echo "<td>" . $row["password"] . "</td>";
        echo "<td> <a href='deletepatient.php?id=" . $row["id"] . "' class='delete-btn'>Delete</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
mysqli_close($conn);
?>
