<?php

function generatePassword($length = 12) {
    return bin2hex(random_bytes($length / 2));
}

function createUser($firstName, $lastName, $email, $phone, $password) {
    try {
        $pdo = getDB();
        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, phone, password) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$firstName, $lastName, $email, $phone, md5($password)]);
    } catch (PDOException $e) {
        $response['error'] = $e->getMessage();
        return json_encode($response);
        
    }
}

function validateUserInput($firstName, $lastName, $email, $phone) {
    $errors = [];

    if (empty($firstName) || empty($lastName) || empty($email) || empty($phone)) {
        $errors[] = 'All fields are required.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'Invalid email address.';
    }

    if (!preg_match('/^\d{10}$/', $phone)) {
        $errors[] = 'Invalid phone number. It should be 10 digits.';
    }

    return $errors;
}
?>
