<?php
require_once __DIR__ . "/../../Template.php";

Template::header("Foraging Map");

$type = TypesService::getTypeById($this->model->type_id);
$user = UsersService::getUserById($this->model->user_id);
?>



<!-- Left Panel and Main Content -->
<div class="flex-1 flex">
    <!-- Left Panel -->
    <div class="bg-gray-200 w-1/4 py-4 px-4">
        <h2 class="text-3xl text-gray-700 font-medium"><?= $type->common_name ?></h2>
        <p class="text-gray-400 font-medium"><?= $type->scientific_name ?></p>
        <br>
        <p class="text-gray-700 font-medium"><?= $user->user_name ?></p>
        <p class="text-gray-700 font-medium"><?= $this->model->lon_coord . ", " . $this->model->lat_coord ?></p>
        <br>
        <a class="text-blue-700 underline" href="<?= $this->home ?>/<?= $this->path_parts[1] ?>/edit">Edit spot</a>
    </div>

    <!-- Main Content -->
    <div class="bg-gray-100 w-3/4 py-4 px-4" id="map"></div>
</div>

<script>
    let map = L.map('map', {
        center: [<?= $this->model->lat_coord ?>, <?= $this->model->lon_coord ?>],
        zoom: 14,
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
</script>

<?php Template::footer(); ?>