<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("db_config.php");
//links to go home or logout
echo "<p><a href='home.php'>Go Home</a> | <a href='logout.php'>Logout</a></p>";

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

            echo "Book reserved successfully!";
        } else {
            echo "Error: " . $reserveBook . "<br>" . $conn->error;
        }
    } else {
        echo "Book is already reserved.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
