<?php

use App\Controllers\UserController;

require __DIR__ . "/vendor/autoload.php";

// if (isset($_GET['user']) && is_numeric($_GET['user'])) {
//     $controller->show((int)$_GET['user']);
// } else {
//     http_response_code(400);
//     echo"error ID de usuário inválido ou ausente.";
// }
// if (isset($_GET['users'])) {
//   $controller->index();
// } else {
//   http_response_code(404);
//   json_encode(['error' => 'Rota não encontrada.']);
// }

// if (isset($_GET['create'])) {
//   $controller->create();
// } else {
//   http_response_code(404);
//   json_encode(['error' => 'Rota não encontrada.']);
// }

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$uri = str_replace('/mvc/public', '', $uri);


// if ($uri === '/users') {
//     // Chama o método para listar usuários
//     $controller = new UserController();
//     $controller->index();
// } 
// if (preg_match('/^\/user\/(\d+)$/', $uri, $matches)) {
//     $controller = new UserController();
//     $controller->show($matches[1]);
// } else {
//     // Rota não encontrada
//     http_response_code(404);
//     echo "Rota não encontrada.";
// }


function handleRequest($uri)
{
    $controller = new UserController();

    if ($uri === '/users') {
        $controller->index();
    } elseif (preg_match('/^\/user\/(\d+)$/', $uri, $matches)) {
        $controller->show($matches[1]);
    } elseif ($uri === '/create') {
        $controller->create();
    } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        $controller->update();
    } else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        $controller->delete();
    }
    else {
        http_response_code(404);
        echo "Rota não encontrada.";
    }
}

handleRequest($uri);