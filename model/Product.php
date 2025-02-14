<?php 

require_once __DIR__ . '/../db/config.php';
require_once __DIR__ . '/../controler/ProductController.php';

class Product{

    function __construct(){
        
        Config::getConnection();
    }

    public function create(){

        $params = "Working CREATE";
        return json_encode(["Message" => $params]);
    }

    public function read(){

        $params = "Working read";
        return json_encode(["Message" => $params]);
    }

    public function update(){
        $params = "Working Update";
        return json_encode($params);
    }

    public function delete(){
        $params = "Working Delete";
        return json_encode($params);
    }

}