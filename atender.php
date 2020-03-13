<?php 
session_start();

//Caminho absoluto dentro de uma pasta o arquivo
//define("ROOT_PATH", $_SERVER["DOCUMENT_ROOT"] . "/Model/DAO/ContratoDAO.php");
					
include_once 'Model/DAO/ContratoDAO.php';
include_once 'Model/DAO/TipoServicoDAO.php';
include_once 'UploadIMG/UploadIMGAtendeContrato.php';
include_once 'Model/DAO/UsuarioDAO.php';

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

    <title>Atender dia do contrato</title>

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
			case 'atender' : $as = 15;   break ;
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
                            <a href="ordemDeServico.php"><i class="fa fa-reply fa-fw"></i> Retorna </a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        
        <?php if (!empty($_SESSION)) { ?>
        
        <?php
		if (!empty($_POST)){
			
			if (empty($_POST['idTipoServicos']) || empty($_POST['descricao']) || empty($_FILES['foto'])){
				?> <div class="alert alert-error"> <font size="3px" color="#111"> Preencha todos os campos </font> </div> <?php
			} else {
				
				//Pegar os dados do post
				$idTipoServi    = $_POST['idTipoServicos'];
				$descricao      = $_POST['descricao'];
				$idUsuario      = $_POST['idUsuario'];
				$data           = date('Y-m-d');
				$status         = "atendido";
				$idFuncionario  = $_SESSION['id_f'];
				$idDataContrato = $_GET['idContrato'];
				$foto           = $_FILES['foto'];
				$dataRealizada  = $_POST['dataRealizada'];
				
				$conDAO = new ContratoDAO();
				$result = $conDAO->CadastraAtenderChamado($status, $idFuncionario, $descricao, $idTipoServi, $data, $idDataContrato, $idUsuario, $dataRealizada);
				
				if ($result){
					
					$idDia = $idDataContrato;
					//Cadastrar o status do dia de trabalho e informa que ja foi atendido
					$conDAO = new ContratoDAO();
					$verifica = $conDAO->StatusChamadoAtendido($status, $idDia);
					
					if ($verifica){
						
						//Pegar o ultimo id do atender_contrato para lista em outra tabela
						$idAtendeContrato = $idDataContrato;
						
						if (empty($foto)){
							$nome_imagem = 0;
						} else {
							//cadastrar as fotos do chamado esse metodo vai para a tela de fotosAdquacaoCliente.php
							$img = new UploadIMGAtendeContrato();
							$nome_imagem = $img->img($foto);
						}
						
						$conDAO = new ContratoDAO();
						$valida = $conDAO->CadastrarFotosAtendidaContratos($nome_imagem, $idAtendeContrato);
						
						if ($valida){
							?> <script type="text/javascript"> alert('Dia do contrato atendido com sucesso!'); window.location="ordemDeServico.php";  </script>  <?php
						} else {
							?> <font size="3px" color="red"> Erro do cadastroda foto. Não foi possivel cadastrar: <?php print_r($valida); ?> </font> <?php
						}
						
					} else {
						?> <font size="3px" color="red"> Não foi possivel mudar o status do chamado: <?php print_r($verifica); ?> </font> <?php
					}
					
				} else {
					?> <font size="3px" color="red"> Ocorreu um erro: <?php print_r($result); ?> </font> <?php
				}
					
			}
			
		}
		?>
        
        <?php
        if (!empty($_GET['idD'])){
			//Receber o geet para lista o contrato para atender
        	$idD = $_GET['idD'];
        	
        	$nomeContrato = null;
        	$statusVerifica = null;
        	
        	$conDAO = new ContratoDAO();
        	$arrayContrato = $conDAO->ListaContratoPeloIdD($idD);
        	
        	if (!empty($arrayContrato)){
        		foreach ($arrayContrato as $conDAO => $valor){
        			$nomeContrato = $valor['nome_contrato'];
        			$statusVerifica = $valor['status'];
        		}
        ?>
        
        <div id="page-wrapper">
            <div class="row">
            <?php if ($statusVerifica === "atendido"){ ?>
            	
				<br><br><div class="alert alert-danger alert-dismissable">
				<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				Atencao! Contrato se encontra atendido.
				</div>
            	
            <?php } ?>
                <div class="col-lg-12">
                    <h1 class="page-header">Atender o contrato <?php echo $nomeContrato; ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Ordem de servico
                        </div>
                        <div class="panel-body">
                            <div class="row">
                            	<div class="col-lg-1"></div>
                                <div class="col-lg-10">
                                    <form role="form" action="atender.php?idContrato=<?php echo $idD; ?>" method="post" enctype="multipart/form-data">
                                        <div class="form-group">
	                                        <label for="disabledSelect">Funcionario que realizou o servico</label>
	                                        <select id="" class="form-control" name="idUsuario">
	                                          <option value="0"></option>
	                                           <?php 
	                                           $usuDAO = new UsuarioDAO();
	                                           $arrayUsu = $usuDAO->listaUsuario();
	                                           foreach ($arrayUsu as $usuDAO => $usuario){
	                                           ?>
	                                           <option value="<?php echo $usuario['id']; ?>"><?php echo $usuario['nome']; ?></option>
	                                           <?php } ?>	
	                                        </select>
                                     	</div>
                                        <div class="form-group">
	                                        <label for="disabledSelect">Tipo de servicos</label>
	                                        <select id="" class="form-control" name="idTipoServicos">
	                                          <option value="0"></option>
	                                           <?php 
	                                           $tipDAO = new TipoServicoDAO();
	                                           $arrayTip = $tipDAO->ListaTodosTipoServico();
	                                           foreach ($arrayTip as $tipDAO => $tipo){
	                                           ?>
	                                           <option value="<?php echo $tipo['id']; ?>"><?php echo $tipo['nome']; ?></option>
	                                           <?php } ?>	
	                                        </select>
                                     	</div>
                                     	<div class="form-group">
	                                        <label>Data da realizacao</label>
	                                        <input type="date" name="dataRealizada" class="form-control" />
                                     	</div>
                                        <div class="form-group">
                                            <label>Informe a descricao do servico</label>
                                            <textarea class="form-control" rows="5" name="descricao"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Inseri as fotos</label>
                                            <input class="form-control" type="file" name="foto" multiple /><br>
                                        </div>
                                        <button type="submit" class="btn btn-default">Atender</button>
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
        
        <?php 
        } else {
        ?>
        
        <p>Contrato nao encontrado</p>
        
        <?php 
        } }
        ?>
        
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