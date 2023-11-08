<?php
// Database configuration
$host = 'localhost'; // Change this if your database server is different
$username = 'root'; // Replace with your MySQL username
$password = ''; // Replace with your MySQL password
$database = 'information'; // Replace with your database name
$table = 'regInfo';

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve form data
  $uname = $_POST['username'];
  $email = $_POST['email'];
  $password = $_POST['psw'];

  // Perform input validation here...

  // Generate a random salt
  $salt = bin2hex(random_bytes(16));

  // Hash the password with the salt using bcrypt
  $hashedPassword = password_hash($password . $salt, PASSWORD_BCRYPT, ['cost' => 12]);

  // Insert data into the 'regInfo' table with the hashed password and salt
  $sql = "INSERT INTO regInfo (username, password, email, salt) VALUES ('$uname', '$hashedPassword', '$email', '$salt')";

  if ($conn->query($sql) === TRUE) {
    echo 'Registration successful!';
  } else {
    echo 'Error: ' . $sql . '<br>' . $conn->error;
  }
}

// Close the database connection
$conn->close();
?>
