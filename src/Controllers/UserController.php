<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use App\Utils\Logger;
use App\Views\UserDto;

class UserController
{
    use Logger;

    public function index(): void
    {
        $userModel = new User();
        $users = $userModel->getAllUsers();
        $usersDto = [];

        foreach ($users as $user) {
            $dto = new UserDto($user['nome'], $user['email']);
            $usersDto[] = $dto;
        }
        if (empty($usersDto)) {
            self::log("Nenhum usuário encontrado.");
            return;
        }

            header('Content-Type: application/json');
            echo json_encode($usersDto, JSON_PRETTY_PRINT);
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
        echo json_encode($dto, JSON_PRETTY_PRINT);
    }
    
    public function create(): void
    {

      $data = json_decode(file_get_contents('php://input'), true);

      if (!$data || !isset($data['nome']) || !isset($data['email'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Dados inválidos.']);
            return;
      }

        $user = new User();
        $user->insertUser($data['nome'], $data['email']);

        http_response_code(201);
        echo json_encode([
            'message' => 'Usuário criado com sucesso.',
            'user' => [
                'nome' => $data['nome'],
                'email' => $data['email']
            ]
        ]);
    }

    public function update(): void
    {
      $data = json_decode(file_get_contents('php://input'), true);
      if (!$data || !isset($data['id']) || !isset($data['nome']) || !isset($data['email'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Dados inválidos.']);
            return;
      }

        $user = new User();
        $user->updateUser($data['id'], $data['nome'], $data['email']);

        http_response_code(200);
        echo json_encode([
            'message' => 'Usuario atualizado com sucesso.',
            'user' => [
                'id' => $data['id'],
                'nome' => $data['nome'],
                'email' => $data['email']
            ]
        ], JSON_PRETTY_PRINT);
    }

    public function delete(): void
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $user = new User();
        if ($user->getUser($data['id']) === null) {
            http_response_code(404);
            json_encode(['error' => 'Usuário não encontrado.'], JSON_PRETTY_PRINT);
            return;
        }
        $user->deleteUser($data['id']);
        http_response_code(200);
        echo json_encode([
            'message' => 'Usuário deletado com sucesso.',
            'user' => [
                'id' => $data['id']
            ]
        ], JSON_PRETTY_PRINT);
    }
}
