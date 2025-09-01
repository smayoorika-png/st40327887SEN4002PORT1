<?php
session_start();
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if booking ID is provided in the URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $booking_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Debugging message to check if user ID and booking ID are received
    error_log("Attempting to cancel booking with ID: " . $booking_id . " for user ID: " . $user_id);

    // SQL to delete the booking
    // Use a prepared statement to prevent SQL injection
    $sql = "DELETE FROM bookings WHERE id = ? AND customer_id = ?";
    $stmt = $conn->prepare($sql);

    // Check if the prepare statement was successful
    if ($stmt === false) {
        error_log("Prepare statement failed: " . $conn->error);
        header("Location: my_bookings.php?status=error");
        exit();
    }

    $stmt->bind_param("ii", $booking_id, $user_id);

    if ($stmt->execute()) {
        // Check if any rows were affected (meaning a booking was actually deleted)
        if ($stmt->affected_rows > 0) {
            error_log("Booking ID: " . $booking_id . " cancelled successfully.");
            header("Location: my_bookings.php?status=cancelled");
            exit();
        } else {
            // This happens if the booking ID doesn't exist or doesn't belong to the user
            error_log("No booking found with ID: " . $booking_id . " for user ID: " . $user_id);
            header("Location: my_bookings.php?status=error");
            exit();
        }
    } else {
        // Redirect back with an error message
        error_log("Execute failed: " . $stmt->error);
        header("Location: my_bookings.php?status=error");
        exit();
    }
} else {
    // If no booking ID is provided, redirect back
    error_log("No booking ID provided.");
    header("Location: my_bookings.php?status=error");
    exit();
}
?>