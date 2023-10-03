<?php

// se ejecuta desde action PDF
//?? ESTE ARCHIVO REVISA QUE SEA UN FORMATO ESTABLECIDO, TRAE LA INFORMACION Y DIBUJA EL PDF PARA VERLO, O PARA DESCARGARLO SEGUN EL METODO
//?? ***************************************************************************************************************
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_DEPRECATED);

// require_once "./../core/app/model/Siniestros.php";
// require_once "./../core/controller/Core.php";
// require_once "./../core/controller/Database.php";
// require_once "./../core/controller/Model.php";
// require_once "./vendor/autoload.php";


date_default_timezone_set("America/Mexico_City");
require_once "./core/app/action/pdf/vendor/autoload.php";
use Spipu\Html2Pdf\Html2Pdf;
// use Spipu\Html2Pdf\HTML2PDF;
ob_start();
/* core::preprint($_REQUEST);exit();
(
    [timerst] => 1648073016.3617
    [doc] => primeraAtencion
) */

switch ($data['c1']) {
    case 'Primera Atención':
    case 'primera Atención':
    case 'primera Atencion':
        
        $contenido = Siniestros::verPrimeraAtencion($data['timerst'],$data['areaNombre'],$data['v']);
        include "formato/primeraAtencion.php";
        break;
    case 'informe Preliminar':
    case 'Informe Preliminar':
    case 'nforme preliminar':
        $contenido = Siniestros::verInformePreliminar($data['timerst'],$data['areaNombre'],$data['v']);
        include "formato/informePreliminar.php";
        break;
    case 'Informe Cancelación':
    case 'informe Cancelación':
    case 'Informe Cancelacion':
    case 'Informe Cancelacion':
        $contenido = Siniestros::verInformeCancelacion($data['timerst'],$data['areaNombre'],$data['v']);
        include "formato/informeCancelacion.php";
        break;
    case 'Informe Actualización':
    case 'informe Actualización':
    case 'informe Actualizacion':
                $contenido = Siniestros::verInformeActualizacion($data['timerst'],$data['areaNombre'],$data['v']);
                include "formato/informeActualizacion.php";
                break;

    case 'demo':
        $contenido = Siniestros::verInformePreliminar($data['timerst'],$data['areaNombre'],$data['v']);
        include "formato/demo.php";
        break;
    case 'demodemo':
        include "formato/informeCancelacion_demo.php";
        break;
    default:
       echo "no hay documento para cargar desde send file. php ..........";
       core::preprint($data['areaNombre'],'area nombre');
       core::preprint($data['timerst'],'timer');
        break;
}

if(isset($data['debug'])){
    core::preprint($contenido);exit();
}

$html = ob_get_clean();             
// $html2pdf = new HTML2PDF('P','Letter','es','true','UTF-8');
$html2pdf = new html2pdf('P','Letter','es','true','UTF-8');
// $html2pdf->addFont('calibri', 'bold', 'file');
$html2pdf->setTestTdInOnePage(false);
$html2pdf->writeHTML($html);
// $html2pdf->createIndex();
// $html2pdf->getNbPages();




// $html2pdf->setModeDebug();
// $html2pdf->previewHTML($html);exit();
    //$html2pdf->pdf->SetDisplayMode('fullpage');
    //$html2pdf->pdf->SetTitle('PDF '.$data['doc']."-".$data['areaNombre'] );
    //$html2pdf->pdf->SetProtection(array('print', 'copy'), '12345', null, 0, null);
    //$html2pdf->output($data['doc']."-".$data['areaNombre'].".pdf");