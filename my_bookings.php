<?php
session_start();
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get user's bookings from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM bookings WHERE customer_id = ? ORDER BY booking_date DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Get status message from URL
$status_message = '';
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'cancelled') {
        $status_message = '<div class="success-message">Booking has been successfully cancelled.</div>';
    } else if ($_GET['status'] == 'error') {
        $status_message = '<div class="error-message">Error cancelling the booking. Please try again.</div>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Bookings</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #6a11cb;
            --secondary-color: #2575fc;
            --background-start: #667eea;
            --background-end: #764ba2;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--background-start) 0%, var(--background-end) 100%);
            padding: 20px;
            color: #444;
            min-height: 100vh;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        h2.page-title {
            text-align: center;
            color: var(--primary-color);
            margin-bottom: 25px;
            font-weight: 600;
        }

        .message-container {
            text-align: center;
            margin-bottom: 15px;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 8px;
        }

        .booking-card {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #ddd;
            padding: 20px;
            margin: 15px 0;
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .booking-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }

        .booking-details {
            flex-grow: 1;
        }
        
        .booking-details h3 {
            font-size: 1.5rem;
            margin: 0 0 10px 0;
            color: var(--secondary-color);
        }
        
        .booking-details p {
            margin: 5px 0;
            font-size: 1rem;
            color: #666;
        }
        
        .booking-details strong {
            color: #222;
        }
        
        .booking-card .actions {
            display: flex;
            align-items: center;
        }

        .btn {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            display: inline-block;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .cancel-btn {
            background: linear-gradient(45deg, #d32f2f, #f44336);
        }

        .back-button-container {
            text-align: center;
            margin-top: 30px;
        }
        
        .back-button {
            text-decoration: none;
            color: #fff;
            font-weight: 500;
            transition: color 0.3s ease;
        }
        
        .back-button:hover {
            color: #ddd;
        }

        .no-bookings-message {
            text-align: center;
            font-size: 1.2rem;
            color: #777;
            padding: 50px;
            border: 2px dashed #ccc;
            border-radius: 10px;
            background-color: #f0f0f0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .booking-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .booking-card .actions {
                margin-top: 15px;
                width: 100%;
                justify-content: center;
            }

            .btn {
                width: 100%;
                text-align: center;
            }
        }
    </style>
    <script>
    function confirmCancel(bookingId) {
        if (confirm("Are you sure you want to cancel this booking?")) {
            window.location.href = "cancel_booking.php?id=" + bookingId;
        }
    }
    </script>
</head>
<body>
    <div class="container">
        <h2 class="page-title">My Bookings</h2>

        <div class="message-container">
            <?php echo $status_message; ?>
        </div>

        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="booking-card">
                    <div class="booking-details">
                        <h3><?php echo htmlspecialchars($row['hotel_name']); ?></h3>
                        <p><strong>Booking ID:</strong> #<?php echo htmlspecialchars($row['id']); ?></p>
                        <p><strong>Amount:</strong> Rs. <?php echo htmlspecialchars($row['price']); ?></p>
                        <p><strong>Check-in:</strong> <?php echo htmlspecialchars($row['check_in_date']); ?></p>
                        <p><strong>Check-out:</strong> <?php echo htmlspecialchars($row['check_out_date']); ?></p>
                        <p><strong>Guests:</strong> <?php echo htmlspecialchars($row['num_members']); ?> members in <?php echo htmlspecialchars($row['num_rooms']); ?> rooms</p>
                    </div>
                    <div class="actions">
                        <a href="#" onclick="confirmCancel(<?php echo htmlspecialchars($row['id']); ?>)" class="btn cancel-btn">Cancel Booking</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-bookings-message">
                <p>You have no current bookings.</p>
                <a href="dashboard.php" class="btn">Book Now</a>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="back-button-container">
        <a href="dashboard.php" class="back-button">← Back to Dashboard</a>
    </div>

</body>
</html>
