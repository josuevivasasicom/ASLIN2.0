<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(0);
//! $('input#formaContacto1:checked').val();
//!falta obtenerlo y generar un string con el value, hay que agregar value a cada radio button. va en mysql en formaContacto

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



<div class="content">

    <div class="">
        <form id="nuevoSiniestro" name="nuevoSiniestro" action="./?action=siniestro/nuevo">
            <div class="row justify-content-between">
                
                <div class="col-5 d-flex">
                    <div class="col-8 pl-0">
                        <div class="nada">
                            <div class="form-group input-group date">
                                <select class="js-select2 form-control" placeholder="Selecciona Proveniente" id="proveniente" name="proveniente" style="width:100%;" required>
                                    <!-- name="states[]" multiple="multiple" -->
                                    <option> </option>
                                    <?php
                                    $provenientes = Folios::obtenerProvenientes();
                                    foreach ($provenientes as $key => $value) {
                                        print "<option numero=" . $value['id'] . " value='prov_" . $value['proveniente'] . "'>" . strtoupper($value['proveniente']) . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group input-group date">
                                <input name="fechaAsignacion" value="<?= core::getTimeNow() ?>" id="fechaAsignacion" type="text" class="form-control " placeholder="Fecha Asignación" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="row"> <label for="proveniente">Proveniente</label></div>
                        <div class="row"> <label for="fechaAsignacion">Fecha Asignación</label></div>
                    </div>
                </div>
                <div class="col-5 text-right">
                    <h4><span style="font-weight: 100;" id="f_ini"></span> / Datos del asegurado: </h4>
                </div>
            </div>
    </div>



    <div class="row row1">
        <div class="col-sm-3 col-md">
            <div class="form-group">
                <label for="floatingInput">Nombre(s)</label>
                <input letter="capitalize" name="nombre" value="" type="text" class="form-control" placeholder="" required>
            </div>
        </div>
        <div class="col-sm-3 col-md">
            <div class="form-group">
                <label for="floatingInput">Apellido Paterno</label>
                <input letter="capitalize" name="apellidoP" value="" type="text" class="form-control" placeholder="" required>
            </div>
        </div>
        <div class="col-sm-3 col-md">
            <div class="form-group">
                <label for="floatingInput">Apellido Materno</label>
                <input letter="capitalize" name="apellidoM" value="" type="text" class="form-control" placeholder="" required>
            </div>
        </div>

    </div>

    <div class="row row2">
        <div class="col-sm-3 col-md-3">
            <div class="form-group">
                <label for="floatingInput">Institución</label>
                <select class="js-select2-tags form-control" placeholder="Selecciona Institución" tag="true" name="institucion" id="institucion" style="width:100%;" required>
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
        <div class="col-sm-3 col-md">
            <div class="form-group">
                <label for="floatingInput">Número de Cel</label>
                <input name="cel" value="" type="text" class="form-control" placeholder="">
            </div>
        </div>
        <div class="col-sm-3 col-md">
            <div class="form-group">
                <label for="floatingInput">Número de Casa</label>
                <input name="casa" value="" type="text" class="form-control" placeholder="">
            </div>
        </div>
        <div class="col-sm-3 col-md">
            <div class="form-group">
                <label for="floatingInput">Número de Oficina</label>
                <input name="oficina" value="" type="text" class="form-control" placeholder="">
            </div>
        </div>

        <div class="col-sm-3 col-md">
            <label for="floatingInput">Fecha de Reporte</label>
            <div class="form-group input-group date" id="datetimepicker">
                <input name="fechaReporte" value="<?=core::getTimeNow()?>" id="fechaReporte" type="text" class="form-control datetimepicker" placeholder="Fecha Reporte" required>
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
            <label for="floatingInput">Estado</label>
            <select id="estado" value="" class="js-select2 form-control custom-select" placeholder="Selecciona Estado" name="estado" style="width:100%;" required>
                <!-- name="states[]" multiple="multiple" -->
                <option></option>
                <!-- <option value="">Seleccione uno...</option> -->
                <?php
                Estados::estadosFn(0);
                ?>
            </select>
        </div>

        <div class="col-sm-3 col-md">
            <label for="floatingInput">Ciudad</label>
            <select name="ciudad" class="js-select2 form-control custom-select" id="ciudad" placeholder="Selecciona Ciudad" required>
                <option> </option>
                <option>necesitas seleccionar estado</option>
            </select>
        </div>
        <div class="col-sm-3 col-md">
            <div class="form-group">
                <label for="floatingInput">E-mail</label>
                <input name="mail" value="" type="email" class="form-control" placeholder="" required>
            </div>
        </div>

        <div class="col-sm-3 col-md-3 row mx-2">
            <div class="title col-12">
                <h6>Forma de Contacto</h6>
            </div>
            <div class="form-check-radio col-4">
                <label class="form-check-label pl-3">
                    <input required class="form-check-input" type="radio" name="formaContacto" value="correo"> Correo
                    <span class="form-check-sign"></span>
                </label>
            </div>
            <div class="form-check-radio col-4">
                <label class="form-check-label pl-3">
                    <input required class="form-check-input" type="radio" name="formaContacto" value="telefono" checked="">Teléfono
                    <span class="form-check-sign"></span>
                </label>
            </div>
            <div class="form-check-radio col-4">
                <label class="form-check-label pl-3">
                    <input required class="form-check-input" type="radio" name="formaContacto" value="directa"> Directa
                    <span class="form-check-sign"></span>
                </label>
            </div>
        </div>

    </div>

    <div class="row row4">
        <div class="col-5">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text">Descripción de los Hechos</span>
                </div>
                <textarea placeholder="" id="descripcionHechos" name="descripcionHechos">
                    <p><strong><?= core::getTimeNow() ?></strong></p>

                    <p><strong>Descripci&oacute;n de los hechos:&nbsp;</strong><br />
                    <big>Lic. Luis Alberto Mart&iacute;nez Garc&iacute;a &nbsp; &nbsp; &nbsp; &nbsp;/ &nbsp;&nbsp;&nbsp;&nbsp;     Lic. Mario Aguilar Guajardo.</big></p>

                    <p>...</p>

                    <p>Agradeciendo su atenci&oacute;n, me reitero a sus &oacute;rdenes para cualquier duda o aclaraci&oacute;n.<br />
                    <br />
                    <p><strong>A T E N T A ME N T E:<br />
                    <?php echo $_SESSION['nombre'].' '.$_SESSION['paterno'].' '.$_SESSION['materno'] ?>.</strong></p>
                    </p>
                </textarea>
                <script>
                    /* CKEDITOR.stylesSet.add( 'descripcionHechos', [
                      // Block-level styles.
                      { name: 'Blue Title', element: 'h2', styles: { color: 'Blue' } },
                      { name: 'Red Title',  element: 'h3', styles: { color: 'Red' } },

                      // Inline styles.
                      { name: 'CSS Style', element: 'span', attributes: { 'class': 'my_style' } },
                      { name: 'Marker2: werewr', element: 'span', styles: { 'background-color': 'green' } }
                  ]); */

                    CKEDITOR.replace('descripcionHechos', {
                        uiColor: '#ede6c6',
                        editorplaceholder: 'Descripcion de hechos',
                        placeholder: 'Descripcion de hechos',
                        width: '100%',
                        height: 450,
                     /* plugins: [ 'Bold', 'Italic', 'Underline', 'Strikethrough', 'Code', 'Subscript', 'Superscript' ],
                        toolbar: {
                            items: [ 'bold', 'italic', 'underline', 'strikethrough', 'code','subscript', 'superscript'  ]
                        }

                      "toolbarGroups": [
                             {
                                 "name": "basicstyles"
                             }, 
                             {
                                 "name": "styles"
                             }, 
                             {
                                 "name": "colors"
                             }, 
                             {
                                 "name": "clipboard"
                             }, "/", {
                                 "name": "links"
                             }, 
                             {
                                 "name": "insert"
                             }, 
                             {
                                 "name": "paragraph",
                                 "groups": ["list", "indent"]
                             }, 
                             {
                                 "name": "align"
                             }, 
                             {
                                 "name": "undo"
                             }, 
                             {
                                 "name": "cleanup"
                             }, 
                             {
                                 "name": "mode"
                             }, 
                             {
                                 "name": "tools"
                         }
                    ], */

                        removeButtons: "Source,Creatediv,Subscript,Superscript,Anchor,PasteFromWord,PasteText,Paste,Cut,Save,NewPage,DocProps,Document,Templates,Print,ExportPdf,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CreateDiv,Language,Link,Unlink,Iframe,About",
                        // Bidirtl,,bidiltr,

                    });
                </script>
                <!-- <textarea name="descripcion" placeholder="Descripción" class="form-control" aria-label="Descripción"></textarea> -->
            </div>
        </div>

        <div class="col-7">
            <div class="row">
                <div class="col-sm-3 col-md">
                    <div class="form-group">
                        <label for="floatingInput">Nº de Reporte</label>
                        <input name="numReporte" value="" type="text" class="form-control" placeholder="" required>
                    </div>
                </div>
                <div class="col-sm-3 col-md">
                    <div class="form-group">
                        <label for="floatingInput">Nº de Siniestro</label>
                        <input name="numSiniestro" value="" type="text" class="form-control" placeholder="" required>
                    </div>
                </div>

                <div class="col-sm-3 col-md">
                    <label for="floatingInput">Fecha Inicio Vigencia</label>
                    <div class="form-group input-group date" id="">
                        <input name="fechaVigencia1" value="" id="fechaVigencia1" type="text" class="form-control " placeholder="" required>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 col-md">
                    <label for="floatingInput">Fecha Fin Vigencia</label>
                    <div class="form-group input-group date" id="">
                        <input name="fechaVigencia2" value="" id="fechaVigencia2" type="text" class="form-control " placeholder="" required>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm col-md-5">
                    <div class="form-group">
                        <label for="floatingInput">Nº de Póliza</label>
                        <select class="js-select2-tags form-control" placeholder="Póliza" id='numPoliza' name="numPoliza[]" tag="true" multiple="multiple" style="width:100%;">
                            <?php
                            $polizas = Folios::obtenerPolizas();
                            foreach ($polizas as $key => $value) {
                                print "<option value='" . $value->id . "'>" . ucwords($value->poliza) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!--  <div class="col-sm col-md-1">
                  <div class="form-group">
                    <button type="button" id="verPoliza" class="btn btn-primary btn-round"> <i class="nc-icon nc-glasses-2" alt=""></i></button>
                  </div>
            </div> -->

                <div class="col-sm col-md">
                    <div class="form-group statusGroup">
                        <label for="floatingInput">Selecciona status</label>
                        <select class="js-select2 form-control" placeholder="Selecciona" name="status" style="width:100%;" required>
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
                <div class="col-sm col-md">
                    <div class="form-group calificacionGroup">
                    <label for="floatingInput">Selecciona calificación</label>
                        <select class="js-select2 form-control" placeholder="Selecciona Calificación" name="calificacion" style="width:100%;" required>
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



            </div>
            <div class="row">
                <div class="col-12">
                        <!-- <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01">Options</label>
                    </div> -->
                    <label for="floatingInput">Selecciona Autoridad</label>
                    <div class="form-group">
                        <select class="js-select2-tag form-control" tag=true placeholder="Selecciona Autoridad" name="autoridad" style="width:100%;" required>
                            <!-- name="states[]" multiple="multiple" -->
                            <!-- <option>Selecciona Autoridad</option> -->
                            <option> </option>
                            <?php
                            $autoridades = Folios::obtenerConfigCampo('autoridad');
                            foreach ($autoridades as $key) {
                                print "<option value='" . $key->id . "'>" . ($key->valor) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

            </div>


            <!-- AREA DE  ASIGNACIONES -->
            <!-- AREA DE  ASIGNACIONES -->
            <div class="row">
                <div class="col-12">
                    <label for="floatingInput">Asigna un área</label>
                    <div class="form-group">
                        <select class="js-select2 form-control" placeholder="Selecciona Área" id="area" name="area[]" style="width:100%;" multiple="multiple" pre>
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

                <div class="col-12">
                    <label for="floatingInput">Asigna un abogado</label>
                    <div class="form-group">
                        <select class="js-select2 form-control" placeholder="Selecciona Abogado" id="abogados" name="abogados[]" multiple="multiple" style="width:100%;">
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

                <!--  nuevos parametros agregados
                TIPO DE INTERVENCIÓN
                TERCERO
                NICHO -->

                <hr style="width: 100%;">

                <div class="col-6">
                    <div class="form-group">
                        <label for="floatingInput">Tipo de Intervención</label>
                        <input name="tipoIntervencion" value="" type="text" class="form-control" placeholder="" opcional XD>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="floatingInput">Tercero</label>
                        <input name="tercero" value="" type="text" class="form-control" placeholder="" opcional XD>
                    </div>
                </div>

                <div class="col-6">
                    <div class="form-group">
                        <label for="floatingInput">Nicho</label>
                        <input name="nicho" value="" type="text" class="form-control" placeholder="" opcional XD>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="floatingInput">Materia</label>
                        <input name="materia" value="" type="text" class="form-control" placeholder="" opcional XD>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="floatingInput">Expediente</label>
                        <input name="expediente" value="" type="text" class="form-control" placeholder="" opcional XD>
                    </div>
                </div>

                <div class="col-6">
                    <div class="update ml-auto mt-3">
                        <button type="button" id="btnFormNuevoSiniestro" style="width:100%" class="btn btn-primary btn-round">Crear Siniestro</button>
                    </div>
                </div>

            </div>

        </div>
    </div>

    </form>
</div>

<!-- 
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
  </div> -->

<script defer>

    window.onload = function() {
        //muestra tabla de las polizas en el input
        $("#verPoliza").on("click", function() {
            var dataPolizas = JSON.stringify($('#numPoliza').val());
            $.ajax({
                url: "./?action=poliza/verId", // se le envia el id de la poliza a buscar ... o de las polizas
                method: "POST",
                data: {
                    'data': dataPolizas
                },
                // cache: false,
                // contentType: false,
                // processData: false,
                success: function(respuesta) {
                    respuesta = JSON.parse(respuesta);
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
                        let nw = '';
                        respuesta.forEach(poliz => {
                            tablePolizasJs = tablePolizasJs + `
                        <tr>
                              <td>` + poliz['id'] + `</td>
                              <td>` + poliz['poliza'] + `</td>
                              <td>` + poliz['reserva'] + `</td>
                              <td>` + poliz['deducible'] + `</td>
                              <td>` + poliz['sumaAsegurada'] + `</td>
                        </tr>`;
                        });

                        tablePolizasJs = tablePolizasJs + `
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
                                $("#folio").text("Folio: " + respuesta.folio);
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
        $('select[tag=true]').select2({
            tags: true,
            tokenSeparators: [','],
            placeholder: this.placeholder
            // placeholder: "No. de Poliza"
        });

        /* $(document).ready(function() {
            $('.js-select2').select2();
        }); remplazado con foreach*/

        $.each(document.querySelectorAll('.js-select2'), function(i, key) {
            $(key).select2({
                placeholder: " " + $(key).attr('placeholder')
            });
        });


        $(function() {
            // Configurar datetimepicker de las fechas
            var dataInfo = {
                format: 'YYYY-MM-DD HH:mm:ss',
                locale: moment.locale('es-mx'),
                allowInputToggle: true,
            }

            $('#fechaAsignacion').datetimepicker(dataInfo);
            $('#fechaCaptura').datetimepicker(dataInfo);
            $('#fechaReporte').datetimepicker(dataInfo);
            $('#fechaVigencia1').datetimepicker(dataInfo);
            $('#fechaVigencia2').datetimepicker(dataInfo);


        });
        console.log('cargando funciones');

        //cambia el color del select2 de status
        $("[name=status]").on("change", function() {
            console.log('cambiando');
            let temp = $("[name=status]").val();
            let bg = $("select option[data-value="+temp+"]").attr('data-background');
            document.querySelector('.statusGroup span span span').style.backgroundColor = bg; //'#000000'
        })


        //cambia el color del select2 de calificacion
        $("[name=calificacion]").on("change", function() {
            let temp = $("[name=calificacion]").val();
            let bg = $("select option[data-value="+temp+"]").attr('data-background');
            document.querySelector('.calificacionGroup span span span').style.backgroundColor = bg; //'#000000'
        })

         //escribe el folio del proveniente en un label
        $("[name=proveniente]").on("change", (element) => {
            cosa = element.target.selectedOptions[0].getAttribute('numero');
            $("#f_ini").html(cosa);
        }); //select

        //selec2 area si cambia su valor, actualiza select2 de abogados
        $("#area").on("change", function() {
            console.log("el valor cambio");
            let temp = $("#area").val();
            if (temp.length == 0) {
                //? si el valor de area esta vacio, puede ver todos los abogados
                $("#abogados").html(" "); //limpia el select de abogados
                /* $.each(abogadosTodos,function(i,k){
                  $("<option value='"+$abogadosTodos[i].id+"'>"+$abogadosTodos[i].nombre+"</option>").appendTo($("#abogados"));
                }); */

                abogadosTodos.forEach(abogado => {
                    $("<option value='" + abogado.id + "'>" + abogado.nombre + ": " + abogado.area +
                        "</option>").appendTo($("#abogados"));
                });
                $('#abogados').select2({
                    placeholder: $('#abogados').attr('placeholder')
                });

                console.log("se actualiza todo");

            } else {
                //? se ha seleccionado un area
                var dataAreas = JSON.stringify($("#area").val());
                var data = {
                    'areasId': dataAreas
                };
                $.ajax({
                    url: "./?action=abogados/porArea", // se le envia el id de la poliza a buscar ... o de las polizas
                    method: "POST",
                    data: data,
                    success: function(respuesta) {
                        respuesta = JSON.parse(respuesta);
                        console.log(respuesta);
                        if (respuesta) {
                            $("#abogados").html(" "); //limpia el select de abogados

                            respuesta.forEach(abogado => {
                                $("<option value='" + abogado.id + "'>" + abogado.nombre +
                                        " <i>: " + abogado.area + "</i> </option>")
                                    .appendTo($("#abogados"));
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

        $("#estado").on("change", function() {

            let temp = $("#estado").val();

            //? se ha seleccionado un estado
            var data = {
                'municipios': temp
            };
            $.ajax({
                url: "./core/app/model/Estados.php", // se le envia el id de la poliza a buscar ... o de las polizas
                method: "POST",
                data: data,
                success: function(respuesta) {
                    // respuesta= JSON.parse(respuesta);
                    console.log(respuesta);
                    if (respuesta) {
                        $("#ciudad").html(" "); //limpia el select de abogados

                        /*  respuesta.forEach(abogado => {
                           $("<option value='"+abogado.id+"'>"+abogado.nombre+" <i>: "+abogado.area+"</i> </option>").appendTo($("#abogados"));
                         }); */
                        $("#ciudad").html(respuesta);
                        $('#ciudad').select2({
                            placeholder: $('#ciudad').attr('placeholder')
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Ha ocurrido un error con el controlador de los estados y ciudades',
                            text: 'Por favor intentalo nuevamente, si persiste el problema, contacte a asicomgraphics.mx',
                            confirmButtonText: 'OK',
                            footer: 'Sentimos las molestias'
                        });
                    }
                }
            })


        })


        //? accion del formulario para crear el nuevo siniestro
        $("#btnFormNuevoSiniestro").on("click", function() {
           
            Swal.fire({
                allowOutsideClick:false,
                icon: 'success',
                title: 'Creando Siniestro...',
                // text: 'Por favor intentalo nuevamente, si persiste el problema, contacte a asicomgraphics.mx',
                confirmButtonText: 'OK',
                // footer: 'Sentimos las molestias',
                didOpen: () => {
                    Swal.showLoading()
                }
            });

            //comprobar dattos, enviar peticion ajax, recibir respuesta , mandar alert sweert
            if (document.querySelector("#nuevoSiniestro").reportValidity()) {
                var descripcionHechos = CKEDITOR.instances['descripcionHechos'].getData();
                var formaContacto = $('input[name=formaContacto]:checked').val();
                var formSerialize = $("#nuevoSiniestro").serialize();
                // formSerialize['descripcionHechos']= descripcionHechos;
                console.log("formulario OK");
                $.ajax({
                    url: '?' + document.querySelector("#nuevoSiniestro").action.split('?')[1], // se envia todo el formulario a la action
                    method: "POST",
                    type: "POST",
                    data: {
                        'data': formSerialize,
                        'textArea': descripcionHechos,
                        'formaContacto':formaContacto
                    },
                    //todo !!! se envia serializado
                    success: function(respuesta) {
                        // console.log("res");
                        //console.log(respuesta);
                        // console.log("res");
                        respuesta = respuesta.trim();
                        respuesta = JSON.parse(respuesta);
                        console.log(respuesta);
                        if (respuesta.siniestro) {
                            var tablePolizasJs = '';
                            Swal.fire({
                                icon: 'success',
                                width: 700,
                                title: 'Creado correctamente',
                                //text: 'Siniestro '+$('#numSiniestro')+'. OK \n \r ¿Quieres ir a todos los siniestros o crear nuevo siniestro?',
                                html: 'Folio Siniestro:<a href="./?view=siniestro/ver&param=' +
                                    respuesta.siniestro + '" > <b>' + respuesta.folio +
                                    '</b></b>; con clave del sistema <a href="./?view=siniestro/ver&param=' +
                                    respuesta.siniestro + '" > <u>' + respuesta.siniestro +
                                    '</u></a>. creado.  <br> ¿Quieres ir a todos los siniestros o crear nuevo siniestro?',
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
                                    window.location = "./?view=siniestro/ver&param=" +
                                        respuesta.siniestro;
                                } else if (result.isDenied) {
                                    console.log('isDeny'); //ver todos los siniestros
                                    window.location = "./?view=siniestro/verTodos";
                                } else {
                                    console.log('isCancel'); // crear uno nuevo
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
                            setTimeout(() => {
                                Swal.hideLoading();
                            }, 1000);
                            
                        }
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { 
                        alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                    }    
                })

            }else{
                setTimeout(() => {
                    Swal.hideLoading();
                }, 1000);

                Swal.fire({
                    icon: 'info',
                    title: 'Debes llenar todos los campos',
                    text: 'Por favor intentalo nuevamente',
                    confirmButtonText: 'OK',
                    footer: 'Todos los campos son obligatorios',
                    confirmButtonColor: '#988763',
                }).then((result)=>{
                    setTimeout(() => {
                        document.querySelector("#nuevoSiniestro").reportValidity()
                    }, 700);
                });
                
            }
        });

        // ajuste auto heigth select2
        // $(".select2-selection--multiple").css();

            $('#proveniente').val('prov_gmx').trigger('change.select2');
            //selecciona por default prov GMX
        


        

    }
    function isString(value) {
            return typeof value === 'string' || value instanceof String;
        }
</script>

<style>
    .floatingInput{
        transform: translate(10px, 38px);
    }
    form-group:hover .floatingInput{
        transform: translate(0px, 0px);
    }
    /* css-tooltip" data-tooltip="Nombre(s)" */
    .container {
        padding: 30px;
    }

    .css-tooltip {
        position: relative;
        transition: all 1.5s ease-on-out;
    }

    .css-tooltip:hover:after {
        content: attr(data-tooltip);
        background: #93866bb0;
        padding: 5px;
        border-radius: 6px;
        display: inline-block;
        position: absolute;
        transform: translate(-50%, -100%);
        margin: 0 auto;
        color: #fff;
        min-width: 100px;
        min-width: 150px;
        top: -5px;
        left: 50%;
        text-align: center;
        font-size: 0.825rem;
    }

    .css-tooltip:hover:before {
        top: -5px;
        left: 50%;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
        border-color: rgba(0, 0, 0, 0);
        border-top-color: #93866bb0;
        border-width: 5px;
        margin-left: -5px;
        transform: translate(0, 0px);
    }
</style>

<?php
//?generando clases para input select2 calificacion
//// echo "<style>".$cssStyleCalificacion."</style>";

// core::preprint($calificaciones);

/* estatus de color
https://select2.org/selections */

