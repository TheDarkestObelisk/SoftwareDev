<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
      background-color: black;
      color: white;
    }

    * {
      box-sizing: border-box;
    }

    .container {
      padding: 16px;
      background-color: white;
    }

    /* Full-width input fields */
    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 15px;
      margin: 5px 0 22px 0;
      display: inline-block;
      border: none;
      background: #f1f1f1;
    }

    input[type="text"]:focus, input[type="password"]:focus {
      background-color: #ddd;
      outline: none;
    }

    /* Overwrite default styles of hr */
    hr {
      border: 1px solid #f1f1f1;
      margin-bottom: 25px;
    }

    /* Set a style for the submit button */
    .registerbtn {
      background-color: #04AA6D;
      color: white;
      padding: 16px 20px;
      margin: 8px 0;
      border: none;
      cursor: pointer;
      width: 100%;
      opacity: 0.9;
    }

    .registerbtn:hover {
      opacity: 1;
    }

    /* Add a blue text color to links */
    a {
      color: dodgerblue;
    }

    /* Set a grey background color and center the text of the "sign in" section */
    .signin {
      background-color: #f1f1f1;
      text-align: center;
    }

    input[type="checkbox"] {
      margin-top: 10px;
    }
  </style>

  <script>
    function togglePasswordVisibility() {
      var passwordInput = document.getElementById("psw");
      var checkbox = document.getElementById("showPasswordCheckbox");

      if (checkbox.checked) {
        passwordInput.type = "text";
      } else {
        passwordInput.type = "password";
      }
    }
  </script>
</head>

<body>

  <form method="post" action="">
    <!-- Add form tag and action attribute -->
    <label for="username"><b>Username</b></label><br>
    <input type="text" placeholder="Enter Username" name="username" id="username" required>
    <br><br>

    <label for="psw"><b>Password</b></label><br>
    <input type="password" placeholder="Enter Password" name="psw" id="psw" required>
    <input type="checkbox" id="showPasswordCheckbox" onclick="togglePasswordVisibility()"> Show Password
    <div id="strengthBadge"></div>
    <hr>
    <button type="submit" class="registerbtn">Login</button>
  </form>

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

  // Prepare the SQL query to fetch the user's hashed password and salt
  $sql = "SELECT password, salt FROM $table WHERE username = '$uname'";

  // Execute the query
  $result = $conn->query($sql);

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $storedPassword = $row['password'];
    $salt = $row['salt'];

    // Hash the provided password with the retrieved salt
    $hashedInputPassword = password_hash($password . $salt, PASSWORD_BCRYPT, ['cost' => 12]);

    // Compare the newly hashed input password with the stored password
    if (password_verify($password . $salt, $storedPassword)) {
      echo "<p>Login successful!</p>";
    } else {
      echo "<p>Invalid username or password.</p>";
    }
  } else {
    echo "<p>Invalid username or password.</p>";
  }

  // Close the database connection
  $conn->close();
}
?>
</body>
</html>
