<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

require_once __DIR__ . "/../ControllerBase.php";

// Class for handling requests to "api/Spot"

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
            $this->showEditSpot($this->path_parts[1]);
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
        $this->model = $this->getOneSpot($id);

        $this->viewPage("spots/one");
    }

    private function showEditSpot($id)
    {
        $this->model = $this->getOneSpot($id);

        $this->viewPage("spots/edit");
    }





    private function getOneSpot($id)
    {
        $spot = SpotsService::getSpotById($id);

        if (!$spot) {
            $this->notFound();
        }

        return $spot;
    }






    // handle all post requests for spots in one place
    private function handlePost()
    {

        if ($this->path_count == 1) {
            $this->createSpot();
        }

        // Path count is 4 meaning the current URL must be "/map/{SOMETHING1}/{SOMETHING2}"
        // {SOMETHING1} is probably the Spot_id
        // if {SOMETHING2} is "edit" we will update the user
        else if ($this->path_count == 3 && $this->path_parts[2] == "edit") {
            $this->updateSpot();
        }

        // Path count is 4 meaning the current URL must be "/map/{SOMETHING1}/{SOMETHING2}"
        // {SOMETHING1} is probably the Spot_id
        // if {SOMETHING2} is "edit" we will show the edit form
        else if ($this->path_count == 3 && $this->path_parts[2] == "delete") {
            $this->deleteSpot();
        }

        // Show "404 not found" if the path is invalid
        else {
            $this->notFound();
        }
    }

    // Create a spot with data from the URL and body
    private function createSpot()
    {
        $spot = new SpotModel();

        var_dump($this->body);

        // Get updated properties from the body
        $spot->lat_coord = $this->body["lat_coord"];
        $spot->lon_coord = $this->body["lon_coord"];
        $spot->description = $this->body["description"];
        $spot->user_id = getUser()->user_id;

        $retrieved_type = TypesService::getTypeByTrefleId($this->body["trefle_id"]);

        if (!$retrieved_type) {

            $new_type = TrefleService::getPlant($this->body["trefle_id"]);

            $success = TypesService::saveType($new_type);

            if ($success) {
                $retrieved_type = TypesService::getTypeByTrefleId($this->body["trefle_id"]);
            } else {
                $this->error();
            }
        }

        $spot->type_id = $retrieved_type->type_id;


        // Save the spot
        $success = SpotsService::savespot($spot);

        // Redirect or show error based on response from business logic layer
        if ($success) {
            $this->redirect($this->home);
        } else {
            $this->error();
        }
    }

    // Update a user with data from the URL and body
    private function updateSpot()
    {

        $spot = new SpotModel();

        // Get ID from the URL
        $id = $this->path_parts[1];

        // Get updated properties from the body
        $spot->lat_coord = $this->body["lat_coord"];
        $spot->lon_coord = $this->body["lon_coord"];
        $spot->description = $this->body["description"];
        $spot->user_id = getUser()->user_id;


        $retrieved_type = TypesService::getTypeByTrefleId($this->body["trefle_id"]);

        if (!$retrieved_type) {

            $new_type = TrefleService::getPlant($this->body["trefle_id"]);

            $success = TypesService::saveType($new_type);

            if ($success) {
                $retrieved_type = TypesService::getTypeByTrefleId($this->body["trefle_id"]);
            } else {
                $this->error();
            }
        }

        $spot->type_id = $retrieved_type->type_id;


        // Update the spot
        $success = SpotsService::updateSpotById($id, $spot);

        // Redirect or show error based on response from business logic layer
        if ($success) {
            $this->redirect($this->home . '/' . $id);
        } else {
            $this->error();
        }
    }


    // Delete a user with data from the URL
    private function deleteSpot()
    {

        // Get ID from the URL
        $id = $this->path_parts[1];

        // Delete the spot
        $success = SpotsService::deleteSpotById($id);

        // Redirect or show error based on response from business logic layer
        if ($success) {
            $this->redirect($this->home);
        } else {
            $this->error();
        }
    }
}
