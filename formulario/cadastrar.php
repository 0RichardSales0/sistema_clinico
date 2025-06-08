<?php
include_once('conexao.php');

if (isset($_POST['nome'], $_POST['email'], $_POST['cpf'], $_POST['senha'])) {
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $cpf = trim($_POST['cpf']);
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $verifica = $conexao->prepare("SELECT id FROM usuarios WHERE email = ? OR cpf = ?");
    $verifica->bind_param("ss", $email, $cpf);
    $verifica->execute();
    $verifica->store_result();

    if ($verifica->num_rows > 0) {
        echo "E-mail ou CPF já cadastrados.";
        exit;
    }

    $stmt = $conexao->prepare("INSERT INTO usuarios (nome, email, cpf, senha) VALUES (?, ?, ?, ?)");
    if ($stmt) {
        $stmt->bind_param("ssss", $nome, $email, $cpf, $senha);
        if ($stmt->execute()) {
            echo "sucesso";
        } else {
            echo "Erro ao cadastrar: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Erro na query: " . $conexao->error;
    }
} else {
    echo "Preencha todos os campos!";
}
?>
