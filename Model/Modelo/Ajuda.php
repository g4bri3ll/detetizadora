<?php

class Ajuda{
	
	private $id;
	private $titulo;
	private $descricao;
	private $data;
	private $status;
	private $idAcesso;
	
	//Atribuir o set a todos os atributos
	public function __set($atrib, $value){
		$this->$atrib = $value;
	}
	
	//Atribuir o get a todos os atributos
	public function __get($atrib){
		return $this->$atrib;
	}
	
}