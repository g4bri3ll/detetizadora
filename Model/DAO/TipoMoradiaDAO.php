<?php

include_once 'Conexao/Conexao.php';

class TipoMoradiaDAO {

	private $conn = null;
	
	public function cadastrar($nome, $status) {
		
			try {
				
				$sql = "INSERT INTO tipo_residencia (nome, status)	VALUES ('" . $nome . "', '" . $status . "')";
				
				$conn = new Conexao ();
				$conn->openConnect ();
				
				$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD());
				$resultado = mysqli_query ( $conn->getCon (), $sql );
				
				$conn->closeConnect ();
								
				return true;
				
			} catch ( PDOException $e ) {
				
				echo $e->getMessage();
				return false;
								
			}
			
	}

	public function deleteId($id, $status) {

		try {
		
			$sql = "UPDATE tipo_residencia SET status = '".$status."' WHERE id = '" . $id . "'";
			
			$conn = new Conexao ();
			$conn->openConnect ();
			
			mysqli_select_db ( $conn->getCon (), $conn->getBD());
			$resultado = mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
			
			return true;
			
		} catch (PDOException $e){
			return false;
		}
		
	}
	
	//Lista para o cadastraTipoMOradia.php
	public function ListaMoradia(){
		
		$sql = "SELECT * FROM tipo_residencia WHERE status = 'ativado' ORDER BY id DESC";

		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$arrayUsuarios = array();
		
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayUsuarios[]=$row;
		}
		
		$conn->closeConnect ();
		return $arrayUsuarios;
		
	}
	
	//Lista para o cadastroComplementoCliente.php
	public function ListaMoradiaAtivo(){
		
		$sql = "SELECT * FROM tipo_residencia WHERE status = 'ativado' ORDER BY id DESC";

		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$arrayUsuarios = array();
		
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayUsuarios[]=$row;
		}
		
		$conn->closeConnect ();
		return $arrayUsuarios;
		
	}
	
	public function VerificaCad($nome){
		
		$sql = "SELECT * FROM tipo_residencia WHERE nome LIKE '".$nome."' AND status = 'ativado'";

		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$arrayUsuarios = array();
		
		while ($row = mysqli_fetch_assoc($resultado)) {
			$arrayUsuarios[]=$row;
		}
		
		$conn->closeConnect ();
		return $arrayUsuarios;
		
	}
	
}
?>