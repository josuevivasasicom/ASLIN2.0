<?php
header("Content-type: text/html");
?>
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">


<!-- inicia modal -->


<!-- newProveniente -->
<div class="modal fade" id="newArea" tabindex="1" role="dialog" aria-labelledby="newAreaLabel" aria-hidden="true"
    style="display: none;">
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
                                <select class="js-example-basic-single form-control" name="usuario" multiple="multiple"
                                    placeholder="asigna uno" style="width:100%;">
                                    <!-- name="states[]"  -->
                                    <!-- <option>Asigna un Jefe de Área</option> -->
                                    <?php
                                    $usuarios = UserData::getAllUsers();
                                    Core::preprint($usuarios);
                                    foreach ($usuarios as $key => $value) {
                                        print "<option value='" . $value['idUser'] . "'>" . $value['nombre'] . ' ' . $value['paterno'] . ' ' . $value['materno'] . "</option>";
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
                    <button id="btn-newArea" type="button" class="btn btn-default btn-simple">Crear Área</button>
                    <!-- data-dismiss="modal" -->
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
                    <h4 class="card-title"> Abogados </h4>
                    <span>Agrega Abogados</span>
                </div>
                <!-- <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">Launch demo modal</button> -->

                <div class="row">
                    <div class="update ml-auto mr-4">
                        <!-- centrado <div class="update ml-auto mr-auto"> -->
                        <button type="button" onclick="newAbogado()" class="btn btn-primary btn-round"
                            data-toggle="modal" data-target="#newAbogado">Añadir Abogado</button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <div id="tablaAbogados" class="mt-1"></div>
                    </div>
                    <!-- <script src="vistas/plugins/jtable2.4/localization/jquery.jtable.es.js" type="text/javascript"></script> -->
                </div>
            </div>
        </div>


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
                        <div class="update ml-auto mr-4">
                            <!-- centrado <div class="update ml-auto mr-auto"> -->
                            <button type="button" onclick="newProv()" class="btn btn-primary btn-round"
                                data-toggle="modal" data-target="#newProveniente">Añadir Proveniente</button>
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
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Etapas 1</h4>
                                <span>Lista por categoria de los archivos que se pueden subir..</span>
                            </div>
                            <!-- <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">Launch demo modal</button> -->

                            <div class="row">
                                <div class="update ml-auto mr-4">
                                    <!-- centrado <div class="update ml-auto mr-auto"> -->
                                    <button type="button" onclick="newTypeFileEtapa1()"
                                        class="btn   btn-primary btn-round" data-toggle="modal"
                                        data-target="#newFile1">Añadir etapa de archivo</button>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <div id="tablaTypeFilesEtapa1" class="mt-1"></div>
                                </div>
                                <!-- <script src="vistas/plugins/jtable2.4/localization/jquery.jtable.es.js" type="text/javascript"></script> -->
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Etapas 2</h4>
                                <span>Lista por categoria de los archivos que se pueden subir..</span>
                            </div>
                            <!-- <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">Launch demo modal</button> -->

                            <div class="row">
                                <div class="update ml-auto mr-4">
                                    <!-- centrado <div class="update ml-auto mr-auto"> -->
                                    <button type="button" onclick="newTypeFileEtapa2()"
                                        class="btn   btn-primary btn-round" data-toggle="modal"
                                        data-target="#newFile2">Añadir etapa de archivo</button>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <div id="tablaTypeFilesEtapa2" class="mt-1"></div>
                                </div>
                                <!-- <script src="vistas/plugins/jtable2.4/localization/jquery.jtable.es.js" type="text/javascript"></script> -->
                            </div>
                        </div>
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
                        <div class="update ml-auto mr-4">
                            <!-- centrado <div class="update ml-auto mr-auto"> -->
                            <button type="button" onclick="newTypeFile()" class="btn   btn-primary btn-round"
                                data-toggle="modal" data-target="#newFileUno">Añadir etapa de archivo</button>
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
                        <div class="update ml-auto mr-4">
                            <!-- centrado <div class="update ml-auto mr-auto"> -->
                            <button onclick="newInst()" class="btn btn-primary btn-round" data-toggle="modal"
                                data-target="#newProveniente">Añadir Institución</button>
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
                        <span>Despliega select del Autoridad, para crear un nuevo siniestro. Listadod e
                            Autoridades</span>
                    </div>
                    <!-- <button class="btn btn-danger" data-toggle="modal" data-target="#myModal">Launch demo modal</button> -->

                    <div class="row">
                        <div class="update ml-auto mr-4">
                            <!-- centrado <div class="update ml-auto mr-auto"> -->
                            <button onclick="newAutoridad()" type="button" class="btn btn-primary btn-round"
                                data-toggle="modal" data-target="#newAutoridad">Añadir Autoridad</button>
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
                        <div class="update ml-auto mr-4">
                            <!-- centrado <div class="update ml-auto mr-auto"> -->
                            <button type="submit" class="btn btn-primary btn-round" data-toggle="modal"
                                data-target="#newAutoridad">Añadir Estatus</button>
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
                        <div class="update ml-auto mr-4">
                            <!-- centrado <div class="update ml-auto mr-auto"> -->
                            <button type="submit" class="btn btn-primary btn-round" data-toggle="modal"
                                data-target="#newAutoridad">Añadir Calificación</button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div id="tablaCalificacion" class="mt-1"></div>
                        <!-- <script src="vistas/plugins/jtable2.4/localization/jquery.jtable.es.js" type="text/javascript"></script> -->
                    </div>
                </div>
            </div>
        </div>

    </div> <!-- //final -->


    <script type="text/javascript" defer>
    window.onload = function() {
        /******
        JTABLES
        ******/

        //activar jtable provenientes
        var botonazo = "";
        $('#tablaProvenientes').jtable({
            title: 'Lista de Todos los Provenientes / Proveedores',
            messages: {
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
                editar: {
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

        var botonazo = "";
        $('#tablaAbogados').jtable({
            title: 'Lista de Todos los Abogados / Abogados',
            messages: {
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
                listAction: '?action=jtable/tablaAbogados.ajax&jtable=jtable'
            },
            fields: {
                editar: {
                    title: 'Editar',
                    style: 'jtable-command-column siniestros-ver',
                    width: '3%',
                    sorting: false,
                    edit: false,
                    create: false,
                    display: function(siniestro) {
                        //Create an image that will be used to open child table
                        // var $img = $('<img src="/Content/images/Misc/phone.png" title="Edit phone numbers" />');


                        console.log(siniestro);

                        var $img = $(
                            '<center><i><img src="https://asicomgraphics.mx/demos/dxlegal/editar.png"></i></center>'
                            //'<center><btn class="btn btn-sm btn-outline-danger btn-round btn-icon"><i class="nc-icon nc-layout-11" style="font-size: 1.5em;"></i></btn></center>'
                        );

                        //Open child table muestra usuarios que pertenecen a esa area y su grupo!
                        $img.click(function() {
                            // alert(siniestro.record.folio);


                            editAbog(siniestro.record);
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
                nombre: {
                    title: 'Nombre',
                    width: '10%'
                },
                paterno: {
                    title: 'Apellido Paterno',
                    width: '20%'
                },
                materno: {
                    title: 'Apellido Materno',
                    width: '20%'
                },
                email: {
                    title: 'Email',
                    width: '10%'
                },
                rol: {
                    title: 'Tipo de Usuario',
                    width: '7%'
                },
                area: {
                    title: 'Area',
                    width: '7%'
                },
                estatus: {
                    title: 'Estatus',
                    width: '7%'
                },
            }
        });
        $('#tablaAbogados').jtable('load');


        //funcion para editar un abogado
        function editAbog(abog) {
            //swert alert para editar el abogado

            let selInput3 = '';
            let selInput2 = '';
            let selInput = '';
            if (abog.estatus == 'Activo') {
                selInput = `<br/><label>Estatus</label><select id="estatus"  class="swal2-input" placeholder="activar o desactivar"  style="width:50%;"> 
                        <option value="1" >` + abog.estatus + `</option>
                        <option value="0">Desactivar</option>
                        </select>`;
            } else {
                selInput = `<br/><label>Estatus</label><select id="estatus" class="swal2-input" placeholder="activar o desactivar"  style="width:50%;"> 
                        <option value="0" >` + abog.estatus + `</option>
                        <option value="1">Activar</option>
                        </select>`;
            }

            selInput2 = `<br/><label>Tipo de Usuario</label><select id="rol"  class="swal2-input" placeholder="Tipo de Usuario"  style="width:50%;"> 
                        <option value="` + abog.id_rol + `" >` + abog.rol + `</option>
                        <option value="1">Super Administrador</option>
                        <option value="2">Jefe de Área</option>
                        <option value="4">Administrador de Siniestros</option>
                        <option value="3">Abogado</option>
                        </select>`;

            selInput3 = `<br/><label>Área</label><select id="area"  class="swal2-input" placeholder="Área" style="width:70%;"> 
                        <option value="` + abog.id_area + `" >` + abog.area + `</option>
                        <option value="1">Servidores Publicos</option>
                        <option value="2">Penal</option>
                        <option value="3">Siniestros</option>
                        <option value="4">Administración</option>
                        <option value="5">Contabilidad</option>
                        <option value="6">Cancelados</option>
                        <option value="7">Civil</option>
                        </select>`;


            let html_ = `<label>Nombre</label><input type="text" id="abogado" value="` + abog.nombre + `" class="swal2-input" placeholder="Nombre del Abogado" style="text-transform: uppercase;width:70%;">                
            <label>Paterno</label><input type="text" id="abogadoP" value="` + abog.paterno + `" class="swal2-input" placeholder="Apellido P. del Abogado" style="text-transform: uppercase;width:70%;">
            <label>Materno</label><input type="text" id="abogadoM" value="` + abog.materno + `" class="swal2-input" placeholder="Apellido M. del Abogado" style="text-transform: uppercase;width:70%;">
            <label>Correo</label><input type="text" id="email" style="width:70%;" value="` + abog.email +
                `" autocomplete="off" class="swal2-input" placeholder="Correo Electrónico" style="">
               <label>Fecha de nacimento</label><input type="date" placeholder="Fecha de fechaNacimiento" id="fechaNacimiento" value="` +
                abog
                .fechaNacimiento +
                `" class="swal2-input" style="width:40%;">`;
            let id_abogado = abog.id;
            html_ = html_ + selInput + selInput2 + selInput3;
            Swal.fire({
                title: 'ID: ' + abog.id,
                html: html_,
                confirmButtonText: 'Guardar',
                showCancelButton: true,
                cancelButtonText: 'Salir',
                focusConfirm: false,
                preConfirm: () => {
                    const abog = Swal.getPopup().querySelector('#abogado').value
                    const paterno = Swal.getPopup().querySelector('#abogadoP').value
                    const materno = Swal.getPopup().querySelector('#abogadoM').value
                    const email = Swal.getPopup().querySelector('#email').value
                    const fechaNac = Swal.getPopup().querySelector('#fechaNacimiento').value
                    const estatus = Swal.getPopup().querySelector('#estatus').value
                    const area = Swal.getPopup().querySelector('#area').value
                    const rol = Swal.getPopup().querySelector('#rol').value
                    const id = id_abogado

                    if (!abog || !paterno || !materno || !estatus || !email || !fechaNac || !area || !
                        id_abogado) {
                        Swal.showValidationMessage(`No puedes dejar campos en blanco`)

                    }
                    return {
                        id,
                        abog,
                        paterno,
                        materno,
                        email,
                        fechaNac,
                        estatus,
                        area,
                        rol
                    }
                }
            }).then((cambios) => {
                // console.log (cambios.isConfirmed);

                if (cambios.isConfirmed)
                    $.ajax({
                        url: "./?action=config/param&modo=abogado&edit=abog",
                        method: "POST",
                        data: {
                            'data': cambios.value
                        },
                        success: function(respuesta) {
                            // dataset = JSON.parse(respuesta);
                            // console.log(respuesta);
                            Swal.fire(`
                                Cambios realizados 
                            `.trim()).then(() => {
                                $('#tablaAbogados').jtable('load');
                            })
                        },
                        error: {
                            function(e) {
                                conjsole.log(e);
                            }

                        }
                    });

            });

        }





        //activar jtable instituciones
        $('#tablaInstituciones').jtable({
            title: 'Lista de Instituciones',
            messages: {
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
                editar: {
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
                            '<center><img src="https://asicomgraphics.mx/demos/dxlegal/editar.png"></i></center>'
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
            messages: {
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
                editar: {
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
                            '<center><i><img src="https://asicomgraphics.mx/demos/dxlegal/editar.png"></i></center>'
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
            messages: {
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
                editar: {
                    title: 'Editar',
                    style: 'jtable-command-column estatus-ver',
                    width: '3%',
                    sorting: false,
                    edit: false,
                    create: false,
                    display: function(estatus) {
                        //Create an image that will be used to open child table
                        var $img = $(
                            '<center><img src="https://asicomgraphics.mx/demos/dxlegal/editar.png"></center>'
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
            messages: {
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
                editar: {
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
        $('#tablaCalificacion').jtable('load');

        $('#tablaTypeFilesEtapa1').jtable({
            title: 'tableTypeFileEtapa1',
            messages: {
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
                listAction: '?action=jtable/tablaTypeFile.ajax&jtabletapa1=jtabletapa1',
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
                    title: '1',
                    width: '10%'
                },
            }
        });

        $('#tablaTypeFilesEtapa1').jtable('load');



        $('#tablaTypeFilesEtapa2').jtable({
            title: 'tableTypeFileEtapa',
            messages: {
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
                listAction: '?action=jtable/tablaTypeFile.ajax&jtabletapa2=jtabletapa2',
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
                c2: {
                    title: '1',
                    key: true,
                    list: true,
                    width: '3%'
                },


                valor: {
                    title: '2',
                    width: '10%'
                },
            }
        });

        $('#tablaTypeFilesEtapa2').jtable('load');

        //activar jtable tableTypeFile tipo de archivo
        $('#tablaTypeFiles').jtable({
            title: 'tableTypeFile',
            messages: {
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
        $('.js-example-basic-single').select2({
            placeholder: "Asigna un Jefe de Área"
        });

        $('#btn-newArea').on('click', function() {
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

    function swalertOk(title, text) {
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
        if (prov.estatus == 'Activo') {
            selInput = `<select id="estatus"  class="swal2-input" placeholder="activar o desactivar"  style="width:90%;"> 
                        <option value="1" >` + prov.estatus + `</option>
                        <option value="0">Desactivar</option>
                        </select>`;
        } else {
            selInput = `<select id="estatus"  class="swal2-input" placeholder="activar o desactivar"  style="width:90%;"> 
                        <option value="0" >` + prov.estatus + `</option>
                        <option value="1">Activar</option>
                        </select>`;
        }

        let html_ = ` <input type="text" id="prov"          value="` + prov.proveniente.toUpperCase() + `"    class="swal2-input" placeholder="prov" style="text-transform: uppercase;width:90%;">
                        <input type="text" id="descripcion"   value="` + prov.descripcion.toUpperCase() +
            `"    class="swal2-input" placeholder="desc" style="text-transform: uppercase;width:90%;">`;
        html_ = html_ + selInput;
        html_ = html_ + `<label style="margin-top: 1em;">borde</label>
                        <input id="border"     value="` + prov.borderColor + `" class="swal2-input" placeholder="" style="display:none">
                        <label style="margin-top: 1em;">fondo</label>
                        <input id='background' value="` + prov.backgroundColor + `" class="swal2-input" placeholder="" style="display:none">
                        <input id='idProv' value="` + prov.id + `" type="hidden" style="display:none">
                        `,
            Swal.fire({
                confirmButtonColor: 'var(--color-blanco)',
                denyButtonColor: 'var(--color-blanco)',
                cancelButtonColor: 'var(--color-blanco)',

                title: 'ID: ' + prov.id,
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
                    return {
                        prov,
                        descripcion,
                        estatus,
                        border,
                        background,
                        id
                    }
                }
            }).then((cambios) => {
                // console.log (cambios.isConfirmed);

                if (cambios.isConfirmed)
                    $.ajax({
                        url: "./?action=config/param&modo=proveniente&edit=prov",
                        method: "POST",
                        data: {
                            'data': cambios.value
                        },
                        success: function(respuesta) {
                            // dataset = JSON.parse(respuesta);
                            console.log(respuesta);
                            Swal.fire(`
                        Cambios realizados 
                    `.trim()).then(() => {
                                $('#tablaProvenientes').jtable(
                                    'load'); //actualiza la tabla al hacer click en OK
                            })
                        },
                        error: {
                            function(e) {
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

        selInput = `<select id="estatus"  class="swal2-input" placeholder="activar o desactivar"  style="width:90%;"> 
                        <option value="1">Activo</option>
                        <option value="0" >Deshabilitado</option>
                        </select>`;


        let html_ =
            ` <input type="text" id="prov"          value=""    class="swal2-input" placeholder="Siglas de Proveniente" style="text-transform: uppercase;width:90%;">
                        <input type="text" id="descripcion"   value=""    class="swal2-input" placeholder="Descripción" style="text-transform: uppercase;width:90%;">`;
        html_ = html_ + selInput;
        html_ = html_ + `<label style="margin-top: 1em;">borde</label>
                        <input id="border"     value="" class="swal2-input" placeholder="" style="display:none">
                        <label style="margin-top: 1em;">fondo</label>
                        <input id='background' value="" class="swal2-input" placeholder="" style="display:none">
                        `,
            Swal.fire({
                confirmButtonColor: 'var(--color-blanco)',
                denyButtonColor: 'var(--color-blanco)',
                cancelButtonColor: 'var(--color-blanco)',

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
                    return {
                        prov,
                        descripcion,
                        estatus,
                        border,
                        background
                    }
                }
            }).then((cambios) => {
                // console.log (cambios.isConfirmed);

                if (cambios.isConfirmed)
                    $.ajax({
                        url: "./?action=config/param&modo=proveniente&new=prov",
                        method: "POST",
                        data: {
                            'data': cambios.value
                        },
                        success: function(respuesta) {
                            // dataset = JSON.parse(respuesta);
                            console.log(respuesta);
                            Swal.fire(`
                        Cambios realizados 
                    `.trim()).then(() => {
                                $('#tablaProvenientes').jtable(
                                    'load'); //actualiza la tabla al hacer click en OK
                            })
                        },
                        error: {
                            function(e) {
                                conjsole.log(e);
                            }

                        }
                    });

            });

    }

    function capitalize(texto) {
        return texto[0].toUpperCase() + texto.slice(1);
    }


    // Función para crear un abogado
    function newAbogado(abogado) {
        // SweetAlert para crear al abogado


        let selInputArea = '';

        selInputArea = `<select id="area" class="swal2-input" placeholder="Área" style="width:90%;">
                                <option value="0">Selecciona un área</option>
                                
                            </select>`;

        let selInput = '';

        selInput = `<select id="estatus" class="swal2-input" placeholder="Activar o desactivar" style="width:90%;">
                            <option value="1">Activo</option>
                            <option value="0">Deshabilitado</option>
                        </select>`;

        let html_ = `<input type="text" id="abogado" value="" class="swal2-input" placeholder="Nombre del Abogado" style="text-transform: uppercase;width:90%;">                
        <input type="text" id="abogadoP" value="" class="swal2-input" placeholder="Apellido P. del Abogado" style="text-transform: uppercase;width:90%;">
        <input type="text" id="abogadoM" value="" class="swal2-input" placeholder="Apellido M. del Abogado" style="text-transform: uppercase;width:90%;">
               <input type="text" id="email" value="" class="swal2-input" placeholder="Correo Electrónico" style="text-transform: uppercase;width:90%;">
               <input type="date" placeholder="Fecha de fechaNacimiento" id="fechaNacimiento" value="" class="swal2-input" style="width:90%;"><p>Fecha de nacimento</p>
               <input type="password" id="password" value="" class="swal2-input" placeholder="Contraseña" style="width:90%;">`;

               selInput3 = `<br/><label>Área</label><select id="area"  class="swal2-input" placeholder="Área" style="width:70%;"> 
                        <option value="1">Servidores Publicos</option>
                        <option value="2">Penal</option>
                        <option value="3">Siniestros</option>
                        <option value="4">Administración</option>
                        <option value="5">Contabilidad</option>
                        <option value="6">Cancelados</option>
                        <option value="7">Civil</option>
                        </select>`;

                        selInput2 = `<br/><label>Tipo de Usuario</label><select id="tipoUsuario"  class="swal2-input" placeholder="Tipo de Usuario"  style="width:50%;"> 
                        <option value="1">Super Administrador</option>
                        <option value="2">Jefe de Área</option>
                        <option value="4">Administrador de Siniestros</option>
                        <option value="3">Abogado</option>
                        </select>`;

        html_ = html_ + selInput + selInput2 + selInput3;


        Swal.fire({
            confirmButtonColor: 'var(--color-blanco)',
            denyButtonColor: 'var(--color-blanco)',
            cancelButtonColor: 'var(--color-blanco)',

            title: 'Crear nuevo Abog.',
            html: html_,
            confirmButtonText: 'Nuevo',
            showCancelButton: true,
            cancelButtonText: 'Salir',
            focusConfirm: false,
            preConfirm: () => {
                const nombre = Swal.getPopup().querySelector('#abogado').value.trim();
                const apAbogadoP = Swal.getPopup().querySelector('#abogadoP').value;
                const apAbogadoM = Swal.getPopup().querySelector('#abogadoM').value;
                const email = Swal.getPopup().querySelector('#email').value;
                const fechaNacimiento = Swal.getPopup().querySelector('#fechaNacimiento').value;
                const tipoUsuario = Swal.getPopup().querySelector('#tipoUsuario').value;
                const password = Swal.getPopup().querySelector('#password').value;
                const area = Swal.getPopup().querySelector('#area').value;
                const estatus = Swal.getPopup().querySelector('#estatus').value;               

                if (!nombre || !apAbogadoM || !apAbogadoP || !email || !tipoUsuario || !area || !estatus) {
                    Swal.showValidationMessage('No puedes dejar campos en blanco');
                }


                    let nombre_limpio = '';
                    let apellidoP = capitalize(apAbogadoP);
                    let apellidoM = capitalize(apAbogadoM);

                    if (Array.isArray(nombre.split(' '))) {
                        const separaciones_nombre = nombre.split(' ');
                        for (var i = 0; i < separaciones_nombre.length; i++) {
                            nombre_limpio += ' ' + capitalize(separaciones_nombre[i]);
                        }

                        nombre_limpio = nombre_limpio.trim();
                    }
                

                
                return {
                    nombre_limpio,
                    apellidoP,
                    apellidoM,
                    email,
                    tipoUsuario,
                    area,
                    password,
                    estatus,
                    fechaNacimiento
                };
            }
        }).then((cambios) => {
            if (cambios.isConfirmed) {
                $.ajax({
                    url: "./?action=config/param&modo=abogado&new=abog",
                    method: "POST",
                    data: {
                        'data': cambios.value
                    },
                    success: function(respuesta) {
                        console.log(respuesta);
                        Swal.fire('Se genero el abogado.').then(() => {
                            $('#tablaAbogados').jtable(
                                'load'); // Actualiza la tabla al hacer clic en OK
                        });
                    },
                    error: function(e) {
                        console.log(e);
                    }
                });
            }
        });
    }


    //funcion para crear un typo de archivo newTypeFile()
    function newTypeFile() {

        setTimeout(function() {
            $.ajax({

                method: "POST",
                url: "?action=jtable/tablaTypeFile.ajax&jtabledos=jtabledos",
                data: {}

            }).done(function(data) {

                console.log("dererreredsfsfdfsdfwr");
                console.log(JSON.parse(data));

                let options = `<option class="" >Elige una etapa</option>`;

                let dataRec = JSON.parse(data);

                dataRec.forEach(element => {

                    console.log(element['id']);
                    options +=
                        `
                            <option class="" value="${element['c_id']}">
                                <div class="">
                                  [  ${element['c3']} ]  
                                    ${element['c_valor']} - 
                                    
                                </div>
                            </option>
                        `;
                });


                $("#dsep").html(options);

            }).fail(function() {

                console.log("fallas en recienetes+++");

            });

            var $disabledResults = $(".js-select2-tags-optionss");
            $disabledResults.select2();



        }, 500);
        //swert alert crear al tipo por categoria de archivos
        let html_ = ` <select id="dsep" class="js-select2-tags-optionss form-control" placeholder="Selecciona Institución" tag="true" name="btnInstitucion" >
          

          </select>
                        <input type="text" id="descripcion"   value=""    class="swal2-input" placeholder="Descripción" style="text-transform: uppercase;width:90%;">
                        `;
        Swal.fire({
            confirmButtonColor: 'var(--color-blanco)',
            denyButtonColor: 'var(--color-blanco)',
            cancelButtonColor: 'var(--color-blanco)',

            title: 'Crear nueva clasificasión.',
            html: html_,
            confirmButtonText: 'Nueva',
            showCancelButton: true,
            cancelButtonText: 'Salir',
            focusConfirm: false,
            preConfirm: () => {
                /*  const etapa1 = Swal.getPopup().querySelector('#prov').value;
                 const etapa2 = Swal.getPopup().querySelector('#descripcion').value;
                 const tipo = Swal.getPopup().querySelector('#estatus').value;
                 
                 if (!etapa1 || !etapa2 || !tipo) {
                 Swal.showValidationMessage(`No puedes dejar campos en blanco`)
                 }
                 return { etapa1,etapa2,tipo} */
                var descripcion = Swal.getPopup().querySelector('#descripcion').value;
                var valorid = Swal.getPopup().querySelector('#dsep').value;
                var tipo = "Nuevo etapa 3";



                return {
                    descripcion,
                    valorid,
                    tipo
                }
            }
        }).then((cambios) => {
            console.log(cambios.value.descripcion);
            console.log(cambios.value.valorid);

            if (cambios.isConfirmed)
                $.ajax({
                    url: "./?action=config/param&modo=typeFile&new=cat",
                    method: "POST",
                    data: {
                        'data': cambios.value
                    },
                    success: function(respuesta) {
                        // dataset = JSON.parse(respuesta);
                        console.log(respuesta);
                        Swal.fire(`
                        Cambios realizados en tipo de archivo
                    `.trim()).then(() => {
                            $('#tablaTypeFile').jtable(
                                'load'); //actualiza la tabla al hacer click en OK
                        })
                    },
                    error: {
                        function(e) {
                            conjsole.log(e);
                        }

                    }
                });

        });

    }

    function newTypeFileEtapa1() {



        //swert alert crear al tipo por categoria de archivos
        let html_ = ` 
                        <input type="text" id="descripcion"   value=""    class="swal2-input" placeholder="Descripción" style="text-transform: uppercase;width:90%;">
                        `;
        Swal.fire({
            confirmButtonColor: 'var(--color-blanco)',
            denyButtonColor: 'var(--color-blanco)',
            cancelButtonColor: 'var(--color-blanco)',

            title: 'Crear nueva clasificación.',
            html: html_,
            confirmButtonText: 'Nueva',
            showCancelButton: true,
            cancelButtonText: 'Salir',
            focusConfirm: false,
            preConfirm: () => {


                var descripcion = Swal.getPopup().querySelector('#descripcion').value;
                var tipo = "Nuevo etapa 3";
                return {
                    descripcion,
                    tipo
                }
            }
        }).then((cambios) => {
            console.log(cambios.value.descripcion);

            if (cambios.isConfirmed)
                $.ajax({
                    url: "./?action=config/param&modo=typeFile&new=etapa1",
                    method: "POST",
                    data: {
                        'data': cambios.value
                    },
                    success: function(respuesta) {
                        // dataset = JSON.parse(respuesta);
                        console.log(respuesta);
                        Swal.fire(`
                        Cambios realizados en tipo de archivo
                    `.trim()).then(() => {
                            $('#tablaTypeFile').jtable(
                                'load'); //actualiza la tabla al hacer click en OK
                        })
                    },
                    error: {
                        function(e) {
                            conjsole.log(e);
                        }

                    }
                });

        });

    }

    function newTypeFileEtapa2() {

        setTimeout(function() {
            $.ajax({

                method: "POST",
                url: "?action=jtable/tablaTypeFile.ajax&jtabledosetapa2=jtabledosetapa2",
                data: {}

            }).done(function(data) {

                console.log("dererreredsfsfdfsdfwr");
                console.log(JSON.parse(data));

                let options = `<option class="" >Elige una etapa</option>`;

                let dataRec = JSON.parse(data);

                dataRec.forEach(element => {

                    console.log(element['id']);
                    options +=
                        `
                            <option class="" value="${element['id']}">
                                <div class="">
                                  [  ${element['valor']} ]  
                                    
                                </div>
                            </option>
                        `;
                });


                $("#optionsdos").html(options);

            }).fail(function() {

                console.log("fallas en recienetes+++");

            });

            var $etapados = $(".js-select2-tags-option-etapa2");
            $etapados.select2();



        }, 500);

        //swert alert crear al tipo por categoria de archivos
        let html_ = ` 
        <select id="optionsdos" class="js-select2-tags-option-etapa2 form-control" placeholder="Selecciona Institución" tag="true" name="btnInstitucion" >
          </select>
                        <input type="text" id="descripcion"   value=""    class="swal2-input" placeholder="Descripción" style="text-transform: uppercase;width:90%;">
                        `;
        Swal.fire({
            confirmButtonColor: 'var(--color-blanco)',
            denyButtonColor: 'var(--color-blanco)',
            cancelButtonColor: 'var(--color-blanco)',

            title: 'Crear nueva clasificación.',
            html: html_,
            confirmButtonText: 'Nueva',
            showCancelButton: true,
            cancelButtonText: 'Salir',
            focusConfirm: false,
            preConfirm: () => {


                var descripcion = Swal.getPopup().querySelector('#descripcion').value;
                var valorid = Swal.getPopup().querySelector('#optionsdos').value;


                var tipo = "Nuevo etapa 3";

                return {
                    descripcion,
                    valorid,
                    tipo
                }
            }
        }).then((cambios) => {


            if (cambios.isConfirmed)
                $.ajax({
                    url: "./?action=config/param&modo=typeFile&new=etapa2",
                    method: "POST",
                    data: {
                        'data': cambios.value
                    },
                    success: function(respuesta) {
                        // dataset = JSON.parse(respuesta);
                        console.log(respuesta);
                        Swal.fire(`
                        Cambio realizado.
                    `.trim()).then(() => {
                            $('#tablaTypeFilesEtapa2').jtable(
                                'load'); //actualiza la tabla al hacer click en OK
                        })
                    },
                    error: {
                        function(e) {
                            conjsole.log(e);
                        }

                    }
                });

        });



    }

    //funcion para crear una nueva institucion
    function newInst() {

        let selInput = '';
        selInput = `<select id="estatus"  class="swal2-input" placeholder="activar o desactivar"  style="width:90%;"> 
                            <option value="1" selected select >Activar</option>
                            <option value="0" >Inactivo</option>
                        </select>`;


        let html_ = ` <input type="text" id="institucion" value=""    class="swal2-input" placeholder="Nombre de institución" style="width:90%;">
                        `;
        html_ = html_ + selInput;
        Swal.fire({
            confirmButtonColor: 'var(--color-blanco)',
            denyButtonColor: 'var(--color-blanco)',
            cancelButtonColor: 'var(--color-blanco)',

            title: 'Nueva institución ',
            html: html_,
            width: 700,
            confirmButtonText: 'Guardar',
            showCancelButton: true,
            cancelButtonText: 'Salir',
            focusConfirm: false,
            preConfirm: () => {
                const institucion = Swal.getPopup().querySelector('#institucion').value
                const estatus = Swal.getPopup().querySelector('#estatus').value

                if (!institucion || !estatus) {
                    Swal.showValidationMessage(`No puedes dejar campos en blanco`)
                }
                return {
                    institucion,
                    estatus
                }
            }
        }).then((cambios) => {
            // console.log (cambios.isConfirmed);

            if (cambios.isConfirmed)
                $.ajax({
                    url: "./?action=config/param&modo=institucion&new=inst",
                    method: "POST",
                    data: {
                        'data': cambios.value
                    },
                    success: function(respuesta) {
                        // dataset = JSON.parse(respuesta);
                        console.log(respuesta);
                        Swal.fire(`
                        Cambios realizados Institución
                    `.trim()).then(() => {
                            $('#tablaInstituciones').jtable(
                                'load'); //actualiza la tabla al hacer click en OK
                        })
                    },
                    error: {
                        function(e) {
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
        if (inst.activo == 'Activo') {
            selInput = `<select id="estatus"  class="swal2-input" placeholder="activar o desactivar"  style="width:90%;"> 
                        <option value="1" >` + inst.activo + `</option>
                        <option value="0">Desactivar</option>
                        </select>`;
        } else {
            selInput = `<select id="estatus"  class="swal2-input" placeholder="activar o desactivar"  style="width:90%;"> 
                        <option value="0" >` + inst.activo + `</option>
                        <option value="1">Activar</option>
                        </select>`;
        }

        let html_ = ` <input type="text" id="institucion" value="` + inst.valor + `"    class="swal2-input" placeholder="institucion" style="width:90%;">
                        <input type="hidden" id="id"   value="` + inst.id +
            `"    class="swal2-input" placeholder="id" style="width:90%;">`;
        html_ = html_ + selInput;
        Swal.fire({
            confirmButtonColor: 'var(--color-blanco)',
            denyButtonColor: 'var(--color-blanco)',
            cancelButtonColor: 'var(--color-blanco)',

            title: 'ID: ' + inst.id,
            html: html_,
            width: 700,
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
                return {
                    id,
                    institucion,
                    estatus
                }
            }
        }).then((cambios) => {
            // console.log (cambios.isConfirmed);

            if (cambios.isConfirmed)
                $.ajax({
                    url: "./?action=config/param&modo=institucion&edit=inst",
                    method: "POST",
                    data: {
                        'data': cambios.value
                    },
                    success: function(respuesta) {
                        // dataset = JSON.parse(respuesta);
                        console.log(respuesta);
                        Swal.fire(`
                        Cambios realizados Institución
                    `.trim()).then(() => {
                            $('#tablaInstituciones').jtable(
                                'load'); //actualiza la tabla al hacer click en OK
                        })
                    },
                    error: {
                        function(e) {
                            conjsole.log(e);
                        }

                    }
                });

        });

    }

    //funcion para crear una nueva autoridad
    function newAutoridad() {

        let selInput = '';
        selInput = `<select id="estatus"  class="swal2-input" placeholder="activar o desactivar"  style="width:90%;"> 
                           <option value="1" selected select >Activar</option>
                           <option value="0" >Inactivo</option>
                       </select>`;


        let html_ = ` <input type="text" id="autoridad" value=""    class="swal2-input" placeholder="Nombre de autoridad" style="width:90%;">
                       `;
        html_ = html_ + selInput;
        Swal.fire({
            confirmButtonColor: 'var(--color-blanco)',
            denyButtonColor: 'var(--color-blanco)',
            cancelButtonColor: 'var(--color-blanco)',

            title: 'Nueva Autoridad ',
            html: html_,
            width: 700,
            confirmButtonText: 'Guardar',
            showCancelButton: true,
            cancelButtonText: 'Salir',
            focusConfirm: false,
            preConfirm: () => {
                const autoridad = Swal.getPopup().querySelector('#autoridad').value
                const estatus = Swal.getPopup().querySelector('#estatus').value

                if (!autoridad || !estatus) {
                    Swal.showValidationMessage(`No puedes dejar campos en blanco`)
                }
                return {
                    autoridad,
                    estatus
                }
            }
        }).then((cambios) => {
            // console.log (cambios.isConfirmed);

            if (cambios.isConfirmed)
                $.ajax({
                    url: "./?action=config/param&modo=autoridad&new=auto",
                    method: "POST",
                    data: {
                        'data': cambios.value
                    },
                    success: function(respuesta) {
                        // dataset = JSON.parse(respuesta);
                        console.log(respuesta);
                        Swal.fire(`
                       Cambios realizados Autoridad
                   `.trim()).then(() => {
                            $('#tablaAutoridades').jtable(
                                'load'); //actualiza la tabla al hacer click en OK
                        })
                    },
                    error: {
                        function(e) {
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
        if (autoridad.activo == 'Activo') {
            selInput = `<select id="estatus"  class="swal2-input" placeholder="activar o desactivar"  style="width:90%;"> 
                        <option value="1" >` + autoridad.activo + `</option>
                        <option value="0">Desactivar</option>
                        </select>`;
        } else {
            selInput = `<select id="estatus"  class="swal2-input" placeholder="activar o desactivar"  style="width:90%;"> 
                        <option value="0" >` + autoridad.activo + `</option>
                        <option value="1">Activar</option>
                        </select>`;
        }

        let html_ = ` <input type="text" id="autoridad"  value="` + autoridad.valor + `"    class="swal2-input" placeholder="autoridad" style="width:90%;">
                        <input type="hidden" id="id"   value="` + autoridad.id +
            `"    class="swal2-input" placeholder="id" style=";width:90%;">`;
        html_ = html_ + selInput;
        Swal.fire({
            confirmButtonColor: 'var(--color-blanco)',
            denyButtonColor: 'var(--color-blanco)',
            cancelButtonColor: 'var(--color-blanco)',

            title: 'ID: ' + autoridad.id,
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
                return {
                    id,
                    autoridad,
                    estatus
                }
            }
        }).then((cambios) => {
            // console.log (cambios.isConfirmed);

            if (cambios.isConfirmed)
                $.ajax({
                    url: "./?action=config/param&modo=autoridad&edit=auto",
                    method: "POST",
                    data: {
                        'data': cambios.value
                    },
                    success: function(respuesta) {
                        // dataset = JSON.parse(respuesta);
                        console.log(respuesta);
                        Swal.fire(`
                        Cambios realizados autoridad
                    `.trim()).then(() => {
                            $('#tablaAutoridades').jtable(
                                'load'); //actualiza la tabla al hacer click en OK
                        })
                    },
                    error: {
                        function(e) {
                            conjsole.log(e);
                        }

                    }
                });

        });

    }
    </script>
    <button onclick="optionsDst()" class="btn">Clicked</button>

    <style defer>
    .swal2-file,
    .swal2-input,
    .swal2-textarea {
        font-size: 0.925em !important;
    }

    .swal2-content {
        overflow-x: hidden;
    }
    </style>

    <style defer>
    .swal2-file,
    .swal2-input,
    .swal2-textarea {
        font-size: 0.825em !important;
        color: gray;
        padding: 0px;
        margin-right: 16px;
        border: solid #d9d9d9 1px;
    }

    .select2-container--open {
        z-index: 99999999999999;
    }

    .swal2-title {
        border-bottom: 1px solid #cacaca;
        font-size: 1.8em;
        font-weight: 400;
    }

    .select2-selection.select2-selection--multiple.swal2-input {
        padding: 0px;
        margin-right: 16px;
        border: solid #d9d9d9 1px;
    }

    .jtable-title-text {
        display: none !important;
    }

    .table-responsive {
        overflow-y: hidden;
    }


    @media screen and (max-width: 1768px) {
        .jtable-right-area {
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