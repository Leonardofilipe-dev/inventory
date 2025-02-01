<?php

// Configurar cabeçalho de resposta JSON
header('Content-Type: application/json');

require_once __DIR__ . '/../model/User.php'; // Caminho correto para sua classe

// Criar instância da classe Users
$user = new Users();

// Obter o método HTTP
$method = $_SERVER['REQUEST_METHOD'];
// Pegar os dados enviados (se existirem)
$data = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'POST':
        echo $user->Create($data['name'], $data['email']);
        break;

    case 'GET':
        echo $user->Read();
        break;

    case 'PUT':
        echo $user->Update($data['id'], $data['name'], $data['email']);
        break;

    case 'DELETE':
        echo $user->Delete($data['id']);
        break;
}
