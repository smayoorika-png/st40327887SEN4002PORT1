<?php
session_start();
$message = '';

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check which form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];
    
    if ($action === 'register') {
        // REGISTRATION
        $new_username = $_POST['new_username'];
        $new_email = $_POST['new_email'];
        $new_password = $_POST['new_password'];
        
        // Check if username or email already exists
        $check_stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $check_stmt->bind_param("ss", $new_username, $new_email);
        $check_stmt->execute();
        $check_result = $check_stmt->get_result();
        
        if ($check_result->num_rows > 0) {
            $message = '<div class="error-message">Username or Email already exists!</div>';
            $show_register = true;
        } else {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $new_username, $new_email, $hashed_password);

            if ($stmt->execute()) {
                $message = '<div class="success-message">Registration successful! Please login.</div>';
                $show_register = false;
            } else {
                $message = '<div class="error-message">Registration failed. Please try again.</div>';
                $show_register = true;
            }
            $stmt->close();
        }
        $check_stmt->close();
        
    } else {
        // LOGIN
        $email_username = $_POST['email_username'];
        $password = $_POST['password'];
        
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $email_username, $email_username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $email_username;
                header("Location: dashboard.php");
                exit();
            } else {
                $message = '<div class="error-message">Invalid password!</div>';
                $show_register = false;
            }
        } else {
            $message = '<div class="error-message">User not found!</div>';
            $show_register = false;
        }
        $stmt->close();
    }
}

// Check which form to show by default
$show_register = isset($show_register) ? $show_register : false;

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Management Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(to right, #190587ff, #758392ff);
            color: #140b0bff;
        }
        .container {
            width: 100%;
            max-width: 400px;
            padding: 2rem;
            background-color: rgba(111, 99, 141, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
        }
        .title {
            margin-bottom: 0.5rem;
            color: #130a0aff;
            font-size: 2rem;
            font-weight: 700;
        }
        .subtitle {
            margin-bottom: 2rem;
            color: #340707ff;
        }
        .input-group {
            margin-bottom: 1.5rem;
        }
        .input-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.3s;
        }
        .input-group input:focus {
            border-color: #4a90e2;
        }
        button {
            width: 100%;
            padding: 0.75rem;
            background: linear-gradient(to right, #4a90e2, #6d8e98ff);
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1rem;
            font-weight: bold;
            letter-spacing: 1px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .message-box {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            font-weight: bold;
        }
        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        .toggle-link {
            color: #4a90e2;
            cursor: pointer;
            font-weight: bold;
        }
        .toggle-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php echo $message; ?>
        
        <!-- LOGIN FORM -->
        <form id="login-form" action="" method="post" style="<?php echo $show_register ? 'display: none;' : 'display: block;'; ?>">
            <h2 class="title">Hotel Management</h2>
            <p class="subtitle">Login to your account</p>
            
            <input type="hidden" name="action" value="login">
            
            <div class="input-group">
                <input type="text" name="email_username" placeholder="Username or Email" required>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            
            <button type="submit">LOGIN</button>
            
            <p style="margin-top: 1rem; color: #1c0808ff;">
                Don't have an account? 
                <span class="toggle-link" onclick="showRegisterForm()">Register here</span>
            </p>
        </form>

        <!-- REGISTER FORM -->
        <form id="register-form" action="" method="post" style="<?php echo $show_register ? 'display: block;' : 'display: none;'; ?>">
            <h2 class="title">Create Account</h2>
            <p class="subtitle">Register for a new account</p>
            
            <input type="hidden" name="action" value="register">
            
            <div class="input-group">
                <input type="text" name="new_username" placeholder="Choose Username" required>
            </div>
            <div class="input-group">
                <input type="email" name="new_email" placeholder="Email Address" required>
            </div>
            <div class="input-group">
                <input type="password" name="new_password" placeholder="Create Password" required>
            </div>
            
            <button type="submit">REGISTER</button>
            
            <p style="margin-top: 1rem; color: #1e0c0cff;">
                Already have an account? 
                <span class="toggle-link" onclick="showLoginForm()">Login here</span>
            </p>
        </form>
    </div>

    <script>
        function showRegisterForm() {
            document.getElementById('login-form').style.display = 'none';
            document.getElementById('register-form').style.display = 'block';
        }
        
        function showLoginForm() {
            document.getElementById('register-form').style.display = 'none';
            document.getElementById('login-form').style.display = 'block';
        }
    </script>
</body>
</html>