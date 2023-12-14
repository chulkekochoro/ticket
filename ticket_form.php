<?php
require_once "phpqrcode/qrlib.php";

// Connect to the database
$servername = "localhost";
$username = "root";
$password = ""; // no password by default in XAMPP
$dbname = "booking_data";

$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Get the ticket number from the URL
$ticket_number = $_GET["ticket_number"];

// Check if the ticket number exists in the database
$sql = "SELECT * FROM bookings_data WHERE ticket_number = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $ticket_number);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
  // Ticket number exists, get the data for the QR code
  $row = mysqli_fetch_assoc($result);
  $name = $row["name"];
  $email = $row["email"];
  $phone = $row["phone"];
  $city = $row["city"];
  $state = $row["state"];
  $nationality = $row["nationality"];
  $numVisitors = $row["num_visitors"];

  // Generate the QR code data
  $qr_code_data = "Name: " . $name . "\n" .
                  "Email: " . $email . "\n" .
                  "Phone: " . $phone . "\n" .
                  "City: " . $city . "\n" .
                  "State: " . $state . "\n" .
                  "Nationality: " . $nationality . "\n" .
                  "Number of Visitors: " . $numVisitors;

  // Generate the QR code image and display it
  QRcode::png($qr_code_data, false, QR_ECLEVEL_Q, 5, 0);
  exit;
} else {
  // Ticket number does not exist
  echo "Invalid ticket number!";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
