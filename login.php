<?php
session_start();

// Database connection parameters
$servername = "localhost";
$username = "php";
$password = "kps(knOcq)ATbwA_";
$dbname = "users_db";

// Create connection
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = new mysqli($servername, $username, $password, $dbname, 3306);
$conn->set_charset('utf8mb4');

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input and prevent SQL injection
function sanitizeInput($data, $conn) {
    return htmlspecialchars(mysqli_real_escape_string($conn, $data));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = sanitizeInput($_POST['username'], $conn);
    $pass = sanitizeInput($_POST['password'], $conn);

    // Prepare and bind
    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $user);
    
    // Execute the statement
    $stmt->execute();

    // Bind result variables
    $stmt->bind_result($hashed_password);
    
    // Fetch value
    if ($stmt->fetch()) {
        // Verify password
        if (password_verify($pass, $hashed_password)) {
            // Password is correct, start session
            $_SESSION['username'] = $user;
            // Redirect to index.html
            header("Location: index.php");
            exit();
        } else {
            // Password is incorrect
            echo "Invalid username or password.";
        }
    } else {
        // Username not found
        echo "Invalid username or password.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        Username: <input type="text" name="username" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>