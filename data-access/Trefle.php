<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

// Data access:
// External API - Trefle

class Trefle
{
    private $token = "wcdLqHiiMC2cj64O1refhRuFp3G9CFe19GI9V3H4iVc";

    // Retrieves one from the specified 
    // table in the database and returns the result.
    protected function getPlantById($id)
    {
        $result = "";

        return $result;
    }

    // Deletes one row from the specified 
    // table in the database.
    protected function searchPlant($query)
    {
        $result = "";

        return $result;
    }
}
