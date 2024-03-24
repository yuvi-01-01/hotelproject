<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('https://www.hotelmetdelhi.com/img/slideshow/banner1.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }

        .result-container {
            background-color: #e0f7fa; /* Change this to your desired background color */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
            text-align: center;
        }

        h1 {
            text-align: center;
            color: #333;
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
    </style>
</head>
<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $servername = "localhost";
        $username = "root";
        $password = "qwer4321";
        $database = "hotelmanage";

        $conn = mysqli_connect($servername, $username, $password, $database);
        

        // Collect form data
        $first_name = $_POST["first_name"];
        $last_name = $_POST["last_name"];
        $dob = $_POST["dob"];
        $phone = $_POST["phone"];
        $email = $_POST["email"];

        // Use prepared statement to prevent SQL injection
        $sql1 = "INSERT INTO customer (FirstName, LastName, DOB, Phone, Email) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $sql1);
        
        mysqli_stmt_bind_param($stmt, "sssss", $first_name, $last_name, $dob, $phone, $email);
        
        $res1 = mysqli_stmt_execute($stmt);
        
        if ($res1) {
            $last_inserted_id = mysqli_insert_id($conn);
            echo "<div class='result-container'>Data inserted successfully. Cust_ID: " . $last_inserted_id . "</div>";
        } else {
            echo "<div class='result-container' style='background-color: #ffcccb;'>Error: " . mysqli_error($conn) . "</div>";
        }
        
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    } else {
    ?>
    <div class="form-container">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <h1>Customer Registration Form</h1>
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" required>

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" required>

            <label for="dob">Date of Birth (YYYY-MM-DD):</label>
            <input type="text" name="dob" required>

            <label for="phone">Phone Number:</label>
            <input type="text" name="phone" required>

            <label for="email">Email Address:</label>
            <input type="email" name="email" required>

            <input type="submit" value="Register">
        </form>
    </div>
    <?php } ?>
</body>
</html>


