<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require 'admin/includes/db.php';
$pdo = getDB();
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
<?php
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT * FROM tasks WHERE user_id = :user_id');
$stmt->execute(['user_id' => $user_id]);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container" style="background-color: aliceblue;">

    <table class="table">
        <thead class="thead-dark">
            <tr>
            <th scope="col">#</th>
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
                        <td><?php echo date('d-M-Y H:i:s', strtotime($task['start_time'])) ; ?></td>
                        <td><?php echo date('d-M-Y H:i:s', strtotime($task['stop_time'])) ; ?></td>
                        <td class="text-break"><?php echo $task['notes']; ?></td>
                        <td class="text-break"><?php echo $task['description']; ?></td>
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

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>