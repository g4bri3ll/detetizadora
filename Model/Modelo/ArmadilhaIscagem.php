<?php

class ArmadilhaIscagem{
	
	private $id;
	private $ordem_servico_programa_id;
	private $setor_id;
	private $contrato_id;
	private $equipamento;
	private $status;
	private $posicao_instalada;
	private $identificacao;
	private $data_instalacao;
	private $armadilhaDispositivo;
	private $caminhoFoto;
	private $quantidade;
	private $check;
	private $data;
	private $select;
	
	//Atribuir o set a todos os atributos
	public function __set($atrib, $value){
		$this->$atrib = $value;
	}
	
	//Atribuir o get a todos os atributos
	public function __get($atrib){
		return $this->$atrib;
	}
	
}