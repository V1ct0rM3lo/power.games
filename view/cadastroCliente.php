<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="../css/login4.css">
    <link rel="icon" href="../img/logo1.png" type="image/png">
    <title>PowerGames - Cadastro Cliente</title>
</head>

<body>

    <div class="video-background">
        <video autoplay loop muted>
            <source src="../videos/Trailer Multiversus.mp4" type="video/mp4">
        </video>
    </div>

    <section class="conteudo-cadastro">
        <section class="conteudo-formulario-cadastro">
            <form method="POST" action="../processamento/processamento.php">
            <label id="input-log" class="titulo-login"><h1>Cadastro</h1></label>
                <input type="text" placeholder="Nome" name="inputNome">
                <input type="text" placeholder="Sobrenome" name="inputSobrenome">
                <input type="text" placeholder="CPF" name="inputCPF">
                <input type="text" placeholder="Telefone" name="inputTelefone">
                <input type="text" placeholder="Email" name="inputEmail">
                <input type="password" placeholder="Senha" name="inputSenha">
                <input id="botao" type="submit" value="Cadastrar">
            </form>
            <p>Ja tem uma conta? <a href="login.php">Conectar</a></p>
        </section>
    </section>

</body>

</html>
