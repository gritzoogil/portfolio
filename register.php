<?php
require_once 'config.php';

// If already logged in, redirect to portfolio
if (isLoggedIn()) {
    header("Location: portfolio.php");
    exit();
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = sanitize($_POST['full_name']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validation
    if (empty($full_name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters long!";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } else {
        // Check if email already exists
        $dbconn = getDBConnection();
        
        $check_query = "SELECT id FROM users WHERE email = $1";
        $result = pg_query_params($dbconn, $check_query, array($email));
        
        if (pg_num_rows($result) > 0) {
            $error = "Email already registered! Please login.";
        } else {
            // Hash password and insert user
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            $insert_query = "INSERT INTO users (full_name, email, password) VALUES ($1, $2, $3)";
            $insert_result = pg_query_params($dbconn, $insert_query, array($full_name, $email, $hashed_password));
            
            if ($insert_result) {
                $success = "Registration successful! You can now login.";
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
        
        pg_close($dbconn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Gil Bryan Guillermo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <h1>Create Account</h1>
            <p class="subtitle">Join to view my portfolio</p>
            
            <?php if ($error): ?>
                <div class="message error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="message success"><?php echo $success; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="register.php" id="registerForm">
                <div class="form-group">
                    <label for="full_name">Full Name</label>
                    <input type="text" id="full_name" name="full_name" 
                           value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>"
                           required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" 
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                           required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" 
                           minlength="6" required>
                    <small>Minimum 6 characters</small>
                </div>
                
                <div class="form-group">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" 
                           minlength="6" required>
                </div>
                
                <button type="submit" class="btn-primary">Create Account</button>
            </form>
            
            <p class="auth-switch">
                Already have an account? <a href="login.php">Login here</a>
            </p>
        </div>
    </div>
    
    <script src="validation.js"></script>
</body>
</html>