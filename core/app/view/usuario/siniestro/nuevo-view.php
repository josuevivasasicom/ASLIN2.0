<?php



?>

<div class="content">
    <div class="title">
        <form id="nuevoSiniestro" name="nuevoSiniestro" action="./?action=siniestro/nuevo">
            <div class="row justify-content-between">
                <div class="col-5">
                    <h4>Datos del asegurado: <span style="font-weight: 100;" id="f_ini"></span></h4>
                </div>
                <div class="col-3">
                    <div class="nada">
                        <div class="form-group input-group date">
                            <select class="js-select2 form-control" placeholder="Selecciona Proveniente" name="proveniente" style="width:100%;" required>
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
            </div>
    </div>



    <div class="row row1">
        <div class="col-sm-3 col-md">
            <div class="form-group">
                <input name="nombre" value="" type="text" class="form-control" placeholder="Nombre(s)" required>
            </div>
        </div>
        <div class="col-sm-3 col-md">
            <div class="form-group">
                <input name="apellidoP" value="" type="text" class="form-control" placeholder="Apellido Paterno" required>
            </div>
        </div>
        <div class="col-sm-3 col-md">
            <div class="form-group">
                <input name="apellidoM" value="" type="text" class="form-control" placeholder="Apellido Materno" required>
            </div>
        </div>

    </div>

    <div class="row row2">
        <div class="col-sm-3 col-md-3">
            <div class="form-group">
                <select class="js-select2 form-control" placeholder="Selecciona Institución" name="institucion" style="width:100%;" required>
                    <!-- name="states[]" multiple="multiple" -->
                    <!-- <option>Selecciona Institución</option> -->
                    <option> </option>
                    <?php
                    $instituciones = Folios::obtenerConfigCampo('institucion');
                    foreach ($instituciones as $key) {
                        print "<option value='" . $key->id . "'>" . strtoupper($key->valor) . "</option>";
                    }
                    ?>
                </select>
            </div>
        </div>
        <div class="col-sm-3 col-md">
            <div class="form-group">
                <input name="cel" value="" type="text" class="form-control" placeholder="Cel" required>
            </div>
        </div>
        <div class="col-sm-3 col-md">
            <div class="form-group">
                <input name="casa" value="" type="text" class="form-control" placeholder="Casa" required>
            </div>
        </div>
        <div class="col-sm-3 col-md">
            <div class="form-group">
                <input name="oficina" value="" type="text" class="form-control" placeholder="Oficina" required>
            </div>
        </div>

        <div class="col-sm-3 col-md">
            <div class="form-group input-group date" id="datetimepicker">
                <input name="fechaReporte" value="2022-01-25 17:01:37" id="fechaReporte" type="text" class="form-control datetimepicker" placeholder="Fecha Reporte" required>
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
            <select name="ciudad" class="js-select2 form-control custom-select" id="ciudad" placeholder="Selecciona Ciudad" required>
                <option> </option>
                <option>necesitas seleccionar estado</option>
            </select>
        </div>
        <div class="col-sm-3 col-md">
            <div class="form-group">
                <input name="mail" value="" type="text" class="form-control" placeholder="Mail" required>
            </div>
        </div>

        <div class="col-sm-3 col-md-3 row mx-2">
            <div class="title col-12">
                <h6>Forma de Contacto</h6>
            </div>
            <div class="form-check-radio col-4">
                <label class="form-check-label pl-3">
                    <input required value="" class="form-check-input" type="radio" name="formaContacto" id="formaContacto1" value="correo"> Correo
                    <span class="form-check-sign"></span>
                </label>
            </div>
            <div class="form-check-radio col-4">
                <label class="form-check-label pl-3">
                    <input required value="" class="form-check-input" type="radio" name="formaContacto" id="formaContacto2" value="telefono" checked="">Teléfono
                    <span class="form-check-sign"></span>
                </label>
            </div>
            <div class="form-check-radio col-4">
                <label class="form-check-label pl-3">
                    <input value="" required class="form-check-input" type="radio" name="formaContacto" id="formaContacto1" value="directa"> Directa
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
                <textarea placeholder="" id="descripcionHechos" name="descripcionHechos">
            <p><strong><?= core::getTimeNow() ?></strong></p>

            <p><strong>Descripci&oacute;n de los hechos:&nbsp;</strong><br />
            <big>Lic. Luis Alberto Mart&iacute;nez Garc&iacute;a   
 &nbsp; &nbsp; &nbsp; &nbsp;/ &nbsp;&nbsp;&nbsp;&nbsp;     Lic. Mario Aguilar Guajardo.</big></p>

            <p>...</p>

            <p>Agradeciendo su atenci&oacute;n, me reitero a sus &oacute;rdenes para cualquier duda o aclaraci&oacute;n.<br />
            <br />
            A T E N T A ME N T E<br />
            Lic. <?= $_SESSION['nombre'] ?>
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

                        removeButtons: "Creatediv,Subscript,Superscript,Anchor,PasteFromWord,PasteText,Paste,Cut,Save,NewPage,DocProps,Document,Templates,Print,ExportPdf,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CreateDiv,Language,Link,Unlink,Iframe,About",
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
                        <input name="numReporte" value="" type="text" class="form-control" placeholder="Nº de Reporte" required>
                    </div>
                </div>
                <div class="col-sm-3 col-md">
                    <div class="form-group">
                        <input name="numSiniestro" value="" type="text" class="form-control" placeholder="Nº de Siniestro" required>
                    </div>
                </div>

                <div class="col-sm-3 col-md">
                    <div class="form-group input-group date" id="">
                        <input name="fechaVigencia1" value="" id="fechaVigencia1" type="text" class="form-control " placeholder="Fecha Vigencia" required>
                        <div class="input-group-append">
                            <span class="input-group-text">
                                <span class="glyphicon glyphicon-calendar"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 col-md">
                    <div class="form-group input-group date" id="">
                        <input name="fechaVigencia2" value="" id="fechaVigencia2" type="text" class="form-control " placeholder="Fin Vigencia" required>
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
                        <select class="js-select2-tags form-control" placeholder="Nº de Póliza" id='numPoliza' name="numPoliza[]" multiple="multiple" style="width:100%;">
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
                    <div class="form-group">
                        <select class="js-select2 form-control" placeholder="Selecciona status" name="status" style="width:100%;" required>
                            <!-- name="states[]" multiple="multiple" -->
                            <!-- <option>Selecciona status</option> -->
                            <option> </option>
                            <?php
                            $statusI = Folios::obtenerConfigCampo('status');
                            foreach ($statusI as $key) {
                                print "<option value='" . $key->id . "'>" . ucwords($key->valor) . "</option>";
                            }
                            ?>
                            <!--  <option value='verificado'>V -Verificado</option>
                  <option value='pendiente'>P-Pendiente</option>
                  <option value='cancelado'>C-Cancelado</option> -->
                        </select>
                    </div>
                </div>
                <div class="col-sm col-md">
                    <div class="form-group">
                        <select class="js-select2 form-control" placeholder="Selecciona Calificación" name="calificacion" style="width:100%;" required>
                            <!-- name="states[]" multiple="multiple" -->
                            <!-- <option>Selecciona Calificacion</option> -->
                            <option> </option>
                            <?php
                            $calificaciones = Folios::obtenerConfigCampo('calificacion');
                            foreach ($calificaciones as $key) {
                                print "<option value='" . $key->id . "'>" . ucwords($key->valor) . "</option>";
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
                    <div class="form-group">
                        <select class="js-select2 form-control" placeholder="Selecciona Autoridad" name="autoridad" style="width:100%;" required>
                            <!-- name="states[]" multiple="multiple" -->
                            <!-- <option>Selecciona Autoridad</option> -->
                            <option> </option>
                            <?php
                            $autoridades = Folios::obtenerConfigCampo('autoridad');
                            foreach ($autoridades as $key) {
                                print "<option value='" . $key->id . "'>" . strtoupper($key->valor) . "</option>";
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
                    <div class="form-group">
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

                <div class="col-12">
                    <div class="form-group">
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
                </div>

                <div class="update ml-auto mr-4">
                    <!-- centrado <div class="update ml-auto mr-auto"> -->
                    <button type="button" id="btnFormNuevoSiniestro" class="btn btn-primary btn-round">Crear
                        Siniestro</button>
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

        //escribe el folio del proveniente en un label
        $("[name=proveniente]").on("change", (element) => {
            cosa = element.target.selectedOptions[0].getAttribute('numero');
            $("#f_ini").html(cosa);
        }); //select


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
        $('#numPoliza').select2({
            tags: true,
            tokenSeparators: [','],
            placeholder: "No. de Poliza"
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
                        })
                    }
                }
            })


        })

        //? accion del formulario para crear el nuevo siniestro
        $("#btnFormNuevoSiniestro").on("click", function() {
            //comprobar dattos, enviar peticion ajax, recibir respuesta , mandar alert sweert
            if (document.querySelector("#nuevoSiniestro").reportValidity()) {
                var descripcionHechos = CKEDITOR.instances['descripcionHechos'].getData();
                var formSerialize = $("#nuevoSiniestro").serialize();
                // formSerialize['descripcionHechos']= descripcionHechos;
                $.ajax({
                    url: '?' + document.querySelector("#nuevoSiniestro").action.split('?')[
                        1], // se envia todo el formulario a la action
                    method: "POST",
                    type: "POST",
                    data: {
                        'data': formSerialize,
                        'textArea': descripcionHechos
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

                                confirmButtonColor: 'var(--color-dark)',
                                denyButtonColor: 'var(--color-blanco)',
                                cancelButtonColor: 'var(--fondo-degradado)',

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
                                confirmButtonColor: 'var(--color-dark)',
                            })
                        }
                    }
                })

            }
        });

    }
</script>

<style>
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
// core::preprint($provenientes);

/* estatus de color
https://select2.org/selections */