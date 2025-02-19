<?php

require_once("../model/Produto.php");
require_once("Fabrica.php");

class FabricaProduto implements Fabrica
{
    private $dados;

    public function __construct($dados)
    {
        $this->dados = $dados;
    }

    public function criarObjeto()
    {
        return new Produto(
            $this->dados['nome'],
            $this->dados['fabricante'],
            $this->dados['descricao'],
            $this->dados['valor'],
            $this->dados['imagem']
        );
    }
}
