<?php
header("Content-type: text/html"); 

?>
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
<div class="content">
  <div class="row">
    <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Libreta de direcciones</h4>
          </div>
          <div class="card-body">


          <div id="tablaLibretaDirecciones" class="mt-4"></div>
            <!-- <script src="vistas/plugins/jtable2.4/localization/jquery.jtable.es.js" type="text/javascript"></script> -->
            <script type="text/javascript" defer>
            

            
              
              
            </script>
          </div>
        </div>
    </div>


    <div class="col-md-12">
      <!-- <div class="card">
        <div class="card-header">
          <h4 class="card-title"> Usuarios</h4>
        </div>
        <div class="card-body">
          <div class="table-responsive">
            <table class="table">
              <thead class=" text-primary">
                <th>
                  Name
                </th>
                <th>
                  Country
                </th>
                <th>
                  City
                </th>
                <th class="text-right">
                  Salary
                </th>
              </thead>
              <tbody>
                <tr>
                  <td>
                    Dakota Rice
                  </td>
                  <td>
                    Niger
                  </td>
                  <td>
                    Oud-Turnhout
                  </td>
                  <td class="text-right">
                    $36,738
                  </td>
                </tr>
                <tr>
                  <td>
                    Minerva Hooper
                  </td>
                  <td>
                    Curaçao
                  </td>
                  <td>
                    Sinaai-Waas
                  </td>
                  <td class="text-right">
                    $23,789
                  </td>
                </tr>
                <tr>
                  <td>
                    Sage Rodriguez
                  </td>
                  <td>
                    Netherlands
                  </td>
                  <td>
                    Baileux
                  </td>
                  <td class="text-right">
                    $56,142
                  </td>
                </tr>
                <tr>
                  <td>
                    Philip Chaney
                  </td>
                  <td>
                    Korea, South
                  </td>
                  <td>
                    Overland Park
                  </td>
                  <td class="text-right">
                    $38,735
                  </td>
                </tr>
                <tr>
                  <td>
                    Doris Greene
                  </td>
                  <td>
                    Malawi
                  </td>
                  <td>
                    Feldkirchen in Kärnten
                  </td>
                  <td class="text-right">
                    $63,542
                  </td>
                </tr>
                <tr>
                  <td>
                    Mason Porter
                  </td>
                  <td>
                    Chile
                  </td>
                  <td>
                    Gloucester
                  </td>
                  <td class="text-right">
                    $78,615
                  </td>
                </tr>
                <tr>
                  <td>
                    Jon Porter
                  </td>
                  <td>
                    Portugal
                  </td>
                  <td>
                    Gloucester
                  </td>
                  <td class="text-right">
                    $98,615
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
        -->
    </div>
    <div class="col-md-12">
      
    </div>
  </div>
</div>

<script defer>
  function editarContacto(idlist,email,nombre,empresa,telefono){
      Swal.fire({
      width: 700,
      title: 'Editar '+email,
      html :`
      <form class="swetForm" style="overflow-x:hidden">
        <input type="hidden" class="form-control" id="idlist" name="idlist" value="`+idlist+`">
      
        <div class="form-group row">
          <label for="nombre" class="col-sm-3 col-form-label">Nombre</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre completo" value="`+nombre+`">
          </div>
        </div>
        <div class="form-group row">
          <label for="empresa" class="col-sm-3 col-form-label">Empresa</label>
          <div class="col-sm-9">
            <input type="text" class="form-control" id="empresa" name="empresa" placeholder="Empresa del contacto" value="`+empresa+`">
          </div>
        </div>

        <div class="form-group row">
          <label for="telefono" class="col-sm-3 col-form-label">Teléfono</label>
          <div class="col-sm-9">
            <input type="number" class="form-control" id="telefono" name="telefono" placeholder="Número" value="`+telefono+`">
          </div>
        </div>

        <div class="form-group row">
          <label for="important" class="col-sm-3 col-form-label">Importancia</label>
          <div class="col-sm-9">
            <select class=" form-control" id="important" name="important" style="display: flex;"><option value="" disabled="">Selecciona importancia</option><optgroup label="Importancia"><option value="0">ninguna</option><option value="1">Enviar</option><option value="2">Enviar CC</option><option value="3">Enviar CCO</option></optgroup></select>
          </div>
        </div>
      </form> 
      
      `,
      showCancelButton: true,
      preConfirm: () => {
        const nombre =  Swal.getPopup().querySelector('#nombre').value;
        const empresa = Swal.getPopup().querySelector('#empresa').value;
        const telefono = Swal.getPopup().querySelector('#telefono').value;
        const important = Swal.getPopup().querySelector('#important').value;f
        const id = Swal.getPopup().querySelector('#idlist').value;

        return{nombre,empresa,telefono,important,id}
      }
    })
    .then((resp)=>{
      if(resp.isConfirmed){
        $.ajax({
            url: "./?action=usuario/libretaDirecciones&method=editContacList&propietario=<?=$_SESSION['id']?>",
            method: "POST",
            data: resp.value ,
            success: function(respuesta) {
              $('#tablaLibretaDirecciones').jtable('load');
              if(respuesta == "ok"){
                Swal.fire({
                  icon:success,
                  html: "datos actualizados correctamente",
                  allowOutsideClick:false,
                })
              }
            },
            error:{ function(e) {
                alert("algo anda mal, por favor refresca la página, disculpa las molestias");
                  console.log(e);
              }
            }
        });
      }
    })
  }

  window.onload=function (){
    console.log("activando");
    //activar jtable 
    $('#tablaLibretaDirecciones').jtable({
            title: 'Personaliza tus contactos',
            messages:{
                noDataAvailable: 'No hay contactos!',
                addNewRecord: 'añadir',
                editRecord: 'edit',
            },
            edit: true,
            StartIndex: 1,
            paging: true, //Enable paging
            pageSize: 10,
            pageSizes: [5, 10, 100],
            sorting: true, //Enable sorting
            defaultSorting: 'id DESC',
            openChildAsAccordion: true,
            toolbar_no: {
                items: [{
                    tooltip: 'Exportar a Excel',
                    icon: 'https://www.jtable.org/Content/images/Misc/excel.png',
                    text: 'Excel',
                    click: function() {
                        downloadAsExcel(res.Records, 'libreta_direcciones');
                    },
                }]
            },
            actions: {
                listAction: './?action=usuario/libretaDirecciones&method=byuserid/ver/tabla&userid=<?=$_SESSION['id']?>',
                //createAction: '/GettingStarted/CreatePerson',
                //updateAction: '?action=jtable/tablaUsuarios.ajax&editar',
                // deleteAction: '/GettingStarted/DeletePerson'
            },
            fields: {
                Editar: {
                    title: 'Editar',
                    style: 'jtable-command-column contactos-editar',
                    width: '3%',
                    sorting: false,
                    edit: false,
                    create: false,
                    display: function(contact) {
                        //Create an image that will be used to open child table
                        // var $img = $('<img src="/Content/images/Misc/phone.png" title="Edit phone numbers" />');
                        let $img = $(
                            '<center><i class="nc-icon nc-ruler-pencil"></i></center>'
                            //'<center><btn class="btn btn-sm btn-outline-danger btn-round btn-icon"><i class="nc-icon nc-layout-11" style="font-size: 1.5em;"></i></btn></center>'
                            );
                        let c = contact.record;

                        //Open child table muestra usuarios que pertenecen a esa area y su grupo!
                        $img.click(function() {
                                // alert(siniestro.record.folio);
                                // window.open('./?view=siniestro/editar&timerst='+siniestro.record.timerst, '_blank');
                                editarContacto(c.id, c.email, c.nombre,  c.empresa,  c.telefono);
                        });
                        //Return image to show
                        return $img;
                    }
                },
                id: {
                    title: 'ID',
                    key: true,
                    list: false,
                    width: '3%'
                },
                important: {
                    title: 'Importancia',
                    width: '7%',
                    options: { 0: 'ninguno', ' ': 'ninguno', '1': 'Enviar','2':'CC', '3':'CCO' },
                },
                nombre: {
                  title: 'Nombre',
                  width: '7%'
                },
                email: {
                  title: 'E-mail',
                  width: '10%'
                },
                empresa: {
                    title: 'Empresa',
                    width: '10%'
                },
                telefono: {
                    title: 'Teléfono',
                    width: '7%',
                },
            }
    });
    $('#tablaLibretaDirecciones').jtable('load');
  }

  function ajaxtable(){
    $.ajax({
        url: "./?action=usuario/libretaDirecciones&method=byuserid/ver&userid=<?=$_SESSION['id']?>",
        method: "POST",
        data: {} ,
        success: function(respuesta) {
            dataset = JSON.parse(respuesta); // parsea los email en json
            //console.log(dataset);

            let listTD=`
              <tr>
              <th>Enviar<td>
              <th>CC<td>
              <th>CCO<td>
              <th>Nombre<td>
              <th>Email<td>
              <th>Empresa<td>
              <tr>`;
                dataset.forEach(acount => {
                  check = '';
                  check2 = '';
                  check3 = '';
                  if(acount.important == 1){ //revisa si es default desde bd libretadirecciones
                    check = ' checked="true" ';
                  }
                  if(acount.important == 2){ //revisa si es default desde bd libretadirecciones
                    check2 = ' checked="true" ';
                  }
                  if(acount.important == 3){ //revisa si es default desde bd libretadirecciones
                    check3 = ' checked="true" ';
                  }
                  disabled = '';
                  if(acount.email=='jesus@cmabogados.mx' 
                      // && acount.email=='siniestros@cmabogados.mx'
                  ){//revisa si es email prioritario para denegar opcion de destildar
                    disabled = ' class="notouch" ';
                  }
                  listTD = listTD+ `
                  <tr>
                  <td> <input type="checkbox" `+check+` name="send_`+acount.idlist+`" id="send_`+acount.idlist+`"  `+disabled+`> <td>
                  <td> <input type="checkbox" `+check2+` name="cc_`+acount.idlist+`" id="cc_`+acount.idlist+`"     `+disabled+`> <td>
                  <td> <input type="checkbox" `+check3+` name="cco_`+acount.idlist+`" id="cco_`+acount.idlist+`"   `+disabled+`> <td>
                  <td>`+acount.email+`<td>
                  <td>`+acount.nombre+`<td>
                  <td>`+acount.empresa+`<td>
                  <tr>`;
                });
            
            let addmails = `
            <div class="spandestinatarios" >
                <div class="d-none form-row send">
                  <div class="form-group col-md-10">
                      <select type=text class='selectEmail js-select2-tags form-control' index=0 placeholder='Agregar destinatarios' tag='true' name='inputsend[]' id='inputsend' style='width:100%;' multiple='multiple'>
                      </select>
                  </div>
                  <div class="form-group col-md-2 pt-2 labelChbox">
                    <label for="inputPassword4">Guardar</label>
                    <input type="checkbox" name="save_send" id="save_send">
                  </div>
                </div>

                <div class="d-none form-row cc">
                  <div class="form-group col-md-10">
                      <select type=text class='selectEmail js-select2-tags form-control' index=0 placeholder='Agregar Con Copia' tag='true' name='inputcc[]' id='inputcc' style='width:100%;' multiple='multiple'>
                      </select>
                  </div>
                  <div class="form-group col-md-2 pt-2 labelChbox">
                    <label for="inputPassword4">Guardar</label>
                    <input type="checkbox" name="save_cc" id="save_cc">
                  </div>
                </div>

                <div class="d-none form-row cco">
                  <div class="form-group col-md-10">
                      <select type=text class='selectEmail js-select2-tags form-control' index=0 placeholder='Agregar Con Copia Oculta' tag='true' name='inputcco[]' id='inputcco' style='width:100%;' multiple='multiple'>
                      </select>
                  </div>
                  <div class="form-group col-md-2 pt-2 labelChbox">
                    <label for="inputPassword4">Guardar</label>
                    <input type="checkbox" name="save_cco" id="save_cco">
                  </div>
                </div>

                <div class=" form-row">
                  <div class="form-group col-md-12 d-flex justify-content-end">
                      <button style="font-weight: 400;text-transform: capitalize;" onclick="agregarDestinatarios()" class="seeWrite btn py-1 btn-small btn-primary"> agregar destinatarios ... </button>
                  </div>
                </div>

                <div class="form-row subject">
                  <div class="form-group col-md-12">
                      <input style="#66615b !important;font-size:18px;width:100%;border: 1px solid #DDDDDD !important; font-family: sans-serif;" class='selectEmail js-select2-tags form-control' type="text" placeholder="Asunto" name="subject" id="subject">
                  </div>
                </div>

            </div>

            <textarea class="textarea" id="textareaEmail" placeholder='Escribe aquí (opcional)'>
                
            </textarea>
            `;

            Swal.fire({
              allowOutsideClick:false,
              showClass: {
                popup: 'animate__animated animate__backInLeft'
              },
              hideClass: {
                popup: 'animate__animated animate__backOutRight'
              },
              width: "90%",
              title: 'Enviar por correo',
              showCancelButton: true,
              cancelButtonColor: '#988763',
              confirmButtonColor: '#988763',
              confirmButtonText: 'Enviar e-mail',
              cancelButtonText: 'salir',
              html: "<style>.tablaEmails tr:nth-child(4n+1){background:#e1e9ed;} .tablaEmails tr:hover{background: #ffedc3b3;color: black;}.tablaEmails tr:nth-child(1){background:#fff;} </style> <table width='100%' class='tablaEmails'>"+listTD+"<table> <br>"+addmails,
              didOpen:()=>{
                //select2 de mas emails
                $('#inputsend').select2({
                    placeholder: $('#inputsend').attr('placeholder'),//"agregar destinatarios",
                    dropdownParent: $('#swal2-html-container'),
                    tags : true ,
                    tokenSeparators : [ ',;' ] ,
                });
                $('#inputcc').select2({
                    placeholder: $('#inputcc').attr('placeholder'),//"agregar destinatarios",
                    dropdownParent: $('#swal2-html-container'),
                    tags : true ,
                    tokenSeparators : [ ',;' ] ,
                });
                $('#inputcco').select2({
                    placeholder: $('#inputcco').attr('placeholder'),//"agregar destinatarios",
                    dropdownParent: $('#swal2-html-container'),
                    tags : true ,
                    tokenSeparators : [ ',;' ] ,
                });

                //textarea cuerpo del correo
                // if(openTxtEditHechos==false){
                CKEDITOR.replace('textareaEmail', {
                          uiColor: '#ede6c6',
                          editorplaceholder: 'Cuerpo del correo',
                          placeholder: 'Escribe algo....',
                          removeButtons: "Creatediv,Subscript,Superscript,Anchor,PasteFromWord,PasteText,Paste,Cut,Save,NewPage,DocProps,Document,Templates,Print,ExportPdf,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CreateDiv,Language,Link,Unlink,Iframe,About",
                      });
                      openTxtEditHechos=true;
                // }
              },
              preConfirm:()=>{
                const timerst = $('#timerstFile').val();
                const areaNombre = $('#nombreAreaFile').val();
                const asunto =  Swal.getPopup().querySelector('#subject').value;


                const c1 = $('#c1').val();
                const c2 = $('#c2').val();
                const c3 = $('#c3').val();

                const linkpdf = $('#linkpdf').val();
                const link = $('#link').val();
                const idfile = $('#idfile').val();
                const version = $('#version').val();
                const v = $('#version').val();

                const save_send = Swal.getPopup().querySelector('[type=checkbox][name=save_send]').checked;
                const save_cc = Swal.getPopup().querySelector('[type=checkbox][name=save_cc]').checked;
                const save_cco = Swal.getPopup().querySelector('[type=checkbox][name=save_cco]').checked;

                const addsend = $('#inputsend').val();
                const addcc = $('#inputcc').val();
                const addcco = $('#inputcco').val();

                const textMail =  CKEDITOR.instances['textareaEmail'].getData();
                const send = Swal.getPopup().querySelectorAll('[type=checkbox][name^=send_]:checked');
                const cc = Swal.getPopup().querySelectorAll('[type=checkbox][name^=cc_]:checked');
                const cco = Swal.getPopup().querySelectorAll('[type=checkbox][name^=cco_]:checked');
                let sendMails = ' ';
                let ccMails = ' ';
                let ccoMails = ' ';
                send.forEach(item => { sendMails = sendMails + "'"+item.id+"'," });
                cc.forEach(item => { ccMails = ccMails + "'"+item.id+"'," });
                cco.forEach(item => { ccoMails = ccoMails + "'"+item.id+"'," });

                sendMails = sendMails.substring(0, sendMails.length - 1);
                ccMails = ccMails.substring(0, ccMails.length - 1);
                ccoMails = ccoMails.substring(0, ccoMails.length - 1);

                
                
                if (textMail == '')
                Swal.showValidationMessage(`Escribe un mensaje por favor.`);
                
                if (asunto == '')
                Swal.showValidationMessage(`Debes escribir un asunto.`);

                if (sendMails == '' )
                Swal.showValidationMessage(`No se puede enviar mail sin un destinatario.`);

                  return {textMail, sendMails,ccMails,ccoMails, addsend, addcc,addcco,save_send,save_cc,save_cco ,idfile,linkpdf, c1,c2,c3, timerst,areaNombre,v,version,folio:'d',link,asunto};
              }
            }).then((res)=>{
              //?cuando se completó el campo de email y de mas opciones y se clickea en evnviar 
              //? enviando ajax para mail
                // location.reload();
                console.log('reload ...');
                console.log(res);
                if (res.isConfirmed)
                Swal.fire({
                  allowOutsideClick:false,
                  title:'enviando..',
                  // showClass: {
                  //   popup: 'animate__animated animate__backInLeft'
                  // },
                  hideClass: {
                    popup: 'animate__animated animate__backOutRight'
                  },
                  didOpen: () => {
                    Swal.showLoading();
                            $.ajax({
                            url: "./?action=mail/enviar&method=formato",
                            method: "POST",
                            data: res.value ,
                            success: function(respuesta) {
                              let texto='';
                              if (respuesta== 'EXITO'){
                                    texto = "Correo enviado correctamente"
                              }
                              else if(respuesta== 'ERROR'){
                                texto = "No se logró enviar, posiblemente el archivo es muy pesado";
                              }
                              else{
                                texto = "OPS!! algo salió mal. informa al desarrollador";
                              }

                                      Swal.fire({
                                        confirmButtonColor: '#988763',
                                        confirmButtonText: 'Continuar',
                                        title:texto,
                                        /* showClass: {
                                          popup: 'animate__animated animate__backInLeft'
                                        }, */
                                        hideClass: {
                                          popup: 'animate__animated animate__backOutRight'
                                        },
                                      })
                              

                            }
                          });
                  },
                });//termina swal


            })
        },
        error:{ function(e) {
          alert("algo anda mal, por favor refresca la página, disculpa las molestias");
            conjsole.log(e);
        }

        }
    });
  }
</script>