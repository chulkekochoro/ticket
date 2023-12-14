<html>
<head>
<link rel="stylesheet" href="main.css">
<script type="js/main.js"></script>
</head>
<body>
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

// Execute the SQL query to get the live count of each site
$sql = "SELECT site,SUM(num_visitors) as visitors_count FROM bookings_data GROUP BY site";
$result = mysqli_query($conn, $sql);

// Loop through the results and display the live count for each site
while ($row = mysqli_fetch_assoc($result)) {
  $site = $row['site'];
  $visitors_count = $row['visitors_count'];


  // Assign a new variable for each specific site name
  if ($site == 'Taj Mahal') {
    $tajMahalCount = $visitors_count;
  } elseif ($site == 'Ellora Caves') {
    $elloraCavesCount = $visitors_count;
  } elseif ($site == 'Qutub Minar') {
    $qutubMinarCount = $visitors_count;
  } elseif ($site == 'red fort') {
    $redfortCount = $visitors_count;
  } elseif ($site == 'Chennai Museum') {
    $ChennaimuseumCount = $visitors_count;
  }



}

mysqli_close($conn);
?>

<div class="relative flex min-h-screen flex-col items-center justify-center overflow-hidden bg-gray-50 py-6 sm:py-12">
  <div class="absolute inset-auto h-96 w-96 scale-150 bg-orange-200 opacity-20 blur-3xl"></div>

  <div class="absolute inset-auto h-96 w-96 translate-x-full scale-150 bg-green-200 opacity-20 blur-3xl"></div>
  <div class="w-full">
    <div class="max-w-lg px-10">
      <h1 class="text-5xl font-bold tracking-tight text-[#2f2963]">Must See Places In India</h1>
      <p class="mt-5 opacity-50"></p>
      
    </div>

    <div class="scrollbar-hide mt-14 flex w-full snap-x snap-mandatory scroll-px-10 gap-10 overflow-x-scroll scroll-smooth px-10">
    <div class="md:2/3 relative aspect-[2/3] w-[90%] shrink-0 snap-start snap-always rounded-xl bg-orange-100 sm:w-[44%] md:w-[30%]" onClick="handleCardClick('TajMahal')">
      <div class="absolute bottom-0 z-10 w-full rounded-xl bg-gradient-to-t from-black px-5 py-3">
        <h2 class="mt-4 text-xl font-bold text-white" >Taj Mahal</h2>
        <p class="text-sm text-white/50">New Delhi</p>
        <p class="text-sm text-white/50">visitors:<?php echo $tajMahalCount; ?></p>
      </div>
      <img src="https://img.itinari.com/pages/images/original/9f615ca8-8bbb-46a6-85a2-b4825f815ba1-44829498324_77297564a1_k.jpg?ch=DPR&dpr=1&w=1600&s=2e8624c73358e5afd755157c2c739c57" alt="image" class="h-full w-full rounded-xl object-cover" />
    </div>

      <div class="md:2/3 relative aspect-[2/3] w-[90%] shrink-0 snap-start snap-always rounded-xl bg-orange-100 sm:w-[44%] md:w-[30%]" onClick="handleCardClick('QutubMinar')">
        <div class="absolute bottom-0 z-10 w-full rounded-xl bg-gradient-to-t from-black px-5 py-3">
          <h2 class="mt-4 text-xl font-bold text-white">Qutub Minar</h2>
          <p class="text-sm text-white/50">New Delhi</p>
          <p class="text-sm text-white/50">visitors:<?php echo $qutubMinarCount; ?></p>
        </div>
        <img src="https://www.savaari.com/blog/wp-content/uploads/2022/08/marvin-castelino-z4GzALvJ8xs-unsplash-2-768x1024.jpg" class="h-full w-full rounded-xl object-cover" />
      </div>

      <div class="md:2/3 relative aspect-[2/3] w-[90%] shrink-0 snap-start snap-always rounded-xl bg-blue-100 sm:w-[44%] md:w-[30%]" onClick="handleCardClick('ElloraCaves')">
        <div class="absolute bottom-0 z-10 w-full rounded-xl bg-gradient-to-t from-black px-5 py-3">
          <h2 class="mt-4 text-xl font-bold text-white">Ellora Caves</h2>
          <p class="text-sm text-white/50">Maharashtra</p>
          <p class="text-sm text-white/50">visitors:<?php echo $elloraCavesCount; ?></p>
        </div>
        <img src="https://i0.wp.com/www.tusktravel.com/blog/wp-content/uploads/2019/10/Ajanta-and-Ellora-Caves-Aurangabad.jpg?fit=800%2C600&ssl=1" class="h-full w-full rounded-xl object-cover" />
      </div>

      <div class="md:2/3 relative aspect-[2/3] w-[90%] shrink-0 snap-start snap-always rounded-xl bg-green-100 sm:w-[44%] md:w-[30%]" onClick="handleCardClick('ChennaiMuseum')">
        <div class="absolute bottom-0 z-10 w-full rounded-xl bg-gradient-to-t from-black px-5 py-3">
          <h2 class="mt-4 text-xl font-bold text-white">Chennai Egmore Museum</h2>
          <p class="text-sm text-white/50">Tamil nadu</p>
          <p class="text-sm text-white/50">visitors:<?php echo $ChennaimuseumCount; ?></p>
        </div>
        <img src="https://images.memphistours.com/large/315709931_Government-Museum-Chennai-2-5250.jpg" />
      </div>
      <div class="md:2/3 relative aspect-[2/3] w-[90%] shrink-0 snap-start snap-always rounded-xl bg-rose-100 sm:w-[44%] md:w-[30%]" onClick="handleCardClick('RedFort')">
        <div class="absolute bottom-0 z-10 w-full rounded-xl bg-gradient-to-t from-black px-5 py-3">
          <h2 class="mt-4 text-xl font-bold text-white">Red Fort</h2>
          <p class="text-sm text-white/50">New Delhi</p>
          <p class="text-sm text-white/50">visitors:<?php echo $redfortCount; ?></p>
        </div>
        <img src="https://res.cloudinary.com/thrillophilia/image/upload/c_fill,f_auto,fl_progressive.strip_profile,g_auto,h_650,q_auto,w_576/v1/filestore/ibpx7t0bhbim3405mg9lo4zve204_shutterstock_613432859.jpg" class="h-full w-full rounded-xl object-cover" />
      </div>

    </div>
  </div>
</div>


</body>
<script type="text/javascript">
function handleCardClick(cardIdentifier) {
  // Navigate to the detail page for the clicked card with the card identifier in the query parameters
  window.location.href = `description.html?card=${cardIdentifier}`;
}

</script>

</html>

