<?php 
session_start();

include_once 'Model/DAO/AcessoPaginasDAO.php';
include_once 'Model/Modelo/AcessoPaginas.php';
include_once 'Model/DAO/AcessoSistemaDAO.php';

?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Altera a permissao de acesso dentro do sistema</title>

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
                            <a href="listaAcessoSistema.php"><i class="fa fa-reply fa-fw"></i> Retorna </a>
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
	                	$idPgAcesso = $_GET['idPgAcesso'];
	                	
	                	$acessoPagina = new AcessoPaginas();
		               	$acessoPagina->nome = $nomeAcesso;
		               	$acessoPagina->id = $idPgAcesso;
		               				
	                	//Cadastrar o nome do acesso a pagina
	                	$aceDAO = new AcessoPaginasDAO();
	                	$res = $aceDAO->AlteraAcessoSistema($acessoPagina);
	                		
	                	if ($res) {
	                			
	                		$result = 0;
	                		for ($i = 0; $i < count($idPaginas); $i++){
	                			
	                			//Verificar se ja possui essa tela de permissão para não cadastrar duas vezes
	                			$aceDAO = new AcessoPaginasDAO();
	                			$verifica = $aceDAO->VerificaTelaAcesso($idPaginas[$i], $idPgAcesso);
	                			
	                			//Se não possui acesso a tela ele faz
	                			if (empty($verifica)){
	                			
	                				$acessoPagina = new AcessoPaginas();
		                			$acessoPagina->idPaginas = $idPaginas[$i];
		                			$acessoPagina->idPaginaAcesso = $idPgAcesso;
		                			$acessoPagina->status = $status;
		                			
		                			//Cadastrar as paginas de acesso
		                			$aceDAO = new AcessoPaginasDAO();
		                			$result = $aceDAO->cadastrarAcessoPag($acessoPagina);
	                			
	                			}
	                			
	                		}
	                		
	                		if ($result){
	                			?> <script type="text/javascript"> alert('Dados do acesso alterado com sucesso!'); window.location="listaAcessoSistema.php";  </script> <?php
	                		}
	                		
                		}
                				                			
                	}
                	
                }
                ?>
                
                <?php 
                //Receber o id do acesso para alterar
                if (!empty($_GET['atr'])){
                	
                	$idAcesso = $_GET['atr'];
                	
                	$aceDAO = new AcessoSistemaDAO();
                	$arrayAcesso = $aceDAO->ListaAcessoPeloId($idAcesso);
                	
                	if (!empty($arrayAcesso)){
                		
                		$nomeDoAcesso = null;
                		$idPagAcesso  = 0;
                		foreach ($arrayAcesso as $aceDAO => $n){
                			$nomeDoAcesso = $n['nome_acesso'];
                			$idPagAcesso  = $n['paginas_acesso_id'];
                		}
                		
                	}
                	
                }
                ?>
                
                <?php
                //Esta opção realmente ele faz a esclusão do item 
		            if (!empty($_GET['exclui']) || !empty($_GET['idUsuExcluir'])){
		            	
		            	$id = $_GET['exclui'];
		            	$idAcessoAlt = $_GET['idUsuExcluir'];
		            	
		            	$aceDAO = new AcessoSistemaDAO();
		            	$aceDAO->DeleteIdDoAcesso($id, $idAcessoAlt);
		            	
		            	//header("alteraAcessoSistema.php?atr=" . $idAcessoAlt);
						?>  <script type="text/javascript"> 
								var id = "<?php echo $idAcessoAlt; ?>"; 
								window.location = "alteraAcessoSistema.php?atr="+id; 
						   </script> 
						<?php
						
		            }
		        ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Paginas de acesso
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        	<form action="alteraAcessoSistema.php?idPgAcesso=<?php echo $idPagAcesso; ?>" method="post" >
                        		
                        		<div class="form-group">
                        			<label>Nome do acesso</label>
	                                <input class="form-control" placeholder="Nome do acesso" name="nomeAcesso" value="<?php echo $nomeDoAcesso; ?>">
	                            </div>
	                        	<table class="table table-striped table-bordered table-hover">
	                                <thead>
	                                    <tr>
	                                        <th>#</th>
	                                        <th>Nome da pagina</th>
	                                        <th>Status</th>
	                                        <th>Exclui</th>
	                                    </tr>
	                                </thead>
	                                <?php 
	                                //Lista todos os acessos
	                                $aceDAO = new AcessoPaginasDAO();
	                                $arrayPaginas = $aceDAO->ListaPaginas();
	                                foreach ($arrayPaginas as $aceDAO => $acesso){
	                                	$verda = 0;
	                                	foreach ($arrayAcesso as $aceTem){
	                                		if ($aceTem['paginas_id'] === $acesso['id']){
	                                			$verda = '1';
	                                		}
	                                	}
	                                ?>
	                                <tbody>
	                                    <tr>
	                                    	<?php if ($verda === '1'){ ?>
	                                        <td><input type="checkbox" name="paginas[]" value="<?php echo $acesso['id']; ?>" checked /></td>
	                                        <?php } else { ?>
	                                        <td><input type="checkbox" name="paginas[]" value="<?php echo $acesso['id']; ?>" /></td>
	                                        <?php } ?>
	                                        
	                                        <td><?php echo $acesso['nome']; ?></td>
	                                        <td><?php echo $acesso['status']; ?></td>
	                                        <?php if ($verda === '1'){ ?>
	                                        <td><a href="alteraAcessoSistema.php?exclui=<?php echo $acesso['id']; ?>&idUsuExcluir=<?php echo $idPagAcesso; ?>"><i class="glyphicon glyphicon-trash"></i></a></td>
	                                        <?php } else { ?>
	                                        <td><i class="glyphicon glyphicon-trash"></i></td>
	                                        <?php } ?>
	                                        
	                                    </tr>
	                            	</tbody>
	                            	<?php } ?>
	                            </table>
	                        	<!-- /.table-responsive -->
	                            <div class="well">
	                                <input type="submit" class="btn btn-default btn-lg btn-block" value="Altera acesso" />
	                            </div>
                            </form>
                        </div>
                        <!-- /.panel-body -->
                    </div>
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

</body>
</html>