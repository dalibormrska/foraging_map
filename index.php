<?php

// Define global constant to prevent direct script loading 
define('MY_APP', true);

// Load the router responsible for handling API requests
require_once __DIR__ . "/config.php";
require_once __DIR__ . "/api/APIRouter.php";
require_once __DIR__ . "/frontend/FrontendRouter.php";

// Get URL path
$path = $_GET["path"];
$path_parts = explode("/", $path);
$base_path = strtolower($path_parts[0]);
$query_params = $_GET;

// If the URL path starts with "api", load the API
if ($base_path == "api" && count($path_parts) > 1) {

    // Handle requests using the API router
    $api = new APIRouter($path_parts, $query_params);
    $api->handleRequest();
} else if ($base_path == "map") {
    // Handle requests using the Frontend router
    $frontend = new FrontendRouter($path_parts, $query_params);
    $frontend->handleRequest();
} else { 
    header("Location: map");
    die();
}
