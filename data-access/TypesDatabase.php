<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

// Use "require_once" to load the files needed for the class

require_once __DIR__ . "/Database.php";
require_once __DIR__ . "/../models/TypeModel.php";

class TypesDatabase extends Database
{
    private $table_name = "types";
    private $p_key = "type_id";

    // Get one type by using the inherited function getOneRowByIdFromTable
    public function getOne($type_id)
    {
        $result = $this->getOneRowByIdFromTable($this->table_name, $this->p_key, $type_id);

        $type = $result->fetch_object("TypeModel");

        return $type;
    }

    // Get one type by using the inherited function getOneRowByIdFromTable
    public function getOneByTreffleId($trefle_id)
    {

        $result = $this->getOneRowByIdFromTable($this->table_name, "trefle_id", $trefle_id);

        $type = $result->fetch_object("TypeModel");

        return $type;
    }


    // Get all types by using the inherited function getAllRowsFromTable
    public function getAll()
    {
        $result = $this->getAllRowsFromTable($this->table_name);

        $types = [];

        while ($type = $result->fetch_object("TypeModel")) {
            $types[] = $type;
        }

        return $types;
    }

    // Create one by creating a query and using the inherited $this->conn 
    public function insert(TypeModel $type)
    {
        $query = "INSERT INTO types (trefle_id, common_name, scientific_name, image_url) VALUES (?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("isss", $type->trefle_id, $type->common_name, $type->scientific_name, $type->image_url);

        $success = $stmt->execute();

        return $success;
    }

    // Update one by creating a query and using the inherited $this->conn 
    public function updateById($type_id, TypeModel $type)
    {
        $query = "UPDATE types SET trefle_id=?, common_name=?, scientific_name=?, image_url=? WHERE type_id=?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("isssi", $type->trefle_id, $type->common_name, $type->scientific_name, $type->image_url, $type_id);

        $success = $stmt->execute();

        return $success;
    }

    // Delete one type by using the inherited function deleteOneRowByIdFromTable
    public function deleteById($type_id)
    {
        $success = $this->deleteOneRowByIdFromTable($this->table_name, $this->p_key, $type_id);

        return $success;
    }
}
