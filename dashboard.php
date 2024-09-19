<?php
include('header.php');
?>

<?php
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare('SELECT * FROM tasks WHERE user_id = :user_id');
$stmt->execute(['user_id' => $user_id]);
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="container" style="background-color: aliceblue;">
<h1>Task List</h1>

    <table id="TaskTable" class="table table-striped" style="width:100%">
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
<script>
    new DataTable('#TaskTable');
</script>
<?php
include('admin/footer.php');
?>