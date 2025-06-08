<?php
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = 'Richard@1';
$dbName = 'formulario-medico';

// Criando conexão
$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Verifica erro de conexão
if ($conexao->connect_error) {
    die("Erro de conexão: " . $conexao->connect_error);
}

// Define charset para UTF-8
$conexao->set_charset("utf8");
?>
