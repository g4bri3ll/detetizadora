<?php 
session_start();

include_once 'Model/DAO/PragasDAO.php';
include_once 'Model/DAO/ControlePragasDAO.php';
include_once 'Model/Modelo/ControleDePragas.php';
include_once 'UploadIMG/UploadFotoJustificativa.php';

?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Justificar controle de pragas</title>

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
			case 'justificarControleDePragas' : $as = 15;   break ;
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
                	
                	if (empty($_POST['descricao'])){
                		?> <br><br><div class="alert alert-danger"> Preencha todos os campos </div> <?php
                	} else {
                		
                		$descricao = $_POST['descricao'];
                		$data      = date('Y-m-d H:i:s');
                		$idfunc    = $_SESSION['id_f'];
                		$id        = $_GET['c'];
                		$status    = "respondido pelo funcionario";
                		
                		
                		if ($_FILES['fotos']['size'] != 0){
                			$foto = $_FILES['fotos'];
                			//Pegar a foto para salvar na pasta
                			$upload = new UploadFotoJustificativa();
                    		$nomeFoto = $upload->img($foto);
                		} else {
                			$nomeFoto = "sem foto";
                		}
            			                		
                		if (!empty($nomeFoto)){
	                		
	                		$controle = new ControleDePragas();
	                		$controle->nomeFoto = $nomeFoto;
	                		$controle->descricaoFuncionario = $descricao;
	                		$controle->dataFuncionario = $data;
	                		$controle->status = $status;
	                		$controle->id = $id;
	                		$controle->idFuncionarios = $idfunc;
	                		
	                		$conDAO =new ControlePragasDAO();
	                		$result = $conDAO->CadastraJustificativaFunc($controle);
	                		
	                		if ($result){
	                			?> <br><br><font size="3px" color="lime"> Justificativa registrado com sucesso! </font> <?php
							} else {
								?> <br><br><font size="3px" color="red"> Ocorreu um erro: <?php print_r($result); ?>  </font> <?php
							}
							
                		} else {
                			?> <br><br><font size="3px" color="red"> Erro ao cadastra, erro na foto </font> <?php
                		}
                		
                	}
                	
                }
                ?>
                    <h1 class="page-header">Justificar controle de pragas</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <?php 
            $praDAO = new PragasDAO();
            $arrayContrato = $praDAO->ListaParaControlePragasResponder();
            if (!empty($arrayContrato)){
            ?>
            <!-- comeca a lista de setores -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Lista de contratos
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nome do contrato</th>
                                            <th>Nome do cliente</th>
                                            <th>Praga</th>
                                            <th>Quantidade</th>
                                            <th>Status</th>
                                            <th>Responder</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($arrayContrato as $praDAO => $dados) {?>
                                        <tr align="center">
                                            <td><?php echo $dados['id']; ?></td>
                                            <td><?php echo $dados['nome_contrato']; ?></td>
                                            <td><?php echo $dados['nome']; ?></td>
                                            <td><?php echo $dados['nome_pragas']; ?></td>
                                            <td><?php echo $dados['qtd_pragas']; ?></td>
                                            <td><?php echo $dados['status']; ?></td>
                                            <td><a href="justificarControleDePragas.php?jus=<?php echo $dados['id']; ?>"><i class="fa fa-pencil fa-fw"></i></a></td>
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
            <?php } ?>
            
            <?php 
            //Montar o painel pelo id do controle de praga selecionado
            if (!empty($_GET['jus'])){
            	$idPraga = $_GET['jus'];
            	$praDAO = new ControlePragasDAO();
            	$arrayPragas = $praDAO->ListaPragasPeloId($idPraga);
            	if (!empty($arrayPragas)){
            		$nomeContrato = null;
            		$nomePraga    = null;
            		$idConPraga   = 0;
            		foreach ($arrayPragas as $praDAO => $dados){
            			$nomeContrato = $dados['nome_contrato'];
            			$nomePraga    = $dados['nome_pragas'];
            			$idConPraga   = $dados['id'];
            		}
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-yellow">
                    	<div class="panel-heading">
                            Justificativa do contrato <?php echo $nomeContrato; ?> para a praga <?php echo $nomePraga; ?>
                        </div>
                        <form action="justificarControleDePragas.php?c=<?php echo $idConPraga; ?>" method="post"  enctype="multipart/form-data">
                        <div class="panel-body">
                            <div class="form-group">
                                <label>Justificativa: </label>
                            	<textarea cols="" class="form-control" rows="5" name="descricao"></textarea>
                            </div>
                            <div class="form-group">
                                <label>Inserir fotos na justificativa: </label>
                            	<input type="file" class="form-control" name="fotos" />
                            </div>
                        </div>
                        <div class="panel-footer">
                            <button type="submit" class="btn btn-default">Salvar</button>
                        	<button type="reset" class="btn btn-default">Reset</button>
                        </div>
                        </form>
                    </div>
                    <!-- /.col-lg-4 -->
                </div>
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