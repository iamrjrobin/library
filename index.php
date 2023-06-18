<!DOCTYPE html>
<html>
<head>
  <title>Homepage</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 20px;
      background-color: #f1f1f1;
    }

    h2 {
      text-align: center;
      color: #333;
    }

    p {
      text-align: center;
    }

    .button-container {
      display: flex;
      justify-content: center;
      margin-top: 20px;
    }

    .button-container a {
      display: inline-block;
      margin: 10px;
      padding: 10px 20px;
      background-color: #4CAF50;
      color: white;
      text-decoration: none;
      border-radius: 4px;
      font-size: 16px;
    }

    @media (max-width: 480px) {
      h2 {
        font-size: 24px;
      }

      p {
        font-size: 14px;
      }

      .button-container {
        flex-direction: column;
        align-items: center;
      }

      .button-container a {
        margin: 5px;
      }
    }
  </style>
</head>
<body>
  <?php
  // Start the session
  session_start();

  // Check if the user is already logged in
  if (isset($_SESSION['user_id'])) {
    $userID = $_SESSION['user_id'];
    // You can perform any action or display personalized content for the logged-in user here
    echo "<h2>Welcome back, User ID: $userID!</h2>";
    echo "<p>You are already logged in.</p>";
    echo "<div class='button-container'>";
    echo "<a href='logout.php'>Logout</a>";
    echo "</div>";
    // add button to show all books
    echo "<div class='button-container'>";
    echo "<a href='view_books.php'>Show All Books</a>";
  } else {
    // The user is not logged in, display login and signup options
    echo "<h2>Welcome to the Homepage!</h2>";
    echo "<p>Please log in or sign up to continue:</p>";
    echo "<div class='button-container'>";
    echo "<a href='login.php'>Login</a>";
    echo "<a href='signup.php'>Sign Up</a>";
    echo "</div>";
  }
  ?>
</body>
</html>
