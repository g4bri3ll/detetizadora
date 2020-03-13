<?php

include_once 'Model/DAO/EmpresaDAO.php';
include_once 'Model/DAO/ContratoDAO.php';
include_once 'Model/DAO/PragasDAO.php';


//Atualizar com o fusio horario do brasil
date_default_timezone_set('America/Sao_Paulo');

//Pegar os dados da empresa
$empDAO = new EmpresaDAO();
$arrayEmpresa = $empDAO->ListaEmpresa();
$nomeIMG = null;
$nomeEmpresa = null;
$assinatura = 0;
$razaoSocial = null;
$telefone = null;
$email = null;
$endereco = null;
foreach ($arrayEmpresa as $empDAO => $valor){
	$nomeIMG = $valor['logo_marca'];
	$nomeEmpresa = $valor['nome'];
	$assinatura = $valor['assinatura_da_empresa'];
	$razaoSocial = $valor['razao_social'];
	$telefone = $valor['telefone'];
	$email = $valor['email'];
	$endereco = $valor['endereco'];
}

//Dados do usuario
$idDataContrato = $_GET['idOrd'];
$conDAO = new ContratoDAO();
$arrayVR = $conDAO->VisualizarRelatorioOrServico($idDataContrato);
$clienteNomeFantasia = null;
$clienteRazaoSocial = null;
$clienteCnpj = null;
$clienteEndereco = null;
$clienteCep = null;
$clienteTelefone = null;
$clienteDataInicioContrato = 0;
$clienteDataFinalContrato = 0;
$clienteNumero = 0;
$dtServico = 0;
$idRenovaContrato = 0;
$arrayRecFuncionraio = array();
$arrayRecServicos = array();
$idContrato = 0;
$status_contrato_renova_contrato = null;
$idRecContratoValida = 0;


for ($i = 0; $i < count($arrayVR); $i++){
	$clienteCep = $arrayVR[$i]['cep'];
	$clienteEndereco = $arrayVR[$i]['endereco'];
	$clienteNumero = $arrayVR[$i]['numero'];
	$dtServico = $arrayVR[$i]['data'];
	$clienteNomeFantasia = $arrayVR[$i]['nome_fantasia'];
	$clienteRazaoSocial = $arrayVR[$i]['razao_social'];
	$clienteCnpj = $arrayVR[$i]['cnpj'];
	$idRenovaContrato = $arrayVR[$i]['renova_contrato_id'];
	$idContrato = $arrayVR[$i]['id_contrato'];
	
	
	//Verificar se a data do renovo do contrato exite
	if (!empty($arrayVR[$i]['ren_contrato_data_inicio'])){
		$clienteDataInicioContrato = $arrayVR[$i]['ren_contrato_data_inicio'];
		$clienteDataFinalContrato = $arrayVR[$i]['ren_contrato_data_final'];
	} else {
		$clienteDataInicioContrato = $arrayVR[$i]['contrato_data_inicio'];
		$clienteDataFinalContrato = $arrayVR[$i]['contrato_data_final'];
	}
	
	
	
	//Pegando o array de funcionario
	$arrayRecFuncionraio[] = $arrayVR[$i]['nome_funcionario'];

	
	//Recebendo o array de servicos nome_servico
	$arrayRecServicos[] = $arrayVR[$i]['nome_servico'];
	
	
}

//Verificar se existe o id do renova contrato, então que dizer que e um renova contrato e não o contrato
if (!empty($idRenovaContrato)){
	$status_contrato_renova_contrato = "renova_contrato";
	$idRecContratoValida = $idRenovaContrato;
} else {
	$status_contrato_renova_contrato = "contrato";
	$idRecContratoValida = $idContrato;
}

//Pegando apenas o array de funcionario sem reepetir
$arrayFuncionario = array_unique($arrayRecFuncionraio);


//Pegando o tipo de servico sem repetir
$arrayServico = array_unique($arrayRecServicos);


?>
<html>
<head>

</head>
<body style="background-color: #696969;">



<div style="float: center; width: 75%; background-color: #FFFAFA; position: absolute;">



<!-- Cabeçalho-->
<div style="background-color: back; text-align: center; width: 100%;  height: 100px;">
	<div style="width: 20%; float: left;"><img alt="" src="Img/empresa/<?php echo $nomeIMG ?>"></div>
	<div style="width: 55%; float: left;"><font size="5"><?php echo $nomeEmpresa; ?></font><br /> <?php echo $razaoSocial ?> <br> Telefone: <?php echo $telefone ?> | Email: <?php echo $email ?> <br> <?php echo $endereco ?> <br> 000034/2019</div>
	<div style="width: 25%; float: left;">Ordem de servico <br> Certificado de Execucao <br> N ____ <br> Via do funcionario</div>
</div><br />

<!-- Menu da pagina -->
<div style="width: 100%; background-color: lime;">
	Nome fantasia: <?php echo $clienteNomeFantasia; ?> | Razao social: <?php echo $clienteRazaoSocial; ?> | CNPJ: <?php echo $clienteCnpj; ?> | Cod. Cliente: __ | IE 
</div>

<div style="width: 100%;">
	Endereco: <?php echo $clienteEndereco ?>, n <?php echo $clienteNumero; ?> | CEP: <?php echo $clienteCep ?> | (______________________________) <br> 
	Telefone(s): <?php echo $clienteTelefone; ?> Validade do contrato: <?php echo date('d-m-Y', strtotime($clienteDataInicioContrato)); ?> a <?php echo date('d-m-Y', strtotime($clienteDataFinalContrato)); ?>
</div>


<div style="background-color: lime;">
	Serv. ___ de <?php echo date('d-m-Y', strtotime($dtServico)) ?> das 08:00 as 18:00 | Dt real: __/__ | Hr real: __:__ as __:__ | Tp Ida: _____ | Tp Volta: ______ 
</div>
	

<table border="1" width="100%">
	<thead>
		<tr>
			<th style="width: 25%; font-size: 12;">Confirmou/Procurar:</th>
			<th style="width: 25%; font-size: 12;">Servico(s):</th>
			<th style="width: 25%; font-size: 12;">Dependencias:</th>
			<th style="width: 25%; font-size: 12;">Tecnico(s) Operador(es):</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="width: 25%; font-size: 12;"></td>
			<td style="width: 25%; font-size: 12;">
			<?php
			foreach ($arrayServico as $servicos){
				echo $servicos . "<br />";
			}
			?>
			</td>
			<td style="width: 25%; font-size: 12;"></td>
			<td style="width: 25%; font-size: 13;">
			<?php
			foreach ($arrayFuncionario as $funcionario){
					echo $funcionario . "<br />";
			}
			?>
			</td>
		</tr>
	</tbody>		
</table>



<?php 

//Receber o contrato para forma a tabela
$conDAO = new ContratoDAO();
$arrayCVR = $conDAO->ComplementoVisualizarRelatorioOrServico($idRecContratoValida, $status_contrato_renova_contrato);
$recValida = 0;
$nomeTipoServico = 0;
foreach ($arrayCVR as $conDAO => $valor){
	//echo $recValida . " -> " . $valor['nome_servico'] . " -- ";
	//echo $valor['nome_produto'] . "<br>";
	if ($recValida !== $valor['nome_servico']){
?>
<table border="1" width="100%" height="100%">
	<thead>
		<tr style="background-color: lime;">
			<th style="width: 20%; font-size: 12;">Objeto Serv.</th>
			<th style="width: 80%; font-size: 12;" align="center">Informacoes do produtos e Aplicacao</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="width: 20%; font-size: 12;"><?php if ($recValida !== $valor['nome_servico']){ echo $valor['nome_servico']; } ?></td>
			<td style="width: 60%;">
			<?php }//Fecha o if que verificar para não repetir mais ?>
			
			
			<?php if ($recValida !== $valor['nome_servico']){ ?>
			<table border="1">
				<thead>
					<tr style="background-color: lime;">
						<th style="width: 20%; font-size: 12;">Produto</th>
						<th style="width: 80%; font-size: 12;">Aplicacao (modo e local)</th>
						<th style="width: 20%; font-size: 12;">Registro</th>
						<th style="width: 20%; font-size: 12;">Diluicao / Qt. Aplicacao</th>
					</tr>
				</thead>
				<?php } ?>
				<tbody>
					<tr>
						<td style="width: 20%; font-size: 12;"><?php echo $valor['nome_produto']; ?></td>
						<td style="width: 20%; font-size: 12;">()</td>
						<td style="width: 20%; font-size: 12;"><?php echo $valor['registro']; ?></td>
						<td style="width: 20%; font-size: 12;">__________</td>
					</tr>
				</tbody>
				<?php if ($recValida !== $valor['nome_servico']){ ?>
			</table>
			<?php } ?>
			
			
			
			<?php if ($recValida !== $valor['nome_servico']){ ?>
			</td>
		</tr>
	</tbody>
</table>
<?php } $recValida = $valor['nome_servico']; } ?>

<div style="background-color: lime;">
	Antidotos dos produtos aplicados/Periodo de Seguranca para Afastamento/Acao Toxicologica 
</div>
<p>
<?php 
echo "teste aqui 1";
?>
</p>

<hr style="background-color: lime">


<div>
(91)3259-3748/3249-6370/0800-722-6001
</div>


<div style="background-color: lime;">
	Adequacacoes solicitadas ao clientes e ainda nao realizadas 
</div>


<div>
	<input type="checkbox"> Retirada de entulhos: SETOR: X / Servindo de acesso a roedores
</div>


<p>
Manuntencao / Armadilhas / Iscagem - Legenda: R = Qt. Resposta | C = Qt. Consumida | QD = Qt. Deteriorada | D = Destruida | O = Obstruida | E = Estraviada
</p>


<div style="width: 49%; float: left;">
<table border="1">
	<thead>
		<tr style="background-color: lime;">
			<th style="width: 33%; font-size: 12;">Nome | Comodo/ Id Extra | Posicao</th>
			<th style="width: 34%; font-size: 12;">Produtos da Manutencao</th>
			<th style="width: 33%; font-size: 12; background-color: lime;">(D)<br />(O)<br />(E)<br /></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="width: 33%; font-size: 12;">Porta Isca raticida | Escritorio - pl03 | </td>
			<td style="width: 34%; font-size: 12;">
				<table border="1">
					<tbody>
						<tr>
							<td style="width: 25%; font-size: 12;">()Ratol mini bloco parafi</td>
							<td style="width: 25%; font-size: 12;">R: ___ </td>
							<td style="width: 25%; font-size: 12;">C: ___</td>
							<td style="width: 25%; font-size: 12;">QD: ___</td>
						</tr>
					</tbody>		
				</table>
			</td>
			<td style="width: 33%; font-size: 12;">(_)<br />(_)<br />(_)<br /></td>
		</tr>
	</tbody>		
</table>
</div>
<div style="width: 2%; float: center;"></div>
<div style="width: 49%; float: right;">
<table border="1">
	<thead>
		<tr style="background-color: lime;">
			<th style="width: 33%; font-size: 12;">Nome | Comodo/ Id Extra | Posicao</th>
			<th style="width: 34%; font-size: 12;">Produtos da Manutencao</th>
			<th style="width: 33%; font-size: 12; background-color: lime;">(D)<br />(O)<br />(E)<br /></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="width: 33%; font-size: 12;">Porta Isca raticida | Escritorio - pl03 | </td>
			<td style="width: 34%; font-size: 12;">
				<table border="1">
					<tbody>
						<tr>
							<td style="width: 25%; font-size: 12;">()Ratol mini bloco parafi</td>
							<td style="width: 25%; font-size: 12;">R: ___ </td>
							<td style="width: 25%; font-size: 12;">C: ___</td>
							<td style="width: 25%; font-size: 12;">QD: ___</td>
						</tr>
					</tbody>		
				</table>
			</td>
			<td style="width: 33%; font-size: 12;">(_)<br />(_)<br />(_)<br /></td>
		</tr>
	</tbody>		
</table>
</div>



<div style="width: 49%; float: left; padding-top: 8px;">
<table border="1">
	<thead>
		<tr style="background-color: lime;">
			<th style="width: 20%; font-size: 12;">Nome | Comodo/ Id Extra | Posicao</th>
			<th style="width: 20%; font-size: 12;">Captura?</th>
			<th style="width: 20%; font-size: 12;">Praga/Qt. Captura</th>
			<th style="width: 20%; font-size: 12;">Refil?</th>
			<th style="width: 20%; font-size: 12;">(D)<br />(O)<br />(E)<br /></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="width: 33%; font-size: 12;">Armadilha Iluminosa | Almoxarifado / AL 01</td>
			<td style="width: 34%; font-size: 12;">( )S ( )N</td>
			<td style="width: 33%; font-size: 12;">____________________________</td>
			<td style="width: 33%; font-size: 12;">( )S ( )N</td>
			<td style="width: 33%; font-size: 12;">(_)<br />(_)<br />(_)<br /></td>
		</tr>
		<tr>
			<td style="width: 33%; font-size: 12;">Armadilha Iluminosa | Deposito / AL 02</td>
			<td style="width: 34%; font-size: 12;">( )S ( )N</td>
			<td style="width: 33%; font-size: 12;">____________________________</td>
			<td style="width: 33%; font-size: 12;">( )S ( )N</td>
			<td style="width: 33%; font-size: 12;">(_)<br />(_)<br />(_)<br /></td>
		</tr>
	</tbody>
</table>
</div>
<div style="width: 2%; float: center; "></div>
<div style="width: 49%; float: right; padding-top: 8px;">
<table border="1">
	<thead>
		<tr style="background-color: lime;">
			<th style="width: 20%; font-size: 12;">Nome | Comodo/ Id Extra | Posicao</th>
			<th style="width: 20%; font-size: 12;">Captura?</th>
			<th style="width: 20%; font-size: 12;">Praga/Qt. Captura</th>
			<th style="width: 20%; font-size: 12;">Refil?</th>
			<th style="width: 20%; font-size: 12;">(D)<br />(O)<br />(E)<br /></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="width: 33%; font-size: 12;">Armadilha Iluminosa | Deposito / AL 03</td>
			<td style="width: 34%; font-size: 12;">( )S ( )N</td>
			<td style="width: 33%; font-size: 12;">____________________________</td>
			<td style="width: 33%; font-size: 12;">( )S ( )N</td>
			<td style="width: 33%; font-size: 12;">(_)<br />(_)<br />(_)<br /></td>
		</tr>
	</tbody>
</table>
</div>

<div style="width: 100%; float: right; padding-top: 8px;">
	<textarea rows="5" cols="100%">Observacoes do tecnico sobre servico (vide-verso): </textarea>
</div>

<br /><br /><br /><br />
<table>
	<thead>
		<tr>
			<th style="width: 30%;">-------------------------------</th>
			<th style="width: 2%;"></th>
			<th style="width: 30%;">-------------------------------</th>
			<th style="width: 2%;"></th>
			<th style="width: 30%;">-------------------------------</th>
			<th style="width: 6%;"></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="width: 30%;">RT: Isabelle martins</td>
			<td style="width: 2%;"></td>
			<td style="width: 30%;">Tecnico Operador da empresa</td>
			<td style="width: 2%;"></td>
			<td style="width: 30%;">
			Ass. do representante do(a) Cliente<br>
			X<br>
			Nome Completo:<br>
			RG:
			</td>
			<td style="width: 6%;"><img alt="" src="Img/empresa/<?php echo $nomeIMG ?>" width="70px" height="50px" /></td>
		</tr>
	</tbody>
</table>

</div>

</body>
</html>