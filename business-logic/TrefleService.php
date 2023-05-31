<?php

require __DIR__ . "/../trefle-data-access/PlantFetcher.php";

class TrefleService {
    public static function searchPlants($query){
        $plant_fetcher = new PlantFetcher();

        $searched_plants = $plant_fetcher->searchPlants($query);

        return $searched_plants;
    }

    public static function getPlant($plant_id){
        $plant_fetcher = new PlantFetcher();

        $plant = $plant_fetcher->getPlant($plant_id);


        $filtered_plant = new TypeModel();

        $filtered_plant->trefle_id = $plant['data']['id'];
        $filtered_plant->common_name = $plant['data']['common_name'];
        $filtered_plant->scientific_name = $plant['data']['scientific_name'];

        return $filtered_plant;
    }
}