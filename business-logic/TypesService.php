<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

require_once __DIR__ . "/../data-access/TypesDatabase.php";

class TypesService{

    // Get one customer by creating a database object 
    // from data-access layer and calling its getOne function.
    public static function getTypeById($id){
        $types_database = new TypesDatabase();

        $type = $types_database->getOne($id);

        // If you need to remove or hide data that shouldn't
        // be shown in the API response you can do that here
        // An example of data to hide is types password hash 
        // or other secret/sensitive data that shouldn't be 
        // exposed to types calling the API

        return $type;
    }

    // Get one customer by creating a database object 
    // from data-access layer and calling its getOne function.
    public static function getTypeByTrefleId($trefle_id){
        $types_database = new TypesDatabase();

        $type = $types_database->getOneByTreffleId($trefle_id);

        // If you need to remove or hide data that shouldn't
        // be shown in the API response you can do that here
        // An example of data to hide is types password hash 
        // or other secret/sensitive data that shouldn't be 
        // exposed to types calling the API

        return $type;
    }

    // Get all customers by creating a database object 
    // from data-access layer and calling its getAll function.
    public static function getAllTypes(){
        $types_database = new TypesDatabase();

        $types = $types_database->getAll();

        // If you need to remove or hide data that shouldn't
        // be shown in the API response you can do that here
        // An example of data to hide is types password hash 
        // or other secret/sensitive data that shouldn't be 
        // exposed to types calling the API

        return $types;
    }

    // Save a customer to the database by creating a database object 
    // from data-access layer and calling its insert function.
    public static function saveType(TypeModel $type){
        $types_database = new TypesDatabase();

        // If you need to validate data or control what 
        // gets saved to the database you can do that here.
        // This makes sure all input from any presentation
        // layer will be validated and handled the same way.

        $success = $types_database->insert($type);

        return $success;
    }

    // Update the customer in the database by creating a database object 
    // from data-access layer and calling its update function.
    public static function updateTypeById($type_id, TypeModel $type){
        $types_database = new TypesDatabase();

        // If you need to validate data or control what 
        // gets saved to the database you can do that here.
        // This makes sure all input from any presentation
        // layer will be validated and handled the same way.

        $success = $types_database->updateById($type_id, $type);

        return $success;
    }

    // Delete the customer from the database by creating a database object 
    // from data-access layer and calling its delete function.
    public static function deleteTypeById($type_id){
        $types_database = new TypesDatabase();

        // If you need to validate data or control what 
        // gets deleted from the database you can do that here.
        // This makes sure all input from any presentation
        // layer will be validated and handled the same way.

        $success = $types_database->deleteById($type_id);

        return $success;
    }
}

