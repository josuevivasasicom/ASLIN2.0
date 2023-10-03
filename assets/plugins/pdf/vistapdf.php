	<!DOCTYPE html>
	<html lang="es">
	<head>
		<meta charset="utf-8">
		<title></title>

		<script src="../assessments/vistas/bower_components/chart.js/Chart.js"></script>
		<script src="../assessments/vistas/bower_components/jquery/dist/jquery.min.js"></script>

		<style type="text/css">
			
		<style>
		table, tr, td {
		  border: 1px solid gray;
		  border-collapse: collapse;
		}
		</style>

	</head>
	<body>

	<?php

	require_once "../../controladores/administradores.controlador.php";
	require_once "../../modelos/administradores.modelo.php";
	require_once "../../modelos/rutas.php";

	$tabla = "pruebas";

	$datos = ModeloAdministradores::mdlMostrarResultado($tabla, $prueba);

	$tabla = "usuarios";
	$item = "id";
	$valor = $datos["id_usuario"];

	$respuesta = ModeloAdministradores::mdlMostrarAdministradores($tabla, $item, $valor);
	
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

	$nacimiento = explode("-", $datos["nacimiento"]);

	$fechaIn = "";
	$fechaEs = "";

	$nacimientoIn = "";
	$nacimientoEs = "";

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

	/*
	switch ($hotel) {

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

	}else{

		$resultado = "Negative";

	}

	?>

	<!--	
	Pagina 1
	-->

	<img src="../../vistas/img/plantilla/fondopdf.jpg" style="width: 100%; height: 100%; position: absolute;">

	<div style="text-align: center; height: 100%; position: absolute;">

		<img src="../../vistas/img/plantilla/encabezado2.jpg" style="width: 100%; position: relative; position: absolute; left: 0px;">

		<br>
		<br>
		<br>

		<div style="position: absolute; top: 10%; left: 50%; margin-left: -50%; text-align: left; margin-top: 0%;">

			<p>Estimated <strong><?php echo $datos["paciente"];?></strong> result of the test that was carried out <strong><?php echo $fechaIn;?></strong> was <strong><?php echo $resultado;?></strong>.
			<br>
			Hereby Rapid Test "ROCHE "GRUPO DIEMSA, S. A. DE C. V." We want to thank the trust placed in our product that meets all the norms, quality standards and authorization by our authorities in Mexico "INDRE" INSTITUTO DE DIAGNOSTICO Y REFERENCIA EPIDEMIOLOGICOS and "COFEPRIS" COMISION FEDERAL PARA LA PROTECCIÓN CONTRA RIESGOS SANITARIOS.
			</p>

		    <p>By this means we inform you today <strong><?php echo $fechaIn;?></strong>, the result that came out  <strong><?php echo $resultado;?></strong> of the SARS-CoV-2, Rapid Antigen Test, which has been endorsed by the Centro de Estudios Cientificos y Clinicos Pharma, SA de CV (CECYC PHARMA) with RFC No. CEC050222MC8 authorized by COFEPRIS, according to authorization No. TA-17-20 as analytical unit and No. TA-20-20. CECYC Pharma is a scientific study laboratory authorized to perform and issue results of PCR, Antigens, nasopharynx and Blood tests, among many other studies.
			</p>
			
		</div>

		<div style="width: 99%; text-align: left; margin-left: 0%; position: absolute; top: 21%;"> 
				
			<table style="width: 100%; text-align: center; margin-top: 10%;">

				<tr>
					<td style="width: 15%; color: #000000; text-align: left;"><h5 style="font-weight: normal;">Sample type</h5></td>
					<td style="width: 84%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;">Nasopharynx</h5></td>
				</tr>

			</table>

			<table style="width: 100%; text-align: center; margin-top: 0%;">

				<tr>
					<td style="width: 15%; color: #000000; text-align: left;"><h5 style="font-weight: normal;">Patient</h5></td>

					<td style="width: 20%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;"><strong><?php echo $datos["paciente"];?></strong></h5></td>

					<td style="width: 15%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;">Date of birth</h5></td>

					<td style="width: 20%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;"><strong><?php echo $nacimientoIn;?></strong></h5></td>

					<td style="width: 14%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;">Passport No</h5></td>

					<td style="width: 15%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;"><strong><?php echo $datos["pasaporte"];?></strong></h5></td>

				</tr>

			</table>

			<table style="width: 100%; text-align: center; margin-top: 0%;">

				<tr>
					<td style="width: 15%; color: #000000; text-align: left;"><h5 style="font-weight: normal;">Medical Staff</h5></td>
					<td style="width: 84%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;">Obed Huerta Gómez</h5></td>
				</tr>

			</table>

			<table style="width: 100%; text-align: center; margin-top: 0%;">

				<tr>
					<td style="width: 25%; color: #000000; text-align: left;"><h5 style="font-weight: normal; text-align: center;">Test type</h5></td>

					<td style="width: 40%;  color: #000000; text-align: left;"><h5 style="font-weight: normal; text-align: center;">SARS-CoV-2 Rapid Antigen</h5></td>

					<td style="width: 34%;  color: #000000; text-align: left;"><h5 style="font-weight: normal; text-align: center;">

						<strong>INTERPRETATION</strong>
						<br><br>
						<?php echo $resultado;?> SARS CoV-19

					</h5></td>

				</tr>

			</table>

			<table style="width: 100%; text-align: center; margin-top: 0%;">
			
				<tr>
					<td style="width: 99%; background-color: #EEEEEE; color: #000000; text-align: left;"><h5 style="">GENERAL DESCRIPTION</h5></td>
				</tr>

				<tr>
					<td style="width: 99%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;">

					This test is a rapid chromatographic immunoassay for the qualitative detection of specific antigens of SARS-CoV-2 present in the human nasopharynx. This test is intended to detect antigen from the SARS-CoV-2 virus in individuals suspected of COVID-19. This product is strictly intended for professional use in laboratory and Point of Care environments.
					<br><br>
					A test validated by the INDRE (SARS-CoV2 Rapid antigen Test) is used for the Rapid detection of by Antigen SARS-CoV-2 virus COVID-19.</h5></td>
				</tr>

				<tr>
					<td style="width: 99%; background-color: #EEEEEE; color: #000000; text-align: left;"><h5 style="">CLINICAL RELEVANCE</h5></td>
				</tr>

				<tr>
					<td style="width: 99%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;">

						The SARS-CoV-2 Rapid Antigen Test showed 96.52 % of sensitivity and 99.68 % of specificity
						<br>
						<br>
						<strong>DATE OF TEST: <?php echo $fechaIn;?></strong>
					</h5></td>

				</tr>

			</table>

			<table style="width: 100%; text-align: center; margin-top: 0%;">
			
				<tr>
					<td style="width: 20%; color: #000000; text-align: left;"><h5 style="font-weight: normal; text-align: center;">NAME AND SIGNATURE OF RESPONSIBLE</h5></td>

					<td style="width: 25%;  color: #000000; text-align: left;"><h5 style="font-weight: normal; text-align: center;">Dr. Rosaura Aparicio Fabre</h5></td>
					<br>
					<img src="../../vistas/img/plantilla/firma.png" style="width: 5%; margin-left: -150px; margin-top: -30px;">

					<td style="width: 15%; color: #000000; text-align: left;"><h5 style="font-weight: normal; text-align: center;">Title</h5></td>

					<td style="width: 39%;  color: #000000; text-align: left;"><h5 style="font-weight: normal; text-align: center;">Chemistry Drug Biologist
					<br>
					M. in Biochemical Sciences 
					<br>
					Dr. In Biochemical Sciences
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

		<img src="../../vistas/img/plantilla/encabezado2.jpg" style="width: 100%; position: relative; position: absolute; left: 0px;">
		<br>
		<br>

		<div style="position: absolute; top: 8%; left: 50%; margin-left: -50%; text-align: left; margin-top: 0%;">

			<p>Estimado <strong><?php echo $datos["paciente"];?></strong> el resultado de la prueba que se realizo el día <strong><?php echo $fechaEs;?></strong> fue <strong><?php echo $datos["estatus"];?></strong>.
			<br>
			Por medio de la Prueba Rápida "ROCHE GRUPO DIEMSA, S. A. DE C. V." Queremos agradecer la confianza depositada en nuestro producto que cumple con todas las normas, estándares de calidad y autorización por parte de nuestras autoridades en México "INDRE" INSTITUTO DE DIAGNOSTICO Y REFERENCIA EPIDEMIOLÓGICOS y "COFEPRIS" COMISIÓN FEDERAL PARA LA PROTECCIÓN CONTRA RIESGOS SANITARIOS.
			</p>

		    <p>Por este medio informamos el día de hoy <strong><?php echo $fechaEs;?></strong>, el resultado <strong><?php echo $datos["estatus"];?></strong> de la prueba Rápida de Antígeno SARS-CoV-2, el cual ha sido avalado por el laboratorio del Centro de Estudios Científicos y Clínicos. Pharma, SA de CV (CECYC PHARMA) con RFC No. CEC050222MC8 autorizado por COFEPRIS, según autorización No. TA-17-20 como unidad analítica y No. TA-20-20. CECYC Pharma es un laboratorio de estudios científicos autorizado para realizar y emitir resultados de PCR, Antígenos, nasofaringe y análisis de sangre, entre muchos otros estudios.
			</p>
			
		</div>

		<div style="width: 99%; text-align: left; margin-left: 0%; position: absolute; top: 21%;"> 
				
			<table style="width: 100%; text-align: center; margin-top: 10%;">

				<tr>
					<td style="width: 15%; color: #000000; text-align: left;"><h5 style="font-weight: normal;">Tipo de muestra</h5></td>
					<td style="width: 84%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;">Nasofaringeo</h5></td>
				</tr>

			</table>

			<table style="width: 100%; text-align: center; margin-top: 0%;">

				<tr>
					<td style="width: 15%; color: #000000; text-align: left;"><h5 style="font-weight: normal;">Paciente</h5></td>

					<td style="width: 20%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;"><strong><?php echo $datos["paciente"];?></strong></h5></td>

					<td style="width: 15%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;">Fecha de nacimiento</h5></td>

					<td style="width: 20%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;"><strong><?php echo $nacimientoEs;?></strong></h5></td>

					<td style="width: 14%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;">Pasaporte No</h5></td>

					<td style="width: 15%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;"><strong><?php echo $datos["pasaporte"];?></strong></h5></td>

				</tr>

			</table>

			<table style="width: 100%; text-align: center; margin-top: 0%;">

				<tr>
					<td style="width: 15%; color: #000000; text-align: left;"><h5 style="font-weight: normal;">Personal Médico</h5></td>
					<td style="width: 84%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;">Obed Huerta Gómez</h5></td>
				</tr>

			</table>

			<table style="width: 100%; text-align: center; margin-top: 0%;">

				<tr>
					<td style="width: 25%; color: #000000; text-align: left;"><h5 style="font-weight: normal; text-align: center;">Tipo de Muestra</h5></td>

					<td style="width: 40%;  color: #000000; text-align: left;"><h5 style="font-weight: normal; text-align: center;">Antigeno Rápido de SARS-CoV-2</h5></td>

					<td style="width: 34%;  color: #000000; text-align: left;"><h5 style="font-weight: normal; text-align: center;">

						<strong>INTERPRETACIÓN</strong>
						<br><br>
						<?php echo $datos["estatus"];?> SARS CoV-19

					</h5></td>

				</tr>

			</table>

			<table style="width: 100%; text-align: center; margin-top: 0%;">
			
				<tr>
					<td style="width: 99%; background-color: #EEEEEE; color: #000000; text-align: left;"><h5 style="">DESCRIPCIÓN GENERAL</h5></td>
				</tr>

				<tr>
					<td style="width: 99%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;">

					Esta prueba es un inmuno ensayo cromatográfico rápido para la detección cualitativa de antígenos específicos del SARS-CoV-2 presentes en la nasofaringe humana. Esta prueba está destinada a detector antígeno del virus SARS-CoV-2 en individuos sospechosos a padecer COVID-19.
					<br>
					Este producto esta estrictamente destinado a un uso profesional en entornos y puntos de atención.
					<br><br>
					Prueba validado por INDRE (SARS-CoV2 Rapid antigen Test) es usado para la detección rápida de antígeno del virus SARS‐CoV‐2 COVID-19.</h5></td>
				</tr>

				<tr>
					<td style="width: 99%; background-color: #EEEEEE; color: #000000; text-align: left;"><h5 style="">RELEVANCIA CLÍNICA</h5></td>
				</tr>

				<tr>
					<td style="width: 99%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;">

						La prueba rápida de antígeno del SARS-CoV-2 muestra una sensibilidad del 96,52% y una especificidad del 99,68%.
						<br>
						<br>
						<strong>FECHA DE PRUEBA: <?php echo $fechaEs;?></strong>

					</h5></td>

				</tr>

			</table>

			<table style="width: 100%; text-align: center; margin-top: 0%;">
			
				<tr>
					<td style="width: 20%; color: #000000; text-align: left;"><h5 style="font-weight: normal; text-align: center;">NOMBRE Y FIRMA DEL RESPONSABLE</h5></td>

					<td style="width: 25%;  color: #000000; text-align: left;"><h5 style="font-weight: normal; text-align: center;">Dr. Rosaura Aparicio Fabre</h5></td>
					<br>
					<img src="../../vistas/img/plantilla/firma.png" style="width: 5%; margin-left: -150px; margin-top: -30px;">

					<td style="width: 15%; color: #000000; text-align: left;"><h5 style="font-weight: normal; text-align: center;">Título</h5></td>

					<td style="width: 39%;  color: #000000; text-align: left;"><h5 style="font-weight: normal; text-align: center;">Dr. Química Fármaco Bióloga
					<br>
					M. en Ciencias Bioquímicas
					<br>
					Dr. en Ciencias Bioquímicas
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