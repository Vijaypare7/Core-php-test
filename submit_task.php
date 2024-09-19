<?php
session_start();
require 'admin/includes/db.php';
$pdo = getDB();

if (!isset($_SESSION['user_id'])) {
    die('You need to be logged in to submit tasks.');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $start_time = $_POST['start_time'];
    $stop_time = $_POST['stop_time'];
    $notes = $_POST['notes'];
    $description = $_POST['description'];
    $user_id = $_SESSION['user_id'];

    if (empty($start_time) || empty($stop_time) || empty($notes) || empty($description)) {
        $error = 'All fields are required.';
    } elseif (!strtotime($start_time) || !strtotime($stop_time)) {
        $error = 'Invalid start or stop time format.';
    } else {
        try {
            $stmt = $pdo->prepare('INSERT INTO tasks (user_id, start_time, stop_time, notes, description) VALUES (:user_id, :start_time, :stop_time, :notes, :description)');
            $stmt->execute([
                'user_id' => $user_id,
                'start_time' => $start_time,
                'stop_time' => $stop_time,
                'notes' => $notes,
                'description' => $description
            ]);

            $success = 'Task submitted successfully!';
        } catch (PDOException $e) {
            $error = 'Database error: ' . htmlspecialchars($e->getMessage());
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Task</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Submit Task</h2>
    <br/>
    <div class="row">
        <div class="col-md-10"><a href="dashboard.php" class="btn btn-success">Dashboard</a></div>
        <div class="col-md-2"><a href="logout.php" class="btn btn-danger">Logout</a></div>
    </div>
    <br/>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if (isset($success)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
    <form method="post">
        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="datetime-local" id="start_time" name="start_time" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="stop_time">Stop Time</label>
            <input type="datetime-local" id="stop_time" name="stop_time" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea id="notes" name="notes" class="form-control" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary" onclick="validateForm(event)">Submit Task</button>
    </form>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
function validateForm(event) {
    const startTime = document.getElementById('start_time').value;
    const stopTime = document.getElementById('stop_time').value;

    if (new Date(stopTime) < new Date(startTime)) {
        alert('Stop Time must be greater than Start Time.');
        event.preventDefault();
    }
}
</script>
</body>
</html>
