<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $bookName = $_POST["book_name"];
    $authorName = $_POST["author_name"];
    $category = $_POST["category"];

    // Validate form data (you can add your validation rules here)
    $errors = [];

    if (empty($bookName)) {
        $errors[] = "Book Name is required.";
    }

    if (empty($authorName)) {
        $errors[] = "Author Name is required.";
    }

    if (empty($category)) {
        $errors[] = "Category is required.";
    }

    // If there are no validation errors, proceed to save the book
    if (empty($errors)) {
        // Database connection setup
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "library";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "INSERT INTO book (name, author_name, category) VALUES ('$bookName', '$authorName', '$category')";
        $result = mysqli_query($conn, $sql);
        if($result === TRUE && mysqli_affected_rows($conn)) {
            echo "<script>alert('Book added successfully!');</script>";
        }
        else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            header("Refresh:0");
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Book</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        form {
            margin: 20px auto;
            width: 300px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"] {
            width: 100%;
            padding: 5px;
            margin-bottom: 10px;
        }

        button[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        button{
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

    <?php
    // Display validation errors if any
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p class='error'>$error</p>";
        }
    }
    ?>

    <form method="POST" action="">
        <label for="book_name">Book Name:</label>
        <input type="text" name="book_name" id="book_name" required>

        <label for="author_name">Author Name:</label>
        <input type="text" name="author_name" id="author_name" required>

        <label for="category">Category:</label>
        <input type="text" name="category" id="category" required>

        <button type="submit">Add Book</button>
        <a href="admin.php"><button type="button">Go to Admin Page</button></a>
    </form>

</body>
</html>
