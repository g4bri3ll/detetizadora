<?php

include_once 'Conexao/Conexao.php';

class AjudarDAO {
	
	private $conn = null;
	
	//Cadastrar a ajudar do usuario no sistema
	public function cadastrar(Ajuda $ajuda) {
		
		try {
			
			$sql = "INSERT INTO ajudar (descricao, status, titulo, acesso_sistema_id, data) VALUES 
					('" . $ajuda->descricao . "', '" . $ajuda->status . "', '" . $ajuda->titulo . "', 
					'" . $ajuda->idAcesso . "', '" . $ajuda->data . "')";
			
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
	
	public function alterar() {
		
		try {
			
			$sql = "UPDATE ajudar SET paginas='" . $ace->nome . "' WHERE id = '" . $ace->id . "'";
			
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
	
	//deleta pelo id selecionado
	public function deleteId($id) {
		
		try {
			
			$sql = "DELETE FROM paginas WHERE id = '" . $id . "'";
			
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
	
	public function Lista(){
		
		$sql = "SELECT * FROM ajudar WHERE status = 'ativado'";
		
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
	
	public function ListaAjudarPeloAcesso($idAcesso){
		
		$sql = "SELECT * FROM ajudar WHERE status = 'ativado' AND acesso_sistema_id = '".$idAcesso."'";
		
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
	
	//Verificar se este titulo ja se encontra cadastrado na base de dados
	public function VerificaCad($titulo){
		
		$sql = "SELECT * FROM ajudar WHERE status = 'ativado' AND titulo = '".$titulo."'";
		
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
		
}
?>