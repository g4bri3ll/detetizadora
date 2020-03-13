<?php

require 'FPDF/fpdf.php';
include_once 'Model/DAO/ArmadilhaIscagemDAO.php';

$id = $_GET['idMp'];

$armDAO = new ArmadilhaIscagemDAO();
$arrayFoto = $armDAO->ListaFotoPDF($id);
        	
$foto = 0;
foreach ($arrayFoto as $armDAO => $f){
	$foto = $f['caminho_foto'];
}
        	
        	
$pdf = new FPDF();

$pdf->AddPage();
$pdf->Image('Img/Mapa/ArmadilhaIsca/' . $foto, 0, 0, 210, 297);
$pdf->Output();

?>