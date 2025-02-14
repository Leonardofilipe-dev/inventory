<?php

class ProductController{

    public function __construct() {
        header('Content-Type: application/json');
    }

    public function setRequestProduct() {

        $product = new Product();

        $method = $_SERVER['REQUEST_METHOD'];

        $data = json_decode(file_get_contents('php://input'), true);

        switch($method){
            case "POST";
            return $product->create();
            break;
            case "GET";
            return $product->read();
            break;
            case "PUT";
            return $product->update();
            break;
            case "DELETE";
            return $product->delete();
            break;

        }
    }




}

$product = new ProductController();
echo $product->setRequestProduct();


