
<header>
    <?php 
    if (isset($_SESSION['user_name'])) {
        echo "<h1>Hey, " .$_SESSION['user_name']."</h1>";
    }
    ?>

    <h1>Welcome to Book Review Platform</h1>
    <p>Dive into the world of books! Discover reviews, share your thoughts, and explore new reads.</p>
</header>
