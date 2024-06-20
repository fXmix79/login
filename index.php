<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    // If not logged in, redirect to the login page
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Protected Page</title>
</head>
<body>
    <h1>Welcome to the protected page, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <p>This page is only accessible to logged-in users.</p>
    <a href="logout.php">Logout</a>
</body>
</html>
