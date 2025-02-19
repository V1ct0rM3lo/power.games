<?php

class Produto
{
    //Atributos
    protected $nome;
    protected $fabricante;
    protected $descricao;
    protected $valor;
    protected $caminhoImagem; // Novo atributo para o caminho da imagem

    //Construtor
    public function __construct($Nome, $Fabricante, $Descricao, $Valor, $CaminhoImagem = null)
    {
        $this->nome = $Nome;
        $this->fabricante = $Fabricante;
        $this->descricao = $Descricao;
        $this->valor = $Valor;
        $this->caminhoImagem = $CaminhoImagem; // Adiciona o caminho da imagem
    }

    //Getter e Setter
    public function get_Nome()
    {
        return $this->nome;
    }

    public function set_Nome($Nome)
    {
        $this->nome = $Nome;
    }

    public function get_Fabricante()
    {
        return $this->fabricante;
    }

    public function set_Fabricante($Fabricante)
    {
        $this->fabricante = $Fabricante;
    }

    public function get_Descricao()
    {
        return $this->descricao;
    }

    public function set_Descricao($Descricao)
    {
        $this->descricao = $Descricao;
    }

    public function get_Valor()
    {
        return $this->valor;
    }

    public function set_Valor($Valor)
    {
        $this->valor = $Valor;
    }

    // Novos métodos getter e setter para o caminho da imagem
    public function get_CaminhoImagem()
    {
        return $this->caminhoImagem;
    }

    public function set_CaminhoImagem($CaminhoImagem)
    {
        $this->caminhoImagem = $CaminhoImagem;
    }

    //Métodos
    public function aplicarCupom($cupomTaxa)
    {
        $valorDesconto = ($this->valor * $cupomTaxa) / 100;
        $this->valor -= $valorDesconto; // Atualiza o valor com desconto
    }
}

?>