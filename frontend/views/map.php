<?php
require_once __DIR__ . "/../Template.php";

Template::header("Home");
?>

<!-- Navbar -->
<nav class="bg-gray-800 py-4">
    <div class="container mx-auto flex justify-between items-center ">
        <div class="flex items-center">
            <img src="https://via.placeholder.com/40" alt="Logo Placeholder" class="mr-2">
            <span class="text-white font-bold text-xl">Foraging Map <?=$this->home?></span>
        </div>
        <div class="flex items-center">
            <a href="#" class="text-white mr-4">Sign Up</a>
            <a href="#" class="text-white border border-white rounded-full px-4 py-2">Login</a>
        </div>
    </div>
</nav>

<!-- Left Panel and Main Content -->
<div class="flex-1 flex">
    <!-- Left Panel -->
    <div class="bg-gray-200 w-1/4 py-4 px-4">
        <p class="text-gray-700 font-medium">Placeholder Text</p>
    </div>

    <!-- Main Content -->
    <div class="bg-gray-100 w-3/4 py-4 px-4" id="map"></div>
</div>

<script>
    var map = L.map('map', {
        center: [30, 0],
        zoom: 2,
    });

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var markers = L.markerClusterGroup();

    fetch('http://localhost:8888/JU_Web/foraging_map/api/spots')
        .then(response => response.json())
        .then(spots => {
            // Loop through the spots and add markers to the map
            spots.forEach(spot => {
                markers.addLayer(L.marker([spot.lat_coord, spot.lon_coord]));
            });
        })
        .catch(error => console.error(error));

    map.addLayer(markers);
</script>

<?php Template::footer(); ?>