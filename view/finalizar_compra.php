<?php
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['cpf'])) {
    echo 'error'; // Usuário não autenticado
    exit;
}

// Recupera o carrinho da sessão
$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
if (empty($cart)) {
    echo 'empty'; // Carrinho vazio
    exit;
}

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "powergames";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão com o banco de dados
if ($conn->connect_error) {
    echo "Falha na conexão com o banco de dados: " . $conn->connect_error;
    exit; // Interrompe a execução se houver falha na conexão
}

// Obtém o CPF do cliente da sessão
$cpf = $_SESSION['cpf'];
$total = 0;

// Inicia uma transação para garantir que tudo seja inserido corretamente
$conn->begin_transaction();

try {
    // Calcula o total do carrinho e insere os itens da venda
    foreach ($cart as $productId => $quantity) {
        // Recupera o valor do produto
        $sql = "SELECT valor FROM produto WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $total += $row['valor'] * $quantity;

            // Insere os itens da venda (detalhes da compra)
            $sql_insert_item = "INSERT INTO itens_venda (cpf, produto_id, quantidade, valor_unitario) VALUES (?, ?, ?, ?)";
            $stmt_insert_item = $conn->prepare($sql_insert_item);
            $stmt_insert_item->bind_param("siii", $cpf, $productId, $quantity, $row['valor']);
            $stmt_insert_item->execute();
        }
    }

    // Insere a venda na tabela "venda"
    $sql = "INSERT INTO venda (cpf, valor_total) VALUES (?, ?)";
    $stmt_sale = $conn->prepare($sql);
    $stmt_sale->bind_param("sd", $cpf, $total);
    $stmt_sale->execute();

    // Confirma a transação
    $conn->commit();

    // Limpa o carrinho após a compra
    unset($_SESSION['cart']);

    echo 'success';
} catch (Exception $e) {
    // Se algo falhar, reverte a transação
    $conn->rollback();
    echo 'error: ' . $e->getMessage(); // Retorna o erro caso haja falha
}

// Fecha a conexão com o banco de dados
$conn->close();
