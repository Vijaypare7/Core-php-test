<?php

session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

require 'includes/db.php';
$pdo = getDB();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .dashboard-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1 class="text-center"> Admin</h1>
        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-primary">Dashboard</a>
            <a href="create_user.php" class="btn btn-success">Create User</a>
            <a href="users.php" class="btn btn-secondary">User list</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
    <?php
    $stmt = $pdo->prepare('SELECT * FROM users ');
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    
    <div class="container" style="background-color: aliceblue;">
    <h2 class="text-center">Users List</h2>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                <th scope="col">#</th>
                <th scope="col">User Name</th>
                <th scope="col">Email</th>
                <th scope="col">Phone</th>
                <th scope="col">Last login</th>
                <th scope="col">Last Password Change</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(isset($users) && count($users) > 0){
                    foreach($users as $k => $user){ ?>
                        <tr>
                            <td><?php echo $k+1; ?></td>
                            <td><?php echo $user['first_name'] . ' ' . $user['last_name']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['phone']; ?></td>
                            <td><?php echo $user['last_login'] ? date('d-M-Y H:i:s', strtotime($user['last_login'])) : 'No last login date available' ; ?></td>
                            <td><?php echo $user['last_password_change'] ? date('d-M-Y H:i:s', strtotime($user['last_password_change'])) : 'No last password change date available' ; ?></td>
                        </tr>
                <?php }
                }else{ ?>
                    <tr class="text-center">
                        <td colspan='5'> No records found! </td>
                    </tr>
                <?php }
                ?>
            </tbody>
        </table>

    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
