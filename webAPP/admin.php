<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$userFile = './users.json';
$data = json_decode(file_get_contents($userFile), true);


// USERS //
$usersPerPage = 5;
$totalUsers = count($data);

$totalPagesUsers = ceil($totalUsers / $usersPerPage);

$page = isset($_GET['usersPage']) ? (int) $_GET['usersPage'] : 1;
$page = max(1, min($page, $totalPagesUsers));

$startIndex = ($page - 1) * $usersPerPage;

$currentUsers = array_slice($data, $startIndex, $usersPerPage);


// PROJECTS //
$projectsPerPage = 5;
$totalProjects = 0;

foreach ($data as $user) {
    $totalProjects += count($user['projects']);
}

$totalPagesProjects = ceil($totalProjects / $projectsPerPage);

$page = isset($_GET['projectsPage']) ? (int) $_GET['projectsPage'] : 1;
$page = max(1, min($page, $totalPagesProjects));

$startIndex = ($page - 1) * $projectsPerPage;

$currentProjects = [];
$currentCount = 0;

foreach ($data as $user) {
    foreach ($user['projects'] as $project) {
        if ($currentCount >= $startIndex && $currentCount < $startIndex + $projectsPerPage) {
            $currentProjects[] = [
                'username' => $user['username'],
                'project_name' => $project['project_name'],
                'deadline' => $project['deadline'],
                'status' => $project['status'],
                'team_members' => implode(', ', $project['team_members']),
            ];
        }
        $currentCount++;
    }
}

// ---- real stats + helpers ----
$activeProjects = 0; $pendingProjects = 0;
foreach ($data as $u) {
    foreach ($u['projects'] as $p) {
        if ($p['status'] === 'Completed') continue;
        if ($p['status'] === 'Pending') $pendingProjects++;
        else $activeProjects++;
    }
}
function statusBadge($s)
{
    $map = ['Completed' => 'badge-green', 'In Progress' => 'badge-blue', 'Pending' => 'badge-amber', 'Ongoing' => 'badge-violet'];
    return $map[$s] ?? '';
}
$adminInitial = strtoupper(substr($_SESSION['username'], 0, 1));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel · Project Manager</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/admin.css">

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const addUserBtn = document.getElementById('addUserBtn');
            const newUserSection = document.getElementById('newUser');
            addUserBtn.addEventListener('click', () => {
                const shown = newUserSection.style.display === 'block';
                newUserSection.style.display = shown ? 'none' : 'block';
                if (!shown) newUserSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
            });

            const sidebar = document.getElementById('sidebar');
            const scrim = document.getElementById('scrim');
            const menuBtn = document.getElementById('menuBtn');
            if (menuBtn) menuBtn.addEventListener('click', () => { sidebar.classList.add('open'); scrim.classList.add('show'); });
            if (scrim) scrim.addEventListener('click', () => { sidebar.classList.remove('open'); scrim.classList.remove('show'); });
        });
    </script>
</head>

<body>
    <div class="app">
        <div class="scrim" id="scrim"></div>

        <!-- Sidebar -->
        <aside class="sidebar" id="sidebar">
            <div class="side-brand">
                <a href="index.php" class="brand">
                    <span class="brand-mark">
                        <svg viewBox="0 0 24 24" fill="none"><path d="M4 6.5A2.5 2.5 0 0 1 6.5 4H11v16H6.5A2.5 2.5 0 0 1 4 17.5v-11Z" fill="currentColor" opacity=".9"/><path d="M13 4h4.5A2.5 2.5 0 0 1 20 6.5V11h-7V4Z" fill="currentColor" opacity=".65"/><path d="M13 13h7v4.5a2.5 2.5 0 0 1-2.5 2.5H13v-7Z" fill="currentColor"/></svg>
                    </span>
                    <span class="brand-name">Project<b>Manager</b></span>
                </a>
            </div>

            <nav class="side-section">
                <div class="side-label">Administration</div>
                <a href="admin.php" class="side-link active">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3l7 3v6c0 4.4-3 7.6-7 9-4-1.4-7-4.6-7-9V6l7-3Z"/></svg>
                    Admin Panel
                </a>
                <a href="admin.php#user-management" class="side-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="8" r="3.2"/><path d="M3.5 20c0-3 2.5-5 5.5-5s5.5 2 5.5 5"/><circle cx="17.5" cy="9" r="2.6"/><path d="M16 15.5c2.5.3 4.5 2.2 4.5 4.5"/></svg>
                    Users
                    <span class="tag"><?php echo $totalUsers; ?></span>
                </a>
                <a href="admin.php#project-management" class="side-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z"/></svg>
                    Projects
                </a>
            </nav>

            <nav class="side-section">
                <div class="side-label">General</div>
                <a href="dashboard.php" class="side-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/><rect x="14" y="12" width="7" height="9" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/></svg>
                    Dashboard
                </a>
                <a href="index.php" class="side-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 11l9-7 9 7"/><path d="M5 10v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-9"/></svg>
                    Home
                </a>
            </nav>

            <div class="side-foot">
                <div class="side-user">
                    <span class="avatar c6"><?php echo htmlspecialchars($adminInitial); ?></span>
                    <div class="meta">
                        <div class="n"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
                        <div class="r">Administrator</div>
                    </div>
                    <a href="logout.php" class="btn btn-ghost btn-sm" style="margin-left:auto;color:#9aa6bd" title="Log out">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M15 4h3a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-3"/><path d="M10 17l5-5-5-5"/><path d="M15 12H3"/></svg>
                    </a>
                </div>
            </div>
        </aside>

        <!-- Main -->
        <div class="main">
            <header class="topbar">
                <button class="icon-btn menu-btn" id="menuBtn" aria-label="Menu">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <div class="page-title">
                    Admin Panel
                    <small>System administration &amp; user management</small>
                </div>
                <div class="spacer"></div>
                <span class="role-pill admin" style="height:26px">
                    <svg viewBox="0 0 24 24" width="13" height="13" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3l7 3v6c0 4.4-3 7.6-7 9-4-1.4-7-4.6-7-9V6l7-3Z"/></svg>
                    Admin access
                </span>
                <button class="icon-btn" aria-label="Notifications"><span class="dot"></span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8a6 6 0 1 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/></svg>
                </button>
                <span class="avatar c6" style="--s:38px"><?php echo htmlspecialchars($adminInitial); ?></span>
            </header>

            <main class="page">
                <div class="section-title" style="margin-bottom:18px">
                    <div>
                        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?> 👋</h2>
                        <span class="hint">Here's what's happening across the platform today.</span>
                    </div>
                </div>

                <!-- Stats -->
                <section class="stat-grid">
                    <div class="stat">
                        <div class="ico i-indigo"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="8" r="3.2"/><path d="M3.5 20c0-3 2.5-5 5.5-5s5.5 2 5.5 5"/><circle cx="17.5" cy="9" r="2.6"/><path d="M16 15.5c2.5.3 4.5 2.2 4.5 4.5"/></svg></div>
                        <div class="label">Total Users</div>
                        <div class="value"><?php echo $totalUsers; ?></div>
                        <div class="trend up">Registered accounts</div>
                    </div>
                    <div class="stat">
                        <div class="ico i-violet"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z"/></svg></div>
                        <div class="label">Total Projects</div>
                        <div class="value"><?php echo $totalProjects; ?></div>
                        <div class="trend up">Across all teams</div>
                    </div>
                    <div class="stat">
                        <div class="ico i-blue"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg></div>
                        <div class="label">Active Projects</div>
                        <div class="value"><?php echo $activeProjects; ?></div>
                        <div class="trend up">In flight</div>
                    </div>
                    <div class="stat">
                        <div class="ico i-amber"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 8v4m0 4h.01"/></svg></div>
                        <div class="label">Pending Approvals</div>
                        <div class="value"><?php echo $pendingProjects; ?></div>
                        <div class="trend down">Awaiting review</div>
                    </div>
                </section>

                <!-- User management -->
                <section id="user-management" class="card">
                    <div class="card-head">
                        <div>
                            <h3>User Management</h3>
                            <div class="sub">Manage user accounts and access.</div>
                        </div>
                        <button id="addUserBtn" class="btn btn-primary btn-sm">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                            Add New User
                        </button>
                    </div>

                    <div class="table-wrap">
                        <table class="data">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($currentUsers as $i => $user):
                                    $c = ($i % 8) + 1; ?>
                                    <tr>
                                        <td>
                                            <div class="u">
                                                <span class="avatar c<?php echo $c; ?>"><?php echo htmlspecialchars(strtoupper(substr($user['username'], 0, 1))); ?></span>
                                                <div>
                                                    <div class="name"><?php echo htmlspecialchars($user['username']); ?></div>
                                                    <div class="mail"><?php echo htmlspecialchars($user['email']); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><?php echo htmlspecialchars($user['phone']); ?></td>
                                        <td><?php echo htmlspecialchars($user['address']); ?></td>
                                        <td><span class="role-pill member">Member</span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination">
                        <?php
                        $projectPage = isset($_GET['usersPage']) ? (int) $_GET['usersPage'] : 1;
                        if ($page > 1) {
                            echo '<a href="admin.php?usersPage=' . ($page - 1) . '&projectsPage=' . $projectPage . '">&laquo; Prev</a>';
                        }
                        for ($i = 1; $i <= $totalPagesUsers; $i++) {
                            $class = ($i == $page) ? 'active' : '';
                            echo '<a href="admin.php?usersPage=' . $i . '&projectsPage=' . $projectPage . '" class="' . $class . '">' . $i . '</a>';
                        }
                        if ($page < $totalPagesUsers) {
                            echo '<a href="admin.php?usersPage=' . ($page + 1) . '&projectsPage=' . $projectPage . '">Next &raquo;</a>';
                        }
                        ?>
                    </div>
                </section>

                <!-- Add user (RCE-vulnerable creation form) -->
                <section id="newUser" class="card" style="display:none;">
                    <div class="card-head">
                        <div class="add-user-head">
                            <span class="ico">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="10" cy="8" r="3.5"/><path d="M3.5 20c0-3.2 2.7-5.5 6.5-5.5"/><path d="M17 12v6m3-3h-6"/></svg>
                            </span>
                            <div>
                                <h3>Add New User</h3>
                                <div class="sub">Provision a new account on the platform.</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-pad">
                        <form action="admin.php" method="POST">
                            <div class="grid2">
                                <div class="field">
                                    <label for="username">Username</label>
                                    <input type="text" id="username" name="username" placeholder="jdoe" required>
                                </div>
                                <div class="field">
                                    <label for="email">Email</label>
                                    <input type="email" id="email" name="email" placeholder="jdoe@example.com" required>
                                </div>
                                <div class="field">
                                    <label for="phone">Phone</label>
                                    <input type="text" id="phone" name="phone" placeholder="555-123-4567" required>
                                </div>
                                <div class="field">
                                    <label for="address">Address</label>
                                    <input type="text" id="address" name="address" placeholder="123 Main St, City" required>
                                </div>
                            </div>
                            <div class="field">
                                <label for="password">Password</label>
                                <input type="password" id="password" name="password" placeholder="••••••••" required>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary btn-block btn-lg">Save New User</button>
                        </form>

                        <?php
                        if (isset($_POST['submit'])) {
                            $username = $_POST['username'];
                            $email = $_POST['email'];
                            $phone = $_POST['phone'];
                            $address = $_POST['address'];
                            $password = sha1($_POST['password']);

                            $userFile = './users.json';
                            $data = json_decode(file_get_contents($userFile), true);

                            $newUser = [
                                'username' => $username,
                                'email' => $email,
                                'phone' => $phone,
                                'address' => $address,
                                'password' => $password,
                                'projects' => []
                            ];

                            $data[] = $newUser;

                            file_put_contents($userFile, json_encode($data, JSON_PRETTY_PRINT));

                            $logMessage = "New user added: $username, email: $email, phone: $phone, address: $address";
                            exec("echo $logMessage >> ./user_creation.log");

                            echo '<div class="alert alert-success" style="margin-top:16px">';
                            echo '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="m8 12 3 3 5-6"/></svg>';
                            echo '<span>User <strong>' . htmlspecialchars($username) . '</strong> added successfully!</span></div>';
                        }
                        ?>
                    </div>
                </section>

                <!-- Project management -->
                <section id="project-management" class="card">
                    <div class="card-head">
                        <div>
                            <h3>Project Management</h3>
                            <div class="sub">Oversee every project across the organization.</div>
                        </div>
                    </div>

                    <div class="table-wrap">
                        <table class="data">
                            <thead>
                                <tr>
                                    <th>Owner</th>
                                    <th>Project Name</th>
                                    <th>Deadline</th>
                                    <th>Status</th>
                                    <th>Team Members</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($currentProjects as $i => $project):
                                    $c = ($i % 8) + 1; ?>
                                    <tr>
                                        <td>
                                            <div class="u">
                                                <span class="avatar c<?php echo $c; ?>" style="--s:28px"><?php echo htmlspecialchars(strtoupper(substr($project['username'], 0, 1))); ?></span>
                                                <span class="name"><?php echo htmlspecialchars($project['username']); ?></span>
                                            </div>
                                        </td>
                                        <td style="color:var(--text);font-weight:600"><?php echo htmlspecialchars($project['project_name']); ?></td>
                                        <td><?php echo htmlspecialchars(date('M j, Y', strtotime($project['deadline']))); ?></td>
                                        <td><span class="badge <?php echo statusBadge($project['status']); ?>"><?php echo htmlspecialchars($project['status']); ?></span></td>
                                        <td><?php echo htmlspecialchars($project['team_members']); ?></td>
                                        <td>
                                            <div class="actions-cell">
                                                <button class="btn btn-sm">Edit</button>
                                                <button class="btn btn-sm btn-danger">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="pagination">
                        <?php
                        $usersPage = isset($_GET['usersPage']) ? (int) $_GET['usersPage'] : 1;
                        if ($page > 1) {
                            echo '<a href="admin.php?usersPage=' . $usersPage . '&projectsPage=' . ($page - 1) . '">&laquo; Prev</a>';
                        }
                        for ($i = 1; $i <= $totalPagesProjects; $i++) {
                            $class = ($i == $page) ? 'active' : '';
                            echo '<a href="admin.php?usersPage=' . $usersPage . '&projectsPage=' . $i . '" class="' . $class . '">' . $i . '</a>';
                        }
                        if ($page < $totalPagesProjects) {
                            echo '<a href="admin.php?usersPage=' . $usersPage . '&projectsPage=' . ($page + 1) . '">Next &raquo;</a>';
                        }
                        ?>
                    </div>
                </section>
            </main>
        </div>
    </div>
</body>

</html>
