<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("db_config.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve Book</title>
    <link rel="stylesheet" href="/WebDevAssignment/style.css">
    <!-- Include any additional styling if needed -->
</head>
<body>
    <div class="container">
        <div class="navbar">
            <div class="nav-buttons">
                <a href="home.php" class="nav-btn">Home</a>
                <a href="view_reserved_books.php" class="nav-btn">Reserved Books</a>
                <a href="search_form.php" class="nav-btn">Search</a>
                <a href="logout.php" class="nav-btn">Logout</a>
            </div>
        </div>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $isbn = $_POST['isbn'];
            $username = $_POST['username'];

            // Check if the book is available for reservation
            $checkAvailability = "SELECT * FROM Books WHERE ISBN = '$isbn' AND is_reserved = 'N'";
            $result = $conn->query($checkAvailability);

            if ($result->num_rows > 0) {
                // Book is available, proceed with reservation
                $reserveDate = date("Y-m-d");
                $reserveBook = "INSERT INTO Reservation (isbn, username, reserved_date) VALUES ('$isbn', '$username', '$reserveDate')";
                
                if ($conn->query($reserveBook) === TRUE) {
                    // Update Books table to mark the book as reserved
                    $updateStatus = "UPDATE Books SET is_reserved = 'Y' WHERE ISBN = '$isbn'";
                    $conn->query($updateStatus);

                    echo "<p>Book reserved successfully!</p>";
                } else {
                    echo "<p>Error: " . $reserveBook . "<br>" . $conn->error . "</p>";
                }
            } else {
                echo "<p>Book is already reserved.</p>";
            }
        }

        $conn->close();
        ?>
    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> My Library C22499352.</p>
        </div>
    </footer>
</body>
</html>
