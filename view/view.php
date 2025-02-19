<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="../css/style2.css">
    <link rel="icon" href="../img/logo1.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>PowerGames - Comprar</title>
    <style>
        nav {
            background-color: #bbb;
        }

        nav a,
        nav a:hover {
            color: var(--primary-color);
        }

        main {
            background-color: #fff;
        }

        main>section {
            width: 100%;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
        }

        main>section img {
            height: 80px;
            flex-grow: 1;
        }

        main>section>div:first-child {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            overflow-x: auto;
        }

        main>section>div:first-child img {
            object-fit: contain;
        }

        main>section>div:nth-child(2) {
            display: flex;
            justify-content: center;
        }

        main>section>div:nth-child(2) img {
            height: 320px;
            object-fit: contain;
        }

        main>section>div:nth-child(3) {
            padding-left: 20px;
        }

        main>section>div:nth-child(3) h1 {
            font-weight: bold;
            font-size: 2rem;
        }

        main>section>div>.selected {
            border: 2px solid var(--primary-s-color);
        }

        @media (min-width: 800px) {
            main>section {
                padding: 0 10%;
                display: grid;
                grid-template-columns: 100px 1fr 1fr;
            }

            main>section img {
                height: auto;
                flex-grow: 0;
                max-width: 100%;
                max-height: 365px;
            }

            main>section>div:first-child {
                display: block;
            }

            main>section>div:nth-child(2) {
                align-items: center;
            }
        }

        .box {
            display: inline-block;
            border: 1px solid #2225;
            padding: 6px 10px;
            color: #0009;
            cursor: pointer;
        }

        .product-item {
            font-family: Arial, sans-serif;
        }

        .product-item h1 {
            font-family: 'Roboto', sans-serif;
            color: #5E17EB;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-item p {
            display: flex;
            font-family: 'Open Sans', sans-serif;
            align-items: center;
            justify-content: center;
        }

        .product-details {
            position: absolute;
            left: 60%;
        }

        .product-details button {
            color: white;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            text-transform: uppercase;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .product-details button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
<header>
        <section id="cabecalho-logo">
            <img src="../img/logo1.png">
            <h1>PowerGames</h1>
        </section>
        <section id="cabecalho-logout">
            <a href="login.php">Sair</a>
        </section>
    </header>


    <nav class="menu-horizontal">
        <ul>
            <li><a href="homeUsuario.php">Home</a></li>
        </ul>
    </nav>

    <main>
        <section class="mt-4">
            <div>
                <!-- Imagens dos jogos (se necessário) -->
            </div>

            <div>
                <!-- Conteúdo dinâmico do jogo -->
                <?php
                // Verifica se o parâmetro 'id' está presente na URL
                if (isset($_GET['id'])) {
                    $id = $_GET['id'];

                    // Sua conexão com o banco de dados aqui
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "powergames";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
                    }

                    // Consulta SQL para buscar as informações do jogo pelo ID, incluindo o nome da desenvolvedora
                    $sql = "SELECT p.id, p.nome, p.descricao, p.valor, p.url_imagem, d.nome AS desenvolvedora_nome 
                            FROM produto p 
                            JOIN desenvolvedora d ON p.desenvolvedora_id = d.id 
                            WHERE p.id = $id";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $id = $row["id"];
                        $nome = $row["nome"];
                        $desenvolvedora_nome = $row["desenvolvedora_nome"]; // Nome da desenvolvedora
                        $descricao = $row["descricao"];
                        $valor = $row["valor"];
                        $url_imagem = $row["url_imagem"];
                        ?>
                        <img src="<?php echo $url_imagem; ?>" alt="<?php echo $nome; ?>" />
                        <div class="product-details">
                            <h1><?php echo $nome; ?></h1>
                            <p>Desenvolvedora: <?php echo $desenvolvedora_nome; ?></p> <!-- Exibindo o nome da desenvolvedora -->
                            <p>Descrição: <?php echo $descricao; ?></p>
                            <p>Valor: R$ <?php echo number_format($valor, 2, ',', '.'); ?></p>
                            <!-- Botão Comprar -->
                            <form action="add_to_cart.php" method="POST">
                                <input type="hidden" name="id_produto" value="<?php echo $id; ?>">
                                <button type="submit">Comprar</button>
                            </form>
                        </div>
                        <?php
                    } else {
                        echo "Produto não encontrado.";
                    }

                    // Fecha a conexão com o banco de dados
                    $conn->close();
                } else {
                    echo "Produto não especificado.";
                }
                ?>
            </div>
        </section>
    </main>

    <!-- Modal do Carrinho de Compras -->
    <div id="cartModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Carrinho de Compras</h2>
            <div id="cartItems"></div>
            <div id="cartTotal"></div>
            <button id="checkoutBtn">Finalizar Compra</button>
        </div>
    </div>

    <style>
        /* Estilos do modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        #cartItems {
            margin-bottom: 20px;
        }

        #checkoutBtn {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        #checkoutBtn:hover {
            background-color: #45a049;
        }
    </style>

    <footer class="rodape-login">
        <img src="../img/footer-login.png">
        <hr>
        <p>© 2022 PowerGames. Todos os direitos reservados</p>
    </footer>
</body>

<script>
    // Pega o modal
    var modal = document.getElementById("cartModal");

    // Pega o botão que abre o modal
    var btn = document.getElementById("cartBtn");

    // Pega o <span> que fecha o modal
    var span = document.getElementsByClassName("close")[0];

    // Quando o usuário clicar no botão, abre o modal
    btn.onclick = function () {
        modal.style.display = "block";
        loadCartItems();
    }

    // Quando o usuário clicar no <span> (x), fecha o modal
    span.onclick = function () {
        modal.style.display = "none";
    }

    // Quando o usuário clicar fora do modal, fecha o modal
    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // Função para carregar os itens do carrinho e mostrar no modal
    function loadCartItems() {
        fetch('load_cart.php')
            .then(response => response.json())
            .then(data => {
                let cartItems = document.getElementById("cartItems");
                let cartTotal = document.getElementById("cartTotal");
                cartItems.innerHTML = "";
                let total = 0;
                data.forEach(item => {
                    cartItems.innerHTML += `
                        <div>
                            <img src="${item.url_imagem}" alt="${item.nome}" width="50">
                            <span>${item.nome} - R$ ${item.valor}</span>
                        </div>
                    `;
                    total += parseFloat(item.valor);
                });
                cartTotal.innerHTML = `Total: R$ ${total.toFixed(2)}`;
            });
    }
</script>

</html>
