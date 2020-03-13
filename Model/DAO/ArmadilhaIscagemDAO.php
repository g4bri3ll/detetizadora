<?php

include_once 'Conexao/Conexao.php';

class ArmadilhaIscagemDAO {
	
	private $conn = null;
	
	//Cadastrar o dia do contrato depois do fechamento do ultimo dia atendido do contrato para configuracao.php
	public function Cadastra(ArmadilhaIscagem $armadilha) {
		
		try {
			
			$sql = "INSERT INTO armadilha_iscagem (contrato_id, status, setor_id, qtd, armadilha_dispositivo, caminho_foto) VALUES 
					('" . $armadilha->contrato_id . "', '" . $armadilha->status . "', '" . $armadilha->setor_id . "', '" . $armadilha->quantidade . "',
					'" . $armadilha->armadilhaDispositivo . "', '" . $armadilha->caminhoFoto . "')";
			
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
	
	//Cadastra
	public function AlterarArmadilha(ArmadilhaIscagem $arma) {
		
		try {

			$sql = "UPDATE armadilha_iscagem SET equipamento = '".$arma->equipamento."', posicao_instalada = '".$arma->posicao_instalada."', 
					identificacao_extra = '".$arma->identificacao."', data_instalacao = '".$arma->data."',
					setor_id = '".$arma->select."' WHERE id = '".$arma->check."'";
			
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
	
	//desativa a armadilha
	public function DeleteId($id, $status) {
		
		try {
			
			$sql = "UPDATE armadilha_iscagem SET status = '".$status."' WHERE id = '" . $id . "'";
			
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
	
	public function ListaArmadilhaIscagemAtiva($idContrato){
		
		$sql = "SELECT s.id as id_setor, s.nome_setor, ai.*, cli.tipo_cliente, cli.nome, cli.nome_fantasia 
				FROM armadilha_iscagem ai
				INNER JOIN setor s ON(ai.setor_id = s.id)
				INNER JOIN contratos c ON(ai.contrato_id = c.id)
				INNER JOIN cliente cli ON(c.clientes_id = cli.id)
				WHERE ai.status = 'ativado' AND ai.contrato_id = '".$idContrato."'
				ORDER BY ai.id DESC";
		
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
	
	//Verificar se existe um mapa cadastro para este contrato
	public function VerificaMapa($idContrato){
		
		$sql = "SELECT * FROM armadilha_iscagem WHERE contrato_id = '".$idContrato."'";
		
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
	
	//lista a foto da armadilha para visualizaMapa.php
	public function ListaFotoMapa($idFoto){
		
		$sql = "SELECT * FROM armadilha_iscagem WHERE id = '".$idFoto."'";
		
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
	
	//lista a foto para o PDF em mapaImpresso.php
	public function ListaFotoPDF($id){
		
		$sql = "SELECT caminho_foto FROM armadilha_iscagem WHERE id = '".$id."'";
		
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