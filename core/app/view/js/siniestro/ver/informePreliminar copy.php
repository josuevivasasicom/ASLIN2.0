<?php ?>

<script>
//LINK outlook
function informePreliminarLINK(area,fullArea,areaID){
    const txt = SiniestroID[area].informePreliminar.informe_preliminar;


    var mailHtm ="<h1> Sample Email <h1>";
    var emailto = "jesus@Wperficient.com";
    var emailsubject = "Se informa Preliminar. <?=$sn['folio']?>";
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

//EDITAR INFORME PRELIMINAR
function informePreliminarEDITAR(area,fullArea,areaID){
    console.log(areaID);
    setTimeout(() => {
            CKEDITOR.replace( 'informePreliminarEDITAR',{
                width:'100%',
                uiColor: '#ede6c6',
                editorplaceholder: 'PRELIMINAR '+fullArea,
            });
        }, 300);

        const txt = SiniestroID[area].informePreliminar.informe_preliminar;
        const html_ = `<div class="input-group">
                    <div class="input-group-prepend">
                      <!-- <span class="input-group-text">With textarea </span> -->
                    </div>
                    <textarea placeholder="" id="informePreliminarEDITAR" name="informePreliminar">
                    `+txt+`
                    </textarea>
                     
                    <label class="mt-4 pt-2" for="horas" >Horas: </label>
                    <input class="mt-4 input form-input input-form" placeholder=" para bitácora" type="number" step=".5" id="horasIP" name="horas" required>
                    <input class="mt-4 input form-input input-form" placeholder="Comentario para bitácora (opcional)" type="text" id="textIP" name="bitacora">

        </div>`;
                    
        Swal.fire({
            width:'50%',
            confirmButtonColor: 'var(--color-dark)',
            denyButtonColor: 'var(--color-blanco)',
            cancelButtonColor: 'var(--fondo-degradado)',
            title: 'Informe Preliminar: '+fullArea,
            html: html_,
            confirmButtonText: 'Guardar',
            showCancelButton: true,
            cancelButtonText: 'Salir',
            focusConfirm: false,
            allowOutsideClick:false,
            didOpen: () => {
              //Swal.showLoading(); coloca color azul a la tabla, solo en swetalert, no pasa a formato pdf
              setTimeout(() => {
                let numFrame= (window.frames.length) - 1;

                window.frames[0].document.querySelectorAll(".anexoTabla tr th").forEach(th => {
                  th.style.background = "#7de8ff";
                });
                
              }, 500);

            },
            preConfirm: () => {
                const informePreliminar = CKEDITOR.instances['informePreliminarEDITAR'].getData();
                const horas = Swal.getPopup().querySelector('#horasIP[name=horas]').value;
                const bitacora = Swal.getPopup().querySelector('#textIP[name=bitacora]').value;
                const timerst = "<?=$sn['timerst']?>";
                const folio = "<?=$sn['folio']?>";


                if (informePreliminar == html_)
                Swal.showValidationMessage(`No puedes dejar el texto igual`);
                
                if (!horas)
                Swal.showValidationMessage(`Selecciona un rango de horas`);
              
                return { informePreliminar,timerst,folio,areaID,horas,bitacora};
            }
            
        })
        .then((cambios) => {
            //alert("archivo cargado!!");
            //?cuando ya está OK
            if (cambios.isConfirmed){
                $.ajax({
                    url: "./?action=siniestro/informePreliminar&guardar=informePreliminar",
                    method: "POST",
                    data: {'data':cambios.value} ,
                    success: function(respuesta) {
                        // dataset = JSON.parse(respuesta);
                        console.log(respuesta);
                        Swal.fire(`
                            Se editó y guardó Informe Preliminar 
                        `.trim()).then(()=>{
                            location.reload();
                        })
                    },
                    error:{ function(e) { conjsole.log(e); }  }
                });
            }
        });

}

//INFORME PRELIMINAR OK
function informePreliminar(area,timerst,calificacion,folio,nombre,numReporte,fechaReporte,vigencia1,vigencia2,fechaAsignacion,fechaCaptura,institucion,autoridad,telefonos,email,formaContacto,poliza){

    // elimina la hora de la fecha en los siguientes: 
   /*  fechaAsignacion =   fechaAsignacion.split(" ")[0]
    fechaCaptura =      fechaCaptura.split(" ")[0]
    fechaReporte =      fechaReporte.split(" ")[0] */
    //retarda el CKEDITOR 200 ms
    console.log(timerst);
    setTimeout(() => {
        CKEDITOR.replace( 'informePreliminar',{
            width:'100%',
            uiColor: '#ede6c6',
            editorplaceholder: 'InformePreliminar '+getAreaNamebyId(area)['area'],
        });


        // ckeditor.on('informePreliminar', function (ck) { ck.editor.on("change", function (e) { var sel = ck.editor.getSelection(); if (sel) { var selected = sel.getStartElement(); if (selected && selected.$) sel.getStartElement().$.normalize(); } }); });



    }, 200);

      //swert alert para editar el proveedor o proveniente
      //FORMATO DE INFORME PRELIMINAR
      let selInput = `
<div class="input-group">
  <div class="input-group-prepend">
  <!-- <span class="input-group-text">With textarea </span> -->
  </div>
  <textarea placeholder="" id="informePreliminar" name="informePreliminar">
      <br>
        <p>Fecha de Asignaci&oacute;n:2022-01-25<br />
        <strong>Lic. Luis Alberto Mart&iacute;nez Garc&iacute;a &nbsp; &nbsp; &nbsp; &nbsp;/ &nbsp;&nbsp;&nbsp;&nbsp; Lic. Mario Aguilar Guajardo.</strong></p>

        <p><strong>ASUNTO: Informe Preliminar.<br />
        REPORTE: 2022-01-25</strong><br />
        Creado el: centro<br />
        I.D.: erick<br />
        Asegurado: 12345</p>

        <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Adjunto al presente env&iacute;o el informe preliminar correspondiente al asegurado <strong>12345</strong>, mismo que se realiz&oacute; con base a la informaci&oacute;n y documentaci&oacute;n suministrada por este &uacute;ltimo, el cual en opini&oacute;n de esta firma legal es <strong> 104-018-22 </strong>, de que se le proporcione la asistencia legal requerida, salvo instrucciones en contrario, por lo que someto a su consideraci&oacute;n la procedencia del mismo, solicit&aacute;ndole se sirva proporcionando el n&uacute;mero de siniestro que le corresponda al mismo, para los efectos y tr&aacute;mites conducentes.</p>

        <p>Agradeciendo su atenci&oacute;n, me reitero a sus &oacute;rdenes para cualquier duda o aclaraci&oacute;n.</p>

        <p><strong>ATENTAMENTE:<br />
        <?php echo $_SESSION['nombre'].' '.$_SESSION['paterno'].' '.$_SESSION['materno'] ?>.</strong></p>

        <p>Email:</p>

        <p>Anexos:</p>

        <div style="page-break-after:always"><span style="display:none">&nbsp;</span></div>

        <table align="center" border="2" cellspacing="0" class="anexoTabla" style="border-collapse:collapse; border:solid 2px red; width:100%">
          <thead>
            <tr>
              <td style=" width:100%" colspan="5"> </td>
            </tr>
            <tr>
              <th style="text-align:center" colspan="2" >NÚMERO DE P&Oacute;LIZA</th>
              <th style="text-align:center" colspan="2" >NOMBRE DEL CONTRATANTE/ASEGURADO</th>
              <th style="text-align:center" >FECHA OCURRIDO</th>
            </tr>
            </thead>
            <tbody>
          <tr>
              <td colspan="2">{POLIZA}</td>
              <td colspan="2">{NOMBRE}</td>
              <td>{FECHA OCURRIDO}</td>
            </tr>
            <tr>
              <th colspan="5">NOMBRE DEL RECLAMANTE Y/O TERCERO</th>
            </tr>
            <tr>
              <td colspan="5">{NOMBRE TERCERO}</td>
            </tr>
            <tr>
              <th colspan="2">CAUSA PROBABLE</th>
              <th colspan="2">LUGAR OCURRIDO</th>
              <th>ESTADO/CIUDAD/POBLACI&Oacute;N</th>
            </tr>
            <tr>
              <td colspan="2">{NA}</td>
              <td colspan="2">{DEPARTAMENTO}</td>
              <td>{CIUDAD}</td>
            </tr>
            <tr>
              <th colspan="2">AGENTE</th>
              <td colspan="3" style="text-align:center">2</td>
            </tr>
            <tr>
              <th colspan="2">PRACTICA</th>
              <td colspan="3" style="text-align:center">3</td>
            </tr>
            <tr>
              <th colspan="2">VIGENCIA</th>
              <th rowspan="2">FECHA Y HORA<br />
              DE REPORTE</th>
              <th rowspan="2">FECHA Y HORA<br />
              DE ASIGNACI&Oacute;N</th>
              <th colspan="1" rowspan="2">FECHA Y HORA<br />
              DE 1A ATENCI&Oacute;N</th>
            </tr>
            <tr>
              <th>INICIO</th>
              <th>FIN</th>
            </tr>
            <tr>
              <td rowspan="2">{INICIO}</td>
              <td rowspan="2">{FIN}</td>
              <td>{FECHA1}</td>
              <td>{FECHA2}</td>
              <td>{FECHA3}</td>
            </tr>
            <tr>
              <td>{HORA1}</td>
              <td>{HORA2}</td>
              <td>{HORA3}</td>
            </tr>
            <tr>
              <th colspan="5">AUTORIDAD: OIC / JUICIO CIVIL / JUICIO PENAL<br />
              RADICADO EN:</th>
            </tr>
            </tbody>
        </table>


        comienzan los rows

        <!-- <p>fghdfg <br> dfgdfg</p>
        <p>fghdfg <br> dfgdfg</p> -->
        <p>
        Adjunto al presente envío el informe preliminar correspondiente al asegurado 12345, mismo que se
        realizó con base a la información y documentación suministrada por este último, el cual en opinión de esta firma
        legal es 104-018-22 , de que se le proporcione la asistencia legal requerida, salvo instrucciones en contrario, por lo
        que someto a su consideración la procedencia del mismo, solicitándole se sirva proporcionando el número de
        siniestro que le corresponda al mismo, para los efectos y trámites conducentes 
        </p>

              
        <p style="text-align:justify"><strong>HECHOS:</strong> El siniestro fue turnado a esta Firma Legal, toda vez que el Representante Legal de la moral asegurada, inform&oacute; que realizaba su reporte, en virtud de la fractura distal de radio derecho que present&oacute; la se&ntilde;ora Margot Haiat Cohen, a consecuencia de la ca&iacute;da que sufri&oacute; durante los cuidados brindados por la C. Nancy Selena Funes Garc&iacute;a (empleada de la asegurada cuando ocurrieron los hechos motivo del siniestro), en las instalaciones de la residencia Belmont Village Senior Living Santa Fe, solicitando el pago del reembolso de los gastos generados con motivo de honorarios m&eacute;dicos, tratamiento quir&uacute;rgico, medicamentos y hospitalizaci&oacute;n para restablecer la salud de la tercero.</p>


        <br>
        <br>
        <br>
        <table border="1" cellpadding="0" cellspacing="0" class="anexoTabla" id="anexoTabla" style="background:#ffffff !important; width:100%">>
          <tbody>
            <tr>
              <th colspan="3">NO DE EXPEDIENTE:</th>
              <td colspan="2" style="text-align:center">{DATO}</td>
            </tr>
            <tr>
              <th colspan="3">ETAPA DE LA INDAGATORIA Y/O JUICIO</th>
              <td colspan="2" style="text-align:center">{DATO}</td>
            </tr>
            <tr>
              <th colspan="5">BREVE DESCRIPCI&Oacute;N DE LOS HECHOS&nbsp;</th>
            </tr>
            <tr>
              <td colspan="5" style="text-align:center">&nbsp;</td>
            </tr>
            <tr>
              <th colspan="2">CAUSA PR&Oacute;XIMA DEL</th>
              <td colspan="3" rowspan="1" style="text-align:center">&nbsp;</td>
            </tr>
            <tr>
              <th colspan="5">RECLAMACI&Oacute;N</th>
            </tr>
            <tr>
              <th colspan="2">PROCEDENTE</th>
              <th colspan="2">IMPROCEDENTE</th>
              <th>POR DETERMINAR</th>
            </tr>
            <tr>
              <td colspan="2" style="text-align:center">&nbsp;</td>
              <td colspan="2" style="text-align:center">&nbsp;</td>
              <td style="text-align:center">&nbsp;</td>
            </tr>
            <tr>
              <th colspan="5">PARA CUALQUIER CASO, FUNDAMENTO:</th>
            </tr>
            <tr>
              <td colspan="5" style="text-align:center">&nbsp;</td>
            </tr>
            <tr>
              <th colspan="5">RESERVA RECOMENDADA</th>
            </tr>
            <tr>
              <th colspan="2">SUMA ASEGURADA</th>
              <th>ESTIMACI&Oacute;N ASEGURADA</th>
              <th>IMPORTE RECLAMADO</th>
              <th>RESERVA RECOMENDADA</th>
            </tr>
            <tr>
              <td colspan="2" style="text-align:center">&nbsp;</td>
              <td style="text-align:center">&nbsp;</td>
              <td style="text-align:center">&nbsp;</td>
              <td style="text-align:center">&nbsp;</td>
            </tr>
            <tr>
              <th colspan="5">OBSERVACIONES</th>
            </tr>
          </tbody>
        </table>

        comienzan los asdasdas 
  </textarea>
  
  <label class="mt-4 pt-2" for="horas" >Horas: </label>
  <input class="mt-4 input form-input input-form" placeholder=" para bitácora" type="number" step=".5" id="horasIP" name="horas" required>
  <input class="mt-4 input form-input input-form" placeholder="Comentario para bitácora (opcional)" type="text" id="textIP" name="bitacora" >
  
</div>
      `;


      let selInputpppp =` <div class="input-group">
        <div class="input-group-prepend">
        <!-- <span class="input-group-text">With textarea </span> -->
        </div>
        <textarea placeholder="" id="informePreliminar" name="informePreliminar">
          <p>Fecha de Asignaci&oacute;n:`+fechaAsignacion+`<br />
          <strong>Lic. Luis Alberto Mart&iacute;nez Garc&iacute;a &nbsp; &nbsp; &nbsp; &nbsp;/ &nbsp;&nbsp;&nbsp;&nbsp; Lic. Mario Aguilar Guajardo.</strong><br />
          <strong>ASUNTO: Informe Preliminar.<br />
          REPORTE: `+numReporte+`</strong><br />
          Creado el: `+fechaCaptura+`<br />
          I.D.: `+folio+`<br />
          Asegurado: `+nombre+`</p>

          <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Adjunto al presente env&iacute;o el informe preliminar correspondiente al asegurado <strong>`+nombre+`</strong>, mismo que se realiz&oacute; con base a la informaci&oacute;n y documentaci&oacute;n suministrada por este &uacute;ltimo, el cual en opini&oacute;n de esta firma legal es <strong> `+calificacion+` </strong>, de que se le proporcione la asistencia legal requerida, salvo instrucciones en contrario, por lo que someto a su consideraci&oacute;n la procedencia del mismo, solicit&aacute;ndole se sirva proporcionando el n&uacute;mero de siniestro que le corresponda al mismo, para los efectos y tr&aacute;mites conducentes.</p>

          <p>Agradeciendo su atenci&oacute;n, me reitero a sus &oacute;rdenes para cualquier duda o aclaraci&oacute;n.</p>

          <p><strong>ATENTAMENTE:<br />
          <?php echo $_SESSION['nombre'].' '.$_SESSION['paterno'].' '.$_SESSION['materno'] ?>.</strong></p>

          <p>Email:</p>

          <p>Anexos:</p>

          <div style="page-break-after:always"><span style="display:none">&nbsp;</span></div>

          <table align="center" border="1" cellspacing="0" class="anexoTabla" style="border-collapse:collapse; border:solid 1px black; width:100%">
            <thead>
              <tr>
                <td style=" width:100%" colspan="5"> </td>
              </tr>
              <tr>
                <th style="text-align:center" colspan="2" >NÚMERO DE P&Oacute;LIZA</th>
                <th style="text-align:center" colspan="2" >NOMBRE DEL CONTRATANTE/ASEGURADO</th>
                <th style="text-align:center" >FECHA OCURRIDO</th>
              </tr>
              </thead>
              <tbody>
            <tr>
                <td colspan="2">`+poliza+`</td>
                <td colspan="2">`+nombre+`</td>
                <td> </td>
              </tr>
              <tr>
                <th colspan="5">NOMBRE DEL RECLAMANTE Y/O TERCERO</th>
              </tr>
              <tr>
                <td colspan="5"> {nombre tercero}</td>
              </tr>
              <tr>
                <th colspan="2">CAUSA PROBABLE</th>
                <th colspan="2">LUGAR OCURRIDO</th>
                <th>ESTADO/CIUDAD/POBLACI&Oacute;N</th>
              </tr>
              <tr>
                <td colspan="2"> {causa} </td>
                <td colspan="2">`+SiniestroID.estado+`</td>
                <td>`+SiniestroID.ciudad+`</td>
              </tr>
              <tr>
                <th colspan="2">AGENTE</th>
                <td colspan="3" style="text-align:center">{?}</td>
              </tr>
              <tr>
                <th colspan="2">PRACTICA</th>
                <td colspan="3" style="text-align:center">{?}</td>
              </tr>
              <tr>
                <th colspan="2">VIGENCIA</th>
                <th rowspan="2">FECHA Y HORA<br />
                DE REPORTE</th>
                <th rowspan="2">FECHA Y HORA<br />
                DE ASIGNACI&Oacute;N</th>
                <th colspan="1" rowspan="2">FECHA Y HORA<br />
                DE 1A ATENCI&Oacute;N</th>
              </tr>
              <tr>
                <th>INICIO</th>
                <th>FIN</th>
              </tr>
              <tr>
                <td rowspan="2">`+SiniestroID.vigencia1.split(' ')[0]+`</td>
                <td rowspan="2">`+SiniestroID.vigencia2.split(' ')[0]+`</td>
                <td>`+SiniestroID.fechaReporte.split(' ')[0]+`</td>
                <td>`+SiniestroID.fechaAsignacion.split(' ')[0]+`</td>
                <td>`+SiniestroID.fechaCaptura.split(' ')[0]+`</td>
              </tr>
              <tr>
                <td>`+SiniestroID.fechaReporte.split(' ')[1]+`</td>
                <td>`+SiniestroID.fechaAsignacion.split(' ')[1]+`</td>
                <td>`+SiniestroID.fechaCaptura.split(' ')[1]+`</td>
              </tr>
              <tr>
                <th colspan="5">AUTORIDAD: OIC / JUICIO CIVIL / JUICIO PENAL<br />
                RADICADO EN:</th>
              </tr>
              <tr>
               <td colspan="5">`+SiniestroID.autoridad.toUpperCase()+`</td>
              </tr>
              <tr>
                <th colspan="3">NO DE EXPEDIENTE:</th>
                <td colspan="2" style="text-align:center">{DATO}</td>
              </tr>
              <tr>
                <th colspan="3">ETAPA DE LA INDAGATORIA Y/O JUICIO</th>
                <td colspan="2" style="text-align:center">{DATO}</td>
              </tr>
              <tr>
                <th colspan="5">BREVE DESCRIPCI&Oacute;N DE LOS HECHOS&nbsp;</th>
              </tr>
            </tbody>
          </table>
          <p style="text-align:justify">Descripción: &nbsp;</p>
          <table align="center" border="1" cellspacing="0" class="anexoTabla" style="border-collapse:collapse; border:solid 1px black; width:100%">
            <thead>
            <tr>
              <td colspan="5" style="text-align:center">&nbsp;</td>
            </tr>
            </thead>
            <tbody>
              <tr>
                <th colspan="2">CAUSA PR&Oacute;XIMA DEL</th>
                <td colspan="3" rowspan="1" style="text-align:center">&nbsp;</td>
              </tr>
              <tr>
                <th colspan="5">RECLAMACI&Oacute;N</th>
              </tr>
              <tr>
                <th colspan="2">PROCEDENTE</th>
                <th colspan="2">IMPROCEDENTE</th>
                <th>POR DETERMINAR</th>
              </tr>
              <tr>
                <td colspan="2" style="text-align:center">&nbsp;</td>
                <td colspan="2" style="text-align:center">&nbsp;</td>
                <td style="text-align:center">&nbsp;</td>
              </tr>
              <tr>
                <th colspan="5">PARA CUALQUIER CASO, FUNDAMENTO:</th>
              </tr>
              <tr>
                <td colspan="5" style="text-align:center">&nbsp;</td>
              </tr>
              <tr>
                <th colspan="5">RESERVA RECOMENDADA</th>
              </tr>
              <tr>
                <th colspan="2">SUMA ASEGURADA</th>
                <th>ESTIMACI&Oacute;N ASEGURADA</th>
                <th>IMPORTE RECLAMADO</th>
                <th>RESERVA RECOMENDADA</th>
              </tr>
              <tr>
                <td colspan="2" style="text-align:center">&nbsp;</td>
                <td style="text-align:center">&nbsp;</td>
                <td style="text-align:center">&nbsp;</td>
                <td style="text-align:center">&nbsp;</td>
              </tr>
              <tr>
                <th colspan="5">OBSERVACIONES</th>
              </tr>
            </tbody>
          </table>

          Observaciones: 

        </textarea>
        
        <label class="mt-4 pt-2" for="horas" >Horas: </label>
        <input class="mt-4 input form-input input-form" placeholder=" para bitácora" type="number" step=".5" id="horasIP" name="horas" required>
        <input class="mt-4 input form-input input-form" placeholder="Comentario para bitácora (opcional)" type="text" id="textIP" name="bitacora" >
        
        </div>`;/* 
        <label class="mt-4 pt-2" for="horas" >MATERIA: </label>
        <input class="mt-4 input form-input input-form" placeholder=" materia" type="text" id="materia" name="materiaIP" required>
        <label class="mt-4 pt-2" for="horas" >EXPEDIENTE: </label>
        <input class="mt-4 input form-input input-form" placeholder=" Número" type="text" id="expediente" name="expedienteIP" required>
         */

    let html_ = `<label>ID : </label> <b> `+folio+`</b>`;
    html_ = html_ + selInput;
    Swal.fire({
        width:'50%',
        confirmButtonColor: 'var(--color-dark)',
        denyButtonColor: 'var(--color-blanco)',
        cancelButtonColor: 'var(--fondo-degradado)',

        title: 'Informe Preliminar: '+getAreaNamebyId(area)['area'],
        html: html_,
        confirmButtonText: 'Guardar',
        showCancelButton: true,
        cancelButtonText: 'Salir',
        focusConfirm: false,
        allowOutsideClick:false,
        didOpen: () => {
          //Swal.showLoading(); coloca color azul a la tabla, solo en swetalert, no pasa a formato pdf
          setTimeout(() => {
            let numFrame= (window.frames.length) - 1;

            window.frames[0].document.querySelectorAll(".anexoTabla tr th").forEach(th => {
              th.style.background = "#7de8ff";
            });
            
          }, 500);

        },
        preConfirm: () => {
           /*  window.frames[0].document.querySelector(".anexoTabla tr:nth-child(1) th:nth-child(1)").classList.add('col1table');
            window.frames[0].document.querySelector(".anexoTabla tr:nth-child(1) th:nth-child(2)").classList.add('col2table');
            window.frames[0].document.querySelector(".anexoTabla tr:nth-child(1) th:nth-child(3)").classList.add('col1table');
            window.frames[0].document.querySelector(".anexoTabla tr:nth-child(1) th:nth-child(1)").setAttribute('width', '205');
            window.frames[0].document.querySelector(".anexoTabla tr:nth-child(1) th:nth-child(2)").setAttribute('width', '330');
            window.frames[0].document.querySelector(".anexoTabla tr:nth-child(1) th:nth-child(3)").setAttribute('width', '205');
            window.frames[0].document.querySelector(".anexoTablaDos tr:nth-child(1) th").setAttribute('width', '205');
            window.frames[0].document.querySelector(".anexoTablaDos tr:nth-child(1) td").setAttribute('width', '535'); */

            const informePreliminar = CKEDITOR.instances['informePreliminar'].getData();
            const horas = Swal.getPopup().querySelector('#horasIP[name=horas]').value;
            const bitacora = Swal.getPopup().querySelector('#textIP[name=bitacora]').value;
            // const materia = Swal.getPopup().querySelector('#materiaIP[name=materia]').value;
            // const expediente = Swal.getPopup().querySelector('#materiaIP[name=expediente]').value;

            // if (!materia)
            // Swal.showValidationMessage(`Escribe materia`);
            
            // if (!expediente)
            // Swal.showValidationMessage(`Escribe el expediente`);
            
            if (!horas)
            Swal.showValidationMessage(`Selecciona un rango de horas`);

            return { informePreliminar, timerst,folio,areaID:area,horas,bitacora}
        }
        
    })
    .then((cambios) => {
        //alert("archivo cargado!!");
        //?cuando ya está OK
        if (cambios.isConfirmed){
            $.ajax({
                url: "./?action=siniestro/informePreliminar&guardar=informePreliminar",
                method: "POST",
                data: {'data':cambios.value} ,
                success: function(respuesta) {
                    // dataset = JSON.parse(respuesta);
                     console.log(respuesta);
                    Swal.fire(`
                        Se guardó el Informe Preliminar
                    `.trim()).then(()=>{
                        location.reload();
                    })
                },
                error:{ function(e) {  conjsole.log(e);  }  }
            });
        }
    });
}

</script>
