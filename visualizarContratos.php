<?php
session_start();

include_once 'Model/DAO/DataDAO.php';
include_once 'Model/DAO/ContratoDAO.php';

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

    <title>Visualizar contrato do cliente</title>

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

<?php
//Pegar o id do cliente da session para ver o contrato
$idSession = $_SESSION['id_c'];

if (!empty($idSession)){
//Lista o contrato pelo id do cliente na session
$conDAO = new ContratoDAO();
$arrayContrato = $conDAO->ListaContratoParaCalendario($idSession);
} else if ($_SESSION['nivel'] === md5("Impar@2019$")){
//Lista todos os nome de contrato para o select
$conDAO = new ContratoDAO();
$arrayListaContrato = $conDAO->VisualizarContratosAdm();
} 
?>


<?php 
//Receber o id para lista o contrato escolhido no select
if (!empty($_GET['cont'])){
	
	if (!empty($_POST)){
		
		if (empty($_POST)){
			echo "Erro campo vazio invalido";
		} else {
			
			$idContrato = $_POST['idContrato'];
			
			//buscar o contrato pelo ADM, se ele seleciona o contrato no select, e traz o renovo do contrato caso existe
			$conDAO = new ContratoDAO();
			$arrayValidaContrato = $conDAO->BuscarContratoPeloIdParaVisualiza($idContrato);
			$arrayContrato = $arrayValidaContrato['contrato'];
			
			
		}
		
	}
	
} 
?>



<?php 
//Receber o get de visualizar as extensões do contrato
if (!empty($_GET['ext'])){
	
	$idRenovoContt = $_GET['ext'];
	
	$conDAO = new ContratoDAO();
	$arrayContrato = $conDAO->MostraRenovoContratoPVisualiza($idRenovoContt);
	
}
?>



<div id="page-wrapper">
	<div class="row"><br><br>
		<div class="col-lg-1"></div>
    	<div class="col-lg-10">
    	
<?php 
//Verificar se a session e do usuario
if (empty($_SESSION['id_c'])){
?>
        	<div class="panel panel-default">
				<div class="panel-body">
                	<div class="row">
                    	<div class="col-lg-1"></div>
                        <div class="col-lg-10">
							<div class="form-group">
								<form action="visualizarContratos.php?cont=304950sllw0494" method="post">
									<label>Informe o contrato para lista</label>
									 <div class="form-group input-group">
		                             	<select id="" class="form-control" name="idContrato">
				                            <option value="0"></option>
				                            <?php 
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
} 

//Faz a listagem de acordo com o login da session, se for adm ele pedi o contrato primeiro
if (!empty($arrayContrato)){
	
	
$dataInicio = 0;
$dataFinal  = 0;
$nomeCliente = null;
$nomeContrato = null;
$statusrenovo = null;
foreach ($arrayContrato as $conDAO => $valor){
	if (!empty($valor['contrato_renovado'])){
		$statusrenovo = $valor['contrato_renovado'];
	}	
	$dataInicio = $valor['data_inicio'];
	$dataFinal  = $valor['data_final'];
	if ($valor['tipo_cliente'] === "PF"){
		$nomeCliente = $valor['nome'];
	} else {
		$nomeCliente = $valor['nome_fantasia'];
	}
	$nomeContrato = $valor['nome_contrato'];
}


//Criar um array de mes
$arrayMes = array(
1 => 'Janeiro',
2 => 'Fevereiro',
3 => 'Marco',
4 => 'Abril',
5 => 'Maio',
6 => 'Junho',
7 => 'Julho',
8 => 'Agosto',
9 => 'Setembro',
10 => 'Outubro',
11 => 'Novembro',
12 => 'Dezembro'
);

//array dia ingles
$arrayDia = array(
0 => 'Sunday',
1 => 'Monday',
2 => 'Tuesday',
3 => 'Wednesday',
4 => 'Thursday',
5 => 'Friday',
6 => 'Saturday'
);


$dataDAO = new DataDAO();
$arrayData = $dataDAO->ListaDataApartirHoje($dataInicio, $dataFinal);


$anoMesBanco = array();
$mesAtual = null;
//Array de mes e ano

$b = 1;
$c = 0;
$a = 0;

for ($va = 0; $va < count($arrayData); $va++){

	$anoMes = date('Y-m', strtotime($arrayData[$va]['data']));

	if ($anoMes <> $mesAtual){
			
		//Pegar os mes e ano
		$anoMesBanco[] = date('Y-m', strtotime($arrayData[$va]['data']));
			
		//Pegar o mes e o ano para quer no if
		$mesAtual = date('Y-m', strtotime($arrayData[$va]['data']));
			
	}

}

?>



<?php
//Verificar se este contrato possui extensao para mostra 
if (!empty($arrayValidaContrato['renovaContrato'])){ ?>
<div class="row">
	<div class="col-lg-3"></div>
	<div class="col-lg-6">
		<h3>Extensao do contrato:</h3>
		<table class="table table-striped table-bordered table-hover">
			<tr>
				<th>Data inicio</th>
				<th>Data final</th>
				<th>Mostra extensao?</th>
			</tr>
			<?php foreach ($arrayValidaContrato['renovaContrato'] as $listExtens){ ?>
			<tr>
				<td><?php echo date('d-m-Y', strtotime($listExtens['data_inicio'])); ?></td>
				<td><?php echo date('d-m-Y', strtotime($listExtens['data_final'])); ?></td>
				<td><a href="visualizarContratos.php?ext=<?php echo $listExtens['id']; ?>">Visualiza</a></td>
			</tr>
			<?php } ?>
		</table>
		<div class="col-lg-3"></div>
	</div>
</div><br><br>
<?php } ?>



<?php if (!empty($arrayRenovoContrato)){?>

<h3>Visualizar extensoes?</h3>
<?php foreach ($arrayRenovoContrato as $conDAO => $renContt){ ?>
<a href="visualizarContratos.php?ext=<?php echo $renContt['id']; ?>"><i class="fa fa-eye fa-fw"></i></a>
<h5><?php echo "Visualizar o contrato com data: " . $renContt['data_inicio'] . " ate " . $renContt['data_final']; ?></h5>
<?php } ?>

<?php }///fecha o if que verifica se existe extensão do contrato ?>

<h4>Contrato<?php if (!empty($statusrenovo)) {echo " renovado"; } ?>: <?php echo $nomeContrato; ?> | do(a) cliente: <?php echo $nomeCliente; ?> | Periodo: <?php echo date('d-m-Y', strtotime($dataInicio)); ?> a <?php echo date('d-m-Y', strtotime($dataFinal)); ?></h4>
<?php
 
for ($a = 0; $a < count($anoMesBanco); $a++){

	$mes = date('m', strtotime($anoMesBanco[$a]));
	$ano = date('Y', strtotime($anoMesBanco[$a]));

	$valorMesSemZero = intval(date($mes));

	$listaMes = $arrayMes[$valorMesSemZero];
	?>

	<?php if ($a >= $c){ $c = $c + 3; ?>
	<div class="row">
	<?php } ?>


		<div class="col-lg-4">

			<table class="table table-striped table-bordered table-hover"
				id="dataTables-example">

				<tr>
					<td valign="top" align="center" colspan="7" bgcolor="#FFCC00"><b><font
							face="Arial" size="3"><?php echo $listaMes; ?> <?php echo $ano; ?>
						</font> </b></td>
				</tr>

				<tr>
					<td valign="top" align="center" bgcolor="#CCFF99"><font size="1"
						face="Arial"><b>Dom</b> </font></td>
					<td valign="top" align="center" bgcolor="#CCFF99"><font size="1"
						face="Arial"><b>Seg</b> </font></td>
					<td valign="top" align="center" bgcolor="#CCFF99"><font size="1"
						face="Arial"><b>Ter</b> </font></td>
					<td valign="top" align="center" bgcolor="#CCFF99"><font size="1"
						face="Arial"><b>Qua</b> </font></td>
					<td valign="top" align="center" bgcolor="#CCFF99"><font size="1"
						face="Arial"><b>Qui</b> </font></td>
					<td valign="top" align="center" bgcolor="#CCFF99"><font size="1"
						face="Arial"><b>Sex</b> </font></td>
					<td valign="top" align="center" bgcolor="#CCFF99"><font size="1"
						face="Arial"><b>Sab</b> </font></td>
				</tr>

				<?php
				//Buscar as data de acordo com o mes e ano
				$dataDAO = new DataDAO();
				$arrayDt = $dataDAO->ListaDataCompletaPeloMesAno($valorMesSemZero, $ano);
					
				$aa = 0;
				$par = 0;
				//Lista as data pelo array enviado no arrayDt
				for ($p = 0; $p < count($arrayDt); $p++){

					//Se o $p for maior que $we que e 6 para lista a semana toda em horizontal ele faz para quebra
					if ($par < 1){ ?>
				<tr>
				<?php }
					
				//Verificar a data para lista no dia certo
				if ($arrayDt[$p]['nome_do_dia_da_semana'] === $arrayDia[$aa]){
					
					//Verificar se e a mesma data que obteve no contrato para lista
					

					if ($dataInicio > $arrayDt[$p]['data']){
						?>
					<td valign="top" align="center"><font size="1" face="Arial"
						color="red"> <b><?php echo $arrayDt[$p]['dia']; ?> </b> </font></td>
						<?php
					} else if ($dataFinal < $arrayDt[$p]['data']){
						?>
					<td valign="top" align="center"><font size="1" face="Arial"
						color="red"> <b><?php echo $arrayDt[$p]['dia']; ?> </b> </font></td>
						<?php
					} else {
						
						
						$inicia = 0;
						//Lista somente os dias do contrato de azul
						for ($ia = 0;$ia < count($arrayContrato); $ia++){
							
							if (empty($inicia)){
								if (($arrayContrato[$ia]['dia_semana'] === $arrayDt[$p]['dia']) && $arrayContrato[$ia]['meses'] === $arrayDt[$p]['nome_do_mes']){
									$inicia = 1;
								} else { $inicia = 0; }
							}
							
						}
						if (empty($inicia)){
							?><td valign="top" align="center"><font size="1" face="Arial"> <b><?php echo $arrayDt[$p]['dia']; ?></b></font></td><?php
						} else {
							?><td valign="top" align="center"><font size="1" face="Arial" color="blue"> <b><?php echo $arrayDt[$p]['dia']; ?></b></font></td><?php
						}
						
						
					}

				}//Fecha o if que verificar se o dia da semana e o mesmo da data
					
				if ($arrayDt[$p]['nome_do_dia_da_semana'] !== $arrayDia[$aa]){
					//Receber o menos um no $p se o nome da semana no banco for menor
					$p = $p - 1;
					?>
					<td valign="top" align="center"><font size="1" face="Arial"> <b>00</b>
					</font></td>
					<?php }//fecha o else que verificar se esta no mesmo dia

					//Neste if verificar se o $p e maior que $we. Ele ganha ele mesmo mais 7 e o $p diminuir menos um para não perder o valor que esta sendo passado
					if ($par > 5){ ?>
				</tr>
				<?php $par = 0; } else { $par = $par + 1; }

				$aa = $aa + 1;

				//Se a for maior do 6 ou igual ele zera novamente para lista
				if ($aa > 6){ $aa = 0; }
					

				}//Fechar o for que lista as datas
				
				?>

			</table>

		</div>

		<?php if ($a > $b){ $b = $b + 3;?>
	</div>
	<?php  } ?>


	<?php
	}//Fecha o for que lista os meses com anos
}
?>

				</div>
				<div class="col-lg-1"></div>
			</div>
		</div>
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