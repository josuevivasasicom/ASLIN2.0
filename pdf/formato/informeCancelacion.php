<style>
.headerboot{
    position:absolute;
    display: block;
    top:10px;
    left: 33px;
    margin-top: -25mm;
    width: 150mm;
    border:#337722 solid 3px;
    text-align: left;
    align:left;
}

.headerboot1{
    position:absolute;
    display: block;
    /* top:10px; */
    /* right: 0mm; */
    margin-top: -29mm;
    right: 30mm;
    width: 260mm;
    border:greenyellow solid 3px;
}
.headerboot1 td{
    align:left;
    width: 90%;
    white-space: nowrap;
}
.headerboot1 th{
    text-align: right;
    align:left;
    width: 30%;
}

p{
    text-align:justify;
}
</style>

<page  backtop="35mm" backbottom="10mm" backleft="14mm" backright="14mm">
    <page_header>
		<table style="width: 100%; border: solid 1px white;">
			<tr>
				<td style="text-align: left;    width: 33%"></td>
				<td style="text-align: center;    width: 34%"></td>
				<td style="text-align: right;    color:gray; width: 33%"><small> página:[[page_cu]]/[[page_nb]]</small> </td>
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
			
	</page_header>
	<page_footer>
		<!-- <span style="font-size: 20px; font-weight: bold">hola mundo asicom</span><br> -->
		<table style="width: 100%; border: solid 0px gray;">
			<tr>
				<td style="text-align: left;  color:gray;  width: 80%">Cracovia No. 72, Int. APO-02, Col. San Ángel, Alcaldía Álvaro Obregón, C.P. O1000, CDMX</td>
				<td style="text-align: right; color:gray;   width: 20%"> página: [[page_cu]]/[[page_nb]]</td>
			</tr>
		</table>
	</page_footer>
    <br>
    <br>
	<?php

		$pdfdoc = str_replace("%3Cstrong%3ES%2FN%3C%2Fstrong%3E", "%26nbsp%3B%26nbsp%3B%26nbsp%3B%26nbsp%3B%3Cstrong%3ES%2FN%3C%2Fstrong%3E", $contenido['informe_cancelacion']);
		$pdfdoc = str_replace("%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A","", $pdfdoc);
		$pdfdoc = str_replace("%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp+style%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A","", $pdfdoc);
		$pdfdoc = str_replace("%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp+style%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp+style%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp+style%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp+style%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Fp%3E%0A","", $pdfdoc);
		$pdfdoc = str_replace("%0A%3Cp+style%3D%22text-align%3Ajustify%22%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp+style%3D%22text-align%3Ajustify%22%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp+style%3D%22text-align%3Ajustify%22%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp+style%3D%22text-align%3Ajustify%22%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp+style%3D%22text-align%3Ajustify%22%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp+style%3D%22text-align%3Ajustify%22%3E%26nbsp%3B%3C%2Fp%3E%0A","", $pdfdoc);
		$pdfdoc = str_replace("%3Cp%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%2Bstyle%3D%22text-align%3Acenter%22%3E%26nbsp%3B%3C%2Fp%3E%0A%0A%3Cp%3E%26nbsp%3B%3C%2Fp%3E","", $pdfdoc);
		//echo $pdfdoc;
		//die();
		echo urldecode($pdfdoc);
	
	?>
</page>
