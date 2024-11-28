<?php
if (!isset($_SESSION["role"])) {
    header('Location: login.php');
    exit();
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
        <h1>Welcome, <span id="username">User</span>!</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="about_us.php">About Us</a>
            <a href="logout.php" id="logoutBtn">Logout</a>
        </nav>
    </header>

    <main>
        <h2>Your Projects</h2>
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
                <tr>
                    <td>Website Redesign</td>
                    <td>2024-11-01</td>
                    <td>In Progress</td>
                    <td>Alice, Bob</td>
                </tr>
                <tr>
                    <td>Mobile App Development</td>
                    <td>2024-12-15</td>
                    <td>Not Started</td>
                    <td>Charlie, David</td>
                </tr>
                <tr>
                    <td>SEO Optimization</td>
                    <td>2024-10-30</td>
                    <td>Completed</td>
                    <td>Emily, Frank</td>
                </tr>
                <tr>
                    <td>Content Creation</td>
                    <td>2024-10-20</td>
                    <td>In Progress</td>
                    <td>Grace, Henry</td>
                </tr>
                <tr>
                    <td>Social Media Strategy</td>
                    <td>2024-11-15</td>
                    <td>Not Started</td>
                    <td>Ivy, John</td>
                </tr>
            </tbody>
        </table>

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
    </main>

    <footer>
        <p>&copy; 2024 Project Manager. All rights reserved.</p>
    </footer>

    <script src="js/dashboard.js"></script>
</body>

</html>