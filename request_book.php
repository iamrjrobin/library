<?php
session_start();

$userId = $_SESSION['user_id'];
$bookId = $_GET['book_id'];

$servername = "localhost";
$username = "root";
$password = "";
$database = "library";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM user WHERE email='$userId' AND requested_book IS NULL";
$result = mysqli_query($conn, $sql);


if (mysqli_num_rows($result) == 1 ) {

    $sql = "UPDATE user SET requested_book = $bookId WHERE email = $userId";
    $result = mysqli_query($conn, $sql);
    exit;
}
else {
    echo "<script>alert('You have already requested a book!');</script>";
    exit;
}   

mysqli_close($conn);
?>


