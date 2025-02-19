<?php
// Estabelecer conexão com o banco de dados (substitua com suas próprias configurações)
$pdo = new PDO('mysql:host=localhost;dbname=powergames', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Query para selecionar todos os clientes
$sql = "SELECT cpf, nome, email FROM cliente";
$stmt = $pdo->query($sql);
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="pt-BR">


<style>
    /* Estilos básicos para o slider */
    .slider-container {
        width: 80%;
        margin: auto;
        overflow: hidden;
        position: relative;
    }

    .slider {
        display: flex;
        transition: transform 0.5s ease-in-out;
    }

    .slide {
        min-width: 100%;
        overflow: hidden;
    }

    img {
        width: 100%;
        height: auto;
    }

    /* Estilos para os botões de navegação */
    .prev,
    .next {
        cursor: pointer;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        font-size: 24px;
        color: white;
        background-color: rgba(0, 0, 0, 0.5);
        padding: 10px;
        border-radius: 50%;
    }

    .prev {
        left: 10px;
    }

    .next {
        right: 10px;
    }



    .modal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: rgba(0, 0, 0, 0.5);
        padding: 20px;
        z-index: 1000;
        border-radius: 5px;
    }

    .modal-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 5px;
    }


    #product-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px 38px;
    }

    .product-item {
        padding: 10px;
        box-shadow: 0 4px 10px #0002;
        border-radius: 2px;
        cursor: pointer;
        transition: transform .2s ease, box-shadow .1s linear;
    }

    .product-item:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 10px -2px #0002;
    }

    .product-item img {
        width: 100%;
    }
</style>




<head>
    <meta charset="UTF-8">
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="../css/home3.css">
    <link rel="icon" href="../img/logo1.png" type="image/png">
    <title>PowerGames - Home</title>
</head>

<body>

    <header>
        <section id="cabecalho-logo">
            <img src="../img/logo1.png">
            <h1>PowerGames</h1>
        </section>
        <section id="cabecalho-logout">
            <a href="login.php">Entrar</a>
        </section>
    </header>

    <nav class="menu-horizontal">
        <ul>
            <li><a href="home.php">Home</a></li>
        </ul>
    </nav>

    <main>
        <div class="slider-container">
            <div class="slider">
                <div class="slide">
                    <img src="../img/1.png" alt="Imagem 1">
                </div>
                <div class="slide">
                    <img src="../img/2.png" alt="Imagem 2">
                </div>
                <div class="slide">
                    <img src="../img/3.png" alt="Imagem 3">
                </div>
                <div class="slide">
                    <img src="../img/4.png" alt="Imagem 3">
                </div>
                <div class="slide">
                    <img src="../img/5.png" alt="Imagem 3">
                </div>
            </div>
            <div class="prev">&#10094;</div>
            <div class="next">&#10095;</div>
        </div>

        <div class="mt-4">
            <img src="../img/home-promocao.png" style="display:block;margin:0 auto;width:75%;" />
        </div>








        <!-- Estilização dos dados dos produtos -->
        <style>
            .product-item {
                font-family: Arial, sans-serif;
            }

            .product-item h3 {
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

            /* Estilos para remover sublinhado e cor de link */
            .product-item a {
                text-decoration: none;
                /* Remove sublinhado */
                color: inherit;
                /* Herda a cor do texto pai */
            }

            .product-item a:hover {
                /* Estilo para o link quando passar o mouse (opcional) */
                text-decoration: underline;
            }

            /* Estilo para remover sublinhado quando hover */
            .product-item a:hover {
                text-decoration: none;
            }
        </style>








        <div class="mt-4" style="padding: 0 8%;">
            <h6 class="text-center primary-color mb-4" style="font-size: 1.2rem; opacity: 0.7;">DESCOBERTAS DO DIA</h6>
            <div class="h-line h-line--primary"></div>
            <div id="product-list" class="mt-4">
                <?php
                // Sua conexão com o banco de dados aqui
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "powergames";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
                }

                // Consulta SQL para buscar os produtos com o caminho da imagem
                $sql = "SELECT id, nome, desenvolvedora_id, descricao, valor, url_imagem FROM produto";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) 
                    {
                        $id = $row["id"]; // ID do produto
                        $nome = $row["nome"];
                        $desenvolvedora_id = $row["desenvolvedora_id"]; // ID da desenvolvedora
                        $descricao = $row["descricao"];
                        $valor = $row["valor"];
                        $url_imagem = $row["url_imagem"]; // Obtendo o caminho da imagem
                    
                        // Nova consulta para pegar o nome da desenvolvedora
                        $desenvolvedora_sql = "SELECT nome FROM desenvolvedora WHERE id = ?";
                        $stmt = $conn->prepare($desenvolvedora_sql);
                        $stmt->bind_param("i", $desenvolvedora_id); // Bind do ID da desenvolvedora
                        $stmt->execute();
                        $desenvolvedora_result = $stmt->get_result();
                        $desenvolvedora = $desenvolvedora_result->fetch_assoc()['nome'] ?? 'Desconhecida'; // Nome padrão caso não encontrado
                    
                        ?>
                        <div class="product-item">
                            <a href="./viewAdmin.php?id=<?php echo $id; ?>">
                                <img src="<?php echo $url_imagem; ?>" alt="<?php echo $nome; ?>">
                                <h3><?php echo $nome; ?></h3>
                                <p><?php echo $desenvolvedora; ?></p> <!-- Aqui exibe o nome da desenvolvedora -->
                                <p><?php echo $descricao; ?></p>
                                <p class="valor">R$ <?php echo number_format($valor, 2, ',', '.'); ?></p>
                            </a>
                        </div>
                        <?php
                    }
                    
                } else {
                    echo "Nenhum produto encontrado.";
                }

                // Fecha a conexão com o banco de dados
                $conn->close();
                ?>

            </div>
        </div>
    </main>




    <footer class="rodape-login">
        <img src="../img/footer-login.png">
        <hr>
        <p>© 2022 PowerGames. Todos os direitos reservados</p>
    </footer>
</body>

<!-- Slide (Carrosel) -->
<script>
    const slider = document.querySelector('.slider');
    const slides = document.querySelectorAll('.slide');
    const prevBtn = document.querySelector('.prev');
    const nextBtn = document.querySelector('.next');
    let counter = 0;

    nextBtn.addEventListener('click', () => {
        counter++;
        if (counter >= slides.length) {
            counter = 0;
        }
        updateSlide();
    });

    prevBtn.addEventListener('click', () => {
        counter--;
        if (counter < 0) {
            counter = slides.length - 1;
        }
        updateSlide();
    });

    function updateSlide() {
        slider.style.transform = `translateX(${-counter * 100}%)`;
    }
</script>


<!-- Modal -->

<script>
    // Abre o modal quando o botão é clicado
    document.getElementById('openModalBtn').addEventListener('click', function () {
        document.getElementById('myModal').style.display = 'block';
    });

    // Fecha o modal quando o botão de fechar é clicado
    document.querySelector('.close').addEventListener('click', function () {
        document.getElementById('myModal').style.display = 'none';
    });

    // Adiciona o novo produto ao product-list quando o botão "Vender" é clicado
    document.getElementById('venderBtn').addEventListener('click', function () {
        var form = document.getElementById('productForm');
        var formData = new FormData(form);
        var descricao = formData.get('descricao');
        var preco = formData.get('preco');
        var quantidade = formData.get('quantidade');
        var imagem = formData.get('imagem');

        var productItem = document.createElement('div');
        productItem.className = 'product-item';
        productItem.innerHTML = `
        <img src="uploads/${imagem.name}">
        <h6 class="mt-2" style="color:#0008;">${descricao}</h6>
        <div class="mt-2" style="display:flex;justify-content:space-between;">
            <span class="primary-color">R$ ${preco}</span>
            <span style="color:#0006;">${quantidade} disponíveis</span>
        </div>
    `;

        document.getElementById('product-list').appendChild(productItem);

        document.getElementById('myModal').style.display = 'none'; // Fecha o modal após adicionar o produto
    });
</script>

</html>