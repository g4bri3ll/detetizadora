<?php

include_once 'Conexao/Conexao.php';

class DataDAO {
	
	private $conn = null;
	
	public function cadastrar($data) {
		
		try {
			
			$sql = "INSERT INTO data (data) VALUES ('" . $data . "')";
			
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
	
	//Cadastrar por aqui se ja estiver dados na tabela data
	public function CadastrarDatasNovas($ultimaDia) {
		
		try {
			
			$sql = "INSERT INTO data (data) VALUES ('" . $ultimaDia . "')";
			
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
	public function Lista($dataInicio, $dataFinal){
		
		$sql = "SELECT * FROM data WHERE between ";
		
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
	
	//Lista a ultima data para cadastrar
	public function ListaUltimaData(){
		
		$sql = "SELECT * FROM data ORDER BY id DESC LIMIT 1";
		
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

	//Lista a ultima data para cadastrar
	public function ListaDataApartirHoje($dataInicio, $dataFinal){
		
		$sql = "SELECT * FROM data WHERE data BETWEEN '".$dataInicio."' AND '".$dataFinal."'";
		
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
	
	//Lista pelo mes e ano selecionado para
	public function ListaDataCompletaPeloMesAno($valorMesSemZero, $ano){
		
		$sql = "SELECT id, DAYNAME(data) as nome_do_dia_da_semana, MONTHNAME(data) as nome_do_mes, YEAR(data) as ano, 
				MONTH(data) as mes, DAYOFMONTH(data) as dia, data 
				FROM data 
				WHERE YEAR(data) = '".$ano."' AND MONTH(data) = '".$valorMesSemZero."'";
		
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