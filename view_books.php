<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page or handle unauthorized access
    header("Location: login.php");
    exit();
}

// Database connection setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";

// Create a new database connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch book details from the database
$sql = "SELECT id, name, author_name, category FROM book";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>View Books</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .logout-button {
            position: absolute;
            top: 20px;
            right: 20px;
            text-decoration: none;
            padding: 10px;
            background-color: #f44336;
            color: #fff;
            border-radius: 4px;
        }

        .logout-button:hover {
            background-color: #d32f2f;
        }

        .request-button {
            padding: 5px 10px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .request-button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>View Books</h1>

    <a href="logout.php" class="logout-button">Logout</a>

    <table>
        <tr>
            <th>Book ID</th>
            <th>Book Name</th>
            <th>Author Name</th>
            <th>Category</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["name"] . "</td>";
                echo "<td>" . $row["author_name"] . "</td>";
                echo "<td>" . $row["category"] . "</td>";
                echo "<td>";
                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No books found.</td></tr>";
            exit;
        }
        ?>
    </table>
    <form action="" method="POST">
            <label for="id">ID:</label>
            <input type="text" id="id" name="id" required placeholder="Book ID to request">
            <button type="submit">Submit</button>
    </form>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $book_id = $_POST['id'];
        $email = $_SESSION['user_id'];
        // check if the user has already requested a book
        $sql = "SELECT * FROM user WHERE email='$email' AND requested_book IS NOT NULL";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('You have already requested a book!');</script>";
            $conn->close();
            exit;
        }
        else{
            $sql = "UPDATE user SET requested_book = '$book_id' WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            echo "<script>alert('Book requested!');</script>";
            $conn->close();
            exit;
        }
    }
    ?>
</body>
</html>

<?php
// Close the database connection
?>
