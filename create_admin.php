<?php

require_once "config/database.php";

$full_name = "AlphaMed Administrator";
$email = "admin@alphamed.com";
$password = "Admin@123";
$role = "admin";

$hashed_password = password_hash(
    $password,
    PASSWORD_DEFAULT
);

$stmt = $conn->prepare(
    "INSERT INTO users
    (full_name, email, password, role)
    VALUES (?, ?, ?, ?)"
);

$stmt->bind_param(
    "ssss",
    $full_name,
    $email,
    $hashed_password,
    $role
);

if ($stmt->execute()) {

    echo "<h2>Admin account created successfully!</h2>";

    echo "<p>Email: admin@alphamed.com</p>";

    echo "<p>Password: Admin@123</p>";

} else {

    echo "Error: " . $stmt->error;

}

?>