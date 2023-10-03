<?php
// hacer referencia al espacio de nombres Dompdf 
require_once  './assets/plugins/dompdf/autoload.inc.php' ;
use  Dompdf\Dompdf;
/* *******************
*  FUNCIONES NATIVAS PARA TRAER LOS DATOS DEL ARCHIVO A VISUALIZAR
*********************** */
$r = $_REQUEST;
if(!isset($r['timerst']) && !isset($r['doc'])){
    echo"No puedes acceder a esta sección.";exit();
}

if( $r['doc']=='primeraAtencion' ){
    // $contenido = Siniestros::verPrimeraAtencion($r['timerst']);
    include "formato/primeraAtencion.php";
}
elseif( $r['doc']=='informePreliminar' ){
    // $contenido = Siniestros::verInformePreliminar($r['timerst']);
    include "formato/informePreliminar.php";
}
   



/* *******************
*  FUNCIONES NATIVAS PARA LA LIBRERIA DEL PDF
*********************** */

$contenido = Siniestros::verPrimeraAtencion($r['timerst']);
include "formato/primeraAtencion.php";

// instanciar y usar la clase dompdf 
$dompdf = new  Dompdf ();
$dompdf -> loadHtml ( 'hola mundo' );

// (Opcional) Configure el tamaño y la orientación del papel 
$dompdf -> setPaper ( 'letter' , 'portail' );

// Renderiza el HTML como PDF 
$dompdf -> render ();

// Envía el PDF generado al navegador VIEW
$dompdf -> stream("doc.pdf", ['Attachment' => false]);
exit(0);