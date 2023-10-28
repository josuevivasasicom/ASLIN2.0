<?php
/* header("Content-type: text/html"); 
header("Expires: Mon, 30 Jan 2022 12:00:00 GMT");  
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
header("Cache-Control: no-store, no-cache, must-revalidate");  
header("Cache-Control: post-check=0, pre-check=0", false);  
header("Pragma: no-cache") */

    $selectInputUsuariosPHP='';
    $abogados=Folios::obtenerUsuarios();
    core::sendVarToJs(json_encode($abogados),'abogadosTodos');
    foreach ($abogados as $key => $value) {
        $selectInputUsuariosPHP.= "<option value='".$value->id."'>".$value->nombre."</option>";
    }
    core::sendVarToJs(json_encode($selectInputUsuariosPHP),'selectInputUsuariosJS');

?> 

<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">

<!-- inicia modal -->
<div class="modal fade" id="newArea" tabindex="1" role="dialog" aria-labelledby="newAreaLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title" id="newAreaLabel">Crear Área</h4>
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <form action="./?action=config/crearArea">
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <input name="area" type="text" class="form-control" placeholder="Área">
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <input name="descripcion" type="text" class="form-control" placeholder="Descripción">
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group">
                        <select class="js-example-basic-single form-control" name="usuario" multiple="multiple" placeholder="asigna uno" style="width:100%;">  <!-- name="states[]"  -->
                        <!-- <option>Asigna un Jefe de Área</option> -->
                        <?php
                            $usuarios=UserData::getAllUsers();
                            Core::preprint($usuarios);
                            foreach ($usuarios as $key => $value) {
                            print "<option value='".$value['idUser']."'>".$value['nombre'].' '.$value['paterno'].' '.$value['materno']."</option>";
                            }
                        ?>
                        </select>
                    
                    </div>
                </div>

                

            </div>
        </form>
      </div>
      <div class="modal-footer">
        <div class="left-side">
            <button id="btn-newArea" type="button" class="btn btn-default btn-simple" >Crear Área</button>  <!-- data-dismiss="modal" -->
        </div>
        <div class="divider"></div>
        <div class="right-side">
            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- termina modal -->


<div class="content">
      

        <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <!-- <h4 class="card-title"> Áreas</h4> -->
              </div>
              <!-- <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">Launch demo modal</button> -->

                <div class="row">
                    <div class="update ml-auto mr-4"> <!-- centrado <div class="update ml-auto mr-auto"> -->
                        <button type="submit" class="btn btn-primary btn-round" data-toggle="modal" data-target="#newArea" >Crear Área</button>
                    </div>
                </div>

              <div class="card-body">
              <div id="tablaAreas" class="mt-1"></div>
                <!-- <script src="vistas/plugins/jtable2.4/localization/jquery.jtable.es.js" type="text/javascript"></script> -->
              </div>
            </div>
        </div>


          <div class="col-md-12">
           
          </div>
          <div class="col-md-12">
            
          </div>
        </div>
      </div>


<script type="text/javascript" defer>
var dataaaa= '';
    window.onload=function (){

        

        //activar jtable
        var botonazo = "";
        $('#tablaAreas').jtable({
            title: 'Lista de Todas las Áreas',
            messages:{
                noDataAvailable: 'No hay registros!',
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

            //selecting: true, //Enable selecting
            //multiselect: true, //Allow multiple selecting
            //selectingCheckboxes: true, //Show checkboxes on first column
            //selectOnRowClick: false, //Enable this to only select using checkboxes

            //openChildAsAccordion: true,
            openChildAsAccordion: true,
            toolbar: {
                items: [{
                    tooltip: 'Exportar a Excel',
                    icon: 'https://asicomgraphics.mx/demos/dxlegal/descargar.png',
                    text: 'Excel',
                    click: function() {
                        downloadAsExcel(res.Records, 'usuarios_cma_');
                    },
                }]
            },
            actions: {
                listAction: '?action=jtable/tablaAreas.ajax',
                //createAction: '/GettingStarted/CreatePerson',
                //updateAction: '?action=jtable/tablaUsuarios.ajax&editar',
                // deleteAction: '/GettingStarted/DeletePerson'
            },
            fields: {
                //CHILD TABLE ""DATOS DEL TIKET DE LA VENTA""
                usuarios: {
                    title: 'Usuarios',
                    style: 'jtable-command-column yata',
                    width: '3%',
                    sorting: false,
                    edit: false,
                    create: false,
                    display: function(dataUser) {
                        //Create an image that will be used to open child table
                        // var $img = $('<img src="/Content/images/Misc/phone.png" title="Edit phone numbers" />');
                        var $img = $(
                            '<center><span class="jtable-page-number-first jtable-page-number-disabled"><img class="nc-icon nc-layout-11" style="font-size: 1.5em;" src="./assets/img/user.png"></span></center>'
                            //'<center><btn class="btn btn-sm btn-outline-danger btn-round btn-icon"><i class="nc-icon nc-layout-11" style="font-size: 1.5em;"></i></btn></center>'
                            );

                        //Open child table muestra usuarios que pertenecen a esa area y su grupo!
                        $img.click(function() {

                            $('#tablaAreas').jtable('openChildTable',
                                $img.closest('tr'), {
                                    title: ' - Permisos del Usuario con el ID : ' + dataUser.record.id,
                                    paging: false, //Enable paging
                                    pageSize: 10,
                                    pageSizes: [10, 20],
                                    sorting: true, //Enable sorting
                                    defaultSorting: 'id ASC',
                                    actions: {
                                        listAction: '?action=jtable/tablaUsuarios.ajax&permisosUsers=' + dataUser.record.id,
                                    },
                                    fields: {
                                        /* id: {
                                            type: 'hidden',
                                            defaultValue: dataUser.record.idArea
                                        }, */
                                        id: {
                                            key: true,
                                            create: false,
                                            edit: false,
                                            list: false,
                                            title: 'id'
                                        },
                                        area: {
                                            title: 'Área',
                                            width: '30%',
                                            /* options: {
                                                '1': 'Home phone',
                                                '2': 'Office phone',
                                                '3': 'Cell phone'
                                            } */
                                        },
                                        grupo: {
                                            title: 'Grupo',
                                            width: '30%'
                                        },
                                        nombre: {
                                            title: 'nombre',
                                            width: '10%'
                                        },
                                        paterno: {
                                            title: 'paterno',
                                            width: '10%'
                                        },
                                        materno: {
                                            title: 'materno',
                                            width: '10%'
                                        },
                                        email: {
                                            title: 'email',
                                            width: '10%'
                                        },
                                    
                                    }
                                },
                                function(data) { //opened handler
                                    data.childTable.jtable('load');
                                });
                        });
                        //Return image to show
                        return $img;
                    }
                },
                editar:{
                    title: 'Editar',
                    style: 'jtable-command-column editar-ver',
                    width: '2%',
                    sorting: false,
                    edit: false,
                    create: false,
                    display: function(area) {
                        //Create an image that will be used to open child table
                        // var $img = $('<img src="/Content/images/Misc/phone.png" title="Edit phone numbers" />');
                        var $img = $(
                            '<center><i><img src="https://asicomgraphics.mx/demos/dxlegal/editar.png"></i></center>'
                            );
                        $img.click(function() {
                                editArea(area.record); //funcion de JS con swetAlert
                        });
                        //Return image to show
                        return $img;
                    }
                },
                //CHILD TABLE ""DATOS DEL TIKET DE LA VENTA""

                id: {
                    title: 'id',
                    key: true,
                    list: true,
                    width: '3%'
                },
                area: {
                    title: 'Área',
                    width: '10%'
                },
                descripcion: {
                    title: 'Descripción',
                    width: '20%'
                },
                jefeArea: {
                    title: 'Jefe Área',
                    width: '15%'
                },
                activo: {
                    title: 'Estatus',
                    width: '15%',
                    options: {
                        '1': 'Activo',
                        '0': 'Deshabilitado',
                    }
                },
                fechaCreacion: {
                    title: 'Fecha Creación',
                    width: '10%'
                },
                fechaModificacion: {
                    title: 'Ultima Modificación',
                    width: '10%'
                },
                historico: {
                    title: 'Histórico',
                    width: '15%'
                },
            }
        });
        $('#tablaAreas').jtable('load');

        //activar multiselect2
        $('.js-example-basic-single').select2(
             {placeholder: "Asigna un Jefe de Área"}
        );

        $('#btn-newArea').on('click',function(){
            // boton nueva area
        });

       
        function editArea(area) {
                //swert alert editar el área
                let selectInputUsuarios = '';
                    selectInputUsuarios =` <select class="swal2-input js-select2 form-control" placeholder="Asigna Jefe de Área" id="jefeA" name="jefeA" multiple="multiple" style="width:100%;">`;
                    selectInputUsuarios= selectInputUsuarios + selectInputUsuariosJS +` </select>`;

                let selInput = '';
                if(area.activo=='1'){
                    selInput = `<select id="activo"  class="swal2-input" placeholder="activar o desactivar"  style="width:90%;"> 
                                <option value="1" >Activo</option>
                                <option value="0">Desactivar</option>
                                </select>`;
                }
                else{
                    selInput =`<select id="activo"  class="swal2-input" placeholder="activar o desactivar"  style="width:90%;"> 
                                <option value="0" >Inhabilitado</option>
                                <option value="1">Activar</option>
                                </select>`;
                }
                

                let html_ = `   <input type="text" id="idA"  value="`+area.id+`"  style="display:none">
                                <input type="text" id="area"          value="`+area.area+`"    class="swal2-input" placeholder="Nombre de Àrea" style="text-transform: uppercase;width:90%;">
                                <input type="text" id="descripcion"   value="`+area.descripcion+`"    class="swal2-input" placeholder="Descripción del Àrea" style="text-transform: uppercase;width:90%;">`;
                html_ = html_ + selectInputUsuarios+' '+selInput;

                setTimeout(() => {
                        $.each(document.querySelectorAll('.js-select2'),function(i,key){
                                $(key).select2({
                                placeholder: " "+  $(key).attr('placeholder')
                            });
                        });
                            $('#jefeA').val(area.jefeArea.split(',')[0]).trigger('change.select2');
                            $('.select2-selection.select2-selection--multiple').addClass('swal2-input');

                    }, 100);
                    
                Swal.fire({
                    
                confirmButtonColor: 'var(--color-blanco)',
                denyButtonColor: 'var(--color-blanco)',
                cancelButtonColor: 'var(--color-blanco)',

                title: 'Crear nueva Área.',
                html: html_,
                confirmButtonText: 'Guardar',
                showCancelButton: true,
                cancelButtonText: 'Salir',
                focusConfirm: false,
                preConfirm: () => {
                    const area = Swal.getPopup().querySelector('#area').value
                    const descripcion = Swal.getPopup().querySelector('#descripcion').value
                    const jefeA = Swal.getPopup().querySelector('#jefeA').value
                    const activo = Swal.getPopup().querySelector('#activo').value
                    const id = Swal.getPopup().querySelector('#idA').value
                    
                    if (!area || !descripcion || !jefeA) {
                    Swal.showValidationMessage(`No puedes dejar campos en blanco`);
                    }
                    return { area,descripcion,jefeA,activo,id}
                }
                }).then((cambios) => {
                    // console.log (cambios.isConfirmed);
                
                if (cambios.isConfirmed)
                    $.ajax({
                        url: "./?action=config/param&modo=area&edit=area",
                        method: "POST",
                        data: {'data':cambios.value} ,
                        success: function(respuesta) {
                            // dataset = JSON.parse(respuesta);
                            console.log(respuesta);
                            Swal.fire(`
                                Cambios realizados 
                            `.trim()).then(()=>{
                                $('#tablaAreas').jtable('load');//actualiza la tabla al hacer click en OK
                            })
                        },
                            error:{ function(e) {
                                conjsole.log(e);
                            }
                        }
                    });
                
                });
                
            }



        /* $('#btn-newArea').on('click',function(){
            Swal.fire({
            title: 'nueva Área',
            text: 'Se guardo el area correctamente',
            icon: 'info',
            confirmButtonText: 'Continuar'
            }).then((result) => {
                if (result.isConfirmed) {
                    //Swal.fire('Saved!', '', 'success')
                    $('#newArea').modal('hide');
                } else if (result.isDenied) {
                    //Swal.fire('Changes are not saved', '', 'info')
                    $('#newArea').modal('hide');
                }
            })

        }); */

    };

    function swalertOk(title,text){
        Swal.fire({
        title: title,
        text: text,
        icon: 'info',
        confirmButtonText: 'Continuar'
        })
    }

    

</script>
<style defer>
    .swal2-file, .swal2-input, .swal2-textarea {
    font-size: 0.825em !important;
    color: gray;
    padding: 0px;
    margin-right: 16px;
    border: solid #d9d9d9 1px;
    }
    .select2-container--open {
        z-index: 99999999999999;
    }
    .swal2-title{
        border-bottom: 1px solid #cacaca;
        font-size: 1.8em;
        font-weight: 400;
    }
    .select2-selection.select2-selection--multiple.swal2-input{
        padding: 0px;
        margin-right: 16px;
        border: solid #d9d9d9 1px;
    }
</style>