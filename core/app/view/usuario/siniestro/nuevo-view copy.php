<?php

?>
<div class="content">
    <div class="title">
        <h4>Datos del asegurado:</h4>
    </div>

    <form id="nuevoSiniestro" >
      <div class="row row1">
          <div class="col-sm-3 col-md">
              <div class="form-group">
                  <input name="nombre" type="text" class="form-control" placeholder="Nombre(s)">
              </div>
          </div>
          <div class="col-sm-3 col-md">
              <div class="form-group">
                  <input name="apellidoP" type="text" class="form-control" placeholder="Apellido Paterno">
              </div>
          </div>
          <div class="col-sm-3 col-md">
              <div class="form-group">
                  <input name="apellidoM" type="text" class="form-control" placeholder="Apellido Materno">
              </div>
          </div>
          <div class="col-sm-3 col-md">
              <div class="form-group input-group date" id="datetimepicker">
                  <input name="fechaCaptura" type="text" class="form-control datetimepicker" placeholder="Fecha Captura">
                  <div class="input-group-append">
                      <span class="input-group-text">
                      <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                      </span>
                  </div>
              </div>
          </div>
          
          <!-- <div class="col-sm-3 col-md-2 row mx-2">
              <div class="title col-12">
                <h6>Proviene de</h6>
              </div>
              <div class="form-check-radio col-6">
                <label class="form-check-label pl-3">
                  <input class="form-check-input" type="radio" name="proviene" id="proviene1" value="GMX"> GMX
                  <span class="form-check-sign"></span>
                </label>
              </div>
              <div class="form-check-radio col-6">
                <label class="form-check-label pl-3">
                  <input class="form-check-input" type="radio" name="proviene" id="proviene2" value="Otros" checked=""> Otros
                  <span class="form-check-sign"></span>
                </label>
              </div>
          </div> -->
          <div class="col-sm-3 col-md-2">
              <div class="form-group">
                <select class="js-example-basic-single form-control" name="proveniente" style="width:100%;">  <!-- name="states[]" multiple="multiple" -->
                <option>Selecciona Proveniente</option>
                  <?php
                    $provenientes=Folios::obtenerProvenientes();
                    foreach ($provenientes as $key => $value) {
                      print "<option value='".$value."'>".strtoupper(explode('_',$value)[1])."</option>";
                    }
                  ?>    
                </select>
              </div>
          </div>
      </div>

      <div class="row row2">
          <div class="col-sm-3 col-md">
              <div class="form-group">
                  <input name="institucion" type="text" class="form-control" placeholder="Institución">
              </div>
          </div>
          <div class="col-sm-3 col-md">
              <div class="form-group">
                  <input name="cel" type="text" class="form-control" placeholder="Cel">
              </div>
          </div>
          <div class="col-sm-3 col-md">
              <div class="form-group">
                  <input name="casa" type="text" class="form-control" placeholder="Casa">
              </div>
          </div>
          <div class="col-sm-3 col-md">
              <div class="form-group">
                  <input name="oficina" type="text" class="form-control" placeholder="Oficina">
              </div>
          </div>
          <div class="col-sm-3 col-md">
              <div class="form-group">
                  <input name="cel" type="text" class="form-control" placeholder="Status">
              </div>
          </div>
          <div class="col-sm-3 col-md">
              <div class="form-group input-group date" id="datetimepicker">
                  <input name="fechaReporte" type="text" class="form-control datetimepicker" placeholder="Fecha Reporte">
                  <div class="input-group-append">
                      <span class="input-group-text">
                      <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                      </span>
                  </div>
              </div>
          </div>

      </div>

      <div class="row row3">
          
          <div class="col-sm-3 col-md">
            <select name="status" class="custom-select" id="inputGroupSelect01">
              <option selected>Estado...</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
            </select>
          </div>
          <div class="col-sm-3 col-md">
            <select name="status" class="custom-select" id="inputGroupSelect01">
              <option selected>Ciudad...</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
            </select>
          </div>
          <div class="col-sm-3 col-md">
              <div class="form-group">
                  <input name="mail" type="text" class="form-control" placeholder="Mail">
              </div>
          </div>

          <div class="col-sm-3 col-md-3 row mx-2">
              <div class="title col-12">
                <h6>Forma de Contacto</h6>
              </div>
              <div class="form-check-radio col-4">
                <label class="form-check-label pl-3">
                  <input class="form-check-input" type="radio" name="formaContacto" id="formaContacto1" value="correo"> Correo
                  <span class="form-check-sign"></span>
                </label>
              </div>
              <div class="form-check-radio col-4">
                <label class="form-check-label pl-3">
                  <input class="form-check-input" type="radio" name="formaContacto" id="formaContacto2" value="telefono" checked="">Teléfono
                  <span class="form-check-sign"></span>
                </label>
              </div>
              <div class="form-check-radio col-4">
                <label class="form-check-label pl-3">
                  <input class="form-check-input" type="radio" name="formaContacto" id="formaContacto1" value="directa"> Directa
                  <span class="form-check-sign"></span>
                </label>
              </div>
          </div>

      </div>

      <div class="row row4">
        <div class="col-5">
          <div class="input-group">
            <div class="input-group-prepend">
              <!-- <span class="input-group-text">With textarea</span> -->
            </div>
            <textarea name="editor1"></textarea>
                <script>
                        CKEDITOR.replace( 'editor1' );
                </script>
            <!-- <textarea name="descripcion" placeholder="Descripción" class="form-control" aria-label="Descripción"></textarea> -->
          </div>
        </div>

        <div class="col-7">
          <div class="row">
            <div class="col-sm-3 col-md">
                <div class="form-group">
                    <input name="numReporte" type="text" class="form-control" placeholder="Nº de Reporte">
                </div>
            </div>
            <div class="col-sm-3 col-md">
                <div class="form-group">
                    <input name="numSiniestro" type="text" class="form-control" placeholder="Nº de Siniestro">
                </div>
            </div>
            
            <div class="col-sm-3 col-md">
                <div class="form-group input-group date" id="datetimepicker">
                    <input name="fechaVigencia1" type="text" class="form-control datetimepicker" placeholder="Fecha Vigencia">
                    <div class="input-group-append">
                        <span class="input-group-text">
                        <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-md">
                <div class="form-group input-group date" id="datetimepicker">
                    <input name="fechaVigencia2" type="text" class="form-control datetimepicker" placeholder="Fin Vigencia">
                    <div class="input-group-append">
                        <span class="input-group-text">
                        <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                        </span>
                    </div>
                </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm col-md">
                  <div class="form-group">
                      <input name="numPoliza" type="text" class="form-control" placeholder="Nº de Póliza">
                  </div>
            </div>

            <div class="col-sm col-md">
              <div class="form-group">
                <select class="js-example-basic-single form-control" name="status" style="width:100%;">  <!-- name="states[]" multiple="multiple" -->
                <option>Selecciona status</option>
                  <option value='verificado'>Verificado</option>
                </select>
              </div>
          </div>
          <div class="col-sm col-md">
              <div class="form-group">
                <select class="js-example-basic-single form-control" name="calificacion" style="width:100%;">  <!-- name="states[]" multiple="multiple" -->
                <option>Selecciona Calificacion</option>
                  <option value='verificado'>??</option>
                </select>
              </div>
          </div>



          </div>
          <div class="row">
            <div class="col-12">
              <!-- <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Options</label>
              </div> -->
              <div class="form-group">
                <select class="js-example-basic-single form-control" name="autoridad" style="width:100%;">  <!-- name="states[]" multiple="multiple" -->
                <option>Selecciona Autoridad</option>
                  <option value='verificado'>??</option>
                </select>
              </div>
            </div>

          </div>
        </div>
      </div>

      <div class="row row5">
        <div class="col-12">
          <nav>
            <div class="nav nav-tabs" >
              <li class="">
                <a class="nav-link" id="nav-asignacion-tab" data-toggle="pill" href="#nav-asignacion">
                  Asignación
                </a>
</li>
              <li class=""> 
                <a class="nav-link" id="nav-profile-tab" data-toggle="pill" href="#nav-atencion">
                Primera Atención
                </a>
</li>
              <li class=""> 
                <a class="nav-link" id="nav-preeliminar-tab" data-toggle="pill" href="#nav-preeliminar">
                Reporte Preeliminar
                </a>
</li>
              <li class=""> 
                <a class="nav-link" id="nav-actualizacion-tab" data-toggle="pill" href="#nav-actualizacion">
                Informe Actualización
                </a>
                </li>
              <li class="">
                <a class="nav-link" id="nav-pericial-tab" data-toggle="pill" href="#nav-pericial">
                Informe Médico y  Pericial
                </a>
                </li>
              <li class="">
                <a class="nav-link" id="nav-bitacoras-tab" data-toggle="pill" href="#nav-bitacoras">
                  Bitacoras
                </a>
                </li>
              <li class="">
                <a class="nav-link" id="nav-cancelacion-tab" data-toggle="pill" href="#nav-cancelacion">
                Informe de  Cancelación
                </a>
                </li>
            </div>
          </nav>
          <div class="tab-content">
            <div class="tab-pane fade active" id="nav-asignacion">   pestaña 1</div>
            <div class="tab-pane fade" id="nav-atencion">                 pestaña 2</div>
            <div class="tab-pane fade" id="nav-preeliminar">              pestaña 3</div>
            <div class="tab-pane fade" id="nav-actualizacion">            pestaña 4</div>
            <div class="tab-pane fade" id="nav-pericial">                 pestaña 5</div>
            <div class="tab-pane fade" id="nav-bitacoras">                pestaña 6</div>
            <div class="tab-pane fade" id="nav-cancelacion">              pestaña 7</div>
          </div>
        </div>

      
      </div>

    </form>
</div>


<ul class="nav nav-pills">
    <li class="active"><a data-toggle="pill" href="#home">Home</a></li>
    <li><a data-toggle="pill" href="#menu1">Menu 1</a></li>
    <li><a data-toggle="pill" href="#menu2">Menu 2</a></li>
    <li><a data-toggle="pill" href="#menu3">Menu 3</a></li>
  </ul>
  
  <div class="tab-content">
    <div id="home" class="tab-pane fade in active">
      <h3>HOME</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    </div>
    <div id="menu1" class="tab-pane fade">
      <h3>Menu 1</h3>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    </div>
    <div id="menu2" class="tab-pane fade">
      <h3>Menu 2</h3>
      <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
    </div>
    <div id="menu3" class="tab-pane fade">
      <h3>Menu 3</h3>
      <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
    </div>
  </div>

<script defer>
    /* $(document).ready(function() {
        $('.js-example-basic-single').select2();
    }); */

  window.onload=function (){
    $('.js-example-basic-single').select2();
  }
</script>