<?php 
session_start();

include_once 'Model/DAO/ClienteDAO.php';
include_once 'Model/DAO/ContratoDAO.php';
include_once 'Model/Modelo/Contrato.php';
include_once 'Model/DAO/SetorDAO.php';
include_once 'Model/DAO/TipoServicoDAO.php';
include_once 'Model/DAO/UsuarioDAO.php';
include_once 'Model/DAO/DataDAO.php';
include_once 'UploadIMG/SalvaPDFContrato.php';

//Atualizar com o fusio horario do brasil
date_default_timezone_set('America/Sao_Paulo');
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Renova contrato do cliente</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="vendor/morrisjs/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><?php echo $_SESSION['login']; ?> v2.0</a>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right">
               <li class="dropdown">
                    <a class="dropdown-toggle" href="ajudar.php">
                        <i class="fa fa-question-circle fa-fw"></i>
                    </a>
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['login']; ?></a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Config</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="Sair.php"><i class="fa fa-sign-out fa-fw"></i> Sair</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="index.php"><i class="fa fa-reply fa-fw"></i> Retorna </a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
		<?php if (!empty($_SESSION)) { ?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Renova contrato do cliente</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Renova contrato
                        </div>
                        <div class="panel-body">
                            <div class="row">
                            	<div class="col-lg-1"></div>
                                <div class="col-lg-10">
                                
                                
                                <?php
                                
                                //Grava as data na session para lista 
                                if (!empty($_POST['dataRenovaInicio']) || !empty($_POST['dataRenovaFinal']) || !empty($_POST['dt']) || !empty($_POST['idContrato'])){
                                	
                                	$_SESSION['dtaInicio'] = $_POST['dataRenovaInicio'];
									$_SESSION['dtaFinal'] = $_POST['dataRenovaFinal'];
									$_SESSION['renova_id_contrato'] = $_POST['idContrato'];
									
									?>  <script type="text/javascript"> window.location="renovaContratos.php"; </script> <?php
									
								} 
                                 
                                //Grava na tabela tabela_temp_tipo_servico_para_contrato os tipo de servicos para o contrato
                                else if (!empty($_POST['idTipoServicos']) || !empty($_GET['list'])){
                                	
                                	if (!empty($_POST['listaNovamente'])){
										
										$idTipoSer     = $_POST['idTipoServicos'];
										$idObjeto      = $_POST['idObjetosServicos'];
										$idTipoObjet   = $_POST['idTiposObjetos'];
										$status        = "renova_contrato";
										$idContrato    = $_SESSION['renova_id_contrato'];
										
										$conDAO = new ContratoDAO();
										$conDAO->CadastrTipoServicoParaRenova($idTipoSer, $idObjeto, $idTipoObjet, $status, $idContrato);
										
										?>  <script type="text/javascript"> window.location="renovaContratos.php"; </script> <?php
										
                                	}
                                	
								} 
                                
                                //Grava o contrato por completo
								else if (!empty($_POST) || !empty($_GET['salvar'])){
									
										if (empty($_POST)){
											?> <font size="3px" color="red"> Preencha todos os campos </font> <?php
										} else {
											
											//Pegar os dados do post
											$valorContrato = $_POST['valorContrato'];
											$status        = "contrato renovado";
											$dataCadastro  = date("Y-m-d");
											$dataInicio    = $_SESSION['dtaInicio'];
											$dataFinal     = $_SESSION['dtaFinal'];
											
											//Array de dia do calendario
											$diaPgto       = $_POST['diaPgto'];
											//As datas
											$diaContrato  = $_POST['valorData'];
											
											//Pegar o id do contrato da session selecionado
											$idContt = $_SESSION['renova_id_contrato'];
											
											if (!empty($_FILES['documento'])){
												
												//Atribuir este valor a esta variavel para passar e salvar
												$nomeDoc = "Salva";
												
											} else {
												
												//Recebe o documetno
												$documento     = $_FILES['documento'];
												
												//Salvando documento PDF do contrato
												$salvaDoc = new SalvaPDFContrato();
												$nomeDoc = $salvaDoc->Salva($documento);
												
											}
											
											if ($nomeDoc !== "erro"){
												
													$contrato = new Contrato();
													$contrato->status = $status;
													$contrato->dataCadastro = $dataCadastro;
													$contrato->dataInicio = $dataInicio;
													$contrato->dataFinal = $dataFinal;
													$contrato->valorTotalContrato = $valorContrato;
													$contrato->diaPgto = $diaPgto;
													$contrato->nomeDoc = $nomeDoc;
													$contrato->id = $_SESSION['renova_id_contrato'];
													
													$conDAO = new ContratoDAO();
													$result = $conDAO->CadastraRenovaContrato($contrato);
													
													if ($result){
														
														//List o ultimo id do contrato renovado da tabela renova_contrato
														$conDAO = new ContratoDAO();
														$ultimoId = $conDAO->ListUltimoIdContratoRenova();
														$ultID = 0;
														foreach ($ultimoId as $cliDAO  => $v){
															$ultID = $v['id'];
														}
														
														
															//Colocar o id do contrato na session
															//$_SESSION['idContratoSession'] = $ultID;
															
															//Cadastrar os setores informado para fazer a dedetização do setores por contrato
															$setores = $_POST['setores'];
															//Receber o ultimo id do contrato
															$idContratoRenova = 0;
															//Cadastrar os setores no contrato
															for ($i = 0; $i < count($setores); $i++){
																
																$status           = "ativado";
																$idContratoRenova = $ultID;
																$idSetor          = $setores[$i];
																$dtCadastro       = date('Y-m-d');
																
																$setDAO = new SetorDAO();
																$resul = $setDAO->CadastrarSetorNoContratoParaRenova($idSetor, $status, $dtCadastro, $idContratoRenova, $idContt);
																
															}
															
															if ($resul){
																
																//Pegar o id da data por data
																for ($i = 0; $i < count($diaContrato); $i++){
																	
																	$dataContra = new Contrato();
																	$dataContra->id = $idContt;
																	$dataContra->idContratoRenovado = $ultID;
																	$dataContra->status = "aberto";
																	$dataContra->diaContrato = $diaContrato[$i];
																	$dataContra->dataCadastro = $dataCadastro;
																	$dataContra->visivelOS = "N";
																	
																	//Faz o cadastro da data no contrato para saber os dias
																	$conDAO = new ContratoDAO();
																	$r = $conDAO->CadastraData($dataContra);
																	
																	
																	
																	$visivel = "Nao";
																	$idContrato = $ultID;
																	//Cadastrar as adquacao de acordo com as data do contrato
																	$conDAO = new ContratoDAO();
																	$r = $conDAO->CadastraAdquacaoContratoRenovado($visivel, $idContrato, $idContt);
																	
																}
																
																if ($r){
																
																	//Buscar os tipo de servico escolhido na tela do renovaContrato.php
																	$conDAO = new ContratoDAO();
																	$arrayTipoSer = $conDAO->ListServicoParaRenova();
																	
																	//Faz o cadastro do contrato nos tipo de servicos aberto
																	for ($ia = 0; $ia < count($arrayTipoSer); $ia++){
																		
																		$idTiCont = $arrayTipoSer[$ia]['id'];
																		$status   = "renovado cont pelo id: " . $ultID;
																		$idContra = $ultID;
																		
																		$conDAO = new ContratoDAO();
																		$valida = $conDAO->CadastrarContratoNoTipoServico($idContra, $status, $idTiCont, $idContt);
																		
																	}
																	
																	if ($valida){
																	
																		//Mantando a session das datas 
																		unset( $_SESSION['dtaInicio'] );
																		unset( $_SESSION['dtaFinal'] );
																		unset( $_SESSION['renova_id_contrato'] );
																		
																		?>  <script type="text/javascript"> alert('Contrato renovado com sucesso!'); window.location="index.php"; </script> <?php
																		
																	}
																	
																}
																
															}
														
														
														
													} else {
														?> <font size="3px" color="red"> Ocorreu um erro: <?php print_r($result); ?> </font> <?php
													}
													
												
											} else {
												?> <font size="3px" color="red"> Ocorreu um erro ao salvar documento em PDF </font> <?php
											}
											
										
										
									}
								
								}
								?>
								
								<?php 
								//Limpa as data que estão na session
								if (!empty($_GET['sxc'])){
									if ($_GET['sxc'] === "562"){
										
										$id = $_SESSION['renova_id_contrato'];
										$status = "renova_contrato";
										
										//Excluir todas os setores que estão gravados
										$setDAO = new SetorDAO();
										$setDAO->DeletaTipoServicoParaRenova($status, $id);
										
										//Mantando a session das datas 
										unset( $_SESSION['dtaInicio'] );
										unset( $_SESSION['dtaFinal'] );
										unset( $_SESSION['renova_id_contrato'] );
										
										//Refdirecionando a pagina
										?>  <script type="text/javascript"> window.location="renovaContratos.php"; </script> <?php
									}
								}
								?>
										
                                    	
                                    	<?php 
                                    	if (empty($_SESSION['dtaInicio']) || empty($_SESSION['dtaFinal'])){
                                    	?>
                                    	
                                    <form role="form" action="renovaContratos.php?dt=Dt524152@" method="post">
                                    	<div class="row">
                            				<div class="col-lg-3">
                            					<div class="form-group">
		                                            <label>Data de inicio</label>
		                                            <input type="date" class="form-control" name="dataRenovaInicio">
		                                        </div>
		                                    </div><div class="col-lg-3">    
		                                        <div class="form-group">
		                                            <label>Data final</label>
		                                            <input type="date" class="form-control" name="dataRenovaFinal">
		                                        </div>
		                                    </div><div class="col-lg-6" align="center">
		                                    	<div class="form-group">
		                                           <label for="disabledSelect">Seleciona um contrato</label>
		                                           <select id="" class="form-control" name="idContrato">
		                                           	  <option value="0"></option>
			                                              <?php 
			                                              $conDAO = new ContratoDAO();
														  $arrayContrato = $conDAO->ListaContratoParaRenova();
			                                              foreach ($arrayContrato as $conDAO => $contrato){
			                                              ?>
			                                        		<option value="<?php echo $contrato['id']; ?>"><?php echo $contrato['nome_contrato']; ?></option>
							                              <?php } ?>
			                                        </select>
			                                     </div>
	                                    	</div>
	                                    </div><br>
	                                    <div class="row">
                            				<div class="col-lg-12" align="center">
                            					<input type="submit" class="btn btn-default" value="Buscar contrato para renova" />
                            				</div>
                            			</div>
                                    </form>
                                    
                                    	<?php } else { 
                                    	
                                    	//Pegar o id do contrato da session para lista o contrato
                                    	$idContrato = $_SESSION['renova_id_contrato'];
                                    	$conDAO = new ContratoDAO();
                                    	$arrayRenovaContrato = $conDAO->BuscarContratoParaRenova($idContrato);
                                    	$nomeContt = null;
                                    	$valoContt = 0;
                                    	$diaPgtoContt = 0;
                                    	$idCliente = 0;
                                    	$nomeCliente = null;
                                    	$dataFinal = 0;
                                    	$dataFinalRenova = 0;
                                    	$statusRenova = null;
                                    	foreach ($arrayRenovaContrato as $conDAO => $listCont){
                                    		$nomeContt       = $listCont['nome_contrato'];
                                    		$valoContt       = $listCont['valor_total_contrato'];
                                    		$diaPgtoContt    = $listCont['dia_pgto'];
                                    		$idCliente       = $listCont['id_cliente'];
                                    		$nomeCliente     = $listCont['nome_cliente'];
                                    		//Data final do contrato
                                    		$dataFinal       = $listCont['data_final'];
                                    		//data final da renovação do contrato
                                    		$dataFinalRenova = $listCont['data_final_renova'];
                                    		$statusRenova = $listCont['status_renova_contrato'];
                                    	}
                                    	$dt = 0;
                                    	if ($dataFinal > $dataFinalRenova){
                                    		$dt = $dataFinal; 
                                    	} else { $dt = $dataFinalRenova; }
                                    	
                                    		?>
                                    	
                                    	
                                    	<?php if ($_SESSION['dtaInicio'] <= $dt) {?>
                                    	<div class="alert alert-danger alert-dismissable">
			                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			                                Atencao! Este contrato possui data neste periodo.
			                            </div>
                            			<?php } ?>
                            			
                            			
                            			<a href="renovaContratos.php?sxc=562" class="btn btn-success">Busca outro contrato com novas datas</a><br><br>
                            			
                            			
                                    	<div class="row">
							                <div class="col-lg-12">
							                    <div class="panel panel-default">
							                        <div class="panel-heading">
							                            Dados do contrato para renovar
							                        </div>
							                        <!-- /.panel-heading -->
							                        <div class="panel-body">
							                            <div class="table-responsive">
							                                <div><p>Nome do contrato: <font color="#449D44" size="3"><?php echo $nomeContt; ?></font> </p></div>
							                                <div><p>Data da renovacao: <font color="#449D44" size="3"><?php echo date('d-m-Y', strtotime($_SESSION['dtaInicio'])); ?> </font> A <font color="#449D44" size="3"><?php echo date('d-m-Y', strtotime($_SESSION['dtaFinal'])); ?> </font></p></div>
							                            </div>
							                            <!-- /.table-responsive -->
							                        </div>
							                        <!-- /.panel-body -->
							                    </div>
							                    <!-- /.panel -->
							                </div>
							                <!-- /.col-lg-6 -->
							          	</div>
                                        
                                        
                                    	<!-- lista os tipo de servico do projeto -->
                                    	<?php
                                    	//Deleta tipo de servico na tela do contrato 
                                    	if (!empty($_GET['excTipoServico'])){
                                    		
                                    		$id = $_GET['excTipoServico'];
                                    		
                                    		$conDAO = new ContratoDAO();
                                    		$conDAO->DeletaTipoServicoNoContrato($id);
                                    		
                                    		?>  <script type="text/javascript"> window.location="renovaContratos.php"; </script> <?php
                                    		
                                    	}
                                    	?>
							            <div class="row">
							                <div class="col-lg-12">
							                    <div class="panel panel-default">
							                        <div class="panel-heading">
							                            Tipo de servico deste contrato
							                        </div>
							                        <!-- /.panel-heading -->
							                        <div class="panel-body">
							                            <div class="table-responsive">
							                            <?php 
							                            //Lista os tipo de servico do contrato
							                            $conDAO = new ContratoDAO();
							                            $arrayTipoServico = $conDAO->ListTipoServicoParaRenovaContrato();
							                            if (!empty($arrayTipoServico)){
							                            ?>
							                                <table class="table table-striped table-bordered table-hover">
							                                    <thead>
							                                        <tr>
							                                            <th>#</th>
							                                            <th>Tipo de servico</th>
							                                            <th>Objeto</th>
							                                            <th>Produto</th>
							                                            <th>Excluir</th>
							                                        </tr>
							                                    </thead>
							                                    <tbody>
							                                    <?php 
							                                    foreach ($arrayTipoServico as $conDAO => $valor){
							                                    ?>
							                                        <tr>
							                                            <td><?php echo $valor['id']; ?></td>
							                                            <td><?php echo $valor['nome_servico']; ?></td>
							                                            <td><?php echo $valor['nome_objeto']; ?></td>
							                                            <td><?php echo $valor['nome_produto']; ?></td>
							                                            <td align="center"><a href="renovaContratos.php?excTipoServico=<?php echo $valor['id']; ?>"><i class="glyphicon glyphicon-trash"></i></a></td>
							                                        </tr>
							                                    <?php } ?>
							                                    </tbody>
							                                </table>
							                            <?php } ?>    
							                            </div>
							                            <!-- /.table-responsive -->
							                        </div>
							                        <!-- /.panel-body -->
							                    </div>
							                    <!-- /.panel -->
							                </div>
							                <!-- /.col-lg-6 -->
							          	</div>
						          	
                                    <form role="form" action="renovaContratos.php?list=Nvo142@12" method="post">
                                    	<div class="row">
                            				<div class="col-lg-12">
	                                    		<div class="panel panel-default">
	                                    			<div class="panel-heading">
							                            Informa os tipo de servico que o contrato tera
							                        </div>
							                        <div class="panel-body">
				                                        <div class="row">
				                            				<div class="col-lg-2" align="center">
				                            					<label for="disabledSelect"> + </label><br>
				                            					<input type="checkbox" name="listaNovamente" value="novamente" />
				                            				</div><div class="col-lg-10">
						                                        <div class="form-group">
							                                        <label for="disabledSelect">Tipo de servicos</label>
							                                        <select class="form-control" name="idTipoServicos" id="id_categoria">
							                                          <option value="0"></option>
							                                           <?php 
							                                           $tipDAO = new TipoServicoDAO();
							                                           $arrayTip = $tipDAO->ListaTodosTipoServico();
							                                           foreach ($arrayTip as $tipDAO => $tipo){
							                                           ?>
							                                           <option value="<?php echo $tipo['id']; ?>"><?php echo $tipo['nome']; ?></option>
							                                           <?php } ?>	
							                                        </select>
							                                     </div>
							                                     </div><div class="col-lg-5">
							                                     <div class="form-group">
							                                        <label for="disabledSelect">Objetos do servicos</label>
							                                        <select id="id_sub_categoria" class="form-control" name="idObjetosServicos">
							                                        	<option value="0"></option>
							                                     	</select>
							                                     </div>
							                                     </div><div class="col-lg-5">
							                                     <div class="form-group">
							                                        <label for="disabledSelect">Informe o produto</label>
							                                        <select id="id_sub_categoria_prod" class="form-control" name="idTiposObjetos">
							                                           <option value="0"></option>
							                                        </select>
							                                     </div>
							                                     </div><div class="col-lg-2" align="center">
							                                     <label for="disabledSelect">#</label><br>
							                                     <input class="btn btn-success" type="submit" value="+" />
					                                     	</div>
					                                     </div>
	                                     			</div>
	                                     		</div>
	                                     	</div>
	                                     </div>
	                                     
	                                     <!-- java script -->
	                                     <script type="text/javascript" src="https://www.google.com/jsapi"></script>
										<script type="text/javascript">
										  google.load("jquery", "1.4.2");
										</script>
										
										<script type="text/javascript">
										//Function para lista as o objeto do servicos 
										$(function(){
											$('#id_categoria').change(function(){
												if( $(this).val() ) {
													$('#id_sub_categoria').hide();
													$('.carregando').show();
													$.getJSON('carregaObjeto.php?search=',{id_categoria: $(this).val(), ajax: 'true'}, function(j){
														var options = '<option value="#">Informe o objeto do servico</option>';	
														for (var i = 0; i < j.length; i++) {
															options += '<option value="' + j[i].id + '">' + j[i].nome_sub_categoria + '</option>';
														}	
														$('#id_sub_categoria').html(options).show();
														$('.carregando').hide();
													});
												} else {
													$('#id_sub_categoria').html('<option value="">– Escolha o setor –</option>');
												}
											});
										});
										</script>
										
										<script type="text/javascript" src="https://www.google.com/jsapi"></script>
										<script type="text/javascript">
										  google.load("jquery", "1.4.2");
										</script>
										<!-- function para lista o produto -->
										<script type="text/javascript">
										//Carregar o produto listado pelo objeto do tipo do servico 
										$(function(){
											$('#id_sub_categoria').change(function(){
												if( $(this).val() ) {
													$('#id_sub_categoria_prod').hide();
													$('.carregando').show();
													$.getJSON('carregaProduto.php?search=',{id_sub_categoria: $(this).val(), ajax: 'true'}, function(j){
														var options = '<option value="#">Informe o produto</option>';	
														for (var i = 0; i < j.length; i++) {
															options += '<option value="' + j[i].id + '">' + j[i].nome_sub_categoria + '</option>';
														}	
														$('#id_sub_categoria_prod').html(options).show();
														$('.carregando').hide();
													});
												} else {
													$('#id_sub_categoria_prod').html('<option value="">– Escolha o setor –</option>');
												}
											});
										});
										</script>
										<!-- /java script -->
										
                                    </form>
                                    	
                                    <form role="form" action="renovaContratos.php?salvar=5256-@asvb@23" method="post" enctype="multipart/form-data">
                                    	
                                        <label>Informe o valor da renovacao do contrato</label>
                                        <div class="form-group input-group">
                                        	<span class="input-group-addon">R$</span>
                                            <input class="form-control" placeholder="Valor total do contrato" name="valorContrato">
                                            <span class="input-group-addon">.00</span>
                                        </div>
                                        <div class="form-group">
                                            <label>Informe o dia do pagamento</label>
                                            <input type="text" class="form-control" name="diaPgto" placeholder="Exemplo: 05">
                                        </div>
                                        
                                        <div class="form-group">
                                        <br><div align="center"> <h4>Informe o dia da visita</h4> </div>
                                        <!-- Comeca o calendario -->
                                        <?php 
											
											//Criar um array de mes
											$arrayMes = array(
											1 => 'Janeiro',
											2 => 'Fevereiro',
											3 => 'Marco',
											4 => 'Abril',
											5 => 'Maio',
											6 => 'Junho',
											7 => 'Julho',
											8 => 'Agosto',
											9 => 'Setembro',
											10 => 'Outubro',
											11 => 'Novembro',
											12 => 'Dezembro'
											);
											
											//array dia ingles
											$arrayDia = array(
											0 => 'Sunday',
											1 => 'Monday',
											2 => 'Tuesday',
											3 => 'Wednesday',
											4 => 'Thursday',
											5 => 'Friday',
											6 => 'Saturday'
											);
											
											
											//$dataHoje = "2019-03-12";
											//Pegando a data escolhida pelo usuario da session
											$dataInicio    = $_SESSION['dtaInicio'];
											$dataFinal     = $_SESSION['dtaFinal'];
											
											
											$dataDAO = new DataDAO();
											$arrayData = $dataDAO->ListaDataApartirHoje($dataInicio, $dataFinal);
											
											
											$anoMesBanco = array();
											$mesAtual = null;
											//Array de mes e ano
											
											$b = 1;
											$c = 0;
											$a = 0;
												
											for ($va = 0; $va < count($arrayData); $va++){
												
												$anoMes = date('Y-m', strtotime($arrayData[$va]['data']));
												
												if ($anoMes <> $mesAtual){
													
													//Pegar os mes e ano 
													$anoMesBanco[] = date('Y-m', strtotime($arrayData[$va]['data'])); 
													
													//Pegar o mes e o ano para quer no if
													$mesAtual = date('Y-m', strtotime($arrayData[$va]['data']));
													
												}
												
											}
											
												
											for ($a = 0; $a < count($anoMesBanco); $a++){
													
												$mes = date('m', strtotime($anoMesBanco[$a]));
												$ano = date('Y', strtotime($anoMesBanco[$a]));
												
												$valorMesSemZero = intval(date($mes));
												
												$listaMes = $arrayMes[$valorMesSemZero];
												?>
												
												<?php if ($a >= $c){ $c = $c + 3; ?>
													<div class="row">
												<?php } ?>
												
												
										        <div class="col-lg-4">
										                
												<table class="table table-striped table-bordered table-hover" id="dataTables-example">
												
													<tr>
														<td valign="top" align="center" colspan="7" bgcolor="#FFCC00"><b><font face="Arial" size="3"><?php echo $listaMes; ?> <?php echo $ano; ?></font> </b></td>
													</tr>
													
													<tr>
														<td valign="top" align="center" bgcolor="#CCFF99"><font size="1" face="Arial"><b>Dom</b> </font></td>
														<td valign="top" align="center" bgcolor="#CCFF99"><font size="1" face="Arial"><b>Seg</b> </font></td>
														<td valign="top" align="center" bgcolor="#CCFF99"><font size="1" face="Arial"><b>Ter</b> </font></td>
														<td valign="top" align="center" bgcolor="#CCFF99"><font size="1" face="Arial"><b>Qua</b> </font></td>
														<td valign="top" align="center" bgcolor="#CCFF99"><font size="1" face="Arial"><b>Qui</b> </font></td>
														<td valign="top" align="center" bgcolor="#CCFF99"><font size="1" face="Arial"><b>Sex</b> </font></td>
														<td valign="top" align="center" bgcolor="#CCFF99"><font size="1" face="Arial"><b>Sab</b> </font></td>
													</tr>
													
													<?php
													//Buscar as data de acordo com o mes e ano
													$dataDAO = new DataDAO();
													$arrayDt = $dataDAO->ListaDataCompletaPeloMesAno($valorMesSemZero, $ano);
													
													$aa = 0;
													$par = 0;
													//Lista as data pelo array enviado no arrayDt
													for ($p = 0; $p < count($arrayDt); $p++){
														
														//Se o $p for maior que $we que e 6 para lista a semana toda em horizontal ele faz para quebra
														if ($par < 1){ ?> <tr> <?php } 
															
															//Verificar a data para lista no dia certo 
															if ($arrayDt[$p]['nome_do_dia_da_semana'] === $arrayDia[$aa]){																
																
																if ($dataInicio > $arrayDt[$p]['data']){
																	?><td valign="top" align="center"><font size="1" face="Arial" color="red"> <b><?php echo $arrayDt[$p]['dia']; ?></b> </font></td><?php 
																} else if ($dataFinal < $arrayDt[$p]['data']){
																	?><td valign="top" align="center"><font size="1" face="Arial" color="red"> <b><?php echo $arrayDt[$p]['dia']; ?></b> </font></td><?php 
																} else { 
																	?> <td valign="top" align="center"><input type="checkbox" name="valorData[]" value="<?php echo $arrayDt[$p]['id'];?>"/><br><font size="1" face="Arial"> <b><?php echo $arrayDt[$p]['dia']; ?></b> </font></td><?php 
																}
																
															}//Fecha o if que verificar se o dia da semana e o mesmo da data
															
															if ($arrayDt[$p]['nome_do_dia_da_semana'] !== $arrayDia[$aa]){
																//Receber o menos um no $p se o nome da semana no banco for menor
																$p = $p - 1;
															?>
																<td valign="top" align="center"><font size="1" face="Arial"> <b>00</b> </font></td>
															<?php }//fecha o else que verificar se esta no mesmo dia
															
														//Neste if verificar se o $p e maior que $we. Ele ganha ele mesmo mais 7 e o $p diminuir menos um para não perder o valor que esta sendo passado
														if ($par > 5){ ?> </tr> <?php $par = 0; } else { $par = $par + 1; }
														
														$aa = $aa + 1;
														
														//Se a for maior do 6 ou igual ele zera novamente para lista
														if ($aa > 6){ $aa = 0; }
													
														
													}//Fechar o for que lista as datas  
													
													?>
												
												</table>
												
												</div>
												
												<?php if ($a > $b){ $b = $b + 3;?>
													</div>
												<?php  } ?>
												
												
												<?php 
												}//Fecha o for que lista os meses com anos 
												?>
												                                
										</div><br>                             
                                        
                                        
                                        
                                        
                                        
                                        
                                        <div class="form-group">
                                        	<label>Informe os setores que faram parte deste contrato</label>
                                        	<table class="table">
			                                    <thead>
			                                        <tr>
			                                        	<th>Id</th>
			                                            <th>Nome setor</th>
			                                            <th>Id</th>
			                                            <th>Nome setor</th>
			                                            <th>Id</th>
			                                            <th>Nome setor</th>
			                                        </tr>
			                                    </thead>
			                                    <tbody>
			                                    <?php 
			                                    $setDAO = new SetorDAO();
			                                    $arraySetores = $setDAO->ListaSetoresAtivo();
			                                    $contador = 2;
			                                    for ($i = 0; $i < count($arraySetores); $i++){
			                                    	$valor = 0;
			                                    	$idSetor = 0;
			                                    	$nomeSetor = null;
			                                    	foreach ($arrayRenovaContrato as $renContra){
			                                    		if (empty($valor)){
				                                        	if ($arraySetores[$i]['nome_setor'] === $renContra['nome_setor']){
				                                        		$valor = "1";
				                                        		$idSetor = $renContra['id_setor'];
				                                        		$nomeSetor = $renContra['nome_setor'];
				                                        	}
			                                    		}
			                                    	}
			                                    ?>
			                                        <?php if ($contador < $i){ $contador = $contador + 3; ?>
			                                        <tr>
			                                        <?php } ?>
			                                        
			                                        
			                                            <?php 
			                                            if ($valor === "1"){
			                                            ?>
			                                            	<td><input type="checkbox" name="setores[]" value="<?php echo $idSetor; ?>" checked /></td>
			                                            <?php } else { ?>
			                                            	<td><input type="checkbox" name="setores[]" value="<?php echo $arraySetores[$i]['id']; ?>"/></td>
			                                            <?php } ?>
			                                            
			                                            
			                                            
			                                            <td><?php echo $arraySetores[$i]['nome_setor']; ?></td>
			                                        <?php if ($contador < $i){ $contador = $contador + 3; ?>
			                                        </tr>
			                                        <?php } ?>
			                                    <?php } ?>
			                                    </tbody>
			                                </table>
                                        </div><br>
                                         
	                                     <div class="form-group">
                                            <label>Inserir documnto em PDF</label>
                                            <input type="file" class="form-control" name="documento">
                                        </div>
                                        
                                        <br>
                                        <button type="submit" class="btn btn-default">Renova e finalizar</button>
                                        <button type="reset" class="btn btn-default">Reset</button>
                                        
                                    </form>
                                    
                                        <?php } //Fecha o else dque verificar se a session da data esta vazia ?>
                                        
                                </div>
                                <div class="col-lg-1"></div>
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
		<?php }//Fecha a session que verifica se esta vazio ?>
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>


</body>
</html>