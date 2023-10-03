<?php ?>

<script>
console.log('hokhojhlkjhl kjhikhkuh kuh ig hih ');

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
    // console.log(areaID);
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
                      </div>`;
                    //bitacora desactivada
                    // <label class="mt-4 pt-2" for="horas" >Horas: </label>
                    // <input class="mt-4 input form-input input-form" placeholder=" para bitácora" type="number" step=".5" id="horasIP" name="horas" required>
                    // <input class="mt-4 input form-input input-form" placeholder="Comentario para bitácora (opcional)" type="text" id="textIP" name="bitacora">
                    
        Swal.fire({
            width:'50%',
            confirmButtonColor: '#988763',
            denyButtonColor: '#988763',
            cancelButtonColor: '#988763',
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
                const horas = 0;  // Swal.getPopup().querySelector('#horasIP[name=horas]').value;
                const bitacora = ''; //Swal.getPopup().querySelector('#textIP[name=bitacora]').value;
                const timerst = "<?=$sn['timerst']?>";
                const folio = "<?=$sn['folio']?>";


                if (informePreliminar == html_)
                Swal.showValidationMessage(`No puedes dejar el texto igual`);
                
                // if (!horas)
                // Swal.showValidationMessage(`Selecciona un rango de horas`);
              
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
                        // informePreliminarSegundaParte(area,timerst,calificacion,folio,nombre,numReporte,fechaReporte,vigencia1,vigencia2,fechaAsignacion,fechaCaptura,institucion,autoridad,telefonos,email,formaContacto,poliza);
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
function informePreliminar(area,timerst){

  let calificacion = SiniestroID.calificacion;
  let folio = SiniestroID.folio;
  let nombre = SiniestroID.nombre+' '+SiniestroID.apellidoP+' '+SiniestroID.apellidoM;
  let numReporte = SiniestroID.numReporte;
  let fechaReporte = SiniestroID.fechaReporte;
  let vigencia1 = SiniestroID.vigencia1;
  let vigencia2 = SiniestroID.vigencia2;
  let fechaAsignacion = SiniestroID.fechaAsignacion;
  let fechaCaptura = SiniestroID.fechaCaptura;
  let institucion = SiniestroID.institucion;
  let autoridad = SiniestroID.autoridad;
  let telefonos = SiniestroID.telefonos;
  let email = SiniestroID.email;
  let formaContacto = SiniestroID.formaContacto;
  let poliza = SiniestroID.poliza;
  let numExpediente = SiniestroID.numExpediente;
  let fechaReporteF = SiniestroID.fechaReporteF;
  let vigencia1F = SiniestroID.vigencia1F;
  let vigencia2F = SiniestroID.vigencia2F;
  let fechaAsignacionF = SiniestroID.fechaAsignacionF;
  let fechaCapturaF = SiniestroID.fechaCapturaF;
  let ciudad = SiniestroID.ciudad;
  


  
  

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



    }, 400);

      //swert alert para editar el proveedor o proveniente
      //FORMATO DE INFORME PRELIMINAR
      let selInput = `
        <div class="input-group">
          <div class="input-group-prepend">
          <!-- <span class="input-group-text">With textarea </span> -->
          </div>
          <textarea placeholder="" id="informePreliminar" name="informePreliminar">
          <br><br>
          <p style="text-align:justify">Fecha de Asignaci&oacute;n::`+fechaAsignacion+`<br />
          <strong>Lic. Luis Alberto Mart&iacute;nez Garc&iacute;a &nbsp; &nbsp; &nbsp; &nbsp;/ &nbsp;&nbsp;&nbsp;&nbsp; Lic. Mario Aguilar Guajardo.</strong><br />
          <strong>ASUNTO: Informe Preliminar.<br />
          REPORTE:  `+numReporte+`</strong><br />
          Creado el: `+fechaCaptura+`<br />
          I.D.: `+folio+`<br />
          Asegurado: `+nombre+`</p>

          <p style="text-align:justify">&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Adjunto al presente env&iacute;o el informe preliminar correspondiente al asegurado &nbsp;&nbsp; &nbsp; <strong> &nbsp; `+nombre+`</strong>, mismo que se realiz&oacute; con base a la informaci&oacute;n y documentaci&oacute;n suministrada por este &uacute;ltimo, el cual en opini&oacute;n de esta firma legal es&nbsp; &nbsp; &nbsp; <strong>  &nbsp; `+calificacion+` </strong>, de que se le proporcione la asistencia legal requerida, salvo instrucciones en contrario, por lo que someto a su consideraci&oacute;n la procedencia del mismo, solicit&aacute;ndole se sirva proporcionando el n&uacute;mero de siniestro que le corresponda al mismo, para los efectos y tr&aacute;mites conducentes.</p>

          <p style="text-align:justify">Agradeciendo su atenci&oacute;n, me reitero a sus &oacute;rdenes para cualquier duda o aclaraci&oacute;n.</p>

          <p style="text-align:justify"><strong>ATENTAMENTE:<br />
          <?php echo $_SESSION['nombre'].' '.$_SESSION['paterno'].' '.$_SESSION['materno'] ?>.</strong></p>

          <p>Email:</p>

          <p>Anexos:</p>
          </textarea>
        </div>
        `;
        /* BITACORA DESACTIVADA */
        /* <label class="mt-4 pt-2" for="horas" >Horas: </label>
        <div style="page-break-after:always"><span style="display:none">&nbsp;</span></div>
        <input class="mt-4 input form-input input-form" placeholder=" para bitácora" type="number" step=".5" id="horasIP" name="horas" required>
        <input class="mt-4 input form-input input-form" placeholder="Comentario para bitácora (opcional)" type="text" id="textIP" name="bitacora" > */

    let html_ = `<label>ID : </label> <b> `+folio+`</b>`;
    html_ = html_ + selInput;
    Swal.fire({
        width:'50%',
        confirmButtonColor: '#988763',
        denyButtonColor: '#988763',
        cancelButtonColor: '#988763',

        title: 'Informe Preliminar: '+getAreaNamebyId(area)['area'],
        html: html_,
        confirmButtonText: 'Continuar',
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
            const horas = 0;  //Swal.getPopup().querySelector('#horasIP[name=horas]').value;
            const bitacora = '';  //Swal.getPopup().querySelector('#textIP[name=bitacora]').value;
            // const materia = Swal.getPopup().querySelector('#materiaIP[name=materia]').value;
            // const expediente = Swal.getPopup().querySelector('#materiaIP[name=expediente]').value;

            // if (!materia)
            // Swal.showValidationMessage(`Escribe materia`);
            
            // if (!expediente)
            // Swal.showValidationMessage(`Escribe el expediente`);
            
            // if (!horas)
            // Swal.showValidationMessage(`Selecciona un rango de horas`);

            return { informePreliminar, timerst,folio,areaID:area,horas,bitacora}
        }
        
    })
    .then((cambios) => {
        //alert("archivo cargado!!");
        //?cuando ya está OK
        if (cambios.isConfirmed){
            $.ajax({
                url: "./?action=siniestro/informePreliminar&guardar=informePreliminar",
                // url: "./?action=siniestro/informePreliminar&remplace=informePreliminar",
                method: "POST",
                data: {'data':cambios.value} ,
                success: function(respuesta) {
                    // dataset = JSON.parse(respuesta);
                     console.log(respuesta);
                     informePreliminarSegundaParte(area,timerst,calificacion,folio,nombre,numReporte,fechaReporte,vigencia1,vigencia2,fechaAsignacion,fechaCaptura,institucion,autoridad,telefonos,email,formaContacto,poliza,numExpediente,fechaReporteF,vigencia1F,vigencia2F,fechaAsignacionF,fechaCapturaF);
                    /* Swal.fire(`
                        Se guardó el Informe Preliminar
                    `.trim()).then((response2)=>{

                      if(response2.isConfirmed){
                        //* Ejecuta funcion para continuar segunda parte del preliminar.
                        informePreliminarSegundaParte(area,timerst,calificacion,folio,nombre,numReporte,fechaReporte,vigencia1,vigencia2,fechaAsignacion,fechaCaptura,institucion,autoridad,telefonos,email,formaContacto,poliza);
                      }
                      else{
                        location.reload();
                      }
                    }) */
                },
                error:{ function(e) {  conjsole.log(e);  }  }
            });
        }else{
          window.location.reload();
        }
    });
}

dataSP = 'nulo';
function informePreliminarSegundaParte(area,timerst){
  let calificacion = SiniestroID.calificacion;
  let folio = SiniestroID.folio;
  let nombre = SiniestroID.nombre+' '+SiniestroID.apellidoP+' '+SiniestroID.apellidoM;
  let numReporte = SiniestroID.numReporte;
  let fechaReporte = SiniestroID.fechaReporte;
  let vigencia1 = SiniestroID.vigencia1;
  let vigencia2 = SiniestroID.vigencia2;
  let fechaAsignacion = SiniestroID.fechaAsignacion;
  let fechaCaptura = SiniestroID.fechaCaptura;
  let institucion= SiniestroID.institucion;
  let autoridad= SiniestroID.autoridad;
  let telefonos = SiniestroID.telefonos;
  let email = SiniestroID.email;
  let formaContacto = SiniestroID.formaContacto;
  let poliza = SiniestroID.poliza;
  let numExpediente = SiniestroID.numExpediente;
  let fechaReporteF = SiniestroID.fechaReporteF;
  let vigencia1F = SiniestroID.vigencia1F;
  let vigencia2F = SiniestroID.vigencia2F;
  let fechaAsignacionF = SiniestroID.fechaAsignacionF;
  let fechaCapturaF = SiniestroID.fechaCapturaF;
  let FaF = getAreaNamebyId(area);
 
  let nombreArea = FaF.area.replace(/ /g, ""); //quitando espacios en string
  
  $.ajax({
      url: "./?action=siniestro/informePreliminar&rellenaForm=informePreliminar",
      // url: "./?action=siniestro/informePreliminar&remplace=informePreliminar",
      method: "POST",
      data: {timerst,area,folio} ,
      success: function(respuesta) {
          dataset = JSON.parse(respuesta);

          if(dataset.modo == 'preliminar form'){
            // console.log('cargando ajax form.');
            dataSP = dataset.data;

            formD = `
                  <form id="formPreliminar">
                    <div class="form-group row">
                      <label for="ramo" class="col-sm-4 col-form-label">Ramo</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="ramo" id="ramo" placeholder="" value="`+(dataSP.ramo?dataSP.ramo:' ') +`" >
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="subramo" class="col-sm-4 col-form-label">Sub Ramo</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="subramo" id="subramo" placeholder="" value="`+(dataSP.subramo??' ')+`" >
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="noPoliza" class="col-sm-4 col-form-label">Póliza</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="noPoliza" id="noPoliza" placeholder="" value="`+poliza+`" readonly>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="asegurado" class="col-sm-4 col-form-label">Asegurado</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="asegurado" id="asegurado" placeholder="Nombre Completo" value="`+nombre+`" readonly>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="fechaOcurrido" class="col-sm-4 col-form-label">Fecha Ocurrido</label>
                      <div class="col-sm-8">
                        <input type="date" class="form-control" name="fechaOcurrido" id="fechaOcurrido" placeholder="Nombre Completo" value="`+dataSP.fechaOcurrido+`">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="tercero" class="col-sm-4 col-form-label">Tercero</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="tercero" id="tercero" placeholder="" value="`+dataSP.tercero+`">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="causa" class="col-sm-4 col-form-label">Causa</label>
                      <div class="col-sm-8">
                        <textarea type="text" rows="5" class="form-control" name="causa" id="causa" placeholder="" style="background: #e3e3e3 !important;margin-bottom: 1.5em;"> `+dataSP.causa+`</textarea>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="lugar" class="col-sm-4 col-form-label">Lugar</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="lugar" id="lugar" placeholder="" value="`+dataSP.lugar+`">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="ciudad" class="col-sm-4 col-form-label">Ciudad</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="ciudad" id="ciudad" placeholder="" value="`+dataSP.ciudad+`">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="agente" class="col-sm-4 col-form-label">Agente</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="agente" id="agente" placeholder="" value="`+dataSP.agente+`">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="practica" class="col-sm-4 col-form-label">Practica</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="practica" id="practica" placeholder="" value="`+dataSP.practica+`">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="vigenciaInicio" class="col-sm-4 col-form-label">Vigencia Inicio</label>
                      <div class="col-sm-8">
                        <input type="date" class="form-control" name="vigenciaInicio" id="vigenciaInicio" placeholder="`+dataSP.vigenciaInicio+`" value="`+dataSP.vigenciaInicio+`">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="vigenciaFin" class="col-sm-4 col-form-label">Vigencia Fin</label>
                      <div class="col-sm-8">
                        <input type="date" pattern="\d{4}-\d{2}-\d{2}" class="form-control" name="vigenciaFin" id="vigenciaFin" placeholder="`+dataSP.vigenciaFin+`" value="`+dataSP.vigenciaFin+`">
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="fechaReporte" class="col-sm-4 col-form-label">Fecha Reporte</label>
                      <div class="d-flex col-sm-8" style="height: fit-content;">
                        <input type="date" class="form-control" name="fechaReporte" id="fechaReporte" placeholder="`+SiniestroID.fechaReporte+`" value="`+(SiniestroID.fechaReporte.split(' ')[0])+`" readonly>
                        <input type="time" class="ml-1 form-control" name="horaReporte" id="horaReporte" placeholder="`+SiniestroID.fechaReporte+`" value="`+(SiniestroID.fechaReporte.split(' ')[1])+`" readonly>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="fechaAsignacion" class="col-sm-4 col-form-label">Fecha Asignación</label>
                      <div class="d-flex col-sm-8" style="height: fit-content;">
                        <input type="date" class="form-control" name="fechaAsignacion" id="fechaAsignacion" placeholder="" value="`+(SiniestroID.fechaAsignacion.split(' ')[0])+`"  readonly>
                        <input type="time" class="ml-1 form-control" name="horaAsignacion" id="horaAsignacion" placeholder="" value="`+(SiniestroID.fechaAsignacion.split(' ')[1])+`"  readonly>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="fecha1raAtencion" class="col-sm-4 col-form-label">Fecha 1ra Atención</label>
                      <div class="d-flex col-sm-8" style="height: fit-content;">
                        <input type="date" class="form-control" name="fecha1raAtencion" id="fecha1raAtencion" placeholder="" value="`+(dataSP.fecha1raAtencion.split(' ')[0])+`" >
                        <input type="time" class="ml-1 form-control" name="hora1raAtencion" id="hora1raAtencion" placeholder="" value="`+(dataSP.fecha1raAtencion.split(' ')[1])+`" >
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="autoridad" class="col-sm-4 col-form-label">Autoridad</label>
                      <div class="col-sm-8">
                        <input type="text" readonly class="form-control" name="autoridad" id="autoridad" placeholder="" value="`+autoridad+`" readonly>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="noExpediente" class="col-sm-4 col-form-label">N° Expediente</label>
                      <div class="col-sm-8">
                        <input type="text"  class="form-control" name="noExpediente" id="noExpediente" placeholder="" value="`+dataSP.noExpediente+`" >
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="etapa" class="col-sm-4 col-form-label">Etapa</label>
                      <div class="col-sm-8">
                        <input type="text"  class="form-control" name="etapa" id="etapa" placeholder="" value="`+dataSP.etapa+`" >
                      </div>
                    </div>

                    <div class="form-group row">
                    <div class="col-sm-12">
                        <textarea placeholder="" id="preliminarHechos" name="preliminarHechos" > `+dataSP.hechos+` <p style="text-align:justify">  </p> </textarea>
                        <br>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="causaProxima" class="col-sm-4 col-form-label">Causa Próxima</label>
                      <div class="col-sm-8">
                        <textarea type="text" rows="5" class="form-control" name="causaProxima" id="causaProxima" placeholder="" style="background: #e3e3e3 !important;margin-bottom: 1.5em;"> `+dataSP.causaProxima+`</textarea>

                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="reclamacion" class="col-sm-4 col-form-label">Reclamación</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="reclamacion" id="reclamacion" placeholder="" value="`+dataSP.reclamacion+`" >
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="fundamento" class="col-sm-4 col-form-label">Fundamento</label>
                      <div class="col-sm-8">
                        <textarea type="text" rows="5" class="form-control" name="fundamento" id="fundamento" placeholder="" style="background: #e3e3e3 !important;margin-bottom: 1.5em;" > `+dataSP.fundamento+`</textarea>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="sumAsegurada" class="col-sm-4 col-form-label">Suma Asegurada</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="sumAsegurada" id="sumAsegurada" placeholder="" value="`+dataSP.sumAsegurada+`" >
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="estimacion" class="col-sm-4 col-form-label">Estimación</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="estimacion" id="estimacion" placeholder="" value="`+dataSP.estimacion+`" >
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="importeReclamado" class="col-sm-4 col-form-label">Importe Reclamado</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="importeReclamado" id="importeReclamado" placeholder="" value="`+dataSP.importeReclamado+`" >
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="reservaRecomendada" class="col-sm-4 col-form-label">Reserva Recomendada</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="reservaRecomendada" id="reservaRecomendada" placeholder="" value="`+dataSP.reservaRecomendada+`" >
                      </div>
                    </div>

                    <div class="form-group row">
                    <div class="col-sm-12">
                        <textarea placeholder="" id="preliminarObservaciones" name="preliminarObservaciones"> `+dataSP.observaciones+`  <p style="text-align:justify"> </p></textarea>
                      </div>
                    </div>
                    



                  </form>
            `;
            console.log("intermedio!!!!");
          }
          else if(dataset.modo == 'primer formato'){
            let fechaPA = '';
            let horaPA = '';
            // console.log(SiniestroID[nombreArea].primeratencion);
            if (SiniestroID[nombreArea].primeratencion.fecha_creacion){ fechaPA= SiniestroID[nombreArea].primeratencion.fecha_creacion.split(' ')[0];}
            if (SiniestroID[nombreArea].primeratencion.fecha_creacion){ horaPA= SiniestroID[nombreArea].primeratencion.fecha_creacion.split(' ')[1];}
            formD = `
                <form id="formPreliminar">
                    <div class="form-group row">
                      <label for="noPoliza" class="col-sm-4 col-form-label">Ramo</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="ramo" id="Ramo" placeholder="" value="" >
                      </div>
                    </div>
                    <div class="form-group row">
                      <label for="noPoliza" class="col-sm-4 col-form-label">Sub Ramo</label>
                      <div class="col-sm-8">
                        <input type="text" class="form-control" name="subramo" id="noPoliza" placeholder="" value="" >
                      </div>
                    </div>

                  <div class="form-group row">
                    <label for="noPoliza" class="col-sm-4 col-form-label">Póliza</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="noPoliza" id="noPoliza" placeholder="" value="`+poliza+`" readonly>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="asegurado" class="col-sm-4 col-form-label">Asegurado</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="asegurado" id="asegurado" placeholder="Nombre Completo" value="`+nombre+`" readonly>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="fechaOcurrido" class="col-sm-4 col-form-label">Fecha Ocurrido</label>
                    <div class="col-sm-8">
                      <input type="date" class="form-control" name="fechaOcurrido" id="fechaOcurrido" placeholder="Nombre Completo" value="">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="tercero" class="col-sm-4 col-form-label">Tercero</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="tercero" id="tercero" placeholder="" value="">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="causa" class="col-sm-4 col-form-label">Causa</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="causa" id="causa" placeholder="" value="">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="lugar" class="col-sm-4 col-form-label">Lugar</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="lugar" id="lugar" placeholder="" value="">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="ciudad" class="col-sm-4 col-form-label">Ciudad</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="ciudad" id="ciudad" placeholder="" value="">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="agente" class="col-sm-4 col-form-label">Agente</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="agente" id="agente" placeholder="" value="">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="practica" class="col-sm-4 col-form-label">Practica</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="practica" id="practica" placeholder="" value="">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="vigenciaInicio" class="col-sm-4 col-form-label">Vigencia Inicio</label>
                    <div class="col-sm-8">
                      <input type="date" class="form-control" name="vigenciaInicio" id="vigenciaInicio" placeholder="`+vigencia1+`" value="`+vigencia1+`">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="vigenciaFin" class="col-sm-4 col-form-label">Vigencia Fin</label>
                    <div class="col-sm-8">
                      <input type="date" pattern="\d{4}-\d{2}-\d{2}" class="form-control" name="vigenciaFin" id="vigenciaFin" placeholder="`+vigencia2+`" value="`+vigencia2+`">
                    </div>
                  </div>

                  <div class="form-group row">
                      <label for="fechaReporte" class="col-sm-4 col-form-label">Fecha Reporte</label>
                      <div class="d-flex col-sm-8" style="height: fit-content;">
                        <input type="date" class="form-control" name="fechaReporte" id="fechaReporte" placeholder="`+fechaReporte+`" value="`+(SiniestroID.fechaReporte.split(' ')[0])+`" readonly>
                        <input type="time" class="ml-1 form-control" name="horaReporte" id="horaReporte" placeholder="`+fechaReporte+`" value="`+(SiniestroID.fechaReporte.split(' ')[1])+`" readonly>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="fechaAsignacion" class="col-sm-4 col-form-label">Fecha Asignación</label>
                      <div class="d-flex col-sm-8" style="height: fit-content;">
                        <input type="date" class="form-control" name="fechaAsignacion" id="fechaAsignacion" placeholder="" value="`+(SiniestroID.fechaAsignacion.split(' ')[0])+`" readonly>
                        <input type="time" class="ml-1 form-control" name="horaAsignacion" id="horaAsignacion" placeholder="" value="`+(SiniestroID.fechaAsignacion.split(' ')[1])+`" readonly>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label for="fecha1raAtencion" class="col-sm-4 col-form-label">Fecha 1ra Atención</label>
                      <div class="d-flex col-sm-8" style="height: fit-content;">
                        <input type="date" class="form-control" name="fecha1raAtencion" id="fecha1raAtencion" placeholder="" value="`+(fechaPA??' ')+`" >
                        <input type="time" class="ml-1 form-control" name="hora1raAtencion" id="hora1raAtencion" placeholder="" value="`+(horaPA??' ')+`" >
                      </div>
                    </div>

                  <div class="form-group row">
                    <label for="autoridad" class="col-sm-4 col-form-label">Autoridad</label>
                    <div class="col-sm-8">
                      <input type="text" readonly class="form-control" name="autoridad" id="autoridad" placeholder="" value="`+autoridad+`" readonly>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="noExpediente" class="col-sm-4 col-form-label">N° Expediente</label>
                    <div class="col-sm-8">
                      <input type="text"  class="form-control" name="noExpediente" id="noExpediente" placeholder="" value="`+(numExpediente??'')+`">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="etapa" class="col-sm-4 col-form-label">Etapa</label>
                    <div class="col-sm-8">
                      <input type="text"  class="form-control" name="etapa" id="etapa" placeholder="" value="">
                    </div>
                  </div>

                  <div class="form-group row">
                  <div class="col-sm-12">
                      <textarea placeholder="" id="preliminarHechos" name="preliminarHechos"><p style="text-align:justify">Descripción de los hechos: </p></textarea>
                      <br>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="causaProxima" class="col-sm-4 col-form-label">Causa Próxima</label>
                    <div class="col-sm-8">
                      <textarea type="text" rows="5" class="form-control" name="causaProxima" id="causaProxima" placeholder="" style="background: #e3e3e3 !important;margin-bottom: 1.5em;"> </textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="reclamacion" class="col-sm-4 col-form-label">Reclamación</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="reclamacion" id="reclamacion" placeholder="" value="">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="fundamento" class="col-sm-4 col-form-label">Fundamento</label>
                    <div class="col-sm-8">
                      <textarea type="text" rows="5" class="form-control" name="fundamento" id="fundamento" placeholder="" style="background: #e3e3e3 !important;margin-bottom: 1.5em;" > </textarea>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="sumAsegurada" class="col-sm-4 col-form-label">Suma Asegurada</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="sumAsegurada" id="sumAsegurada" placeholder="" value="">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="estimacion" class="col-sm-4 col-form-label">Estimación</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="estimacion" id="estimacion" placeholder="" value="">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="importeReclamado" class="col-sm-4 col-form-label">Importe Reclamado</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="importeReclamado" id="importeReclamado" placeholder="" value="">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="reservaRecomendada" class="col-sm-4 col-form-label">Reserva Recomendada</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" name="reservaRecomendada" id="reservaRecomendada" placeholder="" value="">
                    </div>
                  </div>

                  <div class="form-group row">
                  <div class="col-sm-12">
                      <textarea placeholder="" id="preliminarObservaciones" name="preliminarObservaciones"> <p style="text-align:justify">Observaciones: </p></textarea>
                    </div>
                  </div>              
                </form>
                `;
          }

          //*inicia el swetalet
          Swal.fire({
              width:'50%',
              confirmButtonColor: '#988763',
              denyButtonColor: '#988763',
              cancelButtonColor: '#988763',

              title: 'Informe Preliminar GMX: '+getAreaNamebyId(area)['area'],
              html: formD,
              confirmButtonText: 'Guardar',
              showCancelButton: true,
              cancelButtonText: 'Salir',
              focusConfirm: false,
              allowOutsideClick:false,
              didOpen: () => {
                //Swal.showLoading(); coloca color azul a la tabla, solo en swetalert, no pasa a formato pdf
                setTimeout(() => {
                  CKEDITOR.replace( 'preliminarHechos',{
                      width:'99%',
                      uiColor: '#ede6c6',
                      editorplaceholder: 'preliminarHechos ',
                  });

                  CKEDITOR.replace( 'preliminarObservaciones',{
                      width:'99%',
                      uiColor: '#ede6c6',
                      editorplaceholder: 'preliminarObservaciones ',
                  });
                }, 100);

              },
              preConfirm: () => {
                if (!document.querySelector('#formPreliminar').reportValidity())
                  Swal.showValidationMessage(`Todos los campos son obligatorios`);


                  const preliminarHechos = CKEDITOR.instances['preliminarHechos'].getData();
                  const preliminarObservaciones = CKEDITOR.instances['preliminarObservaciones'].getData();
                  const form =$('#formPreliminar').serialize();

                  if (!preliminarHechos)
                  Swal.showValidationMessage(`Todos los campos son obligatorios`);

                  if (!preliminarObservaciones)
                  Swal.showValidationMessage(`Todos los campos son obligatorios`);


                  return { preliminarHechos, preliminarObservaciones, timerst,folio,areaID:area ,form }
              }
          }) .then((btnPush)=>{
              if(btnPush.isDismissed){window.location.reload();}
              if(btnPush.isConfirmed){
                //push ok se envia el formulario 
                $.ajax({
                          url: "./?action=siniestro/informePreliminar&segundaParte=informePreliminar",
                          // url: "./?action=siniestro/informePreliminar&remplace=informePreliminar",
                          method: "POST",
                          data: {'data':btnPush.value} ,
                          success: function(respuesta) {
                              debugger;
                              // dataset = JSON.parse(respuesta);
                              console.log(respuesta);
                                window.location.reload();
                              /* Swal.fire(`
                                  Se guardó el Informe Preliminar
                              `.trim()).then((response2)=>{
                                if(response2.isConfirmed){
                                  //* Ejecuta funcion para continuar segunda parte del preliminar.
                                  informePreliminarSegundaParte(area,timerst,calificacion,folio,nombre,numReporte,fechaReporte,vigencia1,vigencia2,fechaAsignacion,fechaCaptura,institucion,autoridad,telefonos,email,formaContacto,poliza);
                                }
                                else{
                                  location.reload();
                                }
                              }) */
                          },
                          error:{ function(e) {  conjsole.log(e);  }  }
                });
              }
              else{
                window.location.reload();
              }
          })
      //fin swalert

      },
      error: (XMLHttpRequest, textStatus, errorThrown)=>{
        console.log(XMLHttpRequest);
        console.log(textStatus);
        console.log(errorThrown);
        console.log('en caso de error');
           
      }
  });
 

    /// segundo formD donde carga datos del preliminar anterior
    console.log("LLENANDO EL FORMULARIO!!!!");

  
}

</script>


<style>
  #formPreliminar * :not(i){
    font-size: .9em;
  }

  #formPreliminar input{
    background: #80808038 !important;
  }

  #formPreliminar .form-group.row{
    margin-bottom: 0px !important;
  }

  .swal2-html-container{
    overflow-x: hidden !important;
  }

</style>