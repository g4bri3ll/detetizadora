<?php
session_start();

include_once 'Model/DAO/TipoMoradiaDAO.php';
include_once 'Model/DAO/ClienteDAO.php';
include_once 'Model/Modelo/Cliente.php';
include_once 'Model/DAO/ComoEncontroDAO.php';

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

    <title>Cadastro de clientes</title>

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
			case 'cadastroClientes' : $as = 15;   break ;
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
					
					$valorGet = $_GET['idCli'];
					
					//Cadastro de pessoa juridica
					if ($valorGet == "2"){
					
						if (empty($_POST)){
							?> <font size="3px" color="red"> Preencha todos os campos </font> <?php
						} else {
							
							//Pegar os dados do post
							$nomeFantasia    = $_POST['nomeFantasia'];
							$razaoSocial     = $_POST['razaoSocial']; 
							$cnpj            = $_POST['cnpj'];
							$inscEstadMunici = $_POST['estadualMunicipal'];
							$NomeResponsavel = $_POST['nome'];
							$idComoEncontro  = $_POST['idComoEncontro'];
							$email           = $_POST['email'];
							$status          = "ativado";
							$dataCad         = date('Y-m-d');
							$telefone        = $_POST['telefone'];
							$celular         = $_POST['celular'];
							$ramal           = $_POST['ramal'];
							$cep             = $_POST['cep'];
							$cidade          = $_POST['cidade'];
							$endereco        = $_POST['endereco'];
							$numero          = $_POST['numero'];
							$bairro          = $_POST['bairro'];
					 		$complemento     = $_POST['complemento'];
					 		$referencia      = $_POST['pontoReferencia'];
					 		$observacoes     = $_POST['observacoes'];
					 		$nomeRepresetante = $_POST['nomeRepre'];
					 		$idt             = $_POST['idt'];
					 		$cpf             = $_POST['cpf'];
					 		$orgExpedidor    = $_POST['orgaoExpedidor'];
					 		
							
							//Verificar se ja existe um cadastro com esse usuario
							$cliDAO = new ClienteDAO();
							$arrayVerificar = $cliDAO->VerificaCadPJ($NomeResponsavel, $cnpj, $email, $status);
									
							if (empty($arrayVerificar)){
								
								$clienteJ = new Cliente();
								$clienteJ->nomeFantasia = $nomeFantasia;
								$clienteJ->razaoSocial = $razaoSocial;
								$clienteJ->cnpj = $cnpj;
								$clienteJ->estadualMunicipal = $inscEstadMunici;
								$clienteJ->nomeResponsavel = $NomeResponsavel;
								$clienteJ->idComoEncontro = $idComoEncontro;
								$clienteJ->email = $email;
								$clienteJ->status = $status;
								$clienteJ->dataCadastro = $dataCad;
								$clienteJ->telefone = $telefone;
								$clienteJ->celular = $celular;
								$clienteJ->ramal = $ramal;
								$clienteJ->cep = $cep;
								$clienteJ->cidade = $cidade;
								$clienteJ->endereco = $endereco;
								$clienteJ->numero = $numero;
								$clienteJ->bairro = $bairro;
								$clienteJ->complemento = $complemento;
								$clienteJ->referencia = $referencia;
								$clienteJ->observacoes = $observacoes;
								$clienteJ->nomeRepresentante = $nomeRepresetante;
								$clienteJ->idt = $idt;
								$clienteJ->cpf = $cpf;
								$clienteJ->orgExpedidor = $orgExpedidor;
								$clienteJ->tipoCliente = "PJ";
								
								
								$cliDAO = new ClienteDAO();
								$result = $cliDAO->cadastroPJ($clienteJ);
								
								if ($result){
									?>  <script type="text/javascript"> alert('Cliente cadastrado com sucesso!'); window.location="index.php"; </script>  <?php
								} else {
									?> <div class="alert alert-error"> <font size="3px" color="red"> Ocorreu um erro: <?php print_r($result); ?> </font> </div> <?php
								}
								
							} else {
								?> <div class="alert alert-error"> <font size="3px" color="#111"> Esse nome, cnpj e email ja esta cadastrado</font> </div> <?php
							} 
							
						}
						
					} 
					//Cadastro de pessoa fisica
					else if ($valorGet == "1"){
						
						if (empty($_POST)){
							?> <font size="3px" color="red"> Preencha todos os campos </font> <?php
						} else {
							
							$nome           = $_POST['nome'];
							$cpf            = $_POST['cpf'];
							$rg             = $_POST['rg'];
							$data           = $_POST['data'];
							$email          = $_POST['email']; 
							$sexo           = $_POST['sexo'];
							$status         = "ativado";
							$dataCad        = date('Y-m-d');
							$telefone       = $_POST['telefone'];
							$celular        = $_POST['celular'];
							$ramal          = $_POST['ramal'];
							$cep            = $_POST['cep'];
							$cidade         = $_POST['cidade'];
							$endereco       = $_POST['endereco'];
							$idComoEncontro = $_POST['idComoEncontro'];
							$email          = $_POST['email'];
							$bairro         = $_POST['bairro'];
					 		$complemento    = $_POST['complemento'];
					 		$pontoRefere    = $_POST['pontoReferencia'];
					 		$numero         = $_POST['numero'];
					 		
							
							
							//Verificar se ja existe um cadastro com esse usuario
							$cliDAO = new ClienteDAO();
							$arrayVerificar = $cliDAO->VerificaCadPF($nome, $cpf, $email, $status);
									
							if (empty($arrayVerificar)){
								
								$clienteF = new Cliente();
								$clienteF->nome           = $nome;
								$clienteF->cpf            = $cpf;
								$clienteF->rg             = $rg;
								$clienteF->status         = $status;
								$clienteF->dataCadastro   = $dataCad;
								$clienteF->sexo           = $sexo;
								$clienteF->email          = $email;
								$clienteF->dataNascimento = $data;
								$clienteF->tipoCliente    = "PF";
								$clienteF->telefone       = $telefone;
								$clienteF->ramal          = $ramal;
							 	$clienteF->cep            = $cep;
							 	$clienteF->celular        = $celular;
							 	$clienteF->cidade         = $cidade;
							 	$clienteF->endereco       = $endereco;
							 	$clienteF->idComoEncontro = $idComoEncontro;
							 	$clienteF->bairro         = $bairro;
							 	$clienteF->complemento    = $complemento;
							 	$clienteF->referencia     = $pontoRefere;
								$clienteF->numero         = $numero;
								
								$cliDAO = new ClienteDAO();
								$result = $cliDAO->cadastroPF($clienteF);
								
								if ($result){
									?>  <script type="text/javascript"> alert('Cliente cadastrado com sucesso!'); window.location="index.php"; </script> <?php
								} else {
									?> <font size="3px" color="red"> Ocorreu um erro: <?php print_r($result); ?> </font> <?php
								}
								
							} else {
								?> <font size="3px" color="red"> Esse nome, cpf e email ja esta cadastrado</font> <?php
							} 
							
						}
						
					}
					
				}
				?>
                
                    <h1 class="page-header">Cadastro de clientes</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Cadastro
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li>               <a href="#pf" data-toggle="tab">Pessoa fisica</a></li>
                                <li class="active"><a href="#pj" data-toggle="tab">Pessoa juridica</a></li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                            
                            
                            
                            
                            
                            <!-- Pessao Juridica ******************
                            ***************************************
                            ***************************************
                            ***************************************
                            ***************************************
                            ***************************************
                            ***************************************
                            -->
                            
                                <div class="tab-pane fade in active" id="pj">
                                    <div class="col-lg-1"></div>
	                                <div class="col-lg-10">
	                                    <form role="form" action="cadastroClientes.php?idCli=2" method="post">
	                                    <br><br>
	                                        <div class="form-group">
	                                        	<div class="row">
		                                        	<div class="col-lg-5">
			                                            <label>Nome fantasia</label>
			                                            <input class="form-control" placeholder="nome fantasia" name="nomeFantasia">
	                                        		</div><div class="col-lg-4">
			                                            <label>Razao social</label>
			                                            <input class="form-control" placeholder="Razao social" name="razaoSocial">
			                                        </div><div class="col-lg-3">
	                                            		<label>CPF/CNPJ</label>
	                                            		<input class="form-control" placeholder="CPF/CNPJ" name="cnpj">
	                                            	</div>
			                                    </div>        
	                                        </div>
	                                        <div class="form-group">
	                                        	<div class="row">
		                                        	<div class="col-lg-4">
	                                            		<label>Inscr.Estadual/municipal</label>
	                                            		<input class="form-control" placeholder="estadual/municipal" name="estadualMunicipal">
	                                            	</div><div class="col-lg-8">
	                                            		<label>Nome do responsavel</label>
	                                            		<input class="form-control" placeholder="Nome" name="nome">
	                                            	</div>
	                                            </div>
	                                        </div>
	                                        <div class="form-group">
	                                        	<div class="row">
		                                        	<div class="col-lg-5">
				                                        <label>Como encontro?</label>
				                                        <select id="" class="form-control" name="idComoEncontro">
				                                        	<option value=""></option>
					                                        <?php 
					                                        $comoDAO = new ComoEncontroDAO();
					                                        $arrayComo = $comoDAO->ListaAtivados();
					                                        foreach ($arrayComo as $comoDAO => $valor){
					                                        ?>
					                                        <option value="<?php echo $valor['id'];?>"><?php echo $valor['nome_encontrou']; ?></option>
				                                            <?php } ?>
				                                        </select>
			                                        </div><div class="col-lg-7">
	                                            		<label>Informe o email</label>
	                                            		<input class="form-control" placeholder="Email" name="email">
	                                            	</div>
			                                    </div>
			                                </div><br>
	                                        
	                                        <!-- Segunda -->
	                                        <ul class="nav nav-tabs">
                                				<li class="active"><a href="#pj_telefone" data-toggle="tab"><font color="#9932CC" size="3">Telefones</font></a></li>
                                				<li>               <a href="#pj_endereco" data-toggle="tab"><font color="#9932CC" size="3">Endereco</font></a></li>
                                				<li>               <a href="#pj_observacoes" data-toggle="tab"><font color="#9932CC" size="3">Observacoes</font></a></li>
                                				<li>               <a href="#pj_represe" data-toggle="tab"><font color="#9932CC" size="3">Representate Legal</font></a></li>
                            				</ul>
	                                        <br>
	                                        <div class="tab-content">
                                				<div class="tab-pane fade in active" id="pj_telefone">
                                    				<div class="col-lg-12">
	                                    				<div class="form-group">
	                                    			    	<div class="row">
					                                        	<div class="col-lg-5">
				                        		                    <label>Celular com DDD</label>
				                                		            <input class="form-control" placeholder="Numero do celular" name="celular">
				                                		        </div><div class="col-lg-5">
				                        		                    <label>Numero com DDD</label>
				                                		            <input class="form-control" placeholder="Telefone" name="telefone">
				                                		        </div><div class="col-lg-2">
				                        		                    <label>Ramal</label>
				                                		            <input class="form-control" placeholder="Ramal" name="ramal">
				                                		        </div>
				                                		    </div>
				                                	    </div>
                                    				</div>
	                                        	</div>
	                                        	<div class="tab-pane fade" id="pj_endereco">
                                    				<div class="col-lg-12">
                                    					<div class="form-group">
	                                    					<div class="row">
					                                        	<div class="col-lg-3">
				                        		                    <label>Cep</label>
				                                		            <input class="form-control" placeholder="Cep" name="cep">
				                                		        </div><div class="col-lg-4">
				                        		                    <label>Cidade</label>
				                                		            <input class="form-control" placeholder="Cidade" name="cidade">
				                                		        </div><div class="col-lg-5">
				                        		                    <label>Endereco</label>
				                                		            <input class="form-control" placeholder="Endereco" name="endereco">
				                                		        </div>
				                                		    </div>
				                                		</div><div class="form-group">
				                                		    <div class="row">
					                                        	<div class="col-lg-3">
				                        		                    <label>N</label>
				                                		            <input class="form-control" placeholder="Numero" name="numero">
				                                		        </div><div class="col-lg-9">
				                        		                    <label>Bairro</label>
				                                		            <input class="form-control" placeholder="Bairro" name="bairro">
				                                		        </div>
				                                		    </div>
				                                		</div><div class="form-group">
				                                		    <div class="row">
					                                        	<div class="col-lg-5">
				                        		                    <label>Referencia</label>
				                                		            <input class="form-control" placeholder="referencia" name="pontoReferencia">
				                                		        </div><div class="col-lg-7">
				                        		                    <label>Complemento</label>
				                                		            <input class="form-control" placeholder="Complemento" name="complemento">
				                                		        </div>
				                                		    </div>
				                                		</div>
                                    				</div>
	                                        	</div>
	                                        	<div class="tab-pane fade" id="pj_observacoes">
	                                        		<div class="form-group">
		                                        		<div class="row">
		                                    				<div class="col-lg-12">
		                                    					<label>Observacoes</label>
		                                    					<textarea rows="5" cols="100%" name="observacoes"></textarea>
		                                    				</div>
		                                    			</div>
	                                    			</div>
	                                        	</div>
	                                        	<div class="tab-pane fade" id="pj_represe">
                                    				<div class="form-group">
	                                    			   	<div class="row">
					                                       	<div class="col-lg-5">
				                        		                   <label>Nome do representante</label>
				                                	            <input class="form-control" placeholder="Nome do representante" name="nomeRepre">
				                                	        </div><div class="col-lg-3">
				                        		                   <label>CPF</label>
				                                	            <input class="form-control" placeholder="CPF" name="cpf">
				                                	        </div><div class="col-lg-2">
				                        		                   <label>Identidade</label>
				                                	            <input class="form-control" placeholder="identidade" name="idt">
				                                	        </div><div class="col-lg-2">
				                        		                   <label>Orgao exp</label>
				                                	            <input class="form-control" placeholder="Orgao expedidor" name="orgaoExpedidor">
				                                	        </div>
				                                	    </div>
				                                	</div>
                                    				
                                    				<br>
                                    				<button type="submit" class="btn btn-default">Salvar e finalizar</button>
	                                        		<button type="reset" class="btn btn-default">Reset</button>
                                    				
	                                        	</div>
	                                        	
	                                        </div>
	                                        
	                                    </form>
	                                </div>
	                                <div class="col-lg-1"></div>
                                <!-- /.col-lg-6 (nested) -->
                                </div>
                                
                                <!-- /Pessao Juridica *****************
	                            ***************************************
	                            ***************************************
	                            ***************************************
	                            ***************************************
	                            ***************************************
	                            ***************************************
	                            -->
                                
                                
                                
                                
                                <!-- --------------------- ////////////////////////
                                */////////////////////////////////////////////////
                                */////////////////////////////////////////////////
                                */////////////////////////////////////////////////
                                */////////////////////////////////////////////////
                                */////////////////////////////////////////////////-->
                                
                                <div class="tab-pane fade" id="pf">
                                    <div class="col-lg-1"></div>
	                                <div class="col-lg-10">
	                                    <form role="form" action="cadastroClientes.php?idCli=1" method="post">
	                                    <br><br>
	                                        <div class="form-group">
	                                        	<div class="row">
		                                        	<div class="col-lg-8">
			                                            <label>Informe o nome</label>
			                                            <input class="form-control" placeholder="Nome do cliente" name="nome">
		                                        	</div><div class="col-lg-4">
			                                           	<label for="disabledSelect">Sexo</label>
			                                           	<select id="" class="form-control" name="sexo">
			                                           	  <option value="M">Masculino</option>
			                                              <option value="F">Feminino</option>
			                                           	</select>
		                                           	</div>
	                                           	</div>
	                                        </div>
	                                        <div class="form-group">
	                                        	<div class="row">
		                                        	<div class="col-lg-5">
			                                    		<label>Informe o CPF</label>
	           			                                <input class="form-control" placeholder="CPF" name="cpf">
	                                        		</div><div class="col-lg-4">
	                        		                    <label>Informe a identidade</label>
	                                		            <input class="form-control" placeholder="RG" name="rg">
	                                		        </div><div class="col-lg-3">
			                                            <label>Data de nascimento</label>
			                                            <input type="date" class="form-control" name="data">
			                                        </div>
	                                		    </div>
	                                        </div>
	                                        <div class="form-group">
	                                        	<div class="row">
		                                        	<div class="col-lg-5">
			                                            <label>Como encontro?</label>
			                                            <select id="" class="form-control" name="idComoEncontro">
			                                            	<option value=""></option>
				                                            <?php 
				                                            $comoDAO = new ComoEncontroDAO();
				                                            $arrayComo = $comoDAO->ListaAtivados();
				                                            foreach ($arrayComo as $comoDAO => $valor){
				                                            ?>
				                                           	<option value="<?php echo $valor['id'];?>"><?php echo $valor['nome_encontrou']; ?></option>
			                                              	<?php } ?>
			                                           	</select>
			                                        </div><div class="col-lg-7">
			                                            <label>Informe o email</label>
			                                            <input class="form-control" placeholder="Email" name="email">
			                                        </div>
	                                		    </div>    
	                                        </div><br>
	                                        
	                                        
	                                        <!-- Segunda -->
	                                        <ul class="nav nav-tabs">
                                				<li class="active"><a href="#telefone" data-toggle="tab"><font color="#9932CC" size="3">Telefones</font></a></li>
                                				<li>               <a href="#endereco" data-toggle="tab"><font color="#9932CC" size="3">Endereco</font></a></li>
                                				<li>               <a href="#observacoes" data-toggle="tab"><font color="#9932CC" size="3">Observacoes</font></a></li>
                            				</ul>
	                                        <br>
	                                        <div class="tab-content">
                                				<div class="tab-pane fade in active" id="telefone">
                                    				<div class="col-lg-12">
	                                    				<div class="form-group">
	                                    			    	<div class="row">
					                                        	<div class="col-lg-5">
				                        		                    <label>Celular com DDD</label>
				                                		            <input class="form-control" placeholder="Numero do celular" name="celular">
				                                		        </div><div class="col-lg-5">
				                        		                    <label>Numero com DDD</label>
				                                		            <input class="form-control" placeholder="Telefone" name="telefone">
				                                		        </div><div class="col-lg-2">
				                        		                    <label>Ramal</label>
				                                		            <input class="form-control" placeholder="Ramal" name="ramal">
				                                		        </div>
				                                		    </div>
				                                	    </div>
                                    				</div>
	                                        	</div>
	                                        	<div class="tab-pane fade" id="endereco">
                                    				<div class="col-lg-12">
                                    					<div class="form-group">
	                                    					<div class="row">
					                                        	<div class="col-lg-3">
				                        		                    <label>Cep</label>
				                                		            <input class="form-control" placeholder="Cep" name="cep">
				                                		        </div><div class="col-lg-4">
				                        		                    <label>Cidade</label>
				                                		            <input class="form-control" placeholder="Cidade" name="cidade">
				                                		        </div><div class="col-lg-5">
				                        		                    <label>Endereco</label>
				                                		            <input class="form-control" placeholder="Endereco" name="endereco">
				                                		        </div>
				                                		    </div>
				                                		</div><div class="form-group">
				                                		    <div class="row">
					                                        	<div class="col-lg-3">
				                        		                    <label>N</label>
				                                		            <input class="form-control" placeholder="Numero" name="numero">
				                                		        </div><div class="col-lg-9">
				                        		                    <label>Bairro</label>
				                                		            <input class="form-control" placeholder="Bairro" name="bairro">
				                                		        </div>
				                                		    </div>
				                                		</div><div class="form-group">
				                                		    <div class="row">
					                                        	<div class="col-lg-5">
				                        		                    <label>Referencia</label>
				                                		            <input class="form-control" placeholder="referencia" name="pontoReferencia">
				                                		        </div><div class="col-lg-7">
				                        		                    <label>Complemento</label>
				                                		            <input class="form-control" placeholder="Complemento" name="complemento">
				                                		        </div>
				                                		    </div>
				                                		</div>
                                    				</div>
	                                        	</div>
	                                        	<div class="tab-pane fade" id="observacoes">
	                                        		<div class="form-group">
		                                        		<div class="row">
		                                    				<div class="col-lg-12">
		                                    					<label>Observacoes</label>
		                                    					<textarea rows="5" cols="100%" name="observacoes"></textarea>
		                                    				</div>
		                                    			</div>
	                                    			</div>
	                                    			
	                                    			<br>
                                    				<button type="submit" class="btn btn-default">Salvar e finalizar</button>
	                                        		<button type="reset" class="btn btn-default">Reset</button>
	                                        		
	                                        	</div>
	                                        </div>
	                                        
	                                    </form>
	                                </div>
	                                <div class="col-lg-1"></div>
                                <!-- /.col-lg-6 (nested) -->
                                </div>
                                
                                <!-- / Pessoa fisica ------ ////////////////////////
                                */////////////////////////////////////////////////
                                */////////////////////////////////////////////////
                                */////////////////////////////////////////////////
                                */////////////////////////////////////////////////
                                */////////////////////////////////////////////////-->
                                
                                
                                
                                
                                
                                
                                
                                
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

<?php 
	} else {
		header("Location: index.php");
	} 
} //Fecha a session que verifica se esta vazio 
?>

</body>
</html>