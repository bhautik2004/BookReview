<?php
session_start();
include 'db.php';


if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}


$user_name = $_SESSION['user_name'];
$query = "SELECT * FROM users WHERE username = '$user_name'";
$result = $con->query($query);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found!";
    exit();
}


if (isset($_POST['update'])) {
    $new_username = $_POST['username'];
    $new_email = $_POST['email'];

    
    $update_query = "UPDATE users SET username = '$new_username', email = '$new_email' WHERE username = '$user_name'";
    
    if ($con->query($update_query)) {
        $_SESSION['user_name'] = $new_username; 
        header("Location: profile.php?success=1"); 
        exit();
    } else {
        $error = "Failed to update profile. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookExchange - Profile</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<section id="profile">
    <h1>Profile</h1>

    
    <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
        <p style="color: green;">Profile Updated Successfully!</p>
    <?php endif; ?>

    
    <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    
    <form method="POST" action="">
        <div class="profile-details">
            <label for="username"><strong>Username:</strong></label>
            <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>

            <label for="email"><strong>Email:</strong></label>
            <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
        </div>
        
        <div class="profile-actions">
            <button type="submit" class="btn" name="update">Update Profile</button>
            <a href="logout.php" class="btn">Logout</a>
        </div>
    </form>
</section>

</body>
</html>
