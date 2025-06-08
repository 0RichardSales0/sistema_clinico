<?php
include('conexao.php');

$nome = isset($_GET['nome']) ? $conexao->real_escape_string($_GET['nome']) : '';

if ($nome === '') {
  echo json_encode([]);
  exit;
}

$sql = "SELECT id, nome, cpf FROM paciente WHERE nome LIKE '%$nome%' ORDER BY nome LIMIT 20";
$result = $conexao->query($sql);

$pacientes = [];

while ($row = $result->fetch_assoc()) {
  $pacientes[] = $row;
}

header('Content-Type: application/json');
echo json_encode($pacientes);
?>
