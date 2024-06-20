<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "users_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to sanitize input and prevent SQL injection
function sanitizeInput($data, $conn) {
    return htmlspecialchars(mysqli_real_escape_string($conn, $data));
}

// Insert user function
function insertUser($conn, $username, $password) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $hashed_password);
    $stmt->execute();
    $stmt->close();
}

// Delete user function
function deleteUser($conn, $old_username) {    
    $stmt = $conn->prepare("delete from users where username = ?");
    $stmt->bind_param("s", $old_username);
    $stmt->execute();
    $stmt->close();
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['new_username'])) {
    $new_user = sanitizeInput($_POST['new_username'], $conn);
    $new_pass = sanitizeInput($_POST['new_password'], $conn);
    $repeat_pass = sanitizeInput($_POST['repeat_password'], $conn);

    if ($new_pass === $repeat_pass) {
        insertUser($conn, $new_user, $new_pass);
        echo "User registered successfully!";
    } else {
        echo "Passwords do not match!";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['old_username'])){
    $old_username = sanitizeInput($_POST['old_username'], $conn);
    if($old_username){
        deleteUser($conn, $old_username);
        echo "User ". $old_username . " deleted!";
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Protected Page</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .logout {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        .logout a {
            text-decoration: none;
            color: #fff;
            background-color: #ff0000;
            padding: 10px 20px;
            border-radius: 5px;
        }
        .form-container {
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="logout">
        <a href="logout.php">Logout</a>
    </div>
    <h1>Welcome to the protected page, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>This page is only accessible to logged-in users.</p>

    <div class="form-container">
        <h2>Register New User</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            Username: <input type="text" name="new_username" required><br><br>
            Password: <input type="password" name="new_password" required><br><br>
            Repeat Password: <input type="password" name="repeat_password" required><br><br>
            <input type="submit" value="Register">
        </form>
    </div>

    <div class="form-container">
        <h2>Delete Existing User</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            Username: <input type="text" name="old_username" required><br><br>
            <input type="submit" value="Delete">
        </form>
    </div>
</body>
</html>
