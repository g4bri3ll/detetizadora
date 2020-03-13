<?php

class ControleDePragas{
	
	private $id;
	private $qtdPragas;
	private $idContrato;
	private $idPragas;
	private $idClientes;
	private $idFuncionarios;
	private $descricaoCliente;
	private $descricaoFuncionario;
	private $status;
	private $dataCliente;
	private $dataFuncionario;
	private $idSetor;
	private $nomeFoto;
	
	//Atribuir o set a todos os atributos
	public function __set($atrib, $value){
		$this->$atrib = $value;
	}
	
	//Atribuir o get a todos os atributos
	public function __get($atrib){
		return $this->$atrib;
	}
	
}