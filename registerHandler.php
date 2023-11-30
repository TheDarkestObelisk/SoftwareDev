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
  $password_repeat = $_POST['psw-repeat'];
  $phoneNumber = $_POST['phoneNumber'];

  // Perform input validation here...

  // Check if the password meets the specified criteria
  if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*]).{8,}$/", $password)) {
    die('Password must contain at least one digit, one lowercase letter, one uppercase letter, one special character, and be at least 8 characters long.');
  }

  // Check if phone number is valid
  if (!preg_match("/[0-9]{10}$/", $phoneNumber)) {
    die('Phone number must be a valid 10 digit phone number.');
  }

  // Check if the repeated password matches
  if ($password !== $password_repeat) {
    die('Passwords do not match.');
  }

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
