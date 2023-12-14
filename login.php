<?php
session_start();
$_SESSION['loggedin'] = false;


// Check if the user is already logged in
if(isset($_SESSION['admin'])) {
  header('Location: admin_dashboard.php');
  exit;
}

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

// Handle the create account form submission
if(isset($_POST['create_account'])) {
  // Get the form data
  $username = $_POST['new-username'];
  $password = $_POST['new-password'];

  // Check if the username already exists in the database
  $sql = "SELECT * FROM users WHERE username='$username'";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    $errorMessage = 'Username already exists.';
  } else {
    // Add the new user to the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";
    mysqli_query($conn, $sql);

    $successMessage = 'Account created successfully.';
  }
}

// Handle the login form submission
if(isset($_POST['login'])) {
  // Get the form data
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Check if the username exists in the database
  $sql = "SELECT * FROM users WHERE username='$username'";
  $result = mysqli_query($conn, $sql);

  if(mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $hashedPassword = $row['password'];

    // Check if the password is correct
    if(password_verify($password, $hashedPassword)) {
      // If the login is successful, set the session variable and redirect to the admin page
      $_SESSION['loggedin'] = true;
      $_SESSION['admin'] = true;
      header('Location: admin_dashboard.php');
      exit;
    } else {
      $errorMessage = 'Invalid username or password.';
    }
  } else {
    $errorMessage = 'Invalid username or password.';
  }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<head>
  
  <title>Admin Login page</title>

  <style type="text/css">
    body {
  font-family: Arial, sans-serif;
  background-color: #f5f5f5;
}

.form-container {
  display: flex;
  flex-direction: row;
  justify-content: center;
  align-items: center;
  margin-top: 50px;
}

.form-card {
  max-width: 400px;
  padding: 50px;
  border: 1px solid #ccc;
  border-radius: 5px;
  background-color: #fff;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
  margin: 60px;
}

h2 {
  text-align: center;
  font-size: 30px;
  margin-bottom: 20px;
}
h1 {
  text-align: center;
}
form {
  display: flex;
  flex-direction: column;
}

.form-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 20px;
}

label {
  font-size: 18px;
  margin-bottom: 5px;
}

input[type="text"],
input[type="password"] {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 18px;
}

button[type="submit"] {
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 5px;
  padding: 10px;
  font-size: 18px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button[type="submit"]:hover {
  background-color: #3e8e41;
}

  </style>
</head>
<body>
  <h1>Admin Login</h1>

  <?php if(isset($errorMessage)) { ?>
    <p><?php echo $errorMessage; ?></p>
  <?php } ?>

  <?php if(isset($successMessage)) { ?>
    <p><?php echo $successMessage; ?></p>
  <?php } ?>

<div class="form-container">
  <div class="form-card">
    <h2>Login</h2>
    <form method="POST">
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
      </div>
      <button type="submit" name="login">Login</button>
    </form>
  </div>

  <div class="form-card">
    <h2>Create Account</h2>
    <form method="POST">
      <div class="form-group">
        <label for="new-username">New Username:</label>
        <input type="text" id="new-username" name="new-username" required>
      </div>
      <div class="form-group">
        <label for="new-password">New Password:</label>
        <input type="password" id="new-password" name="new-password" required>
      </div>
      <button type="submit" name="create_account">Create Account</button>
    </form>
  </div>
</div>

</body>
</html>
