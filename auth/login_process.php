<?php

session_start();

require_once "../config/database.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit;
}

$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

if (empty($email) || empty($password)) {

    header("Location: login.php?error=Please enter email and password");
    exit;

}

$stmt = $conn->prepare(
    "SELECT id, full_name, email, password, role, status
     FROM users
     WHERE email = ?
     LIMIT 1"
);

$stmt->bind_param("s", $email);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows !== 1) {

    header("Location: login.php?error=Invalid email or password");
    exit;

}

$user = $result->fetch_assoc();

if ($user["status"] !== "active") {

    header("Location: login.php?error=Your account is inactive");
    exit;

}

if (!password_verify($password, $user["password"])) {

    header("Location: login.php?error=Invalid email or password");
    exit;

}

/*
|--------------------------------------------------------------------------
| Store user information in session
|--------------------------------------------------------------------------
*/

session_regenerate_id(true);

$_SESSION["user_id"] = $user["id"];
$_SESSION["full_name"] = $user["full_name"];
$_SESSION["email"] = $user["email"];
$_SESSION["role"] = $user["role"];


/*
|--------------------------------------------------------------------------
| Redirect according to role
|--------------------------------------------------------------------------
*/

switch ($user["role"]) {

    case "admin":
        header("Location: ../admin/dashboard.php");
        break;

    case "doctor":
        header("Location: ../doctor/dashboard.php");
        break;

    case "nurse":
        header("Location: ../nurse/dashboard.php");
        break;

    case "staff":
        header("Location: ../staff/dashboard.php");
        break;

    case "patient":
        header("Location: ../patient/dashboard.php");
        break;

    default:
        session_destroy();

        header("Location: login.php?error=Invalid user role");
        break;
}

exit;

?>