<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

// Use "require_once" to load the files needed for the class

require_once __DIR__ . "/Database.php";
require_once __DIR__ . "/../models/SpotModel.php";

class SpotsDatabase extends Database
{
    private $table_name = "spots";
    private $p_key = "spot_id";

    // Get one spot by using the inherited function getOneRowByIdFromTable
    public function getOne($spot_id)
    {
        $result = $this->getOneRowByIdFromTable($this->table_name, $this->p_key, $spot_id);

        $spot = $result->fetch_object("SpotModel");

        return $spot;
    }


    // Get all spots by using the inherited function getAllRowsFromTable
    public function getAll()
    {
        $result = $this->getAllRowsFromTable($this->table_name);

        $spots = [];

        while ($spot = $result->fetch_object("SpotModel")) {
            $spots[] = $spot;
        }

        return $spots;
    }

    // Create one by creating a query and using the inherited $this->conn 
    public function insert(SpotModel $spot)
    {
        $query = "INSERT INTO spots (user_id, type_id, lat_coord, lon_coord) VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("iiss", $spot->user_id, $spot->type_id, $spot->lat_coord, $spot->lon_coord);

        $success = $stmt->execute();

        return $success;
    }

    // Update one by creating a query and using the inherited $this->conn 
    public function updateById($spot_id, SpotModel $spot)
    {
        $query = "UPDATE spots SET user_id=?, type_id=?, lat_coord=?, lon_coord=? WHERE spot_id=?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("iissi", $spot->user_id, $spot->type_id, $spot->lat_coord, $spot->lon_coord, $spot_id);

        $success = $stmt->execute();

        return $success;
    }

    // Delete one spot by using the inherited function deleteOneRowByIdFromTable
    public function deleteById($spot_id)
    {
        $success = $this->deleteOneRowByIdFromTable($this->table_name, $this->p_key, $spot_id);

        return $success;
    }
}
