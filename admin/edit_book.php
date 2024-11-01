<?php
include '../db.php';
session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $book_id = $_GET['id'];

    $sql = "SELECT * FROM books WHERE book_id = $book_id";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
    } else {
        echo "Book not found!";
        exit();
    }
}

if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $image = $_FILES['image']['name'];
    $image_temp = $_FILES['image']['tmp_name'];

    if (!empty($image)) {
        $target_dir = "../images/";
        $target_file = $target_dir . basename($image);
        move_uploaded_file($image_temp, $target_file);

        $sql = "UPDATE books SET title = '$title', author = '$author', genre = '$genre', image = '$image' WHERE book_id = $book_id";
    } else {
        $sql = "UPDATE books SET title = '$title', author = '$author', genre = '$genre' WHERE book_id = $book_id";
    }

    if ($con->query($sql) === TRUE) {
        header("Location: admin_action.php");
        exit();
    } else {
        echo "Error updating book: " . $con->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
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
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"], input[type="file"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        button {
            padding: 10px 15px;
            font-size: 16px;
            color: white;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #0056b3;
        }
        a {
            display: block;
            margin-top: 10px;
            text-decoration: none;
            color: #007bff;
            text-align: center;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Edit Book</h1>
    <form method="POST" enctype="multipart/form-data">
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
        </div>
        <div>
            <label for="author">Author:</label>
            <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>
        </div>
        <div>
            <label for="genre">Genre:</label>
            <input type="text" id="genre" name="genre" value="<?php echo htmlspecialchars($book['genre']); ?>" required>
        </div>
        <div>
            <label for="image">Image:</label>
            <input type="file" id="image" name="image">
            <p>Current Image: <img src="../images/<?php echo htmlspecialchars($book['image']); ?>" alt="<?php echo htmlspecialchars($book['title']); ?>" style="max-width: 100px; display: block; margin-top: 5px;"></p>
        </div>
        <button type="submit" name="update">Update Book</button>
    </form>
    <a href="admin_action.php">Cancel</a>
</div>

</body>
</html>

<?php
$con->close();
?>
