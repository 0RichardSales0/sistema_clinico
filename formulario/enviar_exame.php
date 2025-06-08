<?php
include('conexao.php');

// Ativa exibição de erros
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Pasta onde os arquivos serão salvos
$pastaDestino = "uploads/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Captura e validação dos dados
    $paciente_id = isset($_POST['paciente_id']) ? intval($_POST['paciente_id']) : 0;
    $tipo_exame = isset($_POST['tipo_exame']) ? trim($_POST['tipo_exame']) : '';
    $arquivo = $_FILES['arquivo'];

    // Verifica se o paciente existe (opcional, caso exista a tabela pacientes)
    $verificaPaciente = $conexao->prepare("SELECT id FROM paciente WHERE id = ?");
if (!$verificaPaciente) {
    die("Erro na preparação da query: " . $conexao->error);
}
$verificaPaciente->bind_param("i", $paciente_id);
$verificaPaciente->execute();
$resultado = $verificaPaciente->get_result();

if ($resultado->num_rows === 0) {
    die("Paciente não encontrado.");
}
$verificaPaciente->close();


    // Verifica se o upload ocorreu sem erros
    if ($arquivo['error'] === UPLOAD_ERR_OK) {
        // Verifica tipo e tamanho do arquivo (exemplo: PDF, JPG, PNG)
        $tiposPermitidos = ['application/pdf', 'image/jpeg', 'image/png'];
        $tamanhoMaximo = 5 * 1024 * 1024; // 5 MB

        if (!in_array($arquivo['type'], $tiposPermitidos)) {
            die("Tipo de arquivo não permitido.");
        }

        if ($arquivo['size'] > $tamanhoMaximo) {
            die("Arquivo muito grande.");
        }

        // Gera nome único e move o arquivo
        $nomeArquivo = uniqid() . "_" . basename($arquivo['name']);
        $caminhoCompleto = $pastaDestino . $nomeArquivo;

        // Garante que a pasta de destino existe
        if (!is_dir($pastaDestino)) {
            mkdir($pastaDestino, 0777, true);
}


        if (move_uploaded_file($arquivo['tmp_name'], $caminhoCompleto)) {
            // Insere no banco de dados
            $stmt = $conexao->prepare("INSERT INTO exames (paciente_id, tipo_exame, arquivo) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $paciente_id, $tipo_exame, $nomeArquivo);

            if ($stmt->execute()) {
                header("Location: home.html"); // redireciona após sucesso
                exit();
            } else {
                echo "Erro ao salvar no banco de dados: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Erro ao mover o arquivo para a pasta de destino.";
        }
    } else {
        echo "Erro no upload do arquivo. Código de erro: " . $arquivo['error'];
    }

    $conexao->close();
}
?>
