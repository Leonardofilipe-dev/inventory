<?php
require_once '../db/config.php';

class Auth
{
    private $pdo;
    
    public function __construct()
    {
        // Conectar ao banco de dados usando a classe Config
        $this->pdo = Config::getConnection();
    }

    // Método para fazer o login
    public function login($email, $password)
    {
        // Validar se o email e senha foram fornecidos
        if (!$email || !$password) {
            return [
                'status' => 'error',
                'message' => 'Email e senha são obrigatórios!'
            ];
        }

        // Buscar o usuário pelo email no banco de dados
        $stmt = $this->pdo->prepare("SELECT id, name, password FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verificar se o usuário existe e se a senha é válida
        if ($user && password_verify($password, $user['password'])) {
            return [
                'status' => 'success',
                'message' => 'Login bem-sucedido!',
                'user_id' => $user['id'],
                'user_name' => $user['name']
            ];
        }

        // Caso contrário, email ou senha estão incorretos
        return [
            'status' => 'error',
            'message' => 'Email ou senha incorretos!'
        ];
    }
}
?>
