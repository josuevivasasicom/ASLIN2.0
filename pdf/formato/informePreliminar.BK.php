<style>
	*,
	p{
	text-align:justify;
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
    <?php
	echo urldecode($contenido['informe_preliminar']);
    ?>
</page>