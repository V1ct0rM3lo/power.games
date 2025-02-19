<?php
// processamentoVenda.php

// Verifica se o POST está correto
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recebe os dados via POST
    $total = isset($_POST['total']) ? $_POST['total'] : 0;
    $cpf_cliente = isset($_POST['cpf_cliente']) ? $_POST['cpf_cliente'] : null;

    // Validações simples (se necessário)
    if (empty($total) || empty($cpf_cliente)) {
        echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
        exit;
    }

    // Conexão com o banco de dados
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "powergames";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Processar a venda (inserir na tabela de vendas)
    $sql = "INSERT INTO vendas (cpf_cliente, total, data_venda) VALUES ('$cpf_cliente', '$total', NOW())";

    if ($conn->query($sql) === TRUE) {
        // Sucesso, retorna resposta JSON
        echo json_encode(['success' => true]);
    } else {
        // Erro, retorna resposta JSON
        echo json_encode(['success' => false, 'message' => 'Erro ao processar a venda']);
    }

    // Fechar a conexão com o banco
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Método inválido']);
}
?>
