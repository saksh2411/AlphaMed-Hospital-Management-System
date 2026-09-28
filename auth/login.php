<?php

session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: ../dashboard.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Login | AlphaMed</title>

    <link rel="stylesheet"
          href="../assets/css/style.css">

</head>

<body>

<div class="login-container">

    <div class="login-card">

        <h1>AlphaMed</h1>

        <p class="subtitle">
            AI-Powered Hospital Management System
        </p>

        <h2>Login</h2>

        <?php

        if (isset($_GET['error'])) {

            echo '<div class="error-message">'
                . htmlspecialchars($_GET['error'])
                . '</div>';

        }

        ?>

        <form action="login_process.php"
              method="POST">

            <div class="form-group">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    placeholder="Enter your email"
                    required
                >

            </div>

            <div class="form-group">

                <label>Password</label>

                <input
                    type="password"
                    name="password"
                    placeholder="Enter your password"
                    required
                >

            </div>

            <button type="submit">
                Login
            </button>

        </form>

    </div>

</div>

</body>

</html>