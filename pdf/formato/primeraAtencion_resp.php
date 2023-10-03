
        <style>
            /** Define the margins of your page **/
           
           
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

            
            

        </style>
<!-- <?php // core::preprint($contenido);exit();?> -->
<page backtop="35mm" backbottom="13mm" backleft="14mm" backright="14mm">
    <!-- Define header and footer blocks before your content -->
    <page_header class="header">
        <table col=1>
            <tr>
                    <td><br>
                    
                        <img src="https://claimsmanager.online/pdf/formato/logoCMA__white.jpg" style="margin-top:15px;padding-bottom:0px;margin-bottom:-18px;width: 150px; height: auto; position: absolute;">
                        <!-- <img src="./formato/logoCMA__white.jpg" style="margin-top:15px;padding-bottom:0px;margin-bottom:-18px;width: 150px; height: auto; position: absolute;"> -->
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
                        <td border=1 style="background-color: #dfbaa0;">Área
                        </td>
                        <td border=1><?=ucwords($contenido['area'])?>
                        </td>
                    </tr>
                </table>
            </div>
    </page_header >
    <page_footer class="footer" >
        <table style="width: 100%; border: solid 0px gray;">
            <tr>
                <td style="text-align: left;  color:gray;  width: 80%">Cracovia No. 72, Int. APO-02, Col. San Ángel, Alcaldía Álvaro Obregón, C.P. O1000, CDMX</td>
                <td style="text-align: right; color:gray;   width: 20%"><b>CMA</b>   página: [[page_cu]]/[[page_nb]]</td>
            </tr>
        </table>
        
    </page_footer>

    <?php echo urldecode($contenido['primera_atencion']);?>

    <!-- Wrap the content of your PDF inside a div class="main" tag -->
</page>