<?php
// --- Database connection settings ---
$servername = "localhost";
$username = "root";   // Change if needed
$password = "";       // Change if needed
$dbname = "library";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- Handle form submission ---
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_number = $_POST['book_number'];
    $title = $_POST['title'];
    $edition = $_POST['edition'];
    $publisher = $_POST['publisher'];

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO books (book_number, title, edition, publisher) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $book_number, $title, $edition, $publisher);

    if ($stmt->execute()) {
        $message = "<p style='color: green;'>✅ Book details saved successfully!</p>";
    } else {
        $message = "<p style='color: red;'>❌ Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Entry Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f6f6f6;
            margin: 50px;
        }
        form {
            background: white;
            padding: 20px;
            width: 350px;
            border-radius: 10px;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
        }
        label {
            display: inline-block;
            width: 100px;
            margin-bottom: 10px;
        }
        input[type=text] {
            width: 200px;
            padding: 5px;
        }
        input[type=submit] {
            margin-top: 10px;
            padding: 8px 15px;
            background: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        input[type=submit]:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>

<h2>Enter Book Details</h2>

<!-- Show message after saving -->
<?php if ($message) echo $message; ?>

<form method="POST" action="">
    <label>Book Number:</label>
    <input type="text" name="book_number" required><br>

    <label>Title:</label>
    <input type="text" name="title" required><br>

    <label>Edition:</label>
    <input type="text" name="edition"><br>

    <label>Publisher:</label>
    <input type="text" name="publisher"><br>

    <input type="submit" value="Save Book">
</form>

</body>
</html>

