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

    <title>Visualiza o funcionario</title>

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
                            <a href="listaFuncionarios.php"><i class="fa fa-reply fa-fw"></i> Retorna </a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        <?php 
        if (!empty($_GET['visualizar'])){
        	
        	$id = $_GET['visualizar'];
        	
        	$usuDAO = new UsuarioDAO();
        	$arrayFunc = $usuDAO->ListaTodosOSDadosFunc($id);
        	
        	//Lista os dados que ira para a tela
        	$nome = null;
        	$cpf = null;
        	$rg = null;
        	$email = null;
        	$telefone = null;
        	$endereco = null;
        	$cidade = null;
        	$bairro = null;
        	$cep = null;
        	$dataNascimento = null;
        	$email = null;
        	$sexo = null;
        	
        	
        	foreach ($arrayFunc as $usuDAO => $valor){
        		
        		$nome = $valor['nome'];
	        	$cpf = $valor['cpf'];
	        	$rg = $valor['rg'];
	        	$email = $valor['email'];
	        	$telefone = $valor['telefone'];
	        	$endereco = $valor['endereco'];
	        	$cidade = $valor['cidade'];
	        	$bairro = $valor['bairro'];
	        	$cep = $valor['cep'];
	        	$dataNascimento = $valor['dt_nascimento'];
	        	$email = $valor['email'];
	        	$sexo = $valor['sexo'];
	        	$idLista = $valor['id'];
	        	
	        	
        	}
        	
        }
        ?>
        <div id="page-wrapper">
            <!-- /.row --><br><br>
            <?php
				if (!empty($_POST)){
					
					if (empty($_POST)){
						?> <div class="alert alert-error"> <font size="3px" color="#111"> Preencha todos os campos </font> </div> <?php
					} else {
						
						$idFunc   = $_GET['idFunc'];
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
						$dataCad  = date('Y-m-d');
						
						//Verificar se ja existe um cadastro com esse usuario
						$usuDAO = new UsuarioDAO();
						$arrayVerificar = $usuDAO->VerificaCadParaAlterar($nome, $email, $cpf, $idFunc);
								
						if (empty($arrayVerificar)){
							
							$usuario = new Usuario();
							$usuario->cpf = $cpf;
							$usuario->id = $idFunc;
							$usuario->rg = $rg;
							$usuario->nome = $nome;
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
							$result = $usuDAO->Alterar($usuario);
							
							if ($result){
								?> <script type="text/javascript"> alert('Funcionario alterado com sucesso!'); window.location="listaFuncionarios.php";  </script> <?php
							} else {
								?> <font size="3px" color="red"> Ocorreu um erro: <?php print_r($result); ?> </font> <?php
							}
							
						} else {
							?> <font size="3px" color="red"> Existe outro funcionario cadastrado com esse nome, cpf e email </font> <?php
						} 
						
					}
					
				}
				?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Visualiza os dados do funcionario
                        </div>
                        <div class="panel-body">
                            <div class="row">
                            	<div class="col-lg-1"></div>
                                <div class="col-lg-10">
                                    <form action="visualizaFuncionarios.php?idFunc=<?php echo $idLista; ?>" method="post">
                                        <div class="form-group">
                                            <label>Nome</label>
                                            <input class="form-control" placeholder="Nome" name="nome" value="<?php echo $nome; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>CPF</label>
                                            <input class="form-control" placeholder="CPF" name="cpf" value="<?php echo $cpf; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>RG</label>
                                            <input class="form-control" placeholder="RG" name="rg" value="<?php echo $rg; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Telefone</label>
                                            <input type="tel" class="form-control" placeholder="telefone" name="telefone" value="<?php echo $telefone; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>CEP</label>
                                            <input type="text" class="form-control" placeholder="cep" name="cep" value="<?php echo $cep; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Endereco</label>
                                            <input class="form-control" placeholder="endereco" name="endereco" value="<?php echo $endereco; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Cidade</label>
                                            <input class="form-control" placeholder="cidade" name="cidade" value="<?php echo $cidade; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Bairro</label>
                                            <input class="form-control" placeholder="bairro" name="bairro" value="<?php echo $bairro; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Data de nascimento</label>
                                            <input type="date" class="form-control" name="data" value="<?php echo $dataNascimento; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Sexo</label>
                                            <input class="form-control" placeholder="sexo" name="sexo" value="<?php echo $bairro; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" class="form-control" placeholder="Email" name="email" value="<?php echo $email; ?>">
                                        </div>
                                        <input type="submit" class="btn btn-default" value="Altera dados" />
                                        <input type="reset" class="btn btn-default" value="Reset" />
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

</body>
</html>