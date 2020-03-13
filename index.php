<?php 
session_start();

include_once 'Model/Entity/EntityContrato.php';
include_once 'Model/DAO/AcessoSistemaDAO.php';
include_once 'Model/DAO/ClienteDAO.php';
include_once 'Model/DAO/UsuarioDAO.php';
include_once 'Model/Entity/EntityData.php';

//Colocar todos os dados na session
if (!empty($_SESSION)){
	
	//Cancelar contrato sem ter concluido pelo sistema
	//$entContrato = new EntityContrato();
	//$entContrato->CancelarContratoPeloSistema();
	
	
	//Lista as datas 
	$entityData = new EntityData();
	$entityData->CadastraDatas();
	
	
	//Excluir o tipo de servico e funcionario caso o usuario sair da tela de contrato.php
	$delete = new EntityContrato();
	$delete->ExcluirTipoServicoEFuncionario();
		
	
	//Excluir o tipo de servico, quando o usuario sair da tela de renovaContratos
	$delete = new EntityContrato();
	$delete->ExcluirTipoServicoContratoRenova();
	
	
	//Mantando a session das datas do contratos se caso o usuario saia da tela
	if (!empty($_SESSION['dtInicio'])){ 
		unset( $_SESSION['dtInicio'] );
		unset( $_SESSION['dtFinal'] );
	}
	
	
	//Destroy a session da armadilhaIscagem.php
	unset( $_SESSION['nome_contrato'] );
	unset( $_SESSION['idContrato'] );
		
	
	//Destroy a session do renovaContratos.php
	unset( $_SESSION['dtaInicio'] );
	unset( $_SESSION['dtaFinal'] );
	unset( $_SESSION['renova_id_contrato'] );
											
	
	//Destroy a session caso o usuario saia do contrato sem fecha-lo
	if (!empty($_SESSION['idContratoSession'])){
		unset( $_SESSION['idContratoSession'] );
		unset( $_SESSION['tipo_servico'] );
		unset( $_SESSION['objeto'] );
		unset( $_SESSION['tipo_objeto'] );
		unset( $_SESSION['funcionario'] );
	}
	
	
	//Destroy a session caso o relatorio de ordemDeServicoPrograma.php não esteja concluido
	if (!empty($_SESSION['tipoServico'])){
		//destroy a session se estiver esse valores nela
		unset( $_SESSION['tipoServico'] );
		unset( $_SESSION['idDiaContrato'] );
		unset( $_SESSION['pragasAlvo'] );
	}
	
	
	//Fecha o contrato caso esteja passado da data para fechamento pela configuração do sistema
	$entFechaCont = new EntityContrato();
	$entFechaCont->FechaContrato();
	

	//Colocar os dados na session
	$aceDAO = new AcessoSistemaDAO();
	$aceDAO->DadosSession();
	

	//Verificar se na session tem alguma pagina de cadastro, lista ou outros para fazer o dropdwan, não pode apagar isso
	foreach ($_SESSION['nome_paginas'] as $key) {
		switch ($key) {
			case 'index'                             : $i    = 1;  break ;
			case 'contrato'                          : $c    = 2;  break ;
			case 'cadastroClientes'                  : $cc   = 3;  break ;
			case 'cadastroUsuario'                   : $cu   = 4;  break ;
			case 'cadastroAcessoSis'                 : $ca   = 5;  break ;
			case 'cadastrarAssinatura'               : $cas  = 6;  break ;
			case 'cadastraTipoMoradia'               : $ctm  = 7;  break ;
			case 'cadastroTipoDeServico'             : $cts  = 8;  break ;
			case 'cadastraObjetosDoServicos'         : $cos  = 9;  break ;
			case 'cadastroEmpresa'                   : $ce   = 10; break ;
			case 'contratosAbertos'                  : $cab  = 11; break ;
			case 'contratosEmAndamento'              : $cea  = 12; break ;
			case 'contratosFechados'                 : $cf   = 13; break ;
			case 'RelatoriosClientes'                : $rc   = 15; break ;
			case 'assinaContratos'                   : $ac   = 16; break ;
			case 'alteraSenhaColaborador'            : $asc  = 17; break ;
			case 'alteraSenha'                       : $as   = 18; break ;
			case 'criarAcessoSistema'                : $casi = 19; break ;
			case 'alteraCodigoAcesso'                : $aca  = 20; break ;
			case 'cadastroAjudar'                    : $caj  = 21; break ;
			case 'controleDePragas'                  : $cdp  = 22; break ;
			case 'visualizarControleDePragas'        : $vcp  = 23; break ;
			case 'RelatoriosOrdemServico'            : $ros  = 24; break ;
			case 'RelatoriosDiaAtendidoPorContrato'  : $rdac = 25; break ;
			case 'relatorioOrdemServicoParaPrograma' : $rosp = 26; break ;
			case 'ordemDeServicoPrograma'            : $osp  = 27; break ;
			case 'ordemDeServico'                    : $os   = 28; break ;
			case 'justificarControleDePragas'        : $jcp  = 29; break ;
			case 'geraRelatorio'                     : $gr   = 30; break ;
			case 'calendario'                        : $cal  = 31; break ;
			case 'cadastroComplementoClientes'       : $ccc  = 32; break ;
			case 'cadastraSetor'                     : $cs   = 33; break ;
			case 'cadastrarProduto'                  : $cp   = 34; break ;
			case 'cadastraPragas'                    : $cpr  = 35; break ;
			case 'atender'                           : $ate  = 36; break ;
			case 'ajudar'                            : $aju  = 37; break ;
			case 'RelatorioControlePraga'            : $rcp  = 38; break ;
			case 'visualizarRespostaControleDePragas': $vrcp = 39; break ;
			case 'configuracao'                      : $conf = 40; break ;
			case 'armadilhaIscagem'                  : $ai   = 14; break ;
			case 'finalizarContratos'                : $fc   = 41; break ;
			case 'adquacao'                          : $adq  = 42; break ;
			case 'alteraAcessoSistema'               : $aasis= 43; break ;
			case 'visualizaClientes'                 : $vcli = 44; break ;
			case 'cadastraComoEncontro'              : $ccen = 45; break ;
			case 'visualizaFuncionarios'             : $visf = 46; break ;
			case 'listaClientes'                     : $lcli = 47; break ;
			case 'listaFuncionarios'                 : $lisf = 48; break ;
			case 'permissaoAcessoSistema'            : $peas = 49; break ;
			case 'renovaContratos'                   : $reco = 50; break ;
			case 'listaAcessoSistema'                : $lias = 51; break ;
			case 'visualizarContratos'               : $visc = 52; break ;
			case 'excluirContratos'                  : $econ = 53; break ; 
			
			
		}
		
	}
	
}
?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Index</title>

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

<?php  if (empty($_SESSION['id_c']) && empty($_SESSION['id_f'])){ header('Location: login.php'); } else { ?>

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
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['login']; ?></a></li>
                        <?php if (!empty($conf) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?>
                        <li><a href="configuracao.php"><i class="fa fa-gear fa-fw"></i> Config</a></li>
                        <?php } ?>
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
                        <?php //Verificar se o usuario tem permissão para fazer algum cadastro no sistema 
			 			if (!empty($i) || $_SESSION['nivel'] === md5("Impar@2019$")){?>
                        <li>
                            <a href="index.php"><i class="fa fa-home fa-fw"></i> Home </a>
                        </li>
                        <?php } if (!empty($cc) || !empty($cu) || !empty($ca) || !empty($cas) || !empty($ctm) || !empty($cts) || !empty($cos) || 
                        !empty($cto) || !empty($ce) || !empty($caj) || !empty($cs) || !empty($cpr) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?>
                        <li>
                            <a href="#"><i class="fa fa-edit fa-fw"></i> Cadastro<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            	<?php if (!empty($cc) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="cadastroClientes.php">Cadastro de clientes</a></li>                  <?php }?>
                                <?php if (!empty($cu) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="cadastroUsuario.php">Cadastro de funcionarios</a></li>               <?php }?>
                                <?php if (!empty($ca) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="cadastroAcessoSis.php">Cadastrar acesso ao sistema</a></li>          <?php }?>
                                <?php if (!empty($cas) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="cadastrarAssinatura.php">Cadastrar assinatura</a></li>               <?php }?>
                                <?php if (!empty($ctm) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="cadastraTipoMoradia.php">Cadastra tipo de moradia</a></li>           <?php }?>
                                <?php if (!empty($cts) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="cadastroTipoDeServico.php">Cadastra o tipo de servico</a></li>       <?php }?>
                                <?php if (!empty($cos) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="cadastraObjetosDoServicos.php">Cadastra o objeto do servico</a></li> <?php }?>
                                <?php if (!empty($cp) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="cadastrarProduto.php">Cadastra de produto</a></li>                   <?php }?>
                                <?php if (!empty($ce) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="cadastroEmpresa.php">Cadastrar a empresa</a></li>                     <?php }?>
                                <?php if (!empty($caj) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="cadastroAjudar.php">Cadastra ajuda</a></li>                          <?php }?>
                                <?php if (!empty($cs) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="cadastraSetor.php">Cadastra setor</a></li>                           <?php }?>
                                <?php if (!empty($cpr) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="cadastraPragas.php">Cadastra de pragas</a></li>                      <?php }?>
                                <li><a href="cadastraTextosRelatorios.php">Cadastro de txt p/ relatorios</a></li>
                                <li><a href="cadastraComoEncontro.php">Cadastrar como encontro</a></li>
                                <li><a href="cadastroLogoMarcaCliente.php">Cadastrar logo marca</a></li>
                                
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <?php } if (!empty($ai) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?>
                        <li>
                            <a href="armadilhaIscagem.php"><i class="glyphicon glyphicon-piggy-bank glyphicon-fw"></i> Armadilhas/ Iscagem </a>
                        </li>
                        <?php } if (!empty($adq) || $_SESSION['nivel'] === md5("Impar@2019$")){  ?>
                        <li>
                            <a href="adquacao.php"><i class="fa fa-lemon-o fa-fw"></i> Adquacoes </a>
                        </li>
                        <?php } ?>
                        
                        
                        
                        <li>
                            <a href="listAdquacao.php"><i class="fa fa-lemon-o fa-fw"></i> Lista Adquacoes </a>
                        </li>
                        
                        
                        
                        <?php  if (!empty($c) || !empty($cab) || !empty($cea) || !empty($cf) || !empty($visc) || !empty($reco) || !empty($econ) || $_SESSION['nivel'] === md5("Impar@2019$")) {?>
                        
                        <li>
                            <a href="#"><i class="fa fa-briefcase fa-fw"></i> Contratos <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            	
                            	<?php if (!empty($c) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?>
		                        <li>
		                            <a href="contrato.php"> Criar Contratos </a>
		                        </li>
                                <?php } if (!empty($cab) || !empty($cea) || !empty($cf) || $_SESSION['nivel'] === md5("Impar@2019$")) {?>
                                <li>
		                            <a href="#"><i class="fa fa-file-text-o fa-fw"></i> Lista contrato <span class="fa arrow"></span></a>
		                            <ul class="nav nav-third-level">
		                                <?php if (!empty($cab) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="contratosAbertos.php">Contratos abertos</a></li>         <?php }?>
		                                <?php if (!empty($cea) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="contratosEmAndamento.php">Contratos em andamento</a></li><?php }?>
		                                <?php if (!empty($cf) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="contratosFechados.php">Contratos fechados</a></li>       <?php }?>
		                            </ul>
		                            <!-- /.nav-second-level -->
		                        </li>
		                        <?php } if (!empty($visc) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?>
		                        	<li><a href="VisualizarContratos.php"> Visualizar Contratos </a></li>
		                        <?php } if (!empty($reco) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?>
		                        	<li><a href="renovaContratos.php"> Renova Contratos </a></li>
		                        <?php } if (!empty($econ) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?>
		                        	<li><a href="excluirContratos.php"> Excluir Contratos </a></li>
		                        <?php } ?>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                     
                     
                        <?php } if (!empty($osp) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?> 
                        	<li><a href="ordemDeServicoPrograma.php"><i class="fa fa-trello fa-fw"></i> Ordem de servico / Programa</a></li>
                        	
                        	
                        	
                        <?php } if (!empty($lcli) || !empty($lisf) || !empty($lias) || !empty($peas) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?>
                        
                        <li>
                            <a href="#"><i class="fa fa-list fa-fw"></i> Listagens <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <?php if (!empty($lcli) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="listaClientes.php">Lista clientes</a></li><?php }?>
                                <?php if (!empty($lisf) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="listaFuncionarios.php">Lista funcionarios</a></li><?php }?>
                                <?php if (!empty($lias) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="listaAcessoSistema.php">Lista de acesso ao sistema</a></li><?php }?>
                                <?php if (!empty($peas) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="PermissaoAcessoSistema.php">Lista/ Altera permissoes de acesso dentro do sistema</a></li><?php }?>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        
                        <?php } if (!empty($os) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?>
                        <li>
                            <a href="ordemDeServico.php"><i class="fa fa-truck fa-fw"></i> Ordem de servico </a>
                        </li>
                        <?php } if (!empty($rc) || !empty($rdac) || !empty($ros) || !empty($rosp) || !empty($rcp) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?>
                        <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Relatorios <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                            	<?php if (!empty($ros) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="geraRelatorio.php?RelatoriosOrdemVistoria=537">            Ordem de vistoria</a></li><?php }?>
                                <?php if (!empty($rosp) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="geraRelatorio.php?RelatorioOrdemServicoParaPrograma=538">Ordem de servico para programa</a></li><?php }?>
                                <?php if (!empty($rcp) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="geraRelatorio.php?RelatorioControlePraga=539">           Controle de pragas</a></li><?php }?>
                                <?php if ($_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="geraRelatorio.php?RelatorioOrdemServicoComArmadilhaFuncionario=638">Ordem de servico com armadilhas funcionario</a></li><?php }?>
                                <?php if ($_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="geraRelatorio.php?RelatorioOrdemServicoComArmadilhaCliente=639">Ordem de servico com armadilha cliente</a></li><?php }?>
                                <?php if ($_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="geraRelatorio.php?RelatorioModeloOrdemServicoFuncionario=637">Modelo de ordem de servico funcionario</a></li><?php }?>
                                <?php if ($_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="geraRelatorio.php?RelatorioModeloOrdemServicoCliente=636">Modelo de ordem de servico cliente</a></li><?php }?>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <?php } if (!empty($ac)){ ?>
                        <li>
                            <a href="assinaContratos.php"><i class="fa fa-pencil fa-fw"></i> Assina Contratos </a>
                        </li>
                        <?php } if (!empty($asc) || !empty($as) || !empty($aca) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?>
                        <li>
                            <a href="#"><i class="fa fa-lock fa-fw"></i> Dados da conexao <span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <?php if (!empty($asc) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="alteraSenhaColaborador.php">Alterar uma senha</a></li>    <?php } ?>
                                <?php if (!empty($as) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?><li><a href="alteraSenha.php">Altera minha senha</a></li>               <?php } ?>
                                <?php //if (!empty($aca) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?><!-- <li><a href="alteraCodigoAcesso.php">Alterar o codigo de acesso</a></li>  --> <?php //} ?>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                        <?php } if (!empty($casi) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?>
                        <li>
                            <a href="criarAcessoSistema.php"><i class="fa fa-unlock fa-fw"></i> Acesso ao sistema </a>
                        </li>
                        <?php } if (!empty($cdp) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?>
                        <li>
                            <a href="controleDePragas.php"><i class="fa fa-bug fa-fw"></i> Controle de pragas </a>
                        </li>
                        <?php } if (!empty($vrcp) || $_SESSION['nivel'] === md5("Impar@2019$")){ ?>
                        <li>
                            <a href="visualizarRespostaControleDePragas.php"><i class="fa fa-eye fa-fw"></i> Visualizar resposta do controle de pragas </a>
                        </li>
                        <?php } if (!empty($jcp) || $_SESSION['nivel'] === md5("Impar@2019$")){?>
                        <li>
                            <a href="justificarControleDePragas.php"><i class="fa fa-ban fa-fw"></i> Justificatica de pragas </a>
                        </li>
                        <?php } if (!empty($vcp) || $_SESSION['nivel'] === md5("Impar@2019$")){?>
                        <li>
                            <a href="visualizarControleDePragas.php"><i class="fa fa-bar-chart-o fa-fw"></i> Visualizar controle de pragas por contratos </a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-briefcase fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
	                                <?php 
	                                //Lista a quantidade de contratos
	                                $conDAO = new ContratoDAO();
	                                $arrayQtd = $conDAO->QtdContratos();
	                                ?>
	                                <div class="huge"><?php echo count($arrayQtd); ?></div>
                                    <div>Contratos</div>
                                </div>
                            </div>
                        </div>
                        <a href="contratosAbertos.php">
                            <div class="panel-footer">
                                <span class="pull-left">Abertos ou em andamento</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-green">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="fa fa-briefcase fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
	                                //Lista a quantidade de contratos
	                                $conDAO = new ContratoDAO();
	                                $arrayQtdF = $conDAO->QtdContratosFechados();
	                                ?>
	                                <div class="huge"><?php echo count($arrayQtdF); ?></div>
                                    <div>Contratos</div>
                                </div>
                            </div>
                        </div>
                        <a href="contratosFechados.php">
                            <div class="panel-footer">
                                <span class="pull-left">Fechados</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-yellow">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="glyphicon glyphicon-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
	                                //Lista a quantidade de contratos
	                                $usuDAO = new UsuarioDAO();
	                                $arrayUsu = $usuDAO->QtdFuncionarios();
	                                ?>
	                                <div class="huge"><?php echo count($arrayUsu); ?></div>
                                    <div>Total!</div>
                                </div>
                            </div>
                        </div>
                        <a href="listaFuncionarios.php">
                            <div class="panel-footer">
                                <span class="pull-left">Funcionarios</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="panel panel-red">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-3">
                                    <i class="glyphicon glyphicon-user fa-5x"></i>
                                </div>
                                <div class="col-xs-9 text-right">
                                    <?php 
	                                //Lista a quantidade de contratos
	                                $cliDAO = new ClienteDAO();
	                                $arrayCli = $cliDAO->QtdClientes();
	                                ?>
	                                <div class="huge"><?php echo count($arrayCli); ?></div>
                                    <div>Total!</div>
                                </div>
                            </div>
                        </div>
                        <a href="listaClientes.php">
                            <div class="panel-footer">
                                <span class="pull-left">Clientes</span>
                                <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                <div class="clearfix"></div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->
		
		<?php } ?>
		
    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="vendor/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="vendor/metisMenu/metisMenu.min.js"></script>

    <!-- Morris Charts JavaScript -->
    <script src="vendor/raphael/raphael.min.js"></script>
    <script src="vendor/morrisjs/morris.min.js"></script>
    <script src="data/morris-data.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

</body>

</html>
