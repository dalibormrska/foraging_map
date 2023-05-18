<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

require_once __DIR__ . "/../ControllerBase.php";

// Class for handling requests to "api/Customer"

class MapController extends ControllerBase
{

    public function handleRequest($request_info)
    {
        // Check for POST method before checking any of the GET-routes
        if ($this->method == "POST") {
            $this->handlePost();
        }



        // Path count is 1 meaning the current URL must be "/map"
        // Load start page for spots
        if ($this->path_count == 1) {
            $this->showAll();
        }

        // Path count is 2 meaning the current URL must be "/map/{SOMETHING}"
        // if {SOMETHING} id "new" we want to show the form for creating a spot
        else if ($this->path_count == 2 && $this->path_parts[1] == "new") {
            $this->showCreateNewSpot();
        }

        // Path count is 3 meaning the current URL must be "/map/{SOMETHING}"
        // {SOMETHING} is probably the spot_id
        else if ($this->path_count == 2 && is_numeric($this->path_parts[1])) {
            $this->showOne($this->path_parts[1]);
        }


        // Path count is 4 meaning the current URL must be "/map/{SOMETHING1}/{SOMETHING2}"
        // {SOMETHING1} is probably the spot_id
        // if {SOMETHING2} is "edit" we will show the edit form
        else if ($this->path_count == 3 && is_numeric($this->path_parts[1]) && $this->path_parts[2] == "edit") {
            $this->showEditSpot();
        }

        // Show "404 not found" if the path is invalid
        else {
            $this->notFound();
        }
    }

    private function showAll()
    {
        $this->model = SpotsService::getAllSpots();

        $this->viewPage("map");
    }

    private function showCreateNewSpot()
    {
        $this->model = SpotsService::getAllSpots();

        $this->viewPage("spots/new");
    }

    private function showOne($id)
    {
        $this->model = SpotsService::getSpotById($id);

        $this->viewPage("spots/one");
    }

    private function showEditSpot()
    {
        $this->model = SpotsService::getAllSpots();

        $this->viewPage("map");
    }

    private function handlePost()
    {
        $this->model = SpotsService::getAllSpots();

        $this->viewPage("map");
    }
}
