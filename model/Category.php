<?php

require_once __DIR__ . '/../db/config.php';
require_once __DIR__ . '/../controler/CategoryController.php';

class Category
{

    public function __construct()
    {

        Config::getConnection();
    }

    public function Create(string $name)
    {

        try {

            if (empty($name)) {
                throw new Exception("Information's requered!");
            }

            $stmt = Config::getConnection()->prepare("INSERT INTO categories (name) VALUES (:name)");
            $stmt->execute([":name" => $name]);
            return http_response_code(200);
        } catch (PDOException $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }

    public function Read()
    {
        try {

            $stmt = Config::getConnection()->prepare("SELECT * FROM categories");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($result);
        } catch (PDOException $e) {

            return json_encode(['error' => $e->getMessage()]);
        }
    }

    public function Update(int $id, string $name)
    {
        try {

            if (empty($id) || empty($name)) {
                throw new Exception("Information's requered!");
            }
            $stmt = Config::getConnection()->prepare("UPDATE categories SET name = :name WHERE id = :id  ");
            $stmt->execute([":name" => $name, ":id" => $id]);
            return http_response_code(200);
        } catch (PDOException $e) {
            return json_encode(['error' => $e->getMessage()]);
        }
    }

    public function Delete(int $id)
    {
        try {

            $stmt = Config::getConnection()->prepare("DELETE FROM categories WHERE id = :id");
            $stmt->execute(["id" => $id]);
            return http_response_code(200);
        } catch (PDOException $e) {

            return json_encode(['error' => $e->getMessage()]);
        }
    }
}
