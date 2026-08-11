<?php
session_start();
$loggedIn = isset($_SESSION['role']);
$isAdmin = $loggedIn && $_SESSION['role'] === 'admin';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About · Project Manager</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/about_us.css">
</head>

<body>
    <!-- Nav -->
    <nav class="site-nav">
        <a href="index.php" class="brand">
            <span class="brand-mark">
                <svg viewBox="0 0 24 24" fill="none"><path d="M4 6.5A2.5 2.5 0 0 1 6.5 4H11v16H6.5A2.5 2.5 0 0 1 4 17.5v-11Z" fill="currentColor" opacity=".9"/><path d="M13 4h4.5A2.5 2.5 0 0 1 20 6.5V11h-7V4Z" fill="currentColor" opacity=".65"/><path d="M13 13h7v4.5a2.5 2.5 0 0 1-2.5 2.5H13v-7Z" fill="currentColor"/></svg>
            </span>
            <span class="brand-name">Project<b>Manager</b></span>
        </a>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="about_us.php" class="active">About</a>
            <a href="index.php#features">Features</a>
            <?php if ($loggedIn): ?><a href="dashboard.php">Dashboard</a><?php endif; ?>
        </div>
        <div class="nav-cta">
            <?php if ($loggedIn): ?>
                <?php if ($isAdmin): ?><a href="admin.php" class="btn btn-ghost btn-sm">Admin</a><?php endif; ?>
                <a href="dashboard.php" class="btn btn-primary btn-sm">Open workspace</a>
                <a href="logout.php" class="btn btn-ghost btn-sm">Log out</a>
            <?php else: ?>
                <a href="login.php" class="btn btn-ghost btn-sm">Sign in</a>
                <a href="login.php" class="btn btn-primary btn-sm">Get started</a>
            <?php endif; ?>
        </div>
    </nav>

    <div class="site-main">
        <header class="about-hero">
            <span class="eyebrow"><span class="pill">Est. 2023</span> Our story</span>
            <h1>We help teams do their best work</h1>
            <p>Project Manager is a leading platform designed to help teams and individuals manage their projects efficiently. We build simple yet powerful tools trusted by thousands of teams worldwide.</p>
        </header>

        <!-- Mission -->
        <section class="section">
            <div class="feature-grid">
                <div class="feature">
                    <div class="fico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="4.5"/><circle cx="12" cy="12" r="1"/></svg></div>
                    <h3>Our Mission</h3>
                    <p>To empower teams of all sizes to reach their project goals faster and more effectively. Good project management leads to better results and a happier team.</p>
                </div>
                <div class="feature">
                    <div class="fico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3v18M5 8l7-5 7 5"/><path d="M5 8v8l7 5 7-5V8"/></svg></div>
                    <h3>Our Vision</h3>
                    <p>A world where every team, regardless of size, has access to the tools they need to turn ambitious ideas into shipped, real-world results.</p>
                </div>
                <div class="feature">
                    <div class="fico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s-7-4.5-7-10a4 4 0 0 1 7-2.5A4 4 0 0 1 19 11c0 5.5-7 10-7 10Z"/></svg></div>
                    <h3>What drives us</h3>
                    <p>Our users are at the heart of everything we do. We obsess over the details so your team can focus on the work that matters most.</p>
                </div>
            </div>
        </section>

        <!-- Values -->
        <section class="section">
            <div class="section-head"><h2>Our Values</h2><p>The principles that guide every decision we make.</p></div>
            <div class="value-grid">
                <div class="value">
                    <span class="vico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m13 2-9 11h7l-1 9 9-11h-7l1-9Z"/></svg></span>
                    <div><h3>Innovation</h3><p>We strive to innovate and continuously improve our tools to stay ahead of how modern teams work.</p></div>
                </div>
                <div class="value">
                    <span class="vico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3l7 3v6c0 4.4-3 7.6-7 9-4-1.4-7-4.6-7-9V6l7-3Z"/><path d="M9 12l2 2 4-4"/></svg></span>
                    <div><h3>Integrity</h3><p>We maintain transparency and honesty in all our interactions — with customers and with each other.</p></div>
                </div>
                <div class="value">
                    <span class="vico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="8" r="3.2"/><path d="M3.5 20c0-3 2.5-5 5.5-5s5.5 2 5.5 5"/><circle cx="17.5" cy="9" r="2.6"/><path d="M16 15.5c2.5.3 4.5 2.2 4.5 4.5"/></svg></span>
                    <div><h3>Collaboration</h3><p>We believe in the power of teamwork — both in the product we build and the way we build it.</p></div>
                </div>
                <div class="value">
                    <span class="vico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s-7-4.5-7-10a4 4 0 0 1 7-2.5A4 4 0 0 1 19 11c0 5.5-7 10-7 10Z"/></svg></span>
                    <div><h3>Customer Focus</h3><p>Every feature starts with a real customer problem. Your success is how we measure our own.</p></div>
                </div>
            </div>
        </section>

        <!-- Team -->
        <section class="section">
            <div class="section-head"><h2>Meet Our Team</h2><p>A diverse group of people passionate about great project management.</p></div>
            <div class="team-grid">
                <div class="member">
                    <span class="avatar c1">JD</span>
                    <div class="mname">Jane Doe</div>
                    <div class="mrole">Chief Executive Officer</div>
                    <p class="mbio">Visionary leader driving our mission forward.</p>
                </div>
                <div class="member">
                    <span class="avatar c2">JS</span>
                    <div class="mname">John Smith</div>
                    <div class="mrole">Chief Technology Officer</div>
                    <p class="mbio">Tech expert overseeing product development.</p>
                </div>
                <div class="member">
                    <span class="avatar c5">EJ</span>
                    <div class="mname">Emily Johnson</div>
                    <div class="mrole">Chief Marketing Officer</div>
                    <p class="mbio">Creative mind behind our marketing strategies.</p>
                </div>
                <div class="member">
                    <span class="avatar c4">MB</span>
                    <div class="mname">Michael Brown</div>
                    <div class="mrole">Head of Support</div>
                    <p class="mbio">Ensuring our users always get the help they need.</p>
                </div>
            </div>
        </section>

        <!-- Contact -->
        <section class="section">
            <div class="section-head"><h2>Contact Us</h2><p>Questions or feedback? We'd love to hear from you.</p></div>
            <div class="contact-card card">
                <div class="ci">
                    <div class="cico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="m3 7 9 6 9-6"/></svg></div>
                    <div class="cl">Email</div>
                    <div class="cv"><a href="mailto:support@projectmanager.com">support@projectmanager.com</a></div>
                </div>
                <div class="ci">
                    <div class="cico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 5c0 9 6 15 15 15l1.5-3.5-4-1.5-1.5 1.5a11 11 0 0 1-5-5l1.5-1.5L10 6 6.5 4.5 5 5Z"/></svg></div>
                    <div class="cl">Phone</div>
                    <div class="cv">+123 456 7890</div>
                </div>
                <div class="ci">
                    <div class="cico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21s-7-5.2-7-11a7 7 0 0 1 14 0c0 5.8-7 11-7 11Z"/><circle cx="12" cy="10" r="2.5"/></svg></div>
                    <div class="cl">Address</div>
                    <div class="cv">123 Main Street, City</div>
                </div>
            </div>
        </section>
    </div>

    <!-- Footer -->
    <footer class="site-footer">
        <div class="inner">
            <div>
                <a href="index.php" class="brand" style="margin-bottom:14px">
                    <span class="brand-mark">
                        <svg viewBox="0 0 24 24" fill="none"><path d="M4 6.5A2.5 2.5 0 0 1 6.5 4H11v16H6.5A2.5 2.5 0 0 1 4 17.5v-11Z" fill="currentColor" opacity=".9"/><path d="M13 4h4.5A2.5 2.5 0 0 1 20 6.5V11h-7V4Z" fill="currentColor" opacity=".65"/><path d="M13 13h7v4.5a2.5 2.5 0 0 1-2.5 2.5H13v-7Z" fill="currentColor"/></svg>
                    </span>
                    <span class="brand-name">Project<b>Manager</b></span>
                </a>
                <p class="muted">The focused workspace for teams who ship.</p>
            </div>
            <div><h5>Product</h5><a href="index.php#features">Features</a><a href="#">Integrations</a><a href="#">Pricing</a></div>
            <div><h5>Company</h5><a href="about_us.php">About</a><a href="#">Careers</a><a href="#">Blog</a></div>
            <div><h5>Legal</h5><a href="#">Privacy</a><a href="#">Terms</a><a href="#">Security</a></div>
        </div>
        <div class="bottom">&copy; 2024 Project Manager, Inc. All rights reserved.</div>
    </footer>
</body>

</html>
