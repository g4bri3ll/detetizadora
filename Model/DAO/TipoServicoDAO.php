<?php

include_once 'Conexao/Conexao.php';

class TipoServicoDAO {

	private $conn = null;
	
	//Cadastrar o tipo de servico oferecido
	public function cadastrar($nome, $status) {
		
			try {
				
				$sql = "INSERT INTO tipo_servico (nome, status)	VALUES ('" . $nome . "', '" . $status . "')";
				
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

	//Cadastrar o objeto do tipo do servico
	public function cadastrarOb($objeto, $status, $idTipoServico) {
		
			try {
				
				$sql = "INSERT INTO objetos_tipo_servico (nome, status, tipo_servico_id) VALUES 
						('" . addslashes($objeto) . "', '" . $status . "', '" . $idTipoServico . "')";
				
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
	
	//Cadastrar o tipo de objeto
	public function cadastrarTipoOb($tipoObjeto, $status, $idTipoObjeto, $registro) {
		
			try {
				
				$sql = "INSERT INTO tipo_objetos (nome, status, objetos_id, registro) VALUES 
						('" . addslashes($tipoObjeto) . "', '" . $status . "', '" . $idTipoObjeto . "', '" . $registro . "')";
				
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
	
	//Desativa o tipo de servico
	public function deleteId($id, $status) {

		try {
		
			$sql = "UPDATE tipo_servico SET status = '".$status."' WHERE id = '" . $id . "'";
			
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
	
	//Desativa o objeto do servico
	public function DesativaObjeto($id, $status) {

		try {
		
			$sql = "UPDATE objetos_tipo_servico SET status = '".$status."' WHERE id = '" . $id . "'";
			
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
	
	//Desativa o produto do objetos
	public function DeleteIdProduto($id, $status) {

		try {
		
			$sql = "UPDATE tipo_objetos SET status = '".$status."' WHERE id = '" . $id . "'";
			
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
	
	//Lista todos os tipo de servico ativo no sistema
	public function listaTipoServico(){
		
		$sql = "SELECT * FROM tipo_servico WHERE status = 'ativado' ORDER BY id DESC";

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
	
	//Lista os tipos de servicos para o contrato.php
	public function ListaTodosTipoServico(){
		
		$sql = "SELECT * FROM tipo_servico WHERE status = 'ativado'";

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
	
	//Lista todos os objetos para o contrato.php
	/*
	public function ListaTodosObjetos(){
		
		$sql = "SELECT * FROM objetos_tipo_servico WHERE status = 'ativado'";

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
		
	}*/
	
	//Lista todos os tipos do objetos para o contrato.php
	/*
	public function ListaTodosTipoObjetos(){
		
		$sql = "SELECT * FROM tipo_objetos WHERE status = 'ativado'";

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
		
	}*/
	
	//Lista todos os tipo de objetos ativo no sistema para controleDePragas.php
	public function listaTipoObjetos(){
		
		$sql = "SELECT id, nome FROM objetos_tipo_servico WHERE status = 'ativado' ORDER BY id DESC";

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
	
	//Lista todos os objetos do tipo de servico para cadastraObjetosDoServicos.php
	public function ListaObjetosCadAtivos(){
		
		$sql = "SELECT ots.id, ots.nome as nome_objeto, ots.status, ts.nome  
				FROM objetos_tipo_servico ots 
				INNER JOIN tipo_servico ts ON(ots.tipo_servico_id = ts.id)
				WHERE ots.status = 'ativado' ORDER BY ots.id DESC";

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
	
	//Lista todos os produtos do objetos para cadastrarProduto.php
	public function ListaProdutosObjeto(){
		
		$sql = "SELECT tos.id, ots.nome as nome_objeto, tos.status, tos.nome  
				FROM objetos_tipo_servico ots 
				INNER JOIN tipo_objetos tos ON(ots.id = tos.objetos_id)
				WHERE tos.status = 'ativado' ORDER BY tos.id DESC";

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
	
	//Lista todos os tipo de objetos ativo para cadastraoTipoDeServico.php
	public function listaTipoServicoAtivo(){
		
		$sql = "SELECT * FROM tipo_servico WHERE status = 'ativado' ORDER BY id DESC";

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
	
	//Verificar o cadastro do tipo de servico se foi cadastrado
	public function VerificaCad($nome){
		
		$sql = "SELECT * FROM tipo_servico WHERE nome LIKE '".$nome."' AND status = 'ativado'";

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
	
	//Verificar se o objeto do tipo de servico foi cadastrado
	public function VerificaCadOb($objeto, $idTipoServico){
		
		$sql = "SELECT * FROM objetos_tipo_servico WHERE nome LIKE '".addslashes($objeto)."' AND status = 'ativado' AND tipo_servico_id = '".$idTipoServico."'";

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
	
	//Verificar se o tipo de objeto foi cadastrado
	public function VerificaCadTipoOb($tipoObjeto, $idTipoObjeto){
		
		$sql = "SELECT * FROM tipo_objetos WHERE nome LIKE '".addslashes($tipoObjeto)."' AND status = 'ativado' AND objetos_id = '".$idTipoObjeto."'";

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