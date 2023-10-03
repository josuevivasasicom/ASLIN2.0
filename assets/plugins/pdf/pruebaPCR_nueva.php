	<!DOCTYPE html>
	<html lang="es">
	<head>
		<meta charset="utf-8">
		<title></title>

		<script src="../assessments/vistas/bower_components/chart.js/Chart.js"></script>
		<script src="../assessments/vistas/bower_components/jquery/dist/jquery.min.js"></script>

		<style type="text/css">
			
    		table, tr, td {
                border-spacing:1px;
    		  border: 1px solid gray;
    	
    		}
		</style>

	</head>
	<body>

	<?php

	// require_once "../../controladores/administradores.controlador.php";
	// require_once "../../modelos/administradores.modelo.php";
	// require_once "../../modelos/rutas.php";

	$tabla = "pruebas";

	//$datos = ModeloAdministradores::mdlMostrarResultado($tabla, $prueba);
    $datos = $data;

	$tabla = "usuarios";
	$item = "id";
	$valor = $datos["id_usuario"];

	// $respuesta = ModeloAdministradores::mdlMostrarAdministradores($tabla, $item, $valor);
                                if ( $datos['estatus']!='Negativo' ){
                                    if($datos['estatus']!='Positivo'){
                                		echo "You don't have access #1LTs";
                                		?>
                                		
                                		
                                		<?php
                                		exit();
                                		header("Location: .?index.php");
                                        }
                                	}

	//$hotel = substr($datos["prueba"], 0, 3);
	$hotel = $valor["hotel"];

	$fecha = explode("-", $datos["fecha_resultado"]);
	$fechaPruebaCompleta = explode(" ", $datos["fecha"]);
	$fechaPrueba = explode("-", $fechaPruebaCompleta[0]);
	
	        $fecha_no = date("Y-m-d",strtotime($datos["fecha_resultado"]."- 1 days")); 
            //$fecha =date ("Y-m-d",strtotime($_REQUEST['date']));

	$nacimiento = explode("-", $datos["nacimiento"]);

	$fechaIn = "";
	$fechaEs = "";

	$fechaPruebaIn = "";
	$fechaPruebaEs = "";

	$nacimientoIn = "";
	$nacimientoEs = "";
	
	
	//$fecha_prueba_menosIn= $fecha_textIn.' '.explode('-',$fecha_no)[2].', '.explode('-',$fecha_no)[0];
	//$fecha_prueba_menosEs= explode('-',$fecha_no)[2];
	
	//$fecha_textIn = explode(' ',$fechaPruebaIn)[0];
	//$fecha_textEs = explode(' ',$fechaPruebaEs[2]);

	switch ($fecha[1]) {

				case '01':
					$fechaIn .= "January ".$fecha[2].", ".$fecha[0];

					$fechaEs = $fecha[2]." de Enero del ".$fecha[0];

				break;

				case '02':
					$fechaIn .= "February ".$fecha[2].", ".$fecha[0];

					$fechaEs = $fecha[2]." de Febrero del ".$fecha[0];

				break;

				case '03':
					$fechaIn .= "March ".$fecha[2].", ".$fecha[0];

					$fechaEs = $fecha[2]." de Marzo del ".$fecha[0];

				break;

				case '04':
					$fechaIn .= "April ".$fecha[2].", ".$fecha[0];

					$fechaEs = $fecha[2]." de Abril del ".$fecha[0];

				break;

				case '05':
					$fechaIn .= "May ".$fecha[2].", ".$fecha[0];

					$fechaEs = $fecha[2]." de Mayo del ".$fecha[0];

				break;

				case '06':
					$fechaIn .= "June ".$fecha[2].", ".$fecha[0];

					$fechaEs = $fecha[2]." de Junio del ".$fecha[0];

				break;

				case '07':
					$fechaIn .= "July ".$fecha[2].", ".$fecha[0];

					$fechaEs = $fecha[2]." de Julio del ".$fecha[0];

				break;

				case '08':
					$fechaIn .= "August ".$fecha[2].", ".$fecha[0];

					$fechaEs = $fecha[2]." de Agosto del ".$fecha[0];

				break;

				case '09':
					$fechaIn .= "September ".$fecha[2].", ".$fecha[0];

					$fechaEs = $fecha[2]." de Septiembre del ".$fecha[0];

				break;

				case '10':
					$fechaIn .= "October ".$fecha[2].", ".$fecha[0];

					$fechaEs = $fecha[2]." de Octubre del ".$fecha[0];

				break;

				case '11':
					$fechaIn .= "November ".$fecha[2].", ".$fecha[0];

					$fechaEs = $fecha[2]." de Noviembre del ".$fecha[0];

				break;

				case '12':
					$fechaIn .= "December ".$fecha[2].", ".$fecha[0];

					$fechaEs = $fecha[2]." de Diciembre del ".$fecha[0];

				break;
				
				default:
				break;

	}

	switch ($fechaPrueba[1]) {

				case '01':

					$fechaPruebaIn .= "January ".$fechaPrueba[2].", ".$fechaPrueba[0];
					$fechaPruebaEs = $fechaPrueba[2]." de Enero del ".$fechaPrueba[0];

				break;

				case '02':
					$fechaPruebaIn .= "February ".$fechaPrueba[2].", ".$fechaPrueba[0];
					$fechaPruebaEs = $fechaPrueba[2]." de Febrero del ".$fechaPrueba[0];
					

				break;

				case '03':
					$fechaPruebaIn .= "March ".$fechaPrueba[2].", ".$fechaPrueba[0];
					$fechaPruebaEs = $fechaPrueba[2]." de Marzo del ".$fechaPrueba[0];

				break;

				case '04':
					$fechaPruebaIn .= "April ".$fechaPrueba[2].", ".$fechaPrueba[0];
					$fechaPruebaEs = $fechaPrueba[2]." de Abril del ".$fechaPrueba[0];

				break;

				case '05':
					$fechaPruebaIn .= "May ".$fechaPrueba[2].", ".$fechaPrueba[0];
					$fechaPruebaEs = $fechaPrueba[2]." de Mayo del ".$fechaPrueba[0];

				break;

				case '06':
					$fechaPruebaIn .= "June ".$fechaPrueba[2].", ".$fechaPrueba[0];
					$fechaPruebaEs = $fechaPrueba[2]." de Junio del ".$fechaPrueba[0];

				break;

				case '07':
					$fechaPruebaIn .= "July ".$fechaPrueba[2].", ".$fechaPrueba[0];
					$fechaPruebaEs = $fechaPrueba[2]." de Julio del ".$fechaPrueba[0];
					
				break;

				case '08':
					$fechaPruebaIn .= "August ".$fechaPrueba[2].", ".$fechaPrueba[0];
					$fechaPruebaEs = $fechaPrueba[2]." de Agosto del ".$fechaPrueba[0];
					
				break;

				case '09':
					$fechaPruebaIn .= "September ".$fechaPrueba[2].", ".$fechaPrueba[0];
					$fechaPruebaEs = $fechaPrueba[2]." de Septiembre del ".$fechaPrueba[0];
					
				break;

				case '10':
					$fechaPruebaIn .= "October ".$fechaPrueba[2].", ".$fechaPrueba[0];
					$fechaPruebaEs = $fechaPrueba[2]." de Octubre del ".$fechaPrueba[0];
					
				break;

				case '11':
					$fechaPruebaIn .= "November ".$fechaPrueba[2].", ".$fechaPrueba[0];
					$fechaPruebaEs = $fechaPrueba[2]." de Noviembre del ".$fechaPrueba[0];
					
				break;

				case '12':
					$fechaPruebaIn .= "December ".$fechaPrueba[2].", ".$fechaPrueba[0];
					$fechaPruebaEs = $fechaPrueba[2]." de Diciembre del ".$fechaPrueba[0];
				break;
				
				default:
				break;

	}

	switch ($nacimiento[1]) {

				case '01':
					$nacimientoIn .= "January ".$nacimiento[2].", ".$nacimiento[0];

					$nacimientoEs = $nacimiento[2]." de Enero del ".$nacimiento[0];

				break;

				case '02':
					$nacimientoIn .= "February ".$nacimiento[2].", ".$nacimiento[0];

					$nacimientoEs = $nacimiento[2]." de Febrero del ".$nacimiento[0];

				break;

				case '03':
					$nacimientoIn .= "March ".$nacimiento[2].", ".$nacimiento[0];

					$nacimientoEs = $nacimiento[2]." de Marzo del ".$nacimiento[0];

				break;

				case '04':
					$nacimientoIn .= "April ".$nacimiento[2].", ".$nacimiento[0];

					$nacimientoEs = $nacimiento[2]." de Abril del ".$nacimiento[0];

				break;

				case '05':
					$nacimientoIn .= "May ".$nacimiento[2].", ".$nacimiento[0];

					$nacimientoEs = $nacimiento[2]." de Mayo del ".$nacimiento[0];

				break;

				case '06':
					$nacimientoIn .= "June ".$nacimiento[2].", ".$nacimiento[0];

					$nacimientoEs = $nacimiento[2]." de Junio del ".$nacimiento[0];

				break;

				case '07':
					$nacimientoIn .= "July ".$nacimiento[2].", ".$nacimiento[0];

					$nacimientoEs = $nacimiento[2]." de Julio del ".$nacimiento[0];

				break;

				case '08':
					$nacimientoIn .= "August ".$nacimiento[2].", ".$nacimiento[0];

					$nacimientoEs = $nacimiento[2]." de Agosto del ".$nacimiento[0];

				break;

				case '09':
					$nacimientoIn .= "September ".$nacimiento[2].", ".$nacimiento[0];

					$nacimientoEs = $nacimiento[2]." de Septiembre del ".$nacimiento[0];

				break;

				case '10':
					$nacimientoIn .= "October ".$nacimiento[2].", ".$nacimiento[0];

					$nacimientoEs = $nacimiento[2]." de Octubre del ".$nacimiento[0];

				break;

				case '11':
					$nacimientoIn .= "November ".$nacimiento[2].", ".$nacimiento[0];

					$nacimientoEs = $nacimiento[2]." de Noviembre del ".$nacimiento[0];

				break;

				case '12':
					$nacimientoIn .= "December ".$nacimiento[2].", ".$nacimiento[0];

					$nacimientoEs = $nacimiento[2]." de Diciembre del ".$nacimiento[0];

				break;
				
				default:
				break;

	}

	/*switch ($hotel) {

				case 'CRT':
					$hotel = "CATALONIA ROYAL TULUM";
				break;

				case 'CRM':
					$hotel = "CATALONIA RIVIERA MAYA";
				break;

				case 'CPM':
					$hotel = "CATALONIA PLAYA MAROMA";
				break;

				case 'CMU':
					$hotel = "CATALONIA COSTA MUJERES";
				break;
				
				default:
					$hotel = "Hotel de prueba";
				break;
	}*/

	$resultado;

	if($datos["estatus"] == "Positivo"){

		$resultado = "Positive";

	}else 
	if($datos["estatus"] == "Negativo"){

		$resultado = "Negative";

	}else{

		$resultado = "null";

	}

	?>

	<!--	
	Pagina 1
	-->

	<img src="../../vistas/img/plantilla/fondopdf.jpg" style="width: 100%; height: 100%; position: absolute;">

	<div style="text-align: center; height: 100%; position: absolute;">

		<img src="../../vistas/img/plantilla/encabezado6.jpg" style="width: 100%; position: relative; position: absolute; left: 0px;">

		<br>
		<br>
		<br>

		<div style="position: absolute; top: 10%; left: 50%; margin-left: -50%; text-align: left; margin-top: 0%;">

			<p>We hereby inform you that on <b><?=$fechaIn?></b>, the result obtained from your molecular PCR test was <b><?=$resultado;?></b> for SARS-CoV-2 or Covid 19 virus, which is endorsed by Medialisis S.A. de C.V. Private diagnostic laboratory located at Boulevard Playa del Carmen Mz 255 Lt 25 Local 44, Col. Ejido, Playa del Carmen, Solidaridad, Quintana Roo, México. CP 77712 COFEPRIS Operation Notice No. 213300536X0283.
			</p>
			
		</div>

		<div style="width: 99%; text-align: left; margin-left: 0%; position: absolute; top: 15%;"> 
				
			<table style="width: 100%; text-align: center; margin-top: 10%;">
			    <tr>
					<td style="width: 15%; color: #000000; text-align: left;"> <span style="font-weight: normal;">No Report</span></td>
					<td style="width: 84%;  color: #000000; text-align: left;"><span style="font-weight: normal;"><b><?=$datos['folioControl']?$datos['folioReporte']:'S/N'?> </b></span></td>
				</tr>

				<tr>
					<td style="width: 15%; color: #000000; text-align: left;"><h5 style="font-weight: normal;">Sample type</h5></td>
					<td style="width: 84%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;">Oropharingeal</h5></td>
				</tr>

			</table>
			
			<table style="width: 100%; text-align: center; margin-top: 0%;">
				<tr>
					<td style="width: 15%; color: #000000; text-align: left;"><span style="font-weight: normal;">Method</span></td>
					<td style="width: 84%;  color: #000000; text-align: left;"><span style="font-weight: normal;">Real time PCR</span></td>
				</tr>
			</table>

			<table style="width: 100%; text-align: center; margin-top: 0%;">
				<tr>
					<td style="width: 15%; color: #000000; text-align: left;"><h5 style="font-weight: normal;">Patient</h5></td>
					<td style="width: 44%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;"><b><?=$datos["paciente"]?></b></h5></td>
					<td style="width: 20%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;">Date of birth :<br><b><?=$nacimientoIn?></b></h5></td>
					<td style="width: 20%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;">Passport No :<br><b><?=$datos["pasaporte"]?></b></h5></td>
				</tr>
			</table>

			
			<table style="width: 100%; text-align: center; margin-top: 0%;">

				<tr>
					<td style="width: 25%; color: #000000; text-align: left;"><h5 style="font-weight: normal; text-align: center;">Test type</h5></td>

					<td style="width: 40%;  color: #000000; text-align: left;">
						<h5 style="font-weight: normal; text-align: center;">SARS-CoV-2 BY PCR</h5>
					</td>

					<td style="width: 34%;  color: #000000; text-align: left;"><h5 style="font-weight: normal; text-align: center;">

						<strong>INTERPRETATION</strong>
						<br>
						<b><?=$resultado?></b> to SARS-Cov-2

					</h5></td>

				</tr>

			</table>

			<table style="width: 100%; text-align: center; margin-top: 0%;">
			
				<tr>
					<td style="width: 99%; background-color: #EEEEEE; color: #000000; text-align: left;"><span style=""><b>GENERAL DESCRIPTION</b></span></td>
				</tr>

				<tr>
					<td style="width: 99%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;">

					Extraction of viral RNA from the submitted sample.
					<br><br>
					Amplification and reading of the viral RNA fragments of interest by means of a real-time PCR thermocycler.</h5></td>
				</tr>

				<tr>
					<td style="width: 99%; background-color: #EEEEEE; color: #000000; text-align: left;"><span style=""><b>NOTE</b></span></td>
				</tr>

				<tr>
					<td style="width: 99%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;">

						The results obtained in this report should be considered in the context of other clinical and pathological factors of the patient.
						<br>
						The existence of Informed Knowledge is assumed to proceed with the realization of this genetic study
						<br>
						<br>
						This analytical diagnosis was carried out with DirectDetect SARS-CoV-2 Detection Kit (PCR-Flourrescence<br>
                        manufactured by Coyote Bioscience Co., Ltd and autorized by InDRE with official letter DGE-DDYR-11408-2020.
						<br>
					</h5></td>

				</tr>

			</table>
			
			<table style="width: 100%; text-align: center; margin-top: 0%;">
			    <tr>
					<td style="width: 15%; color: #000000; text-align: left;"> <span style="font-weight: normal;">Aprobe by</span></td>
					<td style="width: 84%;  color: #000000; text-align: left;"><span style="font-weight: normal;">Q.F.B. CESAR ARIZMENDI MONTOYA Ced. Prof. 4389381</span></td>
				</tr>

				<tr>
					<td style="width: 15%; color: #000000; text-align: left;"><h5 style="font-weight: normal;">Date of Test</h5></td>
					<td style="width: 84%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;"><b><?=$datos["fecha_prueba"]."  ".$datos["hora_prueba"]?></b></h5></td>
				</tr>

			</table>
			

			<table style="width: 100%; text-align: center; margin-top: 0%;">
			
				<tr>
					<td style="width: 20%; color: #000000; text-align: left;"><h5 style="font-weight: normal; text-align: center;">NAME AND SIGNATURE OF RESPONSIBLE</h5></td>

					<td style="width: 30%;  color: #000000; text-align: left;"><h5 style="font-weight: normal; text-align: center;">Q.F.B. CESAR ARIZMENDI MONTOYA<br><br><br><br></h5></td>
					<br>
					<img src="../../vistas/img/plantilla/firmapcr2PCR.png" style="width: 7%; margin-left: -150px; margin-top: -60px;">

					<td style="width: 49%;  color: #000000; text-align: left;"><h5 style="font-weight: normal; text-align: center;">
					<br>
					Ced. Prof. 4389381
					<br>
					</h5></td>

				</tr>

			</table>

			<table style="width: 100%; text-align: center; margin-top: 0%; border: none;">
			
				<tr>
					<td style="width: 15%; color: #000000; text-align: left; border: none;"><h5 style=""></h5></td>
					<td style="width: 84%; color: #000000; text-align: right; border: none;"><h5 style="font-weight: normal;">
					
					GRUPO DIEMSA, S.A. DE C.V.
					<br>
					RFC: GDI-110511-BZ9
					<br>
					Av. Bonampak MZA 27 LT 1-2 UC 54
					<br>
					Edif. Diomeda Local 14, Cancún Centro
					<br>
					77500 Benito Juárez Cancún, Quintana Roo
					<br>
					Tels: 9983132255 / 555286-0507 / 555544-2819. Email: grupo_diemsa@hotmail.com

					</h5></td>
				</tr>

			</table>


		</div>

	</div>

	<!--	
	Pagina 2
	-->

	<img src="../../vistas/img/plantilla/fondopdf.jpg" style="width: 100%; height: 100%; position: relative; top: 100%;">

	<div style="text-align: center; height: 100%; position: absolute;">

		<img src="../../vistas/img/plantilla/encabezado6.jpg" style="width: 100%; position: relative; position: absolute; left: 0px;">
		<br>
		<br>

		<div style="position: absolute; top: 10%; left: 50%; margin-left: -50%; text-align: left; margin-top: 0%;">

			<p>Por la presente le informamos que el día <?=$fechaEs?>, el resultado obtenido de su prueba molecular PCR fue <b><?php echo $datos["estatus"];?></b> para el virus SARS-CoV-2 ó Covid 19, el cual es avalado por Medialisis S.A. de C.V. Laboratorio de diagnóstico privado con domicilio en Boulevard Playa del Carmen Mz 255 Lt 25 Local 44, Col. Ejido, Playa del Carmen, Solidaridad, Quintana Roo, México. CP 77712 Aviso de funcionamiento COFEPRIS 213300536X0283.
			</p>
			
		</div>

		<div style="width: 99%; text-align: left; margin-left: 0%; position: absolute; top: 15%;"> 
				
			<table style="width: 100%; text-align: center; margin-top: 10%;">
			    
			    <tr>
					<td style="width: 15%; color: #000000; text-align: left;"> <span style="font-weight: normal;">No Report</span></td>
					<td style="width: 84%;  color: #000000; text-align: left;"><span style="font-weight: normal;"><b><?=$datos['folioControl']?$datos['folioReporte']:'324324324'?> </b></span></td>
				</tr>

				<tr>
					<td style="width: 15%; color: #000000; text-align: left;"><h5 style="font-weight: normal;">Tipo de muestra</h5></td>
					<td style="width: 84%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;">HISOPADO OROFARINGEO</h5></td>
				</tr>

			</table>
			
			<table style="width: 100%; text-align: center; margin-top: 0%;">
				<tr>
					<td style="width: 15%; color: #000000; text-align: left;"><span style="font-weight: normal;">Método</span></td>
					<td style="width: 84%;  color: #000000; text-align: left;"><span style="font-weight: normal;">PCR en tiempo real</span></td>
				</tr>
			</table>

			<table style="width: 100%; text-align: center; margin-top: 0%;">
			    <tr>
					<td style="width: 15%; color: #000000; text-align: left;"><h5 style="font-weight: normal;">Paciente</h5></td>
					<td style="width: 44%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;"><b><?=$datos["paciente"]?></b></h5></td>
					<td style="width: 20%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;">Fecha de nacimiento :<br><b><?=$nacimientoEs?></b></h5></td>
					<td style="width: 20%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;">No. Pasaporte:<br><b><?=$datos["pasaporte"]?></b></h5></td>
				</tr>
			</table>

			<table style="width: 100%; text-align: center; margin-top: 0%;">

				<tr>
					<td style="width: 25%; color: #000000; text-align: left;"><h5 style="font-weight: normal; text-align: center;">Tipo de Muestra</h5></td>
					<td style="width: 40%;  color: #000000; text-align: left;"><h5 style="font-weight: normal; text-align: center;">SARS-CoV-2 POR PCR</h5></td>
					<td style="width: 34%;  color: #000000; text-align: left;"><h5 style="font-weight: normal; text-align: center;">
						<strong>INTERPRETACIÓN</strong>
						<br><br>
						<b><?=$datos["estatus"]?></b> SARS-Cov-2
					</h5></td>

				</tr>

			</table>

			<table style="width: 100%; text-align: center; margin-top: 0%;">
			
				<tr>
					<td style="width: 99%; background-color: #EEEEEE; color: #000000; text-align: left;"><span style=""><b>DESCRIPCIÓN GENERAL</b></span></td>
				</tr>

				<tr>
					<td style="width: 99%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;">

					Extracción de ARN viral a partir de la muestra remitida
					<br><br>
					Amplificación y lectura de los fragmentos de ARN viral de interés mediante termociclador PCR en tiempo real.</h5></td>
				</tr>

				<tr>
					<td style="width: 99%; background-color: #EEEEEE; color: #000000; text-align: left;"><span style=""><b>NOTA</b></span></td>
				</tr>

				<tr>
					<td style="width: 99%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;">

						Los resultados obtenidos en este informe deben ser considerados en el contexto de otros factores clínicos y patológicos del paciente.
						<br>
						Se asume la existencia del Conocimiento Informado para proceder a la realización del presente estudio genético.
						<br>
						<br>
						Este diagnóstico analítico fue realizado con kits de diagnóstico DirectDetect SARS-CoV-2 Detection Kit (PCR-Fluorescence<br>
                        Probe) fabricados por Coyote Bioscience Co., Ltd y autorizados por el InDRE con oficio DGE-DDYR-11408-2020.
						<br>
				
					</h5></td>

				</tr>

			</table>
			
			<table style="width: 100%; text-align: center; margin-top: 0%;">
			    <tr>
					<td style="width: 15%; color: #000000; text-align: left;"> <span style="font-weight: normal;">Aprobado por </span></td>
					<td style="width: 84%;  color: #000000; text-align: left;"><span style="font-weight: normal;">Q.F.B. CESAR ARIZMENDI MONTOYA Ced. Prof. 4389381</span></td>
				</tr>
				<tr>
					<td style="width: 15%; color: #000000; text-align: left;"><h5 style="font-weight: normal;">Fecha de la Prueba</h5></td>
					<td style="width: 84%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;"><b><?=$datos["fecha_prueba"]."  ".$datos["hora_prueba"]?></b></h5></td>
				</tr>
			</table>
			

			<table style="width: 100%; text-align: center; margin-top: 0%;">
			
				<tr>
					<td style="width: 20%; color: #000000; text-align: left;"><h5 style="font-weight: normal; text-align: center;">NOMBRE Y FIRMA DEL RESPONSABLE</h5></td>

					<td style="width: 30%;  color: #000000; text-align: left;"><h5 style="font-weight: normal; text-align: center;">Q.F.B. CESAR ARIZMENDI MONTOYA<br><br><br><br></h5></td>
					<br>
					<img src="../../vistas/img/plantilla/firmapcr2PCR.png" style="width: 7%; margin-left: -150px; margin-top: -60px;">

					<td style="width: 49%;  color: #000000; text-align: left;"><h5 style="font-weight: normal; text-align: center;">
					<br>
					Ced. Prof. 4389381
					<br>
					</h5></td>

				</tr>

			</table>

			<table style="width: 100%; text-align: center; margin-top: 0%; border: none;">
			
				<tr>
					<td style="width: 15%; color: #000000; text-align: left; border: none;"><h5 style=""></h5></td>
					<td style="width: 84%; color: #000000; text-align: right; border: none;"><h5 style="font-weight: normal;">
					
					GRUPO DIEMSA, S.A. DE C.V.
					<br>
					RFC: GDI-110511-BZ9
					<br>
					Av. Bonampak MZA 27 LT 1-2 UC 54
					<br>
					Edif. Diomeda Local 14, Cancún Centro
					<br>
					77500 Benito Juárez Cancún, Quintana Roo
					<br>
					Tels: 9983132255 / 555286-0507 / 555544-2819. Email: grupo_diemsa@hotmail.com

					</h5></td>
				</tr>

			</table>


		</div>

	</div>

	</body>


	</html>