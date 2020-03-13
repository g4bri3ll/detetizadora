<?php

include_once 'Conexao/Conexao.php';

class SetorDAO {
	
	private $conn = null;
	
	//Cadastrar o nome do setor
	public function cadastrar($nome, $status) {
		
		try {
			
			$sql = "INSERT INTO setor (nome_setor, status) VALUES 
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
	
	//Cadastrar o id do setor e contrato para contrato.php
	public function CadastrarSetorContrato($idContrato, $idSetor, $status, $dataCadastro) {
		
		try {
			
			$sql = "INSERT INTO contratos_setores (contratos_id, setor_id, status, dt_cadastro) VALUES 
					('" . $idContrato . "', '" . $idSetor . "', '" . $status . "', '" . $dataCadastro . "')";
			
			
			
			$conn = new Conexao ();
			$conn->openConnect ();
			
			$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD());
			$resultado = mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
			
			return true;
			
		} catch ( PDOException $e ) {
			return $e->getMessage();
		}
		
	}
	
	//Cadastrar o id do setor e contrato para renova em renovaContratos.php
	public function CadastrarSetorNoContratoParaRenova($idSetor, $status, $dtCadastro, $idContratoRenova, $idContt) {
		
		try {
			
			$sql = "INSERT INTO contratos_setores (setor_id, status, dt_cadastro, contrato_renova_id, contratos_id) 
					VALUES ('" . $idSetor . "', '" . $status . "', '" . $dtCadastro . "', '" . $idContratoRenova . "', 
					'" . $idContt . "')";
			
			$conn = new Conexao ();
			$conn->openConnect ();
			
			$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD());
			$resultado = mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
			
			return true;
			
		} catch ( PDOException $e ) {
			return $e->getMessage();
		}
		
	}
	
	public function DeletaId($status, $id) {
		
		try {
			
			$sql = "UPDATE setor SET status = '".$status."' WHERE id = '".$id."'";
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
	
	//Deleta do renovaContratos.php
	public function DeletaTipoServicoParaRenova($status, $id) {
		
		try {
			
			$sql = "DELETE FROM tipo_servico_por_contrato WHERE contrato_id = '".$id."' AND status = '".$status."'";
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
	
	//Excluir os tipo de servico para lista novas datas em contrato.php
	public function DeletaTipoServicoParaContrato($status) {
		
		try {
			
			$sql = "DELETE FROM tipo_servico_por_contrato WHERE status = '".$status."'";
			
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
	
	//Lista todas as paginas de acesso do sistema para criarAcessoSistema.php e armadilhaIscagem,php
	public function Lista(){
		
		$sql = "SELECT * FROM setor WHERE status = 'ativado' ORDER BY id DESC";
		
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

	//Lista todas os setores para armadilhaIscagem.php
	public function ListaSetoresParaArmadilha(){
		
		$sql = "SELECT * FROM setor WHERE status = 'ativado'";
		
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
	
	//Lista todas os setores ativo no sistema para contrato.php e ordemDeServicoPrograma.php e controleDePragas.php
	public function ListaSetoresAtivo(){
		
		$sql = "SELECT * FROM setor WHERE status = 'ativado' ORDER BY id DESC";
		
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
	
	//Lista todas os setores pelo id do contrato para cdastraSetorXPraga.php
	public function ListaSetoresParaPragas($idContrato){
		
		$sql = "SELECT * FROM contratos_setores cs
				INNER JOIN setor s ON(cs.setor_id = s.id) 
				WHERE contratos_id = '".$idContrato."'";
		
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
	public function VerificaCad($nome, $status){
		
		$sql = "SELECT * FROM setor WHERE nome_setor LIKE '".$nome."' AND status = '".$status."'";
		
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