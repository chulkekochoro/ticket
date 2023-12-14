<?php
// view_customer.php

// Connect to the database
$servername = "localhost";
$username = "root";
$password = ""; // no password by default in XAMPP
$dbname = "ticket_booking";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Get the ticket number from the URL
$ticket_number = $_GET["ticket_number"];

// Check if the ticket number exists in the database
$sql = "SELECT * FROM bookings WHERE ticket_number = '$ticket_number'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  // Ticket number exists, get the data for the customer
  $row = mysqli_fetch_assoc($result);
  $name = $row["name"];
  $email = $row["email"];
  $phone = $row["phone"];
  $idnumber = $row["idnumber"];
  $date = $row["date"];
  $quantity = $row["quantity"];

  // Display the customer data
  echo "Name: " . $name . "<br>";
  echo "Email: " . $email . "<br>";
  echo "Phone: " . $phone . "<br>";
  echo "ID Number: " . $idnumber . "<br>";
  echo "Date: " . $date . "<br>";
  echo "Quantity: " . $quantity . "<br>";
} else {
  // Ticket number does not exist
  echo "Invalid ticket number!";
}

mysqli_close($conn);
?>