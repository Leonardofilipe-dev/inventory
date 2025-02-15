<?php



class UserControler
{

    // Construtor para configurar cabeçalho de resposta JSON
    public function __construct()
    {
        header('Content-Type: application/json');
    }

    public function handleRequest()
    {

        $user = new Users();

        $method = $_SERVER['REQUEST_METHOD'];

        $data = json_decode(file_get_contents('php://input'), true);

        switch ($method) {
            case 'POST':
                return $user->Create($data['name'], $data['email'], $data['password']);
                break;

            case 'GET':
                return $user->Read();
                break;

            case 'PUT':
                return $user->Update($data['id'], $data['name'], $data['email'], $data['password']);
                break;

            case 'DELETE':
                return $user->Delete($data['id']);
                break;
        }
    }
}

$userController = new UserControler();
echo $userController->handleRequest();
