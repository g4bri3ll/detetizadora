<?php 
session_start();

include_once 'Model/DAO/ContratoDAO.php';
include_once 'Model/DAO/ClienteDAO.php';
include_once 'Model/DAO/TipoServicoDAO.php';
include_once 'Model/Modelo/Contrato.php';
include_once 'Model/DAO/UsuarioDAO.php';

//Pegar o id do contrato para lista
$idContrato = $_SESSION['idContratoSession'];

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

    <title>Dias do contrato do cliente</title>

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

<?php 
if (!empty($_SESSION)){
	foreach ($_SESSION['nome_paginas'] as $key) {
		switch ($key) {
			case 'calendario' : $as = 15;   break ;
		}
	}	
	if (!empty($as) || $_SESSION['nivel'] === md5("Impar@2019$")){ 
?>

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
		
        <?php 
        //fechar o contrato
        if (!empty($_GET['fecha'])){
        	
        	if ($_GET['fecha'] == "finaliza"){
        		
        		$status = "em andamento";
        		
        		$conDAO = new ContratoDAO();
        		$result = $conDAO->FechaContrato($status, $idContrato);
        		
	        	if ($result){
	        		unset( $_SESSION['idContratoSession'] );
	        		unset( $_SESSION['tipo_servico'] );
	        		unset( $_SESSION['objeto'] );
	        		unset( $_SESSION['tipo_objeto'] );
	        		unset( $_SESSION['funcionario'] );
					?> <script type="text/javascript"> alert('Contrato cadastrado com sucesso!'); window.location="index.php";  </script> <?php
				} else {
					?> <div class="alert alert-error"> <font size="3px" color="red"> Erro ao fecha contrato: <?php print_r($result); ?> </font> </div> <?php
				}
	        		
        	}
        	
        }
        ?>
        
        <?php 
        if (!empty($_GET['destroy'])) {
        	
        	$valor = $_GET['destroy'];
        	
        	if($valor == "ts"){
        		unset( $_SESSION['tipo_servico'] );
        		?> <script type="text/javascript"> window.location="calendario.php";  </script> <?php
        	} else if($valor == "o"){
        		unset( $_SESSION['objeto'] );
        		?> <script type="text/javascript"> window.location="calendario.php";  </script> <?php
        	} else if($valor == "to"){
        		unset( $_SESSION['tipo_objeto'] );
        		?> <script type="text/javascript"> window.location="calendario.php";  </script> <?php
        	} else if($valor == "f"){
        		unset( $_SESSION['funcionario'] );
        		?> <script type="text/javascript"> window.location="calendario.php";  </script> <?php
        	}
        	
        }
        ?>
        
        
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                	
                	<?php 
                	//Excluir o dia do contrato
                	if (!empty($_GET['excluir'])){
                		
                		$idDia = $_GET['excluir'];
                		$status = "cancelado";
                		
                		$conDAO = new ContratoDAO();
                		$result = $conDAO->CancelaDiaContrato($status, $idDia);
                		
                		if ($result){
                			?>
                			<script type="text/javascript"> alert('Dia da visita excluido com sucesso!'); window.location="calendario.php"; </script>
                			<?php
                		} else {
                			?>
                			<script type="text/javascript"> window.location="calendario.php"; </script> 
                			<br><br>
                			<div class="alert alert-danger alert-dismissable">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                Erro ao cancelar o dia: <?php echo print_r($result); ?>
                            </div> 
                			<?php
                		}
                		
                	}
                	?>
                	
                   <?php
                   if (!empty($_POST)){
                   	
						if (empty($_POST['data'])){
							?> <div class="alert alert-error"> <font size="3px" color="#111"> Preencha todos os campos </font> </div> <?php
						} else {
							
							$data  = $_POST['data'];
							
							//Verificar se a data do contrato e maior do que a data da visita
							$conDAO = new ContratoDAO();
							$verificaCadData = $conDAO->VerificarCadContratoData($data, $idContrato);
							
							if (empty($verificaCadData)){
							
								//Pegar os dados para manter na session
								//Tipo servico
								if (!empty($_POST['manterTipoServico'])) {
									$_SESSION['tipo_servico'] = $_POST['idTipoServicos'];
									$idTipoSer = $_POST['idTipoServicos'];
								} else if (!empty($_SESSION['tipo_servico'])) {
									$idTipoSer = $_SESSION['tipo_servico'];
								} else {
									$idTipoSer = $_POST['idTipoServicos'];
								}
								//Objetos
								if (!empty($_POST['manterObjeto'])){
									$_SESSION['objeto'] = $_POST['idObjetosServicos'];
									$idObjeto = $_POST['idObjetosServicos'];
								} else if (!empty($_SESSION['objeto'])){ 
									$idObjeto = $_SESSION['objeto'];
								} else {
									$idObjeto = $_POST['idObjetosServicos'];
								}
								//Tipo de objeto
								if (!empty($_POST['manterTipoObjeto'])){
									$_SESSION['tipo_objeto'] = $_POST['idTiposObjetos'];
									$idTipoObjet = $_POST['idTiposObjetos'];
								} else if (!empty($_SESSION['tipo_objeto'])){ 
									$idTipoObjet = $_SESSION['tipo_objeto'];
								} else {
									$idTipoObjet = $_POST['idTiposObjetos'];
								}
								//Funcionario
								if (!empty($_POST['manterFuncionario'])){
									$_SESSION['funcionario'] = $_POST['idUsuario'];
									$idUsuario = $_POST['idUsuario'];
								} else if (!empty($_SESSION['funcionario'])){ 
									$idUsuario = $_SESSION['funcionario'];
								} else {
									$idUsuario = $_POST['idUsuario'];
								}
								
								//Pegar os dados do post
								$diaContrato  = $_POST['data'];
								
								
								//Finalizar o dia do contrato
								if (!empty($_GET['acao'])){ $finaliza = $_GET['acao']; } else {$finaliza = null; }
								
								if (empty($finaliza)){
									
									$conDAO = new ContratoDAO();
									$arrayVerificar = $conDAO->VerificaDataContrato($diaContrato, $idContrato);
											
									if (empty($arrayVerificar)){
										
										$dataContra = new Contrato();
										$dataContra->id = $idContrato;
										$dataContra->status = "aberto";
										$dataContra->idTipoServico = $idTipoSer;
										$dataContra->idObjeto = $idObjeto;
										$dataContra->idTipoObjeto = $idTipoObjet;
										$dataContra->diaContrato = $diaContrato;
										$dataContra->idFuncionario = $idUsuario;
										
										$conDAO = new ContratoDAO();
										$result = $conDAO->CadastraData($dataContra);
										
										if ($result){
											?> <br><br><font size="3px" color="lime"> Dia da visitada, cadatrado com sucesso! </font> <?php
										} else {
											?> <br><br><font size="3px" color="red"> Erro causa possivel <?php echo print_r($result); ?> </font> <?php
										}
										
									} else {
										?> <br><br><font size="3px" color="red"> Essa data para este contrato ja foi cadastrado </font> <?php
									}
									
								} else {
									?> <script type="text/javascript"> alert('Datas do contrato cadastrado com sucesso!');  window.location="index.php"; </script> <?php
								}
								
							} else {
								?> <br><br><font size="3px" color="red"> Nao e possivel cadastrar um valor maior que a data final do contrato </font> <?php
							}
							
						}
						
					}
					?>
                    <h1 class="page-header">Contrato do cliente</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3>Complemento do contrato</h3>
                            <div class="row show-grid">
                            	<form action="" method="post">
                            		<div class="row show-grid">
		                                <div class="col-md-3">Manter tipo servico</div>
		                                <div class="col-md-3">Manter objeto</div>
		                                <div class="col-md-3">Manter tipo objeto</div>
		                                <div class="col-md-3">Manter funcionario</div>
		                            </div>
		                            <div class="row show-grid">
		                            	<?php if (empty($_SESSION['tipo_servico'])){ ?>
		                                	<div class="col-md-3"><input type="checkbox" name="manterTipoServico" /></div>
		                                <?php } else { ?>
		                                	<div class="col-md-3"><p><?php echo $_SESSION['tipo_servico']; ?></p><a href="calendario.php?destroy=ts"><i class="fa fa-times fa-fw"></i></a></div>
		                                <?php } if (empty($_SESSION['objeto'])){ ?>
		                                <div class="col-md-3"><input type="checkbox" name="manterObjeto" /></div>
		                                <?php } else { ?>
		                                	<div class="col-md-3"><p><?php echo $_SESSION['objeto']; ?></p><a href="calendario.php?destroy=o"><i class="fa fa-times fa-fw"></i></a></div>
		                                <?php } if (empty($_SESSION['tipo_objeto'])){ ?>
		                                <div class="col-md-3"><input type="checkbox" name="manterTipoObjeto" /></div>
		                                <?php } else { ?>
		                                	<div class="col-md-3"><p><?php echo $_SESSION['tipo_objeto']; ?></p><a href="calendario.php?destroy=to"><i class="fa fa-times fa-fw"></i></a></div>
		                                <?php } if (empty($_SESSION['funcionario'])){ ?>
		                                <div class="col-md-3"><input type="checkbox" name="manterFuncionario" /></div>
		                                <?php } else { ?>
		                                	<div class="col-md-3"><p><?php echo $_SESSION['funcionario']; ?></p><a href="calendario.php?destroy=f"><i class="fa fa-times fa-fw"></i></a></div>
		                                <?php } ?>
		                            </div>
		                            <?php if (empty($_SESSION['tipo_servico'])){ ?>
                            		<div class="form-group">
                                        <label for="disabledSelect">Tipo de servicos</label>
                                        <select id="" class="form-control" name="idTipoServicos">
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
                                     <?php } if (empty($_SESSION['objeto'])){ ?>
                                     <div class="form-group">
                                        <label for="disabledSelect">Objetos do servicos</label>
                                        <select id="" class="form-control" name="idObjetosServicos">
                                          <option value="0"></option>
                                          <?php 
                                          $tipDAO = new TipoServicoDAO();
                                          $arrayTip = $tipDAO->ListaTodosObjetos();
                                          foreach ($arrayTip as $tipDAO => $objet){
                                          ?>
                                          <option value="<?php echo $objet['id']; ?>"><?php echo $objet['nome']; ?></option>
                                          <?php } ?>	
                                        </select>
                                     </div>
                                     <?php } if (empty($_SESSION['tipo_objeto'])){ ?>
                                     <div class="form-group">
                                        <label for="disabledSelect">Tipo do objeto</label>
                                        <select id="" class="form-control" name="idTiposObjetos">
                                           <option value="0"></option>
                                           <?php 
                                           $tipDAO = new TipoServicoDAO();
                                           $arrayTip = $tipDAO->ListaTodosTipoObjetos();
                                           foreach ($arrayTip as $tipDAO => $tipoObjet){
                                           ?>
                                           <option value="<?php echo $tipoObjet['id']; ?>"><?php echo $tipoObjet['nome']; ?></option>
                                           <?php } ?>	
                                        </select>
                                     </div>
                                     <?php } if (empty($_SESSION['funcionario'])){ ?>
                                     <div class="form-group">
                                        <label for="disabledSelect">Informe o funcionario que realizar a etapa</label>
                                        <select id="" class="form-control" name="idUsuario">
                                           <option value="0"></option>
                                           <?php 
                                           $usuDAO = new UsuarioDAO();
                                           $arrayUsu = $usuDAO->listaUsuario();
                                           foreach ($arrayUsu as $usuDAO => $usuario){
                                           ?>
                                           <option value="<?php echo $usuario['id']; ?>"><?php echo $usuario['nome']; ?></option>
                                           <?php } ?>	
                                        </select>
                                     </div>
                                     <?php } ?>
	                                <div class="form-group">
                                        <label>Informe o dia da visita</label>
                                        <input type="date" class="form-control" name="data">
                                    </div><br>
                                    <button type="submit" class="btn btn-default">Salvar</button>
                                    <button type="reset" class="btn btn-default">Reset</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /Row -->
            
            <?php 
            $conDAO = new ContratoDAO();
	        $arrayContrato = $conDAO->ListaContratoPeloId($idContrato);
	        if (!empty($arrayContrato)){
            ?>
            
            <a href="calendario.php?fecha=finaliza" class="btn btn-outline btn-primary btn-lg btn-block">Finalizar contrato</a><br>
            
            <!-- row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Dias do contrato
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Codigo</th>
		                            		<th>Contratante</th>
											<th>Funcionario</th>
		                            		<th>Data Final Contrato</th>
		                            		<th>Dia do servico</th>
		                            		<th>Tipo servico</th>
		                            		<th>Excluir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($arrayContrato as $conDAO => $valor){ ?>
		                            	<tr align="center">
		                            		<td><?php echo  $valor['id']; ?></td>
		                            		<td><?php echo  $valor['nome']; ?></td>
		                            		<td><?php echo  $valor['nome_func']; ?></td>
		                            		<td><?php echo  date('d/m/Y', strtotime($valor['data_final'])); ?></td>
		                            		<td><?php echo  date('d/m/Y', strtotime($valor['data_contrato'])); ?></td>
		                            		<td><?php echo  $valor['nome_servico']; ?></td>
		                            		<td><a href="calendario.php?excluir=<?php echo $valor['id']; ?>"><i class="glyphicon glyphicon-trash"></i></a></td>
		                            	</tr> <?php } ?> 
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /row -->
            
            <?php } ?>
            
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

<?php 
	} else {
		header("Location: index.php");
	} 
} //Fecha a session que verifica se esta vazio 
?>

</body>
</html>