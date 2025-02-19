<?php
// Estabelecer conexão com o banco de dados
$pdo = new PDO('mysql:host=localhost;dbname=powergames', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Capturar dados do formulário
    $nome = $_POST['inputNomeProd'];
    $fabricanteId = $_POST['fabricanteSelect']; // O ID da desenvolvedora
    $descricao = $_POST['inputDescricaoProd'];
    $valor = floatval(str_replace(',', '.', $_POST['inputValorProd'])); // Converter valor
    $imagem = $_FILES['inputImagemProd'];

    // Verificar e preparar o upload da imagem
    $uploadDir = '../uploads';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Criar o diretório, se não existir
    }

    if (isset($imagem) && $imagem['error'] === UPLOAD_ERR_OK) {
        $fileType = mime_content_type($imagem['tmp_name']);
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

        if (in_array($fileType, $allowedTypes)) {
            $imagemPath = $uploadDir . basename($imagem['name']);
            move_uploaded_file($imagem['tmp_name'], $imagemPath);

            // Preparar a query para inserir o produto
            $sql = "INSERT INTO produto (nome, descricao, valor, url_imagem, desenvolvedora_id) VALUES (?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$nome, $descricao, $valor, $imagemPath, $fabricanteId]);

            // Redirecionar após a inserção
            header("Location: ../view/homeAdmin.php");
            exit();
        } else {
            echo "Erro: Tipo de arquivo não permitido. Somente JPEG, PNG ou GIF são permitidos.";
        }
    } else {
        echo "Erro ao fazer o upload da imagem.";
    }
}
?>
