<?php
    require_once "../controller/Controlador.php";
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="../css/home3.css">
    <link rel="icon" href="../img/logo1.png" type="image/png">
    <title>PowerGames - Ver Clientes</title>
</head>
<body>

    <header>
        <section id="cabecalho-logo">
            <img src="../img/logo.png" alt="Logo">
            <h1>PowerGames</h1>
        </section>
        <section id="cabecalho-logout">
            <a href="login.php">Sair</a>
        </section>
    </header>

    <nav class="menu-horizontal">
        <ul>
            <li><a href="homeAdmin.php">Home</a></li>
            <li><a href="cadastroProduto.php">Cadastro Produto</a></li>
            <li><a href="verCliente.php">Ver Clientes</a></li>
        </ul>
    </nav>

    <section class="conteudo-visualizar">
        <section class="conteudo-visualizar-box">
            <h1>Clientes</h1>
            <?php
                $controlador = new Controlador();
                echo $controlador->visualizarClientes(); // Método para exibir os clientes
            ?>
        </section>
    </section>

    <footer class="rodape-login">
        <img src="../img/footer-login.png" alt="Footer Logo">
        <hr>
        <p>© 2022 Xhopii. Todos os direitos reservados</p>
    </footer>
</body>
</html>
