<?php

// se ejecuta desde action PDF
//?? ESTE ARCHIVO REVISA QUE SEA UN FORMATO ESTABLECIDO, TRAE LA INFORMACION Y DIBUJA EL PDF PARA VERLO, O PARA DESCARGARLO SEGUN EL METODO
//?? ***************************************************************************************************************
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_DEPRECATED);*/

require_once "./../core/app/model/Siniestros.php";
require_once "./../core/controller/Core.php";
require_once "./../core/controller/Database.php";
require_once "./../core/controller/Model.php";
// require "./vendor/autoload.php";


date_default_timezone_set("America/Mexico_City");
require "./vendor/autoload.php";
use Spipu\Html2Pdf\Html2Pdf;
ob_start();
/* core::preprint($_REQUEST);exit();
(
    [timerst] => 1648073016.3617
    [doc] => primeraAtencion
) */

switch ($_REQUEST['doc']) {
    case 'primeraAtención':
    case 'primeraAtencion':
        $contenido = Siniestros::verPrimeraAtencion($_REQUEST['timerst'],$_REQUEST['areaNombre'],$_REQUEST['v']);
        include "formato/primeraAtencion.php";
        break;
    case 'informePreliminar':

        $contenido = Siniestros::verInformePreliminar($_REQUEST['timerst'],$_REQUEST['areaNombre'],$_REQUEST['v']);
        include "formato/informePreliminar.php";
        break;
    case 'informeCancelación':
    case 'informeCancelacion':
        $contenido = Siniestros::verInformeCancelacion($_REQUEST['timerst'],$_REQUEST['areaNombre'],$_REQUEST['v']);
        include "formato/informeCancelacion.php";
        break;
    case 'informeActualización':
    case 'informeActualizacion':
        $contenido = Siniestros::verInformeActualizacion($_REQUEST['timerst'],$_REQUEST['areaNombre'],$_REQUEST['v']);
        include "formato/informeActualizacion.php";
        break;
        
    case 'caratula':
    case 'Caratula':
        $contenido = Siniestros::verSiniestroTimerstCaratula($_REQUEST['timerst']);
        include "formato/AcaratulaID.php";
        break;

    case 'demo':
        $contenido = Siniestros::verInformePreliminar($_REQUEST['timerst'],$_REQUEST['areaNombre']);
        include "formato/demo.php";
        break;
    case 'demodemo':
        include "formato/informe_demo.php";
        break;
    default:
       echo "no hay documento para cargar..........";
        break;
}

if(isset($_REQUEST['debug'])){
    core::preprint($contenido);exit();
}                
$html = ob_get_clean();
//core::preprint(html_entity_decode($html));exit();
$html2pdf = new Html2Pdf('P','A4','es','true','UTF-8');
// $html2pdf = new Html2Pdf('P','Letter','es','true','UTF-8');
// $html2pdf->addFont('calibri', 'bold', 'file');
//$html2pdf->setTestTdInOnePage(false);
//core::preprint($html);exit();

//$html2pdf->writeHTML(html_entity_decode($html));
//var_dump($html);
//pdf se ve mal

try{
    $html2pdf->writeHTML(html_entity_decode($html));
    }catch(Exception $e){
        $html2pdf->writeHTML(htmlspecialchars($html));
    }
    
// $html2pdf->createIndex();
// $html2pdf->getNbPages();


if (!isset($_REQUEST['areaNombre'])){ $_REQUEST['areaNombre'] = "CMA";}

    // $html2pdf->setModeDebug());
    // $html2pdf->previewHTML($html);exit();
    $html2pdf->pdf->SetDisplayMode('fullpage');
    $html2pdf->pdf->SetTitle('PDF '.$_REQUEST['doc']."-".$_REQUEST['areaNombre'] );
    //$html2pdf->pdf->SetProtection(array('print', 'copy'), '12345', null, 0, null);
    $html2pdf->output($_REQUEST['doc']."-".$_REQUEST['areaNombre'].".pdf");



exit();