<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

$user_name = $_SESSION['user_name'];
$userQuery = "SELECT user_id FROM Users WHERE username = '$user_name'";
$userResult = mysqli_query($con, $userQuery);

if ($userResult && mysqli_num_rows($userResult) > 0) {
    $userRow = mysqli_fetch_assoc($userResult);
    $owner_id = $userRow['user_id'];
} else {
    echo "<script>alert('User not found.');</script>";
    exit();
}

$sql = "SELECT * from books";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Books - BookExchange</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

<?php include 'navbar.php'; ?>

<section id="featured-books">
<h2>All Books</h2>
    <div class="book-grid">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="book">
                    <img src="images/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>">
                    <h3><?php echo $row['title']; ?></h3>
                    <p>by <?php echo $row['author']; ?></p>
                <div class="book-btn">
                    <a href="book_review.php?id=<?php echo $row['book_id']; ?>" class="btn">View Review</a>
                    <a href="give_review.php?id=<?php echo $row['book_id']; ?>" class="btn">Give Review</a>
                </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No books found.</p>
        <?php endif; ?>
    </div>
</section>

</body>
</html>
