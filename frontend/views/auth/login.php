<?php
require_once __DIR__ . "/../../Template.php";

Template::header("Login", $this->model["error"]);
?>
<main class="bg-gray-100 w-full h-full">
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
        <h1 class="text-3xl text-gray-700 font-medium mt-4">Login</h1>
        <br>
        <form action="<?= $this->home ?>/auth/login" method="post" class="mt-8">
            <input type="text" name="username" placeholder="Username" class="w-64 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-400 mb-4">
            <br>
            <input type="password" name="password" placeholder="Password" class="w-64 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-400 mb-4">
            <br>
            <input type="submit" value="Log in" class="w-64 px-4 py-2 text-gray-900 border border-green-900 rounded-full px-4 py-2 hover:bg-green-800 hover:text-white">
        </form>

        <h2 class="text-orange-400 font-medium mt-4 py-8">
            Not registered?
        </h2>
        <br>
        <a class="text-gray-600 underline hover:text-green-900" href="<?= $this->home ?>/auth/register">Register user</a>

    </div>

</main>
<?php Template::footer(); ?>