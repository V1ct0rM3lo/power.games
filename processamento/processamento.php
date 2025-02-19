<?php
session_start();
require_once("../model/Produto.php");
require_once("../model/Cliente.php");
require_once("../controller/Controlador.php");
require_once("../factory/FabricaCliente.php");
require_once("../factory/FabricaProduto.php");

$controlador = new Controlador();

// Função para verificar login
function verificarLogin($email, $senha) {
    $controlador = new Controlador();

    if ($email === "administrador@hotmail.com" && $senha === "admin123") {
        $_SESSION['estaLogado'] = true;
        header('Location: ../view/homeAdmin.php');
        die();
    }

    if ($controlador->verificarLogin($email, $senha)) {
        $_SESSION['estaLogado'] = true;
        header('Location: ../view/homeUsuario.php');
        die();
    } else {
        header('Location: ../view/login.php?error=invalid');
        die();
    }
}

// Função para cadastrar cliente
function cadastrarCliente($controlador, $dados) {
    // Criação do objeto Cliente utilizando a Fábrica
    $fabricaCliente = new FabricaCliente($dados);
    $cliente = $fabricaCliente->criarObjeto();

    // Inserir o cliente no banco de dados via Controlador
    if ($controlador->cadastrarCliente(
        $cliente->get_Nome(),      // Corrigido para get_Nome()
        $cliente->get_Sobrenome(), // Corrigido para get_Sobrenome()
        $cliente->get_Cpf(),       // Corrigido para get_Cpf()
        $cliente->get_Telefone(),  // Corrigido para get_Telefone()
        $cliente->get_Email(),     // Corrigido para get_Email()
        $cliente->get_Senha()      // Corrigido para get_Senha()
    )) {
        header('Location: ../view/login.php');
    } else {
        echo "Erro ao cadastrar cliente";
    }
    die();
}


// Função para cadastrar produto
function cadastrarProduto($controlador, $dados) {
    // Criação do objeto Produto utilizando a Fábrica
    $fabricaProduto = new FabricaProduto($dados);
    $produto = $fabricaProduto->criarObjeto();

    // Inserir o produto no banco de dados via Controlador
    if ($controlador->cadastrarProduto(
        $produto->getNome(),
        $produto->getFabricante(),
        $produto->getDescricao(),
        $produto->getValor(),
        $produto->getImagem()
    )) {
        header('Location: ../view/home.php');
        die();
    } else {
        echo "Erro ao cadastrar produto";
        die();
    }
}

// Verificar login
if (!empty($_POST['inputEmailLog']) && !empty($_POST['inputSenhaLog'])) {
    verificarLogin($_POST['inputEmailLog'], $_POST['inputSenhaLog']);
} else if (!empty($_POST['inputNome']) && !empty($_POST['inputSobrenome']) &&
    !empty($_POST['inputCPF']) && !empty($_POST['inputTelefone']) &&
    !empty($_POST['inputEmail']) && !empty($_POST['inputSenha'])) {

    $dadosCliente = [
        'nome' => $_POST['inputNome'],
        'sobrenome' => $_POST['inputSobrenome'],
        'cpf' => $_POST['inputCPF'],
        'telefone' => $_POST['inputTelefone'],
        'email' => $_POST['inputEmail'],
        'senha' => $_POST['inputSenha']
    ];

    // Chamar a função para cadastrar o cliente
    cadastrarCliente($controlador, $dadosCliente);
} else if (!empty($_POST['inputNomeProd']) && !empty($_POST['inputFabricanteProd']) &&
    !empty($_POST['inputDescricaoProd']) && !empty($_POST['inputValorProd']) &&
    isset($_FILES['inputImagemProd']) && !empty($_FILES['inputImagemProd']['name'])) {

    // Diretório de upload
    $diretorioUpload = "../uploads/";

    // Criar diretório caso não exista
    if (!is_dir($diretorioUpload)) {
        mkdir($diretorioUpload, 0755, true);
    }

    // Caminho do arquivo
    $caminhoArquivo = $diretorioUpload . basename($_FILES['inputImagemProd']['name']);
    move_uploaded_file($_FILES['inputImagemProd']['tmp_name'], $caminhoArquivo);

    // Dados do produto
    $dadosProduto = [
        'nome' => $_POST['inputNomeProd'],
        'fabricante' => $_POST['inputFabricanteProd'],
        'descricao' => $_POST['inputDescricaoProd'],
        'valor' => $_POST['inputValorProd'],
        'imagem' => $caminhoArquivo
    ];

    // Chamar a função para cadastrar o produto
    cadastrarProduto($controlador, $dadosProduto);
}
?>
