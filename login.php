<?php
require_once 'config.php';

// If already logged in, redirect to portfolio
if (isLoggedIn()) {
    header("Location: portfolio.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    
    // Validation
    if (empty($email) || empty($password)) {
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } else {
        // Check credentials
        $dbconn = getDBConnection();
        
        $query = "SELECT id, full_name, email, password FROM users WHERE email = $1";
        $result = pg_query_params($dbconn, $query, array($email));
        
        if (pg_num_rows($result) > 0) {
            $user = pg_fetch_assoc($result);
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Login successful - create session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['full_name'];
                $_SESSION['user_email'] = $user['email'];
                
                // Update last login
                $update_query = "UPDATE users SET last_login = CURRENT_TIMESTAMP WHERE id = $1";
                pg_query_params($dbconn, $update_query, array($user['id']));
                
                pg_close($dbconn);
                
                // Redirect to portfolio
                header("Location: portfolio.php");
                exit();
            } else {
                $error = "Invalid email or password!";
            }
        } else {
            $error = "Invalid email or password!";
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
    <title>Login - Gil Bryan Guillermo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-box">
            <div class="auth-nav-back">
                <a href="index.php">← Back to Browse</a>
            </div>
            
            <h1>Welcome Back</h1>
            <p class="subtitle">Login to edit your portfolio</p>
            
            <?php if ($error): ?>
                <div class="message error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="login.php" id="loginForm">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" 
                           value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                           required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn-primary">Login</button>
            </form>
            
            <p class="auth-switch">
                Don't have an account? <a href="register.php">Register here</a>
            </p>
            
            <div class="demo-credentials">
                <p><strong>Demo Account:</strong></p>
                <p>Email: test@example.com</p>
                <p>Password: test123</p>
            </div>
        </div>
    </div>
    
    <script src="validation.js"></script>
</body>
</html>