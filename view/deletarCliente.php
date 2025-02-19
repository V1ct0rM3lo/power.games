<?php
// Verifica se foi passado o parâmetro ID na URL
if (isset($_GET['id'])) {
    $idCliente = $_GET['id'];

    // Importe o controlador para ter acesso aos métodos
    require_once "../controller/Controlador.php";
    $controlador = new Controlador();

    // Chame o método para deletar o cliente
    $deletado = $controlador->deletarCliente($idCliente);

    if ($deletado) {
        // Redireciona de volta para a página de visualização de clientes
        header("Location: verCliente.php");
        exit();
    } else {
        echo "Erro ao tentar deletar o cliente.";
    }
} else {
    echo "ID do cliente não foi especificado.";
}
?>
