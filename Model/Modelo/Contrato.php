<?php

class Contrato{
	
	private $id;
	private $idContratoRenovado;
	private $nome;
	private $idCliente;
	private $idTipoServico;
	private $idObjeto;
	private $idTipoObjeto;
	private $status;
	private $dataCadastro;
	private $dataInicio;
	private $dataFinal;
	private $diaContrato;
	private $valorTotalContrato;
	private $idFuncionario;
	private $nomeDoc;
	private $diaPgto;
	private $dataCriacao;
	private $dataRenova;
	private $visivelOS;
	
	//Atribuir o set a todos os atributos
	public function __set($atrib, $value){
		$this->$atrib = $value;
	}
	
	//Atribuir o get a todos os atributos
	public function __get($atrib){
		return $this->$atrib;
	}
	
}