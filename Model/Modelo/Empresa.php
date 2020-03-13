<?php

class Empresa{
	
	private $id;
	private $nome;
	private $cnpj;
	private $razaoSocial;
	private $status;
	private $logoMarca;
	private $assinatura;
	private $idUsuarioResponsavel;
	private $dataCadastro;
	private $endereco;
	private $email;
	private $telefone;
											
	//Atribuir o set a todos os atributos
	public function __set($atrib, $value){
		$this->$atrib = $value;
	}
	
	//Atribuir o get a todos os atributos
	public function __get($atrib){
		return $this->$atrib;
	}
	
}