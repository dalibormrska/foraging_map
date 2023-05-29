<?php

// Check for a defined constant or specific file inclusion
if (!defined('MY_APP') && basename($_SERVER['PHP_SELF']) == basename(__FILE__)) {
    die('This file cannot be accessed directly.');
}

require_once __DIR__ . "/RestAPI.php";
require_once __DIR__ . "/../business-logic/TypesService.php";

// Class for handling requests to "api/type"

class TypesAPI extends RestAPI
{

    // Handles the request by calling the appropriate member function
    public function handleRequest()
    {

        
        // If theres two parts in the path and the request method is GET 
        // it means that the client is requesting "api/types" and
        // we should respond by returning a list of all types 
        if ($this->path_count == 2 && $this->method == "GET") {
            $this->getAll();
        } 

        // If there's three parts in the path and the request method is GET
        // it means that the client is requesting "api/types/{something}".
        // In our API the last part ({something}) should contain the ID of a 
        // type and we should respond with the type of that ID
        else if ($this->path_count == 3 && $this->method == "GET") {
            $this->getById($this->path_parts[2]);
        }

        // If theres two parts in the path and the request method is POST 
        // it means that the client is requesting "api/types" and we
        // should get ths contents of the body and create a type.
        else if ($this->path_count == 2 && $this->method == "POST") {
            $this->postOne();
        }

        // If theres two parts in the path and the request method is PUT 
        // it means that the client is requesting "api/types/{something}" and we
        // should get the contents of the body and update the type.
        else if ($this->path_count == 3 && $this->method == "PUT") {
            $this->putOne($this->path_parts[2]);
        } 

        // Patch
        else if ($this->path_count == 3 && $this->method == "PATCH") {
            $this->patchOne($this->path_parts[2]);
        }

        // If theres two parts in the path and the request method is DELETE 
        // it means that the client is requesting "api/types/{something}" and we
        // should get the ID from the URL and delete that type.
        else if ($this->path_count == 3 && $this->method == "DELETE") {
            $this->deleteOne($this->path_parts[2]);
        } 
        
        // If none of our ifs are true, we should respond with "not found"
        else {
            $this->notFound();
        }
    }

    // Gets all types and sends them to the client as JSON
    private function getAll()
    {
        $this->requireAuth([1]);

        $types = TypesService::getAllTypes();

        $this->sendJson($types);
    }

    // Gets one and sends it to the client as JSON
    private function getById($id)
    {
        $this->requireAuth([1]);

        $type = TypesService::getTypeById($id);

        if ($type) {
            $this->sendJson($type);
        }
        else {
            $this->notFound();
        }
    }

    // Gets the contents of the body and saves it as a type by 
    // inserting it in the database.
    private function postOne()
    {
        $this->requireAuth([1]);

        $type = new TypeModel();

        $type->trefle_id = $this->body["trefle_id"];
        $type->common_name = $this->body["common_name"];
        $type->scientific_name = $this->body["scientific_name"];

        $success = TypesService::saveType($type);

        if($success){
            $this->created();
        }
        else{
            $this->error();
        }
    }

    // Gets the contents of the body and updates the type
    // by sending it to the DB
    private function putOne($id)
    {
        $this->requireAuth([1]);

        $type = new TypeModel();

        $type->trefle_id = $this->body["trefle_id"];
        $type->common_name = $this->body["common_name"];
        $type->scientific_name = $this->body["scientific_name"];

        $success = TypesService::updateTypeById($id, $type);

        if($success){
            $this->ok();
        }
        else{
            $this->error();
        }
    }

    // Patch
    private function patchOne($id)
    {
        $this->requireAuth([1]);

        $type = TypesService::getTypeById($id);

        if ($type) {
            foreach ($this->body as $key => $value) {
                $type->$key = $this->body[$key];
            }
            unset($key, $value);

            $success = TypesService::updateTypeById($id, $type);

            if ($success) {
                $this->noContent();
            } else {
                $this->error();
            }
        } else {
            $this->notFound();
        }
    }

    // Deletes the type with the specified ID in the DB
    private function deleteOne($id)
    {
        $this->requireAuth([1]);

        $type = TypesService::getTypeById($id);

        if($type == null){
            $this->notFound();
        }

        $success = TypesService::deleteTypeById($id);

        if($success){
            $this->noContent();
        }
        else{
            $this->error();
        }
    }
}
