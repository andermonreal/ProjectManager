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
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator - Project Manager</title>
    <link rel="stylesheet" href="css/admin.css">
    <link rel="stylesheet" href="css/styles.css">

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const addUserBtn = document.getElementById('addUserBtn');
            const newUserSection = document.getElementById('newUser');

            addUserBtn.addEventListener('click', () => {
                if (newUserSection.style.display === 'none' || newUserSection.style.display === '') {
                    newUserSection.style.display = 'block';
                } else {
                    newUserSection.style.display = 'none';
                }
            });
        });
    </script>
</head>

<body>
    <header>
        <h1>Welcome, <span id="username"><?php echo htmlspecialchars($_SESSION['username']); ?></span>!</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="about_us.php">About Us</a>
            <a href="admin.php"
                class="<?php echo basename($_SERVER['PHP_SELF']) == 'admin.php' ? 'active' : ''; ?>">Admin Panel</a>
            <a href="dashboard.php">Dashboard</a>
            <a href="logout.php" id="logoutBtn">Logout</a>
        </nav>
    </header>

    <main>
        <h2>Admin Dashboard</h2>
        <p>Welcome to the admin panel. Below are the system statistics:</p>

        <section id="dashboard-stats">
            <div class="stat-card">
                <h3>Total Users</h3>
                <p>1200</p>
            </div>
            <div class="stat-card">
                <h3>Total Projects</h3>
                <p>350</p>
            </div>
            <div class="stat-card">
                <h3>Active Projects</h3>
                <p>50</p>
            </div>
            <div class="stat-card">
                <h3>Pending Approvals</h3>
                <p>15</p>
            </div>
        </section>

        <section id="user-management">
            <h2>User Management</h2>
            <p>Manage user accounts below:</p>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($currentUsers as $user) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['phone']); ?></td>
                            <td><?php echo htmlspecialchars($user['address']); ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>

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


        <section id="project-management">
            <h2>Project Management</h2>
            <p>Manage your projects below:</p>
            <table>
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Project Name</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th>Team Members</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($currentProjects as $project) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($project['username']); ?></td>
                            <td><?php echo htmlspecialchars($project['project_name']); ?></td>
                            <td><?php echo htmlspecialchars($project['deadline']); ?></td>
                            <td><?php echo htmlspecialchars($project['status']); ?></td>
                            <td><?php echo htmlspecialchars($project['team_members']); ?></td>
                            <td class="actions">
                                <button>Edit</button>
                                <button>Delete</button>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>

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

        <button id="addUserBtn">Add New User</button>

        <section id="newUser" style="display:none;">
            <h2>Add New User</h2>
            <form action="admin.php" method="POST">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required><br><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br><br>

                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" required><br><br>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required><br><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br><br>

                <button type="submit" name="submit">Save New User</button>
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

                if (file_put_contents($userFile, json_encode($data, JSON_PRETTY_PRINT))) {
                    echo "<p>User added successfully!</p>";
                    $logMessage = "New user added: $username, email: $email, phone: $phone, address: $address";

                    exec("echo $logMessage >> ./user_creation.log");
                } else {
                    echo "<p>Failed to add user. Please try again.</p>";
                }
            }
            ?>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 Project Manager. All rights reserved.</p>
    </footer>
</body>

</html>