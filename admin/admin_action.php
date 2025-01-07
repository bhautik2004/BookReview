<?php
include '../db.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['delete_id'])) {
    $book_id = $_GET['delete_id'];

    $sql = "DELETE FROM books WHERE book_id = $book_id";

    if ($con->query($sql) === TRUE) {
        $message = "Book deleted successfully.";
    } else {
        $message = "Error deleting book: " . $con->error;
    }
}

$sql = "SELECT * FROM books";
$result = $con->query($sql);

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Books</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .btn {
            display: inline-block;
            margin: 10px 0;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
            background-color: #007bff;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .logout-btn {
            position: absolute; 
            top: 20px;
            right: 20px;
        }
        .book-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .book-table th, .book-table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        .book-table th {
            background-color: #007bff;
            color: white;
        }
        .book-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .book-table tr:hover {
            background-color: #f1f1f1;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
        img {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body>

<form method="POST" class="logout-btn">
    <button type="submit" name="logout" class="btn" style="background-color: #dc3545;">Logout</button>
</form>

<div class="container">
    <h1>Admin - Manage Books</h1>

    <?php if (isset($message)): ?>
        <p style="color: green;"><?php echo $message; ?></p>
    <?php endif; ?>

    <a href="add_book.php" class="btn">Add New Book</a>

    <table class="book-table">
        <thead>
            <tr>
                <th>Book ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Genre</th>
                <th>Image</th>
                <th>Actions</th>
                <th>Reviews</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['book_id']; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['author']; ?></td>
                        <td><?php echo $row['genre']; ?></td>
                        <td><img src="../images/<?php echo $row['image']; ?>" alt="<?php echo htmlspecialchars($row['title']); ?>"></td>
                        <td>
                            <a href="edit_book.php?id=<?php echo $row['book_id']; ?>" class="btn">Edit</a>
                            <a href="?delete_id=<?php echo $row['book_id']; ?>" class="btn btn-delete" onclick="return confirm('Are you sure you want to delete this book?');">Delete</a>
                        </td>
                        <td>
                            <a href="../book_review.php?id=<?php echo $row['book_id']; ?>" class="btn">View Reviews</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7">No books found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
$con->close();
?>

</body>
</html>
