<nav>
    <div class="logo">Book Review</div> 
    <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="books.php">Browse Books</a>
        <a href="profile.php">Profile</a>
        <?php echo isset($_SESSION['user_name']) 
            ? "<a href='logout.php' onclick=\"return confirm('Are you sure you want to logout?');\">Logout</a>"
            : "<a href='login.php'>Login</a>"; 
        ?>
    </div>
</nav>
