<?php

use App\Controllers\UserController;


require __DIR__ . "/vendor/autoload.php";

$controller = new UserController();

if (isset($_GET['user']) && is_numeric($_GET['user'])) {
    $controller->show((int)$_GET['user']);
} else {
    http_response_code(400);
    echo"error ID de usuário inválido ou ausente.";
}
