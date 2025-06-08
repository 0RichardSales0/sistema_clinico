<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("conexao.php");  // Inclui a conexão

    // Recebe os dados do formulário
    $nome = $_POST["nome"];
    $email = $_POST["email"];
    $cpf = $_POST["cpf"];
    $senha = password_hash($_POST["senha"], PASSWORD_DEFAULT);

    $cpf = $_POST['cpf'];
    $cpf = preg_replace('/\D/', '', $cpf); // Remove tudo que não for número

    // Prepara o SQL para evitar SQL Injection
    $sql = "INSERT INTO paciente (nome, email, cpf, senha) VALUES (?, ?, ?, ?)";
    $stmt = $conexao->prepare($sql);

    if ($stmt === false) {
        die("Erro na preparação da query: " . $conexao->error);
    }

    $stmt->bind_param("ssss", $nome, $email, $cpf, $senha);

    if ($stmt->execute()) {
        echo "<script>alert('Cadastro realizado com sucesso!'); window.location.href='index.html';</script>";
    } else {
        echo "Erro ao cadastrar: " . $stmt->error;
    }

    $stmt->close();
    $conexao->close();
} else {
    echo "Requisição inválida.";
}
?>
