<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Customer Information</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
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
            width: 300px;
            text-align: center;
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

        select,
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

        .result-container {
            margin-top: 20px;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
        }

        p {
            color: #27ae60;
            font-weight: bold;
        }

        .error {
            color: #e74c3c;
        }
    </style>
</head>
<body>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <h2>Update Customer Information</h2>
    <label for="cust_id">Enter Customer ID:</label>
    <input type="text" id="cust_id" name="cust_id" required>
    <br>

    <label>Select information to update:</label>
    <select name="update_choice">
        <option value="1">Update Phone Number</option>
        <option value="2">Update Email Address</option>
    </select>
    <br>

    <label for="new_value">Enter new value:</label>
    <input type="text" id="new_value" name="new_value" required>
    <br>

    <input type="submit" value="Update Information">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cust_id = $_POST["cust_id"];
    $update_choice = $_POST["update_choice"];
    $new_value = $_POST["new_value"];

    // Include your database connection
    $servername = "localhost";
    $username = "root";
    $password = "qwer4321";
    $database = "hotelmanage"; // Replace with your actual database name

    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Sorry, failed to connect: " . mysqli_connect_error());
    }

    // Function to update customer information
    function updateCustomerInformation($conn, $customer_id, $choice, $new_value) {
        $update_query = "";
        switch ($choice) {
            case "1":
                $update_query = "
                UPDATE Customer
                SET Phone = '$new_value'
                WHERE Cust_ID = $customer_id
                ";
                break;
            case "2":
                $update_query = "
                UPDATE Customer
                SET Email = '$new_value'
                WHERE Cust_ID = $customer_id
                ";
                break;
            default:
                echo "<p class='error'>Invalid choice. Please select 1 or 2 to update phone number or email.</p>";
                return;
        }

        $result = mysqli_query($conn, $update_query);
        if ($result) {
            echo "<div class='result-container' style='background-color: #d4edda;'><p>Information updated successfully.</p></div>";
        } else {
            echo "<div class='result-container' style='background-color: #f8d7da;'><p class='error'>Error updating information: " . mysqli_error($conn) . "</p></div>";
        }
    }

    // Call the function to update customer information
    updateCustomerInformation($conn, $cust_id, $update_choice, $new_value);

    mysqli_close($conn);
}
?>

</body>
</html>

