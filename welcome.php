<?php
// Get username from URL
if (isset($_GET['user'])) {
    $user = $_GET['user'];
} else {
    // Redirect to login if opened directly
    header("Location: login.php");
    exit;
}
?>
<html>
<head><title>Welcome Page</title></head>
<body>
<h2 align="center">WELCOME PAGE</h2>
<h3 align="center" style="color:green;">Welcome, <?php echo htmlspecialchars($user); ?>!</h3>
<p align="center"><a href="q21.php">Logout</a></p>
</body>
</html>
