<?php
include('header.php');
?>
<body>

    <?php
    $stmt = $pdo->prepare('SELECT count(*) AS total FROM users ');
    $stmt->execute();
    $users = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt = $pdo->prepare('SELECT count(*)  AS total FROM tasks ');
    $stmt->execute();
    $tasks = $stmt->fetch(PDO::FETCH_ASSOC);

    ?>

    <div class="container">
    <h1 class="">Dashboard</h1>
        <div class="card-deck">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Users <p class="card-text text-center"><?php echo $users['total']; ?></p></h5>
                    
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Tasks <p class="card-text text-center"><?php echo $tasks['total']; ?></p></h5>
                </div>
            </div>
        </div>
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
    <h2 class="">Task List</h2>
        <table id="tasksTable" class="table table-striped" style="width:100%">
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
<script>
    new DataTable('#tasksTable');
</script>

<?php 
include('footer.php');
?>
    <!-- Bootstrap JS and dependencies -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html> -->
