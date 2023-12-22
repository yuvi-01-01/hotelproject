<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Bookings</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        form {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #555;
        }

        input[type="text"] {
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
            padding: 10px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            width: 300px;
        }

        li {
            background-color: #ffffff;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <h2>Customer Bookings</h2>
    <label for="cust_id">Enter Customer ID:</label>
    <input type="text" id="cust_id" name="cust_id" required>
    <input type="submit" value="List Bookings">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cust_id = $_POST["cust_id"];

    // Include your database connection
    $servername = "localhost";
    $username = "root";
    $password = "qwer4321";
    $database = "hotelmanage"; // Replace with your actual database name

    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Sorry, failed to connect: " . mysqli_connect_error());
    }

    // Function to list customer bookings
    function listCustomerBookings($conn, $customer_id) {
        $query = "
        SELECT Booking.Booking_ID, Booking.Room_No, Booking.CheckInDate, Booking.CheckOutDate
        FROM Booking
        WHERE Booking.Cust_ID = $customer_id
        ";
        $result = mysqli_query($conn, $query);
        $bookings = mysqli_fetch_all($result, MYSQLI_ASSOC);

        if (!$bookings) {
            echo "<p>No bookings found for this customer.</p>";
        } else {
            echo "<p>List of bookings made by Customer ID $customer_id:</p>";
            echo "<ul>";
            foreach ($bookings as $booking) {
                echo "<li>";
                echo "<strong>Booking ID:</strong> " . $booking["Booking_ID"] . "<br>";
                echo "<strong>Room No:</strong> " . $booking["Room_No"] . "<br>";
                echo "<strong>Check-In Date:</strong> " . $booking["CheckInDate"] . "<br>";
                echo "<strong>Check-Out Date:</strong> " . $booking["CheckOutDate"];
                echo "</li>";
            }
            echo "</ul>";
        }
    }

    // Call the function to list customer bookings
    listCustomerBookings($conn, $cust_id);

    mysqli_close($conn);
}
?>

</body>
</html>
