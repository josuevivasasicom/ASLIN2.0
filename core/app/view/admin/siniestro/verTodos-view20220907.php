<?php
/* header("Content-type: text/html"); 
header("Expires: Mon, 30 Jan 2022 12:00:00 GMT");  
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  
header("Cache-Control: no-store, no-cache, must-revalidate");  
header("Cache-Control: post-check=0, pre-check=0", false);  
header("Pragma: no-cache") */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(1);


/* echo "<br>";
echo core::getTimeNow();

echo "<br>";
echo "<br>";
echo "<br>";

setlocale(LC_ALL,"es_MX");
echo strftime("%A %d de %B del %Y");
// America/Mexico_City
echo "<br>";
echo "<br>";

setlocale(LC_ALL,"es_CO.utf8");
$string = "24/11/2014";
$date = DateTime::createFromFormat("d/m/Y", $string);
echo strftime("%A",$date->getTimestamp()); */

/* core::preprint( core::getTimeNowString('2022-04-18 10:45:29',false));
exit(); */

$areaIDuser = explode('/', $_SESSION['grupo'][0])[2];
$areaNombre = explode('/', $_SESSION['grupo'][0])[0];
$statusList = Folios::obtenerConfigCampo('status');
$calificacionesList = Folios::obtenerConfigCampo('calificacion');

$cssStyle='';
foreach ($calificacionesList as $key) {
    $cssStyle.= ' .'.strtolower(explode(' ',$key->valor)[0]).'{ background:'.$key->extra.';} ' ;
}
foreach ($statusList as $key) {
    $cssStyle.= ' .'.strtolower(explode(' ',$key->valor)[0]).'{ background:'.$key->extra.';} ' ;
}
print('<style>.notouch{pointer-events:none}'.$cssStyle.'</style>');
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
                            $files_sn = Siniestros::verArchivosdelSiniestro('1648073016.3617','1');
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
                                    <button type="button" onclick=selectProv() prov='' class="btn btn-primary  btn-round mr-3 btn_prov btn-link"><b>Todos -></b></button>
                                    <!-- <button type="button" onclick="document.location.reload()" class="btn btn-primary  btn-round mr-3 btn_prov" ><b>Todos</b></button> -->
                                    <?php
                                        $provenientes=Folios::obtenerProvenientes();
                                        foreach ($provenientes as $key => $value) {
                                            echo ' <button type="button" onclick="selectProv(\''.$value['proveniente'].'\')" prov="'.$value['proveniente'].'" class="btn btn-primary btn-link btn-round btn_prov" >'.strtoupper($value['proveniente']).'</button>';
                                        }
                                    ?>
                                    <!-- fin row2 -->
                                    <div  class="custom-control custom-switch d-flex" style="float: right;">
                                        <input onclick="selectAsignados()" type="checkbox" class="custom-control-input" id="siniestrosAsignados">
                                        <label class="custom-control-label" for="siniestrosAsignados">Solo Asignados</label>
                                    </div>

                                </div>


                                <div class="card-header pt-0 " id="headingtwo">
                                    <button type="button" onclick="selectStatus()" status="" class="btn btn-primary btn-round mr-3 btn_prov btn-link"><b>Todas -></b></button>
                                    <!-- <button type="button" onclick="selectStatus('')" status="" class="btn btn-primary btn-round mr-3 btn_prov btn-link"><b>Ver: Todas</b></button> -->
                                    <!-- <button type="button" onclick="document.location.reload()" class="btn btn-primary  btn-round mr-3 btn_prov" ><b>Ver: Todas</b></button> -->
                                    <?php
                                        $status=Folios::obtenerStatus();
                                        foreach ($status as $key => $value) {
                                            echo ' <button type="button" onclick="selectStatus(\''.$value->id.'\')" status="'.$value->id.'" class="btn btn-primary btn-link  btn-link btn-round btn_prov" >'.strtoupper($value->valor).'</button>';
                                        }
                                    ?>
                                </div>
                                <!-- fin row3 -->

                                <div class="card-header pt-0 " id="headingthree">
                                    <button type="button" onclick="selectCalificacion()" calificacion="" class="btn btn-primary btn-round mr-3 btn_prov btn-link"><b>Todas -></b></button>
                                    <?php
                                        $calific=Folios::obtenerCalificaciones();
                                        foreach ($calific as $key => $value) {
                                            echo ' <button type="button" onclick="selectCalificacion(\''.$value->id.'\')" calificacion="'.$value->id.'" class="btn btn-primary btn-link  btn-link btn-round btn_prov" >'.strtoupper($value->valor).'</button>';
                                        }
                                    ?>
                                </div>
                                <!-- fin row4 -->


                                <div class="card-header pt-0 " id="headingtwo">
                                     <button type="button" onclick="selectArea()" areas="" area="" class="btn btn-primary btn-round mr-3 btn_prov btn-link"><b>Todas -></b></button>
                                           <?php
                                           $areasF=Folios::obtenerAreas();
                                           foreach ($areasF as $key => $value) {
                                               echo ' <button type="button" onclick="selectArea(\''.$value->id.'\')" areas="'.$value->id.'" area="'.$value->area.'" class="btn btn-primary btn-link btn-round btn_prov" >'.strtoupper($value->area).'</button>';
                                            }
                                           ?>
                                </div>
                                <!-- fin row4 -->

                                <div class="form-group col-12">
                                    <select class="js-select2 form-control" placeholder="Buscar por Abogado" id="abogados" name="abogados" mNOultiple="multiple" style="float:right;width:85%;">
                                        <?php
                                            $abogados = Folios::obtenerAbogados();
                                            core::sendVarToJs(json_encode($abogados), 'abogadosTodos');
                                            foreach ($abogados as $key => $value) {
                                                print "<option value='" . $value->id . "'>" . $value->nombre . " : " . $value->area . "</option>";
                                            }
                                        ?>
                                    </select>
                                    <button class="btn  btn-prinone btn-round my-0" style="float:right" onclick="laveSelectAbogado()" id="btn_prov_F">Limpiar</button>
                                    <button class="btn  btn-prinone btn-round my-0" style="float:right" onclick="buscarUserSiniestros()" id="btn_prov_F">buscar</button>
                                </div>
                                
                                <div class="col-">
                                </div>

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
    scope = this;
    var siniestroSelect = {};
    var botonazo = "";
    var paramProv = '';
    var paramStatus = '';
    var paramArea = '';
    var soloAsignados=false;
    if (localStorage.getItem('prov') == undefined) { 
        // console.log('no existe prov se establece en blanco.');
        localStorage.setItem('prov', '');
    }
    if (localStorage.getItem('statusS') == undefined) { 
        // console.log('no existe statusS se establece en blanco.');
        localStorage.setItem('statusS', '');
    }
    if (localStorage.getItem('calificacion') == undefined) { 
        // console.log('no existe calificacion se establece en blanco.');
        localStorage.setItem('calificacion', '');
    }
    if (localStorage.getItem('areas') == undefined) { 
        // console.log('no existe areas se establece en blanco.');
        localStorage.setItem('areas', '');
    }
    if (localStorage.getItem('soloAsignados') == undefined) { 
        // console.log('no existe soloAsignados se establece en blanco.');
        localStorage.setItem('soloAsignados', 'false');
    }

    if (localStorage.getItem('abogados') == undefined) { 
        // console.log('no existe soloAsignados se establece en blanco.');
        localStorage.setItem('abogados', '');
        localStorage.setItem('abogados_name', '');
        
    }

    if (localStorage.getItem('filtros') == undefined) { 
        // console.log('no existe soloAsignados se establece en blanco.');
        localStorage.setItem('filtros', '');
    }
   

    /* localStorage.setItem('prov', '');
    localStorage.setItem('statusS', '');
    localStorage.setItem('areas', '');
    localStorage.setItem('soloAsignados', false); */

        function leerTablaSiniestros() {
            mProvNombre = "todos los Provenientes";

            //Status
            if (localStorage.getItem('statusS') !='') { 
                paramStatus = '&statusSelected=' + localStorage.getItem('statusS');
                switch (localStorage.getItem('statusS')) {
                    case '170':
                        nombreStatus = '-Por Determinar';
                        break;
                    case '169':
                        nombreStatus = '-Cancelados';
                        break;
                    case '175':
                        nombreStatus = '-Proceso de Cancelación';
                        break;
                    case '167':
                        nombreStatus = '-Vigente';
                        break;
                    default:
                        nombreStatus = '';
                        break;
                }
                statusS = localStorage.getItem('statusS');
                $('[status=' + statusS + ']').addClass('active');
            }else{ paramStatus ='';nombreStatus=''; $($('[status]')[0]).addClass('active');  $($('[status]')[0]).addClass('btn-link');}

            //calificacion
            if (localStorage.getItem('calificacion') !='') { 
                paramCalificacion = '&calificacionSelected=' + localStorage.getItem('calificacion');
                switch (localStorage.getItem('calificacion')) {
                    case '291':
                    case '315':
                        nombreCalificacion = '-canc. admva.';
                        break;
                    case '169':
                    case '166':
                        nombreCalificacion = '-Por determinar';
                        break;
                    case '165':
                        nombreCalificacion = '-Reapertura';
                        break;
                    case '164':
                        nombreCalificacion = '-Preventivo';
                        break;
                    case '163':
                        nombreCalificacion = '-Improcedente';
                        break;
                    case '162':
                        nombreCalificacion = '-Procedente';
                        break;
                    case '161':
                        nombreCalificacion = '-Asesoría';
                        break;
                    default:
                        nombreCalificacion = '';
                        break;
                }
                calificacion = localStorage.getItem('calificacion');
                $('[calificacion=' + calificacion + ']').addClass('active');
            }else{ paramCalificacion ='',nombreCalificacion=''; $($('[calificacion]')[0]).addClass('active');  $($('[calificacion]')[0]).addClass('btn-link');}

            //prov
            if (localStorage.getItem('prov') !='') { 
                paramProv = '&provSelected=' + localStorage.getItem('prov');
                nombreProv = '-' + localStorage.getItem('prov');
                provS = localStorage.getItem('prov');
                $('[prov=' + provS + ']').addClass('active');
            }else{ paramProv ='';nombreProv=''; $($('[prov]')[0]).addClass('active');  $($('[prov]')[0]).addClass('btn-link');}
            
            if (localStorage.getItem('areas') !='') {
                paramArea = '&area=' + localStorage.getItem('areas');
                nomArea = '-' + localStorage.getItem('areas');
                areaS = localStorage.getItem('areas');
                $('[areas=' + areaS + ']').addClass('active');
                switch (localStorage.getItem('areas')) {
                    case '1':
                        nomArea = '-Servidores Públicos';
                        break;
                    case '2':
                        nomArea = '-Penal';
                        break;
                    case '3':
                        nomArea = '-Siniestros';
                        break;
                    case '4':
                        nomArea = '-Administrativa';
                        break;
                    case '5':
                        nomArea = '-Contabilidad';
                        break;
                    case '6':
                        nomArea = '-Cancelados';
                        break;
                    case '7':
                        nomArea = '-Civil';
                        break;
                    default:
                        nomArea = '';
                        break;
                }
            }else{ paramArea ='';nomArea=''; $($('#headingtwo [areas]')[0]).addClass('active');   $($('#headingtwo [areas]')[0]).addClass('btn-link');}
            
            if (localStorage.getItem('soloAsignados') !='') {
                console.log("||||||||||||||||asignados|||||||||||||||");
                if (localStorage.getItem('soloAsignados')=='false' ){
                    nombreAsign = '';
                    soloAsignados = '';
                }else{
                    console.log("||||||||||||||||TRUE|||||||||||||||");
                    $('#siniestrosAsignados').prop('checked',true) ;
                    nombreAsign = '-Asignados';
                    soloAsignados = '&asignados=' + localStorage.getItem('soloAsignados');
                }
                
            }else{ soloAsignados ='',nombreAsign =''; }

            let paramAbo='';
            if (localStorage.getItem('abogados') !='' ){
               // let x = JSON.parse( localStorage.getItem('abogados') );
                //$('#abogados').select2().val(x).trigger();
                setTimeout(() => {
                    paramAbo = '&aboSelected=' + localStorage.getItem('abogados');
                    // let dinamic = JSON.parse(localStorage.getItem('abogados'));
                    let dinamic = localStorage.getItem('abogados');
                    $('#abogados').select2("val",dinamic).trigger('change');

                    /* dinamic.forEach(element => {
                        // $('#abogados').select2().val(dinamic[0].toString()).trigger();
                        // $('#abogados').select2().val(element.toString()).trigger();
                        $('#abogados').select2("val",element).trigger('change');
                    }); */
                    console.log("cambiando nombre localstorage");
                    
                }, 2000);
            }else{paramAbo=''; }

           
            paramAbo = '&aboSelected=' + localStorage.getItem('abogados');

            paramProvAjax = paramProv + paramStatus + paramArea + paramCalificacion + soloAsignados + paramAbo; //proveniente seleccionado desde los botones
           
            paramNombres = (nombreProv.toUpperCase())+' '+nombreStatus+nombreCalificacion+nomArea+nombreAsign;

            $('#tablaSiniestrosTodos').jtable({
                title: 'Listado '+paramNombres,
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
                selecting: true, //Enable selecting
                //multiselect: true, //Allow multiple selecting
                //selectingCheckboxes: true, //Show checkboxes on first column
                //selectOnRowClick: false, //Enable this to only select using checkboxes

                //openChildAsAccordion: true,
                openChildAsAccordion: true,
                toolbar: {
                    items: [
                        {
                            tooltip: 'Exportar a Excel la tabla actual',
                            icon: 'https://www.jtable.org/Content/images/Misc/excel.png',
                            text: 'Exportar Excel',
                            click: function() {
                                downloadAsExcel(paramProvAjax, paramNombres,'admin');
                            }
                        },
                        {
                            tooltip: 'Columnas para el orden de GMX',
                            icon: 'https://www.jtable.org/Content/images/Misc/excel.png',
                            text: 'Formato GMX',
                            click: function() {
                                downloadAsExcel(paramProvAjax, paramNombres,'gmx');
                            }
                        }
                    ]
                },
                actions: {
                    listAction: '?action=jtable/tablaSiniestrosTodos.ajax'+paramProvAjax,
                    //updateAction: '?action=jtable/tablaUsuarios.ajax&editar',

                },
                fields: {
                    Editar: {
                        title: 'Editar',
                        style: 'jtable-command-column siniestros-editar',
                        width: '3%',
                        sorting: false,
                        edit: false,
                        create: false,
                        display: function(siniestro) {
                            //Create an image that will be used to open child table
                            // var $img = $('<img src="/Content/images/Misc/phone.png" title="Edit phone numbers" />');
                            var $img = $(
                                '<center><i><img src="https://asicomgraphics.mx/demos/dxlegal/editar.png"></i></center>'
                                //'<center><btn class="btn btn-sm btn-outline-danger btn-round btn-icon"><i class="nc-icon nc-layout-11" style="font-size: 1.5em;"></i></btn></center>'
                                );

                            //Open child table muestra usuarios que pertenecen a esa area y su grupo!
                            $img.click(function() {
                                    // alert(siniestro.record.folio);
                                    window.open('./?view=siniestro/editar&timerst='+siniestro.record.timerst, '_blank');
                            });
                            //Return image to show
                            return $img;
                        }
                    },
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
                            snr=sn.record;
                            var obj='';
                            var img_SI='';
                            var img_NO='';
                            //boton con primera atencion cargada
                            // <a class="dropdown-item" href="#" data-toggle="modal" data-target="#modalVerDocumentos" onclick="modalVerDocumentosJS('`+snr.timerst+`')" >Ver Documentos</a>


                            img_NO = $( //sin primer atencion
                            `<center><div class="btn-group actionBtn">
                                <button type="button" class="btn btn-danger dropdown-toggle buttonTable" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin: 0px !important;">
                                <i class="nc-icon nc-bulb-63"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="./?view=siniestro/ver&param=`+snr.timerst+`" target="_blank">Ver id</a>
                                    </div>
                                    </div>
                                    </center>`
                            );
                            /* 

                                    <a class="dropdown-item" onclick="vierFileF( '`+snr.timerst+`','primeraAtencion','PRIMERA ATENCIÓN'  )" class="btn btn-primary" data-toggle="modal" data-target="#modalFileView">Ver Primera Atención</a>
                                    <a class="dropdown-item" onclick="vierFileF( '`+snr.timerst+`','informePreliminar','INFORME PRELIMINAR'  )" class="btn btn-primary" data-toggle="modal" data-target="#modalFileView">Ver Informe Preliminar</a>
                                    <a class="dropdown-item" onclick="vierFileF( '`+snr.timerst+`','informeCancelacion','INFORME CANCELACIÓN'  )" class="btn btn-primary" data-toggle="modal" data-target="#modalFileView">Ver Informe Cancelación</a>
                                    

                                    <a class="dropdown-item" onclick="primeraAtencion(`+snr.timerst+`,'`+snr.folio+`','`+snr.nombre+`','`+snr.numReporte+`','`+snr.fechaReporte+`','`+snr.vigencia1+`','`+snr.vigencia2+`','`+snr.fechaAsignacion+`','`+snr.fechaCaptura+`','`+snr.institucion+`','`+snr.autoridad+`','`+snr.cel+" / "+snr.casa+" / "+snr.oficina+`','`+snr.mail+`')" href="#">Crear Primera Atención</a>
                                    <a class="dropdown-item" onclick="informePreliminar(`+snr.timerst+`,'`+snr.calificacion+`','`+snr.folio+`','`+snr.nombre+`','`+snr.numReporte+`','`+snr.fechaReporte+`','`+snr.vigencia1+`','`+snr.vigencia2+`','`+snr.fechaAsignacion+`','`+snr.fechaCaptura+`','`+snr.institucion+`','`+snr.autoridad+`','`+snr.cel+" / "+snr.casa+" / "+snr.oficina+`','`+snr.mail+`')" href="#">Cargar Informe Preliminar</a>
                                    <a class="dropdown-item" onclick="informeCancelacion(`+snr.timerst+`,'`+snr.calificacion+`','`+snr.folio+`','`+snr.nombre+`','`+snr.numReporte+`','`+snr.fechaReporte+`','`+snr.vigencia1+`','`+snr.vigencia2+`','`+snr.fechaAsignacion+`','`+snr.fechaCaptura+`','`+snr.institucion+`','`+snr.autoridad+`','`+snr.cel+" / "+snr.casa+" / "+snr.oficina+`','`+snr.mail+`')" href="#">Cargar Informe Cancelación</a>
                            
                                    */
                            img_SI = $( // con primer atencion y sin preliminar  ver atencion, cargar preliminar
                            `<center><div class="btn-group actionBtn">
                                <button type="button" class="btn btn-warning dropdown-toggle buttonTable" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="margin: 0px !important;">
                                <i class="nc-icon nc-bulb-63"></i>
                                </button>
                                <div class="dropdown-menu">
                                <a class="dropdown-item" href="./?view=siniestro/ver&param=`+snr.timerst+`" target="_blank">Ver id</a>
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
                                    <div class="dropdown-divider"></div>
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
                                img = img_NO;
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
                                    console.log('hola mundo');
                            });
                            //Return image to show
                            return img;
                        }
                    },

                    //CHILD TABLE "DATOS DE CHILD TABLE DE SINIESTROS""

                    id: {
                        title: 'Folio',
                        key: true,
                        list: true,
                        width: '3%'
                    },
                    status2: {
                        title:'Status',
                        list: true,
                        style: 'jtable-command-column status',
                        width: '3%',
                        sorting: false,
                        edit: false,
                        create: false,
                        display: function(sn) {
                            status = sn.record.status;
                            var $img = $(
                                '<center> <button class="btn btn-round buttonTable notouch '+status.toLowerCase()+'">'+status+'</button></center>'
                                //'<center><btn class="btn btn-sm btn-outline-danger btn-round btn-icon"><i class="nc-icon nc-layout-11" style="font-size: 1.5em;"></i></btn></center>'
                                );
                            //Return image to show
                            return $img;
                        }
                    },
                    /* status:{
                        display:false,
                        title:'Status',
                        list: true,
                    }, */
                    /* calificacion:{
                        title: 'Calificación',
                        width: '10%'
                    }, */
                    calificacion: {
                        title:'Calificación',
                        list: true,
                        style: 'jtable-command-column Calificación',
                        width: '3%',
                        sorting: false,
                        edit: false,
                        create: false,
                        display: function(sn) {
                            calificacion = sn.record.calificacion;
                            var $img = $(
                                '<center> <button class="btn btn-round buttonTable notouch '+calificacion.toLowerCase()+'">'+calificacion+'</button></center>'
                                //'<center><btn class="btn btn-sm btn-outline-danger btn-round btn-icon"><i class="nc-icon nc-layout-11" style="font-size: 1.5em;"></i></btn></center>'
                                );
                            //Return image to show
                            return $img;
                        }
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
                        title: '    ID',
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
                    fechaAsignacion:{
                        title: 'FechaAsignación',
                        width: '10%',
                        type: 'text',
                    },
                    fechaCaptura:{
                        title: 'fechaCaptura',
                        width: '10%',
                        type: 'text'
                    } 
                    
                }
            });
            $('#tablaSiniestrosTodos').jtable('load');
            
            setTimeout(() => {
                $('#abogados').select2().val();
                console.log("update");
            }, 500);
        }

        function laveSelectAbogado(){
            localStorage.setItem("abogados",'');
            $('#abogados').select2().val([]).trigger();
            // $('#abogados').select2().val(null).trigger();
            // $('#abogados').select2().val(null).trigger('change');
        }

        var sel1='';
        var selx='';

    window.onload=function (){

        localStorage.setItem('abogados', "0");

        setTimeout(function(){
            leerTablaSiniestros();
        },500)
        
        /*  $("#btn_prov_F").on('click',function(){ //boton de filtro, al desplegar panel, esconde botones de provenientes
            $("button.btn_prov").toggleClass("showbtn");
        }); */
        
        $.each(document.querySelectorAll('.js-select2'), function(i, key) {
            $(key).select2({
                placeholder: " " + $(key).attr('placeholder')
            });
        });
        
        //filtrar por abogados
        $('#abogados').on( "change", function(event) {//hjace referencia al select2JS de abogados
            //alert( $( this ).html() );
            // localStorage.setItem('abogados', $('#abogados').select2().val()); //en obj
            // $('#abogados').val( localStorage.getItem('abogados') ).trigger('change.select2');
            console.log("#abogados.onchange");
            selx = event;
            if($("#abogados").select2().val().length >=1){
                //let i = $("#abogados").select2().val()[0];
                //let name = event.delegateTarget.options[parseInt(i)].label;

                //localStorage.setItem('abogados_name', name ); // en string
                localStorage.setItem('abogados', JSON.stringify( $("#abogados").select2().val())  ); // en string

                buscarUserSiniestros();
            }
            //leerTablaSiniestros();
            //console.log( localStorage.getItem('abogados') );
        } );

        //activar jtable
      
        
    };


    function swalertOk(title,text){
        Swal.fire({
        title: title,
        text: text,
        icon: 'info',
        confirmButtonText: 'Continuar'
        })
    }


    



    // function tongleShow(elemento){
    //     $(elemento).toggleClass('show');
    // }

    //filtro por proveedor
    function selectProv(prov='') { //selecciona el provedor a ver en la tabla.
        $('.btn_prov').removeClass('active');
        $('.btn_prov').addClass('btn-link'); //desaparece todos

        $('#tablaSiniestrosTodos').jtable('destroy');
        console.log("cargando tabla de " + prov);
        localStorage.setItem('prov', prov);
        leerTablaSiniestros();
    }
    
    function buscarUserSiniestros(statusS = '') { //selecciona el provedor a ver en la tabla.
        setTimeout(function(){
            $('#tablaSiniestrosTodos').jtable('destroy');
            console.log("sersiniestris anogado")
            leerTablaSiniestros();
        },500)
        
    }

    //filtro por status
    function selectStatus(statusS = '') {
        $('.btn_prov').removeClass('active');
        $('.btn_prov').addClass('btn-link'); //desaparece todos

        $('#tablaSiniestrosTodos').jtable('destroy');
        console.log("cargando tabla de " + statusS);
        localStorage.setItem('statusS', statusS);
        leerTablaSiniestros();
    }

    //filtro por status
    function selectCalificacion(calificacion = '') {
        $('.btn_prov').removeClass('active');
        $('.btn_prov').addClass('btn-link'); //desaparece todos

        $('#tablaSiniestrosTodos').jtable('destroy');
        console.log("cargando tabla de " + calificacion);
        localStorage.setItem('calificacion', calificacion);
        leerTablaSiniestros();
    }



    //filtro por areas
    function selectArea(areaS=''){
        $('.btn_prov').removeClass('active');
        $('.btn_prov').addClass('btn-link'); //desaparece todos

        $('#tablaSiniestrosTodos').jtable('destroy');
        console.log("cargando tabla de " + areaS);
        localStorage.setItem('areas',areaS);
        leerTablaSiniestros();
    }


    //filtrar por solo siniestros asignados
    function selectAsignados(){
        console.log("ejecutando....");
        siniestrosAsignados=$('#siniestrosAsignados').prop('checked');
        $('#tablaSiniestrosTodos').jtable('destroy');
        console.log("cargando tabla de asignados1");
        localStorage.setItem('soloAsignados',siniestrosAsignados);
        leerTablaSiniestros();
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

    var hideMenuShow= 1;
    function hideShowMenu(){
        if (hideMenuShow==1){
            hideMenuShow= 0;
            $('.sidebar').css("left","-233px");
            $('.main-panel').css('width','100%');
        }
        else{
            hideMenuShow= 0;
            $('.sidebar').css("left","0px");
            $('.main-panel').css('width','calc(100% - 233px)' );
        }
        

    }
</script>
<style>
    .sidebar{
        transition: all .3s ease-in-out 0s;
    }
    
    button.active{
        color:#d5cab2 !important;
    }
    button.btn_prov:active{
        color:red !important;
    }
    .btn_prov{
        transition: all ease-in-out 0.3s;
    }
    .showbtn{
        display: none !important;
    }

    div.jtable-main-container>table.jtable>tbody>tr.jtable-data-row>td:nth-child(7){  /* status */
        white-space: normal !important;
        min-width: 100px !important;
        text-align: center;
    }
    div.jtable-main-container>table.jtable>tbody>tr.jtable-data-row>td:nth-child(9){ /* prov  */
        text-align: center;
    } 
    div.jtable-main-container>table.jtable>tbody>tr.jtable-data-row>td:nth-child(8),/* folio, reporte  */
    div.jtable-main-container>table.jtable>tbody>tr.jtable-data-row>td:nth-child(10){
        white-space: normal !important;
        min-width: 100px !important;
        text-align: center;
        font-weight: 700;
    }
    div.jtable-main-container>table.jtable>tbody>tr.jtable-data-row>td:nth-child(14), /* institucion , autoridad  */
    div.jtable-main-container>table.jtable>tbody>tr.jtable-data-row>td:nth-child(15){
        white-space: normal !important;
        min-width: 360px !important;
    }
    /* //UIk Jquery */
    .ui-dialog.ui-corner-all.ui-widget.ui-widget-content.ui-front.ui-dialog-buttons.ui-draggable.ui-resizable {
        position: relative;
        height: auto;
        width: 300px;
        top: -659.5px;
        left: 621.5px;
        background: radial-gradient(#e5deb7, #ffffff);
        padding: 2em;
        font-size: 1em;
        text-align: center;
    }
    .custom-control-input:checked~.custom-control-label::before {
        color: #fff !important;
        border-color: #c9b17f !important;
        background-color: #c9b17f !important;
    }
    .custom-switch .custom-control-label::before {
        cursor: pointer;
    }

    .select2-selection--multiple{
        overflow: hidden !important;
        height: auto !important;
        height: max-content !important;
    }
</style>