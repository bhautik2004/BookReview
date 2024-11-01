<?php
session_start();
include '../db.php'; 

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];
    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../images/" . $image);
    $sql = "INSERT INTO Books (title, author, genre, image) 
            VALUES ('$title', '$author', '$genre', '$image')";

    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Book added successfully');</script>";
        header("location:admin_action.php");
    } else {
        echo "<script>alert('Error adding book: " . mysqli_error($con) . "');</script>";
    }
}

$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <link rel="stylesheet" href="../style/style.css">
</head>
<body>

<section id="add-book">
    <h1>Add a New Book</h1>
    <form method="post" enctype="multipart/form-data">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>

        <label for="author">Author:</label>
        <input type="text" name="author" id="author" required>

        <label for="genre">Genre:</label>
        <input type="text" name="genre" id="genre">

        <label for="image">Book Image:</label>
        <input type="file" name="image" id="image" accept="image/*" required>

        <button type="submit" name="add">Add Book</button>
    </form>
</section>

</body>
</html>
