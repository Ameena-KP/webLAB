<?php
// ---------- DATABASE CONNECTION ----------
$servername = "localhost";
$username = "root";   // Change if needed
$password = "";       // Change if needed
$dbname = "school";

// Connect to MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Message placeholder
$message = "";

// ---------- HANDLE FORM SUBMISSION ----------
if (isset($_REQUEST['submit'])) {
    $name = $_REQUEST['name'];
    $email = $_REQUEST['email'];
    $address = $_REQUEST['address'];
    $gender = $_REQUEST['gender'];
    $dob = $_REQUEST['dob'];

    // Insert into database using prepared statement
    $stmt = $conn->prepare("INSERT INTO students (name, email, address, gender, dob) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $address, $gender, $dob);

    if ($stmt->execute()) {
        $message = "<p style='color:green;'>✅ Student record saved successfully!</p>";
    } else {
        $message = "<p style='color:red;'>❌ Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Details Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            margin: 40px;
        }
        form {
            background: #fff;
            padding: 20px;
            width: 420px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
        }
        label {
            display: inline-block;
            width: 120px;
            margin-bottom: 8px;
        }
        input[type=text], input[type=email], textarea, input[type=date] {
            width: 250px;
            padding: 6px;
        }
        input[type=submit] {
            margin-top: 10px;
            background: #007BFF;
            color: white;
            border: none;
            padding: 8px 15px;
            cursor: pointer;
        }
        input[type=submit]:hover {
            background: #0056b3;
        }
        .result {
            margin-top: 25px;
            background: #fff;
            padding: 15px;
            width: 420px;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>

<h2>Student Details Form</h2>
<?php echo $message; ?>

<form method="post" action="">
    <label>Name:</label>
    <input type="text" name="name" required><br>

    <label>Email:</label>
    <input type="email" name="email" required><br>

    <label>Address:</label>
    <textarea name="address" rows="3" required></textarea><br>

    <label>Gender:</label>
    <input type="radio" name="gender" value="Male" required> Male
    <input type="radio" name="gender" value="Female"> Female
    <input type="radio" name="gender" value="Other"> Other<br>

    <label>Date of Birth:</label>
    <input type="date" name="dob" required><br>

    <input type="submit" name="submit" value="Submit">
</form>

<?php
// ---------- DISPLAY SUBMITTED DATA ----------
if (isset($_REQUEST['submit'])) {
    echo "<div class='result'>";
    echo "<h3>Entered Student Details</h3>";
    echo "<b>Name:</b> " . htmlspecialchars($_REQUEST['name']) . "<br>";
    echo "<b>Email:</b> " . htmlspecialchars($_REQUEST['email']) . "<br>";
    echo "<b>Address:</b> " . nl2br(htmlspecialchars($_REQUEST['address'])) . "<br>";
    echo "<b>Gender:</b> " . htmlspecialchars($_REQUEST['gender']) . "<br>";
    echo "<b>Date of Birth:</b> " . htmlspecialchars($_REQUEST['dob']) . "<br>";
    echo "</div>";
}

$conn->close();
?>

</body>
</html>

