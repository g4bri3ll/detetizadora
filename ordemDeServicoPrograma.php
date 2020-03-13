<?php 
session_start();

include_once 'Model/DAO/ContratoDAO.php';
include_once 'Model/DAO/SetorDAO.php';

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

    <title>Ordem de servico para programa</title>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

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
			case 'ordemDeServicoPrograma' : $as = 15;   break ;
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
        <div id="page-wrapper">
        
        <?php 
        //Colocar os valores na session para cadastrar tudo
        if (!empty($_POST)){
        	
        	
        	//Verificar se tipoServico esta vazio na session para lista 
        	if (empty($_SESSION['tipoServico'])){
	        	$_SESSION['tipoServico']   = $_POST['tipoServico'];
	        	$_SESSION['idDiaContrato'] = $_GET['idDiaContrato'];
        	} 
        	
        	//Verificar se pragasAlvo esta na session para lista
        	else if (empty($_SESSION['pragasAlvo'])){
        		$_SESSION['pragasAlvo'] = $_POST['pragasAlvo'];
        	}
        	 
        	//Gravar os valores no banco de dados
        	else if (!empty($_GET['p'])){
        		
        		$produtos = $_POST['produtos'];
        		$tipoSer  = $_SESSION['tipoServico'];
        		$idDiaCon = $_SESSION['idDiaContrato'];
        		$pragas   = $_SESSION['pragasAlvo'];
        		$setores  = $_POST['setores'];
        		$status   = "cadastrado";
        		$data     = date('Y-m-d');
        		
        		//Cadastrar a ordem de servico para programa
        		$conDAO = new ContratoDAO();
        		$result = $conDAO->CadastrarOrdemServicoPrograma($produtos, $tipoSer, $idDiaCon, $pragas, $status, $setores);
        		
        		if ($result){
        			
        			//muda o status do dia de visita do usuario
        			$status = "configurando a ordem de servico para programa";
		        	//Modificar o status do dia do contrato para parcelado
		        	$conDAO = new ContratoDAO();
		        	$conDAO->ConfigurarDiaContratoOrdemServico($status, $idDiaCon);
		        	
					?> <br><br><font size="3px" color="lime"> Dados cadastrado com sucesso! </font><br><br> <?php
				} else {
					?> <br><br><font size="3px" color="#111"> Ocorreu um erro: <?php print_r($result); ?> </font><br><br> <?php
				}
				
        	}
        	
        }
        
        //Finalizar a colocação dos produtos no tipo de servico
        if (!empty($_GET['finalizar'])){
        	
        	
        	$idDiaCon = $_SESSION['idDiaContrato'];
        	$status = "ordem de servico configurado";
        	//Modificar o status do dia do contrato para parcelado
        	$conDAO = new ContratoDAO();
        	$conDAO->FechaStatusOrdemServico($status, $idDiaCon);
        	
        	
        	//Matar os dados da session
            unset( $_SESSION['tipoServico'] );
            unset( $_SESSION['idDiaContrato'] );
            unset( $_SESSION['pragasAlvo'] );
            
            
        	?> <script type="text/javascript"> window.location="ordemDeServicoPrograma.php";</script> <?php
        }
        
        //Se a session estiver vazia dos valores acima ele deixar limpo e lista isso
		if (empty($_GET['idD']) && empty($_SESSION['tipoServico'])){ ?>
        
            <!-- /.row --><br><br>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Contratos em abertos
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Nome contrato</th>
                                            <th>Dia da visita</th>
                                            <th>Status</th>
                                            <th>Atender</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php 
	                                    if ($_SESSION['nivel'] === md5("Impar@2019$")){
	                                    $conDAO = new ContratoDAO();
	                                    $arrayContrato = $conDAO->ListaContratoParaAtenderAdm();
	                                    foreach ($arrayContrato as $conDAO => $c){
	                                    ?>
                                        <tr>
                                            <td><?php echo $c['id']; ?></td>
                                            <td><?php echo $c['nome_contrato']; ?></td>
                                            <td><?php echo $c['data']; ?></td>
                                            <td><?php echo $c['status']; ?></td>
                                            <td><a href="ordemDeServicoPrograma.php?idD=<?php echo $c['id']; ?>">Atender</a></td>
                                        </tr>
                                        <?php } } else {?>
	                                    <?php 
	                                    //Pegar o id da session para lista os contrato por ele comprados
	                                    $idSession = $_SESSION['id_f'];
	                                    $conDAO = new ContratoDAO();
	                                    $arrayContrato = $conDAO->ListaContratoParaAtender($idSession);
	                                    foreach ($arrayContrato as $conDAO => $c){
	                                    ?>
                                        <tr>
                                            <td><?php echo $c['id']; ?></td>
                                            <td><?php echo $c['nome_contrato']; ?></td>
                                            <td><?php echo $c['data']; ?></td>
                                            <td><?php echo $c['status']; ?></td>
                                            <td><a href="ordemDeServicoPrograma.php?idD=<?php echo $c['id']; ?>">Atender</a></td>
                                        </tr>
                                        <?php } } ?>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
            
            <?php } else if (!empty($_GET['idD'])) {
            	$idDtContrato = $_GET['idD'];
            ?>
            		<div class="row">
		                <div class="col-lg-12">
		                    <div class="panel panel-default">
		                        <div class="panel-heading">
		                            Ordem de servico para programa
		                        </div>
		                        <div class="panel-body">
		                            <div class="row">
		                            	<div class="col-lg-1"></div>
		                                <div class="col-lg-10">
		                                    <form role="form" action="ordemDeServicoPrograma.php?idDiaContrato=<?php echo $idDtContrato; ?>" method="post">
		                                        <div class="form-group">
		                                            <label>Informe o tipo de servico</label>
		                                            <input class="form-control" placeholder="Tipo de servico" name="tipoServico">
		                                        </div>
		                                        <button type="submit" class="btn btn-default">Escolha</button>
		                                        <a href="ordemDeServicoPrograma.php" class="btn btn-default">Retorna</a>
		                                 </form>
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
            		<?php } else if (!empty($_SESSION['tipoServico']) && empty($_SESSION['pragasAlvo'])){
            			//Matar esse unico dado da session
            			//unset( $_SESSION['idSetorRelatorio'] );
            		?>
            		
            		<div class="row">
		                <div class="col-lg-12">
		                    <div class="panel panel-default">
		                        <div class="panel-heading">
		                            Ordem de servico para programa
		                        </div>
		                        <div class="panel-body">
		                            <div class="row">
		                            	<div class="col-lg-1"></div>
		                                <div class="col-lg-10">
		                                    <form role="form" action="" method="post">
		                                        <div class="form-group">
		                                            <label>Informe as pragas alvo para o tipo de servico informado</label>
		                                            <input class="form-control" placeholder="Pragas alvo" name="pragasAlvo">
		                                        </div>
		                                        <button type="submit" class="btn btn-default">Escolha</button>
		                                    </form>
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
            
            
            <?php } else if (!empty($_SESSION['pragasAlvo'])){ ?>
            
           			 <div class="row">
		                <div class="col-lg-12">
		                    <div class="panel panel-default">
		                        <div class="panel-heading">
		                            Ordem de servico para programa
		                        </div>
		                        <div class="panel-body">
		                            <div class="row">
		                            	<div class="col-lg-1"></div>
		                                <div class="col-lg-10">
		                                    <form role="form" action="ordemDeServicoPrograma.php?p=valor" method="post">
		                                        <div class="form-group">
		                                            <label>Informe os produtos que serao aplicado nas areas</label>
		                                            <input class="form-control" placeholder="Produtos aplicados" name="produtos">
		                                        </div>
		                                        <div class="form-group">
		                                            <label>Informe os setores da aplicacao por virgulas</label>
		                                            <input class="form-control" placeholder="Setores da aplicados" name="setores">
		                                        </div>
		                                        <button type="submit" class="btn btn-default">Adiciona</button>
		                                        <a href="ordemDeServicoPrograma.php?finalizar=cad" class="btn btn-default">Finaliza</a>
		                                    </form>
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
            
            <?php } ?>
            
            <?php 
            if (!empty($_SESSION['idDiaContrato'])){ 
            	
            	$idDiaCon = $_SESSION['idDiaContrato']; 
	            //Lista todos os produtos e setores adiconado para listagem
	            $conDAO = new ContratoDAO();
	            $arrayCon = $conDAO->ListaSetoresAplicacao($idDiaCon);
	            if (!empty($arrayCon)){
            ?>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Produtos que seram adicionados e suas areas
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Cod</th>
                                            <th>Tipo servico</th>
                                            <th>Pragas alvo</th>
                                            <th>Produtos Aplicados</th>
                                            <th>Setores</th>
                                            <th>status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($arrayCon as $conDAO => $valor){ ?>
                                        <tr>
                                            <td><?php echo $valor['id']; ?></td>
                                            <td><?php echo $valor['tipo_servico']; ?></td>
                                            <td><?php echo $valor['praga_alvo']; ?></td>
                                            <td><?php echo $valor['produto']; ?></td>
                                            <td><?php echo $valor['setor']; ?></td>
                                            <td><?php echo $valor['status']; ?></td>
                                        </tr>
                                        <?php } ?>
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
            <!-- /.row -->
            
            <?php } } ?>
            
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

    <!-- DataTables JavaScript -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    </script>

<?php 
	} else {
		header("Location: index.php");
	} 
} //Fecha a session que verifica se esta vazio 
?>

</body>
</html>