<?php
session_start();

// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "powergames";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão com o banco de dados: " . $conn->connect_error);
}

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];

$items = [];
$total = 0;
foreach ($cart as $productId => $quantity) {
    $sql = "SELECT id, nome, valor, url_imagem FROM produto WHERE id = $productId";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $row['quantidade'] = $quantity;
        $row['subtotal'] = $row['valor'] * $quantity;
        $total += $row['subtotal'];
        $items[] = $row;
    }
}

$conn->close();

?>


<?php
abstract class DiscountTemplate
{
    // Método template
    public function calculateTotal($total)
    {
        return $total - $this->applyDiscount($total);
    }

    // Método abstrato a ser implementado pelas subclasses
    abstract protected function applyDiscount($total);
}
?>



<?php
class BlackFridayDiscount extends DiscountTemplate
{
    protected function applyDiscount($total)
    {
        return $total * 0.50; // Desconto de 50%
    }
}

class ChristmasDiscount extends DiscountTemplate
{
    protected function applyDiscount($total)
    {
        return $total * 0.30; // Desconto de 30%
    }
}
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="../css/home3.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Carrinho de Compras</title>
    <style>
        .cart-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
        }

        .cart-item img {
            width: 50px;
            height: auto;
            border-radius: 5px;
        }

        .cart-item h3 {
            font-size: 20px;
            margin: 0;
        }

        .cart-item p {
            margin: 0;
        }

        .cart-item .remove-item {
            color: red;
            cursor: pointer;
        }

        .total {
            font-size: 24px;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
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





    <div class="cart-container">
        <h2>Carrinho de Compras</h2>
        <?php foreach ($items as $item): ?>
            <div class="cart-item" data-id="<?php echo $item['id']; ?>">
                <img src="<?php echo $item['url_imagem']; ?>" alt="<?php echo $item['nome']; ?>">
                <div>
                    <h3><?php echo $item['nome']; ?></h3>
                    <p>Quantidade: <?php echo $item['quantidade']; ?></p>
                    <p>Subtotal: R$ <?php echo number_format($item['subtotal'], 2, ',', '.'); ?></p>
                </div>
                <i class="fas fa-trash remove-item"></i>
            </div>
        <?php endforeach; ?>
        <div class="total">
            Total: R$ <?php echo number_format($total, 2, ',', '.'); ?>
        </div>
        <button id="checkoutBtn">Finalizar Compra</button>

        <script>
            document.getElementById('checkoutBtn').addEventListener('click', function () {
                const discountType = discountSelect.value;
                const discountedTotal = totalElement.innerText.replace('Total: R$', '').replace(',', '.');

                fetch('finalize_purchase.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `discountType=${discountType}&total=${discountedTotal}`
                })
                    .then(response => response.text())
                    .then(data => {
                        if (data === 'success') {
                            alert('Compra finalizada com sucesso!');
                            location.reload();
                        } else {
                            alert('Erro ao finalizar a compra.');
                        }
                    });
            });
        </script>

        <div class="discount-container">
            <label for="discountType">Escolha o desconto:</label>
            <select id="discountType">
                <option value="none">Sem desconto</option>
                <option value="blackFriday">Black Friday (50%)</option>
                <option value="christmas">Natal 2024 (30%)</option>
            </select>
        </div>


    </div>

    <script>
        document.querySelectorAll('.remove-item').forEach(button => {
            button.addEventListener('click', function () {
                const cartItem = this.closest('.cart-item');
                const productId = cartItem.getAttribute('data-id');
                fetch('remove_from_cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: 'id_produto=' + productId
                })
                    .then(response => response.text())
                    .then(data => {
                        if (data === 'success') {
                            cartItem.remove();
                            updateTotal();
                        } else {
                            alert('Falha ao remover item do carrinho.');
                        }
                    });
            });
        });

        function updateTotal() {
            let total = 0;
            document.querySelectorAll('.cart-item').forEach(item => {
                const subtotal = parseFloat(item.querySelector('p:last-of-type').innerText.replace('Subtotal: R$', '').replace(',', '.'));
                total += subtotal;
            });
            document.querySelector('.total').innerText = 'Total: R$ ' + total.toFixed(2).replace('.', ',');
        }


        const discountSelect = document.getElementById('discountType');
        const totalElement = document.querySelector('.total');
        const originalTotal = parseFloat(<?php echo $total; ?>);

        discountSelect.addEventListener('change', function () {
            let discountedTotal = originalTotal;

            if (this.value === 'blackFriday') {
                discountedTotal -= originalTotal * 0.50; // Desconto de 50%
            } else if (this.value === 'christmas') {
                discountedTotal -= originalTotal * 0.30; // Desconto de 30%
            }

            totalElement.innerText = 'Total: R$ ' + discountedTotal.toFixed(2).replace('.', ',');
        });
    </script>
</body>

</html>