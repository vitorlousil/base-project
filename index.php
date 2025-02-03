<?php

require 'vendor/autoload.php';

use BaseProject\Database;
use BaseProject\Model;

// Modelo de arquivo para execução de testes dos métodos do Model

// Definir a classe para o modelo de usuário
class User extends Model {
    protected static string $table = 'users';
}

// Conectar ao banco
Database::connect();


// Criar um novo usuário
try {
    User::create([
        "name" => "João Silva",
        "email" => "joao4@email.com"
    ]);
    echo "Usuário criado com sucesso!";
} catch (Exception $e) {
    echo "Erro ao criar usuário: " . $e->getMessage();
}

// Listar todos os usuários
try {
    $users = User::all();
    print_r($users);
    echo "Usuários listados com sucesso!";
} catch (Exception $e) {
    echo "Erro ao listar usuários: " . $e->getMessage();
}

// Buscar um usuário específico
try {
    $user = User::find(4);
    print_r($user);
    echo "Usuário encontrado com sucesso!";
} catch (Exception $e) {
    echo "Erro ao buscar usuário: " . $e->getMessage();
}

// Atualizar um usuário
try {
    User::update(2, ["name" => "João Atualizado"]);
    echo "Usuário atualizado com sucesso!";
} catch (Exception $e) {
    echo "Erro ao atualizar usuário: " . $e->getMessage();
}

// Excluir um usuário
try {
    User::delete(1);
    echo "Usuário excluído com sucesso!";
} catch (Exception $e) {
    echo "Erro ao excluir usuário: " . $e->getMessage();
}

// Fechar a conexão
Database::disconnect();
