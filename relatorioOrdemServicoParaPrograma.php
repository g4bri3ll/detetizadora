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
foreach ($arrayRelatorio as $conDAO => $list){
	$nomeFantasia = $list['nome_fantasia'];
	$razaoSocialCliente = $list['razao_social'];
	$cnpj = $list['cnpj'];
	$enderecoCliente = $list['endereco'];
	$cep = $list['cep'];
	$telefoneCliente = $list['telefone'];
}

$data = $_POST['data'];
$conDAO = new ContratoDAO();
$arrayDados = $conDAO->RelatorioOrdemServicoParaProgramaDados($idContrato, $data);



//Topo do PDF
$topo .= '
<table>
	<thead>
		<tr>
			<th width="20%"><img alt="" src="Img/empresa/'.$nomeIMG.'"></th>
			<th width="60%" align="center">'.$nomeEmpresa.' <br> '.$razaoSocial.' <br> Telefone: '.$telefone.' | Email: '.$email.' <br> '.$endereco.'</th>
			<th width="20%" style="background-color: #6B8E23;">Ordem de servico <br> N 01/12 <br> Via do cliente</th>
		</tr>
	</thead>
</table>
';



//Meio do PDF
$html .= '
<br><br><br><br>
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

<table style="background-color: #F4A460; width=100%;">
	<thead>
		<tr>
			<th>Nome fantasia: '.$nomeFantasia.' / Razao social: '.$razaoSocialCliente.' / CNPJ: '.$cnpj.' 
				Endereco: '.$endereco.' | CEP: '.$cep.' Telefone(s): '.$telefoneCliente.' 
				Data: '.date('d-m-Y').' Hora: '.date('H:i').' </th>
		</tr>
	</thead>
</table>
<br>

<table border="1" id="table">
	<thead>
		<tr>
			<th>Tipo de servico</th>
			<th>PRAGA ALVO</th>
			<th>PRODUTO APLICADO</th>
			<th>SETOR</th>
			<th>Qt. Aplicada</th>
		</tr>
	</thead>
	<tbody>';
	foreach ($arrayDados as $conDAO => $valores){  
$html .= '<tr>
			<td>'.$valores['tipo_servico'].'</td>
			<td>'.$valores['praga_alvo'].'</td>
			<td>'.$valores['produto'].'</td>
			<td>'.$valores['setor'].'</td>
			<td></td>
		</tr>';
		}
$html .= '</tbody>
</table>
<br><br>
<textarea rows="5" cols="180">Observacoes do servico:</textarea>
';



//Rodape do PDF
$rodape .= '
<table>
	<thead>
		<tr>
			<th align="center" style="width: 30%;">_______________________________</th>
			<th style="width: 5%;"></th>
			<th align="center" style="width: 30%;">_______________________________</th>
			<th style="width: 5%;"></th>
			<th align="center" style="width: 30%;">_______________________________</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td align="center" style="width: 30%;">Assinatura do Tecnico(s)</td>
			<td style="width: 5%;"></td>
			<td align="center" style="width: 30%;">RT: Isabelle martins</td>
			<td style="width: 5%;"></td>
			<td align="center" style="width: 30%;">Assinatura do Representante da Empresa</td>
		</tr>
	</tbody>
</table>
';



$mpdf = new mPDF();

$mpdf->Bookmark('Start of the document');
$mpdf->SetHTMLHeader($topo,'O',true);
$mpdf->SetHTMLFooter($rodape);
$mpdf->WriteHTML($html);

$mpdf->Output();
?>