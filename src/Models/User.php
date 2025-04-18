<?php

declare(strict_types=1);

namespace App\Models;

use App\Utils\DBconnection;
use App\Utils\Logger;

class User extends DBconnection
{
  protected int $id;

  protected string $nome;

  protected string $email;

  protected string $created_at;

  use Logger;
  public function getUsers(): array
  {
    $pdo = self::$instance->prepare('SELECT * FROM usuarios');
    $pdo->execute();

    $result = $pdo->fetchAll(\PDO::FETCH_ASSOC);

    return $result;
  }

  public function getUser(int $id): ?self
  {
    $pdo = self::$instance->prepare('SELECT * FROM usuarios WHERE id = :id');
    $pdo->bindParam(':id', $id);
    $pdo->execute();

    $user = $pdo->fetch(\PDO::FETCH_ASSOC);

    if (!$user) {
      return null;
    }

    $this->setUser($user['id'], $user['nome'], $user['email']);
  
    return $this;
  }

  public function setUser(int $id, string $nome, string $email): void
  {
    $this->id = $id;
    $this->nome = $nome;
    $this->email = $email;
  }

  public function insertUser(string $nome, string $email): void
  {
    $pdo = self::$instance->prepare('INSERT INTO usuarios (nome, email) VALUES (:nome, :email)');
    $pdo->bindParam(':nome', $nome);
    $pdo->bindParam(':email', $email);
    $pdo->execute();

    self::log("User created: {$nome}");
  }
  public function updateUser(int $id, string $nome, string $email): void
  {
    $pdo = self::$instance->prepare('UPDATE usuarios SET nome = :nome, email = :email WHERE id = :id');
    $pdo->execute([
      ':id' => $id,
      ':nome' => $nome,
      ':email' => $email
    ]);
    self::log("User updated: {$nome}");
  }

  public function deleteUser(int $id): void
  {
    $pdo = self::$instance->prepare('DELETE FROM usuarios WHERE id = :id');
    $pdo->bindParam(':id', $id);
    $pdo->execute();
    self::log("User deleted: {$id}");
  }

  public function getNome(): string
  {
    return $this->nome;
  }

  public function getEmail(): string
  {
    return $this->email;
  }

  public function getId(): int
  {
    return $this->id;
  }
  public function getCreatedAt(): string
  {
    return $this->created_at;
  }

}
