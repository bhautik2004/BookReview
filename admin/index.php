<?php
include '../db.php';
session_start();

if (isset($_SESSION['admin'])) {
    header("Location: admin_action.php");
    exit();
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM admin WHERE username = '$username' AND password= '$password'";
    $res = $con->query($sql);

    if ($res->num_rows > 0) {
        $_SESSION['admin'] = $username;
        header("Location: admin_action.php");
    } else {
        $error = "Invalid Username or Password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookExchange - Login</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>
<section id="login">
    <h1>Admin Login</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST">
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" name="login">Login</button>
    </form>
   
</section>

</body>
</html>
