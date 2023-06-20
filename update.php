<?php
// Start the session
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id'])) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "library";

    // Create a connection
    $email = $_SESSION['user_id'];
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    // query to check the user is admin or not
    $sql = "SELECT * FROM user WHERE email='$email' AND is_admin=1";
    $result = mysqli_query($conn, $sql);
    if(mysqli_num_rows($result) == 0){
        header("Location: view_books.php"); // Redirect to the view_books page if not an admin
        exit;
    }
}

// Logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

// Database connection setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";

// Create a connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Fetch all books
$sql = "SELECT * FROM book";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Books</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f1f1f1;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        a.button {
            display: inline-block;
            padding: 8px 12px;
            background-color: #f44336b2;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 4px;
        }

        a.button:hover {
            background-color: #45a049;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .logout-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #f44336;
            color: #fff;
            border-radius: 4px;
        }
    </style>
</head>

<body>
    <h2>Manage Books</h2>

    <!-- Logout button -->
    <div class="logout-btn">
        <a class="button" href="logout.php">Logout</a>
    </div>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Author Name</th>
            <th>Category</th>
        </tr>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['name'] . "</td>";
            echo "<td>" . $row['author_name'] . "</td>";
            echo "<td>" . $row['category'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>
    <h2>Delete Book</h2>
    <form action="" method="POST">
        <label for="id">ID:</label>
        <input type="text" id="id" name="id" required placeholder="Book ID to delete">
        <button type="submit">Delete</button>
    </form>
    <h2 style="text-align: center;">Update Book Info</h2>
    <div style="width: 300px; margin: 0 auto;">
        <form action="" method="POST">
            <label for="update_id">ID:</label>
            <input type="text" id="update_id" name="update_id" required placeholder="Book ID to update" style="width: 100%; margin-bottom: 10px;">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required placeholder="New Book Name" style="width: 100%; margin-bottom: 10px;">
            <label for="author_name">Author Name:</label>
            <input type="text" id="author_name" name="author_name" required placeholder="New Author Name" style="width: 100%; margin-bottom: 10px;">
            <label for="category">Category:</label>
            <input type="text" id="category" name="category" required placeholder="New Category" style="width: 100%; margin-bottom: 10px;">
            <button type="submit" name="update" style="width: 100%;">Update</button>
        </form>
    </div>
    <?php
        if (isset($_POST['id'])){
            $book_id = $_POST['id'];
            $sql = "DELETE FROM book WHERE id = $book_id";
            $result = mysqli_query($conn, $sql);
            if ($result && mysqli_affected_rows($conn) > 0) {
                echo "<script>alert('Book deleted!');</script>";
                header("Location: update.php");
            } else {
                echo "<script>alert('Book not found!');</script>";
                header("Location: update.php");
            }
        }

        if (isset($_POST['update'])) {
            $book_id = $_POST['update_id'];
            $name = $_POST['name'];
            $author_name = $_POST['author_name'];
            $category = $_POST['category'];

            $sql = "UPDATE book SET name = '$name', author_name = '$author_name', category = '$category' WHERE id = $book_id";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_affected_rows($conn) > 0) {
                echo "<script>alert('Book updated!');</script>";
                header("Refresh:0");
            } else {
                echo "<script>alert('Failed to update book!');</script>";
                header("Refresh:0");
            }
        }
        mysqli_close();
    ?>

</body>

</html>
