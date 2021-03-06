<?php 
session_start();

include_once 'Model/DAO/AcessoSistemaDAO.php';
include_once 'Model/DAO/UsuarioDAO.php';
include_once 'validacoes/gera-senhas.php';
include_once 'Model/DAO/ClienteDAO.php';

$cod = geraSenha(8, true, true, true);
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Alterando o codigo de acesso</title>

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
			case 'alteraSenha' : $as = 15;   break ;
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
					
					if (empty($_GET['cod'])){
						?> <div class="alert alert-error"> <font size="3px" color="#111"> Preencha todos os campos </font> </div> <?php
					} else {
							
						$codigo = $_GET['cod'];
						
						//Cadastrar o codigo de acesso do funcionario
						if (!empty($_POST['idFuncionario'])) {
							
							$id = $_POST['idFuncionario'];
							
							//Verificar se este login existe
							$aceDAO = new AcessoSistemaDAO();
							$arrayAce = $aceDAO->VerificarAcessoFunc($id);
							
							if (!empty($arrayAce)){
							
								$aceDAO = new AcessoSistemaDAO();
								$result = $aceDAO->AlterarCodigoAcessoF($codigo, $id);
								
								if ($result){
									?> <script type="text/javascript"> alert('Codigo de acesso alterado com sucesso!'); window.location="index.php";  </script> <?php
								} else {
									?> <div class="alert alert-error"> <font size="3px" color="#111"> Ocorreu um erro: <?php print_r($result); ?> </font> </div> <?php
								}
								 
							} else {
								?> <div class="alert alert-error"> <font size="3px" color="#111"> Este usuario nao existe, faca seu cadastro </font> </div> <?php
							}
							
						}
						
						//Cadastrar o codigo de acesso do cliente
						if (!empty($_POST['idCliente'])) {
							
							$id = $_POST['idCliente']; 
							
							//Verificar se este login existe
							$aceDAO = new AcessoSistemaDAO();
							$arrayAce = $aceDAO->VerificarAcessoClien($id);
							
							if (!empty($arrayAce)){
								
								$aceDAO = new AcessoSistemaDAO();
								$result = $aceDAO->AlterarCodigoAcessoC($codigo, $id);
								
								if ($result){
									?> <script type="text/javascript"> alert('Codigo de acesso alterado com sucesso!'); window.location="index.php";  </script> <?php
								} else {
									?> <div class="alert alert-error"> <font size="3px" color="#111"> Ocorreu um erro: <?php print_r($result); ?> </font> </div> <?php
								}

							} else {
								?> <div class="alert alert-error"> <font size="3px" color="#111"> Este usuario nao existe, faca seu cadastro </font> </div> <?php
							}
							
						}
					
					}
					
				}
				?>
                    <h1 class="page-header">Alterar o codigo de acesso do usuario</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Codigo de acesso
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#c" data-toggle="tab">Cliente</a></li>
                                <li>               <a href="#f" data-toggle="tab">Funcionario</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="c"><br><br>
	                                <div class="col-lg-2"></div>
	                                <div class="col-lg-8">
	                                    <form role="form" action="alteraCodigoAcesso.php?cod=<?php echo $cod; ?>" method="post">
	                                        <div class="form-group">
	                                           <label for="disabledSelect">Seleciona o cliente</label>
	                                           <select id="" class="form-control" name="idCliente">
	                                           	  <option value="0"></option>
	                                              <?php 
	                                              $cliDAO = new ClienteDAO();
	                                              $arrayCliente = $cliDAO->ListaClientes();
	                                              foreach ($arrayCliente as $cliDAO => $c){
	                                              ?>
	                                              <option value="<?php echo $c['id']; ?>"><?php echo $c['nome']; ?></option>
	                                              <?php } ?>
	                                           </select>
	                                        </div>
	                                        <div class="form-group">
	                                            <label>Codigo de acesso: <?php echo $cod; ?></label>
	                                        </div>
	                                        <button type="submit" class="btn btn-default">Salvar</button>
	                                        <button type="reset" class="btn btn-default">Reset</button>
	                                    </form>
	                                </div>
	                                <div class="col-lg-2"></div>
	                                <!-- /.col-lg-6 (nested) -->
                                </div>
                                
                                <!-- --------------------- -->
                                <div class="tab-pane fade" id="f"><br><br>
	                                <div class="col-lg-2"></div>
	                                <div class="col-lg-8">
	                                    <form role="form" action="alteraCodigoAcesso.php?cod=<?php echo $cod; ?>" method="post">
	                                        <div class="form-group">
	                                           <label for="disabledSelect">Seleciona o funcionario</label>
	                                           <select id="" class="form-control" name="idFuncionario">
	                                           	  <option value="0"></option>
	                                              <?php 
	                                              $pesDAO = new UsuarioDAO();
	                                              $arrayPessoa = $pesDAO->ListaTodasFuncionarios();
	                                              foreach ($arrayPessoa as $pesDAO => $pessoa){
	                                              ?>
	                                              <option value="<?php echo $pessoa['id']; ?>"><?php echo $pessoa['nome']; ?></option>
	                                              <?php } ?>
	                                           </select>
	                                        </div>
	                                        <div class="form-group">
	                                            <label>Codigo de acesso: <?php echo $cod; ?></label>
	                                        </div>
	                                        <button type="submit" class="btn btn-default">Salvar</button>
	                                        <button type="reset" class="btn btn-default">Reset</button>
	                                    </form>
	                                </div>
	                                <div class="col-lg-2"></div>
	                                <!-- /.col-lg-6 (nested) -->
                                </div>
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
        
        <?php } ?>
        
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