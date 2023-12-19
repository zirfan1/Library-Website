<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include 'db_config.php';

// Check if the user is logged in, if not, redirect to the login page
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="/WebDevAssignment/style.css">
</head>
<body id="home">
    <div class="container">
        <div class="navbar">
            <div class="nav-buttons">
                <a href="search_form.php" class="nav-btn">Search</a>
                <a href="view_reserved_books.php" class="nav-btn">Reserved Books</a>
            </div>
            <form action="logout.php" method="post">
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
        <center>
            <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
        </center>

        <br></br>
        <center>
        <p> Welcome to the Library Sytem please click the search button to look for your next read!</p>
        <p> To view reserved books click on Reserved</p>
        </center>
        
        <br></br><br></br><br></br><br></br><br></br><br></br><br></br><br></br>
      

        <!-- Additional content goes here -->

        <!-- Footer -->
        <footer>
            <p>&copy; 2023 My Library C22499352</p>
        </footer>
    </div>
</body>
</html>

