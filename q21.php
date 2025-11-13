<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "userdb";

$conn = new mysqli($servername, $username, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE username='$user'");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['password'] == $pass) {
            // Redirect to welcome page and pass username via URL
            header("Location: welcome.php?user=" . urlencode($user));
            exit;
        } else {
            echo "<p align='center' style='color:red;'>Incorrect Password</p>";
        }
    } else {
        $passCheck = $conn->query("SELECT * FROM users WHERE password='$pass'");
        if ($passCheck->num_rows > 0) {
            echo "<p align='center' style='color:red;'>Incorrect Username</p>";
        } else {
            echo "<p align='center' style='color:red;'>Invalid Username and Password</p>";
        }
    }
}
$conn->close();
?>

<html>
<head><title>Login Page</title></head>
<body>
<h2 align="center">LOGIN PAGE</h2>
<form method="post" action="">
<table border="1" align="center" cellpadding="5" cellspacing="0">
<tr>
    <td>Username:</td>
    <td><input type="text" name="username" required></td>
</tr>
<tr>
    <td>Password:</td>
    <td><input type="password" name="password" required></td>
</tr>
<tr>
    <td colspan="2" align="center">
        <input type="submit" name="submit" value="Login">
    </td>
</tr>
</table>
</form>
</body>
</html>
