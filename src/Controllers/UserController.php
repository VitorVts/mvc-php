<?php

declare(strict_types= 1);

namespace App\Controllers;

use App\Models\User;
use App\Utils\Logger;
use App\Views\UserDto;
class UserController
{
  use Logger;
  public function index(): void
  {
    // $users = new Users();
    // $users->getUsers();
    // $allUsers = $users->getUsers();

    // if (empty($allUsers)) {
    //   self::log("Usuários não encontrados." . PHP_EOL);
    //   return;
    // } 
    // foreach ($allUsers as $user) {
    //   echo "ID: {$user['id']}, Nome: {$user['nome']}, Email: {$user['email']}" . PHP_EOL;
    // }
    
    // $user = new Users();

    // $usuario = $user->getUser(3);
    // var_dump($usuario->getNome());

  }
  public function show(int $id): void
  {
    $user = new User();

    if (is_null($user->getUser($id))) {

      self::log("Usuário não encontrado.");
      return;
    }
    $user->getUser($id);
    $dto = new UserDto($user->getNome(), $user->getEmail());

    header('Content-Type: application/json');
    echo json_encode($dto,JSON_PRETTY_PRINT);
   
  }


}
