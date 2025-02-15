<?php

require_once __DIR__ . '/../controler/Auth.php';

header('Content-Type: application/json');
session_start();

// Verificar se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Para aceitar dados JSON
    $input = json_decode(file_get_contents('php://input'), true);

    // Obter os dados de email e password (agora aceita JSON ou form data)
    $email = $input['email'] ?? $_POST['email'] ?? null;
    $password = $input['password'] ?? $_POST['password'] ?? null;

    // Criar uma instância da classe Auth
    $auth = new Auth();

    // Chamar o método login e obter o resultado
    $result = $auth->login($email, $password);

    // Retornar a resposta em JSON
    echo json_encode($result);

} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Método de requisição inválido!'
    ]);
}
?>
