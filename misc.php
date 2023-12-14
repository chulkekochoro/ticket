<?php
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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Generate a unique ticket number
    $ticket_number = uniqid();

    // Insert form data into the "bookings_data" table using prepared statement
    $sql = "INSERT INTO bookings_data (site, date, name, email, phone, city, state, nationality, num_visitors, ticket_number)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssssis", $_POST["select-site"], $_POST["visit-date"], $_POST["name"], $_POST["email"], $_POST["phone"], $_POST["city"], $_POST["state"], $_POST["nationality"], $_POST["num-visitors"], $ticket_number);

    if (mysqli_stmt_execute($stmt)) {
      // Redirect to the QR code generator
      header("Location: qr_generate.php?ticket_number=$ticket_number");
      exit;
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>
