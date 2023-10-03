

    <style>
        /** Define the margins of your page **/
        @page {
            margin: 5mm;
            width: 190mm;
        }

        .header{
            position: fixed;
            top: 0px;
            left: 0px;
            right: 0px;
            height: 50px;

            /** Extra personal styles **/
            line-height: 1.3;
            max-width: 500px;
        }

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

        .footer {
            position: absolute; 
            width: 100%;
            padding: 10px;
            bottom: 0px;
            left: 0; 
            right: 0;
            font-size: small;

            /** Extra personal styles **/
            /* background-color: #03a9f4; */
            color: black;
            text-align: left;
            line-height: 1;
        }
        .anexoTabla {
            width: 100% !important; /* 210mm - 5mm x 2 (margen A4) - 5mm x 2 (margen tabla) */
            margin: 5mm !important;
        }

        #anexoTabla tr th,
        .anexoTabla tr th{
            background: #7de8ff !important;
        }
        .anexoTabla td {
            background: white !important;
        }
        table#anexoTabla {
            width: 100% !important; /* 210mm - 5mm x 2 (margen A4) - 5mm x 2 (margen tabla) */
            margin: 5mm !important;
        }

        #hechosDiv,
        #observacionesDiv{
            /* 210mm - 5mm x 2 (margen A4) - 5mm x 2 (margen tabla) */
            margin: 0px !important;
            position: relative;
            width:100%;background:#fff; border:1px solid #cccccc; padding:5px 10px;
        }

		.hola,
		#anexoTabla1.anexoTabla tbody tr th{
			border:solid red 2px;
			width:205 !important;
			background-color: red !important;
		}
		#anexoTabla1.anexoTabla tbody tr:nth-child(1) th:nth-child(2){
			border:solid red 2px;
			width:330 !important;
			background-color: red !important;
		}
		#anexoTabla1.anexoTabla{
			border:solid red 2px;
			width:330 !important;
			background-color: red !important;
		}
		


    </style>
<?php

$debug=false;
/* (
Array
    [id] => 30
    [timerst] => 1647305650.2798
    [autor] => Lic. Claudia  Fernanda Mena
    [area] => Siniestros
    [informe_preliminar] => %3Cp+style%3D%22margin-left%3A284px%3B+text-align%3Ajustify%22%3E%3Cstrong%3ESINIESTRO%3C%2Fstrong%3E%3A+202103774.%3Cbr+%2F%3E%0A%3Cstrong%3EI.+D.%3C%2Fstrong%3E%3A+101-027-22.%3Cbr+%2F%3E%0A%3Cstrong%3EASEGURADA%3C%2Fstrong%3E%3A+LEONEL+MARIANO%3Cbr+%2F%3E%0A%3Cstrong%3EP%26Oacute%3BLIZA%3C%2Fstrong%3E%3A+.%3Cbr+%2F%3E%0A%3Cstrong%3EREPORTE%3C%2Fstrong%3E%3A+12345.%3Cbr+%2F%3E%0A%3Cstrong%3EINSTANCIA%3C%2Fstrong%3E%3A+Siniestros+.%3Cbr+%2F%3E%0A%3Cstrong%3EASUNTO%3C%2Fstrong%3E%3A+%3Cstrong%3EINFORME+DE+CIERRE+Y+CONCLUSI%26Oacute%3BN+DEL+SINIESTRO.%3C%2Fstrong%3E%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%3Cstrong%3ELic.+Luis+Alberto+Mart%26iacute%3Bnez+Garc%26iacute%3Ba%26nbsp%3B+%26nbsp%3B%2F%26nbsp%3B+Lic.+Mario+Aguilar+Guajardo.%3Cbr+%2F%3E%0ASubgerente+de+Siniestros%3Cbr+%2F%3E%0AGrupo+Mexicano+de+Seguros%2C+S.+A.+de+C.+V.%3C%2Fstrong%3E%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%3Cstrong%3ECon+relaci%26oacute%3Bn+al+n%26uacute%3Bmero+de+reporte+al+rubro+aludido%2C+por+este+conducto+rindo+el+informe+de+cierre+y+conclusi%26oacute%3Bn+de+las+actividades+realizadas+durante+la+atenci%26oacute%3Bn+y+seguimiento+que+se+le+dio+al+mismo+en+los+siguientes+t%26eacute%3Brminos%3A%3C%2Fstrong%3E%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%3Cstrong%3EHECHOS%3A+%3C%2Fstrong%3EEl+siniestro+fue+turnado+a+esta+Firma+Legal%2C+toda+vez+que+el+Representante+Legal+de+la+moral+asegurada%2C+inform%26oacute%3B+que+realizaba+su+reporte%2C+en+virtud+de+la+fractura+distal+de+radio+derecho+que+present%26oacute%3B+la+se%26ntilde%3Bora+Margot+Haiat+Cohen%2C+a+consecuencia+de+la+ca%26iacute%3Bda+que+sufri%26oacute%3B+durante+los+cuidados+brindados+por+la+C.+Nancy+Selena+Funes+Garc%26iacute%3Ba+%28empleada+de+la+asegurada+cuando+ocurrieron+los+hechos+motivo+del+siniestro%29%2C+en+las+instalaciones+de+la+residencia+Belmont+Village+Senior+Living+Santa+Fe%2C+solicitando+el+pago+del+reembolso+de+los+gastos+generados+con+motivo+de+honorarios+m%26eacute%3Bdicos%2C+tratamiento+quir%26uacute%3Brgico%2C+medicamentos+y+hospitalizaci%26oacute%3Bn+para+restablecer+la+salud+de+la+tercero.%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%3Cstrong%3ETR%26Aacute%3BMITE%3A%3C%2Fstrong%3E%3C%2Fp%3E%0A%0A%3Col%3E%0A%09%3Cli%3ESe+atendi%26oacute%3B+reporte+de+siniestro%2C+para+lo+cual+se+estableci%26oacute%3B+pl%26aacute%3Btica+telef%26oacute%3Bnica+con+el+Licenciado+Manuel+Rosemberg+Stillmann%2C+quien+dijo+ser+el+apoderado+legal+de+la+moral+asegurada%2C+a+quien+se+le+proporcionaron+los+datos+y+n%26uacute%3Bmeros+telef%26oacute%3Bnicos+de+esta+Firma+Legal%2C+se+le+requiri%26oacute%3B+diversa+informaci%26oacute%3Bn+para+la+atenci%26oacute%3Bn+del+asunto.%3C%2Fli%3E%0A%09%3Cli%3ESe+remiti%26oacute%3B+al+Analista+de+GMX+Seguros%2C+el+informe+de+primera+atenci%26oacute%3Bn+del+reporte%2C+solicit%26aacute%3Bndose+la+p%26oacute%3Bliza+correspondiente.+Se+envi%26oacute%3B+correo+electr%26oacute%3Bnico+al+Licenciado+Manuel+Rosemberg+Stillmann%2C+quien+dijo+ser+apoderado+legal+de+la+moral+asegurada+requiriendo+la+documentaci%26oacute%3Bn+necesaria+para+determinar+la+procedencia+del+siniestro.%3C%2Fli%3E%0A%09%3Cli%3ESe+realiz%26oacute%3B+an%26aacute%3Blisis+de+la+P%26oacute%3Bliza+de+Seguro%2C+en+sus+condiciones+particulares+y+generales%2C+as%26iacute%3B+como+la+documentaci%26oacute%3Bn+proporcionada+por+el+Licenciado+Manuel+Rosemberg+Stillmann%2C+apoderado+legal+de+la+moral+asegurada.%3C%2Fli%3E%0A%09%3Cli%3ESe+envi%26oacute%3B+informe+preliminar+al+Analista+de+Siniestros+de+Grupo+Mexicano+de+Seguros+S.+A.+de+C.+V.%2C+en+calidad+de+%26ldquo%3BProcedente%26rdquo%3B.%3C%2Fli%3E%0A%09%3Cli%3ESe+solicit%26oacute%3B+autorizaci%26oacute%3Bn+de+pago+a+GMX+Seguros%2C+a+fin+de+proceder+al+reembolso+requerido+y+de+esa+forma+dar+inicio+a+la+elaboraci%26oacute%3Bn+de+los+convenios+finiquitos+correspondientes.%3C%2Fli%3E%0A%09%3Cli%3EEl+Analista+de+GMX+Seguros+autoriz%26oacute%3B+el+pago+solicitado%2C+en+consecuencia%2C+se+elaboraron+y+enviaron+al+Licenciado+Manuel+Rosemberg+Stillmann+los+convenios+finiquito+a+suscribir+entre+la+tercero+y+Paz+Mental+S.A.P.I.+de+C.V.%2C+as%26iacute%3B+como+el+diverso+a+suscribir+entre+%26eacute%3Bsta+%26uacute%3Bltima+y+GMX+Seguros.%3C%2Fli%3E%0A%09%3Cli%3EUna+vez+que+se+obtuvo+la+firma+de+los+convenios+finiquitos+y+la+documentaci%26oacute%3Bn+pertinente%2C+se+solicit%26oacute%3B+a+GMX+Seguros+la+liberaci%26oacute%3Bn+del+pago+a+favor+de+la+tercero+Margot+Haiat+Cohen%2C+enviando+para+tal+efecto+los+instrumentos+jur%26iacute%3Bdicos+suscritos+entre+las+partes%2C+as%26iacute%3B+como+la+documentaci%26oacute%3Bn+soporte+de+pago.%3C%2Fli%3E%0A%09%3Cli%3EEl+analista+de+siniestros+inform%26oacute%3B+y+remiti%26oacute%3B+el+comprobante+bancario+en+el+cual+se+reflejaba+la+liberaci%26oacute%3Bn+del+monto+solicitado+en+la+cuenta+bancaria+que+se+proporcion%26oacute%3B+para+tal+cometido.%3C%2Fli%3E%0A%3C%2Fol%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%3Cstrong%3ERESOLUCIONES%3A%3C%2Fstrong%3E%3C%2Fp%3E%0A%0A%3Cp%3ENinguna%2C+en+virtud+de+que+se+llev%26oacute%3B+a+cabo+convenio+finiquito+con+el+asegurado.%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%3Cstrong%3E%26Uacute%3Bltima+actuaci%26oacute%3Bn%3A%3C%2Fstrong%3E+Se+procede+a+la+conclusi%26oacute%3Bn+del+siniestro+al+haber+suscrito+los+convenios+finiquitos+correspondientes%2C+una+vez+efectuado+el+reembolso+solicitado+por+la+moral+asegurada+y+al+corroborar+que+el+monto+requerido+se+reflejaba+en+la+cuenta+bancaria+de+la+tercero.+Por+lo+que+no+existe+actividad+pendiente+que+realizar+por+parte+de+esta+Firma+Legal.%3C%2Fp%3E%0A%0A%3Cp%3EAdjunto+al+presente+remito+a+Usted+el+expediente+integrado+por+esta+firma+de+abogados+en+la+atenci%26oacute%3Bn+y+seguimiento+del+siniestro+que+nos+ocupa%3B+en+el+que+entre+otras+cosas+encontrara+el+original+en+4+tantos+del+convenio+finiquito+celebrado+entre+la+tercero+y+la+moral+asegurada%2C+as%26iacute%3B+como+el+suscrito+entre+%26eacute%3Bsta+%26uacute%3Bltima+y+GMX+Seguros%3B+sin+omitir+mencionar+que+no+conservaremos+copia+del+mismo.%3C%2Fp%3E%0A%0A%3Cp%3ESin+otro+particular%2C+reitero+a+Usted+las+seguridades+de+mi+atenta+y+distinguida+consideraci%26oacute%3Bn.%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp+style%3D%22text-align%3Acenter%22%3E%3Cstrong%3EATENTAMENTE%3C%2Fstrong%3E%3C%2Fp%3E%0A%0A%3Cp+style%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp+style%3D%22text-align%3Acenter%22%3E%3Cstrong%3ELIC.+JES%26Uacute%3BS+CORT%26Eacute%3BS+MENA%3Cbr+%2F%3E%0ADIRECTOR+GENERAL%3Cbr+%2F%3E%0ACORT%26Eacute%3BS+MENA+ABOGADOS+S.+C.%3C%2Fstrong%3E%3C%2Fp%3E%0A%0A%3Ctable+align%3D%22center%22+border%3D%220%22+cellpadding%3D%221%22+cellspacing%3D%220%22+id%3D%22tableAtt%22%3E%0A%09%3Ctbody%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Ctd+style%3D%22text-align%3Acenter%22%3E%3Cstrong%3EELABOR%26Oacute%3B%3C%2Fstrong%3E%3C%2Ftd%3E%0A%09%09%09%3Ctd%3E%26nbsp%3B%3C%2Ftd%3E%0A%09%09%09%3Ctd+style%3D%22text-align%3Acenter%22%3E%3Cstrong%3ESUPERVIS%26Oacute%3B%3C%2Fstrong%3E%3C%2Ftd%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Ctd+style%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Ftd%3E%0A%09%09%09%3Ctd%3E%26nbsp%3B%3C%2Ftd%3E%0A%09%09%09%3Ctd+style%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Ftd%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Ctd+style%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Ftd%3E%0A%09%09%09%3Ctd%3E%26nbsp%3B%3C%2Ftd%3E%0A%09%09%09%3Ctd+style%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Ftd%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Ctd+style%3D%22text-align%3Acenter%22%3E%3Cstrong%3ELIC.+CLAUDIA+FERNANDA+MENA+ROMERO+%3C%2Fstrong%3E%3C%2Ftd%3E%0A%09%09%09%3Ctd%3E%26nbsp%3B+%26nbsp%3B+%26nbsp%3B+%26nbsp%3B%3C%2Ftd%3E%0A%09%09%09%3Ctd+style%3D%22text-align%3Acenter%22%3E%3Cstrong%3ELIC.+YESSICA+YORDANA+ROMERO+ADUNAS%3C%2Fstrong%3E%3C%2Ftd%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Ctd+style%3D%22text-align%3Acenter%22%3E%3Cstrong%3EABOGADA+DEL+%26Aacute%3BREA+SINIESTROS%3C%2Fstrong%3E%3C%2Ftd%3E%0A%09%09%09%3Ctd%3E%26nbsp%3B%3C%2Ftd%3E%0A%09%09%09%3Ctd+style%3D%22text-align%3Acenter%22%3E%3Cstrong%3ETITULAR+DEL+%26Aacute%3BREA+PENAL%3C%2Fstrong%3E%3C%2Ftd%3E%0A%09%09%3C%2Ftr%3E%0A%09%09%3Ctr%3E%0A%09%09%09%3Ctd+style%3D%22text-align%3Acenter%22%3E%3Cstrong%3ECORT%26Eacute%3BS+MENA+ABOGADOS+S.+C%3C%2Fstrong%3E%3C%2Ftd%3E%0A%09%09%09%3Ctd%3E%26nbsp%3B%3C%2Ftd%3E%0A%09%09%09%3Ctd+style%3D%22text-align%3Acenter%22%3E%3Cstrong%3ECORT%26Eacute%3BS+MENA+ABOGADOS+S.+C.%3C%2Fstrong%3E%3C%2Ftd%3E%0A%09%09%3C%2Ftr%3E%0A%09%3C%2Ftbody%3E%0A%3C%2Ftable%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A
    [folio] => 101-027-22
    [fecha_creacion] => 2022-04-26 12:37:59
    [asegurado] => LEONEL MARIANO dfghdfgdfg gfhjgjghkgh

	urldecode

	width='205'
	width='330'
	width='205'


) */


$contenido['informe_preliminar']="texto<tabla><th>texto...";

// $tabla= str_replace('<tabla>',$contenido['informe_preliminar']);
// $celda= str_replace('<td>',$tabla[1]);

// $contenido['informe_preliminar']=0;



$contenido['informe_preliminar']="
<p>Fecha de Asignaci&oacute;n:2022-03-14<br />
<strong>Lic. Luis Alberto Mart&iacute;nez Garc&iacute;a &nbsp; &nbsp; &nbsp; &nbsp;/ &nbsp;&nbsp;&nbsp;&nbsp; Lic. Mario Aguilar Guajardo.</strong></p>
DEMOSTRACION
<p><strong>ASUNTO: Informe Preliminar.<br />
REPORTE: 2022-01-25</strong><br />
Creado el: centro<br />
I.D.: LEONEL MARIANO<br />
Asegurado: 12345</p>

<p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Adjunto al presente env&iacute;o el informe preliminar correspondiente al asegurado <strong>12345</strong>, mismo que se realiz&oacute; con base a la informaci&oacute;n y documentaci&oacute;n suministrada por este &uacute;ltimo, el cual en opini&oacute;n de esta firma legal es <strong> 101-027-22 </strong>, de que se le proporcione la asistencia legal requerida, salvo instrucciones en contrario, por lo que someto a su consideraci&oacute;n la procedencia del mismo, solicit&aacute;ndole se sirva proporcionando el n&uacute;mero de siniestro que le corresponda al mismo, para los efectos y tr&aacute;mites conducentes.</p>

<p>Agradeciendo su atenci&oacute;n, me reitero a sus &oacute;rdenes para cualquier duda o aclaraci&oacute;n.</p>

<p><strong>ATENTAMENTE:<br />
Lic. Lic. Mar&iacute;a Teresa Flores Cer&oacute;n. Lic. V&iacute;ctor Hugo Alarc&oacute;n L&oacute;pez</strong></p>

<p>Email:</p>

<p>Anexos:</p>

<p>&nbsp;</p>

<p>&lt; --- &gt;</p>

<table border='1' cellpadding='0' cellspacing='0' class='anexoTabla anexoTabla1' id='anexoTabla1' style='background:#ffffff !important; margin-right: 00px;'  >
    <tr>
        <th width='250' class='hola' colspan='2'>&nbsp;&nbsp;NUMERO DE P&Oacute;LIZA&nbsp;&nbsp;</th>
        <th width='250' colspan='2'>NOMBRE DEL CONTRATANTE/ASEGURADO&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
        <th width='250' >FECHA OCURRIDO&nbsp;&nbsp;</th>
    </tr>
</table>




";

if($debug==true){
	core::preprint($contenido);exit();
}



    if(isset( explode('<p>&lt; --- &gt;</p>', $contenido['informe_preliminar'] )[1]   )  ==true ){
        $content = explode('<p>&lt; --- &gt;</p>', $contenido['informe_preliminar']);
		$pag=1;
        foreach ($content as $p) {
			if($pag==1) {$pag=2;continue;};
            ?>
            <page>
                <div class="header">
                    <table col=1>
                        <tr>
                                <td><br>
                                    <img src="./formato/logoCMA__white.jpg" style="margin-top:15px;padding-bottom:0px;margin-bottom:-18px;width: 150px; height: auto; position: absolute;">
                                </td>
                                <td>
                                <p style="color:white">..</p>
                                </td>
                                <td>
                                
                                </td>

                                <td style="text-align:right !important;">

                                </td>
                        </tr>
                    </table>
                    <div class="tablaTxt">
                        <table class="tablaTxt" style="width:100%;border:solid 1px black;" border=0 cellspacing=0>
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
                                    <td border=1 style="background-color: #dfbaa0;">DEMO
                                    </td>
                                <td border=1><?=ucwords($contenido['asegurado'])?>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <?php
                    echo "<div class='content' style='position:relative;width:100% !important;border:solid green 1px;width:750px'>";
                    echo urldecode($p);
                    echo "</div>";
                    ?>
                </div >
                <div class="footer">
                    Av. Insurgentes Sur Int. 802 y 803, Colonia Florida, Álvaro Obregón, C.P. 0130 CDMX. <br>
                    Teléfonos 55434786 con 5 líneas Fax 1107-6372. &copy; <?php echo date("Y");?> CMA 
                </div class="footer">

                <!-- Wrap the content of your PDF inside a div class="main" tag -->
            </page>
            
            <?php
        }
    }else{
        echo urldecode($contenido['informe_preliminar']);
        ?>
        <page>
            <!-- Define header and footer blocks before your content -->
            <div class="header">
                <table col=1>
                    <tr>
                            <td><br>
                                <img src="./formato/logoCMA__white.jpg" style="margin-top:15px;padding-bottom:0px;margin-bottom:-18px;width: 150px; height: auto; position: absolute;">
                            </td>
                            <td>
                            <p style="color:white">..</p>
                            </td>
                            <td>
                            
                            </td>

                            <td style="text-align:right !important;">

                            </td>
                    </tr>
                </table>
                <div class="tablaTxt">
                    <table class="tablaTxt" style="width:100%;border:solid 1px black;" border=0 cellspacing=0>
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
                    </table>
                </div>
            
                <!-- 
                <p>&lt; --- &gt;</p>
                -->
            <?php echo urldecode($contenido['informe_preliminar']); ?>
            </div >
            <div class="footer">
                Av. Insurgentes Sur Int. 802 y 803, Colonia Florida, Álvaro Obregón, C.P. 0130 CDMX. <br>
                Teléfonos 55434786 con 5 líneas Fax 1107-6372. &copy; <?php echo date("Y");?> CMA 
            </div class="footer">
            <!-- Wrap the content of your PDF inside a div class="main" tag -->
        </page>
        <?php 
    }
?>