<?php
// hacer referencia al espacio de nombres Dompdf 
require_once  './assets/plugins/dompdf/autoload.inc.php' ;
use  Dompdf\Dompdf;

// instanciar y usar la clase dompdf 
$dompdf = new  Dompdf ();
$dompdf -> loadHtml ( 'hola mundo' );

// (Opcional) Configure el tamaño y la orientación del papel 
$dompdf -> setPaper ( 'letter' , 'portail' );

// Renderiza el HTML como PDF 
$dompdf -> render ();

// Envía el PDF generado al navegador para DOWNLOAD
$dompdf -> stream ();