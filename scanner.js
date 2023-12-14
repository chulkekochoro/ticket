// Define the scanner configuration
const config = {
  inputStream: {
    name: "Live",
    type: "LiveStream",
    target: "#interactive",
    constraints: {
      width: 640,
      height: 480,
      facingMode: "environment" // use the back camera
    },
  },
  decoder: {
    readers: ["code_128_reader", "ean_reader", "ean_8_reader", "code_39_reader", "code_39_vin_reader", "codabar_reader", "upc_reader", "upc_e_reader", "i2of5_reader"],
  },
};

// Initialize the scanner with the configuration
Quagga.init(config, function(err) {
  if (err) {
    console.log(err);
    return;
  }

  // Start the scanner
  Quagga.start();

  // Add event listener for successful scans
  Quagga.onDetected(function(result) {
    console.log(result.codeResult.code); // log the scanned code
    // Redirect to the booking details page with the scanned ticket number as a parameter
    window.location.href = `booking_details.php?ticket_number=${result.codeResult.code}`;
  });
});
