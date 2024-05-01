<html>
<head>
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
     <h2>Search Payments</h2>
    <input type="text" id="searchInput" placeholder="Search by Owner Name">
    <div id="searchResult"></div>

    <script>
        $(document).ready(function(){
            $('#searchInput').keyup(function(){
                var query = $(this).val();
                if(query.length > 0){
                    $.ajax({
                        url: 'searchpayment.php',
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
include "connection.php";
session_start();
 if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
  $sql = "SELECT * FROM payments ";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<h1 id= 'hi'>Payments</h1>";
    echo "<table border='1px solid black' id='tables' style='border-collapse:collapse;'>
            <tr>
                <th>ID</th>
                <th>Card_number</th>
                <th>expiry_date</th>
                <th>owner_name</th>
                <th>amount</th>
                <th>aid</th>
            </tr>";


    while($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>".$row["id"]."</td>
                <td>".$row["card_number"]."</td>
                <td>".$row["expiry_date"]."</td>
                <td>".$row["owner_name"]."</td>
                <td>".$row["amount"]."</td>
                 <td>".$row["aid"]."</td>
               
              </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
