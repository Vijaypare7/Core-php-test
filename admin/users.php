<?php
include('header.php');
?>
<body>
    <?php
    $stmt = $pdo->prepare('SELECT * FROM users ');
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>
    
    <div class="container" style="background-color: aliceblue;">
    <h2 class="">Users List</h2>
        <table id="usersTable" class="table table-striped" style="width:100%">
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
    <script>
        new DataTable('#usersTable');
    </script>
<?php 
include('footer.php');
?>
