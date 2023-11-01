<?php ?>

<script>

function informeActualizacionLINK(area,fullArea,areaID){
    const txt = SiniestroID[area].informeActualizacion.informe_actualizacion;


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
    // console.log(textFile);

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

//INFORME ACTUALIZACIÓN EDITAR
function informeActualizacionEDITAR(area,fullArea,areaID){
      // elimina la hora de la fecha en los siguientes: 
      /* fechaAsignacion =   fechaAsignacion.split(" ")[0]
      fechaCaptura =      fechaCaptura.split(" ")[0]
      fechaReporte =      fechaReporte.split(" ")[0] */
      //retarda el CKEDITOR 200 ms
      console.log(timerst);
      setTimeout(() => {
          CKEDITOR.replace( 'informeActualizacionEDITAR',{
              width:'100%',
              uiColor: '#ede6c6',
              editorplaceholder: 'informeActualizacionEDITAR '+fullArea,
          });
          // ckeditor.on('informeActualizacion', function (ck) { ck.editor.on("change", function (e) { var sel = ck.editor.getSelection(); if (sel) { var selected = sel.getStartElement(); if (selected && selected.$) sel.getStartElement().$.normalize(); } }); });
      }, 200);

        //swert alert para editar el proveedor o proveniente
        //FORMATO DE INFORME ACTUALIZACION
        const txt = SiniestroID[area].informeActualizacion.informe_actualizacion;
        const selInput =` <div class="input-group">
          <div class="input-group-prepend">
          <!-- <span class="input-group-text">With textarea </span> -->
          </div>
          <textarea placeholder="" id="informeActualizacionEDITAR" name="informeActualizacion">
          `+txt+`
          </textarea>
            <label class="mt-4 pt-2" for="horas" >Horas: </label>
            <input class="mt-4 input form-input input-form" placeholder=" para bitácora" type="number" step=".5" id="horasIA" name="horas" required>
            <label class="mt-4 pt-2" for="horas" >  Fecha Actividad: </label> &nbsp;&nbsp;
            <input class="mt-4 input form-input input-form" placeholder=" Fecha Actividad" type="date" name="fechaActividad" id="fechaActividadIA"  required> <br>
            <input class="mt-4 input form-input input-form" placeholder="Comentario para bitácora (opcional)" type="text" id="textIA" name="bitacora" style="width=100% !important;">
      
        </div>`;

      Swal.fire({
          width:'50%',
          confirmButtonColor: 'var(--color-dark)',
          denyButtonColor: 'var(--color-blanco)',
          cancelButtonColor: 'var(--fondo-degradado)',

          title: 'Editar Informe Actualización: '+fullArea,
          html: selInput,
          confirmButtonText: 'Guardar',
          showCancelButton: true,
          cancelButtonText: 'Salir',
          focusConfirm: false,
          allowOutsideClick:false,
          preConfirm: () => {
                const informeActualizacion = CKEDITOR.instances['informeActualizacionEDITAR'].getData();
                const horas = Swal.getPopup().querySelector('#horasIA[name=horas]').value;
                const bitacora = Swal.getPopup().querySelector('#textIA[name=bitacora]').value;
                const timerst = "<?=$sn['timerst']?>";
                const folio = "<?=$sn['folio']?>";
                const fechaActividad = Swal.getPopup().querySelector('#fechaActividadIA[name=fechaActividad]').value;


                if (!fechaActividad)
                Swal.showValidationMessage(`Escribe la fecha de la actividad`);

                if (informeActualizacion == txt)
                Swal.showValidationMessage(`No puedes dejar el texto igual`);
                
                if (!horas)
                Swal.showValidationMessage(`Escribe un rango de horas`);

              return { informeActualizacion, timerst,folio,areaID,horas,bitacora,fechaActividad};
          }
          
      })
      .then((cambios) => {
          //?cuando ya está OK
          if (cambios.isConfirmed){
              
              $.ajax({
                  url: "./?action=siniestro/informeActualizacion&guardar=informeActualizacion",
                  method: "POST",
                  data: {'data':cambios.value} ,
                  success: function(respuesta) {
                      // dataset = JSON.parse(respuesta);
                      console.log(respuesta);
                      Swal.fire(`
                          Se editó y guardó el Informe Actualización
                      `.trim()).then(()=>{
                          location.reload();
                      })
                  },
                  error:{ function(e) {  conjsole.log(e);  }  }
              });
          }
      });
}


//INFORME ACTUALIZACIÓN
function informeActualizacion(area,timerst){
      // elimina la hora de la fecha en los siguientes: 
      /* fechaAsignacion =   fechaAsignacion.split(" ")[0]
      fechaCaptura =      fechaCaptura.split(" ")[0]
      fechaReporte =      fechaReporte.split(" ")[0] */
      //retarda el CKEDITOR 200 ms
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
      
      console.log(timerst);
      setTimeout(() => {
          CKEDITOR.replace( 'informeActualizacion',{
              width:'100%',
              uiColor: '#ede6c6',
              editorplaceholder: 'informeActualizacion '+getAreaNamebyId(area)['area'],
          });
          // ckeditor.on('informeActualizacion', function (ck) { ck.editor.on("change", function (e) { var sel = ck.editor.getSelection(); if (sel) { var selected = sel.getStartElement(); if (selected && selected.$) sel.getStartElement().$.normalize(); } }); });
      }, 200);

        //swert alert para editar el proveedor o proveniente
        //FORMATO DE INFORME ACTUALIZACION
        let selInput =` <div class="input-group">
          <div class="input-group-prepend">
          <!-- <span class="input-group-text">With textarea </span> -->
          </div>
          <textarea placeholder="" id="informeActualizacion" name="informeActualizacion">
            <p>Fecha de Asignaci&oacute;n:`+fechaAsignacion+`<br />
            <strong>Lic. Luis Alberto Mart&iacute;nez Garc&iacute;a &nbsp; &nbsp; &nbsp; &nbsp;/ &nbsp;&nbsp;&nbsp;&nbsp; Lic. Mario Aguilar Guajardo.</strong><br />
            <strong>ASUNTO: <b> Informe Actualización.</b><br />
            REPORTE: `+numReporte+`</strong><br />
            Creado el: `+fechaCaptura+`<br />
            I.D.: `+folio+`<br />
            Asegurado: `+nombre+`<br>
            <?= core::getTimeNow() ?>
            </p>

            <p>...</p>

            <p>Agradeciendo su atenci&oacute;n, me reitero a sus &oacute;rdenes para cualquier duda o aclaraci&oacute;n.<br />
            <p><strong>A T E N T A ME N T E:<br />
            <?php echo $_SESSION['nombre'].' '.$_SESSION['paterno'].' '.$_SESSION['materno'] ?>.</strong></p>

          </textarea>
            <label class="mt-4 pt-2" for="horas" >Horas: </label>
            <input class="mt-4 input form-input input-form" placeholder=" para bitácora" type="number" step=".5" id="horasIA" name="horas" required>
            <label class="mt-4 pt-2" for="horas" >  Fecha Actividad: </label> &nbsp;&nbsp;
            <input class="mt-4 input form-input input-form" placeholder=" Fecha Actividad" type="date" name="fechaActividad" id="fechaActividadIA"  required> <br>
            <input class="mt-4 input form-input input-form" placeholder="Comentario para bitácora (opcional)" type="text" id="textIA" name="bitacora" style="width:100% !important;">
      
        </div>`;


      let html_ = `<label>ID : </label> <b> `+folio+`</b>`;
      html_ = html_ + selInput;
      Swal.fire({
          width:'50%',
          confirmButtonColor: 'var(--color-dark)',
          denyButtonColor: 'var(--color-blanco)',
          cancelButtonColor: 'var(--fondo-degradado)',

          title: 'Informe Actualización: '+getAreaNamebyId(area)['area'],
          html: html_,
          confirmButtonText: 'Guardar',
          showCancelButton: true,
          cancelButtonText: 'Salir',
          focusConfirm: false,
          allowOutsideClick:false,
          preConfirm: () => {
                const informeActualizacion = CKEDITOR.instances['informeActualizacion'].getData();
                const horas = Swal.getPopup().querySelector('#horasIA[name=horas]').value;
                const bitacora = Swal.getPopup().querySelector('#textIA[name=bitacora]').value;
                const fechaActividad = Swal.getPopup().querySelector('#fechaActividadIA[name=fechaActividad]').value;

                if (!fechaActividad)
                Swal.showValidationMessage(`Escribe la fecha de la actividad`);

                if (primeraAtencion == html_)
                Swal.showValidationMessage(`No puedes dejar el texto igual`);
                
                if (!horas)
                Swal.showValidationMessage(`Escribe un rango de horas`);

              return { informeActualizacion, timerst,folio,areaID:area,horas,bitacora,fechaActividad}
          }
          
      })
      .then((cambios) => {
          //?cuando ya está OK
          if (cambios.isConfirmed){
              
              $.ajax({
                  url: "./?action=siniestro/informeActualizacion&guardar=informeActualizacion",
                  method: "POST",
                  data: {'data':cambios.value} ,
                  success: function(respuesta) {
                      // dataset = JSON.parse(respuesta);
                      console.log(respuesta);
                      Swal.fire(`
                          Se guardó el Informe Actualización
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
