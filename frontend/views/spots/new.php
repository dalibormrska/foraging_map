<?php
require_once __DIR__ . "/../../Template.php";

Template::header("Foraging Map");

?>

<!-- Left Panel and Main Content -->
<div class="flex-1 flex">
    <!-- Left Panel -->
    <div class="bg-white w-1/4 py-4 px-4 drop-shadow-lg">
        <h2 class="text-3xl text-gray-700 font-medium">New</h2>
        <p class="text-orange-400 font-medium" id="coordinates">Click on the map...or search for a plant!</p>
        <br>
        <!-- Form -->
         <form class="mb-2" name="spot" action="<?= $this->home ?>" method="post">
        <!-- Search Bar -->
        <div id="search-bar" class="flex">
            <label for="plant-name" class="sr-only">Search </label>
            <div class="relative w-full">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <input type="number" name="type_id" id="plant-name" class="bg-white border border-green-900 text-gray-900 text-sm rounded-lg focus:ring-green-900 focus:border-orange-900 block w-full pl-10 p-2.5" placeholder="Apple" required>
            </div>
            
            <button type="submit" class="p-2.5 ml-2 text-sm font-medium text-white bg-green-900 rounded-lg border border-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <span class="sr-only">Search</span>
            </button>
        </div>
            <!-- Two Numeral Inputs for coordinates -->
            <label for="Lat" class="block mb-2 text-sm font-medium text-gray-900 ">Latitude</label>
            <input type="text" name="lat_coord" id="lat_coord" aria-describedby="helper-text-explanation" class="bg-white border border-green-700 text-gray-7 text-sm rounded-lg focus:ring-orange-900 focus:border-orange-900 block w-full p-2.5" value="">
            <label for="Lng" class="block mb-2 text-sm font-medium text-gray-900">Longitude </label>
            <input type="text" name="lon_coord" id="lon_coord" aria-describedby="helper-text-explanation" class="bg-white border border-green-700 text-gray-900 text-sm rounded-lg focus:ring-orange-900 focus:border-orange-900 block w-full p-2.5" value="">
            <label for="Description"  class="block mb-2 text-sm font-medium text-gray-900">Description</label>
            <textarea id="Description" name="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-white rounded-lg border border-green-700 focus:ring-orange-900 focus:border-orange-900" placeholder="Leave a description..."></textarea>
            <br>
            <button type="submit" class="text-white bg-green-900 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-900 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Submit</button>
        </form>
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
        document.getElementById("lat_coord").value = newPoint.getLatLng().lat;
        document.getElementById("lon_coord").value = newPoint.getLatLng().lng;
    }
</script>

<?php Template::footer(); ?>