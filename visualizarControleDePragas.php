<?php 
session_start();

include_once 'Model/DAO/ContratoDAO.php';

?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Visulizar controle de pragas por grafico e contrato</title>

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
			case 'visualizarControleDePragas' : $as = 15;   break ;
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
                    <h1 class="page-header">Visualizar graficos de pragas por contratos</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <?php 
            //Lista todos os contratos que esta em aberto ou em andamento
            $conDAO = new ContratoDAO();
            $arrayContratos = $conDAO->ListaPeloControlePragas();
            if (!empty($arrayContratos)){
            ?>
            <!-- comeca a lista de setores -->
            <div class="row">
                <div class="col-lg-12">
                   
                       
                        <form action="" method="post">
							<div class="panel panel-primary">
								<div class="panel-heading">Informe o contrato</div>
								<div class="panel-body">
									<div class="form-group">
										<label>Informe o mes da visita</label> 
										<select id="" class="form-control" name="mes">
											<option value="0"></option>
			                                <option value="1">Janeiro</option>
			                                <option value="2">Fevereiro</option>
			                                <option value="3">Marco</option>
			                                <option value="4">Abril</option>
			                                <option value="5">Maio</option>
			                                <option value="6">Junho</option>
			                                <option value="7">Julho</option>
			                                <option value="8">Agosto</option>
			                                <option value="9">Setembro</option>
			                                <option value="10">Outubro</option>
			                                <option value="11">Novembro</option>
			                                <option value="12">Dezembro</option>
			                           </select>
									</div>
									<div class="form-group">
										<label>Informe o contrato</label> 
										<select id="" class="form-control" name="idContrato">
			                                <option value="0"></option>
			                                <?php foreach ($arrayContratos as $conDAO => $c){ ?>
			                                   <option value="<?php echo $c['id']; ?>"><?php echo $c['nome_contrato']; ?></option>
			                                <?php } ?>
			                           </select>
								   </div>
								</div>
								<div class="panel-footer">
									<input type="submit" class="btn btn-default" value="Visualizar"> <a
										href="index.php" class="btn btn-default">Volta</a>
								</div>
							</div>
						</form>
                        
                    
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <?php } ?>
            
            <?php 
            //Receber o get para fazer a lista
            if (!empty($_POST)){
            	
            	$idContrato = $_POST['idContrato'];
            	$mes        = $_POST['mes'];
            	
	            $conDAO = new ContratoDAO();
	            $arrayContra = $conDAO->ListaContraPeloId($idContrato, $mes);
	            //Verificar se tem resultado para mostra
	            if (!empty($arrayContra)){
	            	//Lista o contrato e o nome da praga
	            	$nomeContrato = null;
	            	$nomeMes    = null;
	            	$setor = null;
	            	foreach ($arrayContra as $conDAO => $valor){
	            		$nomeContrato = $valor['nome_contrato'];
	            		$nomeMes    = $valor['meses'];
	            		$nomeAno    = $valor['anos'];
	            		$setor = $valor['nome_setor'];
	            	}
            ?>
            
            <!-- Faz o carregamento do grafico -->
            <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
			  <script type="text/javascript">
			    google.charts.load("current", {packages:['corechart']});
			    google.charts.setOnLoadCallback(drawChart);
			
			   function drawChart() {
			      var data = google.visualization.arrayToDataTable([
			        ['Year', 'Pragas', { role: 'style' } ],
			        <?php foreach ($arrayContra as $conDAO => $dados){?>
			        ['<?php echo $dados['nome_pragas']; ?>', <?php echo $dados['qtd_pragas']; ?>, 'color: #76A7FA'],
			        <?php } ?>
			      ]);
			
			      var options = {
			        bar: {groupWidth: '50%'},
			        legend: { position: 'none' }
			      };
			
			      var chart = new google.visualization.ColumnChart(document.getElementById('columnchart_styles'));
			      chart.draw(data, options);
			  }
			  </script>
            
            <div class="row">
            	<!-- /.col-lg-12 -->
                <div class="col-lg-12">
                	 <div class="panel panel-default">
                        <div class="panel-heading">
                            Painel de grafico de pragas Contrato: <?php echo $nomeContrato ?> | Mes: <?php echo $nomeMes."-".$nomeAno; ?> 
                            | Setor: <?php echo $setor; ?>
                        </div>
                        <div class="panel-body">
	                		<!-- Imprimir o grafico -->
	                    	<div id="columnchart_styles"></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php } } ?>
                
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