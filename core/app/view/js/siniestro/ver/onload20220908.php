<?php
?>

<script defer>

window.onload=function (){
    scope=this;

    //ASIGNACION DE LOCALSTORAGE
    if (localStorage.getItem('paramA') == undefined) {
        // console.log('no existe prov se establece en blanco.');
        localStorage.setItem('paramA', '');
    }
    if (localStorage.getItem('paramB') == undefined) {
        // console.log('no existe prov se establece en blanco.');
        localStorage.setItem('paramB', '');
    }
    if (localStorage.getItem('tabOpen') == undefined) {
        // console.log('no existe prov se establece en blanco.');
        localStorage.setItem('tabOpen', '');
    }
    if (localStorage.getItem('panelOpen') == undefined) {
        // console.log('no existe prov se establece en blanco.');
        localStorage.setItem('panelOpen', '');
    }

    //?****** pone titulo a la pagina
    $('.navbar-brand').html("ID: <b><?=$sn['folio']?></b> -  Num siniestro: <b><?=$sn['numSiniestro']?> <br> <?=$sn['nombre']?> <?=$sn['apellidoP']?> <?=$sn['apellidoM']?>");
    $('.sidebar-wrapper li[siniestros]').addClass('active');//activa el menu de siniestros  <?=$sn['numSiniestro']?>


    $("form#verSiniestro").on('change',function(){
        $(".update").css("display",'block');
    })

    $(".update").css("display",'none');

    $("#verPoliza").on("click",function(){
        // var dataPolizas = JSON.stringify($('#numPoliza').val());
        var dataPolizas = JSON.stringify(<?=$sn['numPoliza']?>);
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
                                <th>sum asegurada</th>
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
        });//fin ajax
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



    function formatState (state) {
        // if (!state.id) {
        //   return state.text;
        // }

        // var baseUrl = "/user/pages/images/flags";
        // var baseUrl = "https://select2.org/user/pages/images/flags/ak.png";
        //  var baseUrl = state.element.attributes.avatar;
        // console.log($(state.element).attr('avatar'));
        var baseUrl = $(state.element).attr('avatar');
        var $state = $(
            // '<span><img src="' + baseUrl + '" class="img-flag" /> ' + state.text + '</span>'
            '<span><img src="' + baseUrl + '" class="img-flag" style="display: inline-block; background: transparent !important;width: 2em;height: auto;border-radius: 18% !important;margin-right: 0.6em !important;" /> ' + state.text + '</span>'
            // '<span><img src="' + baseUrl + '/' + state.element.value.toLowerCase() + '.png" class="img-flag" /> ' + state.text + '</span>'
        );
        return $state;
    };

    $.each(document.querySelectorAll('.js-select2'),function(i,key){
        console.log($(key).attr('place') );
        if ($(key).attr('place') == 'abogados' ){
            $(key).select2({
                placeholder: " "+  $(key).attr('placeholder'),
                templateResult: formatState
            });
        }else{
            $(key).select2({
                placeholder: " "+  $(key).attr('placeholder')
            });
        }
    });



    $(function () {
        // Configurar datetimepicker
        var dataInfo={
            format: 'YYYY-MM-DD HH:mm:ss',
            locale: moment.locale('es-mx'),
            allowInputToggle: true,
        }

        // $('#fechaCaptura').datetimepicker(dataInfo);
        // $('#fechaReporte').datetimepicker(dataInfo);
        // $('#fechaVigencia1').datetimepicker(dataInfo);
        // $('#fechaVigencia2').datetimepicker(dataInfo);

    });

    //selec2 area si cambia su valor, actualiza select2 de abogados
    $("#asignArea").on("change",function(){
        console.log("el valor cambio");
        let temp = $("#asignArea").val();
        if(temp.length == 0 ){
            //? si el valor de area esta vacio, puede ver todos los abogados
            $("#abogados").html( " "); //limpia el select de abogados
            /* $.each(abogadosTodos,function(i,k){
            $("<option value='"+$abogadosTodos[i].id+"'>"+$abogadosTodos[i].nombre+"</option>").appendTo($("#abogados"));
            }); */
            
            /*  abogadosTodos.forEach(abogado => {
                $("<option value='"+abogado.id+"'>"+abogado.nombre+": "+abogado.area+"</option>").appendTo($("#abogados"));
                });
                $('#abogados').select2({
                placeholder: $('#abogados').attr('placeholder')
                }); */

            console.log("se actualiza todo");

        }else{
            //? se ha seleccionado un area
            var dataAreas = JSON.stringify($("#asignArea").val());
            var dataAbogados = JSON.stringify($("#abogados").val());
            var data=  {'areasId': dataAreas, abogadosId: dataAbogados};
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
                        $("<option avatar='"+abogado.avatar+"' value='"+abogado.id+"'>"+abogado.nombre+" <i>: "+abogado.area+"</i> </option>").appendTo($("#abogados"));
                        });
                        $('#abogados').select2({
                        placeholder: $('#abogados').attr('placeholder'),
                        templateResult: formatState
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

                            confirmButtonColor: 'var(--color-dark)',
                            denyButtonColor: 'var(--color-blanco)',
                            cancelButtonColor: 'var(--fondo-degradado)',

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
                            confirmButtonColor: 'var(--color-dark)',
                        })
                    } 
                }
            })
            
        }
    });  

    $('#btnEditDescripcion').on('click',()=>{
        var descripcionHechos = CKEDITOR.instances['textareaDescripcion'].getData();
        $.ajax({
            url: "./?action=siniestro/editDescripcion&timerst=<?=$sn['timerst']?>&folio=<?=$sn['folio']?>",// manda a asignar abogado y area segun el timerst
            method: "POST",
            data: {'texarea':descripcionHechos},
            success: function(respuesta) {
            // console.log(respuesta=='asignacionesOK');
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
    });

    //activar jtable Historico
    $('#tablaHistoricoSiniestros').jtable({
            title: 'Movimientos del ID <?=$sn['folio']?>',
            messages:{
                noDataAvailable: 'No hay movimientos!',
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
                listAction: './?action=jtable/tablaHistoricoSiniestros.ajax&by_id=<?=$sn['timerst']?>',
                //createAction: '/GettingStarted/CreatePerson',
                //updateAction: '?action=jtable/tablaUsuarios.ajax&editar',
                // deleteAction: '/GettingStarted/DeletePerson'
            },
            fields: {
                id: {
                    title: 'ID',
                    key: true,
                    list: true,
                    width: '3%'
                },
                folio: {
                    title: 'Folio',
                    width: '7%'
                },
                movimiento: {
                    title: 'Movimiento',
                    width: '10%'
                },
                usuarioN: {
                    title: 'Usuario',
                    width: '10%'
                },
                fecha: {
                    title: 'Fecha',
                    width: '7%'
                },
                historico: {
                    title: 'Histórico',
                    width: '7%'
                },
                
                
            }
    });
    $('#tablaHistoricoSiniestros').jtable('load');


    //abren las pestañas que estaban abiertas antes de refrecar pagina.
    if(localStorage.getItem('panelOpen') !=''){
        let panel = localStorage.getItem('panelOpen'); //'#collapseSiniestros'
        let panelElement = document.querySelector(panel);
        // panelElement.classList.add('active');
        $(panelElement).collapse('show');
        let nameTab= localStorage.getItem('tabOpen').substring(1);
        document.querySelector('[data-name='+nameTab+'] a').classList.add('active');

    }

    if(localStorage.getItem('tabOpen') !=''){
        let tab = localStorage.getItem('tabOpen');
        let tabElement = document.querySelector(tab);
        tabElement.classList.add('active');
    }

    
}//?fin de windows on load

//? ----------------- FUNCIONES DE USUARIO ASIGNADO
//activar select2 en modal de institucion step1
function modalCambiaAutoridadSelect(){
    /* $('.js-select2-tags[name=btnAutoridad]').select2({
        placeholder: " " + $('.js-select2-tags[name=btnAutoridad]').attr('placeholder')
    }); */

    $("#modalCambiaAutoridad").modal('show');

    $('select[tag=true][name=btnAutoridad]').select2({
        tags: true,
        tokenSeparators: [','],
        placeholder: this.placeholder
        // placeholder: "No. de Poliza"
    });

}

//activar select2 en modal de institucion step2
function cambiaAutoridad(){
    let autdad = $('.js-select2-tags[name=btnAutoridad]').val();
    $.ajax({
        url: "./?action=siniestro/cambiarParametro&modo=autoridad",
        method: "POST",
        data: {'timerst':'<?=$sn['timerst']?>',autoridad:autdad},
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

//activar select2 en modal de institucion step1
function modalCambiaInstitucionSelect(){
    /* $('.js-select2-tags[name=btnInstitucion]').select2({
        placeholder: " " + $('.js-select2-tags[name=btnInstitucion]').attr('placeholder')
    }); */

    $("#modalCambiaInstitucion").modal('show');

    $('select[tag=true][name=btnInstitucion]').select2({
        tags: true,
        tokenSeparators: [','],
        placeholder: this.placeholder
        // placeholder: "No. de Poliza"
    });
}

//activar select2 en modal de institucion step2
function cambiaInstitucion(){
    let inst = $('.js-select2-tags[name=btnInstitucion]').val();
    $.ajax({
        url: "./?action=siniestro/cambiarParametro&modo=institucion",
        method: "POST",
        data: {'timerst':'<?=$sn['timerst']?>',institucion:inst},
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

//cambiar nombre del asegurado.
function cambiaNombre(){
    //url: "./?action=siniestro/cambiarParametro&modo=nombre";
    Swal.fire({
        allowOutsideClick:false,
        title: 'Editar Nombre Asegurado',
        showCancelButton: true,
        cancelButtonColor: 'var(--fondo-degradado)',
        confirmButtonColor: 'var(--color-dark)',
        confirmButtonText: 'Cambiar',
        cancelButtonText: 'salir',
        html: `
        <input letter="capitalize"  style="width:100%;text-align: center; text-transform:capitalize;" type="text" name="nombreAsegurado" id="nombreAsegurado" value="`+"<?=$sn['nombre']?>"+`"> 
        <input letter="capitalize"  style="width:100%;text-align: center; text-transform:capitalize;" type="text" name="paternoAsegurado" id="paternoAsegurado" value="`+"<?=$sn['apellidoP']?>"+`"> 
        <input letter="capitalize"  style="width:100%;text-align: center; text-transform:capitalize;" type="text" name="maternoAsegurado" id="maternoAsegurado" value="`+"<?=$sn['apellidoM']?>"+`"> 
        `,
        didOpen:()=>{
            $('#nombreAsegurado').focus();
        },
        preConfirm:()=>{
            const nombre =   capitalize($('#nombreAsegurado').val());
            const paterno =  capitalize($('#paternoAsegurado').val());
            const materno =  capitalize($('#maternoAsegurado').val());
            return {nombre,paterno,materno,"timerst":"<?=$sn['timerst']?>"}
        }
    }).then((resp)=>{
        if(resp.isConfirmed){
        //si le dio confirmar
        $.ajax({
            url: "./?action=siniestro/cambiarParametro&modo=nombre",// manda status nuevo segun el timerst
            method: "POST",
            data: resp.value,
            success: function(respuesta) {
                if (respuesta=='Se cambió el nombre') {
                Swal.fire({
                        icon: 'success',
                        width: 700,
                        title: '¡datos actualizados',
                        // text: 'El cliente puede pasar a caja a pagar con su nombre o puedes seguir editando.',
                        html: "Se guardaron los cambios",
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

    })
    

}

//PREPARANDO TEXTAREA DE DESCRIPCION EDITAR
function openDescripcion(id){
    $("#desHechosAnteriores").html( deshechant[id] );
}

//text area de editar descripcion
function editDescripcion(timerst){
        if(openTxtEditHechos==false){
            CKEDITOR.replace('textareaDescripcion', {
                    uiColor: '#ede6c6',
                    editorplaceholder: 'Descripcion de hechos',
                    placeholder: 'Descripcion de hechos',
                    removeButtons: "Creatediv,Subscript,Superscript,Anchor,PasteFromWord,PasteText,Paste,Cut,Save,NewPage,DocProps,Document,Templates,Print,ExportPdf,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CreateDiv,Language,Link,Unlink,Iframe,About",
                    // Bidirtl,,bidiltr,
                });
                openTxtEditHechos=true;
        }

}

  //? ---------------------------------------------------- FUNCIONES GENERALES

//esta funcion actualiza el valor de la pestaña abierta para activarla cuando se refresca la pagina.
function tabOpen(valor){
    localStorage.setItem('tabOpen',valor);
}
//esta funcion actualiza el valor del panel de area abierto para cuando se refresca la pagina.
function panelOpen(valor){
    localStorage.setItem('panelOpen',valor);
}

function getAreaNamebyId(idArea){
    const name = dataAreasJS.find(areas => areas.id==idArea);
    return name;
}

//Preparar modal para enviar emails
function emailsSendPrepare(){
    $.ajax({
        url: "./?action=usuario/libretaDirecciones&method=byuserid/ver&userid=<?=$_SESSION['id']?>",
        method: "POST",
        data: {} ,
        success: function(respuesta) {
            dataset = JSON.parse(respuesta); // parsea los email en json
            //console.log(dataset);

            let listTD=`
            <tr>
            <th>Enviar<td>
            <th>CC<td>
            <th>CCO<td>
            <th>Nombre<td>
            <th>Email<td>
            <th>Empresa<td>
            <tr>`;
                dataset.forEach(acount => {
                check = '';
                check2 = '';
                check3 = '';
                if(acount.important == 1){ //revisa si es default desde bd libretadirecciones
                    check = ' checked="true" ';
                }
                if(acount.important == 2){ //revisa si es default desde bd libretadirecciones
                    check2 = ' checked="true" ';
                }
                if(acount.important == 3){ //revisa si es default desde bd libretadirecciones
                    check3 = ' checked="true" ';
                }
                disabled = '';
                if(acount.email=='jesus@cmabogados.mx' 
                    // && acount.email=='siniestros@cmabogados.mx'
                ){//revisa si es email prioritario para denegar opcion de destildar
                    disabled = ' class="notouch" ';
                }
                listTD = listTD+ `
                <tr>
                <td> <input type="checkbox" `+check+` name="send_`+acount.idlist+`" id="send_`+acount.idlist+`"  `+disabled+`> <td>
                <td> <input type="checkbox" `+check2+` name="cc_`+acount.idlist+`" id="cc_`+acount.idlist+`"     `+disabled+`> <td>
                <td> <input type="checkbox" `+check3+` name="cco_`+acount.idlist+`" id="cco_`+acount.idlist+`"   `+disabled+`> <td>
                <td>`+acount.email+`<td>
                <td>`+acount.nombre+`<td>
                <td>`+acount.empresa+`<td>
                <tr>`;
                });
            
            let addmails = `
            <div class="spandestinatarios" >
                <div class="d-none form-row send">
                <div class="form-group col-md-10">
                    <select type=text class='selectEmail js-select2-tags form-control' index=0 placeholder='Agregar destinatarios' tag='true' name='inputsend[]' id='inputsend' style='width:100%;' multiple='multiple'>
                    </select>
                </div>
                <div class="form-group col-md-2 pt-2 labelChbox">
                    <label for="inputPassword4">Guardar</label>
                    <input type="checkbox" name="save_send" id="save_send">
                </div>
                </div>

                <div class="d-none form-row cc">
                <div class="form-group col-md-10">
                    <select type=text class='selectEmail js-select2-tags form-control' index=0 placeholder='Agregar Con Copia' tag='true' name='inputcc[]' id='inputcc' style='width:100%;' multiple='multiple'>
                    </select>
                </div>
                <div class="form-group col-md-2 pt-2 labelChbox">
                    <label for="inputPassword4">Guardar</label>
                    <input type="checkbox" name="save_cc" id="save_cc">
                </div>
                </div>

                <div class="d-none form-row cco">
                <div class="form-group col-md-10">
                    <select type=text class='selectEmail js-select2-tags form-control' index=0 placeholder='Agregar Con Copia Oculta' tag='true' name='inputcco[]' id='inputcco' style='width:100%;' multiple='multiple'>
                    </select>
                </div>
                <div class="form-group col-md-2 pt-2 labelChbox">
                    <label for="inputPassword4">Guardar</label>
                    <input type="checkbox" name="save_cco" id="save_cco">
                </div>
                </div>

                <div class=" form-row">
                <div class="form-group col-md-12 d-flex justify-content-end">
                    <button style="font-weight: 400;text-transform: capitalize;" onclick="agregarDestinatarios()" class="seeWrite btn py-1 btn-small btn-primary"> agregar destinatarios ... </button>
                </div>
                </div>

                <div class="form-row subject">
                <div class="form-group col-md-12">
                    <input style="var(--color-blanco) !important;font-size:18px;width:100%;border: 1px solid #DDDDDD !important; font-family: sans-serif;" class='selectEmail js-select2-tags form-control' type="text" placeholder="Asunto" name="subject" id="subject">
                </div>
                </div>

            </div>

            <textarea class="textarea" id="textareaEmail" placeholder='Escribe aquí (opcional)'>
                
            </textarea>
            `;

            Swal.fire({
            allowOutsideClick:false,
            showClass: {
                popup: 'animate__animated animate__backInLeft'
            },
            hideClass: {
                popup: 'animate__animated animate__backOutRight'
            },
            width: "90%",
            title: 'Enviar por correo',
            showCancelButton: true,
            cancelButtonColor: 'var(--fondo-degradado)',
            confirmButtonColor: 'var(--color-dark)',
            confirmButtonText: 'Enviar e-mail',
            cancelButtonText: 'salir',
            html: "<style>.tablaEmails tr:nth-child(4n+1){background:#e1e9ed;} .tablaEmails tr:hover{background: #ffedc3b3;color: black;}.tablaEmails tr:nth-child(1){background:#fff;} </style> <table width='100%' class='tablaEmails'>"+listTD+"<table> <br>"+addmails,
            didOpen:()=>{
                //select2 de mas emails
                $('#inputsend').select2({
                    placeholder: $('#inputsend').attr('placeholder'),//"agregar destinatarios",
                    dropdownParent: $('#swal2-html-container'),
                    tags : true ,
                    tokenSeparators : [ ',;' ] ,
                });
                $('#inputcc').select2({
                    placeholder: $('#inputcc').attr('placeholder'),//"agregar destinatarios",
                    dropdownParent: $('#swal2-html-container'),
                    tags : true ,
                    tokenSeparators : [ ',;' ] ,
                });
                $('#inputcco').select2({
                    placeholder: $('#inputcco').attr('placeholder'),//"agregar destinatarios",
                    dropdownParent: $('#swal2-html-container'),
                    tags : true ,
                    tokenSeparators : [ ',;' ] ,
                });

                //textarea cuerpo del correo
                // if(openTxtEditHechos==false){
                CKEDITOR.replace('textareaEmail', {
                        uiColor: '#ede6c6',
                        editorplaceholder: 'Cuerpo del correo',
                        placeholder: 'Escribe algo....',
                        removeButtons: "Creatediv,Subscript,Superscript,Anchor,PasteFromWord,PasteText,Paste,Cut,Save,NewPage,DocProps,Document,Templates,Print,ExportPdf,Form,Checkbox,Radio,TextField,Textarea,Select,Button,ImageButton,HiddenField,CreateDiv,Language,Link,Unlink,Iframe,About",
                    });
                    openTxtEditHechos=true;
                // }
            },
            preConfirm:()=>{
                //datos del siniestreo
                const timerst = $('#timerstFile').val();
                const areaNombre = $('#nombreAreaFile').val();
                const asunto =  Swal.getPopup().querySelector('#subject').value;

                //datos del dile
                const c1 = $('#c1').val();
                const c2 = $('#c2').val();
                const c3 = $('#c3').val();
                const linkpdf = $('#linkpdf').val();
                const link = $('#link').val();
                const idfile = $('#idfile').val();
                const version = $('#version').val();
                const v = $('#version').val();

                //si se guardaran o no los nuevos agregados
                const save_send = Swal.getPopup().querySelector('[type=checkbox][name=save_send]').checked;
                const save_cc = Swal.getPopup().querySelector('[type=checkbox][name=save_cc]').checked;
                const save_cco = Swal.getPopup().querySelector('[type=checkbox][name=save_cco]').checked;

                const addsend = $('#inputsend').val();
                const addcc = $('#inputcc').val();
                const addcco = $('#inputcco').val();

                const textMail =  CKEDITOR.instances['textareaEmail'].getData();
                const send = Swal.getPopup().querySelectorAll('[type=checkbox][name^=send_]:checked');
                const cc = Swal.getPopup().querySelectorAll('[type=checkbox][name^=cc_]:checked');
                const cco = Swal.getPopup().querySelectorAll('[type=checkbox][name^=cco_]:checked');
                let sendMails = ' ';
                let ccMails = ' ';
                let ccoMails = ' ';
                send.forEach(item => { sendMails = sendMails + "'"+item.id+"'," });
                cc.forEach(item => { ccMails = ccMails + "'"+item.id+"'," });
                cco.forEach(item => { ccoMails = ccoMails + "'"+item.id+"'," });

                sendMails = sendMails.substring(0, sendMails.length - 1);
                ccMails = ccMails.substring(0, ccMails.length - 1);
                ccoMails = ccoMails.substring(0, ccoMails.length - 1);

                
                
                if (textMail == '')
                Swal.showValidationMessage(`Escribe un mensaje por favor.`);
                
                if (asunto == '')
                Swal.showValidationMessage(`Debes escribir un asunto.`);

                if (sendMails == '' )
                Swal.showValidationMessage(`No se puede enviar mail sin un destinatario.`);

                return {textMail, sendMails,ccMails,ccoMails, addsend, addcc,addcco,save_send,save_cc,save_cco ,idfile,linkpdf, c1,c2,c3, timerst,areaNombre,v,version,folio:'<?=$sn['folio']?>',link,asunto}
            }
            }).then((res)=>{
            //?cuando se completó el campo de email y de mas opciones y se clickea en evnviar 
            //? enviando ajax para mail
                // location.reload();
                console.log('reload ...');
                console.log(res);
                if (res.isConfirmed)
                Swal.fire({
                allowOutsideClick:false,
                title:'enviando..',
                // showClass: {
                //   popup: 'animate__animated animate__backInLeft'
                // },
                hideClass: {
                    popup: 'animate__animated animate__backOutRight'
                },
                didOpen: () => {
                    Swal.showLoading();
                            $.ajax({
                            url: "./?action=mail/enviar&method=formato", //paso 1 para enviar data
                            method: "POST",
                            data: res.value ,
                            success: function(respuesta) {
                            let texto='';
                            if (respuesta== 'EXITO'){
                                    texto = "Correo enviado correctamente"
                            }
                            else if(respuesta== 'ERROR'){
                                texto = "No se logró enviar, posiblemente el archivo es muy pesado";
                            }
                            else{
                                texto = "OPS!! algo salió mal. informa al desarrollador";
                            }

                                    Swal.fire({
                                        confirmButtonColor: 'var(--color-dark)',
                                        confirmButtonText: 'Continuar',
                                        title:texto,
                                        /* showClass: {
                                        popup: 'animate__animated animate__backInLeft'
                                        }, */
                                        hideClass: {
                                        popup: 'animate__animated animate__backOutRight'
                                        },
                                    })
                            

                            }
                        });
                },
                });//termina swal


            })
        },
        error:{ function(e) {
        alert("algo anda mal, por favor refresca la página, disculpa las molestias");
            conjsole.log(e);
        }

        }
    });

    /* Swal.fire({
        // icon: 'success',
        width: 700,
        title: 'Enviar por correo',
        // text: 'El cliente puede pasar a caja a pagar con su nombre o puedes seguir editando.',
        html: "Se enviara email a las siguientes direcciones .... <br> en construcción",
        confirmButtonText: 'OK',
        allowOutsideClick: false
    }).then((result) => {
        // location.reload();
    }) */
}

//pone visibles los campos para escribir emals
function agregarDestinatarios(){
    Swal.getPopup().querySelector("div.send").classList.remove('d-none');
    Swal.getPopup().querySelector("div.cc").classList.remove('d-none');
    Swal.getPopup().querySelector("div.cco").classList.remove('d-none');
    Swal.getPopup().querySelector("button.seeWrite").classList.add('d-none');
}

//editar datos de la poliza
function editPoliza(i){
    // const pol = JSON.parse(obj);
    // console.log(pol);
    const pol = polizasArr.find(ele=>ele.id = i);
    Swal.fire({
          allowOutsideClick:false,
          // width: "70%",
          title: 'Editar poliza',
          showCancelButton: true,
          cancelButtonColor: 'var(--fondo-degradado)',
          confirmButtonColor: 'var(--color-dark)',
          confirmButtonText: 'Guardar',
          cancelButtonText: 'salir',
          html: `
          <form class="swetForm" style="overflow-x:hidden">
            <input type="hidden" class="form-control" id="poliza" name="poliza" value="`+pol.poliza+`">
            <input type="hidden" class="form-control" id="idpol" name="idpol" value="`+pol.id+`">
            <input type="hidden" class="form-control" id="timerst" name="timerst" value="`+<?=$sn['timerst']?>+`">

            <div class="form-group row">
              <label for="poliza" class="col-sm-4 col-form-label">Póliza</label>
              <div class="col-sm-8">
                <input type="text" readonly  class="form-control-plaintext" id="non"  placeholder="Póliza" value="`+pol.poliza+`">
              </div>
            </div>
          
            <div class="form-group row">
              <label for="deducible" class="col-sm-4 col-form-label">Deducible</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="deducible" name="deducible" placeholder="Deducible" value="`+pol.deducible+`">
              </div>
            </div>

            <div class="form-group row">
              <label for="reserva" class="col-sm-4 col-form-label">Reserva</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="reserva" name="reserva" placeholder="Reserva" value="`+pol.reserva+`">
              </div>
            </div>

            <div class="form-group row">
              <label for="coaseguro" class="col-sm-4 col-form-label">Coaseguro</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="coaseguro" name="coaseguro" placeholder="coaseguro" value="`+pol.coaseguro+`">
              </div>
            </div>

            <div class="form-group row">
              <label for="sumaAsegurada" class="col-sm-4 col-form-label">Suma Asegurada</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="sumaAsegurada" name="sumaAsegurada" placeholder="Número" value="`+pol.sumaAsegurada+`">
              </div>
            </div>
          </form> 
          `,
          didOpen:()=>{
            //aqui va la mascara de moneda 
            var mony =  {mask: '$num',blocks: {num: {mask: Number,scale: 2,thousandsSeparator: ',',padFractionalZeros:false}}}
            // nested masks are available!
            var currencyMask = IMask(document.getElementById('deducible'),mony);
            var currencyMask = IMask(document.getElementById('reserva'),mony);
            var currencyMask = IMask(document.getElementById('coaseguro'),mony);
            var currencyMask = IMask(document.getElementById('sumaAsegurada'),mony);

            /* var numberMask = IMask(document.getElementById('sumaAsegurada'), {
              mask: Number,  // enable number mask

              // other options are optional with defaults below
              scale: 2,  // digits after point, 0 for integers
              signed: false,  // disallow negative
              thousandsSeparator: ',',  // any single char
              padFractionalZeros: false,  // if true, then pads zeros at end to the length of scale
              normalizeZeros: false,  // appends or removes zeros at ends
              radix: '.',  // fractional delimiter
              mapToRadix: ['.'],  // symbols to process as radix

              // additional number interval options (e.g.)
            }); */

           
          },
          preConfirm:()=>{
            const timerst = Swal.getPopup().querySelector("#timerst").value;
            const id = Swal.getPopup().querySelector("#idpol").value;
            const deducible = Swal.getPopup().querySelector("#deducible").value;
            const reserva = Swal.getPopup().querySelector("#reserva").value;
            const coaseguro = Swal.getPopup().querySelector("#coaseguro").value;
            const sumaAsegurada = Swal.getPopup().querySelector("#sumaAsegurada").value;
            const poliza = Swal.getPopup().querySelector("#poliza").value;

            return{id,deducible,reserva,coaseguro,sumaAsegurada,timerst,poliza}
          }
          
      }).then((res)=>{
            console.log('reload ...');
            console.log(res);
            if (res.isConfirmed)
            Swal.fire({
              didOpen: () => {
                console.log(res);
                Swal.showLoading();
                $.ajax({
                  url: "./?action=poliza/editar&method=porID/unico",
                  method: "POST",
                  data: res.value ,
                  success: function(respuesta) {
                    console.log(respuesta);
                    
                    console.log("texto texto texto");
                    
                    const d = res.value;
                    if(respuesta=='ok')
                    {
                      $('#tablaHistoricoSiniestros').jtable('load');
                      //actualiza datos de poliza
                      $(".row[pol"+d.id+"] [reserva]").html(d.reserva);
                      $(".row[pol"+d.id+"] [deducible]").html(d.deducible);
                      $(".row[pol"+d.id+"] [coaseguro]").html(d.coaseguro);
                      $(".row[pol"+d.id+"] [sumaAsegurada]").html(d.sumaAsegurada);

                      //igualalr el polizasArr de js
                      pol.reserva = d.reserva;
                      pol.deducible = d.deducible;
                      pol.coaseguro = d.coaseguro;
                      pol.sumaAsegurada = d.sumaAsegurada;

                      Swal.hideLoading();

                    }
                  }
                })
              }
            });


      });
}

function disparadorFile(area){
    //swert SUBIR ARCHIVOS

    let options = '';
    dataFilesSelect.forEach(opt => {
        options = options+'<option value="'+opt.id+'"> ['+opt.c3+'] <b>'+opt.c2+'<b> - '+opt.valor+'</option>';
    });

    let selInput =`<input type='hidden' value='`+area+`' name='area' /> <select name="tipo" id="tipo"  class="swal2-input select2 js-select2" placeholder="Selecciona la clasificación del archivo"  style="width:100%;">`+ options +`</select>
    <input name="timerst" type="hidden"value="<?=$sn['timerst']?>" />
    <label class="" for="horas" >Horas: </label>
    <input class="mt-4 input form-input input-form" placeholder=" para bitácora" type="number" step=".5" id="horasDocs" name="horas" required>
    <label class="mt-4 pt-2" for="horas" >bitácora: </label>
    <input class="mt-4 input form-input input-form" placeholder=" Comentario (opcional)" type="text" id="textDOC" name="bitacora" >
    
    </form>`;

    setTimeout(() => {
    //$("#tipo").select2();
    }, 200);
    
    let html_ = ` <form id="formFile" action="./?action=siniestro/files&modo=upload" enctype="multipart/form-data" method="POST"> <input type="file" accept="pdf/doc/docx/csv/xlsx/xls" aria-label="Selecciona un archivo CSV de siniestros" name="importFile" id="importFile" class="swal2-file" placeholder="Importar Archivo" style="display: flex;">`;
    html_ = html_ + selInput;
    Swal.fire({
    width: 800,
    confirmButtonColor: 'var(--color-dark)',
    denyButtonColor: 'var(--color-blanco)',
    cancelButtonColor: 'var(--fondo-degradado)',

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
                        $('#tipo').val(null).trigger("change"); //limpia el campo select2

                    },
    preConfirm: () => {
        const importFile = Swal.getPopup().querySelector('#importFile').value;
        const tipo = Swal.getPopup().querySelector('#tipo').value;
        const horas = Swal.getPopup().querySelector('#horasDocs[name=horas]').value;
        const bitacora = Swal.getPopup().querySelector('#textDOC[name=bitacora]').value;
        
        if (!tipo ) {
        Swal.showValidationMessage(`No puedes dejar campos en blanco`);
        }
        if ( !importFile ) {
        Swal.showValidationMessage(`No puedes dejar campos en blanco`);
        }
        if ( !horas) {
        Swal.showValidationMessage(`No puedes dejar campos en blanco`);
        }
        
        let x = new FormData();
            x.append('archivo', document.querySelector('#importFile').files[0]);
            x.append('importFile', importFile);
            x.append('tipo', tipo);
            x.append('horas', horas);
            x.append('bitacora', bitacora);
            x.append('id', '<?=$sn['timerst']?>');
            ejemplo= x;
        return x;
    }
    }).then((cambios) => {
        console.log (cambios);
        if (cambios.isConfirmed){

        $('#formFile').submit();


            //ALERTA que simula carga de fichero. el backend manda la accion de refrescar.
            let timerInterval
                Swal.fire({
                allowOutsideClick:false,
                title: 'Cargando archivo...',
                html: 'Por favor espera sin cerrar esta ventana.',
                timer: 2000000,
                timerProgressBar: true,
                didOpen: () => {
                Swal.showLoading()
                // const b = Swal.getHtmlContainer().querySelector('b')
                // timerInterval = setInterval(() => {
                //   b.textContent = Swal.getTimerLeft()
                // }, 100)
                },
                willClose: () => {
                clearInterval(timerInterval)
                }
            }).then((result) => {
                /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                console.log('I was closed by the timer');
                }
            })




        }
    
        console.log("archivo cargado!!");

    });
    
}

//?accion del boton para ver archivos del siniestro de formato establecido //la segunda esta en ver todos
function vierFileF(tipo,area,timerst,url,title,idfile,version,c1,c2,c3){
    $('#modalFileViewLabel').html(title);
    $("#modalFileViewBody").html('<iframe src="./?action=pdf/viewFileF&timerst='+timerst+'&doc='+url+'&areaNombre='+area+'&v='+version+'" frameborder="0" style="width:100%;height:66vh;"></iframe>');
    $('#linkpdf').val('https://www.claimsmanager.online/?action=pdf/viewFileF&timerst='+timerst+'&doc='+url+'&areaNombre='+area+'&v='+version);
    $('#link').val(url);
    $('#idfile').val(idfile);
    $('#version').val(version);
    $('#c1').val(c1);
    $('#c2').val(c2);
    $('#c3').val(c3);
    $('#nombreAreaFile').val(area);
}

//?accion del boton para ver archivos del siniestro cargados PDF los ve, otro formato lo descar
function vierFileD(tipo,area,timerst,url,title,idfile,version,c1,c2,c3){
    $('#modalFileViewLabel').html(title);
    $("#modalFileViewBody").html('<iframe src="./?action=pdf/viewFileD&timerst='+timerst+'&doc='+url+'&areaNombre='+area+'&v='+version+'" frameborder="0" style="width:100%;height:66vh;"></iframe>');
    $('#linkpdf').val('https://www.claimsmanager.online/?action=pdf/viewFileF&timerst='+timerst+'&doc='+url+'&areaNombre='+area+'&v='+version+'&c3='+c3);
    $('#link').val(url);
    $('#idfile').val(idfile);
    $('#version').val(version);
    $('#c1').val(c1);
    $('#c2').val(c2);
    $('#c3').val(c3);
    $('#nombreAreaFile').val( area);
}

//funcion para ver caratula del ID en pdf y poderimprimirlo 
function vierFileCaratula(timerst,folio){
    $('#modalFileCaratulaLabel').html('Caratula del id: '+folio);
    $("#modalFileCaratulaBody").html('<iframe src="./pdf/viewFileF-direct.php?timerst='+timerst+'&doc=caratula" frameborder="0" style="width:100%;height:66vh;"></iframe>');
    // $('#linkpdf').val('https://www.claimsmanager.online/?action=pdf/viewFileF&timerst='+timerst+'&doc='+url+'&areaNombre='+area+'&v='+version);

}

//preparar link para ser enviado por outlook MAILITO
function emailsSendOutlook(){
    console.log(renderFile);
    //?    http://localhost/cma/files/1654960235.5588/41/1655716026.xlsx
}


//??FUNCION PARA DESCARGAR ARCHIVOS CON UN CHECKBOX
function createLinksFiles(){
    let urls = [];
    let names = [];
    let checks = document.querySelectorAll("[id*=check]:checked");
    if(checks.length >=1)
    checks.forEach(element => {
        urls.push( element.getAttribute('value') );
        names.push( element.getAttribute('data-name') );
        console.log(element.getAttribute('value'));
    });
    console.log(urls);

    //*SCRIPTING 

    // Prevenir que el browser siga el enlace
    event.preventDefault();
    // Lista de archivos
    // var archivos = ["1.zip", "2.zip", "3.zip"];
    let archivos = urls;
    let host = window.location.href.split('?')[0];
    // Empezamos por 0 en el array
    var aIndex = 0;
    // Iniciamos un timer que se ejecute cada 100ms
    var Ainterval = setInterval(function(){
      // Si el numero del index(array) es menor seguir
      if(aIndex < archivos.length){
        // Indicar el src al iframe
        let file = archivos[aIndex];
        file = file.split('./')[1];
        
        setTimeout(() => {
            $('#downloader').attr('href',host+file); //? link armado download
            $('#downloader').attr('download',names[aIndex]); //? nombre del archivo
            console.log("descargando"+file);
            $('#downloader')[0].click();
        }, 1000);
        
        // Subir el index(array)
        aIndex++;
      // En caso de que sea mayor, limpiar timer.
      } else {clearInterval(Ainterval);}
    }, 100);
  
}

list='';

let dhtml = ``;
//?FUNCION PARA GENERAR LINKS DE DESCARGA EN UN CUERPO DE CORREO
function createLinksFilesForMail(){
    let urls = [];
    let names = [];
    let checks = document.querySelectorAll("[id*=check]:checked");
    if(checks.length >=1)
    checks.forEach(element => {
        urls.push( element.getAttribute('value') );
        names.push( element.getAttribute('data-name') );
        // console.log(element.getAttribute('value'));
    });
    else{exit();}

    //*SCRIPTING 
    // Prevenir que el browser siga el enlace
    event.preventDefault();
    // Lista de archivos
    let archivos = urls;
    let host = window.location.href.split('?')[0];
    // Empezamos por 0 en el array
    var aIndex = 0;
    //concatenado del html para body del mail
    dhtml = `<ul>`;
    // Iniciamos un timer que se ejecute cada 100ms
    var Ainterval = setInterval(function(){
      // Si el numero del index(array) es menor seguir
      if(aIndex < archivos.length){
        // Indicar el src al iframe
        let file = archivos[aIndex];
        if (file.split('./')[1]){//si se puede hacer split es por que trae punto y es fichero para renderizar
            file = file.split('./')[1];
            file = host+''+file;
        }else{
            file = archivos[aIndex];
        }
        // console.log(host);
        // console.log(file);

        let name  = names[aIndex].replaceAll('+',' ');
        
        dhtml += `<li>
                    <a href="`+file+`" download="`+name+`" link>`+name+` </a>
                  </li>`;
        
        // Subir el index(array)
        aIndex++;
        list = urls;
      // En caso de que sea mayor, limpiar timer.
      } else {
            dhtml += `</ul>`; //cerrando corchetes de la lista
            clearInterval(Ainterval); // termina bucle
            continuarmsg(dhtml);
    }
    }, 1);



    ////??CREANDO ELM PARA DESCARGAR email personalizado.

    function continuarmsg(dhtml){
        console.log("inicialdo envio");
        console.log(dhtml);
        //construir dirma
        let imagenfirma = "<?=$_SESSION['firma'];?>";
        const firma = ` <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" class="main">
                            <tbody>
                                <tr>
                                    <td align="left" valign="top" bgcolor="#FFFFFF" style="background:#FFF;overflow:hidden;">
                                    <img width="580" height="150" src="https://claimsmanager.online/`+imagenfirma+`" style="position: absolute;left: 0;right: 0;margin: auto;margin-top: 13px;">
                                    </td>

                                </tr>
                            </tbody>
                        </table>`;

        const txt = "<h3>Se adjuntan links para descargar documentos: </h3> \n\n "+dhtml+"<br><br>"+firma;

    var mailHtm ="<h1> Sample Email <h1>";
    var emailto = "jesus@cmabogados.mx";
    var emailsubject = "adjuntos . <?=$sn['folio']?>";
    var emlCont = 'To: '+emailto + '\n';
    emlCont += 'Cc: siniestros@cmabogados.mx; jesus@cmabogados.mx \n';
    // emlCont += 'Bcc: hola@google.com \n';

    emlCont += 'X-Unsent: 1'+'\n';
    
    emlCont += 'Content-Type: text/html'+'\n';
    emlCont += 'Subject: '+emailsubject+'\n';
    emlCont += ''+'\n';

    emlCont += "<!DOCTYPE html><html><head></head><body style='background-color: white; color: black'>" + txt + "</body></html>";
    // console.log(emlCont) ;
    var textFile = null;
    var data = new Blob([emlCont], {type: 'text/plain'});
    if (textFile !== null) {
    window.URL.revokeObjectURL(textFile);
    }

    textFile = window.URL.createObjectURL(data);
    // console.log(textFile);

    var a = document.createElement('a'); //make a link in document
    var linkText = document.createTextNode('fileLink');
    a.appendChild(linkText) ;

    a.href = textFile;

    a.id = 'fileLink';
    a.download = emailsubject+".eml"; //'filenameTest.eml' ;
    a.style.visibility = "hidden";

    document.body.appendChild(a) ;

    document.getElementById('fileLink').click();

    }
  
}

</script>