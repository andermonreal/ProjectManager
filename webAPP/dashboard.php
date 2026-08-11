<?php
session_start();

if (!isset($_SESSION['role'])) {
    header('Location: login.php');
    exit();
}

if ($_SESSION['role'] === 'user') {
    $userFile = './users.json';
} else {
    $userFile = './adminsCreds43Fb3r8723FDSbncv43.json';
}


if (!file_exists($userFile)) {
    die("El archivo de usuarios no existe.");
}

$users = json_decode(file_get_contents($userFile), true);

$currentUsername = $_SESSION['username'];
$currentUserProjects = [];

foreach ($users as $user) {
    if ($user['username'] === $currentUsername) {
        $currentUserProjects = $user['projects'];
        break;
    }
}

// ---- presentation helpers ----
function statusBadge($s)
{
    $map = [
        'Completed'   => 'badge-green',
        'In Progress' => 'badge-blue',
        'Pending'     => 'badge-amber',
        'Ongoing'     => 'badge-violet',
    ];
    return $map[$s] ?? '';
}
function statusProgress($s)
{
    switch ($s) {
        case 'Completed':   return 100;
        case 'Ongoing':     return 75;
        case 'In Progress': return 60;
        case 'Pending':     return 15;
        default:            return 40;
    }
}
function progGrad($s)
{
    return $s === 'Completed' ? 'g-green' : ($s === 'Pending' ? 'g-amber' : 'g-blue');
}

$statTotal = count($currentUserProjects);
$statDone = 0; $statProg = 0; $statPend = 0;
foreach ($currentUserProjects as $p) {
    if ($p['status'] === 'Completed') $statDone++;
    elseif ($p['status'] === 'Pending') $statPend++;
    else $statProg++;
}
$initial = strtoupper(substr($currentUsername, 0, 1));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard · Project Manager</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/dashboard.css">
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
                <div class="side-label">Workspace</div>
                <a href="dashboard.php" class="side-link active">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="9" rx="1.5"/><rect x="14" y="3" width="7" height="5" rx="1.5"/><rect x="14" y="12" width="7" height="9" rx="1.5"/><rect x="3" y="16" width="7" height="5" rx="1.5"/></svg>
                    Dashboard
                </a>
                <a href="dashboard.php#projects" class="side-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z"/></svg>
                    Projects
                    <span class="tag"><?php echo $statTotal; ?></span>
                </a>
                <a href="dashboard.php?dir=projects/<?php echo htmlspecialchars($currentUsername); ?>#files" class="side-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 3v5h5"/><path d="M6 3h8l5 5v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"/></svg>
                    Files
                </a>
                <a href="dashboard.php#" class="side-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="8" r="3.2"/><path d="M3.5 20c0-3 2.5-5 5.5-5s5.5 2 5.5 5"/><circle cx="17.5" cy="9" r="2.6"/><path d="M16 15.5c2.5.3 4.5 2.2 4.5 4.5"/></svg>
                    Team
                </a>
            </nav>

            <nav class="side-section">
                <div class="side-label">General</div>
                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <a href="admin.php" class="side-link">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3l7 3v6c0 4.4-3 7.6-7 9-4-1.4-7-4.6-7-9V6l7-3Z"/></svg>
                        Admin Panel
                    </a>
                <?php endif; ?>
                <a href="index.php" class="side-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 11l9-7 9 7"/><path d="M5 10v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-9"/></svg>
                    Home
                </a>
                <a href="about_us.php" class="side-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 11v5m0-8h.01"/></svg>
                    About
                </a>
            </nav>

            <div class="side-foot">
                <div class="side-user">
                    <span class="avatar c1"><?php echo htmlspecialchars($initial); ?></span>
                    <div class="meta">
                        <div class="n"><?php echo htmlspecialchars($currentUsername); ?></div>
                        <div class="r"><?php echo $_SESSION['role'] === 'admin' ? 'Administrator' : 'Team member'; ?></div>
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
                    Dashboard
                    <small>Welcome back, <?php echo htmlspecialchars($currentUsername); ?> 👋</small>
                </div>
                <div class="spacer"></div>
                <div class="search input-icon" style="width:280px">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><path d="m20 20-3-3"/></svg>
                    <input type="text" placeholder="Search projects, files…">
                </div>
                <button class="icon-btn" aria-label="Notifications"><span class="dot"></span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8a6 6 0 1 0-12 0c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.7 21a2 2 0 0 1-3.4 0"/></svg>
                </button>
                <span class="avatar c1" style="--s:38px"><?php echo htmlspecialchars($initial); ?></span>
            </header>

            <main class="page">
                <!-- Stats -->
                <section class="stat-grid">
                    <div class="stat">
                        <div class="ico i-indigo"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z"/></svg></div>
                        <div class="label">Total Projects</div>
                        <div class="value"><?php echo $statTotal; ?></div>
                        <div class="trend up">▲ Active workspace</div>
                    </div>
                    <div class="stat">
                        <div class="ico i-blue"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg></div>
                        <div class="label">In Progress</div>
                        <div class="value"><?php echo $statProg; ?></div>
                        <div class="trend up">On track</div>
                    </div>
                    <div class="stat">
                        <div class="ico i-green"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="m8 12 3 3 5-6"/></svg></div>
                        <div class="label">Completed</div>
                        <div class="value"><?php echo $statDone; ?></div>
                        <div class="trend up">Delivered</div>
                    </div>
                    <div class="stat">
                        <div class="ico i-amber"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 9v4m0 4h.01M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"/></svg></div>
                        <div class="label">Pending</div>
                        <div class="value"><?php echo $statPend; ?></div>
                        <div class="trend down">Needs attention</div>
                    </div>
                </section>

                <!-- Projects -->
                <section id="projects">
                    <div class="section-title">
                        <h2>Your Projects</h2>
                        <button class="btn btn-primary btn-sm" id="toggleAddProject">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                            New Project
                        </button>
                    </div>

                    <?php if (!empty($currentUserProjects)): ?>
                        <div class="project-grid" id="projectGrid">
                            <?php foreach ($currentUserProjects as $project):
                                $members = $project['team_members'];
                                $prog = statusProgress($project['status']);
                            ?>
                                <article class="project-card">
                                    <div class="pc-top">
                                        <div>
                                            <div class="pc-title"><?php echo htmlspecialchars($project['project_name']); ?></div>
                                            <div class="pc-key">PRJ-<?php echo strtoupper(substr(md5($project['project_name']), 0, 5)); ?></div>
                                        </div>
                                        <span class="badge <?php echo statusBadge($project['status']); ?>"><?php echo htmlspecialchars($project['status']); ?></span>
                                    </div>

                                    <div class="pc-meta">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4.5" width="18" height="16" rx="2"/><path d="M3 9h18M8 3v3M16 3v3"/></svg>
                                        Due <?php echo htmlspecialchars(date('M j, Y', strtotime($project['deadline']))); ?>
                                    </div>

                                    <div>
                                        <div class="pc-prog-label"><span>Progress</span><span><?php echo $prog; ?>%</span></div>
                                        <div class="progress <?php echo progGrad($project['status']); ?>"><span style="width:<?php echo $prog; ?>%"></span></div>
                                    </div>

                                    <div class="pc-foot">
                                        <div class="avatar-stack">
                                            <?php foreach (array_slice($members, 0, 4) as $i => $m):
                                                $c = ($i % 8) + 1; ?>
                                                <span class="avatar c<?php echo $c; ?>" style="--s:30px" title="<?php echo htmlspecialchars($m); ?>"><?php echo htmlspecialchars(strtoupper(substr($m, 0, 1))); ?></span>
                                            <?php endforeach; ?>
                                            <?php if (count($members) > 4): ?>
                                                <span class="avatar" style="--s:30px;background:#94a3b8">+<?php echo count($members) - 4; ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <span class="menu-dots">
                                            <svg viewBox="0 0 24 24" fill="currentColor"><circle cx="5" cy="12" r="1.6"/><circle cx="12" cy="12" r="1.6"/><circle cx="19" cy="12" r="1.6"/></svg>
                                        </span>
                                    </div>
                                </article>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="card card-pad" style="text-align:center;color:var(--muted)">
                            <p style="font-weight:600;color:var(--text-2)">You have no projects assigned yet.</p>
                            <p style="font-size:.9rem;margin-top:6px">Create your first project to get started.</p>
                        </div>
                    <?php endif; ?>
                </section>

                <!-- Add project (client-side) -->
                <section id="addProjectSection" class="card" style="display:none">
                    <div class="card-head">
                        <div>
                            <h3>Add New Project</h3>
                            <div class="sub">Spin up a new project board for your team.</div>
                        </div>
                    </div>
                    <div class="card-pad">
                        <form id="addProjectForm">
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:0 18px">
                                <div class="field">
                                    <label for="project_name">Project Name</label>
                                    <input type="text" name="project_name" id="project_name" placeholder="e.g. Website Redesign" required>
                                </div>
                                <div class="field">
                                    <label for="deadline">Deadline</label>
                                    <input type="date" name="deadline" id="deadline" required>
                                </div>
                            </div>
                            <div class="field">
                                <label for="team_members">Team Members <span style="color:var(--muted);font-weight:400">(comma separated)</span></label>
                                <input type="text" name="team_members" id="team_members" placeholder="Ada, Grace, Alan" required>
                            </div>
                            <div style="display:flex;gap:10px">
                                <button type="submit" class="btn btn-primary">Create Project</button>
                                <button type="button" class="btn btn-ghost" id="cancelAddProject">Cancel</button>
                            </div>
                        </form>
                    </div>
                </section>

                <!-- Files -->
                <section id="files" class="card">
                    <div class="card-head">
                        <div>
                            <h3>Project Files</h3>
                            <div class="sub">Browse the documents attached to your workspace.</div>
                        </div>
                        <a href="dashboard.php?dir=projects/<?php echo htmlspecialchars($currentUsername); ?>#files" class="btn btn-sm" id="showFilesLink">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 3h8l5 5v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"/><path d="M14 3v5h5"/></svg>
                            Show files
                        </a>
                    </div>
                    <div class="card-pad">
                        <?php
                        if (isset($_GET['dir'])) {
                            $dirPath = $_GET['dir'];

                            echo '<div class="filebar"><span class="breadcrumb">';
                            echo '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z"/></svg>';
                            echo htmlspecialchars($dirPath) . '</span></div>';

                            if (is_dir($dirPath)) {
                                // Directory listing
                                $files = scandir($dirPath);

                                echo '<ul class="file-list">';
                                foreach ($files as $file) {
                                    $filePath = $dirPath . '/' . $file;

                                    if (is_file($filePath)) {
                                        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                        $iconClass = in_array($ext, ['php', 'json', 'txt', 'log']) ? $ext : 'txt';
                                        $glyph = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 3v5h5"/><path d="M6 3h8l5 5v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"/></svg>';
                                        echo '<li><a href="dashboard.php?dir=' . urlencode($filePath) . '#files">';
                                        echo '<span class="fi ' . $iconClass . '">' . $glyph . '</span>';
                                        echo '<span class="fname">' . htmlspecialchars($file) . '</span></a></li>';
                                    }
                                }
                                echo '</ul>';
                            } elseif (is_file($dirPath) || strpos($dirPath, '://') !== false) {
                                // File / wrapper viewer — renders the requested resource
                                echo '<div class="file-view-wrap"><pre class="file-view">';
                                ob_start();
                                include $dirPath;
                                echo htmlspecialchars(ob_get_clean());
                                echo '</pre></div>';
                            } else {
                                echo '<div class="file-empty"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V7Z"/></svg><p>There are no files here.</p></div>';
                            }
                        } else {
                            echo '<div class="file-empty"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M6 3h8l5 5v11a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"/><path d="M14 3v5h5"/></svg><p>Click <strong>Show files</strong> to list your workspace documents.</p></div>';
                        }
                        ?>
                    </div>
                </section>
            </main>
        </div>
    </div>

    <script src="js/dashboard.js"></script>
</body>

</html>
