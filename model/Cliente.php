<?php

class Cliente {
    private $nome;
    private $sobrenome;
    private $cpf;
    private $telefone;
    private $email;
    private $senha;

    // Construtor
    public function __construct($nome, $sobrenome, $cpf, $telefone, $email, $senha) {
        $this->nome = $nome;
        $this->sobrenome = $sobrenome;
        $this->cpf = $cpf;
        $this->telefone = $telefone;
        $this->email = $email;
        $this->senha = $senha;
    }

    // Métodos getter (acessadores)
    public function get_Nome() {
        return $this->nome;
    }

    public function get_Sobrenome() {
        return $this->sobrenome;
    }

    public function get_Cpf() {
        return $this->cpf;
    }

    public function get_Telefone() {
        return $this->telefone;
    }

    public function get_Email() {
        return $this->email;
    }

    public function get_Senha() {
        return $this->senha;
    }
}

?>
