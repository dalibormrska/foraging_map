<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

require_once __DIR__ . "/../data-access/SpotsDatabase.php";
require_once __DIR__ . "/../data-access/TypesDatabase.php";

class SpotsService
{

    // Get one customer by creating a database object 
    // from data-access layer and calling its getOne function.
    public static function getSpotById($id)
    {
        $spots_database = new SpotsDatabase();

        $spot = $spots_database->getOne($id);

        // Add trefle_id
        $types_database = new TypesDatabase();

        $type = $types_database->getOne($spot->type_id);

        $spot->trefle_id = $type->trefle_id;

        return $spot;
    }

    // Get all customers by creating a database object 
    // from data-access layer and calling its getAll function.
    public static function getAllSpots()
    {
        $spots_database = new SpotsDatabase();

        $spots = $spots_database->getAll();

        // If you need to remove or hide data that shouldn't
        // be shown in the API response you can do that here
        // An example of data to hide is users password hash 
        // or other secret/sensitive data that shouldn't be 
        // exposed to users calling the API

        return $spots;
    }

    // Get all spots by creating a database object 
    // from data-access layer and calling its getAll function.
    public static function getSpotsByUser($user_id)
    {
        $spots_database = new SpotsDatabase();

        $spots = $spots_database->getBySpotId($user_id);

        // If you need to remove or hide data that shouldn't
        // be shown in the API response you can do that here
        // An example of data to hide is users password hash 
        // or other secret/sensitive data that shouldn't be 
        // exposed to users calling the API

        return $spots;
    }

    // Save a customer to the database by creating a database object 
    // from data-access layer and calling its insert function.
    public static function saveSpot(SpotModel $spot)
    {
        $spots_database = new SpotsDatabase();

        // If you need to validate data or control what 
        // gets saved to the database you can do that here.
        // This makes sure all input from any presentation
        // layer will be validated and handled the same way.

        $success = $spots_database->insert($spot);

        return $success;
    }

    // Update the customer in the database by creating a database object 
    // from data-access layer and calling its update function.
    public static function updateSpotById($spot_id, SpotModel $spot)
    {
        $spots_database = new SpotsDatabase();

        // If you need to validate data or control what 
        // gets saved to the database you can do that here.
        // This makes sure all input from any presentation
        // layer will be validated and handled the same way.

        $success = $spots_database->updateById($spot_id, $spot);

        return $success;
    }

    // Patch spot by ID
    public static function patchSpotById($spot_id, SpotModel $spot)
    {
        $spots_database = new SpotsDatabase();

        // If you need to validate data or control what 
        // gets saved to the database you can do that here.
        // This makes sure all input from any presentation
        // layer will be validated and handled the same way.

        $success = $spots_database->updateById($spot_id, $spot);

        return $success;
    }

    // Delete the customer from the database by creating a database object 
    // from data-access layer and calling its delete function.
    public static function deleteSpotById($spot_id)
    {
        $spots_database = new SpotsDatabase();

        // If you need to validate data or control what 
        // gets deleted from the database you can do that here.
        // This makes sure all input from any presentation
        // layer will be validated and handled the same way.

        $success = $spots_database->deleteById($spot_id);

        return $success;
    }
}
