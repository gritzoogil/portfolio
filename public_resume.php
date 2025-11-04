<?php
require_once 'config.php';

// NO LOGIN REQUIRED - This is public access

// Get user ID from URL parameter
$user_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($user_id <= 0) {
    die("Invalid user ID");
}

// Fetch user data
$dbconn = getDBConnection();
$query = "SELECT full_name, email, phone, location, bio, skills, education, experience, projects 
          FROM users WHERE id = $1";
$result = pg_query_params($dbconn, $query, array($user_id));

if (pg_num_rows($result) == 0) {
    die("User not found");
}

$user = pg_fetch_assoc($result);
pg_close($dbconn);

// Helper function to split comma-separated skills
function getSkillsArray($skills_string) {
    if (empty($skills_string)) return array();
    return array_map('trim', explode(',', $skills_string));
}

$skills_array = getSkillsArray($user['skills']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($user['full_name']); ?> - Resume</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Public Navigation -->
    <nav class="navbar navbar-public">
        <div class="container">
            <div class="nav-brand"><?php echo htmlspecialchars($user['full_name']); ?></div>
            <div class="nav-menu">
                <a href="index.php">← Browse All</a>
                <a href="login.php" class="btn-login">Login</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero hero-public">
        <div class="container">
            <div class="hero-content">
                <div class="public-badge">Public Resume</div>
                <h1><?php echo htmlspecialchars($user['full_name']); ?></h1>
                
                <div class="contact-badges">
                    <?php if (!empty($user['email'])): ?>
                        <a href="mailto:<?php echo htmlspecialchars($user['email']); ?>" class="badge">
                            📧 <?php echo htmlspecialchars($user['email']); ?>
                        </a>
                    <?php endif; ?>
                    
                    <?php if (!empty($user['phone'])): ?>
                        <a href="tel:<?php echo htmlspecialchars($user['phone']); ?>" class="badge">
                            📱 <?php echo htmlspecialchars($user['phone']); ?>
                        </a>
                    <?php endif; ?>
                    
                    <?php if (!empty($user['location'])): ?>
                        <span class="badge">
                            📍 <?php echo htmlspecialchars($user['location']); ?>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Bio Section -->
    <?php if (!empty($user['bio'])): ?>
    <section class="section">
        <div class="container">
            <h2 class="section-title">About</h2>
            <div class="public-content">
                <p><?php echo nl2br(htmlspecialchars($user['bio'])); ?></p>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Skills Section -->
    <?php if (!empty($skills_array)): ?>
    <section class="section section-alt">
        <div class="container">
            <h2 class="section-title">Skills</h2>
            <div class="skill-tags">
                <?php foreach ($skills_array as $skill): ?>
                    <?php if (!empty($skill)): ?>
                        <span class="skill-tag"><?php echo htmlspecialchars($skill); ?></span>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Education Section -->
    <?php if (!empty($user['education'])): ?>
    <section class="section">
        <div class="container">
            <h2 class="section-title">Education</h2>
            <div class="public-content">
                <p><?php echo nl2br(htmlspecialchars($user['education'])); ?></p>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Experience Section -->
    <?php if (!empty($user['experience'])): ?>
    <section class="section section-alt">
        <div class="container">
            <h2 class="section-title">Experience</h2>
            <div class="public-content">
                <p><?php echo nl2br(htmlspecialchars($user['experience'])); ?></p>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Projects Section -->
    <?php if (!empty($user['projects'])): ?>
    <section class="section">
        <div class="container">
            <h2 class="section-title">Projects</h2>
            <div class="public-content">
                <p><?php echo nl2br(htmlspecialchars($user['projects'])); ?></p>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($user['full_name']); ?>. All rights reserved.</p>
            <p class="footer-note">This is a public resume page. <a href="login.php">Login</a> to edit.</p>
        </div>
    </footer>
</body>
</html>