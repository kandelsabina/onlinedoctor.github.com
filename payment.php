<?php
include "connection.php";
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

$id= $_GET['id'];
  $sql = "SELECT * FROM payments where aid= '$id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    echo "<table border='1px solid black'>
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
    echo"Your payment is completed";
    exit;
} else {
    echo "0 results";
}

$sql= "SELECT * from appointments where id= '$id' ";
$result= mysqli_query($conn, $sql);
if($row= mysqli_num_rows($result)>0){
    $res= mysqli_fetch_assoc($result);
}
if($res['confirmed']==1){

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $card_number = $_POST['card_number'];
    $expiry_date = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];
    $owner_name = $_POST['owner_name'];
    $amount = $_POST['amount'];

    $errors = [];
    if (!is_numeric($card_number) || strlen($card_number) !=15) {
        $errors[] = "Invalid card number";
    }
    if (!preg_match("/^(0[1-9]|1[0-2])\/[0-9]{4}$/", $expiry_date)) {
        $errors[] = "Invalid expiry date. Use MM/YYYY format";
    }
    if (!is_numeric($cvv) || strlen($cvv) !== 3) {
        $errors[] = "Invalid CVV";
    }
    if (empty($owner_name)) {
        $errors[] = "Owner name is required";
    }
    if (!is_numeric($amount) || $amount <= 0) {
        $errors[] = "Invalid amount";
    }
      if (strtotime($expiry_date) < strtotime('today')) {
        $errors[] = "Card expired";
    }

    if (empty($errors)) {
        
        $sql = "INSERT INTO payments (card_number, expiry_date, cvv, owner_name, amount, aid) VALUES ('$card_number', '$expiry_date', '$cvv', '$owner_name', '$amount', '$id')";

        if ($conn->query($sql) === TRUE) {
            $payment_id = $conn->insert_id; 

            echo "Payment successful!<br>";


           echo "<div style= 'text-align: center; border:1px solid black; background-color:lightpink; width: 300px; margin: auto;'>";
            echo "<h2>Bill Summary</h2>";
            echo "<p><strong>Payment ID:</strong> $payment_id</p>";
            echo "<p><strong>Card Number:</strong> $card_number</p>";
            echo "<p><strong>Expiry Date:</strong> $expiry_date</p>";
            echo "<p><strong>CVV:</strong> $cvv</p>";
            echo "<p><strong>Owner Name:</strong> $owner_name</p>";
            echo "<p><strong>Amount Paid:</strong> $amount</p>";
             echo "<p><strong>Appointment Id</strong> $id</p>";
              echo "</div>"; 
              echo "<br> <br>";


        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {

        foreach ($errors as $error) {
            echo "<p class='error'>$error</p>";
        }
    }
}
}
else{
    echo "Waiting for the appointment to be confirmed. You can pay only after doctor's confirmation";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form</title>
    <style>
        .form-container {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Payment Details</h2>
        <form method="post" action="">
            <input type="text" name="card_number" placeholder="Card Number" required>
            <input type="text" name="expiry_date" placeholder="Expiry Date (MM/YYYY)" required>
            <input type="text" name="cvv" placeholder="CVV" required>
            <input type="text" name="owner_name" placeholder="Owner Name" required>
  <?php
    // Assuming $conn is your database connection

    $sql = "SELECT speciality FROM appointments WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);

    $amount = '1500'; // Default value if no rows are found or if the specialty is not matched

    if(mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            switch($row['speciality']) {
                case 'dermatologist':
                    $amount = '4000'; 
                    break;
                case 'general surgeon':
                    $amount = '2000'; 
                    break;
                case 'physician':
                    $amount = '3000'; 
                    break;
                case 'dentist':
                    $amount = '500'; 
                    break;
            }
           
        }
    } 
?>

<input type="number" name="amount" placeholder="Amount" value="<?php echo  $amount; ?>" required>



            <button type="submit">Pay Now</button>
        </form>
    </div>
</body>
</html>
