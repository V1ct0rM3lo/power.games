<?php
// Verifica se o arquivo CSV foi enviado
if (isset($_FILES['csvFile'])) {
    // Caminho temporário do arquivo enviado
    $csvFile = $_FILES['csvFile']['tmp_name'];

    // Verifica se o arquivo foi aberto com sucesso
    if (($handle = fopen($csvFile, 'r')) !== FALSE) {
        $data = [];  // Array onde os dados do CSV serão armazenados
        $header = fgetcsv($handle);  // Lê a primeira linha como cabeçalho

        // Lê as linhas restantes do CSV e as converte em um array associativo
        while (($row = fgetcsv($handle)) !== FALSE) {
            $data[] = array_combine($header, $row);  // Associa as chaves do cabeçalho aos valores da linha
        }

        fclose($handle);  // Fecha o arquivo CSV

        // Converte o array de dados para o formato JSON
        $json = json_encode($data, JSON_PRETTY_PRINT);

        // Definindo cabeçalhos para que o navegador baixe o arquivo JSON
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="relatorio.json"');
        echo $json;  // Exibe o conteúdo JSON para download
    } else {
        // Caso o arquivo não possa ser aberto
        echo "Erro ao abrir o arquivo CSV.";
    }
} else {
    // Caso nenhum arquivo tenha sido enviado
    echo "Nenhum arquivo CSV foi enviado.";
}
?>
