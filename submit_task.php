<?php
include('header.php');

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



<div class="container mt-5">
    <h2>Submit Task</h2>
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
<?php
include('admin/footer.php');
?>
