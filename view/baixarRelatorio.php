<?php
// Estabelecer conexão com o banco de dados
$pdo = new PDO('mysql:host=localhost;dbname=powergames', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Consulta SQL para buscar todos os produtos
$sql = "SELECT id, nome, desenvolvedora_id, descricao, valor, url_imagem FROM produto";
$stmt = $pdo->query($sql);
$produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Se for solicitado um download em JSON
if (isset($_GET['formato']) && $_GET['formato'] == 'json') {
    header('Content-Type: application/json');
    header('Content-Disposition: attachment; filename="relatorio_produtos.json"');
    echo json_encode($produtos);
    exit;
}

// Se for solicitado um download em CSV
if (isset($_GET['formato']) && $_GET['formato'] == 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="relatorio_produtos.csv"');
    
    $output = fopen('php://output', 'w');
    
    // Adiciona o cabeçalho do CSV
    fputcsv($output, ['ID', 'Nome', 'Desenvolvedora ID', 'Descrição', 'Valor', 'URL da Imagem']);
    
    foreach ($produtos as $produto) {
        fputcsv($output, $produto);
    }
    
    fclose($output);
    exit;
}
?>
