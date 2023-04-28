<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

// Model class for customers-table in database

class SpotModel
{
    public $spot_id;
    public $user_id;
    public $trefle_id;
    public $creation_date;
    public $coordinates;
}
