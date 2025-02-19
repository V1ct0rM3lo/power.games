<?php
session_start();

$total = $_POST['total'];
$discountType = $_POST['discountType'];

if ($discountType === 'blackFriday') {
    $template = new BlackFridayDiscount();
} elseif ($discountType === 'christmas') {
    $template = new ChristmasDiscount();
} else {
    $template = null; // Sem desconto
}

if ($template) {
    $total = $template->calculateTotal($total);
}

// Processar a compra com o total atualizado
// Salvar no banco de dados, limpar o carrinho, etc.
echo 'success';
?>
