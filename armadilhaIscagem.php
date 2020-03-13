<?php
session_start();

include_once 'Model/DAO/ContratoDAO.php';
include_once 'Model/DAO/SetorDAO.php';
include_once 'Model/DAO/ArmadilhaIscagemDAO.php';
include_once 'Model/Modelo/ArmadilhaIscagem.php';
include_once 'UploadIMG/MapaArmadilhaIscagem.php';

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

    <title>Armadilhas e iscagem</title>

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
		
		<?php 
		if (!empty($_GET['bus'])){
			
			if ($_GET['bus'] === "contrato2536542sd4"){
				
				//Destroy esses dados da session
				unset( $_SESSION['nome_contrato'] );
				unset( $_SESSION['idContrato'] );
				
				?> <script type="text/javascript"> window.location="armadilhaIscagem.php";  </script> <?php
				
			}
			
		}
		?>
		
		<div id="page-wrapper">
			<div class="row"><br><br>
		    	<div class="col-lg-12">
		    		<?php 
		    		if (!empty($_POST)){
						
						if (empty($_POST['idContrato']) && empty($_SESSION['idContrato'])){
							?> <font size="3px" color="red"> Preencha todos os campos </font> <?php
						} else {
							
							if (!empty($_GET['selecao'])){
							
								//Verificar se na session existe ja o contrato
								if (!empty($_SESSION['idContrato'])){
									$idContrato = $_SESSION['idContrato'];
								} else {
									
									$idContrato = $_POST['idContrato'];
									//Busca o nome do contrato
									$conDAO = new ContratoDAO();
									$arrayContra = $conDAO->BuscarPeloIdArmadilha($idContrato); 
									foreach ($arrayContra as $conDAO => $lista){
										$_SESSION['idContrato'] = $lista['id'];
										$_SESSION['nome_contrato'] = $lista['nome_contrato']; 
									}
									
								}
								
								$idSetor     = $_POST['idSetor'];
								$qtd         = $_POST['qtd'];
								$campo       = $_POST['armadilha'];
								 
								
								//Verificar se os campos estão vazios para lista o contrato, sem precisar fazer o cadastro do mesmo
								if (!empty($idSetor) || !empty($qtd) || !empty($campo)){
								
									$novoFoto = null;
									if (!empty($_FILES)){
										
										$foto = $_FILES['foto'];
										$uplodFoto = new MapaArmadilhaIscagem();
										$novoFoto = $uplodFoto->img($foto);
									
									} else {
										$novoFoto = "dados.png";
									}
									
									if ($novoFoto !== 10){
										
										$armadilha = new ArmadilhaIscagem();
										$armadilha->status = "ativado";
										$armadilha->contrato_id = $idContrato;
										$armadilha->setor_id = $idSetor;
										$armadilha->quantidade = $qtd;
										$armadilha->armadilhaDispositivo = $campo;
										$armadilha->caminhoFoto = $novoFoto;
									
										$armDAO = new ArmadilhaIscagemDAO();
										$verifica = $armDAO->Cadastra($armadilha);
										
										if ($verifica){
											?> <br><font size="3px" color="lime">Armadilha e iscagem cadastrado com sucesso! </font><br><br> <?php
										} else {
											?> <br><font size="3px" color="red"> Ocorreu um erro: <?php print_r($verifica); ?> </font><br><br> <?php
										}
										
									} else { echo "Ocorreu um erro ". $novoFoto; }
									
								}//Fechar o if que verificar se os campos idSetor e demais estão preenchidos
								
							} else if (!empty($_GET['tables'])){
								
								if (!empty($_POST['check'])){
										
									$check            = $_POST['check'];
									$select           = $_POST['select'];
									$equipamentos     = $_POST['equipamentos'];
									$posicaoInstalada = $_POST['posicaoInstalada'];
									$identificacao    = $_POST['identificacao'];
									$data             = $_POST['data'];
									
									$a = 0;
									for ($i = 0; $i < count($_POST['select']); $i++){
										
										if ($_POST['select'][$i] !== "0"){
											
											$arma = new ArmadilhaIscagem();
											$arma->check = $check[$a];
											$arma->select = $select[$i];
											$arma->equipamento = $equipamentos[$i];
											$arma->posicao_instalada = $posicaoInstalada[$i];
											$arma->identificacao = $identificacao[$i];
											$arma->data = $data[$i];
											
											$armDAO = new ArmadilhaIscagemDAO();
											$verif = $armDAO->AlterarArmadilha($arma);
											
											$a = $a + 1;
											
										}
										
									}
									
									if ($verif){
										?> <br><font size="3px" color="lime">Dados salvo com sucesso! </font><br><br> <?php
									} else {
										?> <br><font size="3px" color="red"> Ocorreu um erro: <?php print_r($verifica); ?> </font><br><br> <?php
									}
									
								}
								
							}
							
						}
						
					}
					?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
						<div class="panel-body">
						
		                	<div class="row">
		                    	<div class="col-lg-1"></div>
		                        <div class="col-lg-10">
									<div class="form-group">
										<form action="armadilhaIscagem.php?selecao=contrato" method="post" enctype="multipart/form-data">
											<?php if (empty($_SESSION['idContrato'])){?>
											<div class="row">
		                    					<div class="col-lg-12">
		                    						<label>Informe o contrato</label>
		                    					 	<div class="form-group input-group">
														<select id="" class="form-control " name="idContrato">
									                    	<option value="0"></option>
									                        <?php
									                        $conDAO = new ContratoDAO();
															$arrayContratos = $conDAO->ListaContratoParaArmadilhaIsc(); 
									                        foreach ($arrayContratos as $conDAO => $list){ 
									                        ?>
							                            		<option value="<?php echo $list['id']; ?>"><?php echo $list['nome_contrato']; ?></option>
							                            	<?php } ?>	
									              		</select>
									              		<span class="input-group-btn">
				                                        	<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
				                                        </span>
									              	</div>	
								            	</div>
								            </div>
						              		<?php } else { ?>
						              		<div class="row">
		                    					<div class="col-lg-6">
						              				<h4>Contrato: <?php echo $_SESSION['nome_contrato']; ?></h4>
						              			</div><div class="col-lg-3"></div><div class="col-lg-3"> 
						              				<a href="armadilhaIscagem.php?bus=contrato2536542sd4" class="btn btn-danger">Buscar outro contrato</a>
						              			</div>
						              		</div>
						              		<?php } ?>
						              		<br><div class="form-group">
						              			<div class="row">
						              			
		                    						<div class="col-lg-4">
		                    						
		                                            	<label>Comodo</label>
		                                            	<select id="" class="form-control" name="idSetor">
								                    	<option value="0"></option>
								                        <?php
								                        $setDAO = new SetorDAO();
														$arraySetor = $setDAO->ListaSetoresParaArmadilha(); 
								                        foreach ($arraySetor as $setDAO => $setor){ 
								                        ?>
						                            		<option value="<?php echo $setor['id']; ?>"><?php echo $setor['nome_setor']; ?></option>
						                            	<?php } ?>	
								              			</select>
								              			
								              		</div><div class="col-lg-3">
								              		
								              			<label>Qtd</label>
		                                            	<input type="text" name="qtd" class="form-control" />
		                                            	
								                	</div><div class="col-lg-3">
								                	
								                		<label>Arm/Disp instalar</label>
								                        <input type="text" name="armadilha" class="form-control">
								                        
								                    </div><div class="col-lg-2" align="center">
								                    
								                    	<label>Salvar</label><br />
								                        <input type="submit" value="adicionar" class="btn btn-default">
								                        
								              		</div>
								              	</div><br>
								              	<?php
								              	//Verificar se existe uma mapa ja cadastro para este contrato selecionado 
								              	if (!empty($_SESSION['idContrato'])){
													$idContrato = $_SESSION['idContrato'];
								              	
									              	$armDAO = new ArmadilhaIscagemDAO();
									              	$arrayAmr = $armDAO->VerificaMapa($idContrato);
									              	$mapa = 0;
									              	$idFoto = 0;
									              	foreach ($arrayAmr as $armDAO => $ap){
									              		$verifica = $ap['caminho_foto'];
									              		if ($verifica !== "dados.png"){
									              			$mapa = $ap['caminho_foto'];
									              			$idFoto = $ap['id'];	
									              		}
									              	}
									              	
									              	if ($mapa === "dados.png" || empty($mapa)){
								              	?>
								              	<div class="row">
		                    						<div class="col-lg-7"></div>
		                    						<div class="col-lg-5" align="right">
		                    							<label>Anexa o mapa</label>
		                    							<input type="file" class="btn btn-default" name="foto" />
		                    						</div>
		                    					</div>
		                    					<?php } else {?>
		                    					<a href="VisualizaMapa.php?mps=<?php echo $idFoto; ?>">Visualizar Mapa</a>
		                    					<?php } } ?>
                                        	</div>
		                            	</form>
			                    	</div>
			                	</div>
			            	</div>
			            
			        	</div>
			    	</div>
			    	
				</div>
			</div>
			<!-- /row -->
			
			<?php 
			if (!empty($_SESSION['idContrato'])){
				$idContrato = $_SESSION['idContrato'];
		        //Busca o nome do contrato
				$armDAO = new ArmadilhaIscagemDAO();
				$arrayArmadilha = $armDAO->ListaArmadilhaIscagemAtiva($idContrato);
				if (!empty($arrayArmadilha)){
					$nomeCliente = null;
					foreach ($arrayArmadilha as $armDAO => $v){
						if ($v['tipo_cliente'] === "PF"){
							$nomeCliente = $v['nome'];
						} else {
							$nomeCliente = $v['nome_fantasia'];
						}
					}
			?>
			<div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Lista de Armadilhas Instaladas no Cliente (ordenada pela 'Identificacao Extra'):
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                            	<form action="armadilhaIscagem.php?tables=12508" method="post">
                            		<br><div class="row">
                						<div class="col-lg-9" align="left">
                            				<div class="panel-heading">Mapas de Armadilhas Instaladas no Cliente: <?php echo $nomeCliente; ?> </div>
                            			</div><div class="col-lg-3" align="right">
                            				<input type="submit" value="salvar e continuar" class="btn btn-success" /><br>
                            			</div>
                            		</div><br>		
	                                <table class="table table-striped table-bordered table-hover">
	                                    <thead>
	                                        <tr>
	                                        	<th>Alt</th>
	                                            <th>Equipamento - Codigo</th>
	                                            <th>Servico de inst.</th>
	                                            <th>Comodo/area</th>
	                                            <th>Posicao instalada</th>
	                                            <th>Identificacao Extra</th>
	                                            <th>Dt. Instalacao</th>
	                                        </tr>
	                                    </thead>
	                                    <tbody>
	                                    <?php 
	                                    foreach ($arrayArmadilha as $armDAO => $arma){
	                                    ?>
	                                        <tr>
	                                            <td><input type="checkbox" name="check[]" value="<?php echo $arma['id']; ?>"/></td>
	                                            <td><input type="text" name="equipamentos[]" class="form-control" value="<?php echo $arma['equipamento']; ?>" /></td>
	                                            <td>
	                                            <?php //E o id da armadilha
	                                            echo $arma['id']; ?>
	                                            </td>
	                                            
	                                            <td>
		                                            <select class="form-control" name="select[]">
		                                            	<option value="0"> <?php echo $arma['nome_setor']; ?> </option>
		                                            	<?php 
		                                            	$setDAO = new SetorDAO();
		                                            	$arraySet = $setDAO->Lista();
		                                            	foreach ($arraySet as $setDAO => $s){
		                                            		if ($s['nome_setor'] !== $arma['nome_setor']){
		                                            	?>
		                                            		<option value="<?php echo $s['id']; ?>"> <?php echo $s['nome_setor']; ?> </option>
		                                            	<?php } } ?>
		                                            </select>
	                                            </td>
	                                            
	                                            <td><input type="text" name="posicaoInstalada[]" value="<?php echo $arma['posicao_instalada']; ?>" class="form-control" /></td>
	                                            <td><input type="text" name="identificacao[]" value="<?php echo $arma['identificacao_extra']; ?>" class="form-control" /></td>
	                                            <td><input type="date" name="data[]" value="<?php echo $arma['data_instalacao']; ?>" class="form-control"/></td>
	                                        </tr>
	                                    <?php } ?>
	                                    </tbody>
	                                </table>
                                </form>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
        	</div>
        	<?php } } ?>
		</div>
		
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