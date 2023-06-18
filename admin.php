<?php
// Check if the logout button is clicked
if (isset($_GET['logout'])) {
    // Perform any logout logic here, such as destroying the session
    // Redirect to the login page or any other appropriate page
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Books</title>
    <style>
        /* CSS for logout button */
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
    </style>
</head>
<body>
    <a class="logout-button" href="?logout">Logout</a>
</body>
</html>

<?php
// Database connection setup
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT u.name, u.email, b.name AS requested_book FROM user u INNER JOIN book b ON u.requested_book = b.id WHERE u.approved IS NULL";
$result = mysqli_query($conn, $sql);

// Display the user information
if ($result->num_rows > 0) {
    echo "<h1 style='text-align: center;'>Users who requested Books </h1>";
    echo "<table style='width: 100%; border-collapse: collapse;'>
            <tr>
                <th style='border: 1px solid #ddd; padding: 8px;'>Name</th>
                <th style='border: 1px solid #ddd; padding: 8px;'>Email</th>
                <th style='border: 1px solid #ddd; padding: 8px;'>Book Name</th>
                <th style='border: 1px solid #ddd; padding: 8px;'>Action</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        $mail = $row["email"];
        echo "<tr>
                <td style='border: 1px solid #ddd; padding: 8px;'>" . $row["name"] . "</td>
                <td style='border: 1px solid #ddd; padding: 8px;'>" . $row["email"] . "</td>
                <td style='border: 1px solid #ddd; padding: 8px;'>" . $row["requested_book"] . "</td>
                <td style='border: 1px solid #ddd; padding: 8px;'>
                    <form action='' method='post'>
                        <input type'email' name='email' value='$mail'>
                        <button type='submit' name='approve' style='background-color: #4CAF50; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer;'>Approve</button>
                    </form>
                </td>
              </tr>";
    }

    echo "</table>";
    echo "<button onclick=\"window.location.href='add_book.php'\" style='background-color: #4CAF50; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; margin-top: 10px;'>Add Book</button>";

} else {
    echo "<p style='text-align: center;'>No users found who requested Book</p>";
    echo "<button onclick=\"window.location.href='add_book.php'\" style='background-color: #4CAF50; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; margin: 10px;'>Add Book</button>";
    echo "<button onclick=\"window.location.href='update.php'\" style='background-color: #4CAF50; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; margin: 10px;'>Update</button>";
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['approve']) ) {
    $userId = $_POST["email"];
    $updateSql = "UPDATE user SET approved = 1 WHERE email = '$userId'";
    $result = mysqli_query($conn, $updateSql);
    header("Refresh:0");
    exit();
}

// Close the database connection
$conn->close();
?>
