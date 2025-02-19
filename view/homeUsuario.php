<?php
// Strategy Interface
interface OrderStrategy {
    public function sort(array $produtos): array;
}
?>

<?php
// Strategy: Ordenar por preço (menor para maior)
class OrderByPriceAsc implements OrderStrategy {
    public function sort(array $produtos): array {
        usort($produtos, function ($a, $b) {
            return $a['valor'] <=> $b['valor'];
        });
        return $produtos;
    }
}
?>


<?php
// Classe que aplica a estratégia de ordenação
class ProductFilter {
    private $strategy;

    public function __construct(OrderStrategy $strategy) {
        $this->strategy = $strategy;
    }

    public function filter(array $produtos): array {
        return $this->strategy->sort($produtos);
    }
}
?>





<?php
// Estabelecer conexão com o banco de dados (substitua com suas próprias configurações)
$pdo = new PDO('mysql:host=localhost;dbname=powergames', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Query para selecionar todos os clientes
$sql = "SELECT cpf, nome, email FROM cliente";
$stmt = $pdo->query($sql);
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<?php
// Estabelecer conexão com o banco de dados (substitua com suas próprias configurações)
$pdo = new PDO('mysql:host=localhost;dbname=powergames', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Query para selecionar todos os clientes
$sql = "SELECT cpf, nome, email FROM cliente";
$stmt = $pdo->query($sql);
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Consulta SQL para buscar os produtos com o caminho da imagem
$sqlProdutos = "SELECT id, nome, desenvolvedora_id, descricao, valor, url_imagem FROM produto";
$stmtProdutos = $pdo->query($sqlProdutos);
$produtos = $stmtProdutos->fetchAll(PDO::FETCH_ASSOC);

// Implementando o padrão Strategy para ordenar os produtos
// Verificar se o usuário escolheu a opção de ordenar
$orderStrategy = isset($_GET['order']) && $_GET['order'] == 'price_asc' ? new OrderByPriceAsc() : null;

if ($orderStrategy) {
    // Criando o filtro com a estratégia selecionada
    $productFilter = new ProductFilter($orderStrategy);
    $produtos = $productFilter->filter($produtos);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" type="text/css" href="../css/home3.css">
    <link rel="icon" href="../img/logo1.png" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>PowerGames - Home</title>
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
            <a href="login.php">Sair</a>
        </section>
    </header>

    <nav class="menu-horizontal">
        <ul>
            <li><a href="carrinho.php">Carrinho</a></li>
            <li><a href="?order=price_asc">Ordenar por Preço (Menor para Maior)</a></li>
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

        <div class="mt-4" style="padding: 0 8%;">
            <h6 class="text-center primary-color mb-4" style="font-size: 1.2rem; opacity: 0.7;">DESCOBERTAS DO DIA</h6>
            <div class="h-line h-line--primary"></div>
            <div id="product-list" class="mt-4">
                <?php
                foreach ($produtos as $produto) {
                    // Buscar nome da desenvolvedora
                    $sqlDesenvolvedora = "SELECT nome FROM desenvolvedora WHERE id = ?";
                    $stmtDesenvolvedora = $pdo->prepare($sqlDesenvolvedora);
                    $stmtDesenvolvedora->bindParam(1, $produto['desenvolvedora_id']);
                    $stmtDesenvolvedora->execute();
                    $desenvolvedora = $stmtDesenvolvedora->fetchColumn();
                    ?>
                    <div class="product-item">
                        <a href="./viewAdmin.php?id=<?php echo $produto['id']; ?>">
                            <img src="<?php echo $produto['url_imagem']; ?>" alt="<?php echo $produto['nome']; ?>">
                            <h3><?php echo $produto['nome']; ?></h3>
                            <p><?php echo $desenvolvedora; ?></p>
                            <p><?php echo $produto['descricao']; ?></p>
                            <p class="valor">R$ <?php echo number_format($produto['valor'], 2, ',', '.'); ?></p>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>
    </main>

</body>

</html>


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

<!-- Modal do Carrinho -->
<div id="cartModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeCartModal()">&times;</span>
        <h2>Carrinho de Compras</h2>
        <div id="cartItems">
            <!-- Itens do carrinho serão exibidos aqui -->
        </div>
        <div id="cartTotal">
            Total: R$ 0,00
        </div>
        <button onclick="checkout()">Finalizar Compra</button>
    </div>
</div>

<script>
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    document.addEventListener('DOMContentLoaded', updateCartIcon);

    function openCartModal() {
        const modal = document.getElementById('cartModal');
        const cartItemsDiv = document.getElementById('cartItems');
        const cartTotalDiv = document.getElementById('cartTotal');

        cartItemsDiv.innerHTML = '';
        let total = 0;

        cart.forEach(item => {
            const itemDiv = document.createElement('div');
            itemDiv.classList.add('cart-item');
            itemDiv.innerHTML = `
                    <p>${item.name} - R$ ${item.price.toFixed(2).replace('.', ',')}</p>
                    <i class="fas fa-trash remove-item" onclick="removeItem(${item.id})"></i>
                `;
            cartItemsDiv.appendChild(itemDiv);
            total += item.price;
        });

        cartTotalDiv.innerHTML = `Total: R$ ${total.toFixed(2).replace('.', ',')}`;
        modal.style.display = 'block';
    }

    function closeCartModal() {
        document.getElementById('cartModal').style.display = 'none';
    }

    function removeItem(id) {
        cart = cart.filter(item => item.id !== id);
        localStorage.setItem('cart', JSON.stringify(cart));
        openCartModal();
        updateCartIcon();
    }

    function checkout() {
        alert('Compra finalizada!');
        cart = [];
        localStorage.setItem('cart', JSON.stringify(cart));
        closeCartModal();
        updateCartIcon();
    }

    function updateCartIcon() {
        const itemCount = cart.length;
        document.querySelector('.item-count').textContent = itemCount;
    }

    function addToCart(productId, name, price) {
        const item = { id: productId, name: name, price: price };
        cart.push(item);
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCartIcon();
    }
</script>

</html>