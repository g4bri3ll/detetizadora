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

    <title>Altera permissoes de acesso dentro do sistema</title>

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
                    <h3 class="page-header">Lista/ Alterar</h3>
                    
                    <?php 
	                if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	                	
						if(isset($_POST['check'])){
						
							print 'Campors marcados: <br />';
							$a = 0;
							for($i=0; $i < count($_POST['select']); $i++){
								if ($_POST['select'][$i] !== "0"){
									
									$idPaginaAcesso = $_POST['select'][$i];
									$idAcesso       = $_POST['check'][$a];
									//Cadastrar o nome do acesso a pagina
		            				$aceDAO = new AcessoPaginasDAO();
		            				$res = $aceDAO->AlterarPermissaoDeAcesso($idPaginaAcesso, $idAcesso);
									$a = $a + 1;
								}
							}
							
					    	if ($res){
								?> <script type="text/javascript"> alert('Pagina de acesso alterado com sucesso!'); </script> <?php
							} else {
								?> <font size="3px" color="red"> Ocorreu um erro: <?php print_r($res); ?> </font> <?php
							}
				
						}
						
	                }
	                ?>
	                
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
            <?php
            //Desativa o usuario 
            if (!empty($_GET['exc'])){
            	
            	$id = $_GET['exc'];
            	$status = "desativado";
            	
            	$perDAO = new AcessoSistemaDAO();
            	$perDAO->deleteId($id, $status);
            	
            }
            ?>
            
            <?php
            //Ativa o usuario 
            if (!empty($_GET['atir'])){
            	
            	$id = $_GET['atir'];
            	$status = "ativado";
            	
            	$perDAO = new AcessoSistemaDAO();
            	$perDAO->AtivaPorId($id, $status);
            	
            }
            ?>
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Lista todas as permissoes de acesso dentro do sistema
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                            	<form action="" method="post">
                            		<div align="right"><input type="submit" value=" salvar alteracoes " class="btn btn-success"></div><br>
	                                <table class="table table-striped table-bordered table-hover">
	                                    <thead>
	                                        <tr>
	                                            <th>#</th>
	                                            <th>Nome do acesso</th>
	                                            <th>Tipo de usuario</th>
	                                            <th>Login de acesso</th>
	                                            <th>Status</th>
	                                            <th>Ativa</th>
	                                            <th>Desativar</th>
	                                        </tr>
	                                    </thead>
	                                    <tbody>
	                                    <?php 
	                                    $perDAO = new AcessoSistemaDAO();
	                                    $arraypermissao = $perDAO->ListaTodosAcesso();
	                                    foreach ($arraypermissao as $perDAO => $va){
	                                    	if ($va['status'] === "desativado"){
	                                    ?>
	                                        <tr class="danger">
	                                        <?php } else { ?>
	                                        <tr class="success">
	                                        <?php } ?>
	                                            <td><input type="checkbox" name="check[]" id="valor[]" value="<?php echo $va['id_acesso_sistema']; ?>" /></td>
	                                            <td>
	                                            <div class="form-group">
		                                            <select class="form-control" name="select[]" id="valor[]">
		                                            	<option value="0"><?php echo $va['nome_acesso']; ?></option>
		                                            	<?php 
		                                           		$perDAO = new AcessoSistemaDAO();
	                                    				$arrayAcess = $perDAO->ListaAcessos();
	                                    				
		                                           		for ($i = 0; $i < count($arrayAcess); $i++){
		                                           			if ($arrayAcess[$i]['id'] !== $va['id_pagina']){
		                                           		?>
		                                              		<option value="<?php echo $arrayAcess[$i]['id']; ?>"><?php echo $arrayAcess[$i]['nome_acesso']; ?></option>
		                                              	<?php } } ?>
		                                            </select>
	                                        	</div>
	                                    		</td>
	                                            <td><?php echo $va['tipo_usuario']; ?></td>
	                                            <td><?php echo $va['login']; ?></td>
	                                            <td><?php echo $va['status']; ?></td>
	                                            
	                                            <?php if($va['status'] === "desativado"){ ?>
	                                            <td align="center"><a href="PermissaoAcessoSistema.php?atir=<?php echo $va['id_acesso_sistema']; ?>"><i class="fa fa-check"></i></a></td>
	                                            <?php } else {?>
	                                            <td></td>
	                                            <?php } ?>
	                                            
	                                            <?php if($va['status'] !== "desativado"){ ?>
	                                            <td align="center"><a href="PermissaoAcessoSistema.php?exc=<?php echo $va['id_acesso_sistema']; ?>"><i class="fa fa-times"></i></a></td>
	                                            <?php } else {?>
	                                            <td></td>
	                                            <?php } ?>
	                                            
	                                        </tr>
	                                        
	                                    <?php } ?>
	                                    </tbody>
	                                </table>
                                </form>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
           	</div>
            
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