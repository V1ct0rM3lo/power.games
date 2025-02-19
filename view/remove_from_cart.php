<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $produto_id = $_POST['id_produto'];

    if (isset($_SESSION['cart'][$produto_id])) {
        unset($_SESSION['cart'][$produto_id]);
        echo "success";
    } else {
        echo "error";
    }
}
?>
