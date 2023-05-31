<?php
require_once __DIR__ . "/../../Template.php";
require_once __DIR__ . "/../../../business-logic/TrefleService.php";

Template::header("Foraging Map");

// var_dump(TrefleService::getPlant(96555));
?>


<!-- Left Panel and Main Content -->
<div class="flex-1 flex">
    <!-- Left Panel -->
    <div class="bg-white w-1/4 py-4 px-4 drop-shadow-lg">
        <h2 class="text-3xl text-gray-700 font-medium">New</h2>
        <p class="text-orange-400 font-medium" id="coordinates">Click on the map, and search for a plant!</p>
        <br>
        <!-- Form -->







        <form class="mb-2" name="spot" action="<?= $this->home ?>" method="post">
            <!-- Search Bar -->
            <div id="search-bar" class="flex">
                <div class="relative w-full mb-4">
                    <label for="plant-name" class="sr-only">Search</label>

                    <!-- Combobox input -->
                    <input id="combobox" name="plant-name" type="text" class="bg-white border border-green-700 p-2.5 pr-12 rounded-lg shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 text-sm w-full" role="combobox" aria-controls="options" aria-expanded="false" required>

                    <input type="hidden" id="trefle_id" name="trefle_id" value="">


                    <!-- Arrows icon in the input -->
                    <button type="button" class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
                        <!-- Heroicon name: solid/selector -->
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>



                    <!-- List of results -->
                    <ul class="absolute invisible z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm" id="options" role="listbox">
                    </ul>
                </div>


            </div>
            <!-- Two Numeral Inputs for coordinates -->
            <label for="Lat" class="block mb-2 text-sm font-medium text-gray-900 ">Latitude</label>
            <input type="text" name="lat_coord" id="lat_coord" aria-describedby="helper-text-explanation" class="mb-4 bg-white border border-green-700 p-2.5 pr-12 rounded-lg shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 text-sm w-full" value="" required>

            <label for="Lng" class="block mb-2 text-sm font-medium text-gray-900">Longitude </label>
            <input type="text" name="lon_coord" id="lon_coord" aria-describedby="helper-text-explanation" class="mb-4 bg-white border border-green-700 p-2.5 pr-12 rounded-lg shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 text-sm w-full" value="" required>

            <label for="Description" class="block mb-2 text-sm font-medium text-gray-900">Description</label>
            <textarea id="Description" name="description" rows="4" class="mb-4 bg-white border border-green-700 p-2.5 pr-12 rounded-lg shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-1 focus:ring-indigo-500 text-sm w-full" placeholder="Leave a description..."></textarea>

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
        // document.getElementById("coordinates").innerHTML = newPoint.getLatLng();
        document.getElementById("lat_coord").value = newPoint.getLatLng().lat;
        document.getElementById("lon_coord").value = newPoint.getLatLng().lng;
    }






    // TrefleAPI Combobox
    const plant_input = document.getElementById("combobox")
    const trefle_input = document.getElementById('trefle_id')
    const result_container = document.getElementById('options')
    const search_bar_div = document.getElementById('search-bar')


    plant_input.addEventListener('input', showList);
    plant_input.addEventListener('focus', showList);

    function showList(e) {
        // Clear previous results
        result_container.innerHTML = '';


        if (e.target.value.length >= 2) {

            fetch('<?= $this->home ?>/trefle/search/' + e.target.value)
                .then(response => response.json())
                .then(data => {


                    // Process the received data here
                    data.data.forEach(item => {

                        const is_selected = item.id == trefle_input.value ? true : false

                        createComboList(item.common_name, item.scientific_name, item.id, is_selected)
                    });

                    result_container.classList.remove('invisible')

                })
                .catch(error => {
                    console.error(error);
                });

        } else {
            result_container.classList.add('invisible')
        }
    }


    search_bar_div.addEventListener('blur', closeList);

    function closeList() {
        result_container.classList.add('invisible')
    }






    function createComboList(first_text, second_text, trefle_id, is_selected) {
        const li = document.createElement('li');
        li.className = 'relative cursor-default select-none py-2 pl-3 pr-9 text-gray-900'
        li.id = trefle_id

        const div = document.createElement('div');
        div.className = 'flex';

        const span1 = document.createElement('span');
        span1.className = 'truncate mr-2';
        span1.textContent = first_text;

        const span2 = document.createElement('span');
        span2.className = 'truncate text-gray-500';
        span2.textContent = second_text;

        div.appendChild(span1);
        div.appendChild(span2);

        const spanIcon = document.createElement('span')
        spanIcon.className = 'absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600'

        const svgIcon = document.createElement('svg')
        svgIcon.setAttribute('class', 'h-5 w-5')
        svgIcon.setAttribute('xmlns', 'http://www.w3.org/2000/svg')
        svgIcon.setAttribute('viewBox', '0 0 20 20')
        svgIcon.setAttribute('fill', 'currentColor')
        svgIcon.setAttribute('aria-hidden', 'true')

        svgIcon.innerHTML = "<svg class='h-5 w-5' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='currentColor' aria-hidden='true'><path fill-rule='evenodd' d='M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z' clip-rule='evenodd' /></svg>"


        spanIcon.appendChild(svgIcon);


        li.appendChild(div);
        if (is_selected) li.appendChild(spanIcon);


        li.addEventListener('mouseenter', function(e) {
            li.classList.remove('text-gray-900')
            li.classList.add('text-white', 'bg-indigo-600')

            span2.classList.remove('text-gray-500')
            span2.classList.add('text-slate-300')

            spanIcon.classList.remove('text-indigo-600')
            spanIcon.classList.add('text-white')
        })

        li.addEventListener('mouseleave', function(e) {
            li.classList.remove('text-white', 'bg-indigo-600')
            li.classList.add('text-gray-900')

            span2.classList.remove('text-slate-300')
            span2.classList.add('text-gray-500')

            spanIcon.classList.remove('text-white')
            spanIcon.classList.add('text-indigo-600')
        })

        li.addEventListener('click', function(e) {
            plant_input.value = first_text;
            trefle_input.value = trefle_id;

            closeList()
        })

        // Append the li element to the result container
        result_container.appendChild(li);
    }
</script>

<?php Template::footer(); ?>