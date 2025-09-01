<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Enable error reporting for debugging
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

// Initialize variables
$hotel_name = $_GET['hotel'] ?? '';
$price = $_GET['price'] ?? '';
$error = '';
$success = '';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hotel_name = $_POST['hotel_name'] ?? '';
    $price = $_POST['price'] ?? '';
    $check_in = $_POST['check_in'] ?? '';
    $check_out = $_POST['check_out'] ?? '';
    $num_rooms = $_POST['num_rooms'] ?? '';
    $num_members = $_POST['num_members'] ?? '';
    $customer_name = $_POST['customer_name'] ?? '';
    $customer_email = $_POST['customer_email'] ?? '';
    $customer_phone = $_POST['customer_phone'] ?? '';
    $customer_id_number = $_POST['customer_id_number'] ?? '';
    $customer_id = $_SESSION['user_id'];

    // Insert booking into database
    $sql = "INSERT INTO bookings (hotel_name, price, check_in_date, check_out_date, num_rooms, num_members, customer_name, customer_email, customer_phone, customer_id_number, customer_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssiissssi", $hotel_name, $price, $check_in, $check_out, $num_rooms, $num_members, $customer_name, $customer_email, $customer_phone, $customer_id_number, $customer_id);

    if ($stmt->execute()) {
        $booking_id = $stmt->insert_id;
        
        // Send confirmation email
        $email_subject = "Booking Confirmation - Booking ID: #$booking_id";
        $email_message = "
            <h2>Booking Confirmed Successfully!</h2>
            <p>Thank you for booking with us. Here are your booking details:</p>
            <div style='background:#f8f9fa; padding:15px; border-radius:10px;'>
                <p><strong>Booking ID:</strong> #$booking_id</p>
                <p><strong>Hotel:</strong> $hotel_name</p>
                <p><strong>Check-in:</strong> $check_in</p>
                <p><strong>Check-out:</strong> $check_out</p>
                <p><strong>Rooms:</strong> $num_rooms</p>
                <p><strong>Guests:</strong> $num_members</p>
                <p><strong>Total Amount:</strong> Rs. $price</p>
            </div>
            <p>We look forward to serving you!</p>
        ";
        
        // Send email
        if (sendEmail($customer_email, $customer_name, $email_subject, $email_message)) {
            header("Location: booking_success.php?booking_id=" . $booking_id . "&hotel=" . urlencode($hotel_name) . "&price=" . urlencode($price) . "&email=sent");
        } else {
            header("Location: booking_success.php?booking_id=" . $booking_id . "&hotel=" . urlencode($hotel_name) . "&price=" . urlencode($price) . "&email=failed");
        }
        exit();
    } else {
        $error = "Booking failed. Please try again.";
    }
    $stmt->close();
}
$conn->close();

// Email sending function
function sendEmail($to, $name, $subject, $message) {
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Hotel Management System <noreply@yourhotel.com>" . "\r\n";
    
    return mail($to, $subject, $message, $headers);
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Room - <?php echo htmlspecialchars($hotel_name); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .container {
            max-width: 700px;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
        }
        
        h2 {
            text-align: center;
            color: #2d3436;
            margin-bottom: 20px;
            font-size: 28px;
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .hotel-info {
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            color: white;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .hotel-info p {
            margin: 8px 0;
            font-size: 16px;
            display: flex;
            align-items: center;
        }
        
        .hotel-info i {
            margin-right: 10px;
            font-size: 18px;
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2d3436;
            font-weight: 600;
            font-size: 15px;
        }
        
        .form-group input {
            width: 100%;
            padding: 14px;
            border: 2px solid #ddd;
            border-radius: 10px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus {
            border-color: #6a11cb;
            outline: none;
            box-shadow: 0 0 10px rgba(106, 17, 203, 0.3);
        }
        
        .btn {
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            color: white;
            padding: 16px;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }
        
        .btn i {
            margin-left: 8px;
        }
        
        .error {
            background: #ffebee;
            color: #c62828;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            border-left: 4px solid #c62828;
        }
        
        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            .container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2><i class="fas fa-hotel"></i> Book Your Room</h2>
        
        <div class="hotel-info">
            <p><i class="fas fa-building"></i> <strong>Hotel:</strong> <?php echo htmlspecialchars($hotel_name); ?></p>
            <p><i class="fas fa-tag"></i> <strong>Price per night:</strong> Rs. <?php echo htmlspecialchars($price); ?></p>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="error">
                <i class="fas fa-exclamation-circle"></i> <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form action="" method="post">
            <input type="hidden" name="hotel_name" value="<?php echo htmlspecialchars($hotel_name); ?>">
            <input type="hidden" name="price" value="<?php echo htmlspecialchars($price); ?>">
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="customer_name"><i class="fas fa-user"></i> Full Name</label>
                    <input type="text" id="customer_name" name="customer_name" required>
                </div>
                
                <div class="form-group">
                    <label for="customer_id_number"><i class="fas fa-id-card"></i> ID Number</label>
                    <input type="text" id="customer_id_number" name="customer_id_number" required>
                </div>
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="customer_email"><i class="fas fa-envelope"></i> Email Address</label>
                    <input type="email" id="customer_email" name="customer_email" required>
                </div>
                
                <div class="form-group">
                    <label for="customer_phone"><i class="fas fa-phone"></i> Phone Number</label>
                    <input type="tel" id="customer_phone" name="customer_phone" required>
                </div>
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="check_in"><i class="fas fa-calendar-check"></i> Check-in Date</label>
                    <input type="date" id="check_in" name="check_in" required>
                </div>
                
                <div class="form-group">
                    <label for="check_out"><i class="fas fa-calendar-times"></i> Check-out Date</label>
                    <input type="date" id="check_out" name="check_out" required>
                </div>
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="num_rooms"><i class="fas fa-bed"></i> Number of Rooms</label>
                    <input type="number" id="num_rooms" name="num_rooms" min="1" required>
                </div>
                
                <div class="form-group">
                    <label for="num_members"><i class="fas fa-users"></i> Number of Guests</label>
                    <input type="number" id="num_members" name="num_members" min="1" required>
                </div>
            </div>
            
            <button type="submit" class="btn">Confirm Booking <i class="fas fa-check-circle"></i></button>
        </form>
    </div>

    <script>
        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('check_in').setAttribute('min', today);
        
        // Update checkout min date when checkin changes
        document.getElementById('check_in').addEventListener('change', function() {
            document.getElementById('check_out').setAttribute('min', this.value);
        });
    </script>
</body>
</html>