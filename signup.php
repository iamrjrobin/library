<!DOCTYPE html>
<html>

<head>
  <title>Signup Page</title>
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
    input[type="password"],
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
  </style>
</head>

<body>
  <h2>Signup</h2>
  <form action="" method="post">
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>

    <label for="confirm-password">Confirm Password:</label>
    <input type="password" id="confirm-password" name="confirm-password" required><br><br>

    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br><br>

    <input type="submit" value="Signup">
  </form>

  <?php

  if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $u_password = $_POST['password'];
    $confirmPassword = $_POST['confirm-password'];
    $name = $_POST['name'];


    if ($u_password !== $confirmPassword) {
      // show alert box that passwords do not match
      echo "<script>alert('Passwords do not match!');</script>";
    } else {

      $servername = "localhost";
      $username = "root";
      $password = "";
      $database = "library";

      // Create connection
      $conn = mysqli_connect($servername, $username, $password, $database);

      // Check connection
      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      }

      // check if email already exists
      $sql = "SELECT * FROM user WHERE email='$email'";
      $result = mysqli_query($conn, $sql);

      if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Email already exists!');</script>";
      } else {
        // insert into database
        // hash password
        $u_password = password_hash($u_password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user (email, password, name) VALUES ('$email', '$u_password', '$name')";
        $result = mysqli_query($conn, $sql);

        if ($result === TRUE && mysqli_affected_rows($conn)) {
          echo "<script>alert('Signup successful!');</script>";
          // create session
          session_start();
          $_SESSION['email'] = $email;
          header("Location: login.php");
          exit();
        } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
      }
      // close connection
      mysqli_close($conn);
    }
  }
  ?>
</body>

</html>
