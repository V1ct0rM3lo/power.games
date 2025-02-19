<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="../css/home3.css">
    <link rel="icon" href="../img/logo1.png" type="image/png">
    <title>PowerGames - Cadastrar Jogo</title>
</head>
<body>

    <header>
        <section id="cabecalho-logo">
            <img src="../img/logo.png">
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

    <section class="conteudo-cadastro">
        <section class="conteudo-formulario-cadastro">
            <form method="POST" action="../processamento/processamentoProduto.php" enctype="multipart/form-data">
                <label>Cadastrar Jogos</label>
                <input type="text" placeholder="Nome" name="inputNomeProd" required>
                <input type="text" placeholder="Fabricante" name="inputFabricanteProd" required>
                <input type="text" placeholder="Descrição" name="inputDescricaoProd" required>
                <input type="text" placeholder="Valor" name="inputValorProd" required>
                <input type="file" name="inputImagemProd" accept="image/*" required>
                <input id="botao" type="submit" value="Cadastrar">
            </form>
        </section>
    </section>

    <footer class="rodape-login">
        <img src="../img/footer-login.png">
        <hr>
        <p>© 2022 Xhopii. Todos os direitos reservados</p>
    </footer>
</body>
</html>