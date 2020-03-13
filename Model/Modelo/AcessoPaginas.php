<?php

class AcessoPaginas{
	
	private $id;
	private $nome;
	private $idPaginas;
	private $status;
	private $idPaginaAcesso;
	
	//Atribuir o set a todos os atributos
	public function __set($atrib, $value){
		$this->$atrib = $value;
	}
	
	//Atribuir o get a todos os atributos
	public function __get($atrib){
		return $this->$atrib;
	}
	
}