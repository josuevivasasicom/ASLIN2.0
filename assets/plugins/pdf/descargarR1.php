<?php

// error_reporting(E_ALL);
// ini_set('display_errors', '1');
require_once './utils/Database.php';
require_once './utils/Core.php';
require_once './utils/Hoteles.php';
date_default_timezone_set("America/Mexico_City");

require_once './vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;

//$prueba = $_GET["codigo"];

//$tipoPruebaPDF = $_GET["tipo"];
//$hotelPaciente = $_GET["hotel"];

/*********************************************otro anexo pass test base64_encode y base64_decode *****************************/
// proximamente ELMM

function code_decode($string,$modo='encode') {
    $output = false;
    $encrypt_method = "AES-128-ECB";
    $key = 'GrupoDiemsa';
        if ( $modo == 'encode' ) {
            $output = urlencode($string);
            $output = openssl_encrypt($output, $encrypt_method, $key);
        } else 
        if( $modo == 'decode' ) {
            $output = urldecode($string);
            //$output = openssl_decrypt($output, $encrypt_method, $key);
        }
    return $output;
}


//$prueba = code_decode($prueba,'decode');'GrupoDiemsa'//
$prueba = $_GET["codigo"];
if (strlen($prueba)>12){
    $prueba= openssl_decrypt($prueba, "AES-128-ECB", 'GrupoDiemsa');
}



/*******************************ELMM*******/
$sql= "select u.*, p.id idPrueba ,p.* from pruebas p
inner join usuarios u
on id_usuario = u.id
where prueba = '".$prueba."' and estatus in('Positivo','Negativo')";
$query = Database::ExeDoIt($sql);
$data= $query[0]->fetch_assoc();

$_paceinte = explode(" ",$data['paciente']);

/*******************************ELMM*******/
// seguridad para el PDF ELMM

$tipoPruebaPDF = $data['tipo_test']=='Prueba de Antigenos'?'anti':'pcr';//$_GET["tipo"];  [] => 
$hotelPaciente = $data['paciente'];//$_GET["hotel"];




/*******************************************************************************************************************************/


if($hotelPaciente != "HGE" && $tipoPruebaPDF == "pcr"){

	ob_start();
	//require_once 'vistapcr.php';
	require_once 'pruebaPCR_nueva.php';
	$html = ob_get_clean();

	$html2pdf = new Html2Pdf('P','A4','es','true','UTF-8');
	$html2pdf->writeHTML($html);
    	$html2pdf->pdf->SetDisplayMode('fullpage');
    	//$html2pdf->pdf->SetProtection(array('print', 'copy'), '12345', null, 0, null);
    	$html2pdf->output("PCR_".$_GET['codigo']."_".$_paceinte[0]."-".$_paceinte[1].".pdf");

}else if($hotelPaciente != "HGE" && $tipoPruebaPDF == "anti"){

	ob_start();
	require_once 'pruebaAntigenos.php';
	$html = ob_get_clean();

	$html2pdf = new Html2Pdf('P','A4','es','true','UTF-8');
	$html2pdf->writeHTML($html);
    	$html2pdf->pdf->SetDisplayMode('fullpage');
    	//$html2pdf->pdf->SetProtection(array('print', 'copy'), '12345', null, 0, null);
    	$html2pdf->output("ANTI_".$_GET['codigo']."_".$_paceinte[0]."-".$_paceinte[1].".pdf");

}else if($hotelPaciente == "HGE" && $tipoPruebaPDF == "anti"){

	ob_start();
	require_once 'generalvistapdf.php';
	$html = ob_get_clean();

	$html2pdf = new Html2Pdf('P','A4','es','true','UTF-8');
	$html2pdf->writeHTML($html);
		$html2pdf->pdf->SetDisplayMode('fullpage');
    	//$html2pdf->pdf->SetProtection(array('print', 'copy'), '12345', null, 0, null);
    	$html2pdf->output("G_".$_GET['codigo']."_".$_paceinte[0]."-".$_paceinte[1].".pdf");

}

mysql_close($query);
