<?php

include_once 'Model/DAO/EmpresaDAO.php';
include_once 'Model/DAO/ContratoDAO.php';
include_once 'Model/DAO/PragasDAO.php';

require 'mpdf/mpdf.php';

//Atualizar com o fusio horario do brasil
date_default_timezone_set('America/Sao_Paulo');

//Estancia a classe de Mpdf
$mpdf = new mPDF();

//Pegar os dados da empresa
$empDAO = new EmpresaDAO();
$arrayEmpresa = $empDAO->ListaEmpresa();
$nomeIMG = null;
$nomeEmpresa = null;
$assinatura = 0;
foreach ($arrayEmpresa as $empDAO => $valor){
	$nomeIMG = $valor['logo_marca'];
	$nomeEmpresa = $valor['nome'];
	$assinatura = $valor['assinatura_da_empresa'];
}

//Pegar os dados da empresa que receberar o servico
$data       = $_POST['data'];
$idContrato = $_POST['idContrato'];
$nomeEmpresaCliente = null; 
$dataVistoria = 0;
$logoEmpresaCliente = 0;
$ordemServico = 0;
$conDAO = new ContratoDAO();
$arrayRelatorio = $conDAO->RelatorioContratoPelaIdData($data, $idContrato);
foreach ($arrayRelatorio as $conDAO => $n){
	if (!empty($n['nome_fantasia'])){
		$nomeEmpresaCliente = $n['nome_fantasia'];
	} else {
		$nomeEmpresaCliente = $n['nome'];
	} 
	if (!empty($n['caminho_foto'])){
		$logoEmpresaCliente = $n['caminho_foto'];
	} else {
		$logoEmpresaCliente = "logoCliente.png";
	}
	$dataVistoria = $n['data'];
	$ordemServico = $n['id'];
	
}

//Lista os dados da tabela de sinatropico
$data = $_POST['data'];
$idContrato = $_POST['idContrato'];
$conDAO = new ContratoDAO();
$arrayRelatorio = $conDAO->RelatorioContratoPelaIdData($data, $idContrato);


//Topo do PDF
$htmlTopo .= '
<html>
<body>

<div style="width: 20%; float: left;" align="center"><img alt="" src="Img/empresa/'.$nomeIMG.'" width="120px" height="70px" /> </div>
<div style="width: 55%; float: left;" align="center">
	<br />
	<font color="red" size="5">ORDEM DE VISTORIA</font><br />
	<font color="black" size="2">'.$nomeEmpresaCliente.'</font>
	<table border="1" cellspacing="0" cellpadding="2">
		<thead>
			<tr>
				<th align="center">Data</th>
				<th align="center">Revisao</th>
				<th align="center">N</th>
				<th align="center">Pagina</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td align="center">'.date('/m/Y', strtotime($dataVistoria)).'</td>
				<td align="center">000</td>
				<td align="center">'.$ordemServico.'</td>
				<td align="center"><div align="center">{PAGENO}</div></td>
			</tr>
		</tbody>
	</table>
</div>
<div style="width: 25%; float: left;" align="center"><img alt="" src="Img/logo_cliente/'.$logoEmpresaCliente.'" /></div>
';

//Meio do PDF
$htmlMeio = '
<br />
<table border="1" cellspacing=0>
	<thead>
		<tr>
			<th style="background-color: #efeab1;">SETOR</th>
			<th style="background-color: #efeab1;">SINANTROPICO</th>
			<th style="background-color: #efeab1;">QUANTIDADE DE SINANTROPICOS POR SETOR</th>
		</tr>
	</thead>';
foreach ($arrayRelatorio as $conDAO => $contrato){
	$praDAO = new PragasDAO();
	$arrayPragas = $praDAO->ListaPragasAtivaRelatorio();
	for($i = 0; $i < count($arrayPragas);$i++){	
		
$htmlMeio .='<tbody>
		<tr>
			<td align="center">'.$contrato['nome_setor'].'</td>
			<td align="center">'.$arrayPragas[$i]['nome_pragas'].'</td>
			<td align="center">
				<table border="1" cellspacing=0>
					<tr>
						<th>(  ) Nenhum</th>
						<th>(  ) Pouco(1-5)</th>
						<th>(  ) Medio(6-15)</th>
						<th>(  ) Infestacao(16-30)</th>
					</tr>
				</table>
			</td>
		</tr>
	</tbody>';

} }
$htmlMeio .='
</table>
';

$htmlRodape = '
<br /><br /><br /><br /><br /><br /><br />
<textarea rows="2" cols="60">Nome do controlador:</textarea><br>
<textarea rows="5" cols="60">Rubrica:</textarea>

</html>
</body>
';
//Rodape do PDF
$rodape = '
<div align="center">{PAGENO}</div>
';



$mpdf->Bookmark('Start of the document');
$mpdf->SetHTMLHeader($topo,'O',true);
$mpdf->SetHTMLFooter($rodape);
$mpdf->WriteHTML($htmlTopo);
$mpdf->WriteHTML($htmlMeio);
$mpdf->WriteHTML($htmlRodape);

$mpdf->Output();
?>