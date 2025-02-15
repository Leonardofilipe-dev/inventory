<?php

require_once __DIR__ . '/../db/config.php';
require_once __DIR__ . '/../controler/UserControler.php';

class Users
{


    public function __construct()
    {
        Config::getConnection();
    }

    public function Create(string $name, string $email, string $password)
    {

        try {

            if (empty($name) || empty($email) || empty($password)) {

                throw new Exception("Name and Email are requered");
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


            $stmt = Config::getConnection()->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");
            $stmt->execute([":name" => $name, ":email" => $email, "password" => $hashedPassword]);

            return http_response_code(200);
        } catch (PDOException $e) {


            return json_encode(["Error" => $e->getMessage()]);
        }
    }

    public function Read(): string
    {
        try {
            $stmt =  Config::getConnection()->prepare("SELECT * FROM users");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($result);
        } catch (PDOException $e) {

            return json_encode(['Error' => $e->getMessage()]);
        }
    }

    public function Update(int $id, string $name, string $email, string $password): string
    {

        try {

            if (empty($name) || empty($email)) {
                throw new Exception("Name and Email are required");
            }

            if (!empty($password)) {
                $password = password_hash($password, PASSWORD_DEFAULT);
            }

            $stmt =  Config::getConnection()->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
            $stmt->execute([$name, $email, $password, $id]);

            return http_response_code(200);
        } catch (PDOException $e) {
            return json_encode(["Error" => $e->getMessage()]);
        }
    }

    public function Delete(int $id)
    {

        try {
            $sql = "DELETE FROM users WHERE id = :id";
            $stmt =  Config::getConnection()->prepare($sql);
            $stmt->execute([":id" => $id]);
            return json_encode(['Deleted' => 200]);
        } catch (PDOException $e) {
            return json_encode(['Error' => $e->getMessage()]);
        }
    }
}

