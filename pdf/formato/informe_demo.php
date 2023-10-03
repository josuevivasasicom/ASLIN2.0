<style>
	@page {
            margin: 5mm;
            width: 190mm;
    }

	*,
	p{
	text-align:justify !important;
	}
	.page-break{
		page-break-before:always;
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
		word-wrap: break-word;
		word-wrap: break-word !important;
	}


</style>

<?php
$contenido=array(
	"id" => 31,
	"timerst" => "1644432018.9025",
	"autor" => "Lic. María Teresa Flores",
	"area" => "Siniestros",
	"preliminar" => "%3Ctable+align%3D%22center%22+border%3D%221%22+cellspacing%3D%220%22+class%3D%22anexoTabla%22+style%3D%22border-collapse%3Acollapse%3B+border%3Asolid+2px+red%3B+width%3A100%25%22%3E%0A%09%3Cthead%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Ctd+colspan%3D%225%22+style%3D%22width%3A100%25%22%3E%26nbsp%3B%3C%2Ftd%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Cth+colspan%3D%222%22+style%3D%22text-align%3Acenter%22%3EN%26Uacute%3BMERO+DE+P%26Oacute%3BLIZA%3C%2Fth%3E%0A%09%09%09%3Cth+colspan%3D%222%22+style%3D%22text-align%3Acenter%22%3ENOMBRE+DEL+CONTRATANTE%2FASEGURADO%3C%2Fth%3E%0A%09%09%09%3Cth+style%3D%22text-align%3Acenter%22%3EFECHA+OCURRIDO%3C%2Fth%3E%0A%09%09%3C%2Ftr%3E%0A%09%3C%2Fthead%3E%0A%09%3Ctbody%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Ctd+colspan%3D%222%22%3EMPCOM+3210+039+%2F%3C%2Ftd%3E%0A%09%09%09%3Ctd+colspan%3D%222%22+style%3D%22white-space%3Anowrap%22%3ETipos+De+Archivos+Er+Paterno2%3C%2Ftd%3E%0A%09%09%09%3Ctd%3E%26nbsp%3B%3C%2Ftd%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Cth+colspan%3D%225%22%3ENOMBRE+DEL+RECLAMANTE+Y%2FO+TERCERO%3C%2Fth%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Ctd+colspan%3D%225%22%3ENo+aplica%3C%2Ftd%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Cth+colspan%3D%222%22%3ECAUSA+PROBABLE%3C%2Fth%3E%0A%09%09%09%3Cth+colspan%3D%222%22%3ELUGAR+OCURRIDO%3C%2Fth%3E%0A%09%09%09%3Cth%3EESTADO%2FCIUDAD%2FPOBLACI%26Oacute%3BN%3C%2Fth%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Ctd+colspan%3D%222%22%3ENo+aplica%3C%2Ftd%3E%0A%09%09%09%3Ctd+colspan%3D%222%22%3EBaja+California+Sur%3C%2Ftd%3E%0A%09%09%09%3Ctd%3ELoreto%3C%2Ftd%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Cth+colspan%3D%222%22%3EAGENTE%3C%2Fth%3E%0A%09%09%09%3Ctd+colspan%3D%223%22+style%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Ftd%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Cth+colspan%3D%222%22%3EPRACTICA%3C%2Fth%3E%0A%09%09%09%3Ctd+colspan%3D%223%22+style%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Ftd%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Cth+colspan%3D%222%22%3EVIGENCIA%3C%2Fth%3E%0A%09%09%09%3Cth+rowspan%3D%222%22%3EFECHA+Y+HORA%3Cbr+%2F%3E%0A%09%09%09DE+REPORTE%3C%2Fth%3E%0A%09%09%09%3Cth+rowspan%3D%222%22%3EFECHA+Y+HORA%3Cbr+%2F%3E%0A%09%09%09DE+ASIGNACI%26Oacute%3BN%3C%2Fth%3E%0A%09%09%09%3Cth+colspan%3D%221%22+rowspan%3D%222%22%3EFECHA+Y+HORA%3Cbr+%2F%3E%0A%09%09%09DE+1A+ATENCI%26Oacute%3BN%3C%2Fth%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Cth%3EINICIO%3C%2Fth%3E%0A%09%09%09%3Cth%3EFIN%3C%2Fth%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Ctd+rowspan%3D%222%22%3E2022-07-04%3C%2Ftd%3E%0A%09%09%09%3Ctd+rowspan%3D%222%22%3E2022-07-04%3C%2Ftd%3E%0A%09%09%09%3Ctd%3E2022-07-04%3C%2Ftd%3E%0A%09%09%09%3Ctd%3E2022-07-04%3C%2Ftd%3E%0A%09%09%09%3Ctd%3E2022-07-04%3C%2Ftd%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Ctd%3E15%3A10%3A24%3C%2Ftd%3E%0A%09%09%09%3Ctd%3E15%3A10%3A24%3C%2Ftd%3E%0A%09%09%09%3Ctd%3E15%3A11%3A03%3C%2Ftd%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Cth+colspan%3D%225%22%3EAUTORIDAD%3A+OIC+%2F+JUICIO+CIVIL+%2F+JUICIO+PENAL%3Cbr+%2F%3E%0A%09%09%09RADICADO+EN%3A%3C%2Fth%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Ctd+colspan%3D%225%22%3ECOMISI%26Oacute%3BN+NACIONAL+DE+DERECHOS+HUMANOS.%3C%2Ftd%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Cth+colspan%3D%223%22%3ENO+DE+EXPEDIENTE%3A%3C%2Fth%3E%0A%09%09%09%3Ctd+colspan%3D%222%22+style%3D%22text-align%3Acenter%22%3E%7BDATO%7D%3C%2Ftd%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Cth+colspan%3D%223%22%3EETAPA+DE+LA+INDAGATORIA+Y%2FO+JUICIO%3C%2Fth%3E%0A%09%09%09%3Ctd+colspan%3D%222%22+style%3D%22text-align%3Acenter%22%3E%7BDATO%7D%3C%2Ftd%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Cth+colspan%3D%225%22%3EBREVE+DESCRIPCI%26Oacute%3BN+DE+LOS+HECHOS%26nbsp%3B%3C%2Fth%3E%0A%09%09%3C%2Ftr%3E%0A%09%3C%2Ftbody%3E%0A%3C%2Ftable%3E%0A%0A%3Cp+style%3D%22text-align%3Ajustify%22%3EDescripci%26oacute%3Bn%3A+%26nbsp%3B%3C%2Fp%3E%0A%0A%3Ctable+align%3D%22center%22+border%3D%221%22+cellspacing%3D%220%22+class%3D%22anexoTabla%22+style%3D%22border-collapse%3Acollapse%3B+border%3Asolid+1px+black%3B+width%3A100%25%22%3E%0A%09%3Cthead%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Ctd+colspan%3D%225%22+style%3D%22text-align%3Acenter%3B+white-space%3Anowrap%22%3E%26nbsp%3B%3C%2Ftd%3E%0A%09%09%3C%2Ftr%3E%0A%09%3C%2Fthead%3E%0A%09%3Ctbody%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Cth+colspan%3D%222%22%3ECAUSA+PR%26Oacute%3BXIMA+DEL%3C%2Fth%3E%0A%09%09%09%3Ctd+colspan%3D%223%22+rowspan%3D%221%22+style%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Ftd%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Cth+colspan%3D%225%22%3ERECLAMACI%26Oacute%3BN%3C%2Fth%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Cth+colspan%3D%222%22%3EPROCEDENTE%3C%2Fth%3E%0A%09%09%09%3Cth+colspan%3D%222%22%3EIMPROCEDENTE%3C%2Fth%3E%0A%09%09%09%3Cth%3EPOR+DETERMINAR%3C%2Fth%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Ctd+colspan%3D%222%22+style%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Ftd%3E%0A%09%09%09%3Ctd+colspan%3D%222%22+style%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Ftd%3E%0A%09%09%09%3Ctd+style%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Ftd%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Cth+colspan%3D%225%22%3EPARA+CUALQUIER+CASO%2C+FUNDAMENTO%3A%3C%2Fth%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Ctd+colspan%3D%225%22+style%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Ftd%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Cth+colspan%3D%225%22%3ERESERVA+RECOMENDADA%3C%2Fth%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Cth+colspan%3D%222%22%3ESUMA+ASEGURADA%3C%2Fth%3E%0A%09%09%09%3Cth%3EESTIMACI%26Oacute%3BN+ASEGURADA%3C%2Fth%3E%0A%09%09%09%3Cth%3EIMPORTE+RECLAMADO%3C%2Fth%3E%0A%09%09%09%3Cth%3ERESERVA+RECOMENDADA%3C%2Fth%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Ctd+colspan%3D%222%22+style%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Ftd%3E%0A%09%09%09%3Ctd+style%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Ftd%3E%0A%09%09%09%3Ctd+style%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Ftd%3E%0A%09%09%09%3Ctd+style%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Ftd%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Cth+colspan%3D%225%22%3EOBSERVACIONES%3C%2Fth%3E%0A%09%09%3C%2Ftr%3E%0A%09%3C%2Ftbody%3E%0A%3C%2Ftable%3E%0A%0A%3Cp%3EObservaciones%3A%3C%2Fp%3E%0A",
	"folio" => "104-018-22",
	"fecha_creacion" => "2022-04-28 10:15:32",
	"asegurado" => "erick erick erick",
	
)
?>

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
					<img src="https://claimsmanager.online/pdf/formato/logoCMA__white.jpg" style="margin-top:15px;padding-bottom:0px;margin-bottom:-18px;width: 150px; height: auto; position: absolute;">
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
                        <td border=1 style="background-color: #dfbaa0;">Creado el :
                        </td>
                        <td border=1 width="300"> <?=$contenido['fecha_creacion']?>
                        </td>
                    </tr>
                    <tr>
                            <td border=1 style="background-color: #dfbaa0;">Autor:
                            </td>
                        <td border=1><?=$contenido['autor']?>
                        </td>
                    </tr>
                    <tr>
                            <td border=1 style="background-color: #dfbaa0;">ID:
                            </td>
                        <td border=1><?=$contenido['folio']?>
                        </td>
                    </tr>
                    <tr>
                            <td border=1 style="background-color: #dfbaa0;">Asegurado
                            </td>
                        <td border=1><?=ucwords($contenido['asegurado'])?>
                        </td>
                    </tr>
					<tr>
                            <td border=1 style="background-color: #dfbaa0;">Área
                            </td>
                        <td border=1><?=ucwords($contenido['area'])?>
                        </td>
                    </tr>
                </table>
            </div>
		
	</page_header>
	<page_footer class="footer" >
        <table style="width: 100%; border: solid 0px gray;">
            <tr>
                <td style="text-align: left;  color:gray;  width: 80%">Cracovia No. 72, Int. APO-02, Col. San Ángel, Alcaldía Álvaro Obregón, C.P. O1000, CDMX</td>
                <td style="text-align: right; color:gray;   width: 20%"><b>CMA</b>   página: [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
	</page_footer>
	
<p>Fecha de Asignaci&oacute;n:01 jul 2022<br />
<strong>Lic. Luis Alberto Mart&iacute;nez Garc&iacute;a &nbsp; &nbsp; &nbsp; &nbsp;/ &nbsp;&nbsp;&nbsp;&nbsp; Lic. Mario Aguilar Guajardo.</strong><br />
<strong>ASUNTO: Informe Preliminar.<br />
REPORTE: GMXC220006691</strong><br />
Creado el: 01 jul 2022<br />
I.D.: 102-077-22<br />
Asegurado: HIRAM GUILLERMO JAIME LEON.</p>

<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;</p>

<p>&nbsp; Adjunto al presente env&iacute;o el informe preliminar correspondiente al asegurado&nbsp; &nbsp;<strong>HIRAM GUILLERMO JAIME LE&Oacute;N&nbsp;</strong>, mismo que se realiz&oacute; con base a la informaci&oacute;n y documentaci&oacute;n suministrada por este &uacute;ltimo, el cual en opini&oacute;n de esta firma legal es <strong>PREVENTIVO</strong>&nbsp;de que se le proporcione la asistencia legal requerida<strong>, </strong>salvo instrucciones en contrario<strong>,&nbsp;</strong>toda vez que al d&iacute;a de la fecha el asegurado no ha sido emplazdo a comparecer dentro de procedimiento alguno ante autoridad administrativa y/o judicial, sin embargo existen altas probabilidades de que se posteriormente sea citado a comparecer ante alguna de aquellas autoridades.&nbsp;Por lo anterior, somete a su consideraci&oacute;n la procedencia del mismo, solicit&aacute;ndole se sirva proporcionando el n&uacute;mero de siniestro que le corresponda al mismo, para los efectos y tr&aacute;mites conducentes.</p>

<p>Agradeciendo su atenci&oacute;n, me reitero a sus &oacute;rdenes para cualquier duda o aclaraci&oacute;n.</p>

<p><strong>ATENTAMENTE:<br />
Lic. Jos&eacute; Gerardo Ruiz L&oacute;pez.</strong></p>

<p>Email:</p>

<p>Anexos:</p>

<div style="page-break-after:always"><span style="display:none">&nbsp;</span></div>

<table align="center" border="2" cellspacing="0" class="anexoTabla" style="border-collapse:collapse;margin-bottom:0px; border-bottom:0px; border:solid 0px red;">
		<tr>
			<th width="225" colspan="2" style="text-align:center">N&Uacute;MERO DE P&Oacute;LIZA</th>
			<th width="248" colspan="2" style="text-align:center">NOMBRE DEL CONTRATANTE/ASEGURADO</th>
			<th width="200" colspan="2" style="text-align:center">FECHA OCURRIDO</th>
		</tr>
		<tr>
			<td width="225" colspan="2">1-70-7000123-1-0 /</td>
			<td width="248" colspan="2">HIRAM GUILLERMO JAIME LE&Oacute;N</td>
			<td width="200" colspan="2" >01/07/2021</td>
		</tr>
		<tr>
			<th colspan="6">NOMBRE DEL RECLAMANTE Y/O TERCERO</th>
		</tr>
		<tr>
			<td colspan="6" style="text-align:center">No aplica</td>
		</tr>

		<tr>
			<th colspan="2">CAUSA PROBABLE</th>
			<th colspan="2">LUGAR OCURRIDO</th>
			<th colspan="2">ESTADO/CIUDAD/POBLACI&Oacute;N</th>
		</tr>
		<tr>
			<td width="225" colspan="2">Responsabildiad Administrativa</td>
			<td width="248" colspan="2">Corporaci&oacute;n Mexicana de Investigaci&oacute;n en Materiales S.A. de C.V. (COMIMSA)</td>
			<td width="200" colspan="2" >Saltillo, Coahuila</td>
		</tr>
</table>

<table align="center" border="2" cellspacing="0" class="anexoTabla" style="border-collapse:collapse; border:solid 2px red; border-top:0px;margin-top:0px;margin-bottom:0px;">
		<tr>
			<th width="186" colspan="1">AGENTE</th>
			<td width="500" colspan="4" style="text-align:center">1840 - Vergara Monroy Francisco Javier 1840 - Vergara Monroy Francisco Javier 1840 - Vergara Monroy Francisco Javier 1840 - Vergara Monroy Francisco Javier</td>
		</tr>
		<tr>
			<th width="186" colspan="1">PRACTICA</th>
			<td width="500" colspan="4" style="text-align:center">Intitucional</td>
		</tr>
</table>

<table align="center" border="2" cellspacing="0" class="anexoTabla" style="border-collapse:collapse; border:solid 2px red; border-top:0px;margin-top:0px ;margin-bottom:0px;">
	<tr>
		<th width="180" colspan="2">VIGENCIA</th>
		<th width="185" rowspan="2">FECHA Y HORA<br />
		DE REPORTE</th>
		<th width="145" rowspan="2">FECHA Y HORA<br />
		DE ASIGNACI&Oacute;N</th>
		<th width="142" colspan="1" rowspan="2">FECHA Y HORA<br />
		DE 1A ATENCI&Oacute;N</th>
	</tr>
	<tr>
		<th>INICIO</th>
		<th>FIN</th>
	</tr>
	<tr>
		<td width="90" rowspan="2">2022-12-31</td>
		<td width="90" rowspan="2">2022-12-31</td>
		<td width="185">2022-07-01</td>
		<td width="145">2022-07-01</td>
		<td width="142">2022-07-01</td>
	</tr>
	<tr>
		<td>13:01:00</td>
		<td>00:00:00</td>
		<td>13:07:00</td>
	</tr>
</table>

<table align="center" border="2" cellspacing="0" class="anexoTabla" style="border-collapse:collapse; border:solid 0px red;margin-bottom:0px; margin-top:0px">
		<tr>
			<th width="692" colspan="6">AUTORIDAD: OIC / JUICIO CIVIL / JUICIO PENAL<br />
			RADICADO EN:</th>
		</tr>
		<tr>
			<td width="692" colspan="6">&Aacute;rea de Quejas del &Oacute;rgano Interno de Control en COMIMSA</td>
		</tr>
</table>

<table align="center" border="2" cellspacing="0" class="anexoTabla" style="border-collapse:collapse; border:solid 2px red; margin-bottom:0px;margin-top:0px">
	<tr>
		<th width="400" colspan="3">NO DE EXPEDIENTE:</th>
		<td width="281" colspan="2" style="text-align:center">2022/COMIMSA/DE19</td>
	</tr>
	<tr>
		<th width="400" colspan="3">ETAPA DE LA INDAGATORIA Y/O JUICIO</th>
		<td width="281" colspan="2" style="text-align:center">No aplica</td>
	</tr>
	<tr>
		<th width="681" colspan="5">BREVE DESCRIPCI&Oacute;N DE LOS HECHOS&nbsp;</th>
	</tr>
</table>

			<p style="text-align:left">Descripci&oacute;n: &nbsp;</p>

			<p style="text-align:justify">El asegurado realiz&oacute; su reporte ante la Compa&ntilde;&iacute;a de Seguros ya que, recibi&oacute; por parte del &Aacute;rea de Quejas del &Oacute;rgano Interno de Control en COMIMSA, requerimiento para que en el t&eacute;rmino de 10 d&iacute;as proporcione diversa documentaci&oacute;n derivada de la investigaci&oacute;n que practica dicha &aacute;rea de la contralor&iacute;a, por hechos que podr&iacute;an constituir presuntas irregularidades administrativas cometidas por personal adscrito a Corporaci&oacute;n Mexicana de Investigaci&oacute;n en Materiales S.A. de C.V. (COMIMSA), entre ellos el C. Hiram Guillermo Jaime Le&oacute;n.</p>

			<p style="text-align:left">Si bien es cierto que, el asegurado al d&iacute;a de la fecha no ha sido emplazado a comparecer dentro de alg&uacute;n procedimiento de responsabilidades administrativas, existen probabilidades muy altas de que posteriormente sea citado a comparecer ante autoridades administrativas.</p>
			


<table border="1" cellpadding="0" cellspacing="0" class="anexoTabla" id="anexoTabla" style="background:#ffffff !important; width:100%;margin-bottom:0px;margin-top:0px">
		
		<tr>
			<th width="180" colspan="2">CAUSA PR&Oacute;XIMA DEL</th>
			<td width="510" colspan="3" rowspan="1" style="text-align:center">No aplica </td>
		</tr>

		<tr>
			<th colspan="5" colspan>RECLAMACI&Oacute;N</th>
		</tr>
</table>

<table align="center" border="2" cellspacing="0" class="anexoTabla" style="border-collapse:collapse; border:solid 2px red; margin-bottom:0px;margin-top:0px">
		<tr>
			<th width="220" colspan="3">PROCEDENTE</th>
			<th width="233" colspan="2">IMPROCEDENTE</th>
			<th width="220" colspan="2">POR DETERMINAR</th>
		</tr>

		<tr>
			<td width="220" colspan="3" style="text-align:center">&nbsp;</td>
			<td width="233" colspan="2" style="text-align:center">&nbsp;</td>
			<td width="220" colspan="2" style="text-align:center">PREVENTIVO</td>
		</tr>
</table>

<table align="center" border="2" cellspacing="0" class="anexoTabla" style="border-collapse:collapse; border:solid 2px red; margin-bottom:0px;margin-top:0px">
		<tr>
			<th width="688" colspan="4">PARA CUALQUIER CASO, FUNDAMENTO:</th>
		</tr>
		<tr>
			<td width="688" colspan="4" style="text-align:center">LeyGeneral de Responsabilidades Administrativas.</td>
		</tr>
		<tr>
			<th width="688" colspan="4">RESERVA RECOMENDADA</th>
		</tr>
		<tr>
			<th width="165" >SUMA ASEGURADA</th>
			<th width="165" >ESTIMACI&Oacute;N ASEGURADA</th>
			<th width="165" >IMPORTE RECLAMADO</th>
			<th width="165" >RESERVA RECOMENDADA</th>
		</tr>
		<tr>
			<td width="165" style="text-align:center">$3&acute;000,000.00 M.N.</td>
			<td width="165" style="text-align:center">&nbsp;</td>
			<td width="165" style="text-align:center">&nbsp;</td>
			<td width="165" style="text-align:center">$50,000.00 M.N.</td>
		</tr>
		<tr>
			<th colspan="4">OBSERVACIONES</th>
		</tr>
</table>

<p>Observaciones:</p>

<p>La p&oacute;liza de seguro n&uacute;mero 01-070-07000123-00000-09, cuenta con las siguientes caracter&iacute;sticas:</p>

<p>- Vigencia: 31 de diciembre de 2021 al 31 de diciembre de 2022.</p>

<p>- Fecha convencional: 01 de enero de 2006.</p>

<p>- Suma Asegurada: $3&acute;000,000.00 M.N.</p>

<p>- Deducibles:</p>

<ul>
	<li>10% sobre toda y cada reclamaci&oacute;n con m&iacute;nimo de $20,000,.00 M.N. para la reparaci&oacute;n del da&ntilde;o&nbsp; &nbsp;o indemnizaci&oacute;n a cargo del asegurado.</li>
	<li>Defensa legal sin deducible.</li>
</ul>

<p>&nbsp; Las responsabilidades de este seguro son:</p>

<ul>
	<li>&nbsp; Responsabilidad administrativa.</li>
	<li>&nbsp; Responsabilidad civil.</li>
	<li>&nbsp; Responsabilidad penal.</li>
	<li>&nbsp; Responsabilidad pol&iacute;tica.</li>
</ul>

<p>El asegurado no ha sido notificado de procedimiento disciplinario instruido en su contra, sin embargo existen altas probabilidades de que sea llamada a procedimiento de responsabilidades administrativa posteriormente, raz&oacute;n por la cual en opini&oacute;n de esta Firma Legal el presente reporte se considera <strong>PREVENTIVO</strong>; en ese sentido se remite el presente para todos los efectos administrativos a que haya lugar.</p>

<p>Horas: para bit&aacute;cora Guardar Salir Formatting applied</p>

</page>