<?php 
session_start();

include_once 'Model/DAO/ContratoDAO.php';
include_once 'Model/DAO/EmpresaDAO.php';

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

    <title>Assina contratos</title>

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
			case 'assinaContratos' : $as = 15;   break ;
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
		//Verificar se quem esta na session e um cliente, para lista os contrato para ele assina
		if (!empty($_SESSION['id_c'])){
		
			//Cadastrar a assinatura do contrato
			if (!empty($_GET['idContratoC'])){
				
				$idContrato = $_GET['idContratoC'];
				$idCliente = $_SESSION['id_c'];
				$status = "assinado";
				$dataAssinada = date('Y-m-d');
				
				//Verificar contrato ja assinado
				$conDAO = new ContratoDAO();
				$verifica = $conDAO->VerificaContratoAssinadoC($idContrato, $idCliente, $status);
				
				if (empty($verifica)){
					
					$conDAO = new ContratoDAO();
					$result = $conDAO->AssinaContratoCliente($status, $idContrato, $dataAssinada, $idCliente);
					
					if ($result){
						?>  <script type="text/javascript"> alert('Contrato assinado com sucesso!'); window.location="index.php"; </script>  <?php
					} else {
					?>
					<div class="alert alert-danger alert-dismissable">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						Nao foi possivel assinar o contrato!
					</div> 
					<?php
					}
					
				} else {
					?> <script type="text/javascript"> window.location="index.php"; </script>  <?php
				}
			
			}
		?>
		
        <div id="page-wrapper">
            <!-- /.row --><br><br>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Assina Contratos
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Nome contrato</th>
                                            <th>Assina</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
	                                    <?php 
	                                    //Pegar o id da session para lista os contrato por ele comprados
	                                    $idSession = $_SESSION['id_c'];
	                                    $conDAO = new ContratoDAO();
	                                    $arrayContrato = $conDAO->ListaContratoSemAssinaturaCliente($idSession);
	                                    foreach ($arrayContrato as $conDAO => $c){
	                                    ?>
                                        <tr>
                                            <td><?php echo $c['id']; ?></td>
                                            <td><?php echo $c['nome_contrato']; ?></td>
                                            <td><a href="assinaContratos.php?idContratoC=<?php echo $c['id']; ?>">Assina</a></td>
                                            <?php if (empty($c['status_c'])){ ?>
                                            <td><?php echo "Contrato sem assinatura";?></td>
                                            <?php } else { ?>
                                            <td><?php echo $c['status_c']; ?></td>
                                            <?php } ?>
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
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
        
        <?php 
		} //fecha o if que verifica se e um cliente que esta na session
		//Lista a parte do dono da empresa para assina
        else {
         
        	$idFunc = $_SESSION['id_f'];
        	
        	//Verificar se quem esta na session e o dono da empresa
        	$empDAO = new EmpresaDAO();
        	$verifica = $empDAO->VerificaLoginEmpresa($idFunc);
        	
        	if (!empty($verifica) || $_SESSION['nivel'] === md5("Impar@2019$")){ 
        	
				//Cadastrar a assinatura do contrato
				if (!empty($_GET['idContratoF'])){
					
					$idContrato = $_GET['idContratoF'];
					$status = "assinado";
					$dataAssinada = date('Y-m-d');
					
					//Verificar contrato ja assinado
					$conDAO = new ContratoDAO();
					$verifica = $conDAO->VerificaContratoAssinadoF($idContrato, $idFunc, $status);
					
					if (empty($verifica)){
						
						$conDAO = new ContratoDAO();
						$result = $conDAO->AssinaContratoFuncionario($status, $idContrato, $dataAssinada, $idFunc);
						
						if ($result){
							?> <script type="text/javascript"> alert(' Contrato assinado com sucesso!'); window.location="index.php";  </script> <?php
						} else {
						?>
						<div class="alert alert-danger alert-dismissable">
							<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
							Nao foi possivel assinar o contrato!
						</div> 
						<?php
						}
						
					} else {
						?> <script type="text/javascript"> window.location="assinaContratos.php"; </script>  <?php
					}
				
				}
		?>
		
        <div id="page-wrapper">
            <!-- /.row --><br><br>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Assina Contratos
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Nome contrato</th>
                                            <th>Assina</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
	                                    <?php 
	                                    //Lista o contrato para o dono da empresa assinar
	                                    $idF = $_SESSION['id_f'];
	                                    $conDAO = new ContratoDAO();
	                                    $arrayContrato = $conDAO->ListaContratoSemAssinatura();
	                                    foreach ($arrayContrato as $conDAO => $f){
	                                    ?>
                                        <tr>
                                            <td><?php echo $f['id']; ?></td>
                                            <td><?php echo $f['nome_contrato']; ?></td>
                                            <td><a href="assinaContratos.php?idContratoF=<?php echo $f['id']; ?>">Assina</a></td>
                                            <?php if (empty($f['status_f'])){ ?>
                                            <td><?php echo "Contrato sem assinatura";?></td>
                                            <?php } else { ?>
                                            <td><?php echo $f['status_f']; ?></td>
                                            <?php } ?>
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
                <!-- /.col-lg-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
        	
        <?php 
        	} //fecha o if que verificar se o dono da empresa esta logado na session
        } //fecha o if que verifica se quem esta na session e um funcionario da empresa
		} //Fecha a session que verifica se esta vazio ou não
        ?>

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