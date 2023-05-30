<?php
require_once __DIR__ . "/../Template.php";

Template::header("404: Not found");
?>

<main class="bg-gray-100 w-full h-full">
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
        <h1 class="text-3xl text-orange-700 font-medium mt-2">Not Found</h1>
        <br>
        <p class="text-gray-900">
            Sorry, the page you are looking for cannot be found. Please check the URL for mistakes and try again.
            If you think something is broken, please let us know so we can fix it as soon as possible.
        </p>
    </div>
</main>

<?php Template::footer(); ?>