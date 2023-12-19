<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_config.php';

// Function to sanitize user inputs
function sanitizeInput($input) {
    // Implement your sanitization logic here
    return $input;
}

// Function to validate mobile number
function isValidMobileNumber($number) {
    return preg_match("/^[0-9]{10}$/", $number);
}

// Initialize variables
$username = '';
$password = '';
$confirmPassword = '';
$number = '';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve user input from the form
    $username = sanitizeInput($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    $first_name = sanitizeInput($_POST['first_name'] ?? '');
    $surname = sanitizeInput($_POST['surname'] ?? '');
    $address_line = sanitizeInput($_POST['address_line'] ?? '');
    $city = sanitizeInput($_POST['city'] ?? '');
    $number = sanitizeInput($_POST['number'] ?? '');

    // Validate inputs
    $errors = [];

    // Validate username (example: alphanumeric, min length 4)
    if (!preg_match("/^[a-zA-Z0-9]{4,}$/", $username)) {
        $errors[] = "Invalid username format. Alphanumeric characters only, minimum length 4.";
    }

    // Validate password (example: min length 6)
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }

    // Validate password confirmation
    if ($password !== $confirmPassword) {
        $errors[] = "Passwords do not match.";
    }

    // Validate mobile number using the custom function
    if (!isValidMobileNumber($number)) {
        $errors[] = "Invalid mobile number format. It should be numeric and 10 characters long.";
    }

    // If there are validation errors, display them
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p>Error: $error</p>";
        }
    } else {
        // If validation passed, proceed with database interactions and user registration logic
        $hashedPassword = $password;
        $query = "INSERT INTO registerUser (username, password, first_name, surname, address_line, city, mobile_number) VALUES ('$username', '$password', '$first_name', '$surname', '$address_line', '$city', '$number')";

        // Implement database connection and registration logic here
        if ($conn->query($query) === TRUE) {
            echo "Registration is successful! You can log in";
            header('Location: login.php');
            exit();        
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }

        // Close the database connection
        $conn->close();
    }
}
?>

<!-- LOGIN HTML CODE -->
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="/WebDevAssignment/style.css">
   <title>Login</title>
   <!-- Include any additional styling if needed -->
</head>
<body>
    <center>
   <form action="register.php" method="post">
       <h2>User Registration</h2>

       <label for="username">Username:</label>
       <input type="text" id="username" name="username" required>

       <label for="password">Password:</label>
       <input type="password" id="password" name="password" required>

       <label for="confirm_password">Confirm Password:</label>
       <input type="password" id="confirm_password" name="confirm_password" required>

       <label for="first_name">First Name:</label>
       <input type="text" id="first_name" name="first_name" required>

       <label for="surname">Surname:</label>
       <input type="text" id="surname" name="surname" required>

       <label for="address_line">Address:</label>
       <input type="text" id="address_line" name="address_line" required>

       <label for="city">City:</label>
       <input type="text" id="city" name="city" required>

       <label for="number">Mobile Number:</label>
       <input type="text" id="number" name="number" pattern="[0-9]{10}" required>

       <button type="submit">Register</button>
    </center>
   </form>
      <!-- Footer -->
      <footer>
       <p>&copy; <?php echo date("Y"); ?> Library Website C22499352</p>
   </footer>
</body>
</html>
