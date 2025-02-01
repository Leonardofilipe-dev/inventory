<?php

require_once __DIR__ . '/../db/config.php';
require_once __DIR__ . '/../controler/UserControler.php';

class Users {
    private $pdo;

    public function __construct() {
        $this->pdo = Config::getConnection();
    }

    // Método para criar usuário
    public function Create(string $name, string $email, string $password) {

        try {

            if(empty($name) || empty($email) || empty($password)){
            
                throw new Exception("Name and Email are requered");
            }

            $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, isset($password)]);
    
            return http_response_code(200);

        } catch (PDOException $e) {

            return json_encode(["Erro: SQL - This Email already exists in our dataBase " => $e->getCode()]);
        }
    }

    public function Read(){
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM users");
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return json_encode($result);
        } catch (PDOException $e) {

            return json_encode(['Error' => $e->getMessage()]);
        }
    }

    public function Update(int $id, string $name,string $email, string $password) {

        try {
            // Verificar se os campos estão preenchidos
            if(empty($name) || empty($email)) {
                throw new Exception("Name and Email are required");
            }
    
            // Se a senha for passada e não for vazia, hash da senha
            if (!empty($password)) {
                $password = password_hash($password, PASSWORD_DEFAULT);
            }
    
            // Atualizar o usuário
            $stmt = $this->pdo->prepare("UPDATE users SET name = ?, email = ?, password = ? WHERE id = ?");
            $stmt->execute([$name, $email, $password, $id]);
    
            return json_encode(['message' => 'User updated successfully']);
        } catch (PDOException $e) {
            return json_encode(["Error" => $e->getMessage()]);
        }
    }
    
    
    public function Delete(int $id){

        try{
            $sql = "DELETE FROM users WHERE id = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$id]);
            return json_encode(['Deleted' => 200]);
        }catch (PDOException $e){
            return json_encode(['Error' => $e->getMessage()]);
        }
    }
}
