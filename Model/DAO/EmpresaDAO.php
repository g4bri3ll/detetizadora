<?php

include_once 'Conexao/Conexao.php';

class EmpresaDAO {
	
	private $conn = null;
	
	public function cadastrar(Empresa $empresa) {
		
		try {
			
			$sql = "INSERT INTO empresa (nome, razao_social, cnpj, status, assinatura_da_empresa, usuario_responsavel_id, logo_marca, data_cadastro,
					endereco, email, telefone) VALUES ('" . $empresa->nome . "', '" . $empresa->razaoSocial . "', '" . $empresa->cnpj . "', 
					'" . $empresa->status . "', '" . $empresa->assinatura . "', '" . $empresa->idUsuarioResponsavel . "', '" . $empresa->logoMarca . "', 
					'".$empresa->dataCadastro."', '".$empresa->endereco."', '".$empresa->email."', '".$empresa->telefone."')";
			
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
	
	public function excluirEmpresa($status, $id) {
		
		try {
			
			$sql = "UPDATE empresa SET status = '".$status."' WHERE id = '".$id."'";
			
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
	
	public function ListaEmpresa(){
		
		$sql = "SELECT * FROM empresa WHERE status = 'ativado' ORDER BY id DESC LIMIT 1";
		
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
	
	//Lista todas as empresas ja cadastrada
	public function ListaEmpresaCompleta(){
		
		$sql = "SELECT e.id, e.nome as nome_empresa, u.nome, e.cnpj, e.data_cadastro, e.assinatura_da_empresa, e.logo_marca, e.status 
				FROM empresa e INNER JOIN usuario u ON(e.usuario_responsavel_id = u.id) ORDER BY id DESC";
		
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
	
	//Verificar se quem esta na session e o dono da empresa para lista todos os contratos para assinaContratos.php
	public function VerificaLoginEmpresa($idFunc){
		
		$sql = "SELECT * 
				FROM empresa e
				INNER JOIN usuario u ON(e.usuario_responsavel_id = u.id)
				WHERE e.status = 'ativado' AND u.status = 'ativado'
				AND e.usuario_responsavel_id = '".$idFunc."'";
		
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