<?php

require_once("../model/Produto.php");
require_once("../model/Cliente.php");
require_once("../controller/Controlador.php");
require_once("../factory/FabricaCliente.php");
require_once("../factory/FabricaProduto.php");

class BancoDeDados
{
    private static $instance = null; // A única instância da classe
    private $conexao;

    // Construtor privado para impedir criação de instâncias externas
    private function __construct($host, $usuario, $senha, $banco)
    {
        $this->conexao = new mysqli($host, $usuario, $senha, $banco);
        if ($this->conexao->connect_error) {
            die("Conexão falhou: " . $this->conexao->connect_error);
        }
    }

    // Método estático para obter a única instância da classe
    public static function getInstance($host, $usuario, $senha, $banco)
    {
        if (self::$instance === null) {
            self::$instance = new BancoDeDados($host, $usuario, $senha, $banco);
        }
        return self::$instance;
    }

    // Exemplo de métodos da classe

    public function inserirCliente($cliente)
    {
        // Primeiro, verificamos se o e-mail já existe
        $email = $cliente->get_Email();
        $stmt = $this->conexao->prepare("SELECT id FROM cliente WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
    
        if ($stmt->num_rows > 0) {
            // E-mail já existe
            echo "Erro: O e-mail já está cadastrado.";
            return false;
        }
    
        // Se o e-mail não existir, insira o novo cliente
        $nome = $cliente->get_Nome();
        $sobrenome = $cliente->get_Sobrenome();
        $cpf = $cliente->get_Cpf();
        $telefone = $cliente->get_Telefone();
        $email = $cliente->get_Email();
        $senha = $cliente->get_Senha();
    
        $stmt = $this->conexao->prepare("INSERT INTO cliente (nome, sobrenome, cpf, telefone, email, senha) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $nome, $sobrenome, $cpf, $telefone, $email, $senha);
        return $stmt->execute();
    }
    
    
    public function inserirProduto($produto)
    {
        $conexao = $this->conexao;

        // Obter os dados da desenvolvedora
        $desenvolvedoraNome = $produto->get_Fabricante();

        // Verificar se a desenvolvedora já existe
        $checkQuery = "SELECT id FROM desenvolvedora WHERE nome = ?";
        $checkStmt = mysqli_prepare($conexao, $checkQuery);
        mysqli_stmt_bind_param($checkStmt, 's', $desenvolvedoraNome);
        mysqli_stmt_execute($checkStmt);
        mysqli_stmt_bind_result($checkStmt, $desenvolvedoraId);
        mysqli_stmt_fetch($checkStmt);
        mysqli_stmt_close($checkStmt);

        // Se a desenvolvedora não existir, insira-a
        if (is_null($desenvolvedoraId)) {
            $insertDevQuery = "INSERT INTO desenvolvedora (nome) VALUES (?)";
            $insertDevStmt = mysqli_prepare($conexao, $insertDevQuery);
            mysqli_stmt_bind_param($insertDevStmt, 's', $desenvolvedoraNome);
            mysqli_stmt_execute($insertDevStmt);
            mysqli_stmt_close($insertDevStmt);

            // Obter o ID da desenvolvedora recém-inserida
            $desenvolvedoraId = mysqli_insert_id($conexao);
        }

        // Agora, insira o produto
        $consulta = "INSERT INTO produto (nome, desenvolvedora_id, descricao, valor, url_imagem) 
                     VALUES (?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conexao, $consulta);

        if ($stmt) {
            $nome = $produto->get_Nome();
            $descricao = $produto->get_Descricao();
            $valor = $produto->get_Valor();
            $caminhoImagem = $produto->get_CaminhoImagem();

            mysqli_stmt_bind_param($stmt, 'sssss', $nome, $desenvolvedoraId, $descricao, $valor, $caminhoImagem);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
                echo "Produto inserido com sucesso.";
            } else {
                echo "Erro ao inserir o produto.";
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Erro na preparação da consulta.";
        }
    }

    public function retornarClientes()
    {
        $consulta = "SELECT * FROM cliente";
        return mysqli_query($this->conexao, $consulta);
    }

    public function retornarProdutos()
    {
        $consulta = "SELECT nome, desenvolvedora_id, descricao, valor, url_imagem FROM produto";
        return mysqli_query($this->conexao, $consulta);
    }

    // Novo método para retornar produtos com JOIN
    public function retornarProdutosComJoin()
    {
        $consulta = "
            SELECT p.nome AS produto_nome, d.nome AS desenvolvedora_nome, p.descricao, p.valor, p.url_imagem 
            FROM produto p
            JOIN desenvolvedora d ON p.desenvolvedora_id = d.id
        ";
        return mysqli_query($this->conexao, $consulta);
    }
}

?>