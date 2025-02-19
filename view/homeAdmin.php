<?php
// Estabelecer conexão com o banco de dados
$pdo = new PDO('mysql:host=localhost;dbname=powergames', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Query para selecionar todos os clientes
$sql = "SELECT cpf, nome, email FROM cliente";
$stmt = $pdo->query($sql);
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Query para pegar as descrições dos produtos
$descricoesSql = "SELECT DISTINCT descricao FROM produto";
$descricoesStmt = $pdo->query($descricoesSql);
$descricoes = $descricoesStmt->fetchAll(PDO::FETCH_ASSOC);

// Query para pegar as desenvolvedoras
$desenvolvedorasSql = "SELECT id, nome FROM desenvolvedora";
$desenvolvedorasStmt = $pdo->query($desenvolvedorasSql);
$desenvolvedoras = $desenvolvedorasStmt->fetchAll(PDO::FETCH_ASSOC);
?>


<?php
if (isset($_FILES['csvFile'])) {
    // Recebe o arquivo CSV enviado
    $csvFile = $_FILES['csvFile']['tmp_name'];

    // Abre o arquivo CSV
    if (($handle = fopen($csvFile, 'r')) !== FALSE) {
        $data = [];
        $header = fgetcsv($handle); // Lê o cabeçalho do CSV (primeira linha)

        // Lê as linhas do CSV e as converte para um array associativo
        while (($row = fgetcsv($handle)) !== FALSE) {
            $data[] = array_combine($header, $row);
        }

        fclose($handle);

        // Converte o array para JSON
        $json = json_encode($data, JSON_PRETTY_PRINT);

        // Definindo cabeçalhos para download do arquivo JSON
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="relatorio.json"');
        echo $json;
    } else {
        echo "Erro ao abrir o arquivo CSV.";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="../css/home3.css">
    <link rel="icon" href="../img/logo1.png" type="image/png">
    <title>PowerGames - Home</title>
    <style>
        /* Estilos básicos para o slider e outros elementos */
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

        /* Estilo do produto */
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
    </style>
</head>

<body>

    <header>
        <section id="cabecalho-logo">
            <img src="../img/logo1.png">
            <h1>PowerGames</h1>
        </section>
        <section id="cabecalho-logout">
            <a href="login.php">Sair do Modo Admin</a>
        </section>
    </header>



    <main>
        <div class="slider-container">
            <div class="slider">
                <div class="slide"><img src="../img/1.png" alt="Imagem 1"></div>
                <div class="slide"><img src="../img/2.png" alt="Imagem 2"></div>
                <div class="slide"><img src="../img/3.png" alt="Imagem 3"></div>
                <div class="slide"><img src="../img/4.png" alt="Imagem 3"></div>
                <div class="slide"><img src="../img/5.png" alt="Imagem 3"></div>
            </div>
            <div class="prev">&#10094;</div>
            <div class="next">&#10095;</div>
        </div>

        <div class="mt-4">
            <img src="../img/home-promocao.png" style="display:block;margin:0 auto;width:75%;" />
        </div>

        <div class="mt-4" style="padding: 0 8%;">
            <input type="text" id="searchBar" placeholder="Pesquise um jogo..."
                style="width: 100%; padding: 10px; margin-bottom: 20px;">
            <select id="descricaoSelect" style="width: 100%; padding: 10px; margin-bottom: 20px;">
                <option value="">Selecione a categoria...</option>
                <?php foreach ($descricoes as $desc): ?>
                    <option value="<?php echo $desc['descricao']; ?>"><?php echo $desc['descricao']; ?></option>
                <?php endforeach; ?>
            </select>


            <h6 class="text-center primary-color mb-4" style="font-size: 1.2rem; opacity: 0.7;">DESCOBERTAS DO DIA</h6>
            <div class="h-line h-line--primary"></div>
            <div id="product-list" class="mt-4">
                <?php
                // Utilizando JOIN para obter os dados da desenvolvedora junto com os produtos
                $sql = "SELECT p.id, p.nome AS produto_nome, p.descricao, p.valor, p.url_imagem, d.nome AS desenvolvedora_nome 
            FROM produto p 
            JOIN desenvolvedora d ON p.desenvolvedora_id = d.id";
                $stmt = $pdo->query($sql);
                $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($produtos as $produto) {
                    $id = $produto["id"];
                    $nome = $produto["produto_nome"];
                    $descricao = $produto["descricao"];
                    $valor = $produto["valor"];
                    $url_imagem = $produto["url_imagem"];
                    $desenvolvedora = $produto["desenvolvedora_nome"]; // Deve trazer o nome da desenvolvedora
                    ?>
                    <div class="product-item">
                        <a href="./viewAdmin.php?id=<?php echo $id; ?>" style="text-decoration: none; color: inherit;">
                            <img src="<?php echo $url_imagem; ?>" alt="<?php echo $nome; ?>"
                                style="border-radius: 8px; transition: transform 0.2s;">
                            <h3 style="font-weight: bold;"><?php echo $nome; ?></h3>
                            <p style="font-style: italic; color: #555;"><?php echo $desenvolvedora; ?></p>
                            <!-- Deve mostrar o nome -->
                            <p style="color: #777;"><?php echo $descricao; ?></p>
                            <p class="valor" style="font-weight: bold; color: #d9534f;">R$
                                <?php echo number_format($valor, 2, ',', '.'); ?>
                            </p>
                        </a>
                    </div>
                    <?php
                }
                ?>
            </div>



            <button id="openModalBtn">Adicionar Produto</button>
            <button id="baixarRelatorioBtn" onclick="baixarRelatorio('csv')">Baixar Relatório CSV</button>

            <!-- Botão para abrir o formulário de upload -->
            <button id="baixarRelatorioBtn" onclick="openUploadForm()">Baixar Relatório CSV para JSON</button>

            <!-- Formulário de upload de arquivo CSV -->
            <div id="uploadForm" style="display: none;">
                <form method="POST" enctype="multipart/form-data" action="converterCsvParaJson.php">
                    <input type="file" name="csvFile" accept=".csv" required />
                    <button type="submit">Converter para JSON</button>
                </form>
            </div>

            <script>
                // Função para abrir o formulário de upload de CSV
                function openUploadForm() {
                    const form = document.getElementById("uploadForm");
                    form.style.display = form.style.display === "none" ? "block" : "none";
                }
            </script>

        </div>

        <!-- Modal -->
        <div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form method="POST" action="../processamento/processamentoProduto.php" enctype="multipart/form-data">
                    <label for="inputNomeProd">Cadastrar Produto</label>
                    <input type="text" placeholder="Nome" name="inputNomeProd" required>
                    <select name="fabricanteSelect" required>
                        <option value="">Selecione o Fabricante</option>
                        <?php foreach ($desenvolvedoras as $desenvolvedora): ?>
                            <option value="<?php echo $desenvolvedora['id']; ?>"><?php echo $desenvolvedora['nome']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <input type="text" placeholder="Descrição" name="inputDescricaoProd" required>
                    <input type="text" placeholder="Valor" name="inputValorProd" step="0.01" required>
                    <input type="file" name="inputImagemProd" accept="image/*" required>
                    <input id="botao" type="submit" value="Vender">
                </form>
            </div>
        </div>

    </main>

    <footer class="rodape-login">
        <img src="../img/footer-login.png">
        <hr>
        <p>© 2022 PowerGames. Todos os direitos reservados</p>
    </footer>

    <script>
        // Slide (Carrosel)
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
            updateSlider();
        });

        prevBtn.addEventListener('click', () => {
            counter--;
            if (counter < 0) {
                counter = slides.length - 1;
            }
            updateSlider();
        });

        function updateSlider() {
            slider.style.transform = `translateX(${-counter * 100}%)`;
        }

        // Modal
        const modal = document.getElementById("myModal");
        const btn = document.getElementById("openModalBtn");
        const span = document.getElementsByClassName("close")[0];

        btn.onclick = function () {
            modal.style.display = "block";
        }

        span.onclick = function () {
            modal.style.display = "none";
        }

        window.onclick = function (event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // Função para baixar o relatório
        function baixarRelatorio(formato) {
            window.location.href = `baixarRelatorio.php?formato=${formato}`;
        }



        // Filtros
        document.getElementById('searchBar').addEventListener('keyup', function () {
            const filter = this.value.toLowerCase();
            const products = document.querySelectorAll('.product-item');

            products.forEach(product => {
                const text = product.querySelector('h3').textContent.toLowerCase();
                product.style.display = text.includes(filter) ? '' : 'none';
            });
        });




        // Função para filtrar os produtos por descrição
        document.getElementById('descricaoSelect').addEventListener('change', function () {
            const selectedDescricao = this.value.toLowerCase(); // Valor selecionado no combobox
            const products = document.querySelectorAll('.product-item'); // Todos os produtos

            products.forEach(product => {
                const descricao = product.querySelector('p:nth-of-type(2)').textContent.toLowerCase(); // Captura o parágrafo de descrição
                product.style.display = (selectedDescricao === '' || descricao.includes(selectedDescricao)) ? '' : 'none'; // Filtra os produtos
            });
        });

    </script>
</body>

</html>