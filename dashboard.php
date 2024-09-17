<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5 p-5" style="background-color: aliceblue;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center">Dashboard</h2>
            <p class="text-center">Welcome to your dashboard!</p>
        </div>
    </div>
    <div class="row">
        <div class="col-md-10"><a href="submit_task.php" class="btn btn-success">Add Task</a></div>
        <div class="col-md-2"><a href="logout.php" class="btn btn-danger">Logout</a></div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>