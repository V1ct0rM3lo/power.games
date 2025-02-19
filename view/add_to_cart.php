<?php
session_start();

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém o ID do produto
    $produto_id = $_POST['id_produto'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$produto_id])) {
        $_SESSION['cart'][$produto_id]++;
    } else {
        $_SESSION['cart'][$produto_id] = 1;
    }

    // Redireciona para a página do carrinho
    header("Location: carrinho.php");
    exit();
}
?>
