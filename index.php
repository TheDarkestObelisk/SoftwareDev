<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  background-color: white;
}

* {
  box-sizing: border-box;
}

.container {
  padding: 16px;
  background-color: white;
}
</style>
</head>
<body>

<form method="post" action=""> <!-- Add form tag and action attribute -->
  <input type="text" placeholder="Enter Username" name="username" id="username" required>
  <br><br>
  <input type="password" placeholder="Enter Password" name="psw" id="psw" required>
  <hr>
  <button type="submit" class="registerbtn">Login</button>
</form> <!-- Close the form tag here -->

<div class="container signin">
  <p>Don't have an account? <a href="register.php">Register</a>.</p>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve form data
  $uname = $_POST['username'];
  $password = $_POST['psw'];

  // Database configuration
  $host = 'localhost';
  $db_username = 'root';
  $db_password = '';
  $database = 'information';
  $table = 'regInfo';

  // Create a database connection
  $conn = new mysqli($host, $db_username, $db_password, $database);

  // Check the connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // Prepare the SQL query
  $sql = "SELECT * FROM $table WHERE username = '$uname' AND password = '$password'";

  // Execute the query
  $result = $conn->query($sql);

  // Check if a matching record is found
  if ($result->num_rows > 0) {
    echo "<p>Login successful!</p>";
  } else {
    echo "<p>Invalid username or password.</p>";
  }

  // Close the database connection
  $conn->close();
}
?>
</body>
</html>
