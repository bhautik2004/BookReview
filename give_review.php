<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

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

$user_name = $_SESSION['user_name'];
$sql_check_user = "SELECT user_id FROM users WHERE username = '$user_name'";
$result_user = $con->query($sql_check_user);

if ($result_user->num_rows > 0) {
    $user = $result_user->fetch_assoc();
    $user_id = $user['user_id'];

    if (isset($_POST['submit_review'])) {
        $review_text = $_POST['review_text'];

        $sql = "INSERT INTO reviews (book_id, user_id, review_text, created_at) VALUES ('$book_id', '$user_id', '$review_text', NOW())";

        if ($con->query($sql) === TRUE) {
            header("Location: books.php");
            exit();
        } else {
            echo "Error: " . $con->error;
        }
    }
} else {
    echo "User does not exist.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Review</title>
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

       label {
           display: block;
           margin: 15px 0 8px;
           font-weight: bold;
           color: #333;
       }

       textarea {
           width: 100%;
           height: 120px;
           padding: 15px;
           border-radius: 8px;
           border: 1px solid #ccc;
           font-size: 1rem;
           resize: vertical;
       }

       button {
           width: 100%;
           padding: 12px;
           background-color: #007bff;
           color: white;
           border: none;
           border-radius: 8px;
           cursor: pointer;
           font-size: 1.1rem;
           transition: background-color 0.3s ease;
       }

       button:hover {
           background-color: #0056b3;
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
    <h1>Add Review</h1>
    <?php if ($book): ?>
    <div class="book-details">
        <img src="images/<?php echo $book['image']; ?>" alt="<?php echo $book['title']; ?>">
        <h3><?php echo $book['title']; ?></h3>
        <p>by <?php echo $book['author']; ?></p>
        <p>Genre: <?php echo $book['genre']; ?></p>
    </div>
    <form method="POST">
        <div>
            <label for="review_text">Your Review</label>
            <textarea id="review_text" name="review_text" placeholder="Write your thoughts here..." required></textarea>
        </div>
        <button type="submit" name="submit_review">Submit Review</button>
    </form>
    <?php else: ?>
        <p>Book details could not be retrieved.</p>
    <?php endif; ?>
    <a href="books.php">Cancel</a>
</div>

</body>
</html>

<?php
$con->close();
?>
