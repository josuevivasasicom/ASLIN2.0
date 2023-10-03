<?php






// ob_start();

// error_reporting(E_ALL);
// ini_set('display_errors', '2');

 
date_default_timezone_set("America/Mexico_City");

require_once './utils/Database.php';
require_once './utils/Core.php';
require_once './utils/Hoteles.php';

$sql= "select * from pruebas 
inner join usuarios u
on id_usuario = u.id
where prueba = '".$_GET['codigo']."' and estatus in('Positivo','Negativo')";
$query = Database::ExeDoIt($sql);
$data= $query[0]->fetch_assoc();

$prueba = $_GET["codigo"];

$hotelUperArr = []; 
foreach (Hoteles::$hoteles_nombres as $key => $value) {
	$hotelUperArr[] = strtoupper($value);
}
$hotelnum = array_search(strtoupper($data['hotel']),$hotelUperArr);
$tipoPruebaPDF = $data['tipo_test']=='Prueba de Antigenos'?'anti':'pcr';//$_GET["tipo"];
$hotelPaciente = Hoteles::$hoteles_corto[$hotelnum]; //$_GET["hotel"];


/* echo "<pre>";
print_r($hotelPaciente);
echo "<br>";print_r($tipoPruebaPDF);
echo "<br>";print_r($prueba);
echo "</pre>"; */

 error_reporting(E_ALL ^ E_DEPRECATED); 


//ELMM //require_once dirname(__FILE__).'./../vendor/autoload.php';
error_reporting(E_ALL);
ini_set('display_errors', '1');

date_default_timezone_set("America/Mexico_City");

require_once './vendor/autoload.php';

use Spipu\Html2Pdf\Html2Pdf;


try {
    ob_start();
	error_reporting(E_ALL & ~E_NOTICE);
	ini_set('display_errors', 1);
	ini_set('log_errors', 1);
	
	//TODOS LOS HOTELES PCR
	if($hotelPaciente != "HGE" && $tipoPruebaPDF == "pcr"){
		$html = ob_get_clean();
		require_once './vistapcr.php';
		$html2pdf = new Html2Pdf('P','A4','es','true','UTF-8');
		$html2pdf->writeHTML($html);
		$html2pdf->output();

	}else 
	
	//TODOS LOS HOTELES ANTIGENOS
	if($hotelPaciente != "HGE" && $tipoPruebaPDF == "anti"){
		$html = ob_get_clean();
		
		require_once './demo.php';
		// require_once dirname(__FILE__) . './demo.php';
		// require_once './vistapdf.php';
// core::preprint($data);
		
		$html2pdf = new Html2Pdf('P','A4','es','true','UTF-8');
		// $html2pdf -> setTestIsImage ( true );
		$html2pdf->pdf->SetDisplayMode('fullpage');
		$html2pdf->pdf->SetProtection(array('print', 'copy'), '12345', null, 0, null);
        ob_end_clean();
		$html2pdf->writeHTML($html);
		$html2pdf->output('pruebaANTI.pdf','I');

	}else 

	//todo SOLO PARA HGE ANTIGENOS
	if($hotelPaciente == "HGE" && $tipoPruebaPDF == "anti"){
		require_once './generalvistapdf.php';
		$html = ob_get_clean();
		$html2pdf = new Html2Pdf('P','A4','es','true','UTF-8');
		$html2pdf->writeHTML($html);
		$html2pdf->output();
	}
} /*

catch (Html2PdfException $e) {
    $html2pdf->clean();

    $formatter = new ExceptionFormatter($e);
    echo $formatter->getHtmlMessage();
}*/


/* 
(
    [id] => 23221
    [prueba] => CRT6159
    [fecha_registro] => 2021-08-13 23:44:38
    [hora_registro] => 
    [habitacion] => 
    [id_usuario] => 23221
    [paciente] => ERICK MALAGON
    [nacimiento] => 02//
    [sexo] => 
    [fecha_entrada] => 
    [fecha_salida] => 
    [fecha_prueba] => 
    [hora_prueba] => 
    [tipo_test] => Prueba de Antigenos
    [nacionalidad] => 
    [origen] => 
    [destino] => 
    [pasaporte] => 
    [vuelo] => 
    [observaciones] => 
    [estatus] => Positivo
    [id_pago] => 
    [fecha] => 2021-08-06 20:51:52
    [fecha_resultado] => 0000-00-00
    [metodoPago] => Terminal
    [fechaPago] => 2021-08-14 16:32:25
    [fechaCita] => 0000-00-00 00:00:00
    [telefono] => 65654674
    [pagoValidado] => 
    [pagoValidadoFecha] => 0000-00-00 00:00:00
    [folioControl] => 
    [historico] => 
    [nombre] => ERICK
    [paterno] => MALAGON
    [materno] => SDAASD
    [email] => erick.leo.malagon@gmail.com
    [password] => $2y$12$sGctVMpKzsFn.QKN9fXNbOwH68W4HJVs84KMhjAxctI1cmoZMRMCC
    [fecha_nacimiento] => 
    [hotel] => Catalonia Royal Tulum
    [created_at] => 2021-08-06 20:51:52
    [alter_at] => 
    [active] => 1
    [rol] => 1
) 
*/
?>