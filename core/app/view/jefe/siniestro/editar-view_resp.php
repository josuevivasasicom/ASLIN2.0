<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL & ~E_DEPRECATED);


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

if(!isset($_REQUEST['edit'])  and $_REQUEST['timerst']=='' ){
    header('Location: ?view=index');
}

$Sedit = Siniestros::verSiniestroTimerstEDITAR($_REQUEST['timerst']);
core::sendVarToJs(json_encode($Sedit['numPoliza']), 'numPoliza'); // util para el campo polizas
core::sendVarToJs(json_encode($Sedit['timerst']), 'timerst'); // util para titulo de la barra

?>



<div class="content">

    <div class="title">
        <form id="editarSiniestro" name="editarSiniestro" action="./?action=siniestro/editar">
            <input type="hidden" value="<?=$Sedit['timerst']?>" name="timerst">
            <div class="row justify-content-between">
                <div class="col-5">
                    <h4>Datos del asegurado: <span style="font-weight: 100;" id="f_ini"> <?=$Sedit['folio']?> </span></h4>
                </div>
                <div class="col-3">
                    <div class="nada">
                    </div>
                </div>
            </div>
    </div>



    <div class="row row1">
        <div class="col-sm-3 col-md">
            <div class="form-group">
                <label for="floatingInput">Nombre(s)</label>
                <input  value="<?=$Sedit['nombre'] ?>" name="nombre" value="" type="text" class="form-control" placeholder="" required>
            </div>
        </div>
        <div class="col-sm-3 col-md">
            <div class="form-group">
                <label for="floatingInput">Apellido Paterno</label>
                <input  value="<?=$Sedit['apellidoP'] ?>" name="apellidoP" value="" type="text" class="form-control" placeholder="" required>
            </div>
        </div>
        <div class="col-sm-3 col-md">
            <div class="form-group">
                <label for="floatingInput">Apellido Materno</label>
                <input  value="<?=$Sedit['apellidoM'] ?>" name="apellidoM" value="" type="text" class="form-control" placeholder="" required>
            </div>
        </div>

    </div>

    <div class="row row2">
        <div class="col-sm-3 col-md-3">
            <div class="form-group">
                <label for="floatingInput">Institución</label>
                <select class="js-select2 form-control" placeholder="Selecciona Institución" id="institucion" name="institucion" style="width:100%;" required>
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
                <label for="floatingInput">Número de Cel</label>
                <input name="cel" value="<?=$Sedit['cel'] ?>"  type="text" class="form-control" placeholder="" opcionales XD>
            </div>
        </div>
        <div class="col-sm-3 col-md">
            <div class="form-group">
                <label for="floatingInput">Número de Casa</label>
                <input name="casa" value="<?=$Sedit['casa'] ?>"  type="text" class="form-control" placeholder="" opcionales XD>
            </div>
        </div>
        <div class="col-sm-3 col-md">
            <div class="form-group">
                <label for="floatingInput">Número de Oficina</label>
                <input name="oficina" value="<?=$Sedit['oficina'] ?>"  type="text" class="form-control" placeholder="" opcionales XD>
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
                <option>Necesitas seleccionar estado</option>
                <?php echo "<option value='".$Sedit['ciudad']."' >".$Sedit['ciudad']."</option>";?>
            </select>
        </div>
        <div class="col-sm-3 col-md">
            <div class="form-group">
                <label for="floatingInput">E-mail</label>
                <input name="mail" value="<?=$Sedit['mail'] ?>" type="text" class="form-control" placeholder="" required>
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
                    <input required class="form-check-input" type="radio" name="formaContacto" value="telefono">Teléfono
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
       

        <div class="col">
            <div class="row">
                <div class="col-sm-3 col-md">
                    <div class="form-group">
                        <label for="floatingInput">Nº de Reporte</label>
                        <input id="numReporte" value="<?=$Sedit['numReporte'] ?>"  type="text" class="form-control" placeholder="" disabled>
                    </div>
                </div>
                <div class="col-sm-3 col-md">
                    <div class="form-group">
                        <label for="floatingInput">Nº de Siniestro</label>
                        <input name="numSiniestro" value="<?=$Sedit['numSiniestro'] ?>"  type="text" class="form-control" placeholder="" required>
                    </div>
                </div>

                <div class="col-sm-3 col-md">
                    <label for="floatingInput">Fecha Inicio Vigencia</label>
                    <div class="form-group input-group date" id="">
                        <input name="fechaVigencia1" value="<?=$Sedit['vigencia1'] ?>"  id="fechaVigencia1" type="text" class="form-control " placeholder="" required>
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
                        <input name="fechaVigencia2" value="<?=$Sedit['vigencia2'] ?>"  id="fechaVigencia2" type="text" class="form-control " placeholder="" required>
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
                        <select class="js-select2-tags form-control" placeholder=" " id='numPoliza' name="numPoliza[]" multiple="multiple" style="width:100%;">
                            <?php
                            $polizas = Folios::obtenerPolizas();
                            foreach ($polizas as $key => $value) {
                                print "<option value='" . $value->id . "'>" . ucwords($value->poliza) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-12">
                    <label for="floatingInput">Selecciona Autoridad</label>
                    <div class="form-group">
                        <select class="js-select2 form-control" placeholder="Selecciona Autoridad" id="autoridad"  name="autoridad" style="width:100%;" required>
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

            <!--  nuevos parametros agregados
                TIPO DE INTERVENCIÓN
                TERCERO
                NICHO -->

                <div class="col-6">
                    <div class="update ml-auto mt-3">
                        <button type="button" id="btnFormEditarSiniestro" style="width:49%" class="btn btn-primary btn-round">Guardar cambios</button>
                        <a type="button" href="./?view=siniestro/ver&param=<?=$Sedit['timerst']?>" id="regresar" style="width:49%" class="btn btn-secondary btn-round">Regresar</a>
                    </div>
                </div>

            </div>

        </div>
    </div>

    </form>
</div>

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


        
        console.log('cargando funciones');



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


        //? accion del formulario para editar el siniestro
        $("#btnFormEditarSiniestro").on("click", function() {
            //comprobar dattos, enviar peticion ajax, recibir respuesta , mandar alert sweert
            if (document.querySelector("#editarSiniestro").reportValidity()) {
                // var descripcionHechos = CKEDITOR.instances['descripcionHechos'].getData();
                var formaContacto = $('input[name=formaContacto]:checked').val();
                var formSerialize = $("#editarSiniestro").serialize();
                // formSerialize['descripcionHechos']= descripcionHechos;
                console.log("formulario OK");
                Swal.showLoading();
                $.ajax({
                    url: '?' + document.querySelector("#editarSiniestro").action.split('?')[1]+"&p=jefe", // se envia todo el formulario a la action
                    method: "POST",
                    type: "POST",
                    data: {
                        'data': formSerialize,
                        // 'textArea': descripcionHechos,
                        'formaContacto':formaContacto
                    },
                    //todo !!! se envia serializado
                    success: function(respuesta) {
                        if (respuesta == 'ok') {
                            var tablePolizasJs = '';
                            Swal.fire({
                                icon: 'success',
                                width: 700,
                                title: 'Editado correctamente',
                                //text: 'Siniestro '+$('#numSiniestro')+'. OK \n \r ¿Quieres ir a todos los siniestros o crear nuevo siniestro?',
                                html: 'Editado correctamente',
                                showDenyButton: false,
                                showCancelButton: false,

                                confirmButtonText: 'Continuar',
                                // denyButtonText: `Ir a todos`,
                                // cancelButtonText: 'Crear Nuevo',

                                confirmButtonColor: '#988763',
                                denyButtonColor: '#988763',
                                cancelButtonColor: '#988763',

                                allowOutsideClick: false
                            }).then((result) => {
                                //redireccionar a la vista del ID
                                    window.location = "./?view=siniestro/ver&param="+<?=$Sedit['timerst']?>;
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
                    },
                    error: function(XMLHttpRequest, textStatus, errorThrown) { 
                        alert("Status: " + textStatus); alert("Error: " + errorThrown); 
                    }    
                })

            }else{
                Swal.fire({
                    icon: 'info',
                    title: 'Debes llenar todos los campos',
                    text: 'Por favor intentalo nuevamente',
                    confirmButtonText: 'OK',
                    footer: 'Todos los campos son obligatorios',
                    confirmButtonColor: '#988763',
                }).then((result)=>{
                    document.querySelector("#editarSiniestro").reportValidity();
                })
            }
        });


        //? RELLENNDO LOS SELECT2

        $('input[name=formaContacto][value=<?=$Sedit['formaContacto']?>]').prop("checked", true);
        $('#institucion').val('<?=$Sedit['institucion']?>').trigger('change.select2');
        $('#autoridad').val('<?=$Sedit['autoridad']?>').trigger('change.select2');
        $('#status').val('<?=$Sedit['status']?>').trigger('change.select2');
        $('#calificacion').val('<?=$Sedit['calificacion']?>').trigger('change.select2');
        
        $('#estado').val('<?=$Sedit['estado']?>').trigger('change.select2');
        $('#ciudad').val('<?=$Sedit['ciudad']?>').trigger('change.select2');

        $(()=>{// Trabakjando array de polizas
            let polizas = JSON.parse(numPoliza);
            $('#numPoliza').val(polizas).trigger('change.select2');
        }
        )
        
        //cambia el color del select2 de status
        $("[name=status]").on("change", function() {
            console.log('cambiando');
            let temp = $("[name=status]").val();
            let bg = $("select option[data-value="+temp+"]").attr('data-background');
            document.querySelector('.statusGroup span span span').style.backgroundColor = bg; //'#000000'
        });

        //cambia el color del select2 de calificacion
        $("[name=calificacion]").on("change", function() {
            let temp = $("[name=calificacion]").val();
            let bg = $("select option[data-value="+temp+"]").attr('data-background');
            document.querySelector('.calificacionGroup span span span').style.backgroundColor = bg; //'#000000'
        })
        //cambia colores de status y calificacion por primera vez
        setTimeout(() => {
            let statusbtn = $("[name=status]").val();
            let bg = $("select option[data-value="+statusbtn+"]").attr('data-background');
            document.querySelector('.statusGroup span span span').style.backgroundColor = bg;
            let calibtn = $("[name=calificacion]").val();
            let bg2 = $("select option[data-value="+calibtn+"]").attr('data-background');
            document.querySelector('.calificacionGroup span span span').style.backgroundColor = bg2; //'#000000'
            
        }, 500);

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

