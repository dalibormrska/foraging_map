<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

require_once __DIR__ . "/RestAPI.php";
require_once __DIR__ . "/../business-logic/SpotsService.php";

// Class for handling requests to "api/spot"

class SpotsAPI extends RestAPI
{

    // Handles the request by calling the spotropriate member function
    public function handleRequest()
    {


        // If theres two parts in the path and the request method is GET 
        // it means that the client is requesting "api/spots" and
        // we should respond by returning a list of all spots 
        if ($this->path_count == 2 && $this->method == "GET") {
            $this->getAll();
        }

        // If there's three parts in the path and the request method is GET
        // it means that the client is requesting "api/spots/{something}".
        // In our API the last part ({something}) should contain the ID of a 
        // spot and we should respond with the spot of that ID
        else if ($this->path_count == 3 && $this->method == "GET") {
            $this->getById($this->path_parts[2]);
        }

        // If theres two parts in the path and the request method is POST 
        // it means that the client is requesting "api/spots" and we
        // should get ths contents of the body and create a spot.
        else if ($this->path_count == 2 && $this->method == "POST") {
            $this->postOne();
        }

        // If theres two parts in the path and the request method is PUT 
        // it means that the client is requesting "api/spots/{something}" and we
        // should get the contents of the body and update the spot.
        else if ($this->path_count == 3 && $this->method == "PUT") {
            $this->putOne($this->path_parts[2]);
        }

        // Patch
        else if ($this->path_count == 3 && $this->method == "PATCH") {
            $this->patchOne($this->path_parts[2]);
        }

        // If theres two parts in the path and the request method is DELETE 
        // it means that the client is requesting "api/spots/{something}" and we
        // should get the ID from the URL and delete that spot.
        else if ($this->path_count == 3 && $this->method == "DELETE") {
            $this->deleteOne($this->path_parts[2]);
        }

        // If none of our ifs are true, we should respond with "not found"
        else {
            $this->notFound();
        }
    }

    // Gets all spots and sends them to the client as JSON
    private function getAll()
    {
        $spots = SpotsService::getAllSpots();

        $this->sendJson($spots);
    }

    // Gets one and sends it to the client as JSON
    private function getById($id)
    {
        $spot = SpotsService::getSpotById($id);

        if ($spot) {
            $this->sendJson($spot);
        } else {
            $this->notFound();
        }
    }

    // Gets the contents of the body and saves it as a spot by 
    // inserting it in the database.
    private function postOne()
    {
        $spot = new SpotModel();

        $spot->user_id = $this->body["user_id"];
        $spot->trefle_id = $this->body["trefle_id"];
        $spot->coordinates = $this->body["coordinates"];

        $success = SpotsService::saveSpot($spot);

        if ($success) {
            $this->created();
        } else {
            $this->error();
        }
    }

    // Gets the contents of the body and updates the spot
    // by sending it to the DB
    private function putOne($id)
    {
        $spot = new SpotModel();

        $spot->user_id = $this->body["user_id"];
        $spot->trefle_id = $this->body["trefle_id"];
        $spot->coordinates = $this->body["coordinates"];

        $success = SpotsService::updateSpotById($id, $spot);

        if ($success) {
            $this->ok();
        } else {
            $this->error();
        }
    }

    // Patch
    private function patchOne($id)
    {
        $spot = SpotsService::getSpotById($id);

        if ($spot) {
            foreach ($this->body as $key => $value) {
                $spot->$key = $this->body[$key];
            }
            unset($key, $value);

            $success = SpotsService::updateSpotById($id, $spot);

            if ($success) {
                $this->noContent();
            } else {
                $this->error();
            }
        } else {
            $this->notFound();
        }
    }

    // Deletes the spot with the specified ID in the DB
    private function deleteOne($id)
    {
        $spot = SpotsService::getSpotById($id);

        if ($spot == null) {
            $this->notFound();
        }

        $success = SpotsService::deleteSpotById($id);

        if ($success) {
            $this->noContent();
        } else {
            $this->error();
        }
    }
}
