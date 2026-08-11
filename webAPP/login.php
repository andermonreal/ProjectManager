<?php
session_start();

$loginError = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameInput = $_POST['username'] ?? '';
    $passwordInput = $_POST['password'] ?? '';

    $adminFile = './adminsCreds43Fb3r8723FDSbncv43.json';
    $userFile = './users.json';

    $admins = json_decode(file_get_contents($adminFile), true);
    $users = json_decode(file_get_contents($userFile), true);

    function procesarLogin($username, $password, $data)
    {
        foreach ($data as $user) {
            $passwordHash = sha1($password);
            if ($user['username'] === $username && $passwordHash === $user['password']) {
                return true;
            }
        }
        return false;
    }

    if (!empty($usernameInput) && !empty($passwordInput)) {
        if (procesarLogin($usernameInput, $passwordInput, $admins)) {
            $_SESSION['username'] = $usernameInput;
            $_SESSION['role'] = 'admin';
            header('Location: admin.php');
            exit();
        } elseif (procesarLogin($usernameInput, $passwordInput, $users)) {
            $_SESSION['username'] = $usernameInput;
            $_SESSION['role'] = 'user';
            header('Location: dashboard.php');
            exit();
        }
    }
    $loginError = true;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign in · Project Manager</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/login.css">
</head>

<body>
    <div class="auth">
        <!-- Branded panel -->
        <aside class="auth-aside">
            <a href="index.php" class="brand">
                <span class="brand-mark">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M4 6.5A2.5 2.5 0 0 1 6.5 4H11v16H6.5A2.5 2.5 0 0 1 4 17.5v-11Z" fill="currentColor" opacity=".9"/><path d="M13 4h4.5A2.5 2.5 0 0 1 20 6.5V11h-7V4Z" fill="currentColor" opacity=".65"/><path d="M13 13h7v4.5a2.5 2.5 0 0 1-2.5 2.5H13v-7Z" fill="currentColor"/></svg>
                </span>
                <span class="brand-name">Project<b>Manager</b></span>
            </a>

            <div class="pitch">
                <h2>Ship projects on time, every time.</h2>
                <p>Plan work, track deadlines and keep your whole team aligned in one calm, focused workspace.</p>

                <div class="auth-quote">
                    <p>“We cut our delivery delays in half within a quarter. Project Manager is now the backbone of every sprint we run.”</p>
                    <div class="who">
                        <span class="avatar c3">SL</span>
                        <div>
                            <div class="n">Sarah Lee</div>
                            <div class="r">Head of Delivery · Northwind</div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Form -->
        <main class="auth-main">
            <div class="auth-card">
                <a href="index.php" class="brand">
                    <span class="brand-mark">
                        <svg viewBox="0 0 24 24" fill="none"><path d="M4 6.5A2.5 2.5 0 0 1 6.5 4H11v16H6.5A2.5 2.5 0 0 1 4 17.5v-11Z" fill="currentColor" opacity=".9"/><path d="M13 4h4.5A2.5 2.5 0 0 1 20 6.5V11h-7V4Z" fill="currentColor" opacity=".65"/><path d="M13 13h7v4.5a2.5 2.5 0 0 1-2.5 2.5H13v-7Z" fill="currentColor"/></svg>
                    </span>
                    <span class="brand-name">Project<b>Manager</b></span>
                </a>

                <h1>Welcome back</h1>
                <p class="muted">Sign in to your workspace to continue.</p>

                <?php if ($loginError): ?>
                    <div class="alert alert-error" style="margin-bottom:20px">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 8v4m0 4h.01"/></svg>
                        <span>Invalid username or password. Please try again.</span>
                    </div>
                <?php endif; ?>

                <form method="POST" action="">
                    <div class="field">
                        <label for="loginUsername">Username</label>
                        <div class="input-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 20c0-3.3 3.6-6 8-6s8 2.7 8 6"/></svg>
                            <input type="text" id="loginUsername" name="username" placeholder="e.g. jdoe" required autofocus>
                        </div>
                    </div>

                    <div class="field">
                        <label for="loginPassword">Password</label>
                        <div class="input-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="10" width="16" height="10" rx="2"/><path d="M8 10V7a4 4 0 0 1 8 0v3"/></svg>
                            <input type="password" id="loginPassword" name="password" placeholder="••••••••" required>
                        </div>
                    </div>

                    <div class="auth-row">
                        <label><input type="checkbox" name="remember"> Remember me</label>
                        <a href="#">Forgot password?</a>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg btn-block">Sign in</button>
                </form>

                <p class="auth-alt">Don't have an account? <a href="#">Contact your administrator</a></p>

                <div class="auth-badge">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 3l7 3v6c0 4.4-3 7.6-7 9-4-1.4-7-4.6-7-9V6l7-3Z"/><path d="M9 12l2 2 4-4"/></svg>
                    Secured with 256-bit encryption
                </div>
            </div>
        </main>
    </div>
</body>

</html>
