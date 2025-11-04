<?php
require_once 'config.php';

// Fetch all users who have at least some resume data
$dbconn = getDBConnection();
$query = "SELECT id, full_name, email, location, bio, skills 
          FROM users 
          ORDER BY created_at DESC";
$result = pg_query($dbconn, $query);

$users = array();
while ($row = pg_fetch_assoc($result)) {
    $users[] = $row;
}

pg_close($dbconn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Hub - Browse Resumes</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-public">
        <div class="container">
            <div class="nav-brand">Portfolio Hub</div>
            <div class="nav-menu">
                <a href="index.php">Browse Resumes</a>
                <a href="login.php" class="btn-login">Login</a>
                <a href="register.php" class="btn-register">Register</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero hero-landing">
        <div class="container">
            <div class="hero-content">
                <h1>Discover Professional Resumes</h1>
                <p class="hero-description">
                    Browse through our collection of professional portfolios and resumes. 
                    Create your own account to build and share your resume with the world.
                </p>
                <div class="hero-buttons">
                    <a href="register.php" class="btn-primary">Create Your Resume</a>
                    <a href="#resumes" class="btn-secondary">Browse Resumes</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Resumes Grid Section -->
    <section id="resumes" class="section">
        <div class="container">
            <h2 class="section-title">Available Resumes</h2>
            
            <?php if (count($users) == 0): ?>
                <div class="empty-state">
                    <p>No resumes available yet. Be the first to create one!</p>
                    <a href="register.php" class="btn-primary">Register Now</a>
                </div>
            <?php else: ?>
                <div class="resume-grid">
                    <?php foreach ($users as $user): ?>
                        <div class="resume-card">
                            <div class="resume-card-header">
                                <div class="avatar">
                                    <?php echo strtoupper(substr($user['full_name'], 0, 2)); ?>
                                </div>
                                <h3><?php echo htmlspecialchars($user['full_name']); ?></h3>
                                <?php if (!empty($user['location'])): ?>
                                    <p class="location">📍 <?php echo htmlspecialchars($user['location']); ?></p>
                                <?php endif; ?>
                            </div>
                            
                            <div class="resume-card-body">
                                <?php if (!empty($user['bio'])): ?>
                                    <p class="bio">
                                        <?php 
                                        $bio = htmlspecialchars($user['bio']);
                                        echo strlen($bio) > 120 ? substr($bio, 0, 120) . '...' : $bio;
                                        ?>
                                    </p>
                                <?php else: ?>
                                    <p class="bio empty">No bio available</p>
                                <?php endif; ?>
                                
                                <?php if (!empty($user['skills'])): ?>
                                    <div class="resume-skills">
                                        <?php 
                                        $skills = array_slice(array_map('trim', explode(',', $user['skills'])), 0, 3);
                                        foreach ($skills as $skill): 
                                            if (!empty($skill)):
                                        ?>
                                            <span class="skill-badge"><?php echo htmlspecialchars($skill); ?></span>
                                        <?php 
                                            endif;
                                        endforeach; 
                                        
                                        $skill_count = count(array_filter(explode(',', $user['skills'])));
                                        if ($skill_count > 3):
                                        ?>
                                            <span class="skill-more">+<?php echo $skill_count - 3; ?> more</span>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            
                            <div class="resume-card-footer">
                                <a href="public_resume.php?id=<?php echo $user['id']; ?>" class="btn-view">
                                    View Resume →
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="section section-alt cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Ready to Showcase Your Skills?</h2>
                <p>Create your professional resume and share it with the world in minutes.</p>
                <a href="register.php" class="btn-primary btn-large">Get Started Free</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Portfolio Hub. All rights reserved.</p>
            <p class="footer-links">
                <a href="index.php">Browse</a> • 
                <a href="login.php">Login</a> • 
                <a href="register.php">Register</a>
            </p>
        </div>
    </footer>

    <script src="portfolio.js"></script>
</body>
</html>