<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Get booking details from URL
$hotel_name = $_GET['hotel'] ?? '';
$price = $_GET['price'] ?? '';
$booking_id = rand(1000, 9999); // Random booking ID
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmed</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }
        
        .success-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            max-width: 500px;
            width: 100%;
        }
        
        .success-icon {
            font-size: 80px;
            color: #4CAF50;
            margin-bottom: 20px;
        }
        
        h2 {
            color: #2d3436;
            margin-bottom: 15px;
        }
        
        p {
            color: #636e72;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        strong {
            color: #2d3436;
        }
        
        .booking-details {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: left;
        }
        
        .btn {
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            color: white;
            padding: 12px 25px;
            border: none;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            margin: 10px;
            display: inline-block;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">✅</div>
        <h2>Booking Confirmed Successfully!</h2>
        
        <div class="booking-details">
            <p><strong>Booking ID:</strong> #<?php echo $booking_id; ?></p>
            <p><strong>Hotel:</strong> <?php echo htmlspecialchars($hotel_name); ?></p>
            <p><strong>Amount:</strong> Rs. <?php echo htmlspecialchars($price); ?></p>
            <p><strong>Status:</strong> <span style="color: #4CAF50;">Confirmed</span></p>
        </div>
        
        <p>Thank you for choosing our service! Your booking has been confirmed.</p>
        
        <div style="margin-top: 30px;">
            <a href="dashboard.php" class="btn">Back to Dashboard</a>
           <a href="my_bookings.php" class="btn">View My Bookings</a>
        </div>
    </div>
</body>
</html>