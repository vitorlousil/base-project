<?php

// Modelo de arquivo para execução de envio de e-mails

require 'vendor/autoload.php';

use BaseProject\Email;

$email = new Email();

$mensagem = $email->construirMensagem(
    "Olá, {{ nome }}! Seu pedido foi confirmado!",
    ["nome" => "Vitor"]
);

$email->adicionarFila("vitor@email", "Confirmação de Cadastro", $mensagem);
