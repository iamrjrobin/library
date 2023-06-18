<?php
// Start the session
session_start();

// Check if the user is already logged in, redirect to the home page
if (isset($_SESSION['email'])) {
    // if the user is admin then redirect to admin page else redirect to view_books page
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "library";

    $session_email = $_SESSION['email'];

    $conn = mysqli_connect($servername, $username, $password, $database);
    // Check connection
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    // sql to check the user is admin or not
    $sql = "SELECT * FROM user WHERE email='$session_email' AND is_admin=1";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 0) {
        header("Location: view_books.php");
        mysqli_close($conn);
        exit;
    }
    else {
        header("Location: admin.php");
        mysqli_close($conn);
        exit;
    }

}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $email = $_POST['email'];
    $u_password = $_POST['password'];

    // Connect to MySQL server
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "library";

    $conn = mysqli_connect($servername, $username, $password, $database);
    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    //  check the email exists or not
    $sql = "SELECT * FROM user WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 0) {
        echo "<script>alert('Email does not exist!');</script>";
    }

    // get the user
    // hashed password
    $hash_pass = mysqli_fetch_assoc($result)['password'];

    if (password_verify($u_password, $hash_pass) == false) {
        echo "<script>alert('Incorrect password or email!');</script>";
        mysqli_close($conn);
        exit;
    }

    else {
      // if the user is admin then redirect to admin page
      $sql = "SELECT * FROM user WHERE email='$email' AND is_admin=1";
      $result = mysqli_query($conn, $sql);
      // set session
      $_SESSION['user_id'] = $email;

      if(mysqli_num_rows($result) == 0) {
          header("Location: view_books.php");
          mysqli_close($conn);
          exit;
      }
      else {
          header("Location: admin.php");
          mysqli_close($conn);
          exit;
      }
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login Page</title>
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

    form {
      max-width: 400px;
      margin: 0 auto;
      background-color: #ffffff;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    label {
      font-weight: bold;
    }

    input[type="email"],
    input[type="password"] {
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
  </style>
</head>
<body>
  <h2>Login</h2>
  <form action="" method="post">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <input type="submit" value="Login">

    <p>Don't have an account? <a href="signup.php">Signup here</a>.</p>
  </form>
</body>
</html>
