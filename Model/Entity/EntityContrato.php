<?php

include_once 'Model/DAO/ConfiguracaoDAO.php';
include_once 'Model/DAO/ContratoDAO.php';

//Atualizar com o fusio horario do brasil
date_default_timezone_set('America/Sao_Paulo');

class EntityContrato{
	
	//Pegar a data de cada dia da visita e faz o fechamento dela caso nуo seja atendida pelo funcionario
	function CancelarContratoPeloSistema(){
		
		$data = date('Y-m-d');
		//Veriifca se existe contrato com datas passa e se esta aberto ainda
		$conDAO = new ContratoDAO();
		$arrayContratos = $conDAO->VerificarContratoAbertos($data);
		
		if (!empty($arrayContratos)){
			
			$status = "fechado pelo sistema";
			
			foreach ($arrayContratos as $conDAO => $c){
				
				$id = $c['id'];
				
				$conDAO = new ContratoDAO();
				$conDAO->CancelaEtapaContrato($status, $id);
		
			}
			
		}
		
	}
	
	//Lista todos os contrato aberto e pegar a data de configuraчуo para o fechamento dela
	function FechaContrato(){
		
		$confDAO = new ConfiguracaoDAO();
		$resulDia = $confDAO->ListaDiaFechaContrato();
		//Receber o dia que foi configurado para fecha o contrato
		$diaFecha = 0;
		
		foreach ($resulDia as $confDAO => $valor){
			$diaFecha = $valor['dia_contrato_fecha'];
		}
		
		$data = date('Y-m-d');
		
		//Receber a data maior para fechar
		$dataMaior = date('Y-m-d', strtotime("+".$diaFecha." days",strtotime($data)));
		
		//Verificar se o dia que fecha o contrato e maior ou menor
		$conDAO = new ContratoDAO();
		$idFechaCont = $conDAO->VerificaDataFechamentoContrato($dataMaior);
		
		foreach ($idFechaCont as $conDAO => $f){
			
			$idContrato = $f['id'];
			$status     = "fechado";
			
			$conDAO = new ContratoDAO();
			$conDAO->FechaContrato($status, $idContrato);
			
		}
		
	}
	
	/*
	 * Excluir o tipo de funcionario selecionado na tela do contrato.php,
	 * Excluir o tipo de servico selecionado na tela de contrato.php,
	 * Para zera os dados para selecionar outros
	 * */
	function ExcluirTipoServicoEFuncionario(){
		
		$conDAO = new ContratoDAO();
		$conDAO->DeletaTipoServicoFuncionario();
		
	}

	//Excluir os tipo de servico vindo da tela de renovaContratos.php, caso o usuario tive selecionado alguns
	function ExcluirTipoServicoContratoRenova(){
		
		$conDAO = new ContratoDAO();
		$conDAO->RemoveTipoSerParaEntityContt();
		
	}
	
}

?>