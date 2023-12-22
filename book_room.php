<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Booking Form</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('https://thumbs.dreamstime.com/b/hotel-bed-room-21064950.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        form {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
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
            background-color: #3498db;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .result-box {
            background-color: #f0f0f0;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin-top: 20px;
            text-align: center;
        }

        p {
            margin: 10px 0;
            color: #555;
            font-weight: bold;
        }

        .form-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="form-title">Room Booking</div>

    <label for="cust_id">Customer ID:</label>
    <input type="text" id="cust_id" name="cust_id" required>

    <label for="days">Number of Nights:</label>
    <input type="number" id="days" name="days" required>

    <label for="check_in">Check-in Date:</label>
    <input type="date" id="check_in" name="check_in" required>

    <label for="check_out">Check-out Date:</label>
    <input type="date" id="check_out" name="check_out" required>

    <label for="room_no">Select Room:</label>
    <select id="room_no" name="room_no" required>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "qwer4321";
        $database = "hotelmanage";

        $conn = mysqli_connect($servername, $username, $password, $database);

        if (!$conn) {
            die("Sorry, failed to connect: " . mysqli_connect_error());
        }

        $query = "SELECT Room_No, Type, Price FROM room JOIN roomtype ON room.Room_Type_ID = roomtype.Room_Type_ID";
        $result = mysqli_query($conn, $query);

        while ($record = mysqli_fetch_assoc($result)) {
            $room_no = $record["Room_No"];
            $room_type = $record["Type"];
            $price = intval($record["Price"]);
            echo "<option value='$room_no'>$room_type - Rs.$price (Room $room_no)</option>";
        }
        ?>
    </select>

    <input type="submit" value="Book Room">
</form>

<?php
// Your PHP logic for handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cust_id = $_POST["cust_id"];
    $days = $_POST["days"];
    $check_in = $_POST["check_in"];
    $check_out = $_POST["check_out"];
    $room_no = $_POST["room_no"];

    // Book the room
    $result = bookRoom($conn, $cust_id, $room_no, $check_in, $check_out);

    // Display the result in a separate box
    echo '<div class="result-box">';
    echo "<p>$result</p>";

    if ($result == "Booking successful.") {
        $payment_amount = getPaymentAmount($conn, $room_no, $days);
        $payment_date = $check_out;
        addPayment($conn, $cust_id, $payment_amount, $payment_date);
        echo "<p>Payment of Rs." . $payment_amount . " recorded successfully.</p>";
    }

    echo '</div>';
}

mysqli_close($conn);

// Function to book the room
function bookRoom($conn, $cust_id, $room_no, $check_in, $check_out)
{
    $availability_query = "
    SELECT Room_No
    FROM Booking
    WHERE Room_No = $room_no
    AND CheckInDate <= '$check_out'
    AND CheckOutDate >= '$check_in'
    ";
    $result = mysqli_query($conn, $availability_query);
    $conflicting_bookings = mysqli_fetch_assoc($result);

    if (!$conflicting_bookings) {
        // Insert the booking record
        $booking_query = "
        INSERT INTO Booking (Cust_ID, Room_No, CheckInDate, CheckOutDate)
        VALUES ($cust_id, $room_no, '$check_in', '$check_out')
        ";
        $res = mysqli_query($conn, $booking_query);
        
        if ($res) {
            return "Booking successful.";
        } else {
            return "Error: " . mysqli_error($conn);
        }
    } else {
        return "Room is not available for the selected dates.";
    }
}

// Function to get payment amount
function getPaymentAmount($conn, $room_no, $days)
{
    $query = "
    SELECT roomtype.Price
    FROM room
    INNER JOIN roomtype ON room.Room_Type_ID = roomtype.Room_Type_ID
    WHERE Room_No = $room_no
";
$result = mysqli_query($conn, $query);
$record = mysqli_fetch_assoc($result);

if ($record) {
    $price = intval($record["Price"]); // Convert to integer
    return $price * $days;
} else {
    return null;
}
}

// Function to add payment
function addPayment($conn, $cust_id, $amount, $payment_date)
{
    $query = "
    INSERT INTO Payment (Cust_ID, Amount, PaymentDate)
    VALUES ($cust_id, $amount, '$payment_date')
    ";
    $res = mysqli_query($conn, $query);

    if (!$res) {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

</body>
</html>
