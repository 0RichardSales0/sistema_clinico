<?php
ob_start();
include_once('conexao.php');
// resto do código...

include_once('conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_cpf = $conexao->real_escape_string($_POST['email_cpf']);
    $senha = $_POST['senha'];

    $sql = "SELECT * FROM usuarios WHERE (email = '$email_cpf' OR cpf = '$email_cpf') AND senha = '$senha' LIMIT 1";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows === 1) {
        // Login válido, redireciona para teste.html
        header('Location: home.html');
        exit(); // sempre usar exit após header Location
    } else {
        echo "Email ou CPF e/ou senha incorretos!";
    }
} else {
    echo "Método inválido.";
}
?>
