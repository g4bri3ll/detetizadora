<?php 
session_start();

include_once 'Model/DAO/AcessoPaginasDAO.php';
include_once 'Model/Modelo/AcessoPaginas.php';
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Paginas para acessar o sistema</title>

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
			case 'criarAcessoSistema' : $as = 15;   break ;
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
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Acesso as paginas do sistema</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                
                <?php 
                if (!empty($_POST)){
                	
                	if (empty($_POST['nomeAcesso']) || empty($_POST['paginas'])){
                		?> <font size="3px" color="red"> Preencha todos os campos </font> <?php
                	} else {

                		
	                		$nomeAcesso = $_POST['nomeAcesso'];
	                		$idPaginas  = $_POST['paginas'];
	                		$status     = "ativado";
	                		
	                		//Verificar se este acesso ja existe
	                		$aceDAO = new AcessoPaginasDAO();
	                		$verAcesso = $aceDAO->VerificaAcessoPag($nomeAcesso);
	                		
	                		if (empty($verAcesso)){
	                			
	                			$acessoPagina = new AcessoPaginas();
		                		$acessoPagina->nome = $nomeAcesso;
		                		$acessoPagina->status = $status;
		                				
	                			//Cadastrar o nome do acesso a pagina
	                			$aceDAO = new AcessoPaginasDAO();
	                			$res = $aceDAO->cadastrar($acessoPagina);
	                			
	                			if ($res) {
	                				
	                				//Pegar o ultimo id da pagina para cadastrar 
	                				$aceDAO = new AcessoPaginasDAO();
	                				$ultimiID = $aceDAO->RetornaUltimoId();
	                				$idNomeAcesso = 0;
	                				foreach ($ultimiID as $aceDAO => $ace){
	                					$idNomeAcesso = $ace['id'];
	                				}
	                				
	                				
		                			for ($i = 0; $i < count($idPaginas); $i++){
		                				
		                				$acessoPagina = new AcessoPaginas();
		                				$acessoPagina->idPaginas = $idPaginas[$i];
		                				$acessoPagina->idPaginaAcesso = $idNomeAcesso;
		                				$acessoPagina->status = $status;
		                				
		                				//Cadastrar as paginas de acesso
		                				$aceDAO = new AcessoPaginasDAO();
		                				$result = $aceDAO->cadastrarAcessoPag($acessoPagina);
		                				
		                			}
		                			
		                			if ($result){
		                				?> <font size="3px" color="lime"> Nome do acesso cadastro com sucesso! </font> <?php
		                			}
		                			
	                			}
	                			
	                		} else {
	                			?> <font size="3px" color="red"> Possui um acesso com esse nome! </font> <?php
	                		}
	                		
                	}
                	
                }
                ?>
                
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Paginas de acesso
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        	<form action="" method="post" >
                        		
                        		<div class="form-group">
                        			<label>Informe o nome do acesso</label>
	                                <input class="form-control" placeholder="Nome do acesso" name="nomeAcesso">
	                            </div>
	                        	<table class="table table-striped table-bordered table-hover">
	                                <thead>
	                                    <tr>
	                                        <th>#</th>
	                                        <th>Nome da pagina</th>
	                                        <th>Status</th>
	                                    </tr>
	                                </thead>
	                                <?php 
	                                $aceDAO = new AcessoPaginasDAO();
	                                $arrayPaginas = $aceDAO->listaPaginas();
	                                foreach ($arrayPaginas as $aceDAO => $acesso){
	                                ?>
	                                <tbody>
	                                    <tr>
	                                        <td><input type="checkbox" name="paginas[]" value="<?php echo $acesso['id']; ?>"/></td>
	                                        <td><?php echo $acesso['nome']; ?></td>
	                                        <td><?php echo $acesso['status']; ?></td>
	                                    </tr>
	                            	</tbody>
	                            	<?php } ?>
	                            </table>
	                        	<!-- /.table-responsive -->
	                            <div class="well">
	                                <input type="submit" class="btn btn-default btn-lg btn-block" value="Cadastrar acesso" />
	                            </div>
                            </form>
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