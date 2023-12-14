<?php
// Get the ticket number from the URL
$ticket_number = $_GET["ticket_number"];

// Generate the QR code data as a URL to a webpage
$data = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($ticket_number);

// Generate a download link for the QR code image
$filename = "qrcode_" . $ticket_number . ".png";
echo "<div style='display:flex;justify-content:center;align-items:center;width:100%;height:100%;'><a href='" . $data . "' download='" . $filename . "'><img src='" . $data . "'></a></div>";

?>
