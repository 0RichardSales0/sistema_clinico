<?php
include('conexao.php');
session_start();

$cpf = $_POST['cpf'] ?? '';
$cpf = preg_replace('/\D/', '', $cpf); // remove qualquer coisa que não seja número

if (empty($cpf)) {
    echo json_encode(['erro' => 'CPF não enviado.']);
    exit;
}

$sql = "SELECT id FROM paciente WHERE cpf = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("s", $cpf);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $_SESSION['paciente_id'] = $row['id'];
    echo json_encode(['sucesso' => true, 'paciente_id' => $row['id']]);
} else {
    echo json_encode(['erro' => 'Paciente não encontrado.']);
}
?>
