<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_name'])) {
    $isLoggedIn = false;
} else {
    $isLoggedIn = true;
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
}

$sql = "SELECT * FROM books ORDER BY book_id DESC LIMIT 8";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookExchange - Home</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

<?php include 'navbar.php'; ?>
<?php include 'hero.php'; ?>

<section id="featured-books">
    <h2>Recently Listed Books</h2>
    <div class="book-grid">
        <?php if (mysqli_num_rows($result) > 0): ?>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="book">
                    <img src="images/<?php echo htmlspecialchars($row['image']); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <p>by <?php echo htmlspecialchars($row['author']); ?></p>
                    <div class="book-btn">
                        <a href="book_review.php?id=<?php echo $row['book_id']; ?>" class="btn">View Review</a>
                        <?php if ($isLoggedIn): ?>
                            <a href="give_review.php?id=<?php echo $row['book_id']; ?>" class="btn">Give Review</a>
                        <?php else: ?>
                            <span class="btn" style="cursor: not-allowed; opacity: 0.6;" title="You must be logged in to give a review.">Give Review</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No books found.</p>
        <?php endif; ?>
    </div>
</section>

<?php include 'footer.php'; ?>

</body>
</html>
