<?php 
session_start();

include_once 'Model/DAO/TipoServicoDAO.php';
include_once 'Model/DAO/ControlePragasDAO.php';
include_once 'Model/DAO/PragasDAO.php';
include_once 'Model/Modelo/ControleDePragas.php';
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

    <title>Controle de pragas</title>

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
			case 'controleDePragas' : $as = 15;   break ;
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
                
                <?php
				if (!empty($_POST)){
				
					if (empty($_POST['qtd']) || empty($_POST['descricao']) || empty($_POST['idPragas']) || empty($_POST['idContrato']) || 
						empty($_POST['idSetor'])){
						?> <br><br><div class="alert alert-danger"> Preencha todos os campos </div> <?php
					} else {
						
						//Pegar os dados do post
						$idSetor    = $_POST['idSetor'];
						$idContrato = $_POST['idContrato'];
						$qtd        = $_POST['qtd'];
						$descricao  = $_POST['descricao'];
						$idPragas   = $_POST['idPragas']; 
						$status     = "pendente de resposta";
						$data       = date('Y-m-d H:i:s');
						$idCliente  = $_SESSION['id_c'];
						//Pegar somente o mes para verificar se ja foi feito o cadastro esse mes dessa praga
						$mes        = date('m');
						//Verificar se ja existe um cadastro com esse usuario
						$conDAO = new ControlePragasDAO();
						$arrayVerificar = $conDAO->VerificarCadPelaData($idPragas, $status, $idCliente, $idContrato);
						
						if (empty($arrayVerificar)){
							
							//Verificar se esta praga ja foi cadastrar a quantidade no mes
							$conDAO = new ControlePragasDAO();
							$verificaMes = $conDAO->VerificarCadPeloMes($mes, $idPragas, $status, $idCliente, $idContrato);
							
							if (empty($verificaMes)){
							
								$controle = new ControleDePragas();
								$controle->idSetor = $idSetor;
								$controle->idContrato = $idContrato;
								$controle->qtdPragas = $qtd;
								$controle->descricaoCliente = $descricao;
								$controle->idPragas = $idPragas;
								$controle->status = $status;
								$controle->dataCliente = $data;
								$controle->idClientes = $idCliente;
								
								$conDAO = new ControlePragasDAO();
								$result = $conDAO->CadastrarControlerC($controle);
									
								if ($result){
									?> <br><br><div class="alert alert-success"> Controle de pragas registrado com sucesso! </div> <?php
								} else {
									?> <br><br><div class="alert alert-danger"> Ocorreu um erro: <?php print_r($result); ?> </div> <?php
								}
								
							} else {
								?> <br><br><div class="alert alert-danger"> Ja foi feito o cadastrar de quantidade de praga no mes <?php echo $mes; ?> </div> <?php
							} 
							
						} else {
							?> <br><br><div class="alert alert-danger"> Ja existe um registro com esse tipo de praga </div> <?php
						} 
						
					} 
					
				}
				?>
                
                    <h1 class="page-header">Controle de pragas</h1>
                    
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Pragas
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                    <div class="col-lg-1"></div>
	                                <div class="col-lg-10">
	                                    <form role="form" action="" method="post">
	                                    <br><br>
	                                    	<div class="form-group">
	                                           <label for="disabledSelect">Seleciona o contrato</label>
	                                           <select id="" class="form-control" name="idContrato">
	                                           <option value="0"></option>
	                                              <?php 
	                                               $idCliente = $_SESSION['id_c'];
		                                           $conDAO = new ContratoDAO();
		                                           $arrayContrato = $conDAO->ListaContratoPControlePragas($idCliente);
		                                           foreach ($arrayContrato as $conDAO => $contrato){
		                                           ?>
		                                              <option value="<?php echo $contrato['id']; ?>"><?php echo $contrato['nome_contrato']; ?></option>
		                                           <?php } ?>
	                                           </select>
                                        	</div>
	                                    	<div class="form-group">
	                                           <label for="disabledSelect">Seleciona a praga</label>
	                                           <select id="" class="form-control" name="idPragas">
	                                           <option value="0"></option>
	                                              <?php 
		                                           $praDAO = new PragasDAO();
		                                           $arrayPragas = $praDAO->ListaPragasAtivaRelatorio();
		                                           foreach ($arrayPragas as $praDAO => $valor){
		                                           ?>
		                                              <option value="<?php echo $valor['id']; ?>"><?php echo $valor['nome_pragas']; ?></option>
		                                           <?php } ?>
	                                           </select>
                                        	</div>
                                        	<div class="form-group">
	                                           <label for="disabledSelect">Seleciona o setor</label>
	                                           <select id="" class="form-control" name="idSetor">
	                                           <option value="0"></option>
	                                              <?php 
		                                           $setDAO = new SetorDAO();
		                                           $arraySetor = $setDAO->ListaSetoresAtivo();
		                                           foreach ($arraySetor as $setDAO => $valor){
		                                           ?>
		                                              <option value="<?php echo $valor['id']; ?>"><?php echo $valor['nome_setor']; ?></option>
		                                           <?php } ?>
	                                           </select>
                                        	</div>
	                                        <div class="form-group">
	                                            <label>Informe a quantidade de pragas</label>
	                                            <input class="form-control" placeholder="Quantidade" name="qtd">
	                                        </div>
	                                        <div class="form-group">
	                                            <label>Informe a descricao</label>
	                                            <textarea class="form-control" rows="5" name="descricao"></textarea>
	                                        </div>
	                                        <!-- /.table-responsive -->
	                                        <button type="submit" class="btn btn-default">Salvar</button>
	                                        <button type="reset" class="btn btn-default">Reset</button>
	                                    </form>
	                                </div>
	                                <div class="col-lg-1"></div>
                                
                            </div>
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

<?php 
	} else {
		header("Location: index.php");
	} 
} //Fecha a session que verifica se esta vazio 
?>

</body>
</html>