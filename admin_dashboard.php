<!DOCTYPE html>
<html>
<head>
    <title>Booking Details</title>
    <style>
        /* CSS for table */
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th, .table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #f2f2f2;
        }

        /* CSS for page layout */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8f3; /* Light green background */
            color: #333; /* Dark text color */
        }

        h1 {
            margin-top: 30px;
            margin-bottom: 20px;
            color: #007bff; /* Blue heading color */
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff; /* White container background */
            padding: 20px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); /* Container box shadow */
        }

        .btn {
            padding: 10px 16px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .search-bar {
            margin-bottom: 20px;
        }

        .search-bar input[type="text"] {
            padding: 6px 10px;
            width: 200px;
            border-radius: 4px;
            border: none;
        }

        .search-bar button {
            padding: 6px 10px;
            background-color: #007bff;
            color: #fff;
            border-radius: 4px;
            border: none;
            cursor: pointer;
        }

        .search-bar button:hover {
            background-color: #0056b3;
        }
                /* CSS for table */
        .table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .table th, .table td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .table th {
            background-color: #f2f2f2;
        }

    </style>
    <script src="html5-qrcode.min.js"></script>
    <script src="https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"></script>

</head>
<body>

    <div class="container">
        <a href="logout.php" class="logout">Logout</a>
        <h1>Booking Details</h1>
        <div class="search-bar">
            <form method="post">
              <input type="text" name="ticket_number" placeholder="Enter Ticket Number" required>

                <button type="submit" name="search">Search</button>
                <button type="submit" name="entry">Enter</button>
                <button type="submit" name="exit">Exit</button>
            </form>
        <div id="qr-reader" style="width: 600px">
        </div>

        </div>
        
 <?php
        session_start();
        if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
            if (basename($_SERVER['PHP_SELF']) != 'login.php') {
                header('Location: login.php');
                exit;
            }
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

        // Check if search form is submitted
        if (isset($_POST['search'])) {
            $ticketNumber = $_POST['ticket_number'];
            $sql = "SELECT * FROM bookings_data WHERE ticket_number = '$ticketNumber'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
            echo "<table class='table mt-4'>
                    <thead>
                        <tr>
                            <th scope='col'>Ticket Number</th>
                            <th scope='col'>Site</th>
                            <th scope='col'>Name</th>
                            <th scope='col'>State</th>
                            <th scope='col'>Nationality</th>
                            <th scope='col'>Date</th>
                            <th scope='col'>Num Visitors</th>
                            <th scope='col'>Entry Status</th>

                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>".$row['ticket_number']."</td>
                            <td>".$row['site']."</td>
                            <td>".$row['name']."</td>
                            <td>".$row['state']."</td>
                            <td>".$row['nationality']."</td>
                            <td>".$row['date']."</td>
                            <td>".$row['num_visitors']."</td>
                            <td>".$row['status']."</td>
                        </tr>
                    </tbody>
                </table>";
            } else {
                echo "No results found.";
            }
        }
      // Check if entry form is submitted
        if (isset($_POST['entry'])) {
            $ticketNumber = $_POST['ticket_number'];
            $sql = "UPDATE bookings_data SET status='Entered' WHERE ticket_number='$ticketNumber'";
            if (mysqli_query($conn, $sql)) {
                echo "Status updated to Entered.";
            } else {
                echo "Error updating status: " . mysqli_error($conn);
            } 
        }

        // Check if exit form is submitted
        if (isset($_POST['exit'])) {
            $ticketNumber = $_POST['ticket_number'];
            $sql = "UPDATE bookings_data SET status = 'invalid', num_visitors = 0 WHERE ticket_number = '$ticketNumber'";

            if (mysqli_query($conn, $sql)) {
                echo "Ticket status updated to invalid.";
            } else {
                echo "Error updating ticket status: " . mysqli_error($conn);
            }
        }

?>
    </div>
        
    </div>
    <script type="text/javascript">
    function onScanSuccess(decodedText, decodedResult) {
        console.log(`Code scanned = ${decodedText}`, decodedResult);
        document.querySelector('input[name="ticket_number"]').value = decodedText;
    }
    var html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", { fps: 10, qrbox: 250 });
    html5QrcodeScanner.render(onScanSuccess);

    document.getElementById("scan-button").addEventListener("click", function() {
        html5QrcodeScanner.scan(onScanSuccess);
    });
</script>
</body>
</html>
