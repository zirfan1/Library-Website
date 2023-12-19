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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Books</title>
    <link rel="stylesheet" href="/WebDevAssignment/style.css">
    <!-- Include any additional styling if needed -->
</head>
<body>
    <div class="container">
        <div class="navbar">
            <div class="nav-buttons">
                <a href="home.php" class="nav-btn">Home</a>
                <a href="view_reserved_books.php" class="nav-btn">Reserved Books</a>
                <a href="logout.php" class="nav-btn">Logout</a>
            </div>
        </div>
        <center>
        <form method="GET" action="search_form.php">
            <label for="search_term">Search for a book:</label>
            <input type="text" name="search_term" id="search_term" placeholder="Enter title or author">

            <!-- Fetch categories from the database and create a dropdown menu -->
            <select name="category">
                <option value="">Select Category</option>
                <?php
                $categoryQuery = "SELECT * FROM Category";
                $categoryResult = $conn->query($categoryQuery);

                while ($categoryRow = $categoryResult->fetch_assoc()) {
                    echo "<option value='" . $categoryRow['category_code'] . "'>" . $categoryRow['description'] . "</option>";
                }
                ?>
            </select>

            <input type="submit" value="Search">
        </form>
            </center>
        <?php
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search_term"])) {
    $searchTerm = $_GET['search_term'];
    $categoryCode = isset($_GET['category']) ? $_GET['category'] : '';

    echo "Search Term: $searchTerm, Category: $categoryCode<br>";

    // Perform book search based on title, author, or category
    $sql = "SELECT * FROM Books WHERE (title LIKE '%$searchTerm%' OR author LIKE '%$searchTerm%')";

    // Add category condition if selected
    if (!empty($categoryCode)) {
        $sql .= " AND category_code = '$categoryCode'";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Display search results in a table
        echo "<div class='results'>";
        echo "<table>";
        echo "<tr><th>ISBN</th><th>Title</th><th>Author</th><th>Category</th><th>Action</th></tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row["ISBN"] . "</td>";
            echo "<td>" . $row["title"] . "</td>";
            echo "<td>" . $row["author"] . "</td>";
            echo "<td>" . $row["category_code"] . "</td>";
            echo "<td>";
            echo "<form action='reserve_book.php' method='post'>";
            echo "<input type='hidden' name='isbn' value='" . $row["ISBN"] . "'>";
            echo "<input type='hidden' name='username' value='" . $_SESSION['username'] . "'>";
            echo "<input type='submit' value='Reserve'>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "</div>";
    } else {
        echo "<p>No results found.</p>";
    }
}

$conn->close();
?>
        <br></br><br></br><br></br><br></br><br></br><br></br><br></br><br></br>

    </div>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; <?php echo date("Y"); ?> My Library C22499352.</p>
        </div>
    </footer>
</body>
</html>
