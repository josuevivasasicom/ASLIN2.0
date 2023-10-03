<html>

<head>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">
<meta name=Generator content="Microsoft Word 15 (filtered)">

<style>
    @font-face
	{font-family:"Segoe UI";
        panose-1:2 11 5 2 4 2 4 2 2 3;}
	@font-face
	{font-family:"aealarabiya";
	panose-1:2 11 6 9 2 2 4 3 2 4;}
		/* Style Definitions */
		p.MsoNormal, li.MsoNormal, div.MsoNormal
			{margin-top:0cm;
			margin-right:0cm;
			margin-bottom:3.0pt;
			margin-left:0cm;
			text-align:center;
			line-height:107%;
			font-size:13.5pt;
			font-family:"aealarabiya",sans-serif;
			word-wrap: break-word;
			color:#636A6B;}
		h1,h2,h3,h4
			{
			mso-style-link:"Título 1 Car";
			margin-top:18.0pt;
			margin-right:0cm;
			margin-bottom:3.0pt;
			margin-left:0cm;
			text-align:center;
			line-height:1;
			page-break-after:avoid;
			font-size:12.5pt;
			font-family:"aealarabiya",sans-serif;
			color:#636A6B;
			text-transform:uppercase;
			letter-spacing:2.5pt;
			word-wrap: break-word;
			font-weight:normal;}
		
			
		
		span{
			color:#806000;
			font-variant:small-caps;
			font-style:italic;
			text-transform:none;
			page-break-after:avoid;
			font-size:11pt;
			font-family:"aealarabiya",sans-serif;
			word-wrap: break-word;
		}
		span.sptitle{
			color:#000000 !important;
			font-size: small !important;
			font-variant:small-caps;
			font-style:italic !important;
			text-transform:none;
			page-break-after:avoid;
			font-size:10.3pt;
			/* font-family:"aealarabiya",sans-serif; */
			word-wrap: break-word;
		}
		 *{
			font-size:11pt;
			font-size:11pt;
			word-wrap: break-word;
			word-wrap: break-word !important;
		 }
		
			
			
		/* Page Definitions */
		@page WordSection1{
			size:841.9pt 595.3pt ;
			margin:39.6pt 39.6pt 39.6pt 39.6pt;}
		div.WordSection1
			{page:WordSection1;}
		/* List Definitions */
		

</style>

</head>

<body lang=ES-MX>

<div class=WordSection1>

    <div valign="middle" align=center>

        <table valign="middle" align="center" class="MsoNormalTable" width="100%" border=0 cellspacing=0 cellpadding=0 summary="Diseño de tabla principal" style="margin-top:10px; border-collapse:collapse">
            <tr>
				<td width="117" valign="top" style='border:none;border-right:solid #FFD556 1.5pt; padding:0cm 0cm 0cm 0cm'>
					<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 summary="Diseño de tabla de lado izquierdo" width="350px" style='margin-left:1.45pt;border-collapse:collapse'>
						<tr style='height:126.0pt'>
							<td width="100" align="center" valign=top style='width:100.0%;border:none;border-bottom:solid #FFD556 1.5pt;padding:0cm 18.0pt 2.4pt 18.0pt;height:126.0pt'>
							<img width="120" style="margin-left:10px;width:120; width:120 !important;"  src="https://claimsmanager.online/assets/img/bg/logoCMA_white.jpg" alt="CMA">
							<h1 style="font-size: 20pt;font-weight: 100;"><span style="font-size: 20pt;font-weight: 100;" lang=ES>ID:</span></h1>  <b style="font-size: 20pt;font-weight: 100;"><?=$contenido['folio']?></b>
							
							<h2><span lang=ES>Área: </span></h2>
							<?php
								$areasAsignadas = Siniestros::getAllAreasOfSiniestro($contenido['timerst']);
								$contenido['areas'] = $areasAsignadas;
								$ars=' ';
								if(count($areasAsignadas)>=2){
									foreach ($areasAsignadas as $area) {
										// core::preprint($area['area']);exit();
										$ars .=  $area['area'].'<br>';
									}
									$ars = trim($ars,'<br> ');
								}else{
									$ars=$areasAsignadas[0]['area'];
								}

							?>
								 <b><?=$ars?></b>
							
							<h2><span lang=ES>Fecha Asignacion:  </span></h2>
								 <b><?=$contenido['fechaAsignacion_F']?></b>

							<h2><span lang=ES>Fecha Reporte:  </span></h2>
								 <b><?=$contenido['fechaReporte_F']?></b>

							<h2><span lang=ES>Número Reporte:  </span></h2>
							<b><?=$contenido['numReporte']?></b>

							<h2><span lang=ES>Número de Siniestro:  </span></h2>
								 <b><?=$contenido['numSiniestro']?></b>
							</td>
						</tr>
						
					</table>
					<p class=MsoNormal></p>
				</td>
				<td width=271 valign=top style='width:222.6pt;border:none;padding:0cm 0cm 0cm 0cm'>
				
				<table class=MsoNormalTable border=0 cellspacing=0 cellpadding=0 summary="Tabla de diseño de lado derecho amarillo" width="400px" style='border-collapse:collapse'>
					<tr>
						<td width="430" valign=top align="center" style='text-align:left;border:solid #FFD556 1.5pt; border-left:none;background:#fffbee;padding:0cm 18.0pt 0pt 18.0pt;height: auto;word-wrap: break-word;'>
						<h1>Informacion del ID: <?=$contenido['folio']?> </h1><br>
						</td>
					</tr>
					<tr>
						<td width="430" valign=top align="left" style="padding:0cm 18.0pt 0pt 18.0pt;height: auto;border-bottom:solid #FFD556 1.5pt;word-wrap: break-word;">
							<br>Asegurado:  <b><?=$contenido['nombre'].' '.$contenido['apellidoP'].' '.$contenido['apellidoM']?> </b>  <br>
							<!-- <br>Forma Contacto: <b><?php //$contenido['formaContacto']?>  </b> <br> -->
							<br>Email: <b><?=$contenido['mail']?>  </b> <br>
							<br>Telefonos: <b><?=$contenido['cel'].' '.$contenido['casa'].' '.$contenido['oficina']?>  </b> <br>

							<br>Estado/Ciudad: <b><?=$contenido['estado']?> - <?=$contenido['ciudad']?> </b> <br>
							<br>Institución: <b><?=$contenido['institucion']?></b> <br>
							<br>Autoridad: <b><?=$contenido['autoridad']?>  </b> <br>
							<br>TipoIntervencion: <b><?=$contenido['tipoIntervencion']?>  </b> <br>
							<br>
							<br>Tercero: <b><?=$contenido['tercero']?>  </b> <br>
							<br>Nicho: <b><?=$contenido['nicho']?>  </b> <br>
							<br>Materia: <b><?=$contenido['materia']?>  </b> <br>
							<br>Expediente: <b><?=$contenido['expediente']?>  </b> <br>
							<br>
							<?php
								/* $abogados='<ul>';
								//$abogadosAsignados = Siniestros::getAllAbogadosOnSiniestro($contenido['timerst']);
								//core::preprint($abogadosAsignados);
								foreach ($abogadosAsignados as $a) {
									$abogados.= '<li>'.$a['nombre'].' <span class="sptitle">'.$a['grupo'].'</span> </li>';
								}
								$abogados .= '</ul>'; */
							?>
							<!-- <hr>
							<br>Abogados Asignados: <br> <b><?=$abogados?></b> -->
							<?php

								$poli=' ';
								foreach ($contenido['poliza'] as $poliza){
									$poli.=$poliza['poliza'].'; ';
								}
								$poli = trim($poli,'; ');
							?>
							
							<br>
							<br>
							<br>Núm Póliza: <b> <?=$poli?></b> <br>
							<br>Vigencia Inicio <b> <?=$contenido['vigencia1_F']?></b> <br>
							<br>Vigencia Fin: <b> <?=$contenido['vigencia2_F']?></b> <br>
							<br>
						</td>
					</tr>
					<tr style='height:auto;height:auto !important;'>
						<td width="430" valign=top style='border-top:none;border-left:none;border-bottom:solid #FFD556 1.5pt;border-right:solid #FFD556 1.5pt;padding:0cm 18.0pt 0pt 18.0pt;'>
							<br><b>Calificación </b> <?=$contenido['calificacion']?>
							<br><b>Status: </b> <?=$contenido['status']?>
						</td>
					</tr>
					<!-- <tr>
						<td width="430" style='border-bottom:solid #FFD556 1.5pt;text-align:justify;'>
							<br><b>Descripcion de los hechos: </b> <br> <br>
							<?php // substr(trim(urldecode($contenido['descripcionHechos'])),0,500);?>
						</td>
					</tr> -->
					
				</table>
				</td>
            </tr>
        </table>

    </div>

<p class=MsoNoSpacing><span lang=ES>&nbsp;</span></p>

</div>

</body>

</html>
