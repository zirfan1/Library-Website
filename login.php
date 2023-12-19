<!-- LOGIN HTML CODE -->
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>
   <link rel="stylesheet" href="/WebDevAssignment/style.css">

</head>
<body id="login">

<body>
   <form action="login.php" method="post">
       <h2>User Login</h2>

       <label for="username">Username:</label>
       <input type="text" id="username" name="username" required>

       <label for="password">Password:</label>
       <input type="password" id="password" name="password" required>

       <button type="submit">Login</button>
       <p>Don't have an account? <a href="register.php">Register here</a></p>

   </form>
   <br></br><br></br><br></br><br></br><br></br><br></br><br></br><br></br>

   <footer>
        <p>&copy; 2023 My Library C22499352</p>
    </footer>
</body>
</html>





<?php
//session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_config.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user input from the form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check user credentials in the database
    $query = "SELECT * FROM registerUser WHERE username = '$username'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // User found, verify password
        $row = $result->fetch_assoc();
        if ($password === $row['password']) {
            // Start a session and store user information
            session_start();
            $_SESSION['username'] = $username;
            // Redirect to a welcome page or any other page after successful login
            header('Location: home.php');
            exit();
            echo "Login successful! Welcome, $username!";
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "User not found.";
    }
    // Close the database connection
    $conn->close();
}
?>

