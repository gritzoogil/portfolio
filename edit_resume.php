<?php
require_once 'config.php';

// Require login to access this page
requireLogin();

$user_id = $_SESSION['user_id'];
$success = '';
$error = '';

// Handle form submission (UPDATE)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize all inputs
    $full_name = sanitize($_POST['full_name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $location = sanitize($_POST['location']);
    $bio = sanitize($_POST['bio']);
    $skills = sanitize($_POST['skills']);
    $education = sanitize($_POST['education']);
    $experience = sanitize($_POST['experience']);
    $projects = sanitize($_POST['projects']);
    
    // Validation
    if (empty($full_name) || empty($email)) {
        $error = "Name and email are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } else {
        // Check if email is already taken by another user
        $dbconn = getDBConnection();
        
        $check_query = "SELECT id FROM users WHERE email = $1 AND id != $2";
        $check_result = pg_query_params($dbconn, $check_query, array($email, $user_id));
        
        if (pg_num_rows($check_result) > 0) {
            $error = "Email already taken by another user!";
        } else {
            // Update user data
            $update_query = "UPDATE users SET 
                full_name = $1, 
                email = $2, 
                phone = $3, 
                location = $4, 
                bio = $5, 
                skills = $6, 
                education = $7, 
                experience = $8, 
                projects = $9 
                WHERE id = $10";
            
            $result = pg_query_params($dbconn, $update_query, array(
                $full_name, $email, $phone, $location, $bio, 
                $skills, $education, $experience, $projects, $user_id
            ));
            
            if ($result) {
                $success = "Resume updated successfully!";
                // Update session name if changed
                $_SESSION['user_name'] = $full_name;
                $_SESSION['user_email'] = $email;
            } else {
                $error = "Failed to update resume. Please try again.";
            }
        }
        
        pg_close($dbconn);
    }
}

// Fetch current user data
$dbconn = getDBConnection();
$query = "SELECT * FROM users WHERE id = $1";
$result = pg_query_params($dbconn, $query, array($user_id));
$user = pg_fetch_assoc($result);
pg_close($dbconn);

if (!$user) {
    die("User not found!");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Resume - <?php echo htmlspecialchars($user['full_name']); ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">GBG</div>
            <div class="nav-menu">
                <a href="portfolio.php">Dashboard</a>
                <a href="edit_resume.php" class="active">Edit Resume</a>
                <a href="public_resume.php?id=<?php echo $user_id; ?>" target="_blank">View Public</a>
                <a href="logout.php" class="btn-logout">Logout</a>
            </div>
        </div>
    </nav>

    <section class="section">
        <div class="container">
            <div class="edit-header">
                <h1>Edit Your Resume</h1>
                <p class="subtitle">Update your information to keep your resume current</p>
            </div>

            <?php if ($error): ?>
                <div class="message error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="message success"><?php echo $success; ?></div>
            <?php endif; ?>

            <form method="POST" action="edit_resume.php" class="edit-form">
                <div class="form-section">
                    <h2>Personal Information</h2>
                    
                    <div class="form-group">
                        <label for="full_name">Full Name *</label>
                        <input type="text" id="full_name" name="full_name" 
                               value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="email">Email *</label>
                            <input type="email" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($user['email']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" id="phone" name="phone" 
                                   value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="location">Location</label>
                        <input type="text" id="location" name="location" 
                               value="<?php echo htmlspecialchars($user['location'] ?? ''); ?>"
                               placeholder="e.g., Batangas City, Philippines">
                    </div>
                </div>

                <div class="form-section">
                    <h2>About / Bio</h2>
                    <div class="form-group">
                        <label for="bio">Bio / Introduction</label>
                        <textarea id="bio" name="bio" rows="4" 
                                  placeholder="Tell us about yourself..."><?php echo htmlspecialchars($user['bio'] ?? ''); ?></textarea>
                    </div>
                </div>

                <div class="form-section">
                    <h2>Skills</h2>
                    <div class="form-group">
                        <label for="skills">Skills (comma-separated)</label>
                        <textarea id="skills" name="skills" rows="3" 
                                  placeholder="e.g., JavaScript, Python, SQL, Excel"><?php echo htmlspecialchars($user['skills'] ?? ''); ?></textarea>
                        <small>Separate skills with commas</small>
                    </div>
                </div>

                <div class="form-section">
                    <h2>Education</h2>
                    <div class="form-group">
                        <label for="education">Education</label>
                        <textarea id="education" name="education" rows="4" 
                                  placeholder="Degree, School, Year"><?php echo htmlspecialchars($user['education'] ?? ''); ?></textarea>
                    </div>
                </div>

                <div class="form-section">
                    <h2>Experience</h2>
                    <div class="form-group">
                        <label for="experience">Work Experience / Activities</label>
                        <textarea id="experience" name="experience" rows="5" 
                                  placeholder="List your work experience or relevant activities"><?php echo htmlspecialchars($user['experience'] ?? ''); ?></textarea>
                    </div>
                </div>

                <div class="form-section">
                    <h2>Projects</h2>
                    <div class="form-group">
                        <label for="projects">Projects</label>
                        <textarea id="projects" name="projects" rows="5" 
                                  placeholder="List your projects and descriptions"><?php echo htmlspecialchars($user['projects'] ?? ''); ?></textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">Save Changes</button>
                    <a href="portfolio.php" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </section>
</body>
</html>