<?php

require_once __DIR__ . '/../db/config.php';
require_once __DIR__ . '/../controler/ProductController.php';

class Product
{

    function __construct()
    {

        Config::getConnection();
    }


    public function create(string $name, float $price, int $quantity, int $category_id)
    {

        try {

            if (empty($name || empty($price) || empty($quantity) || empty($category_id))) {

                throw new Exception("Information's Requered");
            }

            $stmt = Config::getConnection()->prepare("INSERT INTO products (name, price, quantity, category_id) VALUES (:name, :price, :quantity, :category_id)");
            $stmt->execute([":name" => $name, ":price" => $price, ":quantity" => $quantity, ":category_id" => $category_id]);
            return http_response_code(200);
        } catch (PDOException $e) {
            json_encode(["Exception" => $e->getMessage()]);
        }
    }

    public function read()
    {

        try {

            $stmt = Config::getConnection()->prepare("
        SELECT p.id, p.name, p.price, p.quantity, c.name as category_name
        FROM products p
        INNER JOIN categories c ON p.category_id = c.id
    ");

            $stmt->execute();
            $result =  $stmt->fetchAll(PDO::FETCH_ASSOC);

            return json_encode($result);
        } catch (PDOException $e) {
            json_encode(['Exception' => $e->getMessage()]);
        }
    }

    public function update(int $id, string $name, float $price, int $quantity, int $category_id)
    {
        try {

            if (empty($name)) {
                throw new Exception("Information's Requered");
            }

            $stmt = Config::getConnection()->prepare("UPDATE products SET name = :name, price = :price, quantity = :quantity, category_id = :category_id WHERE id = :id ");
            $stmt->execute([':name' => $name, ':price' => $price, ':quantity' => $quantity, ':category_id' => $category_id, ':id' => $id]);

            return http_response_code(200);
        } catch (PDOException $e) {
            json_encode(['Excepition' => $e->getMessage()]);
        }
    }

    public function delete(int $id)
    {
        try {
            $stmt = Config::getConnection()->prepare("DELETE FROM products WHERE id = :id");
            $stmt->execute(["id" => $id]);
            return http_response_code(200);
        } catch (PDOException $e) {
            json_encode(["Exception" => $e->getMessage()]);
        }
    }
}
