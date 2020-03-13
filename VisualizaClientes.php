<?php
session_start();

include_once 'Model/DAO/TipoMoradiaDAO.php';
include_once 'Model/DAO/ClienteDAO.php';
include_once 'Model/Modelo/Cliente.php';

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

    <title>Visualiza o clientes</title>

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
                            <a href="listaClientes.php"><i class="fa fa-reply fa-fw"></i> Retorna </a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper"><br>
            <div class="row">
                <div class="col-lg-12">
                
                <?php
				if (!empty($_POST)){
					
					if (empty($_POST)){
						?> <div class="alert alert-error"> <font size="3px" color="#111"> Preencha todos os campos </font> </div> <?php
					} else {
						
						$idCli        = $_GET['idCli'];
						//Pegar os dados do post
						$nome         = $_POST['nome'];
						$nomeFantasia = $_POST['nomeFantasia'];
						$razaoSocial  = $_POST['razaoSocial']; 
						$cnpjj        = $_POST['cnpj'];
						$email        = $_POST['email'];
						$estadMunici  = $_POST['estadualMunicipal'];
						$telefone     = $_POST['telefone'];
						$cep          = $_POST['cep'];
						$cpf          = $_POST['cpf'];
						$rg           = $_POST['rg'];
						$dataNascimen = $_POST['data'];
						$sex          = $_POST['sexo'];
						$cidad        = $_POST['cidade'];
						$enderec      = $_POST['endereco'];
						$bairr        = $_POST['bairro'];
					 	$complemen    = $_POST['complemento'];
					 	$pontoRefere  = $_POST['pontoReferencia'];
					 	$idTipoReside = $_POST['idTipoResidencia'];
						
						//Verificar se ja existe um cadastro com esse usuario
						$cliDAO = new ClienteDAO();
						$arrayVerificar = $cliDAO->VerificaAltCliente($nome, $cnpjj, $email, $idCli);
								
						if (empty($arrayVerificar)){
							
							$cliente = new Cliente();
							$cliente->id = $idCli;
							$cliente->nome = $nome;
							$cliente->dataNascimento = $dataNascimen;
							$cliente->rg = $rg;
							$cliente->cpf = $cpf;
							$cliente->sexo = $sex;
							$cliente->email = $email;
							$cliente->nomeFantasia = $nomeFantasia;
							$cliente->razaoSocial = $razaoSocial;
							$cliente->cep = $cep;
							$cliente->cnpj = $cnpjj;
							$cliente->cidade = $cidad;
							$cliente->endereco = $enderec;
							$cliente->bairro = $bairr;
							$cliente->complemento = $complemen;
							$cliente->referencia = $pontoRefere;
							$cliente->idTipoResidencia = $idTipoReside;
							$cliente->telefone = $telefone;
							$cliente->estadualMunicipal = $estadMunici;
							
							$cliDAO = new ClienteDAO();
							$result = $cliDAO->AlteraDadosCliente($cliente);
							
							if ($result){
								?><script type="text/javascript"> alert('Cliente alterado com sucesso!'); window.location="listaClientes.php";  </script><?php
							} else {
								?> <font size="3px" color="red"> Ocorreu um erro: <?php print_r($result); ?> </font> <?php
							}
							
						} else {
							?> <font size="3px" color="#111"> Esse nome, cnpj e email ja esta cadastrado para outro usuario</font> <?php
						} 
						
					}
					
				}
				?>
                    
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <?php 
            //Pegar o get que a envio para lista na tela
		        if (!empty($_GET['visualizar'])){
		        	
		        	$id = $_GET['visualizar'];
		        	$tipoCliente = $_GET['tipoCli'];
		        	
		        	$cliDAO = new ClienteDAO();
		        	$arrayCli = $cliDAO->ListaTodosOSDadosDoCliente($id);
		        	
		        	//Lista os dados que ira para a tela
		        	$nome = null;
		        	$dataNascimento = null;
		        	$rg = null;
		        	$cpf = null;
		        	$sexo = null;
		        	$email = null;
		        	$nomeFantasia = null;
		        	$razaoSocial = null;
		        	$cep = null;
		        	$cnpj = null;
		        	$cidade = null;
		        	$endereco = null;
		        	$bairro = null;
		        	$complemento = null;
		        	$referencia = null;
		        	$telefone = null;
		        	$inscricao = null;
		        	$idCliente = 0;
		        	$nomeCliente = null;
		        	
		        	
		        	foreach ($arrayCli as $cliDAO => $valor){
		        		
		        		$nome = $valor['nome'];
			        	$dataNascimento = $valor['data_nascimento'];
			        	$rg = $valor['rg'];
			        	$cpf = $valor['cpf'];
			        	$sexo = $valor['sexo'];
			        	$email = $valor['email'];
			        	$nomeFantasia = $valor['nome_fantasia'];
			        	$razaoSocial = $valor['razao_social'];
			        	$cep = $valor['cep'];
			        	$cnpj = $valor['cnpj'];
			        	$cidade = $valor['cidade'];
			        	$endereco = $valor['endereco'];
			        	$bairro = $valor['bairro'];
			        	$complemento = $valor['complemento'];
			        	$referencia = $valor['referencia'];
			        	$telefone = $valor['telefone'];
			        	$inscricao = $valor['inscri_estadual_municipal'];
			        	$idCliente = $valor['id'];
			        	$nomeCliente = $valor['nome'];
			        	
		        	}
		        	
		        }
		    ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Visualiza todos os clientes
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           
                            <!-- Tab panes -->
                            <div class="row">
                                
                                    <div class="col-lg-1"></div>
	                                <div class="col-lg-10">
	                                    <form role="form" action="VisualizaClientes.php?idCli=<?php echo $idCliente; ?>" method="post"><br>
	                                        <?php if ($tipoCliente === "PJ"){ ?>
	                                        <div class="form-group">
	                                            <label>Nome do responsavel</label>
	                                            <input class="form-control" placeholder="Nome" name="nome" value="<?php echo $nome; ?>">
	                                        </div>
	                                        <div class="form-group">
	                                            <label>Nome fantasia</label>
	                                            <input class="form-control" placeholder="nome fantasia" name="nomeFantasia" value="<?php echo $nomeFantasia; ?>">
	                                        </div>
	                                        <div class="form-group">
	                                            <label>Razao social</label>
	                                            <input class="form-control" placeholder="Razao social" name="razaoSocial" value="<?php echo $razaoSocial; ?>">
	                                        </div>
	                                        <div class="form-group">
	                                            <label>CNPJ/CPF</label>
	                                            <input class="form-control" placeholder="CNPJ" name="cnpj" value="<?php echo $cnpj; ?>">
	                                        </div>
	                                        <div class="form-group">
	                                            <label>Inscricao estadual/municipal</label>
	                                            <input class="form-control" placeholder="estadual/municipal" name="estadualMunicipal" value="<?php echo $inscricao; ?>">
	                                        </div>
	                                        <?php } else if ($tipoCliente === "PF"){ ?>
	                                        <div class="form-group">
	                                            <label>Nome</label>
	                                            <input class="form-control" placeholder="Nome" name="nome" value="<?php echo $nomeCliente; ?>">
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
	                                            <label>Data nascimento</label>
	                                            <input type="date" class="form-control" name="data" value="<?php echo $dataNascimento; ?>">
	                                        </div>
	                                        <div class="form-group">
	                                            <label>Sexo</label>
	                                            <input type="text" class="form-control" name="sexo" placeholder="Sexo" value="<?php echo $sexo; ?>">
	                                        </div>
	                                        <?php } ?>
	                                        <div class="form-group">
	                                            <label>EMAIL</label>
	                                            <input class="form-control" placeholder="Email" name="email" value="<?php echo $email;?>">
	                                        </div>
	                                        <div class="form-group">
                                            	<label>Telefone</label>
                                            	<input class="form-control" placeholder="(xx) 00000-0000" name="telefone" value="<?php echo $telefone; ?>">
                                        	</div>
	                                        <div class="form-group">
	                                            <label>CEP</label>
	                                            <input class="form-control" placeholder="CEP" name="cep" value="<?php echo $cep; ?>">
	                                        </div>
	                                        <div class="form-group">
	                                            <label>Cidade</label>
	                                            <input class="form-control" placeholder="cidade" name="cidade" value="<?php echo $cidade; ?>">
	                                        </div>
	                                        <div class="form-group">
	                                            <label>Endereco</label>
	                                            <input class="form-control" placeholder="endereco" name="endereco" value="<?php echo $endereco; ?>">
	                                        </div>
	                                        <div class="form-group">
	                                            <label>Bairro</label>
	                                            <input class="form-control" placeholder="bairro" name="bairro" value="<?php echo $bairro; ?>">
	                                        </div>
	                                        <div class="form-group">
	                                            <label>Complemento</label>
	                                            <input class="form-control" placeholder="complemento" name="complemento" value="<?php echo $complemento; ?>">
	                                        </div>
	                                        <div class="form-group">
	                                            <label>Ponto de referencia</label>
	                                            <input class="form-control" placeholder="Ponto de referencia" name="pontoReferencia" value="<?php echo $referencia; ?>">
	                                        </div>
	                                        
	                                        <!-- x
	                                        <div class="form-group">
	                                            <label>Tipo de residencia</label>
	                                            <select id="" class="form-control" name="idTipoResidencia">
	                                           		<?php 
	                                           		//$tipDAO = new TipoMoradiaDAO();
	                                           		//$arrayTipoMoradia = $tipDAO->lista();
	                                           		//foreach ($arrayTipoMoradia as $tipDAO => $value){
	                                           		?>
	                                              		<option value="<?php //echo $value['id']; ?>"><?php //echo $value['nome_residencia']; ?></option>
	                                              	<?php //} ?>
	                                            </select>
                                        	</div>
                                        	-->
                                        	<br>
	                                        <input type="submit" class="btn btn-default" value="altera dados" />
	                                        <input type="reset" class="btn btn-default" value="reset" />
	                                    </form>
	                                </div>
	                                <div class="col-lg-1"></div>
                                <!-- /.col-lg-12 -->
                               
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