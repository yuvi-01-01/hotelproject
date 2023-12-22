<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Select Facilities Form</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('https://cdn-images.cure.fit/www-curefit-com/image/upload/c_fill,w_375,q_auto:eco,dpr_2,f_auto,fl_progressive/v1/cult-media/v2web/centers/261_Cult_Swimming%20MKR%20Sports%20Arena%20Marathahalli_PRODUCT_BNR_2019-12-05T11:46:12.552Z.png') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }

        form {
            background-color: rgba(255, 255, 255, 0.8);
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
            margin: 10px 0 5px;
            color: #555;
        }

        input[type="checkbox"] {
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #3498db;
            color: white;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }
        .form-title{
            font-weight:bold;
        }
    </style>
</head>
<body>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <div class="form-title">
        Select Facilities
    </div>

    <label for="cust_id">Customer ID:</label>
    <input type="text" id="cust_id" name="cust_id" required><br>

    <!-- Hidden field for hotel_id with a fixed value (e.g., 1) -->
    <input type="hidden" id="hotel_id" name="hotel_id" value="1">

    <br>
    
    <?php
    // PHP code to fetch and display facility data
    $servername = "localhost";
    $username = "root";
    $password = "qwer4321";
    $database = "hotelmanage"; // Replace with your actual database name

    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Sorry, failed to connect: " . mysqli_connect_error());
    }

    $query = "SELECT FacilityID, FacilityName FROM Facility";
    $result = mysqli_query($conn, $query);

    while ($record = mysqli_fetch_assoc($result)) {
        $facility_id = $record["FacilityID"];
        $facility_name = $record["FacilityName"];
        echo "<input type='checkbox' name='selected_facilities[]' value='$facility_id'>$facility_name<br>";
    }

    mysqli_close($conn);
    ?>
    
    <br>

    <input type="submit" value="Select Facilities">
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the PHP code to process facilities here
    $cust_id = $_POST["cust_id"];
    $hotel_id = $_POST["hotel_id"];
    $selected_facilities = $_POST["selected_facilities"];

    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Sorry, failed to connect: " . mysqli_connect_error());
    }

    $insert_query = "INSERT INTO Customer_Hotel_Facility (Cust_ID, HotelID, FacilityID) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_query);
    mysqli_stmt_bind_param($stmt, "iii", $cust_id, $hotel_id, $facility_id);

    foreach ($selected_facilities as $facility_id) {
        mysqli_stmt_execute($stmt);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

    echo "Facilities selected successfully.";
}
?>

</body>
</html>

