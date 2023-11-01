<?php
/* header("Content-type: text/html"); 
header("Expires: Mon, 30 Jan 2022 12:00:00 GMT");  
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
header("Cache-Control: no-store, no-cache, must-revalidate");  
header("Cache-Control: post-check=0, pre-check=0", false);  
header("Pragma: no-cache") */

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);

?>
<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">

<!-- modal de ver archivos de siniestro -->
<div class="modal fade" id="modalVerDocumentos" tabindex="-1" role="dialog" aria-labelledby="modalVerDocumentosLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
          <h5 class="modal-title" id="modalVerDocumentosLabel">Ver Documentos</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body" id="modal-body-docs">
                    <center>
                    <div class="row">
                    <div class="col-2">
                        <!-- <button type="button" onclick="disparadorFile()" class="btn btn-primary">añadir archivo</button> -->
                      </div>
                      <div class="col-10">
                        <div class="table">
                          <table class="table" id="table-body-docs">
                            <tr>
                              <th>ETAPA</th>
                              <th>CAT1</th>
                              <th>CAT2</th>
                              <th>REV</th>
                              <th>FECHA</th>
                              <th>ver</th>
                            </tr>
                         
                            <?php
                            $files_sn = Siniestros::verArchivosdelSiniestro('1648073016.3617');
                            if (count($files_sn)>=1){
                              $col="";
                              $render='no';
                              foreach ($files_sn as $k) {
                                switch ($k['nombre']) {
                                  case 'primeraAtencion':
                                    $k['c1'] = 'PRIMERA ATENCIÓN';
                                    $k['c2'] = 'PRIMERA ATENCIÓN';
                                    $k['c3'] = 'PRIMERA ATENCIÓN';
                                    $render='si';
                                    break;
                                  case 'informePreliminar':
                                    $k['c1'] = 'INFORME PRELIMINAR';
                                    $k['c2'] = 'INFORME PRELIMINAR';
                                    $k['c3'] = 'INFORME PRELIMINAR';
                                    $render='si';
                                    break;
                                  case 'informeCancelación':
                                    $k['c1'] = 'INFORME CANCELACIÓN';
                                    $k['c2'] = 'INFORME CANCELACIÓN';
                                    $k['c3'] = 'INFORME CANCELACIÓN';
                                    $render='si';
                                    break;
                                }
                                $col.='<tr> '.
                                '<td style="text-transform:lowercase;" >'.$k['c1'].'</td>'.
                                '<td style="text-transform:lowercase;" >'.$k['c2'].'</td>'.
                                '<td style="text-transform:lowercase;" >'.$k['c3'].'</td>'.
                                '<td style="text-transform:lowercase;" >'.$k['version'].'</td>'.
                                '<td style="text-transform:lowercase;" >'.$k['fecha'].'</td>';
                                if ($render == 'si') {//necesita renderizar documento,
                                $col.='<td style="text-transform:lowercase;" ><button onclick="vierFileF( \''.$sn['timerst'].'\'  ,\''.$k['url'].'\',  \''.$k['c1'].'\'  )" class="btn btn-primary" data-toggle="modal" data-target="#modalFileView">ver</button></td>'.
                                  '</tr>';
                                }else{
                                  //no necesita renderizar, baja el archivo tal cual
                                  $col.='<td style="text-transform:lowercase;" ><button onclick="vierFileD( \''.$sn['timerst'].'\'  ,\''.$k['url'].'\',  \''.$k['c1'].'\'  )" class="btn btn-primary" data-toggle="modal" data-target="#modalFileView">ver</button></td>'.
                                  '</tr>';
                                }
                              }
                              print $col;
                            }
                            else{//si no hay archivos
                              print "<tr><td colspan='6' class='text-center'>No hay archivos cargados aún.</td></tr>";
                            }
                           /*  core::preprint($files_sn);
                            var_dump($files_sn); */
                            ?>
                          </table>
                        </div> <!-- table responsive -->

                      </div>
                     
                      
                    </div>
                    </center>
      </div>
      <div class="modal-footer">
        <div class="divider"></div>
        <div class="right-side">
            <button type="button" class="btn btn-danger btn-simple" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- termina modal -->


<!-- Modal SE USA E VARIOS PERO SE REESCRIBEN SUS VALORES !!no borrar !!no borrar !!no borrar !!no borrar !!no borrar-->
<div class="modal fade" id="modalFileView" tabindex="-1" role="dialog" aria-labelledby="modalFileViewLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalFileViewLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalFileViewBody">
       ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<div class="content">

        <div class="row">
        <div class="col-md-12">
            <div class="card">
              <!-- filtros -->
                <div class="row">
                    <div class="col-md-12">
                        <div id="accordion">
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <button class="btn  btn-prinone btn-round" style="float:right" id="btn_prov_F" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Filtros
                                    </button>
                            
                                     <button type="button" onclick="document.location.reload()" class="btn btn-primary  btn-round mr-3 btn_prov" ><b>Ver: Todos</b></button>
                                           <?php
                                           $provenientes=Folios::obtenerProvenientes();
                                           foreach ($provenientes as $key => $value) {
                                               echo ' <button type="button" onclick="selectProv(\''.$value['proveniente'].'\')" prov="'.$value['proveniente'].'" class="btn btn-primary btn-link btn-round btn_prov" >'.strtoupper($value['proveniente']).'</button>';
                                            }
                                           ?>
                                <!-- fin row2 -->
                                </div>


                                <div class="card-header pt-0 " id="headingtwo">
                            
                                     <button type="button" onclick="document.location.reload()" class="btn btn-primary  btn-round mr-3 btn_prov" ><b>Ver: Todas</b></button>
                                           <?php
                                           $areasF=Folios::obtenerAreas();
                                           foreach ($areasF as $key => $value) {

                                               echo ' <button type="button" onclick="selectArea(\''.$value->id.'\')" prov="'.$value->area.'" class="btn btn-primary btn-link btn-round btn_prov" >'.strtoupper($value->area).'</button>';
                                            }
                                           ?>
                                        <div class="form-group col-3" style="float: right;">
                                            <select class="js-select2 form-control" placeholder="Asigna Abogado" id="abogados" name="abogados[]" multiple="multiple" style="width:100%;">
                                                <!-- name="states[]"  -->
                                                <!-- <option>Asigna Abogado</option> -->
                                                <?php
                                                $abogados = Folios::obtenerAbogados();
                                                core::sendVarToJs(json_encode($abogados), 'abogadosTodos');
                                                foreach ($abogados as $key => $value) {
                                                    print "<option value='" . $value->id . "'>" . $value->nombre . " : " . $value->area . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                <!-- fin row2 -->
                                </div>

                                <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class=" col-8 form-row mx-1">
                                                <div class="form-input input-group date" class="">
                                                    <select class="js-select2 form-control" placeholder="Proveniente" name="proveniente[]" multiple="multiple" style="width:100%;" required>  <!-- name="states[]" multiple="multiple" -->
                                                    <option> </option>
                                                        <?php
                                                        foreach ($provenientes as $key => $value) {
                                                            print "<option value='prov_".$value['proveniente']."'>".strtoupper($value['proveniente'])."</option>";
                                                        }
                                                        ?>    
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">Buscar:</span>
                                                    </div>
                                                    <input type="text" class="form-control" name="buscar" placeholder="en todo">
                                                    <!-- <input type="text" class="form-control" placeholder="Last Name"> -->
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-group input-group date">
                                                    <input name="fecha1" value="" id="fecha1" type="text" class="form-control " placeholder="Desde el día" required="">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                        <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-3">
                                                <div class="form-input input-group date">
                                                    <input name="fecha2" value="" id="fecha2" type="text" class="form-control " placeholder="Hasta el día" required="">
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">
                                                        <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1">
                                            <div id="dropdownFiltroFechas" class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                   Fecha de ...
                                                </button>
                                                <div class="dropdown-menu " aria-labelledby="dropdownMenuButton">
                                                    <a class="dropdown-item" href="#">Captura</a>
                                                    <a class="dropdown-item" href="#">Reporte</a>
                                                    <a class="dropdown-item" href="#">Asignación</a>
                                                </div>
                                            </div>
                                  

                                            </div>

                                            
                                        </div><!--  fin del row1 -->
                                       
                                        <!-- fin de controles -->
                                    </div>
                                </div> <!-- collapseOne -->
                            </div> <!-- card -->
                        </div> <!-- acordion -->
                    </div> <!-- col-12 -->
                </div>
               

              <div class="card-body">
              <div id="tablaSiniestrosTodos" class="mt-1" style="overflow-x: scroll;"></div>
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
     var botonazo = "";  
     var paramProv= '';
     var siniestroSelect = {};

        function leerTablaSiniestros(paramProv){

            paramProvNombre= "todos los Provenientes";
            paramProvAjax='';
            if(paramProv!=''){ //determina el parametro a utilizar segun el proveniente seleccionado
                paramProvNombre=paramProv.toUpperCase(); //proveniente
                paramProvAjax='&provSelected='+paramProv; //proveniente seleccionado desde los botones
            }
            $('#tablaSiniestrosTodos').jtable({
                title: 'Lista de Todos los Siniestros de '+paramProvNombre,
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
                    items: [
                        {
                            tooltip: 'Exportar a Excel',
                            icon: 'https://www.jtable.org/Content/images/Misc/excel.png',
                            text: 'Exportar Excel',
                            click: function() {
                                downloadAsExcel(res.Records, 'siniestros_');
                            },
                            
                        },
                        {
                            tooltip: 'importar a Excel',
                            icon: 'assets/img/icons/upload-icon.png',
                            text: 'Importar CSV',
                            click: function() {
                                uploadCSV();
                            },
                        }
                    ]
                },
                actions: {
                    listAction: '?action=jtable/tablaSiniestrosTodos.ajax'+paramProvAjax,
                    // createAction: '/GettingStarted/CreatePerson',
                    // updateAction: '?action=jtable/tablaUsuarios.ajax&editar',
                    // deleteAction: '/GettingStarted/DeletePerson'
                },
                fields: {
                    //CHILD TABLE "DATOS DE CHILD TABLE DE SINIESTROS""
                    Areas: {
                        title: 'Áreas',
                        style: 'jtable-command-column areas',
                        width: '3%',
                        sorting: false,
                        edit: false,
                        create: false,
                        display: function(siniestro) {
                            //Create an image that will be used to open child table
                            // var $img = $('<img src="/Content/images/Misc/phone.png" title="Edit phone numbers" />');
                            var $img = $(
                                '<center> <button class="btn btn-primary buttonTable"><i class="nc-icon nc-layout-11" style="font-size: 1.5em;"></i></button></center>'
                                //'<center><btn class="btn btn-sm btn-outline-danger btn-round btn-icon"><i class="nc-icon nc-layout-11" style="font-size: 1.5em;"></i></btn></center>'
                                );

                            //Open child table muestra usuarios que pertenecen a esa area y su grupo!
                            $img.click(function() {

                                $('#tablaSiniestrosTodos').jtable('openChildTable',
                                    $img.closest('tr'), {
                                        title: ' - Áreas asignadas al siniestro : ' + siniestro.record.folio,
                                        paging: true, //Enable paging
                                        pageSize: 10,
                                        pageSizes: [5, 10, 50],
                                        sorting: true, //Enable sorting
                                        defaultSorting: 'id ASC',
                                        actions: {
                                            listAction: '?action=jtable/tablaAreas.ajax&porSiniestro=' + siniestro.record.timerst,
                                        },
                                        fields: {
                                            /* id: {
                                                type: 'hidden',
                                                defaultValue: siniestro.record.idArea
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
                                                width: '10%'
                                            },
                                            estatus: {
                                                title: 'Estatus',
                                                width: '10%'
                                            },
                                            descripcion: {
                                                title: 'Descripción',
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
                    Usuarios: {
                        title: 'Usuarios',
                        style: 'jtable-command-column siniestros-areas',
                        width: '3%',
                        sorting: false,
                        edit: false,
                        create: false,
                        display: function(dataUser) {
                            //Create an image that will be used to open child table
                            // var $img = $('<img src="/Content/images/Misc/phone.png" title="Edit phone numbers" />');
                            var $img = $(
                                '<center> <button class="btn btn-primary buttonTable"><i class="nc-icon nc-layout-11" style="font-size: 1.5em;"></i></button> </center>'
                                //'<center><btn class="btn btn-sm btn-outline-danger btn-round btn-icon"><i class="nc-icon nc-layout-11" style="font-size: 1.5em;"></i></btn></center>'
                                );

                            //Open child table muestra usuarios que pertenecen a esa area y su grupo!
                            $img.click(function() {

                                $('#tablaSiniestrosTodos').jtable('openChildTable',
                                    $img.closest('tr'), {
                                        title: ' - Usuarios asignados al siniestro : ' + dataUser.record.folio,
                                        paging: true, //Enable paging
                                        pageSize: 10,
                                        pageSizes: [5, 10, 50],
                                        sorting: true, //Enable sorting
                                        defaultSorting: 'id ASC',
                                        actions: {
                                            listAction: '?action=jtable/tablaUsuarios.ajax&delSiniestro=' + dataUser.record.timerst,
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
                                            nombre: {
                                                title: 'Nombre',
                                                width: '10%'
                                            },
                                            paterno: {
                                                title: 'A. Paterno',
                                                width: '10%'
                                            },
                                            materno: {
                                                title: 'A. Materno',
                                                width: '10%'
                                            },
                                            estatus: {
                                                title: 'estatus',
                                                width: '7%'
                                            },
                                            area: {
                                                title: 'area',
                                                width: '7%'
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
                    /* Ver: {
                        title: 'Ver',
                        style: 'jtable-command-column siniestros-ver',
                        width: '3%',
                        sorting: false,
                        edit: false,
                        create: false,
                        display: function(siniestro) {
                            //Create an image that will be used to open child table
                            // var $img = $('<img src="/Content/images/Misc/phone.png" title="Edit phone numbers" />');
                            var $img = $(
                                '<center><i class="nc-icon nc-alert-circle-i"></i></center>'
                                //'<center><btn class="btn btn-sm btn-outline-danger btn-round btn-icon"><i class="nc-icon nc-layout-11" style="font-size: 1.5em;"></i></btn></center>'
                                );

                            //Open child table muestra usuarios que pertenecen a esa area y su grupo!
                            $img.click(function() {
                                    // alert(siniestro.record.folio);
                                    window.open('./?view=siniestro/ver&param='+siniestro.record.timerst, '_blank');
                            });
                            //Return image to show
                            return $img;
                        }
                    }, */
                    accion: {
                        title: 'Acciones',
                        style: 'jtable-command-column siniestros-acciones',
                        width: '3%',
                        sorting: false,
                        edit: false,
                        create: false,
                        display: function(sn) {
                            //Create an image that will be used to open child table
                            // var $img = $('<img src="/Content/images/Misc/phone.png" title="Edit phone numbers" />');

                        /*  
                            NumPoliza: "[2]"
                            activo: "1"
                            autoridad: "60"
                            calificacion: "162"
                            casa: "123456"
                            cel: "hgfdfghj"
                            ciudad: "2"
                            descripcionHechos: "%3Cp%3EDesKJHGFD%3C%2Fp%3E%0A%0A%3Ch1%3Edfg+dfs%3C%2Fh1%3E%0A%0A%3Cp%3Egh%3C%2Fp%3E%0A"
                            estado: "Oaxaca"
                            fechaReporte: "2022-01-25"
                            folio: "101-017-22"
                            formaContacto: "123456"
                            id: "43"
                            institucion: "116"
                            mail: "erick@erick.com"
                            nombre: "DFGHJ CVBNHGF YUIUTI"
                            numReporte: "12345"
                            numSiniestro: "987654"
                            oficina: "123456"
                            proveniente: "CMA"
                            status: "166"
                            timerst: "1644426736.6106"
                            vigencia1: "2022-01-25 17:01:37"
                            vigencia2: "2022-01-25 17:01:37" 
                            */
                            
                            snr=sn.record;
                            var obj='';
                            var img_SI='';
                            var img_NO='';
                            //boton con primera atencion cargada
                            

                            img_NO = $( //sin primer atencion
                            `<center><div class="btn-group actionBtn">
                                <button type="button" class="btn btn-danger dropdown-toggle buttonTable" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin: 0px !important;">
                                <i class="nc-icon nc-bulb-63"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="./?view=siniestro/ver&param=`+snr.timerst+`" target="_blank">Ver id</a>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalVerDocumentos" onclick="modalVerDocumentosJS('`+snr.timerst+`')" >Ver Documentos</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" onclick="primeraAtencion(`+snr.timerst+`,'`+snr.folio+`','`+snr.nombre+`','`+snr.numReporte+`','`+snr.fechaReporte+`','`+snr.vigencia1+`','`+snr.vigencia2+`','`+snr.fechaAsignacion+`','`+snr.fechaCaptura+`','`+snr.institucion+`','`+snr.autoridad+`','`+snr.cel+" / "+snr.casa+" / "+snr.oficina+`','`+snr.mail+`')" href="#">Crear Primera Atención</a>
                                </div>
                                </div>
                            </center>`
                            );

                            img_SI = $( // con primer atencion y sin preliminar  ver atencion, cargar preliminar
                            `<center><div class="btn-group actionBtn">
                                <button type="button" class="btn btn-warning dropdown-toggle buttonTable" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin: 0px !important;">
                                <i class="nc-icon nc-bulb-63"></i>
                                </button>
                                <div class="dropdown-menu">
                                <a class="dropdown-item" href="./?view=siniestro/ver&param=`+snr.timerst+`" target="_blank">Ver id</a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalVerDocumentos" onclick="modalVerDocumentosJS('`+snr.timerst+`')" >Ver Documentos</a>
                                    <a class="dropdown-item" onclick="vierFileF( '`+snr.timerst+`','primeraAtencion','PRIMERA ATENCIÓN'  )" class="btn btn-primary" data-toggle="modal" data-target="#modalFileView">Ver Primera Atención</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" onclick="informePreliminar(`+snr.timerst+`,'`+snr.calificacion+`','`+snr.folio+`','`+snr.nombre+`','`+snr.numReporte+`','`+snr.fechaReporte+`','`+snr.vigencia1+`','`+snr.vigencia2+`','`+snr.fechaAsignacion+`','`+snr.fechaCaptura+`','`+snr.institucion+`','`+snr.autoridad+`','`+snr.cel+" / "+snr.casa+" / "+snr.oficina+`','`+snr.mail+`')" href="#">Cargar Informe Preliminar</a>
                                    <span style="display:none"> 
                                    </span> 
                                </div>
                                </div>
                            </center>`
                            );

                            img_SI_preliminar_NO= $(  //con primer atencion, y con preliminar  ver atencion, ver preliminar
                            `<center><div class="btn-group actionBtn">
                                <button type="button" class="btn btn-info dropdown-toggle buttonTable" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin: 0px !important;">
                                <i class="nc-icon nc-bulb-63"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="./?view=siniestro/ver&param=`+snr.timerst+`" target="_blank">Ver id</a>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalVerDocumentos" onclick="modalVerDocumentosJS('`+snr.timerst+`')" >Ver Documentos</a>
                                    <a class="dropdown-item" onclick="vierFileF( '`+snr.timerst+`','primeraAtencion','PRIMERA ATENCIÓN'  )" class="btn btn-primary" data-toggle="modal" data-target="#modalFileView">Ver Primera Atención</a>
                                    <a class="dropdown-item" onclick="vierFileF( '`+snr.timerst+`','informePreliminar','INFORME PRELIMINAR'  )" class="btn btn-primary" data-toggle="modal" data-target="#modalFileView">Ver Informe Preliminar</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" onclick="informeCancelacion(`+snr.timerst+`,'`+snr.calificacion+`','`+snr.folio+`','`+snr.nombre+`','`+snr.numReporte+`','`+snr.fechaReporte+`','`+snr.vigencia1+`','`+snr.vigencia2+`','`+snr.fechaAsignacion+`','`+snr.fechaCaptura+`','`+snr.institucion+`','`+snr.autoridad+`','`+snr.cel+" / "+snr.casa+" / "+snr.oficina+`','`+snr.mail+`')" href="#">Cargar Informe Cancelación</a>
                                    <span style="display:none"> 
                                    </span> 
                                </div>
                                </div></center>`
                            );
                            img_SI_preliminar_SI = $(  //con primer atencion, y con preliminar  ver atencion, ver preliminar
                            `<center><div class="btn-group actionBtn">
                                <button type="button" class="btn btn-success dropdown-toggle buttonTable" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin: 0px !important;">
                                <i class="nc-icon nc-bulb-63"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="./?view=siniestro/ver&param=`+snr.timerst+`" target="_blank">Ver id</a>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalVerDocumentos" onclick="modalVerDocumentosJS('`+snr.timerst+`')" >Ver Documentos</a>
                                    <a class="dropdown-item" onclick="vierFileF( '`+snr.timerst+`','primeraAtencion','PRIMERA ATENCIÓN'  )" class="btn btn-primary" data-toggle="modal" data-target="#modalFileView">Ver Primera Atención</a>
                                    <a class="dropdown-item" onclick="vierFileF( '`+snr.timerst+`','informePreliminar','INFORME PRELIMINAR'  )" class="btn btn-primary" data-toggle="modal" data-target="#modalFileView">Ver Informe Preliminar</a>
                                    <a class="dropdown-item" onclick="vierFileF( '`+snr.timerst+`','informeCancelacion','INFORME CANCELACIÓN'  )" class="btn btn-primary" data-toggle="modal" data-target="#modalFileView">Ver Informe Cancelación</a>
                                    <div class="dropdown-divider"></div>
                                    <span style="display:none"> 
                                    </span> 
                                </div>
                                </div></center>`
                            );

                            //coloca si ya tiene primera atencion o no.
                            if (snr.primera_atencion=='no' && snr.informe_preliminar=='no' && snr.informe_cancelacion=='no'){ //con primera atencion
                                img = img_NO;
                            }
                            else if (snr.primera_atencion=='si' && snr.informe_preliminar=='no' && snr.informe_cancelacion=='no'){ //con primera atencion
                                img = img_SI;
                            }
                            else if (snr.primera_atencion=='si' && snr.informe_preliminar=='si' && snr.informe_cancelacion=='no'){ //con primera atencion  y sin preliminar
                                img = img_SI_preliminar_NO;
                            }
                            else if (snr.primera_atencion=='si' && snr.informe_preliminar=='si' && snr.informe_cancelacion=='si'){ //con primera atencion  y sin preliminar
                                img = img_SI_preliminar_SI;
                            }
                            else {
                                 "error";//no deberia pasar
                            }

                        /*  if (srn.primera_atencion !=""){
                                $img = $(
                                    `<div class="btn-group actionBtn">
                                        <button type="button" class="btn btn-warning dropdown-toggle buttonTable" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin: 0px !important;">
                                        <i class="nc-icon nc-bulb-63"></i>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="./?view=siniestro/ver&param=`+snr.timerst+`" target="_blank">Ver id</a>
                                            <a class="dropdown-item" onclick="primeraAtencion(`+snr.timerst+`,'`+snr.folio+`','`+snr.nombre+`','`+snr.numReporte+`','`+snr.fechaReporte+`','`+snr.vigencia1+`','`+snr.vigencia2+`','`+snr.fechaAsignacion+`','`+snr.fechaCaptura+`')" href="#">Cargar Primera Atención</a>
                                        </div>
                                        </div>`+
                                    '<center></center>'
                                    );
                            } */
                        

                            img.click(function(siniestroSelect) {
                                    // funcion que ejecuta al hacer click
                                    console.log(siniestroSelect);
                            });
                            //Return image to show
                            return img;
                        }
                    },

                    //CHILD TABLE "DATOS DE CHILD TABLE DE SINIESTROS""

                    id: {
                        title: 'id',
                        key: true,
                        list: true,
                        width: '3%'
                    },
                    timerst: {
                        title: 'timerst',
                        width: '5%',
                        type: 'hidden',
                        /* options: {
                            '1': 'Home phone',
                            '2': 'Office phone',
                            '3': 'Cell phone'
                        } */
                    },
                    primera_atencion:{
                        title: 'PA',
                        width: '10%',
                        type: 'hidden',
                    },
                    informe_preliminar:{
                        title: 'IP',
                        width: '10%',
                        type: 'hidden',
                    },
                    informe_cancelacion:{
                        title: 'IC',
                        width: '10%',
                        type: 'hidden',
                    },
                    
                    folio: {
                        title: 'Folio',
                        width: '15'
                    },
                    proveniente: {
                        title: 'Prov',
                        width: '5%'
                    },
                    numReporte:{
                        title: '#Reporte',
                        width: '5'
                    },
                    numSiniestro:{
                        title: '#Siniestro',
                        width: '5%'
                    },
                    nombre: {
                        title: 'Nombre',
                        width: '15%'
                    },
                    mail: {
                        title: 'Email',
                        width: '10%'
                    },
                    institucion: {
                        title: 'Institución',
                        width: '10%'
                    },
                    autoridad:{
                        title: 'Autoridad',
                        width: '10%'
                    },
                    fechaReporte: {
                        title: 'FechaReporte',
                        width: '10%'
                    },
                    estado:{
                        title: 'Estado',
                        width: '10%'
                    },
                    ciudad:{
                        title: 'Ciudad',
                        width: '10%'
                    },
                    formaContacto:{
                        title: 'FormaContacto',
                        width: '10%'
                    },
                    calificacion:{
                        title: 'Calificación',
                        width: '10%'
                    },
                    status:{
                        title: 'Status',
                        width: '10%'
                    },
                    fechaAsignacion:{
                        title: 'Status',
                        width: '10%',
                        type: 'date',
                    displayFormat: 'd dd-mm-YYYY'
                    },
                    fechaCaptura:{
                        title: 'Status',
                        width: '10%',
                        type: 'hidden',
                    },
                    primera_atencion:{
                        title: 'PA',
                        width: '10%',
                        type: 'text',
                    }
                    
                }
            });
            $('#tablaSiniestrosTodos').jtable('load');
            }
    window.onload=function (){

        $("#btn_prov_F").on('click',function(){ //boton de filtro, al desplegar panel, esconde botones de provenientes
                $("button.btn_prov").toggleClass("showbtn");
        });
        

        //activar jtable
        leerTablaSiniestros('');

        $.each(document.querySelectorAll('.js-select2'),function(i,key){
            $(key).select2({
                placeholder: " "+  $(key).attr('placeholder')
            });
        });

        $(function () {
        // Configurar datetimepicker
        var dataInfo={
            format: 'YYYY-MM-DD',
            // locale: moment.locale('es-es'),
            locale: 'es',
            allowInputToggle: true,
        }
        
        $('#fecha1').datetimepicker(dataInfo);
        $('#fecha2').datetimepicker(dataInfo);
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


    //?funciones de botones de la tabla
    function uploadCSV(){
        /* .then((result) => {
            // Read more about isConfirmed, isDenied below 
            if (result.isConfirmed)
            else if (result.isDenied) 
         */
        Swal.fire({
        confirmButtonColor: 'var(--color-dark)',
        denyButtonColor: 'var(--color-blanco)',
        cancelButtonColor: 'var(--fondo-degradado)',
        title: 'Selecciona archivo a importar',
        input: 'file',
        inputAttributes: {
            'accept': 'text/csv',
            'aria-label': 'Selecciona un archivo CSV de siniestros',
            'name':'csvImport',
            'id':'csvImport'
        }
        }).then((result) => {
            if (result.isConfirmed) {
                file= document.querySelector("input[type=file][name=csvImport]").files[0];
                if (file) {
                    //para subir imagenes y mostrar la que se acaba de subir
                    //var reader=new FileReader(); reader.onload=(e)=>{ console.log(e); Swal.fire({ title: 'tu archivo subido', imageUrl: e.target.result, imageAlt: 'se subio el csv', text:e.target})} reader.readAsDataURL(file)
                    console.log("subiendo archivo por ajax");
                    let dataForm= new FormData();
                    dataForm.append('fileCsv',file);


                    $.ajax({
                        url: "./?action=siniestro/importSiniestros",
                        method: "POST",
                        data:dataForm,
                        processData:false,
                        contentType:false,
                        success: function(respuesta) {
                            // dataset = JSON.parse(respuesta);
                            console.log(respuesta);
                           
                            console.log("inicializando file upload");
                        },
                        error:{ function(e) {
                            conjsole.log(e);
                        }

                        }
                    }); 
                }
            }
        });
    }

    // function tongleShow(elemento){
    //     $(elemento).toggleClass('show');
    // }

    //filtro por proveedor
    function selectProv(prov){ //selecciona el provedor a ver en la tabla.
        // alert(prov);
        $('.btn_prov').removeClass('active');
        $('.btn_prov').addClass('btn-link');//desaparece todos
        
        $('[prov='+prov+']').addClass('active');
        $('[prov='+prov+']').addClass('btn-link');
        $('#tablaSiniestrosTodos').jtable('destroy');
       console.log("cargando tabla de "+prov);
        leerTablaSiniestros(prov);

    }

    //filtro por areas
    function selectArea(area){

    }

    //PRIMERA ATENCION
    function primeraAtencion(timerst,folio,nombre,numReporte,fechaReporte,vigencia1,vigencia2,fechaAsignacion,fechaCaptura,institucion,autoridad,telefonos,email){

        // elimina la hora de la fecha en los siguientes: 
        fechaAsignacion =   fechaAsignacion.split(" ")[0]
        fechaCaptura =      fechaCaptura.split(" ")[0]
        fechaReporte =      fechaReporte.split(" ")[0]
        //retarda el CKEDITOR 200 ms
        console.log(timerst);
        setTimeout(() => {
            CKEDITOR.replace( 'primeraAtencion',{
                width:'100%',
                uiColor: '#ede6c6',
                editorplaceholder: 'Descripcion de hechos',
                removeButtons: "Creatediv,Subscript,Superscript,Anchor,PasteFromWord,PasteText,Paste,Cut,Save,NewPage,DocProps,Document,Templates,Print,ExportPdf,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CreateDiv,Language,Link,Unlink,Iframe,About",
            });
        }, 300);

        //trae datos del Primera atención BD para el CKEDITOR
        setTimeout(() => {
            /* $.ajax({
                url: "./?action=siniestro/primeraAtencion",
                method: "POST",
                data:{'timerst':siniestro},
                processData:false,
                contentType:false,
                success: function(respuesta) {
                    dataset = JSON.parse(respuesta);
                    console.log(respuesta);
                    
                    console.log("inicializando file upload");
                },
                error:{ function(e) {
                    conjsole.log(e);
                }

                }
            });  */
            
        }, 300);

            //swert alert para editar el proveedor o proveniente
            //FORMATO DE PRIMERA ATENCION
            let selInput =` <div class="input-group">
            <div class="input-group-prepend">
              <!-- <span class="input-group-text">With textarea </span> -->
            </div>
            <textarea placeholder="" id="primeraAtencion" name="primeraAtencion">
            
            <p>Fecha de Asignación: `+fechaAsignacion+`<br />
            <strong>Lic. Luis Alberto Mart&iacute;nez Garc&iacute;a   
 &nbsp; &nbsp; &nbsp; &nbsp;/ &nbsp;&nbsp;&nbsp;&nbsp;     Lic. Mario Aguilar Guajardo.<br />
            ASUNTO: Informe PReliminar<br />
            REPORTE: `+numReporte+`<br />
            SINIESTRO: `+folio+` </strong>

            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Con relaci&oacute;n al reporte n&uacute;mero <strong>`+numReporte+`</strong> correspondiente al 
            <strong>`+nombre+`</strong> asignado a esta firma legal el d&iacute;a <strong>`+fechaAsignacion+`</strong>, por el presente le informo que ya se tuvo comunicaci&oacute;n con el asegurado a quien se le proporcionaron nuestros datos y n&uacute;meros telef&oacute;nicos y se le requiri&oacute; la informaci&oacute;n necesaria para la atenci&oacute;n del asunto.</p>

            <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Asimismo, hago de su conocimiento los datos m&iacute;nimos de este reporte para la obtenci&oacute;n del n&uacute;mero de siniestro que nos ocupa:</p>

            <p>P&oacute;liza:`+fechaCaptura+`<br />
            Vigencia:<br />
            Instituci&oacute;n: `+institucion+`<br />
            Tercero: Demandante<br />
            Fecha de ocurrido: <br />
            Lugar de ocurrido: <br />
            Fecha de Vigencia: <br />
            Autoridad: `+autoridad+` <br />
            Expediente de Autoridad:<br />
            Forma de contacto.:`+fechaCaptura+`<br />
            Tels.:`+telefonos+`<br />
            Email:`+email+`<br />
            Motivo del siniestro:</p>

            <p>Agradeciendo su atenci&oacute;n, me reitero a sus &oacute;rdenes para cualquier duda o aclaraci&oacute;n.</p>

            <p><strong>A T E N T A ME N T E</strong><br />
            Lic. <?php echo $_SESSION['nombre'].' '.$_SESSION['paterno'].' '.$_SESSION['materno'] ?>.</p>

            </textarea>
          </div>`;

    
      let html_ = `<label>ID : </label> <b> `+folio+`</b>`;
        html_ = html_ + selInput;
        Swal.fire({
            width:'50%',
            confirmButtonColor: 'var(--color-dark)',
            denyButtonColor: 'var(--color-blanco)',
            cancelButtonColor: 'var(--fondo-degradado)',

            title: 'Primera Atención: ',
            html: html_,
            confirmButtonText: 'Guardar',
            showCancelButton: true,
            cancelButtonText: 'Salir',
            focusConfirm: false,
            preConfirm: () => {
                let primeraAtencion = CKEDITOR.instances['primeraAtencion'].getData();
                if (!primeraAtencion)
                Swal.showValidationMessage(`No puedes dejar campos en blanco`);

                return { primeraAtencion, timerst,folio}
            }
            
        })
        .then((cambios) => {
            //alert("archivo cargado!!");
            //?cuando ya está OK
            if (cambios.isConfirmed)
                $.ajax({
                    url: "./?action=siniestro/primeraAtencion&guardar=primeraAtencion",
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

    //INFORME PRELIMINAR
    function informePreliminar(timerst,calificacion,folio,nombre,numReporte,fechaReporte,vigencia1,vigencia2,fechaAsignacion,fechaCaptura,institucion,autoridad,telefonos,email){

        // elimina la hora de la fecha en los siguientes: 
        fechaAsignacion =   fechaAsignacion.split(" ")[0]
        fechaCaptura =      fechaCaptura.split(" ")[0]
        fechaReporte =      fechaReporte.split(" ")[0]
        //retarda el CKEDITOR 200 ms
        console.log(timerst);
        setTimeout(() => {
            CKEDITOR.replace( 'InformePreliminar',{
                width:'100%',
                uiColor: '#ede6c6',
                editorplaceholder: 'InformePreliminar', 
                removeButtons: "Creatediv,Subscript,Superscript,Anchor,PasteFromWord,PasteText,Paste,Cut,Save,NewPage,DocProps,Document,Templates,Print,ExportPdf,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CreateDiv,Language,Link,Unlink,Iframe,About",
            });
        }, 200);

        //trae datos del Primera atención BD para el CKEDITOR
        setTimeout(() => {
            /* $.ajax({
                url: "./?action=siniestro/primeraAtencion",
                method: "POST",
                data:{'timerst':siniestro},
                processData:false,
                contentType:false,
                success: function(respuesta) {
                    dataset = JSON.parse(respuesta);
                    console.log(respuesta);
                    
                    console.log("inicializando file upload");
                },
                error:{ function(e) {
                    conjsole.log(e);
                }

                }
            });  */
            
        }, 300);

            //swert alert para editar el proveedor o proveniente
            //FORMATO DE INFORME PRELIMINAR
            let selInput =` <div class="input-group">
            <div class="input-group-prepend">
            <!-- <span class="input-group-text">With textarea </span> -->
            </div>
            <textarea placeholder="" id="InformePreliminar" name="InformePreliminar">

            <p>Fecha de Asignaci&oacute;n:`+fechaAsignacion+`<br />
            <strong>Lic. Luis Alberto Mart&iacute;nez Garc&iacute;a   
 &nbsp; &nbsp; &nbsp; &nbsp;/ &nbsp;&nbsp;&nbsp;&nbsp;     Lic. Mario Aguilar Guajardo.</strong></p>

            <p><strong> ASUNTO: Informe Preliminar.<br />
            REPORTE: `+numReporte+`</strong><br />
            Creado el:  `+fechaCaptura+`<br />
            I.D.:  `+folio+` <br />
            Asegurado: `+nombre+` </p>

            <p>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Adjunto al presente envío el informe preliminar correspondiente al asegurado <strong>`+nombre+`</strong>, mismo que se realizó con base a la información y documentación suministrada por este último, el cual en opinión de esta firma legal es <strong> `+calificacion+` </strong>, de que se le proporcione la asistencia legal requerida, salvo instrucciones en contrario, por lo que someto a su consideración la procedencia del mismo, solicitándole se sirva proporcionando el número de siniestro que le corresponda al mismo, para los efectos y trámites conducentes.</p>

            <p>Agradeciendo su atención, me reitero a sus órdenes para cualquier duda o aclaración.</p>

            <p><strong>ATENTAMENTE:<br />
            Lic. <?php echo $_SESSION['nombre'].' '.$_SESSION['paterno'].' '.$_SESSION['materno'] ?>.

            Lic. Víctor Hugo Alarcón López</strong></p>

            <p>Email:</p>

            <p>Anexos:</p>
            
            </textarea>
          </div>`;


        let html_ = `<label>ID : </label> <b> `+folio+`</b>`;
        html_ = html_ + selInput;
        Swal.fire({
            width:'50%',
            confirmButtonColor: 'var(--color-dark)',
            denyButtonColor: 'var(--color-blanco)',
            cancelButtonColor: 'var(--fondo-degradado)',

            title: 'Informe Preliminar: ',
            html: html_,
            confirmButtonText: 'Guardar',
            showCancelButton: true,
            cancelButtonText: 'Salir',
            focusConfirm: false,
            preConfirm: () => {
                let InformePreliminar = CKEDITOR.instances['InformePreliminar'].getData();
                if (!InformePreliminar)
                Swal.showValidationMessage(`No puedes dejar campos en blanco`);

                return { InformePreliminar, timerst,folio}
            }
            
        })
        .then((cambios) => {
            //alert("archivo cargado!!");
            //?cuando ya está OK
            if (cambios.isConfirmed)
                $.ajax({
                    url: "./?action=siniestro/informePreliminar&guardar=InformePreliminar",
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

    //?accion del boton para ver archivos del siniestro de formato establecido
    function vierFileF(timerst,url,title){
        $('#modalFileViewLabel').html(title);
        $("#modalFileViewBody").html('<iframe src="./?action=pdf/viewFileF&timerst='+timerst+'&doc='+url+'" frameborder="0" style="width:100%;height:66vh;"></iframe>');

    }

    

    //? accion de ver documentos del siniestro seleccionado.
    function modalVerDocumentosJS(timerst){
        setTimeout(() => {
            $("#modal-body-docs").html('<iframe src="./?action=siniestro/files&modo=verIframeDocsSiniestro&timerst='+timerst+'" frameborder="0" style="width:100%;height:max-content;"></iframe>');
            //////no sirve// $("#modal-body-docs").html('<iframe src="./core/app/view/siniestro/verTodos/iframeDocs.php?modo=verIframeDocsSiniestro&timerst='+timerst+'" frameborder="0" style="width:100%;height:66vh;"></iframe>');


            //?promesa de ajax si no sale con iframe php
            /* $.ajax({
                url: "./?action=siniestro/files&modo=verArchivosdelSiniestro",
                method: "POST",
                data: {timerst} ,
                success: function(respuesta) {
                    console.log(respuesta);
                    //actualizar el innerHTML del modal-body
                    let filesTable= '<tr>No hay archivos</tr>';
                    if (respuesta.length>=1){
                        respuesta.forEach(element => {
                            switch (element.nombre) {
                                case 'primeraAtencion':
                                    $k['c1'] = 'PRIMERA ATENCIÓN';
                                    $k['c2'] = 'PRIMERA ATENCIÓN';
                                    $k['c3'] = 'PRIMERA ATENCIÓN';
                                    $render='si';
                                    break;
                            
                                default:
                                    break;
                            }
                            filesTable="";
                        });
                    }
                    $("#modal-body-docs").html('<tr><th>ETAPA</th><th>CAT1</th><th>CAT2</th><th>REV</th><th>FECHA</th><th>ver</th></tr>');

                },
                error:{ function(e) {
                    conjsole.log(e);
                }

                }
            }); */
        }, 200);
    }


</script>

<script>
                  /* CKEDITOR.stylesSet.add( 'descripcionHechos', [
                      // Block-level styles.
                      { name: 'Blue Title', element: 'h2', styles: { color: 'Blue' } },
                      { name: 'Red Title',  element: 'h3', styles: { color: 'Red' } },

                      // Inline styles.
                      { name: 'CSS Style', element: 'span', attributes: { 'class': 'my_style' } },
                      { name: 'Marker2: werewr', element: 'span', styles: { 'background-color': 'green' } }
                  ]); */

                        /* CKEDITOR.replace( 'descripcionHechos',{
                          uiColor: '#ede6c6',
                          editorplaceholder: 'Descripcion de hechos',
                          placeholder: 'Descripcion de hechos' 
                        }); */
                </script>
<style>
    
    button.active{
        color:#d5cab2 !important;
    }
    button.btn_prov:active{
        color:red !important;
    }
    .btn_prov{
        transition: all ease-in-out 1.3s;
    }
    .showbtn{
        display: none !important;
    }

    div.jtable-main-container>table.jtable>tbody>tr.jtable-data-row>td:nth-child(11),
    div.jtable-main-container>table.jtable>tbody>tr.jtable-data-row>td:nth-child(12){
        white-space: normal !important;
        min-width: 360px !important;
    }
</style>