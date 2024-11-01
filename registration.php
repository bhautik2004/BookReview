<?php
include 'db.php';
session_start();

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    if ($password !== $cpassword) {
        $error = "Passwords do not match.";
    } else {
        $checkUserQuery = "SELECT * FROM users WHERE username = '$username'";
        $result = $con->query($checkUserQuery);
        
        if ($result->num_rows > 0) {
            $error = "Username already exists.";
        } else {
            $sql = "INSERT INTO users(username, password, email) VALUES('$username', '$password', '$email')";
            
            if ($con->query($sql)) {
                $_SESSION['user_name'] = $username;
                header("location:index.php");
                exit();
            } else {
                $error = "Registration failed. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookExchange - Register</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<section id="register">
    <h1>Register</h1>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php if (isset($_POST['username'])) { echo $username; } ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php if (isset($_POST['email'])) { echo $email; } ?>" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="cpassword">Confirm Password:</label>
            <input type="password" id="cpassword" name="cpassword" required>
        </div>
        <button type="submit" name="register">Register</button>
    </form>
    <p>Already have an account? <a href="login.php">Login here</a></p>
</section>

</body>
</html>
