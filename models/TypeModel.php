<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

// Model class for customers-table in database

class TypeModel
{
    public $type_id;
    public $trefle_id;
    public $common_name;
    public $scientific_name;
}
