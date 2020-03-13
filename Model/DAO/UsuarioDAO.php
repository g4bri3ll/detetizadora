<?php

include_once 'Conexao/Conexao.php';

class UsuarioDAO {

	private $conn = null;
	
	public function cadastrar(Usuario $usuario) {
		
			try {
				
				$sql = "INSERT INTO usuario (nome, cpf, rg, status, dt_cadastro, telefone, endereco, cidade, bairro, cep, dt_nascimento, email, sexo)
						VALUES ('" . $usuario->nome . "', '" . $usuario->cpf . "', '" . $usuario->rg . "', '" . $usuario->status . "', 
						'" . $usuario->dt_cadastro . "', '" . $usuario->telefone . "', '" . $usuario->endereco . "','" . $usuario->cidade . "',
						'" . $usuario->bairro . "', '" . $usuario->cep . "','" . $usuario->dt_nascimento . "','" . $usuario->email . "','" . $usuario->sexo . "')";
				
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
	
	
	public function Alterar(Usuario $usuario) {
		
			try {
				
				$sql = "UPDATE usuario SET nome = '" . $usuario->nome . "', cpf = '" . $usuario->cpf . "', rg = '" . $usuario->rg . "',
						dt_cadastro = '" . $usuario->dt_cadastro . "', telefone = '" . $usuario->telefone . "', endereco = '" . $usuario->endereco . "',
						cidade = '" . $usuario->cidade . "', bairro = '" . $usuario->bairro . "', cep = '" . $usuario->cep . "',
						dt_nascimento = '" . $usuario->dt_nascimento . "', email = '" . $usuario->email . "', sexo = '" . $usuario->sexo . "'
						WHERE id = '".$usuario->id."'";
				
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
	
	//Cadastrar as image de suas assinaturas
	public function cadastraAssinatura($nomeFoto, $idFun, $idCli, $status) {
		
			try {
				
				$sql = "INSERT INTO assinatura (usuario_id, cliente_id, foto, status)
						VALUES ('" . $idFun . "', '" . $idCli . "', '" . $nomeFoto . "', '" . $status . "')";
				
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

	//Alterar a senha do usuário
	public function AlterarSenha($senha, $id) {
		
		try {
			
			$sql = "UPDATE usuario SET senha = '".md5 ( $senha)."' WHERE id_usuarios = '".$id."'";
			
			$conn = new Conexao ();
			$conn->openConnect ();
			
			$mydb = mysqli_select_db ( $conn->getCon (), $conn->getBD() );
			$resultado = mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
			
			return true;
			
		} catch ( PDOException $e ) {
			return $e->getMessage();
		}
		
	}
	
	public function deleteId($id, $status) {

		try {
		
			$sql = "UPDATE usuario SET status = '".$status."' WHERE id = '" . $id . "'";
			
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
	
	//Lista todos os funcionarios para calendario.php e listaFuncionarios.php e atender.php
	public function listaUsuario(){
		
		$sql = "SELECT id, nome, cpf, rg, email, endereco FROM usuario WHERE status = 'ativado'";

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
	
	//Lista todos os dados dos funcionarios para visualizaFuncionarios.php
	public function ListaTodosOSDadosFunc($id){
		
		$sql = "SELECT * FROM usuario WHERE status = 'ativado' AND id = '".$id."'";
		
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
	
	//Lista todos os usuarios que tem sua assinatura cadastrada para cadastroAcessoSis.php
	public function ListaTodasFuncionarios(){
		
		$sql = "SELECT id, nome FROM usuario WHERE status = 'ativado'";

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
	
	//Lista a quantidade de usuarios para para index.php
	public function QtdFuncionarios(){
		
		$sql = "SELECT id FROM usuario";

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
	
	
	//Lista todos os funcionarios sem assinatura para cadastrarAssinatura.php
	public function ListaTodasFuncionariosSemAssinatura(){
		
		$sql = "SELECT u.id, u.nome FROM usuario u WHERE u.id NOT IN(SELECT a.usuario_id FROM assinatura a)";

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
	
	//Verificar o cadastro dos usuario na tela
	public function VerificaCad($nome, $email, $cpf){
		
		$sql = "SELECT * FROM usuario WHERE cpf = '".$cpf."' AND email = '".$email."' AND nome LIKE '".$nome."'";

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
	
	//Verificar o cadastro dos usuario na tela visualizaFuncionario.php
	public function VerificaCadParaAlterar($nome, $email, $cpf, $idFunc){
		
		$sql = "SELECT * FROM usuario 
				WHERE cpf = '".$cpf."' AND email = '".$email."' AND nome LIKE '".$nome."'
				AND id <> '".$idFunc."'";
		
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