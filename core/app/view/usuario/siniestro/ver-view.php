<?php
/*ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);*/

if (!isset($_REQUEST['param']) and isset(  explode('.',$_REQUEST['param'])[1])  ){
  header("Location: ./view=index");//redirecciona al inicio si no trae el parametro
}

$SiniestroData = Siniestros::verSiniestroTimerst($_REQUEST['param']);
$sn = $SiniestroData; //datos del siniestro o ID
$sn['bitacora'] = Siniestros::verBitacora($sn['timerst']);//bitacora
$sn['areasAsignadas'] = Siniestros::getAllAreasOfSiniestro($sn['timerst']);
$sn['informeCancelacion'] = Siniestros::verInformeCancelacion($sn['timerst']);

$dataFilesSelect= Config::datosSelectFilesUoload(); //datos del input de tipo de archivo
 core::sendVarToJs(json_encode($dataFilesSelect),'dataFilesSelect');
?>
<style>
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

 <!-- Modal -->
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
                        <select class="js-select2 form-control" placeholder="Asigna Área" id="area" name="area[]" style="width:100%;" multiple="multiple">
                            <!-- name="states[]"  -->
                            <!-- <option>Asigna Área</option> -->
                            <?php
                            $areas = Folios::obtenerAreas();
                            foreach ($areas as $key) {
                                print "<option value='" . $key->id . "'>" . strtoupper($key->area) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
                        <select class="js-select2 form-control" placeholder="Asigna Abogado" id="Aabogados" name="Aabogados[]" multiple="multiple" style="width:100%;">
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
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- modal modalNuevaEntradaBitacora -->
<div class="modal fade" id="modalNuevaEntradaBitacora" tabindex="-1" role="dialog" aria-labelledby="modalNuevaEntradaBitacoraLabel" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content"> 
    <form action="./?action=siniestro/bitacora&metodo=nuevo" method="post">
      <div class="modal-header">
        <h5 class="modal-title" id="modalNuevaEntradaBitacoraTitle">Nueva Entrada En Bitácora</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modalFileViewBody">
        <label for="horas">Horas en número: </label>
        <input id="horasBitacora" name="horasBitacora" type="number" maxlength="2" value="1" min=0.5 max="24" step=".5" required /> hrs.
       <textarea name="nuevaEntrada" id="nuevaEntrada" rows="10" style="width:100%;border:#66615b solid 1px !important" required></textarea>
       <input name="timerst" id="timerst" class="input form-input" type="hidden" value="<?php echo $sn['timerst'] ?>">
      </div>
      <div class="modal-footer">
        <button type="button" type class="btn btn-sm btn-secondary" data-dismiss="modal">Cerrar</button>
        <input class="btn btn-sm btn-primary" type="submit" value="Guardar Entrada">
      </div>
    </form>
    </div>
  </div>
</div>

<!-- INICIA PÁGINA -->

<div class="content">

  <div class="row">
    <div class="col-lg-9 pr-md-0">
      <!-- PESTAÑAS -->
      <div class="col-md-12">
          <div class="card">
            <!-- <div class="card-header">
              <h5> Fases</h5>
            </div> -->
            <div class="card-body">
              <div class="nav-tabs-navigation">
                <div class="nav-tabs-wrapper">
                  <ul id="tabs" class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#descripcion" role="tab" aria-expanded="false" aria-selected="false">Descripción de los hechos</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#atencion" role="tab" aria-expanded="false" aria-selected="false">Primera Atención</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#preliminar" role="tab" aria-expanded="false" aria-selected="false">Informe Preliminar</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#documentos" role="tab" aria-expanded="false" aria-selected="false">Documentación</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#cancelacion" role="tab" aria-expanded="false" aria-selected="false">Informe de Cancelación</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" data-toggle="tab" href="#bitacora" role="tab" aria-expanded="false" aria-selected="false">Bitácora de actividades</a>
                    </li>
                  </ul>
                </div>
              </div>
              <div id="my-tab-content" class="tab-content text-center">
                <div class="tab-pane text-left mx-5 mt-2" id="descripcion" role="tabpanel" aria-expanded="false">
                  
                    <div id="descripcionDeHechos" style="width:100%;">
                      <?=urldecode($sn['descripcionHechos'])?>
                    </div>
                
                </div>
                <div class="tab-pane text-left mx-5 mt-2" id="atencion" role="tabpanel" aria-expanded="false">
                    <div id="primeraAtencionC" style="width:100%;">
                      <?php if(isset($sn['primera_atencion'])==1){
                          print urldecode($sn['primera_atencion']);
                        }
                        else{
                          print '<center>
                            <button class="btn btn-primary" onclick="primeraAtencion(\''.$sn['timerst'].'\',\''.$sn['folio'].'\',\''.$sn['nombre'].'\',\''.$sn['numReporte'].'\',\''.$sn['fechaReporte'].'\',\''.$sn['vigencia1'].'\',\''.$sn['vigencia2'].'\',\''.$sn['fechaAsignacion'].'\',\''.$sn['fechaCaptura'].'\',\''.$sn['institucion'].'\',\''.$sn['autoridad'].'\',\''.$sn['telefonos'].'\',\''.$sn['email'].'\')" >cargar Primera Atención</button>
                            </center>';
                        };
                      ?>
                    </div>
                </div>
                <div class="tab-pane text-left mx-5 mt-2" id="preliminar" role="tabpanel" aria-expanded="false">
                    <div id="informePreliminar" style="width:100%;">
                        <?php if(isset($sn['informe_preliminar'])==1){
                           
                            print urldecode($sn['informe_preliminar']);
                          }
                          else{
                            print '<center>
                            <button class="btn btn-primary" onclick="informePreliminar(\''.$sn['timerst'].'\',\''.$sn['calificacion'].'\',\''.$sn['folio'].'\',\''.$sn['nombre'].'\',\''.$sn['numReporte'].'\',\''.$sn['fechaReporte'].'\',\''.$sn['vigencia1'].'\',\''.$sn['vigencia2'].'\',\''.$sn['fechaAsignacion'].'\',\''.$sn['fechaCaptura'].'\',\''.$sn['institucion'].'\',\''.$sn['autoridad'].'\',\''.$sn['telefonos'].'\',\''.$sn['email'].'\')" >cargar informe Preliminar</button>
                            </center>';
                          };
                        ?>
                    </div>
                </div>
                <div class="tab-pane text-left mx-5 mt-2" id="cancelacion" role="tabpanel" aria-expanded="false">
                    <div id="informeCancelacion" style="width:100%;">
                        <?php
                        
                        if(isset($sn['informeCancelacion'])==1){
                            print urldecode($sn['informeCancelacion']['informe_cancelacion']);
                          }
                          else{
                            print '<center>
                            <button class="btn btn-primary" onclick="informeCancelacion(\''.$sn['timerst'].'\',\''.$sn['folio'].'\',\''.$sn['nombre'].'\',\''.$sn['numReporte'].'\',\''.$sn['fechaReporte'].'\',\''.$sn['vigencia1'].'\',\''.$sn['vigencia2'].'\',\''.$sn['fechaAsignacion'].'\',\''.$sn['fechaCaptura'].'\',\''.$sn['institucion'].'\',\''.$sn['autoridad'].'\',\''.$sn['telefonos'].'\',\''.$sn['email'].'\')" >cargar informe Cancelación</button>
                            </center>';
                          };
                        ?>
                    </div>
                </div>
               
                          <!-- DOCUMENTOS?? -->
                <div class="tab-pane mx-5 mx-5 mt-2" id="documentos" role="tabpanel" aria-expanded="false">
                    <center>
                    <div class="row">
                    <div class="col-2">
                        <button type="button" onclick="disparadorFile()" class="btn btn-primary">añadir archivo</button>
                      </div>
                      <div class="col-10">
                        <div class="table">
                          <table class="table">
                            <tr>
                              <th>ETAPA</th>
                              <th>CAT1</th>
                              <th>CAT2</th>
                              <th>REV</th>
                              <th>FECHA</th>
                              <th>ver</th>
                            </tr>
                           <!--  <tr>
                             <td>Informe Preliminar</td>
                              <td>Abog. Gen.</td>
                              <td>MOD</td>
                              <td>01</td>
                              <td>2022-02-18</td>
                              <td><button class="btn btn-primary">ver</button></td>
                            </tr> -->
                            <?php /* comienza iteracion para traer todos los archivos que se han cargado al ID 
                            Array [0] => Array
                                      (
                                          [id] => 1
                                          [timerst] => 1647358353.5778
                                          [nombre] => ejemplo de archivo.pdf
                                          [id_config_files] => 136
                                          [url] => 234kjh45345.pdf
                                          [fecha] => 2022-03-15 17:43:54
                                          [version] => 01
                                          [c1] => MEDIDAS CAUTELARES.
                                          [c2] => JUICIO CONTENCIOSO
                                          [c3] => PROCEDIMIENTO ADMINISTRATIVO
                                      )
                            */
                            $files_sn = Siniestros::verArchivosdelSiniestro($sn['timerst']);
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
                                '<td style="text-transform:lowercase;" >'.str_pad($k['version'], 2, '0', STR_PAD_LEFT).'</td>'.
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
                            
                            <!-- BITACORA -->
                <div class="tab-pane mt-2 active" id="bitacora" role="tabpanel" aria-expanded="false">
                    <center>
                    <div class=" row justify-content-md-center">
                      
                      <div class="col-12">
                        <div class="table">
                          <table class="table">
                            <tr>
                            <?php // si es admin muestra el campo  accion
                                $power = UserData::isAdmin();
                                if ($power==1)
                                echo "<th>Acn</th>";
                            ?>
                              <th>Verificado</th>
                              <th>Usuario</th>
                              <th>Actividad</th>
                              <th>Fecha</th>
                              <th>Horas</th>
                            </tr>
                            <?php 
                           
                            if (count($sn['bitacora'])>=1){
                              $col="";
                              foreach ($sn['bitacora'] as $k) {
                                $col.='<tr> ';
                                    include "ver/admin.php";  // coloca boton de accion segun el perfil de usuario
                                $col.=
                                '<td style="text-transform:lowercase;" >'.$k['verificado'].'<br> <small style="font-weight:500;" class="text-primary">'.$k['fecha_verificacion'].'</small></td>'.
                                '<td style="text-transform:lowercase;" >'.$k['usuario'].'</td>'.
                                '<td style="text-transform:lowercase;" >'.urldecode($k['bitacora']).'</td>'.
                                '<td style="text-transform:lowercase;" >'.$k['fecha_creacion'].'</td>'.
                                '<td style="text-transform:lowercase;" >'.$k['horas'].' hrs.</td>';
                               
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

                      <div class="col-3">
                        <button type="button" data-toggle="modal" data-target="#modalNuevaEntradaBitacora" class="btn btn-primary">Nueva Entrada </button>
                      </div>
                     
                      
                    </div>
                    </center>
                </div>
              </div>
            </div>
          </div>
      </div>

       <!-- DATOS DEL SINIESTRO -->
      <div class="col-lg-12">
        <div class="card">
          <!-- <div class="card-header"><div class="card-title"><h5>siniestro</div></div> -->
          <div class="card-body">
                <div class="table">
                  <table class="table table-siniestro">
                    <tbody>
                    <tr>
                          <td>
                            <label>Fecha Reporte::</label>
                            <input name="fechaReporte" value="<?=$sn['fechaReporte']?>" id="fechaReporte" type="text" class="form-control datetimepicker" placeholder="Fecha Reporte" required>
                          </td>
                          <td>
                            <label>Fecha Captura:</label>
                            <input name="fechaCaptura" value="<?=$sn['fechaCaptura']?>" id="fechaCaptura" type="text" class="form-control " placeholder="Fecha Captura" required>
                          </td>
                          <td>
                            <label>Fecha Asignación:</label>
                            <input name="fechaAsignacion" value="<?=$sn['fechaAsignacion']?>" id="fechaAsignacion" type="text" class="form-control " placeholder="Fecha Asignación" required>
                          </td>
                      </tr>

                      <tr>
                          <td>
                            <label>Nombre:</label>
                            <input name="nombre" value="<?=$sn['nombre']?>" type="text" class="form-control" placeholder="Nombre(s)" required>
                          </td>
                          <td>
                            <label>Apellido Materno:</label>
                            <input name="apellidoM" value="<?=$sn['apellidoM']?>" type="text" class="form-control" placeholder="Apellido Materno" required>
                          </td>
                          <td>
                            <label>Apellido Paterno:</label>
                            <input name="apellidoP" value="<?=$sn['apellidoP']?>" type="text" class="form-control" placeholder="Apellido Paterno" required>
                          </td>
                        
                          
                      </tr>
                      <tr>
                          <td>
                            <label>Cel:</label>
                            <input name="cel" value="<?=$sn['cel']?>" type="text" class="form-control" placeholder="Cel" required>
                          </td>
                          <td>
                            <label>Casa:</label>
                            <input name="casa" value="<?=$sn['casa']?>" type="text" class="form-control" placeholder="Casa" required>
                          </td>
                          <td>
                            <label>Oficina:</label>
                            <input name="oficina" value="<?=$sn['oficina']?>" type="text" class="form-control" placeholder="Oficina" required>
                          </td>
                          <td>
                            <label>Mail:</label>
                            <input name="mail" value="<?=$sn['mail']?>" type="text" class="form-control" placeholder="Mail" required>
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
                            <input name="Status" value="<?=$sn['status']?>" type="text" class="form-control" placeholder="Status" required>
                          </td>
                          <td>
                            <label>Calificación:</label>
                            <input name="calificacion" value="<?=$sn['calificacion']?>" type="text" class="form-control" placeholder="Calificación" required>
                          </td>
                        
                      </tr>

                      <tr>
                      <td>
                            <label>Num Reporte:</label>
                            <input name="numReporte" value="<?=$sn['numReporte']?>" type="text" class="form-control" placeholder="Nº de Reporte" required>
                          </td>
                          <td>
                            <label>Num Siniestro:</label>
                            <input name="numSiniestro" value="<?=$sn['numSiniestro']?>" row=2 type="text" class="form-control" placeholder="Nº de Siniestro" required>
                          </td>
                          

                          <td>
                          <div class="row">
                          <div class="col-6 mx-0 px-0" style="max-width:11em">
                          <label>Fecha Vidgencia 1:</label>
                            <input name="fechaVigencia1" value="<?=$sn['vigencia1']?>" id="fechaVigencia1" type="text" class="form-control mx-0 px-0" placeholder="Fecha Vigencia" required>
                          </div>

                          <div class="col-6 mx-0 px-0" style="max-width:11em">
                            <label>Fecha Vigencia 2:</label>
                            <input name="fechaVigencia2" value="<?=$sn['vigencia2']?>" id="fechaVigencia2" type="text" class="form-control mx-0 px-0" placeholder="Fin Vigencia" required>
                            </div>
                          </div>
                          </td>
                      </tr>
                      

                      <tr>
                          <td colspan="4">

                            
                            <label>Institución:</label><br>
                            <?=$sn['institucion']?> <br>
                            <!-- <input name="institucion" value="<?=$sn['institucion']?>" type="text" class="form-control" placeholder="Institución" required> -->
                            <label>Autoridad:</label><br>
                            <?=$sn['autoridad']?>
                            <!-- <input name="autoridad" value="<?=$sn['autoridad']?>" type="text" class="form-control" placeholder="Autoridad" required> -->
                            
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
      <div class="col-md-12">
        <div class="card">
          <div class="card-header"><div class="card-title"><h5>Áreas asignadas</div></div>
            <div class="card-body">
                  <ul class="list-unstyled team-members">
                      <li>
                          <div class="row">
                              <!-- <div class="col-md-2 col-2">
                                  <div class="avatar">
                                      <img src="../assets/img/faces/ayo-ogunseinde-2.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                  </div>
                              </div> -->
                              <?php 
                              foreach ($sn['areasAsignadas'] as $k) {
                                print '
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
                                print '</div>';
                              }
                              
                              ?>
                              <!-- <div class="col-md-9 col-7">
                                  PENAL
                                  <br>
                                  <span class="text-muted"><small>Área Penal</small></span>
                              </div>
                              <div class="col-md-3 col-3 text-right">
                                  <btn class="btn btn-sm btn-outline-danger btn-round btn-icon"><i class="fa fa-star-o"></i></btn>
                              </div> -->
                              <!-- Button trigger modal -->
                              <div class="col-12">
                                <button type="button" class="pl-2 btn btn-primary btn-md" data-toggle="modal" data-target="#modalAsignarArea">
                                  Asignar área
                                </button>
                              </div>
                          </div>
                      </li>
                  </ul>
            </div>
          <!-- <div class="card-bottom">hola</div> -->
        </div>
      </div>

      <!-- TABLA ASIGNADOS -->
      <div class="col-md-12">
        <div class="card">
          <div class="card-header"><div class="card-title"><h5>Asignados</div></div>
            <div class="card-body">
                  <ul class="list-unstyled team-members">
                      <li>
                          <div class="row">
                       

                              <div class="col-md-2 col-2">
                                  <div class="avatar">
                                      <img src="./assets/img/faces/ayo-ogunseinde-2.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                  </div>
                              </div>
                              <div class="col-md-7 col-7">
                                  Erick Malagon - PENAL
                                  <br>
                                  <span class="text-muted"><small>Área Penal</small></span>
                                  <span class="text-muted"><small>Abogado</small></span>
                              </div>
                              <div class="col-md-3 col-3 text-right">
                                  <btn class="btn btn-sm btn-outline-success btn-round btn-icon"><i class="fa fa-envelope"></i></btn>
                              </div>

                              <!-- BOTON ASIGNAR USUARIOS -->
                              <div class='col-12'>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAsignaAbogado">
                                  Asignar abogado
                                </button>
                              </div>
                          </div>
                      </li>
                  </ul>
            </div>
          <!-- <div class="card-bottom">hola</div> -->
        </div>
      </div>

      <!-- TABLA polizas -->
      <div class="col-md-12">
        <div class="card">
          <div class="card-header"><div class="card-title"><h5>Pólizas</div></div>
            <div class="card-body">
                              
                  <ul class="list-unstyled team-members">
                      <li>
                          <div class="row">
                              <!-- <div class="col-md-2 col-2">
                                  <div class="avatar">
                                      <img src="../assets/img/faces/ayo-ogunseinde-2.jpg" alt="Circle Image" class="img-circle img-no-padding img-responsive">
                                  </div>
                              </div> -->
                              <div class="col-md-7 col-7">
                                  XBC123123 - VIGENTE
                                  <br>
                                  <span class="text-muted"><small>NOV-2021</small></span>
                                  <span class="text-muted"><small>NOV-2022</small></span>
                                  <span class="text-muted"><small>Cantidades $$$</small></span>
                              </div>
                              <div class="col-md-3 col-3 text-right">
                                  <btn class="btn btn-sm btn-outline-success btn-round btn-icon"><i class="fa fa-envelope"></i></btn>
                              </div>
                          </div>
                      </li>
                  </ul>

                              <!-- Button trigger modal -->
                              <div class="col-12">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalFileView">
                                  Launch demo modal
                                </button>
                              </div>
                  
            </div>
          <!-- <div class="card-bottom">hola</div> -->
        </div>
      </div>


    </div> <!-- termina col-3 -->

   

  </div>

</div>
<!-- TERMINA -->
<!-- TERMINA -->

<script defer>

function disparadorFile(){
    //swert alert para editar el proveedor o proveniente
   
    let options = '';
    dataFilesSelect.forEach(opt => {
        options = options+'<option value="'+opt.id+'"> ['+opt.c3+'] <b>'+opt.c2+'<b> - '+opt.valor+'</option>';
    });

    let selInput =`<select name="tipo" id="tipo"  class="swal2-input select2 js-select2" placeholder="Selecciona la clasificación del archivo"  style="width:100%;">`+ options +`</select>
    <input name="timerst" type="hidden"value="<?=$sn['timerst']?>" />
    </form>`;

    setTimeout(() => {
      //$("#tipo").select2();
    }, 200);
    
      let html_ = ` <form id="formFile" action="./?action=siniestro/files&modo=upload" enctype="multipart/form-data" method="POST"> <input type="file" accept="pdf/doc/docx/csv/xlsx/xls" aria-label="Selecciona un archivo CSV de siniestros" name="importFile" id="importFile" class="swal2-file" placeholder="Importar Archivo" style="display: flex;">`;
    html_ = html_ + selInput;
    Swal.fire({
      width: 800,
    confirmButtonColor: '#988763',
    denyButtonColor: '#988763',
    cancelButtonColor: '#988763',

    title: 'Seleccionar archivo: ',
    html: html_,
    confirmButtonText: 'Guardar',
    showCancelButton: true,
    cancelButtonText: 'Salir',
    focusConfirm: false,
    didOpen: function () {//?disparador de select2
                        $('#tipo').select2({
                            minimumResultsForSearch: 55,
                            width: '100%',
                            placeholder: "Selecciona la clasificación del archivo",
                            language: "es"
                        });
                        $('#tipo').val(null).trigger("change");

                    },
    preConfirm: () => {
        const importFile = Swal.getPopup().querySelector('#importFile').value
        const tipo = Swal.getPopup().querySelector('#tipo').value
        
        if (!tipo || !importFile ) {
        Swal.showValidationMessage(`No puedes dejar campos en blanco`)
        }
        let x = new FormData();
            x.append('archivo', document.querySelector('#importFile').files[0]);
            x.append('importFile', importFile);
            x.append('tipo', tipo);
            x.append('id', '<?=$sn['timerst']?>');
            ejemplo= x;
        return x;
    }
    }).then((cambios) => {
        console.log (cambios);
        $('#formFile').submit();
        if (cambios.isConfirmed)
          /* $.ajax({
            url: "./?action=siniestro/files&modo=upload",
            method: "POST",
            // cache: false,
            // processData: false,
            // contentType: false,
            enctype: 'multipart/form-data',
            data: {'dato':'hola mundo'},
            success: function(respuesta) {
                // dataset = JSON.parse(respuesta);
                console.log(respuesta);
                //  Swal.fire(`
                //     Cambios realizados Institución
                // `.trim()).then(()=>{
                //     $('#tablaInstituciones').jtable('load');//actualiza la tabla al hacer click en OK
                // }) 
            },
            error:{ function(e) {
                conjsole.log(e);
            }

            }
        });  */
        alert("archivo cargado!!");
  
    });
    
}
var ejemplo=''; 

  window.onload=function (){
    //?****** pone titulo a la pagina
    $('.navbar-brand').html("ID: <b><?=$sn['folio']?></b> -  Num siniestro: <b><?=$sn['numSiniestro']?> <br> <?=$sn['nombre']?> <?=$sn['apellidoP']?> <?=$sn['apellidoM']?>");
    $('.sidebar-wrapper li[siniestros]').addClass('active');//activa el menu de siniestros  <?=$sn['numSiniestro']?>


    $("form#verSiniestro").on('change',function(){
        $(".update").css("display",'block');
    })

    $(".update").css("display",'none');

    $("#verPoliza").on("click",function(){
      var dataPolizas = JSON.stringify($('#numPoliza').val());
      $.ajax({
          url: "./?action=poliza/verId",// se le envia el id de la poliza a buscar ... o de las polizas
          method: "POST",
          data: {'data': dataPolizas},
          // cache: false,
          // contentType: false,
          // processData: false,
          success: function(respuesta) {
            respuesta= JSON.parse(respuesta);
             /*  console.log("///////////////////"); 
              console.log("respuesta"); 
              console.log(respuesta); 
              console.log("respuesta"); 
              console.log("///////////////////");  */

              if (respuesta) {
                  var tablePolizasJs = `
                  <table id="tablePolizas" border=1 class="ml-auto mr-auto">
                      <thead>
                          <tr>
                              <th>ID</th>
                              <th>Poliza</th>
                              <th>Reserva</th>
                              <th>deducible</th>
                              <th>Asegurado</th>
                          </tr>
                      </thead>
                      <tbody>`;
                      let nw= '';
                      respuesta.forEach(poliz => {
                        tablePolizasJs=tablePolizasJs+`
                        <tr>
                              <td>`+poliz['id']+`</td>
                              <td>`+poliz['poliza']+`</td>
                              <td>`+poliz['reserva']+`</td>
                              <td>`+poliz['deducible']+`</td>
                              <td>`+poliz['sumaAsegurada']+`</td>
                        </tr>`;
                      });

                      tablePolizasJs=tablePolizasJs+`
                      </tbody>
                    </table>`;
                  Swal.fire({
                      // icon: 'success',
                      width: 700,
                      title: '¡Datos de la(s) pólizas!',
                      // text: 'El cliente puede pasar a caja a pagar con su nombre o puedes seguir editando.',
                      html: tablePolizasJs,
                      confirmButtonText: 'OK',
                      allowOutsideClick: false
                  }).then((result) => {
                      if (result.isConfirmed) {
                          // respuesta= JSON.parse(respuesta);
                          // console.log(respuesta);
                          $("#folio").text("Folio: "+respuesta.folio);
                      }
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
    });

    /* $('.js-select2').select2({
      placeholder: this.placeholder
    }); */
    $('#numPoliza').select2({ 
      tags : true , 
      tokenSeparators : [ ',' ] ,
      placeholder: "No. de Poliza"
    });

     /* $(document).ready(function() {
        $('.js-select2').select2();
    }); remplazado con foreach*/

    $.each(document.querySelectorAll('.js-select2'),function(i,key){
            $(key).select2({
            placeholder: " "+  $(key).attr('placeholder')
          });
    });


    $(function () {
      // Configurar datetimepicker
      var dataInfo={
        format: 'YYYY-MM-DD HH:mm:ss',
        locale: moment.locale('es-mx'),
        allowInputToggle: true,
      }
      
      $('#fechaCaptura').datetimepicker(dataInfo);
      $('#fechaReporte').datetimepicker(dataInfo);
      $('#fechaVigencia1').datetimepicker(dataInfo);
      $('#fechaVigencia2').datetimepicker(dataInfo);

    });

    //selec2 area si cambia su valor, actualiza select2 de abogados
    $("#area").on("change",function(){
      console.log("el valor cambio");
      let temp = $("#area").val();
      if(temp.length == 0 ){
        //? si el valor de area esta vacio, puede ver todos los abogados
        $("#abogados").html( " "); //limpia el select de abogados
        /* $.each(abogadosTodos,function(i,k){
          $("<option value='"+$abogadosTodos[i].id+"'>"+$abogadosTodos[i].nombre+"</option>").appendTo($("#abogados"));
        }); */
        
        abogadosTodos.forEach(abogado => {
          $("<option value='"+abogado.id+"'>"+abogado.nombre+": "+abogado.area+"</option>").appendTo($("#abogados"));
        });
        $('#abogados').select2({
          placeholder: $('#abogados').attr('placeholder')
        });

        console.log("se actualiza todo");

      }else{
        //? se ha seleccionado un area
        var dataAreas = JSON.stringify($("#area").val());
        var data=  {'areasId': dataAreas};
        $.ajax({
            url: "./?action=abogados/porArea",// se le envia el id de la poliza a buscar ... o de las polizas
            method: "POST",
            data: data,
            success: function(respuesta) {
              respuesta= JSON.parse(respuesta);
              console.log(respuesta);
                if (respuesta) {
                    $("#abogados").html( " "); //limpia el select de abogados
                    
                    respuesta.forEach(abogado => {
                      $("<option value='"+abogado.id+"'>"+abogado.nombre+" <i>: "+abogado.area+"</i> </option>").appendTo($("#abogados"));
                    });
                    $('#abogados').select2({
                      placeholder: $('#abogados').attr('placeholder')
                    });

                   /*  Swal.fire({
                        // icon: 'success',
                        width: 700,
                        title: '¡datos actualizados',
                        // text: 'El cliente puede pasar a caja a pagar con su nombre o puedes seguir editando.',
                        html: "se actualizaron los abogados",
                        confirmButtonText: 'OK',
                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // respuesta= JSON.parse(respuesta);
                            // console.log(respuesta);
                            $("#folio").text("Folio: "+respuesta.folio);
                        }
                    }) */
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
    })

    //? accion del formulario para crear el nuevo siniestro
    $("#btnFormNuevoSiniestro").on("click",function(){
      //comprobar dattos, enviar peticion ajax, recibir respuesta , mandar alert sweert
      if(document.querySelector("#nuevoSiniestro").reportValidity()){
        var descripcionHechos = CKEDITOR.instances['descripcionHechos'].getData();
        var formSerialize = $("#nuevoSiniestro").serialize();
        // formSerialize['descripcionHechos']= descripcionHechos;
        $.ajax({
            url: '?'+document.querySelector("#nuevoSiniestro").action.split('?')[1],// se envia todo el formulario a la action
            method: "POST",
            type:"POST",
            data: {'data': formSerialize,'textArea':descripcionHechos},
            //todo !!! se envia serializado
            success: function(respuesta) {
              // console.log("res");
              //console.log(respuesta);
              // console.log("res");
              respuesta= respuesta.trim();
              respuesta= JSON.parse(respuesta);
              // console.log();
                if (respuesta.siniestro) {
                    var tablePolizasJs = '';
                    Swal.fire({
                        icon: 'success',
                        width: 700,
                        title: 'Creado correctamente',
                        //text: 'Siniestro '+$('#numSiniestro')+'. OK \n \r ¿Quieres ir a todos los siniestros o crear nuevo siniestro?',
                        html: 'Siniestro <a href="./?view=siniestro/ver&siniestro='+respuesta.siniestro+'" > <u>'+respuesta.siniestro+'</u></a>. creado.  <br> ¿Quieres ir a todos los siniestros o crear nuevo siniestro?',
                        showDenyButton: true,
                        showCancelButton: true,

                        confirmButtonText: 'Ir a siniestro',
                        denyButtonText: `Ir a todos`,
                        cancelButtonText: 'Crear Nuevo',

                        confirmButtonColor: '#988763',
                        denyButtonColor: '#988763',
                        cancelButtonColor: '#988763',

                        allowOutsideClick: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            console.log('isConfirmed'); //ver siniestro
                            window.location = "./?view=siniestro/ver&siniestro="+respuesta.siniestro;
                        }
                        else if(result.isDenied){
                            console.log('isDeny'); //ver todos los siniestros
                            window.location = "./?view=siniestro/verTodos";
                        }
                        else {
                            console.log('isCancel');// crear uno nuevo
                            window.location = "./?view=siniestro/nuevo";
                        }
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Ha ocurrido un error',
                        text: 'Por favor intentalo nuevamente',
                        confirmButtonText: 'OK',
                        footer: 'Sentimos las molestias',
                        confirmButtonColor: '#988763',
                    })
                } 
            }
        })
        
      }
    });  
  }


  //?accion del boton para ver archivos del siniestro de formato establecido //la segunda esta en ver todos
  function vierFileF(timerst,url,title){
    $('#modalFileViewLabel').html(title);
    $("#modalFileViewBody").html('<iframe src="./?action=pdf/viewFileF&timerst='+timerst+'&doc='+url+'" frameborder="0" style="width:100%;height:66vh;"></iframe>');

  }

  //?accion del boton para ver archivos del siniestro cargados PDF los ve, otro formato lo descar
  function vierFileD(timerst,url,title){
    $('#modalFileViewLabel').html(title);
    $("#modalFileViewBody").html('<iframe src="./?action=pdf/viewFileD&timerst='+timerst+'&doc='+url+'" frameborder="0" style="width:100%;height:66vh;"></iframe>');

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
            });
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
            ASUNTO: Se Informa Primera Atenci&oacute;n.<br />
            REPORTE: `+numReporte+`</strong><br />
            Creado el:`+fechaCaptura+`<br />
            I.D.: `+folio+` <br />
            Asegurado: `+nombre+`</p>

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
            confirmButtonColor: '#988763',
            denyButtonColor: '#988763',
            cancelButtonColor: '#988763',
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
            if (cambios.isConfirmed){
                $.ajax({
                    url: "./?action=siniestro/primeraAtencion&guardar=primeraAtencion",
                    method: "POST",
                    data: {'data':cambios.value} ,
                    success: function(respuesta) {
                        // dataset = JSON.parse(respuesta);
                        console.log(respuesta);
                        Swal.fire(`
                            Se guardó la Primer Atención 
                        `.trim()).then(()=>{
                            location.reload();
                        })
                    },
                    error:{ function(e) { conjsole.log(e); }  }
                });
            }
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
        });
    }, 200);

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
            <p>&nbsp;</p>

              <p>&nbsp;</p>

              <p>&nbsp;</p>

              <p>&nbsp;</p>

              <p>&nbsp;</p>

              <table border="1" cellpadding="0" cellspacing="0" style="width:100%">
                <tbody>
                  <tr>
                    <td>NUMERO DE POLIZA</td>
                    <td>NOMBRE DEL CONTRATANTE/ASEGURADO</td>
                    <td>FECHA OCURRIDO</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td colspan="3" style="text-align:center">NOMBRE DEL RECLAMANTE Y/O TERCERO</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>CAUSA PROBABLE</td>
                    <td>LUGAR OCURRIDO</td>
                    <td>ESTADO/CIUDAD/POBLACI&Oacute;N</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>AGENTE</td>
                    <td colspan="2" style="text-align:center">2</td>
                  </tr>
                  <tr>
                    <td>PRACTICA</td>
                    <td colspan="2" style="text-align:center">2</td>
                  </tr>
                  <tr>
                    <td>VIGENCIA</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>TABLA</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                </tbody>
              </table>

              <p>&nbsp;</p>

            </textarea>
        </div>`;


    let html_ = `<label>ID : </label> <b> `+folio+`</b>`;
    html_ = html_ + selInput;
    Swal.fire({
        width:'50%',
        confirmButtonColor: '#988763',
        denyButtonColor: '#988763',
        cancelButtonColor: '#988763',

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
        if (cambios.isConfirmed){
            $.ajax({
                url: "./?action=siniestro/informePreliminar&guardar=InformePreliminar",
                method: "POST",
                data: {'data':cambios.value} ,
                success: function(respuesta) {
                    // dataset = JSON.parse(respuesta);
                    console.log(respuesta);
                    Swal.fire(`
                        Se guardó el Informe Preliminar
                    `.trim()).then(()=>{
                        location.reload();
                    })
                },
                error:{ function(e) {  conjsole.log(e);  }  }
            });
        }
    });
  }

  //INFORME CANCELACION
  function informeCancelacion(timerst,folio,nombre,numReporte,fechaReporte,vigencia1,vigencia2,fechaAsignacion,fechaCaptura,institucion,autoridad,telefonos,email){

    // elimina la hora de la fecha en los siguientes: 
    fechaAsignacion =   fechaAsignacion.split(" ")[0]
    fechaCaptura =      fechaCaptura.split(" ")[0]
    fechaReporte =      fechaReporte.split(" ")[0]
    //retarda el CKEDITOR 200 ms
    console.log(timerst);
    setTimeout(() => {
        CKEDITOR.replace( 'inputInformeCancelacion',{
            width:'100%',
            uiColor: '#ede6c6',
            editorplaceholder: 'Informe de Cancelación', 
        });
    }, 300);

        //swert alert para editar el proveedor o proveniente
        //FORMATO DE PRIMERA ATENCION
        let selInput =` <div class="input-group">
        <div class="input-group-prepend">
          <!-- <span class="input-group-text">With textarea </span> -->
        </div>
        <textarea placeholder="" id="inputInformeCancelacion" name="inputInformeCancelacion">
        
        <p>Fecha de Asignación: `+fechaAsignacion+`<br />
        <strong>Lic. Luis Alberto Mart&iacute;nez Garc&iacute;a   
 &nbsp; &nbsp; &nbsp; &nbsp;/ &nbsp;&nbsp;&nbsp;&nbsp;     Lic. Mario Aguilar Guajardo.<br />
        ASUNTO:Informe de Cancelacion<br />
        REPORTE: `+numReporte+`</strong><br />
        Creado el:`+fechaCaptura+`<br />
        I.D.: `+folio+` <br />
        Asegurado: `+nombre+`</p>

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
        confirmButtonColor: '#988763',
        denyButtonColor: '#988763',
        cancelButtonColor: '#988763',
        title: 'Informe Cancelación: ',
        html: html_,
        confirmButtonText: 'Guardar',
        showCancelButton: true,
        cancelButtonText: 'Salir',
        focusConfirm: false,
        preConfirm: () => {
            let informeCancelacion = CKEDITOR.instances['inputInformeCancelacion'].getData();
            if (!informeCancelacion)
            Swal.showValidationMessage(`No puedes dejar campos en blanco`);

            return { informeCancelacion, timerst,folio}
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

  // verificacion de BITACORA
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

  //ASIGNACION DE AREAS O QUITAR ASIGNACION
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
</script>


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

</style>

<?php ?>