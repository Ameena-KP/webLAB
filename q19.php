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
    $book_number = (int)$_POST['book_number'];
    $title = $conn->real_escape_string($_POST['title']);
    $edition = $conn->real_escape_string($_POST['edition']);
    $publisher = $conn->real_escape_string($_POST['publisher']);

    $sql = "INSERT INTO books (book_number, title, edition, publisher) 
            VALUES ($book_number, '$title', '$edition', '$publisher')";

    if ($conn->query($sql) === TRUE) {
        echo "<p class='success'>✅ Book added successfully!</p>";
    } else {
        echo "<p class='error'>❌ Error: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Library Book Management</title>
    <style>
        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background-color: #f5f6fa;
            color: #333;
            margin: 40px;
        }

        h2 {
            color: #2f3640;
            border-left: 5px solid #0097e6;
            padding-left: 10px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            width: 400px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-bottom: 40px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input[type="text"], input[type="number"] {
            width: 95%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            background-color: #0097e6;
            color: white;
            border: none;
            padding: 10px 20px;
            margin-top: 15px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        input[type="submit"]:hover {
            background-color: #007bb5;
        }

        table {
            width: 90%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }

        th {
            background-color: #0097e6;
            color: white;
            text-transform: uppercase;
        }

        tr:hover {
            background-color: #f1f2f6;
        }

        .success {
            color: green;
            font-weight: bold;
        }

        .error {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h2>📚 Add New Book</h2>
    <form method="post" action="">
        <label>Book Number:</label>
        <input type="number" name="book_number" required>

        <label>Title:</label>
        <input type="text" name="title" required>

        <label>Edition:</label>
        <input type="text" name="edition" required>

        <label>Publisher:</label>
        <input type="text" name="publisher" required>

        <input type="submit" name="submit" value="Add Book">
    </form>

    <h2>📖 All Books in Library</h2>
    <table>
        <tr>
            <th>Book Number</th>
            <th>Title</th>
            <th>Edition</th>
            <th>Publisher</th>
        </tr>
        <?php
        // Fetch and display all books
        $result = $conn->query("SELECT * FROM books ORDER BY book_number ASC");

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

