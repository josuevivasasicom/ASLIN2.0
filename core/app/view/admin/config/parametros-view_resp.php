<?php
header("Content-type: text/html"); 
?>
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">


<!-- inicia modal -->
<!-- newProveniente -->
<div class="modal fade" id="newArea" tabindex="1" role="dialog" aria-labelledby="newAreaLabel" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
          <h4 class="modal-title" id="newAreaLabel">Añadir Proveniente</h4>
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

<!-- newInstitucion -->

<!-- new? -->
<!-- termina modal -->


<div class="content">
      
        <!-- tabla provenientes -->
        <div class="row justify-content-md-center">
            <div class="col-md-10">
                <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> Provenientes</h4>
                    <span>Agrega Provenientes y cambia el color de las gráficas.</span>
                </div>
                <!-- <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">Launch demo modal</button> -->

                    <div class="row">
                        <div class="update ml-auto mr-4"> <!-- centrado <div class="update ml-auto mr-auto"> -->
                            <button type="button" onclick="newProv()" class="btn btn-primary btn-round" data-toggle="modal" data-target="#newProveniente" >Añadir Proveniente</button>
                        </div>
                    </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <div id="tablaProvenientes" class="mt-1"></div>
                    </div>
                    <!-- <script src="vistas/plugins/jtable2.4/localization/jquery.jtable.es.js" type="text/javascript"></script> -->
                </div>
                </div>
            </div>

            <div class="col-md-10">
                <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Etapas de archivos</h4>
                    <span>Lista por categoria de los archivos que se pueden subir..</span>
                </div>
                <!-- <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">Launch demo modal</button> -->

                    <div class="row">
                        <div class="update ml-auto mr-4"> <!-- centrado <div class="update ml-auto mr-auto"> -->
                            <button type="button" onclick="newTypeFile()" class="btn d-none  btn-primary btn-round" data-toggle="modal" data-target="#newProveniente" >Añadir Proveniente</button>
                        </div>
                    </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <div id="tablaTypeFiles" class="mt-1"></div>
                    </div>
                    <!-- <script src="vistas/plugins/jtable2.4/localization/jquery.jtable.es.js" type="text/javascript"></script> -->
                </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <!-- tabla instituciones  -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"> Instituciones</h4>
                    </div>
                    <!-- <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">Launch demo modal</button> -->
                        <div class="row">
                            <div class="update ml-auto mr-4"> <!-- centrado <div class="update ml-auto mr-auto"> -->
                                <button onclick="newInst()" class="btn btn-primary btn-round" data-toggle="modal" data-target="#newProveniente" >Añadir Institución</button>
                            </div>
                        </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div id="tablaInstituciones" class="mt-1"></div>
                            <!-- <script src="vistas/plugins/jtable2.4/localization/jquery.jtable.es.js" type="text/javascript"></script> -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- tabla de autoridades -->
            <div class="col-md-6">
                <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> Autoridad</h4>
                    <span>Despliega select del Autoridad, para crear un nuevo siniestro. Listadod e Autoridades</span>
                </div>
                <!-- <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">Launch demo modal</button> -->

                    <div class="row">
                        <div class="update ml-auto mr-4"> <!-- centrado <div class="update ml-auto mr-auto"> -->
                            <button onclick="newAutoridad()" type="button" class="btn btn-primary btn-round" data-toggle="modal" data-target="#newAutoridad" >Añadir Autoridad</button>
                        </div>
                    </div>

                <div class="card-body">
                <div id="tablaAutoridades" class="mt-1"></div>
                    <!-- <script src="vistas/plugins/jtable2.4/localization/jquery.jtable.es.js" type="text/javascript"></script> -->
                </div>
                </div>
            </div>

        </div>

        <div class="row mt-4">
             <!-- tabla de estatus -->
            <div class="col-md-6">
                <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> Estatus</h4>
                    <span>Iinformación que aparece en el campo de estatus para nuevo siniestro.</span>
                </div>
                <!-- <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">Launch demo modal</button> -->

                    <div class="row">
                        <div class="update ml-auto mr-4"> <!-- centrado <div class="update ml-auto mr-auto"> -->
                            <button type="submit" class="btn btn-primary btn-round" data-toggle="modal" data-target="#newAutoridad" >Añadir Estatus</button>
                        </div>
                    </div>

                <div class="card-body">
                <div id="tablaEstatus" class="mt-1"></div>
                    <!-- <script src="vistas/plugins/jtable2.4/localization/jquery.jtable.es.js" type="text/javascript"></script> -->
                </div>
                </div>
            </div>
            
            <!-- tabla de calificación -->
             <div class="col-md-6">
                <div class="card">
                <div class="card-header">
                    <h4 class="card-title"> Calificación</h4>
                    <span>Información que aparece en el campo de Calificación para nuevo siniestro.</span>
                </div>
                <!-- <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">Launch demo modal</button> -->

                    <div class="row">
                        <div class="update ml-auto mr-4"> <!-- centrado <div class="update ml-auto mr-auto"> -->
                            <button type="submit" class="btn btn-primary btn-round" data-toggle="modal" data-target="#newAutoridad" >Añadir Calificación</button>
                        </div>
                    </div>

                <div class="card-body">
                <div id="tablaCalificacion" class="mt-1"></div>
                    <!-- <script src="vistas/plugins/jtable2.4/localization/jquery.jtable.es.js" type="text/javascript"></script> -->
                </div>
                </div>
            </div>
         </div>

      </div>  <!-- //final -->


<script type="text/javascript" defer>
    window.onload=function (){
        /******
        JTABLES
        ******/

        //activar jtable provenientes
        var botonazo = "";
        $('#tablaProvenientes').jtable({
            title: 'Lista de Todos los Provenientes / Proveedores',
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
            defaultSorting: 'id ASC',
            openChildAsAccordion: true,
            toolbar_no: {
                items: [{
                    tooltip: 'Exportar a Excel',
                    icon: 'https://www.jtable.org/Content/images/Misc/excel.png',
                    text: 'Excel',
                    click: function() {
                        downloadAsExcel(res.Records, 'usuarios_cma_');
                    },
                }]
            },
            actions: {
                listAction: '?action=jtable/tablaProvenientes.ajax&jtable=jtable',
                //createAction: '/GettingStarted/CreatePerson',
                //updateAction: '?action=jtable/tablaUsuarios.ajax&editar',
                // deleteAction: '/GettingStarted/DeletePerson'
            },
            fields: {
                editar:{
                    title: 'Editar',
                    style: 'jtable-command-column siniestros-ver',
                    width: '3%',
                    sorting: false,
                    edit: false,
                    create: false,
                    display: function(siniestro) {
                        //Create an image that will be used to open child table
                        // var $img = $('<img src="/Content/images/Misc/phone.png" title="Edit phone numbers" />');
                        var $img = $(
                            '<center><img src="https://asicomgraphics.mx/demos/dxlegal/editar.png"></i></center>'
                            //'<center><btn class="btn btn-sm btn-outline-danger btn-round btn-icon"><i class="nc-icon nc-layout-11" style="font-size: 1.5em;"></i></btn></center>'
                            );

                        //Open child table muestra usuarios que pertenecen a esa area y su grupo!
                        $img.click(function() {
                                // alert(siniestro.record.folio);
                                editProv(siniestro.record);
                        });
                        //Return image to show
                        return $img;
                    }
                },
                id: {
                    title: 'ID',
                    key: true,
                    list: true,
                    width: '3%'
                },
                descripcion: {
                    title: 'Descripción',
                    width: '10%'
                },
                proveniente: {
                    title: 'Proveniente',
                    width: '10%'
                },
                borderColor: {
                    title: 'Color Borde',
                    width: '7%'
                },
                backgroundColor: {
                    title: 'Color Fondo',
                    width: '7%'
                },
                estatus: {
                    title: 'Estatus',
                    width: '7%'
                },
            }
        });
        $('#tablaProvenientes').jtable('load');

        //activar jtable instituciones
        $('#tablaInstituciones').jtable({
            title: 'Lista de Instituciones',
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
            defaultSorting: 'id ASC',
            openChildAsAccordion: true,
            toolbar_no: {
                items: [{
                    tooltip: 'Exportar a Excel',
                    icon: 'https://www.jtable.org/Content/images/Misc/excel.png',
                    text: 'Excel',
                    click: function() {
                        downloadAsExcel(res.Records, 'usuarios_cma_');
                    },
                }]
            },
            actions: {
                listAction: '?action=jtable/tablaInstituciones.ajax&jtable=jtable',
                //createAction: '/GettingStarted/CreatePerson',
                //updateAction: '?action=jtable/tablaUsuarios.ajax&editar',
                // deleteAction: '/GettingStarted/DeletePerson'
            },
            fields: {
                editar:{
                    title: 'Editar',
                    style: 'jtable-command-column institucion-ver',
                    width: '3%',
                    sorting: false,
                    edit: false,
                    create: false,
                    display: function(insti) {
                        //Create an image that will be used to open child table
                        // var $img = $('<img src="/Content/images/Misc/phone.png" title="Edit phone numbers" />');
                        var $img = $(
                            '<center><i><img src="https://asicomgraphics.mx/demos/dxlegal/editar.png"></i></center>'
                            //'<center><btn class="btn btn-sm btn-outline-danger btn-round btn-icon"><i class="nc-icon nc-layout-11" style="font-size: 1.5em;"></i></btn></center>'
                            );

                        //Open child table muestra usuarios que pertenecen a esa area y su grupo!
                        $img.click(function() {
                                // alert(insti.record.folio);
                                editInst(insti.record);
                        });
                        //Return image to show
                        return $img;
                    }
                },
                id: {
                    title: 'Id',
                    key: true,
                    list: true,
                    width: '3%'
                },
                valor: {
                    title: 'Descripción',
                    width: '10%'
                },
                activo: {
                    title: 'Estatus',
                    width: '10%'
                },
            }
        });
        $('#tablaInstituciones').jtable('load');

        //activar jtable autoridades
        $('#tablaAutoridades').jtable({
            title: 'Lista de Autoridades',
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
            defaultSorting: 'id ASC',
            openChildAsAccordion: true,
            toolbar_no: {
                items: [{
                    tooltip: 'Exportar a Excel',
                    icon: 'https://www.jtable.org/Content/images/Misc/excel.png',
                    text: 'Excel',
                    click: function() {
                        downloadAsExcel(res.Records, 'usuarios_cma_');
                    },
                }]
            },
            actions: {
                listAction: '?action=jtable/tablaAutoridades.ajax&jtable=jtable',
                //createAction: '/GettingStarted/CreatePerson',
                //updateAction: '?action=jtable/tablaUsuarios.ajax&editar',
                // deleteAction: '/GettingStarted/DeletePerson'
            },
            fields: {
                editar:{
                    title: 'Editar',
                    style: 'jtable-command-column autoridades-ver',
                    width: '3%',
                    sorting: false,
                    edit: false,
                    create: false,
                    display: function(autoridades) {
                        //Create an image that will be used to open child table
                        // var $img = $('<img src="/Content/images/Misc/phone.png" title="Edit phone numbers" />');
                        var $img = $(
                            '<center><img src="https://asicomgraphics.mx/demos/dxlegal/editar.png"></i></center>'
                            //'<center><btn class="btn btn-sm btn-outline-danger btn-round btn-icon"><i class="nc-icon nc-layout-11" style="font-size: 1.5em;"></i></btn></center>'
                            );

                        //Open child table muestra usuarios que pertenecen a esa area y su grupo!
                        $img.click(function() {
                                // alert(autoridades.record.folio);
                                editAutoridad(autoridades.record);
                        });
                        //Return image to show
                        return $img;
                    }
                },
                id: {
                    title: 'Id',
                    key: true,
                    list: true,
                    width: '3%'
                },
                valor: {
                    title: 'Descripción',
                    width: '10%'
                },
                activo: {
                    title: 'Estatus',
                    width: '10%'
                },
            }
        });
        $('#tablaAutoridades').jtable('load');

        //activar jtable estatus
        $('#tablaEstatus').jtable({
            title: 'Lista de Estatus',
            messages:{
                noDataAvailable: 'No hay registros!',
                addNewRecord: 'añadir',
                editRecord: 'edit',
            },
            edit: true,
            StartIndex: 1,
            paging: true, //Enable paging
            pageSize: 3,
            pageSizes: [3, 6, 50],
            sorting: true, //Enable sorting
            defaultSorting: 'id ASC',
            openChildAsAccordion: true,
            toolbar_no: {
                items: [{
                    tooltip: 'Exportar a Excel',
                    icon: 'https://www.jtable.org/Content/images/Misc/excel.png',
                    text: 'Excel',
                    click: function() {
                        downloadAsExcel(res.Records, 'usuarios_cma_');
                    },
                }]
            },
            actions: {
                listAction: '?action=jtable/tablaEstatus.ajax&jtable=jtable',
                //createAction: '/GettingStarted/CreatePerson',
                //updateAction: '?action=jtable/tablaUsuarios.ajax&editar',
                // deleteAction: '/GettingStarted/DeletePerson'
            },
            fields: {
                editar:{
                    title: 'Editar',
                    style: 'jtable-command-column estatus-ver',
                    width: '3%',
                    sorting: false,
                    edit: false,
                    create: false,
                    display: function(estatus) {
                        //Create an image that will be used to open child table
                        var $img = $(
                            '<center><i><img src="https://asicomgraphics.mx/demos/dxlegal/editar.png"></i></center>'
                            );

                        //Open action button
                        $img.click(function() {
                                editAutoridad(estatus.id);
                        });
                        //Return image to show
                        return $img;
                    }
                },
                id: {
                    title: 'Id',
                    key: true,
                    list: true,
                    width: '3%'
                },
                valor: {
                    title: 'Descripción',
                    width: '10%'
                },
                activo: {
                    title: 'Estatus',
                    width: '10%'
                },
            }
        });
        $('#tablaEstatus').jtable('load');

        //activar jtable estatus
        $('#tablaCalificacion').jtable({
            title: 'Lista de calificación',
            messages:{
                noDataAvailable: 'No hay registros!',
                addNewRecord: 'añadir',
                editRecord: 'edit',
            },
            edit: true,
            StartIndex: 1,
            paging: true, //Enable paging
            pageSize: 3,
            pageSizes: [3, 6, 30],
            sorting: true, //Enable sorting
            defaultSorting: 'id ASC',
            openChildAsAccordion: true,
            toolbar_no: {
                items: [{
                    tooltip: 'Exportar a Excel',
                    icon: 'https://www.jtable.org/Content/images/Misc/excel.png',
                    text: 'Excel',
                    click: function() {
                        downloadAsExcel(res.Records, 'usuarios_cma_');
                    },
                }]
            },
            actions: {
                listAction: '?action=jtable/tablaCalificacion.ajax&jtable=jtable',
                //createAction: '/GettingStarted/CreatePerson',
                //updateAction: '?action=jtable/tablaUsuarios.ajax&editar',
                // deleteAction: '/GettingStarted/DeletePerson'
            },
            fields: {
                editar:{
                    title: 'Editar',
                    style: 'jtable-command-column estatus-ver',
                    width: '3%',
                    sorting: false,
                    edit: false,
                    create: false,
                    display: function(estatus) {
                        //Create an image that will be used to open child table
                        var $img = $(
                            '<center><img src="https://asicomgraphics.mx/demos/dxlegal/editar.png"></i></center>'
                            );

                        //Open action button
                        $img.click(function() {
                                editAutoridad(estatus.id);
                        });
                        //Return image to show
                        return $img;
                    }
                },
                id: {
                    title: 'Id',
                    key: true,
                    list: true,
                    width: '3%'
                },
                valor: {
                    title: 'Descripción',
                    width: '10%'
                },
                activo: {
                    title: 'Estatus',
                    width: '10%'
                },
            }
        });
        $('#tablaCalificacion').jtable('load');

         //activar jtable tableTypeFile tipo de archivo
         $('#tablaTypeFiles').jtable({
            title: 'tableTypeFile',
            messages:{
                noDataAvailable: 'No hay registros!',
                addNewRecord: 'añadir',
                editRecord: 'edit',
            },
            edit: true,
            StartIndex: 1,
            paging: true, //Enable paging
            pageSize: 5,
            pageSizes: [5, 10, 30],
            sorting: true, //Enable sorting
            defaultSorting: 'id ASC',
            openChildAsAccordion: true,
            toolbar_no: {
                items: [{
                    tooltip: 'Exportar a Excel',
                    icon: 'https://www.jtable.org/Content/images/Misc/excel.png',
                    text: 'Excel',
                    click: function() {
                        downloadAsExcel(res.Records, 'usuarios_cma_');
                    },
                }]
            },
            actions: {
                listAction: '?action=jtable/tablaTypeFile.ajax&jtable=jtable',
                //createAction: '/GettingStarted/CreatePerson',
                //updateAction: '?action=jtable/tablaUsuarios.ajax&editar',
                // deleteAction: '/GettingStarted/DeletePerson'
            },
            fields: {
                /* editar:{
                    title: 'Editar',
                    style: 'jtable-command-column tipoArchivo TypeFile-ver',
                    width: '3%',
                    sorting: false,
                    edit: false,
                    create: false,
                    display: function(TypeFile) {
                        var $img = $(
                            '<center><i class="nc-icon nc-ruler-pencil"></i></center>'
                            );

                        $img.click(function() {
                                editTypeFile(TypeFile.id);
                        });
                        return $img;
                    }
                }, */
                id: {
                    title: 'Id',
                    key: true,
                    list: true,
                    width: '3%'
                },
                valor: {
                    title: 'Descripción',
                    width: '10%'
                },
                c2: {
                    title: '2',
                    width: '10%'
                },
                c3: {
                    title: '3',
                    width: '10%'
                },
            }
        });
        $('#tablaTypeFiles').jtable('load');

        /******
        INPUTS SELECT2 ACTION BUTTONS ETC
        ******/

        //activar multiselect2
        $('.js-example-basic-single').select2(
             {placeholder: "Asigna un Jefe de Área"}
        );

        $('#btn-newArea').on('click',function(){
            Swal.fire({
            title: 'nueva Área',
            text: 'Se guardo el area correctamente',
            icon: 'info',
            confirmButtonText: 'Continuar'
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    //Swal.fire('Saved!', '', 'success')
                    $('#newArea').modal('hide');
                } else if (result.isDenied) {
                    //Swal.fire('Changes are not saved', '', 'info')
                    $('#newArea').modal('hide');
                }
            })

        });

    };

    function swalertOk(title,text){
        Swal.fire({
        title: title,
        text: text,
        icon: 'info',
        confirmButtonText: 'Continuar'
        })
    }

    /******
    JTABLES  BUTTONS ACTIONS 
    ******/

    //funcion para editar un proveniente
    function editProv(prov) {
        //swert alert para editar el proveedor o proveniente
        setTimeout(() => {
            const ajustesSpectrum = {
                type: "color",
                showPalette: false,
                showInitial: true,
                showButtons: false,
                allowEmpty: false
            }
            $("#background").spectrum(ajustesSpectrum);
            $("#border").spectrum(ajustesSpectrum);
        }, 200);
        let selInput = '';
        if(prov.estatus=='Activo'){
            selInput = `<select id="estatus"  class="swal2-input" placeholder="activar o desactivar"  style="width:90%;"> 
                        <option value="1" >`+prov.estatus+`</option>
                        <option value="0">Desactivar</option>
                        </select>`;
        }
        else{
            selInput =`<select id="estatus"  class="swal2-input" placeholder="activar o desactivar"  style="width:90%;"> 
                        <option value="0" >`+prov.estatus+`</option>
                        <option value="1">Activar</option>
                        </select>`;
        }

          let html_ = ` <input type="text" id="prov"          value="`+prov.proveniente.toUpperCase()+`"    class="swal2-input" placeholder="prov" style="text-transform: uppercase;width:90%;">
                        <input type="text" id="descripcion"   value="`+prov.descripcion.toUpperCase()+`"    class="swal2-input" placeholder="desc" style="text-transform: uppercase;width:90%;">`;
       html_ = html_ + selInput;
       html_ = html_ + `<label style="margin-top: 1em;">borde</label>
                        <input id="border"     value="`+prov.borderColor+`" class="swal2-input" placeholder="" style="display:none">
                        <label style="margin-top: 1em;">fondo</label>
                        <input id='background' value="`+prov.backgroundColor+`" class="swal2-input" placeholder="" style="display:none">
                        <input id='idProv' value="`+prov.id+`" type="hidden" style="display:none">
                        `,
        Swal.fire({
        confirmButtonColor: 'var(--color-dark)',
        denyButtonColor: 'var(--color-blanco)',
        cancelButtonColor: 'var(--fondo-degradado)',

        title: 'ID: '+prov.id,
        html: html_,
        confirmButtonText: 'Guardar',
        showCancelButton: true,
        cancelButtonText: 'Salir',
        focusConfirm: false,
        preConfirm: () => {
            const prov = Swal.getPopup().querySelector('#prov').value
            const descripcion = Swal.getPopup().querySelector('#descripcion').value
            const estatus = Swal.getPopup().querySelector('#estatus').value
            const border = Swal.getPopup().querySelector('#border').value
            const background = Swal.getPopup().querySelector('#background').value
            const id = Swal.getPopup().querySelector('#idProv').value
            
            if (!prov || !descripcion || !estatus) {
            Swal.showValidationMessage(`No puedes dejar campos en blanco`)
            }
            return { prov,descripcion,estatus,border,background,id}
        }
        }).then((cambios) => {
            // console.log (cambios.isConfirmed);
        
           if (cambios.isConfirmed)
             $.ajax({
                url: "./?action=config/param&modo=proveniente&edit=prov",
                method: "POST",
                data: {'data':cambios.value} ,
                success: function(respuesta) {
                    // dataset = JSON.parse(respuesta);
                    console.log(respuesta);
                    Swal.fire(`
                        Cambios realizados 
                    `.trim()).then(()=>{
                        $('#tablaProvenientes').jtable('load');//actualiza la tabla al hacer click en OK
                    })
                },
                error:{ function(e) {
                    conjsole.log(e);
                }

                }
            });
        
        });
        
    }

    //funcion para crear un proveniente
    function newProv(prov) {
        //swert alert crear al proveniente
        setTimeout(() => {
            const ajustesSpectrum = {
                type: "color",
                showPalette: false,
                showInitial: true,
                showButtons: false,
                allowEmpty: false
            }
            $("#background").spectrum(ajustesSpectrum);
            $("#border").spectrum(ajustesSpectrum);
        }, 200);
        let selInput = '';
        
            selInput =`<select id="estatus"  class="swal2-input" placeholder="activar o desactivar"  style="width:90%;"> 
                        <option value="1">Activo</option>
                        <option value="0" >Deshabilitado</option>
                        </select>`;
        

          let html_ = ` <input type="text" id="prov"          value=""    class="swal2-input" placeholder="Siglas de Proveniente" style="text-transform: uppercase;width:90%;">
                        <input type="text" id="descripcion"   value=""    class="swal2-input" placeholder="Descripción" style="text-transform: uppercase;width:90%;">`;
       html_ = html_ + selInput;
       html_ = html_ + `<label style="margin-top: 1em;">borde</label>
                        <input id="border"     value="" class="swal2-input" placeholder="" style="display:none">
                        <label style="margin-top: 1em;">fondo</label>
                        <input id='background' value="" class="swal2-input" placeholder="" style="display:none">
                        `,
        Swal.fire({
        confirmButtonColor: 'var(--color-dark)',
        denyButtonColor: 'var(--color-blanco)',
        cancelButtonColor: 'var(--fondo-degradado)',

        title: 'Crear nuevo Prov.',
        html: html_,
        confirmButtonText: 'Nuevo',
        showCancelButton: true,
        cancelButtonText: 'Salir',
        focusConfirm: false,
        preConfirm: () => {
            const prov = Swal.getPopup().querySelector('#prov').value
            const descripcion = Swal.getPopup().querySelector('#descripcion').value
            const estatus = Swal.getPopup().querySelector('#estatus').value
            const border = Swal.getPopup().querySelector('#border').value
            const background = Swal.getPopup().querySelector('#background').value
            
            if (!prov || !descripcion || !estatus) {
            Swal.showValidationMessage(`No puedes dejar campos en blanco`)
            }
            return { prov,descripcion,estatus,border,background}
        }
        }).then((cambios) => {
            // console.log (cambios.isConfirmed);
        
           if (cambios.isConfirmed)
             $.ajax({
                url: "./?action=config/param&modo=proveniente&new=prov",
                method: "POST",
                data: {'data':cambios.value} ,
                success: function(respuesta) {
                    // dataset = JSON.parse(respuesta);
                    console.log(respuesta);
                    Swal.fire(`
                        Cambios realizados 
                    `.trim()).then(()=>{
                        $('#tablaProvenientes').jtable('load');//actualiza la tabla al hacer click en OK
                    })
                },
                error:{ function(e) {
                    conjsole.log(e);
                }

                }
            });
        
        });
        
    }

     //funcion para crear un typo de archivo newTypeFile()
     function newTypeFile() {
        //swert alert crear al tipo por categoria de archivos
          let html_ = ` <input type="text" id="etapa"    value=""    class="swal2-input" placeholder="Etapa 1" style="text-transform: uppercase;width:90%;">
                        <input type="text" id="etapa2"   value=""    class="swal2-input" placeholder="Etapa 2" style="text-transform: uppercase;width:90%;">
                        <input type="text" id="tipo"   value=""    class="swal2-input" placeholder="Tipo de documento" style="text-transform: uppercase;width:90%;">`;
        Swal.fire({
        confirmButtonColor: 'var(--color-dark)',
        denyButtonColor: 'var(--color-blanco)',
        cancelButtonColor: 'var(--fondo-degradado)',

        title: 'Crear nueva Categoría.',
        html: html_,
        confirmButtonText: 'Nueva',
        showCancelButton: true,
        cancelButtonText: 'Salir',
        focusConfirm: false,
        preConfirm: () => {
            const etapa1 = Swal.getPopup().querySelector('#prov').value;
            const etapa2 = Swal.getPopup().querySelector('#descripcion').value;
            const tipo = Swal.getPopup().querySelector('#estatus').value;
            
            if (!etapa1 || !etapa2 || !tipo) {
            Swal.showValidationMessage(`No puedes dejar campos en blanco`)
            }
            return { etapa1,etapa2,tipo}
        }
        }).then((cambios) => {
            // console.log (cambios.isConfirmed);
        
           if (cambios.isConfirmed)
             $.ajax({
                url: "./?action=config/param&modo=typeFile&new=cat",
                method: "POST",
                data: {'data':cambios.value} ,
                success: function(respuesta) {
                    // dataset = JSON.parse(respuesta);
                    console.log(respuesta);
                    Swal.fire(`
                        Cambios realizados en tipo de archivo
                    `.trim()).then(()=>{
                        $('#tablaTypeFile').jtable('load');//actualiza la tabla al hacer click en OK
                    })
                },
                error:{ function(e) {
                    conjsole.log(e);
                }

                }
            });
        
        });
        
    }

    //funcion para crear una nueva institucion
    function newInst() {
       
        let selInput = '';
            selInput =`<select id="estatus"  class="swal2-input" placeholder="activar o desactivar"  style="width:90%;"> 
                            <option value="1" selected select >Activar</option>
                            <option value="0" >Inactivo</option>
                        </select>`;
        
        
          let html_ = ` <input type="text" id="institucion" value=""    class="swal2-input" placeholder="Nombre de institución" style="width:90%;">
                        `;
        html_ = html_ + selInput;
        Swal.fire({
        confirmButtonColor: 'var(--color-dark)',
        denyButtonColor: 'var(--color-blanco)',
        cancelButtonColor: 'var(--fondo-degradado)',

        title: 'Nueva institución ',
        html: html_,
        width:700,
        confirmButtonText: 'Guardar',
        showCancelButton: true,
        cancelButtonText: 'Salir',
        focusConfirm: false,
        preConfirm: () => {
            const institucion = Swal.getPopup().querySelector('#institucion').value
            const estatus = Swal.getPopup().querySelector('#estatus').value
            
            if ( !institucion || !estatus) {
                Swal.showValidationMessage(`No puedes dejar campos en blanco`)
            }
            return {institucion,estatus }
        }
        }).then((cambios) => {
            // console.log (cambios.isConfirmed);
        
           if (cambios.isConfirmed)
             $.ajax({
                url: "./?action=config/param&modo=institucion&new=inst",
                method: "POST",
                data: {'data':cambios.value} ,
                success: function(respuesta) {
                    // dataset = JSON.parse(respuesta);
                    console.log(respuesta);
                    Swal.fire(`
                        Cambios realizados Institución
                    `.trim()).then(()=>{
                        $('#tablaInstituciones').jtable('load');//actualiza la tabla al hacer click en OK
                    })
                },
                error:{ function(e) {
                    conjsole.log(e);
                }

                }
            });
        
        });
        
    }

    //funcion para editar una institucion
    function editInst(inst) {
        console.log(inst);
        //swert alert para editar el proveedor o proveniente
       
        let selInput = '';
        if(inst.activo=='Activo'){
            selInput = `<select id="estatus"  class="swal2-input" placeholder="activar o desactivar"  style="width:90%;"> 
                        <option value="1" >`+inst.activo+`</option>
                        <option value="0">Desactivar</option>
                        </select>`;
        }
        else{
            selInput =`<select id="estatus"  class="swal2-input" placeholder="activar o desactivar"  style="width:90%;"> 
                        <option value="0" >`+inst.activo+`</option>
                        <option value="1">Activar</option>
                        </select>`;
        }
        
          let html_ = ` <input type="text" id="institucion" value="`+inst.valor+`"    class="swal2-input" placeholder="institucion" style="width:90%;">
                        <input type="hidden" id="id"   value="`+inst.id+`"    class="swal2-input" placeholder="id" style="width:90%;">`;
        html_ = html_ + selInput;
        Swal.fire({
        confirmButtonColor: 'var(--color-dark)',
        denyButtonColor: 'var(--color-blanco)',
        cancelButtonColor: 'var(--fondo-degradado)',

        title: 'ID: '+inst.id,
        html: html_,
        width:700,
        confirmButtonText: 'Guardar',
        showCancelButton: true,
        cancelButtonText: 'Salir',
        focusConfirm: false,
        preConfirm: () => {
            const id = Swal.getPopup().querySelector('#id').value
            const institucion = Swal.getPopup().querySelector('#institucion').value
            const estatus = Swal.getPopup().querySelector('#estatus').value
            
            if (!id || !institucion || !estatus) {
                Swal.showValidationMessage(`No puedes dejar campos en blanco`)
            }
            return { id,institucion,estatus }
        }
        }).then((cambios) => {
            // console.log (cambios.isConfirmed);
        
           if (cambios.isConfirmed)
             $.ajax({
                url: "./?action=config/param&modo=institucion&edit=inst",
                method: "POST",
                data: {'data':cambios.value} ,
                success: function(respuesta) {
                    // dataset = JSON.parse(respuesta);
                    console.log(respuesta);
                    Swal.fire(`
                        Cambios realizados Institución
                    `.trim()).then(()=>{
                        $('#tablaInstituciones').jtable('load');//actualiza la tabla al hacer click en OK
                    })
                },
                error:{ function(e) {
                    conjsole.log(e);
                }

                }
            });
        
        });
        
    }

    //funcion para crear una nueva autoridad
    function newAutoridad() {
       
       let selInput = '';
           selInput =`<select id="estatus"  class="swal2-input" placeholder="activar o desactivar"  style="width:90%;"> 
                           <option value="1" selected select >Activar</option>
                           <option value="0" >Inactivo</option>
                       </select>`;
       
       
         let html_ = ` <input type="text" id="autoridad" value=""    class="swal2-input" placeholder="Nombre de autoridad" style="width:90%;">
                       `;
       html_ = html_ + selInput;
       Swal.fire({
       confirmButtonColor: 'var(--color-dark)',
       denyButtonColor: 'var(--color-blanco)',
       cancelButtonColor: 'var(--fondo-degradado)',

       title: 'Nueva Autoridad ',
       html: html_,
       width:700,
       confirmButtonText: 'Guardar',
       showCancelButton: true,
       cancelButtonText: 'Salir',
       focusConfirm: false,
       preConfirm: () => {
           const autoridad = Swal.getPopup().querySelector('#autoridad').value
           const estatus = Swal.getPopup().querySelector('#estatus').value
           
           if ( !autoridad || !estatus) {
               Swal.showValidationMessage(`No puedes dejar campos en blanco`)
           }
           return {autoridad,estatus }
       }
       }).then((cambios) => {
           // console.log (cambios.isConfirmed);
       
          if (cambios.isConfirmed)
            $.ajax({
               url: "./?action=config/param&modo=autoridad&new=auto",
               method: "POST",
               data: {'data':cambios.value} ,
               success: function(respuesta) {
                   // dataset = JSON.parse(respuesta);
                   console.log(respuesta);
                   Swal.fire(`
                       Cambios realizados Autoridad
                   `.trim()).then(()=>{
                       $('#tablaAutoridades').jtable('load');//actualiza la tabla al hacer click en OK
                   })
               },
               error:{ function(e) {
                   conjsole.log(e);
               }

               }
           });
       
       });
       
   }

    //funcion para editar una editAutoridad
    function editAutoridad(autoridad) {
        console.log(autoridad);
        //swert alert para editar el proveedor o proveniente
       console.log(autoridad);
        let selInput = '';
        if(autoridad.activo=='Activo'){
            selInput = `<select id="estatus"  class="swal2-input" placeholder="activar o desactivar"  style="width:90%;"> 
                        <option value="1" >`+autoridad.activo+`</option>
                        <option value="0">Desactivar</option>
                        </select>`;
        }
        else{
            selInput =`<select id="estatus"  class="swal2-input" placeholder="activar o desactivar"  style="width:90%;"> 
                        <option value="0" >`+autoridad.activo+`</option>
                        <option value="1">Activar</option>
                        </select>`;
        }
        
          let html_ = ` <input type="text" id="autoridad"  value="`+autoridad.valor+`"    class="swal2-input" placeholder="autoridad" style="width:90%;">
                        <input type="hidden" id="id"   value="`+autoridad.id+`"    class="swal2-input" placeholder="id" style=";width:90%;">`;
        html_ = html_ + selInput;
        Swal.fire({
        confirmButtonColor: 'var(--color-dark)',
        denyButtonColor: 'var(--color-blanco)',
        cancelButtonColor: 'var(--fondo-degradado)',

        title: 'ID: '+autoridad.id,
        html: html_,
        confirmButtonText: 'Guardar',
        showCancelButton: true,
        cancelButtonText: 'Salir',
        focusConfirm: false,
        preConfirm: () => {
            const id = Swal.getPopup().querySelector('#id').value
            const autoridad = Swal.getPopup().querySelector('#autoridad').value
            const estatus = Swal.getPopup().querySelector('#estatus').value
            
            if (!id || !autoridad || !estatus) {
            Swal.showValidationMessage(`No puedes dejar campos en blanco`)
            }
            return { id,autoridad,estatus}
        }
        }).then((cambios) => {
            // console.log (cambios.isConfirmed);
        
           if (cambios.isConfirmed)
             $.ajax({
                url: "./?action=config/param&modo=autoridad&edit=auto",
                method: "POST",
                data: {'data':cambios.value} ,
                success: function(respuesta) {
                    // dataset = JSON.parse(respuesta);
                    console.log(respuesta);
                    Swal.fire(`
                        Cambios realizados autoridad
                    `.trim()).then(()=>{
                        $('#tablaAutoridades').jtable('load');//actualiza la tabla al hacer click en OK
                    })
                },
                error:{ function(e) {
                    conjsole.log(e);
                }

                }
            });
        
        });
        
    }
</script>


<style defer>
    .swal2-file, .swal2-input, .swal2-textarea {
    font-size: 0.925em !important;
    }
    .swal2-content{
        overflow-x: hidden;
    }

</style>

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
    .jtable-title-text{
        display:none !important;
    }
    .table-responsive{
        overflow-y: hidden;
    }


    @media screen and (max-width: 1768px) {
        .jtable-right-area{       
            position: absolute !important;
            margin-top: 2em !important;
        }
    }
</style>

<!-- <script defer src='./assets/js/plugins/spectrum/spectrum.js'></script> -->


<!-- /*     backgroundColor: "#f17eff"
borderColor: "#f17e5d"
descripcion: "Cortes Mena Abogados"
estatus: "Activo"
id: "101"
proveniente: "cma" */ -->