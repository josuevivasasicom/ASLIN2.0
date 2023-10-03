<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

date_default_timezone_set("America/Mexico_City");

require_once './vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

$prueba = $_GET["codigo"];
$tipoPruebaPDF = $_GET["tipo"];
$hotelPaciente = $_GET["hotel"];

if($hotelPaciente != "HGE" && $tipoPruebaPDF == "pcr"){

	ob_start();
	require_once 'vistapcr.php';
	$html = ob_get_clean();

	$html2pdf = new Html2Pdf('P','A4','es','true','UTF-8');
	$html2pdf->writeHTML($html);
	$html2pdf->output();

}else if($hotelPaciente != "HGE" && $tipoPruebaPDF == "anti"){

	ob_start();
	require_once 'vistapdf.php';
	$html = ob_get_clean();

	$html2pdf = new Html2Pdf('P','A4','es','true','UTF-8');
	$html2pdf->writeHTML($html);
	$html2pdf->output();

}else if($hotelPaciente == "HGE" && $tipoPruebaPDF == "anti"){

	ob_start();
	require_once 'generalvistapdf.php';
	$html = ob_get_clean();

	$html2pdf = new Html2Pdf('P','A4','es','true','UTF-8');
	$html2pdf->writeHTML($html);
	$html2pdf->output();

}
