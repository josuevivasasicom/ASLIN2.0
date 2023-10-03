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
		  border: none;
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
	
                	            if ( $datos['estatus']!='Negativo' ){
                                    if($datos['estatus']!='Positivo'){
                                		echo "You don't have access #1LTs";
                                		?>
                                		
                                		
                                		<?php
                                		exit();
                                		header("Location: .?index.php");
                                        }
                                	}

	$hotel = substr($datos["prueba"], 0, 3);

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
	}

	$resultado;

	if($datos["estatus"] == "Positivo"){

		$resultado = "Positive";

	}else{

		$resultado = "Negative";

	}

	?>

	<!--	
	Pagina 2
	-->

	<div style="text-align: center; height: 100%; position: absolute;">

		<img src="../../vistas/img/plantilla/encabezado5.png" style="width: 100%; position: relative; position: absolute; left: 0px;">
		<br>
		<br>

		<div style="position: absolute; top: 8%; left: 50%; margin-left: -50%; text-align: left; margin-top: 0%; width: 40%">

			<p>Calderón de la Barca 208, Polanco lll Sección,
			<br>
			Miguel Hidalgo, C.P. 11550 Mexico City, Mexico.
			<br>
			RFC: CAM181218730
			<br>
			info@disaludclinic.com
			<br>
			</p>
			
		</div>

		<div style="position: absolute; top: 8%; left: 55%; margin-left: 0%; text-align: left; margin-top: 0%; width: 40%; text-align: right;">

			<p>Reporte de Resultados de laboratorio
			<br>
			Detección de SARS-CoV-2
			<br>
			</p>
			
		</div>

		<hr style="position: absolute; top: 17%; border:1px solid #000000; width:80%;margin-bottom:5px;">

		<div style="width: 99%; text-align: left; margin-left: 0%; position: absolute; top: 15%;"> 
				
			<table style="width: 100%; text-align: center; margin-top: 10%;">

				<tr>
					<td style="width: 15%; color: #000000; text-align: left;"><h5 style="font-weight: normal;"><strong>Estudio: </strong></h5></td>
					<td style="width: 34%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;"> Prueba de antígenos de SARS-CoV-2</h5></td>
					<td style="width: 15%; color: #000000; text-align: left;"><h5 style="font-weight: normal;"></h5></td>
					<td style="width: 34%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;"></h5></td>
				</tr>

				<tr>
					<td style="width: 15%; color: #000000; text-align: left;"><h5 style="font-weight: normal;"><strong>Nombre de paciente: </strong></h5></td>
					<td style="width: 34%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;"> <?php echo $datos["paciente"];?></h5></td>
					<td style="width: 15%; color: #000000; text-align: left;"><h5 style="font-weight: normal;"></h5></td>
					<td style="width: 34%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;"></h5></td>
				</tr>

				<tr>
					<td style="width: 15%; color: #000000; text-align: left;"><h5 style="font-weight: normal;"><strong>Fecha de nacimiento: </strong></h5></td>
					<td style="width: 34%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;"> <?php echo $nacimientoEs;?></h5></td>
					<td style="width: 15%; color: #000000; text-align: left;"><h5 style="font-weight: normal;"><strong>Sexo: </strong></h5></td>
					<td style="width: 34%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;"><?php echo $datos["sexo"];?></h5></td>
				</tr>

				<tr>
					<td style="width: 15%; color: #000000; text-align: left;"><h5 style="font-weight: normal;"><strong>Tipo de muestra: </strong></h5></td>
					<td style="width: 34%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;">  Hisopado nasofaríngeo</h5></td>
					<td style="width: 15%; color: #000000; text-align: left;"><h5 style="font-weight: normal;"><strong>Metodología: </strong></h5></td>
					<td style="width: 34%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;">Antígenos</h5></td>
				</tr>

				<tr>
					<td style="width: 15%; color: #000000; text-align: left;"><h5 style="font-weight: normal;"><strong>Fecha del informe: </strong></h5></td>
					<td style="width: 34%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;"> <?php echo $fechaEs;?></h5></td>
					<td style="width: 15%; color: #000000; text-align: left;"><h5 style="font-weight: normal;"></h5></td>
					<td style="width: 34%;  color: #000000; text-align: left;"><h5 style="font-weight: normal;"></h5></td>
				</tr>

			</table>

			<table style="width: 100%; text-align: center; margin-top: 0%; border-top: 2px solid #000000; border-bottom: 2px solid #000000;">

				<tr>
					<td style="width: 99%; color: #000000; text-align: center;"><h5 style="font-weight: normal;"><strong>Detección de antígenos SARS-CoV-2</strong></h5></td>
					
				</tr>

			</table>


		</div>

		<div style="position: absolute; top: 50%; left: 50%; margin-left: -50%; text-align: left; margin-top: 0%;">

			<p>
			<br>
			<strong>RESULTADO: <?php echo $datos["estatus"];?> A SARS CoV-2</strong>
			<br>
			<br>
			Un resultado No Detectado no descarta la presencia de inhibidores de PCR en la muestra del paciente o concentraciones de ácido ribonucleico (RNA) viral por debajo del nivel de detección de la prueba.
			<br>
			Un resultado Detectado indica la presencia de ácido ribonucleico (RNA) viral en el paciente.
			<br>
			<br>
			INFORMACIÓN INTERPRETATIVA:
			<br>
			Esta prueba debe realizarse para la detección de coronavirus SARS-CoV-2 en individuos que cumplen con los criterios clínicos y/o epidemiológicos de COVID-19. Esta prueba está basada en las guías publicadas por la Organización Mundial de la Salud (OMS).
			<br>
			<br>
			El resultado de este examen debe ser interpretado bajo el contexto de la información clínica y no debe ser utilizado como la única base para el diagnóstico y tratamiento del paciente. Un resultado negativo no excluye la posibilidad de una infección subclínica.
			<br>
			<br>
			La infección por SARS-CoV-2 es un padecimiento de notificación obligatoria a la Secretaría de Salud.
			</p>
			
		</div>

	</div>

	<img src="../../vistas/img/plantilla/footer2.png" style="width: 100%; width: 100%; position: absolute; top: 89%;">

	</body>


	</html>