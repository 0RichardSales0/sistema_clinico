<?php
include('conexao.php');
session_start();

// Verifica se o CPF foi enviado
if (!isset($_POST['cpf'])) {
    echo json_encode(['erro' => 'CPF não enviado.']);
    exit;
}

// Limpa o CPF (remove qualquer caractere que não seja número)
$cpf = preg_replace('/\D/', '', $_POST['cpf']);

if (empty($cpf)) {
    echo json_encode(['erro' => 'CPF inválido.']);
    exit;
}

// Prepara a consulta
$sql = "SELECT id FROM paciente WHERE cpf = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $cpf);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se encontrou o paciente
if ($row = $result->fetch_assoc()) {
    $_SESSION['paciente_id'] = $row['id'];
    echo json_encode(['sucesso' => true, 'paciente_id' => $row['id']]);
} else {
    echo json_encode(['erro' => 'Paciente não encontrado.']);
}
?>
