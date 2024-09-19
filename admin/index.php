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
        <h1 class="text-center">Welcome Admin</h1>
        <div class="text-center mt-4">
            <a href="download_report.php" class="btn btn-warning">Download Task Report</a>
            <a href="create_user.php" class="btn btn-success">Create User</a>
            <a href="users.php" class="btn btn-primary">User list</a>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
    <?php
    $stmt = $pdo->prepare('
        SELECT tasks.*, users.first_name, users.last_name, users.email
        FROM tasks
        JOIN users ON tasks.user_id = users.id
    ');
    $stmt->execute();
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    
    <div class="container" style="background-color: aliceblue;">
    <h2 class="text-center">Task List</h2>
        <table class="table">
            <thead class="thead-dark">
                <tr>
                <th scope="col">#</th>
                <th scope="col">User Name</th>
                <th scope="col">Start Time</th>
                <th scope="col">End Time</th>
                <th scope="col">Notes</th>
                <th scope="col">Description</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(isset($tasks) && count($tasks) > 0){
                    foreach($tasks as $k => $task){ ?>
                        <tr>
                            <td><?php echo $k+1; ?></td>
                            <td><?php echo $task['first_name'] . ' ' . $task['last_name']. '('. $task['email'] .')'  ; ?></td>
                            <td><?php echo date('d-M-Y H:i:s', strtotime($task['start_time'])) ; ?></td>
                            <td><?php echo date('d-M-Y H:i:s', strtotime($task['stop_time'])) ; ?></td>
                            <td><?php echo $task['notes']; ?></td>
                            <td><?php echo $task['description']; ?></td>
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
