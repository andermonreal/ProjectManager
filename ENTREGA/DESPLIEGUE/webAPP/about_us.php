<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Project Manager</title>
    <link rel="stylesheet" href="css/about_us.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header>
        <h1>About Us</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="about_us.php"
                class="<?php echo basename($_SERVER['PHP_SELF']) == 'about_us.php' ? 'active' : ''; ?>">About Us</a>
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
        <h2>Who We Are</h2>
        <p><strong>Project Manager</strong> is a leading platform designed to help teams and individuals manage their
            projects efficiently. Founded in 2023, we provide simple yet powerful tools for project management. Our team
            consists of experts in software development, design, and business operations, working together to deliver a
            seamless experience for our users.</p>

        <h2>Our Mission</h2>
        <p>Our mission is to empower teams of all sizes to reach their project goals faster and more effectively. We
            believe that good project management leads to better results and a happier team.</p>

        <h2>Our Values</h2>
        <ul>
            <li>Innovation: We strive to innovate and improve our tools continuously.</li>
            <li>Integrity: We maintain transparency and honesty in all our interactions.</li>
            <li>Collaboration: We believe in the power of teamwork to achieve extraordinary results.</li>
            <li>Customer Focus: Our users are at the heart of everything we do.</li>
        </ul>

        <h2>Meet Our Team</h2>
        <p>We have a diverse team of passionate individuals committed to providing the best project management
            experience. Here are a few key members:</p>
        <ul>
            <li><strong>Jane Doe</strong> - CEO: Visionary leader driving our mission forward.</li>
            <li><strong>John Smith</strong> - CTO: Tech expert overseeing product development.</li>
            <li><strong>Emily Johnson</strong> - CMO: Creative mind behind our marketing strategies.</li>
            <li><strong>Michael Brown</strong> - Head of Support: Ensuring our users receive the help they need.</li>
        </ul>

        <h2>Contact Us</h2>
        <p>If you have any questions or feedback, please feel free to reach out to us:</p>
        <ul>
            <li>Email: <a href="mailto:support@projectmanager.com">support@projectmanager.com</a></li>
            <li>Phone: +123 456 7890</li>
            <li>Address: 123 Main Street, City, Country</li>
        </ul>
    </main>

    <footer>
        <p>&copy; 2024 Project Manager. All rights reserved.</p>
    </footer>
</body>

</html>