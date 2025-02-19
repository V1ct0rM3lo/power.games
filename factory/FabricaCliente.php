<?php

require_once("../model/Cliente.php");
require_once("Fabrica.php");

class FabricaCliente implements Fabrica
{
    private $dados;

    public function __construct($dados)
    {
        $this->dados = $dados;
    }

    public function criarObjeto()
    {
        return new Cliente(
            $this->dados['nome'],
            $this->dados['sobrenome'],
            $this->dados['cpf'],
            $this->dados['telefone'],
            $this->dados['email'],
            $this->dados['senha']
        );
    }
}
