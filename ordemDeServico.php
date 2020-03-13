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

    <title>Atender ordem de servico</title>

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
			case 'ordemDeServico' : $as = 15;   break ;
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
		//Tirar a ordem de servico da tela
		if (!empty($_GET['visivel'])){
			
			$id = $_GET['visivel'];
			$status = "C";
			
			$conDAO = new ContratoDAO();
			$ROST = $conDAO->RemoveOrdemServicoTela($status, $id);
			
			?><script type="text/javascript"> window.location="ordemDeServico.php"; </script><?php 
			
		}
		?>
        <div id="page-wrapper">
            <!-- /.row --><br><br>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Contratos para atender e atendidos
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nome contrato</th>
                                            <th>Dia da visita</th>
                                            <th>Status</th>
                                            <th>Atender</th>
                                            <th style="width: 130px;">Visivel Sim/Nao</th>
                                            <th style="width: 100px;">Relatorio</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	<?php 
	                                    if ($_SESSION['nivel'] === md5("Impar@2019$")){
	                                    $conDAO = new ContratoDAO();
	                                    $arrayContrato = $conDAO->ListaContratoParaAtenderAdm();
	                                    foreach ($arrayContrato as $conDAO => $c){
	                                    	if ($c['status'] === "atendido"){
	                                    ?>
	                                    	<tr class="success">
                                        <?php } else {?>
                                        	<tr class="danger">
                                        <?php } ?>
                                            <td><?php echo $c['nome_contrato']; ?></td>
                                            <td><?php echo $c['data']; ?></td>
                                            <td><?php echo $c['status']; ?></td>
                                            
                                            <?php if ($c['status'] === "aberto"){ ?>
                                            <td><a href="atender.php?idD=<?php echo $c['id']; ?>">Atender</a></td>
                                            <?php } else { ?>
                                            <td><a href="atender.php?idD=<?php echo $c['id']; ?>">Atendido</a></td>
                                            <?php } ?>
                                            
                                            <?php if ($c['visivel_para_ordem_servico'] === "S"){ ?>
                                            <td align="center"><a href="ordemDeServico.php?visivel=<?php echo $c['id']; ?>">X</a></td>
                                            <?php } else { ?>
                                            <td align="center">X</td>
                                            <?php } ?>
                                            <td align="center"> <a href="visualizarRelatorioOrdemServico.php?idOrd=<?php echo $c['id']; ?>"><i class="fa fa-file-o fa-fw"></i></a> </td>
                                        </tr>
                                        <?php } } else {?>
	                                    <?php 
	                                    //Pegar o id da session para lista os contrato por ele comprados
	                                    $conDAO = new ContratoDAO();
	                                    $arrayContrato = $conDAO->ListaContratoParaAtender();
	                                    foreach ($arrayContrato as $conDAO => $c){
	                                    	if ($c['status'] === "atendido"){
	                                    ?>
	                                    	<tr class="success">
                                        <?php } else {?>
                                        	<tr class="danger">
                                        <?php } ?>
                                            <td><?php echo $c['nome_contrato']; ?></td>
                                            <td><?php echo $c['data']; ?></td>
                                            <td><?php echo $c['status']; ?></td>
                                            
                                            <?php if ($c['status'] === "aberto"){ ?>
                                            <td><a href="atender.php?idD=<?php echo $c['id']; ?>">Atender</a></td>
                                            <?php } else { ?>
                                            <td><a href="atender.php?idD=<?php echo $c['id']; ?>">Atendido</a></td>
                                            <?php } ?>
                                            
                                            <?php if ($c['visivel_para_ordem_servico'] === "S"){ ?>
                                            <td align="center"><a href="ordemDeServico.php?visivel=<?php echo $c['id']; ?>">X</a></td>
                                            <?php } else { ?>
                                            <td align="center">X</td>
                                            <?php } ?>
                                            <td align="center"><a href="visualizarRelatorioOrdemServico.php?idOrd=<?php echo $c['id']; ?>"><i class="fa fa-file-o fa-fw"></i></a> </td>
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