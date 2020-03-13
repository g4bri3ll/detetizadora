<?php

include_once 'Conexao/Conexao.php';

class ContratoDAO extends Conexao {
	
	private $conn = null;
	
	public function cadastrar(Contrato $contrato) {
		
		try {
			
			$sql = "INSERT INTO contratos (status, clientes_id, dt_cadastro, nome_contrato, data_inicio, data_final, valor_total_contrato,
					dia_pgto, nome_contrato_pdf) VALUES ('" . $contrato->status . "', '" . $contrato->idCliente . "', 
					'" . $contrato->dataCadastro . "', '" . $contrato->nome . "', '".$contrato->dataInicio."', '".$contrato->dataFinal."', 
					'".$contrato->valorTotalContrato."', '".$contrato->diaPgto."', '".$contrato->nomeDoc."')";
			
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
	
	//Cadastrar o renovo do contrato para renovaContratos.php
	public function CadastraRenovaContrato(Contrato $contrato) {
		
		try {
			
			$sql = "INSERT INTO renova_contrato (status, contrato_id, dt_cadastro, data_inicio, data_final, valor_renovacao,
					dia_pgto, nome_contrato_pdf) VALUES ('" . $contrato->status . "', '" . $contrato->id . "', 
					'" . $contrato->dataCadastro . "', '".$contrato->dataInicio."', '".$contrato->dataFinal."', 
					'".$contrato->valorTotalContrato."', '".$contrato->diaPgto."', '".$contrato->nomeDoc."')";
						
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
	
	
	//Cadastrar a data do contrato para contrato.php
	public function CadastraDataContrato(Contrato $dataContra) {
		
		try {
			
			$sql = "INSERT INTO data_contrato (contrato_id, data_id, status, dt_cadastro, visivel_para_ordem_servico) 
					VALUES ('" . $dataContra->id . "', '" . $dataContra->diaContrato . "', '" . $dataContra->status . "',
					'" . $dataContra->dataCadastro . "', '" . $dataContra->visivelOS . "')";
			
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
	
	
	//Cadastrar adquacao para contrato.php
	public function CadastraAdquacao($visivel, $idContrato) {
		
		try {
			
			$sql = "INSERT INTO adquacao (visivel_cliente, contrato_id) VALUES ('" . $visivel . "', '".$idContrato."')";
			
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
	
	//Cadastrar adquacao para renovaContrato.php
	public function CadastraAdquacaoContratoRenovado($visivel, $idContrato, $idContt) {
		
		try {
			
			$sql = "INSERT INTO adquacao (visivel_cliente, renova_contrato_id, contrato_id) VALUES ('" . $visivel . "', '".$idContrato."', '".$idContt."')";
			
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
	
	
	//Cadastrar a data do contrato
	public function CadastraData(Contrato $dataContra) {
		
		try {
			
			$sql = "INSERT INTO data_contrato (contrato_id, renova_contrato_id, data_id, status, dt_cadastro, visivel_para_ordem_servico) 
					VALUES ('" . $dataContra->id . "', '" . $dataContra->idContratoRenovado . "', '" . $dataContra->diaContrato . "', 
					'" . $dataContra->status . "', '" . $dataContra->dataCadastro . "', '" . $dataContra->visivelOS . "')";
			
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
	
	//Cadastrar os tipo de servico do contrato para contrato.php
	public function CadastrTipoServico($idTipoSer, $idObjeto, $idTipoObjet, $status) {
		
		try {
			
			$sql = "INSERT INTO tipo_servico_por_contrato (tipo_servico_id, objeto_servico_id, produto_id, status) 
					VALUES ('" . $idTipoSer . "', '" . $idObjeto . "', '" . $idTipoObjet . "', '" . $status . "')";
			
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
	
	//Cadastrar os tipo de servico para renovar o contrato para renovaContratos.php
	public function CadastrTipoServicoParaRenova($idTipoSer, $idObjeto, $idTipoObjet, $status, $idContrato) {
		
		try {
			
			$sql = "INSERT INTO tipo_servico_por_contrato (tipo_servico_id, objeto_servico_id, produto_id, status, contrato_id) 
					VALUES ('" . $idTipoSer . "', '" . $idObjeto . "', '" . $idTipoObjet . "', '" . $status . "','" . $idContrato . "')";
			
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
	
	//Cadastrar na tabela funcionario_realiza_visita_contrato os usuario que realizara a etapa para contrato.php
	public function CadastrarFuncionarioQueRealizaVisita($idFuncionario, $status, $dataCad) {
		
		try {
			
			$sql = "INSERT INTO funcionario_realiza_visita_contrato (usuario_realiza_id, status, data_cadastro_contrato) 
					VALUES ('" . $idFuncionario . "', '" . $status . "', '" . $dataCad . "')";
			
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
	
	//Cadastrar as fotos do atendimento do contrato para UploadIMGAtenderContrato.php e UploadIMGAdquacao.php
	public function CadastrarFotosAtendidaContratos($nome_imagem, $idAtendeContrato) {
		
		try {
			
			$sql = "INSERT INTO fotos_atender_contrato (data_contrato_id, foto)
					VALUES ('" . $idAtendeContrato . "', '" . $nome_imagem . "')";
			
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
	
	//Cadastrar as ordem de servicos por programa para ordemDeServicoPrograma.php
	public function CadastrarOrdemServicoPrograma($produtos, $tipoSer, $idDiaCon, $pragas, $status, $setores) {
		
		try {
			
			$sql = "INSERT INTO ordem_servico_programa (produto, tipo_servico, praga_alvo, data_contrato_id, status, setor)
					VALUES ('" . $produtos . "', '" . $tipoSer . "', '" . $pragas . "', '" . $idDiaCon . "', '" . $status . "', '" . $setores . "')";
			
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
	
	//Cadastra o atendimento do dia do contrato atendido para atender.php
	public function CadastraAtenderChamado($status, $idFuncionario, $descricao, $idTipoServi, $data, $idDataContrato, $idUsuario, $dataRealizada) {
		
		try {
			
			$sql = "INSERT INTO atender_contrato (usuario_que_realizou_id, tipo_servico_id, status, data_contrato_id, data_que_realizou, descricao, usuario_id, 
					data_que_realizou_visita) VALUES ('" . $idFuncionario . "', '" . $idTipoServi . "', '" . $status . "', '" . $idDataContrato . "', 
					'" . $data . "', '" . $descricao . "', '" . $idUsuario . "', '" . $dataRealizada . "')";
			
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
	
	//Assina o contrato para assinaContratos.php
	public function AssinaContratoCliente($status, $idContrato, $dataAssinada, $idCliente) {
		
		try {
			
			$sql = "UPDATE assina_contrato SET cliente_id = '" . $idCliente . "', status_c = '" . $status . "', 
					data_assina_cliente = '" . $dataAssinada . "' WHERE contrato_id = '" . $idContrato . "'";
			
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
	
	//Cadastrar o contrato na tabela funcionario_realiza_visita_contrato para contrato.php
	public function CadastraIdContratoFuncRealizaVisita($status, $ultID, $id) {
		
		try {
			
			$sql = "UPDATE funcionario_realiza_visita_contrato SET contrato_id = '" . $ultID . "', 
					status = '".$status."' WHERE id = '" . $id . "'";
			
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
	
	
	//cancelar contrato para excluirContratos.php
	public function ExcluirContrato($status, $idContrato) {
		
		try {
			
			$sql = "UPDATE contratos SET status = '" . $status . "' WHERE id = '" . $idContrato . "'";
			
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
	
	//cancelar contrato renovado para excluirContratos.php
	public function ExcluirContratoRenovado($status, $idContrato) {
		
		try {
			
			$sql = "UPDATE renova_contrato SET status = '" . $status . "' WHERE id = '" . $idContrato . "'";
			
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
	
	
	//desativa o dia do contrato para excluirContratos.php
	public function ExcluirDiaContrato($status, $id) {
		
		try {
			
			$sql = "UPDATE data_contrato SET status = '" . $status . "' WHERE id = '" . $id . "'";
			
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
	
	
	//desativa o dia do contrato renovado para excluirContratos.php
	public function ExcluirDiaContratoRenovado($status, $id) {
		
		try {
			
			$sql = "UPDATE data_contrato SET status = '" . $status . "' WHERE id = '" . $id . "'";
			
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

	
	//desativa a mostra na tela da ordem de servico para OrdemDeServico.php
	public function RemoveOrdemServicoTela($status, $id) {
		
		try {
			
			$sql = "UPDATE data_contrato SET status = '" . $status . "' WHERE id = '" . $id . "'";
			
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
	
	
	//excluir a adquacao para excluirContratos.php
	public function ExcluirAdquacaoContrato($id) {
		
		try {
			
			$sql = "DELETE FROM adquacao WHERE id = '" . $id . "'";
			
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
	
	
	//excluir a adquacao de renovo do contrato para excluirContratos.php
	public function ExcluirAdquacaoContratoRenovado($idContrato) {
		
		try {
			
			$sql = "DELETE FROM adquacao WHERE renova_contrato_id = '" . $idContrato . "'";
			
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
	
	
	//cadastrar os dados vindo da table para adquacao.php
	public function AlteraAdquacaoTables($check, $descricao, $select, $data) {
		
		try {
			
			$sql = "UPDATE adquacao SET descricao = '" . $descricao . "', visivel_cliente = '".$select."',
					data_criacao = '".$data."' WHERE id = '" . $check . "'";
			
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
	
	
	//desativa a adquacao para o cliente e ninguem ver mais para adquacao.php
	public function DesativaOrdDaAdquacao($status, $id) {
		
		try {
			
			$sql = "UPDATE data_contrato SET status_adquacao = '" . $status . "' WHERE id = '" . $id . "'";
			
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
	
	//coloca na tabela tipo_servico_por_contrato o contrato para contrato.php
	public function CadastrarTipoServicoNoContrato($idContra, $status, $idTiCont) {
		
		try {
			
			$sql = "UPDATE tipo_servico_por_contrato SET contrato_id = '" . $idContra . "', 
					status = '" . $status . "' WHERE id = '" . $idTiCont . "'";
			
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
	
	//Excluir o funcionario que realizara a etapa do contrato caso ele seja removido da tela de contrato.php
	public function ExcluirFuncionarioRealizaVisita($id) {
		
		try {
			
			$sql = "DELETE FROM funcionario_realiza_visita_contrato WHERE id = '".$id."'";
			
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
	
	//coloca na tabela tipo_servico_por_contrato o contrato para renovaContratos.php
	public function CadastrarContratoNoTipoServico($idContra, $status, $idTiCont, $idContt) {
		
		try {
			
			$sql = "UPDATE tipo_servico_por_contrato SET renova_contrato_id = '" . $idContra . "', 
					status = '" . $status . "', contrato_id = '" . $idContt . "' WHERE id = '" . $idTiCont . "'";
			
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
	
	//Fecha o contrato pela data para EntityContrato.php
	public function FechaContrato($status, $idContrato) {
		
		try {
			
			$sql = "UPDATE contratos SET status = '" . $status . "' WHERE id = '" . $idContrato . "'";
			
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
	
	//Cadastrar na tabela de assinatura de contrato
	public function CadastraAssContrato($ultID, $idCliente) {
		
		try {
			
			$sql = "INSERT INTO assina_contrato (contrato_id, cliente_id) 
					VALUES ('" . $ultID . "', '" . $idCliente . "')";
			
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
	
	//Assina o contrato o dono da empresa para assinaContratos.php
	public function AssinaContratoFuncionario($status, $idContrato, $dataAssinada, $idFunc) {
		
		try {
			
			$sql = "UPDATE assina_contrato SET usuario_id = '" . $idFunc . "', status_f = '" . $status . "',
					data_assina_usuario = '" . $dataAssinada . "' WHERE contrato_id = '" . $idContrato . "'";
			
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
	
	//mudar o status do dia da visita pelo ordemDeServicoPrograma.php
	public function FechaStatusOrdemServico($status, $idDiaCon) {
		
		try {
			
			$sql = "UPDATE data_contrato SET status = '".$status."' WHERE id = '".$idDiaCon."'";
			
			$conn = new Conexao ();
			$conn->openConnect ();
			
			mysqli_select_db ( $conn->getCon (), $conn->getBD());
			$resultado = mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
			
			return true;
			
		} catch (PDOException $e) {
			
			return $e->getMessage();
			
		}
		
	}
	
	//configurar a ordem de servico ao fazer o primeiro cadastrar para o relatorio ordemDeServicoPrograma.php
	public function ConfigurarDiaContratoOrdemServico($status, $idDiaCon) {
		
		try {
			
			$sql = "UPDATE data_contrato SET status = '".$status."' WHERE id = '".$idDiaCon."'";
			
			$conn = new Conexao ();
			$conn->openConnect ();
			
			mysqli_select_db ( $conn->getCon (), $conn->getBD());
			$resultado = mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
			
			return true;
			
		} catch (PDOException $e) {
			
			return $e->getMessage();
			
		}
		
	}
	
	//Chamado do contrato ja atendido
	public function StatusChamadoAtendido($status, $idDia) {
		
		try {
			
			$sql = "UPDATE data_contrato SET status = '".$status."', visivel_para_ordem_servico = 'S' WHERE id = '".$idDia."'";
			
			$conn = new Conexao ();
			$conn->openConnect ();
			
			mysqli_select_db ( $conn->getCon (), $conn->getBD());
			$resultado = mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
			
			return true;
			
		} catch (PDOException $e) {
			
			return $e->getMessage();
			
		}
		
	}
	
	//Fecha o contrato pelo index pela data passada para entityContrato.php
	public function CancelaEtapaContrato($status, $id) {
		
		try {
			
			$sql = "UPDATE data_contrato SET status = '".$status."' WHERE id = '".$id."'";
			
			$conn = new Conexao ();
			$conn->openConnect ();
			
			mysqli_select_db ( $conn->getCon (), $conn->getBD());
			$resultado = mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
			
			return true;
			
		} catch (PDOException $e) {
			
			return $e->getMessage();
			
		}
		
	}
	
	//Cancelar o contrato ao cadastrar os dias na tela calendario.php
	public function CancelaDiaContrato($status, $idDia) {
		
		try {
			
			$sql = "UPDATE data_contrato SET status = '".$status."' WHERE id = '".$idDia."'";
			
			$conn = new Conexao ();
			$conn->openConnect ();
			
			mysqli_select_db ( $conn->getCon (), $conn->getBD());
			$resultado = mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
			
			return true;
			
		} catch (PDOException $e) {
			
			return $e->getMessage();
			
		}
		
	}
	
	//Deleta o tipo de servico no contrato para contrato.php
	public function DeletaTipoServicoNoContrato($id) {
		
		try {
			
			$sql = "DELETE FROM tipo_servico_por_contrato WHERE id = '".$id."'";
			
			$conn = new Conexao ();
			$conn->openConnect ();
			
			mysqli_select_db ( $conn->getCon (), $conn->getBD());
			$resultado = mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
			
			return true;
			
		} catch (PDOException $e) {
			
			return $e->getMessage();
			
		}
		
	}
	
	//Deleta o tipo de servico e funcionario lista na tela contrato.php, caso esteja abilitado para o index
	public function DeletaTipoServicoFuncionario() {
		
		try {
			
			$sql = "DELETE FROM funcionario_realiza_visita_contrato WHERE status = 'usu_realiza'";
			$sql1 = "DELETE FROM tipo_servico_por_contrato WHERE status = 'listado_para_contrato'";
			
			$conn = new Conexao ();
			$conn->openConnect ();
			
			mysqli_select_db ( $conn->getCon (), $conn->getBD());
			
			mysqli_query ( $conn->getCon (), $sql );
			mysqli_query ( $conn->getCon (), $sql1 );
			
			$conn->closeConnect ();
			
			return true;
			
		} catch (PDOException $e) {
			
			return $e->getMessage();
			
		}
		
	}
	
	//Deleta o tipo de servico caso o usuario passa para a tela do index sem excluir os itens
	public function RemoveTipoSerParaEntityContt() {
		
		try {
			
			$sql = "DELETE FROM tipo_servico_por_contrato WHERE status = 'renova_contrato'";
			
			$conn = new Conexao ();
			$conn->openConnect ();
			
			mysqli_select_db ( $conn->getCon (), $conn->getBD());
			
			mysqli_query ( $conn->getCon (), $sql );
			
			$conn->closeConnect ();
			
			return true;
			
		} catch (PDOException $e) {
			
			return $e->getMessage();
			
		}
		
	}
	
	//Lista todos os contratos e renova contrato para excluirContratos.php
	public function ListaContrato(){
		
		$sql = "SELECT cli.nome, cli.tipo_cliente, cli.nome_fantasia, c.*
				FROM contratos c 
				LEFT JOIN cliente cli ON(c.clientes_id = cli.id) 
                WHERE c.status = 'aberto'";
		
		$sql1 = "SELECT c.nome_contrato, cli.nome, cli.tipo_cliente, cli.nome_fantasia, rc.*
				FROM contratos c 
				RIGHT JOIN renova_contrato rc ON(c.id = rc.contrato_id)
                LEFT JOIN cliente cli ON(c.clientes_id = cli.id)
                WHERE rc.status = 'contrato renovado'";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		$resultado1 = mysqli_query($conn->getCon(), $sql1);
		
		$conn->closeConnect ();
		
		$result = array();
		while ($row = mysqli_fetch_assoc($resultado)) {
			$result[]=$row;
		}
		
		$result1 = array();
		while ($row = mysqli_fetch_assoc($resultado1)) {
			$result1[]=$row;
		}
		
		$array = array(
			'contrato' => $result,
			'renova_contrato' => $result1
		);
		
		return $array;
		
	}
	
	/*
	//List contrato renovado para excluiContratos.php
	public function ListaContratoRenovado($idContrato){
		
		$sql = "SELECT cli.nome, cli.tipo_cliente, cli.nome_fantasia, rc.*, rc.id as renova_contrato, rc.status as status_renova, c.nome_contrato 
				FROM contratos c 
				INNER JOIN renova_contrato rc ON(c.id = rc.contrato_id)
				INNER JOIN cliente cli ON(c.clientes_id = cli.id) 
				WHERE rc.status = 'contrato renovado' AND rc.contrato_id = '".$idContrato."'";
		
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
	
	//Lista as adquacoes do contrato se estiver Sim no campo da tabela para listAdquacao.php
	public function ListAdquacoesSim($idCliente){
		
		$sql = "SELECT ad.descricao, ad.data_criacao, dc.id as data_contrato_id, dc.contrato_id 
				FROM adquacao ad
				INNER JOIN contratos c ON(ad.contrato_id = c.id)
				INNER JOIN cliente cli ON(c.clientes_id = cli.id)
				INNER JOIN data_contrato dc ON(c.id = dc.contrato_id)
				LEFT JOIN fotos_atender_contrato fac ON(dc.id = fac.data_contrato_id)
				WHERE c.clientes_id = '".$idCliente."' AND ad.visivel_cliente = 'Sim'
				GROUP BY ad.id";
		
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
	
	
	//Lista todos os tipo de eservico cadastro no contrato para contrato.php
	public function ListaContratoPeloTipoServicoCad(){
		
		$sql = "SELECT * FROM tipo_servico_por_contrato WHERE status LIKE 'listado_para_contrato'";
		
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
	
	//Lista todos os tipo de servico para renovar o cantrato para renovaContratos.php
	public function ListServicoParaRenova(){
		
		$sql = "SELECT * FROM tipo_servico_por_contrato WHERE status LIKE 'renova_contrato'";
		
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
	
	//Lista os dados do contrato para excluirContratos.php
	public function ListaContratoParaExcluir(){
		
		$sql = "SELECT * FROM contratos";
		
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
	
	//Verificar se a data de visita e maior do que a da data final do contrato para calendario.php
	public function VerificarCadContratoData($data, $idContrato){
		
		$sql = "SELECT * FROM contratos WHERE id = '".$idContrato."' AND data_final < '".$data."'";
		
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
	
	//Lista todos os dados do dia de contratos e seus setores de aplicacao para ordemDeServicoPrograma.php
	public function ListaSetoresAplicacao($idDiaCon){
		
		$sql = "SELECT * FROM ordem_servico_programa WHERE data_contrato_id = '".$idDiaCon."' ORDER BY id DESC";
		
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
	
	//Lista todos os contrato em aberto ou pedente para mostra o grafico para visualizarControleDePragas.php
	public function ListaPeloControlePragas(){
		
		$sql = "SELECT * FROM contratos WHERE (status = 'aberto' OR status = 'em andamento') ORDER BY id DESC";
		
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
	
	//Lista contrato para relatorio pela data escolhido do cliente para relatoriosDiaAtendidoPorContrato.php
	public function ListaContratoPelaDataRelatorio($data){
		
		$sql = "SELECT c.nome_contrato, ac.status, ac.data_que_realizou, ac.descricao 
				FROM contratos c 
				INNER JOIN data_contrato dc ON(c.id = dc.contrato_id)
				INNER JOIN atender_contrato ac ON(dc.id = ac.data_contrato_id)
				WHERE dc.data_contrato = '".$data."'";
		
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
	
	//Lista contrato para relatorio pela data escolhido e o id do contrato para relatoriosOrdemVistoria.php
	public function RelatorioContratoPelaIdData($data, $idContrato){
		
		$sql = "SELECT s.nome_setor, cli.nome_fantasia, cli.nome, dt.data, dc.id as data_cliente_id
				FROM contratos c 
				INNER JOIN cliente cli ON(c.clientes_id = cli.id)
				INNER JOIN data_contrato dc ON(c.id = dc.contrato_id)
				INNER JOIN data dt ON(dc.data_id = dt.id)
				INNER JOIN contratos_setores cs ON(c.id = cs.contratos_id)
				INNER JOIN setor s ON(cs.setor_id = s.id)
				WHERE dt.data = '".$data."' AND c.id = '".$idContrato."'";
		
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
	
	//Lista os dados da empresa para relatoriosOrdemServicoParaPrograma.php
	public function RelatorioOrdemServicoParaProgramaCliente($idContrato){
		
		$sql = "SELECT * FROM contratos c 
				INNER JOIN cliente cli ON(c.clientes_id = cli.id) 
				WHERE c.id = '".$idContrato."'";
		
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
	
	
	
	//Lista os dados para geração de relatorios para visualizarRelatrioOrdemServico.php
	public function VisualizarRelatorioOrServico($idDataContrato){
		
		$sql = "SELECT c.id as id_contrato, tob.nome as nome_objeto, cli.cep, cli.endereco, cli.numero, dt.data, cli.nome_fantasia, cli.razao_social, cli.cnpj, tser.nome as nome_servico,
				c.nome_contrato, u.nome as nome_funcionario, ots.nome as nome_objeto_servico, c.data_inicio as contrato_data_inicio, c.data_final as contrato_data_final, rc.data_inicio 
				as ren_contrato_data_inicio, rc.data_final  as ren_contrato_data_final, dc.renova_contrato_id, ots.nome as nome_tipo_objeto
				FROM data_contrato dc
				INNER JOIN data dt ON(dc.data_id = dt.id)
				INNER JOIN contratos c ON(dc.contrato_id = c.id)
				INNER JOIN cliente cli ON(c.clientes_id = cli.id)
				LEFT JOIN renova_contrato rc ON(dc.renova_contrato_id = rc.id)
				INNER JOIN contratos_setores cos ON(c.id = cos.contratos_id)
                INNER JOIN tipo_servico_por_contrato tsc ON(c.id = tsc.contrato_id)
                LEFT JOIN tipo_servico_por_contrato rtsc ON(rc.id = rtsc.renova_contrato_id)
                LEFT JOIN tipo_servico tser ON(tsc.tipo_servico_id = tser.id)
                LEFT JOIN tipo_objetos tob ON(tsc.produto_id = tob.id)
                LEFT JOIN objetos_tipo_servico ots ON(tsc.objeto_servico_id = ots.id)
                LEFT JOIN funcionario_realiza_visita_contrato frvc ON(c.id = frvc.contrato_id)
                LEFT JOIN usuario u ON(frvc.usuario_realiza_id = u.id)
				WHERE dc.id = '".$idDataContrato."'
				GROUP BY tser.id, u.nome";
		
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
	
	
	
	//Complemento da lista de tipo de servico, produto para visualizarRelatrioOrdemServico.php
	public function ComplementoVisualizarRelatorioOrServico($idRecContratoValida, $status_contrato_renova_contrato){
		
		//Verificar se e um contrato ou o renovo do contrato
		if ($status_contrato_renova_contrato === "contrato"){
			$c = "tspc.contrato_id = '".$idRecContratoValida."'";
		} else {
			$c = "tspc.renova_contrato_id = '".$idRecContratoValida."'";
		}
		
		$sql = "SELECT tspc.id, ts.nome as nome_servico, tob.nome as nome_produto, tob.registro
				FROM tipo_servico_por_contrato tspc 
				INNER JOIN contratos c ON(tspc.contrato_id = c.id)
				INNER JOIN renova_contrato rc ON(tspc.renova_contrato_id = rc.id)
				LEFT JOIN tipo_servico ts ON(tspc.tipo_servico_id = ts.id)
				LEFT JOIN objetos_tipo_servico ots ON(tspc.objeto_servico_id = ots.id)
                LEFT JOIN tipo_objetos tob ON(tspc.produto_id = tob.id)
                WHERE " . $c . "";
		
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
	
	
	/*
	//Lista produtos para visualizarRelatorioOrdemServico.php
	public function VisualizaProdutoRelatorio($nomeTipoServico, $idRecContratoValida, $status_contrato_renova_contrato){
		
	//Verificar se e um contrato ou o renovo do contrato
		if ($status_contrato_renova_contrato === "contrato"){
			$c = "tspc.contrato_id = '".$idRecContratoValida."'";
		} else {
			$c = "tspc.renova_contrato_id = '".$idRecContratoValida."'";
		}
		
		$sql = "SELECT ts.nome as nome_servico, tob.nome as nome_produto, tob.registro
				FROM tipo_servico_por_contrato tspc 
				INNER JOIN contratos c ON(tspc.contrato_id = c.id)
				INNER JOIN renova_contrato rc ON(tspc.renova_contrato_id = rc.id)
				INNER JOIN tipo_servico ts ON(tspc.tipo_servico_id = ts.id)
				INNER JOIN objetos_tipo_servico ots ON(tspc.objeto_servico_id = ots.id)
                INNER JOIN tipo_objetos tob ON(tspc.produto_id = tob.id)
                WHERE " . $c . " AND ts.nome = '".$nomeTipoServico."'";
		
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
	*/
	
	
	//Lista todos os produtos para relatoriosOrdemServicoComArmadilhaCliente.php
	public function ListaProdutoRelatorioPorContrato($idContrato, $dataCont){
		
		$sql = "SELECT tob.nome as nome_produto, dt.data, u.nome as nome_func, c.nome_contrato 
				FROM contratos c
				INNER JOIN data_contrato dc ON(c.id = dc.contrato_id)
				INNER JOIN data dt ON(dc.data_id = dt.id)
				INNER JOIN funcionario_realiza_visita_contrato frvc ON(c.id = frvc.contrato_id)
				INNER JOIN usuario u ON(frvc.usuario_realiza_id = u.id)
				INNER JOIN tipo_servico_por_contrato tsc ON(c.id = tsc.contrato_id)
				INNER JOIN tipo_objetos tob ON(tsc.produto_id = tob.id) 
				WHERE tsc.contrato_id = '".$idContrato."' AND dt.data = '".$dataCont."'";
		
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
	

	//Lista os dados da empresa para relatoriosOrdemServicoParaPrograma.php
	public function RelatorioOrdemServicoParaProgramaDados($idContrato, $data){
		
		$sql = "SELECT osp.setor, osp.produto, osp.tipo_servico, osp.praga_alvo, cli.nome_fantasia, cli.razao_social, cli.cnpj, cli.endereco, cli.cep, cli.telefone 
		FROM contratos c
		INNER JOIN cliente cli ON(c.clientes_id = cli.id) 
		INNER JOIN data_contrato dc ON(c.id = dc.contrato_id)
		INNER JOIN data dta ON(dc.data_id = dta.id)
		INNER JOIN ordem_servico_programa osp ON(osp.data_contrato_id = dc.id)
		WHERE dta.data = '".$data."' AND c.id = '".$idContrato."'";
		
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
	
	
	//Lista contrato para relatorio pela data escolhido e o id do contrato para relatoriosOrdemServicoParaPrograma.php
	public function RelatorioContratoParaPrograma($data, $idContrato){
		
		$sql = "SELECT osp.setor, osp.produto, osp.tipo_servico, osp.praga_alvo FROM contratos c 
				INNER JOIN data_contrato dc ON(c.id = dc.contrato_id)
				INNER JOIN data dt ON(dc.data_id = dt.id)
				INNER JOIN ordem_servico_programa osp ON(osp.data_contrato_id = dc.id)
				WHERE dt.data = '".$data."' AND c.id = '".$idContrato."'";
		
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
	
	//Relatorio para controle de pragas para RelatorioControlePraga.php
	public function RelatorioControlePraga($idContrato){
		
		$sql = "SELECT p.nome_pragas, MONTH(cp.data_cliente_inserir) as meses, YEAR(cp.data_cliente_inserir) as anos,s.nome_setor, cp.qtd_pragas, c.nome_contrato
				FROM contratos c
				INNER JOIN controle_de_pragas cp ON(c.id = cp.contrato_id)
				INNER JOIN pragas p ON(cp.pragas_id = p.id)
                INNER JOIN setor s ON(cp.setor_id = s.id)
                WHERE cp.contrato_id = '".$idContrato."' 
                AND (cp.status = 'pendente de resposta' 
                OR cp.status = 'respondido pelo funcionario')";
		
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
	
	//Lista o contrato pelo id para atender.php
	public function ListaContratoPeloIdD($idD){
		
		$sql = "SELECT c.nome_contrato, dc.id, dc.status
				FROM contratos c
				INNER JOIN data_contrato dc ON(c.id = dc.contrato_id)
				WHERE dc.id = '".$idD."'";
		
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
	
	//Lista todas as fotos para visualização de adquacao para fotosAdquacaoCleitne.php
	public function ListaFotoAdquacaoCliente($id){
		
		$sql = "SELECT dc.id as id_data_contrato, fac.*, dc.contrato_id
				FROM data_contrato dc
				INNER JOIN fotos_atender_contrato fac ON(dc.id = fac.data_contrato_id)
				WHERE dc.id = '".$id."'";
		
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
	
	//Lista todos os contrato em aberto para serem completados pelo analista do sistema para finalizarContrato.php
	public function CarregaContratoAbertos(){
		
		$sql = "SELECT * FROM contratos WHERE status = 'aberto'";
		
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
	
	
	//Lista todos os contratos em abertos para calendario.php
	public function ListaContratoAbertos($idSession){
		
		$sql = "SELECT * FROM contratos
				WHERE (status = 'aberto' OR status = 'em andamento') 
				AND clientes_id = '".$idSession."'";
		
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
	
	
	//Lista contrato pelo id para excluirContratos.php
	public function ListaPeloIdParaExcluirDataContrato($idContrato){
		
		$sql = "SELECT dc.id FROM contratos c INNER JOIN data_contrato dc ON(c.id = dc.contrato_id)
				INNER JOIN data dt ON(dc.data_id = dt.id) WHERE c.id = '".$idContrato."'
				AND dt.data BETWEEN c.data_inicio AND c.data_final";
		
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
	
	
	//Lista renova_contrato pelo id para excluirContratos.php
	public function ListaPeloIdParaExcluirRenovaDataContrato($idContrato){
		
		$sql = "SELECT dc.id FROM renova_contrato rc 
				INNER JOIN data_contrato dc ON(rc.id = dc.renova_contrato_id)
				WHERE rc.id = '".$idContrato."'";
		
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
	
	
	//Lista contrato pelo id para excluirContratos.php adquacao
	public function ListaPeloIdParaExcluirAdquacao($idContrato){
		
		$sql = "SELECT a.id FROM contratos c INNER JOIN adquacao a ON(c.id = a.contrato_id)
				WHERE c.id = '".$idContrato."' AND a.renova_contrato_id = '0'";
		
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
	
	
	//Lista o ultimo cadastro do contrato para contrato.php
	public function ListaUltimoId(){
		
		$sql = "SELECT * FROM contratos ORDER BY id DESC LIMIT 1";
		
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
	
	
	//Lista todos os contratos em abertos para calendario.php
	public function NivelListaContratoAbertos(){
		
		$sql = "SELECT * FROM contratos WHERE status = 'aberto' OR status = 'em andamento'";
		
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
	
	
	//Lista todos os renovo do contrato para contratosAbertos.php
	public function ListContratoAbertosRenovado(){
		
		$sql = "SELECT * 
				FROM renova_contrato rc
				INNER JOIN contratos c ON(rc.contrato_id = c.id) 
				WHERE rc.status = 'contrato renovado'";
		
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
	
	
	//Lista todos os contratos fechados para calendario.php
	public function ListaContratoFechados($idSession){
		
		$sql = "SELECT * FROM contratos WHERE status = 'fechado' AND clientes_id = '".$idSession."'";
		
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
	
	//Lista a resposta respondido pelo funcionario do sistema para visualizarRespostaControleDePraga.php
	public function VisualizarRespostaControlePraga($idSession){
		
		$sql = "SELECT c.nome_contrato, cp.status, cp.id, cp.descricao_cliente, cp.descricao_usuario 
				FROM controle_de_pragas cp
				INNER JOIN contratos c ON(cp.contrato_id = c.id) 
				WHERE cp.status = 'respondido pelo funcionario' AND cp.cliente_id = '".$idSession."'
				AND (c.status = 'aberto' OR c.status = 'em andamento')";
		
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
	
	//Lista todos as resposta por contrato para visualizarRespostaControleDePraga.php
	public function VisualizarRespostaPorContratoControlePraga($id){
		
		$sql = "SELECT c.nome_contrato, cp.status, cp.id, cp.descricao_cliente, cp.descricao_usuario 
				FROM controle_de_pragas cp
				INNER JOIN contratos c ON(cp.contrato_id = c.id) 
				WHERE cp.status = 'respondido pelo funcionario' AND c.id = '".$id."'
				AND (c.status = 'aberto' OR c.status = 'em andamento')";
		
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
	
	//Lista a resposta respondido pelo funcionario do sistema para visualizarRespostaControleDePraga.php
	public function ListaContratoParaVisualizarResponstaCP(){
		
		$sql = "SELECT DISTINCT(c.nome_contrato), cp.status, c.id 
				FROM controle_de_pragas cp
				INNER JOIN contratos c ON(cp.contrato_id = c.id) 
				WHERE (cp.status = 'respondido pelo funcionario' OR cp.status = 'pendente de resposta')
				AND (c.status = 'aberto' OR c.status = 'em andamento')
                GROUP BY c.nome_contrato";
		
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
	
	//Lista todos os contratos fechados para calendario.php
	public function NivelListaContratoFechados(){
		
		$sql = "SELECT * FROM contratos WHERE (status = 'fechado' OR status = 'excluido')";
		
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
	
	//Lista todos os contratos que estão sem assinatura do cliente para assinaContratos.php
	public function ListaContratoSemAssinaturaCliente($idSession){
		
		$sql = "SELECT ac.status_c, c.id, c.nome_contrato 
				FROM assina_contrato ac 
				RIGHT JOIN contratos c ON(ac.contrato_id = c.id)
				WHERE c.clientes_id = '".$idSession."' AND ac.status_c = ''";
		
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
	
	//Lista todos os contratos que estão sem assinatura para o dono da empresa assinaContratos.php
	public function ListaContratoSemAssinatura(){
		
		$sql = "SELECT ac.status_f, c.id, c.nome_contrato 
				FROM assina_contrato ac 
				RIGHT JOIN contratos c ON(ac.contrato_id = c.id)
				WHERE status_f = '' AND (c.status = 'aberto' OR c.status = 'em andamento')";
		
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
	
	//Lista o contrato do cliente para controleDePragas.php
	public function ListaContratoPControlePragas($idCliente){
		
		$sql = "SELECT id, nome_contrato FROM contratos WHERE clientes_id = '".$idCliente."'";
		
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
	
	//Lista todos os contratos em andamento para calendario.php
	public function ListaContratoEmAndamento($idSession){
		
		$sql = "SELECT * FROM contratos	WHERE (status = 'em andamento' OR status = 'aberto') AND clientes_id = '".$idSession."'";
		
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
	
	//Lista todos os contratos em andamento para calendario.php
	public function NivelListaContratoEmAndamento(){
		
		$sql = "SELECT * FROM contratos	WHERE (status = 'em andamento' OR status = 'aberto')";
		
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
	
	
	//Lista todos os contratos renovado em andamento para contratosEmAndamento.php
	public function ListContratoRenovadoEmAndamento(){
		
		$sql = "SELECT c.nome_contrato, rc.* FROM renova_contrato rc
				INNER JOIN contratos c ON(rc.contrato_id = c.id)
				WHERE (rc.status = 'contrato renovado')";
		
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
	
	
	//Lista o contratos renovado em andamento pelo cliente para contratosEmAndamento.php
	public function ListContratoRenovadoEmAndamentoPeloCliente($idSession){
		
		$sql = "SELECT c.nome_contrato, rc.* FROM renova_contrato rc
				INNER JOIN contratos c ON(rc.contrato_id = c.id)
				WHERE (rc.status = 'contrato renovado') AND c.clientes_id = '".$idSession."'";
		
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
	
	
	//Lista todos os contratos no nome de quem esta na session para ordemDeServico.php
	public function ListaContratoParaAtender(){
		
		$sql = "SELECT dc.id, c.nome_contrato, dc.data_contrato, dc.status 
				FROM contratos c
				INNER JOIN data_contrato dc ON(c.id = dc.contrato_id)
				WHERE (dc.status = 'aberto' OR dc.status = 'configurando a ordem de servico para programa')";
		
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
	
	//Lista todos os contratos para ordemDeServico.php
	public function ListaContratoParaAtenderAdm(){
		
		//Esse status de atendido, vem da parte do funcionario fazer o atendimento, ele fica com o status de atendido
		$sql = "SELECT dc.visivel_para_ordem_servico, dc.id, c.nome_contrato, dt.data, dc.status 
				FROM data_contrato dc
				INNER JOIN contratos c ON(dc.contrato_id = c.id)
				INNER JOIN data dt ON(dc.data_id = dt.id)
				LEFT JOIN renova_contrato rc ON(dc.renova_contrato_id = rc.id)
				WHERE ((dc.status = 'aberto' OR dc.status = 'atendido')
				OR dc.status = 'ordem de servico configurado') AND 
				(dc.visivel_para_ordem_servico = '' OR dc.visivel_para_ordem_servico = 'N' 
				OR dc.visivel_para_ordem_servico = 'S')";
		
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
	
	//Lista o detalhamento do contrato para contratosEmAndamento.php
	public function ListaDetalhesContrato($idContrato){
		
		$sql = "SELECT c.data_inicio, c.data_final, dt.data, dc.id, c.nome_contrato, ts.nome as nome_servico, dc.status 
				FROM contratos c
				INNER JOIN data_contrato dc ON(c.id = dc.contrato_id)
				INNER JOIN data dt ON(dc.data_id = dt.id)
				INNER JOIN tipo_servico_por_contrato tspc ON(tspc.contrato_id = c.id)
				INNER JOIN tipo_servico ts ON(ts.id = tspc.tipo_servico_id)
				WHERE dc.contrato_id = '".$idContrato."' AND dc.renova_contrato_id = '0' AND dc.status LIKE 'aberto' 
				AND dt.data BETWEEN c.data_inicio AND c.data_final
				GROUP BY dt.data";
		
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
	

	//Lista o detalhamento do contrato renovado para contratosEmAndamento.php
	public function ListaDetalhesContratoRenovado($idContratoRenovado){
		
		$sql = "SELECT dt.data, dc.id, c.nome_contrato, ts.nome as nome_servico, dc.status 
				FROM renova_contrato rc
				INNER JOIN contratos c ON(rc.contrato_id = c.id)
				INNER JOIN data_contrato dc ON(rc.id = dc.renova_contrato_id)
				INNER JOIN data dt ON(dc.data_id = dt.id)
				INNER JOIN tipo_servico_por_contrato tspc ON(tspc.contrato_id = c.id)
				INNER JOIN tipo_servico ts ON(ts.id = tspc.tipo_servico_id)
				WHERE dc.renova_contrato_id = '".$idContratoRenovado."' GROUP BY dt.data";
		
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
	
	
	//Lista o contrato pelo id para calendario.php
	public function ListaContratoPeloId($idContrato){
		
		$sql = "SELECT dc.id, c.nome, co.valor_total_contrato, co.data_inicio, co.data_final, dc.data_contrato,
				ts.nome as nome_servico, u.nome as nome_func FROM contratos co
				INNER JOIN cliente c ON(co.clientes_id = c.id) 
				INNER JOIN data_contrato dc ON(co.id = dc.contrato_id) 
				INNER JOIN usuario u ON(dc.usuario_id = u.id) 
				INNER JOIN tipo_servico ts ON(dc.tipo_servico_id = ts.id)
				WHERE dc.contrato_id = '".$idContrato."' AND dc.status = 'aberto' ORDER BY id DESC";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$conn->closeConnect ();
		
		$array = array();
		while ($row = mysqli_fetch_assoc($resultado)) {
			$array[]=$row;
		}
		
		return $array;
		
	}
	
	//lista a quantidade de contratos para index.php
	public function QtdContratos(){
		
		$sql = "SELECT id FROM contratos WHERE status = 'aberto'";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$conn->closeConnect ();
		
		$array = array();
		while ($row = mysqli_fetch_assoc($resultado)) {
			$array[]=$row;
		}
		
		return $array;
		
	}
	
	//lista a quantidade de contratos fechados para index.php
	public function QtdContratosFechados(){
		
		$sql = "SELECT id FROM contratos WHERE status LIKE 'fechado' OR status = 'excluido'";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$conn->closeConnect ();
		
		$array = array();
		while ($row = mysqli_fetch_assoc($resultado)) {
			$array[]=$row;
		}
		
		return $array;
		
	}
	
	//Lista o contrato para visualizar o grafico deste para visualizarControleDePragasphp
	public function ListaContraPeloId($idContrato, $mes){
		
		$sql = "SELECT p.nome_pragas, MONTH(cp.data_cliente_inserir) as meses, YEAR(cp.data_cliente_inserir) as anos,s.nome_setor, cp.qtd_pragas, 
				c.nome_contrato, s.nome_setor
				FROM contratos c
				INNER JOIN controle_de_pragas cp ON(c.id = cp.contrato_id)
				INNER JOIN pragas p ON(cp.pragas_id = p.id)
                INNER JOIN setor s ON(cp.setor_id = s.id)
                WHERE cp.contrato_id = '".$idContrato."' AND MONTH(cp.data_cliente_inserir) = '".$mes."'
                AND (cp.status = 'pendente de resposta' OR cp.status = 'respondido pelo funcionario')";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$conn->closeConnect ();
		
		$array = array();
		while ($row = mysqli_fetch_assoc($resultado)) {
			$array[]=$row;
		}
		
		return $array;
		
	}
	
	//Lista todos os funcionario que realizara o contrato para contrato.php
	public function ListaFuncionarioRealizaContrato(){
		
		$sql = "SELECT u.nome, frvc.* FROM funcionario_realiza_visita_contrato frvc
				INNER JOIN usuario u ON(frvc.usuario_realiza_id = u.id)
                WHERE frvc.status = 'usu_realiza'";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$conn->closeConnect ();
		
		$array = array();
		while ($row = mysqli_fetch_assoc($resultado)) {
			$array[]=$row;
		}
		
		return $array;
		
	}
	
	//Lista todos os dados do renovo do contrato para visualizarContratos.php
	/*
	public function ListaContratoRenovado($idContrato){
		
		$sql = "SELECT rc.* FROM renova_contrato rc
				INNER JOIN contratos c ON(rc.contrato_id = c.id)
                WHERE rc.contrato_id = '".$idContrato."'";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$conn->closeConnect ();
		
		$array = array();
		while ($row = mysqli_fetch_assoc($resultado)) {
			$array[]=$row;
		}
		
		return $array;
		
	}*/
	
	//Lista  para contrato.php
	public function ListaFuncRealizaContt(){
		
		$sql = "SELECT * FROM funcionario_realiza_visita_contrato WHERE status = 'usu_realiza'";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$conn->closeConnect ();
		
		$array = array();
		while ($row = mysqli_fetch_assoc($resultado)) {
			$array[]=$row;
		}
		
		return $array;
		
	}
	
	//Lista os tipo de servico do contrato para contrato.php
	public function ListTipoServicoPorContrato(){
		
		$sql = "SELECT tttspc.id, ts.nome as nome_servico, ots.nome as nome_objeto, tob.nome as nome_produto
				FROM tipo_servico_por_contrato tttspc
				LEFT JOIN tipo_servico ts ON(tttspc.tipo_servico_id = ts.id)
				LEFT JOIN tipo_objetos tob ON(tttspc.produto_id = tob.id)
				LEFT JOIN objetos_tipo_servico ots ON(tttspc.objeto_servico_id = ots.id)
				WHERE tttspc.status = 'listado_para_contrato'";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$conn->closeConnect ();
		
		$array = array();
		while ($row = mysqli_fetch_assoc($resultado)) {
			$array[]=$row;
		}
		
		return $array;
		
	}
	
	//Lista os tipo de servico para renova contrato para contrato.php
	public function ListTipoServicoParaRenovaContrato(){
		
		$sql = "SELECT tttspc.id, ts.nome as nome_servico, ots.nome as nome_objeto, tob.nome as nome_produto
				FROM tipo_servico_por_contrato tttspc
				LEFT JOIN tipo_servico ts ON(tttspc.tipo_servico_id = ts.id)
				LEFT JOIN tipo_objetos tob ON(tttspc.produto_id = tob.id)
				LEFT JOIN objetos_tipo_servico ots ON(tttspc.objeto_servico_id = ots.id)
				WHERE tttspc.status = 'renova_contrato'";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$conn->closeConnect ();
		
		$array = array();
		while ($row = mysqli_fetch_assoc($resultado)) {
			$array[]=$row;
		}
		
		return $array;
		
	}
	
	//Lista os tipo de servico do contrato listado para renova para tela renovaContrato.php
	public function ListTipoServicoParaRenovaIdContrato($idContratt){
		
		$sql = "SELECT tttspc.id, ts.nome as nome_servico, ots.nome as nome_objeto, tob.nome as nome_produto
				FROM tipo_servico_por_contrato tttspc
				LEFT JOIN tipo_servico ts ON(tttspc.tipo_servico_id = ts.id)
				LEFT JOIN tipo_objetos tob ON(tttspc.produto_id = tob.id)
				LEFT JOIN objetos_tipo_servico ots ON(tttspc.objeto_servico_id = ots.id)
				WHERE tttspc.status = 'ativado pelo cont: ".$idContratt."' AND tttspc.contrato_id = '".$idContratt."'";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$conn->closeConnect ();
		
		$array = array();
		while ($row = mysqli_fetch_assoc($resultado)) {
			$array[]=$row;
		}
		
		return $array;
		
	}
	
	//Retorna o ultimo id do contrato cadastrado para atender.php
	/*
	public function ListaUltimoId(){
		
		$sql = "SELECT id, nome_contrato FROM contratos ORDER BY id DESC LIMIT 1";
		
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
	
	//Retorna o ultimo id da renovação do contrato para renovaContratos.php
	public function ListUltimoIdContratoRenova(){
		
		$sql = "SELECT id FROM renova_contrato ORDER BY id DESC LIMIT 1";
		
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
	
	//Retorna o ultimo id do contrato cadastrado para atender.php
	public function ListaContratoParaCalendario($idSession){
		
		$sql = "SELECT nome_contrato, DAYOFMONTH(dt.data) as dia_semana, dt.data, c.*, cli.nome, MONTHNAME(dt.data) as meses 
				FROM contratos c
				INNER JOIN cliente cli ON(c.clientes_id = cli.id)
				INNER JOIN data_contrato dc ON(c.id = dc.contrato_id)
				INNER JOIN data dt ON(dc.data_id = dt.id)
				WHERE clientes_id = '".$idSession."'";
		
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
	
	//Lista todos os contrato aberto para visualizarContratos.php
	public function VisualizarContratosAdm(){
		
		$sql = "SELECT * FROM contratos WHERE status = 'aberto'";
		
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
	
	//Lista todos os contrato aberto para adquacao.php
	public function ListaContratoParaAdquacao(){
		
		$sql = "SELECT * FROM contratos WHERE status = 'aberto'";
		
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
	
	//Lista todos os contrato atendido para adquacao.php
	public function ListaContratoEscolhidoPeloIdAdquacao($idContrato){
		
		$sql = "SELECT fac.foto as cont_foto, fac.id as foto_atendo_contrato_id, 
				dc.id as data_contrato_id, ad.*, c.id as contrato_id  
				FROM adquacao ad
				,contratos c
				,renova_contrato rc
		        ,data_contrato dc 
				LEFT JOIN fotos_atender_contrato fac ON(dc.id = fac.data_contrato_id)
				WHERE ad.contrato_id = '".$idContrato."' GROUP BY ad.id";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$conn->closeConnect ();
		
		$array = array();
		while ($row = mysqli_fetch_assoc($resultado)) {
			$array[]=$row;
		}
		
		return $array;
		
	}
	
	//Lista todos os contrato aberto para armadilhasIscagem.php
	public function ListaContratoParaArmadilhaIsc(){
		
		$sql = "SELECT * FROM contratos WHERE status = 'aberto'";
		
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
	
	//Lista para colocar na session para armadilhasIscagem.php
	public function BuscarPeloIdArmadilha($idContrato){
		
		$sql = "SELECT * FROM contratos WHERE status = 'aberto' AND id = '".$idContrato."'";
		
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
	
	//Lista contrato para visualizarContratos.php visualizarContratos.php
	public function BuscarContratoPeloIdParaVisualiza($idContrato){
		
		$sql = "SELECT DAYOFMONTH(dt.data) as dia_semana, cli.nome, c.*, nome_contrato, 
				MONTHNAME(dt.data) as meses, cli.tipo_cliente, cli.nome_fantasia
				FROM contratos c
				INNER JOIN cliente cli ON(c.clientes_id = cli.id)
				INNER JOIN data_contrato dc ON(c.id = dc.contrato_id)
				INNER JOIN data dt ON(dc.data_id = dt.id)
				WHERE c.status = 'aberto' AND dc.contrato_id = '".$idContrato."'";
		
		$sql1 = "SELECT rc.* FROM renova_contrato rc
				INNER JOIN contratos c ON(rc.contrato_id = c.id)
                WHERE rc.contrato_id = '".$idContrato."' AND rc.status = 'contrato renovado'";
		
		
		$conn = new Conexao();
		$conn->openConnect();
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		$resultado1 = mysqli_query($conn->getCon(), $sql1);
		$conn->closeConnect ();
		
		$array = array();
		while ($row = mysqli_fetch_assoc($resultado)) {
			$array[]=$row;
		}
		
		$array1 = array();
		while ($row1 = mysqli_fetch_assoc($resultado1)) {
			$array1[]=$row1;
		}
		
		$veriArray = array(
			"contrato" => $array,
			"renovaContrato" => $array1
		);
		
		
		return $veriArray;
		
	}
	
	//Lista pelo renovo do contrato para visualizarContratos.php
	public function MostraRenovoContratoPVisualiza($idRenovoContt){
		
		$sql = "SELECT DAYOFMONTH(dt.data) as dia_semana, cli.nome, rc.*, nome_contrato, 
				MONTHNAME(dt.data) as meses, cli.tipo_cliente, cli.nome_fantasia, dc.status as contrato_renovado
				FROM renova_contrato rc
				INNER JOIN contratos c ON(rc.contrato_id = c.id)
				INNER JOIN cliente cli ON(c.clientes_id = cli.id)
				INNER JOIN data_contrato dc ON(rc.id = dc.renova_contrato_id)
				INNER JOIN data dt ON(dc.data_id = dt.id)
				WHERE dc.status = 'aberto' AND dc.renova_contrato_id = '".$idRenovoContt."'";
		
		$conn = new Conexao();
		$conn->openConnect();
		
		$mydb = mysqli_select_db($conn->getCon(), $conn->getBD());
		$resultado = mysqli_query($conn->getCon(), $sql);
		
		$conn->closeConnect ();
		
		$array = array();
		while ($row = mysqli_fetch_assoc($resultado)) {
			$array[]=$row;
		}
		
		return $array;
		
	}
	
	//Lista os dados do contrato renovado para visualizarContratos.php
	/*
	public function ListaContratoRenovadoVisualizaContt($idRenovaContrato){
		
		$sql = "SELECT DAYOFMONTH(dt.data) as dia_semana, cli.nome, c.*, nome_contrato, 
				MONTHNAME(dt.data) as meses, cli.tipo_cliente, cli.nome_fantasia 
				FROM renova_contrato rc
				INNER JOIN contratos c ON(rc.contrato_id = c.id)
				INNER JOIN cliente cli ON(c.clientes_id = cli.id)
				INNER JOIN data_contrato dc ON(rc.id = dc.renova_contrato_id)
				INNER JOIN data dt ON(dc.data_id = dt.id)
				WHERE dc.renova_contrato_id = '".$idRenovaContrato."'";
		
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
	
	//Lista contrato para renovaContratos.php
	public function BuscarContratoParaRenova($idContrato){
		
		$sql = "SELECT rc.status as status_renova_contrato, dc.id as id_dt_contrato, dc.status as status_dt_contrato, rc.data_inicio as data_inicio_renova, 
				c.nome_contrato, c.valor_total_contrato, c.dia_pgto, dt.*, 
				s.id as id_setor, s.nome_setor, tspc.*, cli.id as id_cliente, cli.nome as nome_cliente, c.data_inicio, c.data_final,
				CASE WHEN rc.status = 'contrato renovado' THEN rc.data_final ELSE '0000/00/00' END as data_final_renova
				FROM contratos c
				LEFT JOIN renova_contrato rc ON(c.id = rc.contrato_id)
				LEFT JOIN cliente cli ON(c.clientes_id = cli.id)
				LEFT JOIN tipo_servico_por_contrato tspc ON(c.id = tspc.contrato_id)
				LEFT JOIN tipo_servico ts ON(tspc.tipo_servico_id = ts.id)
				LEFT JOIN objetos_tipo_servico ots ON(tspc.objeto_servico_id = ots.id)
				LEFT JOIN tipo_objetos tob ON(tspc.produto_id = tob.id)
				LEFT JOIN data_contrato dc ON(c.id = dc.contrato_id)
				LEFT JOIN data dt ON(dc.data_id = dt.id)
				LEFT JOIN contratos_setores cs ON(c.id = cs.contratos_id)
				LEFT JOIN setor s ON(cs.setor_id = s.id)
				WHERE dc.contrato_id = '".$idContrato."' AND dc.status LIKE 'aberto'";
		
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
	
	//Lista contrato para renovaContratos.php
	public function ListaContratoParaRenova(){
		
		$sql = "SELECT * FROM contratos WHERE (status = 'aberto' OR status = 'em andamento')";
		
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
	
	//Verificar se o id de quem esta enviando ja foi cadastrado o produto para ordemDeServicoPrograma.php
	/*
	public function VerificarCadOrdemServicoPro($idDtContrato){
		
		$sql = "SELECT * FROM data_contrato dc 
				INNER JOIN ordem_servico_programa osp ON(dc.id = osp.data_contrato_id)
				WHERE osp.data_contrato_id = '".$idDtContrato."'";
		
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
	*/
	
	//Verificar cadastro contrato
	public function VerificaContrato($nomeContrato){
		
		$sql = "SELECT * FROM contratos WHERE nome_contrato LIKE '".$nomeContrato."' AND status = 'aberto'";
		
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
	
	//Verificar se a data do fechamento e maior ou menor que a data que esta sendo verificado
	public function VerificaDataFechamentoContrato($dataMaior){
		
		$sql = "SELECT id FROM contratos 
				WHERE data_final < '".$dataMaior."' 
				AND (status = 'aberto' OR status = 'em andamento')";
		
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
	
	//Verificar se o contrato ja esta assinado
	public function VerificaContratoAssinadoC($idContrato, $idCliente, $status){
		
		$sql = "SELECT * 
				FROM contratos c
				INNER JOIN assina_contrato ac ON(c.id = ac.contrato_id) 
				WHERE ac.contrato_id = '".$idContrato."' 
				AND ac.cliente_id = '".$idCliente."' 
				AND ac.status_c = '".$status."'";
		
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
	
	//Verificar se o contrato ja esta assinado
	public function VerificaContratoAssinadoF($idContrato, $idFunc, $status){
		
		$sql = "SELECT * FROM assina_contrato WHERE contrato_id = '".$idContrato."' 
				AND status_f = '".$status."'";
		
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
	
	//Verificar contratos abertos para entityContratos.php
	public function VerificarContratoAbertos($data){
		
		$sql = "SELECT * FROM data_contrato dc 
				INNER JOIN data dt
				WHERE dt.data < '".$data."' AND (dc.status = 'aberto' OR dc.status = 'aberto para renova')";
		
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
	
	//Verificar a data do contrato para ver se ja esta cadastrado
	public function VerificaDataContrato($diaContrato, $idContrato){
		
		$sql = "SELECT * FROM data_contrato 
				WHERE data_contrato = '".$diaContrato."' 
				AND contrato_id = '".$idContrato."' 
				AND status = 'aberto'";
		
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