<?php ?>

<script>

//LINK outlook
function informeCancelacionLINK(area,fullArea,areaID){
    const txt = SiniestroID[area].informeCancelacion.informe_cancelacion;


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

//INFORME CANCELACIÓN EDITAR
function informeCancelacionEDITAR(area,fullArea,areaID){
      // elimina la hora de la fecha en los siguientes: 
      /* fechaAsignacion =   fechaAsignacion.split(" ")[0]
      fechaCaptura =      fechaCaptura.split(" ")[0]
      fechaReporte =      fechaReporte.split(" ")[0] */
      //retarda el CKEDITOR 200 ms
      console.log(timerst);
      setTimeout(() => {
          CKEDITOR.replace( 'informeCancelacionEDITAR',{
              width:'100%',
              uiColor: '#ede6c6',
              editorplaceholder: 'informeCancelacionEDITAR '+fullArea,
          });
          // ckeditor.on('informeCancelacion', function (ck) { ck.editor.on("change", function (e) { var sel = ck.editor.getSelection(); if (sel) { var selected = sel.getStartElement(); if (selected && selected.$) sel.getStartElement().$.normalize(); } }); });
      }, 200);

        //swert alert para editar el proveedor o proveniente
        //FORMATO DE INFORME ACTUALIZACION
        const txt = SiniestroID[area].informeCancelacion.informe_cancelacion;
        const selInput =` <div class="input-group">
          <div class="input-group-prepend">
          <!-- <span class="input-group-text">With textarea </span> -->
          </div>
          <textarea placeholder="" id="informeCancelacionEDITAR" name="informeCancelacion">
          `+txt+`
          </textarea>
            <label class="mt-4 pt-2" for="horas" >Horas: </label>
            <input class="mt-4 input form-input input-form" placeholder=" para bitácora" type="number" step=".5" id="horasIC" name="horas" required>
            <label class="mt-4 pt-2" for="horas" >  Fecha Actividad: </label> &nbsp;&nbsp;
            <input class="mt-4 input form-input input-form" placeholder=" Fecha Actividad" type="date" name="fechaActividad" id="fechaActividadIC"  required> <br>
            <input class="mt-4 input form-input input-form" placeholder="Comentario para bitácora (opcional)" type="text" id="textIC" name="bitacora" style="width:100% !important;">
      
        </div>`;

      Swal.fire({
          width:'50%',
          confirmButtonColor: 'var(--color-blanco)',
          denyButtonColor: 'var(--color-blanco)',
          cancelButtonColor: 'var(--color-blanco)',

          title: 'Editar Informe Cancelación: '+fullArea,
          html: selInput,
          confirmButtonText: 'Guardar',
          showCancelButton: true,
          cancelButtonText: 'Salir',
          focusConfirm: false,
          allowOutsideClick:false,
          preConfirm: () => {
                const informeCancelacion = CKEDITOR.instances['informeCancelacionEDITAR'].getData();
                const horas = Swal.getPopup().querySelector('#horasIC[name=horas]').value;
                const bitacora = Swal.getPopup().querySelector('#textIC[name=bitacora]').value;
                const fechaActividad = Swal.getPopup().querySelector('#fechaActividadIC[name=fechaActividad]').value;
                const timerst = "<?=$sn['timerst']?>";
                const folio = "<?=$sn['folio']?>";

                if (!fechaActividad)
                Swal.showValidationMessage(`Escribe la fecha de la actividad`);

                if (informeCancelacion == txt)
                Swal.showValidationMessage(`No puedes dejar el texto igual`);
                
                if (!horas)
                Swal.showValidationMessage(`Escribe un rango de horas`);

              return { informeCancelacion, timerst,folio,areaID,horas,bitacora,fechaActividad};
          }
          
      })
      .then((cambios) => {
          //?cuando ya está OK
          if (cambios.isConfirmed){
              
              $.ajax({
                  url: "./?action=siniestro/informeCancelacion&guardar=informeCancelacion",
                  method: "POST",
                  data: {'data':cambios.value} ,
                  success: function(respuesta) {
                      // dataset = JSON.parse(respuesta);
                      console.log(respuesta);
                      Swal.fire(`
                          Se editó y guardó el Informe Cancelación
                      `.trim()).then(()=>{
                          location.reload();
                      })
                  },
                  error:{ function(e) {  conjsole.log(e);  }  }
              });
          }
      });
}


//INFORME CANCELACIÓN OK formatter2
function informeCancelacion(area,timerst){
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
  
  // elimina la hora de la fecha en los siguientes: 
  /* fechaAsignacion =   fechaAsignacion.split(" ")[0]
  fechaCaptura =      fechaCaptura.split(" ")[0]
  fechaReporte =      fechaReporte.split(" ")[0] */
  //retarda el CKEDITOR 200 ms
  console.log(timerst);
  setTimeout(() => {
      CKEDITOR.replace( 'inputInformeCancelacion',{
          width:'100%',
          uiColor: '#ede6c6',
          editorplaceholder: 'Informe de Cancelación '+getAreaNamebyId(area)['area'],
      });
  }, 300);
  let nombreCreador= '<?php echo $_SESSION['nombre'].' '.$_SESSION['paterno'].' '.$_SESSION['materno'] ?>';

      //swert alert para editar el proveedor o proveniente
      //FORMATO DE CANCELACIÓN
      let selInput =` <div class="input-group">
        <div class="input-group-prepend">
          <!-- <span class="input-group-text">With textarea </span> -->
        </div>
        <textarea placeholder="" id="inputInformeCancelacion" name="inputInformeCancelacion">
        
        <table align="right" border="0" class="headerboot1" style="border:solid 0px white; width:70%">
          <tbody>
            <tr>
              <th>SINIESTRO:</th>
              <td>3321321231</td>
            </tr>
            <tr>
              <th>ID:</th>
              <td>`+folio+`</td>
            </tr>
            <tr>
              <th>ASEGURADA:</th>
              <td>`+nombre+`</td>
            </tr>
            <tr>
              <th>P&Oacute;LIZA:</th>
              <td>654564</td>
            </tr>
            <tr>
              <th>REPORTE:</th>
              <td>`+numReporte+`</td>
            </tr>
            <tr>
              <th>INSTANCIA:</th>
              <td>`+getAreaNamebyId(area)['area']+` </td>
            </tr>
            <tr>
              <th>ASUNTO:</th>
              <td>INFORME DE CIERRE Y CONCLUSI&Oacute;N DEL SINIESTRO</td>
            </tr>
          </tbody>
        </table>

        <p>&nbsp;</p>

        <table align="center" border="0" cellspacing="0" style="border-collapse:collapse; border:solid 0px white; width:100%">
          <thead>
            <tr>
            <p style="text-align:center">&nbsp;</p>

              <td colspan="2" style="text-align:justify">
              <p style="text-align:justify"><strong>Lic. Luis Alberto Mart&iacute;nez Garc&iacute;a / Lic. Mario Aguilar Guajardo.<br />
              Subgerente de Siniestros<br />
              Grupo Mexicano de Seguros, S. A. de C. V.<br />
              &nbsp;&nbsp;<br /></p>
              <p style="text-align:justify">
              Con relaci&oacute;n al n&uacute;mero de reporte al rubro aludido, por este conducto rindo el informe de cierre y conclusi&oacute;n de las actividades realizadas durante la atenci&oacute;n y seguimiento que se le dio al mismo en los siguientes t&eacute;rminos: </strong></p>
              </td>
            </tr>
            </thead>
            <tbody>
            <tr>
              <td colspan="2">
              <p style="text-align:justify"><strong>HECHOS:</strong> El siniestro fue turnado a esta Firma Legal, toda vez que el Representante Legal de la moral asegurada, inform&oacute; que realizaba su reporte, en virtud de la fractura distal de radio derecho que present&oacute; la se&ntilde;ora Margot Haiat Cohen, a consecuencia de la ca&iacute;da que sufri&oacute; durante los cuidados brindados por la C. Nancy Selena Funes Garc&iacute;a (empleada de la asegurada cuando ocurrieron los hechos motivo del siniestro), en las instalaciones de la residencia Belmont Village Senior Living Santa Fe, solicitando el pago del reembolso de los gastos generados con motivo de honorarios m&eacute;dicos, tratamiento quir&uacute;rgico, medicamentos y hospitalizaci&oacute;n para restablecer la salud de la tercero.</p>
              </td>
            </tr>
            <tr>
              <td colspan="2" style="text-align:justify">
              <p><strong>TR&Aacute;MITE:</strong>&nbsp;</p>

              <ol>
                <li>Se atendi&oacute; reporte de siniestro, para lo cual se estableci&oacute; pl&aacute;tica telef&oacute;nica con el Licenciado Manuel Rosemberg Stillmann, quien dijo ser el apoderado legal de la moral asegurada, a quien se le proporcionaron los datos y n&uacute;meros telef&oacute;nicos de esta Firma Legal, se le requiri&oacute; diversa informaci&oacute;n para la atenci&oacute;n del asunto.</li>
                <li>Se remiti&oacute; al Analista de GMX Seguros, el informe de primera atenci&oacute;n del reporte, solicit&aacute;ndose la p&oacute;liza correspondiente. Se envi&oacute; correo electr&oacute;nico al Licenciado Manuel Rosemberg Stillmann, quien dijo ser apoderado legal de la moral asegurada requiriendo la documentaci&oacute;n necesaria para determinar la procedencia del siniestro.</li>
                <li>Se realiz&oacute; an&aacute;lisis de la P&oacute;liza de Seguro, en sus condiciones particulares y generales, as&iacute; como la documentaci&oacute;n proporcionada por el Licenciado Manuel Rosemberg Stillmann, apoderado legal de la moral asegurada.</li>
                <li>Se envi&oacute; informe preliminar al Analista de Siniestros de Grupo Mexicano de Seguros S. A. de C. V., en calidad de &ldquo;Procedente&rdquo;.</li>
                <li>Se solicit&oacute; autorizaci&oacute;n de pago a GMX Seguros, a fin de proceder al reembolso requerido y de esa forma dar inicio a la elaboraci&oacute;n de los convenios finiquitos correspondientes.</li>
                <li>El Analista de GMX Seguros autoriz&oacute; el pago solicitado, en consecuencia, se elaboraron y enviaron al Licenciado Manuel Rosemberg Stillmann los convenios finiquito a suscribir entre la tercero y Paz Mental S.A.P.I. de C.V., as&iacute; como el diverso a suscribir entre &eacute;sta &uacute;ltima y GMX Seguros.</li>
                <li>Una vez que se obtuvo la firma de los convenios finiquitos y la documentaci&oacute;n pertinente, se solicit&oacute; a GMX Seguros la liberaci&oacute;n del pago a favor de la tercero Margot Haiat Cohen, enviando para tal efecto los instrumentos jur&iacute;dicos suscritos entre las partes, as&iacute; como la documentaci&oacute;n soporte de pago.</li>
                <li>El analista de siniestros inform&oacute; y remiti&oacute; el comprobante bancario en el cual se reflejaba la liberaci&oacute;n del monto solicitado en la cuenta bancaria que se proporcion&oacute; para tal cometido.</li>
              </ol>
              </td>
            </tr>
            </tbody>
        </table>
            <br>

        <p><strong>RESOLUCIONES:</strong></p>

        <p>Ninguna, en virtud de que se llev&oacute; a cabo convenio finiquito con el asegurado.</p>


        <p><strong>&Uacute;ltima actuaci&oacute;n:</strong> Se procede a la conclusi&oacute;n del siniestro al haber suscrito los convenios finiquitos correspondientes, una vez efectuado el reembolso solicitado por la moral asegurada y al corroborar que el monto requerido se reflejaba en la cuenta bancaria de la tercero. Por lo que no existe actividad pendiente que realizar por parte de esta Firma Legal.</p>

        <p>Adjunto al presente remito a Usted el expediente integrado por esta firma de abogados en la atenci&oacute;n y seguimiento del siniestro que nos ocupa; en el que entre otras cosas encontrara el original en 4 tantos del convenio finiquito celebrado entre la tercero y la moral asegurada, as&iacute; como el suscrito entre &eacute;sta &uacute;ltima y GMX Seguros; sin omitir mencionar que no conservaremos copia del mismo.</p>

        <p>Sin otro particular, reitero a Usted las seguridades de mi atenta y distinguida consideraci&oacute;n.</p>


        <p style="text-align:center"><strong>ATENTAMENTE</strong></p>

        <p style="text-align:center">&nbsp;</p>

        <p style="text-align:center"><strong>LIC. JES&Uacute;S CORT&Eacute;S MENA<br />
        DIRECTOR GENERAL<br />
        CORT&Eacute;S MENA ABOGADOS S. C.</strong></p>

        <table align="center" border="0" cellpadding="1" cellspacing="0" id="tableAtt">
          <tbody>
            <tr>
              <td style="text-align:center"><strong>ELABOR&Oacute;</strong></td>
              <td>&nbsp;</td>
              <td style="text-align:center"><strong>SUPERVIS&Oacute;</strong></td>
            </tr>
            <tr>
              <td style="text-align:center">&nbsp;</td>
              <td>&nbsp;</td>
              <td style="text-align:center">&nbsp;</td>
            </tr>
            <tr>
              <td style="text-align:center">&nbsp;</td>
              <td>&nbsp;</td>
              <td style="text-align:center">&nbsp;</td>
            </tr>
            <tr>
              <td style="text-align:center"><strong><?php echo strtoupper($_SESSION['nombre'].' '.$_SESSION['paterno'].' '.$_SESSION['materno']) ?>.</strong></td>
              <td>&nbsp; &nbsp; &nbsp; &nbsp;</td>
              <td style="text-align:center"><strong>LIC. YESSICA YORDANA ROMERO ADUNAS</strong></td>
            </tr>
            <tr>
              <td style="text-align:center"><strong>ABOGADA DEL &Aacute;REA SINIESTROS</strong></td>
              <td>&nbsp;</td>
              <td style="text-align:center"><strong>TITULAR DEL &Aacute;REA PENAL</strong></td>
            </tr>
            <tr>
              <td style="text-align:center"><strong>CORT&Eacute;S MENA ABOGADOS S. C</strong></td>
              <td>&nbsp;</td>
              <td style="text-align:center"><strong>CORT&Eacute;S MENA ABOGADOS S. C.</strong></td>
            </tr>
          </tbody>
        </table>

      </textarea>
        <label class="mt-4 pt-2" for="horas" >Horas: </label>
        <input class="mt-4 input form-input input-form" placeholder=" para bitácora" type="number" step=".5" id="horasIC" name="horas" required>
        <label class="mt-4 pt-2" for="horas" >  Fecha Actividad: </label> &nbsp;&nbsp;
        <input class="mt-4 input form-input input-form" placeholder=" Fecha Actividad" type="date" name="fechaActividad" id="fechaActividadIC"  required> <br>
        <input class="mt-4 input form-input input-form" placeholder="Comentario para bitácora (opcional)" type="text" id="textIC" name="bitacora" style="width:100% !important;">

    </div>`;

    selInput =` <div class="input-group">
        <div class="input-group-prepend">
          <!-- <span class="input-group-text">With textarea </span> -->
        </div>
        <textarea placeholder="" id="inputInformeCancelacion" name="inputInformeCancelacion">
        
        <table align="right" border="0" class="headerboot1" style="border:solid 0px white; width:70%">
          <tbody>
            <tr>
              <th>SINIESTRO:</th>
              <td>3321321231</td>
            </tr>
            <tr>
              <th>ID:</th>
              <td>`+folio+`</td>
            </tr>
            <tr>
              <th>ASEGURADA:</th>
              <td>`+nombre+`</td>
            </tr>
            <tr>
              <th>P&Oacute;LIZA:</th>
              <td>654564</td>
            </tr>
            <tr>
              <th>REPORTE:</th>
              <td>`+numReporte+`</td>
            </tr>
            <tr>
              <th>INSTANCIA:</th>
              <td>`+getAreaNamebyId(area)['area']+` </td>
            </tr>
            <tr>
              <th>ASUNTO:</th>
              <td>INFORME DE CIERRE Y CONCLUSI&Oacute;N DEL SINIESTRO</td>
            </tr>
          </tbody>
        </table>
        
        <p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p>
        Escriba o pegue aquí su texto. 
        

        <p style="text-align:center"><strong></strong></p>

        <p style="text-align:center">&nbsp;</p>

        <p style="text-align:center"><strong><br />
        <br />
        CORT&Eacute;S MENA ABOGADOS S. C.</strong></p>

      </textarea>
        <label class="mt-4 pt-2" for="horas" >Horas: </label>
        <input class="mt-4 input form-input input-form" placeholder=" para bitácora" type="number" step=".5" id="horasIC" name="horas" required>
        <label class="mt-4 pt-2" for="horas" >  Fecha Actividad: </label> &nbsp;&nbsp;
        <input class="mt-4 input form-input input-form" placeholder=" Fecha Actividad" type="date" name="fechaActividad" id="fechaActividadIC"  required> <br>
        <input class="mt-4 input form-input input-form" placeholder="Comentario para bitácora (opcional)" type="text" id="textIC" name="bitacora" style="width:100% !important;">

    </div>`;
    // <td style="text-align:center"><strong>MAGDA MART&Iacute;NEZ TOLEDANO</strong></td>

  let html_ = `<label>ID : </label> <b> `+folio+`</b>`;
  html_ = html_ + selInput;
  Swal.fire({
      width:'50%',
      confirmButtonColor: 'var(--color-blanco)',
      denyButtonColor: 'var(--color-blanco)',
      cancelButtonColor: 'var(--color-blanco)',
      title: 'Informe Cancelación: '+getAreaNamebyId(area)['area'], 
      html: html_,
      confirmButtonText: 'Guardar',
      showCancelButton: true,
      cancelButtonText: 'Salir',
      focusConfirm: false,
      allowOutsideClick:false,
      preConfirm: () => {
          const informeCancelacion = CKEDITOR.instances['inputInformeCancelacion'].getData();
          const horas = Swal.getPopup().querySelector('#horasIC[name=horas]').value;
          const bitacora = Swal.getPopup().querySelector('#textIC[name=bitacora]').value;
          const fechaActividad = Swal.getPopup().querySelector('#fechaActividadIC[name=fechaActividad]').value;

          if (!fechaActividad)
          Swal.showValidationMessage(`Escribe la fecha de la actividad`);

          if (!horas)
          Swal.showValidationMessage(`Selecciona un rango de horas`);

          if (!informeCancelacion)
          Swal.showValidationMessage(`No puedes dejar campos en blanco`);

          return { informeCancelacion, timerst,folio,areaID:area,horas,bitacora,fechaActividad}
      }
      
  })
  .then((cambios) => {
      //alert("archivo cargado!!");
      //?cuando ya está OK
      if (cambios.isConfirmed){
          $.ajax({
              url: "./?action=siniestro/informeCancelacion&guardar=informeCancelacion",
              method: "POST",
              data: {'data':cambios.value} ,
              success: function(respuesta) {
                  // dataset = JSON.parse(respuesta);
                  console.log(respuesta);
                  Swal.fire(`
                      Se guardó la Informe de Cancelación
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
