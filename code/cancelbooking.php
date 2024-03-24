<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Booking Form</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('https://www.hoteltheroyalplaza.com/images/room_banner_1.jpg'); /* Replace with the actual image URL */
            background-size: cover;
            background-position: center;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px; /* Adjust the width as needed */
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #e74c3c;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #c0392b;
        }

        p {
            margin: 10px 0;
            color: #555;
        }
    </style>
</head>
<body>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <label for="cust_id">Customer ID:</label>
    <input type="text" id="cust_id" name="cust_id" required><br>

    <label for="booking_id">Booking ID to Cancel:</label>
    <input type="number" id="booking_id" name="booking_id" required><br>

    <input type="submit" name="cancel_booking" value="Cancel Booking">
</form>

<?php
// Include your database connection
$servername = "localhost";
$username = "root";
$password = "qwer4321";
$database = "hotelmanage"; // Replace with your actual database name

$conn = mysqli_connect($servername, $username, $password, $database);
if (!$conn) {
    die("Sorry, failed to connect: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cancel_booking"])) {
    // Include your cancel_booking function code here
    $cust_id = $_POST["cust_id"];
    $booking_id = $_POST["booking_id"];

    $cursor = $conn->prepare("SELECT Booking.Booking_ID, Booking.CheckInDate, Payment.Amount
    FROM Booking
    LEFT JOIN Payment ON Booking.Cust_ID = Payment.Cust_ID
    WHERE Booking.Booking_ID = ? AND Booking.Cust_ID = ?");
    $cursor->bind_param("ii", $booking_id, $cust_id);
    $cursor->execute();
    $cursor->store_result();
    $cursor->bind_result($booking_id, $check_in_date, $payment_amount);
    $cursor->fetch();

    if ($cursor->num_rows == 0) {
        $cursor->close();
        echo "<p>Booking not found or does not belong to the customer.</p>";
    } else {
        $refund_percentage = 0.75;
        $refund_amount = floatval($payment_amount) * $refund_percentage;

        if ($refund_amount > 0) {
            echo "<p>Rs. " . number_format($refund_amount, 2) . " has been refunded to your account.</p>";
        }

        // Delete the booking
        $delete_query = "DELETE FROM Booking WHERE Booking.Booking_ID = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param("i", $booking_id);
        $stmt->execute();
        $stmt->close();
        echo "<br>";

        echo "<p>Booking with Booking ID $booking_id canceled. Refund amount: Rs. " . number_format($refund_amount, 2) . ".</p>";
    }

    $cursor->close();
}

mysqli_close($conn);
?>

</body>
</html>



