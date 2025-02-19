<?php

require_once "../model/BancoDeDados.php";
require_once "../model/Cliente.php";


class Controlador
{

    private $bancoDeDados;

    public function __construct()
    {
        // Chama o Singleton em vez de criar uma nova instância
        $this->bancoDeDados = BancoDeDados::getInstance("localhost", "root", "", "powergames");
    }

    public function cadastrarCliente($nome, $sobrenome, $cpf, $telefone, $email, $senha)
    {
        $senhaHash = password_hash($senha, PASSWORD_BCRYPT); // Hash da senha
        $cliente = new Cliente($nome, $sobrenome, $cpf, $telefone, $email, $senhaHash);
        return $this->bancoDeDados->inserirCliente($cliente);
    }


    public function cadastrarProduto($nome, $fabricante, $descricao, $valor, $caminhoImagem)
    {
        $produto = new Produto($nome, $fabricante, $descricao, $valor, $caminhoImagem);
        $this->bancoDeDados->inserirProduto($produto);
    }


    public function visualizarProdutos()
    {
        $produtos = "";
        $listaProdutos = $this->bancoDeDados->retornarProdutosComJoin(); // Usar o novo método
    
        while ($produto = mysqli_fetch_assoc($listaProdutos)) {
            $produtos .= "<section class=\"conteudo-bloco\">" .
                "<h2>" . $produto['produto_nome'] . "</h2>" .
                "<p>Fabricante: " . $produto['desenvolvedora_nome'] . "</p>" . // Usar o nome da desenvolvedora
                "<p>Descrição: " . $produto['descricao'] . "</p>" .
                "<p>Valor: " . $produto['valor'] . "</p>" .
                "<img src=\"" . $produto['url_imagem'] . "\"/>" .
                "</section>";
        }
        return $produtos;
    }
    
    



    public function visualizarClientes()
    {
        $clientes = "";
        $listaClientes = $this->bancoDeDados->retornarClientes();
        while ($cliente = mysqli_fetch_assoc($listaClientes)) {
            $clientes .= "<section class=\"conteudo-bloco\">" .
                "<h2>" . $cliente["nome"] . "</h2>" .
                "<p>Sobrenome: " . $cliente["sobrenome"] . "</p>" .
                "<p>Cpf: " . $cliente["cpf"] . "</p>" .
                "<p>Telefone: " . $cliente["telefone"] . "</p>" .
                "<p>Email: " . $cliente["email"] . "</p>" .
                "<p>Senha: " . $cliente["senha"] . "</p>" .
                "<a href=\"deletarCliente.php?id=" . $cliente['id'] . "\">Deletar</a>" .
                "</section>";
        }
        return $clientes;
    }


    public function deletarCliente($id)
    {
        // Conexão com o banco de dados
        // Supondo que você já tenha uma instância de conexão ou use PDO, por exemplo
        $conexao = new PDO('mysql:host=localhost;dbname=powergames', 'root', '');

        // Query SQL para deletar o cliente com o ID especificado
        $query = "DELETE FROM cliente WHERE id = :id";
        $stmt = $conexao->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Executa a query
        if ($stmt->execute()) {
            return true; // Deletado com sucesso
        } else {
            return false; // Erro ao deletar
        }
    }

    public function obterCliente()
    {
        // Conexão com o banco de dados
        // Supondo que você já tenha uma instância de conexão ou use PDO, por exemplo
        $conexao = new PDO('mysql:host=localhost;dbname=powergames', 'root', '');

        // Query SQL para selecionar todos os cliente
        $query = "SELECT * FROM cliente";
        $stmt = $conexao->prepare($query);

        // Executa a query
        $stmt->execute();

        // Retorna os resultados como um array associativo
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function verificarLogin($email, $senha)
    {
        // Verifica se o email e a senha correspondem ao admin
        if ($email === 'admin@admin.com' && $senha === 'admin@admin.com') {
            $_SESSION['estaLogado'] = true;
            $_SESSION['usuario'] = 'admin'; // Opcional: para identificar que é o admin
            header('Location: ../view/homeAdmin.php'); // Redireciona para a página admin
            exit(); // Termina a execução do script
        }

        // Conexão com o banco de dados
        $conexao = new mysqli("localhost", "root", "", "powergames");
        $email = $conexao->real_escape_string($email);
        
        // Consulta para verificar se o cliente existe com as credenciais fornecidas
        $query = "SELECT senha FROM cliente WHERE email = '$email'";
        $resultado = $conexao->query($query);
        
        // Verifica se algum resultado foi retornado
        if ($resultado->num_rows > 0) {
            $cliente = $resultado->fetch_assoc();
            // Compara a senha fornecida com a senha armazenada (se for armazenada como hash, utilize password_verify)
            return password_verify($senha, $cliente['senha']); // Verifica a senha
        }

        return false; // Login falhou
    }

}

?>