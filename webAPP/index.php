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
    <title>Project Manager — Plan, track &amp; ship your work</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/index.css">
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
            <a href="index.php" class="active">Home</a>
            <a href="about_us.php">About</a>
            <a href="#features">Features</a>
            <?php if ($loggedIn): ?>
                <a href="dashboard.php">Dashboard</a>
            <?php endif; ?>
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
        <!-- Hero -->
        <header class="hero">
            <span class="eyebrow"><span class="pill">New</span> Timeline view &amp; automations are here</span>
            <h1>Manage projects like a <span class="grad">pro</span>,<br>from idea to delivery.</h1>
            <p class="lead">Project Manager brings your tasks, deadlines and team into one focused workspace — so nothing slips through the cracks and every project ships on time.</p>
            <div class="cta-row">
                <a href="<?php echo $loggedIn ? 'dashboard.php' : 'login.php'; ?>" class="btn btn-primary btn-lg">
                    <?php echo $loggedIn ? 'Go to dashboard' : 'Start for free'; ?>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M13 6l6 6-6 6"/></svg>
                </a>
                <a href="about_us.php" class="btn btn-lg">Learn more</a>
            </div>
            <div class="trust">Trusted by 12,000+ teams · No credit card required</div>

            <!-- Product mockup -->
            <div class="hero-preview reveal">
                <div class="frame">
                    <div class="bar"><i></i><i></i><i></i><span class="url">app.projectmanager.io/dashboard</span></div>
                    <div class="mock">
                        <div class="mside">
                            <div class="ml on"></div><div class="ml"></div><div class="ml"></div><div class="ml"></div>
                        </div>
                        <div class="mbody">
                            <div class="mrow"><div class="mtile"></div><div class="mtile"></div><div class="mtile"></div></div>
                            <div class="mbig"></div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Features -->
        <section class="section" id="features">
            <div class="section-head reveal">
                <h2>Everything your team needs to move faster</h2>
                <p>Powerful, flexible tools that adapt to the way your team already works.</p>
            </div>
            <div class="feature-grid">
                <div class="feature reveal">
                    <div class="fico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg></div>
                    <h3>Flexible boards</h3>
                    <p>Organize work your way with boards, lists and timelines that stay in sync automatically.</p>
                </div>
                <div class="feature reveal">
                    <div class="fico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4.5" width="18" height="16" rx="2"/><path d="M3 9h18M8 3v3M16 3v3"/></svg></div>
                    <h3>Deadline tracking</h3>
                    <p>Never miss a due date. Smart reminders keep every milestone visible and on schedule.</p>
                </div>
                <div class="feature reveal">
                    <div class="fico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="8" r="3.2"/><path d="M3.5 20c0-3 2.5-5 5.5-5s5.5 2 5.5 5"/><circle cx="17.5" cy="9" r="2.6"/><path d="M16 15.5c2.5.3 4.5 2.2 4.5 4.5"/></svg></div>
                    <h3>Real-time collaboration</h3>
                    <p>Assign tasks, mention teammates and share updates — everyone stays on the same page.</p>
                </div>
                <div class="feature reveal">
                    <div class="fico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19V5M4 19h16M8 15l3-4 3 2 4-6"/></svg></div>
                    <h3>Reports &amp; analytics</h3>
                    <p>Turn project data into insight with dashboards that reveal trends and bottlenecks.</p>
                </div>
                <div class="feature reveal">
                    <div class="fico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m13 2-9 11h7l-1 9 9-11h-7l1-9Z"/></svg></div>
                    <h3>Workflow automations</h3>
                    <p>Automate the busywork with custom rules that trigger on status changes and due dates.</p>
                </div>
                <div class="feature reveal">
                    <div class="fico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3l7 3v6c0 4.4-3 7.6-7 9-4-1.4-7-4.6-7-9V6l7-3Z"/><path d="M9 12l2 2 4-4"/></svg></div>
                    <h3>Enterprise security</h3>
                    <p>Secure authentication, granular roles and encryption keep your data protected end to end.</p>
                </div>
            </div>
        </section>

        <!-- Stats band -->
        <section class="section">
            <div class="stat-band reveal">
                <div class="s"><div class="n">12k+</div><div class="l">Active teams</div></div>
                <div class="s"><div class="n">1.8M</div><div class="l">Projects delivered</div></div>
                <div class="s"><div class="n">99.9%</div><div class="l">Uptime SLA</div></div>
                <div class="s"><div class="n">4.9/5</div><div class="l">Average rating</div></div>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="section">
            <div class="section-head reveal">
                <h2>Loved by teams everywhere</h2>
                <p>Here's what people are saying about Project Manager.</p>
            </div>
            <div id="testimonials"></div>
            <div class="logo-row" style="margin-top:36px">
                <span>Northwind</span><span>Acme Co</span><span>Globex</span><span>Initech</span><span>Umbrella</span><span>Hooli</span>
            </div>
        </section>

        <!-- CTA -->
        <section class="section">
            <div class="cta-band reveal">
                <h2>Ready to ship your next project?</h2>
                <p>Join thousands of teams who plan, track and deliver their best work with Project Manager.</p>
                <a href="<?php echo $loggedIn ? 'dashboard.php' : 'login.php'; ?>" class="btn btn-light btn-lg">
                    <?php echo $loggedIn ? 'Open your workspace' : 'Get started — it\'s free'; ?>
                </a>
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
                <p class="muted">The focused workspace for teams who ship. Plan, track and deliver — all in one place.</p>
            </div>
            <div>
                <h5>Product</h5>
                <a href="#features">Features</a><a href="#">Integrations</a><a href="#">Pricing</a><a href="#">Changelog</a>
            </div>
            <div>
                <h5>Company</h5>
                <a href="about_us.php">About</a><a href="#">Careers</a><a href="#">Blog</a><a href="#">Contact</a>
            </div>
            <div>
                <h5>Legal</h5>
                <a href="#">Privacy</a><a href="#">Terms</a><a href="#">Security</a><a href="#">Status</a>
            </div>
        </div>
        <div class="bottom">&copy; 2024 Project Manager, Inc. All rights reserved.</div>
    </footer>

    <script src="js/index.js"></script>
</body>

</html>
