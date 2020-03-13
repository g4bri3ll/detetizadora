<?php 
session_start();

include_once 'Model/DAO/ContratoDAO.php';

//Excluir a session vindo da tela de fotosAdequacaoCliente.php
unset( $_SESSION['idConttrato'] );
unset( $_SESSION['maisFt'] );
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Adquacoes</title>

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
            
            <br><div class="panel panel-default">
				<div class="panel-body">
                	<div class="row">
                    	<div class="col-lg-1"></div>
                        <div class="col-lg-10">
							<div class="form-group">
								<form action="adquacao.php?listContt=52563655@%lkk" method="post">
									<label>Informe o contrato para lista</label>
									 <div class="form-group input-group">
		                             	<select id="" class="form-control" name="idContrato">
				                            <option value="0"></option>
				                            <?php 
				                            //Lista todos os contrato para o adm
											$conDAO = new ContratoDAO();
											$arrayListaContrato = $conDAO->ListaContratoParaAdquacao();
				                            foreach ($arrayListaContrato as $conDAO => $list){
				                            ?>
				                            <option value="<?php echo $list['id']; ?>"><?php echo $list['nome_contrato']; ?></option>
				                            <?php } ?>	
				                        </select>
                                        <span class="input-group-btn">
                                        	<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                                        </span>
                                	</div>
	                            </form>
	                    	</div>
	                	</div>
	            	</div>
	        	</div>
	    	</div>
            <?php
            //Excluir os dados da tabela selecionados por eles
            if (!empty($_GET['exc'])){
            	
            	$id = $_GET['exc'];
            	$status = "excluido";
            	$idContrato = $_GET['idCott'];
            	
            	$conDAO = new ContratoDAO();
            	$result = $conDAO->DesativaOrdDaAdquacao($status, $id);
            	
            	if ($result){
            		?> 
					<script type="text/javascript">
					var id = "<?php echo $idContrato;?>";
					window.location="adquacao.php?listContt="+id; 
					</script>  <?php
            	}
            	
            }

            //Salvar os dados da tabela caso esteja selecionado algum checkbox
            if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	                	
				if(isset($_POST['check'])){
            		
					if (!empty($_POST['check'])){
					
						$check      = $_POST['check'];
						$descricao  = $_POST['descricao'];
						$select     = $_POST['select'];
						$data       = $_POST['data'];
						
						$valida = false;
						$a = 0;
						for($i=0; $i < count($_POST['select']); $i++){
							
							if ($_POST['select'][$i] !== "0"){
								
								$conDAO = new ContratoDAO();
	            				$valida = $conDAO->AlteraAdquacaoTables($check[$a], $descricao[$i], $select[$i], $data[$i]);
								
	            				$a = $a + 1;
	            				
							}
							
						}
						
						if ($valida){
							?> 
							<script type="text/javascript"> var id = "<?php echo $_SESSION['contrato_id'];?>"; 
							window.location="adquacao.php?listContt="+id; </script>  
							<?php
						} else {
							?> <br><font size="3px" color="red"> Ocorreu um erro: <?php print_r($valida); ?> </font><br><br> <?php
						}
						
					}
					
				}
            	
            }
            
            if (!empty($_GET['listContt'])){
            ?>
            
            
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Adquacao
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                            <form action="adquacao.php" method="post">
                            	<div align="right"> <input type="submit" value="salvar dados" class="btn btn-success"> </div><br>
                            	
	            					<?php 
	                            	if ($_GET['listContt'] === "52563655@%lkk"){
	                                    	//Colocar o id do contrato na session
	                                    	$idContrato = $_POST['idContrato'];
	                                    } else {
	                                    	$idContrato = $_GET['listContt'];
	                                    }
	                                    $conDAO = new ContratoDAO();
										$arrayAdquacao = $conDAO->ListaContratoEscolhidoPeloIdAdquacao($idContrato);
	            		
	             						if (!empty($arrayAdquacao)){
	             							
	             							//Matar a session do contrato para lista outro
	             							unset( $_SESSION['contrato_id'] );
	             							$_SESSION['contrato_id'] = $idContrato;
	             							
	             							
	                            	?>
	                            	
	                                <table class="table table-striped table-bordered table-hover">
	                                    <thead>
	                                        <tr>
	                                            <th>S</th>
	                                            <th>Data da criacao</th>
	                                            <th>Vis P/ Cliente</th>
	                                            <th>Descricao</th>
	                                            <th>Fotos</th>
	                                            <th>Del</th>
	                                        </tr>
	                                    </thead>
	                                    <tbody>
	                                    
	                                    <?php for($i = 0; $i < count($arrayAdquacao); $i++){ ?>
	                                        <tr>
	                                            <td><input type="checkbox" name="check[]" value="<?php echo $arrayAdquacao[$i]['id']; ?>" /></td>
	                                            <td><input type="date" name="data[]" value="<?php echo $arrayAdquacao[$i]['data_criacao']; ?>" class="form-control" /> </td>
	                                            <td>
	                                            	<select class="form-control" name="select[]">
	                                            		<option value="0"><?php echo $arrayAdquacao[$i]['visivel_cliente']; ?></option>
	                                            		
	                                            		<?php if ($arrayAdquacao[$i]['visivel_cliente'] !== "Sim"){ ?>
	                                            			<option value="Sim">Sim</option>
	                                            		<?php } if ($arrayAdquacao[$i]['visivel_cliente'] !== "Nao"){ ?>
	                                            			<option value="Nao">Nao</option>
	                                            		<?php } ?>
	                                            		
	                                            	</select>
	                                            </td>
	                                            <td><input type="text" name="descricao[]" value="<?php echo $arrayAdquacao[$i]['descricao']; ?>" class="form-control" /> </td>
	                                            <td><a href="fotosAdequacaoCliente.php?ft=<?php echo $arrayAdquacao[$i]['data_contrato_id']; ?>&idContrato=<?php echo $arrayAdquacao[$i]['contrato_id']; ?>">Visualiza</a></td>
	                                            <td align="center"><a href="adquacao.php?exc=<?php echo $arrayAdquacao[$i]['data_contrato_id']; ?>&idCott=<?php echo $arrayAdquacao[$i]['contrato_id']; ?>"> <i class="glyphicon glyphicon-trash"></i> </a></td>
	                                        </tr>
	                                    <?php } ?>    
	                                    </tbody>
	                                </table>
	                                
	                                <?php
	                                } else { 
	                                   	?>  <script type="text/javascript"> window.location="adquacao.php";  </script>  <?php 
	                                } 
	                                ?>
	                                
                                </form>
                            </div>
                            <!-- /.table-responsive -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
               
            </div>
            <!-- /.row -->
            <?php } ?>
            
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="../vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../vendor/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="../vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="../vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>

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