<?php

class Conexao {
	
	var $con = NULL;
	
	function __construct() {
	
	}
	
	function getCon() {
		return $this->con;
	}
	
	function setCon($con) {
		$this->con = $con;
	}
	
	function openConnect(){
		$this->setCon( mysqli_connect('localhost','id1679663_projeto_igor','gabrieldo') );
		if( !$this->getCon() ){
			die('Erro na conexao'. mysqli_error());
			return FALSE;
		}
		return TRUE;
	
	}
	
	function getBD(){
		return 'id1679663_projeto_igor';
	}
	
	function closeConnect(){
		mysqli_close($this->getCon());
	}
	
	function isConnected(){
		if( $this->getCon() ){
			return TRUE;
		}
		return FALSE;
	}
	
}
?>