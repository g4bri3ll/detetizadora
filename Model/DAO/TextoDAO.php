<?php

include_once 'Conexao/Conexao.php';

class TextoDAO {
	
	private $conn = null;
	
	public function cadastrar($titulo, $descricao, $status) {
		
		try {
			
			$sql = "INSERT INTO texto_relatorios (titulo, descricao, status) VALUES ('" . $titulo . "', '" . $descricao . "', '" . $status . "')";
			
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
	
	//Lista todas as datas
	public function ListTexto(){
		
		$sql = "SELECT * FROM texto_relatorios WHERE status = 'ativado'";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$array = array();
		
		while ($row = mysqli_fetch_assoc($resultado)) {
			$array[]=$row;
		}
		
		$conn->closeConnect ();
		return $array;
		
	}
	
	//Lista todas as datas
	public function ExcluirTexto($id){
		
		try {
			
			$sql = "DELETE FROM texto_relatorios WHERE id = '".$id."'";
		
			$conn = new Conexao ();
			$conn->openConnect ();
			
			mysqli_select_db ( $conn->getCon (), $conn->getBD());
			$resultado = mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
			
			return true;
			
		} catch (PDOException $e) {
			
			return false;
			
		}
		
	}
	
}
?>