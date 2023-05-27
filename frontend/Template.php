<?php

class Template
{
    public static function header($title)
    {
        $home_path = getHomePath();
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script src="https://cdn.tailwindcss.com"></script>

            <!-- Leaflet CSS -->
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI=" crossorigin="" />

            <!-- MarkerCluster CSS -->
            <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.1.0/dist/MarkerCluster.css" />
            <link rel="stylesheet" href="https://unpkg.com/leaflet.markercluster@1.1.0/dist/MarkerCluster.Default.css" />

            <!-- Leaflet JS -->
            <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js" integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM=" crossorigin=""></script>

            <!-- MarkerCluster JS -->
            <script src="https://unpkg.com/leaflet.markercluster@1.1.0/dist/leaflet.markercluster.js"></script>

            <title><?= $title ?></title>
        </head>

        <body class="h-screen flex flex-col">
            <!-- <img src="/assets/img/header-bg.jpg" alt=""> -->

            <!-- Navbar -->
            <nav class="bg-green-800 py-4 drop-shadow-xl">
                <div class="container mx-auto flex justify-between items-center">
                    <div class="flex items-center rounded-lg">
                        <span class="text-orange-50 font-bold text-xl">Foraging Map</span>
                    </div>
                    <div class="flex items-center">
                        <a href="#" class="text-orange-50 mr-8 hover:underline underline-offset-4 ">Sign Up</a>
                        <a href="#" class="text-orange-50 border border-orange-50 rounded-full px-4 py-2 hover:bg-orange-50 hover:text-green-800">Login</a>
                    </div>
                </div>
            </nav>

        <?php }



    public static function footer()
    {
        ?>
        </body>

        </html>
<?php }
}
