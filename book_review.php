<?php
include 'db.php';
session_start();
$book = null;

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    $sql = "SELECT title, author, genre, image FROM books WHERE book_id = '$book_id'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        echo "Book not found.";
        exit();
    }
} else {
    echo "Book ID is required.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reviews</title>
    <link rel="stylesheet" href="style/style.css">
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f2f5;
        margin: 0;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }

    .container {
        max-width: 700px;
        margin: auto;
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    h1 {
        text-align: center;
        color: #333;
        font-size: 2rem;
    }

    .book-details {
        text-align: center;
        margin-bottom: 25px;
    }

    .book-details img {
        max-width: 150px;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .book-details h3 {
        font-size: 1.5rem;
        color: #444;
        margin: 10px 0 5px;
    }

    .book-details p {
        font-size: 1rem;
        color: #666;
    }

    .review {
        margin: 20px 0;
        padding: 15px;
        background: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .review p {
        margin: 0;
        color: #333;
    }

    .review small {
        display: block;
        margin-top: 5px;
        color: #666;
    }

    a {
        display: inline-block;
        margin-top: 20px;
        color: #007bff;
        text-decoration: none;
        text-align: center;
    }

    a:hover {
        text-decoration: underline;
    }
    </style>
</head>

<body>

    <div class="container">
        <h1>Reviews for <?php echo $book['title']; ?></h1>
        <?php if ($book): ?>
        <div class="book-details">
            <img src="images/<?php echo $book['image']; ?>" alt="<?php echo $book['title']; ?>">
            <h3><?php echo $book['title']; ?></h3>
            <p>by <?php echo $book['author']; ?></p>
            <p>Genre: <?php echo $book['genre']; ?></p>
        </div>

        <?php
    $sql_reviews = "SELECT r.review_text, r.created_at, u.username FROM reviews r JOIN users u ON r.user_id = u.user_id WHERE r.book_id = '$book_id' ORDER BY r.created_at DESC";
    $result_reviews = $con->query($sql_reviews);

    if ($result_reviews->num_rows > 0): 
        while ($review = $result_reviews->fetch_assoc()):
    ?>
        <div class="review">
            <p><?php echo $review['review_text']; ?></p>
            <small>Reviewed by <?php echo $review['username']; ?> on
                <?php echo date('F j, Y, g:i a', strtotime($review['created_at'])); ?></small>
        </div>
        <?php 
        endwhile; 
    else: 
    ?>
        <p>No reviews yet for this book.</p>
        <?php endif; ?>
        <?php
    if (isset($_SESSION['admin'])) {
        ?>
        <a href="admin/index.php">Back to Books</a>
        <?php
        
    }else{
        ?>
        <a href="books.php">Back to Books</a>
        <?php
    }
    ?>

        <?php else: ?>
        <p>Book details could not be retrieved.</p>
        <?php endif; ?>
    </div>

</body>

</html>

<?php
$con->close();
?>