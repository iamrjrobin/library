<!DOCTYPE html>
<html>
<head>
    <title>Calculator</title>
</head>
<body>
    <h2>Calculator</h2>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="number" name="num1" placeholder="Enter a number" required><br><br>
        <input type="number" name="num2" placeholder="Enter another number" required><br><br>
        <input type="submit" name="add" value="+">
        <input type="submit" name="subtract" value="-">
        <input type="submit" name="multiply" value="*">
    </form>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $num1 = $_POST["num1"];
        $num2 = $_POST["num2"];

        if (isset($_POST["add"])) {
            $result = $num1 + $num2;
            echo "<p>Result: $result</p>";
        }

        if (isset($_POST["subtract"])) {
            $result = $num1 - $num2;
            echo "<p>Result: $result</p>";
        }

        if (isset($_POST["multiply"])) {
            $result = $num1 * $num2;
            echo "<p>Result: $result</p>";
        }
    }
    ?>
</body>
</html>
