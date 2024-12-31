<?php
// Configurações de conexão com o banco de dados
$host = "localhost";
$user = "root";  // Usuário padrão do MySQL no XAMPP
$password = "";  // Senha padrão do MySQL no XAMPP (em branco)
$dbname = "contato"; // Nome do banco de dados

// Conectar ao banco de dados
$conn = new mysqli($host, $user, $password, $dbname);

// Verifica se há erro na conexão
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Conexão falhou: " . $conn->connect_error]);
    exit;
}

// Obtendo os dados do formulário com verificação
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'] ?? '';
    $sobrenome = $_POST['sobrenome'] ?? '';
    $email = $_POST['email'] ?? '';
    $mensagem = $_POST['mensagem'] ?? '';

    // Verificar se os campos obrigatórios estão preenchidos
    if ($nome && $email) {
        $sql = "INSERT INTO mensagens (nome,sobrenome,email, mensagem) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            echo json_encode(["status" => "error", "message" => "Erro na preparação da consulta: " . $conn->error]);
            exit;
        }

        $stmt->bind_param("ssss", $nome, $sobrenome, $email, $mensagem);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Mensagem enviada com sucesso!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erro ao enviar mensagem: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Todos os campos obrigatórios devem ser preenchidos!"]);
    }
}

$conn->close();
?>
