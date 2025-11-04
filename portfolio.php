<?php
require_once 'config.php';

// Require login to view this page
requireLogin();

$user_name = $_SESSION['user_name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - Gil Bryan Guillermo</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand">GBG</div>
            <div class="nav-menu">
                <a href="portfolio.php">Dashboard</a>
                <a href="edit_resume.php">Edit Resume</a>
                <a href="public_resume.php?id=<?php echo $user_id; ?>" target="_blank">View Public</a>
                <a href="logout.php" class="btn-logout">Logout</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <div class="hero-content">
                <p class="welcome-text">Welcome, <?php echo htmlspecialchars($user_name); ?>!</p>
                <h1>Gil Bryan O. Guillermo</h1>
                <h2>Computer Science Student | Data Analyst | Aspiring Developer</h2>
                <p class="hero-description">
                    3rd Year BS Computer Science student passionate about data analysis, 
                    web development, and software engineering.
                </p>
                <div class="hero-buttons">
                    <a href="#contact" class="btn-primary">Get in Touch</a>
                    <a href="#projects" class="btn-secondary">View Projects</a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section">
        <div class="container">
            <h2 class="section-title">About Me</h2>
            <div class="about-content">
                <p>
                    I am a 3rd-year Computer Science student at Batangas State University, 
                    currently exploring multiple domains including data analysis, web development, 
                    and software engineering. My journey in tech has led me to work on various 
                    personal projects involving SQL databases, data visualization with Tableau, 
                    and creating interactive dashboards.
                </p>
                <p>
                    Beyond academics, I'm actively participating in a game development contest 
                    and a space business innovation contest, constantly pushing my boundaries 
                    and learning new technologies.
                </p>
            </div>
        </div>
    </section>

    <!-- Skills Section -->
    <section id="skills" class="section section-alt">
        <div class="container">
            <h2 class="section-title">Technical Skills</h2>
            <div class="skills-grid">
                <div class="skill-category">
                    <h3>Programming Languages</h3>
                    <div class="skill-tags">
                        <span class="skill-tag">JavaScript</span>
                        <span class="skill-tag">Python</span>
                        <span class="skill-tag">C#</span>
                        <span class="skill-tag">C++</span>
                        <span class="skill-tag">PHP</span>
                    </div>
                </div>
                
                <div class="skill-category">
                    <h3>Databases</h3>
                    <div class="skill-tags">
                        <span class="skill-tag">SQL Server</span>
                        <span class="skill-tag">MySQL</span>
                        <span class="skill-tag">PostgreSQL</span>
                    </div>
                </div>
                
                <div class="skill-category">
                    <h3>Data Analysis & Visualization</h3>
                    <div class="skill-tags">
                        <span class="skill-tag">Excel (Advanced)</span>
                        <span class="skill-tag">Tableau</span>
                        <span class="skill-tag">Data Cleaning</span>
                    </div>
                </div>
                
                <div class="skill-category">
                    <h3>Design & Development</h3>
                    <div class="skill-tags">
                        <span class="skill-tag">Figma</span>
                        <span class="skill-tag">HTML/CSS</span>
                        <span class="skill-tag">Web Development</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section id="projects" class="section">
        <div class="container">
            <h2 class="section-title">Projects</h2>
            <div class="projects-grid">
                <div class="project-card">
                    <h3>COVID-19 Data Exploration</h3>
                    <p class="project-date">October 2024</p>
                    <p>
                        Analyzed global COVID-19 data using SQL to determine infection, mortality, 
                        and vaccination rates by country and continent. Employed complex SQL techniques, 
                        including CTEs, temp tables, and window functions.
                    </p>
                    <div class="project-tech">
                        <span>SQL</span>
                        <span>Data Analysis</span>
                    </div>
                </div>

                <div class="project-card">
                    <h3>Nashville Housing Data Cleaning</h3>
                    <p class="project-date">October 2024</p>
                    <p>
                        Cleaned and standardized Nashville housing data using SQL by creating staging tables, 
                        formatting dates, and handling missing values. Used CTEs and row numbering to identify 
                        and remove duplicate records.
                    </p>
                    <div class="project-tech">
                        <span>SQL</span>
                        <span>Data Cleaning</span>
                    </div>
                </div>

                <div class="project-card">
                    <h3>Bike Sales Dashboard</h3>
                    <p class="project-date">November 2024</p>
                    <p>
                        Created an interactive Excel dashboard analyzing bike sales by cleaning and standardizing data, 
                        adding age brackets, and using pivot tables to calculate insights such as average income per purchase 
                        and age distribution.
                    </p>
                    <div class="project-tech">
                        <span>Excel</span>
                        <span>Pivot Tables</span>
                        <span>Dashboard</span>
                    </div>
                </div>

                <div class="project-card">
                    <h3>Airbnb Dashboard & Price Analysis</h3>
                    <p class="project-date">November 2024</p>
                    <p>
                        Analyzed Airbnb listing data to visualize price distribution and revenue trends. 
                        Created an interactive dashboard with map visualization for price per zip code and 
                        integrated data filters for easy comparison across regions.
                    </p>
                    <div class="project-tech">
                        <span>Tableau</span>
                        <span>Data Visualization</span>
                    </div>
                </div>

                <div class="project-card">
                    <h3>COVID-19 Data Dashboard</h3>
                    <p class="project-date">November 2024</p>
                    <p>
                        Created an interactive Tableau dashboard to analyze global COVID-19 data, focusing on 
                        infection and mortality rates. Included timeline chart of infection rates across key countries 
                        to track pandemic progression.
                    </p>
                    <div class="project-tech">
                        <span>Tableau</span>
                        <span>Data Visualization</span>
                    </div>
                </div>

                <div class="project-card highlight">
                    <h3>Game Development Contest</h3>
                    <p class="project-date">Ongoing - 2025</p>
                    <p>
                        Currently participating in a game development contest, applying programming skills 
                        and creative problem-solving to build an interactive gaming experience.
                    </p>
                    <div class="project-tech">
                        <span>Game Dev</span>
                        <span>C#/C++</span>
                    </div>
                </div>

                <div class="project-card highlight">
                    <h3>Space Business Innovation Contest</h3>
                    <p class="project-date">Ongoing - 2025</p>
                    <p>
                        Participating in a space business innovation contest, exploring innovative solutions 
                        and business models in the space technology sector.
                    </p>
                    <div class="project-tech">
                        <span>Innovation</span>
                        <span>Business</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Education Section -->
    <section id="education" class="section section-alt">
        <div class="container">
            <h2 class="section-title">Education</h2>
            <div class="education-card">
                <h3>Bachelor of Science in Computer Science</h3>
                <p class="education-school">Batangas State University, Philippines</p>
                <p class="education-year">3rd Year, 1st Semester (Current)</p>
                <p class="education-location">Batangas City, Batangas 4200</p>
                <div class="coursework">
                    <h4>Relevant Coursework:</h4>
                    <p>
                        Database Management Systems, Computer Networking, 
                        Object-Oriented Programming, Data Structures & Algorithms
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section">
        <div class="container">
            <h2 class="section-title">Get In Touch</h2>
            <div class="contact-content">
                <div class="contact-info">
                    <div class="contact-item">
                        <strong>Email:</strong>
                        <a href="mailto:guillermoocinagil@gmail.com">guillermoocinagil@gmail.com</a>
                    </div>
                    <div class="contact-item">
                        <strong>Phone:</strong>
                        <a href="tel:+639611400791">+63 961 140 0791</a>
                    </div>
                    <div class="contact-item">
                        <strong>Location:</strong>
                        <span>Batangas City, Batangas 4200</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 Gil Bryan O. Guillermo. All rights reserved.</p>
        </div>
    </footer>

    <script src="portfolio.js"></script>
</body>
</html>