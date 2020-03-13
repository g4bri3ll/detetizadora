<?php
if(!isset($_SESSION)){ session_start(); } 

include_once 'Conexao/Conexao.php';

class AcessoSistemaDAO {

	private $conn = null;
	
	public function cadastrar(AcessoSistema $acesso) {
		
			try {
				
				$senha = md5 ( $acesso->senha );
				
				$sql = "INSERT INTO acesso_sistema (funcionario_id, cliente_id, login, cod_acesso, senha, status, dt_cadastro, tipo_usuario, acesso_id, nivel_acesso)
				VALUES ('" . $acesso->idFuncionario . "', '" . $acesso->idCliente . "', '" . $acesso->login . "', '" . $acesso->codAcesso . "', 
				'" . $senha . "', '" . $acesso->status . "', '" . $acesso->dataCadastro . "', '" . $acesso->tipoUsuario . "',
				'" . $acesso->idAcesso . "', '" . md5("0") . "')";
				
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

	//Alterar a senha do usuário para alteraSenhaColaborador.php e alteraSenha.php
	public function AlterarSenha($senha, $id) {
		
		try {
			
			$sql = "UPDATE acesso_sistema SET senha = '".md5 ( $senha)."' WHERE funcionario_id = '".$id."'";
			
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
	
	//Alterar a senha do usuário para alteraSenhaColaborador.php e alteraSenha.php
	public function AlterarCodigoAcessoF($codigo, $id) {
		
		try {
			
			$sql = "UPDATE acesso_sistema SET cod_acesso = '".$codigo."' WHERE funcionario_id = '".$id."'";
			
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
	
	//Alterar a codigo de acesso do cliente para alteraCodigoAcesso.php
	public function AlterarCodigoAcessoC($codigo, $id) {
		
		try {
			
			$sql = "UPDATE acesso_sistema SET cod_acesso = '".$codigo."' WHERE cliente_id = '".$id."'";
			
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
		
			$sql = "UPDATE paginas_acesso SET status = '".$status."' WHERE id = '" . $id . "'";
			
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
	
	public function AtivaPorId($id, $status) {

		try {
		
			$sql = "UPDATE acesso_sistema SET status = '".$status."' WHERE id = '" . $id . "'";
			
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
	
	//Exclui o item de acesso ao usuario
	public function DeleteIdDoAcesso($id, $idAcessoAlt) {

		try {
		
			$sql = "DELETE FROM acesso_paginas_sistema WHERE paginas_id = '" . $id . "' AND paginas_acesso_id = '".$idAcessoAlt."'";
			
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
	
	//Lista para o listaAcessoSistema.php se estiver ativo
	public function ListaAcessoAtivado(){
		
		$sql = "SELECT * FROM paginas_acesso WHERE status = 'ativado'";

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
	
	//Lista todas as permissoes de acesso ativos dentro do sistema para PermissaoAcessoSistema.php
	public function ListaTodosAcesso(){
		
		$sql = "SELECT acs.tipo_usuario, acs.login, acs.id as id_acesso_sistema, acs.acesso_id, pa.id as id_pagina, acs.tipo_usuario, 
				pa.nome_acesso , acs.status FROM acesso_sistema acs 
				INNER JOIN paginas_acesso pa ON(acs.acesso_id = pa.id) ORDER BY acs.id DESC";

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
	
	//Lista somente os acesso que o sistema tem para PermissaoAcessoSistema.php
	public function ListaAcessos(){
		
		$sql = "SELECT * FROM paginas_acesso WHERE status = 'ativado'";

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
	
	//Lista pelo id passado por listaAcessoSistema.php
	public function ListaAcessoPeloId($idAcesso){
		
		$sql = "SELECT pa.id as paginas_acesso_id, pa.nome_acesso, p.id as paginas_id FROM paginas_acesso pa
				INNER JOIN acesso_paginas_sistema aps ON(pa.id = aps.paginas_acesso_id) 
				INNER JOIN paginas p ON(aps.paginas_id = p.id) 
				WHERE pa.id = '".$idAcesso."'";

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
	
	public function VerificarAcessoClien($id){
		
		$sql = "SELECT login FROM acesso_sistema WHERE cliente_id = '".$id."'";

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
	
	//Verificar se este funcionario esta cadastrado no sistema
	public function VerificarAcessoFunc($id){
		
		$sql = "SELECT login FROM acesso_sistema WHERE funcionario_id = '".$id."'";

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
	
	//Verificar se e a mesma senha para alterar
	public function VerificaSenha($senhaAntiga){
		
		$sql = "SELECT login FROM acesso_sistema WHERE senha = '".md5($senhaAntiga)."'";
		
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
	
	//Verifica se o usuario possui acesso ao sistema
	public function VerificaAcesso($id, $acesso){
		
		$sql = "SELECT login FROM acesso_sistema 
				WHERE funcionario_id = '".$id."' AND tipo_usuario LIKE '".$acesso."'";
		
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
	
	//Verificar se o usuario ja esta cadastro no sistema
	public function VerificaAcessoCadF($login, $idFuncionario){
		
		$sql = "SELECT login FROM acesso_sistema WHERE login LIKE '".$login."' OR funcionario_id = '".$idFuncionario."'";

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
	
	//Verificar se o usuario ja esta cadastro no sistema
	public function VerificaAcessoCadC($login, $idCliente){
		
		$sql = "SELECT login FROM acesso_sistema WHERE login LIKE '".$login."' OR cliente_id = '".$idCliente."'";

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
	
	//Colocar as paginas digitadas na session
	public function DadosSession(){
		
		//Matar o valor especifo para não fica repetindo na session
		unset( $_SESSION['nome_paginas'] );
		
		if ($_SESSION['id_c']){
			$idSession = $_SESSION['id_c'];
			$sql = "SELECT p.nome as nome_paginas, pa.nome_acesso, pa.id as acesso_id, ac.nivel_acesso
				FROM acesso_sistema ac
				INNER JOIN paginas_acesso pa ON(ac.acesso_id = pa.id)
				INNER JOIN acesso_paginas_sistema aps ON(pa.id = aps.paginas_acesso_id)
                INNER JOIN paginas p ON(aps.paginas_id = p.id)
				WHERE ac.cliente_id = '".$idSession."'";
		} else {
			$idSession = $_SESSION['id_f']; 
			$sql = "SELECT p.nome as nome_paginas, pa.nome_acesso, pa.id as acesso_id, ac.nivel_acesso
				FROM acesso_sistema ac
				INNER JOIN paginas_acesso pa ON(ac.acesso_id = pa.id)
				INNER JOIN acesso_paginas_sistema aps ON(pa.id = aps.paginas_acesso_id)
                INNER JOIN paginas p ON(aps.paginas_id = p.id)
				WHERE ac.funcionario_id = '".$idSession."'";
		}		
		
		$conn = new Conexao();
		$conn->openConnect();
		
		//Seleciona o banco de dados
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$conn->closeConnect ();
		
		while ($linha = mysqli_fetch_assoc($resultado)) {
			
			$_SESSION['nome_paginas'][] = $linha['nome_paginas'];
			$_SESSION['acesso_id']      = $linha['acesso_id'];
			$_SESSION['nivel']          = $linha['nivel_acesso'];
		}
		
	}
	
	//Faz a verifica da session
	public function autenticar($login, $senha){
		
		$conn = new Conexao();
		//Abrir a conexao
		$conn->openConnect();
		//Seleciona o banco de dados
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		//Montar o sql
		$sql = "SELECT funcionario_id, cliente_id, login, tipo_usuario FROM acesso_sistema WHERE login = '".$login."' AND senha = '".md5($senha)."'";
		//executar o sql
		$resultado = mysqli_query($conn->getCon(), $sql);
		if (empty($resultado)){
			return false;
		} else {
			$linha = mysqli_fetch_assoc($resultado);
			//se achar algum resultado retorna verdadeiro
			if (mysqli_num_rows($resultado) > 0){
				$_SESSION['id_f']          = $linha['funcionario_id'];
				$_SESSION['id_c']          = $linha['cliente_id'];
				$_SESSION['login']        = $linha['login'];
				$_SESSION['tipo_usuario'] = $linha['tipo_usuario'];
				
				return true;
				
			} else {
				
				return false;
				
			}
			
		}
		
	}
	
}
?>