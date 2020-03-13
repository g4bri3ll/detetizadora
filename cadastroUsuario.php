<?php 
session_start();

include_once 'Model/DAO/UsuarioDAO.php';
include_once 'Model/Modelo/Usuario.php';

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

    <title>Cadastro de usuario</title>

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
			case 'cadastroUsuario' : $as = 15;   break ;
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
        
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Cadastro de funcionarios</h1>
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
                                
                                <?php
									if (!empty($_POST)){
										
										if (empty($_POST)){
											?> <font size="3px" color="red"> Preencha todos os campos </font> <?php
										} else {
											
											//Pegar os dados do post
											$nome     = $_POST['nome'];
											$cpf      = $_POST['cpf'];
											$telefone = $_POST['telefone'];
											$cep      = $_POST['cep'];
										 	$endereco = $_POST['endereco'];
										 	$cidade   = $_POST['cidade'];
										 	$bairro   = $_POST['bairro'];
										 	$data     = $_POST['data'];
										  	$email    = $_POST['email'];
										  	$rg       = $_POST['rg'];
										  	$sexo     = $_POST['sexo'];
											$status   = "ativado";
											$dataCad  = date('Y-m-d');
											
											//Verificar se ja existe um cadastro com esse usuario
											$usuDAO = new UsuarioDAO();
											$arrayVerificar = $usuDAO->VerificaCad($nome, $email, $cpf);
													
											if (empty($arrayVerificar)){
												
												$usuario = new Usuario();
												$usuario->cpf = $cpf;
												$usuario->rg = $rg;
												$usuario->nome = $nome;
												$usuario->status = $status;
												$usuario->dt_nascimento = $data;
												$usuario->bairro = $bairro;
												$usuario->endereco = $endereco;
												$usuario->cidade = $cidade;
												$usuario->cep = $cep;
												$usuario->email = $email;
												$usuario->telefone = $telefone;
												$usuario->sexo = $sexo;
												$usuario->dt_cadastro = $dataCad;
												
												$usuDAO = new UsuarioDAO();
												$result = $usuDAO->cadastrar($usuario);
												
												if ($result){
													?> <script type="text/javascript"> alert('Funcionario cadastrado com sucesso!'); window.location="index.php";  </script> <?php
												} else {
													?> <font size="3px" color="red"> Ocorreu um erro: <?php print_r($result); ?> </font> <?php
												}
												
											} else {
												?> <font size="3px" color="red"> Usuario ja cadastrado com esse nome, cpf e email </font> <?php
											} 
											
										}
										
									}
									?>
                                
                                    <form role="form" action="" method="post">
                                        <div class="form-group">
                                            <label>*Informe o nome</label>
                                            <input class="form-control" placeholder="Nome" name="nome">
                                        </div>
                                        <div class="form-group">
                                            <label>*Informe o CPF</label>
                                            <input class="form-control" placeholder="CPF" name="cpf">
                                        </div>
                                        <div class="form-group">
                                            <label>Informe a identidade</label>
                                            <input class="form-control" placeholder="RG" name="rg">
                                        </div>
                                        <div class="form-group">
                                            <label>*Informe um telefone</label>
                                            <input class="form-control" placeholder="telefone" name="telefone">
                                        </div>
                                        <div class="form-group">
                                            <label>*Informe o cep</label>
                                            <input type="text" class="form-control" placeholder="cep" name="cep">
                                        </div>
                                        <div class="form-group">
                                            <label>*Informe o endereco</label>
                                            <input class="form-control" placeholder="endereco" name="endereco">
                                        </div>
                                        <div class="form-group">
                                            <label>*Informe a cidade</label>
                                            <input class="form-control" placeholder="cidade" name="cidade">
                                        </div>
                                        <div class="form-group">
                                            <label>*Informe o bairro</label>
                                            <input class="form-control" placeholder="bairro" name="bairro">
                                        </div>
                                        <div class="form-group">
                                            <label>Informe a data de nascimento</label>
                                            <input type="date" class="form-control" name="data">
                                        </div>
                                        <div class="form-group">
                                           <label for="disabledSelect">Sexo</label>
                                           <select id="" class="form-control" name="sexo">
                                              <option value="M">Masculino</option>
                                              <option value="F">Feminino</option>
                                           </select>
                                        </div>
                                        <div class="form-group">
                                            <label>*Informe o email</label>
                                            <input type="email" class="form-control" placeholder="Email" name="email">
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
        </div>
        <!-- /#page-wrapper -->
		
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