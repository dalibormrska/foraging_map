<?php

class Template
{
    public static function header($title, $error = false)
    {
        $home_path = getHomePath();
        $user = getUser();

?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">

            <!-- Linking adobe fonts -->
            <link rel="stylesheet" href="https://use.typekit.net/dxm1csy.css">

            <!-- CSS stylesheet, check README.md -->
            <link href="<?= $home_path ?>/assets/css/output.css" rel="stylesheet">



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
            <nav class="bg-orange-50 py-4 drop-shadow-xl">
                <div class="container mx-auto flex justify-between items-center">
                    <div class="flex items-center rounded-lg">
                        <a href="<?= $home_path ?>"><img src="<?= $home_path ?>/assets/img/Logo-13.svg" class="h-8 mr-3" alt="Forage Logo" /></a>
                    </div>
                    <div class="flex items-center">
                        <?php if ($user) : ?>
                            <p class="px-8">
                                Aloha, <b class="text-orange-600"><?= $user->username ?></b>
                            </p>
                            <a href="<?= $home_path ?>/auth/logout" class="text-gray-900 border border-green-900 rounded-full px-4 py-2 hover:bg-green-800 hover:text-white">Log Out</a>
                            <a href="<?= $home_path ?>/new" class="text-gray-900 border border-green-900 rounded-full ml-4 px-4 py-2 hover:bg-green-800 hover:text-white">New Spot</a>
                        <?php else : ?>
                            <a href="<?= $home_path ?>/auth/register" class="text-gray-900 mr-8 hover:underline underline-offset-4 ">Sign Up</a>
                            <a href="<?= $home_path ?>/auth/login" class="text-gray-900 border border-green-900 rounded-full px-4 py-2 hover:bg-green-800 hover:text-white">Login</a>
                        <?php endif; ?>

                    </div>
                </div>
            </nav>
            <!-- Main -->
            <?php if ($error) : ?>
                <div class="error">
                    <p><?= $error ?></p>
                </div>
            <?php endif; ?>

        <?php
    }



    public static function footer()
    {
        ?>
        </body>


        </html>
<?php }
}
