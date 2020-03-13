<?php

include_once 'Conexao/Conexao.php';

class ClienteDAO {
	
	private $conn = null;
	
	//Cadastro de pessoa fisica
	public function cadastroPF(Cliente $clienteF) {
		
		try {
	
			$sql = "INSERT INTO cliente (nome, data_nascimento, rg, cpf, sexo, email, status, data_cadastro, telefone,
					celular, ramal, tipo_cliente, cep, cidade, endereco, id_como_encontro, bairro, complemento, referencia,
					numero) VALUES ('" . $clienteF->nome . "', '" . $clienteF->dataNascimento . "','" . $clienteF->rg . "',
					'" . $clienteF->cpf . "','" . $clienteF->sexo . "','" . $clienteF->email . "','" . $clienteF->status . "',
					'" . $clienteF->dataCadastro . "', '" . $clienteF->telefone . "','" . $clienteF->celular . "', '" . $clienteF->ramal . "', 
					'" . $clienteF->tipoCliente . "', '" . $clienteF->cep . "', '" . $clienteF->cidade . "', '" . $clienteF->endereco . "', 
					'" . $clienteF->idComoEncontro . "','" . $clienteF->bairro . "', '" . $clienteF->complemento . "', '" . $clienteF->referencia . "', 
					'" . $clienteF->numero . "')";
			
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
	
	//Cadastro de pessoa juridca
	public function cadastroPJ(Cliente $clienteJ) {
		
		try {
			
			$sql = "INSERT INTO cliente (nome_fantasia, razao_social, cnpj, inscri_estadual_municipal, nome_responsavel, id_como_encontro, email, status, 
					data_cadastro, telefone, celular, ramal, cep, cidade, endereco, numero, bairro, complemento, referencia, observacoes, nome_representante, 
					idt_representante, cpf_representante, orgao_exp_representante, tipo_cliente ) VALUES ('" . $clienteJ->nomeFantasia . "',
					'" . $clienteJ->razaoSocial . "', '" . $clienteJ->cnpj . "', '" . $clienteJ->estadualMunicipal . "', '" . $clienteJ->nomeResponsavel . "',
					'" . $clienteJ->idComoEncontro . "', '" . $clienteJ->email . "', '" . $clienteJ->status . "', '" . $clienteJ->dataCadastro . "',
					'" . $clienteJ->telefone . "', '" . $clienteJ->celular . "', '" . $clienteJ->ramal . "', '" . $clienteJ->cep . "',
					'" . $clienteJ->cidade . "', '" . $clienteJ->endereco . "', '" . $clienteJ->numero . "', '" . $clienteJ->bairro . "',
					'" . $clienteJ->complemento . "', '" . $clienteJ->referencia . "', '" . $clienteJ->observacoes . "', '" . $clienteJ->nomeRepresentante . "',
					'" . $clienteJ->idt . "', '" . $clienteJ->cpf . "', '" . $clienteJ->orgExpedidor . "', '" . $clienteJ->tipoCliente . "')";
			
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
	
	
	//Cadastro de logo marca
	public function cadastroLogoMarca($status, $caminhoFoto, $idCliente) {
		
		try {
			
			$sql = "INSERT INTO logo_marca_cliente (status, caminho_foto, cliente_id) 
					VALUES ('" . $status . "', '" . $caminhoFoto . "', '" . $idCliente . "')";
			
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
	
	
	//Desativa o cliente
	public function deleteId($id, $status) {

		try {
		
			$sql = "UPDATE cliente SET status = '".$status."' WHERE id = '" . $id . "'";
			
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
	
	
	//Deleta a logo marca do cliente
	public function DeletaLogo($id) {

		try {
		
			$sql = "DELETE FROM logo_marca_cliente WHERE id = '" . $id . "'";
			
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
	
	//alterar os dados do cliente todo
	public function AlteraDadosCliente(Cliente $cliente) {
		
		try {
				
			$sql = "UPDATE cliente SET 
					nome = '".$cliente->nome."',
					data_nascimento = '".$cliente->dataNascimento."',
					rg = '".$cliente->rg."',
					cpf = '".$cliente->cpf."',
					sexo = '".$cliente->sexo."',
					email = '".$cliente->email."',
					nome_fantasia = '".$cliente->nomeFantasia."',
					razao_social = '".$cliente->razaoSocial."',
					cep = '" . $cliente->cep . "',
					cnpj = '".$cliente->cnpj."', 
					cidade = '" . $cliente->cidade . "', 
					telefone = '".$cliente->telefone."', 
					endereco = '" . $cliente->endereco . "', 
					bairro = '" . $cliente->bairro . "', 
					complemento = '" . $cliente->complemento . "', 
					tipo_residencia_id = '" . $cliente->idTipoResidencia . "', 
					referencia = '" . $cliente->referencia . "',
					inscri_estadual_municipal = '".$cliente->estadualMunicipal."'
					WHERE id = '" . $cliente->id . "'";
			
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
	
	//Cadastro do endereco da cliente
	public function cadastroEndereco(Cliente $endere) {
		
		try {
			
			$sql = "UPDATE cliente SET 
					cep = '" . $endere->cep . "', cidade = '" . $endere->cidade . "', telefone = '".$endere->telefone."', endereco = '" . $endere->endereco . "', 
					bairro = '" . $endere->bairro . "', complemento = '" . $endere->complemento . "', tipo_residencia_id = '" . $endere->idTipoResidencia . "', 
					referencia = '" . $endere->referencia . "' WHERE id = '" . $endere->id . "'";
			
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
		
	//Lista cliente juridico para ver se ja possui cadastro
	public function VerificaCadPJ($NomeResponsavel, $cnpj, $email, $status){
		
		$sql = "SELECT * FROM cliente WHERE nome_representante = '".$NomeResponsavel."' AND cnpj = '".$cnpj."' AND 
				email = '".$email."' AND status = '".$status."'";
		
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
	
	//Lista cliente juridico para ver se ja possui cadastro
	public function VerificaAltCliente($nome, $cnpj, $email, $idCli){
		
		$sql = "SELECT * FROM cliente WHERE nome = '".$nome."' AND cnpj = '".$cnpj."' AND 
				email = '".$email."' AND id <> '".$idCli."'";
		
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
	
	//Retorna o ultimo id cadastrado pessoa fisica
	/*
	public function retornaUltimoIdPF(){
		
		$sql = "SELECT id FROM cliente ORDER BY id DESC LIMIT 1";
		
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
	
	
	//Retorna o ultimo id cadastrado pessoa juridica
	public function retornaUltimoIdPJ(){
		
		$sql = "SELECT id FROM cliente ORDER BY id DESC LIMIT 1";
		
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
	
	//Lista todos os clientes para o contrato.php
	public function ListaClientes(){
		
		$sql = "SELECT nome, id, tipo_cliente, nome_fantasia FROM cliente WHERE status = 'ativado'";
		
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
	
	//Lista todos as logo marca do clientes para cadastroLogoMarcaCliente.php
	public function ListaLogoCliente(){
		
		$sql = "SELECT c.nome, c.nome_fantasia, lmc.* 
				FROM logo_marca_cliente lmc
				INNER JOIN cliente c ON(lmc.cliente_id = c.id)";
		
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
	
	//Lista todos os dados do cliente para o VisualizaClientes.php
	public function ListaTodosOSDadosDoCliente($id){
		
		$sql = "SELECT * FROM cliente WHERE status = 'ativado' AND id = '".$id."'";
		
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
	
	//Lista todos os clientes para o listaCliente.php
	public function ListaTodosOsClientes(){
		
		$sql = "SELECT razao_social, nome, endereco, id, tipo_cliente FROM cliente WHERE status = 'ativado'";
		
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
	
	//Lista a quantidade de cliente para index.php
	public function QtdClientes(){
		
		$sql = "SELECT id FROM cliente";
		
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
	
	//Lista todos os clientes que tem a assinatura cadastrada para cadastroAcessoSis.php
	public function ListaClientesParaAcesso(){
		
		$sql = "SELECT nome, id, tipo_cliente, nome_fantasia FROM cliente WHERE status = 'ativado'";
		
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
	
	//Esta list aqui gera o PDF para o cliente com todos os dados do cliente
	public function ListaClientesParaPDF(){
		
		$sql = "SELECT * FROM cliente";
		
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
	
	//Lista todos os clientes que não tem assinatura para cadastrarAssinatura.php
	public function ListaClientesSemAssinatura(){
		
		$sql = "SELECT c.nome, c.id, c.tipo_cliente FROM cliente c WHERE c.id NOT IN(SELECT a.cliente_id FROM assinatura a)";
		
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
	
	//Lista pessoa fisica para ver se ja possui cadastro
	public function VerificaCadPF($nome, $cpf, $email, $status){
		
		$sql = "SELECT * FROM cliente WHERE nome = '".$nome."' AND cpf = '".$cpf."' AND 
				email = '".$email."' AND status = '".$status."'";
		
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