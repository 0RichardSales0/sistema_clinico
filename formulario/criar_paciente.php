<?php
include('conexao.php');

$nome = $_POST['nome'] ?? '';
$cpf = $_POST['cpf'] ?? '';

if (!$nome || !$cpf) {
    http_response_code(400);
    echo "Dados incompletos.";
    exit;
}

$stmt = $conexao->prepare("INSERT INTO paciente (nome, cpf) VALUES (?, ?)");

if ($stmt) {
    $stmt->bind_param("ss", $nome, $cpf);
    if ($stmt->execute()) {
        http_response_code(200);
        echo "Sucesso";
    } else {
        http_response_code(500);
        echo "Erro ao inserir no banco.";
    }
    $stmt->close();
} else {
    http_response_code(500);
    echo "Erro ao preparar query: " . $conexao->error;
}
?>
