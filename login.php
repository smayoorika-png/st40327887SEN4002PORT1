<?php
// Initialize a message variable for status updates
$message = '';

// --- MySQL DATABASE CONNECTION ---
// IMPORTANT: Replace these with your actual database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_management"; // Use the same database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $user_name = $_POST['username'];
    $pass_word = $_POST['password'];

    // --- VERY IMPORTANT SECURITY NOTE ---
    // This is a basic example. In a real application, you MUST:
    // 1. Hash passwords before storing them in the database.
    // 2. Use prepared statements with parameterized queries to prevent SQL injection.
    // 3. Implement session management for authenticated users.

    // --- Search for the user in the database ---
    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user_name, $pass_word);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User found, login successful
        // In a real app, you would set a session variable here
        $message = '<div class="success-message">Login successful! Redirecting...</div>';
        // Redirect to the dashboard page after a short delay
        header("refresh:2;url=dashboard.php");
    } else {
        // User not found or incorrect credentials
        $message = '<div class="error-message">Invalid username or password.</div>';
    }
    $stmt->close();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7f6;
            color: #333;
        }
        .login-container {
            display: flex;
            height: 100vh;
        }
        .login-image {
            flex: 1;
            background-image: url('https://images7.alphacoders.com/379/379773.jpg');
            background-size: cover;
            background-position: center;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        .login-image::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(74, 144, 226, 0.4);
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
        }
        .login-form-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: white;
            padding: 2rem;
        }
        .login-form {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            text-align: center;
        }
        .login-form h2 {
            font-size: 2rem;
            color: #4a90e2;
            margin-bottom: 2rem;
        }
        .form-group {
            margin-bottom: 1.5rem;
            text-align: left;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: bold;
        }
        .form-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        .form-group input:focus {
            border-color: #4a90e2;
            outline: none;
        }
        button {
            width: 100%;
            padding: 0.75rem;
            background-color: #718fb1ff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: bold;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #a54b8cff;
        }
        .message-container {
            margin-top: 1rem;
        }
        .error-message, .success-message {
            padding: 0.75rem;
            border-radius: 5px;
            text-align: center;
        }
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
        }

        /* Responsive design for small screens */
        @media (max-width: 768px) {
            .login-container {
                flex-direction: column;
            }
            .login-image {
                height: 30vh;
                border-radius: 0;
            }
            .login-form-container {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-image"></div>
        <div class="login-form-container">
            <div class="login-form">
                <h2>Welcome Back</h2>
                <div class="message-container">
                    <?php echo $message; ?>
                </div>
                <form action="login.php" method="post">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit">LOGIN</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
