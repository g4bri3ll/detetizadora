<?php 
session_start();

include_once 'Model/DAO/EmpresaDAO.php';
include_once 'Model/Modelo/Empresa.php';
include_once 'Model/DAO/UsuarioDAO.php';
include_once 'UploadIMG/UploadAssinaturaEmpresa.php';
include_once 'UploadIMG/UploadLogoMarca.php';

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

    <title>Cadastrar a empresa</title>

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
			case 'cadastroEmpresa' : $as = 15;   break ;
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
                    <h1 class="page-header">Cadastrar a empresa</h1>
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
										
										if (empty($_POST['nome']) || empty($_POST['razaoSocial']) || empty($_POST['cnpj']) || empty($_POST['idFuncionario'])){
											?> <font size="3px" color="red"> Preencha todos os campos </font> <?php
										} else {
											
											//Pegar os dados do post
											$nome              = $_POST['nome'];
											$razaoSocial       = $_POST['razaoSocial'];
											$cnpj              = $_POST['cnpj'];
											$endereco          = $_POST['endereco'];
											$email             = $_POST['email'];
											$telefone          = $_POST['telefone'];
											$idFuncionario     = $_POST['idFuncionario'];
											$fotoLogo          = $_FILES['logoMarca'];
											$fotoAssinaturaEmp = $_FILES['assinaturaEmpresa'];
											$dataCadastro      = date('Y-m-d');
											$status            = "ativado";
											
											//Faz o cadastro da imagem
											$upload = new UploadLogoMarca();
											$recebe = $upload->img($fotoLogo);
											
											if ($recebe != 10){
												
												$uploadAss = new UploadAssinaturaEmpresa();
												$veriAss = $uploadAss->img($fotoAssinaturaEmp);
												
												if ($veriAss != 10){
												
													$empresa = new Empresa();
													$empresa->nome = $nome;
													$empresa->cnpj = $cnpj;
													$empresa->telefone = $telefone;
													$empresa->email = $email;
													$empresa->endereco = $endereco;
													$empresa->razaoSocial = $razaoSocial;
													$empresa->status = $status;
													$empresa->logoMarca = $recebe;
													$empresa->assinatura = $veriAss;
													$empresa->idUsuarioResponsavel = $idFuncionario;
													$empresa->dataCadastro = $dataCadastro;
													
													$empDAO = new EmpresaDAO();
													$result = $empDAO->cadastrar($empresa);
													
													if ($result){
														?> <font size="3px" color="lime"> Empresa cadastrada com sucesso! </font> <?php
													} else {
														?> <div class="alert alert-error"> <font size="3px" color="red"> Ocorreu um erro: <?php print_r($result); ?> </font> </div> <?php
													}
													
												}
												
											}
											
										}
										
									}
									?>
                                
                                    <form role="form" action="" method="post"  enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label>Informe o nome</label>
                                            <input class="form-control" placeholder="Nome" name="nome">
                                        </div>
                                        <div class="form-group">
                                            <label>Informe a razao social</label>
                                            <input class="form-control" placeholder="Razao social" name="razaoSocial">
                                        </div>
                                        <div class="form-group">
                                            <label>Informe o CNPJ</label>
                                            <input class="form-control" placeholder="CNPJ" name="cnpj">
                                        </div>
                                        <div class="form-group">
                                            <label>Informe o E-mail</label>
                                            <input class="form-control" placeholder="E-mail" name="email">
                                        </div>
                                        <div class="form-group">
                                            <label>Informe o endereco</label>
                                            <input class="form-control" placeholder="Endereco" name="endereco">
                                        </div>
                                        <div class="form-group">
                                            <label>Informe o telefone</label>
                                            <input class="form-control" placeholder="Telefone" name="telefone">
                                        </div>
                                        <div class="form-group">
                                            <label>Assinatura da empresa</label>
                                            <input class="form-control" type="file" name="assinaturaEmpresa">
                                        </div>
                                        <div class="form-group">
                                            <label>Informe a logo marca da empresa</label>
                                            <input type="file" class="form-control" name="logoMarca">
                                        </div>
                                        <div class="form-group">
                                           <label for="disabledSelect">Funcionario responsavel pela empresa</label>
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
            
            <?php 
            if (!empty($_GET['exc'])){
            	
            	$id = $_GET['exc'];
            	$status = "desativada";
            	
            	$empDAO = new EmpresaDAO();
            	$empDAO->excluirEmpresa($status, $id);
            	
            	?> <script type="text/javascript"> window.location="cadastroEmpresa.php";  </script> <?php
            	
            }
            ?>
            
            <!-- /.row -->
            <div class="row">
            	<div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Lista todas as empresa cadastrada
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nome da empresa</th>
                                            <th>Responsavel pela empresa</th>
                                            <th>CNPJ</th>
                                            <th>Data do cadastro</th>
                                            <th>Assinatura</th>
                                            <th>Logo marca</th>
                                            <th>Status</th>
                                            <th>Excluir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
	                                    <?php 
	                                    $empDAO = new EmpresaDAO();
	                                    $arrayEmpresa = $empDAO->ListaEmpresaCompleta();
	                                    foreach ($arrayEmpresa as $empDAO => $empresa){
	                                    ?>
                                        <tr>
                                            <td><?php echo $empresa['id']; ?></td>
                                            <td><?php echo $empresa['nome_empresa']; ?></td>
                                            <td><?php echo $empresa['nome']; ?></td>
                                            <td><?php echo $empresa['cnpj']; ?></td>
                                            <td><?php echo $empresa['data_cadastro']; ?></td>
                                            <td><img alt="" src="Img/empresa/<?php echo $empresa['assinatura_da_empresa']; ?>"></td>
                                            <td><img alt="" src="Img/empresa/<?php echo $empresa['logo_marca']; ?>"></td>
                                            <td><?php echo $empresa['status']; ?></td>
                                            <?php if ($empresa['status'] == "desativada"){ ?>
                                            <td><i class="glyphicon glyphicon-trash"></i></td>
                                            <?php } else { ?>
                                            <td><a href="cadastroEmpresa.php?exc=<?php echo $empresa['id']; ?>"><i class="glyphicon glyphicon-trash"></i></a></td>
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
            <!-- fecha a row -->
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