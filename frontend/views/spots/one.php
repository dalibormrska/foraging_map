<?php
require_once __DIR__ . "/../../Template.php";

Template::header("Foraging Map");

$type = TypesService::getTypeById($this->model->type_id);
$user = UsersService::getUserById($this->model->user_id);
$spot = SpotsService::getSpotById($this->model->spot_id);
?>



<!-- Left Panel and Main Content -->
<div class="flex-1 flex flex-row">
    <!-- Left Panel -->
    <div class="bg-white w-1/4 py-4 px-4">
        <h2 class="text-3xl text-gray-700 font-bold"><?= $type->common_name ?></h2>
        <p class="text-gray-400 font-medium"><?= $type->scientific_name ?></p>
        <hr class="h-px mt-1 mb-4 bg-gray-200 border-0 dark:bg-gray-300">

        <?php if ($type->image_url) : ?>

            <div class="mb-4 rounded-lg overflow-hidden hover:overflow-auto">
                <img src="<?= $type->image_url ?>" alt="Image of <?= $type->common_name ?>" class="w-full object-cover h-48 hover:object-scale-down hover:h-auto">
            </div>

        <?php endif; ?>

        <div class="user-icon">
            <div class="relative w-10 h-10 overflow-hidden bg-gray-100 rounded-full dark:bg-gray-600 mb-3">
                <svg class="absolute w-12 h-12 text-gray-400 -left-1 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div>
                <div class="text-gray-400 font-medium">Created by <p class="text-gray-900"><?= $user->username ?></p>
                </div>
                <div class="text-sm text-gray-400 mb-2"><?= $spot->creation_date ?></div>
            </div>

            <p class="text-gray-400 font-medium">Location</p>
            <p class="text-gray-800 font-medium mb-2"><?= $this->model->lon_coord . ", " . $this->model->lat_coord ?></p>
            <p class="text-gray-400 font-medium">Description</p>
            <p class="h-auto pr-2 py-1 text-left text-gray-600 font-medium text-sm mb-2"><?= $spot->description ?></p>
            <br>
            <?php if ($this->user) : ?>
                <?php if ($this->user->user_id === $user->user_id || $this->user->user_role === 1) : ?>
                    <a class="text-green-700 border border-green-700 rounded-full px-4 py-2 hover:bg-green-700 hover:text-orange-50" href="<?= $this->home ?>/<?= $this->path_parts[1] ?>/edit">Edit spot</a>
                <?php else : ?>
                    <h2 class="text-orange-400 font-medium mt-4 py-8">
                        Only creator can edit. </h2>
                    <a class="text-green-700 border border-green-700 rounded-full px-4 py-2 mt-2 hover:bg-green-700 hover:text-orange-50" href="<?= $this->home ?>/new">Create spot</a>

                <?php endif; ?>
            <?php else : ?>
                <h2 class="text-orange-400 font-medium mt-4 py-8">
                    Login to edit or create a spot.
                </h2>
            <?php endif; ?>
        </div>
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