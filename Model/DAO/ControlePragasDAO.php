<?php

include_once 'Conexao/Conexao.php';

class ControlePragasDAO {
	
	private $conn = null;
	
	//Cadastrar o controle de pragas pelo cliente
	public function CadastrarControlerC(ControleDePragas $controle) {
		
		try {
			
			$sql = "INSERT INTO controle_de_pragas (pragas_id, status, cliente_id, descricao_cliente, qtd_pragas, data_cliente_inserir, contrato_id, setor_id) VALUES 
					('" . $controle->idPragas . "', '" . $controle->status . "', '" . $controle->idClientes . "', '" . $controle->descricaoCliente . "', 
					'" . $controle->qtdPragas . "', '" . $controle->dataCliente . "', '" . $controle->idContrato . "', '".$controle->idSetor."')";
			
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

	//Cadastrar a justificativa do funcionario
	public function CadastraJustificativaFunc(ControleDePragas $controle) {
		
		try {
			
            $sql = "UPDATE controle_de_pragas SET descricao_usuario = '" . $controle->descricaoFuncionario . "', 
					data_usuario_inserir = '" . $controle->dataFuncionario . "', status = '" . $controle->status . "', 
					usuario_id = '" . $controle->idFuncionarios . "', nome_foto = '".$controle->nomeFoto."' WHERE id = '" . $controle->id . "'";
			
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
	
	public function Lista(){
		
		$sql = "SELECT * FROM controle_de_pragas";
		
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
	
	//Lista a quantidade de pragas selecionada pelo cliente, relatando que ainda tem
	/*public function ListaQtdParaGrafico(){
		
		$sql = "SELECT * FROM controle_de_pragas";
		
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
		
	}*/
	
	//Lista somente pragas ativa
	public function ListaPragaAtiva(){
		
		$sql = "SELECT * FROM controle_de_pragas WHERE status = 'ativado'";
		
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
	
	//Lista pragas pelo id para justificarControleDePragas.php
	public function ListaPragasPeloId($idPraga){
		
		$sql = "SELECT cp.id, c.nome_contrato, p.nome_pragas
				FROM controle_de_pragas cp 
				INNER JOIN contratos c ON(cp.contrato_id = c.id) 
				INNER JOIN pragas p ON(cp.pragas_id = p.id)
				WHERE cp.id = '".$idPraga."'";
		
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
	
	
	//Verificar se este cadastrado ja foi feito esse dia
	public function VerificarCadPelaData($idPragas, $status, $idCliente, $idContrato){
		
		$sql = "SELECT * FROM controle_de_pragas 
				WHERE status = '".$status."' 
				AND pragas_id = '".$idPragas."' 
				AND cliente_id = '".$idCliente."' 
				AND contrato_id = '".$idContrato."'";
		
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
	
		//Verificar se este cadastrado ja foi feito esse dia
	public function VerificarCadPeloMes($mes, $idPragas, $status, $idCliente, $idContrato){
		
		$sql = "SELECT * FROM controle_de_pragas 
				WHERE status = '".$status."' 
				AND pragas_id = '".$idPragas."' 
				AND cliente_id = '".$idCliente."' 
				AND contrato_id = '".$idContrato."'
				AND MONTH(data_usuario_inserir) = '".$mes."'";
		
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