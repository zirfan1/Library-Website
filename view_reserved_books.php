<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'db_config.php';

// Check if the user is logged in, if not, redirect to the login page
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Handle unreserving books
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["isbn"])) {
    $isbnToUnreserve = $_POST["isbn"];
    $username = $_SESSION["username"];

    // Perform the unreserve action in your database
    $unreserveQuery = "DELETE FROM Reservation WHERE isbn = '$isbnToUnreserve' AND username = '$username'";
    if ($conn->query($unreserveQuery) === TRUE) {
        // Update the Books table to mark the book as not reserved
        $updateStatus = "UPDATE Books SET is_reserved = 'N' WHERE ISBN = '$isbnToUnreserve'";
        $conn->query($updateStatus);
    }
}

// Fetch and display the list of reserved books for the logged-in user
$username = $_SESSION['username'];
$sql = "SELECT b.ISBN, b.title, b.author, r.reserved_date
        FROM Reservation r
        JOIN Books b ON r.isbn = b.ISBN
        WHERE r.username = '$username'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Reserved Books</title>
    <link rel="stylesheet" href="/WebDevAssignment/style.css">
    <!-- Include any additional styling if needed -->
</head>
<body>
    <div class="container">
        <div class="navbar">
            <div class="nav-buttons">
                <a href="home.php" class="nav-btn">Home</a>
                <a href="search_form.php" class="nav-btn">Search</a>
                <a href="logout.php" class="nav-btn">Logout</a>
            </div>
        </div>

        <h1>Your Reserved Books</h1>

        <ul>
            <?php
            if ($result->num_rows > 0) {
                // Display reserved books
                while ($row = $result->fetch_assoc()) {
                    echo "<li>";
                    echo "Title: " . $row["title"] . "<br>";
                    echo "Author: " . $row["author"] . "<br>";
                    echo "Reserved Date: " . $row["reserved_date"] . "<br>";
                    echo "<form action='' method='post'>";
                    echo "<input type='hidden' name='isbn' value='" . $row["ISBN"] . "'>";
                    echo "<button type='submit'>Unreserve</button>";
                    echo "</form>";
                    echo "</li>";
                }
            } else {
                echo "<li>No reserved books.</li>";
            }
            ?>
        </ul>
    </div>
    <br></br><br></br><br></br><br></br><br></br><br></br><br></br><br></br>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> My Library C22499352.</p>
        </div>
    </footer>
</body>
</html>
