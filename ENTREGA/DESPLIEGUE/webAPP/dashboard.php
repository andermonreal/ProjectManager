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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Project Manager</title>
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="about_us.php">About Us</a>
            <?php
            if (isset($_SESSION['role'])) {
                if ($_SESSION['role'] === 'admin') {
                    echo '<a href="admin.php">Admin Panel</a>';
                }
            }
            ?>
            <a href="dashboard.php"
                class="<?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">Dashboard</a>
            <a href="logout.php" id="logoutBtn">Logout</a>
        </nav>
    </header>

    <main>
        <div id="table-container">
            <h2>Your Projects</h2>
            <?php if (!empty($currentUserProjects)): ?>
                <table id="projectsTable" border="1">
                    <thead>
                        <tr>
                            <th>Project Name</th>
                            <th>Deadline</th>
                            <th>Status</th>
                            <th>Team Members</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($currentUserProjects as $project): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($project['project_name']); ?></td>
                                <td><?php echo htmlspecialchars($project['deadline']); ?></td>
                                <td><?php echo htmlspecialchars($project['status']); ?></td>
                                <td><?php echo htmlspecialchars(implode(', ', $project['team_members'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>You have no projects assigned.</p>
            <?php endif; ?>
        </div>

        <div id="new-project-container">
            <h3>Add New Project</h3>
            <form id="addProjectForm">
                <label for="project_name">Project Name:</label><br>
                <input type="text" name="project_name" id="project_name" required><br><br>

                <label for="deadline">Deadline:</label><br>
                <input type="date" name="deadline" id="deadline" required><br><br>

                <label for="team_members">Team Members (comma separated):</label><br>
                <input type="text" name="team_members" id="team_members" required><br><br>

                <button type="submit">Add Project</button>
            </form>
        </div>

        <div id="files-container">

            <a href="dashboard.php?dir=projects/<?php echo $_SESSION['username']; ?>" id="showFilesLink"
                onclick="disableAndRedirect(event)">
                <button id="showFiles">Show files</button>
            </a>

            <script>
                function disableAndRedirect(event) {
                    event.preventDefault();

                    var link = document.getElementById("showFilesLink");
                    link.style.pointerEvents = "none";

                    var button = document.getElementById("showFiles");
                    button.disabled = true;

                    window.location.href = link.href;
                }
            </script>

            <?php
            if (isset($_GET['dir'])) {
                echo "<h2>Archivos del usuario</h2>";
                echo "<ul>";
                $dirPath = isset($_GET['dir']) ? $_GET['dir'] : 'projects/' . $_SESSION['username'];

                if (is_dir($dirPath)) {
                    $files = scandir($dirPath);

                    foreach ($files as $file) {
                        $filePath = $dirPath . '/' . $file;

                        if (is_file($filePath)) {
                            echo "<li><a href=\"#\" onclick=\"loadFileContent('$filePath'); return false;\">$file</a></li>";
                        }
                    }
                    echo "</ul>";

                    echo '<iframe id="fileContent" width="100%" height="600px" style="display:none;" src="about:blank"></iframe>';
                } else {
                    echo "There are no files here";
                }
            }
            ?>
        </div>


        <script>
            function loadFileContent(filePath) {
                const iframe = document.getElementById('fileContent');

                fetch(filePath)
                    .then(response => response.text())
                    .then(data => {
                        const doc = iframe.contentWindow.document;
                        doc.open();
                        doc.write("<pre>" + data + "</pre>");
                        doc.close();

                        iframe.style.display = 'block';
                    })
                    .catch(error => {
                        iframe.style.display = 'none';
                    });
            }

            const iframe = document.getElementById('fileContent');
            iframe.onload = function () {
                if (iframe.contentDocument && iframe.contentDocument.body.innerHTML.trim().length > 0) {
                    iframe.style.display = 'block';
                } else {
                    iframe.style.display = 'none';
                }
            };
        </script>
    </main>

    <footer>
        <p>&copy; 2024 Project Manager. All rights reserved.</p>
    </footer>

    <script src="js/dashboard.js"></script>
</body>

</html>