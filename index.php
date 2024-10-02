<?php
// Database connection parameters
$servername = "localhost";  // Change if your DB is hosted elsewhere
$username = "root";         // DB username
$password = "";             // DB password
$dbname = "ludo_game";      // Your database name

session_start();
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL to create the users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    // Table created successfully or already exists
}


// Handle signup form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['signup-username'])) {
    $signup_username = $conn->real_escape_string($_POST['signup-username']);
    $signup_email = $conn->real_escape_string($_POST['signup-email']);
    $signup_password = password_hash($_POST['signup-password'], PASSWORD_BCRYPT);

    // Check if username or email already exists
    $sql = "SELECT * FROM users WHERE username = '$signup_username' OR email = '$signup_email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "Username or email already exists.";

    } else {
        // Insert new user into database
        $sql = "INSERT INTO users (username, email, password) VALUES ('$signup_username', '$signup_email', '$signup_password')";
        if ($conn->query($sql) === TRUE) {
            echo "Sign up successful! Welcome, $signup_username";
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login-username'])) {
    $login_username = $conn->real_escape_string($_POST['login-username']);
    $login_password = $_POST['login-password'];

    // Fetch user details from database
    $sql = "SELECT * FROM users WHERE username = '$login_username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($login_password, $user['password'])) {
            // Store session variables for logged-in user
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            // Redirect to the dashboard or next page after successful login
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Username does not exist.";
    }
}

$conn->close();



?>
