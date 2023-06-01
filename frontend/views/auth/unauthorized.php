<?php
require_once __DIR__ . "/../../Template.php";

Template::header("Unauthorized");
?>

<main class="bg-gray-100 w-full h-full">
    <div class="flex flex-col items-center justify-center min-h-screen bg-gray-100">
        <h1 class="text-3xl text-gray-700 font-medium mt-4">Unauthorised</h1>
        <br>
        <p class="text-orange-900">
            You're not authorized to view this page
        </p>

        <?php if ($this->user) : ?>
            <p class="mt-4">
                Return home:
                <a href="<?= $this->home ?>/" class="text-gray-900 underline hover:text-green-900">Home</a>
            </p>
        <?php else : ?>
            <p class="mt-4">
                Login here:
                <a href="<?= $this->home ?>/auth/login" class="text-gray-900 underline hover:text-green-900">Login</a>
            </p>

            <p>
                Not registered?
                <a href="<?= $this->home ?>/auth/register" class="text-gray-900 underline hover:text-green-900">Register user</a>
            </p>
        <?php endif; ?>
    </div>
</main>

<?php Template::footer(); ?>