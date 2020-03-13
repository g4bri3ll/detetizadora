<?php

include_once 'Model/DAO/DataDAO.php';

//Atualizar com o fusio horario do brasil
date_default_timezone_set('America/Sao_Paulo');

class EntityData{
	
	//Pegar a data de cada dia da visita e faz o fechamento dela caso não seja atendida pelo funcionario
	function CadastraDatas(){
		
		$data = date('Y-m-d');
		$dataCima = date('Y-m-d', strtotime("+320 days",strtotime($data)));
			
		$dataDAO = new DataDAO();
		$arrayUltimaData = $dataDAO->ListaUltimaData();
		
		foreach ($arrayUltimaData as $dataDAO => $valor){
			$ultimaDia = $valor['data'];
		}
		
		//Senao houver data cadastrar 
		if (empty($ultimaDia)){
			
			$data = date('Y-m-d');
			//Aumenta a data nesta quantidade de 500 dias a frente
			$dataMuitoAcima = date('Y-m-d', strtotime("+400 days",strtotime($data)));
			
			while ($data < $dataMuitoAcima){	
				
				$dataDAO = new DataDAO();
				$dataDAO->cadastrar($data);
				
				$data = date('Y-m-d', strtotime("+1 days",strtotime($data)));
				
			}
			
		} 
		//Cadastrar as data acima se as data no banco estiver menor que a dataCima
		else if ($ultimaDia < $dataCima){
			
			//Aumenta a data nesta quantidade de 500 dias a frente
			$dataMuitoAcima = date('Y-m-d', strtotime("+140 days",strtotime($ultimaDia)));
			
			while ($ultimaDia < $dataMuitoAcima){	
				
				$ultimaDia = date('Y-m-d', strtotime("+1 days",strtotime($ultimaDia)));
				
				$dataDAO = new DataDAO();
				$dataDAO->CadastrarDatasNovas($ultimaDia);
				
				
			}
		
		}
			
	}
	
}

?>