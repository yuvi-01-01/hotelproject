<?php
$servername = "localhost";
$username = "root";
$password = "qwer4321";
$database = "hotelmanage";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Sorry, failed to connect: " . mysqli_connect_error());
}

function getRoomData($conn)
{
    $query = "
        SELECT Room_No, Type, Price FROM room JOIN roomtype ON room.Room_Type_ID = roomtype.Room_Type_ID
    ";
    $result = mysqli_query($conn, $query);

    while ($record = mysqli_fetch_assoc($result)) {
        $room_no = $record["Room_No"];
        $room_type = $record["Type"];
        $price = intval($record["Price"]); // Convert to integer
        echo "<option value='$room_no'>$room_type - Rs.$price (Room $room_no)</option>";
    }
}
?>
