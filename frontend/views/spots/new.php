<?php
require_once __DIR__ . "/../../Template.php";

Template::header("Foraging Map");

?>

<!-- Left Panel and Main Content -->
<div class="flex-1 flex">
    <!-- Left Panel -->
    <div class="bg-gray-200 w-1/4 py-4 px-4">
        <h2 class="text-3xl text-gray-700 font-medium">New</h2>
        <p class="text-gray-700 font-medium" id="coordinates">Click on the map...</p>
    </div>

    <!-- Main Content -->
    <div class="bg-gray-100 w-3/4 py-4 px-4" id="map"></div>
</div>

<script>
    let map = L.map('map', {
        center: [30, 0],
        zoom: 2,
    });

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    let markers = L.markerClusterGroup();

    let spots = <?= json_encode(SpotsService::getAllSpots()); ?>;

    spots.forEach(spot => {
        markers.addLayer(L.marker([spot.lat_coord, spot.lon_coord]).on('click', function(e) {
            window.location = "<?= $this->home ?>/" + spot.spot_id;
        }));
    });

    map.addLayer(markers);



    // New point

    let newPoint;

    map.on('click', function(e) {
        if (!newPoint) {
            newPoint = new L.marker([e.latlng.lat, e.latlng.lng], {
                draggable: true
            }).addTo(map);

            defineOnDrag();
        } else {
            newPoint.setLatLng(e.latlng);
        }

        updateCoordinates()
    })

    function defineOnDrag() {
        newPoint.on('move', function(e) {
            updateCoordinates();
        })
    }

    function updateCoordinates() {
        document.getElementById("coordinates").innerHTML = newPoint.getLatLng();
    }
</script>

<?php Template::footer(); ?>