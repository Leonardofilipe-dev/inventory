<?php

class CategoryController
{


    public function handleRequestCategory(){

        $category = new Category;

        //'REQUEST_METHOD'
        //Which request method was used to access the page; e.g. 'GET', 'HEAD', 'POST', 'PUT' (Documentação PHP).

        $method = $_SERVER['REQUEST_METHOD'];

        $data = json_decode(file_get_contents('php://input'), true);

        switch ($method) {
            case 'POST':
                return $category->Create($data['name']);
                break;

            case 'GET':
                return $category->Read($data);
                break;

            case 'PUT':
                return $category->Update($data['id'] ,$data['name']);
                break;

            case 'DELETE':
                return $category->Delete($data['id']);
                break;

            default:
                'Option Invalid!';
                break;
        }
    }
}

$category = new CategoryController();

echo $category->handleRequestCategory();
