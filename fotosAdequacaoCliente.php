<?php
session_start();

include_once 'Model/DAO/ContratoDAO.php';
include_once 'UploadIMG/UploadIMGAdquacao.php';

?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Visualiza o mapa</title>

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
                            <a href="adquacao.php?listContt=<?php echo $_GET['idContrato']; ?>"><i class="fa fa-reply fa-fw"></i> Retorna </a>
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        <div id="page-wrapper"><br>
            <?php 
            //Recebe o get vindo da tela de adquacao.php
	        if (!empty($_GET['ft']) || !empty($_SESSION['maisFt'])){
	        	//echo "aqui";
	        	
	        	if (empty($_SESSION['maisFt'])){
	        		$_SESSION['maisFt'] = $_GET['ft'];
	        		$id  = $_GET['ft'];
	        	} else {
	        		$id = $_SESSION['maisFt']; 
	        	}
	        	
	        	//Gravar as fotos escolhido pelo usuario que esta logado e inserindo
	        	if (!empty($_GET['maisFt'])){
	            	//echo "if";	
	            	$idAtendeContrato = $_GET['maisFt'];
	            	$foto = $_FILES['foto'];
	            	//print_r($foto);
	            	//cadastrar as fotos
					$img = new UploadIMGAdquacao();
					$nomeFoto = $img->imagem($foto, $idAtendeContrato);
					
					?>
					<script type="text/javascript">
					var id = "<?php echo $_SESSION['idConttrato'];?>";
					window.location="fotosAdequacaoCliente.php?idContrato="+id; 
					</script> 
					<?php
	            	
	            } else {
	        		//echo "else";
		        	$conDAO = new ContratoDAO();
		        	$arrayFoto = $conDAO->ListaFotoAdquacaoCliente($id);
		        	$idDataContrato = null;
		        	$nContrato = null;
		        	foreach ($arrayFoto as $conDAO => $f){
		        		$idDataContrato = $f['id_data_contrato'];
		        		$nContrato = $f['contrato_id'];
		        	}
		        	$_SESSION['idConttrato'] = $nContrato;
	            }
	            
	        }
	        
	        ?>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Upload de mais fotos
                            <?php //echo $_SESSION['maisFt'];?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                           
                            <!-- Tab panes -->
                            <div class="row">
								<form action="fotosAdequacaoCliente.php?maisFt=<?php echo $idDataContrato; ?>&idContrato=<?php echo $nContrato; ?>" method="post" enctype="multipart/form-data">
									<div class="col-lg-9" align="left"><input type="file" name="foto"></div>
									<div class="col-lg-3" align="right"><input type="submit" value="salvar foto" class="btn btn-default"></div>
								</form>
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
            
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Lista foto de adquacao do cliente
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
	                    	
                            <?php foreach ($arrayFoto as $conDAO => $valor){ ?>
								<img alt="" src="Img/chamados_atendidos/<?php echo $valor['foto']; ?>" width="100%" height="100%"><br><br>
							<?php } ?>
						
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