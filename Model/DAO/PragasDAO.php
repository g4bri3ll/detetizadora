<?php

include_once 'Conexao/Conexao.php';

class PragasDAO {
	
	private $conn = null;
	
	public function cadastrar($nome, $status) {
		
		try {
			
			$sql = "INSERT INTO pragas (nome_pragas, status) VALUES 
					('" . $nome . "', '" . $status . "')";
			
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
	
	public function DeletaIdPraga($status, $id) {
		
		try {
			
			$sql = "UPDATE pragas SET status = '".$status."' WHERE id = '".$id."'";
			echo $sql;
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
	
	//Lista todas as pragas
	public function ListaPragas(){
		
		$sql = "SELECT * FROM pragas WHERE status = 'ativado' ORDER BY id DESC";
		
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

	//Lista para ver sobre o contrale de pragas para justificarControleDePragas.php
	public function ListaParaControlePragasResponder(){
		
		$sql = "SELECT p.nome_pragas, c.nome_contrato, cli.nome, cp.id, cp.status, cp.qtd_pragas
				FROM pragas p 
				INNER JOIN controle_de_pragas cp ON(p.id = cp.pragas_id) 
				INNER JOIN contratos c ON(cp.contrato_id = c.id) 
				INNER JOIN cliente cli ON(c.clientes_id = cli.id)
				WHERE cp.status = 'pendente de resposta' 
				ORDER BY p.nome_pragas";
		
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
	
	//Lista todas as pragas ativa para relatorioOrdemServico.php e controleDePragas.php
	public function ListaPragasAtivaRelatorio(){
		
		$sql = "SELECT * FROM pragas WHERE status = 'ativado'";
		
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
	
	//Veirifaca se este acesso ja existe
	public function VerificaCad($nome){
		
		$sql = "SELECT * FROM pragas WHERE nome_pragas LIKE '".$nome."' AND status = 'ativado'";
		
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