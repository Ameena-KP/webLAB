<?php
// Database connection
$servername = "localhost";
$username = "root";      // Change if needed
$password = "";          // Change if needed
$dbname = "library";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert book details if form submitted
if (isset($_POST['submit'])) {
    $book_no = $_POST['book_number'];
    $title = $_POST['title'];
    $edition = $_POST['edition'];
    $publisher = $_POST['publisher'];

    // Prevent SQL injection
    $book_no = (int)$book_number;
    $title = $conn->real_escape_string($title);
    $edition = $conn->real_escape_string($edition);
    $publisher = $conn->real_escape_string($publisher);

    $sql = "INSERT INTO books (book_number, title, edition, publisher) 
            VALUES ($book_number, '$title', '$edition', '$publisher')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color:green;'>Book added successfully!</p>";
    } else {
        echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Details</title>
</head>
<body>
    <h2>Enter Book Information</h2>
    <form method="post" action="">
        <label>Book Number:</label><br>
        <input type="number" name="book_number" required><br><br>

        <label>Title:</label><br>
        <input type="text" name="title" required><br><br>

        <label>Edition:</label><br>
        <input type="text" name="edition" required><br><br>

        <label>Publisher:</label><br>
        <input type="text" name="publisher" required><br><br>

        <input type="submit" name="submit" value="Add Book">
    </form>

    <hr>
    <h2>All Book Details</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>Book Number</th>
            <th>Title</th>
            <th>Edition</th>
            <th>Publisher</th>
        </tr>
        <?php
        // Fetch and display all books
        $result = $conn->query("SELECT * FROM books");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['book_number']}</td>
                        <td>{$row['title']}</td>
                        <td>{$row['edition']}</td>
                        <td>{$row['publisher']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No records found</td></tr>";
        }

        $conn->close();
        ?>
    </table>
</body>
</html>
