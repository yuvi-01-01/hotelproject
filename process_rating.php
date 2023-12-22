<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rating Form</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            background: url('https://t4.ftcdn.net/jpg/00/65/82/13/360_F_65821315_WGpXLhFtlEHfGQ8sqJ5RUNFNmnYDGgOd.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        form {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        fieldset {
            border: none;
        }

        legend {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            color: #555;
        }

        input,
        textarea {
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
            background-color: #27ae60;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .result-text {
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    <fieldset>
        <legend>Rating Form</legend>

        <label for="cust_id">Customer ID:</label>
        <input type="text" id="cust_id" name="cust_id" required>

        <label for="rating">Rating (0.0 to 5.0):</label>
        <input type="number" id="rating" name="rating" min="0" max="5" step="0.1" required>

        <!-- Remove the Hotel ID input field -->

        <label for="review">Review:</label>
        <textarea id="review" name="review" rows="4" cols="50" required></textarea>

        <label for="RatingDate">Rating Date:</label>
        <input type="date" id="RatingDate" name="RatingDate" required>

        <input type="submit" value="Submit Rating">
    </fieldset>
</form>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "qwer4321";
    $database = "hotelmanage"; // Replace with your actual database name

    $conn = mysqli_connect($servername, $username, $password, $database);
    if (!$conn) {
        die("Sorry, failed to connect: " . mysqli_connect_error());
    }

    // Collect form data
    $cust_id = $_POST["cust_id"];
    $rating = $_POST["rating"];
    $h_id = 1; // Set a fixed Hotel ID
    $review = $_POST["review"];
    $RatingDate = $_POST["RatingDate"];

    // Call the function to add rating
    $result = addRating($conn, $cust_id, $rating, $h_id, $review, $RatingDate);

    // Display the result in a separate box
    echo '<div class="result-box">';
    if ($result) {
        echo '<p class="result-text">Rating recorded successfully.</p>';
    } else {
        echo '<p class="result-text">Error: ' . mysqli_error($conn) . '</p>';
    }
    echo '</div>';

    mysqli_close($conn);
}

function addRating($conn, $cust_id, $rating, $h_id, $review, $RatingDate)
{
    $query = "INSERT INTO Rating (Cust_ID, Rating, HotelID, Review, RatingDate)
              VALUES ($cust_id, $rating, $h_id, '$review', '$RatingDate')";
    return mysqli_query($conn, $query);
}
?>
</body>
</html>
