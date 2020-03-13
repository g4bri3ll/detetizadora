<?php

class Usuario{
	
	private $id;
	private $nome;
	private $cpf;
	private $rg;
	private $status;
	private $dt_cadastro;
	private $telefone;
	private $endereco;
	private $cidade;
	private $bairro;
	private $cep;
	private $email;
	private $dt_nascimento;
	
	//Atribuir o set a todos os atributos
	public function __set($atrib, $value){
		$this->$atrib = $value;
	}
	
	//Atribuir o get a todos os atributos
	public function __get($atrib){
		return $this->$atrib;
	}
	
}