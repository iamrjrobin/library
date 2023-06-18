<?php
session_start();
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
    if (mysqli_num_rows($result) == 0) {
        header("Location: view_books.php"); // Redirect to the view_books page if not an admin
        mysqli_close($conn);
        exit;
    }
}
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

if (isset($_POST['update_id'])){
    
}
else {
    header("Location: update.php");
    exit;
}
?>
