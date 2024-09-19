<?php
session_start();
require 'admin/includes/db.php';
$pdo = getDB();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try{

        $stmt = $pdo->prepare('SELECT id, password, last_login, last_password_change, is_password_default FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password']) || md5($password) == $user['password'] ) {

            $updateStmt = $pdo->prepare('UPDATE users SET last_login = NOW() WHERE id = :id');
            $updateStmt->execute(['id' => $user['id']]);

            // Check if password needs to be changed
            $lastPasswordChange = new DateTime($user['last_password_change']);
            $now = new DateTime();
            $interval = $now->diff($lastPasswordChange);

            if ($interval->days >= 30 || $user['is_password_default']) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['change_password'] = true;
                header('Location: change_password.php');
                exit();
            } else {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['change_password'] = false;
                header('Location: dashboard.php');
                exit();
            }
        } else {
            $error = 'Invalid username or password';
        }

    } catch (PDOException $e) {
        echo 'Database error: ' . htmlspecialchars($e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h2 class="text-center">User Login</h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form method="post">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Login</button>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>