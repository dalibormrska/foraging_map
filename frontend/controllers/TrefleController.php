<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

require_once __DIR__ . "/../ControllerBase.php";
require_once __DIR__ . "/../../business-logic/TrefleService.php";


// Class for handling requests to "trefle"

class TrefleController extends ControllerBase
{
    

    public function handleRequest($request_info)
    {
        // Trefle API Async 
        if ($this->path_count == 4 && $this->path_parts[1] == "trefle" && $this->path_parts[2] == "search") {
            $this->trefleSearch($this->path_parts[3]);
        }

        // Trefle API AJAX call
        else if ($this->path_count == 4 && $this->path_parts[1] == "trefle" && $this->path_parts[2] == "one" && is_numeric($this->path_parts[3])) {
            $this->trefleGetOne($this->path_parts[3]);
        }


        // Show "404 not found" if the path is invalid
        else {
            $this->notFound();
        }
    }


    

    private function trefleSearch($query)
    {
        $results = TrefleService::searchPlants($query);

        if (!$results) {
            $this->notFound();
        }

        header('Content-Type: application/json');
        echo json_encode($results);
    }


    private function trefleGetOne($trefle_id)
    {
        $plant = TrefleService::getPlant($trefle_id);

        if (!$plant) {
            $this->notFound();
        }

        header('Content-Type: application/json');
        echo json_encode($plant);
    }

}
