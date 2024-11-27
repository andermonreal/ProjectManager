<?php
session_start();

$adminFile = './admins.json';
$userFile = './users.json';

$admins = json_decode(file_get_contents($adminFile), true);
$users = json_decode(file_get_contents($userFile), true);

function procesarLogin($username, $password, $data)
{
    $passwordHash = hash('sha512', $password);
    foreach ($data as $user) {
        if ($user['username'] === $username && $user['password'] === $passwordHash) {
            return true;
        }
    }
    return false;
}

$usernameInput = $_POST['username'] ?? '';
$passwordInput = $_POST['password'] ?? '';

if (!empty($usernameInput) && !empty($passwordInput)) {
    if (procesarLogin($usernameInput, $passwordInput, $admins)) {
        $_SESSION['username'] = $usernameInput;
        $_SESSION['role'] = 'admin';
        header('Location: admin.php');
    } elseif (procesarLogin($usernameInput, $passwordInput, $users)) {
        $_SESSION['username'] = $usernameInput;
        $_SESSION['role'] = 'user';
        header('Location: dashboard.php');
    } else {
        echo "Username or passord incorrect";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Manager - Login</title>
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/styles.css">
</head>

<body>
    <header>
        <h1>Login to Project Manager</h1>
        <nav>
            <a href="index.php">Home</a>
            <a href="about_us.php">About Us</a>
            <a href="login.php">Login</a>
        </nav>
    </header>

    <main>
        <h2>Login</h2>
        <form id="loginForm" method="POST" action="">
            <div class="form-group">
                <label for="loginUsername">Username:</label>
                <input type="text" id="loginUsername" name="username" required>
            </div>
            <div class="form-group">
                <label for="loginPassword">Password:</label>
                <input type="password" id="loginPassword" name="password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </form>

        <p>Don't have an account? <a href="register.php" class="link">Register here</a></p>
    </main>

    <footer>
        <p>&copy; 2024 Project Manager. All rights reserved.</p>
    </footer>
</body>

</html>