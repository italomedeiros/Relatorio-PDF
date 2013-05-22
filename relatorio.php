<?php

// Caminho para o arquivo fpdf.php
include("config.php");

$escritorio = $_GET['idEscritorio'];
$status = utf8_decode($_GET['status']);
$tipoCert = $_GET['tipoCert'];
$dataemissao1 = $_GET['dtDe'];
$dataemissao2 = $_GET['dtAte'];
//echo $status;
if ($tipoCert === "0" && $status === "Todos")
{
    //echo $status;
    $sql = mysql_query("SELECT scripts.tipo as tipo, 
       scripts.mostrar as mostrar, 
       certidao_processada.certidao_contratada_cnpj_idcnpj as cnpj, 
       DATE_FORMAT(certidao_processada.dataHoraConcluido, '%d/%m/%Y  %H:%i') as dataHora, 
       certidao_processada.status as status, 
       cnpj.razao_social as razao_social
FROM certidao_processada 
INNER JOIN certidao_contratada 
	ON certidao_contratada.cnpj_idcnpj = certidao_processada.certidao_contratada_cnpj_idCnpj
AND certidao_contratada.scripts_idScript = certidao_processada.certidao_contratada_scripts_idScript
INNER JOIN cnpj 
        ON certidao_contratada.cnpj_idcnpj = cnpj.idcnpj
INNER JOIN scripts 
	ON certidao_contratada.scripts_idscript = scripts.idscript
WHERE certidao_contratada.empresa_idEscritorio = '$escritorio'
AND certidao_processada.dataHoraConcluido >= '$dataemissao1' 
AND certidao_processada.dataHoraConcluido <= '$dataemissao2'") or die(mysql_error());
}
elseif ($tipoCert === "0" && $status != "Todos")
{
    //echo ("2");
    $sql = mysql_query("SELECT scripts.tipo as tipo, 
       scripts.mostrar as mostrar, 
       certidao_processada.certidao_contratada_cnpj_idcnpj as cnpj, 
       DATE_FORMAT(certidao_processada.dataHoraConcluido, '%d/%m/%Y  %H:%i') as dataHora, 
       certidao_processada.status as status, 
       cnpj.razao_social as razao_social
FROM certidao_processada 
INNER JOIN certidao_contratada 
	ON certidao_contratada.cnpj_idcnpj = certidao_processada.certidao_contratada_cnpj_idCnpj
AND certidao_contratada.scripts_idScript = certidao_processada.certidao_contratada_scripts_idScript
INNER JOIN cnpj 
        ON certidao_contratada.cnpj_idcnpj = cnpj.idcnpj
INNER JOIN scripts 
	ON certidao_contratada.scripts_idscript = scripts.idscript
WHERE certidao_contratada.empresa_idEscritorio = '$escritorio'
AND certidao_processada.dataHoraConcluido >= '$dataemissao1' 
AND certidao_processada.dataHoraConcluido <= '$dataemissao2'
AND certidao_processada.status = '$status'") or die(mysql_error());
}
elseif($tipoCert != "0" && $status === "Todos")
{
    //echo ("3");
    $sql1 = "SELECT scripts.tipo as tipo, 
       scripts.mostrar as mostrar, 
       certidao_processada.certidao_contratada_cnpj_idcnpj as cnpj, 
       DATE_FORMAT(certidao_processada.dataHoraConcluido, '%d/%m/%Y  %H:%i') as dataHora, 
       certidao_processada.status as status, 
       cnpj.razao_social as razao_social
FROM certidao_processada 
INNER JOIN certidao_contratada 
	ON certidao_contratada.cnpj_idcnpj = certidao_processada.certidao_contratada_cnpj_idCnpj
AND certidao_contratada.scripts_idScript = certidao_processada.certidao_contratada_scripts_idScript
INNER JOIN cnpj 
        ON certidao_contratada.cnpj_idcnpj = cnpj.idcnpj
INNER JOIN scripts 
	ON certidao_contratada.scripts_idscript = scripts.idscript
WHERE certidao_contratada.empresa_idEscritorio = '$escritorio'
AND certidao_processada.dataHoraConcluido >= '$dataemissao1' 
AND certidao_processada.dataHoraConcluido <= '$dataemissao2'
AND certidao_processada.certidao_contratada_scripts_idscript = $tipoCert";
    $sql = mysql_query($sql1) or die(mysql_error());
    //echo $sql1;

    
}

elseif ($tipoCert != "0" && $status != "Todos")
{
    //echo ("4");
    $sql = mysql_query("SELECT scripts.tipo as tipo, 
       scripts.mostrar as mostrar, 
       certidao_processada.certidao_contratada_cnpj_idcnpj as cnpj, 
       DATE_FORMAT(certidao_processada.dataHoraConcluido, '%d/%m/%Y  %H:%i') as dataHora, 
       certidao_processada.status as status, 
       cnpj.razao_social as razao_social
FROM certidao_processada 
INNER JOIN certidao_contratada 
	ON certidao_contratada.cnpj_idcnpj = certidao_processada.certidao_contratada_cnpj_idCnpj
AND certidao_contratada.scripts_idScript = certidao_processada.certidao_contratada_scripts_idScript
INNER JOIN cnpj 
        ON certidao_contratada.cnpj_idcnpj = cnpj.idcnpj
INNER JOIN scripts 
	ON certidao_contratada.scripts_idscript = scripts.idscript
WHERE certidao_contratada.empresa_idEscritorio = '$escritorio'
AND certidao_processada.dataHoraConcluido >= '$dataemissao1' 
AND certidao_processada.dataHoraConcluido <= '$dataemissao2'
AND certidao_processada.certidao_contratada_scripts_idscript = $tipoCert
AND certidao_processada.status = '$status'") or die(mysql_error());
}


/* $html = '<table border="1"><tbody>';
  while ($linha = mysql_fetch_array($sql))
  {
  $html = '<tr><td>'.$linha['cnpj'].'</td><td>'.$linha['tipo'].'</td><td>'.$linha['status'].'</td><td>'.$linha['dataHora'].'</td></tr>';
  }
  $html = '<tr><td>TESTE1</td><td>TESTE2</td><td>TESTE3</td><td>TESTE4</td></tr>';
  $html = '</tbody></table>'; */

$html ='<table style="border: solid 1px; border-spacing: 4px; text-align:center;">';
$html =$html .'<tr><td>RELAT&Oacute;RIO DE EMISS&Atilde;O DE CERTID&Otilde;ES</td></tr>';
$html =$html .'</table>';

$html = $html .'<table style="border: solid 1px; border-spacing: 4px; text-align:center;">';

$html = $html . '<tr><td>CNPJ</td><td>CERTID&Atilde;O</td><td>STATUS</td><td>DATA-CONCLUS&Atilde;O</td></tr>';
while ($linha = mysql_fetch_array($sql))
{
    $html = $html . '<tr><td>' . $linha['cnpj'] . '</td><td>' . utf8_encode($linha['tipo']) . " - " . utf8_encode($linha['mostrar']). '</td><td>' . utf8_encode($linha['status']) . '</td><td>' .  utf8_encode($linha['dataHora']) . '</td></tr>';
}
$html = $html . '</table>';

$html =$html .'<table style="border: solid 1px; border-spacing: 4px; text-align:center;">';
$html =$html .'<tr><td>&#169; Copyright 2013 - NetCertid&atilde;o</td></tr>';
$html =$html .'</table>';

require_once('tcpdf/config/lang/eng.php');
require_once('tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('NetCertidão');
$pdf->SetTitle('Relatório');
$pdf->SetSubject('Relatório_TESTE');
$pdf->SetKeywords('NetCertidão, Relatório');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
//$pdf->setLanguageArray($l);
// ---------------------------------------------------------
// set font
$pdf->SetFont('helvetica', 'I', 10);

// add a page
$pdf->AddPage();

//add club logo
$ext = pathinfo("logo.jpg", PATHINFO_EXTENSION);
$pdf->Image("logo.jpg", 95, 10, 15, '', $ext, '', 'C', false, 300, '', false, false, 0, false, false, false);

//add club data

$pdf->writeHTML($html, true, false, false, false, '');

// ---------------------------------------------------------
//Close and output PDF document
$pdf->Output('account.pdf', 'I');


//mysql_close($link);
?>
