<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Manager - Welcome</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header>
        <h1>Welcome to Project Manager</h1>
        <nav>
            <a href="index.php"
                class="<?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>">Home</a>
            <a href="about_us.php">About Us</a>
            <?php
            if (isset($_SESSION['role'])) {
                if ($_SESSION['role'] === 'admin') {
                    echo '<a href="admin.php">Admin Panel</a>';
                }
                echo '<a href="dashboard.php">Dashboard</a>';
                echo '<a href="logout.php">Logout</a>';
            } else {
                echo '<a href="login.php">Login</a>';
            }
            ?>
        </nav>
    </header>

    <main>
        <h2>Manage Your Projects Like a Pro</h2>
        <p>With <strong>Project Manager</strong>, you can organize, monitor, and complete your tasks and projects
            efficiently.
            Track your deadlines, manage your teams, and achieve your goals with our platform.</p>

        <h3>Key Features</h3>
        <ul>
            <li>Easy project creation and management.</li>
            <li>Track tasks with deadlines and priority levels.</li>
            <li>Collaborate with your team in real-time.</li>
            <li>Fully customizable project workflows.</li>
            <li>View reports and analytics for your projects.</li>
            <li>Secure user authentication and data encryption.</li>
        </ul>

        <div id="testimonials">
            <h3>User Testimonials</h3>
        </div>

        <h3>See it in action!</h3>
        <div class="demo-container">
            <p>Click the video below to see a quick walkthrough of the platform:</p>
            <iframe width="560" height="315" src="https://www.youtube.com/embed/GLr8NjngjYo" frameborder="0"
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>

        </div>
    </main>

    <footer>
        <p>&copy; 2024 Project Manager. All rights reserved.</p>
    </footer>

    <script src="js/index.js"></script>
</body>

</html>