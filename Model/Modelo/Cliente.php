<?php

class Cliente{
	
	private $id;
	private $nome;
	private $tipoCliente;
	private $dataNascimento;
	private $rg;
	private $cpf;
	private $sexo;
	private $email;
	private $status;
	private $dataCadastro;
	private $nomeFantasia;
	private $razaoSocial;
	private $cep;
	private $cnpj;
	private $cidade;
	private $endereco;
	private $bairro;
	private $complemento;
	private $referencia;
	private $idTipoResidencia;
	private $telefone;
	private $estadualMunicipal;
	private $ramal;
	private $celular;
	private $idComoEncontro;
	private $numero;
	private $nomeResponsavel;
	private $nomeRepresentante;
	private $observacoes;
	private $idt;
	
	//Atribuir o set a todos os atributos
	public function __set($atrib, $value){
		$this->$atrib = $value;
	}
	
	//Atribuir o get a todos os atributos
	public function __get($atrib){
		return $this->$atrib;
	}
	
}