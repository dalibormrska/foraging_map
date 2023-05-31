<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

// https://cdn.jsdelivr.net/gh/fawazahmed0/currency-api@1/latest/currencies.json

// https://github.com/fawazahmed0/currency-api#readme
class PlantFetcher
{
    private $base_url = "https://trefle.io/api/v1/plants/";

    // Fetches all available currencies from the API
    function searchPlants($query)
    {

        $query = rawurlencode($query);

        // Construct the URL for the API request using the base URL
        $url = "{$this->base_url}search?q={$query}&token=" . TREFLE_TOKEN;

        // Fetch the data from the API using the constructed URL
        $data = file_get_contents($url);

        // Decode the JSON data
        // The "true" argument to json_decode returns an associative array instead of an object
        $retrieved_plants = json_decode($data, true);

        // Return the currency codes to the caller
        return $retrieved_plants;
    }

    // Fetches the exchange rate for the specified currency pair
    function getPlant($plant_id)
    {
        // Construct the URL for the API request using the base URL and currency codes
        $url = "{$this->base_url}{$plant_id}?token=" . TREFLE_TOKEN;

        // Fetch the data from the API using the constructed URL
        $data = file_get_contents($url);

        // Decode the JSON data and extract the exchange rate value
        // The "true" argument to json_decode returns an associative array instead of an object
        $retrieved_plant = json_decode($data, true);

        // Return the exchange rate value to the caller
        return $retrieved_plant;
    }
}