<?php

include_once 'Model/DAO/EmpresaDAO.php';
include_once 'Model/DAO/ContratoDAO.php';
include_once 'Model/DAO/PragasDAO.php';

require 'mpdf/mpdf.php';

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
$idContrato = $_POST['idContrato'];
$conDAO = new ContratoDAO();
$arrayRelatorio = $conDAO->RelatorioOrdemServicoParaProgramaCliente($idContrato);
$nomeFantasia = null;
$razaoSocialCliente = null;
$cnpj = null;
$enderecoCliente = null;
$cep = null;
$telefoneCliente = null;
$dataInicioContrato = 0;
$dataFinalContrato = 0;
foreach ($arrayRelatorio as $conDAO => $list){
	$nomeFantasia = $list['nome_fantasia'];
	$razaoSocialCliente = $list['razao_social'];
	$cnpj = $list['cnpj'];
	$enderecoCliente = $list['endereco'];
	$cep = $list['cep'];
	$telefoneCliente = $list['telefone'];
	$dataInicioContrato = $list['data_inicio'];
	$dataFinalContrato = $list['data_final'];
}


//Pegar a data do post
$dataCont = $_POST['data'];
$dtServico = 0;
//Lista o contrato, data contrato, e o tipo de servico
$conDAO = new ContratoDAO();
$arrayDados = $conDAO->ListaProdutoRelatorioPorContrato($idContrato, $dataCont);
foreach ($arrayDados as $conDAO => $valorCont){
	$dtServico = $valorCont['data'];
}



$cabecalho = '
<html>
<head>
<style>
.table{
  border: 1px solid black;
}

table {
  border-collapse: collapse;
  width: 100%;
}

th {
  text-align: left;
}
</style>
</head>
<body>

<div style="width: 20%; float: left;" align="center"><img alt="" src="Img/empresa/'.$nomeIMG.'"></div>
<div style="width: 55%; float: left;" align="center"><font size="5">'.$nomeEmpresa.'</font><br /> '.$razaoSocial.' <br> Telefone: '.$telefone.' | Email: '.$email.' <br> '.$endereco.' <br> 000034/2019</div>
<div style="width: 25%; float: left;" align="center">Ordem de servico <br> Certificado de Execucao <br> N ____ <br> Via do funcionario</div>
';

//Meio do PDF
$html .= '

<br />
<div style="background-color: lime; top: 10px;">
	Nome fantasia: '.$nomeFantasia.' | Razao social: '.$razaoSocialCliente.' | CNPJ: '.$cnpj.' | Cod. Cliente: __ | IE 
</div>


<div>
	Endereco: '.$endereco.' | CEP: '.$cep.' | (______________________________) <br> 
	Telefone(s): '.$telefoneCliente.' Validade do contrato: '.date('d-m-Y', strtotime($dataInicioContrato)).' a '.date('d-m-Y', strtotime($dataFinalContrato)).'
</div>


<div style="background-color: lime;">
	Serv. ___ de '.date('d-m-Y', strtotime($dtServico)).' das 08:00 as 18:00 | Dt real: __/__ | Hr real: __:__ as __:__ | Tp Ida: _____ | Tp Volta: ______ 
</div>
	

<table>
	<thead>
		<tr>
			<th style="width: 20%; font-size: 12;">Confirmou/Procurar:</th>
			<th style="width: 20%; font-size: 12;">Servico(s):</th>
			<th style="width: 20%; font-size: 12;">Dependencias:</th>
			<th style="width: 20%; font-size: 12;">Tecnico(s) Operador(es):</th>
			<th style="width: 20%; font-size: 12;"></th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="width: 20%; font-size: 12;"></td>
			<td style="width: 20%; font-size: 12;">';
$nomeRepeti = null;
foreach ($arrayDados as $valorCont){
	if ($valorCont['nome_produto'] !== $nomeRepeti){
		$valorCont['nome_produto']."<br>";
	}
	$nomeRepeti = $valorCont['nome_produto'];	
}

$html .='</td>
			<td style="width: 20%; font-size: 12;"></td>
			<td style="width: 20%; font-size: 13;">';
$nomeRepeti = null;
foreach ($arrayDados as $valorCont){
	if ($valorCont['nome_func'] !== $nomeRepeti){
		$valorCont['nome_func']."<br>";
	}
	$nomeRepeti = $valorCont['nome_func'];	
}			
$html .='</td>
			<td style="width: 20%; font-size: 12;"></td>
		</tr>
	</tbody>		
</table>



<table border="1">
	<thead>
		<tr style="background-color: lime;">
			<th style="width: 20%; font-size: 12;">Objeto Serv.</th>
			<th style="width: 80%; font-size: 12;" align="center">Informacoes do produtos e Aplicacao</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="width: 20%; font-size: 12;">Armadilha Luminosa</td>
			<td style="width: 60%;">
			
			<table border="1">
				<thead>
					<tr style="background-color: lime;">
						<th style="width: 20%; font-size: 12;">Produto</th>
						<th style="width: 80%; font-size: 12;">Aplicacao (modo e local)</th>
						<th style="width: 20%; font-size: 12;">Registro</th>
						<th style="width: 20%; font-size: 12;">Diluicao / Qt. Aplicacao</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="width: 20%; font-size: 12;">AL (do grupo quim. Nao Quimico --- em)</td>
						<td style="width: 20%; font-size: 12;">()</td>
						<td style="width: 20%; font-size: 12;">Isento</td>
						<td style="width: 20%; font-size: 12;">__________</td>
					</tr>
				</tbody>		
			</table>
			
			</td>
		</tr>
	</tbody>
	<thead>
		<tr style="background-color: lime;">
			<th style="width: 20%; font-size: 12;">Objeto Serv.</th>
			<th style="width: 80%; font-size: 12;" align="center">Informacoes do produtos e Aplicacao</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="width: 20%; font-size: 12;">Porta Iscas</td>
			<td style="width: 60%;">
			
			<table border="1">
				<thead>
					<tr style="background-color: lime;">
						<th style="width: 20%; font-size: 12;">Produto</th>
						<th style="width: 80%; font-size: 12;">Aplicacao (modo e local)</th>
						<th style="width: 20%; font-size: 12;">Registro</th>
						<th style="width: 20%; font-size: 12;">Diluicao / Qt. Aplicacao</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="width: 20%; font-size: 12;">AL (do grupo quim. Nao Quimico --- em)</td>
						<td style="width: 20%; font-size: 12;">()</td>
						<td style="width: 20%; font-size: 12;">Isento</td>
						<td style="width: 20%; font-size: 12;">__________</td>
					</tr>
				</tbody>		
			</table>
			
			</td>
		</tr>
	</tbody>
	<thead>
		<tr style="background-color: lime;">
			<th style="width: 20%; font-size: 12;">Objeto Serv.</th>
			<th style="width: 80%; font-size: 12;" align="center">Informacoes do produtos e Aplicacao</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td style="width: 20%; font-size: 12;">()Baratas ()Formigas ()Mosquitos ()Moscas ()Aranhas ()e4scorpioes ()Outros</td>
			<td style="width: 60%;">
			
			<table border="1">
				<thead>
					<tr style="background-color: lime;">
						<th style="width: 20%; font-size: 12;">Produto</th>
						<th style="width: 80%; font-size: 12;">Aplicacao (modo e local)</th>
						<th style="width: 20%; font-size: 12;">Registro</th>
						<th style="width: 20%; font-size: 12;">Diluicao / Qt. Aplicacao</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="width: 20%; font-size: 12;">TWO-OL (diclo)</td>
						<td style="width: 20%; font-size: 12;">()</td>
						<td style="width: 20%; font-size: 12;">Isento</td>
						<td style="width: 20%; font-size: 12;">__________</td>
					</tr>
					<tr>
						<td style="width: 20%; font-size: 12;">AL (do grupo quim. Nao Quimico --- em)</td>
						<td style="width: 20%; font-size: 12;">()</td>
						<td style="width: 20%; font-size: 12;">Isento</td>
						<td style="width: 20%; font-size: 12;">__________</td>
					</tr>
					<tr>
						<td style="width: 20%; font-size: 12;">AL (do grupo quim. Nao Quimico --- em)</td>
						<td style="width: 20%; font-size: 12;">()</td>
						<td style="width: 20%; font-size: 12;">Isento</td>
						<td style="width: 20%; font-size: 12;">__________</td>
					</tr>
				</tbody>		
			</table>
			
			</td>
		</tr>
	</tbody>
</table>

<div style="background-color: lime;">
	Antidotos dos produtos aplicados/Periodo de Seguranca para Afastamento/Acao Toxicologica 
</div>
<p>';
foreach ($arrayDados as $listProd){
	$listProd['nome_produto']."<br>";	
}
$html .='</p>

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
	<textarea rows="5" cols="140">Observacoes do tecnico sobre servico (vide-verso): </textarea>
</div>

';


$assinatura = '
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
			<td style="width: 6%;"><img alt="" src="Img/empresa/'.$nomeIMG.'" width="70px" height="50px" /></td>
		</tr>
	</tbody>
</table>

</body>
</html>
';

$rodape = '<div align="center">{PAGENO}</div>';


$mpdf = new mPDF('utf-8', 'A4-R');

$mpdf->Bookmark('Start of the document');
$mpdf->SetHTMLHeader($topo,'O',true);
$mpdf->SetHTMLFooter($rodape);
$mpdf->WriteHTML($cabecalho);
$mpdf->WriteHTML($html);
$mpdf->WriteHTML($assinatura);

$mpdf->Output();
?>