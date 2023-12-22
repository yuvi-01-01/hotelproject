<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Hotel Delight</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            text-align: center;
            color: white;
        }

        #top-section {
            background: url('https://cdn.loewshotels.com/loewshotels.com-2466770763/cms/cache/v2/620d6d91270c8.jpg/1920x1080/fit/80/eb7551cd93224863612f7472c55d933f.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 700px; /* Adjust the height as needed */
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        header {
            background: rgba(255, 255, 255, 0.8);
            padding: 30px; /* Increased padding for better visual appeal */
            font-size: 36px; /* Larger font size for the heading */
            margin-bottom: 20px;
            color: #2980b9; /* Set heading color to a shade of blue */
            font-weight: bold; /* Boldify the heading */
        }

        #bottom-section {
            background-color: #f5f5f5;
            padding: 20px;
            text-align: center;
            position: relative; /* Relative positioning for child elements */
        }

        main {
            margin: 20px auto;
            max-width: 800px;
        }

        h2 {
            color: #333;
            font-size: 32px;
            margin-bottom: 20px;
        }

        a {
            text-decoration: none;
            color: #2ecc71; /* Set link color to green */
            margin: 10px;
            padding: 15px 20px;
            display: inline-block;
            border: 2px solid #2ecc71; /* Set border color to green */
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s;
        }

        a:hover {
            background-color: #27ae60; /* Darker green on hover */
            color: white;
        }

        footer {
            background: rgba(255, 255, 255, 0.8);
            color: #333;
            padding: 20px;
            text-align: left;
            font-size: 14px;
        }

        footer p {
            margin: 5px 0;
        }

        footer strong {
            font-weight: bold; /* Boldify the "Contact Us" */
        }
    </style>
</head>
<body>

<div id="top-section">
    <header>
        <h1>Welcome to Hotel Delight!</h1>
    </header>
</div>

<div id="bottom-section">
    <main>
        <a href="./register_process.php">Customer Registration</a>
        <a href="./book_room.php">Room Booking</a>
        <a href="./process_rating.php">Give Rating</a>
        <a href="./selectfacilities.php">Select Facilities</a>
        <a href="./knowbookings.php">Know Your Bookings</a>
        <a href="./updateinfo.php">Update Your Information</a>
        <a href="./seereviews.php">See All Reviews</a>
        <a href="./cancelbooking.php">Cancel Your Booking</a>
    </main>

    <footer>
        <p><strong>Contact Us:</strong></p>
        <p>Email: info@hoteldelight.com</p>
        <p>Phone: 123-456-7890</p>
    </footer>
</div>

</body>
</html>