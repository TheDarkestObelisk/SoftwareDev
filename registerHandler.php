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

  // Insert data into the 'users' table
  $sql = "INSERT INTO regInfo (username, password, email) VALUES ('$uname','$password','$email')";

  if ($conn->query($sql) === TRUE) {
    echo 'Registration successful!';
  } else {
    echo 'Error: ' . $sql . '<br>' . $conn->error;
  }
}

// Close the database connection
$conn->close();
?>