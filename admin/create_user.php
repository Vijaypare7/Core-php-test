<?php
include('header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    $errors = validateUserInput($firstName, $lastName, $email, $phone);

    if (isset($_POST['auto_generate_password']) && $_POST['auto_generate_password']) {
        $password = $_POST['generated_password'];
    }else{
        $password = $_POST['password'];
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if (empty($errors)) {
        $data = createUser($firstName, $lastName, $email, $phone, $hashedPassword);
        if(is_string($data)){
            $res = json_decode($data);
            $errors[] = $res->error;
        }else {
            $message = "User created successfully";
        }
    }
}
?>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h1>Create User</h1>
            </div>
        </div>

        <?php if (!empty($message)): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($message); ?></div>
        <?php endif; ?>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form action="create_user.php" method="POST">
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo htmlspecialchars($firstName ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo htmlspecialchars($lastName ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($email ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" class="form-control" value="<?php echo htmlspecialchars($phone ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <div class="input-group">
                    <input type="password" id="password" name="password" class="form-control" value="<?php echo htmlspecialchars($password ?? ''); ?>">
                    <div class="input-group-append">
                        <span class="input-group-text" id="eye-icon" onclick="togglePasswordVisibility()">
                            <i class="fas fa-eye"></i>
                        </span>
                    </div>
                </div>
                <!-- Hidden field to store the generated password -->
                <input type="hidden" id="generated_password" name="generated_password">
            </div>
            <div class="form-group form-check">
                <input type="checkbox" id="auto_generate_password" name="auto_generate_password" class="form-check-input" onclick="togglePasswordGeneration()">
                <label for="auto_generate_password" class="form-check-label">Auto-generate password</label>
            </div>
            <button type="submit" class="btn btn-primary">Create User</button>
        </form>

    </div>

<?php 
include('footer.php');
?>
<script>
    function togglePasswordGeneration() {
        var checkbox = document.getElementById('auto_generate_password');
        var passwordField = document.getElementById('password');
        var password = document.getElementById('generated_password');

        if (checkbox.checked) {
            // Generate password
            var generatedPassword = generatePassword();
            passwordField.value = generatedPassword;
            passwordField.disabled = true;
            password.value = generatedPassword; 
        } else {
            passwordField.disabled = false;
            passwordField.value = '';
            password.value = '';
        }
    }

    function generatePassword() {
        var length = 12;
        var charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()";
        var retVal = "";
        for (var i = 0, n = charset.length; i < length; ++i) {
            retVal += charset.charAt(Math.floor(Math.random() * n));
        }
        return retVal;
    }

    function togglePasswordVisibility() {
        var passwordField = document.getElementById('password');
        var eyeIcon = document.getElementById('eye-icon');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');
        } else {
            passwordField.type = 'password';
            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');
        }
    }
</script>
