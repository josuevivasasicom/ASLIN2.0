<?php
//?? ESTE ARCHIVO REVISA QUE SEA UN FORMATO ESTABLECIDO, TRAE LA INFORMACION Y DIBUJA EL PDF PARA VERLO, O PARA DESCARGARLO SEGUN EL METODO
//?? ***************************************************************************************************************
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_DEPRECATED);


echo "HOLA MUNDO";
exit();


require_once "./../../siniestros.php";
require_once "./../../../controller/Core.php";
require_once "./../../../controller/Database.php";
require_once "./../../../controller/Model.php";
require "./core/app/action/pdf/vendor/autoload.php";


date_default_timezone_set("America/Mexico_City");
require "./vendor/autoload.php";
use Spipu\Html2Pdf\Html2Pdf;
ob_start();


switch ($_REQUEST['doc']) {
    case 'primerAtencion':
        $contenido = Siniestros::verPrimeraAtencion($_REQUEST['timerst']);
        include "formato/primeraAtencion.php";
    break;
    case 'informePreliminar':
        $contenido = Siniestros::verPrimeraAtencion($_REQUEST['timerst']);
        include "formato/informePreliminar.php";
    default:
        # code...
        break;
}
$html = ob_get_clean();

$html2pdf = new Html2Pdf('P','A4','es','true','UTF-8');
$html2pdf->writeHTML($html);
    $html2pdf->pdf->SetDisplayMode('fullpage');
    //$html2pdf->pdf->SetProtection(array('print', 'copy'), '12345', null, 0, null);
    $html2pdf->output("nombre.pdf");



exit();