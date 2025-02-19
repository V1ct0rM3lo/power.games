<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="../css/login4.css">
    <link rel="icon" href="../img/logo1.png" type="image/png">
    <title>PowerGaming</title>
</head>

<body>

    <div class="video-background">
        <video autoplay loop muted>
            <source src="../videos/Trailer Fortnite.mp4" type="video/mp4">
        </video>
    </div>

    <section class="conteudo-login">
        <section class="conteudo-formulario">
            <form id="form-log" method="POST" action="../processamento/processamento.php">
                <label id="input-log" class="titulo-login"><h1>Login</h1></label>
                <input id="input-log" type="text" placeholder="Email" name="inputEmailLog" required>
                <input id="input-log" type="password" placeholder="Senha" name="inputSenhaLog" required>
                <input id="botao-log" type="submit" value="ENTRE">
            </form>
            <?php
            if (isset($_GET['error']) && $_GET['error'] == 'invalid') {
                echo "<p style='color:red;'>Email ou senha inválidos. Tente novamente.</p>";
            }
            ?>
            <p>Novo na PowerGaming? <a href="cadastroCliente.php">Cadastrar</a></p>
        </section>
    </section>

</body>

</html>
