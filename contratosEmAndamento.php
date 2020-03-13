<?php 
session_start();

include_once 'Model/DAO/ContratoDAO.php';
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Contratos em andamento</title>

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
			case 'contratosEmAndamento' : $as = 15;   break ;
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
            <!-- /.row --><br><br>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Contratos em andamento
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Nome contrato</th>
                                            <th>Data inicio</th>
                                            <th>Data final</th>
                                            <th>Status</th>
                                            <th>Detalhes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
	                                    <?php 
	                                    //Verificar se quem esta na session e um cliente
	                                    if (!empty($_SESSION['id_c'])){
		                                    //Pegar o id da session para lista os contrato por ele comprados
		                                    $idSession = $_SESSION['id_c'];
		                                    $conDAO = new ContratoDAO();
		                                    $arrayContrato = $conDAO->ListaContratoEmAndamento($idSession);
		                                    
		                                    //Lista contrato renovado do cliente
		                                    $conDAO = new ContratoDAO();
	                                    	$arrayContratoRenovado = $conDAO->ListContratoRenovadoEmAndamentoPeloCliente($idSession);
	                                    
		                                    foreach ($arrayContrato as $conDAO => $c){
	                                    	if (!empty($_GET['lista'])){
	                                    		if ($_GET['lista'] === $c['id']){
	                                    ?>
                                        <tr class="warning">
                                        <?php } } else { ?>
                                        <tr>
                                        <?php } ?>
                                            <td><?php echo $c['id']; ?></td>
                                            <td><?php echo $c['nome_contrato']; ?></td>
                                            <td><?php echo $c['data_inicio']; ?></td>
                                            <td><?php echo $c['data_final']; ?></td>
                                            <td><?php echo $c['status']; ?></td>
                                            <?php 
                                            if (!empty($_GET['lista'])){
                                            	if ($_GET['lista'] == $c['id']){ ?>
                                            <td><a href="contratosEmAndamento.php">Ocultar detalhes</a></td>
                                            <?php 
                                            	} else {
                                            		?> <td><a href="contratosEmAndamento.php?lista=<?php echo $c['id']; ?>">Mostra detalhes</a></td> <?php 
                                            	}
                                            } else {
                                            ?>
                                            <td><a href="contratosEmAndamento.php?lista=<?php echo $c['id']; ?>">Mostra detalhes</a></td>
                                            <?php } ?>
                                        </tr>
                                        <?php }
                                        if (!empty($arrayContratoRenovado)){
                                        	foreach ($arrayContratoRenovado as $conDAO => $cr){
                                        		if (!empty($_GET['listaRen'])){
	                                    			if ($_GET['listaRen'] === $cr['id']){
	                                    ?>
                                        <tr class="warning">
                                        <?php } } else { ?>
                                        <tr>
                                        <?php } ?>
                                            <td><?php echo $cr['id']; ?></td>
                                            <td><?php echo $cr['nome_contrato']; ?></td>
                                            <td><?php echo $cr['data_inicio']; ?></td>
                                            <td><?php echo $cr['data_final']; ?></td>
                                            <td><?php echo $cr['status']; ?></td>
                                            <?php 
                                            if (!empty($_GET['listaRen'])){
                                            	if ($_GET['listaRen'] == $cr['id']){ ?>
                                            <td><a href="contratosEmAndamento.php">Ocultar detalhes</a></td>
                                            <?php 
                                            	} else {
                                            		?> <td><a href="contratosEmAndamento.php?listaRen=<?php echo $cr['id']; ?>">Mostra detalhes</a></td> <?php 
                                            	}
                                            } else {
                                            ?>
                                            <td><a href="contratosEmAndamento.php?listaRen=<?php echo $cr['id']; ?>">Mostra detalhes</a></td>
                                            <?php } ?>
                                        </tr>
		                                <?php } } ?>
                                    </tbody>
                                    <?php } else if ($_SESSION['nivel'] == md5("Impar@2019$")) { ?>
                                    <tbody>
	                                    <?php 
	                                    //Pegar o id da session para lista os contrato por ele comprados
	                                    $conDAO = new ContratoDAO();
	                                    $arrayContrato = $conDAO->NivelListaContratoEmAndamento();
	                                    
	                                    $conDAO = new ContratoDAO();
	                                    $arrayContratoRenovado = $conDAO->ListContratoRenovadoEmAndamento();
	                                    
	                                    foreach ($arrayContrato as $conDAO => $c){
	                                    	if (!empty($_GET['lista'])){
	                                    		if ($_GET['lista'] === $c['id']){
	                                    ?>
                                        <tr class="warning">
                                        <?php } } else { ?>
                                        <tr>
                                        <?php } ?>
                                            <td><?php echo $c['id']; ?></td>
                                            <td><?php echo $c['nome_contrato']; ?></td>
                                            <td><?php echo $c['data_inicio']; ?></td>
                                            <td><?php echo $c['data_final']; ?></td>
                                            <td><?php echo $c['status']; ?></td>
                                            <?php if (!empty($_GET['lista'])){ if ($_GET['lista'] === $c['id']){ ?>
                                            <td><a href="contratosEmAndamento.php">Ocultar detalhes</a></td>
                                            <?php }  else { 
                                            	?><td><a href="contratosEmAndamento.php?lista=<?php echo $c['id']; ?>">Mostra detalhes</a></td><?php
                                            } } else { ?>
                                            <td><a href="contratosEmAndamento.php?lista=<?php echo $c['id']; ?>">Mostra detalhes</a></td>
                                            <?php } ?>
                                        </tr>
                                        <?php }
                                        if (!empty($arrayContratoRenovado)){
                                        	foreach ($arrayContratoRenovado as $conDAO => $cr){ 
                                        		if (!empty($_GET['listaRen'])){
                                        			if ($_GET['listaRen'] === $cr['id']){
	                                    ?>
                                        <tr class="warning">
                                        <?php } } else { ?>
                                        <tr>
                                        <?php } ?>
                                            <td><?php echo $cr['id']; ?></td>
                                            <td><?php echo $cr['nome_contrato']; ?></td>
                                            <td><?php echo $cr['data_inicio']; ?></td>
                                            <td><?php echo $cr['data_final']; ?></td>
                                            <td><?php echo $cr['status']; ?></td>
                                            <?php if (!empty($_GET['listaRen'])){ if ($_GET['listaRen'] === $cr['id']){ ?>
                                            <td><a href="contratosEmAndamento.php">Ocultar detalhes</a></td>
                                            <?php }  else { 
                                            	?><td><a href="contratosEmAndamento.php?listaRen=<?php echo $cr['id']; ?>">Mostra detalhes</a></td><?php
                                            } } else { ?>
                                            <td><a href="contratosEmAndamento.php?listaRen=<?php echo $cr['id']; ?>">Mostra detalhes</a></td>
                                            <?php } ?>
                                        </tr>
                                        <?php } } ?>
                                    </tbody>
                                    <?php } ?>
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
            
            <?php 
            if (!empty($_GET['lista']) || !empty($_GET['listaRen'])){
            	
            	if (!empty($_GET['lista'])){
            		
            		$idContrato = $_GET['lista'];
            		$conDAO = new ContratoDAO();
	            	$arrayDetContrato = $conDAO->ListaDetalhesContrato($idContrato);
	            
            	} else if (!empty($_GET['listaRen'])){
            		
            		$idContratoRenovado = $_GET['listaRen'];
            		$conDAO = new ContratoDAO();
	            	$arrayDetContrato = $conDAO->ListaDetalhesContratoRenovado($idContratoRenovado);
	            
            	}
            	
	            if (!empty($arrayDetContrato)){
            ?>
            <!-- /Comeca outra row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Detalhes do contrato
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Codigo</th>
                                            <th>Nome contrato</th>
                                            <th>Nome do servico</th>
                                            <th>Dia da visita</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
	                                    <?php 
	                                    foreach ($arrayDetContrato as $conDAO => $c){
	                                    	if ($c['status'] == "aberto") {
	                                    ?>
                                        <tr class="danger">
                                            <td><?php echo $c['id']; ?></td>
                                            <td><?php echo $c['nome_contrato']; ?></td>
                                            <td><?php echo $c['nome_servico']; ?></td>
                                            <td><?php echo $c['data']; ?></td>
                                            <td><?php echo $c['status']; ?></td>
                                        </tr>
                                        <?php } else if ($c['status'] == "fechado pelo sistema") { ?>
                                        <tr class="info">
                                            <td><?php echo $c['id']; ?></td>
                                            <td><?php echo $c['nome_contrato']; ?></td>
                                            <td><?php echo $c['nome_servico']; ?></td>
                                            <td><?php echo $c['data']; ?></td>
                                            <td><?php echo $c['status']; ?></td>
                                        </tr>	
                                        <?php } else if ($c['status'] == "atendido") { ?>
                                        <tr class="success">
                                            <td><?php echo $c['id']; ?></td>
                                            <td><?php echo $c['nome_contrato']; ?></td>
                                            <td><?php echo $c['nome_servico']; ?></td>
                                            <td><?php echo $c['data']; ?></td>
                                            <td><?php echo $c['status']; ?></td>
                                        </tr>	
                                        <?php } else if ($c['status'] == "ordem de servico configurado") { ?>
                                        <tr class="warning">
                                            <td><?php echo $c['id']; ?></td>
                                            <td><?php echo $c['nome_contrato']; ?></td>
                                            <td><?php echo $c['nome_servico']; ?></td>
                                            <td><?php echo $c['data']; ?></td>
                                            <td><?php echo $c['status']; ?></td>
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
            
            <?php 
            	}
            }
            ?>
            
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