<?php
require_once __DIR__ . "/../Template.php";

Template::header("Foraging Map");
?>


<!-- Main Content -->
<div class="bg-gray-100 w-full h-full py-4 px-4" id="map"></div>

<script>

    // Create a map
    var map = L.map('map', {
        center: [30, 0],
        zoom: 2,
    });

    // Call tiling API of Open Street Map
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    // Creating a cluster of markers (using leaflet cluster plugin)
    var markers = L.markerClusterGroup();

    // Reading data in model sent from MapController and saving is as spots
    let spots = <?= json_encode($this->model); ?>;

    // Looping through each spot and adding it to markers cluster
    spots.forEach(spot => {
        markers.addLayer(L.marker([spot.lat_coord, spot.lon_coord]).on('click', function(e) {
            window.location = "<?= $this->home ?>/" + spot.spot_id;
        }));
    });

    // Adding the cluster of markers to the map, the plugin dynamicly takes care of grouping
    map.addLayer(markers);
</script>



<?php Template::footer(); ?>