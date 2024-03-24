<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Reviews</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('https://www.itchotels.com/content/dam/itchotels/in/umbrella/images/headmast-desktop/sustainablity.jpg'); /* Replace with the actual image URL */
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        h2 {
            color: #ffffff; /* Change heading color */
            margin-bottom: 20px;
        }

        .review-box {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            margin-bottom: 20px;
        }

        .review-heading {
            color: #3498db; /* Change review heading color */
            margin: 10px 0;
        }

        p {
            margin: 10px 0;
            color: #555;
        }
    </style>
</head>
<body>

<h2>All Reviews</h2>

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

// Function to display all reviews
function displayAllReviews($conn) {
    $query = "
    SELECT Hotel.Name, Rating.Rating, Rating.Review, Rating.RatingDate
    FROM Rating
    JOIN Hotel ON Rating.HotelID = Hotel.HotelID
    ";
    $result = mysqli_query($conn, $query);

    if ($result) {
        while ($review = mysqli_fetch_assoc($result)) {
            $hotel_name = $review["Name"];
            $rating = $review["Rating"];
            $review_text = $review["Review"];
            $rating_date = $review["RatingDate"];

            echo "<div class='review-box'>";
            
            echo "<p class='review-heading'>Hotel Name: $hotel_name</p>";
            echo "<p>Rating: $rating</p>";
            echo "<p>Review: $review_text</p>";
            echo "<p>Rating Date: $rating_date</p>";
            echo "</div>";
        }
    } else {
        echo "No reviews found in the database.";
    }
}

// Call the function to display all reviews
displayAllReviews($conn);

mysqli_close($conn);
?>

</body>
</html>
