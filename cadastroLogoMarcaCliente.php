<?php 
session_start();

include_once 'Model/DAO/ClienteDAO.php';
include_once 'UploadIMG/UploadFotoLogoCliente.php';

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

    <title>Cadastro de logo marca do cliente</title>

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
                
                <?php
				if (!empty($_POST)){
				
					if (empty($_POST['idCliente']) || empty($_FILES['logo'])){
						?> <br><font size="3px" color="red"> Preencha todos os campos </font> <?php
					} else {
						
						//Pegar os dados do post
						$idCliente   = $_POST['idCliente'];
						$foto = $_FILES['logo'];
						$status      = "ativado";
						
						//Cadastrar a foto
						$upload = new UploadFotoLogoCliente();
						$caminhoFoto = $upload->imagem($foto);
						
						//Verificar se ja existe um cadastro com esse usuario
						$cliDAO = new ClienteDAO();
						$result = $cliDAO->cadastroLogoMarca($status, $caminhoFoto, $idCliente);
							
						if ($result){
							?> <br><br><font size="3px" color="lime"> Logo inserida com sucesso! </font> <?php
						} else {
							?> <br><font size="3px" color="red"> Ocorreu um erro: <?php print_r($result); ?> </font> <?php
						}
						
					}
					
				}
				?>
                
                    <h1 class="page-header">Inserir logo de cliente</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            logo
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Tab panes -->
                            <div class="tab-content">
                                    <div class="col-lg-1"></div>
	                                <div class="col-lg-10">
	                                    <form role="form" action="" method="post"  enctype="multipart/form-data"><br>
	                                        <div class="form-group">
	                                           <label for="disabledSelect">Seleciona um cliente</label>
	                                           <select id="" class="form-control" name="idCliente">
	                                           	  <option value="0"></option>
	                                              <?php 
	                                              $cliDAO = new ClienteDAO();
	                                              $arrayCli = $cliDAO->ListaClientes();
	                                              foreach ($arrayCli as $cliDAO => $clientes){
	                                              	if ($clientes['tipo_cliente'] === "PF"){
	                                              ?>
	                                              	<option value="<?php echo $clientes['id']; ?>"><?php echo $clientes['nome']; ?> - Pessoa fisica</option>
	                                              <?php } else { ?>	
	                                              	<option value="<?php echo $clientes['id']; ?>"><?php echo $clientes['nome_fantasia']; ?> - Pessoa juridica</option>
	                                              <?php } } ?>
	                                           </select>
                                        	</div>
	                                        <div class="form-group">
	                                            <label>Informe a logo marca</label>
	                                            <input type="file" name="logo">
	                                        </div>
	                                        
				                        	<!-- /.table-responsive -->
	                                        <button type="submit" class="btn btn-default">Salvar</button>
	                                        <button type="reset" class="btn btn-default">Reset</button>
	                                    </form>
	                                </div>
	                                <div class="col-lg-1"></div>
                            </div>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
            
            <?php 
            if (!empty($_GET['exc'])){
            	
            	$id = $_GET['exc'];
            	
            	$cliDAO = new ClienteDAO();
            	$cliDAO->DeletaLogo($id);
            	
            	?> <script type="text/javascript"> window.location="cadastroLogoMarcaCliente.php";  </script> <?php
            	
            }
            ?>
            
            
            <?php 
            $cliDAO = new ClienteDAO();
            $arrayLogo = $cliDAO->ListaLogoCliente();
            if (!empty($arrayLogo)){
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Mostra todos as logo cadastrada!
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Tab panes -->
                            <div class="tab-content">
                            	<div class="col-lg-12">
                                	<table>
                                		<thead>
                                			<tr>
                                				<th>Cliente</th>
                                				<th>Foto</th>
                                				<th>Excluir</th>
                                			</tr>
                                		</thead>
                                		<?php foreach ($arrayLogo as $cliDAO => $cli){ ?>
                                		<tbody>
                                			<tr>
                                			<?php if (!empty($cli['nome_fantasia'])){ ?>
                                				<td style="width: 30%;"><?php echo $cli['nome_fantasia']; ?></td>
                                			<?php } else { ?>
                                				<td style="width: 30%;"><?php echo $cli['nome']; ?></td>
                                			<?php } ?>
                                				<td style="width: 60%;"><img alt="" src="Img/logo_cliente/<?php echo $cli['caminho_foto']; ?>"></td>
                                				<td style="width: 10%;"><a href="cadastroLogoMarcaCliente.php?exc=<?php echo $cli['id']; ?>">Excluir</a></td>
                                			</tr>
                                		</tbody>
                                		<?php } ?>
                                	</table>    
                                </div>
                        	</div>
                    	</div>
                	</div>
				</div>
            </div>
            <?php } ?>
            
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