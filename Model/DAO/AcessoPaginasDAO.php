<?php

include_once 'Conexao/Conexao.php';

class AcessoPaginasDAO {
	
	private $conn = null;
	
	//Cadastrar o nome do acesso vindo da criarAcessoSistema.php
	public function cadastrar(AcessoPaginas $acessoPagina) {
		
		try {
			
			$sql = "INSERT INTO paginas_acesso (nome_acesso, status) VALUES 
					('" . $acessoPagina->nome . "', '" . $acessoPagina->status . "')";
			
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
	
	//Cadastrar todos os acesso deste nome do acesso na tabela acesso_paginas_sistema para criarAcessoSistema.php
	public function cadastrarAcessoPag(AcessoPaginas $acessoPagina) {
		
		try {
			
			$sql = "INSERT INTO acesso_paginas_sistema (paginas_acesso_id, paginas_id, status) VALUES 
					('" . $acessoPagina->idPaginaAcesso . "', '" . $acessoPagina->idPaginas . "', '" . $acessoPagina->status . "')";
			
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
	
	//Alterar o acesso ao sistema paraalteraAcessoSistema.php
	public function AlteraAcessoSistema(AcessoPaginas $acessoPagina) {
		
		try {
			
			$sql = "UPDATE paginas_acesso SET nome_acesso = '" . $acessoPagina->nome . "' WHERE id = '" . $acessoPagina->id . "'";
			
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
	
	public function alterar(AcessoPaginas $ace) {
		
		try {
			
			$sql = "UPDATE paginas SET paginas='" . $ace->nome . "' WHERE id = '" . $ace->id . "'";
			
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
	
	//Altera a permissão de acesso do usurio
	public function AlterarPermissaoDeAcesso($idPaginaAcesso, $idAcesso) {
		
		try {
			
			$sql = "UPDATE acesso_sistema SET acesso_id ='" . $idPaginaAcesso . "' WHERE id = '" . $idAcesso . "'";
			
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
	
	//Retorna o ultimo id da pagina cadastrar para cadastrar novamente para pagina criarAcessoSistema.php
	public function RetornaUltimoId(){
		
		$sql = "SELECT id FROM paginas_acesso ORDER BY id DESC LIMIT 1";
		
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
	
	//Lista todas as paginas de acesso do sistema para criarAcessoSistema.php e alteraAcessoSistema.php
	public function ListaPaginas(){
		
		$sql = "SELECT * FROM paginas WHERE status = 'ativado' ORDER BY nome";
		
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
	
	//Lista paginas de acesso para altera no acesso para alteraAcessoSistema.php
	/*
	public function ListaPaginasParaAlteraAcesso(){
		
		$sql = "SELECT aps.id as ace_pag_sis, aps.status as aps_status, p.* 
				FROM paginas p 
				INNER JOIN acesso_paginas_sistema aps ON(p.id = aps.paginas_id) 
				WHERE p.status = 'ativado'";
		
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
	
	//Lista todas as paginas de acesso do sistema para criarAcessoSistema.php
	public function ListaAcessoPaginas(){
		
		$sql = "SELECT * FROM paginas_acesso";
		
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
	
	//Verificar se ja possui esta tela para acessa para alteraAcessoSistema.php
	public function VerificaTelaAcesso($idPaginas, $idPgAcesso){
		
		$sql = "SELECT * FROM acesso_paginas_sistema WHERE paginas_id = '".$idPaginas."' AND paginas_acesso_id = '".$idPgAcesso."'";
		
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
	
	//Lista todos os nomes do acesso a pagina
	public function ListaTodosAcesso(){
		
		$sql = "SELECT * FROM paginas_acesso WHERE status = 'ativado'";
		
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
	public function VerificaAcessoPag($nomeAcesso){
		
		$sql = "SELECT * FROM paginas_acesso WHERE nome_acesso LIKE '".$nomeAcesso."'";
		
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