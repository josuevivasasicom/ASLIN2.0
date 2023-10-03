<style>
	@page {
            margin: 3mm;
            width: 190mm;
    }

	
	h1 {page-break-before:always}

	.tablaTxt {
		position: absolute;
		width: 300px;
		right: 0px;
		top: 15px;
		min-width: 500px;
	}

	.tablaTxt tr td {
		text-align: center;
	}
	.anexoTablaDos tr th,
	.anexoTabla tr th{
		background: #7de8ff;
		text-align: center;
	}
	.anexoTablaDos td,
	.anexoTabla td {
		background: white !important;
		word-wrap:break-word !important;
		/* border-bottom: white; */
	}
	.anexoTabla{
		/* border-bottom: white; */
	}
	.col1table{
            width:35% !important;
        }
	.col2table{
		width:30% !important;
	}
	td{
		text-align: center;
		word-wrap: break-word;
		word-wrap: break-word !important;
		font-size: 13px;
	}
	th{
		font-weight: 300;
		font-weight: 300 !important;
		font-size: 14px;
	}
	
	.middle{
		vertical-align: middle;
		vertical-align: middle !important;
	}
	
	/* *,
	strong,b,
	p span,
	p{
	text-align:justify;
	text-align:justify !important;
	font-size: 14px;
	word-wrap: break-word;
	word-wrap: break-word !important;
	}
	p{width: 190mm; width: 190mm !important;}
	p span{width: 170mm;width: 170mm !important;}
	strong{width: 170mm;width: 170mm !important;}
	.page-break{
		page-break-before:always;
	}
	p *{
		padding-right: 4px;
		padding-right: 4px !important;
		text-align: justify;
		text-align: justify !important;
		align-content: space-between;

	}
	* p,p span, span,p strong, strong{
		padding-right: 4px;
		text-align: justify;
		text-align: justify !important;
	} */
	
	
	


</style>


<page  backtop="35mm" backbottom="10mm" backleft="7mm" backright="11mm">
    <page_header>
        <table style="width: 100%; border: solid 1px white;">
            <tr>
                <td style="text-align: left;    width: 33%"></td>
                <td style="text-align: center;    width: 34%"></td>
                <td style="text-align: right;    color:gray; width: 33%"><small><?php echo date('d/m/Y'); ?> página:[[page_cu]]/[[page_nb]]</small> </td>
            </tr>
        </table>
        <table style="width: 100%; border: solid 1px white;">
			<tr>
				<td style="width:45%;"><br>
					<img src="https://claimsmanager.online/pdf/formato/logoCMA__white.jpg" style="margin-top:45px;padding-bottom:0px;margin-bottom:-38px;width: 160px; height: auto; position: absolute;">
					<!-- <img src="./formato/logoCMA__white.jpg" style="margin-top:15px;padding-bottom:0px;margin-bottom:-18px;width: 150px; height: auto; position: absolute;"> -->
				</td>
				<td style="width:5%;">
					<p style="color:white">..</p>
				</td>
				<td style="width:50%;">
				</td>
			</tr>
		</table>
			<div class="tablaTxt">
                <table class="tablaTxt" style="width:100%;padding-right:30px; border:solid 1px black;" border=0 cellspacing=0>
                    <!-- <tr border=0 ><td border=0 colspan="2" style="color:white">.............................................................</td></tr> -->
                    <tr>
                        <td border=1 style="text-align:rigth; background-color: #dfbaa0;">Creado el :
                        </td>
                        <td style="text-align: center;" border=1 width="300"> <?=explode(' ',$contenido['fecha_creacion'])[0]?>
                        </td>
                    </tr>
                    <tr>
                            <td border=1 style="text-align:rigth; background-color: #dfbaa0;">Autor:
                            </td>
                        <td style="text-align: center;" border=1><?=$contenido['autor']?>
                        </td>
                    </tr>
                    <tr>
                            <td border=1 style="text-align:rigth; background-color: #dfbaa0;">ID:
                            </td>
                        <td style="text-align: center;" border=1><?=$contenido['folio']?>
                        </td>
                    </tr>
                    <tr>
                            <td border=1 style="text-align:rigth; background-color: #dfbaa0;">Asegurado:
                            </td>
                        <td style="text-align: center;" border=1><?=ucwords($contenido['asegurado'])?>
                        </td>
                    </tr>
					<tr>
                            <td border=1 style="text-align:rigth; background-color: #dfbaa0;">Área:
                            </td>
                        <td style="text-align: center;" border=1><?=ucwords($contenido['area'])?>
                        </td>
                    </tr>
                </table>
            </div>
		
	</page_header>
	<page_footer class="footer" >
        <table style="width: 100%; border: solid 0px gray;">
            <tr>
                <td style="text-align: left;  color:gray;  width: 80%">&nbsp;&nbsp;&nbsp;&nbsp;Cracovia No. 72, Int. APO-02, Col. San Ángel, Alcaldía Álvaro Obregón, C.P. O1000, CDMX</td>
                <td style="text-align: right; color:gray;   width: 20%"><b>CMA</b>   página: [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
	</page_footer>
    <?php
    echo "<p></p> <p></p>";
    echo '<div style="width: 100%; border: solid 0mm #770000; margin: 1mm; padding: 2mm; font-size: 4mm; line-height: normal; text-align: justify">';

	$pdfdoc = str_replace("%3Cstrong%3ES%2FN%3C%2Fstrong%3E", "%26nbsp%3B%26nbsp%3B%26nbsp%3B%26nbsp%3B%3Cstrong%3ES%2FN%3C%2Fstrong%3E", $contenido['informe_preliminar']);
    echo urldecode($pdfdoc);
	echo '</div>';

    // core::preprint($contenido,'contenido'); ///primer hoja

    $salto = '<div style="page-break-after:always"><span style="display:none">&nbsp;</span></div>'; //corte de página
	?>
</page>
<!-- //AQUI COMIENZA LA SEGUJDA PARTE -->


<page  backtop="35mm" backbottom="10mm" backleft="4mm" left="4mm" backright="4mm" right="4mm">
    <page_header>
        <table style="width: 100%; border: solid 1px white; padding:0px;">
            <tr>
                <td style="text-align: left;    width: 18%"></td>
                <td style="text-align: center;    width: 57%"> <b> GRUPO MEXICANO DE SEGUROS, S.A. DE C.V.</b></td>
                <td style="text-align: right;    color:gray; width: 25%"><small><?php echo date('d/m/Y'); ?> página:[[page_cu]]/[[page_nb]]</small> </td>
            </tr>
        </table>
        <table style="width: 100%; border: solid 0px white;">
			<tr>
				<td style="width:45%;"><br>
					<img src="https://claimsmanager.online/pdf/formato/gmx.png" style="margin-top:39px;margin-left:6px;padding-bottom:0px;margin-bottom:-28px;width: 180px; height: auto; position: absolute;">
					<!-- <img src="./formato/logoCMA__white.jpg" style="margin-top:15px;padding-bottom:0px;margin-bottom:-18px;width: 150px; height: auto; position: absolute;"> -->
				</td>
				<td style="width:5%;">
					<p style="color:white">..</p>
				</td>
				<td style="width:50%;">
				</td>
			</tr>
		</table>
			<div class="tablaTxt">
                <table class="tablaTxt" style="width:100%;padding-right:20px; border:solid 1px black;" border=0 cellspacing=0>
                    <!-- <tr border=0 ><td border=0 colspan="2" style="color:white">.............................................................</td></tr> -->
                    
                    <tr>
                        <td border=1 style="background-color: #7de8ff; text-align:right;">FECHA :
                        </td>
                        <td border=1 width="300"> <?=explode(' ',$contenido['fecha_creacion'])[0]?>
                        </td>
                    </tr>
					<tr>
                            <td border=1 style="background-color: #7de8ff;text-align:right;">SINIESTRO :
                            </td>
                        <td border=1><?=$contenido['numSiniestro']?>
                        </td>
                    </tr>
                    <tr>
                            <td border=1 style="background-color: #7de8ff;text-align:right;">RAMO:
                            </td>
                        <td border=1><?=$contenido['segundaParte']['ramo']?>
                        </td>
                    </tr>
					<tr>
                            <td border=1 style="background-color: #7de8ff;text-align:right;">SUB RAMO:
                            </td>
                        <td border=1><?=$contenido['segundaParte']['subramo']?>
                        </td>
                    </tr>

                    <tr>
                            <td border=1 style="background-color: #7de8ff;text-align:right;">REF ABOGADO:
                            </td>
                        <td border=1><?=$contenido['folio']?>
                        </td>
                    </tr>
					
                </table>
            </div>
		
	</page_header>
	<page_footer class="footer" >
        <table style="width: 100%; border: solid 0px gray;">
            <tr>
                <td  align="left" style="text-align: left;  color:gray;  width: 80%"> &nbsp;&nbsp;&nbsp;&nbsp; Cracovia No. 72, Int. APO-02, Col. San Ángel, Alcaldía Álvaro Obregón, C.P. O1000, CDMX</td>
                <td style="text-align: right; color:gray;   width: 20%"><b>CMA</b>   página: [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
	</page_footer>

	<?php
    $s= $contenido['segundaParte'];
    $c= $contenido;
	// core::preprint($c['calificacion']);
	
	switch ($c['calificacion']) { ///areglo de calificacion imporovisado
                case 291:
                     $c['calificacion'] = 'canc. admva.';
                    break;
                case 169:
                     $c['calificacion'] = 'Por determinar';
                    break;
                case 165:
                     $c['calificacion'] = 'Reapertura';
                    break;
                case 164:
                     $c['calificacion'] = 'Preventivo';
                    break;
                case 163:
                     $c['calificacion'] = 'Improcedente';
                    break;
                case '162':
                     $c['calificacion'] = 'Procedente';
                    break;
                case 161:
                     $c['calificacion'] = 'Asesoría';
                    break;
                default:
                     $c['calificacion'] = $c['calificacion'];
                    break;
            }
            
    ?>
	

    <table align="left" border="2" cellspacing="0" class="anexoTabla" style="width:100%;text-align:center;border-collapse:collapse; border:solid 0px red; margin-bottom:0px;border-bottom:0px;">
		<tr>
			<th width="180" colspan="2" style="text-align:center">N&Uacute;MERO DE P&Oacute;LIZA</th>
			<th width="320" colspan="2" style="text-align:center">NOMBRE DEL CONTRATANTE/ASEGURADO</th>
			<th width="177" colspan="2" style="text-align:center">FECHA OCURRIDO</th>
		</tr>
		<tr>
			<td width="180" colspan="2"><?=$s['noPoliza']?></td>
			<td width="320" colspan="2"><?=$s['asegurado']?></td>
			<td width="177" colspan="2" ><?=$s['fechaOcurrido']?></td>
		</tr>
		<tr>
			<th colspan="6">NOMBRE DEL RECLAMANTE Y/O TERCERO</th>
		</tr>
		<tr>
			<td colspan="6" style="text-align:center"><?=$s['tercero']?></td>
		</tr>

		<tr>
			<th colspan="2">CAUSA PROBABLE</th>
			<th colspan="2">LUGAR OCURRIDO</th>
			<th colspan="2">ESTADO/CIUDAD/POBLACI&Oacute;N</th>
		</tr>
		<tr>
			<td width="180" colspan="2"><?=$s['causa']?></td>
			<td width="320" colspan="2"><?=$s['lugar']?></td>
			<td width="177" colspan="2" ><?=$s['ciudad']?></td>
		</tr>
	</table>

	<table align="left" border="2" cellspacing="0" class="anexoTabla" style="width:100%;text-align:center;border-collapse:collapse; border:solid 0px red; border-top:0px;border-bottom:0px;margin-top:-2px;margin-bottom:0px;">
			<tr>
				<th width="182" colspan="1">AGENTE</th>
				<td width="525" colspan="4" style="text-align:center"><?=$s['agente']?></td>
			</tr>
			<tr>
				<th width="182" colspan="1">PRACTICA</th>
				<td width="525" colspan="4" style="text-align:center"><?=$s['practica']?></td>
			</tr>
	</table>

	<table align="left" border="2" cellspacing="0" class="anexoTabla" style="width:100%;text-align:center;border-collapse:collapse; border:solid 0px red; border-top:0px;margin-top:-2px ;margin-bottom:0px;border-bottom:0px;">
		<tr>
			<th width="168" colspan="2">VIGENCIA</th>
			<th width="170" rowspan="2">FECHA Y HORA<br />
			DE REPORTE</th>
			<th width="170" rowspan="2">FECHA Y HORA<br />
			DE ASIGNACI&Oacute;N</th>
			<th width="165" colspan="1" rowspan="2">FECHA Y HORA<br />
			DE 1A ATENCI&Oacute;N</th>
		</tr>
		<tr>
			<th>INICIO</th>
			<th>FIN</th>
		</tr>
		<tr>
			<td width="84" rowspan="2"><?=$s['vigenciaInicio']?></td>
			<td width="84" rowspan="2"><?=$s['vigenciaFin']?></td>
			<td width="170"><?=explode(' ',$s['fechaReporte'])[0]?></td>
			<td width="170"><?=explode(' ',$s['fechaAsignacion'])[0]?></td>
			<td width="165"><?=explode(' ',$s['fecha1raAtencion'])[0]?></td>
		</tr>
		<tr>
			<td><?=explode(' ',$s['fechaReporte'])[1]?></td>
			<td><?=explode(' ',$s['fechaAsignacion'])[1]?></td>
			<td><?=explode(' ',$s['fecha1raAtencion'])[1]?></td>
		</tr>
	</table>

	<table align="left" border="2" cellspacing="0" class="anexoTabla" style="width:100%;text-align:center;border-collapse:collapse; border:solid 0px red;margin-bottom:0px; margin-top:-2px;border-bottom:0px;">
			<tr>
				<th width="713" colspan="5">AUTORIDAD: OIC / JUICIO CIVIL / JUICIO PENAL<br /> RADICADO EN:</th>
			</tr>
			<tr>
				<td width="713" colspan="5"><?=$s['autoridad']?></td>
			</tr>
	</table>

	<table align="left" border="2" cellspacing="0" class="anexoTabla" style="width:100%;text-align:center;border-collapse:collapse; border:solid 0px red; margin-bottom:0px;margin-top:-2px;border-bottom:0px;">
		<tr>
			<th width="400" colspan="3">NO DE EXPEDIENTE:</th>
			<td width="294" colspan="2" style="text-align:center"><?=$s['noExpediente']?></td>
		</tr>
		<tr>
			<th width="400" colspan="3">ETAPA DE LA INDAGATORIA Y/O JUICIO</th>
			<td width="294" colspan="2" style="text-align:center"><?=$s['etapa']?></td>
		</tr>
		<tr>
			<th width="694" colspan="5">BREVE DESCRIPCI&Oacute;N DE LOS HECHOS&nbsp;</th>
		</tr>
	</table>


<!-- DESCRIPCION DE HECHOS -->


	<?=urldecode($contenido['segundaParte']['hechos'])?>

<br>

	<table align="left" border="1" cellpadding="0" cellspacing="0" class="anexoTabla" id="anexoTabla" style="background:#ffffff !important; width:100%;margin-bottom:0px;margin-top:-2px">
			
			<tr>
				<th width="180" colspan="2">CAUSA PR&Oacute;XIMA DEL</th>
				<td width="430" colspan="3" rowspan="1" style="text-align:center"><?=$s['causaProxima']?> </td>
			</tr>

			<tr>
				<th width="705" colspan="5" colspan>RECLAMACI&Oacute;N</th>
			</tr>
			<tr>
				<td width="705" style="word-wrap: break-word;" colspan="5"><?=$s['reclamacion'].'.'?></td>
			</tr>
	</table>

	<table align="left" border="2" cellspacing="0" class="anexoTabla" style="border-collapse:collapse; border:solid 2px red; margin-bottom:0px;margin-top:-2px">
			<tr>
				<th width="220" colspan="3">PROCEDENTE</th>
				<th width="253" colspan="2">IMPROCEDENTE</th>
				<th width="220" colspan="2">POR DETERMINAR</th>
			</tr>

			<tr>
				<td width="220" colspan="3" style="text-align:center"> <?php echo $c['calificacion']=='Procedente'?'(X)':'';?> </td>
				<td width="253" colspan="2" style="text-align:center"> &nbsp; <?php echo $c['calificacion']=='Improcedente'?'(X)':'';?> </td>
				<td width="220" colspan="2" style="text-align:center"><?php echo $c['calificacion']=='Procedente'?'':($c['calificacion']=='Improcedente'?'':$c['calificacion']);?></td>
			</tr>
	</table>

	<table align="left" border="2" cellspacing="0" class="anexoTabla" style="border-collapse:collapse; border:solid 2px red; margin-bottom:0px;margin-top:-2px">
			<tr>
				<th width="713" colspan="4">PARA CUALQUIER CASO, FUNDAMENTO:</th>
			</tr>
			<tr>
				<td width="713" colspan="4" style="text-align:center"><?=$s['fundamento'].' '?> </td>
			</tr>
			
	</table>
	<table align="left" border="2" cellspacing="0" class="anexoTabla" style="border-collapse:collapse; border:solid 2px red; margin-bottom:0px;margin-top:-2px">
		<tr>
			<th width="717" colspan="4">RESERVA RECOMENDADA</th>
		</tr>
		<tr>
				<th width="168" >SUMA ASEGURADA</th>
				<th width="168" >ESTIMACI&Oacute;N ASEGURADA</th>
				<th width="168" >IMPORTE RECLAMADO</th>
				<th width="168" >RESERVA RECOMENDADA</th>
			</tr>
			<tr>
				<td width="168" style="text-align:center"><?=$s['sumAsegurada']?></td>
				<td width="168" style="text-align:center"><?=$s['estimacion'].' '?></td>
				<td width="168" style="text-align:center"><?=$s['importeReclamado']?></td>
				<td width="168" style="text-align:center"><?=$s['reservaRecomendada']?></td>
			</tr>
	</table>
	<table align="left" border="2" cellspacing="0" class="anexoTabla" style="border-collapse:collapse; border:solid 2px red; margin-bottom:0px;margin-top:-2px">
			<tr>
				<th width="717" colspan="4">OBSERVACIONES</th>
			</tr>
	</table>

<!-- OBSERVACIONES -->

	<?=urldecode($contenido['segundaParte']['observaciones'])?>

</page>