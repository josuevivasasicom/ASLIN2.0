<?php ?>

<script>
//LINK outlook
function primeraAtencionLINK(area,fullArea,areaID){
    const txt = SiniestroID[area].primeratencion.primera_atencion;

    var mailHtm ="<h1> Sample Email <h1>";
    var emailto = "jesus@Wperficient.com";
    var emailsubject = "Se informa . <?=$sn['folio']?>";
    var emlCont = 'To: '+emailto + '\n';
    emlCont += 'Cc: siniestros@cmabogados.com; jesus@cmabogados.com \n';
    emlCont += 'Bcc: hola@google.com \n';

    emlCont += 'X-Unsent: 1'+'\n';
    
    emlCont += 'Content-Type: text/html'+'\n';
    emlCont += 'Subject: '+emailsubject+'\n';
    emlCont += ''+'\n';

    emlCont += "<!DOCTYPE html><html><head></head><body style='background-color: white; color: black'>" + txt + "</body></html>";
    console.log(emlCont) ;
    var textFile = null;
    var data = new Blob([emlCont], {type: 'text/plain'});
    if (textFile !== null) {
    window.URL.revokeObjectURL(textFile);
    }

    textFile = window.URL.createObjectURL(data);
    console.log(textFile);

    var a = document.createElement('a'); //make a link in document
    var linkText = document.createTextNode('fileLink');
    a.appendChild(linkText) ;

    a.href = textFile;

    a.id = 'fileLink';
    a.download = emailsubject+".eml"; //'filenameTest.eml' ;
    a.style.visibility = "hidden";

    document.body.appendChild(a) ;

    document.getElementById('fileLink').click();
}

function primeraAtencionLINKnofunk(area,fullArea,areaID){
    console.log('creando...');
     
        let t1= `To: User <user@domain.demo>
                Subject: Subject
                X-Unsent: 1
                Content-Type: text/html

                <html>
                <head></head> <body>`;
        const txt = SiniestroID[area].primeratencion.primera_atencion;
        let t2 = `</body>`;

        let textFile = null,
        makeTextFile = function (text) {
            let data = new Blob([text], {type: 'text/plain'});
            if (textFile !== null) {
            window.URL.revokeObjectURL(textFile);
            }
            textFile = window.URL.createObjectURL(data);
            return textFile;
        };

        makeTextFile(t1+txt+t2);
        console.log('descargando...');
}


function primeraAtencionLINKDisabled(area,fullArea,areaID){
    const txt = SiniestroID[area].primeratencion.primera_atencion;
    // window.open("mailto:mena@cmabogados.mx?Subject=Primera%20Atención%20&body="+txt,"_blank");
    // window.location.href="mailto:mena@cmabogados.mx?Subject=Primera%20Atención&body=<p>Fecha de Asignaci&oacute;n: 14 jun 2022<br />\n<strong>Lic. Luis Alberto Mart&iacute;nez Garc&iacute;a &nbsp; &nbsp; &nbsp; &nbsp;/ &nbsp;&nbsp;&nbsp;&nbsp; Lic. Mario Aguilar Guajardo.<br />\nASUNTO: Se Informa Primera Atenci&oacute;n.<br />\nREPORTE: ASD23456</strong><br />\nCreado el:11 jun 2022<br />\nID: 102-024-22<br />\nAsegurado: Adolfo renato Mariano Chavez</p>\n\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Con relaci&oacute;n al reporte n&uacute;mero <strong>ASD23456</strong> correspondiente al <strong>Adolfo renato Mariano Chavez</strong> asignado a esta firma legal el d&iacute;a <strong>14 jun 2022</strong>, por el presente le informo que ya se tuvo comunicaci&oacute;n con el asegurado a quien se le proporcionaron nuestros datos y n&uacute;meros telef&oacute;nicos y se le requiri&oacute; la informaci&oacute;n necesaria para la atenci&oacute;n del asunto.</p>\n\n<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Asimismo, hago de su conocimiento los datos m&iacute;nimos de este reporte para la obtenci&oacute;n del n&uacute;mero de siniestro que nos ocupa:</p>\n\n<p>P&oacute;liza:3-70-7000118-1-0 / 123ert /<br />\nVigencia:10-jun-22<br />\nInstituci&oacute;n: capufe.<br />\nTercero: Demandante<br />\nFecha de ocurrido:<br />\nLugar de ocurrido:<br />\nFecha de Vigencia: 10-jun-22<br />\nAutoridad: cesamed<br />\nExpediente de Autoridad:<br />\nForma de contacto: telefono<br />\nTels.:cel: / casa: / oficina:<br />\nEmail:mail@gmail.com<br />\nMotivo del siniestro:</p>\n\n<p>Agradeciendo su atenci&oacute;n, me reitero a sus &oacute;rdenes para cualquier duda o aclaraci&oacute;n.</p>\n\n<p><strong>A T E N T A ME N T E</strong><br />\nLic. Victor Hugo Alarc&oacute;n L&oacute;pez.</p>\n";

    var item;

    Office.initialize = function () {
        item = Office.context.mailbox.item;
        // Checks for the DOM to load using the jQuery ready function.
        $(document).ready(function () {
            // After the DOM is loaded, app-specific code can run.
            // Insert data in the top of the body of the composed 
            // item.
            prependItemBody();
        });
    }

    // Get the body type of the composed item, and prepend data  
    // in the appropriate data type in the item body.
    function prependItemBody() {
        item.body.getTypeAsync(
            function (result) {
                if (result.status == Office.AsyncResultStatus.Failed){
                    write(asyncResult.error.message);
                }
                else {
                    // Successfully got the type of item body.
                    // Prepend data of the appropriate type in body.
                    if (result.value == Office.MailboxEnums.BodyType.Html) {
                        // Body is of HTML type.
                        // Specify HTML in the coercionType parameter
                        // of prependAsync.
                        item.body.prependAsync(
                            '<b>Greetings!</b>',
                            { coercionType: Office.CoercionType.Html, 
                            asyncContext: { var3: 1, var4: 2 } },
                            function (asyncResult) {
                                if (asyncResult.status == 
                                    Office.AsyncResultStatus.Failed){
                                    write(asyncResult.error.message);
                                }
                                else {
                                    // Successfully prepended data in item body.
                                    // Do whatever appropriate for your scenario,
                                    // using the arguments var3 and var4 as applicable.
                                }
                            });
                    }
                    else {
                        // Body is of text type. 
                        item.body.prependAsync(
                            'Greetings!',
                            { coercionType: Office.CoercionType.Text, 
                                asyncContext: { var3: 1, var4: 2 } },
                            function (asyncResult) {
                                if (asyncResult.status == 
                                    Office.AsyncResultStatus.Failed){
                                    write(asyncResult.error.message);
                                }
                                else {
                                    // Successfully prepended data in item body.
                                    // Do whatever appropriate for your scenario,
                                    // using the arguments var3 and var4 as applicable.
                                }
                            });
                    }
                }
            });

    }

    // Writes to a div with id='message' on the page.
    function write(message){
        document.getElementById('message').innerText += message; 
    }

}

//EDITAR PRIMERA ATENCION
function primeraAtencionEDITAR(area,fullArea,areaID){
    console.log(areaID);
    setTimeout(() => {
            CKEDITOR.replace( 'primeraAtencionEditar',{
                width:'100%',
                uiColor: '#ede6c6',
                editorplaceholder: 'Descripcion de hechos '+fullArea,
            });
        }, 300);

        const txt = SiniestroID[area].primeratencion.primera_atencion;
        const html_ = `<div class="input-group">
                    <div class="input-group-prepend">
                      <!-- <span class="input-group-text">With textarea </span> -->
                    </div>
                    <textarea placeholder="" id="primeraAtencionEditar" name="primeraAtencion">
                    `+txt+`
                    </textarea>
                    <label class="mt-4 pt-2" for="horas" >Horas: </label>
                    <input class="mt-4 input form-input input-form" placeholder=" para bitácora" type="number" step=".5" id="horasPA" name="horas" required>
                    <label class="mt-4 pt-2" for="horas" >  Fecha Actividad: </label> &nbsp;&nbsp;
                    <input class="mt-4 input form-input input-form" placeholder=" Fecha Actividad" type="date" name="fechaActividad" id="fechaActividadPA"  required> <br>
                    <input class="mt-4 input form-input input-form" placeholder="Comentario para bitácora (opcional)" type="text" id="textPA" name="bitacora" style="width=100% !important;">

        </div>`;
                    
        Swal.fire({
            width:'50%',
            confirmButtonColor: 'var(--color-dark)',
            denyButtonColor: 'var(--color-blanco)',
            cancelButtonColor: 'var(--fondo-degradado)',
            title: 'Primera Atención: '+fullArea,
            html: html_,
            confirmButtonText: 'Guardar',
            showCancelButton: true,
            cancelButtonText: 'Salir',
            focusConfirm: false,
            allowOutsideClick:false,
            preConfirm: () => {
                const primeraAtencion = CKEDITOR.instances['primeraAtencionEditar'].getData();
                const horas = Swal.getPopup().querySelector('#horasPA[name=horas]').value;
                const bitacora = Swal.getPopup().querySelector('#textPA[name=bitacora]').value;
                const fechaActividad = Swal.getPopup().querySelector('#fechaActividadPA[name=fechaActividad]').value;
                const timerst = "<?=$sn['timerst']?>";
                const folio = "<?=$sn['folio']?>";


                if (primeraAtencion == html_)
                Swal.showValidationMessage(`No puedes dejar el texto igual`);
                
                if (!horas)
                Swal.showValidationMessage(`Escribe un rango de horas`);

                if (!fechaActividad)
                Swal.showValidationMessage(`Escribe la fecha de la actividad`);
              
                return { primeraAtencion,timerst,folio,areaID,horas,bitacora,fechaActividad};
            }
            
        })
        .then((cambios) => {
            //alert("archivo cargado!!");
            //?cuando ya está OK
            if (cambios.isConfirmed){
                $.ajax({
                    url: "./?action=siniestro/primeraAtencion&guardar=primeraAtencion",
                    method: "POST",
                    data: {'data':cambios.value} ,
                    success: function(respuesta) {
                        // dataset = JSON.parse(respuesta);
                        console.log(respuesta);
                        Swal.fire(`
                            Se editó y guardó la Primer Atención 
                        `.trim()).then(()=>{
                            location.reload();
                        })
                    },
                    error:{ function(e) { conjsole.log(e); }  }
                });
            }
        });

}

//PRIMERA ATENCIÓN OK
function primeraAtencion(area,timerst){
    let calificacion = SiniestroID.calificacion;
    let folio = SiniestroID.folio;
    let nombre = SiniestroID.nombre+' '+SiniestroID.apellidoP+' '+SiniestroID.apellidoM;
    let numReporte = SiniestroID.numReporte;
    let fechaReporte = SiniestroID.fechaReporte;
    let vigencia1 = SiniestroID.vigencia1_F2;
    let vigencia2 = SiniestroID.vigencia2_F2;
    let fechaAsignacion = SiniestroID.fechaAsignacion;
    let fechaCaptura = SiniestroID.fechaCaptura;
    let institucion= SiniestroID.institucion;
    let autoridad= SiniestroID.autoridad;
    let telefonos = SiniestroID.telefonos;
    let mail = SiniestroID.mail;
    let formaContacto = SiniestroID.formaContacto;
    let poliza = SiniestroID.poliza;
    let tercero = SiniestroID.tercero;
    

    // elimina la hora de la fecha en los siguientes: 
    /* fechaAsignacion =   fechaAsignacion.split(" ")[0]
    fechaCaptura =      fechaCaptura.split(" ")[0]
    fechaReporte =      fechaReporte.split(" ")[0] */
    //retarda el CKEDITOR 200 ms
    console.log(timerst);
    setTimeout(() => {
        CKEDITOR.replace( 'primeraAtencion',{
            width:'100%',
            uiColor: '#ede6c6',
            editorplaceholder: 'Descripcion de hechos '+getAreaNamebyId(area)['area'],
        });
    }, 300);

        //swert alert para editar el proveedor o proveniente
        //FORMATO DE PRIMERA ATENCION
        let selInput =` <div class="input-group">
        <div class="input-group-prepend">
            <!-- <span class="input-group-text">With textarea </span> -->
        </div>
        <textarea placeholder="" id="primeraAtencion" name="primeraAtencion">
        
        <p>
        <strong>Lic. Luis Alberto Mart&iacute;nez Garc&iacute;a  &nbsp; &nbsp; &nbsp; &nbsp;/ &nbsp;&nbsp;&nbsp;&nbsp;     Lic. Mario Aguilar Guajardo.<br />
        ASUNTO: Se Informa Primera Atenci&oacute;n.<br />
        REPORTE: `+numReporte+`</strong><br />
        ID: `+folio+` <br />
        Asegurado: `+nombre+` </p>

        <p align"justify" style="text-align:justify" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Con relaci&oacute;n al reporte n&uacute;mero &nbsp;&nbsp;&nbsp;&nbsp; <strong> &nbsp;  `+numReporte+`</strong> correspondiente a &nbsp;
        <strong> &nbsp; `+nombre+`</strong> asignado a esta firma legal el d&iacute;a  &nbsp; <strong> &nbsp;  `+fechaAsignacion+`</strong>, por el presente le informo que ya se tuvo comunicaci&oacute;n con el asegurado a quien se le proporcionaron nuestros datos y n&uacute;meros telef&oacute;nicos y se le requiri&oacute; la informaci&oacute;n necesaria para la atenci&oacute;n del asunto.</p>

        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Asimismo, hago de su conocimiento los datos m&iacute;nimos de este reporte para la obtenci&oacute;n del n&uacute;mero de siniestro que nos ocupa:</p>

        <p>P&oacute;liza:`+poliza+`<br />
        Fecha de Vigencia inicio:`+vigencia1+`<br />
        Fecha de Vigencia fin: `+vigencia2+` <br />
        Instituci&oacute;n:  `+institucion+`<br />
        Tercero: `+tercero+`<br />
        Fecha de ocurrido: <br />
        Lugar de ocurrido: <br />
        Autoridad: `+autoridad+` <br />
        Expediente de Autoridad:<br />
        Tels.:`+telefonos+`<br />
        Email:`+mail+`<br />
        Motivo del siniestro:</p>

        <p align"justify">Agradeciendo su atenci&oacute;n, me reitero a sus &oacute;rdenes para cualquier duda o aclaraci&oacute;n.</p>

        <p><strong>A T E N T A ME N T E</strong><br />
        <?php echo $_SESSION['nombre'].' '.$_SESSION['paterno'].' '.$_SESSION['materno'] ?>.</p>

        <p align"justify"> </>

        </textarea>
        <label class="mt-4 pt-2" for="horas" >Horas: </label>
        <input class="mt-4 input form-input input-form" placeholder=" para bitácora" type="number" step=".5" id="horasPA" name="horas" required>
        <label class="mt-4 pt-2" for="horas" >  Fecha Actividad: </label> &nbsp;&nbsp;
        <input class="mt-4 input form-input input-form" placeholder=" Fecha Actividad" type="date" name="fechaActividad" id="fechaActividadPA"  required> <br>
        <input class="mt-4 input form-input input-form" placeholder="Comentario para bitácora (opcional)" type="text" id="textPA" name="bitacora" style="width:100% !important;">

        </div>`;
    let html_ = `<label>ID : </label> <b> `+folio+`</b>`;
    html_ = html_ + selInput;
    Swal.fire({
        width:'50%',
        confirmButtonColor: 'var(--color-dark)',
        denyButtonColor: 'var(--color-blanco)',
        cancelButtonColor: 'var(--fondo-degradado)',
        title: 'Primera Atención: '+getAreaNamebyId(area)['area'],
        html: html_,
        confirmButtonText: 'Guardar',
        showCancelButton: true,
        cancelButtonText: 'Salir',
        focusConfirm: false,
        allowOutsideClick:false,
        preConfirm: () => {
            const primeraAtencion = CKEDITOR.instances['primeraAtencion'].getData();
            const horas = Swal.getPopup().querySelector('#horasPA[name=horas]').value;
            const fechaActividad = Swal.getPopup().querySelector('#fechaActividadPA[name=fechaActividad]').value;
            const bitacora = Swal.getPopup().querySelector('#textPA[name=bitacora]').value;
            
            if (!fechaActividad)
            Swal.showValidationMessage(`Escribe la fecha de la actividad`);

            if (primeraAtencion == html_)
            Swal.showValidationMessage(`No puedes dejar el texto igual`);
            
            if (!horas)
            Swal.showValidationMessage(`Escribe un rango de horas`);


            return { primeraAtencion,timerst,folio,areaID:area,horas,bitacora,fechaActividad}
        }
        
    })
    .then((cambios) => {
        //alert("archivo cargado!!");
        //?cuando ya está OK
        if (cambios.isConfirmed){
            $.ajax({
                url: "./?action=siniestro/primeraAtencion&guardar=primeraAtencion",
                method: "POST",
                data: {'data':cambios.value} ,
                success: function(respuesta) {
                    // dataset = JSON.parse(respuesta);
                    console.log(respuesta);
                    Swal.fire(`
                        Se guardó la Primer Atención 
                    `.trim()).then(()=>{
                        location.reload();
                    })
                },
                error:{ function(e) { conjsole.log(e); }  }
            });
        }
    });
}
</script>
