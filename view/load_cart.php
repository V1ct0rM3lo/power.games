<?php
session_start();

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "powergames";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

$items = [];
foreach ($cart as $productId => $quantity) {
    $sql = "SELECT id, nome, valor, url_imagem FROM produto WHERE id = $productId";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $row['quantidade'] = $quantity;
        $items[] = $row;
    }
}

echo json_encode($items);

$conn->close();
?>
