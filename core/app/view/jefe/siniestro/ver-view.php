<?php
/*ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(1);*/

if ( isset($_REQUEST['search']) and isset($_REQUEST['search']) ){
  header("Location: ./?action=searchID&search=".$_REQUEST['search']);//redirecciona al para buscar siniestro por id
}

if (!isset($_REQUEST['param']) and isset(  explode('.',$_REQUEST['param'])[1])  ){
header("Location: ./view=index");//redirecciona al inicio si no trae el parametro
}
// core::preprint(explode('/',$_SESSION['grupo'][0]));
$areaIDuser = explode('/',$_SESSION['grupo'][0])[2];
$areaNombre = explode('/',$_SESSION['grupo'][0])[0];
  $__area__ = str_replace(' ','',$areaNombre); //nombre del area sin espacios
$SiniestroData = Siniestros::verSiniestroTimerst($_REQUEST['param']);
$sn = $SiniestroData; //datos del siniestro o ID
$sn['areasAsignadas'] = Siniestros::getAllAreasOfSiniestro($sn['timerst']);
$sn['abogadosAsignados'] = Siniestros::getAllAbogadosOnSiniestro($sn['timerst']);
$anterioresDescripcionesHechos = Siniestros::getVersionesDescripcionHechos($sn['timerst']);
$sn['descripciones'] = $anterioresDescripcionesHechos;
$poliza = Siniestros::getNumPoliza($sn['timerst'],$sn['numPoliza']);
$sn['poliza'] = '';
foreach ($poliza as $key) {
  $sn['poliza'].= $key['poliza'].' / ';
}



$sn['telefonos']= 'cel: '.$sn['cel'].' / casa: ' .$sn['casa'] .' / oficina: '.$sn['oficina'];



$dataFilesSelect= Config::datosSelectFilesUoload(); //datos del input de tipo de archivo
core::sendVarToJs(json_encode($dataFilesSelect),'dataFilesSelect');

$dataAreasJS=Folios::obtenerAreas();
core::sendVarToJs(json_encode($dataAreasJS),'dataAreasJS');

//codigo para crear las clases que colorean los status y calificaciones.
$statusList = Folios::obtenerConfigCampo('status');
$calificacionesList = Folios::obtenerConfigCampo('calificacion');
$cssStyle='';
foreach ($calificacionesList as $key) {
    $cssStyle.= ' .'.strtolower(explode(' ',$key->valor)[0]).'{ background:'.$key->extra.' !important;} ' ;
}
foreach ($statusList as $key) {
    $cssStyle.= ' .'.strtolower(explode(' ',$key->valor)[0]).'{ background:'.$key->extra.' !important;} ' ;
}
print('<style>.notouch{pointer-events:none}'.$cssStyle.'</style>');


/* $sn['Administrativa'] = Siniestros::verInformePreliminar($sn['timerst'],'Administrativa');
core::preprint($sn['Administrativa']);
exit(); */
?>
<style>
  .capsule{
    float: right;
    padding: 0.4em;
    border-radius: 11px;
    margin-top: -6px;
  }
  span.select2-selection,
  span.select2-selection__rendered,
  select,
  textarea,
  input{
    background-color: white !important;
    border: 0px solid #DDDDDD !important;
    color:#66615b !important;
  }
</style>


<!-- Modal cambniar Autoridad-->
<div class="modal fade" id="modalCambiaAutoridad" tabindex="null" role="dialog" aria-labelledby="modalCambiaAutoridadLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCambiaAutoridadLabel">Cambia Autoridad</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalCambiaAutoridadBody">
                    <div class="form-group institucionGroup">
                        <label for="floatingInput">Selecciona Autoridad</label>
                        <select class="js-select2-tags form-control" placeholder="Selecciona Autoridad" tag="true" name="btnAutoridad" id="btnAutoridad" style="width:100%;" required>
                            <!-- name="states[]" multiple="multiple" -->
                            <!-- <option>Selecciona Autoridad</option> -->
                            <option> </option>
                            <?php
                            $instituciones = Folios::obtenerConfigCampo('autoridad');
                            foreach ($instituciones as $key) {
                                print "<option value='" . $key->id . "'>" . ($key->valor) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" >Cerrar</button>
        <button type="button" class="btn btn-secondary" onclick="cambiaAutoridad()" >Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal cambniar Institución-->
<div class="modal fade" id="modalCambiaInstitucion" tabindex="null" role="dialog" aria-labelledby="modalCambiaInstitucionLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCambiaInstitucionLabel">Cambia Institución</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalCambiaInstitucionBody">
                    <div class="form-group institucionGroup">
                        <label for="floatingInput">Selecciona Institución</label>
                        <select class="js-select2-tags form-control" placeholder="Selecciona Institución" tag="true" name="btnInstitucion" id="btnInstitucion" style="width:100%;" required>
                            <!-- name="states[]" multiple="multiple" -->
                            <!-- <option>Selecciona Institución</option> -->
                            <option> </option>
                            <?php
                            $instituciones = Folios::obtenerConfigCampo('institucion');
                            foreach ($instituciones as $key) {
                                print "<option value='" . $key->id . "'>" . ($key->valor) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" >Cerrar</button>
        <button type="button" class="btn btn-secondary" onclick="cambiaInstitucion()" >Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal cambniar Status-->
<div class="modal fade" id="modalCambiaStatus" tabindex="-1" role="dialog" aria-labelledby="modalCambiaStatusLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCambiaStatusLabel">Cambia Status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalCambiaStatusBody">
                    <div class="form-group statusGroup">
                        <label for="floatingInput">Selecciona status</label>
                        <select class="js-select2 form-control" placeholder="Selecciona" id="btnstatus" name="btnstatus" style="width:100%;" required>
                            <!-- name="states[]" multiple="multiple" -->
                            <!-- <option>Selecciona status</option> -->
                            <option> </option>
                            <?php

                            $statusI = $statusList;////Folios::obtenerConfigCampo('status');
                            foreach ($statusI as $key) {
                                print "<option class='".strtolower($key->valor)."' data-value='".$key->id."' data-background='".$key->extra."' value='" . $key->id . "'>" . ucwords($key->valor) . "</option>";
                            }
                            ?>
                            <!--    <option value='verificado'>V -Verificado</option>
                                    <option value='pendiente'>P-Pendiente</option>
                                    <option value='cancelado'>C-Cancelado</option> 
                            -->
                        </select>
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" >Cerrar</button>
        <button type="button" class="btn btn-secondary" onclick="cambiaStatus()" >Guardar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal cambniar calificacion-->
<div class="modal fade" id="modalCambiacalificacion" tabindex="-1" role="dialog" aria-labelledby="modalCambiacalificacionLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalCambiacalificacionLabel">Cambia calificacion</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalCambiacalificacionBody">
                    <div class="form-group calificacionGroup">
                        <label for="floatingInput">Selecciona calificación</label>
                        <select class="js-select2 form-control" placeholder="Selecciona Calificación" name="btncalificacion" id="btncalificacion" style="width:100%;" required>
                            <!-- name="states[]" multiple="multiple" -->
                            <!-- <option>Selecciona Calificacion</option> -->
                            <option> </option>
                            <?php
                            $calificaciones = $calificacionesList;//// = Folios::obtenerConfigCampo('calificacion');
                            ////$cssStyleCalificacion='';
                            foreach ($calificaciones as $key) {
                                print "<option class='".strtolower($key->valor)."'  data-value='" . $key->id . "' data-background='".$key->extra."' value='" . $key->id . "'>" . ucwords($key->valor) . "</option>";
                                ////$cssStyleCalificacion.= ' .'.strtolower(explode(' ',$key->valor)[0]).'{ background:'.$key->extra.';} ' ;
                            }
                            ?>
                        </select>
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" >Cerrar</button>
        <button type="button" class="btn btn-secondary" onclick="cambiaCalificacion()" >Guardar</button>
      </div>
    </div>
  </div>
</div>



 <!-- Modal -->
 <!-- Modal SE USA E VARIOS PERO SE REESCRIBEN SUS VALORES !!no borrar !!no borrar !!no borrar !!no borrar !!no borrar-->
<div class="modal fade" id="modalFileView" role="dialog" aria-labelledby="modalFileViewLabel" aria-hidden="true">
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
        <input type="hidden" value="cero" name="link" id="link">
        <input type="hidden" value="cero" name="linkpdf" id="linkpdf">
        <input type="hidden" value="cero" name="idfile" id="idfile">
        <input type="hidden" value="cero" name="version" id="version">
        <input type="hidden" value="cero" name="c1" id="c1">
        <input type="hidden" value="cero" name="c2" id="c2">
        <input type="hidden" value="cero" name="c3" id="c3">
        <input type="hidden" value="<?=$sn['timerst']?>" name="timerstFile" id="timerstFile">
        <input type="hidden" value="null" name="nombreAreaFile" id="nombreAreaFile">

        <!-- <button onclick="emailsSendOutlook()" outlook type="button" class="btn btn-secondary">Enviar por Outlook</button> -->
        <button onclick="emailsSendPrepare()" plataforma type="button" class="btn btn-primary">Enviar por plataforma</button>

        <button type="button" class="btn btn-outline-primary " data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Asignar Area modalAsignarArea-->
<div class="modal fade" id="modalAsignarArea" tabindex="-1" role="dialog" aria-labelledby="modalAsignarAreaLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAsignarAreaLabel">Asignar Area</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalAsignarAreaBody">
                    <div class="form-group col-12">
                        <select class="js-select2 form-control" placeholder="Asigna Área" id="asignArea" name="asignArea[]" style="width:100%;" multiple="multiple">
                            <!-- name="states[]"  -->
                            <!-- <option>Asigna Área</option> -->
                            <?php
                              $areas = Folios::obtenerAreas();
                              $areasA=[];
                              foreach ($sn['areasAsignadas'] as $key) {
                                $areasA[]=array('area'=> $key['area'],'id'=>$key['id']);
                              }
                              $areasNoasignadas=[];
                              foreach ($areas as $key) { //recorre todas las areas
                                $existe='no';
                                foreach ($areasA as $k ) { //recorre las areas asignadas
                                  if ($key->area==$k['area']) { $existe='si';}
                                  else{ continue; }
                                }
                                if($existe=='no'){ $areasNoasignadas[]=$key; } //si no existe en el array de asignadas, lo push a $areasNoasignadas
                              }
                              foreach ($areasNoasignadas as $key) {
                                  print "<option value='" . $key->id . "'>" . strtoupper($key->area) . "</option>";
                              }
                            ?>
                        </select>
                    </div>
                    <div class="col-12">
                      <div class="form-group">
                          <select class="js-select2 form-control" place="abogados" placeholder="Asigna Abogado" id="abogados" name="abogados[]" multiple="multiple" style="width:100%;">
                              <?php
                             /*  $abogados = Folios::obtenerAbogados();
                              core::sendVarToJs(json_encode($abogados), 'abogadosTodos');
                              foreach ($abogados as $key => $value) {
                                  print "<option value='" . $value->id . "'>" . $value->nombre . " : " . $value->area . "</option>";
                              } */
                              ?>
                          </select>
                      </div>
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" >Cerrar</button>
        <button type="button" class="btn btn-secondary" onclick="asignArea()" >Asignar</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal modalAsignaAbogado -->
<div class="modal fade" id="modalAsignaAbogado" tabindex="-1" role="dialog" aria-labelledby="modalAsignaAbogadoLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAsignaAbogadoLabel">Asigna un nuevo Abogado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalAsignaAbogadoBody">
                  <div class="form-group">
                        <select class="js-select2 form-control" place='abogados' placeholder="Asigna Abogado" id="aboAsigndo" name="aboAsigndo[]" multiple="multiple" style="width:100%;">
                            <!-- name="states[]"  -->
                            <!-- <option>Asigna Abogado</option> -->
                            <?php
                            
                            // core::preprint($sn['abogadosAsignados']);
                            $abogados = Folios::obtenerAbogados($sn['areasAsignadas']);
                            //  core::preprint($abogados);
                                                        
                            $abogadosNoAsignados=[];
                            foreach ($abogados as $key) { //recorre todos abogados de las areas asignadas
                              $existe='no';
                              foreach ($sn['abogadosAsignados'] as $k ) { //recorre las areas asignadas
                                // core::preprint($k['usuario'],'uscompar');
                                // core::preprint($key->id,'uscompar2');
                                if ($key->id==$k['usuario']) { $existe='si';}
                                else{ continue; }
                              }
                              if($existe=='no'){ $abogadosNoAsignados[]=$key; } //si no existe en el array de asignadas, lo push a $abogadosNoAsignados
                            }
                            foreach ($abogadosNoAsignados as $key) {
                                print "<option avatar='".$key->avatar."' value='" . $key->id . "'>" .($key->nombre) ." : ". ($key->area)."</option>";
                            }
                            /* core::sendVarToJs(json_encode($abogados), 'abogadosTodos');
                            foreach ($abogados as $key => $value) {
                                print "<option value='" . $value->id . "'>" . $value->nombre . " : " . $value->area . "</option>";
                            } */
                            ?>
                        </select>
                        <?php //core::preprint($abogados); ?>
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" >Cerrar</button>
        <button type="button" class="btn btn-secondary" onclick="this.disabled=true;asignAbogado()" >Asignar</button>

      </div>
    </div>
  </div>
</div>

<!-- modal modalNuevaEntradaBitacora -->
<div class="modal fade" id="modalNuevaEntradaBitacora" tabindex="-1" role="dialog" aria-labelledby="modalNuevaEntradaBitacoraLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content"> 
    <form id="newBitacoraModalForm" action="./?action=siniestro/bitacora&metodo=nuevo" method="post">
      <div class="modal-header">
        <h5 class="modal-title" id="modalNuevaEntradaBitacoraTitle">Nueva Entrada En Bitácora</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="">
        <div class="d-none" id="inputArea">

        </div>
        <label for="horas">Horas en número: </label>
        <input class="campoBitacora" id="horasBitacora" name="horasBitacora" type="number" maxlength="2" value="1" min=0.5 max="24" step=".5" required /> hrs. <br>
        <label for="horas">Fecha Actividad: </label>
        <input class="campoBitacora" id="fechaActividad" name="fechaActividad" type="date" required />.

       <textarea class="campoBitacora"  name="nuevaEntrada" id="nuevaEntrada" rows="10" style="width:100%;border:#66615b solid 1px !important" required></textarea>
       <input name="timerst" id="timerst" class="input form-input" type="hidden" value="<?php echo $sn['timerst'] ?>">
      </div>
      <div class="modal-footer">
        <button type="button" type class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
        <input class="btn  btn-primary" type="submit" value="Guardar Entrada">
      </div>
    </form>
    </div>
  </div>
</div>

<!-- modal modalVerDescricionHechos -->
<div class="modal fade" id="modalVerDescricionHechos" tabindex="-1" role="dialog" aria-labelledby="modalVerDescricionHechosLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content"> 
      <div class="modal-header">
        <h5 class="modal-title" id="modalVerDescricionHechosTitle">Descripción de los hechos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="">
        <div class="d-none" id="inputArea">

        </div>
       <span name="desHechosAnteriores" id="desHechosAnteriores" style="width:100%;border:#66615b solid 0px !important" required></span>
       <input name="timerst" id="timerst" class="input form-input" type="hidden" value="<?php echo $sn['timerst'] ?>">
      </div>
      <div class="modal-footer">
        <button type="button" type class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
        <!-- <input class="btn  btn-primary" type="submit" value="Guardar Entrada"> -->
      </div>
    </div>
  </div>
</div>

<!-- modal modalEditDescricionHechos -->
<div class="modal fade" id="modalEditDescricionHechos" tabindex="-1" role="dialog" aria-labelledby="modalEditDescricionHechosLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <form action="" method="post">
        <div class="modal-content"> 
          <div class="modal-header">
            <h5 class="modal-title" id="modalEditDescricionHechosTitle">Editar Descripción de los hechos</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="">
            <textarea class="textarea" id="textareaDescripcion">
                <?php echo urldecode($sn['descripcionHechos'] )?>
            </textarea>
          <input name="timerst" id="timerst" class="input form-input" type="hidden" value="<?php echo $sn['timerst'] ?>">
          </div>
          <div class="modal-footer">
            <button type="button" type class="btn  btn-secondary" data-dismiss="modal">Cerrar</button>
            <input class="btn  btn-primary" id="btnEditDescripcion" type="button" value="Guardar Entrada">
          </div>
        </div>
    </form>
  </div>
</div>

<!-- MODAL CARATULA -->
<div class="modal fade" id="modalFileCaratula" role="dialog" aria-labelledby="modalFileCaratulaLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalFileCaratulaLabel">Caratula del ID</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalFileCaratulaBody">
       ...
      </div>
      <div class="modal-footer">
        <input type="hidden" value="cero" name="link" id="link">
        <input type="hidden" value="cero" name="linkpdf" id="linkpdf">
        <input type="hidden" value="cero" name="idfile" id="idfile">
        <input type="hidden" value="cero" name="version" id="version">
        <input type="hidden" value="cero" name="c1" id="c1">
        <input type="hidden" value="cero" name="c2" id="c2">
        <input type="hidden" value="cero" name="c3" id="c3">
        <input type="hidden" value="<?=$sn['timerst']?>" name="timerstFile" id="timerstFile">
        <input type="hidden" value="null" name="nombreAreaFile" id="nombreAreaFile">

        <!-- <button onclick="emailsSendOutlook()" outlook type="button" class="btn btn-secondary">Enviar por Outlook</button> -->
        <!-- <button onclick="emailsSendPrepare()" plataforma type="button" class="btn btn-primary">Enviar por plataforma</button> -->

        <button type="button" class="btn btn-outline-primary " data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- INICIA PÁGINA -->

<div class="content">

  <div class="row">
    <div class="col-lg-9 pr-md-0">
      <!-- PESTAÑAS -->
      <div class="col-md-12">


<!-- INICIAN BOTONES DE SEGMENTACION POR AREAS SOLO PARA ADMINISTRADOR DE SINIESTROS Y ADMIN DE APP1 -->
<?php 
$power=false;
foreach ($sn['abogadosAsignados'] as $abo) {
  if ($abo['usuario'] == $_SESSION['id'])
  $power=true;
}

// core::preprint($sn['abogadosAsignados']);

$permisoKey=[];//permiso para ver cada area
foreach ($sn['areasAsignadas'] as $k) {
  $permiso=true;
  $permisoKey[str_replace(' ','',$k['area'])]=true;
  $type=" btn-primary ";
  

  
  if(strcmp($areaIDuser, $k['id']) != 0) {
    $permiso=false; 
    $type=" btn-outline-primary ";
    $permisoKey[str_replace(' ','',$k['area'])]=false;};
  print '<a onclick="panelOpen(\'#collapse'.str_replace(' ','',$k['area']).'\')" class="btn '.$type.' btn-round" data-toggle="collapse" href="#collapse'.str_replace(' ','',$k['area']).'" role="button" aria-expanded="false" aria-controls="collapse'.str_replace(' ', '', $k['area']).'">'.$k['area'].'</a>';
}
if(!$power){
  ?>
  <script>
    setTimeout(() => {
      document.querySelector("div.content").style.opacity = 0.6;
      document.querySelectorAll("button.btn").forEach(element => element.style.display = 'none');
    }, 500);
  </script>
  <?php
}
?>
<!-- TERMINAN BOTONES DE SEGMENTACION POR AREAS SOLO PARA ADMINISTRADOR DE SINIESTROS Y ADMIN DE APP -->

<!-- INICIAN EXPAND DE BOTONES DE SEGMENTACION SOLO PARA ADMINISTRADOR DE SINIESTROS Y ADMIN DE APP -->
<?php 
$scripttable ="";
foreach ($sn['areasAsignadas'] as $k) {
  $_AreaID= $k['id']; //id del area
  $_AREA = $k['area']; // nombre del area
  $_area = str_replace(' ','',$_AREA); //nombre del area sin espacios
  $oculto = ' '; if($_AreaID=='4' || $_AreaID==5  || $permisoKey[$_area] === false){ $oculto = 'display:none !important;'; } //si es area 4 o 5 , cntabilidad o administrativa, oculta.

  //core::preprint(  $sn[$_area]['primera_atencion']);exit();
  $sn[$_area]['bitacora'] = Siniestros::verBitacora($sn['timerst'],$_AREA);//bitacora
  $sn[$_area]['primeratencion'] = Siniestros::verPrimeraAtencion($sn['timerst'],$_AREA);
  $sn[$_area]['informePreliminar'] = Siniestros::verInformePreliminar($sn['timerst'],$_AREA);
  $sn[$_area]['informeActualizacion'] = Siniestros::verInformeActualizacion($sn['timerst'],$_AREA);
  $sn[$_area]['informeCancelacion'] = Siniestros::verInformeCancelacion($sn['timerst'],$_AREA);
  $sn[$_area]['calificacion'] = Siniestros::getCalificacionByArea($sn['timerst'],$_AreaID);
  $sn[$_area]['status'] = Siniestros::getStatusByArea($sn['timerst'],$_AreaID);

  // core::preprint($sn[$_area]['primeratencion']['primera_atencion'],'area');exit();


  $scripttable .="
  $('#theTable$_AreaID').DataTable({
    language: {
      url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-MX.json',
      //cdn.datatables.net/plug-ins/1.13.4/i18n/es-MX.json
    },
    ajax: './?action=siniestro/datos&metodo=traer&param1=" . $sn['timerst'] . "&param2=$_AreaID&param3=$_area',
    columns: [" . '
      { "data": "blanco" },
      { "data": "instancia_procedimiento" },
      { "data": "etapa" },
      { "data": "nombre_documento" },
      { "data": "version" },
      { "data": "fecha" },
      { "data": "ver" }
    ],' . "
    initComplete: function () {
      //$('.dataTables_length label').attr('aria-label', 'table length');
      $('label').contents().unwrap();

    }
  });
  ";
  


  print '
  <div class="collapse multi-collapse " id="collapse'.$_area.'">
    <div class="row">
      <div class="col  pl-lg-0 pr-lg-0">
        <div class="card-header">
            <span> ' .$_AREA. ' </span>
            ';
            if($permisoKey[$_area]==true){
                print '<span onclick="changeParam('.$_AreaID.',\'status\',\''.$_AREA.'\')" data-toggle="modal" data-target="#modalCambiaStatus"       class="mr-3 capsule rounded-pill '.strtolower($sn[$_area]['status']).'" style="cursor:pointer; float: right;"><b>Status:</b>   '.$sn[$_area]['status'].'  </span>';
                print '<span onclick="changeParam('.$_AreaID.',\'calificacion\',\''.$_AREA.'\')" data-toggle="modal" data-target="#modalCambiacalificacion"  class="mr-3 capsule rounded-pill '.strtolower($sn[$_area]['calificacion']).' " style="cursor:pointer; float: right;"><b>Calificación:</b> '. $sn[$_area]['calificacion'].'  </span>';
            }
            else{
              print '<span class="mr-3 capsule rounded-pill '.strtolower($sn[$_area]['status']).'" style="cursor:pointer; float: right;"><b>Status:</b>   '.$sn[$_area]['status'].'  </span>';
              print '<span class="mr-3 capsule rounded-pill '.strtolower($sn[$_area]['calificacion']).' " style="cursor:pointer; float: right;"><b>Calificación:</b> '. $sn[$_area]['calificacion'].'  </span>';
            }
 print '</div>
        <div class="">
          <div claas="">';
          ?>
          <!-- COMIENZA ITERACION DE PESTAÑAS POR AREAS SOLO PARA ADMINISTRADORES Y ADMIN DE SINIESTROS -->
            <div class="card" style="border-radius: 0 0 12px 12px;">
              <div class="card-body">
                <div class="nav-tabs-navigation">
                  <div class="nav-tabs-wrapper">
                    <ul id="tabs row" class="nav nav-tabs" role="tablist">
                      <li  onclick="tabOpen('#atencion<?=$_area?>')"  data-name="atencion<?=$_area?>" class="nav-item col px-0 mx-0" style="<?=$oculto;?>"> <!-- si el area lo permite, se muestra o se oculta -->
                        <a class="nav-link" data-toggle="tab" href="#atencion<?=$_area?>" role="tab" aria-expanded="false" aria-selected="false">Primera Atención</a>
                      </li>
                      <li onclick="tabOpen('#preliminar<?=$_area?>')" data-name="preliminar<?=$_area?>" class="nav-item col px-0 mx-0" style="<?=$oculto;?>"> <!-- si el area lo permite, se muestra o se oculta -->
                        <a class="nav-link" data-toggle="tab" href="#preliminar<?=$_area?>" role="tab" aria-expanded="false" aria-selected="false">Informe Preliminar</a>
                      </li>
                      <li onclick="tabOpen('#actualizacion<?=$_area?>')" data-name="actualizacion<?=$_area?>" class="nav-item col px-0 mx-0" style="<?=$oculto;?>"> <!-- si el area lo permite, se muestra o se oculta -->
                        <a class="nav-link" data-toggle="tab" href="#actualizacion<?=$_area?>" role="tab" aria-expanded="false" aria-selected="false">Informe Actualización</a>
                      </li>
                      <li onclick="tabOpen('#documentos<?=$_area?>')" data-name="documentos<?=$_area?>" class="nav-item col px-0 mx-0"> <!-- si el area lo permite, se muestra o se oculta -->
                        <a class="nav-link" data-toggle="tab" href="#documentos<?=$_area?>" role="tab" aria-expanded="false" aria-selected="false">Documentación Cargada</a>
                      </li>
                      <li onclick="tabOpen('#cancelacion<?=$_area?>')" data-name="cancelacion<?=$_area?>" class="nav-item col px-0 mx-0" style="<?=$oculto;?>"> <!-- si el area lo permite, se muestra o se oculta -->
                        <a class="nav-link" data-toggle="tab" href="#cancelacion<?=$_area?>" role="tab" aria-expanded="false" aria-selected="false">Informe de Cancelación</a>
                      </li>
                      <li onclick="tabOpen('#bitacora<?=$_area?>')" data-name="bitacora<?=$_area?>" class="nav-item col px-0 mx-0" > <!-- si el area lo permite, se muestra o se oculta -->
                        <a class="nav-link" data-toggle="tab" href="#bitacora<?=$_area?>" role="tab" aria-expanded="false" aria-selected="false">Bitácora de actividades</a>
                      </li>
                    </ul>
                  </div>
                </div>
                <div id="my-tab-content" class="tab-content text-center">
                  
                  <div class="tab-pane text-left mx-5 mt-2" style="<?=$oculto?>" id="atencion<?=$_area?>" role="tabpanel" aria-expanded="false">
                      <div id="primeraAtencionC" style="width:100%;">
                        <?php //no tocar variables. quiebran en este punto y deben reasignarse.
                        $_area=$_area;
                        $_AREA=$_AREA;
                        $_AreaID=$_AreaID;

                         if(isset($sn[$_area]['primeratencion']['primera_atencion'])==1){
                            $bts= "
                            <div style='float: right;margin-right: -3em;' class='btn-group' role='group' aria-label='Basic example'>
                              <button style='float: right;' class='btn btn-secondary' onclick='primeraAtencionEDITAR(\"".$_area."\",\"".$_AREA."\",\"".$_AreaID."\")' > <i class='fa fa-pencil' aria-hidden='true'></i> </button> </center>
                              <button style='float: right;' class='btn btn-primary' onclick='primeraAtencionLINK(\"".$_area."\",\"".$_AREA."\",\"".$_AreaID."\")' > <i class='fa fa-envelope-o' aria-hidden='true'></i> </button> </center>
                            </div>
                            ";
                            print $bts;
                            $sn[$_area]['primeratencion']['primera_atencion'] = urldecode($sn[$_area]['primeratencion']['primera_atencion']);
                            print $sn[$_area]['primeratencion']['primera_atencion'];
                          }
                          else{
                            // <button class="btn btn-primary" onclick="primeraAtencion(\''.$sn['timerst'].'\',\''.$sn['folio'].'\',\''.$sn['nombre'].'\',\''.$sn['numReporte'].'\',\''.$sn['fechaReporte_F2'].'\',\''.$sn['vigencia1_F2'].'\',\''.$sn['vigencia2_F2'].'\',\''.$sn['fechaAsignacion_F2'].'\',\''.$sn['fechaCaptura_F2'].'\',\''.$sn['institucion'].'\',\''.$sn['autoridad'].'\',\''.$sn['telefonos'].'\',\''.$sn['mail'].'\')" >cargar Primera Atención</button>
                            print '<center><button class="btn btn-primary"  onclick="notificarAbogado(\''.$sn['timerst'].'\',\'primera_atencion\',\''.$_AREA.'\')" >Notificar al abogado asignado</button>';
                            print '<button class="btn btn-secondary" onclick="primeraAtencion('.$_AreaID.',\''.$sn['timerst'].'\')" >Cargar Primera Atención</button> </center>';
                          };
                        ?>
                      </div>
                  </div>
                  <div class="tab-pane text-left mx-5 mt-2" style="<?=$oculto?>" id="preliminar<?=$_area?>" role="tabpanel" aria-expanded="false">
                      <div id="informePreliminarC" style="width:100%;">
                          <?php 
                          if(isset($sn[$_area]['informePreliminar']['informe_preliminar'])==1){
                              // print '<button style="float: right;" class="btn btn-secondary" onclick="informePreliminarEDITAR(\''.$_area.'\',\''.$_AREA.'\',\''.$_AreaID.'\')" >Editar Informe Preliminar</button> </center>';

                                $action= 'onclick="informePreliminarSegundaParte('.$_AreaID.',\''.$sn['timerst'].'\',\''.  $sn[$_area]['calificacion'] .'\',\''.$sn['folio'].'\',\''.$sn['nombre'].' '.$sn['apellidoP'].' '.$sn['apellidoM'].'\',\''.$sn['numReporte'].'\',\''.$sn['fechaReporte'].'\',\''.$sn['vigencia1'].'\',\''.$sn['vigencia2'].'\',\''.$sn['fechaAsignacion'].'\',\''.$sn['fechaCaptura'].'\',\''.$sn['institucion'].'\',\''.$sn['autoridad'].'\',\''.$sn['telefonos'].'\',\''.$sn['mail'].'\',\''.$sn['formaContacto'].'\',\''.$sn['poliza'].'\',\''.$sn['numSiniestro'].'\',\''.$sn['fechaReporte'].'\',\''.$sn['vigencia1'].'\',\''.$sn['vigencia2'].'\',\''.$sn['fechaAsignacion'].'\',\''.$sn['fechaCaptura'].'\')" ';
                                $btnSegundaPart= "<button style='float: right;' class='btn btn-secondary' $action > Continuar Formato </button> </center>";
                                if($sn[$_area]['informePreliminar']['segundaParte'])
                                $btnSegundaPart = '';
                              $bts= "
                              <div style='float: right;margin-right: -3em;' class='btn-group' role='group' aria-label='Basic example'>
                                ".$btnSegundaPart."
                                <button style='float: right;' class='btn btn-primary' onclick='informePreliminarEDITAR(\"".$_area."\",\"".$_AREA."\",\"".$_AreaID."\")' > <i class='fa fa-pencil' aria-hidden='true'></i> </button> </center>
                                <button style='float: right;' class='btn btn-primary' onclick='informePreliminarLINK(\"".$_area."\",\"".$_AREA."\",\"".$_AreaID."\")' > <i class='fa fa-envelope-o' aria-hidden='true'></i> </button> </center>
                              </div>
                              ";
                              print $bts;
                              $sn[$_area]['informePreliminar']['informe_preliminar'] = urldecode($sn[$_area]['informePreliminar']['informe_preliminar']);
                              print $sn[$_area]['informePreliminar']['informe_preliminar'];

                                print '<br><b>PRIMER HOJA: </b><br>';
                              if($sn[$_area]['informePreliminar']['segundaParte']){
                                print '<br><b>HECHOS: </b><br>';
                                print urldecode( $sn[$_area]['informePreliminar']['segundaParte']['hechos'] );
                                print '<br><b>OBSERVACIONES: </b><br>';
                                print urldecode( $sn[$_area]['informePreliminar']['segundaParte']['observaciones'] );
                              }
                            }
                            else{
                              print '<center><button class="btn btn-primary" onclick="notificarAbogado('.$sn['timerst'].',\'informe_preliminar\',\''.$_AREA.'\')" >Notificar al abogado asignado</button>';
                              print '<button class="btn btn-secondary" onclick="informePreliminar('.$_AreaID.',\''.$sn['timerst'].'\')" >Cargar informe Preliminar</button> </center>';
                            };
                          ?>
                      </div>
                  </div>
                  <div class="tab-pane text-left mx-5 mt-2" style="<?=$oculto?>" id="cancelacion<?=$_area?>" role="tabpanel" aria-expanded="false">
                      <div id="informeCancelacionC" style="width:100%;">
                          <?php
                          
                          if(isset($sn[$_area]['informeCancelacion']['informe_cancelacion'])){
                              // print '<button style="float: right;" class="btn btn-secondary" onclick="informeCancelacionEDITAR(\''.$_area.'\',\''.$_AREA.'\',\''.$_AreaID.'\')" >Editar Informe Cancelación</button> </center>';
                              $bts= "
                              <div style='float: right;margin-right: -3em;' class='btn-group' role='group' aria-label='Basic example'>
                                <button style='float: right;' class='btn btn-secondary' onclick='informeCancelacionEDITAR(\"".$_area."\",\"".$_AREA."\",\"".$_AreaID."\")' > <i class='fa fa-pencil' aria-hidden='true'></i> </button> </center>
                                <button style='float: right;' class='btn btn-primary' onclick='informeCancelacionLINK(\"".$_area."\",\"".$_AREA."\",\"".$_AreaID."\")' > <i class='fa fa-envelope-o' aria-hidden='true'></i> </button> </center>
                              </div>
                              ";
                              print $bts;
                              $sn[$_area]['informeCancelacion']['informe_cancelacion'] = urldecode($sn[$_area]['informeCancelacion']['informe_cancelacion']);
                              print $sn[$_area]['informeCancelacion']['informe_cancelacion'];
                            }
                            else{
                              print '<center><button class="btn btn-primary" onclick="notificarAbogado('.$sn['timerst'].',\'informe_cancelacion\',\''.$_AREA.'\')" >Notificar al abogado asignado</button>';
                              print '<button class="btn btn-secondary" onclick="informeCancelacion('.$_AreaID.',\''.$sn['timerst'].'\')" >cargar informe Cancelación</button> </center>';
                            };
                          ?>
                      </div>
                  </div>
                  <div class="tab-pane text-left mx-5 mt-2" style="<?=$oculto?>" id="actualizacion<?=$_area?>" role="tabpanel" aria-expanded="false">
                      <div id="informeActualizacionC" style="width:100%;">
                          <?php
                          
                          if(isset($sn[$_area]['informeActualizacion']['informe_actualizacion'])){
                            // print '<button style="float: right;" class="btn btn-secondary" onclick="informeActualizacionEDITAR(\''.$_area.'\',\''.$_AREA.'\',\''.$_AreaID.'\')" >Editar Informe Actualización</button> </center>';
                            $bts= "
                              <div style='float: right;margin-right: -3em;' class='btn-group' role='group' aria-label='Basic example'>
                                <button style='float: right;' class='btn btn-secondary' onclick='informeActualizacionEDITAR(\"".$_area."\",\"".$_AREA."\",\"".$_AreaID."\")' > <i class='fa fa-pencil' aria-hidden='true'></i> </button> </center>
                                <button style='float: right;' class='btn btn-primary' onclick='informeActualizacionLINK(\"".$_area."\",\"".$_AREA."\",\"".$_AreaID."\")' > <i class='fa fa-envelope-o' aria-hidden='true'></i> </button> </center>
                              </div>
                              ";
                            print $bts;
                            $sn[$_area]['informeActualizacion']['informe_actualizacion']= urldecode($sn[$_area]['informeActualizacion']['informe_actualizacion']);
                            print $sn[$_area]['informeActualizacion']['informe_actualizacion'];
                            }
                            else{
                              print '<center><button class="btn btn-primary" onclick="notificarAbogado('.$sn['timerst'].',\'informe_actualizacion\',\''.$_AREA.'\') >Notificar al abogado asignado</button>';
                              print '<button class="btn btn-secondary" onclick="informeActualizacion('.$_AreaID.',\''.$sn['timerst'].'\')" >cargar informe Actualización</button> </center>';
                            };
                          ?>
                      </div>
                  </div>
                       
                  <!-- BITACORA -->
                  <div class="tab-pane mt-2 " id="bitacora<?php echo $_area;?>" role="tabpanel" aria-expanded="false">
                      <center>
                      <div class=" row justify-content-md-center">
                        <div class="col-12">
                            <button style='float: right;' class='btn btn-primary' onclick="downloadAsExcelBitacorasID('<?=$sn['timerst']?>');" > Descargar &nbsp; &nbsp; <!-- <i class='fa fa-file-excel-o' aria-hidden='true'></i> --> <span class="jtable-toolbar-item-icon" style="width: 17px;height: 17px;background: url('https://www.jtable.org/Content/images/Misc/excel.png')  no-repeat;position: absolute;" ></span> </button>
                      
                        </div>
                        <div class="col-12">
                          <div class="table">
                            <table class="table bitacoras">
                              <tr>
                              <?php // si es admin muestra el campo  accion
                                  $power = UserData::isAdmin();
                                  // if ($power==1)
                                  // echo "<th>Acn</th>";
                              ?>
                                <th width="55">V</th>
                                <th width="135" >Usuario</th>
                                <th>Actividad</th>
                                <th width="10%">Fecha Creado</th>
                                <th width="10%">Fecha Actividad</th>
                                <th width="35">Horas</th>
                              </tr>
                              <?php 
                            
                              if (count($sn[$_area]['bitacora'])>=1){
                                $col="";
                                $b=[];
                                foreach ($sn[$_area]['bitacora'] as $k) {
                                  // array_push($b,array('id'=>$k['id'],'bitacora'=>urldecode($k['bitacora'])) );
                                  $col.='<tr> ';
                                      // fecha de verificacion o boton de verificacion si es titular del area.
                                      include "ver/admin.php";  // coloca boton de accion segun el perfil de usuario
                                  
                                  // if($k['verificado']=='Verificado'){ // fecha de verificacion
                                  //   $col.=
                                  //   '<td style="text-transform:lowercase;" >'.$k['verificado'].'<br> <small style="font-weight:500;" class="text-primary">'.$k['fecha_verificacion'].'</small></td>';
                                  // }
                                  // else{//boton editar por que no se ha verificado
                                  //   $col.= 
                                  //   '<td> <button data-toggle="modal" data-target="#modalNuevaEntradaBitacora" onclick="disparadorEditarBitacora( \''.$_AreaID.'\',\''.$sn['timerst'].'\'  ,\''.$k['id'].'\' ,\''.$_area.'\' )" class="btn btn-primary btn-sm" >  <i class="nc-icon nc-ruler-pencil"></i>  </button> </td>';
                                  // }

                                  $col.='<td style="text-transform:capitalize;" >'.$k['usuario'];
                                      if($k['usuario_alter']){
                                        $col.='<br> <small>'.$k['usuario_alter'].'<small>';
                                      }
                                      $col.='</td>';
                                  $col.='<td style="" >'.urldecode($k['bitacora']).'</td>'.
                                  '<td style="text-transform:lowercase;" >'.$k['fecha_creacion_F'].'</td>'.
                                  '<td style="text-transform:lowercase;" >'.$k['fecha_actividad_F'].'</td>'.
                                  '<td style="text-transform:lowercase;" >'.$k['horas'].' hrs.</td>';
                                
                                }
                                //termina foreach
                                print $col;
                              }
                              else{//si no hay archivos
                                print "<tr><td colspan='6' class='text-center'>No se ha cargado Bitácora .</td></tr>";
                              }
                            /*  core::preprint($files_sn);
                              var_dump($files_sn); */
                              ?>
                            </table>
                          </div> <!-- table responsive -->

                        </div>

                        <div class="col-3">
                          <button type="button" data-toggle="modal" data-target="#modalNuevaEntradaBitacora" onclick="prepareModalBitacora('<?=$_AreaID?>')" class="btn btn-primary">Nueva Entrada</button>
                        </div>
                      
                        
                      </div>
                      </center>
                  </div>

                  <!-- DOCUMENTOS?? -->
                  <div class="tab-pane mx-5 mx-5 mt-2" id="documentos<?=$_area?>" role="tabpanel" aria-expanded="false">
                      <center>
                      <div class="row">
                      <div class="col-2">
                          <button type="button" onclick="disparadorFile('<?=$_AreaID?>')" class="btn btn-primary">añadir archivo</button>
                          <button type="button" style='float: right;' class='btn btn-primary' onclick="createLinksFiles('<?=$_area?>', '<?=$_AREA?>','<?=$_AreaID?>')" > <i class='fa fa-cloud-download' aria-hidden='true'></i> </button>
                          <button type="button" style='float: right;' class='btn btn-primary' onclick="createLinksFilesForMail('<?=$_area?>', '<?=$_AREA?>','<?=$_AreaID?>')" > <i class='fa fa-envelope-o' aria-hidden='true'></i> </button>
                        </div>
                        <div class="col-10">
                          <div class="table">
                          <table id="theTable<?=$_AreaID?>" class="display">
													<thead>
														<tr>
															<th></th>
															<th>Instancia / Procedimiento</th>
															<th>Etapa</th>
															<th>Nombre Documento</th>
															<th>Versión</th>
															<th>fecha</th>
															<th>Ver</th>
														</tr>
													</thead>
													<tfoot>
														<tr>
															<th></th>
															<th>Instancia / Procedimiento</th>
															<th>Etapa</th>
															<th>Nombre Documento</th>
															<th>Versión</th>
															<th>fecha</th>
															<th>Ver</th>
														</tr>
													</tfoot>
												</table>
                          </div> <!-- table responsive -->
                          <!-- <iframe id="downloader" src="" style="display:none;"></iframe> -->
                          <a id="downloader" href="" download="" style="display:none;">baja invisible</a>
                        </div>
                        
                      </div>
                      </center>
                  </div>



                </div>
              </div>
            </div>
          <!-- TERMINA ITERACION DE PESTAÑAS POR AREAS SOLO PARA ADMINISTRADORES Y ADMIN DE SINIESTROS -->

  <?php
    // ... div claas=" card-body">';
    print '</div> 
        </div>
      </div>
    </div>
  </div>';
}

core::sendVarToJs(json_encode($sn),'SiniestroID');
?>
<!-- TERMINA EXPAND DE BOTONES DE SEGMENTACION SOLO PARA ADMINISTRADOR DE SINIESTROS Y ADMIN DE APP -->


          
      </div>

      <!-- DATOS DEL SINIESTRO -->
      <!-- INFO DESCRIPCION DE HECHOS  -->
      <div class="row">
        <div class="col-lg-12  pl-lg-0 pr-lg-0">
          <!-- TAB -->
          <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="nav-tabs-navigation">
                    <div class="nav-tabs-wrapper">
                      <ul id="tabs" class="nav nav-tabs" role="tablist">
                        <li class="nav-item active">
                          <a class="nav-link active" data-toggle="tab" href="#descripcion" role="tab" aria-expanded="false" aria-selected="true">Descripción de los hechos</a>
                        </li>
                        <?php
                        if($anterioresDescripcionesHechos!=0 && is_array($anterioresDescripcionesHechos)){
                              ?>
                                <li class="nav-item">
                                  <a class="nav-link" data-toggle="tab" href="#versiones" role="tab" aria-expanded="false" aria-selected="false">Versiones Anteriores</a>
                                </li>
                              <?php
                        } // end if
                        
                        ?>
                      <button class='btn btn-primary py-0 m-0' data-toggle='modal' data-target='#modalEditDescricionHechos'  onclick="editDescripcion('<?=$sn['timerst']?>')" >Editar Descripción</button>
                      </ul>
                    </div>
                  </div>
                  <div id="my-tab-content" class="tab-content text-center">
                    <div class="tab-pane active text-left mx-5 mt-2" id="descripcion" role="tabpanel" aria-expanded="true">
                        <div id="descripcionDeHechos" style="width:100%;">
                          <?=urldecode($sn['descripcionHechos'])?>
                        </div>
                    </div>

                    <div class="tab-pane text-left mx-5 mt-2" id="versiones" role="tabpanel" aria-expanded="false">
                        <div id="descripcionDeHechos" style="width:100%;">
                            <div class="col-10">
                              <div class="table">
                                <table class="table">
                                  <tr>
                                    <th>Usuario</th>
                                    <th>Área</th>
                                    <th>Fecha</th>
                                    <th>Rev</th>
                                    <th>ver</th>
                                  </tr>
                                  <?php
                                  // core::preprint($anterioresDescripcionesHechos[0]);
                                  // core::preprint($anterioresDescripcionesHechos[0]['id']);
                                  $deshechant = [];
                                  if($anterioresDescripcionesHechos!=0 && is_array($anterioresDescripcionesHechos)){
                                        foreach ($anterioresDescripcionesHechos as $k) {
                                        $td= "<tr>
                                            <td>". $k['autor'] ."</td>
                                            <td>". $k['area'] ."</td>
                                            <td>". $k['fecha_creacion'] ."</td>
                                            <td>". $k['rev'] ."</td>
                                            <td><button class='btn btn-primary' data-toggle='modal' data-target='#modalVerDescricionHechos'  onclick='openDescripcion(\"".$k['id']. "\")' >ver</button></td>
                                          </tr>";
                                          echo $td;
                                          $d= $k['descripcion_hechos'];
                                          $deshechant[ $k['id'] ] = urldecode($d);
                                        }
                                        core::sendVarToJs($deshechant,'deshechant');
                                        echo "<script>
                                              var deshechant = ". json_encode($deshechant) .
                                        "/*variable varJs*/
                                        </script>";
                                  // core::preprint($deshechant);

                                  }?>
                                </table>
                              </div>
                            </div>
                        </div>
                    </div>

                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>



       <!-- INFO GENERAL DEL SINIESTRO O ID  -->
      <div class="col-lg-12  pl-lg-0 pr-lg-0">
        <div class="card">
          <!-- <div class="card-header"><div class="card-title"><h5>siniestro</div></div> -->
          <div class="card-body">
            <button onclick="vierFileCaratula('<?=$sn['timerst']?>','<?=$sn['folio']?>')" class="btn btn-primary" data-toggle="modal" data-target="#modalFileCaratula">caratula</button>
            <button style="float: right;" class="btn btn-secondary btn-special" onclick="window.location.href = '.?view=siniestro/editar&timerst=<?=$sn['timerst']?>';" >EDITAR</button> 

            
            <div class="table">
                  <table class="table table-siniestro">
                    <tbody>
                    <tr>
                          <td>
                            <label>Fecha Reporte::</label>
                            <span name="fechaReporte" value="<?=$sn['fechaReporte_F']?>" id="fechaReporte" type="text" class="form-control datetimepicker" placeholder="Fecha Reporte" required><?=$sn['fechaReporte_F']?></span>
                          </td>
                          <td>
                            <label>Fecha Captura:</label>
                            <span name="fechaCaptura" value="<?=$sn['fechaCaptura_F']?>" id="fechaCaptura" type="text" class="form-control " placeholder="Fecha Captura" required><?=$sn['fechaCaptura_F']?></span>
                          </td>
                          <td>
                            <label>Fecha Asignación:</label>
                            <span name="fechaAsignacion" value="<?=$sn['fechaAsignacion_F']?>" id="fechaAsignacion" type="text" class="form-control " placeholder="Fecha Asignación" required><?=$sn['fechaAsignacion_F']?></span>
                          </td>
                      </tr>

                      <!-- <tr>
                          <td>
                            <label>Nombre:</label>
                            <span name="nombre" value="<?=$sn['nombre']?>" type="text" class="form-control" placeholder="Nombre(s)" required><?=$sn['nombre']?></span>
                          </td>
                          <td>
                            <label>Apellido Materno:</label>
                            <span name="apellidoM" value="<?=$sn['apellidoM']?>" type="text" class="form-control" placeholder="Apellido Materno" required><?=$sn['apellidoM']?></span>
                          </td>
                          <td>
                            <label>Apellido Paterno:</label>
                            <span name="apellidoP" value="<?=$sn['apellidoP']?>" type="text" class="form-control" placeholder="Apellido Paterno" required><?=$sn['apellidoP']?></span>
                          </td>
                      </tr> -->
                      <tr>
                          <td colspan="3">
                            <label>Nombre asegurado:</label>
                          </td>
                          <td>
                            <label for="contacto">Forma de Contacto:</label>
                          </td>
                      </tr>
                      <tr>
                        <td ondblclick="cambiaNombre()" colspan="3" class="pt-1 text-capitalize ">
                            <span name="nombre" type="text" class="form-control changueinput" placeholder="Nombre(s)" required=""><?=$sn['nombre'] .' '.$sn['apellidoP'].' '.$sn['apellidoM']?></span>
                        </td>
                        <td>
                          <span name="contacto"><?=$sn['formaContacto']?> </span>
                        </td>
                      </tr>

                      <tr>
                          <td>
                            <label>Cel:</label>
                            <span name="cel" value="" type="text" class="form-control" placeholder="Cel" required> <?=$sn['cel']!=''?$sn['cel']:"s/n";?> </span>
                          </td>
                          <td>
                            <label>Casa:</label>
                            <span name="casa" value="" type="text" class="form-control" placeholder="Casa" required> <?=$sn['casa']!=''?$sn['casa']:"s/n"?> </span>
                          </td>
                          <td>
                            <label>Oficina:</label>
                            <span name="oficina" value="" type="text" class="form-control" placeholder="Oficina" required> <?=$sn['oficina']!=''?$sn['oficina']:"s/n"?> </span>
                          </td>
                          <td>
                            <label>Mail:</label>
                            <span name="mail" value="" type="text" class="form-control" placeholder="Mail" required> <?=$sn['mail']?> </span>
                          </td>
                      </tr>

                      <tr>
                          <td>
                            <label>Estado:</label><br>
                            <?=$sn['estado']?>
                            <!-- <input name="estado" value="<?=$sn['estado']?>" type="text" class="form-control" placeholder="Estado" required> -->
                          </td>
                          <td>
                            <label>Ciudad:</label><br>
                            <?=$sn['ciudad']?>
                            <!-- <input name="ciudad" value="<?=$sn['ciudad']?>" type="text" class="form-control" placeholder="Ciudad" required> -->
                          </td>

                          <td>
                            <label>Status:</label>
                            <input name="Status" value="<?=$sn['status']?>" type="text" class="form-control <?=strtolower($sn['status'])?>" placeholder="Status" required>
                          </td>
                          <td>
                            <label>Calificación:</label>
                            <input name="calificacion" value="<?=$sn['calificacion']?>" type="text" class="form-control <?=strtolower($sn['calificacion'])?>" placeholder="Calificación" required>
                          </td>
                        
                      </tr>

                      <tr>
                      <td>
                            <label>Num Reporte:</label>
                            <span name="numReporte" value="" type="text" class="form-control" placeholder="Nº de Reporte" required> <?=$sn['numReporte']?> </span>
                          </td>
                          <td>
                            <label>Num Siniestro:</label>
                            <span name="numSiniestro" value="" row=2 type="text" class="form-control" placeholder="Nº de Siniestro" required> <?=$sn['numSiniestro']?> </span>
                          </td>
                          

                          <td>
                          <div class="row">
                          <div class="col-6 mx-0 px-0" style="max-width:11em">
                          <label>Fecha Vidgencia 1:</label>
                            <span name="fechaVigencia1" value="" id="fechaVigencia1" type="text" class="form-control mx-0 px-0" placeholder="Fecha Vigencia" required> <?=$sn['vigencia1']?> </span>
                          </div>

                          <div class="col-6 mx-0 px-0" style="max-width:11em">
                            <label>Fecha Vigencia 2:</label>
                            <span name="fechaVigencia2" value="" id="fechaVigencia2" type="text" class="form-control mx-0 px-0" placeholder="Fin Vigencia" required> <?=$sn['vigencia2']?> </span>
                            </div>
                          </div>
                          </td>
                      </tr>
                      

                      <tr>
                          <td colspan="4">

                            
                            <div class="changueinput" style="cursor:pointer" ondblclick="modalCambiaInstitucionSelect()">
                              <label>Institución:</label><br>
                              <?=$sn['institucion']?> <br>
                            </div>

                            <!-- <input name="institucion" value="<?=$sn['institucion']?>" type="text" class="form-control" placeholder="Institución" required> -->
                            <div class="changueinput" style="cursor:pointer" ondblclick="modalCambiaAutoridadSelect()">
                              <label>Autoridad:</label><br>
                              <?=$sn['autoridad']?>
                            </div>

                          </td>
                        
                      </tr>

                    </tbody>
                  </table>
                </div>

          
          </div>
          <!-- <div class="card-bottom">hola</div> -->
        </div>
      </div>

    </div>


    <!-- inicia col-3 -->
    <div class="col-lg-3 col-sm-12 pl-md-0">
      <!-- TABLA ÁREAS -->
      <!-- <div class="col-md-12">
        <div class="card">
          <div class="card-header"><div class="card-titl my-0"><h5>Áreas asignadas</div></div>
            <div class="card-body mt-0 pt-0">
                  <ul class="list-unstyled team-members mb-0">
                      
                              <?php 
                              foreach ($sn['areasAsignadas'] as $k) {
                                print ' <li><div class="row" style="min-height: 45px !important;">
                                <div class="col-md-9 col-9"> '.$k['area'].'
                                <br>
                                <span class="text-muted"><small>'.$k['descripcion'].'</small></span>
                                </div>
                                <div class="col-md-3 col-3 text-right">';
                                if($k['estatus']=='Activa'){ //estatus de la asignacion del area al siniestro
                                  print '<div class="tooltip"><btn onclick="asignacion(\'area\',\'desactivar\',\''.$k['id_asignacion'].'\')" class="btn btn-sm btn-outline-success btn-round btn-icon"> <i class="fa fa-star"></i></btn><span class="tooltiptext">Desactivar</span></div>';
                                }
                                else{
                                  print '<div class="tooltip"><btn onclick="asignacion(\'area\',\'habilitar\',\''.$k['id_asignacion'].'\')" class="btn btn-sm btn-outline-danger btn-round btn-icon"><i class="fa fa-star-o"></i></btn><span class="tooltiptext">Habilitar</span></div>';
                                }
                                print '</div></div></li> <hr style="margin: 3px;">';
                              }
                              
                              ?>
                          
                  </ul>
                  <div class="col-12">
                    <button type="button" class="pl-2 btn btn-primary btn-md" data-toggle="modal" data-target="#modalAsignarArea">
                      Asignar área
                    </button>
                  </div>
            </div>
        </div>
      </div> -->

      <div class="col-md-12">
        <div class="card">
          <div class="card-header"><div class="card-title"><h5>Áreas asignadas</div></div>
            <div class="card-body">
                  <ul class="list-unstyled team-members mb-0">
                      <li>
                          <div class="row">
                              <!-- <div class="col-md-2 col-2">
                                  <div class="avatar">
                                      <img src="../assets/img/faces/ayo-ogunseinde-2.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                  </div>
                              </div> -->
                              <?php 
                              foreach ($sn['areasAsignadas'] as $k) {
                                $activeClass= '';
                                if($k['id']==$areaIDuser){ $activeClass='active'; }

                                $ars= '<div class="col-md-3 col-3 text-right">';
                                if($k['estatus']=='Activa'){ //estatus de la asignacion del area al siniestro
                                  // $ars.= '<div class="tooltip"><btn class="btn btn-sm btn-outline-success '.$activeClass.' btn-round btn-icon"> <i class="fa fa-star"></i></btn><span class="tooltiptext">Activa</span></div> </div>';
                                  $ars.= '<div class="tooltip"><btn class="btn btn-sm btn-outline-success '.$activeClass.' btn-round btn-icon"> <i class="fa fa-star"></i></btn><span class="tooltiptext">Activa</span></div> </div>';
                                }
                                else{
                                  // $ars.= '<div class="tooltip"><btn class="btn btn-sm btn-outline-danger '.$activeClass.' btn-round btn-icon"><i class="fa fa-star-o"></i></btn><span class="tooltiptext">Inactiva</span></div> </div>';
                                  $ars.= '<div class="tooltip"><btn class="btn btn-sm btn-outline-danger '.$activeClass.' btn-round btn-icon"><i class="fa fa-star-o"></i></btn><span class="tooltiptext">Inactiva</span></div> </div>';
                                }
                                $ars.= '
                                <div class="col-md-9 col-9"> '.$k['area'].'
                                <br>
                                </div>
                                ';
                                // <span class="text-muted"><small>'.$k['descripcion'].'</small></span>
                                if ($k['id']==$areaIDuser){ //si el area iterada es el area del abogado, esta se pone diferente clase
                                  print "<div class='areaActiva' style='width:100%;background:#f1efd2;display:flex;align-items:center;'>";
                                  print $ars;
                                  print "</div>";
                                }else{
                                  print "<div class='' style='width:100%;display:flex;align-items:center;'>";
                                  print $ars;
                                  print "</div>";
                                }
                                print "  <br> ";
                              }
                              ?>
                          </div>
                      </li>
                  </ul>
                 
            </div>
          <!-- <div class="card-bottom">hola</div> -->
        </div>
      </div>

      <!-- TABLA ASIGNADOS -->
      <!-- <div class="col-md-12">
        <div class="card">
          <div class="card-header mb-0"><div class="card-title"><h5>Asignados</div></div>
            <div class="card-body mt-0 pt-0">
                  <ul class="list-unstyled team-members mb-0">
                    <?php 
                    foreach ($sn['abogadosAsignados'] as $kabg) {
                        ?>
                          <li>
                            <div class="row pr-2">
                              <div class="col-md-2 col-2">
                                  <div class="avatar">
                                      <img src="./assets/img/faces/ayo-ogunseinde-2.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                  </div>
                              </div>
                              <div class="col-md-8 col-8">
                                  <?='<small>'.$kabg['area'].'</small> <br>'.$kabg['nombre']?>
                                  <br>
                                  <span class="text-muted"><small> <?=$kabg['grupo']?></small></span>
                              </div>

                              <div class="col-md-2 col-2 text-right">
                              <?php
                              if($kabg['estatus']==1){ //estatus de la asignacion del abogado al siniestro
                                  print '<div class="tooltip"><btn onclick="asignacion(\'abogado\',\'desactivar\',\''.$kabg['id_asignacion'].'\')" class="btn btn-sm btn-outline-success btn-round btn-icon"> <i class="fa fa-star"></i></btn><span class="tooltiptext">Desactivar</span></div>';
                              }
                              else{
                                print '<div class="tooltip"><btn onclick="asignacion(\'abogado\',\'habilitar\',\''.$kabg['id_asignacion'].'\')" class="btn btn-sm btn-outline-danger btn-round btn-icon"><i class="fa fa-star-o"></i></btn><span class="tooltiptext">Habilitar</span></div>';
                              }

                              ?>
                              </div>
                            </div>
                            <hr>
                          </li>
                        <?php
                    }
                    
                    ?>
                  </ul>
                  <div class='col-12'>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAsignaAbogado">
                      Asignar abogado
                    </button>
                  </div>
            </div>
        </div>
      </div> -->

      <div class="col-md-12">
        <div class="card">
          <div class="card-header mb-0"><div class="card-title"><h5>Asignados</div></div>
            <div class="card-body mt-0 pt-0">
                  <ul class="list-unstyled team-members mb-0">
                    <?php 
                    foreach ($sn['abogadosAsignados'] as $kabg) {
                      $activeClass= '';
                      $active= '';
                      if($kabg['usuario']== $_SESSION['id']){ $active= ' style="background:#f1efd2;" ';$activeClass='active'; }
                      ?>
                        <li>
                          <div class="row pr-2" <?=$active?> >
                            <div class="col-md-2 col-2">
                                <div class="avatar">
                                    <img src="./assets/img/faces/ayo-ogunseinde-2.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                </div>
                            </div>
                            <div class="col-md-8 col-8">
                                <?='<small>'.$kabg['area'].'</small> <br>'.$kabg['nombre']?>
                                <br>
                                <!-- <span class="text-muted"><small>Área Penal</small></span> -->
                                <span class="text-muted"><small> <?=$kabg['grupo']?></small></span>
                            </div>

                            <div class="col-md-2 col-2 text-right">
                            <?php
                            if($kabg['estatus']==1){ //estatus de la asignacion del abogado al siniestro
                                // print '<div class="tooltip"><btn class="btn btn-sm btn-outline-success '.$activeClass.' btn-round btn-icon"> <i class="fa fa-star"></i></btn><span class="tooltiptext">Activo</span></div>';
                                print '<div class="tooltip"><btn onclick="asignacion(\'abogado\',\'desactivar\',\''.$kabg['id_asignacion'].'\')" class="btn btn-sm btn-outline-success '.$activeClass.' btn-round btn-icon"> <i class="fa fa-star"></i></btn><span class="tooltiptext">Desactivar</span></div>';
                              }
                            else{
                              // print '<div class="tooltip"><btn class="btn btn-sm btn-outline-danger '.$activeClass.' btn-round btn-icon"><i class="fa fa-star-o"></i></btn><span class="tooltiptext">Inactivo</span></div>';
                              print '<div class="tooltip"><btn onclick="asignacion(\'abogado\',\'habilitar\',\''.$kabg['id_asignacion'].'\')" class="btn btn-sm btn-outline-danger '.$activeClass.' btn-round btn-icon"><i class="fa fa-star-o"></i></btn><span class="tooltiptext">Habilitar</span></div>';
                            }


                            ?>
                            </div>
                            <!-- <btn class="btn btn-sm btn-outline-success btn-round btn-icon"><i class="fa fa-envelope"></i></btn> -->
                          </div>
                          <hr>
                        </li>
                      <?php
                    }
                    
                    ?>
                  </ul>
                   <!-- BOTON ASIGNAR USUARIOS -->
                   <div class='col-12'>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAsignaAbogado">
                      Asignar abogado
                    </button>
                  </div>
            </div>
          <!-- <div class="card-bottom">hola</div> -->
        </div>
      </div>

      <!-- TABLA polizas -->
      <div class="col-md-12">
        <div class="card">
          <div class="card-header"><div class="card-title"><h5>Pólizas</div></div>
            <div class="card-body">

                              
                <ul class="list-unstyled team-members mb-0">
                  <?php
                  $pols=Siniestros::getNumPolizaValores($sn['timerst']);
                  Core::sendVarToJs(json_encode($pols),"polizasArr");

                  foreach ($pols as $p) {
                     /* [id] => 6
                        [timerst] => 1655279818.0833
                        [poliza] => 234324BG-srew 55
                        [reserva] => 0
                        [deducible] => 0
                        [coaseguro] => 
                        [sumaAsegurada] => 0 */
                  
                    ?>
                      <li>
                          <div class="row" pol<?=$p['id']?> >
                              <div class="col-md-9 col-9">
                                <span class="text-muted"><small>No°: </small><b poliza><?=$p['poliza']?></b></span>
                                  <br>
                                  <span class="text-muted">Deducible: <small deducible> $ <?=number_format($p['deducible'], 2);?> </small></span> <br>
                                  <span class="text-muted">Reserva: <small reserva> $ <?=number_format($p['reserva'], 2);?> </small></span> <br>
                                  <span class="text-muted">Coaseg.: <small coaseguro> $ <?=number_format($p['coaseguro'], 2);?> </small></span> <br>
                                  <span class="text-muted">Sum Aseg.: <small sumaAsegurada > $ <?=number_format($p['sumaAsegurada'], 2);?> </small></span> <br>
                              </div>
                              <div class="col-md-3 col-3 text-right">
                                  <btn onclick="editPoliza(<?=$p['id']?>)" class="btn btn-sm btn-outline-success btn-round btn-icon"><i class="fa fa-pencil"></i></btn>
                              </div>
                          </div>
                          <hr>
                      </li>
                      <?php
                  }
                  ?>
                </ul>

                <!-- Button trigger modal -->
                <div class="col-12">
                  <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalFileView">Launch demo modal</button> -->
                  <button class="btn btn-primary" id="verPoliza">todas las pólizas</button>
                </div>
                  
            </div>
          <!-- <div class="card-bottom">hola</div> -->
        </div>
      </div>

      

    </div> <!-- termina col-3 -->

   

  </div>

  <!-- tabla histórico Siniestros -->
  <div class="row">
            <div class="col-md-12">
                <div class="card">
                <div class="card-header">
                    <!-- <h4 class="card-title"> Histórico de Siniestros</h4> -->
                    <!-- <span>Actividad relacionada con los siniestros.</span> -->
                </div>
                <div class="card-body">
                <div id="tablaHistoricoSiniestros" class="mt-1"></div>
                </div>
                </div>
            </div>
        </div>

</div>
<!-- TERMINA -->
<!-- TERMINA -->

<script defer>
  var ejemplo=''; 
  var openTxtEditHechos = false;

  //? ----------------------------------- FUNCIONES DE ADMINISTRACIÓN

  function cambiaStatus(){//? esta funcion cambiara el status dependiendo si es area  
      let valorStatus = $('#btnstatus').val();
      let valorArea = localStorage.getItem('paramA');
      let valorPrincipal = localStorage.getItem('paramA');
      data = { 'idArea': valorArea, 'isStatus' : valorStatus, 'timerst': <?=$sn['timerst']?> };
      $.ajax({
            url: "./?action=siniestro/cambiarParametro&modo=status",// manda status nuevo segun el timerst
            method: "POST",
            data: data,
            success: function(respuesta) {
              let r = respuesta.indexOf("Status cambiado");
                if (r) {
                   Swal.fire({
                        icon: 'success',
                        width: 700,
                        title: '¡datos actualizados',
                        // text: 'El cliente puede pasar a caja a pagar con su nombre o puedes seguir editando.',
                        html: "Se realizaron nuevas asignaciones",
                        confirmButtonText: 'OK',
                        allowOutsideClick: false
                    }).then((result) => {
                        location.reload();
                    })
                } else {
                    console.log(respuesta);
                    Swal.fire({
                        icon: 'error',
                        title: 'Ha ocurrido un error',
                        text: 'Por favor intentalo nuevamente',
                        confirmButtonText: 'OK',
                        footer: 'Sentimos las molestias'
                    })
                } 
            }
      })

  }

  function cambiaCalificacion(){//? esta funcion cambiara calificacion dependiendo el area
      let valorCalificacion = $('#btncalificacion').val();
      let valorArea = localStorage.getItem('paramA');
      data = { 'idArea': valorArea, 'isCalificacion' : valorCalificacion, 'timerst': <?=$sn['timerst']?> };
      $.ajax({
            url: "./?action=siniestro/cambiarParametro&modo=calificacion",// manda calificacion nuevo segun el timerst
            method: "POST",
            data: data,
            success: function(respuesta) {
                if (respuesta=='Calificacion cambiada') {
                   Swal.fire({
                        icon: 'success',
                        width: 700,
                        title: '¡datos actualizados',
                        // text: 'El cliente puede pasar a caja a pagar con su nombre o puedes seguir editando.',
                        html: "Se realizaron nuevas asignaciones",
                        confirmButtonText: 'OK',
                        allowOutsideClick: false
                    }).then((result) => {
                        location.reload();
                    })
                } else {
                    console.log(respuesta);
                    Swal.fire({
                        icon: 'error',
                        title: 'Ha ocurrido un error',
                        text: 'Por favor intentalo nuevamente',
                        confirmButtonText: 'OK',
                        footer: 'Sentimos las molestias'
                    })
                } 
            }
      })

  }

  
  function asignAbogado(){//? esta funcion asigna un nuevo abogado al siniestro o ID 
      let A2 = $("#aboAsigndo").val();
      data = { 'idAbogado' : A2, 'timerst': <?=$sn['timerst']?> };
      $.ajax({
            url: "./?action=siniestro/asignar&modo=nuevoAbogadoAsignado",// manda a asignar abogado y area segun el timerst
            method: "POST",
            data: data,
            success: function(respuesta) {
              console.log(respuesta=='asignacionesOK');
                if (respuesta) {
                  console.log(respuesta);

                   Swal.fire({
                        // icon: 'success',
                        width: 700,
                        title: '¡datos actualizados',
                        // text: 'El cliente puede pasar a caja a pagar con su nombre o puedes seguir editando.',
                        html: "Se realizaron nuevas asignaciones",
                        confirmButtonText: 'OK',
                        allowOutsideClick: false
                    }).then((result) => {
                        location.reload();
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ha ocurrido un error',
                        text: 'Por favor intentalo nuevamente',
                        confirmButtonText: 'OK',
                        footer: 'Sentimos las molestias'
                    })
                } 
            }
        })
  }
  
  // VERIFICACIÓN de BITÁCORA
  function disparadorVerificar(timerst,id){
    $.ajax({
        url: "./?action=siniestro/bitacora&metodo=verificar",
        method: "POST",
        data: {timerst,id} ,
        success: function(respuesta) {
            // dataset = JSON.parse(respuesta);
            console.log(respuesta);
            Swal.fire(`
                Bitácora Verificada. 
            `.trim()).then(()=>{
                location.reload();
            })
        },
        error:{ function(e) {
            conjsole.log(e);
        }

        }
    });
  }

  //ASIGNACION DE AREAS O QUITAR ASIGNACIÓN
  function asignacion(entidad,modo,idAsignacion){
    $.ajax({
        url: "./?action=siniestro/asignar&entidad="+entidad,
        method: "POST",
        data: {modo,idAsignacion} ,
        success: function(respuesta) {
            // dataset = JSON.parse(respuesta);
            console.log(respuesta);
            Swal.fire(respuesta.trim()).then(()=>{
                location.reload();
            })
        },
        error:{ function(e) {
            conjsole.log(e);
        }

        }
    });

  }

  //PREPARANDO MODAL DE BITACORA POR AREA
  function prepareModalBitacora(area){
    $("#newBitacoraModalForm #inputArea").html("<input type='hidden' value='"+area+"' name='area' />");
    $("#modalNuevaEntradaBitacoraTitle").html("Nueva Bitácora en <?=$sn['folio']?> ");
    $("textarea#nuevaEntrada").html("");
    $("#fechaActividad").val('');
    $("#newBitacoraModalForm").attr('action','./?action=siniestro/bitacora&metodo=nuevo')
  }
  //PREPARAR MODAL PARA EDITAR UNA BITÁCORA
  let sin= "";
  function disparadorEditarBitacora(area,timerst,idBitacora,area_n){
    sin = SiniestroID[""+area_n]["bitacora"];
    let i = sin.findIndex(i => i.id==idBitacora);
    // SiniestroID.Penal.bitacora.findIndex(i => i.id=="11541"); real 100% efe
    if (i == -1){ i = 0;} // si el id del array es -1, entonces es cero.

    let txt = sin[i]['bitacora'];
    let fechaActividad = sin[i]['fecha_actividad'];
    $("#modalNuevaEntradaBitacoraTitle").html("Editar Bitácora en <?=$sn['folio']?> ");
    $("textarea#nuevaEntrada").html(txt);
    $("#fechaActividad").val(fechaActividad);
    // $("textarea#fechaActividad").html(fechaActividad);
    $("#newBitacoraModalForm #inputArea").html(" ");
    $("#newBitacoraModalForm #inputArea").append("<input type='hidden' value='"+area+"' name='area' />");
    $("#newBitacoraModalForm #inputArea").append("<input type='hidden' value='"+idBitacora+"' name='idBitacora' />");
    $("#newBitacoraModalForm").attr('action','./?action=siniestro/bitacora&metodo=editar');

  }

  //CAMBIAR ESTATUS O CALIFICACION DE AREA  okoy
  function changeParam(areaID,param,tit){
    localStorage.setItem('paramA', areaID);
    localStorage.setItem('paramB', param);
    let title = ' de '+ tit;
    if(param=='status'){
      $('#modalCambiaStatusLabel').html('Cambiar Status'+title);
    }
    else if(param=='calificacion'){
      console.log(title);
      $('#modalCambiacalificacionLabel').html('Cambiar Calificación'+title);
    }
  }
  

</script>
<!-- formatos -->
<?php include "core/app/view/js/siniestro/ver/informePrimerAtencion.php";?>
<?php include "core/app/view/js/siniestro/ver/informePreliminar.php";?>
<?php include "core/app/view/js/siniestro/ver/informeActualizacion.php";?>
<?php include "core/app/view/js/siniestro/ver/informeCancelacion.php";?>

<!-- winload -->
<?php include "core/app/view/js/siniestro/ver/onload.php";?>


<style>
  .table-siniestro tr ,
  .table-siniestro th ,
  .table-siniestro td ,
  .table-siniestro {
      border: none !important;
      border-top: none !important;
  }


  .table-siniestro tr {
      border-bottom: gray solid 1px;
      ;
  }
  .table>thead>tr>th, 
  .table>tbody>tr>th, 
  .table>tfoot>tr>th, 
  .table>thead>tr>td, 
  .table>tbody>tr>td, 
  .table>tfoot>tr>td {
      padding: 1.3em 7px 0 7px;
      vertical-align: bottom;
  }

  input[name=nombre],
  input[name=apellidoP],
  input[name=apellidoM],
  input[name=numSiniestro]{
    font-weight: 800;
    text-transform: capitalize;
  } 

    /* ajustes para SELECT2 */
    .select2-container--open {
    z-index: 99999999999999 !important;
    }
    .swal2-file {
      width: 100% !important;
      margin-bottom: 2em !important;
    }

  .select2-selection.select2-selection--multiple{
    height: max-content !important;
  }

  #anexoTabla tr th,
  .anexoTabla tr th{
    background: #7de8ff !important;
  }
  .anexoTabla td {
    background: white !important;
  }

  .nav-tabs .nav-link.active{
    background-color: #f1efd2a8 !important;
  }

  [name=bitacora]{
    width: 50% !important;
  }
  /* alert para email desde file view modal */
  .labelChbox{
    display: flex;
    align-content: space-around;
    align-items: center;
    justify-content: space-between;
  }

  label{
    pointer-events: none;
  }
  span.form-control{ border:0 !important}
  .changueinput{
    transition: all ease-in-out .3s;
    background:white;
  }
  .changueinput:hover{
    transition: all ease-in-out .3s;
    background:#cbb37c4d;
    cursor:pointer;
  }

  
  .table.documentos,
  .table.documentos th,
  .table.documentos td,
  .table.bitacoras,
  .table.bitacoras th,
  .table.bitacoras td {
    text-align: center;
    vertical-align: middle;
  }
  .table.bitacoras tr,
  .table.bitacoras th,
  .table.bitacoras td {
    padding: 8px 5px;
    padding: 8px 5px !important;
  }
  .table.documentos tr:nth-child(even),
  .table.bitacoras tr:nth-child(even) {
    background-color: #f9f9f9;
  }

  .campoBitacora{
    border:solid 2px #eceded;
    border:solid 2px #eceded !important;
  }


</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/select/1.6.2/css/select.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
<script src="core/app/view/js/jquery.dataTables.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/js/select2.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.2/css/select2.min.css" rel="stylesheet" type="text/css" />
<!-- jtable JS-->
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js" integrity="sha256-hlKLmzaRlE8SCJC1Kw8zoUbU8BxA+8kR3gseuKfMjxA=" crossorigin="anonymous"></script>
  <script src="./assets/js/plugins/jtable/jquery.jtable.min.js"></script>
  <script src="./assets/js/plugins/jtable/localization/jquery.jtable.es.js"></script>

<script type="application/javascript">
	$(document).ready(function () {
		$.noConflict();
		<?=$scripttable?>
	});
</script>
<?php ?>