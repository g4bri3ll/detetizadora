<?php
session_start();
 
include_once 'Model/DAO/TipoMoradiaDAO.php';
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Cadastra tipo moradia</title>

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
			case 'cadastraTipoMoradia' : $as = 15;   break ;
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
                    <h1 class="page-header">Cadastra o tipo de moradia</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Cadastro
                        </div>
                        <div class="panel-body">
                            <div class="row">
                            	<div class="col-lg-1"></div>
                                <div class="col-lg-10">
                                    <form role="form" action="" method="post">
                                    	<?php
										if (!empty($_POST)){
											
											if (empty($_POST['nome'])){
												?> <font size="3px" color="red"> Preencha todos os campos </font> <?php
											} else {
												
												//Pegar os dados do post
												$nome     = $_POST['nome'];
												$status   = "ativado";
												
												//Verificar se ja existe um cadastro com esse usuario
												$tipDAO = new TipoMoradiaDAO();
												$arrayVerificar = $tipDAO->VerificaCad($nome);
														
												if (empty($arrayVerificar)){
													
													$tipDAO = new TipoMoradiaDAO();
													$result = $tipDAO->cadastrar($nome, $status);
													
													if ($result){
														?> <font size="3px" color="lime"> Tipo de moradia cadastrado com sucesso! </font><br><br> <?php
													} else {
														?> <font size="3px" color="red"> Ocorreu um erro: <?php print_r($result); ?> </font> <?php
													}
													
												} else {
													?> <font size="3px" color="red"> Tipo de moradia ja cadastrado com esse nome </font><br><br> <?php
												} 
												
											}
											
										}
										?>
                                        <div class="form-group">
                                            <label>Informe o tipo de moradia</label>
                                            <input class="form-control" placeholder="casa, galpao, etc" name="nome">
                                        </div>
                                        <button type="submit" class="btn btn-default">Salvar</button>
                                        <button type="reset" class="btn btn-default">Reset</button>
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
            <?php 
            $tipDAO = new TipoMoradiaDAO();
            $arrayMoradia = $tipDAO->ListaMoradia();
            if (!empty($arrayMoradia)){
            ?>
            
            <?php 
            if (!empty($_GET['exc'])){
            	
            	$id = $_GET['exc'];
            	$status = "desativada";
            	
            	$tipDAO = new TipoMoradiaDAO();
            	$res = $tipDAO->deleteId($id, $status);
            	
				if ($res){
					?> <script type="text/javascript"> window.location="cadastraTipoMoradia.php";  </script> <?php
				} else {
					?> <font size="3px" color="red"> Ocorreu um erro: <?php print_r($res); ?> </font> <?php
				}
				
            }
            ?>
            
            <!-- comeca a lista de setores -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Lista os tipo de moradia cadastrada
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nome da moradia</th>
                                            <th>Status</th>
                                            <th>Excluir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($arrayMoradia as $tipDAO => $valor) {?>
                                        <tr>
                                            <td><?php echo $valor['id']; ?></td>
                                            <td><?php echo $valor['nome']; ?></td>
                                            <td><?php echo $valor['status']; ?></td>
                                            <td><a href="cadastraTipoMoradia.php?exc=<?php echo $valor['id']; ?>"><i class="glyphicon glyphicon-trash"></i></a></td>
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